<?php // This must be used within the Loop.

// Show author bio box unless the author is Guest (26).
if ( get_the_author_meta( 'ID' ) != 26 ) {

  lawyerist_get_author_bio();

  ?>

  <p class="coauthors"><em><?php get_coauthors(); ?></em></p>

  <?php

}

$date         = get_the_time( 'F jS, Y' );
$updated_date = get_the_modified_date( 'F jS, Y' );

if ( $date != $updated_date ) {

  ?>

  <div class="postmeta">Last updated <span class="date updated"><?php echo $updated_date; ?></span>.</div>

  <?php

}
