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

		#modal-login-screen {
			background-color: rgb( 0, 0, 0 );
			background-color: rgb( 0, 0, 0, .4 );
			height: 100%;
			width: 100%;
			position: fixed;
				left: 0;
				top: 0;
		}

		#modal-login {
			min-width: 30rem;
			padding: 2rem;
			position: absolute;
				left: 10rem;
				top: 10rem;
			width: 50%;
		}

		</style>

		<div id="modal-login-screen"></div>

		<div id="modal-login" class="card">
			<div id="login">
				<?php wp_login_form(); ?>
				<p>Not an Insider yet? <a href="#register" class="modal-register-link">Register here.</a></p>
				<p>Forgot your password? <a href="#forgot-password" class="modal-forgot-password-link">Reset it here.</a></p>
			</div>
			<div id="register">
				<?php echo do_shortcode( '[gravityform id="57" title="false" ajax="true"]' ); ?>
				<p><a href="#login" class="modal-back-to-login-link">Back to login.</a></p>
			</div>
			<div id="forgot-password">
				<p><a href="#login" class="modal-back-to-login-link">Back to login.</a></p>
			</dvi>
		</div>

	</div>

</body>
</html>
