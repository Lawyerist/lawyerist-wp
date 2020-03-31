<?php

/* INDEX

- Pullquotes
- Pullouts
- Testimonials
- Feature Charts
- Vendor Recommender Results
- List Child Pages
- List Featured Products
- List All Products
- List Affinity Partners
- Get Portal Card
- Gravity Forms Conirmation Message Shortcodes
  - Get Affinity Confirmation Message
  - Get Scorecard Grade
- List Contributors
- List Users
- Praise Cards

*/


/*--------------------------------------------------
Pullquotes
--------------------------------------------------*/

function lawyerist_pullquote_shortcode( $atts, $content = null ) {
  return '<aside><blockquote class="pullquote" markdown="1">' . $content . '</blockquote></aside>';
}

add_shortcode( 'pullquote', 'lawyerist_pullquote_shortcode' );


/*--------------------------------------------------
Pullouts
--------------------------------------------------*/

function lawyerist_pullout_shortcode( $atts, $content = null ) {
  return '<aside class="pullout"><p class="pullout" markdown="1"><span class="pullout_label">Related </span>' . $content . '</p></aside>';
}

add_shortcode( 'pullout', 'lawyerist_pullout_shortcode' );


/*--------------------------------------------------
Testimonials
--------------------------------------------------*/

function lawyerist_testimonial_shortcode( $atts, $quotation = null ) {

  $attributes = shortcode_atts( array(
    'source'  => '',
  ), $atts );

  $source = $attributes['source'];

  return '<aside><blockquote class="testimonial" markdown="1"><span class="sponsored_testimonial_quotation">&ldquo;' . $quotation . '&rdquo;</span><span class="sponsored_testimonial_source postmeta">—' . $source . '</span><span class="sponsored_testimonial_label">Testimonial Provided by Sponsor</span></blockquote></aside>';

}

add_shortcode( 'testimonial', 'lawyerist_testimonial_shortcode' );


/*--------------------------------------------------
Feature Charts
--------------------------------------------------*/

function get_feature_chart_ids() {

  // Connects portal IDs to the ACF field group ID so we can show filters
  // for this product list.
  // Portal ID => Group ID
  $feature_chart_ids = array(
    '306077' => 333571, // Reputation Management
    '121024' => 471015, // Law Practice Management Software
    '212684' => 480121, // Legal Research
    '254718' => 510758, // eDiscovery Software
    '200884' => 511008, // Credit Card Processing
    '158523' => 513265, // Accounting Software
    '238035' => 519846, // Intake & CRM
    '200847' => 545853, // Timekeeping & Billing Software
    '195769' => 566001, // Virtual Receptionists & Chat
    '306014' => 627369, // Document Management & Automation
    '226192' => 761359, // SEO & Marketing
  );

  return $feature_chart_ids;

}


function fc_process_feature_value( $feature ) {

    switch ( $feature[ 'type' ] ) {

      case 'url' :

        if ( $feature[ 'value' ] ) {

          $url_parsed = parse_url( $feature[ 'value' ] );
          $url_host  	= $url_parsed[ 'host' ];

          echo '<a href="' . $feature[ 'value' ] . '?utm_source=lawyerist&utm_medium=free-resources-page-link">' . $url_host . '</a>';

        } else {

          echo '&mdash;';

        }

        break;

      case 'checkbox' :

        if ( $feature[ 'value' ] ) {

          usort( $feature[ 'value' ], function( $a, $b ) {
            return strtoupper( $a ) <=> strtoupper( $b );
          });

          echo '<ul>';

            foreach ( $feature[ 'value' ] as $item ) {
              echo '<li>' . $item . '</li>';
            }

          echo '</ul>';

        } else {

          echo '&mdash;';

        }

        break;

      case 'true_false' :

        if ( $feature[ 'value' ] == true ) {

          echo '<div class="true">&check;</div>';

        } else {

          echo '<div class="false">&cross;</div>';

        }

        break;

      case 'string' :
      default :

        if ( $feature[ 'value' ] ) {

          echo $feature[ 'value' ];

        } else {

          echo '&mdash;';

        }

    }

  echo '</tr>';

}

function feature_chart( $post ) {

  ob_start();

    global $post;

    $post_id  = $post->ID;
    $parent   = wp_get_post_parent_id( $post_id );
    $fc_ids   = get_feature_chart_ids();

    if ( array_key_exists( $parent, $fc_ids ) ) {

      ?>

      <div id="feature-chart">
        <table>
          <tbody>

            <?php $fields = acf_get_fields( $fc_ids[ $parent ] ); ?>

            <?php foreach ( $fields as $field ) { ?>

              <?php

              $feature =  array(
                'type'    => $field[ 'type' ],
                'name'    => $field[ 'name' ],
                'label'   => $field[ 'label' ],
                'value'   => get_field( $field[ 'name' ] ),
              );

              if ( !empty( $field[ 'message' ] ) ) {
                $feature[ 'message' ] = $field[ 'message' ];
              }

              ?>

              <tr class="<?php echo $feature[ 'type' ]; ?>">

                <?php

                $colspan = '';

                if (
                  $feature[ 'type' ] == 'group' ||
                  $feature[ 'type' ] == 'message' ||
                  ( $feature[ 'type' ] == 'checkbox' && count( $feature[ 'value' ] ) > 5 )
                ) {
                  $colspan = ' colspan="2"';
                }

                ?>

                <th scope="row"<?php echo $colspan; ?>>

                  <div class="label"><?php echo  $feature[ 'label' ]; ?></div>

                  <?php if ( !empty( $feature[ 'message' ] ) )  { ?>
                    <div class="message"><?php echo $feature[ 'message' ]; ?></div>
                  <?php } ?>

                </th>

                <?php if ( $feature[ 'type' ] == 'group' ) { ?>

                  </tr>

                  <?php if ( have_rows( $feature[ 'name' ] ) ): ?>

                    <tr class="sub_feature">

                      <?php while ( have_rows( $feature[ 'name' ] ) ) : the_row(); ?>

                        <?php

                        $rows = get_row();

                        foreach ( $rows as $row_key => $row_val ) {

                          $sub_field  = get_sub_field_object( $row_key );

                          $sub_feature = array(
                            'type'    => $sub_field[ 'type' ],
                            'label'   => $sub_field[ 'label' ],
                            'value'   => get_sub_field( $row_key ),
                          );

                          if ( !empty( $sub_field[ 'message' ] ) ) {
                            $sub_feature[ 'message' ] = $sub_field[ 'message' ];
                          }

                          $colspan = '';

                          if ( $sub_feature[ 'type' ] == 'group' || $sub_feature[ 'type' ] == 'message' ) {
                            $colspan = ' colspan="2"';
                          }

                          ?>

                          <tr class="sub_feature">

                            <th scope="row" class="sub_feature"<?php echo $colspan; ?>>

                              <div class="label"><?php echo $sub_feature[ 'label' ]; ?></div>

                              <?php if ( !empty( $sub_feature[ 'message' ] ) )  { ?>
                                <div class="message"><?php echo $sub_feature[ 'message' ]; ?></div>
                              <?php } ?>

                            </th>

                            <?php if ( $sub_feature[ 'type' ] != 'message' ) { ?>

                              <td class="value">
                                <?php fc_process_feature_value( $sub_feature ); ?>
                              </td>

                            <?php } ?>

                          </tr>

                        <?php } ?>

                      <?php endwhile; ?>

                    </tr>

                  <?php endif; ?>

                <?php } elseif ( $feature[ 'type' ] == 'checkbox' && count( $feature[ 'value' ] ) > 5 ) { ?>

                  </tr>

                  <tr class="<?php echo $feature[ 'type' ]; ?>">

                    <td scope="row" class="value columns"<?php echo $colspan; ?>>
                      <?php fc_process_feature_value( $feature ); ?>
                    </td>

                <?php } elseif ( $feature[ 'type' ] == 'message' ) { ?>

                  <?php continue; ?>

                <?php } else { ?>

                  <td class="value">
                    <?php fc_process_feature_value( $feature ); ?>
                  </td>

                <?php } ?>

              </tr>

            <?php } ?>

          </tbody>
        </table>
      </div>

      <?php

    }

  return ob_get_clean();

}

add_shortcode( 'feature-chart', 'feature_chart' );


/*------------------------------
Vendor Recommender Results
------------------------------*/

function mktg_seo_recommender_results( $atts ) {

  $atts = shortcode_atts( array(
    'form_id'   => null,
    'entry_id'  => null,
  ), $atts );

  if ( !$atts[ 'entry_id' ] || !$atts[ 'form_id' ] ) {
    return '<p>Either the entry ID or the form ID is missing.</p>';
  }

  $entry = GFAPI::get_entry( $atts[ 'entry_id' ] );
  $services_field_id  = 10;
  $services_field_obj = RGFormsModel::get_field( $atts[ 'form_id' ], $services_field_id );

  $submission[ 'services' ]         = explode( ', ', $services_field_obj->get_value_export( $entry ) );
  $submission[ 'up_front_budget' ]  = $entry[ 30 ];
  $submission[ 'ongoing_budget' ]   = $entry[ 40 ];

  $total_choices  = count( $submission[ 'services' ] ) + 2;

  $meta_query_args = array(
    'relation'  => 'OR',
    array(
      'key'     => 'fc_seo_target_up_front_budget',
      'value'   => $submission[ 'up_front_budget' ],
    ),
    array(
      'key'     => 'fc_seo_target_ongoing_budget',
      'value'   => $submission[ 'ongoing_budget' ],
    ),
  );

  foreach ( $submission[ 'services' ] as $service ) {

    $meta_query_args[] = array(
      'key'           => 'fc_seo_services_offered',
      'value'         => $submission[ 'up_front_budget' ],
      'meta_compare'  => 'IN',
    );

  }

  $args = array(
    'fields'          => 'ids',
    'meta_query'      => $meta_query_args,
    'posts_per_page'  => -1,
    'post_status'     => 'publish',
    'post_type'       => 'page',
	);

  $products = new WP_Query( $args );

  if ( $products->have_posts() ):

    $results = array();

    while ( $products->have_posts() ): $products->the_post();

      $product_id = get_the_ID();
      $services   = get_field( 'fc_seo_services_offered', $product_id );

      foreach ( $submission[ 'services' ] as $service ) {

        if ( in_array( $service, $services ) ) {
          $matches++;
        }

      }

      if ( $submission[ 'up_front_budget'] == get_field( 'fc_seo_target_up_front_budget', $product->ID ) ) { $matches++; }
      if ( $submission[ 'ongoing_budget'] == get_field( 'fc_seo_target_ongoing_budget', $product->ID ) ) { $matches++; }

      if ( has_term( 'affinity-partner', 'page_type', $product_id ) && get_field( 'affinity_active' ) == true ) {
        $affinity_partner = true;
      } else {
        $affinity_partner = false;
      }

      $results[] = array(
        'id'                => $product_id,
        'title'             => the_title( '', '', FALSE ),
        'url'               => get_permalink(),
        'affinity_partner'  => $affinity_partner,
        'rating'            => lwyrst_get_composite_rating(),
        'match_score'       => round( $match_score / $total_choices * 100 ),
      );

    endwhile;

    usort( $results, function( $a, $b ) {
      return $a[ 'match_score' ] <=> $b[ 'match_score' ];
    });

    ?>

    <p>We found <?php echo count( $results ) . _n( ' product', ' products', $results ); ?> you should consider.</p>

      <?php foreach ( $results as $result ) { ?>

        <div class="recommender-result">

          <div class="title_container">

            <a class="title" href="<?php echo $result['url']; ?>"><?php echo $result['title']; ?></a>
            <div class="match-percentage"><?php echo $product_match_score; ?>% match</div>
            <div class="user-rating">

              <?php if ( !empty( $composite_rating ) ) { ?>

                <a href="<?php echo $product_page_url; ?>#rating">
                  <?php echo lwyrst_product_rating(); ?>
                </a>

              <?php } ?>

            </div>

          </div>

          <div class="result-row">

            <?php if ( has_post_thumbnail() ) { ?>

              <a class="image" href="<?php echo $product_page_url; ?>">

                <?php if ( has_term( 'affinity-partner', 'page_type', $post->ID ) && get_field( 'affinity_active' ) == true ) { ?>

                  <?php $theme_dir = get_template_directory_uri(); ?>

                  <img class="affinity-partner-badge" alt="Lawyerist affinity partner badge." src="<?php echo $theme_dir; ?>/images/affinity-partner-mini-badge.png" height="64" width="75" />

                <?php } ?>

                <?php the_post_thumbnail( 'thumbnail' ); ?>

              </a>

            <?php } ?>

            <table>
              <tbody>
                <tr>
                  <th colspan="3">Services</th>
                </tr>

                  <?php foreach ( $submission[ 'services' ] as $service ) { ?>

                    <tr>
                      <th class="sub-feature" colspan="2">
                        <?php echo $service; ?>
                      </th>
                      <td>
                        <?php if ( in_array( $service, $services ) ) { ?>
                          <div class="true">&check;</div>
                        <?php } else { ?>
                          <div class="false">&cross;</div>
                        <?php } ?>
                      </td>
                    </tr>

                  <?php } ?>

                <tr>
                  <th colspan="3">Budget</th>
                </tr>
                <tr>
                  <th class="sub-feature">Up-Front</th>
                  <td><?php echo $submission[ 'up_front_budget']; ?></td>
                  <td>
                    <?php if ( $submission[ 'up_front_budget'] == get_field( 'fc_seo_target_up_front_budget' ) ) { ?>
                      <div class="true">&check;</div>
                    <?php } else { ?>
                      <div class="false">&cross;</div>
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <th class="sub-feature">Monthly</th>
                  <td><?php echo $submission[ 'ongoing_budget']; ?></td>
                  <td>
                    <?php if ( $submission[ 'ongoing_budget'] == get_field( 'fc_seo_target_ongoing_budget' ) ) { ?>
                      <div class="true">&check;</div>
                    <?php } else { ?>
                      <div class="false">&cross;</div>
                    <?php } ?>
                  </td>
                </tr>

              </tbody>
            </table>

          </div>

        </div>

      <?php } ?>

  <?php else: ?>

    <p>There are no products that meet your requirements. Try using the product filters to narrow down the options.</p>

  <?php endif;

}

add_shortcode( 'mktg-seo-recommender-results', 'mktg_seo_recommender_results' );


/*------------------------------
List Child Pages
------------------------------*/

// Explodes a comma-separated list (',' and ', ').
// Nabbed from the excellent Display Posts Shortcode plugin.
// https://wordpress.org/plugins/display-posts-shortcode/
function explode_csv( $string = '' ) {
  $string = str_replace( ', ', ',', $string );
  return explode( ',', $string );
}

function lawyerist_child_pages_list( $atts ) {

  $current = get_the_ID();
	$parent  = get_the_ID();

	// Shortcode attributes.
	$atts = shortcode_atts( array(
    'portal'  => $parent,
    'exclude' => false,
  ), $atts );

  $exclude      = $atts['exclude'];
  $post__not_in = array();

  // Query variables.
	$args = array(
    'meta_query'      => array(
      'relation'      => 'OR',
      array(
        'key'   => '_yoast_wpseo_meta-robots-noindex',
        'value' => array( 0, 2 ),
      ),
      array(
        'key'     => '_yoast_wpseo_meta-robots-noindex',
        'value'   => 'nessie', // See https://core.trac.wordpress.org/ticket/23268
        'compare' => 'NOT EXISTS',
      ),
    ),
    'order'           => 'ASC',
    'orderby'         => 'menu_order',
    'post__not_in'    => $atts['exclude'],
		'post_parent'			=> $atts['portal'],
    'posts_per_page'  => -1,
    'post_status'     => 'publish',
		'post_type'				=> 'page',
	);

  // Maps comma-separated list of post IDs to exclude to an array, then assigns
  // them to the query args.
	if( !empty( $exclude ) ) {
		$post__not_in = array_map( 'intval', explode_csv( $exclude ) );
	}

	if( !empty( $post__not_in ) ) {
		$args['post__not_in'] = $post__not_in;
	}

  // Exclude the current post and portal parent regardless.
  $args['post__not_in'][] = $parent;

  if ( $parent != $current ) {
    $args['post__not_in'][] = $current;
  }

  ob_start();

    // Fires up the query.
  	$child_pages_list_query = new WP_Query( $args );

  	if ( $child_pages_list_query->have_posts() ) :

        echo '<div class="child-pages-list">';

    			// Start the Loop.
    			while ( $child_pages_list_query->have_posts() ) : $child_pages_list_query->the_post();

            lawyerist_get_post_card();

    			endwhile; wp_reset_postdata();

    		echo '</div>'; // End #child_pages

  	endif; // End child pages list.

  $child_pages_list = ob_get_clean();

  if ( !empty( $child_pages_list ) ) {

    return $child_pages_list;

  } else {

    return;

  }

}

add_shortcode( 'list-child-pages', 'lawyerist_child_pages_list' );


/*------------------------------
List Child Pages Fallback

Outputs child pages if all of the following are true:

1. It's a page.
2. It has children.
3. The page is not a product portal.
4. The [list-child-pages] shortcode is not used anywhere on the page.
------------------------------*/

function lawyerist_list_child_pages_fallback( $content ) {

	global $post;

	$get_children_args = array(
		'post_parent'		=> $post->ID,
		'post__not_in'	=> array(
			3379, 	// About
			245258, // Community
			128819, // LabCon
		),
		'fields'			=> 'ids',
		'post_type'		=> 'page',
	);

	$children = get_posts( $get_children_args );

if ( !is_home() && is_page() && ( count( $children ) > 0 ) && !is_product_portal() && !has_shortcode( $content, 'list-child-pages' ) ) {

		ob_start();

			echo do_shortcode( '[list-child-pages]' );

		$child_pages = ob_get_clean();

		$content .= $child_pages;

		return $content;

	} else {

		return $content;

	}

}

add_action( 'the_content', 'lawyerist_list_child_pages_fallback' );


/*------------------------------
List Featured Products
------------------------------*/

function lawyerist_featured_products_list( $atts ) {

  $parent   = get_the_ID();
  $country  = get_country();;

	// Shortcode attributes.
	$atts = shortcode_atts( array(
    'portal'  => $parent,
  ), $atts );

  // Quit if this isn't a product portal.
  if ( !is_product_portal( $atts[ 'portal' ] ) ) {
    return;
  }

  // Query variables.
  $args = array(
    'meta_query'      => array(
      'relation'      => 'OR',
      array(
        'key'   => '_yoast_wpseo_meta-robots-noindex',
        'value' => array( 0, 2 ),
      ),
      array(
        'key'     => '_yoast_wpseo_meta-robots-noindex',
        'value'   => 'nessie', // See https://core.trac.wordpress.org/ticket/23268
        'compare' => 'NOT EXISTS',
      ),
    ),
    'orderby'					=> 'rand',
    'post_parent'			=> $atts['portal'],
    'post_type'				=> 'page',
    'posts_per_page'	=> -1, // Determines how many page are displayed in the list.
    'tax_query' => array(
      array(
        'taxonomy' => 'page_type',
        'field'    => 'slug',
        'terms'    => array( 'platinum-sponsor', 'gold-sponsor' ),
      ),
    ),
  );

  $featured_products_list_query = new WP_Query( $args );

  if ( $featured_products_list_query->have_posts() ) :

    global $post;

    $portal_title = get_the_title( $post->ID );

    ob_start();

      ?>

      <h2>Featured <?php echo $portal_title; ?></h2>

      <ul class="product-pages-list featured-products-list">

        <?php

        // Start the Loop.
        while ( $featured_products_list_query->have_posts() ) : $featured_products_list_query->the_post();

          $product_page_id    = get_the_ID();
          $product_page_title = the_title( '', '', FALSE );
          $product_page_url		= get_permalink();

          $seo_descr  = get_post_meta( $product_page_id, '_yoast_wpseo_metadesc', true );

          if ( !empty( $seo_descr ) ) {
            $page_excerpt = $seo_descr;
          } else {
            $page_excerpt = get_the_excerpt();
          }

          // Check for a rating.
          if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {
            $composite_rating = lwyrst_get_composite_rating();
          }

          ?>

          <li class="card">

            <?php if ( has_post_thumbnail() ) { ?>

              <a class="image" href="<?php echo $product_page_url; ?>">

                <?php if ( has_term( 'affinity-partner', 'page_type', $post->ID ) && get_field( 'affinity_active' ) == true ) { ?>

                  <?php $theme_dir = get_template_directory_uri(); ?>

                  <img class="affinity-partner-badge" alt="Lawyerist affinity partner badge." src="<?php echo $theme_dir; ?>/images/affinity-partner-mini-badge.png" height="64" width="75" />

                <?php } ?>

                <?php the_post_thumbnail( 'thumbnail' ); ?>

              </a>

            <?php } ?>

            <div class="title_container">

              <a class="title" href="<?php echo $product_page_url; ?>"><?php echo $product_page_title; ?></a>

              <div class="user-rating">

                <?php if ( !empty( $composite_rating ) ) { ?>

                  <a href="<?php echo $product_page_url; ?>#rating">
                    <?php echo lwyrst_product_rating(); ?>
                  </a>

                <?php } else { ?>

                  <a href="<?php echo $product_page_url; ?>#respond">Leave a review.</a>

                <?php } ?>

              </div>

            </div>

            <?php if ( ( $country == ( 'US' || 'CA' ) ) && has_trial_button( $product_page_id ) ) { ?>

              <div class="list-products-trial-button">
                <?php echo trial_button( $product_page_id ); ?>
              </div>

            <?php } ?>

            <span class="excerpt"><?php echo $page_excerpt; ?> <a href="<?php echo $product_page_url; ?>">Learn more about <?php echo $product_page_title; ?></a></span>

          </li>

          <?php

        endwhile; wp_reset_postdata();

        ?>

      </ul>

      <?php if ( has_shortcode( $post->post_content, 'list-products' ) ) { ?>

        <p><a href="#all-products" class="button greybutton">See All</a></p>

      <?php }

    return ob_get_clean();

  endif; // End product list.

}

add_shortcode( 'list-featured-products', 'lawyerist_featured_products_list' );


/*------------------------------
List All Products
------------------------------*/

function lawyerist_all_products_list( $atts ) {

	$parent   = get_the_ID();
  $country  = get_country();

	// Shortcode attributes.
	$atts = shortcode_atts( array(
    'portal'        => $parent,
    'show_heading'  => 'true',
    'show_excerpt'  => 'true',
  ), $atts );

  // Quit if this isn't a product portal.
  if ( !is_product_portal( $atts[ 'portal' ] ) ) {
    return;
  }

  // Query variables.
	$args = array(
    'meta_query'      => array(
      'relation'      => 'OR',
      array(
        'key'   => '_yoast_wpseo_meta-robots-noindex',
        'value' => array( 0, 2 ),
      ),
      array(
        'key'     => '_yoast_wpseo_meta-robots-noindex',
        'value'   => 'nessie', // See https://core.trac.wordpress.org/ticket/23268
        'compare' => 'NOT EXISTS',
      ),
    ),
		'order'						=> 'ASC',
		'orderby'					=> 'title',
		'post_parent'			=> $atts[ 'portal' ],
    'posts_per_page'  => -1,
		'post_type'				=> 'page',
    'tax_query' => array(
			array(
				'taxonomy' => 'page_type',
				'field'    => 'slug',
				'terms'    => 'discontinued-product',
        'operator' => 'NOT IN',
			),
		),
	);

	$product_list_query = new WP_Query( $args );

	if ( $product_list_query->post_count > 0 ) :

    global $post;

    $fields       = array();
    $portal_title = get_the_title( $post->ID );

    ob_start();

      ?>

      <div id="all-products" class="target"></div>

      <?php if ( $atts[ 'show_heading' ] == 'true' ) { ?>
        <h2><?php echo $portal_title; ?> (Alphabetical List)</h2>
      <?php } ?>

      <?php $acf_group_ids = get_feature_chart_ids();

      if ( array_key_exists( $parent, $acf_group_ids ) ) {

        // Get filters.
        $fields = acf_get_fields( $acf_group_ids[ $atts[ 'portal' ] ] );

        ?>

        <p class="card-label">Filter by Feature</p>

        <div class="product-filters">
          <a class="show-all">Show All</a>

          <?php

          if ( !empty( $fields ) ) {

            foreach ( $fields as $field ) {

              if ( $field['type'] == 'true_false' ) {

                ?>

                <a class="filter" data-acf_label="<?php echo $field[ 'name' ]; ?>"><?php echo $field['label']; ?></a>

                <?php

              }

            }

          }

          ?>

          <div class="clear"></div>

        </div>

        <?php

      }

      ?>

  		<ul class="product-pages-list">

        <?php

  			// Start the Loop.
  			while ( $product_list_query->have_posts() ) : $product_list_query->the_post();

          $product_page_id    = get_the_ID();
  				$product_page_title	= the_title( '', '', FALSE );
  				$product_page_url		= get_permalink();

          $seo_descr  = get_post_meta( $product_page_id, '_yoast_wpseo_metadesc', true );

          if ( !empty( $seo_descr ) ) {
            $page_excerpt = $seo_descr;
          } else {
            $page_excerpt = get_the_excerpt();
          }

          // Check for a rating.
          if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {
          	$composite_rating = lwyrst_get_composite_rating();
          }

          $classes = array( 'card product-card' );

          foreach ( $fields as $field ) {

            if ( $field['type'] == 'true_false' ) {

              $field_val = get_field( $field[ 'name' ], $post->ID );

              if ( $field_val == true ) {
                $classes[] = $field[ 'name' ];
              }

            }

          }

          ?>

  				<li <?php post_class( $classes ); ?>>

  					<?php if ( has_post_thumbnail() ) { ?>

  						<a class="image" href="<?php echo $product_page_url; ?>">

                <?php if ( has_term( 'affinity-partner', 'page_type', $post->ID ) && get_field( 'affinity_active' ) == true ) { ?>

                  <?php $theme_dir = get_template_directory_uri(); ?>

                  <img class="affinity-partner-badge" alt="Lawyerist affinity partner badge." src="<?php echo $theme_dir; ?>/images/affinity-partner-mini-badge.png" height="64" width="75" />

                <?php } ?>

    						<?php the_post_thumbnail( 'thumbnail' ); ?>

  						</a>

  					<?php } ?>

            <div class="title_container">

              <a class="title" href="<?php echo $product_page_url; ?>"><?php echo $product_page_title; ?></a>

              <div class="user-rating">

                <?php if ( !empty( $composite_rating ) ) { ?>

                  <a href="<?php echo $product_page_url; ?>#rating">

                    <?php echo lwyrst_product_rating(); ?>

                  </a>

                <?php } else { ?>

                  <a href="<?php echo $product_page_url; ?>#respond">Leave a review.</a>

                <?php } ?>

              </div>

            </div>

            <?php

            // Outputs trial button if there is one, except on the all-reviews page.
            if ( !is_page( '301729' ) ) {

              if ( ( $country == ( 'US' || 'CA' ) ) && has_trial_button( $product_page_id ) ) {

                ?>

                <div class="list-products-trial-button">
                  <?php echo trial_button( $product_page_id ); ?>
                </div>

                <?php

              }

            }

            ?>

  					<?php if ( $atts[ 'show_excerpt' ] == 'true' ) { ?>
              <span class="excerpt"><?php echo $page_excerpt; ?> <a href="<?php echo $product_page_url; ?>">Learn more about <?php echo $product_page_title; ?>.</a></span>
            <?php } ?>

  				</li>

          <?php

          unset( $classes );

  			endwhile; wp_reset_postdata();

        ?>

  		</ul>

      <p id="no-results-placeholder" style="display: none;">Sorry, no results based on your choices.</p>

      <?php

    return ob_get_clean();

	endif; // End product list.

}

add_shortcode( 'list-products', 'lawyerist_all_products_list' );


function product_features_list( $atts ) {

  $portal = get_the_ID();

  // Shortcode attributes.
  $atts = shortcode_atts( array(
    'portal' => $portal,
  ), $atts );

  // Quit if this isn't a product portal.
  if ( !is_product_portal( $atts[ 'portal' ] ) ) {
    return;
  }

  ob_start();

    $acf_group_ids  = get_feature_chart_ids();
    $fields         = acf_get_fields( $acf_group_ids[ $atts[ 'portal' ] ] );

    if ( !empty( $fields ) ) {

      echo '<h2>' . get_the_title( $atts[ 'portal' ] ) . ' Feature Descriptions</h2>';

      foreach ( $fields as $field ) {

        if ( !empty( $field[ 'message' ] ) )  {
          echo '<p><strong>' . $field[ 'label' ] . '.</strong> ' . $field[ 'message' ] . '</p>';
        }

      }

    } else {

      $return;

    }

  return ob_get_clean();

}

add_shortcode( 'list-product-features', 'product_features_list' );


/*------------------------------
List Affinity Partners
------------------------------*/

function lwyrst_affinity_partners_list() {

  // Get a list of product portals.
  $prod_portal_args = array(
    'order'						=> 'ASC',
		'orderby'					=> 'title',
    'post_parent'     => 301729,
    'posts_per_page'  => -1,
    'post_type'       => 'page',
  );

  $prod_portal_query = new WP_Query( $prod_portal_args );

  if ( $prod_portal_query->post_count > 0 ) :

    ob_start();

      while ( $prod_portal_query->have_posts() ) : $prod_portal_query->the_post();

        $portal_ID = get_the_ID();

        // Query variables.
      	$child_args = array(
          'meta_key'		    => 'affinity_active',
        	'meta_value'	    => true,
      		'order'						=> 'ASC',
      		'orderby'					=> 'title',
          'post_parent'     => $portal_ID,
          'posts_per_page'  => -1,
      		'post_type'				=> 'page',
          'tax_query'       => array(
            array(
              'taxonomy'  => 'page_type',
              'field'     => 'slug',
              'terms'     => 'affinity-partner',
            ),
          ),
      	);

      	$affinity_partner_list_query = new WP_Query( $child_args );

      	if ( $affinity_partner_list_query->post_count > 0 ) :

          ?>

          <h3><?php echo get_the_title( $portal_ID ); ?></h3>

      		<ul class="product-pages-list">

      			<?php while ( $affinity_partner_list_query->have_posts() ) : $affinity_partner_list_query->the_post(); ?>

              <?php

              $product_page_id    = get_the_ID();
      				$product_page_title	= the_title( '', '', FALSE );
      				$product_page_url		= get_permalink();

              $seo_descr  = get_post_meta( $product_page_id, '_yoast_wpseo_metadesc', true );

              if ( !empty( $seo_descr ) ) {
                $page_excerpt = $seo_descr;
              } else {
                $page_excerpt = get_the_excerpt();
              }

              // Check for a rating.
              if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

              	$composite_rating = lwyrst_get_composite_rating();

              }

              ?>

      				<li <?php post_class( 'card' ); ?>>

      					<?php if ( has_post_thumbnail() ) { ?>

      						<a class="image" href="<?php echo $product_page_url; ?>">

                    <?php if ( has_term( 'affinity-partner', 'page_type', $product_page_id ) && get_field( 'affinity_active' ) == true ) { ?>

                      <?php $theme_dir = get_template_directory_uri(); ?>

                      <img class="affinity-partner-badge" alt="Lawyerist affinity partner badge." src="<?php echo $theme_dir; ?>/images/affinity-partner-mini-badge.png" height="64" width="75" />

                    <?php } ?>

        						<?php the_post_thumbnail( 'thumbnail' ); ?>

      						</a>

      					<?php } ?>

                <div class="title_container">

                  <a class="title" href="<?php echo $product_page_url; ?>"><?php echo $product_page_title; ?></a>

                  <div class="user-rating">

                    <?php if ( !empty( $composite_rating ) ) { ?>

                      <a href="<?php echo $product_page_url; ?>#rating"><?php  echo lwyrst_product_rating(); ?></a>

                    <?php } else { ?>

                      <a href="<?php echo $product_page_url; ?>#respond">Leave a review.</a>

                    <?php } ?>

                  </div>

                </div>

      					<span class="excerpt"><?php echo $page_excerpt; ?> <a href="<?php echo $product_page_url; ?>">Learn more about <?php echo $product_page_title; ?>.</a></span>

      				</li>

      			<?php endwhile; wp_reset_postdata(); ?>

      		</ul>

          <?

      	endif; // End product list.

      endwhile; wp_reset_postdata();

    $all_partners = ob_get_clean();

  endif;

  return $all_partners;

}

add_shortcode( 'list-affinity-partners', 'lwyrst_affinity_partners_list' );


/*------------------------------
Get Portal Card
------------------------------*/

function lawyerist_get_portal_card( $atts ) {

	// Shortcode attributes.
	$atts = shortcode_atts( array(
    'portal'  => '',
  ), $atts );

  if ( empty( $atts[ 'portal' ] ) ) {
    return;
  }

  $portal_url     = get_permalink( $atts[ 'portal' ] );
  $portal_title   = get_the_title( $atts[ 'portal' ] );
  $product_logos  = array();
  $logo_total     = 12;
  $logo_count     = 0;

  // Start by getting platinum thumbnails and adding them to $product_logos.
	$args = array(
    'meta_query'      => array(
      'relation'      => 'OR',
      array(
        'key'   => '_yoast_wpseo_meta-robots-noindex',
        'value' => array( 0, 2 ),
      ),
      array(
        'key'     => '_yoast_wpseo_meta-robots-noindex',
        'value'   => 'nessie', // See https://core.trac.wordpress.org/ticket/23268
        'compare' => 'NOT EXISTS',
      ),
    ),
		'orderby'					=> 'rand',
		'post_parent'			=> $atts[ 'portal' ],
    'posts_per_page'  => $logo_total,
		'post_type'				=> 'page',
    'tax_query' => array(
      array(
				'taxonomy' => 'page_type',
				'field'    => 'slug',
				'terms'    => 'platinum-sponsor',
        'operator' => 'IN',
			),
		),
	);

	$platinum_query = new WP_Query( $args );

	if ( $platinum_query->post_count > 0 ) {

    $logo_count = $platinum_query->post_count;

    while ( $platinum_query->have_posts() ) : $platinum_query->the_post();

      $post_ID  = get_the_ID();
      $url      = get_the_post_thumbnail_url( $post_ID, 'thumbnail' );
      $alt      = get_the_title();

      $product_logos[] = '<img src="' . $url . '" alt="' . $alt . '" />';

    endwhile; wp_reset_postdata();

  }

  // If we still don't have 6 logos, add gold sponsors.
  /* if ( $logo_count < $logo_total ) { */

  	$args = array(
      'meta_query'      => array(
        'relation'      => 'OR',
        array(
          'key'   => '_yoast_wpseo_meta-robots-noindex',
          'value' => array( 0, 2 ),
        ),
        array(
          'key'     => '_yoast_wpseo_meta-robots-noindex',
          'value'   => 'nessie', // See https://core.trac.wordpress.org/ticket/23268
          'compare' => 'NOT EXISTS',
        ),
      ),
  		'orderby'					=> 'rand',
  		'post_parent'			=> $atts[ 'portal' ],
      'posts_per_page'  => -1,
  		'post_type'				=> 'page',
      'tax_query' => array(
        array(
  				'taxonomy' => 'page_type',
  				'field'    => 'slug',
  				'terms'    => 'gold-sponsor',
          'operator' => 'IN',
  			),
  		),
  	);

  	$gold_query = new WP_Query( $args );

  	if ( $gold_query->post_count > 0 ) {

      $logo_count = $logo_count + $gold_query->post_count;

      while ( $gold_query->have_posts() ) : $gold_query->the_post();

        $post_ID  = get_the_ID();
        $url      = get_the_post_thumbnail_url( $post_ID, 'thumbnail' );
        $alt      = get_the_title();

        $product_logos[] = '<img src="' . $url . '" alt="' . $alt . '" />';

      endwhile; wp_reset_postdata();

    }

  /* }

  // If we still don't have 6 logos, add silver sponsors.
  if ( $logo_count < $logo_total ) { */

  	$args = array(
      'meta_query'      => array(
        'relation'      => 'OR',
        array(
          'key'   => '_yoast_wpseo_meta-robots-noindex',
          'value' => array( 0, 2 ),
        ),
        array(
          'key'     => '_yoast_wpseo_meta-robots-noindex',
          'value'   => 'nessie', // See https://core.trac.wordpress.org/ticket/23268
          'compare' => 'NOT EXISTS',
        ),
      ),
  		'orderby'					=> 'rand',
  		'post_parent'			=> $atts[ 'portal' ],
      'posts_per_page'  => -1,
  		'post_type'				=> 'page',
      'tax_query' => array(
        array(
  				'taxonomy' => 'page_type',
  				'field'    => 'slug',
  				'terms'    => 'silver-sponsor',
          'operator' => 'IN',
  			),
  		),
  	);

  	$silver_query = new WP_Query( $args );

  	if ( $silver_query->post_count > 0 ) {

      $logo_count = $logo_count + $silver_query->post_count;

      while ( $silver_query->have_posts() ) : $silver_query->the_post();

        $post_ID  = get_the_ID();
        $url      = get_the_post_thumbnail_url( $post_ID, 'thumbnail' );
        $alt      = get_the_title();

        $product_logos[] = '<img src="' . $url . '" alt="' . $alt . '" />';

      endwhile; wp_reset_postdata();

    }

  /* }

  // And if we somehow still don't have 6 logos, add the rest sponsors.
  if ( $logo_count < $logo_total ) { */

  	$args = array(
      'meta_query'      => array(
        'relation'      => 'OR',
        array(
          'key'   => '_yoast_wpseo_meta-robots-noindex',
          'value' => array( 0, 2 ),
        ),
        array(
          'key'     => '_yoast_wpseo_meta-robots-noindex',
          'value'   => 'nessie', // See https://core.trac.wordpress.org/ticket/23268
          'compare' => 'NOT EXISTS',
        ),
      ),
  		'orderby'					=> 'rand',
  		'post_parent'			=> $atts[ 'portal' ],
      'posts_per_page'  => -1,
  		'post_type'				=> 'page',
      'tax_query' => array(
        array(
  				'taxonomy' => 'page_type',
  				'field'    => 'slug',
  				'terms'    => array(
            'platinum-sponsor',
            'gold-sponsor',
            'silver-sponsor',
          ),
          'operator' => 'NOT IN',
  			),
  		),
  	);

  	$remainder_query = new WP_Query( $args );

  	if ( $remainder_query->post_count > 0 ) {

      $logo_count = $logo_count + $remainder_query->post_count;

      while ( $remainder_query->have_posts() ) : $remainder_query->the_post();

        $post_ID  = get_the_ID();
        $url      = get_the_post_thumbnail_url( $post_ID, 'thumbnail' );
        $alt      = get_the_title();

        $product_logos[] = '<img src="' . $url . '" alt="' . $alt . '" />';

      endwhile; wp_reset_postdata();

    }

  /* } */

  ob_start();

    echo '<a href="' . $portal_url . '" class="card portal-card">';

      echo '<div class="portal-card-header">';

        echo '<h2 class="headline">' . $portal_title . '</h2>';
        echo '<button>See the Reviews</button>';

      echo '</div>';

      echo '<div class="portal-card-logos">';

  			foreach ( $product_logos as $logo ) {

          echo $logo;

        }

      echo '</div>';

		echo '</a>';

  $portal_card = ob_get_clean();

  return $portal_card;

}

add_shortcode( 'get-portal-card', 'lawyerist_get_portal_card' );


/*------------------------------
Gravity Forms Confirmation Message Shortcodes

These shortcodes are only useful in Gravity Forms confirmations.
------------------------------*/

/*------------------------------
Get Affinity Confirmation Message

Returns the affinity confirmation message
for affinity benefit claims.

Shortcode: [affinity-confirmation partner="{Affinity Partner:3}" workflow="{Affinity Workflow:7}" claim_url="{Affinity Claim URL:8}" claim_code="{Affinity Claim Code:9}"]
------------------------------*/

function lawyerist_get_affinity_confirmation_message( $atts ) {

    $atts = shortcode_atts( array(
      'partner'     => null,
      'workflow'    => null,
      'claim_url'   => null,
      'claim_code'  => null,
    ), $atts );

    $partner    = $atts['partner'];
    $workflow   = $atts['workflow'];
    $claim_url  = $atts['claim_url'];
    $claim_code = $atts['claim_code'];

    ob_start();

      echo '<h2>Thanks!</h2>';

      echo '<p>We have received your ' . $partner . ' benefit claim.</p>';

      switch ( $workflow ) {

        case $workflow == 'warm_handoff':

          echo '<p>Please check your email. Within the next few minutes you should receive an email introducing you to your contact at ' . $partner . ' who will help you claim your benefit. If you do not receive the email, please check your spam folder. And if that does not work, use our <a href="https://lawyerist.com/contact/">contact form</a> to ask for help.</p>';

          break;

        case $workflow == 'coupon_code':

          echo '<p>You are almost done claiming your discount! To finish, follow these easy steps:</p>';

          echo '<ol>';
            echo '<li><a href="' . $claim_url . '" target="_blank">Follow this link.</a></li>';
            echo '<li>Enter this claim code: <strong>' . $claim_code . '</strong></li>';
          echo '</ol>';

          echo '<p>We also emailed these instructions to you. If you do not receive the email within a few minutes, please check your spam folder. And if that does not work, use our <a href="https://lawyerist.com/contact/">contact form</a> to ask for help.</p>';

          break;

        case $workflow == 'url_only':

          echo '<p><strong>To claim your discount, just <a href="' . $claim_url . '">follow this link</a>!</strong></p>';

          echo '<p>That\'s it!</p>';

          echo '<p>We also emailed these instructions to you. If you do not receive the email within a few minutes, please check your spam folder. And if that does not work, use our <a href="https://lawyerist.com/contact/">contact form</a> to ask for help.</p>';

          break;

      }

    $confirmation_message = ob_get_clean();

    return $confirmation_message;

}

add_shortcode( 'affinity-confirmation', 'lawyerist_get_affinity_confirmation_message' );


/*------------------------------
Get Scorecard Grade

Returns the Scorecard grade for a given score.

Shortcode: [get_grade form_id="{form_id}" raw_score="{survey_total_score}" q1="{score:id=101}" q2="{score:id=102}" q3="{score:id=103}"]
------------------------------*/

function lawyerist_get_scorecard_grade( $atts ) {

  $atts = shortcode_atts( array(
    'form_id'   => null,
    'raw_score' => null,
    'q1'        => null,
    'q2'        => null,
    'q3'        => null,
  ), $atts );

  $form_id      = $atts[ 'form_id' ];
  $raw_score    = $atts[ 'raw_score' ];
  $goals_score  = $atts[ 'q1' ] + $atts[ 'q2' ] + $atts[ 'q3' ];

  // Checks to see which form was submitted.
  switch ( $form_id ) {

    // Small Firm Scorecard 1.0 & 2.0
    case $form_id == 45:
    case $form_id == 60:
      $total = 500;
      break;

    // Solo Practice Scorecard 1.0
    case $form_id == 47:
      $total = 400;
      break;

    // Solo Practice Scorecard 2.0
    case $form_id == 61:
      $total = 420;
      break;

  }

  // Calculates the % score.
  $score = ( $raw_score / $total ) * 100;

  switch ( $score ) {

    case ( $score < 60 ):
      $grade = 'F';
      break;

    case ( $score >= 60 && $score < 70 ):
      $grade = 'D';
      break;

    case ( $score >= 70 && $score < 80 ):
      $grade = 'C';
      break;

    case ( $score >= 80 && $score < 90 ):
      $grade = 'B';
      break;

    case ( $score >= 90 ):
      $grade = 'A';
      break;

  }

  ob_start();

  ?>

    <div id="scorecard_results">
      <div id="grade_box">
        <div class="grade_label">Your Firm's Score</div>
        <div class="grade"><?php echo $grade; ?></div>
        <div class="score"><?php echo $raw_score; ?>/<?php echo $total; ?></div>
      </div>
      <div id="get_results">
        <a class="button" href="#interpret_results">Interpret Your Results</a>
      </div>
      <div class="clear"></div>
    </div>

  <?php

    if ( $goals_score <= 15 ) {

      echo '<p class="alert">Regardless of your overall score, it looks like your goals need your attention. Keep reading for more information.</p>';

    }

    echo '<div id="interpret_results"></div>';

  $scorecard_results = ob_get_clean();

  return $scorecard_results;

}

add_shortcode( 'get_grade', 'lawyerist_get_scorecard_grade' );


/*------------------------------
List Contributors
------------------------------*/

function list_contributors_shortcode() {

  global $wpdb;

  $args = array(
    'has_published_posts' => array( 'post', 'page' ),
    'exclude'             => array( 26, 32, 37 ), // Excludes Lawyerist, guest, and sponsor.
    'orderby'             => 'display_name',
    'role__in'            => array( 'Contributor' ),
  );

  $contributors = new WP_User_Query( $args );

  ob_start();

    echo '<div id="contributors-list">';

    if ( !empty( $contributors->results ) ) {

      foreach ( $contributors->results as $contributor ) {

        if ( count_user_posts( $contributor->ID ) >= 5 ) {

          echo '<div class="contributor">';
          echo '<div class="contributor-avatar">' . get_avatar( $contributor->ID, 150 ) . '</div>';
          echo '<div class="contributor-caption wp-caption-text"><a href="' . get_author_posts_url( $contributor->ID ) . '">' . $contributor->display_name . '</a></div>';
          echo '</div>';

        }

      }

    } else {

      echo 'No contributors found.';

    }

    echo '</div>';

  $contributors_list = ob_get_clean();

  return $contributors_list;

}

add_shortcode( 'list-contributors', 'list_contributors_shortcode' );


/*------------------------------
List Users
------------------------------*/

function list_users_shortcode( $atts ) {

  $atts = shortcode_atts( array(
    'membership'  => null,
    'product'     => null,
  ), $atts );

  $users = array();

  if ( $atts[ 'membership' ] ) {

    $args = array(
      'post_type'				=> 'wc_user_membership',
      'post_status'			=> 'wcm-active',
      'post_parent'			=> $atts[ 'membership' ],
      'posts_per_page'	=> -1,
    );

    $user_query = new WP_Query( $args );

    if ( $user_query->have_posts() ) :

      while ( $user_query->have_posts() ) : $user_query->the_post();

        array_push( $users, array(
          'user_id'     => get_the_ID(),
          'email'				=> get_the_author_meta( 'user_email' ),
          'first_name'	=> get_the_author_meta( 'user_firstname' ),
          'last_name'		=> get_the_author_meta( 'user_lastname' ),
          'firm_name'   => get_field( 'firm_name', 'user_' . get_the_ID() ),
          'city'        => get_user_meta( get_the_ID(), 'billing_city', true ),
          'state'       => get_user_meta( get_the_ID(), 'billing_state', true ),
        ) );

      endwhile; wp_reset_postdata();

    endif;

  }

  if ( $atts[ 'product' ] ) {

    $product_id = intval( $atts[ 'product' ] );

    $args = array(
      'fields'  => 'ID',
      'role'    => 'customer',
    );

    $customer_query = new WP_User_Query( $args );
    $customers      = $customer_query->get_results();

    if ( !empty( $customers ) ) {

      foreach ( $customers as $customer ) {

        if ( wc_customer_bought_product( '', $customer, $product_id ) ) {

          $customer_data = get_userdata( $customer );

          array_push( $users, array(
            'user_id'     => $customer,
            'email'				=> $customer_data->user_email,
            'first_name'	=> $customer_data->first_name,
            'last_name'		=> $customer_data->last_name,
            'firm_name'   => get_field( 'firm_name', 'user_' . $customer ),
            'city'        => get_user_meta( $customer, 'billing_city', true ),
            'state'       => get_user_meta( $customer, 'billing_state', true ),
          ) );

        }

      }

    }

  }

  if ( !empty( $users ) ) {

    usort( $users, function( $a, $b ) {
      return $a[ 'last_name' ] <=> $b[ 'last_name' ];
    });

    ob_start();

      ?>

      <ul class="user-list">

        <?php foreach ( $users as $user ) { ?>

          <li>

            <?php echo get_avatar( $user[ 'email' ], 100 ); ?>
            <span class="name"><?php echo $user[ 'first_name' ] . ' ' . $user[ 'last_name' ]; ?></span><br />
            <?php if ( $user[ 'firm_name' ] ) { ?><span class="firm-name"><?php echo $user[ 'firm_name' ]; ?></span><br /><?php } ?>
            <?php if ( $user[ 'city' ] && $user[ 'state' ] ) { ?><span class="address"><?php echo $user[ 'city' ]  . ', ' . $user[ 'state' ]; ?></span><br /><?php } ?>
            <span class="email"><?php echo $user[ 'email' ]; ?></span>

          </li>

        <?php } ?>

      </ul>

      <?php

    return ob_get_clean();

  } else {

    return '<p>No users found!</p>';

  }

}

add_shortcode( 'list-users', 'list_users_shortcode' );


/*------------------------------
Praise Cards
------------------------------*/

function praise_cards_shortcode() {

  ob_start();

  if ( comments_open() ) { comments_template( '/praise-cards.php' ); }

  return ob_get_clean();

}

add_shortcode( 'praise-cards', 'praise_cards_shortcode' );
