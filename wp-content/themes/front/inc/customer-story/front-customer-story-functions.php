<?php
/**
 * Functions used in Customer Story
 */

if ( ! function_exists( 'front_customer_story_header_args' ) ) {
    function front_customer_story_header_args( $args ) {
        if ( apply_filters( 'front_enable_customer_story_header_args', true ) && is_singular( 'customer_story' ) ) {
            $args = wp_parse_args( array(
                'enablePostion' => false,
                'enableTransparent' => false,
            ), $args );
        }

        return $args;
    }
}