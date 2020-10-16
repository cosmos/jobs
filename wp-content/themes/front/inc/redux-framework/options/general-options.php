<?php
/**
 * General Theme Options
 *
 */
$is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

$is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

if ( $is_woocommerce_activated || $is_job_manager_activated ) {
    $my_account_enabled = false;
} else {
    $my_account_enabled = true;
}

$general_options = apply_filters( 'front_general_options_args', array(
    'title'            => esc_html__( 'General', 'front' ),
    'desc'             => esc_html__( 'General Options available in theme', 'front' ),
    'id'               => 'general',
    'customizer_width' => '400px',
    'icon'             => 'far fa-dot-circle',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Scroll To Top', 'front' ),
            'subtitle'     => esc_html__( 'Enable to display the scroll to top arrow', 'front' ),
            'id'        => 'scrollup',
            'type'      => 'switch',
            'on'        => esc_html__('Enable', 'front'),
            'off'       => esc_html__('Disable', 'front'),
            'default'   => 1,
        ),
    )
) );

$general_my_account_options = apply_filters( 'front_general_my_account_options_args', array(
    'title'            => esc_html__( 'My Account', 'front' ),
    'id'               => 'general-my-account',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(

        array(
            'title'     => esc_html__( 'My Account Login Form Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter my account login form title', 'front' ),
            'id'        => 'my_account_login_form_title',
            'type'      => 'text',
            'default'   => sprintf( '%s <span class="font-weight-semi-bold">%s</span>', esc_html__( 'Welcome', 'front' ), esc_html__( 'back', 'front' )),
        ),

        array(
            'title'     => esc_html__( 'My Account Login Form Description', 'front' ),
            'subtitle'  => esc_html__( 'Enter my account login form description', 'front' ),
            'id'        => 'my_account_login_form_desc',
            'type'      => 'textarea',
            'default'   => esc_html__( 'Login to manage your account.', 'front' ),
        ),

        array(
            'title'     => esc_html__( 'My Account Register Form Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter my account register form title', 'front' ),
            'id'        => 'my_account_register_form_title',
            'type'      => 'text',
            'default'   => sprintf( '%s <span class="font-weight-semi-bold">%s</span>', esc_html__( 'Welcome to', 'front' ), get_bloginfo( 'name' ) ),
        ),

        array(
            'title'     => esc_html__( 'My Account Register Form Description', 'front' ),
            'subtitle'  => esc_html__( 'Enter my account register form description', 'front' ),
            'id'        => 'my_account_register_form_desc',
            'type'      => 'textarea',
            'default'   => esc_html__( 'Fill out the form to get started.', 'front' ),
        ),

        array(
            'title'     => esc_html__( 'My Account Reset Password Form Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter my account reset password form title', 'front' ),
            'id'        => 'my_account_lost_password_form_title',
            'type'      => 'text',
            'default'   => sprintf( '%s <span class="font-weight-semi-bold">%s</span>', esc_html__( 'Forgot your', 'front' ), esc_html__( 'password?', 'front' ) ),
        ),

        array(
            'title'     => esc_html__( 'My Account Reset Password Form Description', 'front' ),
            'subtitle'  => esc_html__( 'Enter my account reset password form description', 'front' ),
            'id'        => 'my_account_lost_password_form_desc',
            'type'      => 'textarea',
            'default'   => esc_html__( 'Enter your email address below and well get you back on track.', 'front' ),
        ),
    ),
) );
