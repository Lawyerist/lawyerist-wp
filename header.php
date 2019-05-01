<div id="header_shadow"></div>
<div id="black-stripe"></div>
<div id="red-stripe"></div>

<div id="header">

	<?php if ( is_front_page() ) { ?>

		<h1 id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>

	<?php } else { ?>

		<p id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></p>
		
	<?php } ?>

	<?php wp_nav_menu( array( 'theme_location' => 'header-nav-menu' ) ); ?>

</div><!-- #header -->
