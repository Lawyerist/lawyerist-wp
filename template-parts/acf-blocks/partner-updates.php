<?php

// Outputs sponsored posts in the current range (today minus 7 days) using
// the Sponsored Post Options start and end dates.

$today			= date( 'Ymd' );
$a_week_ago = date( 'Ymd', strtotime( '-7 days' ) );

$args		= array(
  'cat'					=> 1320,
  'meta_query'	=> array(
    array(
      'key'     => 'sponsored_post_start_date',
      'compare' => '>=',
      'value'   => $a_week_ago,
    ),
    array(
      'key'     => 'sponsored_post_end_date',
      'compare' => '>=',
      'value'   => $today,
    ),
  ),
  'orderby'							=> 'meta_value_num',
  'post__not_in'				=> get_option( 'sticky_posts' ),
  'posts_per_page'			=> 5,
);

$current_post_query = new WP_Query( $args );

if ( $current_post_query->have_posts() ) :

  ?>

  <p class="section-header">Partner Updates</p>

  <div id="fp-product-spotlights" class="card has-card-label sponsored">

    <?php

    while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

      lawyerist_get_post_card();

    endwhile; wp_reset_postdata();

    $all_spotlights_txt		= 'All Partner Updates';
    $all_spotlights_url		=	get_category_link( 1320 );

    echo '<p class="card-label card-bottom-label"><a href="' . $all_spotlights_url . '" title="' . $all_spotlights_txt . '">' . $all_spotlights_txt . '</a></p>';

    ?>

  </div>

  <?php

endif;
