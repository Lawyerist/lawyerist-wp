<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  // Assign post variables.
  $post_title = the_title( '', '', FALSE );

  // This is the post container.
  echo '<div ';
  post_class();
  echo '>';

    // Featured image
    if ( has_post_thumbnail() ) {
      echo '<div id="featured-image">';
        the_post_thumbnail();
      echo '</div>';
    }

    // Headline
    echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

    get_template_part( 'postmeta', 'single_top' );


    // Output the post.
    echo '<div class="post_body" itemprop="articleBody">';

      the_content();

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

      // Show date modified if it's different than the date published.
      get_template_part( 'postmeta', 'single_bottom' );

    echo '</div>'; // Close .post_body.

    lawyerist_get_related_resources();

    echo '<div id="comments_container">';
    comments_template( '/comments.php' );
    echo '</div>';

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.
