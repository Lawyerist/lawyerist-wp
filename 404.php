<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body id="post-<?php the_ID(); ?>" class="custom single page<?php if ( wp_is_mobile() ) { ?> mobile<?php } ?>">

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<div <?php post_class($class); ?>>

			<h1 class="headline" id="404">Congratulations! You Found a Typo!</h1>
			
			<div class="post_body">

				<p>Legal fame and glory are yours!</p>

				<p><iframe width="640" height="360" src="//www.youtube.com/embed/N_auFicUWK4?list=PL923B0FEA7688AA58" frameborder="0" allowfullscreen></iframe></p>

				<p>Seriously, it looks like you got bad directions somewhere. If you know what you were looking for, try searching for it:</p>

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

				<div style="margin-bottom:1.571em;"><?php wp_tag_cloud('exclude=2580,2602'); ?></div>

				<p>If these don't work for you, check out our <a href="http://lawyerist.com/start/">start page</a>.</p>

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