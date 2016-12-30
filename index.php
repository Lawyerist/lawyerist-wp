<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'index' ); ?>>

<?php get_header(); ?>

<div id="column_container">

  <div id="content_column">

    <?php

    if ( is_archive() || is_search() ) { lawyerist_get_archive_header(); }

    // Get the Loop.
    get_template_part( 'loop', 'index' );

    ?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { get_template_part( 'sidebar' ); } ?>

	<div class="clear"></div>

</div><!-- end #column_container -->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
