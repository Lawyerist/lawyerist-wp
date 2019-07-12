<?php

/*------------------------------
Selectors

has_category( 'lawyerist-podcast' )
has_term( true, 'sponsor' )
$post_type == 'product'
$post_type == 'page'

------------------------------*/

$post_num = 1; // Counter for inserting mobile ads and other stuff.

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  lawyerist_get_post_card();

  // Insert product updates, and ads on mobile.
  if ( $post_num == 1 && is_mobile() ) { lawyerist_get_display_ad(); }

  $post_num++; // Increment counter.

endwhile;

echo '<div class="page_links">';
  echo paginate_links();
echo '</div>';

else :

  echo '<p class="post">No posts match your query.</p>';

endif; // Close the Loop.
