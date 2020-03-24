<?php

  if ( !get_field( 'fp_show_announcement' ) ) { return; }

  $announcement[ 'headline' ]	= get_field( 'fp_announcement_headline' );
  $announcement[ 'content' ]	= get_field( 'fp_announcement_content' );

?>

<div id="fp_announcement" class="card">

  <h2><?php echo $announcement[ 'headline' ]; ?></h2>
  <?php echo $announcement[ 'content' ]; ?>

</div>
