<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $post_title   = the_title( '', '', FALSE );

  // Assign this post to a variable so we can exclude it from series posts and
  // current posts.
  $this_post[] = $post->ID;

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
        $series_title				= $series_info->name;
        $series_slug				= $series_info->slug;
        $series_url					=	get_term_link( $series_ID[0], 'series' );

        echo '<p class="series_title"><a href="' . $series_url . '" title="' . $series_title . '">' . $series_title . '</a></p>';

      }

      // Headline
      echo '<h1 class="headline entry-title">' . $post_title . '</h1>';

      // Call the lawyerist_postmeta function, which outputs the byline, date,
      // and share and comment counts.
      lawyerist_postmeta();

    echo '</div>'; // Close .headline_postmeta.

    // Show featured image (1) if the post has a featured image AND (2) if it's
    // the first page of the post AND (3) the post DOES NOT have the no-image tag.
    if ( has_post_thumbnail() && !has_tag('no-image') ) {

      echo '<div itemprop="image">';
      the_post_thumbnail('standard_thumbnail');
      echo '</div>';

    }

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
          echo 'This post is part of "' . $series_title . '," a series of ' . $series_query->post_count . ' posts.';
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

      echo '<div class="clear"></div>';

      previous_post_link( '<p><strong>Read the next post in this series: "%link."</em></strong>', '%title', true, '', 'series' );

      // Show page navigation if the post is paginated unless we're displaying
      // the RSS feed.
      if ( $numpages > 1 && !is_feed() ) {

        $wp_link_pages_args = array(
          'before'           => '<p class="page_links">',
          'after'            => '</p>',
          'link_before'      => '<span class="page_number">',
          'link_after'       => '</span>',
        );

        wp_link_pages( $wp_link_pages_args );

      }

    echo '</div>'; // Close .post_body.

    // Author bio footer.
    echo '<div id="author_bio_footer">';

      $author               = $wp_query->query_vars['author'];
      $author_name          = get_the_author_meta( 'display_name' );
      $author_bio           = get_the_author_meta( 'description' );
      $author_website       = get_the_author_meta( 'user_url' );
      $parsed_url           = parse_url( $author_website );
      $author_nice_website  = $parsed_url['host'];
      $author_twitter       = get_the_author_meta( 'twitter' );
      $author_avatar        = get_avatar( get_the_author_meta( 'user_email' ), 100, '', $author_name );

      // Show the author's headshot.
      echo $author_avatar;

      // Show the author bio.
      echo '<p>' . $author_bio . '</p>';

      // Show links to the author's website and Twitter and LinkedIn profiles.
      echo '<div id="author_connect">';
        if ( $author_twitter == true ) {
          echo '<p class="author_twitter"><a href="https://twitter.com/' . $author_twitter . '">@' . $author_twitter . '</a></p>';
        }
        if ( $author_website == true ) {
          echo '<p class="author_website"><a href="' . $author_website . '">' . $author_nice_website . '</a></p>';
        }
      echo '</div>'; // Close #author_connect.

    echo '</div>'; // Close #author_bio_footer.


    // Display page navigation, categories, and tags.
    echo '<div id="categories_tags">';

      // Show the category list.
      $cats = get_the_category_list( ', ' );

      echo '<p class="category_list">' . $cats . '</p>';

      // Show the tag list.
      echo get_the_tag_list( '<p class="tag_list">', ', ', '</p>' );

    echo '</div>'; // Close #categories_tags.

    lawyerist_current_posts();

    lawyerist_recent_discussions();

    comments_template();

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.

?>