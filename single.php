<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class($class); ?>>

<?php get_header(); ?>

<div id="content_column_container">

	<div id="content_column">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div <?php post_class('hentry'); ?>>

				<h1 class="headline entry-title"><?php the_title(); ?></h1>

				<div class="postmeta">
					<div class="author_link">By <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><span class="vcard author post-author"><span class="fn"><?php the_author(); ?></span></span></a> on <span class="post-date updated"><?php the_time('F jS, Y'); ?></span></div>
					<div class="comment_link"><a href="#disqus_thread">&nbsp;</a></div>
					<div class="clear"></div>
				</div>

				<?php /* Show featured image (1) if the post has a featured image AND
								 (2) if it's the first page of the post AND (3) the post DOES
								 NOT have the no-image tag. */

				if ( has_post_thumbnail() && $page == 1 && !has_tag('no-image') ) { ?>

					<div itemprop="image"><?php the_post_thumbnail('large'); ?></div>

				<?php } ?>

				<div class="post_body" itemprop="articleBody">

					<?php if ( !has_tag( 'no-note' ) ) { include('notes.php'); } ?>

					<?php the_content(); ?>


					<!--Begin series nav-->
					<?php if ( has_term( true , 'series' ) ) {

						echo '<div id="series_nav">';

							/* SERIES LOOP */

							$this_post[] = $post->ID;

							$series_title = wp_get_post_terms(
								$post->ID,
								'series',
								array(
									'fields' 	=> 'names',
									'orderby' => 'count',
									'order' 	=> 'DESC'
								)
							);
							$series_title = $series_title[0];

							$series_slug = wp_get_post_terms(
								$post->ID,
								'series',
								array(
									'fields' 	=> 'slugs',
									'orderby' => 'count',
									'order' 	=> 'DESC'
								)
							);
							$series_slug = $series_slug[0];

							$series_query_args = array(
								'post__not_in'		=> $this_post,
								'posts_per_page'  => 4,
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

								<h3>More in this Series: <?php echo $series_title; ?></h3>

								<ul>

									<?php while ( $series_query->have_posts() ) : $series_query->the_post(); ?>

										<li><a href="<?php the_permalink(); ?>?utm_source=lawyerist-series-footer-nav&utm_medium=internal&utm_campaign=nav" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>"><?php the_title(); ?></a></li>

									<?php endwhile; ?>

								</ul>

								<?php if ( $series_query->post_count >= 5 ) { ?>

									<p>There are even more posts in this series! <a href="<?php echo get_term_link( $series_slug, 'series' ); ?>?utm_source=lawyerist-series-footer-nav&utm_medium=internal&utm_campaign=nav">Read them all.</a></p>

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

					</div><!--end #author_bio_footer-->

				</div><!--end .post_body-->

			</div><!--end .post-->

      <div class="clear"></div>

			<!--Begin issue nav-->
			<?php if ( has_term( true , 'issue' ) ) {

				$this_post[] = $post->ID;

			  $issue_slug = wp_get_post_terms(
			    $post->ID,
			    'issue',
			    array(
			      'fields' 	=> 'slugs',
			      'orderby' => 'slug',
			      'order' 	=> 'DESC'
			    )
			  );
			  $issue_slug = $issue_slug[0];

			  $issue_title = wp_get_post_terms(
			    $post->ID,
			    'issue',
			    array(
			      'fields' 	=> 'names',
			      'orderby' => 'slug',
			      'order' 	=> 'DESC'
			    )
			  );
			  $issue_title = $issue_title[0];

			  $issue_query_args = array(
			    'orderby'					=> 'rand',
			    'order'						=> 'ASC',
			    'post__not_in'		=> $this_post,
			    'posts_per_page'	=> 4,
			    'tax_query'     	=> array(
			      array(
			        'taxonomy'  => 'issue',
			        'field'			=> 'slug',
			        'terms'			=> $issue_slug,
			      )
			    )
			  );

			  $issue_query = new WP_Query( $issue_query_args );

			  if ( $issue_query->post_count > 1 ) { ?>

			    <div class="fp_tab"><h2>More from <?php echo $issue_title; ?></h2></div>
			    <div id="issue_nav">

			      <?php while ( $issue_query->have_posts() ) : $issue_query->the_post();

							$title = the_title( '', '', FALSE );

			        if ( $issue_query->post_count == 2 ) {

			          $classes = array(
			            'two_in_issue_nav'
			          );

			        } elseif ( $issue_query->post_count == 3 ) {

			          $classes = array(
			            'three_in_issue_nav'
			          );

							} elseif ( !wp_is_mobile() && strlen( $title ) > 80 ) {

		            $title = substr( $title, 0, 79 );
		            $title .= ' …';

		          } elseif ( wp_is_mobile() && strlen( $title ) > 70 ) {

								$title = substr( $title, 0, 69 );
		            $title .= ' …';

							} ?>

			        <a <?php post_class($classes); ?> href="<?php the_permalink(); ?>?utm_source=lawyerist-issue-footer-nav&utm_medium=internal&utm_campaign=nav" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
			          <div class="issue_headline"><?php echo $title; ?></div>
			          <?php if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'thumbnail' );
								} else {
									echo '<img src="' . get_template_directory_uri() . '/images/fff-thumb.png" class="attachment-thumbnail wp-post-image" />';
								} ?>
			        </a>

			      <?php endwhile; ?>

			    </div><!--end #issue_nav-->
			    <div class="clear"></div>
			    <div class="fp_bottom_tab issue_nav_bottom_tab"><h2><a href="https://lawyerist.com/issue/<?php echo $issue_slug; ?>/">Read the Full Issue</a></h2></div>

			    <?php wp_reset_postdata();

			  }

			} ?>
			<!--End issue nav-->


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

		<?php endwhile; endif; ?>

	</div><!-- end #content_column -->

	<ul id="sidebar_column">
		<?php include('sidebar.php'); ?>
	</ul>

	<div class="clear"></div>

</div><!--end #content_column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
