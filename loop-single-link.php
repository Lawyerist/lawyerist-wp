<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $post_title   = the_title( '', '', FALSE );

  // This is the post container.
  echo '<div ';
  post_class( 'hentry' );
  echo '>';

    echo '<div class="headline_postmeta">';

      // Headline
      echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

    echo '</div>'; // Close .headline_postmeta.

    // Show featured image (1) if the post has a featured image AND (2) if it's
    // the first page of the post AND (3) the post DOES NOT have the no-image tag.
    if ( has_post_thumbnail() ) {

      echo '<div itemprop="image">';
      the_post_thumbnail( 'standard_thumbnail' );
      echo '</div>';

    }

    // Output the post.
    echo '<div class="post_body" itemprop="articleBody">';

      the_content();

      echo '<div class="clear"></div>';

    echo '</div>'; // Close .post_body.

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.

?>
