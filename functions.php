<?php

/* INDEX

Nav Menu
Theme Setup
Add Image Sizes
Featured Images in RSS Feeds
Sidebar
Add Capabilities to Contributor Role
De-Sanitize Author Bio Field [This Should be a Plugin]
Remove Quickpress
RSS Feed Caching

*/


/*------------------------------
Nav Menu
------------------------------*/

function register_my_menus() {
	register_nav_menus( array(
		'header_nav' => 'Header Nav Menu',
		'main_nav' => 'Main Nav Menu (Below Header)',
	)	);
}

add_action('init','register_my_menus');


/*------------------------------
Theme Setup
------------------------------*/

add_action( 'after_setup_theme', 'lawyerist_theme_setup' );

function lawyerist_theme_setup() {

	add_theme_support('post-thumbnails');
	add_theme_support( 'post-formats', array( 'aside' ) );

}


/*------------------------------
Rename "Aside" Post Format to "Note"
------------------------------*/

function rename_post_formats( $safe_text ) {
    if ( $safe_text == 'Aside' )
        return 'Note';

    return $safe_text;
}

add_filter( 'esc_html', 'rename_post_formats' );

//rename Aside in posts list table
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

add_action('admin_head', 'live_rename_formats');


/*------------------------------
Add Image Sizes
------------------------------*/


if ( function_exists( 'add_image_size' ) ) {
	add_image_size( '60px_thumb', 60, 60, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( '75px_thumb', 75, 75, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'featured', 320, 240, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'featured_top', 640, 320, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'featured_topics', 269, 150, true);
}


/*------------------------------
Featured Images in RSS Feeds
------------------------------*/

function featuredtoRSS($content) {

	global $post;

	if ( has_post_thumbnail( $post->ID ) && has_tag('big-image') ) {
		$content = '' . get_the_post_thumbnail( $post->ID, 'large', array( 'style' => 'display:block;margin:0 0 15px 0;' ) ) . '' . $content;
	}


	elseif ( has_post_thumbnail( $post->ID ) ) {
		$content = '' . get_the_post_thumbnail( $post->ID, 'medium', array( 'style' => 'float:right; margin:0 0 15px 15px;' ) ) . '' . $content;
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
		'description'   => 'Left sidebar on Lawyerist.com',
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
Add Capabilities to Contributor Role
------------------------------*/

function add_permissions_contributor() {
    $role = get_role( 'contributor' );
    $role->add_cap( 'upload_files' );
		$role->remove_cap( 'edit_others_posts' );
}

add_action( 'admin_init', 'add_permissions_contributor');


/*------------------------------
De-Sanitize Author Bio Field
------------------------------*/

//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter('pre_user_description', 'wp_filter_kses');
//add sanitization for WordPress posts
add_filter( 'pre_user_description', 'wp_filter_post_kses');


/*------------------------------
Remove Quickpress
------------------------------*/

function remove_quickpress() {
	remove_meta_box('dashboard_quick_press','dashboard','side');
}

add_action('wp_dashboard_setup','remove_quickpress');


/*------------------------------
RSS Feed Caching
------------------------------*/

function return_3600( $seconds )
{
  /* Change the default feed cache re-creation period to 1 hour */
  return 3600;
}

add_filter( 'wp_feed_cache_transient_lifetime' , 'return_3600' );
$feed = fetch_feed( $feed_url );
remove_filter( 'wp_feed_cache_transient_lifetime' , 'return_3600' );
