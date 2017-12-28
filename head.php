<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>


<?php wp_head(); ?>


<link rel="shortcut icon" href="<?php echo get_bloginfo( 'template_url' ); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_bloginfo( 'template_url' ); ?>/images/favicon.ico" type="image/x-icon">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">


<?php /* Meta descriptions */

// Authors, series, products, categories with empty descriptions

	if ( is_front_page() ) {

		$description = wp_strip_all_tags( get_bloginfo( 'description' ), true );

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

	} elseif ( is_singular() ) {

		global $post;

		if ( defined( 'WPSEO_VERSION' ) ) {
			$description = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );
		} else {
			$description = get_the_excerpt( $post->ID );
		}

	}

?>

<meta name="description" content="<?php echo $description; ?>">

<?php if ( is_single() && has_category( 'sponsored-posts', $post->ID ) ) { echo '<meta name="robots" content="noindex, nofollow">'; } ?>

<!-- DoubleClick Tags -->
<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
<script>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
</script>

<script>
  googletag.cmd.push(function() {
    googletag.defineSlot('/12659965/lawyerist_ap1_leaderboard', [728, 90], 'div-gpt-ad-1510163574833-0').addService(googletag.pubads());
    googletag.defineSlot('/12659965/lawyerist_ap2_sidebar1', [300, 250], 'div-gpt-ad-1510163574833-1').addService(googletag.pubads());
    googletag.defineSlot('/12659965/lawyerist_ap3_sidebar2', [300, 250], 'div-gpt-ad-1510163574833-2').addService(googletag.pubads());
		googletag.defineSlot('/12659965/lawyerist_product_page_trial_button', [300, 75], 'div-gpt-ad-1510786516010-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.pubads().collapseEmptyDivs();
		googletag.pubads().setTargeting('pageID', '<?php if ( is_singular() ) { echo $post->ID; } ?>');
    googletag.enableServices();
  });
</script>
<!-- End DoubleClick Tags -->

<!-- Google Webmaster Tools site verification tag for Sam -->
<meta name="google-site-verification" content="GwbQ-BLG3G-tXV4-uG-_kZIaxXxm_Wqmzg5wFSBa9hI" />

<!-- Google Webmaster Tools site verification tag for Aaron -->
<meta name="google-site-verification" content="d_OrAi2nt_o3Y3uQ-dicRpRYaxZSynFLUhHY15cnJUY" />

</head>
