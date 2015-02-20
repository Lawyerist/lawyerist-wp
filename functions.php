<?php

/* INDEX

Nav Menu
Theme Setup
Add Image Sizes
Featured Images in RSS Feeds
Sidebar
Add Capabilities to Contributor Role
Remove Quickpress
RSS Feed Caching

*/


/*------------------------------
Nav Menu
------------------------------*/

add_action('init','register_my_menus');

function register_my_menus() {
	register_nav_menus( array(
		'header_nav' => 'Header Nav Menu',
		'main_nav' => 'Main Nav Menu (Below Header)',
	)	);
}


/*------------------------------
Theme Setup
------------------------------*/

add_action( 'after_setup_theme', 'lawyerist_theme_setup' );

function lawyerist_theme_setup() {

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support( 'post-formats', array( 'aside' ) );

}


/*------------------------------
Rename "Aside" Post Format to "Note"
------------------------------*/

add_filter( 'esc_html' , 'rename_post_formats' );

function rename_post_formats( $safe_text ) {
    if ( $safe_text == 'Aside' )
        return 'Note';

    return $safe_text;
}


add_action( 'admin_head' , 'live_rename_formats' );

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


/*------------------------------
Edit Flow
Limit Custom Statuses
------------------------------*/

add_filter( 'ef_custom_status_list', 'edit_flow_limit_custom_statuses_by_role' );

function edit_flow_limit_custom_statuses_by_role( $custom_statuses ) {

	$current_user = wp_get_current_user();

	switch( $current_user->roles[0] ) {

		// Limit contributors and authors to the same statuses
		case 'contributor':
		case 'author':
			$permitted_statuses = array(
				'draft',
				'pending',
				'in-revision',
		);

			// Remove the custom status if it's not whitelisted
			foreach( $custom_statuses as $key => $custom_status ) {

				if ( !in_array( $custom_status->slug, $permitted_statuses ) )
					unset( $custom_statuses[$key] );
				}

				break;

	}

	return $custom_statuses;

}


/*------------------------------
Edit Flow
Show Submit for Review Button
------------------------------*/

add_action( 'admin_head', 'edit_flow_show_publish_button' );

function edit_flow_show_publish_button() {

	if ( ! function_exists( 'EditFlow' ) )
		return;

	if ( ! EditFlow()->custom_status->is_whitelisted_page() )
		return;

	if ( get_post_status() == 'draft' ) { ?>
		<style>
			#publishing-action #publish { display: block; }
		</style>
	<?php }
}



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

add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');

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


/*------------------------------
Sidebar
------------------------------*/

add_action( 'widgets_init', 'lawyerist_sidebar_1' );

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


/*------------------------------
Add Capabilities to Contributor Role
------------------------------*/

add_action( 'admin_init', 'add_permissions_contributor');

function add_permissions_contributor() {
    $role = get_role( 'contributor' );
    $role->add_cap( 'upload_files' );
		$role->remove_cap( 'edit_others_posts' );
}


/*------------------------------
Remove Quickpress
------------------------------*/

add_action('wp_dashboard_setup','remove_quickpress');

function remove_quickpress() {
	remove_meta_box('dashboard_quick_press','dashboard','side');
}


/*------------------------------
RSS Feed Caching
------------------------------*/

add_filter( 'wp_feed_cache_transient_lifetime' , 'return_3600' );
$feed = fetch_feed( $feed_url );
remove_filter( 'wp_feed_cache_transient_lifetime' , 'return_3600' );

function return_3600( $seconds )
{
  /* Change the default feed cache re-creation period to 1 hour */
  return 3600;
}
