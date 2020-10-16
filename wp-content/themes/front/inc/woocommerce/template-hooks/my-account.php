<?php
/**
 * Template hooks used in My Account
 */
remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );
remove_action( 'woocommerce_register_form', 'wc_registration_privacy_policy_text', 20 );

add_filter( 'woocommerce_breadcrumb_defaults', 'front_modify_wc_breadcrumb_args', 10 );
add_action( 'front_page', 'front_myaccount_page_header', 5 );

add_action( 'woocommerce_account_content',   'front_account_content_wrapper_start',    1 );
add_action( 'woocommerce_account_content',   'front_account_content_wrapper_end',    20 );

add_action( 'front_myaccount_partners',   'front_myaccount_partners',    10 );
remove_action( 'woocommerce_register_form', 'front_registration_privacy_policy_text', 20 );

add_filter( 'woocommerce_registration_errors', 'front_registration_errors_validation', 10, 3 );

add_action( 'woocommerce_edit_account_form_start', 'front_woocommerce_edit_account_form_profile_pic_field' );
add_action( 'woocommerce_save_account_details', 'front_woocommerce_save_account_form_profile_pic_field' );