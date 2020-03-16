<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $post_title = the_title( '', '', FALSE );

  // Breadcrumbs
  if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
  }

  ?>

  <main>

    <div <?php post_class(); ?>>

      <?php

      // Featured image
      if ( has_post_thumbnail() ) {

        ?>

        <div id="featured-image"><?php the_post_thumbnail(); ?></div>

        <?php

      }

      ?>

      <h1 class="headline entry-title"><?php echo $post_title; ?></h1>

      <?php get_template_part( './template-parts/postmeta', 'single_top' ); ?>

      <div class="post_body" itemprop="articleBody">

        <?php the_content(); ?>

        <?php

        // Show page navigation if the post is paginated unless we're displaying
        // the RSS feed.
        if ( !is_feed() ) {

          $wp_link_pages_args = array(
            'before'            => '<p class="page_links">',
            'after'             => '</p>',
            'link_before'       => '<span class="page_number">',
            'link_after'        => '</span>',
            'next_or_number'    => 'next',
            'nextpagelink'      => 'Next Page &raquo;',
            'previouspagelink'  => '&laquo; Previous Page',
            'separator'         => '|',
          );

          wp_link_pages( $wp_link_pages_args );

        }

        get_template_part( './template-parts/postmeta', 'single_bottom' );

        ?>

      </div>

    </div>

  </main>

  <?php

  echo lawyerist_cta();

  lawyerist_get_related_resources();

endwhile; endif; // Close the Loop.
