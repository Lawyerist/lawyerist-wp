<?php

// This must be used within the Loop.

echo '<div class="postmeta">';

  // Get author and date.
  $author     = get_the_author_meta( 'display_name' );
  $date       = get_the_time( 'F jS, Y' );

  if ( has_term( true, 'sponsor' ) ) {

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
    $sponsor_url  = $sponsor_info->description;

    if ( has_category( 'sponsored-posts' ) ) {
      echo '<span class="author sponsor">Sponsored by <a href="' . $sponsor_url . '">' . $sponsor . '</a></span> ';
    } else {
      echo '<span class="author">By <a href="' . $author_url . '">' . $author . '</a>,&nbsp;</span><span class="author sponsor">sponsored by <a href="' . $sponsor_url . '">' . $sponsor . '</a>,&nbsp;</span> ';
    }

    echo '<span class="date">on ' . $date . '</span>';

  } elseif ( $author == 'Lawyerist' ) {

    echo '<span class="date">' . $date . '</span>';

  } else {

    $author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );

    echo '<span class="author">By <a href="' . $author_url . '">' . $author . '</a>&nbsp;</span>';
    echo '<span class="date">on ' . $date . '</span>';

  }

  // Comments
  $num_comments	= get_comments_number();

  if ( $num_comments > 10 ) {
    echo '<span class="comment_link">' . $comments . '</span>';
  }

echo '</div>'; // Close .postmeta.

?>
