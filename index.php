<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body <?php body_class('index'); ?>>

<?php get_header(); ?>

<div id="content_column_container">

  <div id="content_column">

    <?php if ( is_archive() ) {

      $title = single_term_title( '', FALSE);
      $descr = term_description();

      echo '<div id="archive_header"><h1>' . $title . '</h1>';
      echo "\n" . $descr;
      echo '</div>';

    }

    if ( is_search() ) {

			echo '<div id="archive_header"><h1>Search results for "' . get_search_query() . '"</h1></div>';
      echo '<div id="lawyerist_content_search">';
        get_search_form();
      echo '</div>';

		} ?>


    <!--/* THE LOOP */-->

    <?php // Prime the main query.
    $index_query_args = array(
      'post_type' => array(
        'post',
        'page',
        'download',
      ),
    );

    $index_query = new WP_Query( $index_query_args );

    $post_num = 1; // Counter for inserting mobile ads.

    if ( $index_query->have_posts() ) : while ( $index_query->have_posts() ) : $index_query->the_post();
    ?>

      <?php // Embedded loop for posts in a series.
      if ( has_term( true , 'series' ) ) { ?>

        <div class="series_post_container">

          <?php // Get series information.
          $current_post	= get_the_ID();
          $this_post[]	= $post->ID;

          $series_title = wp_get_post_terms(
            $post->ID,
            'series',
            array(
              'fields' 	=> 'names',
              'orderby' => 'count',
              'order' 	=> 'DESC'
            )
          );
          $series_title = $series_title[0];

          $series_slug = wp_get_post_terms(
            $post->ID,
            'series',
            array(
              'fields' 	=> 'slugs',
              'orderby' => 'count',
              'order' 	=> 'DESC'
            )
          );
          $series_slug = $series_slug[0];
          ?>

          <h2 class="series_title"><a href="<?php echo get_term_link( $series_slug, 'series' ); ?>" title="<?php echo $series_title; ?>"><?php echo $series_title; ?></a></h2>

          <a <?php post_class( 'post_in_series' ); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'aside_thumbnail' ); } ?>
            <div class="headline_excerpt">
              <h2 class="headline" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
              <?php if ( !is_mobile() ) { ?>
                <p class="excerpt<?php if ( has_post_thumbnail() ) { echo ' excerpt_with_thumb'; } ?>"><?php echo get_the_excerpt(); ?></p>
              <?php } ?>
              <?php lawyerist_get_postmeta(); ?>
            </div>
          </a>


          <?php // Series loop

          $series_query_args = array(
            'orderby'					=> 'date',
            'order'						=> 'DESC',
            'post__not_in'		=> $this_post,
            'posts_per_page'	=> 4,
            'tax_query'     	=> array(
              array(
                'taxonomy'  => 'series',
                'field'			=> 'slug',
                'terms'			=> $series_slug,
              )
            )
          );

          $series_query = new WP_Query( $series_query_args );

          if ( $series_query->post_count > 1 ) { ?>

            <ul>

              <?php while ( $series_query->have_posts() ) : $series_query->the_post();

                if ( get_the_ID() == $current_post ) { ?>

                  <li><h3 class="headline post_in_series" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h3></li>

                <?php } else { ?>

                  <li><a class="post_in_series" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h3 class="headline" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h3></a></li>

                <?php } ?>

              <?php endwhile; ?>

            </ul>

            <div class="clear"></div>

          <?php // End series loop.
          }

          wp_reset_postdata(); ?>

        </div>

      <?php // Loop through remaining post types/formats.
      } else { ?>

        <a <?php post_class(); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

          <?php // Select the appropriate thumbnail based on post type/format.
          if ( has_post_thumbnail() && (
            has_post_format( 'aside' ) ||
            get_post_type( get_the_ID() ) == 'page'
          ) ) {
            the_post_thumbnail( 'aside_thumbnail' );
          } elseif ( has_post_thumbnail() && get_post_type( get_the_ID() ) == 'download' ) {
            the_post_thumbnail( 'medium' );
          } elseif ( has_post_thumbnail() && has_post_format( 'audio' ) ) {
            the_post_thumbnail( 'aside_thumbnail' );
          } elseif ( has_post_thumbnail() ) {
            the_post_thumbnail( 'standard_thumbnail' );
          }
          ?>

          <div class="headline_excerpt">

    				<h2 class="headline" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>

    				<?php if ( !is_mobile() ) { ?>
              <p class="excerpt<?php if ( has_post_thumbnail() ) { echo ' excerpt_with_thumb'; } ?>"><?php echo get_the_excerpt(); ?></p>
            <?php } ?>

            <?php lawyerist_get_postmeta(); ?>

          </div>

  				<div class="clear"></div>

  			</a><!-- End .post -->

      <?php } ?>

    <?php // Insert ads on mobile.
    if ( $post_num == 1 && is_mobile() ) { insert_lawyerist_ap2(); }
    if ( $post_num == 3 && is_mobile() ) { insert_lawyerist_ap3(); }

    $post_num++; // Increment counter.

		endwhile; endif;
    ?>

		<!--/* END LOOP */-->


		<?php lawyerist_get_pagenav(); ?>


	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include('sidebar.php'); } ?>

	<div class="clear"></div>

</div><!-- end #content_column_container -->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
