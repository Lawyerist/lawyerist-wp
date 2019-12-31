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

// Default greeting and logout link removed.

if ( is_plugin_active( 'scorecard-helper/scorecard-helper.php' ) ) {

	// Outputes the Scorecard Report Card widget.
	echo '<div id="insider-dashboard">';

	  $logout_link = '<a href="'. esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ) . '">Log Out</a>';

	  $current_user = wp_get_current_user();
	  echo '<p id="dashboard-title">' . $current_user->user_firstname . ' ' . $current_user->user_lastname . '\'s Small Firm Dashboard <span class="logout-link">' . $logout_link . '</span?></p>';

	  echo scorecard_results_graph();

	echo '</div>';

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
