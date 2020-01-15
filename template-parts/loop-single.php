<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $post_title = the_title( '', '', FALSE );

  // Breadcrumbs
  if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
  }

  echo '<main>';

    // This is the post container.
    echo '<div ';
    post_class();
    echo '>';

      // Featured image
      if ( has_post_thumbnail() ) {

        echo '<div id="featured-image">';

        $featured_img_url_1x = get_the_post_thumbnail_url( $post->ID, 'large' );
        $featured_img_url_2x = get_the_post_thumbnail_url( $post->ID, 'large_2x' );

          echo '<img class="wp-post-image size-large" srcset="' . $featured_img_url_1x . ' 1x, ' . $featured_img_url_2x . ' 2x" src="' . $featured_img_url_1x . '" />';

        echo '</div>';

      }

      // Headline
      echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

      get_template_part( './template-parts/postmeta', 'single_top' );


      // Output the post.
      echo '<div class="post_body" itemprop="articleBody">';

        the_content();

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

        get_template_part( './template-parts/postmeta', 'single_bottom' );

      echo '</div>'; // Close .post_body.

    echo '</div>'; // Close .post.

  echo '</main>';

  echo lawyerist_cta();

  lawyerist_get_related_resources();

endwhile; endif; // Close the Loop.
