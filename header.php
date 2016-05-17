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
			<div id="mc_embed_signup">
				<form action="//lawyerist.us2.list-manage.com/subscribe/post?u=a5da2382c098b6541dcd6cf8e&amp;id=30d7a1f6e2&SOURCE=header_signup_02_orange" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email address" required>
					<!-- Real people should not fill this in and expect good things—do not remove this or risk form bot signups. -->
					<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_a5da2382c098b6541dcd6cf8e_30d7a1f6e2" tabindex="-1" value=""></div>
					<input type="submit" value="Subscribe!" name="subscribe" id="mc-embedded-subscribe" class="button">
				</form>
			</div><!--End mc_embed_signup-->
		</div>

		<div class="clear"></div>

	</div><!-- #header -->

</div><!-- #header_container -->

<div id="main-menu">
	<?php wp_nav_menu( array( 'theme_location' => 'main_nav' ) ); ?>
</div>
