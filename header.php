<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <?php
  // Enqueues Gravity Forms scripts necessary for the #lawyerist-login modal.
  gravity_form_enqueue_scripts( 59, true );
  ?>

  <?php wp_head(); ?>

  <!-- Gets favicon. -->
  <link rel="shortcut icon" href="<?php echo get_bloginfo( 'template_url' ); ?>/images/favicon.ico" type="image/x-icon">

  <!-- Gets the RSS feed link. -->
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">

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

  <?php

  // Nofollows sponsored posts.
  if ( has_category( 'sponsored') ) {
    echo '<!-- Showing a sponsored post, so it is nofollowed. -->';
    echo '<meta name="robots" content="nofollow">';
  }

  // Noindexes author archives if the author has fewer than 5 posts.
  if ( is_author() ) {

    global $wp_query;

    $author_ID          = $wp_query->queried_object->data->ID;
    $author_name        = $wp_query->queried_object->data->display_name;
    $author_post_count  = count_user_posts( $author_ID );

    if ( $author_post_count < 5 ) {
      echo '<!-- ' . $author_name . ' has ' . sprintf ( _n( '%s post', '%s posts', $author_post_count ), $author_post_count ). ', so this page is noindexed. -->';
      echo '<meta name="robots" content="noindex">';
    }

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

	<?php	echo get_lawyerist_login(); ?>

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
