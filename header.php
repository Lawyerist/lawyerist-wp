<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-WVFM84N');</script>
  <!-- End Google Tag Manager -->

  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <?php

  // Enqueue scripts necessary for the #lawyerist-login modal.
  if ( !is_user_logged_in() ) {
    gravity_form_enqueue_scripts( 59, true );
  }

  ?>

  <?php wp_head(); ?>

  <link rel="shortcut icon" href="<?php echo get_bloginfo( 'template_url' ); ?>/images/favicon.ico" type="image/x-icon">

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">

  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/adler/adler-webfont.woff2" type="font/woff2" crossorigin="anonymous">

  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/genericons/Genericons.woff2" type="font/woff2" crossorigin="anonymous">

  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/concourse/concourse_t4_regular-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/concourse/concourse_t4_italic-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/concourse/concourse_t4_bold-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/concourse/concourse_t4_bold_italic-webfont.woff2" type="font/woff2" crossorigin="anonymous">

  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/equity/equity_text_b_regular-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/equity/equity_text_b_italic-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/equity/equity_text_b_bold-webfont.woff2" type="font/woff2" crossorigin="anonymous">
  <link rel="preload" as="font" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/equity/equity_text_b_bold_italic-webfont.woff2" type="font/woff2" crossorigin="anonymous">

  <link rel="prefetch" href="<?php echo get_bloginfo( 'template_url' ); ?>/fonts/triplicate/triplicate_t4_code_regular-webfont.woff2" type="font/woff2" crossorigin="anonymous">

  <?php

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

  ?>

  <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
  <script>
    window.googletag = window.googletag || {cmd: []};
    googletag.cmd.push(function() {
      googletag.defineSlot('/12659965/lawyerist_300x250_ad_position', [300, 250], 'div-gpt-ad-1565383693580-0').addService(googletag.pubads());
      googletag.pubads().enableSingleRequest();
      googletag.enableServices();
    });
  </script>

  <!-- Google Webmaster Tools site verification tag for Sam -->
  <meta name="google-site-verification" content="GwbQ-BLG3G-tXV4-uG-_kZIaxXxm_Wqmzg5wFSBa9hI" />

  <!-- Google Webmaster Tools site verification tag for Aaron -->
  <meta name="google-site-verification" content="d_OrAi2nt_o3Y3uQ-dicRpRYaxZSynFLUhHY15cnJUY" />

</head>

<body <?php body_class(); ?>>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WVFM84N"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

	<?php

	if ( !is_user_logged_in() ) {
		echo get_lawyerist_login( 'modal' );
	}

	?>

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
