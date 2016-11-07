<?php

$post_num     = 1; // Counter for inserting mobile ads.

if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Group a post that is in a series with other posts in that series.
  if ( has_term( true, 'series' ) ) {

    echo '<div class="series_post_container">';

      $this_post[] = $post->ID;

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

      $post_title   = the_title( '', '', FALSE );
      $post_excerpt = get_the_excerpt();
      $post_url     = get_permalink();

      echo '<h2 class="series_title"><a href="' . $series_url . '" title="' . $series_title . '">' . $series_title . '</a></h2>';

      echo '<a ';
      post_class( 'post_in_series' );
      echo 'href="' . $post_url . '" title="' . $post_title . '">';

        if ( has_post_thumbnail() ) { the_post_thumbnail( 'aside_thumbnail' ); }

        echo '<div class="headline_excerpt">';

          echo '<h2 class="headline">' . $post_title . '</h2>';

          if ( !is_mobile() ) { echo '<p class="excerpt">' . $post_excerpt . '</p>'; }

          lawyerist_get_postmeta();

        echo '</div>'; // End .headline_excerpt.

      echo '</a>';

      // Begin series loop.

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

      if ( $series_query->post_count > 1 ) {

        echo '<ul>';

          while ( $series_query->have_posts() ) : $series_query->the_post();

            $post_title = the_title( '', '', FALSE );
            $post_url   = get_permalink();

            echo '<li><a class="post_in_series" href="' . $post_url . '" title="' . $post_title . '"><h3 class="headline">' . $post_title . '</h3></a></li>';

          endwhile;

        echo '</ul>';

        echo '<div class="clear"></div>';

      } // End series loop.

      wp_reset_postdata(); // Necessary because the series loop is nested in the main loop.

    echo '</div>'; // End #series_post_container.

  // End series post.

  // Downloads (need different formatting so the button shows up and is clickable.)
  } elseif ( get_post_type( $post->ID ) == 'download' ) {

    $post_title   = the_title( '', '', FALSE );
    $post_excerpt = get_the_excerpt();
    $post_url     = get_permalink();

    echo '<div ';
    echo post_class( 'download_post_container' );
    echo '>';

      echo '<a href="' . $post_url . '" title="' . $post_title . '">';

        if ( has_post_thumbnail() ) { the_post_thumbnail( 'download_thumbnail' ); }

        echo '<div class="headline_excerpt">';

          echo '<h2 class="headline">' . $post_title . '</h2>';

          echo '<p class="excerpt">' . $post_excerpt . '</p>';

        echo '</div>'; // End .headline_excerpt.

      echo '</a>';

      echo edd_get_purchase_link( array( 'download_id' => $post->ID ) );

    echo '</div>'; // End #download_post_container.

  // End download.

  // Remaining post types/formats.
  } else {

    $post_title   = the_title( '', '', FALSE );
    $post_excerpt = get_the_excerpt();
    $post_url     = get_permalink();
    $post_classes = [];

    if ( has_term( true, 'sponsor' ) ) { $post_classes[] = 'sponsored_post'; }

    echo '<a ';
    post_class( $post_classes );
    echo 'href="' . $post_url . '" title="' . $post_title . '">';

      // Select the appropriate thumbnail based on post type/format.
      if ( has_post_thumbnail() ) {

        if ( has_post_format( 'aside' ) ) {
          the_post_thumbnail( 'aside_thumbnail' );
        } elseif ( get_post_type( $post->ID ) == 'page' ) {
          the_post_thumbnail( 'thumbnail' );
        } else {
          the_post_thumbnail( 'standard_thumbnail' );
        }

      }

      echo '<div class="headline_excerpt">';

        echo '<h2 class="headline">' . $post_title . '</h2>';

        if ( get_post_type( $post->ID ) != 'page' ) {
          if ( !is_mobile() ) { echo '<p class="excerpt">' . $post_excerpt . '</p>'; }
          lawyerist_get_postmeta();
        }

      echo '</div>'; // End .headline_excerpt.

      echo '<div class="clear"></div>';

    echo '</a>'; // End .post.

  }

// Insert ads on mobile.
if ( $post_num == 1 && is_mobile() ) { lawyerist_get_ap2(); }
if ( $post_num == 3 && is_mobile() ) { lawyerist_get_ap3(); }

$post_num++; // Increment counter.

endwhile; endif;

?>
