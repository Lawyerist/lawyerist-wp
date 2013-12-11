<div id="leaderboard_container">

	<!-- lawyerist_ap1_leaderboard -->
	<div id='div-gpt-ad-1356989285353-0' style='width:728px; height:90px;'>
	<script type='text/javascript'>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1356989285353-0'); });
	</script>
	</div>

</div>

<div id="header_container">
<div id="header">

	<?php if ( is_front_page() ) { ?>
		<h1 id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); echo ' &mdash; '; bloginfo('description'); ?></a></h1>
		<?php }

	else { ?>
		<p id="title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); echo ' &mdash; '; bloginfo('description'); ?></a></p>
		<?php } ?>
	
	<div id="blog_forum_nav">
		<ul>
			<li class="nav_blog"><a href="http://lawyerist.com" title="You are here" rel="nofollow">blog</a></li>
			<li class="nav_lab"><a href="http://lab.lawyerist.com">lab</a></li>
    		<li class="nav_sites"><a href="http://sites.lawyerist.com">sites</a></li>
		</ul>
	</div>

	<div id="email_social">
	<ul>
			<li class="lawyerist_insider_header_signup">
				<form id="lawyerist_insider_subscribe" action="http://lawyerist.us2.list-manage.com/subscribe/post?u=a5da2382c098b6541dcd6cf8e&amp;id=30d7a1f6e2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
					<input type="email" onblur="if (this.value == '') {this.value = 'Enter email address for weekly updates';}" onfocus="if (this.value == 'Enter email address for weekly updates') {this.value = '';}" value="Enter email address for weekly updates" name="EMAIL" class="required email" id="mce-EMAIL">
					<input type="hidden" value="1" name="group[5769][1]" id="mce-group[5769]-5769-0" checked>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>
				</form>	
			</li>
		<li><a class="linkedin sprite" href="http://www.linkedin.com/company/lawyerist-media-llc" title="Connect with Lawyerist on LinkedIn" target="_blank"></a></li>
		<li><a class="facebook sprite" href="http://facebook.com/lawyerist" title="Friend Lawyerist on Facebook" target="_blank"></a></li>
		<li><a class="twitter sprite" href="http://twitter.com/lawyerist" title="Follow Lawyerist on Twitter" target="_blank"></a></li>
		<li class="lawyerist_connect_more">
			<a href="http://lawyerist.com/subscribe/" title="More ways to subscribe to connect with Lawyerist">
			<div class="connect_more">More</div>
			<div class="connect_ways_to">ways to</div>
			<div class="connect_connect">Connect</div>
			</a>
		</li>
	</ul>
	</div>

	<div class="clear"></div>

</div>
</div>

<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
