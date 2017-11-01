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

		<?php

		global $woocommerce;

		$cart_num	= $woocommerce->cart->cart_contents_count;

		if ( $cart_num > 0 ) {

			$cart_url	= $woocommerce->cart->get_cart_url();

			echo '<a class="cart-in-header" href="' . $cart_url . '">' . $cart_num . '</a>';
		}

		?>

		<div class="clear"></div>

	</div><!-- #header -->

</div><!-- #header_container -->

<div id="main_menu_container">
	<?php wp_nav_menu( array( 'theme_location' => 'header-nav-menu' ) ); ?>
</div>
