<?php
/**
 * Filter functions for 404 Page of Theme Options
 */

if ( ! function_exists( 'front_redux_toggle_separate_404_page_header' ) ) {
    function front_redux_toggle_separate_404_page_header( $enable_separate_404_page_header ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_404_page_header'] ) && $front_options['enable_separate_404_page_header'] ) {
            $enable_separate_404_page_header = true;
        } else {
            $enable_separate_404_page_header = false;
        }

        return $enable_separate_404_page_header;
    }
}

if( ! function_exists( 'front_redux_404_page_header_static_block' ) ) {
    function front_redux_404_page_header_static_block( $static_block_id ) {
        global $front_options;

        $enable_separate_404_page_header = isset( $front_options['enable_separate_404_page_header'] ) && $front_options['enable_separate_404_page_header'];

        if( $enable_separate_404_page_header && isset( $front_options['header_404_page_static_block_id'] ) && is_404() ) {
            $static_block_id = $front_options['header_404_page_static_block_id'];
        }

        return $static_block_id;
    }
}

if ( ! function_exists( 'redux_apply_404_page_args' ) ) {
    function redux_apply_404_page_args( $args ) {
        global $front_options;

        if( isset( $front_options['404_page_page_title'] ) ) {
            $args['page_title'] = $front_options['404_page_page_title'];
        }

        if ( isset( $front_options['404_page_sub_titles'] ) ) {
            if ( is_array( $front_options['404_page_sub_titles'] ) ) {
                $args['sub_titles'] = $front_options['404_page_sub_titles'];
            } else {
                $args['sub_titles'] = array();
            }
        }

        if( isset( $front_options['404_page_contact_text'] ) ) {
            $args['contact_text'] = $front_options['404_page_contact_text'];
        }

        if( isset( $front_options['404_page_contact_link'] ) ) {
            $args['contact_link'] = $front_options['404_page_contact_link'];
        }

        return $args;
    }
}

if ( ! function_exists( 'redux_apply_404_bg_img' ) ) {
    function redux_apply_404_bg_img( $page_404_bg_img ) {
        global $front_options;

        if( isset( $front_options['page_404_bg_img'] ) && isset( $front_options['page_404_bg_img']['url'] ) && !empty( $front_options['page_404_bg_img']['url'] ) ) {
            $page_404_bg_img = $front_options['page_404_bg_img']['url'];
        }

        return $page_404_bg_img;
    }
}