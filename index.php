<?php get_header(); ?>

<div id="column_container">

  <div id="content_column">

    <?php

    // Gets the archive header for archive, author, and search pages.
    if ( is_archive() || is_author() || is_search() ) {

      lawyerist_get_archive_header();

    }

    // Gets the appropriate Loop.
    if ( is_single() ) {

      get_template_part( 'loop', 'single' );

    } elseif ( is_page() ) {

      get_template_part( 'loop', 'page' );

    } else {

      get_template_part( 'loop', 'index' );
    }

    ?>

	</div>
  <!-- end #content_column -->

	<?php

  if ( !is_mobile() && !wc_memberships_is_user_active_member( get_current_user_id(), 'lab' ) ) {
    get_template_part( 'sidebar' );
  }

  ?>

</div>
<!-- end #column_container -->

<?php get_footer(); ?>
