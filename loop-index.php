<?php

/*------------------------------
Selectors

$post_type == 'post' && $post_format == 'standard'
$post_format == 'aside'
has_tag( 'lawyerist-podcast' )
has_tag( 'tbd-law-community' )
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
  $seo_title      = get_post_meta( $post->ID, '_yoast_wpseo_title', true );
  if ( !empty( $seo_title ) ) { $post_title = $seo_title; }
  $seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );
  $post_url       = get_permalink();
  $post_type      = get_post_type( $post->ID );
  if ( $post_type == 'post' ) {
    $post_format  = get_post_format() ? : 'standard';
  }
  $post_classes[] = 'index_post_container'; // .post, .page, and .product are added automatically, as are tags and formats.

  // Assign classes.
  if ( has_term( true, 'series' ) ) {
    $post_classes[] = 'series';
  }

  if ( has_term( true, 'sponsor' ) ) {
    $post_classes[] = 'sponsored';
  }

  if ( $post_type == 'page' && !has_term( 'show-in-feed', 'page_type' ) ) {

    continue;

  } else {

    // This is the container for all posts/groups of posts.
    echo '<div ' ;
    post_class( $post_classes );
    echo '>';

      // First we look for labels to show above the post container.

        // Series title:
        // Check for a series, get the series information, then output the series title.
        if ( has_term( true, 'series' ) && !is_tax( 'series' ) ) {

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
          $series_title				= $series_info->name;
          $series_description = $series_info->description;
          $series_slug				= $series_info->slug;
          $series_url					=	get_term_link( $series_IDs[0], 'series' );

          echo '<p class="series_title"><a href="' . $series_url . '" title="Read more posts in ' . $series_title . '">' . $series_title . '</a></p>';

        }

        // TBD Law Community Flag
        if ( has_tag( 'tbd-law-community' ) ) {
          echo '<p class="series_title"><a href="https://lawyerist.com/tag/tbd-law-community/" title="Read more posts from the TBD Law community.">TBD Law community</a></p>';
        }


      // Now we output the post link container (.post). The whole thing is a link!
      echo '<a href="' . $post_url . '" title="' . $post_title . '">';

        // First we figure out the post image based on the type of post.
        if ( has_post_thumbnail() ) {

            if ( has_term( true, 'series' ) && !is_tax( 'series' ) ) {

              the_post_thumbnail( 'default_thumbnail' );

            } elseif ( has_term( true, 'series' ) && is_tax( 'series' ) ) {

              echo '<div class="default_thumbnail" style="background-image: url( ';
              echo the_post_thumbnail_url( 'default_thumbnail' );
              echo ' );"></div>';

            } elseif ( $post_type == 'product' ) {

              the_post_thumbnail( 'shop_single' );

            } elseif ( has_tag( 'tbd-law-community' ) ) {

              echo get_avatar( get_the_author_meta( 'user_email' ), 100, '', get_the_author_meta( 'display_name' ) );

            } elseif ( $post_type == 'post' && $post_format == 'standard' && !has_term( true, 'sponsor' ) ) {

              echo '<div class="thumbnail_wrapper">';
                the_post_thumbnail( 'standard_thumbnail' );
              echo '</div>';

            } else {

              echo '<div class="default_thumbnail" style="background-image: url( ';
              echo the_post_thumbnail_url( 'default_thumbnail' );
              echo ' );"></div>';

            }

        }

        // Now we get the headline and excerpt (except for certain kinds of posts).
        echo '<div class="headline_excerpt">';

          // Headline
          echo '<h2 class="headline">' . $post_title; '</h2>';

          // Output the excerpt unless we're showing a page or a post from the
          // TBD Law community.
          if ( $post_type != 'page' && !has_tag( 'tbd-law-community' ) ) {

            if ( !empty( $seo_descr ) ) {
              $post_excerpt = $seo_descr;
            } else {
              $post_excerpt = get_the_excerpt();
            }

            echo '<p class="excerpt">' . $post_excerpt . '</p>';

          }

          // Output the post meta only for posts.
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

    unset ( $post_classes ); // Clear the post classes for the next trip through the Loop.

  } // End loop for excluding pages without the "Show in Feed" page type.

endwhile;

else :

  echo '<p class="post">No posts match your query.</p>';

endif; // Close the Loop.

?>
