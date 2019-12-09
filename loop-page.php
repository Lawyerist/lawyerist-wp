<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $page_title   = the_title( '', '', FALSE );
  $page_ID      = $post->ID;

  // Breadcrumbs
  if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
  }

  echo '<main>';

    // This is the post container.
    echo '<div ';
    post_class();
    echo '>';

      $show_featured_image = get_field( 'show_featured_image' );

      // Featured image
      if ( ( is_null( $show_featured_image ) || $show_featured_image == true ) && has_post_thumbnail() ) {
        echo '<div id="featured-image">';
          the_post_thumbnail();
        echo '</div>';
      }

      // Headline
      echo '<h1 class="headline entry-title">' . $page_title . '</h1>';

      // Output the post.
      echo '<div class="post_body" itemprop="articleBody">';

        if ( is_product_portal() && !is_page( '301729' ) ) {

          if ( !has_shortcode( $post->post_content, 'list-featured-products' ) ) {
            echo do_shortcode( '[list-featured-products]' );
          }

          if ( !has_shortcode( $post->post_content, 'list-products' ) ) {
            echo do_shortcode( '[list-products show_features="false"]' );
          }

        }

        the_content();

        // Byline
        if ( !is_really_a_woocommerce_page() ) {
          get_template_part( 'postmeta', 'page' );
        }

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

    echo '</div>'; // Close .post.

  echo '</main>';

  if ( !is_user_logged_in() ) {
    lawyerist_cta();
  }

  if ( comments_open() ) {

    echo '<div id="comments_container">';

    if ( function_exists( 'wp_review_show_total' ) ) {
      comments_template( '/reviews.php' );
    } else {
      comments_template( '/comments.php' );
    }

    echo '</div>';

  }

  lawyerist_get_related_posts();

endwhile; endif; // Close the Loop.
