<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Breadcrumbs
    if ( function_exists( 'yoast_breadcrumb' ) ) {
      yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
    }

		woocommerce_content();

		?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

</div><!--end #column_container-->

<?php get_footer(); ?>
