<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

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
        $series_title				= $series_info->name;
        $series_description = $series_info->description;
        $series_slug				= $series_info->slug;
        $series_url					=	get_term_link( $series_ID[0], 'series' );
        $series_numposts    = 4; // Determines how many posts are displayed in the list.

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

    // Output the post.
    echo '<div class="post_body" itemprop="articleBody">';

      the_content();

      echo '<div class="clear"></div>';

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


    // If the post is in a series, list the other posts in the series.
    if ( has_term( true , 'series' ) ) {

      echo '<div id="series_nav">';

        // Start the series sub-Loop.
        // Uses variables from earlier in the loop, when we put the series title
        // above the headline.
        $series_query_args = array(
          'orderby'					=> 'date',
          'order'						=> 'ASC',
          'posts_per_page'	=> $series_numposts,
          'tax_query'     	=> array(
            array(
              'taxonomy'  => 'series',
              'field'			=> 'slug',
              'terms'			=> $series_slug,
            )
          )
        );

        $series_query = new WP_Query( $series_query_args );

        // Only show the series if there is more than one post in the series.
        if ( $series_query->post_count > 1 ) :

          // Series title.
          echo '<p class="h3">More in this Series: ' . $series_title . '</p>';

          // Show the series description if there is one.
          if ( $series_description != false ) { echo '<p>' . $series_description . '</p>'; }

          // Start the list of posts in the series.
          echo '<ul>';

            while ( $series_query->have_posts() ) : $series_query->the_post();

              $series_post_title = the_title( '', '', FALSE );
              $series_post_url   = get_permalink();

              // This doesn't link the current post's title to the current post,
              // because that would be silly.
              if ( get_the_ID() == $current_post ) {

                echo '<li>' . $series_post_title . '</li>';

              // This links all the other post's titles to those posts.
              } else {

                echo '<li><a href="' . $series_post_url . '" title="' . $series_post_title . '">' . $series_post_title . '</a></li>';

              }

            endwhile; // End the series sub-Loop while statement.

          echo '</ul>'; // End the list of posts in the series.

          // If there are more than the number of posts shown, show a link to
          // the series landing page.
          if ( $series_query->found_posts > $series_numposts ) {

            echo '<p><a href="' . $series_url . '">See all the posts in this series.</a></p>';

          }

        endif; // End the series sub-Loop while statement.

        wp_reset_postdata(); // Necessary because the series loop is nested in the main loop.

      echo '</div>'; // Close #series_nav.

    } // End series footer.


    // Display page navigation, categories, and tags.
    echo '<div id="categories_tags">';

      // Show the category list.
      $cats = get_the_category_list( ', ' );

      echo '<p class="category_list">' . $cats . '</p>';

      // Show the tag list.
      echo get_the_tag_list( '<p class="tag_list">', ', ', '</p>' );

    echo '</div>'; // Close #categories_tags.


    // Current posts.
		$this_post[]	= $post->ID;
		$after_date		= date( 'Y-m-d H:i:s', strtotime( '-6 days' ) );

		$current_posts_query_args = array(
      'category__not_in'		=> 1320, // Excludes sponsor-submitted posts.
      'date_query'					=> array(
        'after'             => $after_date,
      ),
      'ignore_sticky_posts' => TRUE,
      'orderby'							=> 'rand',
      'post__not_in'				=> $this_post,
      'posts_per_page'			=> 4,  // Determines how many posts are displayed in the list.
		);

		$current_posts_query = new WP_Query( $current_posts_query_args );

		if ( $current_posts_query->post_count > 1 ) :

			echo '<div id="current_posts">';

        echo '<p class="current_posts_heading">Current Posts</p>';

        // Start the current posts sub-Loop.
        while ( $current_posts_query->have_posts() ) : $current_posts_query->the_post();

					$current_post_title = the_title( '', '', FALSE );
          $current_post_url   = get_permalink();

          echo '<a href="' . $current_post_url . '" title="' . $current_post_title . '">';

            if ( has_post_thumbnail() ) {
              the_post_thumbnail( 'current_posts_thumbnail' );
            } else {
              echo '<img src="' . get_template_directory_uri() . '/images/fff-thumb.png" class="attachment-thumbnail wp-post-image" />';
            }

            echo '<p class="current_post_title">' . $current_post_title . '</p>';

          echo '</a>';

				endwhile;

        wp_reset_postdata();

        echo '<div class="clear"></div>';

			echo '</div>'; // Close #current_posts.

    endif; // End current posts.

    comments_template();

  echo '</div>'; // Close .post.

endwhile; endif; // Close the Loop.

?>
