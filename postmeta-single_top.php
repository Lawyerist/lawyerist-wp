<?php

// This must be used within the Loop.

echo '<div class="postmeta">';

  // Get author and date.
  $author = get_the_author_meta( 'display_name' );
  $date   = get_the_time( 'F jS, Y' );

  // Selects product updates and sponsored posts because they should all have a
  // sponsor tag.
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
    $sponsor_url  = filter_var( $sponsor_info->description, FILTER_SANITIZE_URL );

    if ( empty( $sponsor_url ) ) {

      // Does not output the sponsor name as a link if the sponsor URL isn't in
      // the sponsor tag description.
      if ( has_category( 'sponsored-posts' ) ) { // Product updates and old sponsored posts.
        echo '<span class="sponsor">Sponsored by ' . $sponsor . '</span> ';
      } else { // Product spotlights.
        echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>,&nbsp;<span class="sponsor">sponsored by ' . $sponsor . '</span>, ';
      }

    // Outputs the sponsor name with a link if the sponsor URL is in the sponsor
    // tag description.
    } else {

      if ( has_category( 'sponsored-posts' ) ) { // Product updates and old sponsored posts.
        echo '<span class="sponsor">Sponsored by <a href="' . $sponsor_url . '">' . $sponsor . '</a></span> ';
      } else { // Product spotlights.
        echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>,&nbsp;<span class="sponsor">sponsored by <a href="' . $sponsor_url . '">' . $sponsor . '</a></span>,&nbsp;';
      }

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
