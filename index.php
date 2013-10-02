<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body class="custom index<?php if ( wp_is_mobile() ) { ?> mobile<?php } ?>">

<?php $ltheme_options = get_option( 'theme_ltheme_options' ); ?>

<?php get_header(); ?>

<div id="content_column_container">

    <div id="content_column">
	
		<?php global $wp_query;
		
		if ( is_author() ) {
			$author = $wp_query->query_vars['author'];
			$author_name = get_the_author_meta('display_name',$author);
			$author_bio = get_the_author_meta('description',$author);
			$author_avatar = get_avatar( get_the_author_meta('user_email',$author) , 100 );
			
			echo '<div id="archive_header"><h1>' . $author_name . '</h1>' . "\n" . $author_avatar . "\n" . '<p class="author_descr">' . $author_bio . '</p><div class="clear"></div></div>';

		} elseif ( is_category() ) {
			$cat = $wp_query->query_vars['cat'];
			$cat_descr = category_description($cat);
			
			echo '<div id="archive_header"><h1>';
			single_cat_title();
			echo '</h1>' . "\n" . '<p>' . $cat_descr . '</p></div>';
		
		} elseif ( is_tag() ) {
			$tag = $wp_query->query_vars['tag'];
			$tag_descr = tag_description($tag);
			
			echo '<div id="archive_header"><h1>Posts tagged "';
			single_tag_title();
			echo '"</h1></div>';
        
        } ?>

		<?php if ( !is_paged() ) { ?>

			<!-- Loop 1: this week -->

			<div id="current_posts">
		
			<h3>THIS WEEK on LAWYERIST</h3>
		
			<?php 
			$post_num = 1;
		
			$week = date('W');
			$year = date('Y');
			$my_query = new WP_Query( 'year=' . $year . '&w=' . $week );
		
			while ( $my_query->have_posts() ) : $my_query->the_post();

				$do_not_duplicate[] = $post->ID;
				$num_comments = get_comments_number();
			
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
				$url = $thumb['0']; ?>

				<a class="index_post post<?php if ( $post_num == 1 ) { echo ' current_post'; } ?>" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

					<?php if ( $post_num == 1 ) { ?>
						<?php the_post_thumbnail('large'); ?>
						<h2 class="headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
						<div class="postmeta">					
							<?php if ( $num_comments > 0 ) { ?>
								<div class="comment_link th_comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
							<?php } ?>
							<div class="author_link th_author_link">by <?php the_author(); ?></div>
						</div>
						<div class="clear"></div>
						<p class="excerpt remove_bottom"><?php echo get_the_excerpt(); ?></p>
					<?php }

					else { ?>
						<?php the_post_thumbnail('thumbnail'); ?>
						<h2 class="headline th_headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
						<div class="postmeta th_postmeta">					
							<?php if ( $num_comments > 0 ) { ?>
								<div class="comment_link th_comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
							<?php } ?>
							<div class="author_link th_author_link">by <?php the_author(); ?></div>
						</div>
						<p class="excerpt excerpt_postimg remove_bottom"><?php echo get_the_excerpt(); ?></p>
					<?php } ?>

					<div class="clear"></div>

				</a>
			
				<?php $post_num++; ?>

			<?php endwhile; ?>

			</div>
		

			<!-- Loop 2: previous posts -->
		
			<div id="previous_posts">
		
			<h3>PREVIOUSLY on LAWYERIST</h3>
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		
			if ( in_array( $post->ID, $do_not_duplicate ) ) continue;
		
				$num_comments = get_comments_number(); ?>
			
				<a class="index_post post" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
	
					<?php if ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail('thumbnail'); ?>
						<h2 class="headline th_headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
						<div class="postmeta th_postmeta">					
							<?php if ( $num_comments > 0 ) { ?>
								<div class="comment_link th_comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
							<?php } ?>
							<div class="author_link th_author_link">by <?php the_author(); ?></div>
							<p class="excerpt excerpt_postimg remove_bottom"><?php echo get_the_excerpt(); ?></p>
						</div>
					<?php }

					else { ?>
						<h2 class="headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
						<div class="postmeta">					
							<?php if ( $num_comments > 0 ) { ?>
								<div class="comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
							<?php } ?>
							<div class="author_link">by <?php the_author(); ?></div>
							<p class="excerpt remove_bottom"><?php the_excerpt(); ?></p>
						</div>
					<?php } ?>

					<div class="clear"></div>
				
				</a>
			
			<?php endwhile; endif; ?>
		
			</div>
		
			<!-- End posts -->
		
		<?php } else { ?>
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		
				$num_comments = get_comments_number(); ?>

				<a class="index_post post <?php if ( is_sticky() ) { echo 'sticky'; } ?>" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

					<?php if ( has_post_thumbnail() && has_tag('big-image-everywhere') ) { ?>
						<?php the_post_thumbnail('large'); ?>
						<h2 class="headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
						<div class="postmeta">					
							<?php if ( $num_comments > 0 ) { ?>
								<div class="comment_link th_comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
							<?php } ?>
							<div class="author_link th_author_link">by <?php the_author(); ?></div>
						</div>
						<div class="clear"></div>
						<p class="excerpt remove_bottom"><?php echo get_the_excerpt(); ?></p>
					<?php }

					elseif ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail('thumbnail'); ?>
						<h2 class="headline th_headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
						<div class="postmeta th_postmeta">					
							<?php if ( $num_comments > 0 ) { ?>
								<div class="comment_link th_comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
							<?php } ?>
							<div class="author_link th_author_link">by <?php the_author(); ?></div>
						</div>
						<p class="excerpt excerpt_postimg remove_bottom"><?php echo get_the_excerpt(); ?></p>
					<?php }

					else { ?>
						<h2 class="headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
						<div class="postmeta">					
							<?php if ( $num_comments > 0 ) { ?>
								<div class="comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
							<?php } ?>
							<div class="author_link">by <?php the_author(); ?></div>
						</div>
						<p class="excerpt remove_bottom"><?php the_excerpt(); ?></p>
					<?php } ?>

					<div class="clear"></div>

				</a>

			<?php endwhile;
			endif; ?>
		
		<?php } ?>


		<div id="pagenav_container">
			<div id="pagenav">
				<div class="alignleft">
					<?php previous_posts_link('<div class="pagenav_disc"><div class="genericon pagenav_leftarrow"></div></div><div class="pagenav_link">browse newer posts</div>') ?>
				</div>
				<div class="alignright">
					<?php next_posts_link('<div class="pagenav_link">browse older posts</div><div class="pagenav_disc"><div class="genericon pagenav_rightarrow"></div></div>') ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	
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