<?php

if ( get_field( 'cta_show_custom_cta' ) == true ) {

  $cta = array(
    'dismissible' => get_field( 'cta_dismissible' ),
    'image'       => get_field( 'cta_image' ),
    'headline'    => get_field( 'cta_headline' ),
    'subheading'  => get_field( 'cta_subheading' ),
    'content'     => get_field( 'cta_content' ),
    'button_text' => get_field( 'cta_button_text' ),
    'button_url'  => get_field( 'cta_button_url' ),
    'free'        => get_field( 'cta_show_free_dot' ),
  );

} else {

  $cta = array(
    'dismissible' => get_field( 'cta_dismissible', 'option' ),
    'image'       => get_field( 'cta_image', 'option' ),
    'headline'    => get_field( 'cta_headline', 'option' ),
    'subheading'  => get_field( 'cta_subheading', 'option' ),
    'content'     => get_field( 'cta_content', 'option' ),
    'button_text' => get_field( 'cta_button_text', 'option' ),
    'button_url'  => get_field( 'cta_button_url', 'option' ),
    'free'        => get_field( 'cta_show_free_dot', 'option' ),
  );

}

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

  <a class="button<?php if ( $cta[ 'free' ] ) { echo ' free-flag'; } ?>" href="<?php echo $cta[ 'button_url' ]; ?>"><?php echo $cta[ 'button_text' ]; ?></a>

</div>
