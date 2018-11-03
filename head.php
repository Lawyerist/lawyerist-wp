<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>


<?php wp_head(); ?>


<link rel="shortcut icon" href="<?php echo get_bloginfo( 'template_url' ); ?>/images/favicon.ico" type="image/x-icon">

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">


<?php

	// Outputs the meta description.

	if ( is_front_page() ) {

		$description	= wp_strip_all_tags( get_bloginfo( 'description' ), true );

	} elseif ( is_archive() && !is_author() && !is_post_type_archive( 'product' ) ) {

		$description = wp_strip_all_tags( term_description(), true );

		if ( empty( $description ) ) {
			$title = single_term_title( '', FALSE );
			$description = 'All our posts labeled ' . $title . '.';
		}

	} elseif ( is_author() ) {

		$description = wp_strip_all_tags( get_the_author_meta( 'description' ), true );

		if ( empty( $description ) ) {
			$name = get_the_author_meta( 'display_name' );
			$description = 'Posts by ' . $name . ' on Lawyerist.com.';
		}

	} elseif ( is_post_type_archive( 'product' ) ) {

		$description = wp_strip_all_tags( term_description(), true );

		if ( empty( $description ) ) {
			$title = single_term_title( '', FALSE );
			$description = 'All our ' . $title . ' products.';
		}

	}

	if ( !empty( $description ) ) {

		echo '<meta name="description" content="' . $description . '">';

	}


	// Noindexes and nofollows sponsored posts.
	if ( is_single() && has_category( 'sponsored-posts', $post->ID ) ) {

		echo '<meta name="robots" content="noindex, nofollow">';

	// Noindexes but dofollows hidden products.
	} elseif ( is_single() && has_term( 'exclude-from-catalog', 'product_visibility', $post->ID ) ) {

		echo '<meta name="robots" content="noindex, follow">';

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
