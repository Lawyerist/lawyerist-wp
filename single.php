<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( $class ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Assign post variables.
		$post_type	= get_post_type( $post->ID );

		// Get the Loop.
		if ( $post_type == 'download' ) {

			get_template_part( 'loop', 'single-download' );

		} elseif ( has_post_format( 'link' ) ) {

			get_template_part( 'loop', 'single-link' );

		} else {

			get_template_part( 'loop', 'single' );

		}

		?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

	<div class="clear"></div>

</div><!--end #column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
