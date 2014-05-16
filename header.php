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
			<li class="nav_lab"><a href="http://lab.lawyerist.com">forum</a></li>
    		<li class="nav_sites"><a href="http://sites.lawyerist.com">sites</a></li>
    		<li class="nav_store"><a href="http://lawyerist.com/store/">store</a></li>
		</ul>
	</div>

	<div id="email_social">
	<ul>
			<li class="lawyerist_insider_header_signup">
				<form id="lawyerist_insider_subscribe" accept-charset="UTF-8" action="https://zr188.infusionsoft.com/app/form/process/f0c3c55ad3fc171fd11e4f98c9d49a78" class="infusion-form" method="POST">
					<input name="inf_form_xid" type="hidden" value="f0c3c55ad3fc171fd11e4f98c9d49a78" />
					<input name="inf_form_name" type="hidden" value="Sign up for newsletter" />
					<input name="infusionsoft_version" type="hidden" value="1.29.11.21" />
					<label for="inf_field_Email">Email *</label>
					<input class="infusion-field-input-container" id="inf_field_Email" name="inf_field_Email" type="text" placeholder="Enter your email address to subscribe" />
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
