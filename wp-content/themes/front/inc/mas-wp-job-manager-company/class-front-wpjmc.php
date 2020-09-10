<?php
/**
 * Front MAS Company for WP Job Manager Class
 *
 * @package  front
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Front_WPJMC' ) ) :

    /**
     * The Front MAS Company for WP Job Manager Integration class
     */
    class Front_WPJMC {

        public function __construct() {
            add_filter( 'register_post_type_company', array( $this, 'modify_register_post_type_company' ) );
            add_filter( 'mas_wpjmc_enqueue_scripts_enable_frontend_css', '__return_false' );
            add_action( 'front_before_header', array( $this, 'remove_header_topbar_icons' ) );
            // add_filter( 'front_display_header_args', array( $this, 'header_args' ) );
        }

        public function modify_register_post_type_company( $args ) {
            $args['template'] = array();
            $args['template_lock'] = false;

            return $args;
        }

        public function remove_header_topbar_icons() {
            if( apply_filters( 'front_enable_company_header_args', true ) && ( is_post_type_archive( 'company' ) || is_page( mas_wpjmc_get_page_id( 'companies' ) ) || is_page( mas_wpjmc_get_page_id( 'company_dashboard' ) ) || is_page( mas_wpjmc_get_page_id( 'submit_company_form' ) ) || mas_wpjmc_is_company_taxonomy() || is_singular( 'company' ) ) ) {
                add_filter( 'front_header_topbar_cart_enable', '__return_false', 9 );
                add_filter( 'front_header_topbar_search_enable', '__return_false', 9 );
            }
        }

        public function header_args( $args ) {
            if( apply_filters( 'front_enable_company_header_args', true ) && ( is_post_type_archive( 'company' ) || is_page( mas_wpjmc_get_page_id( 'companies' ) ) || is_page( mas_wpjmc_get_page_id( 'company_dashboard' ) ) || is_page( mas_wpjmc_get_page_id( 'submit_company_form' ) ) || mas_wpjmc_is_company_taxonomy() || is_singular( 'company' ) ) ) {
                $args = wp_parse_args( array(), $args );
            }

            return $args;
        }
    }

endif;

return new Front_WPJMC();