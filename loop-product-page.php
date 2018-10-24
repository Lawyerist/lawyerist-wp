<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $page_title   = the_title( '', '', FALSE );
  $page_ID      = $post->ID;

  // Check for a rating.
  if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

    $our_rating             = lawyerist_get_our_rating();
    $community_rating       = lawyerist_get_community_rating();
    $community_review_count = lawyerist_get_community_review_count();
    $composite_rating       = lawyerist_get_composite_rating();

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
      if ( !empty( $our_rating ) || !empty( $community_rating ) ) {

        echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
        echo '<h1 class="headline entry-title" itemprop="itemReviewed">' . $page_title . '</h1>';

      } else {

        echo '<h1 class="headline entry-title">' . $page_title . '</h1>';

      }

      // Shows ratings if comments are open.
      if ( comments_open() ) {

        echo '<div class="user-rating">';

          // Rating
          if ( !empty( $our_rating ) || !empty( $community_rating ) ) {

            echo '<a href="#comments">';

              echo lawyerist_product_rating();

            echo '</a>';

          } else {

            echo '<a href="#respond">Leave a review below.</a>';

          }

        echo '</div>'; // End .user_rating.

        if ( !empty( $our_rating ) || !empty( $community_rating ) ) {
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

      echo '<div class="clear"></div>';

      echo '<div class="our_rating">';

        if ( function_exists( 'wp_review_show_total' ) && !empty( $our_rating ) ) {

          echo '<h2>' . $page_title . ' Rating: ' . $composite_rating . '/5</h2>';

          echo '<div class="card rating-box">';

            echo '<h3>Features</h3>';

            echo wp_review_get_review_box();

              echo '<div class="rating-breakdown">';

              if ( !empty( $our_rating ) && !empty( $community_rating ) ) {

                echo '<h3>Rating Breakdown</h3>';

              }

              if ( !empty( $our_rating ) ) {

                echo '<p class="rating">Our Rating: <strong>' . $our_rating . '</strong>/5</p>';
                echo '<p><small>Our rating is based on our subjective judgment.</small></p>';

              }

              if ( !empty( $our_rating ) && !empty( $community_rating ) ) {

                echo '<p class="rating">Community Rating: <strong>' . $community_rating . '</strong>/5 (based on ' . $community_review_count . _n( ' ratings', ' ratings', $community_review_count ) . ')</p>';
                echo '<p><small>The community rating is based on the average of the community reviews below.</small></p>';

              }

              if ( !empty( $our_rating ) && !empty( $community_rating ) ) {

                echo '<p class="rating composite-rating">Composite Rating: <strong>' . $composite_rating . '</strong>/5</p>';
                echo '<p><small>The composite rating is a weighted average of our rating and the community ratings below.</small></p>';

              }

            echo '</div>';

          echo '</div>';

        }

      echo '</div>';

      $trial_button	= trial_button();
      echo '<p align="center">' . $trial_button . '</p>';

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
