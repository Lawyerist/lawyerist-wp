<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class($class); ?>>

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<div class="post">

			<h1 class="headline">We Can't Find That Page</h1>

			<div class="post_body">

				<p>Sorry, we can't find the page you are looking for. Try searching for it, in case it moved:</p>

				<div id="lawyerist_content_search">
					<?php get_search_form(); ?>
				</div>

				<p>Or, maybe you prefer a more serendipitous approach to discovery. Here are our most popular tags:</p>

				<div class="tag_cloud"><?php wp_tag_cloud('exclude=2580,2602'); ?></div>

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
