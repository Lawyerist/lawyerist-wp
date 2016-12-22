<?php

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

if ( $downloads->have_posts() ) :
while ( $downloads->have_posts() ) : $downloads->the_post();

?>

  <a <?php post_class($class); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

    <?php if ( has_post_thumbnail() ) { the_post_thumbnail('medium'); }

    $price = edd_get_download_price( get_the_ID() );

    if ( $price == 0 ) { ?>
      <div class="price_tag">FREE</div>
    <?php } else { ?>
      <div class="price_tag"><?php edd_price( get_the_ID() ); ?></div>
    <?php } ?>

  </a>

<?php

endwhile;
endif;

?>
