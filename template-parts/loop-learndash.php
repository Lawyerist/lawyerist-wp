<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $post_title   = the_title( '', '', FALSE );
  $post_type    = get_post_type( $post->ID );

  // Breadcrumbs
  if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
  }

  ?>

  <main>

    <div <?php post_class(); ?>>

      <div class="headline_postmeta">
        <h1 class="headline entry-title"><?php echo $post_title; ?></h1>
      </div>

      <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>

      <div class="post_body" itemprop="articleBody">

        <?php

        the_content();

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

        ?>

      </div>

    </div>

    <?php 

endwhile; endif; // Close the Loop.
