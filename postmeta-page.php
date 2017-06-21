<?php

// This must be used within the Loop.

  echo '<div class="postmeta">';

    // Get author and date.
    $author         = get_the_author_meta( 'display_name' );
    $updated_date   = get_the_modified_date( 'F jS, Y' );
    $author_url     = get_author_posts_url( get_the_author_meta( 'ID' ) );

    if ( $author != 'Lawyerist' ) {

      echo 'Page edited by <span class="vcard author author_name"><a href="' . $author_url . '">' . $author . '</a></span>.&nbsp;';

    }

    echo 'Last updated <span class="date updated published">' . $updated_date . '</span>.';

  echo '</div>'; // Close .postmeta.

?>
