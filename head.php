<head>

<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic|Roboto+Slab:700,400' type='text/css'>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/normalize.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.min.css?2015-01-28-23-11" type="text/css" media="screen, projection">
<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">

<meta charset="utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php if ( has_post_format( 'aside' )) { ?><meta name="robots" content="noindex"><?php } ?>

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
googletag.defineSlot('/12659965/lawyerist_ap1_leaderboard', [728, 90], 'div-gpt-ad-1356989285353-0').addService(googletag.pubads());
googletag.defineSlot('/12659965/lawyerist_ap2_sidebar1', [300, 250], 'div-gpt-ad-1356989285353-1').addService(googletag.pubads());
googletag.defineSlot('/12659965/lawyerist_ap3_sidebar2', [300, 250], 'div-gpt-ad-1356989285353-2').addService(googletag.pubads());
googletag.defineSlot('/12659965/lawyerist_ap4_halfpage', [300, 600], 'div-gpt-ad-1356989285353-3').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();
});
</script>

<title><?php wp_title(); ?></title>

<?php /* Meta descriptions */

	if ( is_front_page() ) {

		$description = get_bloginfo('description'); ?>

		<meta name="description" content="<?php echo $description; ?>"><?php }

	elseif ( is_single() || is_page() ) {

		global $post;
		$excerpt = get_the_excerpt( $post->ID ) ?>

		<meta name="description" content="<?php echo $excerpt; ?>">

<?php } ?>

</head>
