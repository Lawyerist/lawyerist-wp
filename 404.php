<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<div class="post">

			<h1 class="headline">We Can't Find That Page</h1>

			<div class="post_body">

				<p>Sorry, we can't find the page you are looking for. Try searching for it, in case it moved:</p>

				<?php get_search_form(); ?>


				<p class="fp-section-header">Featured Resources</p>

				<?php
				// Outputs up to 12 pages with Show in Featured.
				$args = array(
					'meta_key'		=> 'order_in_featured',
					'meta_query'	=> array(
		        array(
	            'key'		=> 'show_in_featured',
	            'value'	=> true,
		        ),
			    ),
					'order'						=> 'ASC',
					'orderby'					=> 'meta_value_num',
					'post_type'				=> 'page',
					'posts_per_page'	=> 12,
				);

				$featured_pages_query = new WP_Query( $args );

				if ( $featured_pages_query->have_posts() ) :

					// Starts the post container.
					echo '<div id="fp-recent-pages" class="cards">';

						while ( $featured_pages_query->have_posts() ) : $featured_pages_query->the_post();

							lawyerist_get_post_card();

						endwhile; wp_reset_postdata();

					echo '</div>';

				endif;
				// End of featured pages.
				?>

				<p class="fp-section-header">Join your tribe. Grow your firm.</p>

				<?php if ( !is_user_logged_in() ) {
			    lawyerist_cta();
			  } ?>

			</div>

		</div>

	</div>

	<?php get_template_part( 'sidebar' ); ?>

</div>

<?php get_footer(); ?>
