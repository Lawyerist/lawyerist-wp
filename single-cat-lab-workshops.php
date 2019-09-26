<?php /* Template Name: Full Width */ ?>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		// Start the Loop.
		if ( have_posts() ) : while ( have_posts() ) : the_post();

		  $this_post[] = $post->ID; // We use this to exclude the current post from things.

		  // Assign post variables.
		  $post_title = the_title( '', '', FALSE );

		  // Breadcrumbs
		  if ( function_exists( 'yoast_breadcrumb' ) ) {
		    yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
		  }

		  echo '<main>';

		    // This is the post container.
		    echo '<div ';
		    post_class();
		    echo '>';

		      // Headline
		      echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

		      get_template_part( 'postmeta', 'single_top' );


		      // Output the post.
		      echo '<div class="post_body" itemprop="articleBody">';

		        the_content();

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

		      echo '</div>'; // Close .post_body.

		    echo '</div>'; // Close .post.

		  echo '</main>';

		  if ( !is_user_logged_in() ) {
		    lawyerist_cta();
		  }

		  lawyerist_get_related_resources();

		  echo '<div id="comments_container">';
		  comments_template( '/comments.php' );
		  echo '</div>';

		endwhile; endif; // Close the Loop.

		?>

	</div><!-- end #content_column -->

</div><!--end #column_container-->

<?php get_footer(); ?>