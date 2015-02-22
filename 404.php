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
					  <input type="text" id="st-search-input-content" class="st-search-input" value="Search" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" />
					</form>
					<div id="st-results-container"></div>
				</div>

				<p>Or, maybe you prefer a more serendipitous approach to discovery. Here are our most-popular tags:</p>

				<div class="tag_cloud"><?php wp_tag_cloud('exclude=2580,2602'); ?></div>

				<p>If these don't work for you, check out our <a href="http://lawyerist.com/start/">start page</a>.</p>

				<h3>Before you go, sign up for our email newsletter:</h3>

				<?php echo do_shortcode( '[gravityform id="14" name="Lawyerist Insider Signup" title="false" description="false" ajax="true"]' ) ?>

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
