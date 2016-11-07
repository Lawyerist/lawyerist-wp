<?php


/******************************
Selectors

has_tag( 'lawyerist-podcast' )
has_term( true, 'series' )
has_term( true, 'sponsor' )
get_post_type( $post->ID ) == 'download'
get_post_type( $post->ID ) == 'page'
get_post_type( $post->ID ) == 'aside'

******************************/

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $post_num = 1; // Counter for inserting mobile ads.
  $post_title   = the_title( '', '', FALSE );
  $post_url     = get_permalink();
  $post_classes = []; // .post, .page, and .download are added automatically, as are tags and formats.

  // Assign classes.
  if ( has_term( true, 'series' ) ) {
    $post_classes[] = 'series';
  }

  if ( has_term( true, 'sponsor' ) ) {
    $post_classes[] = 'sponsored';
  }


  // This is the container for all posts/groups of posts.
  echo '<div class="index_post_container">';

    // Series title:
    // Check for a series, get the series information, then output the series title.
    if ( has_term( true, 'series' ) ) {

      $series_ID = wp_get_post_terms(
        $post->ID,
        'series',
        array(
          'fields' 	=> 'ids',
          'orderby' => 'count',
          'order' 	=> 'DESC'
        )
      );

      $series_info				= get_term( $series_ID[0] );
      $series_title				= $series_info->name;
      $series_description = $series_info->description;
      $series_slug				= $series_info->slug;
      $series_url					=	get_term_link( $series_ID[0], 'series' );

      echo '<h2 class="series_title"><a href="' . $series_url . '" title="' . $series_title . '">' . $series_title . '</a></h2>';

    }


    // Post link container (.post). The whole thing is a link!
    echo '<a href="' . $post_url . '" title="' . $post_title . '"';
    post_class( $post_classes );
    echo '>';

      // Show the post image if there is one.
      if ( has_post_thumbnail() ) {

        if ( has_post_format( 'aside' ) ) {
          the_post_thumbnail( 'aside_thumbnail' );
        } elseif ( has_post_thumbnail() ) {
          the_post_thumbnail( 'download_thumbnail' );
        } elseif ( get_post_type( $post->ID ) == 'page' ) {
          the_post_thumbnail( 'thumbnail' );
        } else {
          the_post_thumbnail( 'standard_thumbnail' );
        }

      }

      echo '<div class="headline_excerpt">';

        // Headline
        echo '<h2 class="headline">' . $post_title . '</h2>';

        // Output the excerpt unless we're showing a page.
        if ( get_post_type( $post->ID ) != 'page' ) {

          $post_excerpt = get_the_excerpt();

          echo '<p class="excerpt">' . $post_excerpt . '</p>';

        }

        // Output the post meta unless we're showing a page or a download.
        if ( get_post_type( $post->ID ) != ( 'page' || 'download' ) ) {
          lawyerist_get_postmeta();
        }

      echo '</div>'; // Close .headline_excerpt.

    echo '</a>'; // This closes the post link container (.post).


    // Show a button for downloads.
    if ( get_post_type( $post->ID ) == 'download' ) {
      echo edd_get_purchase_link( array( 'download_id' => $post->ID ) );
    }


    // If the post is in a series, show up to 4 additional posts in that series.
    if ( has_term( true, 'series' ) ) {

      $this_post[] = $post->ID; // We use this to exclude the current post.

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

      // Start the series sub-Loop.

      if ( $series_query->post_count > 1 ) :

        echo '<ul>';

          while ( $series_query->have_posts() ) : $series_query->the_post();

            $post_title = the_title( '', '', FALSE );
            $post_url   = get_permalink();

            echo '<li><a class="series" href="' . $post_url . '" title="' . $post_title . '"><h3 class="headline">' . $post_title . '</h3></a></li>';

          endwhile;

        echo '</ul>';

        echo '<div class="clear"></div>';

      endif; // End series sub-Loop.

      wp_reset_postdata(); // Necessary because the series loop is nested in the main loop.

    } // End the additional series posts.


  echo '</div>'; // Close .index_post_container.

  // Insert ads on mobile.
  if ( $post_num == 1 && is_mobile() ) { lawyerist_get_ap2(); }
  if ( $post_num == 3 && is_mobile() ) { lawyerist_get_ap3(); }

  $post_num++; // Increment counter.

endwhile; endif; // Close the Loop.

?>
