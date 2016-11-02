<!DOCTYPE html>
<html lang="en">

<?php include('head.php'); ?>

<body <?php body_class('index'); ?>>

<?php get_header(); ?>

<div id="content_column_container">

  <div id="content_column">

    <?php

    // Display the archive header if we're on an archive page.
    if ( is_archive() ) {

      $title = single_term_title( '', FALSE );
      $descr = term_description();

      echo '<div id="archive_header"><h1>' . $title . '</h1>';
      echo '\n' . $descr;
      echo '</div>';

    }

    // Display the search header if we're on a search page.
    if ( is_search() ) {

			echo '<div id="archive_header"><h1>Search results for "' . get_search_query() . '"</h1></div>';
      echo '<div id="lawyerist_content_search">';
        get_search_form();
      echo '</div>';

		}

    // Get the Loop.
    get_template_part( 'loop', 'index' );

    ?>

	</div><!-- end #content_column -->

	<?php if ( !is_mobile() ) { get_template_part( 'sidebar' ); } ?>

	<div class="clear"></div>

</div><!-- end #content_column_container -->

<div class="clear"></div>

<?php get_footer(); ?>

</body>
</html>
