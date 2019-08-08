<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <?php wp_head(); ?>

  <link rel="shortcut icon" href="<?php echo get_bloginfo( 'template_url' ); ?>/images/favicon.ico" type="image/x-icon">

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">

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

  <!-- Google global site tag (gtag.js) - Google Ads: 928946623 -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-928946623"></script>
  <script>
   window.dataLayer = window.dataLayer || [];
   function gtag(){dataLayer.push(arguments);}
   gtag('js', new Date());

   gtag('config', 'AW-928946623');
  </script>
  <!-- End Google global site tag. -->

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
  		googletag.defineSlot('/12659965/lawyerist_300x250_ad_position', [300, 250], 'div-gpt-ad-1516051566911-0').addService(googletag.pubads());
  		googletag.pubads().enableSingleRequest();
  		googletag.pubads().collapseEmptyDivs();
  		googletag.pubads().setTargeting('pageID', '<?php if ( is_singular() ) { echo $post->ID; } ?>');
  		googletag.pubads().setTargeting('test', 'refresh');
  		googletag.enableServices();
    });
  </script>
  <!-- End DoubleClick Tag for Sidebar Ad -->

  <!-- Google Webmaster Tools site verification tag for Sam -->
  <meta name="google-site-verification" content="GwbQ-BLG3G-tXV4-uG-_kZIaxXxm_Wqmzg5wFSBa9hI" />

  <!-- Google Webmaster Tools site verification tag for Aaron -->
  <meta name="google-site-verification" content="d_OrAi2nt_o3Y3uQ-dicRpRYaxZSynFLUhHY15cnJUY" />

  <!-- Pinterest site verification. -->
  <meta name="p:domain_verify" content="53c0a3083959448fb93c9672226a472e"/>

</head>

<body <?php body_class(); ?>>

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

  </div><!-- #header -->
