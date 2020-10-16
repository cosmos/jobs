<?php
/**
 * Front WooCommerce Class
 *
 * @package  front
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Front_WooCommerce' ) ) :

    /**
     * Front WooCommerce Integration class
     */
    class Front_WooCommerce {

        /**
         * Setup class.
         *
         * @since 1.0.0
         */
        public function __construct() {
            $this->includes();
            $this->init_hooks();
        }

        /**
         * Includes classes and other files required
         */
        public function includes() {
            require_once get_template_directory() . '/inc/woocommerce/classes/class-front-wc-helper.php';
            require_once get_template_directory() . '/inc/woocommerce/classes/class-front-shortcode-products.php';
            require_once get_template_directory() . '/inc/woocommerce/classes/class-front-categories.php';
        }

        /**
         * Setup class.
         *
         * @since 1.0
         */
        private function init_hooks(){
            add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
            // add_filter( 'front_display_header_args', array( $this, 'header_args' ) );
            add_action( 'admin_init', array( $this, 'allow_customer_uploads' ) );
            add_action( 'init', array( $this, 'allow_customer_uploads' ) );
            add_filter( 'ajax_query_attachments_args',  array( $this, 'filter_get_the_user_attachments' ) );
        }

        public function header_args( $args ) {
            if ( apply_filters( 'front_enable_woocommerce_header_args', true ) && ( is_woocommerce() || is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
                $args = wp_parse_args( array(
                    'enablePostion' => false,
                    'enableTransparent' => false,
                ), $args );
            }

            return $args;
        }

        public static function allow_customer_uploads() {
            if ( ! current_user_can('upload_files') && is_wc_endpoint_url( 'edit-account' ) ) {
                $customer = get_role('customer');
                $customer->add_cap('upload_files');
            }
        }

        public static function filter_get_the_user_attachments( $query ) {
            $current_user = wp_get_current_user();

            if ( ! $current_user ) {
                return $query;
            }

            if( current_user_can('administrator') ) {
                return $query;
            }

            if( current_user_can('customer') ) {
                $current_user_id = $current_user->ID;
                $query['author__in'] = array(
                    $current_user_id
                );
                return $query;
            }
            return $query;
        }
    }

endif;

return new Front_WooCommerce();