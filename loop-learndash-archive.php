<?php

/*------------------------------
Selectors

has_category( 'lawyerist-podcast' )
has_term( true, 'sponsor' )
$post_type == 'product'
$post_type == 'page'

------------------------------*/

$courses_archive_args = array(
  'order'     => 'ASC',
  'orderby'   => 'menu_order',
  'post_type' => 'sfwd-courses',
);

$courses_archive = new WP_Query( $courses_archive_args );


// Start the Loop.
if ( $courses_archive->have_posts() ) :

  echo '<h1>Lawyerist Lab Courses</h1>';
  echo '<div id="courses-list">';

  while ( $courses_archive->have_posts() ) : $courses_archive->the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  // Assign post variables.
  $post_title     = the_title( '', '', FALSE );
  $post_url       = get_permalink();

  $post_classes[] = 'card';

  // Starts the post container.
  echo '<div ' ;
  post_class( $post_classes );
  echo '>';

    // Starts the link container. Makes for big click targets!
    echo '<a href="' . $post_url . '" title="' . $post_title . '">';

      // Now we get the headline.
      echo '<div class="headline-excerpt">';

        // Headline
        echo '<h2 class="headline">' . $post_title . '</h2>';

      echo '</div>'; // Close .headline-excerpt.

    echo '</a>'; // This closes the post link container (.post).

  echo '</div>'; // Close .post.
  echo "\n\n";

  endwhile;

  echo '</div>'; // Close #courses-list.

echo '<div class="page_links">';
  echo paginate_links();
echo '</div>';

else :

  echo '<p class="post">No posts match your query.</p>';

endif; // Close the Loop.


wp_reset_postdata();
