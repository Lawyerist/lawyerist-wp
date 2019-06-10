<?php // This must be used within the Loop.

$author = get_the_author_meta( 'display_name' );
$date   = get_the_time( 'F jS, Y' );

if ( $author == 'Lawyerist' ) {
  $author = 'the Lawyerist editorial team';
}

echo '<div class="postmeta">';

  // Gets the byline for sponsored posts.
  if ( has_term( true, 'sponsor' ) || has_category( 'sponsored-posts' ) ) {

    $sponsor_IDs = wp_get_post_terms(
      $post->ID,
      'sponsor',
      array(
        'fields' 	=> 'ids',
        'orderby' => 'count',
        'order' 	=> 'DESC',
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

  // Gets just the date on author archives.
  } elseif ( is_author() ) {

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
