<!DOCTYPE html>
<html lang="en">

<?php get_template_part( 'head' ); ?>

<body <?php body_class( $class ); ?>>

<?php get_header(); ?>

<div id="content_column_container">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div <?php post_class( 'hentry' ); ?>>

				<div class="headline_postmeta">

					<h1 class="headline entry-title"><?php the_title(); ?></h1>
					<?php lawyerist_postmeta(); ?>
					<div class="clear"></div>

				</div>

				<?php /* Show featured image (1) if the post has a featured image AND
								 (2) if it's the first page of the post AND (3) the post DOES
								 NOT have the no-image tag. */

				if ( has_post_thumbnail() && !has_tag('no-image') ) { ?>

					<div itemprop="image"><?php the_post_thumbnail('single_featured'); ?></div>

				<?php } ?>

			<div id="content_column">

				<div class="post_body" itemprop="articleBody">

					<?php the_content(); ?>
					<div class="clear"></div>

					<div id="post_footer">

						<!--Begin series nav-->
						<?php if ( has_term( true , 'series' ) ) {

							echo '<div id="series_nav">';

								/* SERIES LOOP */

								$series_ID = wp_get_post_terms(
									$post->ID,
									'series',
									array(
										'fields' 	=> 'ids',
										'orderby' => 'count',
										'order' 	=> 'DESC'
									)
								);

								$series_info				= get_term( $series_ID[0] );
								$series_title				= $series_info->name;
								$series_description = $series_info->description;
								$series_slug				= $series_info->slug;
								$series_url					=	get_term_link( $series_ID[0], 'series' );

								$series_query_args = array(
									'orderby'					=> 'date',
									'order'						=> 'ASC',
									'posts_per_page'	=> 10,
									'tax_query'     	=> array(
										array(
											'taxonomy'  => 'series',
											'field'			=> 'slug',
											'terms'			=> $series_slug,
										)
									)
								);

								$series_query = new WP_Query( $series_query_args );

								if ( $series_query->post_count > 1 ) { ?>

									<p class="h3">More in this Series: <?php echo $series_title; ?></p>

									<?php if ( $series_description != false ) { echo '<p>' . $series_description . '</p>'; } ?>

									<ul>

										<?php while ( $series_query->have_posts() ) : $series_query->the_post();

											if ( get_the_ID() == $current_post ) { ?>

												<li><?php the_title(); ?></li>

											<?php } else { ?>

												<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>"><?php the_title(); ?></a></li>

											<?php } ?>

										<?php endwhile; ?>

									</ul>

									<?php if ( $series_query->found_posts > 4 ) { ?>

										<p><a href="<?php echo $series_url ?>">See all the posts in this series.</a></p>

									<?php }

								}

								wp_reset_postdata(); ?>

							</div>

						<?php } ?>
						<!--End series nav-->

						<div id="pages_categories_tags">
							<?php if ( $numpages > 1 && !is_feed() ) {

								$wp_link_pages_args = array(
									'before'           => '<p class="page_links">',
									'after'            => '</p>',
									'link_before'      => '<span class="page_number">',
									'link_after'       => '</span>',
								);

								wp_link_pages( $wp_link_pages_args );

							}	?>
							<p class="category_list"><?php echo get_the_category_list( ', ' ); ?></p>
							<?php echo get_the_tag_list( '<p class="tag_list">', ', ', '</p>' ); ?>
						</div>

					</div><!-- end #post_footer -->

					<!-- Author bio footer -->
					<div id="author_bio_footer">

						<?php /* Author bio footer variables */

							$author = $wp_query->query_vars['author'];

							$author_name    = get_the_author_meta( 'display_name', $author );
							$author_website = get_the_author_meta( 'user_url', $author );
							$parsed_url     = parse_url( $author_website );
							$author_nice_website = $parsed_url['host'];
							$author_twitter = get_the_author_meta( 'twitter', $author );

							$author_avatar  = get_avatar( get_the_author_meta( 'user_email', $author ), 100, '', $author_name );

						echo $author_avatar; ?>

						<p><?php the_author_description(); ?></p>
						<div id="author_connect">
							<?php if ( $author_twitter == true ) { ?><p class="author_twitter"><a href="https://twitter.com/<?php echo $author_twitter; ?>">@<?php echo $author_twitter; ?></a></p><?php } ?>
							<?php if ( $author_website == true ) { ?><p class="author_website"><a href="<?php echo $author_website; ?>"><?php echo $author_nice_website; ?></a></p><?php } ?>
						</div>

					</div>
					<!-- End author bio footer -->

				</div><!--end .post_body-->

				<?php comments_template(); ?>

			</div><!--end .post-->

			<?php if ( !is_mobile() ) { include('sidebar.php'); } ?>

      <div class="clear"></div>

		<?php endwhile; endif; ?>

	</div><!-- end #content_column -->

	<div class="clear"></div>

</div><!--end #column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
