<?php

/* INDEX

NAV MENU
FEATURED IMAGES
SIDEBAR
ADD CAPABILITIES TO CONTRIBUTOR ROLE
REMOVE QUICKPRESS
DASHBOARD RSS WIDGET
ADD EDITOR STYLESHEET
RSS FEED CACHING

*/

/* NAV MENU */

function register_my_menu() {
	register_nav_menu('header-menu',__( 'Header Menu' ));
}

add_action('init','register_my_menu');


/* FEATURED IMAGES */

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


/* SIDEBAR */

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


/* ADD CAPABILITIES TO CONTRIBUTOR ROLE */

function add_permissions_contributor() {
    $role = get_role( 'contributor' );
    $role->add_cap( 'upload_files' ); 
}

add_action( 'admin_init', 'add_permissions_contributor');


/* REMOVE QUICKPRESS */

function remove_quickpress() {
	remove_meta_box('dashboard_quick_press','dashboard','side');
}

add_action('wp_dashboard_setup','remove_quickpress');


/* DASHBOARD RSS WIDGET */

function lawyerist_dashboard_widget_function() {
     $rss = fetch_feed( "http://lawyerist.com/feed/" );
 
     if ( is_wp_error($rss) ) {
          if ( is_admin() || current_user_can('manage_options') ) {
               echo '<p>';
               printf(__('<strong>RSS Error</strong>: %s'), $rss->get_error_message());
               echo '</p>';
          }
     return;
}
 
if ( !$rss->get_item_quantity() ) {
     echo '<p>Apparently, there is nothing on Lawyerist!</p>';
     $rss->__destruct();
     unset($rss);
     return;
}
 
echo "<ul>\n";
 
if ( !isset($items) )
     $items = 5;
 
     foreach ( $rss->get_items(0, $items) as $item ) {
          $publisher = '';
          $site_link = '';
          $link = '';
          $content = '';
          $date = '';
          $link = esc_url( strip_tags( $item->get_link() ) );
		  $title = esc_html( $item->get_title() );
          $content = $item->get_content();
          $content = wp_html_excerpt($content, 250) . ' ...';
 
         echo "<li><a class='rsswidget' href='$link'>$title</a>\n<div class='rssSummary'>$content</div>\n";
}
 
echo "</ul>\n";
$rss->__destruct();
unset($rss);
}

function ls_add_lawyerist_dashboard_widget() {
     wp_add_dashboard_widget('lawyerist_dashboard_widget', 'Recent Posts from Lawyerist.com', 'lawyerist_dashboard_widget_function');
}

add_action('wp_dashboard_setup', 'ls_add_lawyerist_dashboard_widget');


/* ADD EDITOR STYLESHEET */

function my_theme_add_editor_styles() {
    add_editor_style();
}

add_action( 'init', 'my_theme_add_editor_styles' );


/* RSS FEED CACHING */

function return_3600( $seconds )
{
  /* Change the default feed cache recreation period to 1 hour */
  return 3600;
}

add_filter( 'wp_feed_cache_transient_lifetime' , 'return_3600' );
$feed = fetch_feed( $feed_url );
remove_filter( 'wp_feed_cache_transient_lifetime' , 'return_3600' );