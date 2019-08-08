<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<div class="post">

			<h1 class="headline">We Can't Find That Page</h1>

			<div class="post_body">

				<p>Sorry, we can't find the page you are looking for. Try searching for it, in case it moved:</p>

				<div id="lawyerist_content_search">
					<?php get_search_form(); ?>
				</div>

				<p>Or, maybe you prefer a more serendipitous approach to discovery. Here are our most popular tags:</p>

				<div class="tag_cloud"><?php wp_tag_cloud('exclude=2580,2602'); ?></div>

			</div>

		</div>

	</div>

	<?php if ( !is_mobile() ) { get_template_part( 'sidebar' ); } ?>

	<div class="clear"></div>

</div>

<div class="clear"></div>

<?php get_footer(); ?>
