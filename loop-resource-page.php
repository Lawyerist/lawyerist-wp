<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $page_title   = the_title( '', '', FALSE );
  $page_ID      = $post->ID;

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
        the_post_thumbnail( 'shop_thumbnail' );
        echo '</div>';
      }

      // Headline
      echo '<h1 class="headline entry-title">' . $page_title . '</h1>';

      // Output the excerpt.
      $seo_descr = get_post_meta( $page_ID, '_yoast_wpseo_metadesc', true );

      if ( !empty( $seo_descr ) ) {

        $page_excerpt = $seo_descr;

      } else {

        $page_excerpt = get_the_excerpt();

      }

      echo '<p class="excerpt">' . $page_excerpt . '</p>';

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

    lawyerist_get_related_podcasts();
    lawyerist_get_related_posts();

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.
