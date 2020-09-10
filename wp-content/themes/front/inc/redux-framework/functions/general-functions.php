<?php
/**
 * Filter functions for General Section of Theme Options
 */

if( ! function_exists( 'front_redux_scroll_to_top_enable' ) ) {
    function front_redux_scroll_to_top_enable() {
        global $front_options;

        if( isset( $front_options['scrollup'] ) && $front_options['scrollup'] == '1' ) {
            $scrollup = true;
        } else {
            $scrollup = false;
        }

        return $scrollup;
    }
}

if ( ! function_exists( 'front_redux_apply_my_account_login_form_title' ) ) {
    function front_redux_apply_my_account_login_form_title( $myaccount_form_title ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['my_account_login_form_title'] ) && ! empty( $front_options['my_account_login_form_title'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $myaccount_form_title = $front_options['my_account_login_form_title'];
        }

        return $myaccount_form_title;
    }
}

if ( ! function_exists( 'front_redux_apply_my_account_login_form_desc' ) ) {
    function front_redux_apply_my_account_login_form_desc( $myaccount_form_desc ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['my_account_login_form_desc'] ) && ! empty( $front_options['my_account_login_form_desc'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $myaccount_form_desc = $front_options['my_account_login_form_desc'];
        }

        return $myaccount_form_desc;
    }
}

if ( ! function_exists( 'front_redux_apply_my_account_register_form_title' ) ) {
    function front_redux_apply_my_account_register_form_title( $myaccount_form_title ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['my_account_register_form_title'] ) && ! empty( $front_options['my_account_register_form_title'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $myaccount_form_title = $front_options['my_account_register_form_title'];
        }

        return $myaccount_form_title;
    }
}

if ( ! function_exists( 'front_redux_apply_my_account_register_form_desc' ) ) {
    function front_redux_apply_my_account_register_form_desc( $myaccount_form_desc ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['my_account_register_form_desc'] ) && ! empty( $front_options['my_account_register_form_desc'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $myaccount_form_desc = $front_options['my_account_register_form_desc'];
        }

        return $myaccount_form_desc;
    }
}

if ( ! function_exists( 'front_redux_apply_woocommerce_lost_password_form_title' ) ) {
    function front_redux_apply_woocommerce_lost_password_form_title( $myaccount_lost_password_form_title ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['my_account_lost_password_form_title'] ) && ! empty( $front_options['my_account_lost_password_form_title'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $myaccount_lost_password_form_title = $front_options['my_account_lost_password_form_title'];
        }

        return $myaccount_lost_password_form_title;
    }
}

if ( ! function_exists( 'front_redux_apply_woocommerce_lost_password_message' ) ) {
    function front_redux_apply_woocommerce_lost_password_message( $myaccount_lost_password_form_desc ) {

        global $front_options; 

        $is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        if ( isset( $front_options['my_account_lost_password_form_desc'] ) && ! empty( $front_options['my_account_lost_password_form_desc'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
            $myaccount_lost_password_form_desc = $front_options['my_account_lost_password_form_desc'];
        }

        return $myaccount_lost_password_form_desc;
    }
}