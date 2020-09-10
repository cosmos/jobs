<?php
/**
 * Front WeDocs Class
 *
 * @package  front
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Front_WeDocs' ) ) :

    /**
     * Front WooCommerce Integration class
     */
    class Front_WeDocs {

        /**
         * Setup class.
         *
         * @since 1.0.0
         */
        public function __construct() {
            $this->init_hooks();
        }

        /**
         * Init Hooks
         *
         * @since 1.0
         */
        private function init_hooks(){
            // add_filter( 'front_display_header_args', array( $this, 'header_args' ) );
            add_filter( 'body_class', array( $this, 'docs_body_classes' ) );
            add_action( 'wp_print_styles', array( $this, 'dequeue_default_wedoc_styles' ) );
        }

        public function header_args( $args ) {
            if ( apply_filters( 'front_enable_docs_header_args', true ) && ( is_singular( 'docs' ) || front_wedocs_is_docs_home() || front_wedocs_is_docs_search() || front_wedocs_is_docs_taxonomy() ) ) {
                $args = wp_parse_args( array(
                    'enablePostion' => false,
                ), $args );
            }

            return $args;
        }

        public function docs_body_classes( $classes ) {

            if( is_post_type_archive( 'docs' ) || is_singular( 'docs' ) || front_wedocs_is_docs_home() || front_wedocs_is_docs_search() || front_wedocs_is_docs_taxonomy() ) {
                $classes[] = 'front-docs-pages';
            }

            return $classes;
        }

        public function dequeue_default_wedoc_styles() {
            wp_dequeue_style( 'wedocs-styles' );
        }
    }

endif;

return new Front_WeDocs();