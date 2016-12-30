<?php

echo '<div id="sidebar_column">';

	if ( !has_tag('no-ads') ) {

		echo '<div id="sidebar_ads">';

		lawyerist_get_ap2();
		lawyerist_get_ap3();

		echo '</div>';

	}

	dynamic_sidebar('sidebar');

echo '</div>';

?>
