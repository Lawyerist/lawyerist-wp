	<div id="footer-grid">

		<div id="footer">

			<p>Lawyerist.com<br />331 2nd Avenue South<br />Minneapolis, MN 55401</p>

			<p>612-424-9855</p>

			<div id="footer_legal">

				<p>The original content within this website is &copy; <?php echo date('Y') ?>.</p>

				<p>Lawyerist, Lawyerist Lab, TBD Law, and The Small Firm Scorecard are trademarks registered by Lawyerist Media, LLC.</p>

				<p><a href="<?php echo home_url(); ?>/privacy-policy/">Privacy policy</a> / <a href="<?php echo home_url(); ?>/sitemap_index.xml">XML sitemap</a></p>

		  </div>

			<?php if ( is_singular() ) { echo '<p id="pageID">Page ID: ' . $post->ID . '</p>'; } ?>

			<?php wp_footer(); ?>

		</div>

	</div>

	<?php

	if( !is_user_logged_in() ) {
		echo get_lawyerist_login( 'modal' );
	}

	?>

</body>
</html>
