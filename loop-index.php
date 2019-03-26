<?php

/*------------------------------
Selectors

has_category( 'lawyerist-podcast' )
has_term( true, 'sponsor' )
$post_type == 'product'
$post_type == 'page'

------------------------------*/

$post_num = 1; // Counter for inserting mobile ads and other stuff.

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  $this_post[] = $post->ID; // We use this to exclude the current post from things.

  // Assign post variables.
  $post_title     = the_title( '', '', FALSE );
  $post_excerpt   = get_the_excerpt();
  $seo_title      = get_post_meta( $post->ID, '_yoast_wpseo_title', true );
  $seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );
  $post_url       = get_permalink();
  $post_type      = get_post_type( $post->ID );

  // Sets the post excerpt to the Yoast Meta Description.
  if ( !empty( $seo_descr ) ) { $post_excerpt = $seo_descr; }

  $post_classes[] = 'card'; // .post, .page, and .product are added automatically, as are categories, tags, and formats.

  // Skips sponsored posts.
  if ( is_category( 1320 ) ) {

    continue;

  } else {

    // Figures out the post thumbnail.
    if ( has_category( 'lawyerist-podcast' ) || has_tag( 'how-lawyers-work' ) ) {

      $first_image_url = get_first_image_url();

      if ( empty( $first_image_url ) ) {

        if ( has_category( 'lawyerist-podcast' ) ) {

          $first_image_url = 'https://lawyerist.com/lawyerist/wp-content/uploads/2018/09/podcast-mic-square-150x150.png';

        } elseif ( has_tag( 'how-lawyers-work' ) ) {

          $first_image_url = 'https://lawyerist.com/lawyerist/wp-content/uploads/2018/01/typewriter-150x150.jpg';

        }

      }

      $thumbnail      = '<div class="author_avatar"><img class="avatar" src="' . $first_image_url . '" /></div>';
      $post_classes[] = 'has-avatar-thumbnail';

    } elseif ( ( is_page() || is_author() ) && has_post_thumbnail() ) {

      $thumbnail_url  = get_the_post_thumbnail_url( $post->ID, 'default_thumbnail' );
      $thumbnail      = '<div class="default_thumbnail" style="background-image: url( ' . $thumbnail_url . ' );"></div>';

    } elseif ( $post_type == 'product' ) {

      $thumbnail_url  = get_the_post_thumbnail_url( $post->ID, 'shop_single' );
      $thumbnail      = '<img class="product-thumbnail" src="' . $thumbnail_url . '" />';

    } elseif ( !is_page() && !is_author() ) {

      $author_name		= get_the_author_meta( 'display_name' );
      $author_avatar	= get_avatar( get_the_author_meta( 'user_email' ), 150, '', $author_name );

      $thumbnail      = '<div class="author_avatar">' . $author_avatar . '</div>';
      $post_classes[] = 'has-avatar-thumbnail';

    }

    // Starts the post container.
    echo '<div ' ;
    post_class( $post_classes );
    echo '>';

      // Outputs the post label if there is one.
      if ( !empty( $post_label ) ) {
        echo '<p class="post_label"><a href="' . $post_label_url . '" title="Read all posts in ' . $post_label . '.">' . $post_label . '</a></p>';
      }

      // Starts the link container. Makes for big click targets!
      echo '<a href="' . $post_url . '" title="' . $post_title . '">';

        // Now we get the headline and, for some posts, the excerpt.
        echo '<div class="headline-excerpt">';

          // Thumbnail

          if ( !empty ( $thumbnail ) ) {
            echo $thumbnail;
          }

          // Headline
          echo '<h2 class="headline">' . $post_title . '</h2>';

          // Output the excerpt, with exceptions.
          if ( !has_category( 'lawyerist-podcast' ) && !has_category( 'blog-posts' ) && $post_type != 'page' ) {
            echo '<p class="excerpt">' . $post_excerpt . '</p>';
          }

          // Output the post meta, with exceptions.
          if ( $post_type == 'post' ) {
            lawyerist_postmeta();
          }

          // Show a button for products.
          if ( $post_type == 'product' ) {
            echo '<a href="' . $post_url . '" class="button">Learn More</a>';
          }

          // Clearfix
          echo '<div class="clear"></div>';

        echo '</div>'; // Close .headline-excerpt.

      echo '</a>'; // This closes the post link container (.post).

    echo '</div>'; // Close .post.
    echo "\n\n";

    // Insert product updates, and ads on mobile.
    if ( $post_num == 1 && is_mobile() ) { lawyerist_get_display_ad(); }

    $post_num++; // Increment counter.

    unset ( $post_classes, $post_label, $post_label_url, $thumbnail, $thumbnail_url ); // Clear variables for the next trip through the Loop.

  } // End loop for excluding sponsored posts and pages without the "Show in Feed" page type.

endwhile;

echo '<div class="page_links">';
  echo paginate_links();
echo '</div>';

else :

  echo '<p class="post">No posts match your query.</p>';

endif; // Close the Loop.
