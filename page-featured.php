<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body <?php body_class('front_page'); ?>>

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

        while ( $sticky_query->have_posts() ) : $sticky_query->the_post();

          $do_not_duplicate[] = $post->ID; ?>

          <a <?php post_class("fp_sticky"); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
           <div class="pin"></div>
           <h2 class="headline"><?php the_title(); ?></h2>
          </a>

        <?php endwhile;

    /* END PINNED POST LOOP */ ?>

  	<div id="featured_posts">

      <?php /* TOP POST LOOP */

        $top_post_query_args = array(
          'author__not_in'      => array(
            32 /* excludes sponsored posts */
          ),
          'ignore_sticky_posts' => TRUE,
          'posts_per_page'      => 1,
          'post__not_in'        => $do_not_duplicate,
          'tax_query'           => array(
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

  			$top_post_query = new WP_Query( $top_post_query_args );

  			while ( $top_post_query->have_posts() ) : $top_post_query->the_post();

          $do_not_duplicate[] = $post->ID;

          $title = the_title( '', '', FALSE );
          if ( strlen( $title ) > 80 ) {
            $classes[] = 'smaller-title';
          } ?>

  				<a <?php post_class($classes); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

  					<div class="headline_excerpt">

              <?php if ( has_tag('updated') ) { echo '<div class="flag no_shadow">Updated</div>'; } ?>

  						<h2 class="headline"><?php the_title(); ?></h2>
  						<?php lawyerist_get_postmeta(); ?>

  					</div><!-- end .headline_excerpt -->

  					<?php if ( has_post_thumbnail() && !is_mobile() ) { the_post_thumbnail( 'featured_top' ); }
            elseif ( has_post_thumbnail() ) { the_post_thumbnail( 'featured' ); }
            else { echo '<img src="' . get_template_directory_uri() . '/images/fff-thumb.png" class="attachment-thumbnail wp-post-image" />'; } ?>

  					<div class="clear"></div>

  				</a>

  				<?php endwhile;

  		/* END TOP POST LOOP */

      if ( is_mobile() ) { insert_lawyerist_mobile_ad(); }

  		/* FEATURED POSTS LOOP */

        $featured_query_args = array(
          'ignore_sticky_posts' => TRUE,
          'posts_per_page'      => 4,
          'post__not_in'        => $do_not_duplicate
        );

  			$featured_query = new WP_Query( $featured_query_args );

  			$post_num = 2;

  			while ( $featured_query->have_posts() ) : $featured_query->the_post();

          $do_not_duplicate[] = $post->ID; ?>

  				<a <?php post_class($classes); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

  					<div class="headline_excerpt">

  						<h2 class="headline"><?php the_title(); ?></h2>
  						<?php lawyerist_get_postmeta(); ?>
              <div class="clear"></div>

  					</div><!--end .headline_excerpt-->

  					<?php if ( has_post_thumbnail() && !wp_is_mobile() && $post_num==1 ) { the_post_thumbnail( 'featured_top' ); }
            elseif ( has_post_thumbnail() ) { the_post_thumbnail( 'featured' ); }
            else { echo '<img src="' . get_template_directory_uri() . '/images/fff-thumb.png" class="attachment-thumbnail wp-post-image" />'; } ?>

  					<div class="clear"></div>

  				</a>

  				<?php if ( $post_num==3 ) { $post_num = 2; }
          else { $post_num++; }

  			endwhile;

  		/* END FEATURED POSTS LOOP */ ?>

  		<div class="clear"></div>

  	</div><!--end #featured_posts-->

    <div class="clear"></div>

    <div id="featured_notes">

      <?php /* NOTES LOOP */

        $featured_query_args = array(
        'ignore_sticky_posts' => TRUE,
          'posts_per_page'    => 5,
          'post__not_in'      => $do_not_duplicate
        );

        $featured_query = new WP_Query( $featured_query_args );

        while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>

          <a <?php post_class(); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
            <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'thumbnail' ); } ?>
            <h2 class="headline"><?php the_title(); ?></h2>
            <?php lawyerist_get_postmeta(); ?>
            <div class="clear"></div>
          </a>

        <?php endwhile;

      /* END NOTES LOOP */ ?>

    </div><!--end #featured_posts-->
    <div class="fp_bottom_tab"><a href="<?php echo bloginfo('url') . '/articles/'; ?>">View All Articles</a></div>

    <div class="clear"></div>


    <div class="fp_tab">Current Lab Discussions</div>
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
    <div class="fp_bottom_tab"><a href="http://lab.lawyerist.com">View All Discussions</a></div>

    <div class="clear"></div>


    <div id="survival_guides">

			<?php /* SURVIVAL GUIDES LOOP */

			$downloads_args = array(
				'post_type'	=> 'download',
				'tax_query'	=> array(
					array(
						'taxonomy'	=> 'download_category',
						'field'			=> 'slug',
						'terms'			=> 'guides',
					),
				),
			);

			$downloads = new WP_Query( $downloads_args );

			if ( $downloads->have_posts() ) :
			while ( $downloads->have_posts() ) : $downloads->the_post();

			?>

				<a <?php post_class($class); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('medium'); }

					$price = edd_get_download_price( get_the_ID() );

					if ( $price == 0 ) { ?>
						<div class="price_tag">FREE</div>
					<?php } else { ?>
						<div class="price_tag"><?php edd_price( get_the_ID() ); ?></div>
					<?php } ?>

				</a>

			<?php

			endwhile;
			endif;

			/* END SURVIVAL GUIDES LOOP */ ?>

      <div class="clear"></div>

		</div><!-- end #survival_guides -->

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
