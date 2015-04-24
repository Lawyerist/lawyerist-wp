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

						<?php /* Author bio footer variables */

							$author = $wp_query->query_vars['author'];

				      $author_name    = get_the_author_meta( 'display_name', $author );
				      $author_website = get_the_author_meta( 'user_url', $author );
				      $parsed_url     = parse_url( $author_website );
				      $author_nice_website = $parsed_url['host'];
				      $author_twitter = get_the_author_meta( 'twitter', $author );

				      $author_avatar  = get_avatar( get_the_author_meta( 'user_email', $author ), 100, '', $author_name );

						?>

						<?php echo $author_avatar; ?>

						<p><?php the_author_description(); ?></p>
						<div id="author_connect">
			        <?php if ( $author_twitter == true ) { ?><p class="author_twitter"><a href="https://twitter.com/<?php echo $author_twitter; ?>">@<?php echo $author_twitter; ?></a></p><?php } ?>
			        <?php if ( $author_website == true ) { ?><p class="author_website"><a href="<?php echo $author_website; ?>"><?php echo $author_nice_website; ?></a></p><?php } ?>
			      </div>

					</div>

				</div>

				<div id="category_tag_lists">
					<p class="category_list"><small><?php echo get_the_category_list( ', ' ); ?></small></p>
					<?php echo get_the_tag_list( '<p class="tag_list"><small>', ', ', '</small></p>' ); ?>
				</div>

				<?php /* ISSUE NAV */

				if ( has_term( true , 'issue' ) ) {

					$this_post = $post->ID;

					$issue_title = wp_get_post_terms(
						$post->ID,
						'issue',
						array(
							'fields' 	=> 'names',
							'orderby' => 'slug',
							'order' 	=> 'DESC'
						)
					);

					$issue_id = wp_get_post_terms(
						$post->ID,
						'issue',
						array(
							'fields' 	=> 'ids',
							'orderby' => 'slug',
							'order' 	=> 'DESC'
						)
					);

					$issue_descr = term_description( $issue_id[0] , 'issue' );
					$issue_descr = strip_tags( $issue_descr );

					$issue_slug = wp_get_post_terms(
						$post->ID,
						'issue',
						array(
							'fields' 	=> 'slugs',
							'orderby' => 'slug',
							'order' 	=> 'DESC'
						)
					);

					$issue_query_args = array(
						'nopaging'				=> true,
						'orderby'					=> 'date',
						'order'						=> 'ASC',
						'tax_query'     	=> array(
							array(
								'taxonomy'  => 'issue',
								'field'			=> 'slug',
								'terms'			=> $issue_slug[0],
							)
						)
					);

					echo '<h3>Read the Rest of ' . $issue_title[0] . '</h3>';

					echo '<div id="issue_nav">';

						echo '<div id="issue_header">';
							echo '<img class="cover_title" src="' . get_template_directory_uri() . '/images/lawyerist-magazine-cover-title.png" />';
							echo '<div class="issue_label">' . $issue_title[0] . '<span class="issue_date">' . $issue_descr . '</span></div>';
						echo '</div>';

						echo '<div id="issue_contents">';

							/* Cover story loop */

							$issue_query_cover_args = $issue_query_args;
							$issue_query_cover_args = array_merge(
							  $issue_query_cover_args,
							  array(
							    'tag'							=>	'cover',
							    'posts_per_page'	=>	1
							  )
							);

							$issue_query = new WP_Query( $issue_query_cover_args );
							if ( $issue_query->have_posts() ) : while ( $issue_query->have_posts() ) : $issue_query->the_post();

								if ( has_post_thumbnail() ) { the_post_thumbnail( 'featured_top' ); } ?>

								<div id="issue_cover_story">

									<?php if ( $this_post == $post->ID ) { ?>
										<h2 class="issue_cover_headline headline issue_headline"><?php the_title(); ?></h2>
										<div class="issue_author">by <?php the_author(); ?></div>
									<?php } else { ?>
										<h2 class="issue_cover_headline headline issue_headline"><a href="<?php the_permalink(); ?>?utm_source=lawyerist-issue-footer-nav&utm_medium=internal&utm_campaign=nav" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>"><?php the_title(); ?></a></h2>
										<div class="issue_author">by <?php the_author(); ?></div>
									<?php } ?>

								</div>

						  <?php endwhile; endif;

							/* End cover story loop */


							echo '<ul>';

								/* Published posts loop */

								$issue_query_posts_args = $issue_query_args;
								$issue_query_posts_args['posts_per_page'] = -1;

								$issue_query = new WP_Query( $issue_query_posts_args );
								if ( $issue_query->have_posts() ) : while ( $issue_query->have_posts() ) : $issue_query->the_post();

									if ( has_tag('cover') ) { continue; } ?>

									<li>

										<?php if ( $this_post == $post->ID ) { ?>
											<div class="issue_headline"><?php the_title(); ?></div>
											<div class="issue_author">by <?php the_author(); ?></div>
										<?php } else { ?>
											<div class="issue_headline"><a href="<?php the_permalink(); ?>?utm_source=lawyerist-issue-footer-nav&utm_medium=internal&utm_campaign=nav" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>"><?php the_title(); ?></a></div>
											<div class="issue_author">by <?php the_author(); ?></div>
										<?php } ?>

									</li>

							  <?php endwhile;	endif;

								/* End published post loop */

								echo '<div class="clear"></div>';

							echo '</ul>';

						echo '</div>'; /* End #issue_contents */

					echo '</div>'; /* end #issue_nav */

				}

				wp_reset_postdata();

				/* END ISSUE NAV */ ?>


				<!--Begin series nav-->
				<?php if ( has_term( true , 'series' ) ) {

					$this_post = $post->ID;

					echo '<div id="series_nav">';

						/* SERIES LOOP */

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
									<a href="<?php the_permalink(); ?>?utm_source=lawyerist-series-footer-nav&utm_medium=internal&utm_campaign=nav" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>"><?php the_title(); ?></a>
								<?php }

								echo '</li>';

							endwhile;

							echo '</ul>';

							if ( $series_query->post_count >= 10 ) {

								echo 'There are even more posts in this series! <a href="' . get_term_link( $series_slug[0], 'series' ) .  '?utm_source=lawyerist-series-footer-nav&utm_medium=internal&utm_campaign=nav">Read them all here.</a>';

							}

						}

						wp_reset_postdata();

						/* END SERIES LOOP */

					echo '</div>';

				} ?><!--End series nav-->

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

	</div><!-- end #content_column -->

	<ul id="sidebar_column">
		<?php include('sidebar.php'); ?>
	</ul>

	<div class="clear"></div>

</div>

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
