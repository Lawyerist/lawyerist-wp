<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $post_title   = the_title( '', '', FALSE );
  $post_ID      = $post->ID;

  // This is the post container.
  echo '<div ';
  post_class( 'hentry' );
  echo '>';

    // Breadcrumbs
    if ( function_exists( 'yoast_breadcrumb' ) ) {
      yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
    }

    // Headline Container
    echo '<div class="headline_container">';

      // Show featured image if there is one.
      if ( has_post_thumbnail() ) {
        echo '<div itemprop="image">';
        the_post_thumbnail( 'thumbnail' );
        echo '</div>';
      }

      // Headline
      echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

      // Show ratings for child posts.
      if ( $post->post_parent > 0 ) {

        // Rating
        if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

          $rating       = get_post_meta( $post_ID, 'wp_review_comments_rating_value', true );
          $review_count = lawyerist_get_review_count();

          echo '<div class="user-rating">';

            if ( !empty( $rating ) ) {
              echo '<a href="#comments">';
                wp_review_show_total();
              echo ' <span class="review_count">(' . $review_count . ')</span></a>';
            } else {
              echo '<a href="#respond">Leave a review below.</a>';
            }

           echo '</div>';

        }

      } else {

        // Output the excerpt.
        $seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );

        if ( !empty( $seo_descr ) ) {

          $post_excerpt = $seo_descr;

        } else {

          $post_excerpt = get_the_excerpt();

        }

        echo '<p class="excerpt">' . $post_excerpt . '</p>';

      }

      echo '<div class="clear"></div>';

    echo '</div>'; // Close .headline_container.


    // Output the post.
    echo '<div class="post_body" itemprop="articleBody">';

      the_content();

      // Byline
      get_template_part( 'postmeta', 'page' );

      echo '<div class="clear"></div>';

      // Show page navigation if the post is paginated unless we're displaying
      // the RSS feed.
      if ( !is_feed() ) {

        $wp_link_pages_args = array(
          'before'            => '<p class="page_links">',
          'after'             => '</p>',
          'link_before'       => '<span class="page_number">',
          'link_after'        => '</span>',
          'next_or_number'    => 'next',
          'nextpagelink'      => 'Next Page &raquo;',
          'previouspagelink'  => '&laquo; Previous Page',
          'separator'         => '|',
        );

        wp_link_pages( $wp_link_pages_args );

      }

    echo '</div>'; // Close .post_body.

    if ( comments_open() ) {

      echo '<div id="comments_container">';

      if ( function_exists( 'wp_review_show_total' ) ) {
        comments_template( '/reviews.php' );
      } else {
        comments_template();
      }

      echo '</div>';

    }

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.

?>
