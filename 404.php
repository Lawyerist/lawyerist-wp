<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class($class); ?>>

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<div class="post">

			<h1 class="headline" id="404">404: Congratulations! You Found a Typo!</h1>

			<div class="post_body">

				<p>Legal fame and glory are yours!</p>

				<p><iframe width="640" height="360" src="//www.youtube.com/embed/N_auFicUWK4?list=PL923B0FEA7688AA58" frameborder="0" allowfullscreen></iframe></p>

				<p>Seriously, it looks like the page you were looking for doesn't exist. Try searching for it, in case it moved:</p>

				<div id="lawyerist_content_search">
					<form>
					  <input type="text" id="st-search-input" class="st-search-input" value="Search" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" />
					</form>
					<div id="st-results-container"></div>
					<script type="text/javascript">
					  var Swiftype = window.Swiftype || {};
					  (function() {
						Swiftype.key = 'Y6pVA25sVzapo465JPtR';
						Swiftype.inputElement = '#st-search-input';
						Swiftype.resultContainingElement = '#st-results-container';
						Swiftype.attachElement = '#st-search-input';
						Swiftype.renderStyle = "overlay";

						var script = document.createElement('script');
						script.type = 'text/javascript';
						script.async = true;
						script.src = "//swiftype.com/embed.js";
						var entry = document.getElementsByTagName('script')[0];
						entry.parentNode.insertBefore(script, entry);
					  }());
					</script>
				</div>

				<p>Or, maybe you prefer a more serendipitous approach to discovery. Here are our most-popular tags:</p>

				<div class="tag_cloud"><?php wp_tag_cloud('exclude=2580,2602'); ?></div>

				<p>If these don't work for you, check out our <a href="http://lawyerist.com/start/">start page</a>.</p>

				<h3>Before you go, sign up for our email newsletter:</h3>

				<!-- Begin MailChimp Signup Form -->
				<div id="mc_embed_signup">
				<form action="http://lawyerist.us2.list-manage.com/subscribe/post?u=a5da2382c098b6541dcd6cf8e&amp;id=30d7a1f6e2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

				<div class="mc-field-group">
					<label for="mce-FNAME">First Name  <span class="asterisk">*</span>
				</label>
					<input type="text" value="" name="FNAME" class="required" id="mce-FNAME">
				</div>
				<div class="mc-field-group">
					<label for="mce-LNAME">Last Name </label>
					<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
				</div>
				<div class="mc-field-group">
					<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
				</label>
					<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
				</div>
				<div class="mc-field-group input-group">
				    <strong>Newsletters </strong>
				    <ul><li><input checked type="checkbox" value="1" name="group[5769][1]" id="mce-group[5769]-5769-0"><label for="mce-group[5769]-5769-0">Lawyerist Insider Newsletter</label></li>
				<li><input type="checkbox" value="2" name="group[5769][2]" id="mce-group[5769]-5769-1"><label for="mce-group[5769]-5769-1">Lawyerist Insider Tech News Updates</label></li>
				</ul>
				</div>
				<div class="mc-field-group input-group">
				    <strong>Practice Type </strong>
				    <ul><li><input type="radio" value="4" name="group[5801]" id="mce-group[5801]-5801-0"><label for="mce-group[5801]-5801-0">Solo</label></li>
				<li><input type="radio" value="16" name="group[5801]" id="mce-group[5801]-5801-1"><label for="mce-group[5801]-5801-1">Small firm (2–10 lawyers)</label></li>
				<li><input type="radio" value="32" name="group[5801]" id="mce-group[5801]-5801-2"><label for="mce-group[5801]-5801-2">Medium-sized firm (16–25 lawyers)</label></li>
				<li><input type="radio" value="64" name="group[5801]" id="mce-group[5801]-5801-3"><label for="mce-group[5801]-5801-3">Large firm (25+ lawyers)</label></li>
				<li><input type="radio" value="2048" name="group[5801]" id="mce-group[5801]-5801-4"><label for="mce-group[5801]-5801-4">In-house</label></li>
				<li><input type="radio" value="128" name="group[5801]" id="mce-group[5801]-5801-5"><label for="mce-group[5801]-5801-5">Government</label></li>
				<li><input type="radio" value="256" name="group[5801]" id="mce-group[5801]-5801-6"><label for="mce-group[5801]-5801-6">Public interest/non-profit</label></li>
				<li><input type="radio" value="4096" name="group[5801]" id="mce-group[5801]-5801-7"><label for="mce-group[5801]-5801-7">Legal staff (paralegal, legal secretary)</label></li>
				<li><input type="radio" value="512" name="group[5801]" id="mce-group[5801]-5801-8"><label for="mce-group[5801]-5801-8">Not a lawyer / not in the legal industry</label></li>
				<li><input type="radio" value="1024" name="group[5801]" id="mce-group[5801]-5801-9"><label for="mce-group[5801]-5801-9">Other</label></li>
				</ul>
				</div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				    <div style="position: absolute; left: -5000px;"><input type="text" name="b_a5da2382c098b6541dcd6cf8e_30d7a1f6e2" tabindex="-1" value=""></div>
				    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
				</form>
				</div>

				<!--End mc_embed_signup-->

			</div>

		</div>

	</div>

	<ul id="sidebar_column">
		<?php include('sidebar.php'); ?>
	</ul>

	<div class="clear"></div>

</div>

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
