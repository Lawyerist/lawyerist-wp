	<div id="footer-grid">

		<div id="footer">

			<div id="footer_legal">
				<p>The original content within this website is &copy; <?php echo date('Y') ?>.</p>
				<p>Lawyerist, Lawyerist Lab, TBD Law, and The Small Firm Scorecard are trademarks registered by Lawyerist Media, LLC.</p>
				<p><a href="<?php echo home_url(); ?>/privacy-policy/">Privacy policy</a> / <a href="<?php echo home_url(); ?>/sitemap_index.xml">XML sitemap</a></p>
		  </div>

			<?php if ( is_singular() ) { echo '<p id="pageID">Page ID: ' . $post->ID . '</p>'; } ?>

			<?php wp_footer(); ?>

		</div>

		<style>

		#modal-login-container {
			background-color: rgb( 0, 0, 0 );
			background-color: rgb( 0, 0, 0, .4 );
			height: 100%;
			width: 100%;
			position: fixed;
				left: 0;
				top: 0;
		}

		#modal-login-container .card {
			margin: 40% auto;
			min-width: 30rem;
			padding: 2rem;
			width: 50%;
		}

		</style>

		<div id="modal-login-container">

			<div class="card">
				<div id="modal-login">
					<?php wp_login_form(); ?>
				</div>
				<div id="modal-register">
					<?php echo do_shortcode( '[gravityform id="57" title="false" ajax="true"]' ); ?>
				</div>
				<div id="modal-forgot-password">
				</dvi>
			</div>

		</div>

	</div>

</body>
</html>
