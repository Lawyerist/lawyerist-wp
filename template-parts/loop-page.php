<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $page_title = the_title( '', '', FALSE );

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

          if ( is_page_template( 'product-page.php' ) || is_page_template( 'full-width.php' ) ) {

            $featured_img_url_1x = get_the_post_thumbnail_url( $post->ID, 'featured_image' );
            $featured_img_url_2x = get_the_post_thumbnail_url( $post->ID, 'featured_image_2x' );

          } else {

            $featured_img_url_1x = get_the_post_thumbnail_url( $post->ID, 'large' );
            $featured_img_url_2x = get_the_post_thumbnail_url( $post->ID, 'large_2x' );

          }

          echo '<img class="wp-post-image size-large" srcset="' . $featured_img_url_1x . ' 1x, ' . $featured_img_url_2x . ' 2x" src="' . $featured_img_url_1x . '" />';

        echo '</div>';

      }

      // Headline
      echo '<h1 class="headline entry-title">' . $page_title . '</h1>';

      // Output the post.
      echo '<div class="post_body" itemprop="articleBody">';

        if ( is_product_portal() && !is_page( 'reviews' ) ) {

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
          get_template_part( './template-parts/postmeta', 'page' );
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

  echo lawyerist_cta();

  // Shows review template if comments are open and reviews are enabled. The only
  // reason this is present on plain pages is that we're using the regular page
  // template for a few specific pages like Lab and LabCon.
  if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

    echo '<div id="comments_container">';
      comments_template( '/reviews.php' );
    echo '</div>';

  }

  lawyerist_get_related_posts();

endwhile; endif; // Close the Loop.
