<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  // Assign post variables.
  $post_title = the_title( '', '', FALSE );

  // This is the post container.
  echo '<div ';
  post_class( 'hentry' );
  echo '>';

    echo '<div class="headline_postmeta">';

      // Series Title
      if ( has_term( true , 'series' ) ) {

        // Get the series variables (we'll use them again after the post).
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
        $post_label				= $series_info->name;
        $series_slug				= $series_info->slug;
        $series_url					=	get_term_link( $series_ID[0], 'series' );

        echo '<p class="post_label"><a href="' . $series_url . '" title="' . $post_label . '">' . $post_label . '</a></p>';

      }

      // Headline
      echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

      // Call the lawyerist_postmeta function, which outputs the byline, date,
      // and share and comment counts.
      get_template_part( 'postmeta', 'single_top' );

    echo '</div>'; // Close .headline_postmeta.

    // Show featured image (1) if the post has a featured image AND (2) if it's
    // the first page of the post AND (3) the post DOES NOT have the no-image tag.
    if ( has_post_thumbnail() && !has_tag('no-image') ) { the_post_thumbnail('standard_thumbnail'); }

    // If the post is in a series, link to the series.
    if ( has_term( true , 'series' ) ) {

      // Uses variables from earlier in the loop, when we put the series title
      // above the headline.
      $series_query_args = array(
        'orderby'					=> 'date',
        'order'						=> 'ASC',
        'tax_query'     	=> array(
          array(
            'taxonomy'  => 'series',
            'field'			=> 'slug',
            'terms'			=> $series_slug,
          )
        )
      );

      echo '<div id="series_note">';

        // Start the series sub-Loop.
        $series_query = new WP_Query( $series_query_args );

        // Only show the series if there is more than one post in the series.
        if ( $series_query->have_posts() ) : $series_query->the_post();

          $first_post_url = get_the_permalink();

          echo '<div class="series_icon"></div><p class="remove_bottom">';
          echo 'This post is part of "' . $post_label . '," a series of ' . $series_query->post_count . ' posts.';
          echo ' You can ';
          if ( $this_post[0] != $post->ID ) {
            echo '<a href="' . $first_post_url . '">start at the beginning</a> or ';
          }
          echo '<a href="' . $series_url . '">see all posts in the series</a>.';
          echo '</p>';

        endif; // End the series sub-Loop if statement.

        wp_reset_postdata(); // Necessary because the series loop is nested in the main loop.

      echo '</div>'; // Close #series_note.

    } // End series footer.

    // Output the post.
    echo '<div class="post_body" itemprop="articleBody">';

      the_content();

      // Show date modified if it's different than the date published.
      get_template_part( 'postmeta', 'single_bottom' );

      echo '<div class="clear"></div>';

      next_post_link( '<p class="series_next_post"><strong>Read the next post in this series: "%link."</em></strong>', '%title', true, '', 'series' );

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

  	lawyerist_get_author_bio();

    scorecard_cta();

    lawyerist_current_posts( $this_post );

    echo '<div id="comments_container">';
    comments_template( '/comments.php' );
    echo '</div>';

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.

?>
