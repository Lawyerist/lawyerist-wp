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


  // Calculate shares.

    /* Twitter (via http://newsharecounts.com/) */
    $tw_api_call	= file_get_contents( 'http://public.newsharecounts.com/count.json?url=' . $url );
    $tw_shares		= json_decode( $tw_api_call );

    /* Facebook */
    // $fb_api_call	= 'http://api.facebook.com/restserver.php?format=json&method=links.getStats&urls=' . urlencode( $url );
    // $fb_shares		= json_decode( file_get_contents( $fb_api_call ), true );

    /* LinkedIn */
    $li_api_call	= file_get_contents( 'https://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json' );
    $li_shares		= json_decode( $li_api_call );

    $shares						= $tw_shares->count /* + $fb_shares[0][share_count] */ + $li_shares->count;
    $shares_formatted	= number_format( $shares );

  if ( $shares > 10 ) {
    echo '<span class="shares">' . $shares_formatted . ' Shares </span> ';
  }

  // Comments
  $num_comments	= get_comments_number();

  if ( $num_comments > 10 ) {
    echo '<span class="comment_link">' . $comments . '</span>';
  }

echo '</div>'; // Close .postmeta.

?>
