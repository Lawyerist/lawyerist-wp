<?php // This must be used within the Loop.

lawyerist_get_author_bio();

// Outputs list of additional contributors.
$coauthors  = get_coauthors();

/*
echo '<pre>';
var_dump( $coauthors );
echo '</pre>';
*/

if ( count( $coauthors ) > 1 ) {

  // Removes the primary author.
  unset( $coauthors[0] );

  echo '<p class="coauthors"><em>';

    $coauthor_list = array();

    foreach ( $coauthors as $coauthor ) {

      if ( count_user_posts( $coauthor->data->ID ) >= 5 ) {

        $profile_page_url = get_field( 'profile_page', 'user_' . $coauthor->data->ID );

        if ( empty( $profile_page_url ) ) {
          $profile_page_url = get_author_posts_url( $coauthor->data->ID );
        }

        $coauthor_list[] = '<span class="vcard author"><cite class="fn"><a href="' . $profile_page_url . '">' . $coauthor->data->display_name . '</a></cite></span>';

      } else {

        $coauthor_list[] = '<span class="vcard author"><cite class="fn">' . $coauthor->data->display_name . '</cite></span>';

      }

    }

    if ( count( $coauthor_list ) === 1 ) {

      echo $coauthor_list[ 0 ];

    } elseif ( count( $coauthor_list ) === 2 ) {

      echo implode( ' and ', $coauthor_list );

    } else {

      echo implode( ', ', array_slice( $coauthor_list, 0, -1 ) ) . ', and ' . end( $coauthor_list );

    }

  echo ' also contributed to this page.</em></p>';

}

$date         = get_the_time( 'F jS, Y' );
$updated_date = get_the_modified_date( 'F jS, Y' );

if ( $date != $updated_date ) {

  echo '<div class="postmeta">';
  echo 'Last updated <span class="date updated">' . $updated_date . '</span>.';
  echo '</div>'; // Close .postmeta.

}
