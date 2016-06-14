<?php

/* INDEX

SETUP
- Stylesheets & Scripts
- Theme Setup

STRUCTURE
- Nav Menu
- Sidebar

WIDGETS
- Popular Posts Widget

CONTENT
- Bylines
- Mobile Ad
- Add Image Sizes
- Page Navigation
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

	wp_enqueue_script( 'idTabs', get_template_directory_uri() . '/jquery.idTabs.min.js', array( 'jquery' ), '2.2', 'true' );
	wp_enqueue_script( 'responsive-menu', get_template_directory_uri() . '/responsive-menu.js', array( 'jquery' ), '1.0.0', 'true' );

}

add_action( 'wp_enqueue_scripts', 'lawyerist_stylesheets_scripts' );


/*------------------------------
Theme Setup
------------------------------*/

function lawyerist_theme_setup() {

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support( 'post-formats', array( 'aside' ) );
	add_theme_support( 'html5', array( 'search-form' ) );

}

add_action( 'after_setup_theme', 'lawyerist_theme_setup' );


/* STRUCTURE ******************/

/*------------------------------
Nav Menu
------------------------------*/

function register_my_menus() {
	register_nav_menus( array(
		'main_nav' => 'Responsive Nav Menu (Below Header)'
	)	);
}

add_action('init','register_my_menus');


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


/* WIDGETS ********************/

/*------------------------------
Popular Posts Widget
------------------------------*/

function lawyerist_popular_posts_widget( $args ) {

	echo $args['before_widget'];
	echo $args['before_title'] . 'Popular Posts' .  $args['after_title'];

		?>

		<div id="popular_posts_tabbed">

		<ul class="idTabs">
			<li><a href="#current">This Week</a></li>
			<li><a href="#all-time">All Time</a></li>
		</ul>

		<div id="current" class="tabs_sublist">
			<?php wpp_get_mostpopular("post_type='post'&range=weekly&limit=5&freshness=1&stats_comments=0&thumbnail_height=60&thumbnail_width=60&post_html='<li>{thumb}<a class=\"wpp_headline\" href=\"{url}\">{text_title}</a></li>'"); ?>
		</div>

		<div id="all-time" class="tabs_sublist">
			<?php wpp_get_mostpopular("post_type='post'&range=all&limit=5&stats_comments=0&thumbnail_height=60&thumbnail_width=60&post_html='<li>{thumb}<a class=\"wpp_headline\" href=\"{url}\">{text_title}</a></li>'"); ?>
		</div>

		</div>

		<?php

	echo $args['after_widget'];

}

wp_register_sidebar_widget(

	'popular-posts-tabbed-widget',			// your unique widget id
	'Popular Posts',										// widget name
	'lawyerist_popular_posts_widget',		// callback function
	array(															// options
		'description' => 'Displays a tabbed list of current and all-time popular posts.'
	)

);


/* CONTENT ********************/

/*------------------------------
Bylines
------------------------------*/

function lawyerist_get_byline() {

	// This function must be used within the Loop

	$this_post_id = get_the_ID();

	// Sponsor-submitted posts will have a sponsor and the category will be set
	// to Sponsored Post.
	if ( has_term( true, 'sponsor' ) && has_category( 'sponsored-posts' ) ) {

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

	// Sponsored collaborative posts will have a sponsor but the
	// category will *not* be set to Sponsored Posts.
	} elseif ( has_term( true, 'sponsor' ) && !has_category( 'sponsored-posts' ) ) {

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
			$author = '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a>, sponsored by ' . '<a href="' . $sponsor_url . '" rel="nofollow">' . $sponsor . '</a>,';
		} else {
			$author = get_the_author() . '<span class="sponsored_by">, sponsored by ' . $sponsor . ',</span>';
		}

	// Regular posts
	} else {

		/* Bylines should only have links to the author page on single post pages. */
		if ( is_single() ) {

			$author = '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a>';

		} else {

			$author = get_the_author();

		}

	}

	$date = get_the_time( 'F jS, Y' );

	// Output the results
	echo '<span class="author_link">By ' . $author . '</span> <span class="on_date">on ' . $date. '</span>';

}


/*------------------------------
Mobile Ad
------------------------------*/

function insert_lawyerist_mobile_ad() { ?>

	<div id="mobile_ad">
		<div id='div-gpt-ad-1429843825352-1' style='height:250px; width:300px;'>
		<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1429843825352-1'); });
		</script>
		</div>
	</div>

<?php }


function lawyerist_mobile_ad( $content ) {

	// Show on single posts but not pages.
	if ( is_mobile() && is_single() && !is_page() ) {

		$p_close		= '</p>';
		$paragraphs = explode( $p_close, $content );

		ob_start();
			echo insert_lawyerist_mobile_ad();
		$dfp_code		= ob_get_clean();

		foreach ( $paragraphs as $p_num => $paragraph ) {

			// Only add closing tag to non-empty paragraphs
			if ( trim( $paragraph ) ) {
				// Adding closing markup now, rather than at implode, means insertion
				// is outside of the paragraph markup, and not just inside of it.
				$paragraphs[$p_num] .= $p_close;
			}

			// Insert DFP code after 2nd paragraph
			// (0 is paragraph #1 in the $paragraphs array)
			if ( $p_num == 0 ) {
				$paragraphs[$p_num] .= $dfp_code;
			}
		}

		return implode( '', $paragraphs );

	} else {

		return $content;

	}

}

add_filter( 'the_content', 'lawyerist_mobile_ad' );


/*------------------------------
Add Image Sizes
------------------------------*/


if ( function_exists( 'add_image_size' ) ) {
	add_image_size( '60px_thumb', 60, 60, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'featured', 320, 255.5, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'featured_top', 640, 344.5, true);
}


/*------------------------------
Page Navigation
------------------------------*/

function lawyerist_get_pagenav() {

	// This function must be used within the Loop in single.php.
	// It doesn't matter in other template files.

	if ( is_home() || is_archive() || is_search() ) {

		ob_start();
			echo paginate_links( 'mid_size=3' );
		$pagenav = ob_get_clean();

	} elseif ( is_single() && has_term( true, 'series' ) ) {

		ob_start();
			?>

			<div class="alignleft pagenav_link_block">
				<?php next_post_link( '%link', '<div class="genericon pagenav_leftarrow"></div><div class="pagenav_link">%title</div>', TRUE, '', 'series', 0 ) ?>
			</div>
			<div class="alignright pagenav_link_block">
				<?php previous_post_link( '%link', '<div class="pagenav_link">%title</div><div class="genericon pagenav_rightarrow"></div>', TRUE, '', 'series', 0 ) ?>
			</div>
			<div class="clear"></div>

			<?php
		$pagenav = ob_get_clean();

	} elseif ( is_single() ) {

		ob_start();
			?>

			<div class="alignleft pagenav_link_block">
				<?php next_post_link('%link','<div class="genericon pagenav_leftarrow"></div><div class="pagenav_link">%title</div>',0) ?>
			</div>
			<div class="alignright pagenav_link_block">
				<?php previous_post_link('%link','<div class="pagenav_link">%title</div><div class="genericon pagenav_rightarrow"></div>',0) ?>
			</div>
			<div class="clear"></div>

			<?php
		$pagenav = ob_get_clean();

	}


	echo '<div id="pagenav">';
	echo $pagenav;
	echo '</div>';

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
