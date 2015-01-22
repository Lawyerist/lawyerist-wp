<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class('index'); ?>>

<?php get_header(); ?>

<div id="content_column_container">

  <div id="content_column">

		<?php /* THE LOOP */

    $paged = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
    $query_args = array(
      'paged'           => $paged,
      'tax_query'       => array(
        array(
          'taxonomy'    => 'post_format',
          'field'       => 'slug',
          'terms'       => array(
            'post-format-aside'
          ),
          'operator'  => 'NOT IN'
        )
      )
    );

    query_posts( $query_args );

		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<a <?php post_class(); ?> href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

				<?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); } ?>

				<h2 class="headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
				<div class="postmeta">
					<div class="author_link">by <?php the_author(); ?></div>
				</div>
				<p class="excerpt remove_bottom<?php if ( has_post_thumbnail() ) { echo ' excerpt_with_thumb'; } ?>"><?php echo get_the_excerpt(); ?></p>

				<div class="clear"></div>

			</a>

		<?php endwhile; endif;

		/* END LOOP */ ?>

		<div id="pagenav">
			<div class="alignleft pagenav_link_block">
				<?php previous_posts_link('<div class="genericon pagenav_leftarrow"></div><div class="pagenav_link">browse newer posts</div>',0) ?>
			</div>
			<div class="alignright pagenav_link_block">
				<?php next_posts_link('<div class="pagenav_link">browse older posts</div><div class="genericon pagenav_rightarrow"></div>',0) ?>
			</div>
			<div class="clear"></div>
		</div>

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
