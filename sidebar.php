<?php

echo '<div id="sidebar_column">';

	if ( !is_single() || ( is_single() && !has_tag('no-ads') ) ) {

		echo '<div id="sidebar_ads">';

		lawyerist_get_ap2();
		lawyerist_get_ap3();

		echo '</div>';

	}

	dynamic_sidebar( 'sidebar' );

echo '</div><!--end #sidebar_column"';

?>
