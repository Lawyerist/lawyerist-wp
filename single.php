<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class($class); ?>>

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<?php if ( have_posts() ) :
		while ( have_posts() ) : the_post(); ?>

			<div <?php post_class('hentry'); ?>>

				<h1 class="headline entry-title"><?php the_title(); ?></h1>

				<div class="postmeta">
					<div class="author_link">by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><span class="vcard author post-author"><span class="fn"><?php the_author(); ?></span></span></a> on <span class="post-date updated"><?php the_time('F jS, Y'); ?></span></div>
					<div class="comment_link"><a href="#disqus_thread">&nbsp;</a></div>
					<div class="clear"></div>
				</div>

				<?php /* Show featured images (1) if the post has one AND (2) if it's
								 the first page of the post AND (3) the post DOES NOT have the
								 no-image tag. */
				if ( has_post_thumbnail() && $page == 1 && !has_tag('no-image') ) { ?>
					<div itemprop="image"><?php the_post_thumbnail('large'); ?></div>
				<?php } ?>

				<div class="post_body" itemprop="articleBody">
					<?php if ( !has_tag( 'no-note' ) ) { include('notes.php'); } ?>
					<?php the_content(); ?>
					<?php if ( !is_feed() ) { wp_link_pages(); } ?>
				</div>

				<div id="author_bio_footer">
					<?php echo get_avatar( get_the_author_meta('user_email') , 100 ); ?>
					<p class="remove_bottom"><?php the_author_description(); ?></p>
				</div>

				<div id="category_tag_lists">
					<p class="category_list"><small><?php echo get_the_category_list( ', ' ); ?></small></p>
					<?php echo get_the_tag_list( '<p class="tag_list"><small>', ', ', '</small></p>' ); ?>
				</div>

			</div>

      <div class="clear"></div>

			<div id="pagenav">
				<div class="alignleft pagenav_link_block">
					<?php next_post_link('%link','<div class="genericon pagenav_leftarrow"></div><div class="pagenav_link">%title</div>',0) ?>
				</div>
				<div class="alignright pagenav_link_block">
					<?php previous_post_link('%link','<div class="pagenav_link">%title</div><div class="genericon pagenav_rightarrow"></div>',0) ?>
				</div>
				<div class="clear"></div>
			</div>

      <div id="related_posts">
  			<h3>KEEP READING on LAWYERIST</h3>
				<?php get_related_posts_thumbnails(); ?>
			</div>

      <?php comments_template(); ?>

		<?php endwhile;
		endif; ?>

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
