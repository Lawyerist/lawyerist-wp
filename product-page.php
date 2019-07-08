<?php /* Template Name: Product Page */ ?>

<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'product-page full-width' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Get the Loop.
    get_template_part( 'loop', 'product-page' );

		?>

	</div><!-- end #content_column -->

</div><!--end #column_container-->

<?php get_footer(); ?>

</body>
</html>
