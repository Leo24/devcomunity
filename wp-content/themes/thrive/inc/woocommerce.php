<?php
/**
 * WooCommerce filters, action hooks, and other functions
 * related to WooCommerce plugin.
 *
 * @since 1.1.0 Added bbPress and WooCommerce support.
 * @package thrive\inc\woocommerce
 */

// Change number or products per row to 3.
add_filter('loop_shop_columns', 'loop_columns');

if ( ! function_exists( 'loop_columns' ) ) {

	function loop_columns() {

		return 3; // 3 products per row

	}

}