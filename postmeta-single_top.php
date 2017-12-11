<?php

// This must be used within the Loop.

echo '<div class="postmeta">';

  // Get author and date.
  $author         = get_the_author_meta( 'display_name' );
  $date           = get_the_time( 'F jS, Y' );

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
      echo '<span class="sponsor">Sponsored by <a href="' . $sponsor_url . '">' . $sponsor . '</a></span> ';
    } else {
      echo 'By <span class="vcard author"><cite class="fn">Lawyerist</cite></span>,&nbsp;<span class="sponsor">sponsored by <a href="' . $sponsor_url . '">' . $sponsor . '</a></span>,&nbsp;';
    }

    echo 'on <span class="date updated published">' . $date . '</span>';

  } elseif ( $author == 'Lawyerist' ) {

    echo '<span class="date updated published">' . $date . '</span>';

  } else {

    $author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );

    echo 'By <span class="vcard author"><cite class="fn"><a href="' . $author_url . '" class="url">' . $author . '</a></cite></span> ';
    echo 'on <span class="date published">' . $date . '</span> ';

  }

  // Comments
  $num_comments	= get_comments_number();

  if ( $num_comments > 10 ) {
    echo '<span class="comment_link"><a href="#comments">' . $num_comments . ' comments</a></span>';
  }

echo '</div>'; // Close .postmeta.

?>
