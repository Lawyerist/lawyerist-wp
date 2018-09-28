<?php

// This must be used within the Loop.

echo '<div class="postmeta">';

  // Get author and date.
  $author = get_the_author_meta( 'display_name' );
  $date   = get_the_time( 'F jS, Y' );

  // Gets the byline for sponsored posts.
  if ( has_term( true, 'sponsor' ) || has_category( 'sponsored-posts' ) ) {

    $sponsor_IDs = wp_get_post_terms(
      $post->ID,
      'sponsor',
      array(
        'fields' 	=> 'ids',
        'orderby' => 'count',
        'order' 	=> 'DESC'
      )
    );

    $sponsor_info = get_term( $sponsor_IDs[0] );
    $sponsor      = $sponsor_info->name;

    // Replaces the author with the sponsor on sponsored product updates and old sponsored posts.
    if ( has_category( 'sponsored-posts' ) ) {

      echo '<span class="sponsor">Sponsored by ' . $sponsor . '</span> ';

    // Adds "sponsored by" after the authoer on product spotlights.
    } else {

      echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>,&nbsp;<span class="sponsor">sponsored by ' . $sponsor . '</span>, ';

    }

    echo 'on <span class="date updated published">' . $date . '</span>';

  // Gets the byline without the author when Lawyerist is the author, and for podcasts.
  } elseif ( $author == 'Lawyerist' || has_category( 'lawyerist-podcast' ) ) {

    echo '<span class="date updated published">' . $date . '</span>';

  } else {

    echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span> ';
    echo 'on <span class="date updated published">' . $date . '</span> ';

  }

  // Comments
  $num_comments	= get_comments_number();

  if ( $num_comments > 10 ) {
    echo '<span class="comment_link">' . $num_comments . ' comments</span>';
  }

echo '</div>'; // Close .postmeta.

?>
