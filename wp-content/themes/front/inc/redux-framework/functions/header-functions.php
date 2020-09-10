<?php
/**
 * Filter functions for Header of Theme Options
 */

if ( ! function_exists( 'front_redux_apply_header_args' ) ) {
    function front_redux_apply_header_args( $args ) {

        global $front_options;

        if ( ! empty( $front_options['header_menu_style'] ) ) {
            $args['menuStyle'] = $front_options['header_menu_style'];

            if ( $front_options['header_menu_style'] == 'full-screen' && ! empty( $front_options['header_full_screen_nav_style'] ) ) {
                $args['fullScreenNavStyle'] = $front_options['header_full_screen_nav_style'];
            }
        }

        if ( isset( $front_options['header_is_container_fluid'] ) ) {
            $args['isContainerFluid'] = $front_options['header_is_container_fluid'];
        }

        if ( isset( $front_options['header_enable_postion'] ) ) {
            $args['enablePostion'] = $front_options['header_enable_postion'];

            if ( ! empty( $front_options['header_position'] ) ) {
                $args['position'] = $front_options['header_position'];
            }

            if ( ! empty( $front_options['header_position_screen'] ) ) {
                $args['positionScreen'] = $front_options['header_position_screen'];
            }
        }

        if ( isset( $front_options['header_enable_sticky'] ) ) {
            $args['enableSticky'] = $front_options['header_enable_sticky'];

            if ( ! empty( $front_options['header_sticky_position'] ) ) {
                $args['stickyPosition'] = $front_options['header_sticky_position'];
            }

            if ( ! empty( $front_options['header_sticky_breakpoint'] ) ) {
                $args['stickyBreakpoint'] = $front_options['header_sticky_breakpoint'];
            }

            if ( ! empty( $front_options['header_sticky_scroll_behavior'] ) ) {
                $args['stickyScrollBehavior'] = $front_options['header_sticky_scroll_behavior'];
            }

            if ( isset( $front_options['header_enable_toggle_section'] ) ) {
                $args['enableToggleSection'] = $front_options['header_enable_toggle_section'];
            }
        }

        if ( isset( $front_options['header_enable_show_hide'] ) ) {
            $args['enableShowHide'] = $front_options['header_enable_show_hide'];

            if ( ! empty( $front_options['header_show_hide_breakpoint'] ) ) {
                $args['showHideBreakpoint'] = $front_options['header_show_hide_breakpoint'];
            }

            if ( ! empty( $front_options['header_show_hide_scroll_behavior'] ) ) {
                $args['showHideScrollBehavior'] = $front_options['header_show_hide_scroll_behavior'];
            }
        }

        if ( isset( $front_options['header_enable_white_nav_links'] ) ) {
            $args['enableWhiteNavLinks'] = $front_options['header_enable_white_nav_links'];

            if ( ! empty( $front_options['header_white_nav_links_breakpoint'] ) ) {
                $args['whiteNavLinksBreakpoint'] = $front_options['header_white_nav_links_breakpoint'];
            }
        }

        if ( isset( $front_options['header_enable_transparent'] ) ) {
            $args['enableTransparent'] = $front_options['header_enable_transparent'];

            if ( ! empty( $front_options['header_transparent_breakpoint'] ) ) {
                $args['transparentBreakpoint'] = $front_options['header_transparent_breakpoint'];
            }

            if ( isset( $front_options['header_enable_border'] ) ) {
                $args['enableBorder'] = $front_options['header_enable_border'];
            }
        }

        if ( isset( $front_options['header_enable_fix_effect'] ) ) {
            $args['enableFixEffect'] = $front_options['header_enable_fix_effect'];
        }

        if ( ! empty( $front_options['header_background'] ) ) {
            $args['background'] = $front_options['header_background'];
        }

        if ( isset( $front_options['header_enable_topbar'] ) ) {
            $args['enableTopBar'] = $front_options['header_enable_topbar'];

            if ( isset( $front_options['header_enable_topbar_left'] ) ) {
                $args['enableTopBarLeft'] = $front_options['header_enable_topbar_left'];
            }

            if ( isset( $front_options['header_enable_topbar_right'] ) ) {
                $args['enableTopBarRight'] = $front_options['header_enable_topbar_right'];
            }
        }

        if ( isset( $front_options['header_enable_logo_white'] ) ) {
            $args['enableLogoWhite'] = $front_options['header_enable_logo_white'];
        }

        if ( ! empty( $front_options['header_logo_align'] ) ) {
            $args['logoAlign'] = $front_options['header_logo_align'];

            if ( $front_options['header_logo_align'] == 'center' && ! empty( $front_options['header_logo_align_breakpoint'] ) ) {
                $args['logoAlignBreakpoint'] = $front_options['header_logo_align_breakpoint'];
            }
        }

        if ( ! empty( $front_options['header_logo_scroll_image']['url'] ) ) {
            $args['logoScrollImageUrl'] = $front_options['header_logo_scroll_image']['url'];
        }

        if ( ! empty( $front_options['header_navbar_responsive_type'] ) ) {
            $args['navbarResponsiveType'] = $front_options['header_navbar_responsive_type'];

            if ( $front_options['header_navbar_responsive_type'] == 'collapse' && ! empty( $front_options['header_navbar_collapse_breakpoint'] ) ) {
                $args['navbarCollapseBreakpoint'] = $front_options['header_navbar_collapse_breakpoint'];
            }
        }

        if ( ! empty( $front_options['header_navbar_align'] ) ) {
            $args['navbarAlign'] = $front_options['header_navbar_align'];
        }

        if ( ! empty( $front_options['header_navbar_dropdown_trigger'] ) ) {
            $args['navbarDropdownTrigger'] = $front_options['header_navbar_dropdown_trigger'];
        }

        if ( isset( $front_options['header_navbar_scroll_nav'] ) ) {
            $args['navbarScrollNav'] = $front_options['header_navbar_scroll_nav'];
        }

        if ( ! empty( $front_options['header_menu_style'] ) && ( $front_options['header_menu_style'] == 'off-screen' || ( $front_options['header_menu_style'] == 'navbar' && $front_options['header_navbar_align'] == 'center' ) ) ) {
            if ( isset( $front_options['header_button_enable'] ) ) {
                $args['enableButton'] = $front_options['header_button_enable'];
            }

            if ( ! empty( $front_options['header_button_text'] ) ) {
                $args['buttonText'] = $front_options['header_button_text'];
            }

            if ( ! empty( $front_options['header_button_url'] ) ) {
                $args['buttonUrl'] = $front_options['header_button_url'];
            }

            if ( ! empty( $front_options['header_button_background'] ) ) {
                $args['buttonBackground'] = $front_options['header_button_background'];
            }

            if ( ! empty( $front_options['header_button_size'] ) ) {
                $args['buttonSize'] = $front_options['header_button_size'];
            }

            if ( ! empty( $front_options['header_button_border_radius'] ) ) {
                $args['buttonBorderRadius'] = $front_options['header_button_border_radius'];
            }

            if ( isset( $front_options['header_button_is_transition'] ) ) {
                $args['buttonIsTransition'] = $front_options['header_button_is_transition'];
            }
        }

        return $args;
    }
}

if ( ! function_exists( 'front_redux_apply_header_cart_view_switcher' ) ) {
    function front_redux_apply_header_cart_view_switcher( $front_cart_view ) {

        global $front_options; 

        if ( isset( $front_options['front_cart_view'] ) ) {
            $front_cart_view = $front_options['front_cart_view'];
        }

        return $front_cart_view;
    }
}

if ( ! function_exists( 'front_redux_apply_header_user_account_view_switcher' ) ) {
    function front_redux_apply_header_user_account_view_switcher( $front_header_user_account_view ) {

        global $front_options; 

        if ( isset( $front_options['front_header_user_account_view'] ) ) {
            $front_header_user_account_view = $front_options['front_header_user_account_view'];
        }

        return $front_header_user_account_view;
    }
}

if ( ! function_exists( 'front_redux_apply_header_user_account_enable_user_name' ) ) {
    function front_redux_apply_header_user_account_enable_user_name( $front_header_user_account_enable_user_name ) {

        global $front_options; 

        if ( isset( $front_options['front_header_user_account_enable_user_name'] ) ) {
            $front_header_user_account_enable_user_name = $front_options['front_header_user_account_enable_user_name'];
        }

        return $front_header_user_account_enable_user_name;
    }
}

if ( ! function_exists( 'front_redux_apply_header_fullscreen_modal_address_title' ) ) {
    function front_redux_apply_header_fullscreen_modal_address_title( $title ) {

        global $front_options; 

        if ( isset( $front_options['header_fullscreen_modal_address_title'] ) ) {
            $title = $front_options['header_fullscreen_modal_address_title'];
        }

        return $title;
    }
}

if ( ! function_exists( 'front_redux_apply_header_fullscreen_modal_address_lines' ) ) {
    function front_redux_apply_header_fullscreen_modal_address_lines( $front_cart_view ) {

        global $front_options; 

        if ( isset( $front_options['header_fullscreen_modal_address_lines'] ) ) {
            $front_cart_view = $front_options['header_fullscreen_modal_address_lines'];
        }

        return $front_cart_view;
    }
}

if ( ! function_exists( 'front_redux_apply_header_fullscreen_modal_social_links_title' ) ) {
    function front_redux_apply_header_fullscreen_modal_social_links_title( $title ) {

        global $front_options; 

        if ( isset( $front_options['header_fullscreen_modal_social_links_title'] ) ) {
            $title = $front_options['header_fullscreen_modal_social_links_title'];
        }

        return $title;
    }
}

if( ! function_exists( 'front_redux_apply_search_push_top_static_content_id' ) ) {
    function front_redux_apply_search_push_top_static_content_id( $static_content_id ) {
        global $front_options;

        if( isset( $front_options['header_search_push_top_static_content_id'] ) ) {
            $static_content_id = $front_options['header_search_push_top_static_content_id'];
        }

        return $static_content_id;
    }
}

if ( ! function_exists( 'front_redux_apply_user_account_not_login_text' ) ) {
    function front_redux_apply_user_account_not_login_text( $header_form_title ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['header_my_account_login_form_title'] ) && ! empty( $front_options['header_my_account_login_form_title'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $header_form_title = $front_options['header_my_account_login_form_title'];
        }

        return $header_form_title;
    }
}

if ( ! function_exists( 'front_redux_apply_user_account_not_login_description' ) ) {
    function front_redux_apply_user_account_not_login_description( $header_form_description ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['header_my_account_login_form_description'] ) && ! empty( $front_options['header_my_account_login_form_description'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $header_form_description = $front_options['header_my_account_login_form_description'];
        }

        return $header_form_description;
    }
}

if ( ! function_exists( 'front_redux_apply_user_account_register_text' ) ) {
    function front_redux_apply_user_account_register_text( $header_form_title ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['header_my_account_register_form_title'] ) && ! empty( $front_options['header_my_account_register_form_title'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $header_form_title = $front_options['header_my_account_register_form_title'];
        }

        return $header_form_title;
    }
}

if ( ! function_exists( 'front_redux_apply_user_account_register_description' ) ) {
    function front_redux_apply_user_account_register_description( $header_form_description ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['header_my_account_register_form_description'] ) && ! empty( $front_options['header_my_account_register_form_description'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $header_form_description = $front_options['header_my_account_register_form_description'];
        }

        return $header_form_description;
    }
}

if ( ! function_exists( 'front_redux_apply_user_account_recover_password_text' ) ) {
    function front_redux_apply_user_account_recover_password_text( $header_form_title ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['header_my_account_forget_password_form_title'] ) && ! empty( $front_options['header_my_account_forget_password_form_title'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $header_form_title = $front_options['header_my_account_forget_password_form_title'];
        }

        return $header_form_title;
    }
}

if ( ! function_exists( 'front_redux_apply_user_account_recover_password_description' ) ) {
    function front_redux_apply_user_account_recover_password_description( $header_form_description ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['header_my_account_forget_password_form_description'] ) && ! empty( $front_options['header_my_account_forget_password_form_description'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $header_form_description = $front_options['header_my_account_forget_password_form_description'];
        }

        return $header_form_description;
    }
}

if ( ! function_exists( 'front_redux_toggle_header_search_enable' ) ) {
    function front_redux_toggle_header_search_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['header_enable_search'] ) ) {
            $enabled = (bool) $front_options['header_enable_search'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_toggle_header_mini_cart_enable' ) ) {
    function front_redux_toggle_header_mini_cart_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['header_enable_mini_cart'] ) ) {
            $enabled = (bool) $front_options['header_enable_mini_cart'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_toggle_header_user_account_enable' ) ) {
    function front_redux_toggle_header_user_account_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['header_enable_user_account'] ) ) {
            $enabled = (bool) $front_options['header_enable_user_account'];
        }

        return $enabled;
    }
}