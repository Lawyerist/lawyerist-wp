<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

	<?php

		// Checks to see if the front page is set to show blog posts, and if so uses
		// the same code as index.php.
		if ( 'posts' == get_option( 'show_on_front' ) ) :

			if ( is_archive() || is_search() ) { lawyerist_get_archive_header(); }

	    // Get the Loop.
	    get_template_part( 'loop', 'index' );

		else :

			// Outputs the most recent sticky post.
			$sticky_posts = get_option( 'sticky_posts' );

			$sticky_post_query_args = array(
				'post__in'						=> $sticky_posts,
				'posts_per_page'			=> 1,
			);

			$sticky_post_query = new WP_Query( $sticky_post_query_args );

			if ( $sticky_post_query->have_posts() ) :

				while ( $sticky_post_query->have_posts() ) : $sticky_post_query->the_post();

					$num_sticky_posts = 0;

					if ( is_sticky() ) {

						$num_sticky_posts++;

						$sticky_post_title	= the_title( '', '', FALSE );
						$sticky_post_url		= get_permalink();

						// Starts the post container.
						echo '<div ';
						post_class( 'front_page_sticky_post card' );
						echo '>';

							// Starts the link container. Makes for big click targets!
							echo '<a href="' . $sticky_post_url . '" title="' . $sticky_post_title . '">';

								echo '<h2 class="headline">' . $sticky_post_title . '</h2>';

							echo '</a>';

						echo '</div>';

					}

				endwhile; wp_reset_postdata();

			endif;

			if ( $num_sticky_posts > 0 ) {
				echo '<div class="separator_3rem"></div>';
			}


			// Outputes the Scorecard Report Card widget.
			if ( is_user_logged_in() ) {

				echo '<div id="insider-dashboard">';

					$current_user = wp_get_current_user();
					echo '<p id="dashboard-title">' . $current_user->user_firstname . ' ' . $current_user->user_lastname . '\'s Small Firm Dashboard</p>';

					echo scorecard_results_graph();

				echo '</div>';

			}


			echo lawyerist_cta();


			echo '<p class="fp-section-header">Recent Updates</p>';

			// Outputs the most recent podcast episode.

			$podcast_feed			= fetch_feed( 'https://lawyerist.libsyn.com/' );
			$current_episode	= $podcast_feed->get_item( 0 );

			$show_img_url			= array(
				'1x' => 'https://lawyerist.com/lawyerist/wp-content/uploads/2019/12/podcast-mic_1x.png',
				'2x' => 'https://lawyerist.com/lawyerist/wp-content/uploads/2019/12/podcast-mic_2x.png',
			);
			$ep_title					= $current_episode->get_title();
			$ep_date					= $current_episode->get_date( 'F jS, Y' );

			echo '<div class="card post-card podcast-card has-card-label">';
				echo '<a href="https://lawyerist.com/podcast/" title="The Lawyerist Podcast" class="post has-post-thumbnail">';
					echo '<img srcset="' . $show_img_url[ '1x' ] . ' 1x, ' . $show_img_url[ '2x' ] . ' 2x" src="' . $show_img_url[ '1x' ] . '" />';
					echo '<div class="headline-byline">';
						echo '<h2 class="headline" title="' . $ep_title . '">' . $ep_title . '</h2>';
						echo '<div class="postmeta"><span class="date updated published">' . $ep_date . '</span></div>';
					echo '</div>';
				echo '</a>';
				echo '<p class="card-label card-bottom-label"><a href="https://lawyerist.com/podcast/" title="All episodes of The Lawyerist Podcast.">All episodes of The Lawyerist Podcast</a></p>';
			echo '</div>';

			// End of podcast episode.


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

				// Starts the post container.
				echo '<div id="fp-recent-pages" class="cards">';

					while ( $recent_pages_query->have_posts() ) : $recent_pages_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

				echo '</div>';

			endif;
			// End of recent pages.

			// Outputs sponsored posts in the current range (today minus 7 days) using
			// the Sponsored Post Options start and end dates.
			$today	= date( 'Ymd' );
			$args		= array(
				'category__in'				=> array(
					'1320', // Blog Posts
				),
				'meta_key'						=> 'sponsored_post_start_date',
				'meta_query'					=> array(
					array(
						'key'     => 'sponsored_post_start_date',
						'compare' => '<=',
						'value'   => $today - 7,
					),
					array(
						'key'     => 'sponsored_post_end_date',
						'compare' => '>=',
						'value'   => $today,
					),
				),
				'orderby'							=> 'meta_value_num',
				'post__not_in'				=> get_option( 'sticky_posts' ),
				'posts_per_page'			=> -1,
			);

			$current_post_query = new WP_Query( $args );

			if ( $current_post_query->have_posts() ) :

				// Starts the post container.
				echo '<div id="fp-product-spotlights" class="card has-card-label sponsored">';

					while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

					$all_spotlights_txt		= 'All Partner Updates';
					$all_spotlights_url		=	get_category_link( 1320 );
					echo '<p class="card-label card-bottom-label"><a href="' . $all_spotlights_url . '" title="' . $all_spotlights_txt . '">' . $all_spotlights_txt . '</a></p>';

				echo '</div>';

			endif;
			// End of sponsored posts.


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

				// Starts the post container.
				echo '<div id="fp-blog-posts" class="card has-card-label">';

					while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

					$all_posts_txt	= 'All Blog Posts';
					$all_posts_url	=	get_category_link( 555 );

					echo '<p class="card-label card-bottom-label"><a href="' . $all_posts_url . '" title="' . $all_posts_txt . '">' . $all_posts_txt . '</a></p>';

				echo '</div>';

			endif;
			// End of blog posts.


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

				// Starts the post container.
				echo '<div id="fp-case-studies" class="card has-card-label">';

					while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

						lawyerist_get_post_card();

					endwhile; wp_reset_postdata();

					$all_posts_txt	= 'All Small Firm Roadmap Stories';
					$all_posts_url	=	get_category_link( 4406 );

					echo '<p class="card-label card-bottom-label"><a href="' . $all_posts_url . '" title="' . $all_posts_txt . '">' . $all_posts_txt . '</a></p>';

				echo '</div>';

			endif;
			// End of case studies.


			echo '<p class="fp-section-header">Featured Resources</p>';

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

	</div><!-- end #content_column -->

	<?php get_template_part( 'sidebar' ); ?>

<?php

	endif;

?>

</div><!--end #column_container-->

<?php get_footer(); ?>
