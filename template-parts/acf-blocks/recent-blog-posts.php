<?php

$num_posts = get_field( 'recent_blog_posts_block_number_to_show' );

$args = array(
  'category__in'		=> array(
    '555', // Blog Posts
  ),
  'post__not_in'		=> get_option( 'sticky_posts' ),
  'posts_per_page'	=> $num_posts,
);

$current_post_query = new WP_Query( $args );

if ( $current_post_query->have_posts() ) :

  ?>

  <div id="fp-blog-posts" class="card has-card-label">

    <?php

    while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

      lawyerist_get_post_card();

    endwhile; wp_reset_postdata();

    $all_posts_txt	= 'All Blog Posts';
    $all_posts_url	=	get_category_link( 555 );

    echo '<p class="card-label card-bottom-label"><a href="' . $all_posts_url . '" title="' . $all_posts_txt . '">' . $all_posts_txt . '</a></p>';

    ?>

  </div>

  <?php

endif;
