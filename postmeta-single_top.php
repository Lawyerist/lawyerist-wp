<?php // This must be used within the Loop.

echo '<div class="postmeta">';

  // Gets the date because we always show the date.
  $date = get_the_time( 'F jS, Y' );

  // Shows just the date for podcast posts.
  if ( has_category( 'lawyerist-podcast' ) ) {

    echo '<span class="date published">' . $date . '</span> ';

  // Shows just the sponsor on product updates and sponsored posts.
  } elseif ( has_category( 'sponsored-posts' ) ) {

    $sponsor = get_sponsor_link();

    if ( !empty( $sponsor ) ) {

      echo '<span class="sponsor">Sponsored by ' . $sponsor . '</span> ';

    } else {

      echo '<span class="sponsor">Sponsored post</span>, published ';

    }

    echo 'on <span class="date published">' . $date . '</span> ';


  // Shows the author on blog posts, and adds the sponsor for product spotlights.
  } elseif ( has_category( 'blog-posts' ) ) {

    $author             = get_the_author_meta( 'display_name' );
    $author_ID          = get_the_author_meta( 'ID' );
    $author_post_count  = count_user_posts( $author_ID );

    if ( $author == 'Lawyerist' ) {

      $author = 'the Lawyerist editorial team';

    }

    if ( $author_post_count >= 5 ) {

      $profile_page_url = get_field( 'profile_page', 'user_' . $author_ID );

      if ( empty( $profile_page_url ) ) {
        $profile_page_url = get_author_posts_url( $author_ID );
      }

      echo 'By <span class="vcard author"><cite class="fn"><a href="' . $profile_page_url . '" class="url">' . $author . '</a></cite></span>';

    } else {

      echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>';

    }

    if ( !has_tag( 'product-spotlights' ) ) { echo ' '; }

    if ( has_tag( 'product-spotlights' ) ) {

      $sponsor = get_sponsor_link();

      if ( !empty( $sponsor ) ) {

        echo ', <span class="sponsor">sponsored by ' . $sponsor . '</span>, ';

      } else {

        echo ', <span class="sponsor">Sponsored post</span>, published ';

      }

    }

    echo 'on <span class="date published">' . $date . '</span> ';

  } else {

    echo '<span class="date published">' . $date . '</span> ';

  }


  // Comments
  $num_comments	= get_comments_number();

  if ( $num_comments > 10 ) {
    echo '<span class="comment_link"><a href="#comments">' . $num_comments . ' comments</a></span>';
  }

echo '</div>'; // Close .postmeta.
