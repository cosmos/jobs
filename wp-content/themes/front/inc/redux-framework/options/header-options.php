<?php
global $front_options;

$is_woocommerce_activated = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

$is_job_manager_activated = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

if ( isset( $front_options['front_header_user_account_view'] ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
    $header_my_account_login_form_title_condition = false;
} else {
    $header_my_account_login_form_title_condition = true;
}

if ( isset( $front_options['front_header_user_account_view'] ) && ( $front_options['front_header_user_account_view'] == 'sidebar-left' || $front_options['front_header_user_account_view'] == 'sidebar-right' ) && ( $is_woocommerce_activated || $is_job_manager_activated ) ) {
    $header_my_account_regster_form_description_condition = false;
} else {
    $header_my_account_regster_form_description_condition = true;
}

$header_options = apply_filters( 'front_header_options_args', array(
    'title'            => esc_html__( 'Header', 'front' ),
    'id'               => 'header',
    'desc'             => esc_html__( 'Options available for your header', 'front' ),
    'customizer_width' => '400px',
    'icon'             => 'far fa-arrow-alt-circle-up',
    'desc'             => esc_html__( 'These settings are not applied to pages that have Custom Header.', 'front' ),
) );

$header_general_options = apply_filters( 'front_header_general_options_args', array(
    'title'            => esc_html__( 'General', 'front' ),
    'id'               => 'header-general',
    'desc'             => esc_html__( 'Use the options below to set the general behaviour of your website\'s header', 'front' ),
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'type'         => 'select',
            'id'           => 'header_menu_style',
            'title'        => esc_html__( 'Menu Style', 'front' ),
            'options'      => array(
                'navbar'      => esc_html__( 'Navbar', 'front' ),
                'off-screen'  => esc_html__( 'Off Screen', 'front' ),
                'full-screen' => esc_html__( 'Full Screen' , 'front' ),
                'logo-only'   => esc_html__( 'Logo Only', 'front' ),
            ),
            'default'  => 'navbar'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_full_screen_nav_style',
            'title'        => esc_html__( 'Full Screen Nav Style', 'front' ),
            'options'      => array(
                'modal'         => esc_html__( 'Modal', 'front' ),
                'sidebar-right' => esc_html__( 'Sidebar Right', 'front' ),
                'sidebar-left'  => esc_html__( 'Sidebar Left', 'front' ),
            ),
            'required'  => array( 'header_menu_style', 'equals', 'full-screen' ),
            'default'  => 'modal'
        ),

        array(
            'title'     => esc_html__( 'Is Container Fluid ?', 'front' ),
            'id'        => 'header_is_container_fluid',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => false,
        ),

        array(
            'title'     => esc_html__( 'Enable Postion', 'front' ),
            'id'        => 'header_enable_postion',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => true,
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_position',
            'title'        => esc_html__( 'Position', 'front' ),
            'options'      => array(
                'abs-top'               => esc_html__( 'Absolute Top', 'front' ),
                'abs-bottom'            => esc_html__( 'Absolute Bottom', 'front' ),
                'abs-top-2nd-screen'    => esc_html__( 'Second Screen', 'front' ),
                'floating'              => esc_html__( 'Floating', 'front' ),
            ),
            'required'  => array( 'header_enable_postion', 'equals', true ),
            'default'  => 'abs-top'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_position_screen',
            'title'        => esc_html__( 'Position Only in', 'front' ),
            'options'      => array(
                'all-screens'   => esc_html__( 'All Screens', 'front' ),
                'sm'            => esc_html__( 'sm', 'front' ),
                'md'            => esc_html__( 'md', 'front' ),
                'lg'            => esc_html__( 'lg', 'front' ),
                'xl'            => esc_html__( 'xl', 'front' ),
            ),
            'required'  => array( 'header_enable_postion', 'equals', true ),
            'default'  => 'md'
        ),

        array(
            'title'     => esc_html__( 'Enable Sticky', 'front' ),
            'id'        => 'header_enable_sticky',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => false,
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_sticky_position',
            'title'        => esc_html__( 'Sticky Position', 'front' ),
            'options'      => array(
                'top'               => esc_html__( 'Top', 'front' ),
                'bottom'            => esc_html__( 'Bottom', 'front' ),
            ),
            'required'  => array( 'header_enable_sticky', 'equals', true ),
            'default'  => 'top'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_sticky_breakpoint',
            'title'        => esc_html__( 'Sticky Breakpoint', 'front' ),
            'options'      => array(
                'all-screens'   => esc_html__( 'All Screens', 'front' ),
                'sm'            => esc_html__( 'sm', 'front' ),
                'md'            => esc_html__( 'md', 'front' ),
                'lg'            => esc_html__( 'lg', 'front' ),
                'xl'            => esc_html__( 'xl', 'front' ),
            ),
            'required'  => array( 'header_enable_sticky', 'equals', true ),
            'default'  => 'all-screens'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_sticky_scroll_behavior',
            'title'        => esc_html__( 'Sticky On scroll behavior', 'front' ),
            'options'      => array(
                'none'                      => esc_html__( 'None', 'front' ),
                'hide-topbar'               => esc_html__( 'Hide topbar', 'front' ),
                'toggle-topbar'             => esc_html__( 'Toggle topbar', 'front' ),
                'changing-logo-on-scroll'   => esc_html__( 'Changing logo on scroll', 'front' ),
                'white-bg-on-scroll'        => esc_html__( 'White Background on Scroll', 'front' ),
            ),
            'required'  => array( 'header_enable_sticky', 'equals', true ),
            'default'  => 'none'
        ),

        array(
            'title'     => esc_html__( 'Enable Toggle Section', 'front' ),
            'id'        => 'header_enable_toggle_section',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'required'  => array( 'header_sticky_position', 'equals', 'top' ),
            'default'   => false,
        ),

        array(
            'title'     => esc_html__( 'Enable Show/Hide', 'front' ),
            'id'        => 'header_enable_show_hide',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => true,
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_show_hide_breakpoint',
            'title'        => esc_html__( 'Show/Hide Breakpoint', 'front' ),
            'options'      => array(
                'all-screens'   => esc_html__( 'All Screens', 'front' ),
                'sm'            => esc_html__( 'sm', 'front' ),
                'md'            => esc_html__( 'md', 'front' ),
                'lg'            => esc_html__( 'lg', 'front' ),
                'xl'            => esc_html__( 'xl', 'front' ),
            ),
            'required'  => array( 'header_enable_show_hide', 'equals', true ),
            'default'  => 'md'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_show_hide_scroll_behavior',
            'title'        => esc_html__( 'Show/Hide On scroll behavior', 'front' ),
            'options'      => array(
                'none'                      => esc_html__( 'None', 'front' ),
                'hide-topbar'               => esc_html__( 'Hide topbar', 'front' ),
                'changing-logo-on-scroll'   => esc_html__( 'Changing logo on scroll', 'front' ),
            ),
            'required'  => array( 'header_enable_show_hide', 'equals', true ),
            'default'  => 'none'
        ),

        array(
            'title'     => esc_html__( 'Enable White Nav Links', 'front' ),
            'id'        => 'header_enable_white_nav_links',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => false,
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_white_nav_links_breakpoint',
            'title'        => esc_html__( 'White Nav Links Breakpoint', 'front' ),
            'options'      => array(
                'all-screens'   => esc_html__( 'All Screens', 'front' ),
                'sm'            => esc_html__( 'sm', 'front' ),
                'md'            => esc_html__( 'md', 'front' ),
                'lg'            => esc_html__( 'lg', 'front' ),
                'xl'            => esc_html__( 'xl', 'front' ),
            ),
            'required'  => array( 'header_enable_white_nav_links', 'equals', true ),
            'default'  => 'all-screens'
        ),

        array(
            'title'     => esc_html__( 'Enable Transparent', 'front' ),
            'id'        => 'header_enable_transparent',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => true,
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_transparent_breakpoint',
            'title'        => esc_html__( 'Transparent Breakpoint', 'front' ),
            'options'      => array(
                'all-screens'   => esc_html__( 'All Screens', 'front' ),
                'sm'            => esc_html__( 'sm', 'front' ),
                'md'            => esc_html__( 'md', 'front' ),
                'lg'            => esc_html__( 'lg', 'front' ),
                'xl'            => esc_html__( 'xl', 'front' ),
            ),
            'required'  => array( 'header_enable_transparent', 'equals', true ),
            'default'  => 'all-screens'
        ),

        array(
            'title'     => esc_html__( 'Enable Border', 'front' ),
            'id'        => 'header_enable_border',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'required'  => array( 'header_enable_transparent', 'equals', true ),
            'default'   => false,
        ),

        array(
            'title'     => esc_html__( 'Enable Fix Effect', 'front' ),
            'id'        => 'header_enable_fix_effect',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => false,
        ),
    )
) );

$header_background_options = apply_filters( 'front_header_background_options_args', array(
    'title'            => esc_html__( 'Background', 'front' ),
    'id'               => 'header-background',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'type'         => 'select',
            'id'           => 'header_background',
            'title'        => esc_html__( 'Background', 'front' ),
            'options'      => array(
                'default'                   => esc_html__( 'Default', 'front' ),
                'dark'                      => esc_html__( 'Dark', 'front' ),
                'navbar-primary'            => esc_html__( 'Navbar Primary', 'front' ),
                'navbar-gradient'           => esc_html__( 'Navbar Gradient', 'front' ),
                'navbar-dark'               => esc_html__( 'Navbar Dark', 'front' ),
                'white-to-dark-on-scroll'   => esc_html__( 'White-to-dark on scroll', 'front' ),
                'dark-to-white-on-scroll'   => esc_html__( 'Dark-to-white on scroll', 'front' ),
                'submenu-dark'              => esc_html__( 'Submenu dark', 'front' )
            ),
            'default'  => 'default'
        ),
    )
) );

$header_topbar_options = apply_filters( 'front_header_topbar_options_args', array(
    'title'            => esc_html__( 'Topbar', 'front' ),
    'id'               => 'header-topbar',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Enable Topbar', 'front' ),
            'id'        => 'header_enable_topbar',
            'subtitle'  => esc_html__( 'Enable to display top bar in header', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => true,
        ),

        array(
            'title'     => esc_html__( 'Enable Topbar Left', 'front' ),
            'id'        => 'header_enable_topbar_left',
            'subtitle'  => esc_html__( 'Enable to display top bar left in header', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'required'  => array( 'header_enable_topbar', 'equals', true ),
            'default'   => true,
        ),

        array(
            'title'     => esc_html__( 'Enable Topbar Right', 'front' ),
            'id'        => 'header_enable_topbar_right',
            'subtitle'  => esc_html__( 'Enable to display top bar right in header', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'required'  => array( 'header_enable_topbar', 'equals', true ),
            'default'   => true,
        ),

        array(
            'title'     => esc_html__( 'Enable Search', 'front' ),
            'id'        => 'header_enable_search',
            'subtitle'  => esc_html__( 'Enable to display Search in header', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'required'  => array( 
                array( 'header_enable_topbar_right', 'equals', true ),
            ),
            'default'   => true,
        ),

        array(
            'title'     => esc_html__( 'Enable Mini Cart', 'front' ),
            'id'        => 'header_enable_mini_cart',
            'subtitle'  => esc_html__( 'Enable to display Mini Cart in header', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'required'  => array( 
                array( 'header_enable_topbar_right', 'equals', true ),
            ),
            'default'   => true,
        ),

        array(
            'type'         => 'select',
            'id'           => 'front_cart_view',
            'title'        => esc_html__( 'Mini Cart View', 'front' ),
            'subtitle'     => esc_html__( 'Select the view for mini cart', 'front' ),
            'options'      => array(
                'dropdown'      => esc_html__( 'Dropdown', 'front' ),
                'modal'         => esc_html__( 'Modal',    'front' ),
                'sidebar-right' => esc_html__( 'Sidebar Right' ,   'front' ),
                'sidebar-left'  => esc_html__( 'Sidebar Left', 'front' ),
                'link'          => esc_html__( 'Link',  'front' ),
            ),
            'required'  => array( 
                array( 'header_enable_mini_cart', 'equals', true ),
            ),
            'default'  => 'dropdown'
        ),

        array(
            'title'     => esc_html__( 'Enable User Account', 'front' ),
            'id'        => 'header_enable_user_account',
            'subtitle'  => esc_html__( 'Enable to display User Account in header', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'required'  => array( 
                array( 'header_enable_topbar_right', 'equals', true ),
            ),
            'default'   => true,
        ),

        array(
            'type'         => 'select',
            'id'           => 'front_header_user_account_view',
            'title'        => esc_html__( 'Header User Account View', 'front' ),
            'subtitle'     => esc_html__( 'Select the view for user account. To view meta box option for header form save & refresh the page.', 'front' ),
            'options'      => array(
                'dropdown'      => esc_html__( 'Dropdown', 'front' ),
                'modal'         => esc_html__( 'Modal',    'front' ),
                'sidebar-right' => esc_html__( 'Sidebar Right' ,   'front' ),
                'sidebar-left'  => esc_html__( 'Sidebar Left', 'front' ),
            ),
            'required'  => array( 'header_enable_user_account', 'equals', true ),
            'default'  => 'dropdown'
        ),

        array(
            'title'     => esc_html__( 'Header Login Form Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter header my account login form title', 'front' ),
            'id'        => 'header_my_account_login_form_title',
            'type'      => 'text',
            'required'  => array( 
                array( 'header_enable_topbar_right', 'equals', true ),
                array( 'header_enable_user_account', 'equals', true ),
                array( 'header_enable_topbar', '=', true ),
            ),
        ),

        array(
            'title'     => esc_html__( 'Header Login Form Description', 'front' ),
            'subtitle'  => esc_html__( 'Enter header my account login form description', 'front' ),
            'id'        => 'header_my_account_login_form_description',
            'type'      => 'textarea',
            'required'  => array(
                array( 'front_header_user_account_view', 'equals', array( 'sidebar-left', 'sidebar-right' ) )
            )
        ),

        array(
            'title'     => esc_html__( 'Header Register Form Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter header my account register form title', 'front' ),
            'id'        => 'header_my_account_register_form_title',
            'type'      => 'text',
            'required'  => array( 
                array( 'header_enable_topbar_right', 'equals', true ),
                array( 'header_enable_user_account', 'equals', true ),
                array( 'header_enable_topbar', '=', true ),
            ),
        ),

        array(
            'title'     => esc_html__( 'Header Register Form Description', 'front' ),
            'subtitle'  => esc_html__( 'Enter header my account register form description', 'front' ),
            'id'        => 'header_my_account_register_form_description',
            'type'      => 'textarea',
            'required'  => array(
                array( 'front_header_user_account_view', 'equals', array( 'sidebar-left', 'sidebar-right' ) )
            )
        ),

        array(
            'title'     => esc_html__( 'Header Reset Password Form Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter header my account reset password form title', 'front' ),
            'id'        => 'header_my_account_forget_password_form_title',
            'type'      => 'text',
            'required'  => array( 
                array( 'header_enable_topbar_right', 'equals', true ),
                array( 'header_enable_user_account', 'equals', true ),
                array( 'header_enable_topbar', '=', true ),
            ),
        ),

        array(
            'title'     => esc_html__( 'Header Reset Password Form Description', 'front' ),
            'subtitle'  => esc_html__( 'Enter header my account reset password form description', 'front' ),
            'id'        => 'header_my_account_forget_password_form_description',
            'type'      => 'textarea',
            'required'  => array(
                array( 'front_header_user_account_view', 'equals', array( 'sidebar-left', 'sidebar-right' ) )
            )
        ),

        array(
            'title'     => esc_html__( 'Header My Account Username', 'front' ),
            'id'        => 'front_header_user_account_enable_user_name',
            'subtitle'  => esc_html__( 'Enable to show username in my account in header', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'required'  => array( 'header_enable_topbar', 'equals', true ),
            'default'   => true,
        ),
    )
) );

$header_logo_options = apply_filters( 'front_header_logo_options_args', array(
    'title'            => esc_html__( 'Logo', 'front' ),
    'desc'             => esc_html__( 'Please use Appearance > Customize > Site Identity > Site Logo to upload your Site Logo & Favicon', 'front' ),
    'id'               => 'header-logo',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Enable Logo White', 'front' ),
            'id'        => 'header_enable_logo_white',
            'desc'      => esc_html__( 'Use this option to enable to display White Logo for darker backgrounds( Works only for default logo ).', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => false,
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_logo_align',
            'title'        => esc_html__( 'Logo Align', 'front' ),
            'desc'         => esc_html__( 'If you select "Center" option, the navbar will appear in the next line.', 'front' ),
            'options'      => array(
                'left'      => esc_html__( 'Left', 'front' ),
                'center'    => esc_html__( 'Center', 'front' ),
            ),
            'default'  => 'left'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_logo_align_breakpoint',
            'title'        => esc_html__( 'Logo Align Breakpoint', 'front' ),
            'options'      => array(
                'all-screens'   => esc_html__( 'All Screens', 'front' ),
                'sm'            => esc_html__( 'sm', 'front' ),
                'md'            => esc_html__( 'md', 'front' ),
                'lg'            => esc_html__( 'lg', 'front' ),
                'xl'            => esc_html__( 'xl', 'front' ),
            ),
            'required'  => array( 'header_logo_align', 'equals', 'center' ),
            'default'  => 'all-screens'
        ),

        array(
            'title'     => esc_html__( 'Upload Scroll Logo', 'front' ),
            'desc'      => esc_html__( 'Scroll Logo is the Logo that you want to appear when the user scrolls down and the header sticks.', 'front' ),
            'id'        => 'header_logo_scroll_image',
            'type'      => 'media',
        ),
    )
) );

$header_navbar_options = apply_filters( 'front_header_navbar_options_args', array(
    'title'            => esc_html__( 'Primary Menu ( Navbar )', 'front' ),
    'id'               => 'header-navbar',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'type'         => 'select',
            'id'           => 'header_navbar_responsive_type',
            'title'        => esc_html__( 'Responsive Type', 'front' ),
            'options'      => array(
                'none'          => esc_html__( 'None', 'front' ),
                'collapse'      => esc_html__( 'Collapse', 'front' ),
                'scroll'        => esc_html__( 'Scroll', 'front' ),
            ),
            'default'  => 'collapse'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_navbar_collapse_breakpoint',
            'title'        => esc_html__( 'Collapse Breakpoint', 'front' ),
            'options'      => array(
                'sm'            => esc_html__( 'sm', 'front' ),
                'md'            => esc_html__( 'md', 'front' ),
                'lg'            => esc_html__( 'lg', 'front' ),
                'xl'            => esc_html__( 'xl', 'front' ),
            ),
            'required'  => array( 'header_navbar_responsive_type', 'equals', 'collapse' ),
            'default'  => 'md'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_navbar_align',
            'title'        => esc_html__( 'Align', 'front' ),
            'options'      => array(
                'left'      => esc_html__( 'Left', 'front' ),
                'right'     => esc_html__( 'Right', 'front' ),
                'center'    => esc_html__( 'Center', 'front' ),
            ),
            'default'  => 'right'
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_navbar_dropdown_trigger',
            'title'        => esc_html__( 'Dropdown Trigger', 'front' ),
            'options'      => array(
                'hover'     => esc_html__( 'Hover', 'front' ),
                'click'     => esc_html__( 'Click', 'front' ),
            ),
            'default'  => 'hover'
        ),

        array(
            'title'     => esc_html__( 'Enable Scroll Nav', 'front' ),
            'id'        => 'header_navbar_scroll_nav',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => false,
        ),
    )
) );

$header_button_options = apply_filters( 'front_header_button_options_args', array(
    'title'            => esc_html__( 'Header Action Button', 'front' ),
    'id'               => 'header-button',
    'subsection'       => true,
    'customizer_width' => '450px',
    'desc'             => esc_html__( 'This is the button that appears to the right of the Header when there is no Primary Menu ( navbar ) or if it is center aligned.', 'front' ),
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Enable', 'front' ),
            'id'        => 'header_button_enable',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => true,
        ),

        array(
            'title'     => esc_html__( 'Text', 'front' ),
            'id'        => 'header_button_text',
            'type'      => 'text',
            'default'   => esc_html__( 'Buy Now', 'front'),
        ),

        array(
            'title'     => esc_html__( 'Link', 'front' ),
            'id'        => 'header_button_url',
            'type'      => 'text',
            'default'   => '#',
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_button_background',
            'title'        => esc_html__( 'Background Color', 'front' ),
            'options'      => array(
                'primary'       => esc_html__( 'Primary', 'front' ),
                'secondary'     => esc_html__( 'Secondary', 'front' ),
                'success'       => esc_html__( 'Success', 'front' ),
                'danger'        => esc_html__( 'Danger', 'front' ),
                'warning'       => esc_html__( 'Warning', 'front' ),
                'info'          => esc_html__( 'Info', 'front' ),
                'dark'          => esc_html__( 'Dark', 'front' ),
                'light'         => esc_html__( 'Light', 'front' ),
                'indigo'        => esc_html__( 'Indigo', 'front' ),
                'white'         => esc_html__( 'White', 'front' ),
            ),
            'default'  => 'primary',
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_button_size',
            'title'        => esc_html__( 'Size', 'front' ),
            'options'      => array(
                'btn-xs'        => esc_html__( 'Extra Small', 'front' ),
                'btn-sm'        => esc_html__( 'Small', 'front' ),
                'default'       => esc_html__( 'Default', 'front' ),
                'btn-lg'        => esc_html__( 'Large', 'front' ),
            ),
            'default'  => 'default',
        ),

        array(
            'type'         => 'select',
            'id'           => 'header_button_border_radius',
            'title'        => esc_html__( 'Border Radius', 'front' ),
            'options'      => array(
                'rounded-0'         => esc_html__( 'Rounded 0', 'front' ),
                'default'           => esc_html__( 'Default', 'front' ),
                'btn-pill'          => esc_html__( 'Pill', 'front' ),
                'rounded-circle'    => esc_html__( 'Circle', 'front' ),
            ),
            'default'  => 'default',
        ),

        array(
            'title'     => esc_html__( 'Enable Transition', 'front' ),
            'id'        => 'header_button_is_transition',
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => false,
        ),
    )
) );

$header_fullscreen_modal_options = apply_filters( 'front_header_fullscreen_modal_options_args', array(
    'title'            => esc_html__( 'Fullscreen Modal', 'front' ),
    'id'               => 'header-fullscreen-modal',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'title'     => esc_html__( 'Address Title', 'front' ),
            'id'        => 'header_fullscreen_modal_address_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Address', 'front' ),
        ),

        array(
            'title'     => esc_html__( 'Address', 'front' ),
            'id'        => 'header_fullscreen_modal_address_lines',
            'type'      => 'multi_text',
            'subtitle'  => esc_html__('Add Address', 'front'),
            'default'   => array( '+1 (062) 109-9222', 'support@htmlstream.com', esc_html__( '153 Williamson Plaza, Maggieberg, MT 09514', 'front' ) ),
        ),

        array(
            'title'     => esc_html__( 'Social Title', 'front' ),
            'id'        => 'header_fullscreen_modal_social_links_title',
            'type'      => 'text',
            'default'   => esc_html__( 'Social', 'front' ),
        ),
    )
) );

$header_search_options = apply_filters( 'front_header_search_options_args', array(
    'title'            => esc_html__( 'Search', 'front' ),
    'id'               => 'header-search',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'header_search_push_top_static_content_id',
            'title'     => esc_html__( 'Push Top Static Content', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static content for search push top', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
        ),
    )
) );
