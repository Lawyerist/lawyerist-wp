<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( 'index' ); ?>>

<?php get_header(); ?>

<div id="column_container">

  <div id="content_column">

    <?php

      /*------------------------------
      HERO CALL TO ACTION
      ------------------------------*/

      /*------------------------------
      WHAT'S NEW
      ------------------------------*/

      // Displays the latest podcast episode.
    	$podcast_args = array(
    		'tag'                 => 'lawyerist-podcast',
    		'ignore_sticky_posts' => TRUE,
    		'posts_per_page'			=> 1,
    	);

    	$podcast = new WP_Query( $podcast_args );

			// Starts the podcast sub-Loop.
			if ( $podcast->have_posts() ) : while ( $podcast->have_posts() ) : $podcast->the_post();

        // Outputs the post container.
        echo '<div ';
        post_class( 'index_post_container' );
        echo '>';

          $episode_title = the_title( '', '', FALSE );
  				$episode_url   = get_permalink();

  				echo '<a href="' . $episode_url . '" title="' . $episode_title . '">';

  					if ( has_post_thumbnail() ) {

              echo '<div class="default_thumbnail" style="background-image: url( ';
              echo the_post_thumbnail_url( 'default_thumbnail' );
              echo ' );"></div>';

  					}

          echo '</a>';

            // Now we get the headline and excerpt (except for certain kinds of posts).
            echo '<div class="headline_excerpt">';

              echo '<a href="' . $episode_url . '" title="' . $episode_title . '">';
              echo '<h2 class="headline">' . $episode_title . '</h2>';
              echo '</a>';

              $home_url = get_home_url( '', '/tag/lawyerist-podcast/' );
              echo '<a class="button" href="' . $home_url . '">See all episodes</a>.';

            echo '</div>'; // Close .headline_excerpt.

        echo '</div>'; // Close .post.
        echo "\n\n";

			endwhile; endif;

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
