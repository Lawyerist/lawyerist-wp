<?php

// This loop outputs the covers with price tags of downloads in the Survival
// Guides category.

$downloads_args = array(
  'post_type'	=> 'download',
  'tax_query'	=> array(
    array(
      'taxonomy'	=> 'download_category',
      'field'			=> 'slug',
      'terms'			=> 'survival-guides',
    ),
  ),
);

$downloads = new WP_Query( $downloads_args );

if ( $downloads->have_posts() ) : while ( $downloads->have_posts() ) : $downloads->the_post();

  // Assign post variables.
  $page_title     = the_title( '', '', FALSE );
  $page_url       = get_permalink();

  // This is the post container.
  echo '<a ';
  post_class( 'hentry' );
  echo ' href="' . $page_url . '" title="' . $page_title . '">';

    if ( has_post_thumbnail() ) { the_post_thumbnail('medium'); }

    $price            = edd_get_download_price( $post->ID );
    $price_formatted  = edd_price( $post->ID, false );

    if ( $price == 0 ) {

      echo '<div class="price_tag">FREE</div>';

    } else {

      echo '<div class="price_tag">' . $price_formatted . '</div>';

    }

  echo '</a>';

endwhile;
endif;

?>
