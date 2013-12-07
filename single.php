<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body id="post-<?php the_ID(); ?>" class="custom single<?php if ( wp_is_mobile() ) { ?> mobile<?php } ?>">

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<?php if ( have_posts() ) :
		while ( have_posts() ) : the_post(); ?>

			<div class="post">
		
				<h1 class="headline" itemprop="headline"><?php the_title(); ?></h1>
				
				<div class="postmeta">
					<div class="comment_link th_comment_link"><a href="#disqus_thread"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></a></div>
					<div class="author_link">by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> on <span itemprop="datePublished"><?php the_time('F jS, Y'); ?></span></div>
					<div class="clear"></div>
				</div>

				<?php if ( has_post_thumbnail() && has_tag('big-image') ) { ?>
					<div itemprop="image"><?php the_post_thumbnail('large'); ?></div>
				<?php }

				elseif ( has_post_thumbnail() ) { ?>
					<div itemprop="image"><?php the_post_thumbnail('medium'); ?></div>
				<?php } ?>
				
				<div class="post_body" itemprop="articleBody">
					<?php include('notes.php'); ?>
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
				
				<p class="post_bio_sep"></p>

				<div id="author_bio_footer">
					<?php echo get_avatar( get_the_author_meta('user_email') , 100 ); ?>
					<p class="remove_bottom"><?php the_author_description(); ?></p>
				</div>
			
			</div>
            
            <div class="clear"></div>

            <div id="related_posts">
    			<h3>KEEP READING on LAWYERIST</h3>
				<?php get_related_posts_thumbnails(); ?>
			</div>
			
            <div id="comments"><?php comments_template(); ?></div>
			
			<div id="pagenav">
                <div class="alignleft pagenav_link_block">
                	<?php next_post_link('%link','<div class="genericon pagenav_leftarrow"></div><div class="pagenav_link">%title</div>',0) ?>
                </div>
                <div class="alignright pagenav_link_block">
                	<?php previous_post_link('%link','<div class="pagenav_link">%title</div><div class="genericon pagenav_rightarrow"></div>',0) ?>
                </div>
                <div class="clear"></div>
            </div>

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