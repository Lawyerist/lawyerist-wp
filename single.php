<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body <?php body_class($class); ?>>

<?php get_header(); ?>

<div id="content_column_container">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div <?php post_class( 'hentry' ); ?>>

				<div class="headline_postmeta">

					<h1 class="headline entry-title"><?php the_title(); ?></h1>
					<?php lawyerist_get_postmeta(); ?>
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

			</div><!--end .post-->

      <div class="clear"></div>

			<div id="after_post">

				<!-- Email signup form -->
				<div class="fp_tab">Subscribe</div>
				<div id="after_post_signup">

					<p class="h3">Get <em>Lawyerist</em> in Your Inbox, Daily</p>

					<!-- Email signup form -->
					<div id="mc_embed_signup_after_post">
					<form action="//lawyerist.us2.list-manage.com/subscribe/post?u=a5da2382c098b6541dcd6cf8e&amp;id=30d7a1f6e2&SOURCE=after_post_signup" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div class="name_input_container">
							<div class="mc_input"><input type="text" value="" name="FNAME" class="" id="mce-FNAME" placeholder="First name"></div>
							<div class="mc_input"><input type="text" value="" name="LNAME" class="" id="mce-LNAME" placeholder="Last name"></div>
							<div class="clear"></div>
						</div>
						<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email address">
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>
						<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					  <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_a5da2382c098b6541dcd6cf8e_30d7a1f6e2" tabindex="-1" value=""></div>
					  <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
					</form>
					</div><!-- End mc_embed_signup -->

					<div class="clear"></div>

				</div><!-- end #after_post_signup -->
				<div class="clear"></div>

				<!-- Current posts nav -->
				<?php

				$this_post[]	= $post->ID;

				$after_date		= date( 'Y-m-d H:i:s', strtotime( '-6 days' ) );

				$current_posts_query_args = array(
					'category__not_in'			=> 1320, // Excludes sponsor-submitted posts.
					'date_query'						=> array(
						'after'			=> $after_date,
					),
					'ignore_sticky_posts'		=> TRUE,
					'orderby'								=> 'rand',
					'post__not_in'					=> $this_post,
					'posts_per_page'				=> 4,
				);

				$current_posts_query = new WP_Query( $current_posts_query_args );

				if ( $current_posts_query->post_count > 1 ) : ?>

					<div class="fp_tab">Current Articles</div>
					<div id="current_posts_nav">

						<?php while ( $current_posts_query->have_posts() ) : $current_posts_query->the_post();

							$title = the_title( '', '', FALSE );

							if ( $current_posts_query->post_count == 2 ) {

								$classes = array(
									'two_in_current_posts_nav'
								);

							} elseif ( $current_posts_query->post_count == 3 ) {

								$classes = array(
									'three_in_current_posts_nav'
								);

							} elseif ( !wp_is_mobile() && strlen( $title ) > 70 ) {

								$title = substr( $title, 0, 69 );
								$title .= ' …';

							} elseif ( wp_is_mobile() && strlen( $title ) > 60 ) {

								$title = substr( $title, 0, 59 );
								$title .= ' …';

							} ?>

							<a <?php post_class($classes); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
								<div class="current_posts_headline"><?php echo $title; ?></div>
								<?php if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'thumbnail' );
								} else {
									echo '<img src="' . get_template_directory_uri() . '/images/fff-thumb.png" class="attachment-thumbnail wp-post-image" />';
								} ?>
							</a>

						<?php endwhile; wp_reset_postdata(); ?>

					</div><!-- end #current_posts_nav -->
					<div class="clear"></div>
					<div class="fp_bottom_tab"><a href="https://lawyerist.com/articles/">View All Articles</a></div>
					<div class="clear"></div>

				<?php endif; ?>
				<!-- End current posts nav -->

				<!-- Discussions -->
				<div class="fp_tab">Current Lab Discussions</div>
		    <div id="lab_posts">

		      <?php // Get RSS Feed(s)
		      include_once( ABSPATH . WPINC . '/feed.php' );

		      // Get a SimplePie feed object from the specified feed source.
		      $rss = fetch_feed( 'http://lab.lawyerist.com/discussions/feed.rss' );

		      if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

		        // Figure out how many total items there are, but limit it to 5.
		        $maxitems = $rss->get_item_quantity( 5 );

		        // Build an array of all the items, starting with element 0 (first element).
		        $rss_items = $rss->get_items( 0, $maxitems );

		      endif;
		      ?>

		      <ul>
		        <?php if ( $maxitems == 0 ) : ?>
		          <li><?php _e( 'No items', 'my-text-domain' ); ?></li>
		        <?php else : ?>
		          <?php // Loop through each feed item and display each item as a hyperlink. ?>
		          <?php foreach ( $rss_items as $item ) : ?>
		            <li>
		              <a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Updated on %s', 'my-text-domain' ), $item->get_date('F jS, Y @ g:i a') ); ?>">
		                <img src="https://lawyerist.com/lawyerist/wp-content/uploads/2013/10/lab-favicon.png" />
		                <div class="lab_headline"><?php echo esc_html( $item->get_title() ); ?></div>
		                <div class="clear"></div>
		              </a>
		            </li>
		          <?php endforeach; ?>
		        <?php endif; ?>
		      </ul>
		    </div><!--end #lab_posts-->
		    <div class="fp_bottom_tab"><a href="http://lab.lawyerist.com">View All Discussions</a></div>
				<div class="clear"></div>

				<!-- End discussions -->

	      <?php comments_template(); ?>

			</div><!-- end #after_post -->

		<?php endwhile; endif; ?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include('sidebar.php'); } ?>

	<div class="clear"></div>

</div><!--end #content_column_container-->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
