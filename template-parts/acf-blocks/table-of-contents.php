<?php

if ( is_admin() ) {

  echo '<div class="card padded-card"><div class="card-label">Table of Contents</div>';
  echo 'Preview unavailable in the editor.';
  return;
}

echo get_toc();
