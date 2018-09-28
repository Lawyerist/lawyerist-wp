<?php

/*------------------------------
Selectors

has_category( 'lawyerist-podcast' )
has_term( true, 'series' )
has_term( true, 'sponsor' )
$post_type == 'product'
$post_type == 'page'

------------------------------*/

$post_num = 1; // Counter for inserting mobile ads and other stuff.

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  // Assign post variables.
  $post_title     = the_title( '', '', FALSE );
  $post_excerpt   = get_the_excerpt();
  $seo_title      = get_post_meta( $post->ID, '_yoast_wpseo_title', true );
  $seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );
  $post_url       = get_permalink();
  $post_type      = get_post_type( $post->ID );

  // Sets the post title to the Yoast SEO Title for pages.
  // if ( $post_type == 'page' && !empty( $seo_title ) ) { $post_title = $seo_title; }

  // Sets the post excerpt to the Yoast Meta Description.
  if ( !empty( $seo_descr ) ) { $post_excerpt = $seo_descr; }

  $post_classes[] = 'index_post_container'; // .post, .page, and .product are added automatically, as are tags and formats.

  // Assigns series class and label.
  if ( has_term( true, 'series' ) ) {

    $post_classes[] = 'series';

    if ( !is_tax( 'series' ) ) {

      $post_classes[] = 'has-post-label';

      $series_IDs = wp_get_post_terms(
        $post->ID,
        'series',
        array(
          'fields' 	=> 'ids',
          'orderby' => 'count',
          'order' 	=> 'DESC'
        )
      );

      $series_info				= get_term( $series_IDs[0] );
      $series_slug				= $series_info->slug;

      $post_label 		   	= $series_info->name;
      $post_label_url			=	get_term_link( $series_IDs[0], 'series' );

    }

  }

  // Skips sponsored posts.
  if ( has_term( true, 'sponsor' ) ) {

    continue;

  // Skips pages if they don't have the 'Show in Feed' page type.
  } elseif ( $post_type == 'page' && !has_term( 'show-in-feed', 'page_type' ) ) {

    continue;

  } else {

    // Starts the post container.
    echo '<div ' ;
    post_class( $post_classes );
    echo '>';

      // Outputs the post label if there is one.
      if ( !empty( $post_label ) ) {
        echo '<p class="post_label"><a href="' . $post_label_url . '" title="Read all posts in ' . $post_label . '.">' . $post_label . '</a></p>';
      }

      // Starts the link container. Makes for big click targets!
      echo '<a href="' . $post_url . '" title="' . $post_title . '">';

        // Now we get the headline and excerpt (except for certain kinds of posts).
        echo '<div class="headline_excerpt">';

          // Outputs an image for podcast episodes.
          if ( has_category( 'lawyerist-podcast' ) ) {

            $first_image_url = get_first_image_url();

            if ( empty( $first_image_url ) ) {
              $first_image_url = 'https://lawyerist.com/lawyerist-dev/wp-content/uploads/2018/02/lawyerist-ltn-podcast-logo-16x9-684x385.png';
            }

            echo '<div class="author_avatar"><img class="avatar" src="' . $first_image_url . '" /></div>';



            // echo '<div class="default_thumbnail" alt="The Lawyerist Podcast logo" style="background-image: url( https://lawyerist.com/lawyerist-dev/wp-content/uploads/2018/02/lawyerist-ltn-podcast-logo-16x9-684x385.png );"></div>';
          }

          // Outputs an image for community posts.
          if ( has_category( 'community-posts' ) ) {

            if ( has_category( 'how-lawyers-work' ) ) {

              $first_image_url = get_first_image_url();

              if ( empty( $first_image_url ) ) {
                $first_image_url = 'https://lawyerist.com/lawyerist/wp-content/uploads/2018/01/typewriter-150x150.jpg';
              }

              echo '<div class="author_avatar"><img class="avatar" src="' . $first_image_url . '" /></div>';

            } else {

              $author_name		= get_the_author_meta( 'display_name' );
              $author_avatar	= get_avatar( get_the_author_meta( 'user_email' ), 150, '', $author_name );

              echo '<div class="author_avatar">' . $author_avatar . '</div>';

            }

          }

          // Outputs the featured image for other posts.
          if ( has_post_thumbnail() && !has_category( 'lawyerist-podcast' ) && !has_category( 'community-posts' ) ) {

            if ( $post_type == 'product' ) {

              the_post_thumbnail( 'shop_single' );

            } else {

              echo '<div class="default_thumbnail" style="background-image: url( ';
              echo the_post_thumbnail_url( 'default_thumbnail' );
              echo ' );"></div>';

            }

          }

          // Headline
          echo '<h2 class="headline">' . $post_title . '</h2>';

          // Output the excerpt, with exceptions.
          if ( !has_category( 'lawyerist-podcast' ) && !has_tag( 'tbd-law-community' ) && $post_type != 'page' ) {
            echo '<p class="excerpt">' . $post_excerpt . '</p>';
          }

          // Output the post meta, with exceptions.
          if ( $post_type == 'post' ) {
            lawyerist_postmeta();
          }

          // Show a button for products.
          if ( $post_type == 'product' ) {
            echo '<a href="' . $post_url . '" class="button">Learn More</a>';
          }

          // Clearfix
          echo '<div class="clear"></div>';

        echo '</div>'; // Close .headline_excerpt.

      echo '</a>'; // This closes the post link container (.post).


      // If the post is in a series, show up to 4 additional posts in that series.
      if ( has_term( true, 'series' ) && !is_tax( 'series' ) ) {

        $series_query_args = array(
          'orderby'					=> 'date',
          'order'						=> 'DESC',
          'post__not_in'		=> $this_post,
          'posts_per_page'	=> 4,
          'tax_query'     	=> array(
            array(
              'taxonomy'  => 'series',
              'field'			=> 'slug',
              'terms'			=> $series_slug,
            )
          )
        );

        $series_query = new WP_Query( $series_query_args );

        // Start the series sub-Loop.

        if ( $series_query->post_count > 1 ) :

          $posts_in_series = 'series_of_' . $series_query->post_count;

          echo '<ul class="' . $posts_in_series . '">';

            while ( $series_query->have_posts() ) : $series_query->the_post();

              $series_post_title = the_title( '', '', FALSE );
              $series_post_url   = get_permalink();

              echo '<li><a href="' . $post_url . '" title="' . $series_post_title . '"><h3 class="headline">' . $series_post_title . '</h3></a></li>';

            endwhile;

          echo '</ul>';

          // Clearfix
          echo '<div class="clear"></div>';

        endif; // End series sub-Loop.

        wp_reset_postdata(); // Necessary because the series loop is nested in the main loop.

      } // End the additional series posts.

    echo '</div>'; // Close .post.
    echo "\n\n";

    // Insert product updates, and ads on mobile.
    if ( $post_num == 1 && is_mobile() ) { lawyerist_get_display_ad(); }
    if ( $post_num == 3 ) {
      if ( is_front_page() && !is_paged() ) { lawyerist_sponsored_product_updates(); }
    }

    $post_num++; // Increment counter.

    unset ( $post_classes, $post_label, $post_label_url ); // Clear variables for the next trip through the Loop.

  } // End loop for excluding pages without the "Show in Feed" page type.

endwhile;

echo '<div class="page_links">';
  echo paginate_links( $args );
echo '</div>';

else :

  echo '<p class="post">No posts match your query.</p>';

endif; // Close the Loop.

?>
