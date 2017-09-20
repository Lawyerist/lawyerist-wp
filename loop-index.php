<?php

/*------------------------------
Selectors

$post_type == 'post' && $post_format == 'standard'
$post_format == 'aside'
has_tag( 'lawyerist-podcast' )
has_tag( 'tbd-law-community' )
has_term( true, 'series' )
has_term( true, 'sponsor' )
$post_type == 'download'
$post_type == 'page'

------------------------------*/

$post_num = 1; // Counter for inserting mobile ads and other stuff.

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  // Assign post variables.
  $post_title     = the_title( '', '', FALSE );
  $post_url       = get_permalink();
  $post_type      = get_post_type( $post->ID );
  if ( $post_type == 'post' ) {
    $post_format  = get_post_format() ? : 'standard';
  }
  $post_classes[] = 'index_post_container'; // .post, .page, and .download are added automatically, as are tags and formats.

  // Assign classes.
  if ( has_term( true, 'series' ) ) {
    $post_classes[] = 'series';
  }

  if ( has_term( true, 'sponsor' ) ) {
    $post_classes[] = 'sponsored';
  }


  // This is the container for all posts/groups of posts.
  echo '<div ' ;
  post_class( $post_classes );
  echo '>';

    // First we look for labels to show above the post container.

      // Series title:
      // Check for a series, get the series information, then output the series title.
      if ( has_term( true, 'series' ) && !is_tax( 'series' ) ) {

        $series_IDs = wp_get_post_terms(
          $post->ID,
          'series',
          array(
            'fields' 	=> 'ids',
            'orderby' => 'count',
            'order' 	=> 'DESC'
          )
        );

        $series_info				= get_term( $series_IDs[0] );
        $series_title				= $series_info->name;
        $series_description = $series_info->description;
        $series_slug				= $series_info->slug;
        $series_url					=	get_term_link( $series_IDs[0], 'series' );

        echo '<p class="series_title"><a href="' . $series_url . '" title="Read more posts in ' . $series_title . '">' . $series_title . '</a></p>';

      }

      // TBD Law Community Flag
      if ( has_tag( 'tbd-law-community' ) ) {
        echo '<p class="series_title"><a href="https://lawyerist.com/tag/tbd-law-community/" title="Read more posts from the TBD Law community.">TBD Law community</a></p>';
      }


    // Now we output the post link container (.post). The whole thing is a link!
    echo '<a href="' . $post_url . '" title="' . $post_title . '">';

      // First we figure out the post image based on the type of post.
      if ( has_post_thumbnail() ) {

        if ( has_term( true, 'series' ) && !is_tax( 'series' ) ) {

          the_post_thumbnail( 'default_thumbnail' );

        } elseif ( has_term( true, 'series' ) && is_tax( 'series' ) ) {

          echo '<div class="default_thumbnail" style="background-image: url( ';
          echo the_post_thumbnail_url( 'default_thumbnail' );
          echo ' );"></div>';

        } elseif ( $post_type == 'download' ) {

          the_post_thumbnail( 'download_thumbnail' );

        } elseif ( has_tag( 'tbd-law-community' ) ) {

          echo get_avatar( get_the_author_meta( 'ID' ), 100, '', get_the_author_meta( 'nicename' ) );

        } elseif ( $post_type == 'post' && $post_format == 'standard' && !has_term( true, 'sponsor' ) ) {

          the_post_thumbnail( 'standard_thumbnail' );

        } else {

          echo '<div class="default_thumbnail" style="background-image: url( ';
          echo the_post_thumbnail_url( 'default_thumbnail' );
          echo ' );"></div>';

        }

      }

      // Now we get the headline and excerpt (except for certain kinds of posts).
      echo '<div class="headline_excerpt">';

        // Headline
        echo '<h2 class="headline">' . $post_title . '</h2>';

        // Output the excerpt unless we're showing a page or a post from the
        // TBD Law community.
        if ( $post_type != 'page' && !has_tag( 'tbd-law-community' ) ) {

          $post_excerpt = get_the_excerpt();

          echo '<p class="excerpt">' . $post_excerpt . '</p>';

        }

        // Output the post meta unless we're showing a sticky, download or Link post.
        if ( !is_sticky() && $post_type != 'download' && !has_post_format( 'link' ) ) {
          lawyerist_postmeta();
        }

        // Show a button for downloads.
        if ( $post_type == 'download' ) {
          echo edd_get_purchase_link( array( 'download_id' => $post->ID ) );
        }

        // Clearfix
        echo '<div class="clear"></div>';

      echo '</div>'; // Close .headline_excerpt.

    echo '</a>'; // This closes the post link container (.post).


    // If the post is in a series, show up to 4 additional posts in that series.
    if ( has_term( true, 'series' ) && !is_tax( 'series' ) ) {

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

        $posts_in_series = 'series_of_' . $series_query->post_count;

        echo '<ul class="' . $posts_in_series . '">';

          while ( $series_query->have_posts() ) : $series_query->the_post();

            $series_post_title = the_title( '', '', FALSE );
            $series_post_url   = get_permalink();

            echo '<li><a href="' . $post_url . '" title="' . $series_post_title . '"><h3 class="headline">' . $series_post_title . '</h3></a></li>';

          endwhile;

        echo '</ul>';

        // Clearfix
        echo '<div class="clear"></div>';

      endif; // End series sub-Loop.

      wp_reset_postdata(); // Necessary because the series loop is nested in the main loop.

    } // End the additional series posts.

  echo '</div>'; // Close .post.
  echo "\n\n";

  // Insert ads on mobile.
  if ( $post_num == 1 && is_mobile() ) { lawyerist_get_ap2(); }
  if ( $post_num == 3 && is_mobile() ) { lawyerist_get_ap3(); }

  $post_num++; // Increment counter.

  unset ( $post_classes ); // Clear the post classes for the next trip through the Loop.

endwhile;

else :

  echo '<p class="post">No posts match your query.</p>';

endif; // Close the Loop.

?>
