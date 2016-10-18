<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body <?php body_class('index'); ?>>

<?php get_header(); ?>

<div id="content_column_container">

  <div id="content_column">

    <?php if ( is_archive() ) {

      $title = single_term_title( '', FALSE);
      $descr = term_description();

      echo '<div id="archive_header"><h1>' . $title . '</h1>';
      echo "\n" . $descr;
      echo '</div>';

    }

    if ( is_search() ) {

			echo '<div id="archive_header"><h1>Search results for "' . get_search_query() . '"</h1></div>';
      echo '<div id="lawyerist_content_search">';
        get_search_form();
      echo '</div>';

		} ?>


    <?php /* THE LOOP */

    $index_query_args = array(
      'post_type' => array(
        'post',
        'page',
        'download',
      ),
    );

    $index_query = new WP_Query( $index_query_args );

    $post_num = 1;

		if ( $index_query->have_posts() ) : while ( $index_query->have_posts() ) : $index_query->the_post();
    ?>

			<a <?php post_class(); ?> href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

        <?php
        if ( has_post_thumbnail() && has_post_format( 'aside' ) ) {
          the_post_thumbnail( 'aside_thumbnail' );
        } elseif ( has_post_thumbnail() ) {
          the_post_thumbnail( 'standard_thumbnail' );
        }
        ?>

        <div class="headline_excerpt">

  				<h2 class="headline" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>

  				<?php if ( !is_mobile() ) { ?>
            <p class="excerpt<?php if ( has_post_thumbnail() ) { echo ' excerpt_with_thumb'; } ?>"><?php echo get_the_excerpt(); ?></p>
          <?php } ?>

          <?php lawyerist_get_postmeta(); ?>

        </div>

				<div class="clear"></div>

			</a><!-- End .post -->

      <?php
      if ( $post_num == 1 && is_mobile() ) { insert_lawyerist_ap2(); }
      if ( $post_num == 3 && is_mobile() ) { insert_lawyerist_ap3(); }

      $post_num++;

		endwhile; endif;

		/* END LOOP */ ?>


		<?php lawyerist_get_pagenav(); ?>


	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { include('sidebar.php'); } ?>

	<div class="clear"></div>

</div><!-- end #content_column_container -->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
