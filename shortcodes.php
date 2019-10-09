<?php

/*
Plugin Name: Lawyerist Shortcodes
Plugin URI: http://lawyerist.com
Description: A plugin with shortcodes for Lawyerist.com.
Author: Sam Glover
Version: [See README.md for changelog]
Author URI: http://samglover.net
*/

/* INDEX
- Pullquotes
- Pullouts
- Testimonials
- List Child Pages
- List Featured Products
- List All Products
- List Affinity Partners
- Get Portal Card
- Gravity Forms Conirmation Message Shortcodes
  - Get Affinity Confirmation Message
  - Get Scorecard Grade
- List Contributors
- List Labsters
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
List Featured Products
------------------------------*/

function lawyerist_featured_products_list( $atts ) {

  $parent   = get_the_ID();
  $country  = get_country();;

	// Shortcode attributes.
	$atts = shortcode_atts( array(
    'portal'  => $parent,
  ), $atts );

  // Query variables.
  $featured_products_list_query_args = array(
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

  $featured_products_list_query = new WP_Query( $featured_products_list_query_args );

  if ( $featured_products_list_query->have_posts() ) :

    ob_start();

      global $post;

      $portal_title = get_the_title( $post->ID );

      echo '<h2>Featured ' . $portal_title . '</h2>';

      echo '<ul class="product-pages-list featured-products-list">';

        // Start the Loop.
        while ( $featured_products_list_query->have_posts() ) : $featured_products_list_query->the_post();

          $featured_page_ID     = get_the_ID();
          $featured_page_title	= the_title( '', '', FALSE );
          $featured_page_URL		= get_permalink();

          $seo_descr  = get_post_meta( $featured_page_ID, '_yoast_wpseo_metadesc', true );

          if ( !empty( $seo_descr ) ) {
            $page_excerpt = $seo_descr;
          } else {
            $page_excerpt = get_the_excerpt();
          }

          // Check for a rating.
          if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

            $composite_rating = lawyerist_get_composite_rating();

          }

          echo '<li class="card">';

            if ( has_post_thumbnail() ) {

              echo '<a class="image" href="' . $featured_page_URL . '">';

                if ( has_term( 'affinity-partner', 'page_type', $post->ID ) && get_field( 'affinity_active' ) == true ) {

                  $theme_dir = get_template_directory_uri();
                  echo '<img class="affinity-partner-badge" alt="Lawyerist affinity partner badge." src="' . $theme_dir . '/images/affinity-partner-mini-badge.png" height="64" width="75" />';

                }

                the_post_thumbnail( 'thumbnail' );

              echo '</a>';

            }

            echo '<div class="title_container">';

              if ( !empty( $composite_rating ) ) {

                echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
                echo '<a class="title" href="' . $featured_page_URL . '"><span itemprop="itemReviewed">' . $featured_page_title . '</span></a>';

              } else {

                echo '<a class="title" href="' . $featured_page_URL . '">' . $featured_page_title . '</a>';

              }

              // Rating
              echo '<div class="user-rating">';

                if ( !empty( $composite_rating ) ) {

                  echo '<a href="' . $featured_page_URL . '#rating">';

                    echo lawyerist_product_rating();

                  echo '</a>';

                } else {

                  echo '<a href="' . $featured_page_URL . '#respond">Leave a review.</a>';

                }

              echo '</div>'; // End .user_rating.

              if ( !empty( $composite_rating ) ) {
                echo '</div>'; // End aggregateRating schema.
              }

            echo '</div>'; // End .title_container.

            if ( ( $country == ( 'US' || 'CA' ) ) && has_trial_button( $featured_page_ID ) ) {

              echo '<div class="list-products-trial-button">';
                echo  trial_button( $featured_page_ID );
              echo '</div>';

            }

            echo '<div class="clear"></div>';

            echo '<span class="excerpt">' . $page_excerpt . ' <a href="' . $featured_page_URL . '">Learn more about ' . $featured_page_title . '.</a></span>';

          echo '</li>';

        endwhile; wp_reset_postdata();

  		echo '</ul>';

    $featured_products = ob_get_clean();

	endif; // End product list.

  return $featured_products;

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

  // Query variables.
	$product_list_query_args = array(
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

	$product_list_query = new WP_Query( $product_list_query_args );

	if ( $product_list_query->post_count > 0 ) :

    ob_start();

      global $post;

      if ( $atts[ 'show_heading' ] == 'true' ) {

        $portal_title = get_the_title( $post->ID );

        echo '<h2>' . $portal_title . ' (Alphabetical List)</h2>';

      }

  		echo '<ul class="product-pages-list">';

  			// Start the Loop.
  			while ( $product_list_query->have_posts() ) : $product_list_query->the_post();

          $product_page_ID    = get_the_ID();
  				$product_page_title	= the_title( '', '', FALSE );
  				$product_page_URL		= get_permalink();

          $seo_descr  = get_post_meta( $product_page_ID, '_yoast_wpseo_metadesc', true );

          if ( !empty( $seo_descr ) ) {
            $page_excerpt = $seo_descr;
          } else {
            $page_excerpt = get_the_excerpt();
          }

          // Check for a rating.
          if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

          	$composite_rating = lawyerist_get_composite_rating();

          }

  				echo '<li ';
          post_class( 'card' );
          echo '>';

  					if ( has_post_thumbnail() ) {

  						echo '<a class="image" href="' . $product_page_URL . '">';

                if ( has_term( 'affinity-partner', 'page_type', $post->ID ) && get_field( 'affinity_active' ) == true ) {

                  $theme_dir = get_template_directory_uri();
                  echo '<img class="affinity-partner-badge" alt="Lawyerist affinity partner badge." src="' . $theme_dir . '/images/affinity-partner-mini-badge.png" height="64" width="75" />';

                }

    						the_post_thumbnail( 'thumbnail' );

  						echo '</a>';

  					}

            echo '<div class="title_container">';

              if ( !empty( $composite_rating ) ) {

                echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
                echo '<a class="title" href="' . $product_page_URL . '"><span itemprop="itemReviewed">' . $product_page_title . '</span></a>';

              } else {

                echo '<a class="title" href="' . $product_page_URL . '">' . $product_page_title . '</a>';

              }

              // Rating
              echo '<div class="user-rating">';

                if ( !empty( $composite_rating ) ) {

                  echo '<a href="' . $product_page_URL . '#rating">';

                    echo lawyerist_product_rating();

                  echo '</a>';

                } else {

                  echo '<a href="' . $product_page_URL . '#respond">Leave a review.</a>';

                }

              echo '</div>'; // End .user_rating.

              if ( !empty( $composite_rating ) ) {
                echo '</div>'; // End aggregateRating schema.
              }

            echo '</div>'; // End .title_container.

            // Outputs trial button if there is one, except on the all-reviews page.
            if ( !is_page( '301729' ) ) {

              if ( ( $country == ( 'US' || 'CA' ) ) && has_trial_button( $product_page_ID ) ) {

                echo '<div class="list-products-trial-button">';
                  echo  trial_button( $product_page_ID );
                echo '</div>';

              }

            }

  					echo '<div class="clear"></div>';

  					if ( $atts[ 'show_excerpt' ] == 'true' ) { echo '<span class="excerpt">' . $page_excerpt . ' <a href="' . $product_page_URL . '">Learn more about ' . $product_page_title . '.</a></span>'; }

  				echo '</li>';

  			endwhile; wp_reset_postdata();

  		echo '</ul>';

    $all_products = ob_get_clean();

	endif; // End product list.

  return $all_products;

}

add_shortcode( 'list-products', 'lawyerist_all_products_list' );


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

          echo '<h3>' . get_the_title( $portal_ID ) . '</h3>';

      		echo '<ul class="product-pages-list">';

      			// Start the Loop.
      			while ( $affinity_partner_list_query->have_posts() ) : $affinity_partner_list_query->the_post();

              $product_page_ID    = get_the_ID();
      				$product_page_title	= the_title( '', '', FALSE );
      				$product_page_URL		= get_permalink();

              $seo_descr  = get_post_meta( $product_page_ID, '_yoast_wpseo_metadesc', true );

              if ( !empty( $seo_descr ) ) {
                $page_excerpt = $seo_descr;
              } else {
                $page_excerpt = get_the_excerpt();
              }

              // Check for a rating.
              if ( comments_open() && function_exists( 'wp_review_show_total' ) ) {

              	$composite_rating = lawyerist_get_composite_rating();

              }

      				echo '<li ';
              post_class( 'card' );
              echo '>';

      					if ( has_post_thumbnail() ) {

      						echo '<a class="image" href="' . $product_page_URL . '">';

                    if ( has_term( 'affinity-partner', 'page_type', $post->ID ) && get_field( 'affinity_active' ) == true ) {

                      $theme_dir = get_template_directory_uri();
                      echo '<img class="affinity-partner-badge" alt="Lawyerist affinity partner badge." src="' . $theme_dir . '/images/affinity-partner-mini-badge.png" height="64" width="75" />';

                    }

        						the_post_thumbnail( 'thumbnail' );

      						echo '</a>';

      					}

                echo '<div class="title_container">';

                  if ( !empty( $composite_rating ) ) {

                    echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';
                    echo '<a class="title" href="' . $product_page_URL . '"><span itemprop="itemReviewed">' . $product_page_title . '</span></a>';

                  } else {

                    echo '<a class="title" href="' . $product_page_URL . '">' . $product_page_title . '</a>';

                  }

                  // Rating
                  echo '<div class="user-rating">';

                    if ( !empty( $composite_rating ) ) {

                      echo '<a href="' . $product_page_URL . '#rating">';

                        echo lawyerist_product_rating();

                      echo '</a>';

                    } else {

                      echo '<a href="' . $product_page_URL . '#respond">Leave a review.</a>';

                    }

                  echo '</div>'; // End .user_rating.

                  if ( !empty( $composite_rating ) ) {
                    echo '</div>'; // End aggregateRating schema.
                  }

                echo '</div>'; // End .title_container.

      					echo '<span class="excerpt">' . $page_excerpt . ' <a href="' . $product_page_URL . '">Learn more about ' . $product_page_title . '.</a></span>';

      				echo '</li>';

      			endwhile; wp_reset_postdata();

      		echo '</ul>';

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
List Labsters
------------------------------*/

function list_labsters_shortcode() {

  $labsters = get_active_labsters();

  if ( !empty( $labsters ) ) {

    ob_start();

      echo '<ul id="labsters">';

        foreach ( $labsters as $labster ) {

          echo '<li class="labster">';

            // echo get_avatar( $labster[ 'email' ], 100 );
            echo '<span class="labster-name">' . $labster[ 'last_name' ] . ', ' . $labster[ 'first_name' ] . '</span> <span class="labster-email">(' . $labster[ 'email' ] . ')</span>';

          echo '</li>';

        }

      echo '</ul>';

    $labsters_list = ob_get_clean();

    return $labsters_list;

  } else {

    return '<p>No Labsters found!</p>';

  }

}

add_shortcode( 'list-labsters', 'list_labsters_shortcode' );
