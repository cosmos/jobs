<?php
/**
 * Server-side rendering of the `fgb/shortcode` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/shortcode` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_shortcode_block' ) ) {
    function frontgb_render_shortcode_block( $attributes ) {
        if( ! empty( $attributes['text'] ) && ! empty( $attributes['className'] ) ) {
            return '<div class="' . esc_attr( $attributes["className"] ) . '">' . do_shortcode( $attributes['text'] ) . '</div>';
        } else {
            return ! empty( $attributes['text'] ) ? do_shortcode( $attributes['text'] ) : '';
        }
    }
}

if ( ! function_exists( 'frontgb_register_shortcode_block' ) ) {
    /**
     * Registers the `fgb/shortcode` block on server.
     */
    function frontgb_register_shortcode_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/shortcode',
            array(
                'attributes'      => array(
                    'label' => array(
                        'type'   => 'string'
                    ),
                    'placeholder' => array(
                        'type'   => 'string'
                    ),
                    'text' => array(
                        'type'   => 'string'
                    ),
                    'className'     => array(
                        'type'      => 'string',
                    ),
                ),
                'render_callback' => 'frontgb_render_shortcode_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_shortcode_block' );
}