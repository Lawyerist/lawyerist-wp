<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class($class); ?>>

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div <?php post_class('hentry'); ?>>

				<h1 class="headline entry-title"><?php the_title(); ?></h1>

				<?php if ( get_post_type() == 'download' && has_post_thumbnail() ) { ?>

					<div itemprop="image"><?php the_post_thumbnail('medium'); ?></div>

				<?php } ?>

				<div class="post_body" itemprop="articleBody">

					<?php the_content(); ?>

					<?php if ( !is_feed() ) { wp_link_pages(); } ?>

				</div><!--end .post_body-->

			</div><!--end .post-->

      <div class="clear"></div>

		<?php endwhile; endif; ?>

	</div><!-- end #content_column -->

	<ul id="sidebar_column">
		<?php include('sidebar.php'); ?>
	</ul>

	<div class="clear"></div>

</div><!--end #content_column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
