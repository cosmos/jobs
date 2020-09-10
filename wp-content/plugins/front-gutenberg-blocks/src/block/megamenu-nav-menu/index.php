<?php
/**
 * Server-side rendering of the `fgb/megamenu-nav-menu` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/megamenu-nav-menu` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_megamenu_nav_menu_block' ) ) {
    function frontgb_render_megamenu_nav_menu_block( $attributes ) {
        ob_start();
        if( function_exists( 'frontgb_megamenu_nav_menu' ) ) {
            frontgb_megamenu_nav_menu( $attributes );
        }
        return ob_get_clean();
    }
}

if ( ! function_exists( 'frontgb_megamenu_nav_menu' ) ) {
    function frontgb_megamenu_nav_menu( $args = array() ) {
        $defaults = array(
            'className'                 => '',
            'megaMenuID'                => 0,
            'megaMenuSlug'              => '',
            'enableMarginBottom'        => true
        );

        $args = wp_parse_args( $args, $defaults );
        extract( $args );

        $nav_menu_args = array(
            'theme_location'     => 'footer_primary_menu',
            'depth'              => 0,
            'container'          => false,
            'menu_class'         => 'u-header__sub-menu-nav-group header-nav-menu-block ' . ( $enableMarginBottom == true ? 'mb-3' : 'mb-0' ) . ( ! empty( $className ) ? ' ' . $className : '' ),
            'fallback_cb'        => 'Front_Walker_Bootstrap_Nav_Menu::fallback',
            'walker'             => new Front_Walker_Bootstrap_Nav_Menu(),
        );

        if( $megaMenuID > 0 ) {
            $nav_menu_args['menu'] = $megaMenuID;
        } elseif( ! empty( $megaMenuSlug ) ) {
            $nav_menu_args['menu'] = $megaMenuSlug;
        }

        wp_nav_menu( $nav_menu_args );
    }
}

if ( ! function_exists( 'frontgb_register_megamenu_nav_menu_block' ) ) {
    /**
     * Registers the `fgb/megamenu-nav-menu` block on server.
     */
    function frontgb_register_megamenu_nav_menu_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/megamenu-nav-menu',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                    ),
                    'megaMenuID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'megaMenuSlug' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'enableMarginBottom' => array(
                        'type' => 'boolean',
                        'default' => true
                    ),
                ),
                'render_callback' => 'frontgb_render_megamenu_nav_menu_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_megamenu_nav_menu_block' );
}