<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'index' ); ?>>

<?php get_header(); ?>

<div id="column_container">

  <div id="content_column">

    <?php

      if ( is_archive() || is_search() ) { lawyerist_get_archive_header(); }

      // Displays the "hero" call to action.

      /*------------------------------
      WHAT'S NEW
      ------------------------------*/

      // Displays the latest podcast episode.
    	$podcast_args = array(
    		'category_name'       => 'lawyerist-podcast',
    		'ignore_sticky_posts' => TRUE,
    		'posts_per_page'			=> 1,
    	);

    	$podcast = new WP_Query( $podcast_args );

			// Starts the podcast sub-Loop.
			while ( $podcast->have_posts() ) : $podcast->the_post();

        // Outputs the post container.
        echo '<div ' ;
        post_class( $post_classes );
        echo '>';

        $episode_title      = the_title( '', '', FALSE );
        $episode_seo_title  = get_post_meta( $post->ID, '_yoast_wpseo_title', true );
        if ( !empty( $episode_seo_title ) ) { $episode_title = $episode_seo_title; }

        $episode_seo_descr  = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );
				$episode_url        = get_permalink();
        $post_classes[]     = 'index_post_container'; // .post, .page, and .product are added automatically, as are tags and formats.

  				echo '<a href="' . $episode_url . '" title="' . $episode_title . '">';

  					if ( has_post_thumbnail() ) {
  						the_post_thumbnail( 'current_posts_thumbnail' );
  					} else {
  						echo '<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/current-posts-placeholder-160x90.png" class="attachment-thumbnail wp-post-image" />';
  					}

  					echo '<p class="current_post_title">' . $current_post_title . '</p>';

  				echo '</a>';

        echo '</div>'; // Close .post.
        echo "\n\n";

			endwhile;

			wp_reset_postdata();

    ?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { get_template_part( 'sidebar' ); } ?>

	<div class="clear"></div>

</div><!-- end #column_container -->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
