<?php

$content  = get_the_content();
$pattern  = '#<h2[^>]*>(?P<heading>.*)<\/h2>#i';
$toc      = null;
$i        = 1;

if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {

  ob_start();

  ?>

  <div class="card toc-card">

    <p class="card-label">On this Page</p>

    <nav class="toc">
      <ul>

        <?php foreach ( $matches as $match ) { ?>

          <?php

          // This is a little clunky because get_the_content() gets the
          // unfiltered content, which means headings don't have the IDs added
          // by functions.php:lwyrst_add_heading_ids(). So we have to recreate
          // those IDs here. As long as the functions match, this will work
          // fine. If they don't match, it won't.

          $id = sanitize_title( $match[ 'heading' ] );

          ?>

          <li>
            <a href="#<?php echo $id; ?>">
              <div class="toc-num"><?php echo $i++; ?></div>
              <div class="toc-heading"><?php echo $match[ 'heading' ]; ?></div>
            </a>
          </li>

        <?php } ?>

      </ul>
    </nav>
  </div>

  <?php

  $toc = ob_get_clean();

}

echo $toc;
