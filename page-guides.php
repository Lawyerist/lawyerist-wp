<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class($class); ?>>

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<h1 class="headline">Lawyerist Survival Guides</h1>

		<div class="postmeta">
			<div class="breadcrumbs">Guides</div>
		</div>

		<div id="survival_guides">

			<?php

			$downloads_args = array(
				'post_type'	=> 'download',
				'tax_query'	=> array(
					array(
						'taxonomy'	=> 'download_category',
						'field'			=> 'slug',
						'terms'			=> 'guides',
					),
				),
			);

			$downloads = new WP_Query( $downloads_args );

			if ( $downloads->have_posts() ) :
			while ( $downloads->have_posts() ) : $downloads->the_post();

			?>

				<a <?php post_class($class); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('medium'); }

					$price = edd_get_download_price( get_the_ID() );

					if ( $price == 0 ) { ?>
						<div class="price_tag">FREE</div>
					<?php } else { ?>
						<div class="price_tag"><?php edd_price( get_the_ID() ); ?></div>
					<?php } ?>

				</a>

			<?php

			endwhile;
			endif;

			?>

			<div class="clear"></div>

		</div><!-- end #survival_guides -->

	</div><!-- end #content_column -->


	<ul id="sidebar_column">
		<?php include('sidebar.php'); ?>
	</ul>

	<div class="clear"></div>


</div><!-- end #content_column_container -->

<div class="clear"></div>


<?php get_footer(); ?>


</body>
</html>
