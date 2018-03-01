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

			<div class="one_third">
				<div class="index_post_container">
					<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2017/10/lawyerist-insider-logo.png?w=320&h=180" />
					<h3>Join Your Tribe. Grow Your Firm.</h3>
					<a class="button" href="https://lawyerist.com/insider/">Learn More</a>
				</div>
			</div>

			<div class="one_third">
				<div class="index_post_container">
					<img src="http://via.placeholder.com/320x180" />
					<h3>Find a Web Designer</h3>
					<a class="button" href="#">Learn More</a>
				</div>
			</div>

			<div class="one_third">
				<div class="index_post_container">
					<img src="http://via.placeholder.com/320x180" />
					<h3>The Lawyerist Productivity Journal</h3>
					<a class="button" href="#">Learn More</a>
				</div>
			</div>

			<div class="clear"></div>

		</div>

		<!-- Outputs strategic pages. -->
		<div id="resource_pages">

			<div class="one_third">
				<div class="index_post_container">
					<img src="http://via.placeholder.com/320x180" />
					<h3>The Best Law Firm Websites</h3>
				</div>
			</div>

			<div class="one_third">
				<div class="index_post_container">
					<img src="http://via.placeholder.com/320x180" />
					<h3>Law Practice Management Software</h3>
				</div>
			</div>

			<div class="one_third">
				<div class="index_post_container">
					<img src="http://via.placeholder.com/320x180" />
					<h3>The Lawyerist Podcast</h3>
				</div>
			</div>

			<div class="clear"></div>

		</div>

		<?php

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

						echo '<a href="' . $post_url . '" class="button">Learn More</a>';

						// Clearfix
						echo '<div class="clear"></div>';

					echo '</div>'; // Close .headline_excerpt.

				echo '</a>'; // This closes the post link container (.post).

				// Outputs the label.
				echo '<p class="post_label"><a href="https://lawyerist.com/library/" title="Explore the Lawyerist Insider Library.">Explore the Lawyerist Insider Library</a></p>';

			echo '</div>';

		endwhile; endif;
		// End of download.


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

		?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include( 'sidebar.php' ); } ?>

	<div class="clear"></div>

</div><!--end #column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
