<?php

// Start the Loop.
if ( have_posts() ) : while ( have_posts() ) : the_post();

  // Assign post variables.
  $page_title = the_title( '', '', FALSE );

  // Checks for a rating, then assigns variables if they will be needed.
  if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

    $our_rating             = lawyerist_get_our_rating();
    $community_rating       = lawyerist_get_community_rating();
    $community_review_count = lawyerist_get_community_review_count();
    $composite_rating       = lawyerist_get_composite_rating();

  }

  // Gets the $trial_button if there is one.
  $trial_button	= trial_button();

  // Breadcrumbs
  if ( function_exists( 'yoast_breadcrumb' ) ) {
    yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
  }

  if ( has_term( 'affinity-partner', 'page_type', $post->ID ) && get_field( 'affinity_active' ) == true ) {
    echo affinity_notice();
  }

  ?>

  <main>

    <div <?php post_class(); ?>>

      <div class="headline_container">

        <?php

        // Show featured image if there is one.
        if ( has_post_thumbnail() ) {

          ?>

          <div itemprop="image"><?php the_post_thumbnail( 'thumbnail' ); ?></div>

          <?php

        }

        ?>

        <div id="product_page_title">

          <?php if ( !empty( $composite_rating ) ) { ?>

            <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
            <h1 class="headline entry-title" itemprop="itemReviewed"><?php echo $page_title; ?></h1>

          <?php } else { ?>

            <h1 class="headline entry-title"><?php echo $page_title; ?></h1>

          <?php } ?>

          <?php if ( !empty( $composite_rating ) ) { ?>

            </div>

          <?php } ?>

        </div>

      </div>

      <div class="post_body" itemprop="articleBody">

        <?php if ( !empty( $trial_button ) ) { ?>

          <p align="center"><?php echo $trial_button; ?></p>

        <?php } ?>

        <?php if ( !empty( $composite_rating ) ) { ?>

          <div id="rating">

            <div class="card rating-box">

              <h2><?php echo $page_title; ?> Rating: <?php echo lawyerist_star_rating() . $composite_rating; ?>/5</h2>

              <?php if ( !empty( $our_rating ) ) { ?>

                <p class="card-label">Features</p>

                <?php echo wp_review_get_review_box(); ?>

              <?php } ?>

              <div class="card-label expandthis-click">Details</div>

              <div class="expandthis-hide">

                <div class="rating-breakdown">

                  <h3>Rating Breakdown</h3>

                  <?php if ( !empty( $our_rating ) ) { ?>

                    <p class="rating">Our Rating: <strong><?php echo $our_rating; ?></strong>/5</p>
                    <p><small>Our rating is based on our subjective judgment. Use our resources—including our rating and community ratings and reviews—to find the best fit for your firm.</small></p>

                  <?php } ?>

                  <?php if ( !empty( $community_rating ) ) { ?>

                    <p class="rating">Community Rating: <strong><?php echo $community_rating; ?></strong>/5 (based on <?php echo $community_review_count . _n( ' rating', ' ratings', $community_review_count ); ?>)</p>
                    <p><small>The community rating is based on the average of the community reviews below.</small></p>

                  <?php } ?>

                  <?php if ( !empty( $our_rating ) && !empty( $community_rating ) ) { ?>

                    <p class="rating composite-rating">Composite Rating: <strong><?php echo $composite_rating; ?></strong>/5</p>
                    <p><small>The composite rating is a weighted average of our rating and the community ratings below.</small></p>

                  <?php } ?>

                </div>

              </div>

            </div>

          </div>

        <?php

        }

        the_content();

        // Trial button
        if ( !empty( $trial_button ) ) {
          echo '<p align="center">' . $trial_button . '</p>';
        }

        // Byline
        get_template_part( './template-parts/postmeta', 'page' );

        lawyerist_get_alternative_products();

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

  </main>

  <?php

  if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

    ?>

    <div id="comments_container">
      <?php comments_template( '/reviews.php' ); ?>
    </div>

    <?php

  }

  lawyerist_get_related_posts();

endwhile; endif; // Close the Loop.
