<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  lawyerist_get_post_card();

  endwhile;

  ?>

  <div class="page_links"><?php echo paginate_links(); ?></div>

  <?php

else :

  ?>

  <p class="post">No posts match your query.</p>

  <?php 

endif; // Close the Loop.
