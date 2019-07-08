<?php /* Template Name: Team Profile */ ?>

<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'profile-page' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Get the Loop.
    get_template_part( 'loop', 'profile-page' );

		?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

</div><!--end #column_container-->

<?php get_footer(); ?>

</body>
</html>
