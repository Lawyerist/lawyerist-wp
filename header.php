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

<div id="header_container" data-swiftype-index="false">

	<div id="header">

		<?php if ( is_front_page() ) { ?>
			<h1 id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		<?php }

		else { ?>
			<p id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></p>
		<?php } ?>

		<ul id="email_social">
			<li><a class="linkedin sprite" href="https://www.linkedin.com/company/lawyerist-media-llc" title="Connect with Lawyerist on LinkedIn" target="_blank"></a></li>
			<li><a class="facebook sprite" href="https://facebook.com/lawyerist" title="Friend Lawyerist on Facebook" target="_blank"></a></li>
			<li><a class="twitter sprite" href="https://twitter.com/lawyerist" title="Follow Lawyerist on Twitter" target="_blank"></a></li>
			<li><a class="more_social sprite" href="http://lawyerist.com/subscribe/" title="More ways to subscribe to connect with Lawyerist"></a></li>
		</ul>

		<div class="responsive_clear"></div>

		<div id="header_signup">
			<!-- /12659965/lawyerist_header_signup -->
			<div id='div-gpt-ad-1455661914226-0' style='height:32px; width:300px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1455661914226-0'); });
			</script>
			</div>
		</div>

		<div class="clear"></div>

	</div><!-- #header -->

</div><!-- #header_container -->

<div id="main-menu" data-swiftype-index="false">
	<?php wp_nav_menu( array( 'theme_location' => 'main_nav' ) ); ?>
</div>
