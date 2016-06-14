<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>
<?php wp_head(); ?>

<body <?php body_class('archive'); ?>>

<?php get_header(); ?>

<div id="content_column_container">

  <div id="content_column">

		<?php /* ARCHIVE PAGE TITLES */

      $title = single_term_title( '', FALSE);
      $descr = term_description();

      echo '<div id="archive_header"><h1>' . $title . '</h1>';
      echo "\n" . $descr;
      /* ------------------------------
      // If the WPP plugin ever turns on taxonomy options, enable this bit.
      if ( is_category() || is_tag() ) {
        echo '<p>Here are the most-popular <em>' . $title . '</em> posts:</p>';
        wpp_get_mostpopular("post_type='post'&range=all&limit=15&stats_comments=0&stats_views=0");
      }
      ------------------------------*/
      echo '</div>'; ?>


    <?php /* THE LOOP */

    $post_num = 1;

		if ( have_posts() ) : while ( have_posts() ) : the_post();

      $num_comments = get_comments_number(); ?>

			<a <?php post_class('index_post'); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>, posted on <?php the_time('F jS, Y'); ?>">

				<?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); } ?>

				<h2 class="headline remove_bottom" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
				<div class="postmeta">
          <?php lawyerist_get_byline(); ?>
          <?php if ( $num_comments > 0 ) { ?>
            <span class="comment_link"><?php comments_number( 'Leave a comment', '1 comment', '% comments' ); ?></span>
          <?php } ?>
				</div>
				<p class="excerpt remove_bottom<?php if ( has_post_thumbnail() ) { echo ' excerpt_with_thumb'; } ?>"><?php echo get_the_excerpt(); ?></p>

				<div class="clear"></div>

			</a>

      <?php if ( $post_num == 1 && is_mobile() ) { insert_lawyerist_mobile_ad(); } $post_num++; ?>

		<?php endwhile; endif;

		/* END LOOP */ ?>


		<?php lawyerist_get_pagenav(); ?>


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
