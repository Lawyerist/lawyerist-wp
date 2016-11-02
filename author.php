<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body <?php body_class('archive'); ?>>

<?php get_header(); ?>

<div id="content_column_container">

  <div id="content_column">

		<?php /* AUTHOR DISPLAY */

      $author = $wp_query->query_vars['author'];

      $author_name    = get_the_author_meta( 'display_name', $author );
      $author_website = get_the_author_meta( 'user_url', $author );
      $parsed_url     = parse_url( $author_website );
      $author_nice_website = $parsed_url['host'];
      $author_bio     = get_the_author_meta( 'description', $author );
      $author_twitter = get_the_author_meta( 'twitter', $author );

      $author_avatar  = get_avatar( get_the_author_meta( 'user_email', $author ), 300, '', $author_name );

    ?>

    <div id="author_header">

      <h1><?php echo $author_name; ?></h1>

      <?php echo $author_avatar; ?>

      <p class="author_bio"><?php echo $author_bio; ?></p>

      <div id="author_connect">
        <?php if ( $author_twitter == true ) { ?><p class="author_twitter"><a href="https://twitter.com/<?php echo $author_twitter; ?>">@<?php echo $author_twitter; ?></a></p><?php } ?>
        <?php if ( $author_website == true ) { ?><p class="author_website"><a href="<?php echo $author_website; ?>"><?php echo $author_nice_website; ?></a></p><?php } ?>
      </div>

      <div class="clear"></div>

    </div>


    <?php
    // Get the Loop.
    get_template_part( 'loop', 'index' );
    ?>


	</div><!-- end #content_column -->


  <?php if ( !is_mobile() ) { include('sidebar.php'); } ?>

	<div class="clear"></div>


</div><!-- end #content_column_container -->

<div class="clear"></div>


<?php get_footer(); ?>


</body>
</html>
