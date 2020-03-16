<?php

get_header();

// Outputes the Scorecard Report Card widget.
if ( is_user_logged_in() ) {

	$current_user = wp_get_current_user();

	?>

	<div id="small-firm-dashboard-container">
		<p id="dashboard-title"><?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?>'s Small Firm Dashboard</p>
		<div id="small-firm-dashboard">
			<?php
			echo scorecard_results_graph();

			if ( wc_customer_bought_product( '', get_current_user_id(), 321206 ) ) {
				echo financial_scorecard_graph();
			}

			?>
		</div>
	</div>

	<?php

}

?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Checks to see if the front page is set to show blog posts, and if so uses
		// the same code as index.php.
		if ( 'posts' == get_option( 'show_on_front' ) ) :

			if ( is_archive() || is_search() ) {
				lawyerist_get_archive_header();
			}

	    get_template_part( 'template-parts/loop', 'index' );

		else :

			// Outputs the most recent sticky post.
			$sticky_posts = get_option( 'sticky_posts' );

			if ( $sticky_posts ) {

				$args = array(
					'post__in'						=> $sticky_posts,
					'posts_per_page'			=> 1,
				);

				$sticky_post_query = new WP_Query( $args );

				if ( $sticky_post_query->have_posts() ) :

					?>

					<div id="fp-sticky-posts">

						<?php

						while ( $sticky_post_query->have_posts() ) : $sticky_post_query->the_post();

							if ( is_sticky() ) {

								$sticky_post_title	= the_title( '', '', FALSE );
								$sticky_post_url		= get_permalink();

								?>

								<div <?php post_class( 'front_page_sticky_post card' ); ?>>
									<a href="<?php echo $sticky_post_url; ?>" title="<?php echo $sticky_post_title; ?>">
										<h2 class="headline"><?php echo $sticky_post_title; ?></h2>
									</a>
								</div>

								<?php

							}

						endwhile; wp_reset_postdata();

						?>

					</div>

					<?php

				endif;

			}

			// Outputs the call to action.
			echo lawyerist_cta();

			?>

			<p class="fp-section-header">Recent Updates</p>

			<?php

			// Outputs the most recent podcast episode.

			$podcast_feed			= fetch_feed( 'https://lawyerist.libsyn.com/' );
			$current_episode	= $podcast_feed->get_item( 0 );

			$show_img_url			= array(
				'1x' => 'https://lawyerist.com/lawyerist/wp-content/uploads/2019/12/podcast-mic_1x.png',
				'2x' => 'https://lawyerist.com/lawyerist/wp-content/uploads/2019/12/podcast-mic_2x.png',
			);
			$ep_title					= $current_episode->get_title();
			$ep_date					= $current_episode->get_date( 'F jS, Y' );

			?>

			<div class="card post-card podcast-card has-card-label">
				<a href="https://lawyerist.com/podcast/" title="The Lawyerist Podcast" class="post has-post-thumbnail">
					<?php echo wp_get_attachment_image( 529989, array( 100, 201 ) ); ?>
					<div class="headline-byline">
						<h2 class="headline" title="<?php echo $ep_title; ?>"><?php echo $ep_title; ?></h2>
						<div class="postmeta"><span class="date updated published"><?php echo $ep_date; ?></span></div>
					</div>
				</a>
				<p class="card-label card-bottom-label"><a href="https://lawyerist.com/podcast/" title="All episodes of The Lawyerist Podcast.">All episodes of The Lawyerist Podcast</a></p>
			</div>

			<?php

			// Outputs 4 pages with Show in Recent.

			$args = array(
				'meta_key'				=> 'show_in_recent',
				'meta_value'			=> true,
				'orderby'					=> 'modified',
				'post_type'				=> 'page',
				'posts_per_page'	=> 4,
			);

			$recent_pages_query = new WP_Query( $args );

			if ( $recent_pages_query->have_posts() ) :

				?>

				<div id="fp-recent-pages" class="cards">

					<?php

					while ( $recent_pages_query->have_posts() ) : $recent_pages_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

					?>

				</div>

				<?php

			endif;


			// Outputs sponsored posts in the current range (today minus 7 days) using
			// the Sponsored Post Options start and end dates.

			$today			= date( 'Ymd' );
			$a_week_ago = date( 'Ymd', strtotime( '-7 days' ) );

			$args		= array(
				'cat'					=> 1320,
				'meta_query'	=> array(
					array(
						'key'     => 'sponsored_post_start_date',
						'compare' => '>=',
						'value'   => $a_week_ago,
					),
					array(
						'key'     => 'sponsored_post_end_date',
						'compare' => '>=',
						'value'   => $today,
					),
				),
				'orderby'							=> 'meta_value_num',
				'post__not_in'				=> get_option( 'sticky_posts' ),
				'posts_per_page'			=> 5,
			);

			$current_post_query = new WP_Query( $args );

			if ( $current_post_query->have_posts() ) :

				?>

				<div id="fp-product-spotlights" class="card has-card-label sponsored">

					<?php

					while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

					$all_spotlights_txt		= 'All Partner Updates';
					$all_spotlights_url		=	get_category_link( 1320 );

					echo '<p class="card-label card-bottom-label"><a href="' . $all_spotlights_url . '" title="' . $all_spotlights_txt . '">' . $all_spotlights_txt . '</a></p>';

					?>

				</div>

				<?php

			endif;


			// Outputs the 3 most recent blog posts.

			$args = array(
				'category__in'		=> array(
					'555', // Blog Posts
				),
				'post__not_in'		=> get_option( 'sticky_posts' ),
				'posts_per_page'	=> 3,
			);

			$current_post_query = new WP_Query( $args );

			if ( $current_post_query->have_posts() ) :

				?>

				<div id="fp-blog-posts" class="card has-card-label">

					<?php

					while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

					$all_posts_txt	= 'All Blog Posts';
					$all_posts_url	=	get_category_link( 555 );

					echo '<p class="card-label card-bottom-label"><a href="' . $all_posts_url . '" title="' . $all_posts_txt . '">' . $all_posts_txt . '</a></p>';

					?>

				</div>

				<?php

			endif;


			// Outputs the 3 most recent case studies.

			$args = array(
				'category__in'		=> array(
					'4406', // Blog Posts
				),
				'post__not_in'		=> get_option( 'sticky_posts' ),
				'posts_per_page'	=> 3,
			);

			$current_post_query = new WP_Query( $args );

			if ( $current_post_query->have_posts() ) :

				?>

				<div id="fp-case-studies" class="card has-card-label">

					<?php

					while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

					$all_posts_txt	= 'All Small Firm Roadmap Stories';
					$all_posts_url	=	get_category_link( 4406 );

					echo '<p class="card-label card-bottom-label"><a href="' . $all_posts_url . '" title="' . $all_posts_txt . '">' . $all_posts_txt . '</a></p>';

					?>

				</div>

				<?php

			endif;

			?>

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

				?>

				<div id="fp-recent-pages" class="cards">

					<?php

					while ( $featured_pages_query->have_posts() ) : $featured_pages_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

					?>

				</div>

				<?php

			endif;

			?>

	</div><!-- end #content_column -->

	<?php get_template_part( 'template-parts/sidebar' ); ?>

<?php

	endif;

?>

</div><!--end #column_container-->

<?php get_footer(); ?>
