<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'index' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

    <!-- Outputs the Scorecard call to action. -->
		<div id="big_hero_cta" class="index_post_container">
			<a class="big_hero_top" href="https://lawyerist.com/scorecard/">
				<div class="scorecard_image_wrapper"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/scorecard-page.png" alt="The Small Firm Scorecard example" /></div>
				<div class="scorecard_prompt_wrapper">
					<h2>The Small Firm Scorecard<sup>TM</sup></h2>
					<p>Is your law firm structured to succeed in the future?</p>
				</div>
				<div class="clear"></div>
			</a>
			<div class="big_hero_button"><a class="button" href="https://lawyerist.com/scorecard/">Get Your Free Score</a></div>
		</div>

    <!-- Outputs the secondary calls to action: Insider, website assessment, and LPJ. -->
		<div id="secondary_ctas">

			<div class="index_post_container one_third">
			</div>

			<div class="index_post_container one_third">
			</div>

			<div class="index_post_container one_third">
			</div>

		</div>

		<?php

		$categories = get_categories();

		foreach ( $categories as $category ) {



		}

























		if ( has_category() && !has_category( 'sponsored-posts' ) ) {
			$post_classes[] = 'has-post-label';

			$cat_IDs = wp_get_post_terms(
				$post->ID,
				'category',
				array(
					'fields' 	=> 'ids',
					'orderby' => 'count',
					'order' 	=> 'DESC'
				)
			);

			$cat_info				= get_term( $cat_IDs[0] );
			$cat_slug				= $cat_info->slug;

			$post_label 		   	= $cat_info->name;
			$post_label_url			=	get_term_link( $cat_IDs[0], 'category' );
		}

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
