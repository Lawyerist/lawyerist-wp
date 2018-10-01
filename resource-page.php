<?php /* Template Name: Resource Page */ ?>

<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'resource-page' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Get the Loop.
    get_template_part( 'loop', 'resource-page' );

		?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include('sidebar.php'); } ?>

	<div class="clear"></div>

</div><!--end #column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
