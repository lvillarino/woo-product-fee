<?php

/**
 * WooCommerce Product Fee 
 *
 * Allows you to add a fee at checkout based on a product that are in the cart.
 *
 * @author 	Luis Villarino
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'woo_product_fee_enable' );
delete_option( 'woo_product_fee_label' );
delete_option( 'woo_product_fee_percent' );
delete_option( 'woo_product_fee_pid' );
