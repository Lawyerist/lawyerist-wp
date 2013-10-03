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
        
        }


				/* THE LOOP */

				$post_num = 1;

				if ( have_posts() ) : while ( have_posts() ) : the_post();
		
					$num_comments = get_comments_number(); ?>
					
					<a class="index_post post post_num_<?php echo $post_num; if ( $post_num < 4 ) { echo ' featured_post'; } if ( $post_num == 1 ) { echo ' top_post'; } elseif ( $post_num < 4 ) { echo ' other_featured_post'; } ?>" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">
	
						<?php if ( has_post_thumbnail() ) {
							if ( $post_num == 1 ) { the_post_thumbnail( 'large' ); }
							elseif ( $post_num < 4 ) { the_post_thumbnail( 'featured_thumb_2' ); }
							else { the_post_thumbnail('thumbnail'); }
						} ?>
						
						<div class="headline_excerpt">	
							<h2 class="headline<?php if ( $post_num > 3 ) { echo ' remove_bottom'; } ?>" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
							<div class="postmeta">					
								<?php if ( $num_comments > 0 ) { ?>
									<div class="comment_link th_comment_link"><div class="comment_bubble"></div> <?php comments_number('leave a comment','1 comment','% comments'); ?></div>
								<?php } ?>
								<div class="author_link<?php if ( $post_num == 1 ) { echo ' double_bottom'; } ?>">by <?php the_author(); ?></div>
								<?php if ( $post_num == 1 || $post_num > 3 ) { ?>
									<p class="excerpt remove_bottom<?php if ( has_post_thumbnail() && $post_num > 3 ) { echo ' excerpt_with_thumb'; } ?>"><?php echo get_the_excerpt(); ?></p>
								<?php } ?>
							</div>
						</div>

						<div class="clear"></div>

					</a>
					
					<?php $post_num++;
			
				endwhile; endif;
				
				/* END LOOP */ ?>


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