<?php

/**
 * WooCommerce
 */
if( function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated() ) {

    function front_custom_woocommerce_catalog_orderby( $sortby ) {
        unset($sortby);
        $sortby['name_asc'] = esc_html__( 'A-to-Z', 'front-extensions' );
        $sortby['name_desc'] = esc_html__( 'Z-to-A', 'front-extensions' );
        return $sortby;
    }

    /**
     * Add custom sorting options (asc/desc)
     */
    function front_woocommerce_catalog_ordering() {
        add_filter( 'woocommerce_get_catalog_ordering_args', 'front_custom_woocommerce_get_catalog_ordering_args' );
        function front_custom_woocommerce_get_catalog_ordering_args( $args ) {
            $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
            if ( 'name_asc' == $orderby_value ) {
                $args['orderby'] = 'name';
                $args['order'] = 'ASC';
            }
            if ( 'name_desc' == $orderby_value ) {
                $args['orderby'] = 'name';
                $args['order'] = 'DESC';
            }
            return $args;
        }
        add_filter( 'woocommerce_default_catalog_orderby_options', 'front_custom_woocommerce_catalog_orderby' );
        add_filter( 'woocommerce_catalog_orderby', 'front_custom_woocommerce_catalog_orderby' );
        woocommerce_catalog_ordering();
        remove_filter( 'woocommerce_get_catalog_ordering_args', 'front_custom_woocommerce_get_catalog_ordering_args' );
        remove_filter( 'woocommerce_default_catalog_orderby_options', 'front_custom_woocommerce_catalog_orderby' );
        remove_filter( 'woocommerce_catalog_orderby', 'front_custom_woocommerce_catalog_orderby' );
    }
}
