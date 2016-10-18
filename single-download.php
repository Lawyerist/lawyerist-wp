<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body <?php body_class($class); ?>>

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div <?php post_class('hentry'); ?>>

				<h1 class="headline entry-title"><?php the_title(); ?></h1>

				<div class="postmeta">
					<div class="breadcrumbs"><a href="https://lawyerist.com/guides/">Guides</a> / <?php the_title(); ?></div>
				</div>

				<?php if ( get_post_type() == 'download' && has_post_thumbnail() ) { ?>

					<div itemprop="image"><?php the_post_thumbnail('medium'); ?></div>

				<?php } ?>

				<div class="post_body" itemprop="articleBody">

					<?php the_content(); ?>
					<div class="clear"></div>

					<?php if ( !is_feed() ) { wp_link_pages(); } ?>

				</div><!--end .post_body-->

			</div><!--end .post-->

      <div class="clear"></div>

		<?php endwhile; endif; ?>

	</div><!-- end #content_column -->

	<div id="ads_sidebar">
		<?php include('ads-sidebar.php'); ?>
	</div>

	<div class="clear"></div>

</div><!--end #content_column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
