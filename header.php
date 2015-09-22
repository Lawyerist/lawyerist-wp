<?php if ( !has_tag('no-ads') ) { ?>

	<div id="leaderboard_container">

		<!-- /12659965/lawyerist_ap1_leaderboard -->
		<div id='div-gpt-ad-1429843825352-0' style='height:90px; width:728px;'>
		<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1429843825352-0'); });
		</script>
		</div>

	</div>

<?php } ?>

<div id="header_container">

	<div id="header">

		<?php if ( is_front_page() ) { ?>
			<h1 id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); echo ' &mdash; '; bloginfo('description'); ?></a></h1>
		<?php }

		else { ?>
			<p id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); echo ' &mdash; '; bloginfo('description'); ?></a></p>
		<?php } ?>

		<?php if ( !is_mobile() ) { wp_nav_menu( array( 'theme_location' => 'header_nav' ) ); } ?>

		<?php /* if ( is_mobile() ) { wp_nav_menu( array( 'theme_location' => 'mobile_nav' ) ); } */ ?>

		<div id="email_social">
			<ul>
				<li><a class="linkedin sprite" href="https://www.linkedin.com/company/lawyerist-media-llc" title="Connect with Lawyerist on LinkedIn" target="_blank"></a></li>
				<li><a class="facebook sprite" href="https://facebook.com/lawyerist" title="Friend Lawyerist on Facebook" target="_blank"></a></li>
				<li><a class="twitter sprite" href="https://twitter.com/lawyerist" title="Follow Lawyerist on Twitter" target="_blank"></a></li>
				<li><a class="more_social sprite" href="http://lawyerist.com/subscribe/" title="More ways to subscribe to connect with Lawyerist"></a></li>
			</ul>
		</div>

		<div class="clear"></div>

	</div><!-- #header -->

	<?php if ( !is_mobile() ) { wp_nav_menu( array( 'theme_location' => 'main_nav' ) ); } ?>

</div><!-- #header_container -->
