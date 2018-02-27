<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'index' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

    <?php

    // Outputs the Scorecard call to action.
		echo '<div id="big_hero" class="index_post_container">';
			echo '<a id="big_hero_top" href="https://lawyerist.com/scorecard/">';
				echo '<div id="scorecard_image_wrapper"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/scorecard-page.png" alt="The Small Firm Scorecard example" /></div>';
				echo '<div id="scorecard_prompt_wrapper">';
					echo '<h2>The Small Firm Scorecard<sup>TM</sup></h2>';
					echo '<p>Is your law firm structured to succeed in the future?</p>';
				echo '</div>';
				echo '<div class="clear"></div>';
			echo '</a>';
			echo '<div id="big_hero_button"><a class="button" href="https://lawyerist.com/scorecard/">Get Your Free Score</a></div>';
		echo '</div>';

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
