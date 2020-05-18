<?php

/* INDEX

SETUP
- Stylesheets & Scripts
- Theme Setup
- Template Files

STRUCTURE
- Nav Menu

ADMIN
- Login Form
- Remove Menu Items

UTILITY FUNCTIONS
- Get Country
- Retina Thumbnail
- Get First Image URL
- Is This a Product Portal?

CARDS
- Post Cards

CONTENT
- Archive Headers
- Yoast SEO Breadcrumbs
- Add IDs to Headings
- Render Table of Contents
- Author Bios
- List of Coauthors
- Get Alternative Products
- Get Related Posts
		- Get Related Resources
- Remove Inline Width from Image Captions
- Featured Images in RSS Feeds
- Remove Lab Workshops from Sitemap
- Remove Lab Workshops from RSS Feed
- Remove Default Gallery Styles

PARTNERSHIPS
- Platinum Sponsors Widget
- Affinity Benefit Notice

COMMENTS & REVIEWS
- Custom Default Gravatar
- Show Commenter's First Name & Initial
- Reviews

GRAVITY FORMS
- Enable CC Field on Form Notifications
- Populate Form Fields
- Auto-Login New Users

WOOCOMMERCE
- WooCommerce Setup
- Check to See if Page is Really a WooCommerce Page
- Checkout Fields
- Display Price of Free Products As "Free!" Not "$0.00".
- Remove My Account Navigation Items
- Remove Membership & Subscription Details from WC Order & Thank-You Pages

LEARNDASH
- Disable Comments on LearnDash Pages

TAXONOMY
- Page Type Custom Taxonomy

*/


/* SETUP **********************/

/*------------------------------
Stylesheets & Scripts
------------------------------*/

function stylesheets_scripts() {

	$template_dir_uri = get_template_directory_uri();

	// Normalize the default styles. From https://github.com/necolas/normalize.css/
	wp_register_style( 'normalize-css', $template_dir_uri . '/css/normalize.css' );
	wp_enqueue_style( 'normalize-css' );

	// Load the main stylesheet.
	$cacheBusterCSS = filemtime( get_stylesheet_directory() . '/style.css' );
	wp_register_style( 'stylesheet', $template_dir_uri . '/style.css', array(), $cacheBusterCSS, 'all' );
	wp_enqueue_style( 'stylesheet' );

	// Load consolidated scripts in the footer.
	$cacheBusterFS = filemtime( get_stylesheet_directory() . '/js/footer-scripts.js' );
	wp_register_script( 'footer-scripts', $template_dir_uri . '/js/footer-scripts.js',  array( 'jquery' ), $cacheBusterFS, true );
	wp_enqueue_script( 'footer-scripts' );

}

add_action( 'wp_enqueue_scripts', 'stylesheets_scripts' );


/*------------------------------
Theme Setup
------------------------------*/

function theme_setup() {

	add_theme_support( 'editor-styles' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'wp-block-styles' );

	add_image_size( 'featured_image', 1024 );
	add_image_size( 'featured_image_2x', 2048 );
	add_image_size( 'large_2x', 1388 );
	add_image_size( 'thumbnail_2x', 300, 300, true );

	add_editor_style( 'template-parts/acf-blocks/acf-block-styles.css' );

}

add_action( 'after_setup_theme', 'theme_setup' );


function remove_image_sizes() {

	remove_image_size( '1536x1536' );
	remove_image_size( '2048x2048' );
	remove_image_size( 'wp_review_small' );
	remove_image_size( 'wp_review_large' );

}

add_action( 'init', 'remove_image_sizes' );


function remove_image_size_options( $possible_sizes ) {

	unset( $possible_sizes[ 'wp_review_small' ] );
	unset( $possible_sizes[ 'wp_review_large' ] );

	return $possible_sizes;

}

add_filter( 'image_size_names_choose', 'remove_image_size_options' );


/**
* Adds options page(s) for ACF. (Add more as needed.)
*/
function front_page_options_acf_op_init() {

  // Check function exists.
  if( function_exists( 'acf_add_options_sub_page' ) ) {

    acf_add_options_sub_page( array(
      'page_title'  => __( 'Block Defaults' ),
      'menu_title'  => __( 'Block Defaults' ),
      'parent_slug' => __( 'options-general.php' ),
    ) );

  }

}

add_action( 'acf/init', 'front_page_options_acf_op_init' );


/*------------------------------
Template Files
------------------------------*/

require_once( 'acf-blocks.php' );

if ( !is_admin() ) {

  require_once( 'shortcodes.php' );

}


/* STRUCTURE ******************/

/**
* Nav Menu
*/

function register_menus() {

	register_nav_menus(
		array(
			'header-nav-menu' => 'Header Nav Menu'
		)
	);

}

add_action( 'init', 'register_menus' );


/**
* Adds a login/register item to the nav menu.
*/
function lawyerist_loginout( $items, $args ) {

	if ( !function_exists( 'wc_memberships' ) ) {
    return;
  }

	if ( is_user_logged_in() && $args->theme_location == 'header-nav-menu' ) {

		$user_ID = get_current_user_id();

		ob_start();

		?>

			<li class="menu-item menu-item-loginout menu-item-has-children">

				<a>Account</a>

				<ul class="sub-menu">

					<li class="menu-item"><a href="https://lawyerist.com/account/">My Account</a>

					<?php if ( wc_memberships_is_user_active_member( $user_ID, 'lab' ) ) { ?>
						<li class="menu-item"><a href="https://lawyerist.com/labster-portal/">Member Portal</a></li>
					<?php } ?>

					<?php if ( wc_memberships_is_user_active_member( $user_ID, 'accelerator' ) ) { ?>
						<li class="menu-item"><a href="https://lawyerist.com/courses/accelerator/">Accelerator</a></li>
					<?php } ?>

					<li class="menu-item"><a href="https://lawyerist.com/scorecard/">Update My Scorecard</a></li>

				</ul>

			</li>

		<?php

		$new_items = ob_get_clean();

    $items .= $new_items;

  } elseif ( !is_user_logged_in() && $args->theme_location == 'header-nav-menu' ) {

		ob_start();

		?>

			<li class="menu-item menu-item-has-children menu-item-loginout">

				<a class="login-link">Log In</a>

			</li>

		<?php

		$new_items = ob_get_clean();

		$items .= $new_items;

  }

  return $items;

}

add_filter( 'wp_nav_menu_items', 'lawyerist_loginout', 10, 2 );


/* ADMIN ********************/

/*------------------------------
Login Form
------------------------------*/

/**
* Get Login/Register
*
* Returns the modal login/register form. Called from header.php so it is always
* available.
*/

function get_lawyerist_login() {

	ob_start();

	?>

	<div id="lawyerist-login" class="modal" style="display: none;">

		<div class="card">

			<button class="greybutton dismiss-button"></button>
			<img class="l-dot" src="<?php echo get_template_directory_uri(); ?>/images/L-dot-login-large.png">

			<li id="login">
				<h2>Log in to Lawyerist.com</h2>
				<p>Not an Insider yet? <a class="link-to-register">Register here.</a> (It's free!)</p>
				<?php wp_login_form(); ?>
				<p class="remove_bottom">Forgot your password? <a href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>" alt="<?php esc_attr_e( 'Lost Password', 'textdomain' ); ?>" class="forgot-password-link">Reset it here.</a></p>
			</li>

			<li id="register" style="display: none;">
				<h2>Join Lawyerist Insider</h2>
				<p><a class="back-to-login">Back to login.</a></p>
				<?php echo do_shortcode( '[gravityform id=59 title=false ajax=true]' ); ?>
			</li>

		</div>

	</div>

	<div id="lawyerist-login-screen" style="display: none;"></div>

	<?php

	$lawyerist_login = ob_get_clean();

	return $lawyerist_login;

}


/**
* The following functions modify the regularly WordPress login form defaults by
* adding our logo, URL, and company name, just in case anyone finds it.
*/

function lawyerist_login_logo() { ?>

	<style type="text/css">

		#login h1 a,
		.login h1 a {
			background-image: url( <?php echo get_stylesheet_directory_uri(); ?>/images/L-dot-login.png );
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
        return '<p>Don\'t have an account yet? <a href="https://lawyerist.com/community/insider/">Click here to join the Lawyerist Insider today (it\'s free)!</a></p>';
    } else {
        return $message;
    }
}

add_action( 'login_enqueue_scripts', 'lawyerist_login_logo' );
add_filter( 'login_headerurl', 'lawyerist_login_logo_url' );
add_filter( 'login_headertitle', 'lawyerist_login_logo_url_title' );
add_filter( 'login_message', 'lawyerist_login_message' );


/**
* Remove Menu Items
*
* None of these are essential, but our +New menu had become a mess, so these
* functions clean it up.
*/

function remove_admin_bar_items( $wp_admin_bar ) {

	// Remove from the +New menu.
	$wp_admin_bar->remove_node( 'new-link' );
	$wp_admin_bar->remove_node( 'new-media' );
	$wp_admin_bar->remove_node( 'new-product' );
	$wp_admin_bar->remove_node( 'new-shop_coupon' );
	$wp_admin_bar->remove_node( 'new-shop_order' );
	$wp_admin_bar->remove_node( 'new-wc_zapier_feed' );
	$wp_admin_bar->remove_node( 'new-sfwd-courses' );
	$wp_admin_bar->remove_node( 'new-sfwd-lessons' );
	$wp_admin_bar->remove_node( 'new-sfwd-topic' );
	$wp_admin_bar->remove_node( 'new-sfwd-quiz' );
	$wp_admin_bar->remove_node( 'new-sfwd-question' );
	$wp_admin_bar->remove_node( 'new-sfwd-certificates' );
	$wp_admin_bar->remove_node( 'new-shop_subscription' );
	$wp_admin_bar->remove_node( 'new-groups' );
	$wp_admin_bar->remove_node( 'new-wc_membership_plan' );
	$wp_admin_bar->remove_node( 'new-wc_user_membership' );
	$wp_admin_bar->remove_node( 'new-user' );
	$wp_admin_bar->remove_node( 'new-tablepress-table' );

	// Remove Monster Insights.
	$wp_admin_bar->remove_node( 'monsterinsights_frontend_button' );

}
add_action( 'admin_bar_menu', 'remove_admin_bar_items', 999 );


function remove_stubborn_admin_bar_items() {

	global $wp_admin_bar;

	$wp_admin_bar->remove_menu( 'gravityforms-new-form' );

}
add_action( 'wp_before_admin_bar_render', 'remove_stubborn_admin_bar_items', 999 );


/* UTILITY FUNCTIONS ********************/

/**
* Get Country
*
* This gets the country from the ipStack.com API (we have a paid account there).
* We use this to make sure we are only showing trial buttons to visitors from
* the US and Canada.
*/

function get_country() {

	global $post;

	// Limits API calls to product pages and portals.
	if ( is_plugin_active( 'lawyerist-trial-buttons/lawyerist-trial-buttons.php' ) && ( has_trial_button() || get_page_template_slug( $post->ID ) == 'product-page.php' ) ) {

		// Get user's geographic location by IP address.
		// Set IP address and API access key.
		$ip = $_SERVER[ 'REMOTE_ADDR' ];
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

/**
* Get Sponsor Link
*
* Gets the sponsor for bylines. If the post is singular and published, it
* returns the sponsor as a link.
*/

function get_sponsor_link( $post_id = null ) {

	if ( !$post_id || !has_category( 'sponsored', $post_id ) ) { return; }

	$sponsor					= get_post( get_field( 'sponsored_post_partner', $post_id ) );
	$product_page_id	= get_field( 'product_page', $sponsor->ID ) ? get_post( get_field( 'product_page', $sponsor->ID ) ) : null;

	if ( is_single() && $product_page_id && get_post_status( $product_page_id ) == 'publish' ) {

		return '<a href="' . get_permalink( $product_page_id ) . '">' . $sponsor->post_title . '</a>';

	} else {

		return $sponsor->post_title;

	}

}


/**
* Get First Image URL
*
* Gets the URL of the first image in a post. We use this for our Case Study
* posts, where the first image is a headshot of the featured lawyer.
*/

function get_first_image_url( $post_id = NULL ) {

	if ( empty( $post_id ) ) {
		global $post;
	} else {
		$post = get_post( $post_id );
	}

	$first_image_url = array();

	preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );

	if ( !empty( $matches[1][0] ) ) {

		$first_image_url[ '1x' ]	= filter_var( $matches[1][0], FILTER_SANITIZE_URL );
		$first_image_id						= attachment_url_to_postid( $first_image_url[ '1x' ] );

		if ( $first_image_id ) {

			$first_image_1x = wp_get_attachment_image_src( $first_image_id );
			$first_image_2x = wp_get_attachment_image_src( $first_image_id, 'retina-thumbnail' );

			$first_image_url[ '1x' ] = $first_image_1x[0];
			$first_image_url[ '2x' ] = $first_image_2x[0];

		} else {

			$first_image_url[ '2x' ] = $first_image_url[ '1x' ];

		}

		return $first_image_url;

	} else {

		return;

	}

}


/**
* Answers the question "Is this a product portal?"
*/

function is_product_portal() {

	global $post;

	$args = array(
		'post_parent'	=> $post->ID,
		'fields'		=> 'ids',
		'post_type'	=> 'page',
	);

	$exclude = array(
		245317, // Insider
		220087, // Lab
		128819, // LabCon
	);

	$children = get_posts( $args );

	if ( is_page() && !in_array( $post->ID, $exclude ) && is_page_template( 'product-page.php' ) && ( count( $children ) > 0 ) ) {

		return true;

	} else {

		return false;

	}

}


/* CARDS **********************/

/**
* Post Cards
*
* Outputs the post card for use in lists of posts. This is used all over the
* place.
*
* @param int $post_id Optional. Accepts a valid post ID.
* @param string $card_top_label Optional.
* @param string $card_bottom_label Optional.
* @param bool $title_only. Whether to show the title by itself, or include the
* byline. Defaults to false (i.e., does show the byline).
*/

function lawyerist_get_post_card( $post_id = null, $card_top_label = null, $card_bottom_label = null, $title_only = false ) {

	// Gets the post object.
	if ( !$post_id ) { global $post; }

	$post_type = get_post_type( $post_id );

	// Assigns card classes based on post type and a couple of special cases.
	$card_classes		= array( 'card' );
	$card_classes[]	= $post_type . '-card';

	if ( !empty( $card_top_label ) || !empty( $card_bottom_label ) ) { $card_classes[] = 'has-card-label'; }

	$post_classes = array();

	// Gets the guest image for case studies, or the post thumbnail for everything else.
	if ( has_category( 'case-studies' ) ) {

		$first_image_url = get_first_image_url( $post_id );

		if ( !empty( $first_image_url ) ) {
			$thumbnail			= '<img class="guest-avatar" srcset="' . $first_image_url[ '1x' ] . ' 1x, ' . $first_image_url[ '2x' ] . ' 2x" src="' . $first_image_url[ '1x' ] . '" />';
			$post_classes[]	= 'has-guest-avatar';
		}

	} elseif ( has_post_thumbnail( $post_id ) ) {

    $thumbnail_id   = get_post_thumbnail_id( $post_id );
    $thumbnail      = wp_get_attachment_image( $thumbnail_id, 'medium' );
		$post_classes[]	= 'has-post-thumbnail';

  }

	// Gets the post title and permalink for the link container.
	$post_title	= get_the_title( $post_id );
	$post_url		= get_permalink( $post_id );

	?>

	<div class="<?php echo implode( ' ', $card_classes ); ?>">

		<?php

		if ( !empty( $card_top_label ) ) {
			echo '<p class="card-label card-top-label">' . $card_top_label . '</p>';
		}

		?>

		<a href="<?php echo $post_url; ?>" title="<?php echo $post_title; ?>" <?php post_class( $post_classes ); ?>>

			<?php

			if ( is_category( 'lab-workshops' ) && has_block( 'embed' ) ) {

				$blocks = parse_blocks( $post->post_content );

				foreach ( $blocks as $block ) {

					if ( $block[ 'blockName' ] == "core/embed" ) {
						echo apply_filters( 'the_content', render_block( $block ) );
						break;
					}

				}

			} elseif ( !empty( $thumbnail ) ) {

				echo $thumbnail;

			}

			?>

			<div class="headline-byline">

				<h2 class="headline" title="<?php echo $post_title; ?>"><?php echo $post_title; ?></h2>

				<?php if ( $post_type == 'post' && $title_only == false ) { ?>

					<div class="postmeta">

						<?php

						$date = get_the_time( 'F jS, Y', $post_id );

						if ( has_category( array( 'case-studies', 'lab-workshops' ) ) ) {

					    echo '<span class="date updated published">' . $date . '</span>';

					  } else {

							$author = get_the_author_meta( 'display_name' );

							if ( $author == 'Lawyerist' ) {
								$author = 'the Lawyerist editorial team';
							}

							if ( has_category( 'sponsored' ) ) {

								$sponsor = get_sponsor_link( $post_id );

								if ( has_tag( 'product-spotlights' ) ) {

									// Adds "sponsored by" after the author on product spotlights.
									echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>,&nbsp;<span class="sponsor">sponsored by ' . $sponsor . '</span>, ';

								} else {

									// Otherwise, replaces the author with the sponsor's name.
						      echo '<span class="sponsor">Sponsored by ' . $sponsor . '</span> ';

								}

						    echo 'on <span class="date updated published">' . $date . '</span>';

							} else {

						    echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span> ';
						    echo 'on <span class="date updated published">' . $date . '</span> ';

						  }

						}

						?>

					</div>

        <?php } ?>

			</div>

		</a>

		<?php

		if ( !empty( $card_bottom_label ) ) {
			echo '<p class="card-label card-bottom-label">' . $card_bottom_label . '</p>';
		}

		?>

	</div>

	<?php

	unset( $thumbnail );

	wp_reset_postdata();

}


/* CONTENT ********************/

/**
* Archive Headers
*
* Headers with the term (category, tag, etc.) name and description for lists.
*/

function lawyerist_get_archive_header() {

	if ( is_search() ) {

		echo '<div id="archive-header"><h1>Search results for "' . get_search_query() . '"</h1></div>';
		echo '<div id="lawyerist_content_search">';
			get_search_form();
		echo '</div>';

	} elseif ( is_category() ) {

		$category			= get_queried_object();
		$cat_image_ID	= get_field( 'cat_featured_image', 'category_' . $category->term_id );
		$cat_image		= wp_get_attachment_image( $cat_image_ID, 'large' );

		$title				= single_term_title( '', FALSE );
		$descr				= term_description();

		echo '<div id="archive-header">' . "\n";

		if ( !empty( $cat_image ) ) { echo $cat_image . "\n"; }

		echo '<h1>' . $title . '</h1>' . "\n";
		echo $descr . "\n";
		echo '</div>';

	} elseif ( is_post_type_archive( array( 'sfwd-lessons', 'sfwd-topic' ) ) ) {

		$course_id 		= learndash_get_course_id( get_the_ID( $post->$post_parent ) );
		$course_title	= get_the_title( $course_id );
		$archive_title = post_type_archive_title( '', FALSE );

		echo '<div id="archive-header">' . "\n";
			echo '<h1>' . $course_title . ' ' . $archive_title . '</h1>' . "\n";
		echo '</div>';

	} else {

		$title			= single_term_title( '', FALSE );
		$descr			= term_description();

		echo '<div id="archive-header">' . "\n";
		echo '<h1>' . $title . '</h1>' . "\n";
		echo $descr . "\n";
		echo '</div>';

	}

}


/**
* Yoast SEO Breadcrumbs
*
* Removes the Products breadcrumb on WooCommerce pages.
*/

function lawyerist_remove_products_breadcrumb( $link_output, $link ) {

	if ( is_really_a_woocommerce_page() && $link[ 'text' ] == 'Products' ) {
		$link_output = '';
	}

	return $link_output;

}

add_filter( 'wpseo_breadcrumb_single_link', 'lawyerist_remove_products_breadcrumb', 10, 2 );


/**
* Inserts the Member Portal as a breadcrumb on LearnDash pages, and some other
* tweaks.
*/

function lawyerist_add_learndash_breadcrumbs( $links ) {

	global $post;

	$post_type = get_post_type( $post->ID );

	if ( $post_type == 'sfwd-courses' ) {

		$replace_course_breadcrumb[] = array(
			'url'		=> 'https://lawyerist.com/labster-portal/',
			'text'	=> 'Member Portal',
		);

		array_splice( $links, 1, 1, $replace_course_breadcrumb );

	}

	if ( $post_type == 'sfwd-lessons' || $post_type == 'sfwd-topic' ) {

		$course_id 		= learndash_get_course_id( $post->ID );
		$course_title	= get_the_title( $course_id );
		$course_url		= get_permalink( $course_id );

		$course_breadcrumb[] = array(
        'url' => $course_url,
        'text' => $course_title,
        );

		array_splice( $links, 1, 0, $course_breadcrumb );

		if ( $post_type == 'sfwd-topic' ) {

			$lesson_id		= learndash_get_lesson_id( $post->ID );
			$lesson_title	= get_the_title( $lesson_id );
			$lesson_url		= get_permalink( $lesson_id );

			$lesson_breadcrumb[] = array(
	        'url' => $lesson_url,
	        'text' => $lesson_title,
	        );

			array_splice( $links, 1, 0, $lesson_breadcrumb );

		}

	}

	return $links;

}

add_filter( 'wpseo_breadcrumb_links', 'lawyerist_add_learndash_breadcrumbs' );


/**
* Add IDs to Headings
*/

function add_ids_to_headings( $content ) {

	if ( !is_main_query() || !has_block( 'core/heading' ) ) { return $content; }

	$pattern = '#(?P<full_tag><(?P<tag_name>h\d)(?P<tag_atts>[^>]*)>(?P<tag_contents>.*)<\/h\d>)#i';

  if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {

    $find			= array();
    $replace	= array();

    foreach( $matches as $match ) {

      if ( strlen( $match[ 'tag_atts' ] ) && false !== stripos( $match[ 'tag_atts' ], 'id=' ) ) {
				continue;
      }

      $find[]    = $match[ 'full_tag' ];
      $id        = sanitize_title( $match[ 'tag_contents' ] );
      $id_attr   = sprintf( ' id="%s"', $id );
      $replace[] = sprintf(
				'<%1$s%2$s%3$s>%4$s</%1$s>',
				$match[ 'tag_name' ],
				$match[ 'tag_atts' ],
				$id_attr,
				$match[ 'tag_contents' ]
			);

    }

    $modified_content = str_replace( $find, $replace, $content );

  }

	return $modified_content;

}

add_filter( 'the_content', 'add_ids_to_headings' );



/**
* Render Table of Contents
*/

function get_toc() {

	global $post;

	if ( !has_block( 'core/heading' ) ) { return; }

  $pattern  = '#<h(?P<level>\d).*?id=[\'|\"](?P<id>[^\'\"]*)[^>]*\>(?P<heading>.*)<\/h\d>#i';
	$content	= add_ids_to_headings( get_the_content() );
  $toc      = null;
  $i        = 1;

  if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {

    ob_start();

	    ?>

	    <div class="card toc-card">

	      <p class="card-label">On this Page</p>

	      <nav class="toc">
	        <ul>

	          <?php foreach ( $matches as $match ) { ?>

	            <?php if ( $match[ 'level' ] == 2 ) { ?>

	              <li>
	                <a href="#<?php echo $match[ 'id' ]; ?>">
	                  <div class="toc-num"><?php echo $i++; ?></div>
	                  <div class="toc-heading"><?php echo strip_tags( $match[ 'heading' ] ); ?></div>
	                </a>
	              </li>

	            <?php } ?>

	          <?php } ?>

	        </ul>
	      </nav>
	    </div>

	    <?php

    $toc = ob_get_clean();

  }

  return $toc;

}


/**
* TOC Fallback
*/

function toc_fallback( $content ) {

	global $post;

	if ( !is_page() || !is_main_query() ) { return $content; }

	if ( has_block( 'core/heading' ) && !has_block( 'acf/table-of-contents' ) && get_field( 'show_table_of_contents' ) !== false ) {

		$toc      = get_toc();
		$splitter = '<h';
		$headings = explode( $splitter, $content );

		foreach ( $headings as $key => $val ) {

			switch ( $key ) {

				case 0:
					$replace = $val;
					break;

				case 1:
					$replace = $toc . $splitter . $val;
					break;

				default:
					$replace = $splitter . $val;
					break;

			}

			$headings[ $key ] = $replace;

		}

		return implode( '', $headings );

	} else {

		return $content;

	}

}

add_filter( 'the_content', 'toc_fallback' );


/**
* Author Bios
*
* Outputs the author bio box at the bottom of posts and pages.
*/

function lawyerist_get_author_bio() {

	global $wp_query;

	$author               = $wp_query->query_vars[ 'author' ];
	$author_name          = get_the_author_meta( 'display_name' );
	$author_bio           = get_the_author_meta( 'description' );

	$author_avatar     		= get_avatar( get_the_author_meta( 'user_email' ), 300, '', $author_name );

	$author_url       		= get_the_author_meta( 'user_url' );
	$author_url_parsed    = parse_url( $author_url );
	$author_url_host  		= $author_url_parsed[ 'host' ];

	$twitter_username     = get_the_author_meta( 'twitter' );

	$linkedin_url  				= get_the_author_meta( 'linkedin' );
	$linkedin_url_parsed 	= parse_url( $linkedin_url );
	$linkedin_username		= $linkedin_url_parsed[ 'path' ];

	?>

	<div class="author-bio-box card">
		<?php echo $author_avatar; ?>
		<div class="author-bio-connect">
			<div class="author-bio"><?php echo $author_bio; ?></div>
			<div class="author-connect">

				<?php if ( $twitter_username == true ) { ?>
					<p class="author-twitter"><a href="https://twitter.com/<?php echo $twitter_username; ?>">@<?php echo $twitter_username; ?></a></p>
				<?php } ?>

				<?php if ( $linkedin_username == true ) { ?>
					<p class="author-linkedin"><a href="<?php echo $linkedin_url; ?>"><?php echo $linkedin_url; ?></a></p>
				<?php } ?>

				<?php if ( $author_url == true ) { ?>
					<p class="author-website"><a href="<?php echo $author_url; ?>"><?php echo $author_url; ?></a></p>
				<?php } ?>

			</div>
		</div>
	</div>

	<?php

}


/**
* List of Coauthors
*
* Adds a list of coathors at the bottom of posts and pages, if there are any.
*/

function lawyerist_get_coauthors() {

	global $wp_query;

	$coauthors = get_coauthors();

	if ( count( $coauthors ) > 1 ) {

	  // Removes the primary author.
	  unset( $coauthors[0] );

    $coauthor_list = array();

    foreach ( $coauthors as $coauthor ) {

			$profile_page_url = get_field( 'profile_page', 'user_' . $coauthor->data->ID );

      if ( count_user_posts( $coauthor->data->ID ) >= 5 && !empty( $profile_page_url ) ) {

        $coauthor_list[] = '<span class="vcard author"><cite class="fn"><a href="' . $profile_page_url . '">' . $coauthor->data->display_name . '</a></cite></span>';

      } else {

        $coauthor_list[] = '<span class="vcard author"><cite class="fn">' . $coauthor->data->display_name . '</cite></span>';

      }

    }

    if ( count( $coauthor_list ) === 1 ) {

      echo $coauthor_list[ 0 ];

    } elseif ( count( $coauthor_list ) === 2 ) {

      echo implode( ' and ', $coauthor_list );

    } else {

      echo implode( ', ', array_slice( $coauthor_list, 0, -1 ) ) . ', and ' . end( $coauthor_list );

    }

	  echo ' also contributed to this page.';

	}

}


/**
* Get Alternative Products
*
* Outputs alternative products on product pages if any are selected.
*/

function lawyerist_get_alternative_products() {

	global $post;

	$page_title		= get_the_title ( $post->ID );
	$alternatives = get_field( 'alternative_products' );

	if ( !empty( $alternatives ) ) {

		?>

		<h2>Alternatives to <?php echo $page_title; ?></h2>

		<div id="alternative-products" class="cards cards-6-columns">

			<?php

			foreach ( $alternatives as $alternative ) {

				$alt_title			= get_the_title( $alternative );
				$alt_url				= get_permalink( $alternative );

				if ( has_post_thumbnail() ) {

					$alt_thumbnail_id   = get_post_thumbnail_id( $alternative );
					$alt_thumbnail      = wp_get_attachment_image( $alt_thumbnail_id, 'thumbnail' );

				}

				?>

				<div class="card">
					<a href="<?php echo $alt_url; ?>" title="<?php echo $alt_title; ?>" class="has-post-thumbnail">
						<?php if ( !empty( $alt_thumbnail ) ) { echo $alt_thumbnail; } ?>
						<div class="headline-byline">
								<h2 class="headline"><?php echo $alt_title; ?></h2>
						</div>
					</a>
				</div>

				<?php

				unset( $alt_thumbnail );

			}

			?>

		</div>

		<?php

	}

}


/*------------------------------
Get Related Posts

This is used on product pages to show related posts by matching the current page
slug to a tag slug.
------------------------------*/

function lawyerist_get_related_posts() {

	global $post;

	$current_id[]		= $post->ID;
	$current_slug		= $post->post_name;
	$current_title	= $post->post_title;

	if ( !empty( $current_slug ) ) {

		$args = array(
			'category__not_in'	=> array(
				43419,	// Excludes Lab workshops.
			),
			'post__not_in'		=> $current_id,
			'posts_per_page'	=> -1,
			'tag' 						=> $current_slug,
		);

		$lawyerist_related_posts_query = new WP_Query( $args );

		if ( $lawyerist_related_posts_query->have_posts() ) :

			echo '<h2>Posts About ' . $current_title . '</h2>';

			echo '<div id="related-posts">';

				while ( $lawyerist_related_posts_query->have_posts() ) : $lawyerist_related_posts_query->the_post();

					lawyerist_get_post_card( $post->ID );

				endwhile; wp_reset_postdata();

			echo '</div>';

		endif;

	}

}


/*------------------------------
Get Related Resources

This is used on posts to show related resource pages by matching the post tags
to resource page slugs. If it doesn't find at least 4 resource pages, it adds
recent posts with any of the same tags.
------------------------------*/

function lawyerist_get_related_resources() {

	global $post;

	if ( is_singular( 'post' ) ) {

		$current_id[]				= $post->ID;
		$current_tags				= get_the_tags( $post->ID );
		$current_tags_slugs	= array();

		if ( !empty( $current_tags ) ) {

			foreach( $current_tags as $current_tag ) {
				array_push( $current_tags_slugs, $current_tag->slug );
			}

			echo '<div id="related-resources">';

				echo '<h2>More Resources</h2>';

				$args = array(
					'post__not_in'		=> $current_id,
					'posts_per_page'	=> 4,
					'post_type'				=> 'page',
					'post_name__in' 	=> $current_tags_slugs,
				);

				$related_pages		= new WP_Query( $args );
				$resources_count	= $related_pages->post_count;

				if ( $related_pages->have_posts() ) : while ( $related_pages->have_posts() ) : $related_pages->the_post();

					lawyerist_get_post_card();

				endwhile; endif;

				if ( $resources_count < 4 ) {

					$args = array(
						'category__not_in'	=> array(
							1320,		// Excludes sponsored posts.
							43419,	// Excludes Lab workshops.
						),
						'orderby'						=> 'date',
						'post__not_in'			=> $current_id,
						'posts_per_page'		=> 4 - $resources_count,
						'post_type'					=> 'post',
						'tag_slug__in' 			=> $current_tags_slugs,
					);

					$related_posts = new WP_Query( $args );

					if ( $related_posts->have_posts() ) : while ( $related_posts->have_posts() ) : $related_posts->the_post();

						lawyerist_get_post_card( '', '', '', true );

					endwhile; wp_reset_postdata(); endif;

				}

			echo '</div>';

		}

	}

}


/*------------------------------
Remove Inline Width from Image Captions

At some point I decided this looked dumb. ¯\_(ツ)_/¯
------------------------------*/

function lawyerist_remove_caption_padding( $width ) {
	return $width - 10;
}

add_filter( 'img_caption_shortcode_width', 'lawyerist_remove_caption_padding' );


/*------------------------------
Featured Images in RSS Feeds

Adds featured images to RSS feeds.
------------------------------*/

function featuredtoRSS( $content ) {

	global $post;

	if ( has_post_thumbnail( $post->ID ) ) {
		$content = '' . get_the_post_thumbnail( $post->ID, 'large', array( 'style' => 'display:block; height:auto; margin:0 0 15px 0; width:560px;' ) ) . '' . $content;
	}

	return $content;

}

add_filter( 'the_excerpt_rss', 'featuredtoRSS' );
add_filter( 'the_content_feed', 'featuredtoRSS' );


/*------------------------------
Remove Lab Workshops from Sitemap

We don't want Google to index them becuase they are restricted to Lab members
and there is no unrestricted content on the pages for Google to index.
------------------------------*/

function remove_workshops_from_sitemap( $excluded_posts_ids ) {

	$args = array(
		'fields'					=> 'ids',
		'post_type'				=> 'post',
		'category_name'		=> 'lab-workshops',
		'posts_per_page'	=> -1,
	);

	return array_merge( $excluded_posts_ids, get_posts( $args ) );

}

add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'remove_workshops_from_sitemap' );


/*------------------------------
Remove Lab Workshops from RSS Feed

See above.
------------------------------*/

function remove_workshops_from_feed( $query ) {

	if ( $query->is_feed() ) {
		$query->set( 'post_type', 'post' );
		$query->set( 'cat', '-43419' );
	}

	return $query;

}

add_filter( 'pre_get_posts', 'remove_workshops_from_feed' );


/*------------------------------
Remove Default Gallery Styles

I guess I didn't like these. ¯\_(ツ)_/¯
------------------------------*/

add_filter( 'use_default_gallery_style', '__return_false' );


/* PARTNERSHIPS	***************/

/*------------------------------
Platinum Sponsors Widget

Creates the platinum sidebar widget (the only thing currently in the sidebar)
and adds a tracking code to the URL so we can report clicks.
------------------------------*/

function lwyrst_plat_sponsors_widget() {

	$args = array(
		'orderby'					=> 'rand',
		'post_type'				=> 'page',
		'posts_per_page'	=> -1,
		'tax_query' => array(
      array(
				'taxonomy' => 'page_type',
				'field'    => 'slug',
				'terms'    => 'platinum-sponsor',
			),
		),
	);

	$plat_sponsors_query = new WP_Query( $args );

	if ( $plat_sponsors_query->have_posts() ) :

		echo '<div id="platinum-sponsors-widget">';

			echo '<h3>Platinum Sponsors</h3>';

			echo '<div id="platinum-sponsors">';

				while ( $plat_sponsors_query->have_posts() ) : $plat_sponsors_query->the_post();

					if ( get_field( 'platinum_sidebar_image' ) ) {

						$product_page_title	= the_title( '', '', FALSE );
						$product_page_url		= get_permalink();
						$plat_sidebar_img		= get_field( 'platinum_sidebar_image' );

						echo '<a href="' . $product_page_url . '?utm_source=lawyerist&amp;utm_medium=platinum_sidebar_widget">';
							echo wp_get_attachment_image( $plat_sidebar_img, 'large' );
						echo '</a>';

					}

				endwhile; wp_reset_postdata();

			echo '</div>';

		echo '</div>';

	endif;

}


/*------------------------------
Affinity Benefit Notice

Adds an affinity benefit notice at the top of product pages. Requires
WooCommerce Memberships to determine which message to show. Also requires AFC
for the custom fields that define the benefit details.
------------------------------*/

function affinity_notice() {

	if ( !function_exists( 'wc_memberships' ) ) { return; }

	global $post;

	ob_start();

		$availability = get_field( 'affinity_availability' );

		switch ( $availability ) {

			case $availability == 'new_only':

				$whom = 'new customers';
				break;

			case $availability == 'old_only':

				$whom = 'existing customers';
				break;

			case $availability == 'both_new_and_old':

				$whom = 'new & existing customers';
				break;

		}

		$card_label = 'Discount Available to ' . $whom;

		$user_id = get_current_user_id();

		if ( wc_memberships_is_user_active_member( $user_id, 'insider' ) ) {

			$discount_descr	= get_field( 'affinity_discount_descr' );

		} else {

			$post_title			= the_title( '', '', FALSE );
			$discount_descr = $post_title . ' offers a discount to ' . $whom . ' through our Affinity Benefits program. The details of this discount are only available to members. <a href="https://lawyerist.com/affinity-benefits/">Learn more about the Affinity Benefits program</a> or <a class="login-link" href="https://lawyerist.com/account/">log in</a> if you are a member of Insider or Lab.';

		}

		$theme_dir = get_template_directory_uri();

		?>

		<div class="card affinity-discount-card">

			<img alt="Lawyerist affinity partner badge." src="<?php echo $theme_dir; ?>/images/affinity-partner-badge.png" height="128" width="150" />
			<p class="card-label"><?php echo $card_label; ?></p>
			<p class="discount_descr"><?php echo $discount_descr; ?></p>

			<?php if ( wc_memberships_is_user_active_member( $user_id, 'insider' ) ) { ?>

				<button class="button expandthis-click">Claim Your Discount</button>
				<div class="expandthis-hide">
					<?php echo do_shortcode( '[gravityform id="55" title="false" ajax="true"]' ); ?>
				</div>

			<?php } ?>

			</div>
		</div>

		<?php

	$affinity_notice = ob_get_clean();

	return $affinity_notice;

}


/* COMMENTS & REVIEWS *********/

/*------------------------------
Custom Default Gravatar
------------------------------*/

function lawyerist_custom_gravatar ( $avatar_defaults ) {

	$lawyerist_avatar = get_bloginfo( 'template_directory' ) . '/images/lawyerist-default-avatar.png';
	$avatar_defaults[ $lawyerist_avatar ] = "Lawyerist Insider";

	return $avatar_defaults;

}

add_filter( 'avatar_defaults', 'lawyerist_custom_gravatar' );


/*------------------------------
Show Commenter's First Name & Initial
------------------------------*/

function lawyerist_comment_author_name( $author = '' ) {

	$comment = get_comment( $comment_ID );

	if ( !empty( $comment->comment_author ) ) {

		if ( !empty( $comment->user_id ) ) {

			$user		= get_userdata( $comment->user_id );
			$author	= $user->first_name . ' ' . substr( $user->last_name, 0, 1 ) . '.';

		} else {

			$author	= $comment->comment_author;

		}

	} else {

		$author = __( 'Anonymous' );

	}

	return $author;
}

add_filter( 'get_comment_author', 'lawyerist_comment_author_name', 10, 1 );


/*------------------------------
Reviews
------------------------------*/

// Modify WP Review Pro JSON schema output.
function lwyrst_wp_review_pro_schema( $output, $review ) {

	if ( ( is_single() || is_page() ) && !is_product_portal() ) {

		$schema_json							= strip_tags( $output );
		$schema_obj   						= json_decode( $schema_json );

		$schema_obj->{ '@type' }	= $schema_obj->itemReviewed->{ '@type' };
		$schema_obj->name					= get_the_title();

		$post_id		= get_the_ID();
		$parent_id	= wp_get_post_parent_id( $post_id );

		$schema_obj->description	= get_the_title( $parent_id );

		$schema_obj->review 							= new StdClass();
		$schema_obj->review->{ '@type' } 	= 'Review';

		$schema_obj->review->author				= new StdClass();
		$schema_obj->review->author->{ '@type' } = get_the_author_meta( 'display_name' ) == 'Lawyerist' ? 'Organization' : 'Person';
		$schema_obj->review->author->name	= get_the_author_meta( 'display_name' );

		switch ( $schema_obj->{ '@type' } ) {

			case 'SoftwareApplication':

				$post_id		= get_the_ID();
				$parent_id	= wp_get_post_parent_id( $post_id );

				$schema_obj->applicationCategory = get_the_title( $parent_id );

				unset( $schema_obj->reviewBody );

				break;

			case 'Product':

				$schema_obj->review->reviewBody 	= get_the_excerpt();

				break;

		}


		$our_rating		= lwyrst_get_our_rating();
		$rating_count	= lwyrst_get_community_review_count();

		if ( !empty( $our_rating ) ) {
			$rating_count++;
		}

		$schema_obj->aggregateRating 							= new stdClass();
		$schema_obj->aggregateRating->{ '@type' } = 'AggregateRating';
		$schema_obj->aggregateRating->ratingValue = lwyrst_get_composite_rating();
		$schema_obj->aggregateRating->bestRating  = 5;
		$schema_obj->aggregateRating->ratingCount = $rating_count;

		unset( $schema_obj->author );
		unset( $schema_obj->reviewRating );
		unset( $schema_obj->itemReviewed );

		if ( version_compare( phpversion(), '7.1', '>=' ) ) {
	    ini_set( 'serialize_precision', -1 );
		}

		$output  = '<script type="application/ld+json">' . PHP_EOL;
		$output .= wp_json_encode( $schema_obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . PHP_EOL;
		$output .= '</script>' . PHP_EOL;

		return $output;

	} else {

		return false;

	}

}

add_filter( 'wp_review_get_schema', 'lwyrst_wp_review_pro_schema', 10, 2 );



// Gets the author rating ("our" rating) from WP Review Pro, and converts it
// from a 10-point scale to a 5-point scale. Rounds to one decimal point.
function lwyrst_get_our_rating( $product_id = null ) {

	if ( ! $product_id ) {
		global $post;
		$product_id = get_the_ID();
	}

	$our_rating_raw	= get_post_meta( $product_id, 'wp_review_total', true );
	$our_rating			= round( floatval( $our_rating_raw ) / 2, 1 );

	return $our_rating;

}

// Gets the comments rating ("community" rating) from WP Review Pro. Rounds to
// one decimal point.
function lwyrst_get_community_rating( $product_id = null ) {

	if ( ! $product_id ) {
		global $post;
		$product_id = get_the_ID();
	}

	$community_rating = round( get_post_meta( $product_id, 'wp_review_comments_rating_value', true ), 1 );

	return $community_rating;

}

// Gets the number of comment reviews ("community" reviews) from WP Review Pro.
function lwyrst_get_community_review_count( $product_id = null ) {

	if ( ! $product_id ) {
		global $post;
		$product_id = get_the_ID();
	}

	$community_review_count	= get_post_meta( $product_id, 'wp_review_comments_rating_count', true );

	return intval( $community_review_count );

}

// Calculates the composite rating. If only one rating exists, that rating is
// returned. If both ratings exist, it combines them. The output is rounded to
// one decimal point.
function lwyrst_get_composite_rating( $product_id = null ) {

	if ( ! $product_id ) {
		global $post;
		$product_id = $post->ID;
	}

	$our_rating							= lwyrst_get_our_rating( $product_id );
	$community_rating				= lwyrst_get_community_rating( $product_id );
	$community_review_count	= lwyrst_get_community_review_count( $product_id );

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
function lwyrst_product_rating( $rating_type = null ) {

	switch ( $rating_type ) {

		case 'our_rating':

			$rating				= lwyrst_get_our_rating();
			$rating_count	=	1;
			break;

		case 'community_rating':

			$rating				= lwyrst_get_community_rating();
			$rating_count	=	lwyrst_get_community_review_count();
			break;

		default:

			$rating				= lwyrst_get_composite_rating();
			$our_rating		= lwyrst_get_our_rating();

			if ( !empty( $our_rating ) ) {
				$rating_count	=	intval( lwyrst_get_community_review_count() ) + 1;
			} else {
				$rating_count	=	intval( lwyrst_get_community_review_count() );
			}

			break;

	}

	ob_start();

		echo lwyrst_star_rating( $rating );

		?>

		<span><?php echo $rating; ?>/5 (based on <?php echo $rating_count; ?> <?php echo _n( 'rating', 'ratings', $rating_count ); ?>)</span>

		<?php

	return ob_get_clean();

}


/**
* Outputs the star rating.
*
* @param int $rating Optional. Defaults to composite rating.
*/
function lwyrst_star_rating( $rating = null ) {

	if ( ! $rating ) {
		$rating	= lwyrst_get_composite_rating();
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

	$lwyrst_star_rating = ob_get_clean();

	return $lwyrst_star_rating;

}


/* GRAVITY FORMS **************/

/*------------------------------
Enable CC Field on Form Notifications.
------------------------------*/

function gf_enable_cc( $enable, $notification, $form ){
  return true;
}

add_filter( 'gform_notification_enable_cc', 'gf_enable_cc', 10, 3 );


/*------------------------------
Populate Form Fields
------------------------------*/

function populate_fields( $value, $field, $name ) {

	global $post;

	$post_title	= the_title( '', '', FALSE );

	$user_ID						= get_current_user_id();

	$discount_descr			= get_field( 'affinity_discount_descr' );
	$availability				= get_field( 'affinity_availability' );
	$workflow						= get_field( 'affinity_workflow' );
	$claim_url					= get_field( 'affinity_claim_url' );
	$claim_code					= get_field( 'affinity_claim_code' );
	$notification_email	= get_field( 'affinity_notification_email' );

	switch ( $availability ) {

		case $availability == 'new_only':

			$whom = 'new ' . $post_title . ' customers only';
			break;

		case $availability == 'old_only':

			$whom = 'existing ' . $post_title . ' customers only';
			break;

		case $availability == 'both_new_and_old':

			$whom = 'both new and existing ' . $post_title . ' customers';
			break;

	}

  $values = array(
		'user-id'											=> $user_ID,
		'affinity-discount'						=> $discount_descr,
		'affinity-availability'				=> $whom,
    'affinity-workflow'						=> $workflow,
		'affinity-claim-url'					=> $claim_url,
		'affinity-claim-code'					=> $claim_code,
    'affinity-notification-email'	=> $notification_email,
  );

  return isset( $values[ $name ] ) ? $values[ $name ] : $value;

}

add_filter( 'gform_field_value', 'populate_fields', 10, 3 );


/*------------------------------
Auto-Login New Users
------------------------------*/

function lawyerist_gf_registration_autologin( $user_id, $user_config, $entry, $password ) {

	$user						= get_userdata( $user_id );
	$user_login			= $user->user_login;
	$user_password	= $password;

		$user->set_role( get_option( 'default_role', 'subscriber' ) );

    wp_signon( array(
			'user_login'		=> $user_login,
			'user_password'	=> $user_password,
			'remember'			=> true,
    ) );

}

add_action( 'gform_user_registered', 'lawyerist_gf_registration_autologin',  10, 4 );


/* WOOCOMMERCE ****************/

/*------------------------------
WooCommerce Setup
------------------------------*/

/* Declare WooCommerce support. */
function lawyerist_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'lawyerist_woocommerce_support' );


/* Apply a new credit card to all subscriptions by default. */
add_filter( 'wcs_update_all_subscriptions_payment_method_checked', '__return_true' );


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
Checkout Fields
------------------------------*/

function lawyerist_checkout_fields( $fields ) {

	// Disables all billing fields except the name, email address, and country.
	unset( $fields[ 'billing' ][ 'billing_company' ] );
	unset( $fields[ 'billing' ][ 'billing_address_1' ] );
	unset( $fields[ 'billing' ][ 'billing_address_2' ] );
	unset( $fields[ 'billing' ][ 'billing_city' ] );
	unset( $fields[ 'billing' ][ 'billing_phone' ] );

	// Disables the order comments/notes field.
	unset( $fields[ 'order' ][ 'order_comments' ] );

	// Changes field labels.
	$fields[ 'billing' ][ 'billing_postcode' ][ 'label' ] = 'Zip code';

	// Adds our demographic questions.
	$fields[ 'order' ][ 'firm_size' ] = array(
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

	$fields[ 'order' ][ 'firm_role' ] = array(
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

	$fields[ 'order' ][ 'practice_area' ] = array(
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

	return $fields;

}

add_filter( 'woocommerce_checkout_fields' , 'lawyerist_checkout_fields' );


/* Update the Order Meta */

function lawyerist_checkout_fields_update_order_meta( $order_id ) {

	if ( !empty( $_POST[ 'firm_size' ] ) ) {
		update_post_meta( $order_id, 'firm_size', sanitize_text_field( $_POST[ 'firm_size' ] ) );
	}

	if ( !empty( $_POST[ 'firm_role' ] ) ) {
		update_post_meta( $order_id, 'firm_role', sanitize_text_field( $_POST[ 'firm_role' ] ) );
	}

	if ( !empty( $_POST[ 'practice_area' ] ) ) {
		update_post_meta( $order_id, 'practice_area', sanitize_text_field( $_POST[ 'practice_area' ] ) );
	}

}

add_action( 'woocommerce_checkout_update_order_meta', 'lawyerist_checkout_fields_update_order_meta' );


/*------------------------------
Display Price of Free Products As "Free!" Not "$0.00".
------------------------------*/

function lawyerist_wc_free_products( $price, $product ) {

	global $woocommerce;

	if ( $product->get_price() == 0 ) {

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
Remove My Account Navigation Items
------------------------------*/

function lawyerist_remove_my_account_links( $menu_links ){

	// unset( $menu_links[ 'dashboard' ] );
	// unset( $menu_links[ 'orders' ] );
	unset( $menu_links[ 'subscriptions' ] );
	unset( $menu_links[ 'downloads' ] );
	unset( $menu_links[ 'edit-address' ] );
	// unset( $menu_links[ 'payment-methods' ] );
	// unset( $menu_links[ 'edit-account' ] );
	// unset( $menu_links[ 'customer-logout' ] );

	/* This method doesn't work for removing the "Memberships" link, so we do that
	by removing the endpoint in WooCommerce > Settings > Advanced. */

	return $menu_links;

}

add_filter ( 'woocommerce_account_menu_items', 'lawyerist_remove_my_account_links' );


/*------------------------------
Remove Membership & Subscription Details from WC Order & Thank-You Pages
------------------------------*/

add_filter( 'woocommerce_memberships_thank_you_message', '__return_empty_string' );

remove_action( 'woocommerce_thankyou', 'WC_Subscriptions_Order::subscription_thank_you' );
remove_action( 'woocommerce_order_details_after_order_table', 'WC_Subscriptions_Order::add_subscriptions_to_view_order_templates', 10, 1 );


/*------------------------------
Hide Product Categories & Tags
------------------------------*/

// Overwrites product_tag taxonomy properties to hide it from the WP admin.
add_action( 'init', function() {
  register_taxonomy( 'product_tag', 'product', [
    'public'            => false,
    'show_ui'           => false,
    'show_admin_column' => false,
    'show_in_nav_menus' => false,
    'show_tagcloud'     => false,
  ]);
}, 100 );


// And remove tags from the Products table.
add_action( 'admin_init' , function() {
  add_filter( 'manage_product_posts_columns', function( $columns ) {
    unset( $columns[ 'product_tag' ] );
    return $columns;
  }, 100 );
});


// Overwrites product_cat taxonomy properties to hide it from the WP admin.
add_action( 'init', function() {
  register_taxonomy( 'product_cat', 'product', [
    'public'            => false,
    'show_ui'           => false,
    'show_admin_column' => false,
    'show_in_nav_menus' => false,
    'show_tagcloud'     => false,
  ]);
}, 100 );

// And remove categories from the Products table.
add_action( 'admin_init' , function() {
  add_filter( 'manage_product_posts_columns', function( $columns ) {
    unset( $columns[ 'product_cat' ] );
    return $columns;
  }, 100 );
});


/* LEARNDASH ******************/

/*------------------------------
Disable Comments on LearnDash Pages
------------------------------*/

function ld_disable_comments() {

	remove_post_type_support( 'sfwd-courses', 'comments' );
	remove_post_type_support( 'sfwd-lessons', 'comments' );
	remove_post_type_support( 'sfwd-topic', 'comments' );
	remove_post_type_support( 'sfwd-quiz', 'comments' );
	remove_post_type_support( 'sfwd-essays', 'comments' );

}

add_filter( 'init', 'ld_disable_comments' );


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
