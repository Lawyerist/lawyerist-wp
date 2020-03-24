<?php if ( have_rows( 'pages_block' ) ) : ?>

<div class="cards">

  <?php

  while( have_rows( 'pages_block' ) ) : the_row();

    $page_id = get_sub_field( 'pages_block_page' );

    lawyerist_get_post_card( $page_id );

  endwhile; wp_reset_postdata();

  ?>

</div>

<?php endif; ?>
