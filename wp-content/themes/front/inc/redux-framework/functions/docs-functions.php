<?php
/**
 * Filter functions for Job Section of Theme Options
 */

if ( ! function_exists( 'front_redux_toggle_separate_docs_header' ) ) {
    function front_redux_toggle_separate_docs_header( $enable_separate_docs_header ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_docs_header'] ) && $front_options['enable_separate_docs_header'] ) {
            $enable_separate_docs_header = true;
        } else {
            $enable_separate_docs_header = false;
        }

        return $enable_separate_docs_header;
    }
}

if( ! function_exists( 'front_redux_docs_header_static_block' ) ) {
    function front_redux_docs_header_static_block( $docs_static_block_id ) {
        global $front_options;

        $docs = function_exists( 'front_is_wedocs_activated' ) && front_is_wedocs_activated();

        $enable_separate_docs_header = isset( $front_options['enable_separate_docs_header'] ) && $front_options['enable_separate_docs_header'];

        if( $enable_separate_docs_header && isset( $front_options['header_docs_static_block_id'] ) && $docs && ( is_singular( 'docs' ) || front_wedocs_is_docs_home() || front_wedocs_is_docs_search() || front_wedocs_is_docs_taxonomy() ) ) {
            $docs_static_block_id = $front_options['header_docs_static_block_id'];
        }

        return $docs_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_toggle_separate_docs_footer' ) ) {
    function front_redux_toggle_separate_docs_footer( $enable_separate_docs_footer ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_docs_footer'] ) && $front_options['enable_separate_docs_footer'] ) {
            $enable_separate_docs_footer = true;
        } else {
            $enable_separate_docs_footer = false;
        }

        return $enable_separate_docs_footer;
    }
}

if( ! function_exists( 'front_redux_docs_footer_static_block' ) ) {
    function front_redux_docs_footer_static_block( $docs_static_block_id ) {
        global $front_options;

        $docs = function_exists( 'front_is_wedocs_activated' ) && front_is_wedocs_activated();

        $enable_separate_docs_footer = isset( $front_options['enable_separate_docs_footer'] ) && $front_options['enable_separate_docs_footer'];

        if( $enable_separate_docs_footer && isset( $front_options['header_docs_static_block_id'] ) && $docs && ( is_singular( 'docs' ) || front_wedocs_is_docs_home() || front_wedocs_is_docs_search() || front_wedocs_is_docs_taxonomy() ) ) {
            $docs_static_block_id = $front_options['footer_docs_static_block_id'];
        }

        return $docs_static_block_id;
    }
}