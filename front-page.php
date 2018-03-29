<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'index' ); ?>>

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

		?>

	    <!-- Outputs the Scorecard call to action. -->
			<div id="big_hero_cta" class="index_post_container">
				<a class="big_hero_top" href="https://lawyerist.com/scorecard/">
					<div class="scorecard_image_wrapper"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/scorecard-page.png" alt="The Small Firm Scorecard example graphic." /></div>
					<div class="scorecard_prompt_wrapper">
						<h2>The Small Firm Scorecard<sup>TM</sup></h2>
						<p>Is your law firm structured to succeed in the future?</p>
					</div>
					<div class="clear"></div>
				</a>
				<p class="big_hero_p">The practice of law is changing. You need to understand whether your firm is positioned for success in the coming years. Our free Small Firm Scorecard will identify your firm’s strengths and weaknesses in just a few minutes.</p>
				<div class="big_hero_button"><a class="button" href="https://lawyerist.com/scorecard/">Get Your Free Score</a></div>
			</div>


	    <!-- Outputs a block of secondary calls to action. -->
			<div class="front_page_block">

				<div class="one_half">
					<div class="index_post_container">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2017/10/lawyerist-insider-logo.png?w=320&h=180" alt="Lawyerist Insider logo." />
						<h3>Join Your Tribe. Grow Your Firm.</h3>
						<a class="button" href="https://lawyerist.com/insider/">Join Now</a>
					</div>
				</div>

				<div class="one_half">
					<div class="index_post_container">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/03/lawyerist-productivity-journal.jpg?w=320&h=180" alt="The Lawyerist Productivity Journal cover." />
						<h3>The Lawyerist Productivity Journal</h3>
						<a class="button" href="https://lawyerist.com/journal/">Learn More</a>
					</div>
				</div>

				<div class="clear"></div>

			</div>

		<?php

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
				post_class( 'index_post_container has-post-label' );
				echo '>';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $podcast_url . '" title="' . $podcast_title . '">';

						// Now we get the headline and excerpt (except for certain kinds of posts).
						echo '<div class="headline_excerpt">';

							// Outputs the podcast cover image.
							echo '<div class="default_thumbnail" alt="The Lawyerist Podcast logo" style="background-image: url( https://lawyerist.com/lawyerist-dev/wp-content/uploads/2018/02/lawyerist-ltn-podcast-logo-16x9-684x385.png );"></div>';

							// Headline
							echo '<h2 class="headline">' . $podcast_title . '</h2>';

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


	    // Outputs the most recent download.
			$download_query_args = array(
				'post_type'						=> 'product',
				'ignore_sticky_posts' => TRUE,
				'posts_per_page'			=> 1,
				'tax_query' => array(
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
				post_class( 'index_post_container has-post-label' );
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

							echo '<a href="' . $post_url . '" class="button">Get it Now</a>';

							// Clearfix
							echo '<div class="clear"></div>';

						echo '</div>'; // Close .headline_excerpt.

					echo '</a>'; // This closes the post link container (.post).

					// Outputs the label.
					echo '<p class="post_label"><a href="https://lawyerist.com/library/" title="Explore the Lawyerist Insider Library.">Explore the Lawyerist Insider Library</a></p>';

				echo '</div>';

			endwhile; endif;
			// End of download.


			// Outputs the most recent blog post.
			$current_post_query_args = array(
				'category_name'				=> 'blog-posts',
				'ignore_sticky_posts' => TRUE,
				'posts_per_page'			=> 1,
			);

			$current_post_query = new WP_Query( $current_post_query_args );

			if ( $current_post_query->have_posts() ) : while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

				$post_title			= the_title( '', '', FALSE );
				$post_url				= get_permalink();
				$post_excerpt   = get_the_excerpt();
			  $seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );

			  // Sets the post excerpt to the Yoast Meta Description.
			  if ( !empty( $seo_descr ) ) { $post_excerpt = $seo_descr; }

				// Starts the post container.
				echo '<div ' ;
				post_class( 'index_post_container has-post-label' );
				echo '>';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $post_url . '" title="' . $post_title . '">';

						// Now we get the headline and excerpt (except for certain kinds of posts).
						echo '<div class="headline_excerpt">';

							// Outputs the featured image.
							if ( has_post_thumbnail() ) {
								echo '<div class="default_thumbnail" style="background-image: url( ';
								echo the_post_thumbnail_url( 'default_thumbnail' );
								echo ' );"></div>';
							}

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
			// End of blog post.

			echo '</div>'; // End of .front_page_block with the current podcast, download, and blog post.

		?>

			<!-- Outputs strategic pages. -->
			<div class="front_page_block">

				<div class="one_half">
					<div class="index_post_container">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/03/best-law-firm-websites-2018.jpg?w=1600&ssl=1?w=320&h=180" alt="A law firm website as viewed on a laptop." />
						<h3>The Best Law Firm Websites, 2018 Edition</h3>
						<a class="button" href="https://lawyerist.com/best-law-firm-websites/">See the Top 10</a>
					</div>
				</div>

				<div class="one_half">
					<div class="index_post_container">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/03/web-designer-recommendation.jpg?w=320&h=180" alt="Law firm website designer at work." />
						<h3>Get a Personalized Web Designer Referral</h3>
						<a class="button" href="https://lawyerist.com/website-designer-assessment/">Get a Referral</a>
					</div>
				</div>

				<div class="clear"></div>

				<div class="one_half">
					<div class="index_post_container">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/03/law-practice-management-software.jpg?w=320&h=180" alt="Law practice management software graphic." />
						<h3>Law Practice Management Software</h3>
						<a class="button" href="https://lawyerist.com/law-practice-management-software/">See All</a>
					</div>
				</div>

				<div class="one_half">
					<div class="index_post_container">
						<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2017/08/receptionist.jpg?w=320&h=180" alt="Virtual receptionist image." />
						<h3>Virtual Receptionists for Law Firms</h3>
						<a class="button" href="https://lawyerist.com/virtual-receptionists/">See All</a>
					</div>
				</div>

				<div class="clear"></div>

			</div>

		<?php

			// Outputs the most recent How Lawyers Work post.
			$hlw_query_args = array(
				'category_name'				=> 'how-lawyers-work',
				'ignore_sticky_posts' => TRUE,
				'posts_per_page'			=> 1,
			);

			$hlw_query = new WP_Query( $hlw_query_args );

			if ( $hlw_query->have_posts() ) : while ( $hlw_query->have_posts() ) : $hlw_query->the_post();

				$podcast_title	= the_title( '', '', FALSE );
				$podcast_url		= get_permalink();

				// Gets the first image, or a default.
				$first_img = '';
				ob_start();
				ob_end_clean();
				$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
				$first_img = $matches[1][0];

				if ( empty( $first_img ) ) {
					$first_img = 'https://lawyerist.com/lawyerist/wp-content/uploads/2018/01/typewriter.jpg';
				}

				// Starts the post container.
				echo '<div ' ;
				post_class( 'index_post_container has-post-label' );
				echo '>';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $podcast_url . '" title="' . $podcast_title . '">';

						// Now we get the headline and excerpt (except for certain kinds of posts).
						echo '<div class="headline_excerpt">';

							// Outputs a featured image.
							echo '<div class="default_thumbnail" style="background-image: url( ';
							echo $first_img;
							echo ' );"></div>';

							// Headline
							echo '<h2 class="headline">' . $podcast_title . '</h2>';

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
						echo '<p class="post_label"><a href="' . $post_label_url . '" title="All ' . $post_label . ' profiles.">All ' . $post_label . ' profiles</a></p>';
					}

				echo '</div>';

			endwhile; endif;
			// End of How Lawyers Work.


	    // Outputs the Sponsored Product Updates widget.
	    lawyerist_sponsored_product_updates();

		endif;

	?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

	<div class="clear"></div>

</div><!--end #column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
