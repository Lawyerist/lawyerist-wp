<?php lawyerist_get_ap1(); ?>

<div id="header_container">

	<div id="header">

		<?php if ( is_front_page() ) { ?>
			<h1 id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
			<p id="description"><?php bloginfo('description'); ?></p>
		<?php }

		else { ?>
			<p id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></p>
			<p id="description"><?php bloginfo('description'); ?></p>
		<?php } ?>

		<?php /* This used to be a small shopping-cart indicator next to the logo.

		$cart_num	= edd_get_cart_quantity();

		if ( $cart_num > 0 ) {

			$cart_url	= edd_get_checkout_uri();

			echo '<a class="edd_cart" href="' . $cart_url . '">' . $cart_num . '</a>';
		}

		*/ ?>

		<div class="clear"></div>

	</div><!-- #header -->

</div><!-- #header_container -->

<div id="main_menu_container">
	<ul id="main-menu">
		<li id="main-menu-home" class="main-menu-item">
			<a href="<?php echo home_url(); ?>">Home</a>
		</li>
		<li id="main-menu-topics" class="main-menu-item">
			<a href="#">Topics</a>
			<div class="main-menu-dropdown">
				<?php wp_nav_menu( array( 'theme_location' => 'main_topics' ) ); ?>
			</div>
		</li>
		<li id="main-menu-about" class="main-menu-item">
			<a href="#">About</a>
			<div class="main-menu-dropdown">
				<?php wp_nav_menu( array( 'theme_location' => 'main_about' ) ); ?>
			</div>
		</li>
		<li id="main-menu-subscribe" class="main-menu-item">
			<a href="https://lawyerist.com/product/insider/">Join</a>
		</li>
		<li id="main-menu-search" class="main-menu-item">
			<a href="#">Search</a>
			<div class="main-menu-dropdown">
				<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
				<label for="main-menu-search-box">
					<span hidden class="screen-reader-text"><?php echo _x( 'Search Lawyerist.com:', 'label' ) ?></span>
				</label>
				<input id="main-menu-search-box" type="search" class="search-field" name="s" placeholder="<?php echo esc_attr_x( 'Search Lawyerist.com …', 'placeholder' ) ?>" title="<?php echo esc_attr_x( 'Search Lawyerist.com', 'label' ) ?>" />
				<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
				</form>
			</div>
		</li>
	</ul>
</div>
