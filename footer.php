<div id="footer_container">

	<div id="footer">
		
		<div id="footer_legal">
			<p class="text_right">The original content within this website is &copy; 2007&ndash;<?php echo date('Y') ?>.</p>
			<p class="text_right">LAWYERIST, LAWYERIST LAB, and LAWYERIST SITES<br />are trademarks registered by Lawyerist Media, LLC.</p>
			<p class="text_right"><a href="<?php echo home_url(); ?>/about/">About</a> / <a href="<?php echo home_url(); ?>/privacy-policy/">Privacy policy</a> / <a href="<?php echo home_url(); ?>/ftc-disclosures/">FTC disclosures</a> / <a href="<?php echo home_url(); ?>/sitemap_index.xml">XML sitemap</a></p>
	  </div>

		<?php wp_footer(); ?>

	</div>

</div>


<!-- Load scripts -->

<!-- MailChimp Goal tracking -->
<script type="text/javascript">
	var $mcGoal = {'settings':{'uuid':'a5da2382c098b6541dcd6cf8e','dc':'us2'}};
	(function() {
		 var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true;
		sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s);
	})();
</script>


<!-- Responsive Menu -->
<script type="text/javascript">
	jQuery(function( $ ){

	  $("#main-menu").before('<div class="mobile-menu-icon"></div>');

	  $(".mobile-menu-icon").click(function(){
			$(this).next("#main-menu").slideToggle();
		});

	  $(".sub-menu").before('<div class="mobile-sub-menu-icon"></div>');
	  $(".mobile-sub-menu-icon").prev("a").addClass("has-sub-menu");

	  $(".mobile-sub-menu-icon").click(function(){
	    $(this).prev("a").toggleClass("open-menu");
			$(this).next(".sub-menu").slideToggle();
		});

	});
</script>
