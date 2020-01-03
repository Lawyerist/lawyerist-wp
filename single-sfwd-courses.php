<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Get the Loop.
    get_template_part( 'loop', 'learndash' );

		?>

	</div><!-- end #content_column -->

</div><!--end #column_container-->

<div class="clear"></div>

<?php get_footer(); ?>
