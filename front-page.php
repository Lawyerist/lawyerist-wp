<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class(); ?>>

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
					echo '<p id="dashboard-title">' . $current_user->user_firstname . ' ' . $current_user->user_lastname . '\'s Dashboard</p>';

					echo scorecard_results_graph();

				echo '</div>';

			}


	    // Outputs the front page call to action.
			if ( !is_user_logged_in() ) {

				// Outputs the Insider (free) call to action.
				$cta_label				= 'Insider';
				$cta_button_url 	= 'https://lawyerist.com/insider/';
				$cta_button_text	=	'Join Now';

				ob_start();

				?>

					<p class="headline">Join Your Tribe.</p>
					<p>Lawyerist Insider is the community of solo and small firm lawyers building modern, future-oriented law practices.</p>
					<p class="headline">Grow Your Firm.</p>
					<p>Our Insider Library is full of checklists, templates, and other resources to help you grow.</p>

				<?php

				$cta_copy = ob_get_clean();

			// Outputs the Insider Plus upsell call to action for logged-in Insiders
			// who are not yet members of Insider Plus.
			} elseif ( is_user_logged_in() ) {

				$user_id = get_current_user_id();

				if (	!wc_memberships_is_user_active_member( $user_id, 'insider-plus-affinity' ) && !wc_memberships_is_user_active_member( $user_id, 'lab' ) ) {

					$cta_label				= 'Insider Plus';
					$cta_button_url	 	= 'https://lawyerist.com/cart/?add-to-cart=242723';
					$cta_button_text	=	'Upgrade Now';

					ob_start();

					?>

						<p class="headline">Get More.</p>
						<p>Upgrade to Insider Plus to get access to our Affinity Benefits program. You'll get access to discounts on dozens of carefully selected products and services—including some you already use.</p>
						<p>Insider Plus is just $89/year, and with so many discounts and premium downloads, your subscription will pay for itself.</p>

					<?php

					$cta_copy = ob_get_clean();

				}

			}

			// Outputs the call to action.

			if ( !empty( $cta_label ) ) {

			?>

				<div id="big_hero_cta" class="card dismissible-notice" data-id="<?php echo esc_attr( md5( $cta_label ) ); ?>">
					<div id="big_hero_left">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/L-dot-150x150.png" />
						<span class="big_hero_label"><?php echo $cta_label; ?></span>
					</div>
					<div id="big_hero_right">
						<button class="greybutton dismiss-button"></button>
						<div id="big_hero_top">
							<?php echo $cta_copy; ?>
						</div>
						<a class="button <?php if ( !is_user_logged_in() ) { echo 'free-flag'; } ?>" href="<?php echo $cta_button_url; ?>"><?php echo $cta_button_text; ?></a>
					</div>
				</div>

			<?php

			}


			echo '<p class="fp-section-header">Recent Updates</p>';

			// Outputs the most recent podcast episode.
			$current_podcast_query_args = array(
				'category_name'				=> 'lawyerist-podcast',
				'post__not_in'				=> get_option( 'sticky_posts' ),
				'posts_per_page'			=> 1,
			);

			$current_podcast_query = new WP_Query( $current_podcast_query_args );

			if ( $current_podcast_query->have_posts() ) : while ( $current_podcast_query->have_posts() ) : $current_podcast_query->the_post();

				$podcast_title		= the_title( '', '', FALSE );
				$podcast_url			= get_permalink();
				$first_image_url	= get_first_image_url();

				if ( empty( $first_image_url ) ) {
					$first_image_url = 'https://lawyerist.com/lawyerist-dev/wp-content/uploads/2018/02/lawyerist-ltn-podcast-logo-16x9-684x385.png';
				}

				// Starts the post container.

				echo '<div id="fp-latest-podcast" class="card has-card-label">';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $podcast_url . '" title="' . $podcast_title . '" ';
					post_class( 'has-guest-avatar' );
					echo '>';

						echo '<img class="guest-avatar" src="' . $first_image_url . '" />';

						// Now we get the headline and excerpt (except for certain kinds of posts).
						echo '<div class="headline-excerpt">';

							// Headline
							echo '<h2 class="headline" title="' . $podcast_title . '">' . $podcast_title . '</h2>';

							get_template_part( 'postmeta', 'index' );

						echo '</div>'; // Close .headline-excerpt.

					echo '</a>'; // This closes the post link container (.post).

					// Outputs the label.
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
					$card_label 		= $cat_info->name;
					$card_label_url	=	get_term_link( $cat_IDs[0], 'category' );

					if ( !empty( $card_label ) ) {
						echo '<p class="card-label"><a href="' . $card_label_url . '" title="All episodes of ' . $card_label . '.">All episodes of ' . $card_label . '</a></p>';
					}

				echo '</div>';

			endwhile; wp_reset_postdata(); endif;

			// End of podcast episode.


			// Embedded Lawyerist Lens playlist.
			echo '<div id="fp-lens-playlist" class="card has-card-label">';

				echo '<div id="lens-wrapper"><iframe width="560" height="315" data-src="https://www.youtube.com/embed/videoseries?list=PLtFJu5URBISmTDaVOF3l-cQl08f2qUMr_" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>';

				echo '<p class="card-label"><a href="https://www.youtube.com/playlist?list=PLtFJu5URBISmTDaVOF3l-cQl08f2qUMr_" title="Watch all episodes of Lawyerist Lens on YouTube">Watch all episodes of Lawyerist Lens on YouTube</a></p>';

			echo '</div>';
			// End of embedded Lawyerist Lens playlist.


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

						$post_title			= the_title( '', '', FALSE );
						$post_url				= get_permalink();

						if ( has_post_thumbnail() ) {

							$thumbnail_id   = get_post_thumbnail_id();
					    $thumbnail      = wp_get_attachment_image( $thumbnail_id, 'medium' );

						}

						echo '<div class="card">';

							// Starts the link container. Makes for big click targets!
							echo '<a href="' . $post_url . '" title="' . $post_title . '"';
							post_class();
							echo '>';

							if ( !empty ( $thumbnail ) ) {
								echo $thumbnail;
							}

								// Now we get the headline and excerpt (except for certain kinds of posts).
								echo '<div class="headline-excerpt">';

									// Headline
									echo '<h2 class="headline">' . $post_title . '</h2>';

								echo '</div>'; // Close .headline-excerpt.

							echo '</a>'; // This closes the post link container (.post).

						echo '</div>';

						unset( $thumbnail );

					endwhile; wp_reset_postdata();

				echo '</div>';

			endif;
			// End of recent pages.


			// Outputs the 6 most recent blog posts.
			$args = array(
				'category__in'				=> array(
					'555', // Blog Posts
				),
				'post__not_in'				=> get_option( 'sticky_posts' ),
				'posts_per_page'			=> 6,
			);

			$current_post_query = new WP_Query( $args );

			if ( $current_post_query->have_posts() ) :

				// Starts the post container.
				echo '<div id="fp-blog-posts" class="card composite-card">';

					while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

					$post_title			= the_title( '', '', FALSE );
					$post_url				= get_permalink();

					if ( has_post_thumbnail() ) {

						$thumbnail_id   = get_post_thumbnail_id();
				    $thumbnail      = wp_get_attachment_image( $thumbnail_id, 'medium' );

					}

						// Starts the link container. Makes for big click targets!
						echo '<a href="' . $post_url . '" title="' . $post_title . '"';
						post_class();
						echo '>';

						if ( !empty ( $thumbnail ) ) {
							echo $thumbnail;
						}

							// Now we get the headline and excerpt (except for certain kinds of posts).
							echo '<div class="headline-excerpt">';

								// Headline
								echo '<h2 class="headline">' . $post_title . '</h2>';

								get_template_part( 'postmeta', 'index' );

							echo '</div>'; // Close .headline-excerpt.

						echo '</a>'; // This closes the post link container (.post).

						unset( $thumbnail );

					endwhile; wp_reset_postdata();

					// Outputs the label.
					echo '<p class="card-label"><a href="https://lawyerist.com/category/blog-posts/" title="All Blog Posts">All Blog Posts</a></p>';

				echo '</div>';

			endif;
			// End of blog posts.


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

					$post_title			= the_title( '', '', FALSE );
					$post_url				= get_permalink();

					if ( has_post_thumbnail() ) {

						$thumbnail_id   = get_post_thumbnail_id();
				    $thumbnail      = wp_get_attachment_image( $thumbnail_id, 'medium' );

					}

						echo '<div class="card">';

							// Starts the link container. Makes for big click targets!
							echo '<a href="' . $post_url . '" title="' . $post_title . '"';
							post_class();
							echo '>';

							if ( !empty ( $thumbnail ) ) {
								echo $thumbnail;
							}

								// Now we get the headline and excerpt (except for certain kinds of posts).
								echo '<div class="headline-excerpt">';

									// Headline
									echo '<h2 class="headline">' . $post_title . '</h2>';

								echo '</div>'; // Close .headline-excerpt.

							echo '</a>'; // This closes the post link container (.post).

						echo '</div>';

						unset( $thumbnail );

					endwhile; wp_reset_postdata();

				echo '</div>';

			endif;
			// End of featured pages.

		?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

<?php

	endif;

?>

</div><!--end #column_container-->

<?php get_footer(); ?>

</body>
</html>
