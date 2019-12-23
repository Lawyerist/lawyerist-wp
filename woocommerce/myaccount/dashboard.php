<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<!-- Default greeting and logout link removed. -->

<?php

if ( is_plugin_active( 'scorecard-helper/scorecard-helper.php' ) ) {

	// Outputes the Scorecard Report Card widget.
	echo '<div id="insider-dashboard">';

	  $logout_link = '<a href="'. esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ) . '">Log Out</a>';

	  $current_user = wp_get_current_user();
	  echo '<p id="dashboard-title">' . $current_user->user_firstname . ' ' . $current_user->user_lastname . '\'s Small Firm Dashboard <span class="logout-link">' . $logout_link . '</span?></p>';

	  echo scorecard_results_graph();

	echo '</div>';

	/* Ready for when we have an actual link to
	$scorecard_results = get_scorecard_results();

	if ( !empty( $scorecard_results ) ) {

		echo '<h2>Scorecard History</h2>';

		echo '<table class="widefat">';
			echo '<thead>';
				echo '<tr>';
					echo '<th>Grade</th>';
					echo '<th>Date</th>';
					echo '<th>Version</th>';
					echo '<th>More</th>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';

				foreach ( $scorecard_results as $scorecard_result ) {

					$scorecard_id				= $scorecard_result[ 'entry_id' ];
					$form_id						= $scorecard_result[ 'form_id' ];
					$scorecard_grade		= $scorecard_result[ 'grade' ];
					$scorecard_score		= $scorecard_result[ 'percentage' ];
					$scorecard_date			= date_format( date_create( $scorecard_result[ 'date' ] ), 'M. j, Y' );
					$scorecard_version	= $scorecard_result[ 'version' ];

					// I don't think this actually works?
					$account_page				= woocommerce_my_account();

					echo '<tr>';
						echo '<td><strong>' . $scorecard_grade . '</strong> (' . round( $scorecard_score ) . '%)</td>';
						echo '<td>' . $scorecard_date . '</td>';
						echo '<td>' . $scorecard_version . '</td>';
						echo '<td><a href="' . $account_page. '&scorecard_id=' . $scorecard_id . '">See Scorecard</a></td>';
					echo '</tr>';

				}

			echo '<tbody>';
		echo '</table>';

	}
	*/


}


	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
