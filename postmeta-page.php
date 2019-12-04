<?php // This must be used within the Loop.

$author           = get_the_author_meta( 'display_name' );
$author_ID        = get_the_author_meta( 'ID' );
$profile_page_url = get_field( 'profile_page', 'user_' . $author_ID );
$updated_date     = get_the_modified_date( 'F jS, Y' );

if ( $author == 'Lawyerist' ) {
  $author = 'the Lawyerist editorial team';
}

echo '<div class="postmeta">';

  if ( !empty( $profile_page_url ) ) {

    echo 'Page edited by <span class="vcard author"><cite class="fn"><a href="' . $profile_page_url . '" class="url">' . $author . '</a></cite></span>. ';

  } else {

    echo 'Page edited by <span class="vcard author"><cite class="fn">' . $author . '</cite></span>. ';
    
  }

  $coauthors  = get_coauthors();

	if ( count( $coauthors ) > 1 ) {

    echo '<span class="coauthors">';
    lawyerist_get_coauthors();
    echo '</span> ';

  }

  echo 'Last updated <span class="date updated published">' . $updated_date . '</span>.';

echo '</div>'; // Close .postmeta.
