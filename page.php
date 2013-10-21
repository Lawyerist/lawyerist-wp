<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body id="post-<?php the_ID(); ?>" class="custom single page<?php if ( wp_is_mobile() ) { ?> mobile<?php } ?>">

<?php $ltheme_options = get_option( 'theme_ltheme_options' ); ?>

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">
		
		<?php if ( have_posts() ) :
		while ( have_posts() ) : the_post(); ?>

			<div class="post">
		
				<h1 class="headline"><?php the_title(); ?></h1>
				<p class="postmeta">
					<?php if ( is_user_logged_in() ) { edit_post_link( 'edit page', ' [', ']' ); } ?>
				</p>

				<?php if ( has_post_thumbnail() ) { 
					the_post_thumbnail('large');
				} ?>
				
				<div class="post_body">
					<?php the_content(); ?>
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