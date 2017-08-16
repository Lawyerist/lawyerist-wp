<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>


<?php wp_head(); ?>


<link rel="shortcut icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon">
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS feed" href="http://feeds.feedburner.com/solosmalltech">


<?php /* Meta descriptions */

// Authors, series, downloads, categories with empty descriptions

	if ( is_front_page() ) {

		$description = wp_strip_all_tags( get_bloginfo( 'description' ), true );

	} elseif ( is_archive() && !is_author() && !is_post_type_archive( 'download' ) ) {

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

	} elseif ( is_post_type_archive( 'download' ) ) {

		$description = wp_strip_all_tags( term_description(), true );

		if ( empty( $description ) ) {

			$title = single_term_title( '', FALSE );
			$description = 'All our ' . $title . ' downloads.';
		}

	} elseif ( is_singular() ) {

		global $post;
		$description = get_the_excerpt( $post->ID );

	}

?>

<meta name="description" content="<?php echo $description; ?>">


<?php if ( is_single() && has_post_format( 'link', $post->ID ) ) { echo '<meta name="robots" content="noindex">'; } ?>


<!-- Google Webmaster Tools site verification tag for Sam -->
<meta name="google-site-verification" content="GwbQ-BLG3G-tXV4-uG-_kZIaxXxm_Wqmzg5wFSBa9hI" />
<!-- Google Webmaster Tools site verification tag for Aaron -->
<meta name="google-site-verification" content="d_OrAi2nt_o3Y3uQ-dicRpRYaxZSynFLUhHY15cnJUY" />

</head>
