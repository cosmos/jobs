<?php

if ( ! function_exists( 'front_redux_change_front_blog_view' ) ) {
    function front_redux_change_front_blog_view( $front_blog_view ) {

        global $front_options;

        if ( isset( $front_options['front_blog_view'] ) ) {
            $front_blog_view = $front_options['front_blog_view'];
        }

        return $front_blog_view;
    }
}

if ( ! function_exists( 'front_redux_change_front_blog_layout' ) ) {
    function front_redux_change_front_blog_layout( $front_blog_layout ) {

        global $front_options;

        if ( isset( $front_options['front_blog_layout'] ) ) {
            $front_blog_layout = $front_options['front_blog_layout'];
        }

        return $front_blog_layout;
    }
}

if ( ! function_exists( 'front_redux_toggle_single_post_style' ) ) {
    function front_redux_toggle_single_post_style( $style ) {

        global $front_options;

        if ( isset( $front_options['single_post_style'] ) ) {
            $style = $front_options['single_post_style'];
        }

        return $style;
    }
}

if( ! function_exists( 'front_redux_footer_blog_before_static_content_id' ) ) {
    function front_redux_footer_blog_before_static_content_id( $footer_before_static_block_id ) {
        global $front_options;

        if( isset( $front_options['footer_before_static_block_id'] ) && is_singular( 'post' ) ) {
            $footer_before_static_block_id = $front_options['footer_before_static_block_id'];
        }

        return $footer_before_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_toggle_single_post_tags' ) ):
    function front_redux_toggle_single_post_tags( $enabled ) {
        global $front_options;

        if ( isset( $front_options['enable_classic_single_post_tags'] ) ) {
            if ( $front_options['enable_classic_single_post_tags'] == true ) {
                $enabled = true;
            } else {
                $enabled = false;
            }
        }

        return $enabled;
    }
endif;

if ( ! function_exists( 'front_redux_toggle_single_post_share' ) ):
    function front_redux_toggle_single_post_share( $enabled ) {
        global $front_options;

        if ( isset( $front_options['enable_classic_single_post_share'] ) ) {
            if ( $front_options['enable_classic_single_post_share'] == true ) {
                $enabled = true;
            } else {
                $enabled = false;
            }
        }

        return $enabled;
    }
endif;

if ( ! function_exists( 'front_redux_toggle_single_post_author_info' ) ):
    function front_redux_toggle_single_post_author_info( $enabled ) {
        global $front_options;

        if ( isset( $front_options['enable_classic_single_post_author_info'] ) ) {
            if ( $front_options['enable_classic_single_post_author_info'] == true ) {
                $enabled = true;
            } else {
                $enabled = false;
            }
        }

        return $enabled;
    }
endif;

if ( ! function_exists( 'front_redux_toggle_single_post_navigation' ) ):
    function front_redux_toggle_single_post_navigation( $enabled ) {
        global $front_options;

        if ( isset( $front_options['enable_classic_single_post_navigation'] ) ) {
            if ( $front_options['enable_classic_single_post_navigation'] == true ) {
                $enabled = true;
            } else {
                $enabled = false;
            }
        }

        return $enabled;
    }
endif;

if ( ! function_exists( 'front_redux_toggle_single_post_related_posts' ) ):
    function front_redux_toggle_single_post_related_posts( $enabled ) {
        global $front_options;

        if ( isset( $front_options['enable_classic_single_post_related_posts'] ) ) {
            if ( $front_options['enable_classic_single_post_related_posts'] == true ) {
                $enabled = true;
            } else {
                $enabled = false;
            }
        }

        return $enabled;
    }
endif;

if ( ! function_exists( 'front_redux_toggle_separate_single_post_header' ) ) {
    function front_redux_toggle_separate_single_post_header( $enable_separate_single_post_header ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_single_post_header'] ) && $front_options['enable_separate_single_post_header'] ) {
            $enable_separate_single_post_header = true;
        } else {
            $enable_separate_single_post_header = false;
        }

        return $enable_separate_single_post_header;
    }
}

if( ! function_exists( 'front_redux_single_post_header_static_block' ) ) {
    function front_redux_single_post_header_static_block( $single_post_static_block_id ) {
        global $front_options;

        $enable_separate_single_post_header = isset( $front_options['enable_separate_single_post_header'] ) && $front_options['enable_separate_single_post_header'];

        if( $enable_separate_single_post_header && isset( $front_options['header_single_post_static_block_id'] ) && is_single() ) {
            $single_post_static_block_id = $front_options['header_single_post_static_block_id'];
        }

        return $single_post_static_block_id;
    }
}