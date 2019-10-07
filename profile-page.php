<?php /* Template Name: Team Profile */ ?>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Get the Loop.
    get_template_part( 'loop', 'profile-page' );

		?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { get_template_part( 'sidebar' ); } ?>

</div><!--end #column_container-->

<?php get_footer(); ?>
