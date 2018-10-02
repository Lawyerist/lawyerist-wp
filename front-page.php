<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'index' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

	<?php

		// Checks to see if the front page is set to show community posts, and if so uses
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

			if ( $sticky_post_query->have_posts() ) : while ( $sticky_post_query->have_posts() ) : $sticky_post_query->the_post();

				if ( is_sticky() ) {

						$num_sticky_posts++;

						$sticky_post_title	= the_title( '', '', FALSE );
						$sticky_post_url		= get_permalink();

						// Starts the post container.
						echo '<div ' ;
						post_class( 'front_page_sticky_post shadow' );
						echo '>';

							// Starts the link container. Makes for big click targets!
							echo '<a href="' . $sticky_post_url . '" title="' . $sticky_post_title . '">';

								echo '<h2 class="headline">' . $sticky_post_title . '</h2>';

							echo '</a>';

						echo '</div>';

				}

			endwhile; endif;

			if ( $num_sticky_posts > 0 ) {
				echo '<div class="separator_3rem"></div>';
			}

	    // Outputs the Scorecard call to action.
			if ( !is_user_logged_in() ) {

			?>

				<div id="big_hero_cta shadow">
					<div id="big_hero_left">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/L-dot-150x150.png" />
						<span class="big_hero_label">Insider</span>
					</div>
					<div id="big_hero_right">
						<a href="https://lawyerist.com/insider/">
							<div id="big_hero_top">
								<p class="headline">Join Your Tribe.</p>
								<p>Lawyerist Insider is the community of solo and small firm lawyers building modern, future-oriented law practices.</p>
								<p class="headline">Grow Your Firm.</p>
								<p>Our Insider Library is full of checklists, templates, and other resources to help you grow.</p>
							</div>
						</a>
						<a class="button" href="https://lawyerist.com/insider/">Join Now</a>
					</div>
				</div>

			<?php

			}

			// Outputs a block of new stuff (podcast, Lens, download, and community posts).
			echo '<div class="front_page_block">';

				// Outputs the most recent podcast episode.
				$current_podcast_query_args = array(
					'category_name'				=> 'lawyerist-podcast',
					'ignore_sticky_posts' => TRUE,
					'posts_per_page'			=> 1,
				);

				$current_podcast_query = new WP_Query( $current_podcast_query_args );

				if ( $current_podcast_query->have_posts() ) : while ( $current_podcast_query->have_posts() ) : $current_podcast_query->the_post();

					$podcast_title	= the_title( '', '', FALSE );
					$podcast_url		= get_permalink();

					// Starts the post container.
					echo '<div ' ;
					post_class( 'post_container has-post-label' );
					echo '>';

						// Starts the link container. Makes for big click targets!
						echo '<a href="' . $podcast_url . '" title="' . $podcast_title . '">';

							// Now we get the headline and excerpt (except for certain kinds of posts).
							echo '<div class="headline_excerpt">';

								// Outputs the podcast cover image.
								$first_image_url = get_first_image_url();

		            if ( empty( $first_image_url ) ) {
		              $first_image_url = 'https://lawyerist.com/lawyerist-dev/wp-content/uploads/2018/02/lawyerist-ltn-podcast-logo-16x9-684x385.png';
		            }

		            echo '<div class="author_avatar"><img class="avatar" src="' . $first_image_url . '" /></div>';

								// Headline
								echo '<h2 class="headline">' . $podcast_title . '</h2>';

								get_template_part( 'postmeta', 'index' );

								// Clearfix
								echo '<div class="clear"></div>';

							echo '</div>'; // Close .headline_excerpt.

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

						$post_label 		   	= $cat_info->name;
						$post_label_url			=	get_term_link( $cat_IDs[0], 'category' );

						if ( !empty( $post_label ) ) {
							echo '<p class="post_label"><a href="' . $post_label_url . '" title="All episodes of ' . $post_label . '.">All episodes of ' . $post_label . '</a></p>';
						}

					echo '</div>';

				endwhile; endif;
				// End of podcast episode.


				// Embedded Lawyerist Lens playlist.
				echo '<div class="post_container lens_playlist has-post-label">';

				echo '<iframe width="636" height="358" src="https://www.youtube.com/embed/videoseries?list=PLtFJu5URBISmTDaVOF3l-cQl08f2qUMr_" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';

				echo '<p class="post_label"><a href="https://www.youtube.com/playlist?list=PLtFJu5URBISmTDaVOF3l-cQl08f2qUMr_" title="Watch all episodes of Lawyerist Lens on YouTube">Watch all episodes of Lawyerist Lens on YouTube</a></p>';

				echo '</div>';
				// End of embedded Lawyerist Lens playlist.


		    // Outputs the most recent download.
				$download_query_args = array(
					'post_type'						=> 'product',
					'ignore_sticky_posts' => TRUE,
					'posts_per_page'			=> 1,
					'tax_query'						=> array(
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => 'exclude-from-catalog',
							'operator' => 'NOT IN',
						),
					),
				);

				$download_query = new WP_Query( $download_query_args );

				if ( $download_query->have_posts() ) : while ( $download_query->have_posts() ) : $download_query->the_post();

					$download_title			= the_title( '', '', FALSE );
					$download_url				= get_permalink();
					$download_excerpt   = get_the_excerpt();
				  $seo_descr    		  = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );

				  // Sets the post excerpt to the Yoast Meta Description.
				  if ( !empty( $seo_descr ) ) { $download_excerpt = $seo_descr; }

					// Starts the post container.
					echo '<div ' ;
					post_class( 'post_container has-post-label' );
					echo '>';

						// Starts the link container. Makes for big click targets!
						echo '<a href="' . $download_url . '" title="' . $download_title . '">';

							// Now we get the headline and excerpt (except for certain kinds of posts).
							echo '<div class="headline_excerpt">';

								// Outputs a featured image.
								if ( has_post_thumbnail() ) { the_post_thumbnail( 'shop_single' ); }

								// Headline
								echo '<h2 class="headline">' . $download_title . '</h2>';

								echo '<p class="excerpt">' . $download_excerpt . '</p>';

								echo '<a href="' . $download_url . '" class="button">Get it Now</a>';

								// Clearfix
								echo '<div class="clear"></div>';

							echo '</div>'; // Close .headline_excerpt.

						echo '</a>'; // This closes the post link container (.post).

						// Outputs the label.
						echo '<p class="post_label"><a href="https://lawyerist.com/library/" title="Explore the Lawyerist Insider Library.">Explore the Lawyerist Insider Library</a></p>';

					echo '</div>';

				endwhile; endif;
				// End of download.


				// Outputs the most recent community post.
				$current_post_query_args = array(
					'category_name'				=> 'community-posts',
					'ignore_sticky_posts' => TRUE,
					'posts_per_page'			=> 1,
				);

				$current_post_query = new WP_Query( $current_post_query_args );

				if ( $current_post_query->have_posts() ) : while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

					$post_title			= the_title( '', '', FALSE );
					$post_url				= get_permalink();
					$post_excerpt   = get_the_excerpt();
				  $seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );

					$author_name		= get_the_author_meta( 'display_name' );
					$author_avatar	= get_avatar( get_the_author_meta( 'user_email' ), 150, '', $author_name );

				  // Sets the post excerpt to the Yoast Meta Description.
				  if ( !empty( $seo_descr ) ) { $post_excerpt = $seo_descr; }

					// Starts the post container.
					echo '<div ' ;
					post_class( 'post_container has-post-label' );
					echo '>';

						// Starts the link container. Makes for big click targets!
						echo '<a href="' . $post_url . '" title="' . $post_title . '">';

							// Now we get the headline and excerpt (except for certain kinds of posts).
							echo '<div class="headline_excerpt">';

								// Outputs the author's avatar.
								echo '<div class="author_avatar">' . $author_avatar . '</div>';

								// Headline
								echo '<h2 class="headline">' . $post_title . '</h2>';

								echo '<p class="excerpt">' . $post_excerpt . '</p>';

								get_template_part( 'postmeta', 'index' );

								// Clearfix
								echo '<div class="clear"></div>';

							echo '</div>'; // Close .headline_excerpt.

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

						$post_label 		   	= $cat_info->name;
						$post_label_url			=	get_term_link( $cat_IDs[0], 'category' );

						if ( !empty( $post_label ) ) {
							echo '<p class="post_label"><a href="' . $post_label_url . '" title="All ' . $post_label . '.">All ' . $post_label . '</a></p>';
						}

					echo '</div>';

				endwhile; endif;
				// End of community post.

			echo '</div>'; // End of new stuff.

		?>

			<!-- Outputs strategic pages. -->
			<div class="front_page_block fp_contains_boxes">

				<div class="one_half">
					<div class="post_container">
						<a href="https://lawyerist.com/scorecard/">
							<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/09/scorecard-front-page.png" alt="Lawyerist Insider logo." />
							<h3 class="headline">Use the Small Firm Scorecard to Evaluate Your Law Firm</h3>
						</a>
					</div>
				</div>

				<div class="one_half">
					<div class="post_container">
						<a href="https://lawyerist.com/journal/">
							<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/lawyerist-productivity-journal-front-page.jpg" alt="The Lawyerist Productivity Journal cover." />
							<h3 class="headline">Get Organized with the Lawyerist Productivity Journal</h3>
						</a>
					</div>
				</div>

				<div class="clear"></div>

				<div class="one_half">
					<div class="post_container">
						<a href="https://lawyerist.com/best-law-firm-websites/">
							<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/best-law-firm-websites-2018-front-page.jpg" alt="A law firm website as viewed on a laptop." />
							<h3 class="headline">The Best Law Firm Websites, 2018 Edition</h3>
						</a>
					</div>
				</div>

				<div class="one_half">
					<div class="post_container">
						<a href="https://lawyerist.com/website-designer-assessment/">
							<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/web-designer-recommendation-front-page.jpg" alt="Law firm website designer at work." />
							<h3 class="headline">Get a Personalized Web Designer Referral</h3>
						</a>
					</div>
				</div>

				<div class="clear"></div>

			</div>

			<div class="front_page_block fp_contains_boxes">

				<?php lawyerist_sponsored_product_updates(); ?>

			</div>

			<div class="front_page_block fp_contains_boxes">

				<div class="one_half">
					<div class="post_container">
						<a href="https://lawyerist.com/law-practice-management-software/">
							<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/law-practice-management-software-front-page.jpg" alt="Law practice management software graphic." />
							<h3 class="headline">Law Practice Management Software</h3>
						</a>
					</div>
				</div>

				<div class="one_half">
					<div class="post_container">
						<a href="https://lawyerist.com/virtual-receptionists/">
							<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/receptionist-front-page.jpg" alt="Virtual receptionist image." />
							<h3 class="headline">Virtual Receptionists for Law Firms</h3>
						</a>
					</div>
				</div>

				<div class="clear"></div>

				<div class="one_half">
					<div class="post_container">
						<a href="https://lawyerist.com/best-law-firm-websites/designers-seo/">
							<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/07/website-designers-seo-consultants-front-page.jpg" alt="SEO Scrabble tiles." />
							<h3 class="headline">Website Designers & SEO Consultants</h3>
						</a>
					</div>
				</div>

				<div class="one_half">
					<div class="post_container">
						<a href="https://lawyerist.com/legal-billing-software/">
							<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/07/time-billing-software-front-page.jpg" alt="An accountant working on a laptop." />
							<h3 class="headline">Timekeeping & Billing Software for Law Firms</h3>
						</a>
					</div>
				</div>

				<div class="clear"></div>

			</div>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

	<div class="clear"></div>

<?php

	endif;

?>

</div><!--end #column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
