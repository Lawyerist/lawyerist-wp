<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<div class="post">

			<h1 class="headline">We Can't Find That Page</h1>

			<div class="post_body">

				<p>Sorry, we can't find the page you are looking for. Try searching for it, in case it moved:</p>

				<?php get_search_form(); ?>
        
			</div>

		</div>

	</div>

	<?php get_template_part( 'template-parts/sidebar' ); ?>

</div>

<?php get_footer(); ?>
