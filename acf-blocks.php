<?php

// Check if function exists and hook into setup.
if ( function_exists( 'acf_register_block_type' ) ) {
  add_action( 'acf/init', 'register_acf_block_types' );
}


function register_acf_block_types() {

    // Call to Action
    acf_register_block_type(
			array(
        'name'              => 'cta',
        'title'             => __( 'Call to Action' ),
        'render_template'   => 'template-parts/acf-blocks/cta.php',
        'category'          => 'common',
				'icon'							=> 'button',
        'keywords'          => array( 'call to action', 'cta' ),

	    )
		);

		// Current Podcast
    acf_register_block_type(
			array(
        'name'              => 'podcast',
        'title'             => __( 'Current Podcast' ),
        'render_template'   => 'template-parts/acf-blocks/current-podcast.php',
        'category'          => 'common',
				'icon'							=> 'microphone',
        'keywords'          => array( 'podcast' ),
	    )
		);

    // Featured Pages
    acf_register_block_type(
			array(
        'name'              => 'featured-pages',
        'title'             => __( 'Featured Pages' ),
        'render_template'   => 'template-parts/acf-blocks/featured-pages.php',
        'category'          => 'common',
				'icon'							=> 'screenoptions',
        'keywords'          => array( 'blog posts', 'recent' ),
	    )
		);

    // Front-Page Message
		acf_register_block_type(
			array(
				'name'              => 'message',
				'title'             => __( 'Message' ),
				'render_template'   => 'template-parts/acf-blocks/message.php',
				'category'          => 'common',
				'icon'							=> 'format-quote',
				'keywords'          => array( 'message' ),
			)
		);

		// Partner Updates
    acf_register_block_type(
			array(
        'name'              => 'partner-updates',
        'title'             => __( 'Partner Updates' ),
        'render_template'   => 'template-parts/acf-blocks/partner-updates.php',
        'category'          => 'common',
				'icon'							=> 'excerpt-view',
        'keywords'          => array( 'partner updates', 'product spotlights', 'sponsored' ),
	    )
		);

		// Recent Blog Posts
    acf_register_block_type(
			array(
        'name'              => 'recent-blog-posts',
        'title'             => __( 'Recent Blog Posts' ),
        'render_template'   => 'template-parts/acf-blocks/recent-blog-posts.php',
        'category'          => 'common',
				'icon'							=> 'excerpt-view',
        'keywords'          => array( 'blog posts', 'recent' ),
	    )
		);

    // Table of Contents
    acf_register_block_type(
			array(
        'name'              => 'table-of-contents',
        'title'             => __( 'Table of Contents' ),
        'render_template'   => 'template-parts/acf-blocks/table-of-contents.php',
        'category'          => 'common',
				'icon'							=> 'editor-ul',
        'keywords'          => array( 'table of contents', 'toc', 'index' ),
        'mode'              => 'preview',
	    )
		);

    // Vendor Recommender
    acf_register_block_type(
			array(
        'name'              => 'vendor-recommender',
        'title'             => __( 'Vendor Recommender' ),
        'render_template'   => 'template-parts/acf-blocks/vendor-recommender.php',
        'category'          => 'common',
				'icon'							=> 'image-filter',
        'keywords'          => array( 'recommend', 'wizard' ),
	    )
		);

}
