<head>

<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic|Roboto+Slab:700,400' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>?2014-10-02-09-12" type="text/css" media="screen, projection">
<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">

<meta charset="utf-8" />

<?php if ( wp_is_mobile() ) { ?>
    <meta name="viewport" content="width=320,initial-scale=1.0">
<?php } ?>

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

<title>
<?php /* Title tags */
	if ( is_front_page() ) { bloginfo('name'); echo ' &mdash; '; bloginfo('description'); }
	elseif ( is_home () ) { bloginfo('name'); echo ' &mdash; All Posts'; }
	elseif ( is_single() || is_page() ) { the_title(); }
	elseif ( is_author() ) { global $wp_query; $author_name = get_the_author_meta('display_name',$author); echo $author_name; }
	elseif ( is_category() ) { single_cat_title(); }
	elseif ( is_tag() ) { single_tag_title(); }
  elseif ( is_404() ) { echo '404: You Found a Typo!'; }
?>
</title>


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
