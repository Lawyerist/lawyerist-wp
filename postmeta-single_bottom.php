<?php // This must be used within the Loop.

$coauthors = get_coauthors();

echo '<pre>';
var_dump( $coauthors );
echo '</pre>';

lawyerist_get_author_bio();

$date         = get_the_time( 'F jS, Y' );
$updated_date = get_the_modified_date( 'F jS, Y' );

if ( $date != $updated_date ) {

  echo '<div class="postmeta">';
  echo 'Last updated <span class="date updated">' . $updated_date . '</span>.';
  echo '</div>'; // Close .postmeta.

}
