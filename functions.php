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
- Get First Image URL
- Is This a Product Portal?

CONTENT
- Archive Headers
- Yoast SEO Breadcrumbs
- Postmeta
- Author Bios
- Custom Default Gravatar
- Get Related Podcasts
- Get Related Posts
- Get Related Pages
- List Child Pages Fallback
- Current Posts Widget
- Ads
- Affinity Partner Buttons
- Mobile Ads
- Add Image Sizes
- Remove Inline Width from Image Captions
- Featured Images in RSS Feeds
- Remove Hidden Products from RSS Feed
- Remove Default Gallery Styles

COMMENTS & REVIEWS
- Show Commenter's First Name & Initial
- Reviews

GRAVITY FORMS
- Auto-Populate Form Fields

WOOCOMMERCE
- WooCommerce Setup
- Check to See if Page is Really a WooCommerce Page
- Check to See if a Product ID is in the Cart
- Checkout Fields
- Display Price of Free Products As "Free!" Not "$0.00".

LEARNDASH
- Disable Comments on LearnDash Pages

TAXONOMY
- Page Type Custom Taxonomy
- Sponsors Custom Taxonomy

*/


/* SETUP **********************/

/*------------------------------
Stylesheets & Scripts
------------------------------*/

function lawyerist_stylesheets_scripts() {

	// Normalize the default styles. From https://github.com/necolas/normalize.css/
	wp_register_style( 'normalize-css', get_template_directory_uri() . '/css/normalize.min.css' );
	wp_enqueue_style( 'normalize-css' );

	// Load the main stylesheet, with a cachebuster.
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
	wp_register_script( 'footer-scripts', get_template_directory_uri() . '/js/footer-scripts.js',  array( 'jquery' ), $cacheBusterMC, true );
	wp_enqueue_script( 'footer-scripts' );

}

add_action( 'wp_enqueue_scripts', 'lawyerist_stylesheets_scripts' );

// Dequeue stylesheet
function lawyerist_dequeue_styles() {

	// Prevent stylesheets and scripts from loading on the front page.
	if ( is_front_page() ) {

		// WooCommerce
		wp_deregister_style( 'woocommerce-inline' );
		wp_deregister_style( 'woocommerce-general' );
		wp_deregister_style( 'woocommerce-layout' );
		wp_deregister_style( 'woocommerce-smallscreen' );
		wp_deregister_style( 'wc-memberships-frontend' );

		wp_dequeue_style( 'woocommerce-inline' );
		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'wc-memberships-frontend' );

		// TablePress (doesn't fully work)
		// wp_deregister_style( 'tablepress-default' );
		wp_deregister_style( 'tablepress-responsive-tables' );
		wp_deregister_style( 'tablepress-responsive-tables-flip' );
		wp_deregister_style( 'tablepress-combined' );

		// wp_dequeue_style( 'tablepress-default' );
		wp_dequeue_style( 'tablepress-responsive-tables' );
		wp_dequeue_style( 'tablepress-responsive-tables-flip' );
		wp_dequeue_style( 'tablepress-combined' );

	}

	// Prevent WP Review Pro stylesheets from appearing on non-product pages.
	if ( !is_page_template( 'product-page.php' ) && !is_admin() ) {

		wp_deregister_style( 'fontawesome' );
		wp_deregister_style( 'magnificPopup' );
		wp_deregister_style( 'wp_review-style' );

		wp_dequeue_style( 'fontawesome' );
		wp_dequeue_style( 'magnificPopup' );
		wp_dequeue_style( 'wp_review-style' );

	}

}

// Hooked to the wp_print_styles action, with a late priority so that it is after the style was enqueued.
add_action( 'wp_print_styles', 'lawyerist_dequeue_styles', 100 );


function lawyerist_dequeue_scripts() {

	// Prevent stylesheets and scripts from loading on the front page.
	if ( is_front_page() ) {

		// WooCommerce
		wp_deregister_script( 'js-cookie' );
		wp_deregister_script( 'wc-cart-fragments' );
		wp_deregister_script( 'woocommerce' );
		wp_deregister_script( 'wc-add-to-cart' );

		wp_dequeue_script( 'js-cookie' );
		wp_dequeue_script( 'wc-cart-fragments' );
		wp_dequeue_script( 'woocommerce' );
		wp_dequeue_script( 'wc-add-to-cart' );

	}

	// Prevent WP Review Pro stylesheets and scripts from appearing on non-product pages.
	// IF the scripts don't load on the admin end of things, it breaks reviews.
	if ( !is_page_template( 'product-page.php' ) && !is_admin() ) {

		wp_deregister_script( 'jquery-knob' );
		wp_deregister_script( 'magnificPopup' );
		wp_deregister_script( 'stacktable' );
		wp_deregister_script( 'wp-review-exit-intent' );
		wp_deregister_script( 'wp_review-js' );
		wp_deregister_script( 'wp_review-jquery-appear' );

		wp_dequeue_script( 'jquery-knob' );
		wp_dequeue_script( 'magnificPopup' );
		wp_dequeue_script( 'stacktable' );
		wp_dequeue_script( 'wp-review-exit-intent' );
		wp_dequeue_script( 'wp_review-js' );
		wp_dequeue_script( 'wp_review-jquery-appear' );

	}

}

// Hooked to the wp_print_styles action, with a late priority so that it is after the style was enqueued.
add_action( 'wp_print_scripts', 'lawyerist_dequeue_scripts', 100 );


/*------------------------------
Theme Setup
------------------------------*/

function lawyerist_theme_setup() {

	// add_theme_support( 'disable-custom-colors' );
	// add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'wp-block-styles' );

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

	global $post;

	// Limits API calls to product pages and portals.
	if ( is_plugin_active( 'lawyerist-trial-buttons/lawyerist-trial-buttons.php' ) && ( has_trial_button() || get_page_template_slug( $post->ID ) == 'product-page.php' ) ) {

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
		return $api_result[ 'country_code' ];

	}

}

/*------------------------------
Get First Image URL
------------------------------*/

function get_first_image_url() {

	global $post;

	$first_image_url = '';

	ob_start();
	ob_end_clean();

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

	if ( !empty( $matches[1][0] ) ) {

		$first_image_url = $matches[1][0];

		return $first_image_url;

	} else {

		return;

	}

}


/*------------------------------
Is This a Product Portal?
------------------------------*/

function is_product_portal() {

	global $post;

	$get_children_args = array(
		'child_of'	=> $post->ID,
		'exclude_tree' => array(
			245258, // Community
			245317, // Insider
			220087, // Lab
			128819, // LabCon
		),
	);

	$children = get_pages( $get_children_args );

	if ( is_page() && is_page_template( 'product-page.php' ) && ( count( $children ) > 0 ) ) {

		return true;

	} else {

		return false;

	}

}


/* CONTENT ********************/

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

	global $wp_query;

	$author               = $wp_query->query_vars['author'];
	$author_name          = get_the_author_meta( 'display_name' );
	$author_bio           = get_the_author_meta( 'description' );
	$author_website       = get_the_author_meta( 'user_url' );
	$parsed_url           = parse_url( $author_website );
	$author_nice_website  = $parsed_url[ 'host' ];
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
Get Related Podcasts
------------------------------*/

function lawyerist_get_related_podcasts() {

	global $post;

	$current_id[]		= $post->ID;
	$current_slug		= $post->post_name;
	$current_title	= $post->post_title;

	if ( !empty( $current_slug ) ) {

		$lawyerist_related_podcasts_query_args = array(
			'category_name'			=> 'lawyerist-podcast',
			'category__not_in'	=> array(
				1320, // Excludes sponsored posts.
			),
			'post__not_in'		=> $current_id,
			'posts_per_page'	=> -1,
			'tag' 						=> $current_slug,
		);

		$lawyerist_related_podcasts_query = new WP_Query( $lawyerist_related_podcasts_query_args );

		if ( $lawyerist_related_podcasts_query->have_posts() ) :

			echo '<div id="related_podcasts">';
			echo '<h2>Podcasts About ' . $current_title . '</h2>';

				// Start the Loop.
				while ( $lawyerist_related_podcasts_query->have_posts() ) : $lawyerist_related_podcasts_query->the_post();

					$post_title			= the_title( '', '', FALSE );
					$post_url				= get_permalink();

					echo '<div ' ;
					post_class( 'card' );
					echo '>';

						// Starts the link container. Makes for big click targets!
						echo '<a href="' . $post_url . '" title="' . $post_title . '">';

							// Outputs the podcast guest thumbnail.
							$first_image_url = get_first_image_url();

							if ( empty( $first_image_url ) ) {
								$first_image_url = 'https://lawyerist.com/lawyerist/wp-content/uploads/2018/09/podcast-mic-square-150x150.png';
							}

							echo '<div class="author_avatar"><img class="avatar" src="' . $first_image_url . '" /></div>';

							echo '<div class="headline-excerpt">';

								echo '<h2 class="headline" title="' . $post_title . '">' . $post_title . '</h2>';

								get_template_part( 'postmeta', 'index' );

								// Clearfix
								echo '<div class="clear"></div>';

							echo '</div>'; // Close .headline-excerpt.

						echo '</a>'; // This closes the link container.

					echo '</div>'; // This closes .card.

				endwhile;

				echo '<div class="clear"></div>';

			echo '</div>';

		endif;

		wp_reset_postdata();

	}

}


/*------------------------------
Get Related Posts
------------------------------*/

function lawyerist_get_related_posts() {

	global $post;

	$current_id[]		= $post->ID;
	$current_slug		= $post->post_name;
	$current_title	= $post->post_title;

	if ( !empty( $current_slug ) ) {

		$lawyerist_related_posts_query_args = array(
			'category__not_in'	=> array(
				1320, // Excludes sponsored posts.
				4183, // Excludes podcast episodes.
			),
			'post__not_in'		=> $current_id,
			'posts_per_page'	=> -1,
			'tag' 						=> $current_slug,
		);

		$lawyerist_related_posts_query = new WP_Query( $lawyerist_related_posts_query_args );

		if ( $lawyerist_related_posts_query->have_posts() ) :

			echo '<div id="related_posts">';
			echo '<h2>Posts About ' . $current_title . '</h2>';

				while ( $lawyerist_related_posts_query->have_posts() ) : $lawyerist_related_posts_query->the_post();

					$post_title			= the_title( '', '', FALSE );
					$post_url				= get_permalink();

					$author_name		= get_the_author_meta( 'display_name' );
					$author_avatar	= get_avatar( get_the_author_meta( 'user_email' ), 150, '', $author_name );

					// Starts the post container.
					echo '<div ' ;
					post_class( 'card' );
					echo '>';

						// Starts the link container. Makes for big click targets!
						echo '<a href="' . $post_url . '" title="' . $post_title . '">';

							// Outputs the author's avatar.
							echo '<div class="author_avatar">' . $author_avatar . '</div>';

							echo '<div class="headline-excerpt">';

								// Headline
								echo '<h2 class="headline" title="' . $post_title . '">' . $post_title . '</h2>';

								get_template_part( 'postmeta', 'index' );

								// Clearfix
								echo '<div class="clear"></div>';

							echo '</div>'; // Close .headline-excerpt.

						echo '</a>'; // This closes the post link container (.post).

					echo '</div>';

				endwhile;

				echo '<div class="clear"></div>';

			echo '</div>';

		endif;

		wp_reset_postdata();

	}

}


/*------------------------------
Get Related Pages
------------------------------*/

function lawyerist_get_related_pages() {

	global $post;

	$current_id[]				= $post->ID;
	$current_tags				= get_the_tags( $post->ID );
	$current_tags_slugs	= array();

	if ( !empty( $current_tags ) ) {

		foreach( $current_tags as $current_tag ) {
			array_push( $current_tags_slugs, $current_tag->slug );
		}

		$lawyerist_related_pages_query_args = array(
			'post__not_in'				=> $current_id,
			'post_parent__not_in'	=> array( // Excludes Affinity partner pages.
				239204, // Affinity Benefits
				242095, // Claim Your Affinity benefits
				242252, // Accounting Software
				242234, // Credit Card Processing
				242243, // Intake CRM Software
				242244, // Law Practice Management Software
				269706, // Lawyer Ratings & Directories
				242251, // Legal Timekeeping & Billing Software
				242249, // Online Legal Research Tools
				243267, // Other Legal Marketing Tools
				242253, // Virtual Receptionists
				242254, // Website Designers & SEO Consultants
			),
			'posts_per_page'			=> -1,
			'post_type'						=> 'page',
			'post_name__in' 			=> $current_tags_slugs,
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
					post_class( 'card' );
					echo '>';

						// Starts the link container. Makes for big click targets!
						echo '<a href="' . $post_url . '" title="' . $post_title . '">';

							// Outputs the post thumbnail or a default image.
							if ( has_post_thumbnail() ) {
								echo '<div class="author_avatar">';
									the_post_thumbnail( 'thumbnail' );
								echo '</div>';
							} else {
								echo '<div class="author_avatar"><img class="attachment-thumbnail wp-post-image" src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/L-dot.png" /></div>';
							}

							echo '<div class="headline-excerpt">';

								echo '<h2 class="headline" title="' . $post_title . '">' . $post_title . '</h2>';

							echo '</div>'; // Close .headline-excerpt.

							echo '<div class="clear"></div>';

						echo '</a>'; // This closes the post link container (.post).

					echo '</div>';

				endwhile;

				echo '<div class="clear"></div>';

			echo '</div>';

		endif;

		wp_reset_postdata();

	}

}


/*------------------------------
List Child Pages Fallback


Outputs child pages if all of the following are true:

1. The page has children.
2. The page is not a product portal.
3. The [list-child-pages] shortcode is not used anywhere on the page.
------------------------------*/

function lawyerist_list_child_pages_fallback( $content ) {

	global $post;
	$children = get_pages( array( 'child_of' => $post->ID ) );

if ( is_page() && ( count( $children ) > 0 ) && !has_shortcode( $content, 'list-child-pages' ) && !has_shortcode( $content, 'list-products' ) ) {

		ob_start();

			echo do_shortcode( '[list-child-pages]' );

		$child_pages = ob_get_clean();

		$content .= $child_pages;

		return $content;

	} else {

		return $content;

	}

}

// add_action( 'the_content', 'lawyerist_list_child_pages_fallback' );


/*------------------------------
Current Posts Widget
------------------------------*/

function lawyerist_current_posts( $this_post ) {

	global $post;

	$this_post[] = $post->ID;

	echo '<div id="current_posts">';

		echo '<div class="current_posts_heading"><a href="' . home_url() . '">What\'s New</a></div>';

			// Outputs the most recent podcast episode.
			$current_podcast_query_args = array(
				'category_name'				=> 'lawyerist-podcast',
				'post__not_in'				=> get_option( 'sticky_posts' ),
				'posts_per_page'			=> 1,
				'post__not_in'				=> $this_post,
			);

			$current_podcast_query = new WP_Query( $current_podcast_query_args );

			if ( $current_podcast_query->have_posts() ) : while ( $current_podcast_query->have_posts() ) : $current_podcast_query->the_post();

				$podcast_title	= the_title( '', '', FALSE );
				$podcast_url		= get_permalink();

				echo '<a href="' . $podcast_url . '" title="' . $podcast_title . '" class="current_post">';

					echo '<img class="attachment-thumbnail wp-post-image" src="https://lawyerist.com/lawyerist/wp-content/uploads/2018/02/lawyerist-ltn-podcast-logo-16x9-160x90.png" />';

					echo '<p class="current_post_title">' . $podcast_title . '</p>';

				echo '</a>';

			endwhile; endif;
			// End of podcast episode.

			// Outputs the most recent download.
			$download_query_args = array(
				'post_type'						=> 'product',
				'post__not_in'				=> get_option( 'sticky_posts' ),
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

			// Outputs the most recent blog post.
			$current_post_query_args = array(
				'category_name'				=> 'blog-posts',
				'post__not_in'				=> get_option( 'sticky_posts' ),
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
			// End of blog post.

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
Affinity Partner Buttons
------------------------------*/

function lawyerist_affinity_partner_button() {

	global $post;

	if ( is_user_logged_in() ) {

    $user_id = get_current_user_id();

    if ( wc_memberships_is_user_active_member( $user_id, 'insider-plus' ) || wc_memberships_is_user_active_member( $user_id, 'lab' ) || wc_memberships_is_user_active_member( $user_id, 'lab-pro' ) ) {

			$current_slug = $post->post_name;
			$parent_data	= get_post( $post->post_parent );
			$parent_slug	= $parent_data->post_name;

			if ( !empty( $current_slug ) ) {

				// Assembles the path.
				$partner_path = 'affinity-benefits/claim/' . $parent_slug . '/' . $current_slug;

				if ( get_page_by_path( $partner_path ) ) {
						echo '<a href="https://lawyerist.com/' . $partner_path . '/" class="affinity-partner-link" rel="nofollow">Claim Your Discount</a>';
				}

			}

    }

  }

}


/*------------------------------
Mobile Ads
------------------------------*/

// Inserts the mobile ad on single posts and pages.

function lawyerist_mobile_display_ad( $content ) {

	if ( is_mobile() && ( is_single() || is_page() ) && is_main_query() && !is_page_template( 'product-page.php' ) ) {

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
			if ( ( count( $paragraphs ) > 3 ) && $p_num == 2 ) {
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
Reviews
------------------------------*/

// Gets the author rating ("our" rating) from WP Review Pro, and converts it
// from a 10-point scale to a 5-point scale. Rounds to one decimal point.
function lawyerist_get_our_rating() {

	global $post;

	$our_rating_raw	= get_post_meta( $post->ID, 'wp_review_total', true );
	$our_rating			= round( intval( $our_rating_raw ) / 2, 1 );

	return $our_rating;

}

// Gets the comments rating ("community" rating) from WP Review Pro. Rounds to
// one decimal point.
function lawyerist_get_community_rating() {

	global $post;

	$community_rating = round( get_post_meta( $post->ID, 'wp_review_comments_rating_value', true ), 1 );

	return $community_rating;

}

// Gets the numnber of comment reviews ("community" reviews) from WP Review Pro.
function lawyerist_get_community_review_count() {

	global $post;

	$community_review_count	= get_post_meta( $post->ID, 'wp_review_comments_rating_count', true );

	return $community_review_count;

}

// Calculates the composite rating. If only one rating exists, that rating is
// returned. If both ratings exist, it combines them. The output is rounded to
// one decimal point.
function lawyerist_get_composite_rating() {

	$our_rating							= lawyerist_get_our_rating();
	$community_rating				= lawyerist_get_community_rating();
	$community_review_count	= lawyerist_get_community_review_count();

	if ( !empty( $our_rating ) && !empty( $community_rating ) ) {

		if ( $community_review_count == 1 ) {

			// If our rating and only one community rating exists, they are averaged
			// together equally.
			$composite_rating	= round( ( $community_rating + $our_rating ) / 2, 1 );

		} else {

			// If our rating and two or more community ratings exist, our rating is
			// calculated at one third of the average.
			$composite_rating	= round( ( ( $community_rating * 2 ) + $our_rating ) / 3, 1 );

		}

	} elseif ( !empty( $our_rating ) && empty( $community_rating ) ) {

		$composite_rating	= round( $our_rating, 1 );

	} elseif ( empty( $our_rating ) && !empty( $community_rating ) ) {

		$composite_rating	= round( $community_rating, 1 );

	} else {

		return;

	}

	return $composite_rating;

}


/**
* Displays the star rating, rating, and number of reviews. Includes
* aggregateRating schema on the assumption that the necessary opening and
* closing schema tags will be included in the page template. Also used in our
* Lawyerist Shortcodes plugin.
*
* @param string $rating_type Optional. Accepts 'our_rating' and
* 'community_rating'.
*/
function lawyerist_product_rating( $rating_type = '' ) {

	if ( $rating_type == 'our_rating' ) {

		$rating				= lawyerist_get_our_rating();
		$rating_count	=	1;

	} elseif ( $rating_type == 'community_rating' ) {

		$rating				= lawyerist_get_community_rating();
		$rating_count	=	lawyerist_get_community_review_count();

	} else {

		$rating				= lawyerist_get_composite_rating();
		$our_rating		= lawyerist_get_our_rating();

		if ( !empty( $our_rating ) ) {
			$rating_count	=	lawyerist_get_community_review_count() + 1;
		} else {
			$rating_count	=	lawyerist_get_community_review_count();
		}

	}

	ob_start();

		echo lawyerist_star_rating( $rating );

		echo '<span class="review_count"><span itemprop="ratingValue">' . $rating . '</span>/5 (based on <span itemprop="reviewCount">' . $rating_count . '</span> ' . _n( 'rating', 'ratings', $rating_count ) . ')</span>';

	$lawyerist_product_rating = ob_get_clean();

	return $lawyerist_product_rating;

}


/**
* Outputs the star rating.
*
* @param int $rating Optional. Defaults to composite rating.
*/
function lawyerist_star_rating( $rating = '' ) {

	if ( empty( $rating ) ) {
		$rating	= lawyerist_get_composite_rating();
	}

	$star_rating_width = ( $rating / 5 ) * 100;

	ob_start();

		echo '<div class="lawyerist-star-rating">';

			echo '<div class="lawyerist-star-rating-wrapper">';

				$star_count = 0;

				while ( $star_count < 5 ) {

					echo '<div class="icon rating-star"></div>';

					$star_count++;

				}

				echo '<div class="lawyerist-star-rating-result" style="width: ' . $star_rating_width . '%">';

					$star_result_count = 0;

					while ( $star_result_count < 5 ) {

						echo '<div class="icon rating-star"></div>';

						$star_result_count++;

					}

				echo '</div>';

			echo '</div>';

		echo '</div>';

	$lawyerist_star_rating = ob_get_clean();

	return $lawyerist_star_rating;

}


/* GRAVITY FORMS **************/

/*------------------------------
Auto-Populate Form Fields
------------------------------*/

function populate_first_name_field( $value ){

	if ( is_user_logged_in() ) {

		$user_info = get_userdata( get_current_user_id() );

		$first_name = $user_info->first_name;

		return $first_name;

	}

}

function populate_last_name_field( $value ){

	if ( is_user_logged_in() ) {

		$user_info = get_userdata( get_current_user_id() );

		$last_name = $user_info->last_name;

		return $last_name;

	}

}

function populate_email_field( $value ){

	if ( is_user_logged_in() ) {

		$user_info = get_userdata( get_current_user_id() );

		$email = $user_info->user_email;

		return $email;

	}

}

add_filter( 'gform_field_value_first-name', 'populate_first_name_field' );
add_filter( 'gform_field_value_last-name', 'populate_last_name_field' );
add_filter( 'gform_field_value_email', 'populate_email_field' );


/* WOOCOMMERCE ****************/

/*------------------------------
WooCommerce Setup
------------------------------*/

/* Declare WooCommerce support. */
function lawyerist_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'lawyerist_woocommerce_support' );


/*------------------------------
Check to See if Page is Really a WooCommerce Page
------------------------------*/

function is_really_a_woocommerce_page() {

	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

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

		if ( get_the_ID() == get_option ( $wc_page_id , 0 ) ) {
			return true ;
		}

	}

	return false;

}


/*------------------------------
Check to See if a Product ID is in the Cart
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
	unset( $fields['billing']['billing_phone'] );

	// Disables the order comments/notes field.
	unset( $fields['order']['order_comments'] );

	// Changes field labels.
	$fields['billing']['billing_postcode']['label'] = 'Zip code';

	// Creates an array of Insider, Lab, and LabCon product IDs.
	$lab_insider_product_ids = array(
		208237, // Lawyerist Insider
		242723, // Lawyerist Insider Plus
		259298, // Lawyerist Lab
		224435, // Lawyerist Lab Pro
		227674, // Lawyerist LabCon
		291111, // Lawyerist LabCon Early Bird Payment Plan
		235522, // Lawyerist LabCon Pre-Registration
	);

	foreach ( $lab_insider_product_ids as $val ) {

		if ( woo_in_cart( $val ) ) {

			$fields['order']['firm_size'] = array(
				'label'				=> __( 'What is the size of your firm?', 'woocommerce' ),
				'type'				=> 'select',
				'options'			=> array(
					''																		=> 'Select one.',
					'Solo practice'												=> 'Solo practice',
					'Small firm (2–15 lawyers)'						=> 'Small firm (2–15 lawyers)',
					'Medium or large firm (16+ lawyers)'	=> 'Medium or large firm (16+ lawyers)',
					'I don\'t work at a law firm'					=> 'I don\'t work at a law firm',
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
					''																				=> 'Select one.',
					'Owner/partner'														=> 'Owner/partner',
					'Lawyer'																	=> 'Lawyer',
					'Staff'																		=> 'Staff',
					'Vendor (web designer, consultant, etc.)'	=> 'Vendor (web designer, consultant, etc.)',
					'I don\'t work at a law firm'							=> 'I don\'t work at a law firm',
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
					''																		=> 'Select your primary practice area.',
					'Civil litigation (non-PI)'						=> 'Civil litigation (non-PI)',
					'Corporate'														=> 'Corporate',
					'Criminal'														=> 'Criminal',
					'Estate planning, probate, or elder'	=> 'Estate planning, probate, or elder',
					'Family'															=> 'Family',
					'General practice'										=> 'General practice',
					'Personal injury'											=> 'Personal injury',
					'Real estate'													=> 'Real estate',
					'Other'																=> 'Other',
					'I don\'t work in law'								=> 'I don\'t work in law',
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


/* Update the Order Meta */

function lawyerist_checkout_fields_update_order_meta( $order_id ) {

	if ( !empty( $_POST['firm_size'] ) ) {
		update_post_meta( $order_id, 'firm_size', sanitize_text_field( $_POST['firm_size'] ) );
	}

	if ( !empty( $_POST['firm_role'] ) ) {
		update_post_meta( $order_id, 'firm_role', sanitize_text_field( $_POST['firm_role'] ) );
	}

	if ( !empty( $_POST['practice_area'] ) ) {
		update_post_meta( $order_id, 'practice_area', sanitize_text_field( $_POST['practice_area'] ) );
	}

}

add_action( 'woocommerce_checkout_update_order_meta', 'lawyerist_checkout_fields_update_order_meta' );


/*------------------------------
Display Price of Free Products As "Free!" Not "$0.00".
------------------------------*/

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


/* LEARNDASH ******************/

/*------------------------------
Disable Comments on LearnDash Pages
------------------------------*/

function lawyerist_ld_disable_comments() {

	remove_post_type_support( 'sfwd-courses', 'comments' );
	remove_post_type_support( 'sfwd-lessons', 'comments' );
	remove_post_type_support( 'sfwd-topic', 'comments' );
	remove_post_type_support( 'sfwd-quiz', 'comments' );
	remove_post_type_support( 'sfwd-essays', 'comments' );

}

add_filter( 'init', 'lawyerist_ld_disable_comments' );


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
		'show_in_rest'							 => true,
		'show_tagcloud'              => false,
	);

	register_taxonomy( 'page_type', array( 'page' ), $args );

}

add_action( 'init', 'page_type_tax', 0 );


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
		'show_in_rest'							 => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'sponsor', array( 'post' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'sponsor_tax', 0 );
