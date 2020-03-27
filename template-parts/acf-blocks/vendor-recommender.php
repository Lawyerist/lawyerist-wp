<?php

$portal_id = get_field( 'recommender_product_portal' )?: get_the_ID();

if ( !is_product_portal( $portal_id ) ) { return; }

$feature_chart_ids  = get_feature_chart_ids();
$feature_chart      = $feature_chart_ids[ $portal_id ];

?>

<div class="card padded-card vendor-recommender">

  <?php

  switch ( $portal_id ) {

    case 226192: // Marketing & SEO
      echo do_shortcode( '[gravityform id=65 title=false ajax=true]' );
      break;

    default:
      return;

  }

  ?>

</div>

<?php
