	<div id="footer-grid">

		<div id="footer">

			<p>The original content within this website is &copy; <?php echo date( 'Y' ) ?>.</p>

			<p>Lawyerist, Lawyerist Lab, TBD Law, Small Firm Dashboard, and The Small Firm Scorecard are trademarks registered by Lawyerist Media, LLC.</p>

			<p><a href="<?php echo home_url(); ?>/privacy-policy/">Privacy policy</a> / <a href="<?php echo home_url(); ?>/sitemap_index.xml">XML sitemap</a></p>

			<?php if ( is_singular() ) { echo '<p id="pageID">Page ID: ' . $post->ID . '</p>'; } ?>

			<?php wp_footer(); ?>

		</div>

	</div>

</body>
</html>
