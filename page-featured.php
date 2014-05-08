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
        'posts_per_page' => 1,
        'post__in'  => $sticky,
        'ignore_sticky_posts' => 1
      );

      $sticky_query = new WP_Query( $args );

      if ( $sticky[0] ) {

        while ( $sticky_query->have_posts() ) : $sticky_query->the_post();

          $do_not_duplicate = $post->ID; ?>

          <a class="fp_sticky" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
           <div class="pin"></div>
           <p><?php the_title(); ?></p>
          </a>

        <?php endwhile;

      }

    /* END PINNED POST LOOP */ ?>

  <div class="fp_tab"><h2>Latest Posts</h2></div>
  	<div id="featured_posts">

  		<?php /* THE LOOP */

  			$featured_query = new WP_Query( 'posts_per_page=7' );

  			$post_num = 1;

  			while ( $featured_query->have_posts() ) : $featured_query->the_post();

          if ( $post->ID == $do_not_duplicate ) continue;

          $do_not_duplicate = $post->ID;

  				$num_comments = get_comments_number();
  				$classes = array(
  					'featured_post',
  					'post_num_' . $post_num
  				); ?>

  				<a id="post-<?php the_ID(); ?>" <?php post_class($classes); ?> href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

  					<div class="headline_excerpt">

  						<h2 class="headline"><?php the_title(); ?></h2>
  						<div class="postmeta">
  							<?php if ( $num_comments > 0 ) { ?>
  								<div class="comment_link"><?php comments_number('leave a comment','1 comment','% comments'); ?></div>
  							<?php } ?>
  							<div class="author_link">by <?php the_author(); ?></div>
  						</div>

  					</div><!--end .headline_excerpt-->

  					<div class="shadowbox"></div>
  					<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'featured_thumb_2' ); } ?>

  					<div class="clear"></div>

  				</a>

  				<?php $post_num++;

  			endwhile;

			/* END LOOP */ ?>

			<div class="clear"></div>

		</div><!--end #featured_posts-->

		<div id="read_latest_posts">
			<a href="<?php echo bloginfo('url') . '/articles/'; ?>">
				<p>Read all posts &rarr;</p>
			</a>
		</div>

		<div class="fp_tab"><h2>Discussions</h2></div>
		<div id="discussions_container">
      <div id="most_discussed">
        <h3>Most-Discussed Posts</h3>
  			<?php wpp_get_mostpopular("post_type='post'&range=monthly&order_by=comments&limit=3&thumbnail_height=60&thumbnail_width=60&post_html='<li><div class=\"wpp_thumb\">{thumb}</div><a class=\"wpp_headline\" href=\"{url}\">{text_title}</a><a class=\"comment_link\" href=\"{url}#comments\" rel=\"nofollow\">{comments} recent comments</a><div class=\"clear\"></div></li>'"); ?>
        <div class="clear"></div>
      </div>
      <div id="lab_posts">
        <h3>Forum Posts</h3>

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
                <a href="<?php echo esc_url( $item->get_permalink() ); ?>"
                  title="<?php printf( __( 'Updated on %s', 'my-text-domain' ), $item->get_date('F jS, Y @ g:i a') ); ?>">
                  <img src="http://lawyerist.com/lawyerist/wp-content/uploads/2013/10/lab-favicon.png" />
                  <div class="lab_headline"><?php echo esc_html( $item->get_title() ); ?></div>
                </a>
              </li>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>
      </div><!--end #lab_posts-->
		</div>

		<div class="fp_tab"><h2>Lawyerist Sites Network</h2></div>
		<div id="sites_network_posts">
			<?php // Get RSS Feed(s)
			include_once( ABSPATH . WPINC . '/feed.php' );

			// Get a SimplePie feed object from the specified feed source.
			$rss = fetch_feed( 'http://sites.lawyerist.com/feed/globalpostsfeed' );

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
      				<a href="<?php echo esc_url( $item->get_permalink() ); ?>"
      					title="<?php printf( __( 'Posted on %s', 'my-text-domain' ), $item->get_date('F jS, Y') ); ?>">
      					<?php echo esc_html( $item->get_title() ); ?>
      				</a>
      			</li>
      		<?php endforeach; ?>
      	<?php endif; ?>
      </ul>
    </div><!--end #sites_network_posts-->

    <div id="infinite_posts">

      <?php /* THE LOOP */

        $infinite_query = new WP_Query();

        while ( $infinite_query->have_posts() ) : $infinite_query->the_post();

          if ( $post->ID == $do_not_duplicate ) continue;

          $num_comments = get_comments_number();
          $classes = 'featured_post'; ?>

          <a id="post-<?php the_ID(); ?>" <?php post_class($classes); ?> href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

            <div class="headline_excerpt">

              <h2 class="headline"><?php the_title(); ?></h2>
              <div class="postmeta">
                <?php if ( $num_comments > 0 ) { ?>
                  <div class="comment_link"><?php comments_number('leave a comment','1 comment','% comments'); ?></div>
                <?php } ?>
                <div class="author_link">by <?php the_author(); ?></div>
              </div>

            </div><!--end .headline_excerpt-->

            <div class="shadowbox"></div>
            <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'featured_thumb_2' ); } ?>

            <div class="clear"></div>

          </a>

          <?php $post_num++;

        endwhile;

      /* END LOOP */ ?>

    </div><!--end #infinite_posts-->

	</div><!--end content_column-->

	<ul id="sidebar_column">
		<?php include('sidebar.php'); ?>
	</ul>

	<div class="clear"></div>

</div><!--end content_column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
