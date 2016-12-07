<?php /* Template Name: No Sidebar */ ?>

<!DOCTYPE html>
<html lang="en">

<?php get_template_part('head'); ?>


<body <?php body_class( 'no-sidebar' ); ?>>

<?php get_header(); ?>

<div id="column_container">

	<div id="content_column">

		<?php

		if ( have_posts() ) :
		while ( have_posts() ) : the_post();

		?>

			<div <?php post_class($class); ?>>

				<h1 class="headline"><?php the_title(); ?></h1>

				<?php if ( has_post_thumbnail() ) {
					the_post_thumbnail('full');
				} ?>

				<div class="post_body">
					<?php the_content(); ?>
				</div>

			</div>

		<?php

		endwhile;
		endif;

		?>


	</div><!-- end #content_column -->


</div><!-- end #column_container -->

<div class="clear"></div>


<?php get_footer(); ?>


</body>
</html>
