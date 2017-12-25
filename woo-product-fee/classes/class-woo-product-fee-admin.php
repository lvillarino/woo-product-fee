<?php

/**
 * WooCommerce Product Fee 
 *
 * Admin Settings
 *
 * @class 	Woo_Product_Fee_Admin
 * @author 	Luis Villarino
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Woo_Product_Fee_Admin {

    /**
     * Woo_Product_Fee_Admin Constructor
     */
    public function __construct() {
        add_action('woocommerce_get_sections_products', array($this, 'add_product_fee_section'), 10);
        add_action('woocommerce_get_settings_products', array($this, 'product_fee_settings_output'), 10, 2);
    }

    public function add_product_fee_section($sections) {
        $sections['woo_product_fee'] = __('Product Fee', 'woo-product-fee');
        return $sections;
    }

    public function product_fee_settings_output($settings, $current_section) {
        if ('woo_product_fee' == $current_section) {
            $settings = $this->settings_fields();
        }
        return $settings;
    }

    public function settings_fields() {
        $settings = array(
            array(
                'title' => __('Product Fee', 'woo-product-fee'),
                'type' => 'title',
                'desc' => __('WooCommerce extension that increases cart total by X% if a certain product is in the cart.', 'woo-product-fee'),
                'id' => 'woo_product_fee_options',
            ),
            array(
                'title' => __('Enable: ', 'woo-product-fee'),
                'id' => 'woo_product_fee_enable',
                'type' => 'checkbox',
            ),
            array(
                'title' => __('Cart Label: ', 'woo-product-fee'),
                'desc' => __('Default: Product Fee', 'woo-product-fee'),
                'default' => __('Product Fee', 'woo-product-fee'),
                'id' => 'woo_product_fee_label',
                'type' => 'text',
            ),
            array(
                'title' => __('Percent (%): ', 'woo-product-fee'),
                'desc' => __('Ex: 10', 'woo-product-fee'),
                'id' => 'woo_product_fee_percent',
                'type' => 'text',
            ),
            array(
                'title' => __('Product Id: ', 'woo-product-fee'),
                'desc' => __('<br>Ex: 136, <a href="https://docs.woocommerce.com/document/managing-products/#section-22" target="_blank">How To Easily Find Your Product ID in WooCommerce?</a>', 'woo-product-fee'),
                'id' => 'woo_product_fee_pid', 
                'type' => 'text',
                
            ),
            array('type' => 'sectionend', 'id' => 'woo_product_fee_options'),
        );

        return $settings;
    }

}

return new Woo_Product_Fee_Admin();
