<?php get_header(); ?>

<div id="column_container">

  <div id="content_column">

    <?php

    lawyerist_get_archive_header();

    echo '<div class="cards">';

      // Start the Loop.
      if ( have_posts() ) : while ( have_posts() ) : the_post();

        lawyerist_get_post_card();

      endwhile;

    echo '</div>';

    echo '<div class="page_links">';
      echo paginate_links();
    echo '</div>';

    else :

      echo '<p class="post">No posts match your query.</p>';

    endif; // Close the Loop.

    ?>

	</div>
  <!-- end #content_column -->

</div>
<!-- end #column_container -->

<?php get_footer(); ?>
