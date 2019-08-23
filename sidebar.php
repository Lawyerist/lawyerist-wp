<?php

echo '<div id="sidebar_column">';

	if ( !is_single() || ( is_single() && !has_tag('no-ads') ) ) {

		lawyerist_get_display_ad();

	}

	lawyerist_platinum_sponsors_widget();

	dynamic_sidebar( 'sidebar' );

echo '</div>' . "\n" . '<!-- end #sidebar_column -->';

?>
