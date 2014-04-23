<?php

/* INDEX

Nav Menu
Featured Images
Sidebar
Add Capabilities to Contributor Role
Remove Quickpress
Add Editor Stylesheet
RSS Feed Caching

*/


/*------------------------------
Nav Menu
------------------------------*/

function register_my_menu() {
	register_nav_menu('header-menu',__( 'Header Menu' ));
}

add_action('init','register_my_menu');


/*------------------------------
Featured Images
------------------------------*/

add_theme_support('post-thumbnails');


function featuredtoRSS($content) {

	global $post;

	if ( has_post_thumbnail( $post->ID ) && has_tag('big-image-everywhere') ) {
		$content = '' . get_the_post_thumbnail( $post->ID, 'large', array( 'style' => 'display:block;margin:0 0 15px 0;' ) ) . '' . $content;
	}


	elseif ( has_post_thumbnail( $post->ID ) ) {
		$content = '' . get_the_post_thumbnail( $post->ID, 'medium', array( 'style' => 'float:right; margin:0 0 15px 15px;' ) ) . '' . $content;
	}

	return $content;

}

add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');


if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'featured_thumb_2', 320, 240, true);
}


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
