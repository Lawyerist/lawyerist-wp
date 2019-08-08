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
