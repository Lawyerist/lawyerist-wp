<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body class="custom front_page<?php if ( wp_is_mobile() ) { ?> mobile<?php } ?>">

<?php $ltheme_options = get_option( 'theme_ltheme_options' ); ?>

<?php get_header(); ?>

<div id="content_column_container">

    <div id="content_column">
    
    	<div id="this_weeks_posts">

			<h3>THIS WEEK on LAWYERIST</h3>

			<?php /* THE LOOP */

				$week = date('W');
				$year = date('Y');
				$my_query = new WP_Query( 'year=' . $year . '&w=' . $week );

				$post_num = 1;
		
				if ( $my_query->have_posts() ) {
		
					while ( $my_query->have_posts() ) : $my_query->the_post();
		
						$num_comments = get_comments_number(); ?>

						<a id="post-<?php the_ID(); ?>" class="post featured_post post_num_<?php echo $post_num; ?>" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

							<?php if ( has_post_thumbnail() ) {
									if ( $post_num == 1 ) { the_post_thumbnail( 'large' ); }
									else { the_post_thumbnail( 'featured_thumb_2' ); }
							} ?>
		
							<div class="headline_excerpt">
								<h2 class="headline" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
								<div class="postmeta">
									<?php if ( $num_comments > 0 ) { ?>
										<div class="comment_link th_comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
									<?php } ?>
									<div class="author_link">by <?php the_author(); ?></div>
									<?php if ( $post_num == 1 ) { ?><p class="excerpt remove_bottom"><?php echo get_the_excerpt(); ?></p><?php } ?>
								</div>
							</div>

							<div class="clear"></div>

						</a>

						<?php $post_num++;
			
					endwhile;
		
				}
		
				else {
		
					echo 'There are no posts to show.<br />';
					echo 'The year is ' . $year . ' and the week is ' . $week . '.';
		
				}
		
			/* END LOOP */ ?>

			<div class="clear"></div>

		</div>

		<div id="pagenav_container">
			<div id="pagenav">
				<div class="alignright">
					<a href="http://robots.samglover.net/previous-posts/"><div class="pagenav_link">browse older posts</div><div class="pagenav_disc"><div class="genericon pagenav_rightarrow"></div></div></a>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div id="lab_posts">
			<h3>NEW in the LAB</h3>

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
							<a href="<?php echo esc_url( $item->get_permalink() ); ?>"
								title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
								<?php echo esc_html( $item->get_title() ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>

		<div id="sites_network_posts">
			<h3>SITES NETWORK UPDATES</h3>
			
			<?php // Get RSS Feed(s)
			include_once( ABSPATH . WPINC . '/feed.php' );

			// Get a SimplePie feed object from the specified feed source.
			$rss = fetch_feed( 'http://sites.lawyerist.com/feed/globalpostsfeed' );

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
							<a href="<?php echo esc_url( $item->get_permalink() ); ?>"
								title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>">
								<?php echo esc_html( $item->get_title() ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
		
		<div class="clear"></div>

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