<?php
/**
 * Filter functions for Job Section of Theme Options
 */

if ( ! function_exists( 'front_redux_toggle_separate_customer_story_header' ) ) {
    function front_redux_toggle_separate_customer_story_header( $enable_separate_customer_story_header ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_customer_story_header'] ) && $front_options['enable_separate_customer_story_header'] ) {
            $enable_separate_customer_story_header = true;
        } else {
            $enable_separate_customer_story_header = false;
        }

        return $enable_separate_customer_story_header;
    }
}

if( ! function_exists( 'front_redux_customer_story_header_static_block' ) ) {
    function front_redux_customer_story_header_static_block( $customer_story_static_block_id ) {
        global $front_options;

        $customer_story = apply_filters( 'front_extensions_enable_customer_story_post_type', true );

        $enable_separate_customer_story_header = isset( $front_options['enable_separate_customer_story_header'] ) && $front_options['enable_separate_customer_story_header'];

        if( $enable_separate_customer_story_header && isset( $front_options['header_customer_story_static_block_id'] ) && $customer_story && is_singular( 'customer_story' ) ) {
            $customer_story_static_block_id = $front_options['header_customer_story_static_block_id'];
        }

        return $customer_story_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_toggle_separate_customer_story_footer' ) ) {
    function front_redux_toggle_separate_customer_story_footer( $enable_separate_customer_story_footer ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_customer_story_footer'] ) && $front_options['enable_separate_customer_story_footer'] ) {
            $enable_separate_customer_story_footer = true;
        } else {
            $enable_separate_customer_story_footer = false;
        }

        return $enable_separate_customer_story_footer;
    }
}

if( ! function_exists( 'front_redux_customer_story_footer_static_block' ) ) {
    function front_redux_customer_story_footer_static_block( $customer_story_static_block_id ) {
        global $front_options;

        $customer_story = apply_filters( 'front_extensions_enable_customer_story_post_type', true );

        $enable_separate_customer_story_footer = isset( $front_options['enable_separate_customer_story_footer'] ) && $front_options['enable_separate_customer_story_footer'];

        if( $enable_separate_customer_story_footer && isset( $front_options['header_customer_story_static_block_id'] ) && $customer_story && is_singular( 'customer_story' ) ) {
            $customer_story_static_block_id = $front_options['footer_customer_story_static_block_id'];
        }

        return $customer_story_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_customer_story_single_bg_img' ) ) {
    function front_redux_customer_story_single_bg_img( $customer_story_single_bg_img ) {
        global $front_options;

        if( isset( $front_options['customer_story_single_bg_img'] ) && isset( $front_options['customer_story_single_bg_img']['url'] ) && !empty( $front_options['customer_story_single_bg_img']['url'] ) ) {
            $customer_story_single_bg_img = $front_options['customer_story_single_bg_img']['url'];
        }

        return $customer_story_single_bg_img;
    }
}

if ( ! function_exists( 'front_redux_customer_story_single_pretitle' ) ) {
    function front_redux_customer_story_single_pretitle( $customer_story_single_pretitle ) {
        global $front_options;

        if ( isset( $front_options['customer_story_single_pretitle'] ) && ( ! empty( $front_options['customer_story_single_pretitle'] ) ) ) {
            $customer_story_single_pretitle = $front_options['customer_story_single_pretitle'];
        }

        return $customer_story_single_pretitle;
    }
}

if ( ! function_exists( 'front_redux_customer_story_single_enable_pretitle' ) ) {
    function front_redux_customer_story_single_enable_pretitle( $customer_story_single_enable_pretitle ) {
        global $front_options;

        if ( isset( $front_options['customer_story_single_enable_pretitle'] ) && $front_options['customer_story_single_enable_pretitle'] ) {
            $customer_story_single_enable_pretitle = true;
        } else {
            $customer_story_single_enable_pretitle = false;
        }

        return $customer_story_single_enable_pretitle;
    }
}