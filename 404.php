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

				<form accept-charset="UTF-8" action="https://zr188.infusionsoft.com/app/form/process/1694a4caccf4e3492ea92528c1e598ae" class="infusion-form" method="POST">
					<input name="inf_form_xid" type="hidden" value="1694a4caccf4e3492ea92528c1e598ae" />
					<input name="inf_form_name" type="hidden" value="Lawyerist Insider 404 Page Signup Form" />
					<input name="infusionsoft_version" type="hidden" value="1.29.11.21" />
					<div class="infusion-field">
						<label for="inf_field_FirstName">First Name *</label>
						<input class="infusion-field-input-container" id="inf_field_FirstName" name="inf_field_FirstName" type="text" />
					</div>
					<div class="infusion-field">
						<label for="inf_field_LastName">Last Name *</label>
						<input class="infusion-field-input-container" id="inf_field_LastName" name="inf_field_LastName" type="text" />
					</div>
					<div class="infusion-field">
						<label for="inf_field_Email">Email *</label>
						<input class="infusion-field-input-container" id="inf_field_Email" name="inf_field_Email" type="text" />
					</div>
					<div class="infusion-submit">
						<input type="submit" value="Submit" />
					</div>
				</form>

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
