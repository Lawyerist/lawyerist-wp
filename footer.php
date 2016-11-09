<div id="footer_container">

	<div id="footer">

		<div id="footer_legal">
			<p>The original content within this website is &copy; <?php echo date('Y') ?>.</p>
			<p>LAWYERIST, LAWYERIST LAB, and LAWYERIST SITES are trademarks registered by Lawyerist Media, LLC.</p>
			<p><a href="<?php echo home_url(); ?>/privacy-policy/">Privacy policy</a> / <a href="<?php echo home_url(); ?>/ftc-disclosures/">FTC disclosures</a> / <a href="<?php echo home_url(); ?>/sitemap_index.xml">XML sitemap</a></p>
	  </div>

		<?php wp_footer(); ?>

	</div>

</div>


<!--
Load scripts
--------------------------->



<!--
Load trackers
--------------------------->

<!-- MailChimp Goal tracking -->
<script type="text/javascript">
	var $mcGoal = {'settings':{'uuid':'a5da2382c098b6541dcd6cf8e','dc':'us2'}};
	(function() {
		 var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true;
		sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s);
	})();
</script>

<!-- Drip -->
<script type="text/javascript">
  var _dcq = _dcq || [];
  var _dcs = _dcs || {};
  _dcs.account = '5816544';

  (function() {
    var dc = document.createElement('script');
    dc.type = 'text/javascript'; dc.async = true;
    dc.src = '//tag.getdrip.com/5816544.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(dc, s);
  })();
</script>
