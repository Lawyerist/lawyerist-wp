<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'survival-guides' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		get_template_part( 'loop', 'page' );

		echo '<div id="survival_guides">';

			// Get the Loop.
	    get_template_part( 'loop', 'page-guides' );

			echo '<div class="clear"></div>';

		echo '</div>'; // End #survival_guides

		?>

	</div><!-- end #content_column -->


	<?php if ( !is_mobile() ) { include('sidebar.php'); } ?>

	<div class="clear"></div>


</div><!-- end #column_container -->

<div class="clear"></div>


<?php get_footer(); ?>


</body>
</html>
