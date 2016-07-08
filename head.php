<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php wp_head(); ?>

<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">

<?php /* Meta descriptions */

	if ( is_front_page() ) {

		$description = get_bloginfo('description'); ?>

		<meta name="description" content="<?php echo $description; ?>"><?php }

	elseif ( is_single() || is_page() ) {

		global $post;
		$excerpt = get_the_excerpt( $post->ID ) ?>

		<meta name="description" content="<?php echo $excerpt; ?>">

<?php } ?>

<!-- Begin DoubleClick tags -->
<script type='text/javascript'>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
  (function() {
    var gads = document.createElement('script');
    gads.async = true;
    gads.type = 'text/javascript';
    var useSSL = 'https:' == document.location.protocol;
    gads.src = (useSSL ? 'https:' : 'http:') +
      '//www.googletagservices.com/tag/js/gpt.js';
    var node = document.getElementsByTagName('script')[0];
    node.parentNode.insertBefore(gads, node);
  })();
</script>

<script type='text/javascript'>
  googletag.cmd.push(function() {
    googletag.defineSlot('/12659965/lawyerist_ap1_leaderboard', [728, 90], 'div-gpt-ad-1429843825352-0').addService(googletag.pubads());
    googletag.defineSlot('/12659965/lawyerist_ap2_sidebar1', [300, 250], 'div-gpt-ad-1429843825352-1').addService(googletag.pubads());
    googletag.defineSlot('/12659965/lawyerist_ap3_sidebar2', [300, 250], 'div-gpt-ad-1429843825352-2').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });
</script>
<!-- End DoubleClick tags -->

<!-- Google Webmaster Tools site verification tag for Sam -->
<meta name="google-site-verification" content="GwbQ-BLG3G-tXV4-uG-_kZIaxXxm_Wqmzg5wFSBa9hI" />
<!-- Google Webmaster Tools site verification tag for Aaron -->
<meta name="google-site-verification" content="d_OrAi2nt_o3Y3uQ-dicRpRYaxZSynFLUhHY15cnJUY" />

</head>
