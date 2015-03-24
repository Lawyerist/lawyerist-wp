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

					<div id="author_bio_footer">
						<?php echo get_avatar( get_the_author_meta('user_email') , 100 ); ?>
						<p class="remove_bottom"><?php the_author_description(); ?></p>
					</div>

				</div>

				<div id="category_tag_lists">
					<p class="category_list"><small><?php echo get_the_category_list( ', ' ); ?></small></p>
					<?php echo get_the_tag_list( '<p class="tag_list"><small>', ', ', '</small></p>' ); ?>
				</div>

				<!--Begin series nav-->
				<?php if ( has_term( true , 'series' ) ) {

					$this_post = $post->ID; ?>

					<div id="series_nav">

						<?php /* SERIES LOOP */

							$series_title = wp_get_post_terms(
								$post->ID,
								'series',
								array(
									'fields' 	=> 'names',
									'orderby' => 'count',
									'order' 	=> 'DESC'
								)
							);

							$series_slug = wp_get_post_terms(
								$post->ID,
								'series',
								array(
									'fields' 	=> 'slugs',
									'orderby' => 'count',
									'order' 	=> 'DESC'
								)
							);

							$series_query_args = array(
								'nopaging'				=> true,
								'posts_per_page'  => 10,
								'tax_query'     	=> array(
									array(
										'taxonomy'  => 'series',
										'field'			=> 'slug',
										'terms'			=> $series_slug[0],
									)
								)
							);

							$series_query = new WP_Query( $series_query_args );

								if ( $series_query->post_count > 1 ) {

									echo '<p class="series_tag">This post is part of a series:</p>';
									echo '<h3>' . $series_title[0] . '</h3>';
									echo '<ul>';

									while ( $series_query->have_posts() ) : $series_query->the_post();

										echo '<li>';

										if ( $this_post == $post->ID ) {
											echo the_title();
										} else { ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>"><?php the_title(); ?></a>
										<?php }

										echo '</li>';

									endwhile;
									wp_reset_postdata();

									echo '</ul>';

									if ( $series_query->post_count > 10 ) {

										echo 'There are even more posts in this series! <a href="' . get_term_link( $series_slug[0], 'series' ) .  '">Read them all here.</a>';

									}

								}

						/* END SERIES LOOP */ ?>

					</div>

				<?php } ?><!--End series nav-->

			</div>

      <div class="clear"></div>

      <?php comments_template(); ?>

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
