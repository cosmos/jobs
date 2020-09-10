<?php
/**
 * Server-side rendering of the `fgb/nav-menu` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/nav-menu` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_nav_menu_block' ) ) {
    function frontgb_render_nav_menu_block( $attributes ) {
        ob_start();

        if( ! empty( $attributes['navMenu'] ) ) {
            wp_nav_menu( array(
                'menu'              => $attributes['navMenu'],
                'menu_class'        => ! empty( $attributes['className'] ) ? 'menu ' . $attributes['className'] : 'menu',
                'container'         => false,
            ) );
        }

        return ob_get_clean();
    }
}

if ( ! function_exists( 'frontgb_register_nav_menu_block' ) ) {
    /**
     * Registers the `fgb/nav-menu` block on server.
     */
    function frontgb_register_nav_menu_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/nav-menu',
            array(
                'attributes' => array(
                    'className' => array(
                        'type' => 'string',
                    ),
                    'navMenu' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                ),
                'render_callback' => 'frontgb_render_nav_menu_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_nav_menu_block' );
}

/**
 * Add REST API support to `nav_menu` taxonomy.
 */
add_filter( 'register_taxonomy_args', 'frontgb_nav_menu_taxonomy_args', 10, 3 );

function frontgb_nav_menu_taxonomy_args( $args, $taxonomy_name, $object_type ) {
    if ( 'nav_menu' === $taxonomy_name ) {
        $args['show_in_rest'] = true;
    }

    return $args;
}