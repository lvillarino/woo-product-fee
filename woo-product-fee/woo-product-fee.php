<?php
/**
 * Plugin Name: WooCommerce Product Fee 
 * Description: WooCommerce extension that increases cart total by X% if a certain product is in the cart.
 * Version: 0.0.1
 * Author: Luis Villarino
 *
 * Text Domain: woo-product-fee
 *
 * Requires at least: 4.9
 * Tested up to: 4.9
 * WC tested up to: 3.2
 * WC requires at least: 3.0
 *
 * Copyright: (c) 2017 Luis Villarino
 * License: GPL v3 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-3.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'plugins_loaded', 'woo_product_fee_load_plugin' );
function woo_product_fee_load_plugin() {
    if ( ! class_exists( "Woo_Product_Fee" ) && class_exists( 'WooCommerce' ) ) {
        require_once( 'classes/class-woo-product-fee.php' );
        new Woo_Product_Fee;
    }
}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'woo_product_fee_action_links' );
function woo_product_fee_action_links( $links ) {
	$links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/admin.php?page=wc-settings&tab=products&section=woo_product_fee' ) ) . '">' 
            . __( 'Settings', 'woo-product-fee' ) 
            . '</a>'
	), $links );
	return $links;
}

