<?php

// This must be used within the Loop.

echo '<div class="postmeta">';

  // Get author and date.
  $author = get_the_author_meta( 'display_name' );
  $date   = get_the_time( 'F jS, Y' );

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

    if ( has_category( 'sponsored-posts' ) ) {
      echo '<span class="sponsor">Sponsored by ' . $sponsor . '</span> ';
    } else {
      echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>,&nbsp;<span class="sponsor">sponsored by ' . $sponsor . '</span>,&nbsp;';
    }

    echo 'on <span class="date updated published">' . $date . '</span>';

  } elseif ( $author == 'Lawyerist' ) {

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
