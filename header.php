<?php lawyerist_get_ap1(); ?>

<div id="header_container">

	<div id="header">

		<?php if ( is_front_page() ) { ?>
			<h1 id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		<?php }

		else { ?>
			<p id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></p>
		<?php } ?>

		<div class="clear"></div>

	</div><!-- #header -->

</div><!-- #header_container -->

<div id="main-menu">
	<ul>
		<li id="main-menu-home">
			<a href="<?php echo home_url(); ?>">Home</a>
		</li>
		<li id="main-menu-topics">
			<a href="#">Topics</a>
			<?php wp_nav_menu( array( 'theme_location' => 'main_topics' ) ); ?>
		</li>
		<li id="main-menu-discuss">
			<a href="#">Discuss</a>
			<?php wp_nav_menu( array( 'theme_location' => 'main_discuss' ) ); ?>
		</li>
		<li id="main-menu-subscribe">
			<a href="#">Subscribe</a>
			<?php gravity_form( 14, false, false, false, '', true, 1010, true ); ?>
		</li>
		<li id="main-menu-search">
			<a href="#">Search</a>
			<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
			<label for="main-menu-search-box">
				<span hidden class="screen-reader-text"><?php echo _x( 'Search Lawyerist.com: ', 'label' ) ?></span>
			</label>
			<input id="main-menu-search-box" type="search" class="search-field" name="s" placeholder="<?php echo esc_attr_x( 'Search Lawyerist.com …', 'placeholder' ) ?>" title="<?php echo esc_attr_x( 'Search Lawyerist.com', 'label' ) ?>" />
			<input hidden type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
			</form>
		</li>
	</ul>
</div>
