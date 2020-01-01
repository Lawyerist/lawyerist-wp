<?php

/* INDEX

SETUP
- Stylesheets & Scripts
- Theme Setup
- Template Files
- Add Categories to Body Classes

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
- Author Bios
- List of Coauthors
- Post/Page Footer CTA
- Get Alternative Products
- Get Related Posts
- Get Related Resources
- List Child Pages Fallback
- Remove Inline Width from Image Captions
- Featured Images in RSS Feeds
- Remove Lab Workshops from RSS Feed
- Remove Default Gallery Styles

PARTNERSHIPS
- Platinum Sidebar Widget
- Affinity Benefit Notice
- Add Sponsor to Post Meta

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
- Disable Tag & Author Archives
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

	$template_dir_uri = get_template_directory_uri();

	// Load the main stylesheet.
	$cacheBusterCSS = filemtime( get_stylesheet_directory() . '/style.css' );
	wp_register_style( 'stylesheet', $template_dir_uri . '/style.css', array(), $cacheBusterCSS, 'all' );
	wp_enqueue_style( 'stylesheet' );

	// Load consolidated scripts in the footer.
	$cacheBusterFS = filemtime( get_stylesheet_directory() . '/js/footer-scripts.js' );
	wp_register_script( 'footer-scripts', $template_dir_uri . '/js/footer-scripts.js',  array( 'jquery' ), $cacheBusterFS, true );
	wp_enqueue_script( 'footer-scripts' );

}

add_action( 'wp_enqueue_scripts', 'lawyerist_stylesheets_scripts' );


/*------------------------------
Theme Setup
------------------------------*/

function lawyerist_theme_setup() {

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'wp-block-styles' );

	add_image_size( 'featured-image', 1024 );
	add_image_size( 'retina-thumbnail', 300, 300, true );

}

add_action( 'after_setup_theme', 'lawyerist_theme_setup' );


/*------------------------------
Template Files
------------------------------*/

if ( !is_admin() ) {

  require_once( 'shortcodes.php' );

}


/*------------------------------
Add Categories to Body Classes
------------------------------*/

function lwyrst_cat_body_class( $classes ) {

	if ( is_single() ) {

		global $post;

		$cats = get_the_category( $post->ID );

		foreach ( $cats as $cat ) {
      $classes[] = 'single-cat-' . $cat->category_nicename;
    }

	}

  return $classes;

}

add_filter( 'body_class', 'lwyrst_cat_body_class' );


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


/*------------------------------
Remove Menu Items
------------------------------*/

function lawyerist_remove_admin_bar_items( $wp_admin_bar ) {

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


/*------------------------------
Is This a Product Portal?
------------------------------*/

function is_product_portal() {

	global $post;

	$get_children_args = array(
		'post_parent'	=> $post->ID,
		'post__not_in' => array(
			245317, // Insider
			220087, // Lab
			128819, // LabCon
		),
		'fields'		=> 'ids',
		'post_type'	=> 'page',
	);

	$children = get_posts( $get_children_args );

	if ( is_page() && is_page_template( 'product-page.php' ) && ( count( $children ) > 0 ) ) {

		return true;

	} else {

		return false;

	}

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

	if ( !empty( $card_top_label ) || !empty( $card_bottom_label ) ) { $card_classes[] = 'has-card-label'; }

	$post_classes = array();

	// Gets the guest image for case studies, or the post thumbnail for everything else.
	if ( has_category( 'case-studies' ) ) {

		$first_image_url = get_first_image_url( $post_ID );

		if ( !empty( $first_image_url ) ) {
			$thumbnail			= '<img class="guest-avatar" srcset="' . $first_image_url[ '1x' ] . ' 1x, ' . $first_image_url[ '2x' ] . ' 2x" src="' . $first_image_url[ '1x' ] . '" />';
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

			echo '<div class="headline-byline">';

				echo '<h2 class="headline" title="' . $post_title . '">' . $post_title . '</h2>';

				// Outputs the byline, with exceptions.
        if ( $post_type == 'post' && $title_only == false ) {

					echo '<div class="postmeta">';

						$date = get_the_time( 'F jS, Y', $post_ID );

						if ( has_category( array( 'case-studies', 'lab-workshops' ) ) ) {

					    echo '<span class="date updated published">' . $date . '</span>';

					  } else {

							$author = get_the_author_meta( 'display_name' );

							if ( $author == 'Lawyerist' ) {
								$author = 'the Lawyerist editorial team';
							}

							if ( has_category( 'sponsored' ) ) {

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

								if ( !empty( $sponsor ) ) {

									if ( has_tag( 'product-spotlights' ) ) {

										// Adds "sponsored by" after the author on product spotlights.
										echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span>,&nbsp;<span class="sponsor">sponsored by ' . $sponsor . '</span>, ';

									} else {

										// Otherwise, replaces the author with the sponsor's name.
							      echo '<span class="sponsor">Sponsored by ' . $sponsor . '</span> ';

									}

								} else {

									// Fallback if no sponsor is tagged.
									echo '<span class="sponsor">Sponsored post</span>, published ';

								}

						    echo 'on <span class="date updated published">' . $date . '</span>';

						  } else {

						    echo 'By <span class="vcard author"><cite class="fn">' . $author . '</cite></span> ';
						    echo 'on <span class="date updated published">' . $date . '</span> ';

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

	wp_reset_postdata();

}


/* CONTENT ********************/

/*------------------------------
Archive Headers
------------------------------*/

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

	} else {

		$title			= single_term_title( '', FALSE );
		$descr			= term_description();

		echo '<div id="archive-header">' . "\n";
		echo '<h1>' . $title . '</h1>' . "\n";
		echo $descr . "\n";
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
List of Coauthors
------------------------------*/

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


/*------------------------------
Post/Page Footer CTA
------------------------------*/

function lawyerist_cta() {

	if ( is_user_logged_in() ) {

		ob_start();

			?>

			<h2>Start Reading for Free</h2>
			<p>OK, you're probably wondering <em>what next?</em> We've got you covered with our survival guide to the future of your law practice.</p>
			<p>As an Insider, you can get the first chapter of our book plus additional resources for free.</p>

			<?php

		$copy = ob_get_clean();

		ob_start();

			?>

			<center>
				<span class="hs-cta-wrapper" id="hs-cta-wrapper-9366b998-d7ac-4496-9b7d-68c2c0fa9e8c">
					<span class="hs-cta-node hs-cta-9366b998-d7ac-4496-9b7d-68c2c0fa9e8c" id="hs-cta-9366b998-d7ac-4496-9b7d-68c2c0fa9e8c">
						<!--[if lte IE 8]><div id="hs-cta-ie-element"></div><![endif]-->
						<a href="https://cta-redirect.hubspot.com/cta/redirect/2910598/9366b998-d7ac-4496-9b7d-68c2c0fa9e8c" target="_blank">
							<img class="hs-cta-img" id="hs-cta-img-9366b998-d7ac-4496-9b7d-68c2c0fa9e8c" style="border-width: 0px;" src="https://no-cache.hubspot.com/cta/default/2910598/9366b998-d7ac-4496-9b7d-68c2c0fa9e8c.png" alt="Download Chapter One">
						</a>
					</span>
					<script charset="utf-8" src="https://js.hscta.net/cta/current.js"></script>
					<script type="text/javascript">
						hbspt.cta.load( 2910598, '9366b998-d7ac-4496-9b7d-68c2c0fa9e8c', {} );
					</script>
				</span>
			</center>

			<?php

		$button = ob_get_clean();

	} else {

		ob_start();

			?>

			<h2>Start Reading for Free</h2>
			<p>OK, you're probably wondering <em>what next?</em> We've got you covered with our survival guide to the future of your law practice.</p>
			<p>Join our free Insider community now to get the first chapter of our book <em>plus</em> access to a community of other innovative and entrepreneurial small-firm lawyers and even more law practice resources—all for free.</p>

			<?php

		$copy		= ob_get_clean();
		$button	= '<a class="button free-flag register-link" href="https://lawyerist.com/community/insider/">Join Now to Read</a>';

	}

	ob_start();

		?>

		<div id="book_cta" class="card<?php if ( is_front_page() ) { echo ' dismissible-notice'; } ?>" data-id="book_cta">

			<?php if ( is_front_page() ) { echo '<button class="greybutton dismiss-button"></button>'; } ?>

			<div class="book_cta_grid_row">

				<div id="book_cta_img">
					<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2019/09/small-firm-roadmap-featured-image.jpg" alt="The Small Firm Roadmap book cover">
				</div>

				<div id="book_cta_copy">
					<?php echo $copy; ?>
					<?php if ( is_user_logged_in() ) { echo $button; } ?>
				</div>

			</div>

			<?php if ( !is_user_logged_in() ) { echo $button; } ?>

		</div>

		<?php

	return ob_get_clean();

}


function lawyerist_cta_shortcode() {

	return lawyerist_cta();

}

add_shortcode( 'book-cta', 'lawyerist_cta_shortcode' );


/*------------------------------
Get Alternative Products
------------------------------*/

function lawyerist_get_alternative_products() {

	global $post;

	$page_title		= get_the_title ( $post->ID );
	$alternatives = get_field( 'alternative_products' );

	if ( !empty( $alternatives ) ) {

		echo '<h2>Alternatives to ' . $page_title . '</h2>';

		echo '<div id="alternative-products" class="cards cards-4-columns">';

			foreach ( $alternatives as $alternative ) {

				$alt_title			= get_the_title( $alternative );
				$alt_url				= get_permalink( $alternative );

				if ( has_post_thumbnail() ) {

					$alt_thumbnail_id   = get_post_thumbnail_id( $alternative );
					$alt_thumbnail      = wp_get_attachment_image( $alt_thumbnail_id, 'medium' );

				}

				echo '<div class="card">';

					// Starts the link container. Makes for big click targets!
					echo '<a href="' . $alt_url . '" title="' . $alt_title . '" class="has-post-thumbnail">';

					if ( !empty( $alt_thumbnail ) ) {
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

add_filter( 'the_excerpt_rss', 'featuredtoRSS' );
add_filter( 'the_content_feed', 'featuredtoRSS' );


/*------------------------------
Remove Lab Workshops from RSS Feed
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
------------------------------*/

add_filter( 'use_default_gallery_style', '__return_false' );


/* PARTNERSHIPS	***************/

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

		echo '<div id="platinum-sponsors-widget">';

			echo '<h3>Platinum Sponsors</h3>';

			while ( $platinum_sponsors_query->have_posts() ) : $platinum_sponsors_query->the_post();

					$product_page_title			= the_title( '', '', FALSE );
					$product_page_url				= get_permalink();
					$platinum_sidebar_image	= get_field( 'platinum_sidebar_image' );

					echo '<a href="' . $product_page_url . '?utm_source=lawyerist&amp;utm_medium=platinum_sidebar_widget">';
						echo wp_get_attachment_image( $platinum_sidebar_image, 'large' );
					echo '</a>';

			endwhile; wp_reset_postdata();

		echo '</div>';

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

			if ( wc_memberships_is_user_active_member( $user_id, 'insider' ) ) {

				$discount_descr	= get_field( 'affinity_discount_descr' );

			} else {

				$post_title			= the_title( '', '', FALSE );
				$discount_descr = $post_title . ' offers a discount to ' . $whom . ' through our Affinity Benefits program. The details of this discount are only available to members. <a href="https://lawyerist.com/affinity-benefits/">Learn more about the Affinity Benefits program</a> or <a class="login-link" href="https://lawyerist.com/account/">log in</a> if you are a member of Insider or Lab.';

			}

			echo '<div class="card affinity-discount-card">';

				$theme_dir = get_template_directory_uri();

				echo '<img alt="Lawyerist affinity partner badge." src="' . $theme_dir . '/images/affinity-partner-badge.png" height="128" width="150" />';

				echo '<p class="card-label">' . $card_label . '</p>';

				echo '<p class="discount_descr">' . $discount_descr . '</p>';

				if ( wc_memberships_is_user_active_member( $user_id, 'insider' ) ) {

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


/*Add Sponsor to Post Meta */

function lwyrst_sponsor_order_meta( $post_id ) {

	if ( has_category( 'sponsored' ) ) {

		$sponsor_IDs = wp_get_post_terms(
			$post_id,
			'sponsor',
			array(
				'fields' 	=> 'ids',
				'orderby' => 'count',
				'order' 	=> 'DESC',
			)
		);

		$sponsor_info = get_term( $sponsor_IDs[0] );
		$sponsor      = $sponsor_info->name;

		update_post_meta( $post_id, 'sponsor', sanitize_text_field( $sponsor ) );

	}

}

add_action( 'save_post', 'lwyrst_sponsor_order_meta' );


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

		$author = __('Anonymous');

	}

	return $author;
}

add_filter( 'get_comment_author', 'lawyerist_comment_author_name', 10, 1 );


/*------------------------------
Reviews
------------------------------*/

// Gets the author rating ("our" rating) from WP Review Pro, and converts it
// from a 10-point scale to a 5-point scale. Rounds to one decimal point.
function lawyerist_get_our_rating() {

	global $post;

	$our_rating_raw	= get_post_meta( $post->ID, 'wp_review_total', true );
	$our_rating			= round( floatval( $our_rating_raw ) / 2, 1 );

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
			$rating_count	=	intval( lawyerist_get_community_review_count() ) + 1;
		} else {
			$rating_count	=	intval( lawyerist_get_community_review_count() );
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
Disable Tag & Author Archives
------------------------------*/

function lawyerist_disable_archives() {

	if ( is_admin() ) { return; }

  if ( is_tag() || is_author() ) {
		global $wp_query;
    $wp_query->set_404();
  }

}

add_action( 'pre_get_posts', 'lawyerist_disable_archives' );


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
