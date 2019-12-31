<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  lawyerist_get_post_card();

  endwhile;

  echo '<div class="page_links">';
    echo paginate_links();
  echo '</div>';

else :

  echo '<p class="post">No posts match your query.</p>';

endif; // Close the Loop.
