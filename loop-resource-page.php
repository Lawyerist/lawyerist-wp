<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $post_title   = the_title( '', '', FALSE );

  // This is the post container.
  echo '<div ';
  post_class( 'hentry' );
  echo '>';

    // Breadcrumbs
    if ( function_exists( 'yoast_breadcrumb' ) ) {
      yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
    }

    echo '<div class="headline_container">';

      // Show featured image if there is one.
      if ( has_post_thumbnail() ) {
        echo '<div itemprop="image">';
        the_post_thumbnail( 'thumbnail' );
        echo '</div>';
      }

      // Headline
      echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

      echo '<div class="clear"></div>';

    echo '</div>'; // Close .headline_postmeta.

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

?>
