<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $page_title   = the_title( '', '', FALSE );
  $page_ID      = $post->ID;

  // This is the post container.
  echo '<div ';
  post_class();
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
      echo '<h1 class="headline entry-title">' . $page_title . '</h1>';

      // Output the excerpt.
      $seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );

      if ( !empty( $seo_descr ) ) {

        $post_excerpt = $seo_descr;

      } else {

        $post_excerpt = get_the_excerpt();

      }

      echo '<p class="excerpt">' . $post_excerpt . '</p>';

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

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.
