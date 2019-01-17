<div id="footer_container">

	<div id="footer">

		<div id="footer_legal">
			<p>The original content within this website is &copy; <?php echo date('Y') ?>.</p>
			<p>Lawyerist, Lawyerist Lab, TBD Law, and The Small Firm Scorecard are trademarks registered by Lawyerist Media, LLC.</p>
			<p><a href="<?php echo home_url(); ?>/privacy-policy/">Privacy policy</a> / <a href="<?php echo home_url(); ?>/sitemap_index.xml">XML sitemap</a></p>
	  </div>

		<?php if ( is_singular() ) { echo '<p id="pageID">Page ID: ' . $post->ID . '</p>'; } ?>

		<?php wp_footer(); ?>

	</div>

</div>

<!-- Amazon Associates OneTag -->
<div id="amzn-assoc-ad-01e6e315-1d4b-424c-8d56-fc2b9f9463bb"></div><script async src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US&adInstanceId=01e6e315-1d4b-424c-8d56-fc2b9f9463bb"></script>
<!-- End Amazon Associates OneTag -->

<!-- LawyeristBot -->
<script type="text/javascript">
window.LAWDROID_BOT_ID = window.LAWDROID_BOT_ID || {};
window.LAWDROID_BOT_ID = "2340";
(function() {
var ld = document.createElement('script'); ld.type = 'text/javascript'; ld.async = true;
ld.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'lawdroid.com/widget/loader.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ld, s);
})();
</script>
<!-- End LawyeristBot -->
