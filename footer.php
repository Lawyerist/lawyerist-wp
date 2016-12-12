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

<!-- Responsive Menu -->
<script type="text/javascript">
	jQuery(function( $ ){
	  $( ".main-menu-item a" ).click(function() {
			$( this ).toggleClass( "open" ).next( ".main-menu-dropdown" ).slideToggle( 145 );
			$( ".open" ).not( this ).toggleClass( "open" ).next( ".main-menu-dropdown" ).slideToggle( 95 );
		});
	});
</script>


<!--
Load trackers
--------------------------->
