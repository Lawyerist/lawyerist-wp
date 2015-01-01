<?php /* Template Name: Landing Page */ ?>

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

			<div <?php post_class($class); ?>>

				<h1 class="headline"><?php the_title(); ?></h1>

				<?php if ( has_post_thumbnail() ) {
					the_post_thumbnail('large');
				} ?>

				<div class="post_body">
					<?php include('notes.php'); ?>
					<?php the_content(); ?>
				</div>

			</div>

		<?php endwhile;
		endif; ?>


	</div><!-- end #content_column -->

	<div class="clear"></div>


</div><!-- end #content_column_container -->

<div class="clear"></div>


<?php get_footer(); ?>


</body>
</html>
