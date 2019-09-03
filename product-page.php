<?php /* Template Name: Product Page */ ?>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Get the Loop.
		if ( is_product_portal() ) {

			get_template_part( 'loop', 'page' );

		} else {

			get_template_part( 'loop', 'product-page' );
			
		}

		?>

	</div><!-- end #content_column -->

</div><!--end #column_container-->

<?php get_footer(); ?>
