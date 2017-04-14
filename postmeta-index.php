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
      echo '<span class="author sponsor">Sponsored by ' . $sponsor . '</span> ';
    } else {
      echo '<span class="author">By ' . $author . ',&nbsp;</span><span class="author sponsor">sponsored by ' . $sponsor . ',&nbsp;</span>';
    }

    echo '<span class="date">on ' . $date . '</span>';

  } elseif ( $author == 'Lawyerist' ) {

    echo '<span class="date">' . $date . '</span>';

  } else {

    echo '<span class="author">By ' . $author . '&nbsp;</span>';
    echo '<span class="date">on ' . $date . '</span>';

  }

  // Comments
  $num_comments	= get_comments_number();

  if ( $num_comments > 10 ) {
    echo '<span class="comment_link">' . $num_comments . ' comments</span>';
  }

echo '</div>'; // Close .postmeta.

?>
