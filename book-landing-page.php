<?php /* Template Name: Book Landing Page */ ?>

<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'book full-width' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Start the Loop.
		if ( have_posts() ) : while ( have_posts() ) : the_post();

		  // Assign post variables.
		  $page_title   = the_title( '', '', FALSE );
		  $page_ID      = $post->ID;

		  // This is the post container.
		  echo '<div ';
		  post_class();
		  echo '>';

				echo '<div id="book-cover">';

			    // Featured image
			    if ( has_post_thumbnail() ) { the_post_thumbnail(); }

				echo '</div>';

				echo '<div id="book-cta">';

			    // Headline
			    echo '<h1 class="headline entry-title">' . $page_title . '</h1>';

			    // Output the post.
			    echo '<div class="post_body" itemprop="articleBody">';

			      the_content();

			    echo '</div>'; // Close .post_body.

					// Show page navigation if the post is paginated unless we're displaying
					// the RSS feed.
					if ( !is_feed() ) {

						$wp_link_pages_args = array(
							'before'            => '<p class="page_links">',
							'after'             => '</p>',
							'link_before'       => '<span class="page_number">',
							'link_after'        => '</span>',
							'next_or_number'    => 'next',
							'nextpagelink'      => 'Next Page &raquo;',
							'previouspagelink'  => '&laquo; Previous Page',
							'separator'         => '|',
						);

						wp_link_pages( $wp_link_pages_args );

					}

				echo '</div>';

		  echo '</div>'; // Close .post.

		endwhile; endif; // Close the Loop.

		?>

	</div><!-- end #content_column -->

</div><!--end #column_container-->

<?php get_footer(); ?>

</body>
</html>
