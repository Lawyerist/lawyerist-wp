<?php

$cta[ 'dismissible' ]	= get_field( 'cta_dismissible' ) ?: get_field( 'cta_dismissible', 'option' );
$cta[ 'image' ]				= get_field( 'cta_image' ) ?: get_field( 'cta_image', 'option' );
$cta[ 'headline' ]		= get_field( 'cta_headline' ) ?: get_field( 'cta_headline', 'option' ) ;
$cta[ 'subheading' ]	= get_field( 'cta_subheading' ) ?: get_field( 'cta_subheading', 'option' );
$cta[ 'content' ]			= get_field( 'cta_content' ) ?: get_field( 'cta_content', 'option' );
$cta[ 'button_text' ]	= get_field( 'cta_button_text' ) ?: get_field( 'cta_button_text', 'option' );
$cta[ 'button_url' ]	= get_field( 'cta_button_url' ) ?: get_field( 'cta_button_url', 'option' );
$cta[ 'free' ]				= get_field( 'cta_show_free_dot' ) ?: get_field( 'cta_show_free_dot', 'option' );

?>

<div id="cta" class="card<?php if ( $cta[ 'dismissible' ] ) { echo ' dismissible-notice'; } ?>" data-id="cta-<?php echo get_the_ID(); ?>">

  <?php if ( $cta[ 'dismissible' ] ) { ?>
    <button class="greybutton dismiss-button"></button>
  <?php } ?>

  <div class="cta_grid_row">

    <div id="cta_img">
      <?php echo wp_get_attachment_image( $cta[ 'image' ], 'medium' ); ?>
    </div>

    <div id="cta_copy">
      <h2><?php echo $cta[ 'headline' ]; ?></h2>
      <?php if ( $cta[ 'subheading' ] ) { ?><p class="card-label"><?php echo $cta[ 'subheading' ] ?></p><?php } ?>
      <?php echo $cta[ 'content' ] ?>
    </div>

  </div>

  <a class="button register-link<?php if ( $cta[ 'free' ] ) { echo ' free-flag'; } ?>" href="<?php echo $cta[ 'button_url' ]; ?>"><?php echo $cta[ 'button_text' ]; ?></a>

</div>
