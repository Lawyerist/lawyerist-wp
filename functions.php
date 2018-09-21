<?php

/* INDEX

SETUP
- Stylesheets & Scripts
- Theme Setup

STRUCTURE
- Nav Menu
- Sidebar

ADMIN
- Login Form

UTILITY FUNCTIONS
- Get Country

CONTENT
- Query Mods
- Archive Headers
- Yoast SEO Breadcrumbs
- Postmeta
- Author Bios
- Custom Default Gravatar
- Sponsored Product Updates Widget
- Get Related Podcasts
- Get Related Posts
- Get Related Pages
- Current Posts Widget
- Scorecard Call to Action
- Ads
- Trial Buttons
- Mobile Ads
- Add Image Sizes
- Remove Inline Width from Image Captions
- Featured Images in RSS Feeds
- Remove Hidden Products from RSS Feed
- Remove Default Gallery Styles

COMMENTS & REVIEWS
- Show Commenter's First Name & Initial
- Get Number of Reviews

WOOCOMMERCE
- WooCommerce Setup
- Function for Checking to See if a Product ID is in the Cart
- Checkout Fields
- Insider Plus Shopping Cart Upsell
- Check to See if Page is Really a WooCommerce Page

TAXONOMY
- Page Type Custom Taxonomy
- Series Custom Taxonomy
- Sponsors Custom Taxonomy

PATCHES
- RSS Feed Caching

*/


/* SETUP **********************/

/*------------------------------
Stylesheets & Scripts
------------------------------*/

function lawyerist_stylesheets_scripts() {

	// Normalize the default styles. From https://github.com/necolas/normalize.css/
	wp_register_style( 'normalize-css', get_template_directory_uri() . '/normalize.min.css' );
	wp_enqueue_style( 'normalize-css' );

	// Load the stylesheet, with a cachebuster.
	$cacheBusterCSS = filemtime( get_stylesheet_directory() . '/style.css' );
	wp_register_style( 'stylesheet', get_template_directory_uri() . '/style.css', array(), $cacheBusterCSS, 'all' );
	wp_enqueue_style( 'stylesheet' );

	// Load the comment-reply script, but only if we're on a single page and comments are open and threaded.
	if ( !is_admin() && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load consolidated scripts in the header. NOT CURRENTLY IN USE.
	// $cacheBusterMC = filemtime( get_stylesheet_directory() . '/js/header-scripts.js' );
	// wp_register_script( 'header-scripts', get_template_directory_uri() . '/js/header-scripts.js', '', $cacheBusterMC );
	// wp_enqueue_script( 'header-scripts' );

	// Load consolidated scripts in the footer.
	$cacheBusterMC = filemtime( get_stylesheet_directory() . '/js/footer-scripts.js' );
	wp_register_script( 'footer-scripts', get_template_directory_uri() . '/js/footer-scripts.js', '', $cacheBusterMC, true );
	wp_enqueue_script( 'footer-scripts' );

}

add_action( 'wp_enqueue_scripts', 'lawyerist_stylesheets_scripts' );


/*------------------------------
Theme Setup
------------------------------*/

function lawyerist_theme_setup() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form' ) );

}

add_action( 'after_setup_theme', 'lawyerist_theme_setup' );


/* STRUCTURE ******************/

/*------------------------------
Nav Menu
------------------------------*/

function lawyerist_register_menus() {

	register_nav_menus(
		array(
			'header-nav-menu' => 'Header Nav Menu'
		)
	);

}

add_action( 'init','lawyerist_register_menus' );


function lawyerist_loginout( $items, $args ) {

  	if ( is_user_logged_in() && $args->theme_location == 'header-nav-menu' ) {
        $items .= '<li class="menu-item menu-item-loginout"><a href="https://lawyerist.com/account/">Account</a></li>';
    } elseif ( !is_user_logged_in() && $args->theme_location == 'header-nav-menu' ) {
        $items .= '<li class="menu-item menu-item-loginout"><a href="https://lawyerist.com/account/">Log In</a></li>';
    }

    return $items;

}

add_filter( 'wp_nav_menu_items', 'lawyerist_loginout', 10, 2 );


/*------------------------------
Sidebar
------------------------------*/

function lawyerist_register_sidebars()  {

	$sidebar_args = array(
		'id'            => 'sidebar',
		'name'          => 'Sidebar',
		'description'   => 'Widgets start below the ads. Not visible on mobile.',
		'class'         => 'sidebar',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	);
	register_sidebar( $sidebar_args );

}

add_action( 'widgets_init', 'lawyerist_register_sidebars' );

// Enable shortcodes in text widgets
add_filter( 'widget_text', 'do_shortcode' );



/* ADMIN ********************/

/*------------------------------
Login Form
------------------------------*/

function lawyerist_login_logo() { ?>

	<style type="text/css">

		#login h1 a, .login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/L-dot-login.png);
		}

	</style>

<?php }

function lawyerist_login_logo_url() {
    return home_url();
}

function lawyerist_login_logo_url_title() {
    return 'Lawyerist.com';
}

function lawyerist_login_message( $message ) {
    if ( empty($message) ){
        return '<p>Don\'t have an account yet? <a href="https://lawyerist.com/insider/">Click here to join the Lawyerist Insider today (it\'s free)!</a></p>';
    } else {
        return $message;
    }
}

add_action( 'login_enqueue_scripts', 'lawyerist_login_logo' );
add_filter( 'login_headerurl', 'lawyerist_login_logo_url' );
add_filter( 'login_headertitle', 'lawyerist_login_logo_url_title' );
add_filter( 'login_message', 'lawyerist_login_message' );


/* UTILITY FUNCTIONS ********************/

/*------------------------------
Get Country
------------------------------*/

function get_country() {

	// Limits API calls to product pages, not portals (i.e., child pages only).
	if ( has_trial_button() || ( get_page_template_slug( $post->ID ) == 'product-page.php' && $post->post_parent == 0 ) ) {

		// Get user's geographic location by IP address.
		// Set IP address and API access key.
		$ip = $_SERVER['REMOTE_ADDR'];
		$access_key = '55e08636154002dca5b45f0920143108';

		// Initialize CURL.
		$ch = curl_init( 'http://api.ipstack.com/' . $ip . '?access_key=' . $access_key . '' );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		// Store the data.
		$json = curl_exec( $ch );
		curl_close( $ch );

		// Decode JSON response.
		$api_result = json_decode( $json, true );

		// Return the country code (i.e., "US" or "CA").
		return $api_result['country_code'];

	}

}


/* CONTENT ********************/

/*------------------------------
Query Mods
------------------------------*/

function lawyerist_query_mods( $wp_query ) {

	// Exclude sponsored posts from the front page.
	if ( is_front_page() ) {
		set_query_var( 'category__not_in', array( 1320 ) );
	}

	// Add pages and products to the main feed, and pages to author feeds.
	if ( !is_admin() && !is_author() ) {
		set_query_var( 'post_type', array( 'post', 'page', 'product' ) );
	} elseif ( is_author() ) {
		set_query_var( 'post_type', array( 'post', 'page' ) );
	}

	// If displaying a series archive page, show the oldest post first.
	if ( !is_admin() && is_tax( 'series' ) ) {
		set_query_var( 'order', 'ASC' );
	}

}

add_action( 'pre_get_posts', 'lawyerist_query_mods' );


/*------------------------------
Archive Headers
------------------------------*/

function lawyerist_get_archive_header() {

	// Display the author header if we're on an author page.
	if ( is_author() ) {

		lawyerist_get_author_bio();

	}

	// Display the archive header if we're on an archive page (but not on an author page).
	if ( is_archive() && !is_author() ) {

		$title = single_term_title( '', FALSE );
		$descr = term_description();

		echo '<div id="archive_header"><h1>' . $title . '</h1>' . "\n";
		echo $descr . "\n";
		echo '</div>';

	}

	// Display the search header if we're on a search page.
	if ( is_search() ) {

		echo '<div id="archive_header"><h1>Search results for "' . get_search_query() . '"</h1></div>';
		echo '<div id="lawyerist_content_search">';
			get_search_form();
		echo '</div>';

	}

}


/*------------------------------
Yoast SEO Breadcrumbs
------------------------------*/

function lawyerist_remove_products_breadcrumb($link_output, $link ){

	if( is_really_a_woocommerce_page() && $link['text'] == 'Products' ) {
		$link_output = '';
	}

	return $link_output;

}

add_filter( 'wpseo_breadcrumb_single_link' ,'lawyerist_remove_products_breadcrumb', 10 ,2 );


/*------------------------------
Postmeta
------------------------------*/

function lawyerist_postmeta() {

	if ( is_home() || is_archive() || is_search() ) {

		get_template_part( 'postmeta', 'index' );

	} elseif ( is_single() ) {

		get_template_part( 'postmeta', 'single' );

	}

}


/*------------------------------
Author Bios
------------------------------*/

function lawyerist_get_author_bio() {

	$author               = $wp_query->query_vars['author'];
	$author_name          = get_the_author_meta( 'display_name' );
	$author_bio           = get_the_author_meta( 'description' );
	$author_website       = get_the_author_meta( 'user_url' );
	$parsed_url           = parse_url( $author_website );
	$author_nice_website  = $parsed_url['host'];
	$author_twitter       = get_the_author_meta( 'twitter' );
	$author_avatar_sm     = get_avatar( get_the_author_meta( 'user_email' ), 100, '', $author_name );
	$author_avatar_lg     = get_avatar( get_the_author_meta( 'user_email' ), 300, '', $author_name );


	if ( is_single() ) {

		echo '<div id="author_bio_footer">' . "\n";
		echo $author_avatar_sm;

	} elseif ( is_author() ) {

		echo '<div id="author_header">' . "\n";
		echo $author_avatar_lg;
		echo '<h1>' . $author_name . '</h1>' . "\n";

	}

	echo '<div id="author_bio">' . $author_bio . '</div>';

	// Show links to the author's website and Twitter and LinkedIn profiles.
	echo '<div id="author_connect">';
		if ( $author_twitter == true ) {
			echo '<p class="author_twitter"><a href="https://twitter.com/' . $author_twitter . '">@' . $author_twitter . '</a></p>';
		}
		if ( $author_website == true ) {
			echo '<p class="author_website"><a href="' . $author_website . '">' . $author_nice_website . '</a></p>';
		}
	echo '</div>'; // Close #author_connect.

	echo '</div>'; // End author bio.

}


/*------------------------------
Custom Default Gravatar
------------------------------*/

function lawyerist_custom_gravatar ( $avatar_defaults ) {

	$lawyerist_avatar = get_bloginfo('template_directory') . '/images/lawyerist-default-gravatar.png';
	$avatar_defaults[ $lawyerist_avatar ] = "Lawyerist.com Logo";

	return $avatar_defaults;

}

add_filter( 'avatar_defaults', 'lawyerist_custom_gravatar' );


/*------------------------------
Sponsored Product Updates Widget
------------------------------*/

function lawyerist_sponsored_product_updates() {

	// Product Updates
	$product_updates_query_args = array(
		'tax_query' => array(
			'relation' => 'OR',
			// Posts with the "Sponsored Posts" category.
			array(
				'taxonomy' => 'category',
				'terms'    => array( 1320 ),
			),
			// Posts with the "product spotlight" tag.
			array(
				'taxonomy' => 'post_tag',
				'terms'    => array( 4077 ),
			),
		),
		'ignore_sticky_posts' => TRUE,
		'posts_per_page'			=> 4, // Determines how many posts are displayed in the list.
	);

	$product_updates_query = new WP_Query( $product_updates_query_args );

	if ( $product_updates_query->post_count > 1 ) :

		echo '<div id="sponsored_product_updates">';

			echo '<div class="product_updates_heading">Product Updates</div>';

			echo '<ul>';

				// Start the product updates sub-Loop.
				while ( $product_updates_query->have_posts() ) : $product_updates_query->the_post();

					$product_update_title = the_title( '', '', FALSE );
					$product_update_ID = get_the_ID();

					if ( has_term( true, 'sponsor' ) ) {

				    $sponsor_IDs = wp_get_post_terms(
				      $product_update_ID,
				      'sponsor',
				      array(
				        'fields' 	=> 'ids',
				        'orderby' => 'count',
				        'order' 	=> 'DESC',
				      )
				    );

				    $sponsor_info = get_term( $sponsor_IDs[0] );
				    $sponsor      = $sponsor_info->name;
				    $sponsor_url  = $sponsor_info->description;

						if ( !empty( $sponsor_url ) ) {

							echo '<li><a href="' . $sponsor_url . '" title="' . $product_update_title . '" class="product_update">' . $product_update_title . '</a></li>';

						} else {

							echo '<li>' . $product_update_title . '</li>';

						}

					}

				endwhile;

				wp_reset_postdata();

			echo '</ul>';

			echo '<div class="clear"></div>';

		echo '</div>'; // Close #sponsored_product_updates.

	endif; // End product updates.

}

/*------------------------------
Get Related Podcasts
------------------------------*/

function lawyerist_get_related_podcasts() {

	// Use global post if it wasn't provided.
	if ( !is_a( $post, 'WP_Post' ) ) {
		global $post;
	}

	$current_id[]		= $post->ID;
	$current_slug		= $post->post_name;
	$current_title	= $post->post_title;

	$lawyerist_related_podcasts_query_args = array(
		'category_name'			=> 'lawyerist-podcast',
		'category__not_in'	=> array(
			1320, // Excludes sponsored posts.
		),
		'post__not_in'		=> $current_id,
		'posts_per_page'	=> -1,
		'tag' 						=> $current_slug,
		'tag__not_in'			=> array(
			4077, // Excludes product spotlights.
		),
	);

	$lawyerist_related_podcasts_query = new WP_Query( $lawyerist_related_podcasts_query_args );

	if ( $lawyerist_related_podcasts_query->have_posts() ) :

		echo '<div id="related_podcasts">';
		echo '<h2>Podcasts About ' . $current_title . '</h2>';

			// Start the Loop.
			while ( $lawyerist_related_podcasts_query->have_posts() ) : $lawyerist_related_podcasts_query->the_post();

				$post_title			= the_title( '', '', FALSE );
				$post_url				= get_permalink();
				$post_excerpt   = get_the_excerpt();
				$seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );

				$author_name		= get_the_author_meta( 'display_name' );
				$author_avatar	= get_avatar( get_the_author_meta( 'user_email' ), 150, '', $author_name );

				// Sets the post excerpt to the Yoast Meta Description if there is one.
				if ( !empty( $seo_descr ) ) { $post_excerpt = $seo_descr; }

				echo '<div ' ;
				post_class( 'index_post_container' );
				echo '>';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $post_url . '" title="' . $post_title . '">';

						echo '<div class="headline_excerpt">';

							// Gets the first image, or a default.
							$first_img = '';
								ob_start();
								ob_end_clean();
								$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
								$avatar_url = $matches[1][0];

							if ( empty( $avatar_url ) ) {
								$avatar_url = '	https://lawyerist.com/lawyerist/wp-content/uploads/2018/09/podcast-mic-square-150x150.png';
							}

							echo '<div class="author_avatar"><img class="avatar" src="' . $avatar_url . '" /></div>';

							echo '<h2 class="headline" title="' . $post_title . '">' . $post_title . '</h2>';

							echo '<p class="excerpt">' . $post_excerpt . '</p>';

							get_template_part( 'postmeta', 'index' );

							// Clearfix
							echo '<div class="clear"></div>';

						echo '</div>'; // Close .headline_excerpt.

					echo '</a>'; // This closes the link container.

				echo '</div>'; // This closes .index_post_container.

			endwhile;

			echo '<div class="clear"></div>';

		echo '</div>';

	endif;

	wp_reset_postdata();

}


/*------------------------------
Get Related Posts
------------------------------*/

function lawyerist_get_related_posts() {

	// Use global post if it wasn't provided.
	if ( !is_a( $post, 'WP_Post' ) ) {
		global $post;
	}

	$current_id[]		= $post->ID;
	$current_slug		= $post->post_name;
	$current_title	= $post->post_title;

	$lawyerist_related_posts_query_args = array(
		'category__not_in'	=> array(
			1320, // Excludes sponsored posts.
			4183, // Excludes podcast episodes.
		),
		'post__not_in'		=> $current_id,
		'posts_per_page'	=> -1,
		'tag' 						=> $current_slug,
		'tag__not_in'			=> array(
			4077, // Excludes product spotlights.
		),
	);

	$lawyerist_related_posts_query = new WP_Query( $lawyerist_related_posts_query_args );

	if ( $lawyerist_related_posts_query->have_posts() ) :

		echo '<div id="related_posts">';
		echo '<h2>Posts About ' . $current_title . '</h2>';

			while ( $lawyerist_related_posts_query->have_posts() ) : $lawyerist_related_posts_query->the_post();

				$post_title			= the_title( '', '', FALSE );
				$post_url				= get_permalink();
				$post_excerpt   = get_the_excerpt();
				$seo_descr      = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );

				$author_name		= get_the_author_meta( 'display_name' );
				$author_avatar	= get_avatar( get_the_author_meta( 'user_email' ), 150, '', $author_name );

				// Sets the post excerpt to the Yoast Meta Description.
				if ( !empty( $seo_descr ) ) { $post_excerpt = $seo_descr; }

				// Starts the post container.
				echo '<div ' ;
				post_class( 'index_post_container' );
				echo '>';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $post_url . '" title="' . $post_title . '">';

						echo '<div class="headline_excerpt">';

							// Outputs the author's avatar.
							echo '<div class="author_avatar">' . $author_avatar . '</div>';

							// Headline
							echo '<h2 class="headline">' . $post_title . '</h2>';

							echo '<p class="excerpt">' . $post_excerpt . '</p>';

							get_template_part( 'postmeta', 'index' );

							// Clearfix
							echo '<div class="clear"></div>';

						echo '</div>'; // Close .headline_excerpt.

					echo '</a>'; // This closes the post link container (.post).

				echo '</div>';

			endwhile;

			echo '<div class="clear"></div>';

		echo '</div>';

	endif;

	wp_reset_postdata();

}


/*------------------------------
Get Related Pages
------------------------------*/


function lawyerist_get_related_pages() {

	// Use global post if it wasn't provided.
	if ( !is_a( $post, 'WP_Post' ) ) {
		global $post;
	}

	$current_id[]				= $post->ID;
	$current_tags				= get_the_tags( $post->ID );
	$current_tags_slugs	= array();

	if ( $current_tags ) {
		foreach( $current_tags as $current_tag ) {
			array_push( $current_tags_slugs, $current_tag->slug );
		}
	}

	var_dump( $current_tags );

	echo '<p>…</p>';

	var_dump( $current_tags_slugs );

	$lawyerist_related_pages_query_args = array(
		'post__not_in'		=> $current_id,
		'posts_per_page'	=> -1,
		'post_type'				=> 'page',
		'tag_slug__in' 		=> $current_tags_slugs,
		'tag__not_in'			=> array(
			4077, // Excludes product spotlights.
		),
	);

	$lawyerist_related_pages_query = new WP_Query( $lawyerist_related_pages_query_args );

	if ( $lawyerist_related_pages_query->have_posts() ) :

		echo '<div id="related_pages">';
		echo '<h2>More Resources</h2>';

			while ( $lawyerist_related_pages_query->have_posts() ) : $lawyerist_related_pages_query->the_post();

				$post_title			= the_title( '', '', FALSE );
				$post_url				= get_permalink();

				// Sets the post excerpt to the Yoast Meta Description.
				if ( !empty( $seo_descr ) ) { $post_excerpt = $seo_descr; }

				// Starts the post container.
				echo '<div ' ;
				post_class( 'index_post_container' );
				echo '>';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $post_url . '" title="' . $post_title . '">';

						if ( has_post_thumbnail() ) {
              the_post_thumbnail( 'thumbnail' );
            } else {
              echo '<img class="attachment-thumbnail wp-post-image" src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/L-dot.png" />';
            }

						echo '<div class="headline_excerpt">';
							echo '<h2 class="headline" title="' . $post_title . '">' . $post_title . '</h2>';
						echo '</div>'; // Close .headline_excerpt.

						echo '<div class="clear"></div>';

					echo '</a>'; // This closes the post link container (.post).

				echo '</div>';

			endwhile;

			echo '<div class="clear"></div>';

		echo '</div>';

	endif;

	wp_reset_postdata();

}


/*------------------------------
Current Posts Widget
------------------------------*/

function lawyerist_current_posts( $this_post ) {

	// Use global post if it wasn't provided.
	if ( !is_a( $post, 'WP_Post' ) ) {
		global $post;
	}

	$this_post[] = $post->ID;

	echo '<div id="current_posts">';

		echo '<div class="current_posts_heading"><a href="' . home_url() . '">What\'s New</a></div>';

			// Outputs the most recent podcast episode.
			$current_podcast_query_args = array(
				'category_name'				=> 'lawyerist-podcast',
				'ignore_sticky_posts' => TRUE,
				'posts_per_page'			=> 1,
				'post__not_in'				=> $this_post,
			);

			$current_podcast_query = new WP_Query( $current_podcast_query_args );

			if ( $current_podcast_query->have_posts() ) : while ( $current_podcast_query->have_posts() ) : $current_podcast_query->the_post();

				$podcast_title	= the_title( '', '', FALSE );
				$podcast_url		= get_permalink();

				echo '<a href="' . $podcast_url . '" title="' . $podcast_title . '" class="current_post">';

					echo '<img class="attachment-thumbnail wp-post-image" src="https://lawyerist.com/lawyerist-dev/wp-content/uploads/2018/02/lawyerist-ltn-podcast-logo-16x9-160x90.png" />';

					echo '<p class="current_post_title">' . $podcast_title . '</p>';

				echo '</a>';

			endwhile; endif;
			// End of podcast episode.

			// Outputs the most recent download.
			$download_query_args = array(
				'post_type'						=> 'product',
				'ignore_sticky_posts' => TRUE,
				'posts_per_page'			=> 1,
				'post__not_in'				=> $this_post,
				'tax_query'						=> array(
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'exclude-from-catalog',
						'operator' => 'NOT IN',
					),
				),
			);

			$download_query = new WP_Query( $download_query_args );

			if ( $download_query->have_posts() ) : while ( $download_query->have_posts() ) : $download_query->the_post();

				$download_title	= the_title( '', '', FALSE );
				$download_url		= get_permalink();

				echo '<a href="' . $download_url . '" title="' . $download_title . '" class="current_post">';

					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'current_posts_thumbnail' );
					} else {
						echo '<img class="attachment-thumbnail wp-post-image" src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/current-posts-placeholder-160x90.png" />';
					}

					echo '<p class="current_post_title">' . $download_title . '</p>';

				echo '</a>';

			endwhile; endif;
			// End of download.

			// Outputs the most recent community post.
			$current_post_query_args = array(
				'category_name'				=> 'community-posts',
				'ignore_sticky_posts' => TRUE,
				'posts_per_page'			=> 1,
				'post__not_in'				=> $this_post,
			);

			$current_post_query = new WP_Query( $current_post_query_args );

			if ( $current_post_query->have_posts() ) : while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

				$post_title	= the_title( '', '', FALSE );
				$post_url		= get_permalink();

				echo '<a href="' . $post_url . '" title="' . $post_title . '" class="current_post">';

					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'current_posts_thumbnail' );
					} else {
						echo '<img class="attachment-thumbnail wp-post-image" src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/current-posts-placeholder-160x90.png" />';
					}

					echo '<p class="current_post_title">' . $post_title . '</p>';

				echo '</a>';

			endwhile; endif;
			// End of community post.

			// Outputs the most recent portal.
			$current_post_query_args = array(
				'post_parent'					=> 0,
				'post_type'						=> 'page',
				'posts_per_page'			=> 1,
				'post__not_in'				=> $this_post,
			);

			$current_post_query = new WP_Query( $current_post_query_args );

			if ( $current_post_query->have_posts() ) : while ( $current_post_query->have_posts() ) : $current_post_query->the_post();

				$post_title	= the_title( '', '', FALSE );
				$post_url		= get_permalink();

				echo '<a href="' . $post_url . '" title="' . $post_title . '" class="current_post">';

					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'current_posts_thumbnail' );
					} else {
						echo '<img class="attachment-thumbnail wp-post-image" src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/current-posts-placeholder-160x90.png" />';
					}

					echo '<p class="current_post_title">' . $post_title . '</p>';

				echo '</a>';

			endwhile; endif;
			// End of portal.

		echo '<div class="clear"></div>';

	echo '</div>'; // Close #current_posts.

	wp_reset_postdata(); // Necessary because otherwise comments will not display.

}


/*------------------------------
Scorecard Call to Action
------------------------------*/

function scorecard_cta() {
?>

	<div id="big_hero_cta">
		<div class="index_post_container">
			<a class="big_hero_top" href="https://lawyerist.com/scorecard/">
				<div class="scorecard_image_wrapper"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/05/scorecard-thumbnail.png" alt="The Small Firm Scorecard example graphic." /></div>
				<div class="scorecard_prompt_wrapper">
					<h2>The Small Firm Scorecard<sup>TM</sup></h2>
					<p>Is your law firm structured to succeed in the future?</p>
				</div>
				<div class="clear"></div>
			</a>
			<p class="big_hero_p">The practice of law is changing. You need to understand whether your firm is positioned for success in the coming years. Our free Small Firm Scorecard will identify your firm’s strengths and weaknesses in just a few minutes.</p>
			<div class="big_hero_button"><a class="button" href="https://lawyerist.com/scorecard/">Get Your Free Score</a></div>
		</div>
	</div>

<?php
}

/*------------------------------
Ads
------------------------------*/

function lawyerist_get_display_ad() { ?>

	<div id="lawyerist_display_ad" class="lawyerist_display_ad_in_sidebar">
		<div id='div-gpt-ad-1516051566911-0' style='height:250px; width:300px;'>
			<script>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1516051566911-0'); });
				// Set timer to refresh the display ad slot every 30 seconds
				setInterval(function(){googletag.pubads().refresh();}, 30000);
			</script>
		</div>
	</div>

<?php }


/*------------------------------
Trial Buttons
Adds trial buttons to product pages.
------------------------------*/

function lawyerist_sponsored_trial_button( $content ) {

	// Use global post if it wasn't provided.
	if ( !is_a( $post, 'WP_Post' ) ) {
		global $post;
	}

	$country = get_country();

	if ( has_trial_button() && $country == ( 'US' || 'CA' ) && is_main_query() ) {

		$p_close			= '</p>';
		$paragraphs 	= explode( $p_close, $content );
		$trial_button	= trial_button();

		foreach ( $paragraphs as $p_num => $paragraph ) {

			// Only add closing tag to non-empty paragraphs
			if ( trim( $paragraph ) ) {
				// Adding closing markup now, rather than at implode, means insertion
				// is outside of the paragraph markup, and not just inside of it.
				$paragraphs[$p_num] .= $p_close;
			}

			// Insert DFP code after 1st paragraph (0 is paragraph #1).
			if ( $p_num == 0 ) {
				$paragraphs[$p_num] .= '<p align="center">' . $trial_button . '</p>' . "\n" . '<!-- Country is ' . $country .  '-->';
			}

		}

		$content = implode( '', $paragraphs );
		$content .= '<p align="center">' . $trial_button . '</p>';

	}

	return $content;

}

add_filter( 'the_content', 'lawyerist_sponsored_trial_button' );


/*------------------------------
Mobile Ads
------------------------------*/

// Inserts the mobile ad on single posts and pages.

function lawyerist_mobile_display_ad( $content ) {

	if ( is_mobile() && is_single() && is_main_query() && !is_page_template( 'product-page.php' ) ) {

		$p_close		= '</p>';
		$paragraphs = explode( $p_close, $content );

		ob_start();
			echo lawyerist_get_display_ad();
		$display_ad = ob_get_clean();

		foreach ( $paragraphs as $p_num => $paragraph ) {

			// Only add closing tag to non-empty paragraphs
			if ( trim( $paragraph ) ) {
				// Adding closing markup now, rather than at implode, means insertion
				// is outside of the paragraph markup, and not just inside of it.
				$paragraphs[$p_num] .= $p_close;
			}

			// Insert DFP code after 3rd paragraph
			// (0 is paragraph #1 in the $paragraphs array)
			if ( $p_num == 2 ) {
				$paragraphs[$p_num] .= $display_ad;
			}

		}

		$content = implode( '', $paragraphs );

	}

	return $content;

}

add_filter( 'the_content', 'lawyerist_mobile_display_ad' );


/*------------------------------
Add Image Sizes
------------------------------*/

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'default_thumbnail', 300, 250, true ); // The default thumbnail in index lists.
	add_image_size( 'standard_thumbnail', 684, 385, true ); // For the full-sized featured image on single posts and pages.
	add_image_size( 'current_posts_thumbnail', 160, 90, true ); // For the current-posts footer on single post pages.
}


/*------------------------------
Remove Inline Width from Image Captions
------------------------------*/

function lawyerist_remove_caption_padding( $width ) {

	return $width - 10;

}

add_filter( 'img_caption_shortcode_width', 'lawyerist_remove_caption_padding' );


/*------------------------------
Featured Images in RSS Feeds
------------------------------*/

function featuredtoRSS( $content ) {

	global $post;

	if ( has_post_thumbnail( $post->ID ) ) {
		$content = '' . get_the_post_thumbnail( $post->ID, 'featured_top', array( 'style' => 'display:block;height:auto;margin:0 0 15px 0;width:560px;' ) ) . '' . $content;
	}

	return $content;

}

add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');


/*------------------------------
Remove Hidden Products from RSS Feed
------------------------------*/

function lawyerist_remove_hidden_products_from_feed( $query ) {

	if ( $query->is_feed() ) {

		$query->set( 'post_type', array( 'post', 'product' ) );
		$query->set( 'tax_query', array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			),
		) );

	}

	return $query;

}

add_filter( 'pre_get_posts', 'lawyerist_remove_hidden_products_from_feed' );


/*------------------------------
Remove Default Gallery Styles
------------------------------*/

add_filter( 'use_default_gallery_style', '__return_false' );


/* COMMENTS & REVIEWS *********/

/*------------------------------
Show Commenter's First Name & Initial
------------------------------*/

function lawyerist_comment_author_name( $author = '' ) {

	// Get the comment ID from WP_Query
	$comment = get_comment( $comment_ID );

	if ( !empty( $comment->comment_author ) ) {

		if ( !empty( $comment->user_id ) ) {

			$user		= get_userdata( $comment->user_id );
			$author	= $user->first_name . ' ' . $user->last_name;

		} else {

				$author	= $comment->comment_author;

		}

	} else {

		$author = __('Anonymous');

	}

	return $author;

}

add_filter( 'get_comment_author', 'lawyerist_comment_author_name', 10, 1 );


/*------------------------------
Get Number of Reviews
------------------------------*/

function lawyerist_get_review_count() {

	global $post;

	$page_title		= the_title( '', '', FALSE );
	$rating				= get_post_meta( $post->ID, 'wp_review_comments_rating_value', true );
	$review_count	= get_post_meta( $post->ID, 'wp_review_comments_rating_count', true );

	if ( empty( $review_count ) || $review_count == 0 ) {
		return;
	} elseif ( $review_count == 1 ) {
		return '<span itemprop="ratingValue">' . $rating . '</span>/5 based on <span itemprop="reviewCount">' . $review_count . '</span> review';
	} else {
		return '<span itemprop="ratingValue">' . $rating . '</span>/5 based on <span itemprop="reviewCount">' . $review_count . '</span> reviews';
	}

}


/* WOOCOMMERCE ****************/

/*------------------------------
WooCommerce Setup
------------------------------*/

/* Declare WooCommerce support. */
function lawyerist_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'lawyerist_woocommerce_support' );


/* Display price of free products as "Free!" not "$0.00". */
function lawyerist_wc_free_products( $price, $product ) {

	global $woocommerce;

	if ( wc_memberships_user_has_member_discount() && $product->get_price() == 0 ) {

		$reg_price = $product->get_regular_price();

		return '<del>$' . $reg_price . '</del> Free!';

	} elseif ( $product->get_price() == 0 ) {

		return 'Free!';

	} else {

		return $price;

	}

}

add_filter( 'woocommerce_get_price_html', 'lawyerist_wc_free_products', 10, 2 );


/*------------------------------
Function for Checking to See if a Product ID is in the Cart
------------------------------*/

// To check, call the function as woo_in_cart( $product_id ). Returns true or false.
function woo_in_cart( $product_id ) {

	foreach( WC()->cart->get_cart() as $key => $val ) {

		$products_in_cart = $val['data'];

		if( $product_id == $products_in_cart->id ) {
			return true;
		}

	}

	return false;

}

/*------------------------------
Checkout Fields
------------------------------*/

function lawyerist_checkout_fields( $fields ) {

	// Disables all billing fields except the name, email address, and country.
	unset( $fields['billing']['billing_company'] );
	unset( $fields['billing']['billing_address_1'] );
	unset( $fields['billing']['billing_address_2'] );
	unset( $fields['billing']['billing_city'] );
	unset( $fields['billing']['billing_postcode'] );
	unset( $fields['billing']['billing_phone'] );

	// Disables the order comments/notes field.
	unset( $fields['order']['order_comments'] );

	// Creates an array of Insider, Lab, and LabCon product IDs.
	$lab_insider_product_ids = array(
		208237, // Lawyerist Insider
		208247, // Lawyerist Insider Plus
		224266, // Lawyerist Lab
		224435, // Lawyerist Lab Pro
		227674, // Lawyerist LabCon
		235522, // Lawyerist LabCon 2019 Pre-Registration
		237327, // Lawyerist Lab (Full)
		237421, // Lawyerist Lab (Monthly Payments)
		238051, // Lawyerist Lab + LabCon (Monthly Payments)
		238052, // Lawyerist Lab + LabCon (Full Payment)

	);

	foreach ( $lab_insider_product_ids as $val ) {

		if ( woo_in_cart( $val ) ) {

			$fields['order']['firm_size'] = array(
				'label'				=> __( 'What is the size of your firm?', 'woocommerce' ),
				'type'				=> 'select',
				'options'			=> array(
					''						=> 'Select one.',
					'solo'				=> 'Solo practice',
					'small'				=> 'Small firm (2–15 lawyers)',
					'large'				=> 'Medium or large firm (16+ lawyers)',
					'nope'				=> 'I don\'t work at a law firm',
				),
				'placeholder'	=> _x( 'Select one.', 'placeholder', 'woocommerce' ),
				'required'		=> true,
				'class'				=> array( 'form-row', 'form-row-wide', 'survey_question' ),
				'clear'				=> true,
			);

			$fields['order']['firm_role'] = array(
				'label'				=> __( 'What is your role at your firm?', 'woocommerce' ),
				'type'				=> 'select',
				'options'				=> array(
					''						=> 'Select one.',
					'owner'				=> 'Owner/partner',
					'lawyer'			=> 'Lawyer',
					'staff'				=> 'Staff',
					'nope'				=> 'I don\'t work at a law firm',
				),
				'placeholder'	=> _x( 'Select one.', 'placeholder', 'woocommerce' ),
				'required'		=> true,
				'class'				=> array( 'form-row', 'form-row-wide', 'survey_question' ),
				'clear'				=> true,
			);

			$fields['order']['practice_area'] = array(
				'label'				=> __( 'What type of law do you practice?', 'woocommerce' ),
				'type'				=> 'select',
				'options'			=> array(
					''									=> 'Select your primary practice area.',
					'civil_litigation'	=> 'Civil litigation (non-PI)',
					'corporate'					=> 'Corporate',
					'criminal'					=> 'Criminal',
					'estate_planning'		=> 'Estate planning, probate, or elder',
					'family'						=> 'Family',
					'general_practice'	=> 'General practice',
					'personal_injury'		=> 'Personal injury',
					'real_estate'				=> 'Real estate',
					'other'							=> 'Other',
					'not_in_law'				=> 'I don\'t work in law',
				),
				'placeholder'	=> _x( 'Select your primary practice area.', 'placeholder', 'woocommerce' ),
				'required'		=> true,
				'class'				=> array( 'form-row', 'form-row-wide', 'survey_question' ),
				'clear'				=> true,
			);

		}

	}

	return $fields;

}

add_filter( 'woocommerce_checkout_fields' , 'lawyerist_checkout_fields' );


/*------------------------------
Insider Plus Shopping Cart Upsell
------------------------------*/

function insider_plus_shopping_cart_upsell() {

	if ( is_page( 'cart' ) ) {

		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
		}

		if ( !wc_memberships_is_user_active_member( $user_id, 'insider-plus' ) && !woo_in_cart( 208247 ) ) {
			echo '<div id="insider_plus_upsell" class="woocommerce-info">Want to be able to get everything in our library? Upgrade to Insider Plus for just $29.99/year! <a class="button" href="https://lawyerist.com/cart/?add-to-cart=208247">Upgrade Now!</a></div>';
		}

	}

}

add_action( 'woocommerce_before_cart', 'insider_plus_shopping_cart_upsell' );


/*------------------------------
Check to See if Page is Really a WooCommerce Page
------------------------------*/

function is_really_a_woocommerce_page() {

	if ( function_exists ( "is_woocommerce" ) && is_woocommerce() ) {

		return true;

	}

	$woocommerce_keys = array (
		'woocommerce_shop_page_id',
		'woocommerce_terms_page_id',
		'woocommerce_cart_page_id',
		'woocommerce_checkout_page_id',
		'woocommerce_pay_page_id',
		'woocommerce_thanks_page_id',
		'woocommerce_myaccount_page_id',
		'woocommerce_edit_address_page_id',
		'woocommerce_view_order_page_id',
		'woocommerce_change_password_page_id',
		'woocommerce_logout_page_id',
		'woocommerce_lost_password_page_id'
	);

	foreach ( $woocommerce_keys as $wc_page_id ) {

		if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
			return true ;
		}

	}

	return false;

}


/* TAXONOMY *******************/

/*------------------------------
Page Type Custom Taxonomy
------------------------------*/

// Register Custom Taxonomy
function page_type_tax() {

	$labels = array(
		'name'                       => 'Page Types',
		'singular_name'              => 'Page Type',
		'menu_name'                  => 'Page Types',
		'all_items'                  => 'Page Types',
		'parent_item'                => 'Parent Page Type',
		'parent_item_colon'          => 'Parent Page Type:',
		'new_item_name'              => 'New Page Type',
		'add_new_item'               => 'Add New Page Type',
		'edit_item'                  => 'Edit Page Type',
		'update_item'                => 'Update Page Type',
		'view_item'                  => 'View Page Type',
		'separate_items_with_commas' => 'Separate page types with commas',
		'add_or_remove_items'        => 'Add or remove page types',
		'choose_from_most_used'      => 'Choose from the most used page types',
		'popular_items'              => 'Popular Page Types',
		'search_items'               => 'Search Page Types',
		'not_found'                  => 'Page Type Not Found',
		'no_terms'                   => 'No page types',
		'items_list'                 => 'Page type list',
		'items_list_navigation'      => 'Page type list navigation',
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);

	register_taxonomy( 'page_type', array( 'page' ), $args );

}

add_action( 'init', 'page_type_tax', 0 );


/*------------------------------
Series Custom Taxonomy
------------------------------*/

// Register Custom Taxonomy
function series_tax() {

	$labels = array(
		'name'                       => 'Series',
		'singular_name'              => 'Series',
		'menu_name'                  => 'Series',
		'all_items'                  => 'All Series',
		'parent_item'                => 'Parent Series',
		'parent_item_colon'          => 'Parent Series:',
		'new_item_name'              => 'New Series',
		'add_new_item'               => 'Add New Series',
		'edit_item'                  => 'Edit Series',
		'update_item'                => 'Update Series',
		'separate_items_with_commas' => 'Separate series with commas',
		'search_items'               => 'Search Series',
		'add_or_remove_items'        => 'Add or remove series',
		'choose_from_most_used'      => 'Choose from existing series',
		'not_found'                  => 'Series Not Found',
	);

	$rewrite = array(
		'slug'                       => 'series',
		'with_front'                 => true,
		'hierarchical'               => false,
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
	);

	register_taxonomy( 'series', array( 'post' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'series_tax', 0 );


/*------------------------------
Sponsors Custom Taxonomy
------------------------------*/

// Register Custom Taxonomy
function sponsor_tax() {

	$labels = array(
		'name'                       => 'Sponsors',
		'singular_name'              => 'Sponsor',
		'menu_name'                  => 'Sponsors',
		'all_items'                  => 'All Sponsors',
		'parent_item'                => 'Parent Sponsor',
		'parent_item_colon'          => 'Parent Sponsor:',
		'new_item_name'              => 'New Sponsor',
		'add_new_item'               => 'Add New Sponsor',
		'edit_item'                  => 'Edit Sponsor',
		'update_item'                => 'Update Sponsor',
		'view_item'                  => 'View Sponsor',
		'separate_items_with_commas' => 'Posts can have only one sponsor',
		'add_or_remove_items'        => 'Add or remove sponsors',
		'choose_from_most_used'      => 'Choose from the most used sponsors',
		'popular_items'              => 'Popular Sponsors',
		'search_items'               => 'Search Sponsors',
		'not_found'                  => 'Sponsor Not Found',
	);
	$rewrite = array(
		'slug'                       => 'sponsor',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'sponsor', array( 'post' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'sponsor_tax', 0 );


/* PATCHES ********************/

/*------------------------------
RSS Feed Caching
------------------------------*/

function return_3600( $seconds ) {
  /* Change the default feed cache re-creation period to 1 hour */
  return 3600;
}

add_filter( 'wp_feed_cache_transient_lifetime' , 'return_3600' );
$feed = fetch_feed( $feed_url );
remove_filter( 'wp_feed_cache_transient_lifetime' , 'return_3600' );
