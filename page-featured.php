<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class('front_page'); ?>">

<?php $ltheme_options = get_option( 'theme_ltheme_options' ); ?>

<?php get_header(); ?>

<div id="content_column_container">

  <div id="content_column">

    <?php /* PINNED POST LOOP */

      $sticky = get_option( 'sticky_posts' );
      $args = array(
        'posts_per_page'      => 1,
        'post__in'            => $sticky,
        'ignore_sticky_posts' => 1
      );

      $sticky_query = new WP_Query( $args );

      if ( $sticky[0] ) {

        while ( $sticky_query->have_posts() ) : $sticky_query->the_post();

          $do_not_duplicate[] = $post->ID; ?>

          <a <?php post_class("fp_sticky"); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
           <div class="pin"></div>
           <p><?php the_title(); ?></p>
          </a>

        <?php endwhile;

      }

    /* END PINNED POST LOOP */ ?>

    <div class="fp_tab"><h2>Articles</h2></div>
  	<div id="featured_posts">

  		<?php /* FEATURED POSTS LOOP */

        $featured_query_args = array(
          'posts_per_page'  => 5,
          'post__not_in'    => $do_not_duplicate,
          'tax_query'       => array(
            array(
              'taxonomy'  => 'post_format',
              'field'     => 'slug',
              'terms'     => array(
                'post-format-aside'
              ),
              'operator'  => 'NOT IN'
            )
          )
        );

  			$featured_query = new WP_Query( $featured_query_args );

  			$post_num = 1;

  			while ( $featured_query->have_posts() ) : $featured_query->the_post();

  				$num_comments = get_comments_number();
          $classes = array(
  					'featured_post',
  					'post_num_' . $post_num
  				); ?>

  				<a <?php post_class($classes); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

  					<div class="headline_excerpt raised_text">

              <?php if ( has_tag('updated') ) { echo '<div class="flag no_shadow">Updated</div>'; } ?>

  						<h2 class="headline"><?php the_title(); ?></h2>
  						<div class="postmeta">
  							<div class="author_link">by <?php the_author(); ?> on <span class="post-date updated"><?php the_time('F jS, Y'); ?></div>
                <?php if ( $num_comments > 0 ) { ?>
                  <div class="comment_link"><?php comments_number( 'Leave a comment', '1 comment', '% comments' ); ?></div>
                <?php } ?>
  						</div>

  					</div><!--end .headline_excerpt-->

  					<?php if ( has_post_thumbnail() && $post_num==1 ) { the_post_thumbnail( 'featured_top' ); }
            elseif ( has_post_thumbnail() ) { the_post_thumbnail( 'featured' ); }
            else { echo ''; } ?>

  					<div class="clear"></div>

  				</a>

  				<?php if ( $post_num==3 ) { $post_num = 2; }
          else { $post_num++; }

  			endwhile;

  		/* END FEATURED POSTS LOOP */ ?>

  		<div class="clear"></div>

  	</div><!--end #featured_posts-->
    <div class="fp_bottom_tab"><h2><a href="<?php echo bloginfo('url') . '/articles/'; ?>">More Articles</a></h2></div>

    <div class="clear"></div>

    <div class="fp_tab"><h2>Notes</h2></div>
    <div id="featured_notes">

      <?php /* NOTES LOOP */

        $featured_query_args = array(
          'posts_per_page'  => 5,
          'post__not_in'    => $do_not_duplicate,
          'tax_query'       => array(
            array(
              'taxonomy'  => 'post_format',
              'field'     => 'slug',
              'terms'     => array(
                'post-format-aside'
              )
            )
          )
        );

        $featured_query = new WP_Query( $featured_query_args );

        while ( $featured_query->have_posts() ) : $featured_query->the_post();

          $num_comments = get_comments_number();
          $classes = array(
            'featured_note'
          ); ?>

          <a <?php post_class($classes); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
            <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'thumbnail' ); } ?>
            <h2 class="headline"><?php the_title(); ?></h2>
            <div class="postmeta">
              <div class="author_link">by <?php the_author(); ?> on <span class="post-date updated"><?php the_time('F jS, Y'); ?> at <?php the_time('g:i a'); ?></span></div>
              <?php if ( $num_comments > 0 ) { ?>
                <div class="comment_link"><?php comments_number( 'Leave a comment', '1 comment', '% comments' ); ?></div>
              <?php } ?>
            </div>
            <div class="clear"></div>
          </a>

        <?php endwhile;

      /* END NOTES LOOP */ ?>

    </div><!--end #featured_posts-->
    <div class="fp_bottom_tab"><h2><a href="<?php echo bloginfo('url') . '/notes/'; ?>">More Notes</a></h2></div>

    <div class="clear"></div>

    <div class="fp_tab"><h2>Q&A</h2></div>
    <div id="lab_posts">

      <?php // Get RSS Feed(s)
      include_once( ABSPATH . WPINC . '/feed.php' );

      // Get a SimplePie feed object from the specified feed source.
      $rss = fetch_feed( 'http://lab.lawyerist.com/discussions/feed.rss' );

      if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

        // Figure out how many total items there are, but limit it to 5.
        $maxitems = $rss->get_item_quantity( 5 );

        // Build an array of all the items, starting with element 0 (first element).
        $rss_items = $rss->get_items( 0, $maxitems );

      endif;
      ?>

      <ul>
        <?php if ( $maxitems == 0 ) : ?>
          <li><?php _e( 'No items', 'my-text-domain' ); ?></li>
        <?php else : ?>
          <?php // Loop through each feed item and display each item as a hyperlink. ?>
          <?php foreach ( $rss_items as $item ) : ?>
            <li>
              <a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Updated on %s', 'my-text-domain' ), $item->get_date('F jS, Y @ g:i a') ); ?>">
                <img src="https://lawyerist.com/lawyerist/wp-content/uploads/2013/10/lab-favicon.png" />
                <div class="lab_headline"><?php echo esc_html( $item->get_title() ); ?></div>
                <div class="clear"></div>
              </a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div><!--end #lab_posts-->
    <div class="fp_bottom_tab"><h2><a href="http://lab.lawyerist.com">More Q&A</a></h2></div>

    <div class="clear"></div>

	</div><!--end #content_column-->

	<ul id="sidebar_column">
		<?php include('sidebar.php'); ?>
	</ul>

	<div class="clear"></div>

</div><!-- end #content_column_container -->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
