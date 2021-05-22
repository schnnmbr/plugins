<?php

namespace WooViews;

/* This was previously the class Toolset_WooCommerce_Views from ../views-woocommerce.php. */
class Bootstrap {
	/**
	 * Init
	 */
	public function init() {
		global $Class_WooCommerce_Views, $WCViews_shortcodes_gui;

		// Instantiate new plugin object
		if ( ! isset( $Class_WooCommerce_Views ) ) {
			$Class_WooCommerce_Views = new \Class_WooCommerce_Views();
		}

		// Alias Functions compatible for [wpv-if].
		require WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/inc/wcviews-alias-functions.php';

		// Offer to recalculate prices on plugin activation:
		// This is as simple as to add an admin notice if the woocommerce_last_run_update option is missing
		// or empty, no need to run this here...
		register_activation_hook( WC_VIEWS_FILE, array( $Class_WooCommerce_Views, 'maybe_start_processing_products_fields' ) );

		// Reset custom fields updating when deactivated.
		register_deactivation_hook( WC_VIEWS_FILE, array( $Class_WooCommerce_Views, 'wcviews_request_to_reset_field_option' ) );

		// Clear Functions inside conditional evaluations when deactivated.
		register_deactivation_hook( WC_VIEWS_FILE, array( $Class_WooCommerce_Views, 'wcviews_clear_all_func_conditional_eval' ) );

		// Shortcodes GUI.
		require WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/inc/wcviews-shortcodes-gui.php';
		$WCViews_shortcodes_gui = new \WCViews_shortcodes_gui();
		$WCViews_shortcodes_gui->initialize();

		// Constants for messages.
		require WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/inc/wcviews-messaging-constants.php';

		// Tooltip messages.
		require WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/inc/wcviews-admin-messages.php';

		// Core Compatibility.
		require WOOCOMMERCE_VIEWS_PLUGIN_PATH . '/inc/wcviews-core-compatibility.php';
	}
}
