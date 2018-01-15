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

    // Show a small image and ratings for child posts.
    if ( $post->post_parent > 0 ) {

      echo '<div class="headline_container">';

        // Show featured image if there is one.
        if ( has_post_thumbnail() ) {
          echo '<div itemprop="image">';
          the_post_thumbnail( 'thumbnail' );
          echo '</div>';
        }

        // Headline
        echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

        // Rating
        if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

          $rating = get_post_meta( $post_ID, 'wp_review_comments_rating_value', true );

          echo '<div class="user-rating">';

          if ( !empty( $rating ) ) {
            wp_review_show_total();
            echo '<br />';
          }

          echo '<a href="#respond">Leave a review below.</a></div>';

        }

        echo '<div class="clear"></div>';

      echo '</div>'; // Close .headline_container.

    // Show a big image for parent posts.
    } else {

      echo '<div class="headline_postmeta">';

        // Headline
        echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

        // Featured image
        if ( has_post_thumbnail() ) { the_post_thumbnail( 'standard_thumbnail' ); }

      echo '</div>'; // Close .headline_postmeta.

    }


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
