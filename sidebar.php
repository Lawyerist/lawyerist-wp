<?php

echo '<div id="sidebar_column">';

	if ( !has_tag('no-ads') ) {

		echo '<div id="sidebar_ads">';

		insert_lawyerist_ap2();
		insert_lawyerist_ap3();

		echo '</div>';

	}

	dynamic_sidebar('sidebar');

echo '</div>';

?>
