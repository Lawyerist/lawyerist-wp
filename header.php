<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <?php

  // Enqueues Gravity Forms scripts necessary for the #lawyerist-login modal.
  gravity_form_enqueue_scripts( 59, true );

  ?>

  <!-- Preloads/prefetches fonts. -->

  <!-- Adler -->
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/adler/adler-webfont.woff2" type="font/woff2" crossorigin="anonymous">

  <!-- Genericons -->
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/genericons/Genericons.woff2" type="font/woff2" crossorigin="anonymous">

  <!-- Concourse -->
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/concourse/concourse_t4_regular-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/concourse/concourse_t4_italic-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/concourse/concourse_t4_bold-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/concourse/concourse_t4_bold_italic-webfont.woff2" type="font/woff2" crossorigin="anonymous">

  <!-- Equity -->
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/equity/equity_text_b_regular-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/equity/equity_text_b_italic-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/equity/equity_text_b_bold-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/equity/equity_text_b_bold_italic-webfont.woff2" type="font/woff2" crossorigin="anonymous">

  <!-- Triplicate -->
  <link rel="prefetch" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/triplicate/triplicate_t4_code_regular-webfont.woff2" type="font/woff2" crossorigin="anonymous">


  <?php wp_head(); ?>


  <!-- Gets favicon. -->
  <link rel="shortcut icon" href="<?php echo get_bloginfo( 'template_url' ); ?>/images/favicon.ico" type="image/x-icon">

  <!-- Gets the RSS feed link. -->
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">

  <?php

  // Nofollows sponsored posts.
  if ( has_category( 'sponsored') ) {
    echo '<!-- Showing a sponsored post, so it is nofollowed. -->';
    echo '<meta name="robots" content="nofollow">';
  }

  // Noindexes/nofollows Lab Workshop archives and posts.
  if ( is_category( 'lab-workshops') || has_category( 'lab-workshops') ) {
    echo '<!-- Showing a Lab Workshops archive or post, so this page is noindexed and nofollowed. -->';
    echo '<meta name="robots" content="noindex,nofollow">';
  }

  ?>

  <!-- DoubleClick Script -->
  <script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
  <script>
    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
  </script>
  <!-- End DoubleClick Script -->

  <!-- DoubleClick Tag for Sidebar Ad-->
  <script>
  googletag.cmd.push(function() {
    googletag.defineSlot('/12659965/lawyerist_300x250_ad_position', [300, 250], 'div-gpt-ad-1565383693580-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.pubads().collapseEmptyDivs();
    googletag.pubads().setTargeting('test', 'refresh');
    googletag.enableServices();
  });
  </script>
  <!-- End DoubleClick Tag for Sidebar Ad -->

  <!-- Google Webmaster Tools site verification tag for Sam -->
  <meta name="google-site-verification" content="GwbQ-BLG3G-tXV4-uG-_kZIaxXxm_Wqmzg5wFSBa9hI" />

  <!-- Google Webmaster Tools site verification tag for Aaron -->
  <meta name="google-site-verification" content="d_OrAi2nt_o3Y3uQ-dicRpRYaxZSynFLUhHY15cnJUY" />

</head>

<body <?php body_class(); ?>>

  <?php

  // Displays the signup wall notice, which also triggers the signup wall script
  // to record a pageview. (The script will only record pageviews when the notice
  // is present.)
  // The notice is displayed only if (1) the user is not logged in AND (2) viewing 
  // a single post or page, and (3) that post or page is not one of the listed
  // exceptions.

  global $post;

  $exclude_from_signup_wall = array(
    3379,   // About
    220087, // Lab
    245258, // Community
  );

  if  (
    !is_user_logged_in() && ( is_single() || is_page() ) &&
      !(
        is_front_page() ||
        is_product() || // WooCommerce products.
        is_product_portal() ||
        is_page_template( 'product-page.php' ) || // Product pages.
        is_page( $exclude_from_signup_wall ) ||
        $post->post_parent == 245258 || // Community pages.
        $post->post_parent == 3379 || // About pages.
        has_category( 'sponsored' )
      )
  ) {

    echo '<div id="article-counter-container">';
      echo '<div id="article-counter" data-post_id="' . $post->ID . '"></div>';
    echo '</div>';

  }

  ?>

	<?php echo get_lawyerist_login(); ?>

  <div id="header-grid">

  	<div id="black-buffer"></div>

  	<div id="header">

  		<?php if ( is_front_page() ) { ?>

  			<h1 id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>

  		<?php } else { ?>

  			<p id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></p>

  		<?php } ?>

  		<?php wp_nav_menu( array( 'theme_location' => 'header-nav-menu' ) ); ?>

  	</div>

  	<div id="red-buffer"></div>

  </div><!-- #header-grid -->
