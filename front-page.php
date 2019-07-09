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

				echo '<div id="insider-dashboard" class="front_page_block">';

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

				/* Workaround because WooCommerce Memberships isn't getting membership status. */

				$memberships = wc_memberships_get_user_memberships( $user_id );

				foreach ( $memberships as $membership ) {

					if ( $membership->status == 'wcm-active' && ( $membership->plan->slug == 'lab' || $membership->plan->slug == 'insider-plus-affinity' ) ) {

						$is_labster_or_insider_plus = true;

						break;

					}

				}

				if ( $is_labster_or_insider_plus !== true ) {

				/* End workaround. */

				// This is what's not working.
				// if (	!wc_memberships_is_user_active_member( $user_id, 'insider-plus-affinity' ) && !wc_memberships_is_user_active_member( $user_id, 'lab' ) ) {

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


			// Outputs a block of new stuff (podcast, Lens, download, and blog posts).
			echo '<div class="front_page_block">';

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

					echo '<div id="lens-wrapper"><iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLtFJu5URBISmTDaVOF3l-cQl08f2qUMr_" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>';

					echo '<p class="card-label"><a href="https://www.youtube.com/playlist?list=PLtFJu5URBISmTDaVOF3l-cQl08f2qUMr_" title="Watch all episodes of Lawyerist Lens on YouTube">Watch all episodes of Lawyerist Lens on YouTube</a></p>';

				echo '</div>';
				// End of embedded Lawyerist Lens playlist.


				// Outputs the 5 most recent blog posts.
				$current_post_query_args = array(
					'category__in'				=> array(
						'555', // Blog Posts
					),
					'post__not_in'				=> get_option( 'sticky_posts' ),
					'posts_per_page'			=> 5,
				);

				$current_post_query = new WP_Query( $current_post_query_args );

				if ( $current_post_query->have_posts() ) :

					// Starts the post container.
					echo '<div id="fp-blog-posts" class="card">';

						while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

						$post_title			= the_title( '', '', FALSE );
						$post_url				= get_permalink();

						$author_name		= get_the_author_meta( 'display_name' );
						$author_avatar	= get_avatar( get_the_author_meta( 'user_email' ), 100, '', $author_name );

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
							unset( $post_classes );

						endwhile; wp_reset_postdata();

						// Outputs the label.
						echo '<p class="card-label"><a href="https://lawyerist.com/category/blog-posts/" title="All Blog Posts">All Blog Posts</a></p>';

					echo '</div>';

				endif;

				// End of blog posts.

			echo '</div>';
			// End of new stuff.

		?>

			<!-- Outputs strategic pages. -->
			<div class="cards front_page_block">

				<div class="card">
					<a href="https://lawyerist.com/scorecard/" class="post has-post-thumbnail">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2019/03/scorecard-front-page.png" alt="Lawyerist Insider logo." />
						<div class="headline-excerpt">
							<h3 class="headline">Use the Small Firm Scorecard to Evaluate Your Law Firm</h3>
						</div>
					</a>
				</div>

				<div class="card">
					<a href="https://lawyerist.com/journal/" class="post has-post-thumbnail">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/lawyerist-productivity-journal-front-page.jpg" alt="The Lawyerist Productivity Journal cover." />
						<div class="headline-excerpt">
							<h3 class="headline">Get Organized with the Lawyerist Productivity Journal</h3>
						</div>
					</a>
				</div>

				<div class="card">
					<a href="https://lawyerist.com/best-law-firm-websites/" class="post has-post-thumbnail">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/best-law-firm-websites-2018-front-page.jpg" alt="A law firm website as viewed on a laptop." />
						<div class="headline-excerpt">
							<h3 class="headline">Check Out the Best Law Firm Websites</h3>
						</div>
					</a>
				</div>

				<div class="card">
					<a href="https://lawyerist.com/website-designer-assessment/" class="post has-post-thumbnail">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/web-designer-recommendation-front-page.jpg" alt="Law firm website designer at work." />
						<div class="headline-excerpt">
							<h3 class="headline">Get a Personalized Web Designer Referral</h3>
						</div>
					</a>
				</div>

				<div class="card">
					<a href="https://lawyerist.com/law-practice-management-software/" class="post has-post-thumbnail">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/law-practice-management-software-front-page.jpg" alt="Law practice management software graphic." />
						<div class="headline-excerpt">
							<h3 class="headline">Law Practice Management Software</h3>
						</div>
					</a>
				</div>


				<div class="card">
					<a href="https://lawyerist.com/virtual-receptionists/" class="post has-post-thumbnail">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/receptionist-front-page.jpg" alt="Virtual receptionist image." />
						<div class="headline-excerpt">
							<h3 class="headline">Virtual Receptionists for Law Firms</h3>
						</div>
					</a>
				</div>



				<div class="card">
					<a href="https://lawyerist.com/best-law-firm-websites/designers-seo/" class="post has-post-thumbnail">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/07/website-designers-seo-consultants-front-page.jpg" alt="SEO Scrabble tiles." />
						<div class="headline-excerpt">
							<h3 class="headline">Website Designers & SEO Consultants</h3>
						</div>
					</a>
				</div>

				<div class="card">
					<a href="https://lawyerist.com/legal-billing-software/" class="post has-post-thumbnail">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/07/time-billing-software-front-page.jpg" alt="An accountant working on a laptop." />
						<div class="headline-excerpt">
							<h3 class="headline">Timekeeping & Billing Software for Law Firms</h3>
						</div>
					</a>
				</div>

			</div>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

<?php

	endif;

?>

</div><!--end #column_container-->

<?php get_footer(); ?>

</body>
</html>
