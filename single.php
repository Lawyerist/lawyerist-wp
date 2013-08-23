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
		
				<h1 class="headline remove_bottom"><?php the_title(); ?></h1>
				<p class="postmeta half_bottom">
					by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a> on <?php the_time('F jS, Y'); ?>
					<?php if ( is_user_logged_in() ) { edit_post_link( 'edit post', ' [', ']' ); } ?>
				</p>
				
				<?php if ( has_post_thumbnail() && ( has_tag('big-image') || has_tag('big-image-everywhere') ) ) {
					the_post_thumbnail('large');
				}

				elseif ( has_post_thumbnail() ) {
					the_post_thumbnail('medium');
				} ?>
				
				<div class="post_body">
					<?php include('notes.php'); ?>
					<?php the_content(); ?>
				</div>
				
				<p class="post_bio_sep"></p>

				<div id="author_bio_footer">
					<?php echo get_avatar( get_the_author_meta('user_email') , 100 ); ?>
					<p class="remove_bottom"><?php the_author_description(); ?></p>
				</div>
			
			</div>
            
            <div class="clear"></div>

            <div id="related_posts">
    			<h3>Read More</h3>
				<?php get_related_posts_thumbnails(); ?>
			</div>
			
            <div id="comments"><?php comments_template(); ?></div>
			
			<div id="pagenav">
                <div class="alignleft">
                	<?php next_post_link('%link','<div class="pagenav_disc"><div class="genericon pagenav_leftarrow"></div></div><div class="pagenav_link">%title</div>',0) ?>
                </div>
                <div class="alignright">
                	<?php previous_post_link('%link','<div class="pagenav_link">%title</div><div class="pagenav_disc"><div class="genericon pagenav_rightarrow"></div></div>',0) ?>
                </div>
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