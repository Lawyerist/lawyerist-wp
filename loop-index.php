<?php

$post_num = 1; // Counter for inserting mobile ads and other stuff.

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  lawyerist_get_post_card();

  // Insert product updates, and ads on mobile.
  if ( $post_num == 1 && is_mobile() && !has_category( 'lab-workshops' ) ) { lawyerist_get_display_ad(); }

  $post_num++; // Increment counter.

endwhile;

if ( is_plugin_active( 'ajax-load-more/ajax-load-more.php' ) && is_category() ) {

  $cat            = get_query_var( 'cat' );
  $category       = get_category ( $cat );
  $posts_per_page = get_option( 'posts_per_page' );


  echo do_shortcode( '[ajax_load_more container_type="div" post_type="post" category="' . $category->slug . '" offset="' . $posts_per_page . '" button_label="Load More" button_loading_label="Loading …"]' );

} else {

  echo '<div class="page_links">';
    echo paginate_links();
  echo '</div>';

}

else :

  echo '<p class="post">No posts match your query.</p>';

endif; // Close the Loop.
