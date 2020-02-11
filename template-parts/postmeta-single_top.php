<?php // This must be used within the Loop.

echo '<div class="postmeta">';

  $date = get_the_time( 'F jS, Y' );

  if ( has_category( array( 'case-studies', 'lab-workshops' ) ) ) {

    echo '<span class="date published">' . $date . '</span>';

  } else {

    $author = get_the_author_meta( 'display_name' );

    if ( $author == 'Lawyerist' ) {
      $author = 'the Lawyerist editorial team';
    }

    if ( has_category( 'sponsored' ) ) {

      $sponsor = get_sponsor_link( $post->ID );

      if ( !empty( $sponsor ) ) {

        if ( has_tag( 'product-spotlights' ) ) {

          // Adds "sponsored by" after the author on product spotlights.
          echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>,&nbsp;<span class="sponsor">sponsored by ' . $sponsor . '</span>, ';

        } else {

          // Otherwise, replaces the author with the sponsor's name.
          echo '<span class="sponsor">Sponsored by ' . $sponsor . '</span> ';

        }

      } else {

        // Fallback if no sponsor is tagged.
        echo '<span class="sponsor">Sponsored post</span>, published ';

      }

      echo 'on <span class="date updated published">' . $date . '</span>';

    } else {

      $author_ID          = get_the_author_meta( 'ID' );
      $author_post_count  = count_user_posts( $author_ID );
      $profile_page_url   = get_field( 'profile_page', 'user_' . $author_ID );

      if ( $author_post_count >= 5 && !empty( $profile_page_url ) ) {

        echo 'By <span class="vcard author"><cite class="fn"><a href="' . $profile_page_url . '" class="url">' . $author . '</a></cite></span> ';

      } else {

        echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span> ';

      }

      echo 'on <span class="date updated published">' . $date . '</span> ';

    }

  }

echo '</div>'; // Close .postmeta.
