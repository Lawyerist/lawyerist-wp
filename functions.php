<?php

/* INDEX

SETUP
- Stylesheets & Scripts
- Theme Setup
- Template Files

STRUCTURE
- Nav Menu
- Sidebar

ADMIN
- Login Form
- Remove Menu Items

UTILITY FUNCTIONS
- Get Country
- Get First Image URL
- Is This a Product Portal?
- Get Active Labsters

CARDS
- Post Cards

CONTENT
- Archive Headers
- Yoast SEO Breadcrumbs
- Author Bios
- Show Pages in Author Archives
- List of Coauthors
- Custom Default Gravatar
- Get Alternative Products
- Get Related Podcasts
- Get Related Posts
- Get Related Pages
- List Child Pages Fallback
- Remove Inline Width from Image Captions
- Featured Images in RSS Feeds
- Remove Hidden Products from RSS Feed
- Remove Default Gallery Styles
- Show Commenter's First Name & Initial

PARTNERSHIPS
- Display Ad
- Mobile Display Ad
- Platinum Sidebar Widget
- Affinity Benefit Notice

COMMENTS & REVIEWS
- Reviews

GRAVITY FORMS
- Enable CC Field on Form Notifications
- Populate Form Fields
- Auto-Login New Users

WOOCOMMERCE
- WooCommerce Setup
- Check to See if Page is Really a WooCommerce Page
- Check to See if a Product ID is in the Cart
- Checkout Fields
- Display Price of Free Products As "Free!" Not "$0.00".
- Remove My Account Navigation Items

LEARNDASH
- Disable Comments on LearnDash Pages

TAXONOMY
- Disable Tag Archives
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

	// Load the comment-reply script, but only if we're on a single post page and comments are open and threaded.
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


/*------------------------------
Theme Setup
------------------------------*/

function lawyerist_theme_setup() {

	add_theme_support( 'html5', array( 'search-form' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'wp-block-styles' );

}

add_action( 'after_setup_theme', 'lawyerist_theme_setup' );


/*------------------------------
Template Files
------------------------------*/

require_once( 'shortcodes.php' );



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

add_action( 'init', 'lawyerist_register_menus' );


/**
* Get Login/Register
*
* @param $version. Can be 'menu' or 'modal'.
*/
function get_lawyerist_login( $version = null ) {

	ob_start();

	if ( $version == 'menu' ) {
		$gf_id = 58;
	} elseif ( $version == 'modal' ) {
		$gf_id = 59;
	}

	?>

	<div id="lawyerist-login"<?php if ( $version == 'modal' ) { echo ' class="modal"'; } ?>>

		<div id="lawyerist-login-container"<?php if ( $version == 'modal' ) { echo ' class="card"'; } ?>>

			<?php if ( $version == 'modal' ) { ?>
				<button class="greybutton dismiss-button"></button>
			<?php } ?>

			<li id="login">
				<h2>Log In</h2>
				<p>Not an Insider yet? <a class="register-link">Register here.</a></p>
				<?php wp_login_form(); ?>
				<p class="remove_bottom">Forgot your password? <a href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>" alt="<?php esc_attr_e( 'Lost Password', 'textdomain' ); ?>" class="forgot-password-link">Reset it here.</a></p>
			</li>

			<li id="register">
				<?php if ( !is_user_logged_in() ) { ?>
					<h2>Join Lawyerist Insider</h2>
					<?php echo do_shortcode( '[gravityform id="' . $gf_id . '" title="false" ajax="true"]' ); ?>
					<p class="remove_bottom"><a class="back-to-login-link">Back to login.</a></p>
				<?php } else { ?>
					<h2>Welcome to the Lawyerist Community!</h2>
					<p>Welcome to the Lawyerist Insider community! You can keep doing what you were doing, but don't forget to check out the free resources in the <a href="https://lawyerist.com/community/insider/library/">Insider Library</a>. And if you are a solo or small-firm lawyer in the US or Canada, please <a href="https://www.facebook.com/groups/lawyeristinsiders/">join our private Facebook Group for Insiders</a>.</p>
				<?php } ?>
			</li>

		</div>

	</div>

	<?php if ( $version == 'modal' ) { ?>
		<div id="lawyerist-login-screen" style="display: none;"></div>
	<?php } ?>

	<?php

	$lawyerist_login = ob_get_clean();

	return $lawyerist_login;

}


function lawyerist_loginout( $items, $args ) {

	if ( !function_exists( 'wc_memberships' ) ) {
    return;
  }

	if ( is_user_logged_in() && $args->theme_location == 'header-nav-menu' ) {

		ob_start();

		?>

			<li class="menu-item menu-item-loginout menu-item-has-children">

				<a>Account</a>

				<ul class="sub-menu">

					<li class="menu-item"><a href="https://lawyerist.com/account/">My Account</a>

					<?php if ( wc_memberships_is_user_active_member( get_current_user_id(), 'lab' ) ) { ?>
						<li class="menu-item"><a href="https://lawyerist.com/labster-portal/">Member Portal</a></li>
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

				<a>Log In</a>

				<ul class="sub-menu">

					<?php echo get_lawyerist_login( 'menu' ); ?>

				</ul>

			</li>

		<?php

		$new_items = ob_get_clean();

		$items .= $new_items;

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


/*------------------------------
Remove Menu Items
------------------------------*/

function lawyerist_remove_admin_bar_items( $wp_admin_bar ) {

	// Remove from the +New menu.
	$wp_admin_bar->remove_node( 'new-link' );
	$wp_admin_bar->remove_node( 'new-media' );
	$wp_admin_bar->remove_node( 'new-product' );
	$wp_admin_bar->remove_node( 'new-shop_coupon' );
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
add_action( 'admin_bar_menu', 'lawyerist_remove_admin_bar_items', 999 );


function lawyerist_remove_stubborn_admin_bar_items() {

	global $wp_admin_bar;

	// replace 'updraft_admin_node' with your node id
	$wp_admin_bar->remove_menu( 'gravityforms-new-form' );

}
add_action( 'wp_before_admin_bar_render', 'lawyerist_remove_stubborn_admin_bar_items', 999 );



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
Get Sponsor
------------------------------*/

function get_sponsor() {

	global $post;

	if ( has_term( true, 'sponsor' ) ) {

		$sponsor_IDs = wp_get_post_terms(
			$post->ID,
			'sponsor',
			array(
				'fields' 	=> 'ids',
				'orderby' => 'count',
				'order' 	=> 'DESC',
			),
		);

		$sponsor_info = get_term( $sponsor_IDs[0] );
		$sponsor      = $sponsor_info->name;

		if ( !empty( $sponsor ) ) {

			return $sponsor;

		}

	} else {

		return;

	}

}


function get_sponsor_link() {

	global $post;

	if ( has_term( true, 'sponsor' ) ) {

		$sponsor_IDs = wp_get_post_terms(
			$post->ID,
			'sponsor',
			array(
				'fields' 	=> 'ids',
				'orderby' => 'count',
				'order' 	=> 'DESC',
			),
		);

		$sponsor_info = get_term( $sponsor_IDs[0] );
		$sponsor      = $sponsor_info->name;
		$sponsor_url  = filter_var( $sponsor_info->description, FILTER_SANITIZE_URL );

		if ( !empty( $sponsor_url ) ) {

			$sponsor_link = '<a href="' . $sponsor_url . '">' . $sponsor . '</a>';

			return $sponsor_link;

		} else {

			return $sponsor;

		}

	} else {

		return;

	}

}


/*------------------------------
Get First Image URL
------------------------------*/

function get_first_image_url( $post_ID = NULL ) {

	if ( empty( $post_ID ) ) {
		global $post;
	} else {
		$post = get_post( $post_ID );
	}

	$first_image_url = '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

	if ( !empty( $matches[1][0] ) ) {

		$first_image_url = filter_var( $matches[1][0], FILTER_SANITIZE_URL );

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


/*------------------------------
Get Active Labsters
------------------------------*/

function get_active_labsters() {

	$labster_query_args = array(
		'post_type'				=> 'wc_user_membership',
		'post_status'			=> 'wcm-active',
		'post_parent'			=> 223685,
		'posts_per_page'	=> -1,
	);

	$labster_query = new WP_Query( $labster_query_args );

	if ( $labster_query->have_posts() ) :

		$labsters	= array();

		while ( $labster_query->have_posts() ) : $labster_query->the_post();

			array_push( $labsters, array(
				'labster_id'	=> get_the_ID(),
				'email'				=> get_the_author_meta( 'user_email' ),
				'first_name'	=> get_the_author_meta( 'user_firstname' ),
				'last_name'		=> get_the_author_meta( 'user_lastname' ),
			) );

		endwhile; wp_reset_postdata();

		// Sorts $labsters[] by last name.
		usort( $labsters, function( $a, $b ) {
			return $a[ 'last_name' ] <=> $b[ 'last_name' ];
		});

		return $labsters;

	else :

		return;

	endif;

}


/* CARDS **********************/

/**
* Post Cards
*
* @param int $post_ID Optional. Accepts a valid post ID.
* @param string $card_top_label Optional.
* @param string $card_bottom_label Optional.
* @param bool $title_only. Whether to show the title by itself, or include the
* byline. Defaults to false (i.e., does show the byline).
*/

function lawyerist_get_post_card( $post_ID = null, $card_top_label = null, $card_bottom_label = null, $title_only = false ) {

	// Gets the post object.
	if ( empty( $post_ID ) ) {

		global $post;
		$post_ID = $post->ID;

	} else {

		$post = get_post( $post_ID );

	}

	$post_type = get_post_type( $post_ID );

	// Assigns card classes based on post type and a couple of special cases.
	$card_classes		= array( 'card' );
	$card_classes[]	= $post_type . '-card';

	if ( has_category( 'lawyerist-podcast' ) ) { $card_classes[] = 'podcast-card'; }
	if ( has_tag( 'how-lawyers-work' ) ) { $card_classes[] = 'hlw-card'; }
	if ( is_page_template( 'product-page.php' ) ) { $card_classes[] = 'product-page-card'; }
	if ( !empty( $card_top_label ) || !empty( $card_bottom_label ) ) { $card_classes[] = 'has-card-label'; }

	$post_classes = array();

	// Gets the guest image for podcast and How Lawyers Work posts, or the post
	// thumbnail for everything else.
	if ( has_category( 'lawyerist-podcast' ) || has_tag( 'how-lawyers-work' ) ) {

		$first_image_url = get_first_image_url( $post_ID );

		if ( !empty( $first_image_url ) ) {
			$thumbnail			= '<img class="guest-avatar" src="' . $first_image_url . '" />';
			$post_classes[]	= 'has-guest-avatar';
		}

	} elseif ( has_post_thumbnail() ) {

    $thumbnail_id   = get_post_thumbnail_id( $post_ID );
    $thumbnail      = wp_get_attachment_image( $thumbnail_id, 'medium' );

  }

	// Gets the post title and permalink for the link container.
	$post_title	= get_the_title( $post_ID );
	$post_url		= get_permalink( $post_ID );

	echo '<div class="' . implode( ' ', $card_classes ) . '">';

		if ( !empty( $card_top_label ) ) {
			echo '<p class="card-label card-top-label">' . $card_top_label . '</p>';
		}

		echo '<a href="' . $post_url . '" title="' . $post_title . '" ';
		post_class( $post_classes );
		echo '>';

			echo $thumbnail;

			echo '<div class="headline-byline">';

				echo '<h2 class="headline" title="' . $post_title . '">' . $post_title . '</h2>';

				// Outputs the byline, with exceptions.
        if ( $post_type == 'post' && $title_only == false ) {

					echo '<div class="postmeta">';

						$post_date = get_the_time( 'F jS, Y', $post_ID );

						if ( has_category( 'lawyerist-podcast' ) ) {

					    echo '<span class="date updated published">' . $post_date . '</span>';

					  } else {

							$author = get_the_author_meta( 'display_name' );

							if ( $author == 'Lawyerist' ) {
								$author = 'the Lawyerist editorial team';
							}

							if ( has_term( true, 'sponsor' ) || has_category( 'sponsored-posts' ) ) {

						    $sponsor_IDs = wp_get_post_terms(
						      $post_ID,
						      'sponsor',
						      array(
						        'fields' 	=> 'ids',
						        'orderby' => 'count',
						        'order' 	=> 'DESC',
						      )
						    );

						    $sponsor_info = get_term( $sponsor_IDs[0] );
						    $sponsor      = $sponsor_info->name;

						    // Replaces the author with the sponsor on sponsored product updates and old sponsored posts.
						    if ( has_category( 'sponsored-posts' ) ) {

						      echo '<span class="sponsor">Sponsored by ' . $sponsor . '</span> ';

						    // Adds "sponsored by" after the author on product spotlights.
						    } else {

						      echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>,&nbsp;<span class="sponsor">sponsored by ' . $sponsor . '</span>, ';

						    }

						    echo 'on <span class="date updated published">' . $post_date . '</span>';

						  } elseif ( has_category( 'lawyerist-podcast' ) || is_author() ) {

						    echo '<span class="date updated published">' . $post_date . '</span>';

						  } else {

						    echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span> ';
						    echo 'on <span class="date updated published">' . $post_date . '</span> ';

						  }

						}

					echo '</div>';

        }

			echo '</div>'; // Close .headline-byline.

		echo '</a>'; // Close the post container.

		if ( !empty( $card_bottom_label ) ) {
			echo '<p class="card-label card-bottom-label">' . $card_bottom_label . '</p>';
		}

	echo '</div>'; // Close .card.

	unset( $thumbnail );

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

function lawyerist_remove_products_breadcrumb( $link_output, $link ) {

	if ( is_really_a_woocommerce_page() && $link['text'] == 'Products' ) {
		$link_output = '';
	}

	return $link_output;

}

add_filter( 'wpseo_breadcrumb_single_link', 'lawyerist_remove_products_breadcrumb', 10, 2 );


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


/*------------------------------
Author Bios
------------------------------*/

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


	echo '<div class="author-bio-box card">' . "\n";

		if ( is_author() ) {
			echo '<h1>' . $author_name . '</h1>' . "\n";
		}

		echo $author_avatar;

		echo '<div class="author-bio-connect">';

			echo '<div class="author-bio">' . $author_bio . '</div>';

			// Show links to the author's website and Twitter and LinkedIn profiles.
			echo '<div class="author-connect">';

				if ( $twitter_username == true ) {
					echo '<p class="author-twitter"><a href="https://twitter.com/' . $twitter_username . '">@' . $twitter_username . '</a></p>';
				}

				if ( $linkedin_username == true ) {
					echo '<p class="author-linkedin"><a href="' . $linkedin_url . '">' . $linkedin_username . '</a></p>';
				}

				if ( $author_url == true ) {
					echo '<p class="author-website"><a href="' . $author_url . '">' . $author_url_host . '</a></p>';
				}

			echo '</div>'; // Close .author_connect.

		echo '</div>'; // Close .author-bio-connect.

	echo '</div>'; // Close .author-bio-box.

}


/*------------------------------
Show Pages in Author Archives
------------------------------*/

function lawyerist_show_authors_pages( $query ) {

  if ( !is_admin() && $query->is_author() && $query->is_main_query() ) {

    $query->set( 'post_type', array( 'post', 'page' ) );

  }

}

add_action( 'pre_get_posts', 'lawyerist_show_authors_pages' );


/*------------------------------
List of Coauthors
------------------------------*/

function lawyerist_get_coauthors() {

	global $wp_query;

	$coauthors  = get_coauthors();

	if ( count( $coauthors ) > 1 ) {

	  // Removes the primary author.
	  unset( $coauthors[0] );

    $coauthor_list = array();

    foreach ( $coauthors as $coauthor ) {

      if ( count_user_posts( $coauthor->data->ID ) >= 5 ) {

        $profile_page_url = get_field( 'profile_page', 'user_' . $coauthor->data->ID );

        if ( empty( $profile_page_url ) ) {
          $profile_page_url = get_author_posts_url( $coauthor->data->ID );
        }

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


/*------------------------------
Custom Default Gravatar
------------------------------*/

function lawyerist_custom_gravatar ( $avatar_defaults ) {

	$lawyerist_avatar = get_bloginfo( 'template_directory' ) . '/images/lawyerist-default-gravatar.png';
	$avatar_defaults[ $lawyerist_avatar ] = "Lawyerist.com Logo";

	return $avatar_defaults;

}

add_filter( 'avatar_defaults', 'lawyerist_custom_gravatar' );


/*------------------------------
Get Alternative Products
------------------------------*/

function lawyerist_get_alternative_products() {

	global $post;

	$page_title		= get_the_title ( $post->ID );
	$alternatives = get_field( 'alternative_products' );

	if ( !empty( $alternatives ) ) {

		echo '<h2>Alternatives to ' . $page_title . '</h2>';

		echo '<div id="alternative-products" class="cards cards-3-columns">';

			foreach ( $alternatives as $alternative ) {

				$alt_title			= get_the_title( $alternative );
				$alt_url				= get_permalink( $alternative );

				if ( has_post_thumbnail() ) {

					$alt_thumbnail_id   = get_post_thumbnail_id( $alternative );
					$alt_thumbnail      = wp_get_attachment_image( $alt_thumbnail_id, 'medium' );

				}

				echo '<div class="card">';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $alt_url . '" title="' . $alt_title . '"';
					post_class();
					echo '>';

					if ( !empty ( $alt_thumbnail ) ) {
						echo $alt_thumbnail;
					}

						// Now we get the headline and excerpt (except for certain kinds of posts).
						echo '<div class="headline-byline">';

							// Headline
							echo '<h2 class="headline">' . $alt_title . '</h2>';

						echo '</div>'; // Close .headline-byline.

					echo '</a>'; // This closes the post link container (.post).

				echo '</div>';

				unset( $alt_thumbnail );

			}

		echo '</div>';

	}

}

/*------------------------------
Get Related Podcasts
------------------------------*/

function lawyerist_get_related_podcasts() {

	global $post;

	$current_id[]		= $post->ID;
	$current_slug		= $post->post_name;
	$current_title	= $post->post_title;

	if ( !empty( $current_slug ) ) {

		$args = array(
			'category_name'			=> 'lawyerist-podcast',
			'category__not_in'	=> array(
				1320, // Excludes sponsored posts.
			),
			'post__not_in'		=> $current_id,
			'posts_per_page'	=> -1,
			'tag' 						=> $current_slug,
		);

		$lawyerist_related_podcasts_query = new WP_Query( $args );

		if ( $lawyerist_related_podcasts_query->have_posts() ) :

			echo '<h2>Podcasts About ' . $current_title . '</h2>';

			echo '<div id="related-podcasts">';

				// Start the Loop.
				while ( $lawyerist_related_podcasts_query->have_posts() ) : $lawyerist_related_podcasts_query->the_post();

					lawyerist_get_post_card();

				endwhile; wp_reset_postdata();

			echo '</div>';

		endif;

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

		$args = array(
			'category__not_in'	=> array(
				1320, // Excludes sponsored posts.
				4183, // Excludes podcast episodes.
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

					lawyerist_get_post_card();

				endwhile; wp_reset_postdata();

			echo '</div>';

		endif;

	}

}


/*------------------------------
Get Related Resources
------------------------------*/

function lawyerist_get_related_resources() {

	global $post;

	if ( is_singular( 'post') ) {

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
							1320, // Sponsored posts.
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
List Child Pages Fallback

Outputs child pages if all of the following are true:

1. The page has children.
2. The page is not one of several listed.
3. The page is not a product portal.
4. The [list-child-pages] shortcode is not used anywhere on the page.
------------------------------*/

function lawyerist_list_child_pages_fallback( $content ) {

	global $post;

	$children = get_pages( array( 'child_of' => $post->ID ) );

if ( is_page() && !is_page( 'about' ) && !is_product_portal() && !has_shortcode( $content, 'list-child-pages' ) ) {

		ob_start();

			echo do_shortcode( '[list-child-pages]' );

		$child_pages = ob_get_clean();

		$content .= $child_pages;

		return $content;

	} else {

		return $content;

	}

}

add_action( 'the_content', 'lawyerist_list_child_pages_fallback' );


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
		$content = '' . get_the_post_thumbnail( $post->ID, 'featured_top', array( 'style' => 'display:block; height:auto; margin:0 0 15px 0; width:560px;' ) ) . '' . $content;
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

		$author = __('Anonymous');

	}

	return $author;
}

add_filter( 'get_comment_author', 'lawyerist_comment_author_name', 10, 1 );


/* PARTNERSHIPS	***************/

/*------------------------------
Display Ad
------------------------------*/

function lawyerist_get_display_ad() { ?>

	<div id="lawyerist_display_ad" class="lawyerist_display_ad_in_sidebar">
		<!-- /12659965/lawyerist_300x250_ad_position -->
		<div id='div-gpt-ad-1565383693580-0' style='width: 300px; height: 250px;'>
		  <script>
		    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1565383693580-0'); });
		  </script>
		</div>
	</div>

<?php }


/*------------------------------
Mobile Display Ad
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
Platinum Sidebar Widget
------------------------------*/

function lawyerist_platinum_sponsors_widget() {

	$args = array(
		'meta_key'				=> 'show_in_platinum_sidebar_widget',
		'meta_value'			=> true,
		'orderby'					=> 'rand',
		'post_type'				=> 'page',
		'posts_per_page'	=> -1,
		'tax_query' => array(
      array(
        'taxonomy' => 'page_type',
        'field'    => 'slug',
        'terms'    => array( 'platinum-sponsor' ),
      ),
    ),
	);

	$platinum_sponsors_query = new WP_Query( $args );

	if ( $platinum_sponsors_query->have_posts() ) :

		echo '<li id="platinum-sponsors-widget" class="widget">' . "\n" . '<div class="textwidget custom-html-widget">';

			echo '<h3>Platinum Sponsors</h3>';

			while ( $platinum_sponsors_query->have_posts() ) : $platinum_sponsors_query->the_post();

					$product_page_title			= the_title( '', '', FALSE );
					$product_page_url				= get_permalink();
					$platinum_sidebar_image	= get_field( 'platinum_sidebar_image' );

					echo '<a href="' . $product_page_url . '?utm_source=lawyerist&amp;utm_medium=platinum_sidebar_widget">';
						echo wp_get_attachment_image( $platinum_sidebar_image, 'large' );
					echo '</a>';

			endwhile; wp_reset_postdata();

		echo '</div>' . "\n" . '</li>';

	endif;

}


/*------------------------------
Affinity Benefit Notice
------------------------------*/

function affinity_notice() {

	if ( !function_exists( 'wc_memberships' ) ) {
    return;
  }

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

			if ( wc_memberships_is_user_active_member( $user_id, 'insider-plus-affinity' ) ) {

				$discount_descr	= get_field( 'affinity_discount_descr' );

			} else {

				$post_title			= the_title( '', '', FALSE );
				$discount_descr = $post_title . ' offers a discount to ' . $whom . ' through our Affinity Benefits program. The details of this discount are only available to members. <a href="https://lawyerist.com/affinity-benefits/">Learn more about the Affinity Benefits program</a> or <a class="login-link" href="https://lawyerist.com/account/">log in</a> if you are a member of Insider Plus or Lab.';

			}

			echo '<div class="card affinity-discount-card">';

				echo '<p class="card-label">' . $card_label . '</p>';

					$theme_dir = get_template_directory_uri();

					echo '<img alt="Lawyerist affinity partner badge." src="' . $theme_dir . '/images/affinity-partner-badge.png" height="128" width="150" />';

					echo '<p class="discount_descr">' . $discount_descr . '</p>';

					if ( wc_memberships_is_user_active_member( $user_id, 'insider-plus-affinity' ) ) {

						echo '<button class="button expandthis-click">Claim Your Discount</button>';

						echo '<div class="expandthis-hide">';

							echo do_shortcode( '[gravityform id="55" title="false" ajax="true"]' );

						echo '</div>';

					}

				echo '</div>';

			echo '</div>';

	$affinity_notice = ob_get_clean();

	return $affinity_notice;

}


/* COMMENTS & REVIEWS *********/

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

/* Enable CC Field on Form Notifications. */

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


/* Auto-Login New Users */
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

		header( 'refresh' );

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

	// Adds our demographic questions.
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
Hide Product Categories & Tags
------------------------------*/

// Overwrites product_tag taxonomy properties to hide it from the WP admin.
add_action('init', function() {
    register_taxonomy('product_tag', 'product', [
        'public'            => false,
        'show_ui'           => false,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
    ]);
}, 100);


// And remove tags from the Products table.
add_action( 'admin_init' , function() {
    add_filter('manage_product_posts_columns', function($columns) {
        unset($columns['product_tag']);
        return $columns;
    }, 100);
});


// Overwrites product_cat taxonomy properties to hide it from the WP admin.
add_action('init', function() {
    register_taxonomy('product_cat', 'product', [
        'public'            => false,
        'show_ui'           => false,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
    ]);
}, 100);

// And remove categories from the Products table.
add_action( 'admin_init' , function() {
    add_filter('manage_product_posts_columns', function($columns) {
        unset($columns['product_cat']);
        return $columns;
    }, 100);
});


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
Disable Tag Archives
------------------------------*/

function lawyerist_disable_tag_archives() {

	if ( is_admin() ) {
		return;
	}

  if ( is_tag() ) {
		global $wp_query;
    $wp_query->set_404();
  }

}

add_action( 'pre_get_posts', 'lawyerist_disable_tag_archives' );


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
