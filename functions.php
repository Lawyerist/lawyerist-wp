<?php

/* INDEX

Stylesheets & Google Fonts
Nav Menu
Bylines
Theme Setup
Rename "Aside" Post Format to "Note"
Series Custom Taxonomy
Edit Flow
Add Image Sizes
Featured Images in RSS Feeds
Sidebar
Allow PHP in Widgets
Add Capabilities to Contributor Role
RSS Feed Caching

*/


/*------------------------------
Stylesheets & Google Fonts
------------------------------*/

function lawyerist_stylesheets() {

	wp_register_style( 'normalize-css', get_template_directory_uri() . '/normalize.min.css' );
	wp_enqueue_style( 'normalize-css' );

	$cacheBusterCSS = date("Y m d", filemtime( get_stylesheet_directory() . '/style.css'));
	wp_register_style( 'stylesheet', get_template_directory_uri() . '/style.css', array(), $cacheBusterCSS, 'all' );
	wp_enqueue_style( 'stylesheet' );

}

add_action( 'wp_enqueue_scripts', 'lawyerist_stylesheets' );


/*------------------------------
Nav Menu
------------------------------*/

function register_my_menus() {
	register_nav_menus( array(
		'header_nav' => 'Header Nav Menu',
		'main_nav' => 'Main Nav Menu (Below Header)',
		'mobile_nav' => 'Mobile Nav Menu for Phones',
	)	);
}

add_action('init','register_my_menus');


/*------------------------------
Bylines
------------------------------*/

function lawyerist_get_byline() {

	// This function must be used within the Loop

	$this_post_id = get_the_ID();

	// Sponsor-submitted posts
	if ( has_term( true , 'sponsor' ) && has_category( 'sponsored-posts' ) ) {

		$sponsors = wp_get_post_terms(
			$this_post_id,
			'sponsor',
			array(
				'fields' 	=> 'names',
				'orderby' => 'count',
				'order' 	=> 'DESC'
			)
		);
		$sponsor = $sponsors[0];

		$sponsor_ids = wp_get_post_terms(
			$this_post_id,
			'sponsor',
			array(
				'fields' 	=> 'ids',
				'orderby' => 'count',
				'order' 	=> 'DESC'
			)
		);
		$sponsor_id = $sponsor_ids[0];

		$sponsor_url = term_description( $sponsor_id, 'sponsor' );
		$sponsor_url = strip_tags( $sponsor_url );

		if ( is_single() ) {
			$author = '<a href="' . $sponsor_url . '" rel="nofollow">' . $sponsor . '</a>';
		} else {
			$author = $sponsor;
		}

	// Sponsored collaborative (native) posts
	} elseif ( has_term( true , 'sponsor' ) && !has_category( 'sponsored-posts' ) ) {

		$sponsors = wp_get_post_terms(
			$this_post_id,
			'sponsor',
			array(
				'fields' 	=> 'names',
				'orderby' => 'count',
				'order' 	=> 'DESC'
			)
		);
		$sponsor = $sponsors[0];

		$sponsor_ids = wp_get_post_terms(
			$this_post_id,
			'sponsor',
			array(
				'fields' 	=> 'ids',
				'orderby' => 'count',
				'order' 	=> 'DESC'
			)
		);
		$sponsor_id = $sponsor_ids[0];

		$sponsor_url = term_description( $sponsor_id, 'sponsor' );
		$sponsor_url = strip_tags( $sponsor_url );

		/* Bylines should only have links to the author page on single post pages. */
		if ( is_single() ) {
			$author = '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a>, a <a href="https://lawyerist.com/advertising/">sponsored collaboration</a> with ' . '<a href="' . $sponsor_url . '" rel="nofollow">' . $sponsor . '</a>,';
		} else {
			$author = get_the_author() . ', a sponsored collaboration with ' . $sponsor . ',';
		}

	// Regular posts
	} else {

		/* Bylines should only have links to the author page on single post pages. */
		if ( is_single() ) {

			if ( function_exists( 'coauthors_posts_links' ) ) {
				$author = coauthors_posts_links( ', ',' and ','','', false );
			} else {
			  $author = '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a>';
			}

		} else {

			if ( function_exists( 'coauthors_posts_links' ) ) {
				$author = coauthors( ', ',' and ','','', false );
			} else {
				$author = get_the_author();
			}

		}

	}

	$date = get_the_time( 'F jS, Y' );

	// Output the results
	echo '<div class="author_link">By ' . $author . ' <span class="fp_postmeta_break">on ' . $date. '</span></div>';

}


/*------------------------------
Theme Setup
------------------------------*/

function lawyerist_theme_setup() {

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support( 'post-formats', array( 'aside', 'audio' ) );

}

add_action( 'after_setup_theme', 'lawyerist_theme_setup' );


/*------------------------------
Rename "Aside" Post Format to "Note"
------------------------------*/

// Rename Aside post format
function rename_post_formats( $safe_text ) {
    if ( $safe_text == 'Aside' )
        return 'Note';

    return $safe_text;
}

add_filter( 'esc_html' , 'rename_post_formats' );


// Rename Aside in posts list table
function live_rename_formats() {
    global $current_screen;

    if ( $current_screen->id == 'edit-post' ) { ?>
        <script type="text/javascript">
        jQuery('document').ready(function() {

            jQuery("span.post-state-format").each(function() {
                if ( jQuery(this).text() == "Aside" )
                    jQuery(this).text("Note");
            });

        });
        </script>
<?php }
}

add_action( 'admin_head' , 'live_rename_formats' );


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


/*------------------------------
Add Image Sizes
------------------------------*/


if ( function_exists( 'add_image_size' ) ) {
	add_image_size( '60px_thumb', 60, 60, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'featured', 320, 263.5, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'featured_top', 640, 387.5, true);
}


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


/*------------------------------
Sidebar
------------------------------*/

function lawyerist_sidebar_1()  {
	$args = array(
		'id'            => 'sidebar_1',
		'name'          => 'Sidebar 1',
		'description'   => 'Right sidebar on Lawyerist.com',
		'class'         => 'sidebar',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
	);

	register_sidebar( $args );
}

add_action( 'widgets_init', 'lawyerist_sidebar_1' );


/*------------------------------
Allow PHP in Widgets
------------------------------*/

function php_execute($html){

	if ( strpos( $html,"<"."?php" ) !== false ) {

		ob_start(); eval("?".">".$html);

		$html=ob_get_contents();

		ob_end_clean();

	}

	return $html;
}

add_filter('widget_text','php_execute',100);


/*------------------------------
Add Capabilities to Contributor Role
------------------------------*/

function add_permissions_contributor() {
  $role = get_role( 'contributor' );
  $role->add_cap( 'upload_files' );
	$role->remove_cap( 'edit_others_posts' );
}

add_action( 'admin_init', 'add_permissions_contributor');


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
