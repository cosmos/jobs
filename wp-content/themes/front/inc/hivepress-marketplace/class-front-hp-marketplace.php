<?php
/**
 * Front HivePress Marketplace
 *
 * @package Front/HivePress/Marketplace
 * @since 1.1.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use HivePress\Helpers as hp;

if ( ! class_exists( 'Front_HP_Marketplace' ) ):

    /**
     * Front HivePress Integration for Marketplace
     */
    class Front_HP_Marketplace {

        /**
         * Setup class
         */
        public function __construct() {
            $this->init_hooks();
        }

        /**
         * Initialize Hooks
         */
        private function init_hooks() {
            add_filter( 'body_class', array( $this, 'body_classes' ) );
            add_filter( 'hivepress/v1/styles', array( $this, 'set_styles' ) );
            add_filter( 'hivepress/v1/templates/listing_view_page/blocks', array( $this, 'build_listing_view_page' ) );
            //add_filter( 'hivepress/v1/templates/listing_view_block/blocks', array( $this, 'build_listing_view_block' ) );
            //add_filter( 'hivepress/v1/templates/listings_view_page', array( $this, 'build_listings_view_page' ) );
            add_filter( 'hivepress/v1/templates/listings_view_page/blocks', array( $this, 'build_listings_view_page' ) );
        }

        public function body_classes( $classes ) {

            $hp_route = hivepress()->router->get_current_route_name();
            if( ! empty( $hp_route ) ) {
                if( in_array( $hp_route, array( 'user_login_page', 'listings_edit_page', 'listing_edit_page', 'user_edit_settings_page' ) ) ) {
                    $classes[] = 'hp-listing-dashboard';
                    if( $hp_route == 'user_login_page' ) {
                        $classes[] = 'hp-listing-dashboard--login';
                    } elseif( $hp_route == 'listings_edit_page' ) {
                        $classes[] = 'hp-listing-dashboard--listings';
                    } elseif( $hp_route == 'listing_edit_page' ) {
                        $classes[] = 'hp-listing-dashboard--listing__edit';
                    } elseif( $hp_route == 'user_edit_settings_page' ) {
                        $classes[] = 'hp-listing-dashboard--settings';
                    }
                } elseif( in_array( $hp_route, array( 'listing_submit_page', 'listing_submit_category_page', 'listing_submit_details_page', 'listing_submit_complete_page' ) ) ) {
                    $classes[] = 'hp-listing-submit-page';
                    if( $hp_route == 'listing_submit_category_page' ) {
                        $classes[] = 'hp-listing-submit-page--category';
                    } elseif( $hp_route == 'listing_submit_details_page' ) {
                        $classes[] = 'hp-listing-submit-page--details';
                    } elseif( $hp_route == 'listing_submit_complete_page' ) {
                        $classes[] = 'hp-listing-submit-page--complete';
                    }
                } elseif( in_array( $hp_route, array( 'listing_renew_page', 'listing_renew_complete_page' ) ) ) {
                    $classes[] = 'hp-listing-renew-page';
                }
            }

            return $classes;
        }

        public function set_styles( $styles ) {
            $unset_styles = array(
                'fontawesome', 'fontawesome_solid', 'grid', 'core_frontend'
            );
            foreach( $unset_styles as $unset_style ) {
                if ( isset( $styles[ $unset_style] ) ) {
                    unset( $styles[ $unset_style ] );
                }
            }
            return $styles;
        }

        public function build_listings_view_page( $args ) {
            //echo '<pre>' . print_r( $args, 1 ) . '</pre>';
            //return $args;
            return array(
                'page_container' => array(
                    'type'   => 'page',
                    '_order' => 10,
                    'blocks' => array(
                        'listings_view_page_content' => array(
                            'type' => 'part',
                            'path' => 'listing/archive-listing'
                        ),
                    ),
                ),
            );
        }

        public function build_listing_view_block( $args ) {
            //echo '<pre>' . print_r( $args, 1 ) . '</pre>'; return $args;
            return array(
                'listing_loop' => array(
                    'type' => 'part',
                    'path' => 'listing/view/content-listing'
                ),
            );
            return $args;
        }

        public function build_listing_view_page( $args ) {
            // echo '<pre>' . print_r( $args, 1 ) . '</pre>';
            return array(
                'page_container' => array(
                    'type'   => 'page',
                    '_order' => 10,
                    'blocks' => array(
                        'listing_view_page_content' => array(
                            'type' => 'part',
                            'path' => 'listing/view/content-single-listing'
                        )
                    )
                ),
            );
        }
    }

endif;

return new Front_HP_Marketplace();
