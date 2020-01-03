<?php get_header(); ?>

<div id="column_container">

  <div id="content_column">

    <?php

    // Gets the archive header for archives and search pages.
    if ( is_archive() || is_search() ) {

      lawyerist_get_archive_header();

    }

    // Gets the appropriate Loop.
    if ( is_single() ) {

      get_template_part( 'template-parts/loop', 'single' );

    } elseif ( is_page() ) {

      get_template_part( 'template-parts/loop', 'page' );

    } else {

      get_template_part( 'template-parts/loop', 'index' );

    }

    ?>

  </div>
  <!-- end #content_column -->

  <?php get_template_part( 'template-parts/sidebar' ); ?>

</div>
<!-- end #column_container -->

<?php get_footer(); ?>
