<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  // Assign post variables.
  $post_title = the_title( '', '', FALSE );

  // This is the post container.
  echo '<div ';
  post_class( 'hentry' );
  echo '>';

    echo '<div class="headline_postmeta">';

      // Shows author avatar on blog posts.
      if ( has_category( 'blog-posts' ) ) {
        $author_name   = get_the_author_meta( 'display_name' );
        $author_avatar = get_avatar( get_the_author_meta( 'user_email' ), 100, '', $author_name );

        echo '<div class="author_avatar">';
        echo $author_avatar;
        echo '</div>';
      }

      // Headline
      echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

      // Call the lawyerist_postmeta function, which outputs the byline, date,
      // and comment count.
      get_template_part( 'postmeta', 'single_top' );

      echo '<div class="clear"></div>';

    echo '</div>'; // Close .headline_postmeta.

    // Shows featured image if (1) this isn't a blog post AND (2) this post
    // has a featured image AND (3) it is the first page of the post AND (4) the
    // post DOES NOT have the no-image tag.
    if ( !has_category( 'blog-posts' ) && has_post_thumbnail() && !has_tag('no-image') ) { the_post_thumbnail('standard_thumbnail'); }

    // Output the post.
    echo '<div class="post_body" itemprop="articleBody">';

      the_content();

      // Show date modified if it's different than the date published.
      get_template_part( 'postmeta', 'single_bottom' );

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

    // Outputs the author bio except on blog posts.
  	if ( !has_category( 'blog-posts' ) ) {
      lawyerist_get_author_bio();
    }

    lawyerist_current_posts( $this_post );

    echo '<div id="comments_container">';
    comments_template( '/comments.php' );
    echo '</div>';

    lawyerist_get_related_pages();

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.
