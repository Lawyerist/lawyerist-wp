<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'survival-guides' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		get_template_part( 'loop', 'page' );

		?>

		<div id="survival_guides">

			<?php

			// Get the Loop.
	    get_template_part( 'loop', 'guides' );

			?>

			<div class="clear"></div>

		</div><!-- end #survival_guides -->

	</div><!-- end #content_column -->


	<?php if ( !is_mobile() ) { include('sidebar.php'); } ?>

	<div class="clear"></div>


</div><!-- end #column_container -->

<div class="clear"></div>


<?php get_footer(); ?>


</body>
</html>
