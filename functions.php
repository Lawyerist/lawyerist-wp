<?php

/* INDEX

SETUP
- Stylesheets & Scripts
- Theme Setup

STRUCTURE
- Nav Menu
- Sidebar

CONTENT
- Query Mods
- Archive Headers
- Postmeta
- Loops
- Ads
- Add Image Sizes
- Remove Inline Width from Image Captions
- Featured Images in RSS Feeds

TAXONOMY
- Rename "Aside" Post Format
- Series Custom Taxonomy
- Sponsors Custom Taxonomy

PATCHES
- RSS Feed Caching
- Fix Gravity Form Tab Index Conflicts

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

	$cacheBusterCSS = date("Y m d", filemtime( get_stylesheet_directory() . '/style.css'));
	wp_register_style( 'stylesheet', get_template_directory_uri() . '/style.css', array(), $cacheBusterCSS, 'all' );
	wp_enqueue_style( 'stylesheet' );

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
	add_theme_support( 'post-formats', array( 'aside' ) );
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
		 'main_nav' => 'Responsive Nav Menu (Below Header)'
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


/* CONTENT ********************/

/*------------------------------
Query Mods
------------------------------*/

function lawyerist_query_mod( $wp_query ) {

	// Add pages and downloads to the main query.
	set_query_var( 'post_type' , array( 'post', 'page', 'download' ) );

}

add_action('pre_get_posts','lawyerist_query_mod');


/*------------------------------
Archive Headers
------------------------------*/

function lawyerist_get_archive_header() {

	// Display the author header if we're on an author page.
	if ( is_author() ) {

		$author = $wp_query->query_vars['author'];

		$author_name					= get_the_author_meta( 'display_name', $author );
		$author_website				= get_the_author_meta( 'user_url', $author );
		$parsed_url						= parse_url( $author_website );
		$author_nice_website	= $parsed_url['host'];
		$author_bio						= get_the_author_meta( 'description', $author );
		$author_twitter				= get_the_author_meta( 'twitter', $author );

		$author_avatar  = get_avatar( get_the_author_meta( 'user_email', $author ), 300, '', $author_name );

		echo '<div id="author_header">' . "\n";
		echo '<h1>' . $author_name . '</h1>' . "\n";

		echo $author_avatar;

		echo '<p class="author_bio">' . $author_bio . '</p>' . "\n";

		echo '<div id="author_connect">' . "\n";

			if ( $author_twitter == true ) {
				echo '<p class="author_twitter"><a href="https://twitter.com/' . $author_twitter . '">@' . $author_twitter . '</a></p>';
			}

			if ( $author_website == true ) {
				echo '<p class="author_website"><a href="' . $author_website . '">' . $author_nice_website . '</a></p>';
			}

		echo '</div>' . "\n";

		echo '<div class="clear"></div>';

		echo '</div>'; // End #author_header.

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
Loops
------------------------------*/

function lawyerist_loops() {

	if ( is_home() || is_archive() || is_search() ) {
		get_template_part( 'loop', 'index' );
	}

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
Add Image Sizes
------------------------------*/

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'default_thumbnail', 300, 250, true );
	add_image_size( 'standard_thumbnail', 740, 416.25, true );
	add_image_size( 'single_featured', 1180, 0 );
	add_image_size( 'download_thumbnail', 250, 0 );
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


/*------------------------------
Fix Gravity Form Tab Index Conflicts
http://gravitywiz.com/fix-gravity-form-tabindex-conflicts/
------------------------------*/

function gform_tabindexer( $tab_index, $form = false ) {
    $starting_index = 1000; // if you need a higher tabindex, update this number
    if( $form )
        add_filter( 'gform_tabindex_' . $form['id'], 'gform_tabindexer' );
    return GFCommon::$tab_index >= $starting_index ? GFCommon::$tab_index : $starting_index;
}
add_filter( 'gform_tabindex', 'gform_tabindexer', 10, 2 );
