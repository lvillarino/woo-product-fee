<?php

/**
 * WooCommerce Product Fee 
 *
 * Allows you to add a fee at checkout based on a product that are in the cart.
 *
 * @class 	Woo_Product_Fee
 * @author 	Luis Villarino
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Woo_Product_Fee {

    /**
     * Woo_Product_Fee Constructor
     */
    public function __construct() {
        if (is_admin()) {
            // Admin Settings
            require_once 'class-woo-product-fee-admin.php';
        }

        // Text domain
        add_action('plugins_loaded', array($this, 'text_domain'));

        // Hook-in for fee to be added
        add_action('woocommerce_cart_calculate_fees', array($this, 'apply_fee'), 15);
    }

    /**
     * Add the fee to the cart.
     *
     * @param object $cart WC Cart object.
     * @return null
     */
    public function apply_fee($cart) {
        if (is_admin() && !defined('DOING_AJAX') ) {
            return;
        }
        
        if ('yes' !== get_option('woo_product_fee_enable')){
            return;
        }

        if ($this->verify_products(get_option('woo_product_fee_pid'), $cart)) {
            $fee = $this->calculate_fee(get_option('woo_product_fee_percent'), $cart);
            if (0 < $fee) {
                $label = (empty(get_option('woo_product_fee_label'))) ?
                        __('Product Fee', 'woo-product-fee') : get_option('woo_product_fee_label');
                $cart->add_fee($label, $fee, true, '');
            }
        }
    }

    /**
     * Check if a product is in the cart
     *
     * @param int $product_id
     * @param object $cart WC Cart object.
     * 
     * @return bool
     */
    public function verify_products($product_id, $cart) {
        $product_id = (int) $product_id;

        if (0 == $product_id) {
            return false;
        }

        foreach ($cart->get_cart() as $cart_item => $item) {
            if ($product_id == $item['product_id']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Calculate fee
     *
     * @param type $percent
     * @param object $cart WC Cart object.
     * 
     * @return bool
     */
    public function calculate_fee($percent, $cart) {
        if (!is_numeric($percent)){
            return 0;
        }
        
        $percentage = $percent / 100;
        
        return $cart->cart_contents_total * $percentage;
    }

    /**
     * Load Text Domain
     */
    public function text_domain() {
        load_plugin_textdomain( 'woo-product-fee', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

}
