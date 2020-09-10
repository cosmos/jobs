<?php
/**
 * Server-side rendering of the `fgb/products-block-content` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/products-block-content` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */


if ( ! function_exists( 'frontgb_register_products_block' ) ) {
    /**
     * Registers the `fgb/products-block-content` block on server.
     */
    function frontgb_register_products_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/products-block-content',
            array(
                'attributes' => array (
                    'className' => array(
                        'type' => 'string',
                    ),
                    'posts' => array (
                        'type' => 'array',
                        'items' => array(
                            'type' => 'object'
                        ),
                        'default' =>[],
                    ),
                    'shortcode_tag' => array (
                        'type' => 'string',
                        'default' => 'recent_products',
                    ),
                    'shortcode_atts'=> array (
                        'type'      => 'object',
                        'default'   => array(
                            'limit'         => 4,
                            'columns'       => 4,
                            'orderby'       => 'date',
                            'order'         => 'DESC',
                        ),
                    ),
                ),
                'render_callback' => 'frontgb_products_blocks',
            )
        );
    }
    add_action( 'init', 'frontgb_register_products_block' );
}

if ( ! function_exists( 'frontgb_products_blocks' ) ) {
    function frontgb_products_blocks( $args ) {

        if ( ! class_exists( 'Front' ) ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'Front is not activated', FRONTGB_I18N ) . '</p>';
        } elseif ( function_exists( 'front_is_woocommerce_activated' ) && ! front_is_woocommerce_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'WooCommerce is not activated', FRONTGB_I18N ) . '</p>';
        }

        $defaults = apply_filters( 'frontgb_products_blocks_default_args', array(
            'shortcode_tag'     => 'recent_products',
            'shortcode_atts'        => array(
                'columns'               => '4',
                'limit'                 => '4',
            ),
        ) );


        $args = wp_parse_args( $args, $defaults );

        extract( $args );
        
        ob_start();
        echo front_do_shortcode( 'products' , $shortcode_atts ); 
        return ob_get_clean();

    }
}
