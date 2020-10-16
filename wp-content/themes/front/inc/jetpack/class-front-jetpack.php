<?php
/**
 * Front JetPack Class
 *
 * @package  front
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Front_JetPack' ) ) :

    /**
     * Front WooCommerce Integration class
     */
    class Front_JetPack {

        /**
         * Setup class.
         *
         * @since 1.0.0
         */
        public function __construct() {
            $this->init_hooks();
        }

        /**
         * Setup class.
         *
         * @since 1.0
         */
        private function init_hooks(){
            add_action( 'init', array( $this, 'jetpack_setup' ) );
            add_filter( 'front_localize_script_data', array( $this, 'jetpack_localize_options' ) );
            // add_filter( 'front_display_header_args', array( $this, 'header_args' ) );
        }

        /**
         * Setup JetPack
         */
        public function jetpack_setup() {
            add_post_type_support( 'jetpack-portfolio', array( 'custom-fields' ) );
        }

        /**
         * Append to JS front_options
         */
        public function jetpack_localize_options( $options ) {
            if ( front_is_jetpack_portfolio() ) {
                $options['jetpack_porfolio'] = '1';
            }

            return $options;
        }

        public function header_args( $args ) {
            if ( apply_filters( 'front_enable_portfolio_header_args', true ) && front_is_jetpack_portfolio() ) {
                $args = wp_parse_args( array(
                    'enablePostion' => true,
                    'position' => 'abs-top',
                    'positionScreen' => 'md',
                    'enableShowHide' => true,
                    'showHideBreakpoint' => 'md',
                ), $args );
            }
            return $args;
        }
    }


endif;

return new Front_JetPack();