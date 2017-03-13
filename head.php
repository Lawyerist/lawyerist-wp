<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<?php wp_head(); ?>

<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">

<?php /* Meta descriptions */

	if ( is_front_page() ) {

		$description = get_bloginfo( 'description' );

	} elseif ( is_single() || is_page() ) {

		global $post;
		$description = get_the_excerpt( $post->ID );

	} ?>

<meta name="description" content="<?php echo $description; ?>">

<?php if ( is_single() && has_post_format( 'link', $post->ID ) ) { echo '<meta name="robots" content="noindex">'; } ?>

<!-- Google Webmaster Tools site verification tag for Sam -->
<meta name="google-site-verification" content="GwbQ-BLG3G-tXV4-uG-_kZIaxXxm_Wqmzg5wFSBa9hI" />
<!-- Google Webmaster Tools site verification tag for Aaron -->
<meta name="google-site-verification" content="d_OrAi2nt_o3Y3uQ-dicRpRYaxZSynFLUhHY15cnJUY" />

</head>
