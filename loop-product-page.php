<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $page_title   = the_title( '', '', FALSE );
  $page_ID      = $post->ID;

  // Check for a rating.
  if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

    $rating       = get_post_meta( $page_ID, 'wp_review_comments_rating_value', true );
    $review_count = lawyerist_get_review_count();

  }

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
      if ( !empty( $rating ) ) {

        echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
        echo '<h1 class="headline entry-title" itemprop="itemReviewed">' . $page_title . '</h1>';

      } else {

        echo '<h1 class="headline entry-title">' . $page_title . '</h1>';

      }

      // Show ratings for child posts.
      if ( $post->post_parent > 0 ) {

        echo '<div class="user-rating">';

          // Rating
          if ( !empty( $rating ) ) {

            echo '<a href="#comments">';
              wp_review_show_total();
            echo ' <span class="review_count">(' . $review_count . ')</span></a>';

          } else {

            echo '<a href="#respond">Leave a review below.</a>';

          }

        echo '</div>'; // End .user_rating.

        if ( !empty( $rating ) ) {
          echo '</div>'; // End aggregateRating schema.
        }

      } else {

        // Output the excerpt.
        $seo_descr = get_post_meta( $page_ID, '_yoast_wpseo_metadesc', true );

        if ( !empty( $seo_descr ) ) {

          $page_excerpt = $seo_descr;

        } else {

          $page_excerpt = get_the_excerpt();

        }

        echo '<p class="excerpt">' . $page_excerpt . '</p>';

      }

      if ( function_exists( 'lawyerist_affinity_partner_button' ) ) {
          lawyerist_affinity_partner_button();
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
        comments_template( '/comments.php' );
      }

      echo '</div>';

    }

    /* if ( is_page( '226480' ) ) {
      lawyerist_affinity_partner_button();
    } */

    lawyerist_get_related_podcasts();
    lawyerist_get_related_posts();

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.

?>
