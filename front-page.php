<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'index' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

    <?php

    // Outputs the Scorecard call to action.

    // Outputs the Insider, website assessment, and LPJ calls to action.

    // Outputs the most recent podcast episode.

    // Outputs strategic resource pages.

    // Outputs the most recent How Lawyers Work post.

    // Outputs the most recent download.

    // Outputs the Sponsored Product Updates widget.
    lawyerist_sponsored_product_updates();

    // Outputs the Recent Page Updates widget.

    ?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

	<div class="clear"></div>

</div><!--end #column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
