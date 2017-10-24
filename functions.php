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

CONTENT
- Query Mods
- Archive Headers
- Author Bios
- Custom Default Gravatar
- Loops for Infinite Scrolling
- Current Posts Widget
- Ads
- Mobile Ads
- Add Image Sizes
- Remove Inline Width from Image Captions
- Featured Images in RSS Feeds

TAXONOMY
- Rename "Aside" Post Format
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

	wp_register_style( 'lawyerist-fonts', 'https://lawyerist.com/lawyerist-fonts/lawyerist-fonts.css' );
	wp_enqueue_style( 'lawyerist-fonts' );

	wp_register_style( 'normalize-css', get_template_directory_uri() . '/normalize.min.css' );
	wp_enqueue_style( 'normalize-css' );

	$cacheBusterCSS = date("Y m d", filemtime( get_stylesheet_directory() . '/style.css') );
	wp_register_style( 'stylesheet', get_template_directory_uri() . '/style.css', array(), $cacheBusterCSS, 'all' );
	wp_enqueue_style( 'stylesheet' );

	if ( !is_admin() && is_singular() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load consolidated scripts in the header.
	$cacheBusterMC = date("Y m d", filemtime( get_stylesheet_directory() . '/js/header-scripts.js') );
	wp_register_script( 'header-scripts', get_template_directory_uri() . '/js/header-scripts.js', '', $cacheBusterMC );
	wp_enqueue_script( 'header-scripts' );

	// Load consolidated scripts in the footer.
	$cacheBusterMC = date("Y m d", filemtime( get_stylesheet_directory() . '/js/footer-scripts.js') );
	wp_register_script( 'footer-scripts', get_template_directory_uri() . '/js/footer-scripts.js', '', $cacheBusterMC, true );
	if ( is_singular() ) {
		global $post;
		$footer_script_vars_array = array(
			'page_slug' => $post->post_name
		);
		wp_localize_script( 'footer-scripts', 'footer_script_vars', $footer_script_vars_array );
	}
	wp_enqueue_script( 'footer-scripts' );

	// Load sticky sharing buttons on single posts and pages.
	if ( !is_mobile() && ( ( is_single() || is_page() ) ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'sharedaddy' ) ) {
		$cacheBusterSharedaddy = date("Y m d", filemtime( get_stylesheet_directory() . '/js/sticky-sharedaddy.js') );
		wp_register_script( 'sticky_sharedaddy', get_template_directory_uri() . '/js/sticky-sharedaddy.js', '', $cacheBusterSharedaddy, true );
		wp_enqueue_script( 'sticky_sharedaddy' );
	}

}

add_action( 'wp_enqueue_scripts', 'lawyerist_stylesheets_scripts' );


/*------------------------------
Theme Setup
------------------------------*/

function lawyerist_theme_setup() {

	add_theme_support( 'title-tag' );
	add_theme_support( 'infinite-scroll', array(
    'container'				=> 'content_column',
    'footer'					=> false,
		'posts_per_page'	=> 10,
		'render'					=> 'lawyerist_loops', // Found below.
		)
	);
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', 'link' ) );
	add_theme_support( 'html5', array( 'search-form' ) );

}

add_action( 'after_setup_theme', 'lawyerist_theme_setup' );


/* Declare WooCommerce support. */
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'woocommerce_support' );


/* STRUCTURE ******************/

/*------------------------------
Nav Menu
------------------------------*/

function lawyerist_register_menus() {

	register_nav_menus(
		array(
		 'main_topics'	=> 'Main Menu: Topics',
		 'main_about'	=> 'Main Menu: About'
		)
	);

}

add_action('init','lawyerist_register_menus');


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

add_action( 'login_enqueue_scripts', 'lawyerist_login_logo' );
add_filter( 'login_headerurl', 'lawyerist_login_logo_url' );
add_filter( 'login_headertitle', 'lawyerist_login_logo_url_title' );



/* CONTENT ********************/

/*------------------------------
Query Mods
------------------------------*/

function lawyerist_query_mod( $wp_query ) {

	// Add downloads to the feed.
	if ( is_feed() ) {
		set_query_var( 'post_type', array( 'post', 'download' ) );
	}

	// Add pages and downloads to the front page.
	if ( is_front_page() ) {
		set_query_var( 'post_type', array( 'post', 'page', 'download' ) );
	}

	// Add pages and downloads to author feeds in the admin dashboard.
	if ( !is_admin() && is_author() ) {
		set_query_var( 'post_type', array( 'post', 'page', 'download' ) );
	}

	// If displaying a series archive page, show the oldest post first.
	if ( !is_admin() && is_tax( 'series' ) ) {
		set_query_var( 'order', 'ASC' );
	}

}

add_action('pre_get_posts','lawyerist_query_mod');


/*------------------------------
Archive Headers
------------------------------*/

function lawyerist_get_archive_header() {

	// Display the author header if we're on an author page.
	if ( is_author() ) {

		lawyerist_get_author_bio();

	}

	// Display the archive header if we're on an archive page (but not on an author
	// or downloads page).
	if ( is_archive() && !is_author() && !is_post_type_archive( 'download' ) ) {

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

	// Display the download header if we're showing the download page.
	if ( is_post_type_archive( 'download' ) ) {

		echo '<div id="archive_header"><h1>All Downloads</h1></div>';

	}

}



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

	echo '<p class="author_bio">' . $author_bio . '</p>';

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
Loops for Infinite Scrolling
------------------------------*/

function lawyerist_loops() {
	if ( is_home() || is_archive() || is_search() ) {
		get_template_part( 'loop', 'index' );
	}
}


/*------------------------------
Current Posts Widget
------------------------------*/

function lawyerist_current_posts( $this_post ) {

	// Current Posts
	$current_posts_query_args = array(
		'category__not_in'		=> 1320, // Excludes sponsor-submitted posts.
		'ignore_sticky_posts' => TRUE,
		'post__not_in'				=> $this_post,
		'posts_per_page'			=> 4, // Determines how many posts are displayed in the list.
	);

	$current_posts_query = new WP_Query( $current_posts_query_args );

	if ( $current_posts_query->post_count > 1 ) :

		echo '<div id="current_posts">';

			echo '<div class="current_posts_heading"><a href="' . home_url() . '">Current Posts</a></div>';

			// Start the current posts sub-Loop.
			while ( $current_posts_query->have_posts() ) : $current_posts_query->the_post();

				$current_post_title = the_title( '', '', FALSE );
				$current_post_url   = get_permalink();

				echo '<a href="' . $current_post_url . '" title="' . $current_post_title . '" class="current_post">';

					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'current_posts_thumbnail' );
					} else {
						echo '<img src="' . get_template_directory_uri() . '/images/fff-thumb.png" class="attachment-thumbnail wp-post-image" />';
					}

					echo '<p class="current_post_title">' . $current_post_title . '</p>';

				echo '</a>';

			endwhile;

			wp_reset_postdata();

			echo '<div class="clear"></div>';

		echo '</div>'; // Close #current_posts.

	endif; // End current posts.

}


/*------------------------------
Ads
------------------------------*/

function lawyerist_get_ap1() { ?>

	<?php if ( !has_tag('no-ads') && !is_mobile() ) { ?>

		<div id="lawyerist_ap1">
			<div id='div-gpt-ad-1429843825352-0' style='height:90px; width:728px;'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1429843825352-0'); });
				</script>
			</div>
		</div>

	<?php } ?>

<?php }


function lawyerist_get_ap2() { ?>

	<div id="lawyerist_ap2">
		<div id='div-gpt-ad-1429843825352-1' style='height:250px; width:300px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1429843825352-1'); });
			</script>
		</div>
	</div>

<?php }


function lawyerist_get_ap3() { ?>

	<div id="lawyerist_ap3">
		<div id='div-gpt-ad-1429843825352-2' style='height:250px; width:300px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1429843825352-2'); });
			</script>
		</div>
	</div>

<?php }


/*------------------------------
Mobile Ads
------------------------------*/

function lawyerist_mobile_ads( $content ) {

	// Show on single posts.
	if ( is_mobile() && is_single() ) {

		$p_close		= '</p>';
		$paragraphs = explode( $p_close, $content );

		ob_start();
			echo lawyerist_get_ap2();
		$ap2 = ob_get_clean();

		ob_start();
			echo lawyerist_get_ap3();
		$ap3 = ob_get_clean();

		foreach ( $paragraphs as $p_num => $paragraph ) {

			// Only add closing tag to non-empty paragraphs
			if ( trim( $paragraph ) ) {
				// Adding closing markup now, rather than at implode, means insertion
				// is outside of the paragraph markup, and not just inside of it.
				$paragraphs[$p_num] .= $p_close;
			}

			// Insert DFP code after 2nd and 4th paragraphs
			// (0 is paragraph #1 in the $paragraphs array)
			if ( $p_num == 1 ) {
				$paragraphs[$p_num] .= $ap2;
			}

			if ( $p_num == 3 ) {
				$paragraphs[$p_num] .= $ap3;
			}

		}
		return implode( '', $paragraphs );

	} else {

		return $content;

	}

}

add_filter( 'the_content', 'lawyerist_mobile_ads' );


/*------------------------------
Add Image Sizes
------------------------------*/

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'default_thumbnail', 300, 250, true );
	add_image_size( 'standard_thumbnail', 684, 385, true );
	add_image_size( 'download_thumbnail', 250, 0 );
	add_image_size( 'current_posts_thumbnail', 160, 90, true );
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

function featuredtoRSS($content) {

	global $post;

	if ( has_post_thumbnail( $post->ID ) ) {
		$content = '' . get_the_post_thumbnail( $post->ID, 'featured_top', array( 'style' => 'display:block;height:auto;margin:0 0 15px 0;width:560px;' ) ) . '' . $content;
	}

	return $content;

}

add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');


/* TAXONOMY *******************/

/*------------------------------
Rename Aside Post Format
------------------------------*/

// Rename Aside post format
function rename_aside_post_format( $safe_text ) {

  if ( $safe_text == 'Aside' )
      return 'Not Featured';

  return $safe_text;

}

add_filter( 'esc_html' , 'rename_aside_post_format' );


// Rename Aside in posts list table
function live_rename_aside_format() {

    global $current_screen;

    if ( $current_screen->id == 'edit-post' ) { ?>

      <script type="text/javascript">
      jQuery('document').ready(function() {

        jQuery("span.post-state-format").each(function() {
          if ( jQuery(this).text() == "Aside" )
              jQuery(this).text("Not Featured");
        });

      });
      </script>

	<?php }

}

add_action( 'admin_head' , 'live_rename_aside_format' );


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
