<?php // This must be used within the Loop.

$author           = get_the_author_meta( 'display_name' );
$author_ID        = get_the_author_meta( 'ID' );
$profile_page_url = get_field( 'profile_page', 'user_' . $author_ID );
$updated_date     = get_the_modified_date( 'F jS, Y' );

if ( $author == 'Lawyerist' ) {
  $author = 'the Lawyerist editorial team';
}

if ( empty( $profile_page_url ) ) {
  $profile_page_url = get_author_posts_url( $author_ID );
}


echo '<div class="postmeta">';

  echo 'Page edited by <span class="vcard author"><cite class="fn"><a href="' . $profile_page_url . '" class="url">' . $author . '</a></cite></span>. ';

  echo 'Last updated <span class="date updated published">' . $updated_date . '</span>.';

echo '</div>'; // Close .postmeta.
