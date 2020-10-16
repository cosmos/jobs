<?php

$portfolio_options = apply_filters( 'front_portfolio_options_args', array(
    'title'            => esc_html__( 'Portfolio', 'front' ),
    'desc'             => esc_html__( 'Options available for your portfolio', 'front' ),
    'id'               => 'portfolio',
    'customizer_width' => '400px',
    'icon'             => 'far fa-images'
) );

$portfolio_header_options = apply_filters( 'front_portfolio_header_options_args', array(
    'title'            => esc_html__( 'Header', 'front' ),
    'id'               => 'portfolio-header',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_potfolio_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for portfolio', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for portfolio ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_portfolio_static_block_id',
            'title'     => esc_html__( 'Portfolio Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for portfolio', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_potfolio_header', 'equals', 1 ),
        ),
    )
) );

$portfolio_footer_options = apply_filters( 'front_portfolio_footer_options_args', array(
    'title'            => esc_html__( 'Footer', 'front' ),
    'id'               => 'portfolio-footer',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_potfolio_footer',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate footer for portfolio', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate footer for portfolio ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'footer_portfolio_static_block_id',
            'title'     => esc_html__( 'Portfolio Footer', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block footer for portfolio', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_potfolio_footer', 'equals', 1 ),
        ),
    )
) );

$portfolio_general_options = apply_filters( 'front_portfolio_general_options_args', array(
    'title'            => esc_html__( 'General', 'front' ),
    'id'               => 'portfolio-general',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'type'         => 'select',
            'id'           => 'portfolio_view',
            'title'        => esc_html__( 'Portfolio View', 'front' ),
            'subtitle'     => esc_html__( 'Select your portfolio view', 'front' ),
            'options'      => array(
                'classic'      => esc_html__( 'Classic', 'front' ),
                'grid'         => esc_html__( 'Grid',    'front' ),
                'masonry'      => esc_html__( 'Masonry', 'front' ),
                'modern'       => esc_html__( 'Modern',  'front' ),
            ),
            'default'      => 'grid'
        ),

        array(
            'type'     => 'select',
            'id'       => 'portfolio_layout',
            'title'    => esc_html__( 'Portfolio Layout', 'front' ),
            'subtitle' => esc_html__( 'Select your portfolio layout', 'front' ),
            'options' => array(
                'boxed'       => esc_html__( 'Boxed', 'front' ),
                'fullwidth'   => esc_html__( 'Fullwidth', 'front' ),
            ),
            'default' => 'boxed'
        ),

        array(
            'id'        => 'portfolio_posts_per_page',
            'type'      => 'slider',
            'title'     => esc_html__( 'Projects per page', 'front' ),
            'subtitle'  => esc_html__( 'How many projects should be shown per page?', 'front' ),
            'min'       => 8,
            'max'       => 32,
            'default'   => '16'
        ),

        array(
            'id'        => 'portfolio_enable_filters',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Portfolio Type Filters', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to enable Filters in Portfolio page', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
        ),

        array(
            'id'        => 'portfolio_enable_author',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Portfolio Author', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to show Author in Portfolio', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
        ),

        array(
            'id'        => 'portfolio_enable_content',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Portfolio Content', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to show portfolio content', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
        ),
    )
) );

$portfolio_hero_block_options = apply_filters( 'front_portfolio_hero_block_options_args', array(
    'title'            => esc_html__( 'Hero Block', 'front' ),
    'id'               => 'portfolio-hero-block',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'portfolio_enable_hero',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Hero', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to enable Hero block in Portfolio page', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
        ),

        array(   
            'type'      => 'textarea',
            'id'        => 'portfolio_hero_title',
            'title'     => esc_html__( 'Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter the hero title. HTML tags permitted.', 'front' ),
            'default'   =>  wp_kses_post(sprintf( esc_html__( 'Portfolio %s card %s', 'front' ), '<span class="font-weight-semi-bold">', '</span>' ) ),
            'rows'      => 2,
            'required'  => array( 'portfolio_enable_hero', 'equals', 1 ),
        ),

        array(   
            'type'      => 'textarea',
            'id'        => 'portfolio_hero_subtitle',
            'title'     => esc_html__( 'Subtitle', 'front' ),
            'subtitle'  => esc_html__( 'Enter the text that you want to appear below hero title.', 'front' ),
            'default'   => esc_html__( 'Your portfolio should tell your story.', 'front' ),
            'rows'      => 3,
            'required'  => array( 'portfolio_enable_hero', 'equals', 1 ),
        ),
    )
) );

$portfolio_related_projects_options = apply_filters( 'front_portfolio_related_projects_options_args', array(
    'title'            => esc_html__( 'Related Projects', 'front' ),
    'id'               => 'portfolio-related-projects',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'portfolio_enable_related_works',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Related Works', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to enable related works block in Single Portfolio page', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
        ),

        array(
            'id'        => 'portfolio_realated_works_enable_author',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Portfolio Related Works Author', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to show Author in Portfolio Related Works', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
            'required'  => array( 'portfolio_enable_related_works', 'equals', 1 ),
        ),

        array(
            'id'        => 'portfolio_realated_works_enable_content',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Portfolio Related Works Content', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to show Portfolio Related Works Content', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
            'required'  => array( 'portfolio_enable_related_works', 'equals', 1 ),
        ),

        array(
            'id'        => 'portfolio_related_works_pretitle_enable',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Related Works Pretitle', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to enable related works block pretitle in Single Portfolio page', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
            'required'  => array( 'portfolio_enable_related_works', 'equals', 1 ),
        ),

        array(   
            'type'      => 'text',
            'id'        => 'portfolio_related_works_pretitle',
            'title'     => esc_html__( 'Pre-Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter the text that you want to appear above the section title', 'front' ),
            'default'   => esc_html__( 'Portfolio', 'front' ),
            'required'  => array( 'portfolio_related_works_pretitle_enable', 'equals', 1 ),
        ),

        array(
            'type'         => 'select',
            'id'           => 'portfolio_related_works_pretitle_color',
            'title'        => esc_html__( 'Pretitle Color', 'front' ),
            'options'      => array(
                'btn-primary'        => esc_html__( 'Primary', 'front' ),
                'btn-secondary'      => esc_html__( 'Secondary', 'front' ),
                'btn-success'        => esc_html__( 'Success', 'front' ),
                'btn-danger'         => esc_html__( 'Danger', 'front' ),
                'btn-warning'        => esc_html__( 'Warning', 'front' ),
                'btn-info'           => esc_html__( 'Info', 'front' ),
                'btn-dark'           => esc_html__( 'Dark', 'front' ),
                'btn-light'          => esc_html__( 'Light', 'front' ),
                'btn-indigo'         => esc_html__( 'Indigo', 'front' ),
                'btn-white'          => esc_html__( 'white', 'front' ),
                'btn-soft-primary'   => esc_html__( 'Soft Primary', 'front' ),
                'btn-soft-secondary' => esc_html__( 'Soft Secondary', 'front' ),
                'btn-soft-success'   => esc_html__( 'Soft Success', 'front' ),
                'btn-soft-danger'    => esc_html__( 'Soft Danger', 'front' ),
                'btn-soft-warning'   => esc_html__( 'Soft Warning', 'front' ),
                'btn-soft-indigo'    => esc_html__( 'Soft Indigo', 'front' ),
                'btn-soft-info'      => esc_html__( 'Soft Info', 'front' ),
                'btn-soft-dark'      => esc_html__( 'Soft Dark', 'front' ),
            ),
            'default'  => 'btn-soft-success',
            'required'  => array( 'portfolio_related_works_pretitle_enable', 'equals', 1 ),
        ),

        array(   
            'type'      => 'textarea',
            'id'        => 'portfolio_related_works_title',
            'title'     => esc_html__( 'Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter the section title. HTML tags permitted.', 'front' ),
            'default'   => wp_kses_post( sprintf( esc_html__( 'Our %s branding %s works', 'front' ), '<strong class="font-weight-semi-bold">', '</strong>' ) ),
            'rows'      => 2,
            'required'  => array( 'portfolio_enable_related_works', 'equals', 1 ),
        ),

        array(   
            'type'      => 'textarea',
            'id'        => 'portfolio_related_works_subtitle',
            'title'     => esc_html__( 'Subtitle', 'front' ),
            'subtitle'  => esc_html__( 'Enter the text that you want to appear below title.', 'front' ),
            'default'   => esc_html__( 'Experience a level of our quality in both design & customization works.', 'front' ),
            'rows'      => 3,
            'required'  => array( 'portfolio_enable_related_works', 'equals', 1 ),
        ),

        array(
            'type'         => 'select',
            'id'           => 'portfolio_related_works_view',
            'title'        => esc_html__( 'Projects View', 'front' ),
            'subtitle'     => esc_html__( 'Select the view for related projects', 'front' ),
            'options'      => array(
                'classic'      => esc_html__( 'Classic', 'front' ),
                'grid'         => esc_html__( 'Grid',    'front' ),
                'masonry'      => esc_html__( 'Masonry', 'front' ),
                'modern'       => esc_html__( 'Modern',  'front' ),
            ),
            'default'      => 'grid',
            'required'  => array( 'portfolio_enable_related_works', 'equals', 1 ),
        ),
    )
) );

$portfolio_header_options = apply_filters( 'front_portfolio_header_options_args', array(
    'title'            => esc_html__( 'Header', 'front' ),
    'id'               => 'portfolio-header',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_potfolio_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for portfolio', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for portfolio ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_portfolio_static_block_id',
            'title'     => esc_html__( 'Portfolio Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for portfolio', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_potfolio_header', 'equals', 1 ),
        ),
    )
) );

$portfolio_static_content_options = apply_filters( 'front_portfolio_static_content_args', array(
    'title'            => esc_html__( 'Static Content', 'front' ),
    'id'               => 'portfolio-Static-Content',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'portfolio_enable_static_content_block',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Static Block in Portfolio Page', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to enable static block in Portfolio page', 'front' ),
            'default'   => false,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
        ),

        array(
            'id'        => 'portfolio_static_content_block',
            'title'     => esc_html__( 'Portfolio Static Content', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block for portfolio Contact', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'portfolio_enable_static_content_block', 'equals', true ),
        ),
    )
) );

$portfolio_contact_options = apply_filters( 'front_portfolio_contact_options_args', array(
    'title'            => esc_html__( 'Contact', 'front' ),
    'id'               => 'portfolio-contact',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'portfolio_enable_contact',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Contact Block in Portfolio Page', 'front' ),
            'subtitle'  => esc_html__( 'Please choose if you want to enable contact block in Portfolio page', 'front' ),
            'default'   => true,
            'on'        => esc_html__( 'Enabled', 'front' ),
            'off'       => esc_html__( 'Disabled', 'front' ),
        ),

        array(   
            'type'      => 'textarea',
            'id'        => 'portfolio_contact_title',
            'title'     => esc_html__( 'Title', 'front' ),
            'subtitle'  => esc_html__( 'Enter the contact section title. HTML tags permitted.', 'front' ),
            'default'   =>  wp_kses_post( sprintf( esc_html__( 'You wish us %s to talk about %s your project %s', 'front' ), '<br/>', '<span class="font-weight-semi-bold">', '</span>' ) ),
            'rows'      => 3,
        ),

         array(   
            'type'      => 'text',
            'id'        => 'portfolio_contact_email',
            'title'     => esc_html__( 'Email Address', 'front' ),
            'subtitle'  => esc_html__( 'Enter your contact email address', 'front' ),
            'default'   => esc_html__( 'support@htmlstream.com', 'front' ),
        ),

        array(
            'type'     => 'select',
            'id'       => 'portfolio_contact_sm_menu_id',
            'title'    => esc_html__( 'Social Network Menu', 'front' ),
            'subtitle' => esc_html__( 'Select the menu that displays your social networks', 'front' ),
            'data'     => 'menus',
            'default'  => '',
        ),

        array(   
            'type'      => 'text',
            'id'        => 'portfolio_contact_phone',
            'title'     => esc_html__( 'Phone Number', 'front' ),
            'subtitle'  => esc_html__( 'Enter your phone number ', 'front' ),
            'default'   => esc_html__( '+1 (062) 109-9222', 'front' ),
        ),
    )
) );