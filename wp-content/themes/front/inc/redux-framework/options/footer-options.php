<?php
global $front_options;

$footer_options_fields_footer_contact_info = array();
$footer_options_fields_footer_logo_section = array();

for ( $i = 0; $i <= apply_filters( 'front_footer_primary_v6_contact_info_limit', 3 ) - 1; $i++ ) {

    $contact_start = array(
        'id'        => 'footer_primary_contact_info_section_start'. $i,
        'type'      => 'section',
        'title'     => esc_html__( 'Footer Contact Info ', 'front' ) . '#' . ( $i + 1 ),
        'indent'    => true,
        'required'  => array(
            array( 'footer_primary_version', 'equals', 'v6' )
        ),
    );

    $contact_icon = array(
        'id'        => 'footer_primary_contact_info_icon' . $i,
        'type'      => 'text',
        'title'     => esc_html__( 'Footer Contact Info Icon ', 'front' ),
        'subtitle'  => esc_html__( 'Enter footer contact info icon class', 'front' ),
    );

    $contact_title = array(
        'id'        => 'footer_primary_contact_info_title' . $i,
        'type'      => 'text',
        'title'     => esc_html__( 'Footer Contact Title', 'front' ),
        'subtitle'  => esc_html__( 'Enter footer contact info title', 'front' ),
    );

    $contact_link = array(
        'id'        => 'footer_primary_contact_info_description_link' . $i,
        'type'      => 'text',
        'title'     => esc_html__( 'Footer Contact Details Link', 'front' ),
        'subtitle'  => esc_html__( 'Enter footer contact info description link', 'front' ),
    );

    $contact_desc = array(
        'id'        => 'footer_primary_contact_info_description' . $i,
        'type'      => 'textarea',
        'title'     => esc_html__( 'Footer Contact Details', 'front' ),
        'subtitle'  => esc_html__( 'Enter footer contact info description', 'front' ),
    );

    $contact_end = array(
        'id'        => 'footer_primary_contact_info_section_end' . $i,
        'type'      => 'section',
        'indent'    => false,
        'required'  => array(
            array( 'footer_primary_version', 'equals', 'v6' )
        ),
    );

    array_push( $footer_options_fields_footer_contact_info, $contact_start );
    array_push( $footer_options_fields_footer_contact_info, $contact_icon );
    array_push( $footer_options_fields_footer_contact_info, $contact_title );
    array_push( $footer_options_fields_footer_contact_info, $contact_link );
    array_push( $footer_options_fields_footer_contact_info, $contact_desc );
    array_push( $footer_options_fields_footer_contact_info, $contact_end );
}

$logo_section_start = array(
    'id'        => 'footer_logo_section_start',
    'type'      => 'section',
    'title'     => esc_html__( 'Footer Logo', 'front' ),
    'indent'    => true,
);

$logo_section_1 = array(
    'id'        => 'enable_separate_footer_logo',
    'type'      => 'switch',
    'title'     => esc_html__( 'Use separate logo for Footer', 'front' ),
    'subtitle'  => esc_html__( 'Do you want to display a separate logo for footer ?', 'front' ),
    'desc'      => esc_html__( 'By default the logo uploaded to Appearance > Customize > Site Identity > Site Logo is displayed in footer', 'front' ),
    'on'        => esc_html__( 'Yes', 'front' ),
    'off'       => esc_html__( 'No', 'front' ),
    'default'   => 0,
);

$logo_section_2 = array(
    'id'        => 'separate_footer_logo',
    'type'      => 'media',
    'title'     => esc_html__( 'Footer Logo', 'front' ),
    'subtitle'  => esc_html__( 'Upload an image file. Recommended Size : 150x57 pixels', 'front' ),
    'desc'      => esc_html__( 'Upload a separate logo that you want to be displayed in footer', 'front' ),
    'required'  => array( 'enable_separate_footer_logo', 'equals', true ),
);

$logo_section_3 = array(
    'id'        => 'enable_svg_logo_light',
    'type'      => 'switch',
    'title'     => esc_html__( 'Use Light SVG logo for Footer', 'front' ),
    'subtitle'  => esc_html__( 'Do you want to display a light svg logo for footer ?', 'front' ),
    'on'        => esc_html__( 'Yes', 'front' ),
    'off'       => esc_html__( 'No', 'front' ),
    'default'   => 0,
    'required'  => array( 'enable_separate_footer_logo', 'equals', false ),
);

$logo_section_end = array(
    'id'        => 'footer_logo_section_end',
    'type'      => 'section',
    'indent'    => false,
);

if ( isset( $front_options ) && ! empty( $front_options ) ) {
    if ( isset( $front_options['footer_style'] ) && ( $front_options['footer_style'] == 'default' || $front_options['footer_style'] == 'dark-background' ) || ( $front_options['footer_style'] == 'primary-background' && ( $front_options[ 'footer_primary_version' ] != 'v3' && $front_options[ 'footer_primary_version' ] != 'v2' ) ) ) {
        array_push( $footer_options_fields_footer_logo_section, $logo_section_start );
        array_push( $footer_options_fields_footer_logo_section, $logo_section_1 );
        array_push( $footer_options_fields_footer_logo_section, $logo_section_2 );
        array_push( $footer_options_fields_footer_logo_section, $logo_section_3 );
        array_push( $footer_options_fields_footer_logo_section, $logo_section_end );
    }
}

$footer_options_fields = array(

    array(
        'type'         => 'select',
        'id'           => 'footer_style',
        'title'        => esc_html__( 'Footer Style', 'front' ),
        'subtitle'     => esc_html__( 'Select the style for footer', 'front' ),
        'options'      => array(
            'default'           => esc_html__( 'Default', 'front' ),
            'dark-background'   => esc_html__( 'Dark Background',    'front' ),
            'primary-background'=> esc_html__( 'Primary Background' ,   'front' ),
        ),
        'default'  => 'default'
    ),

    array(
        'type'         => 'select',
        'id'           => 'footer_default_version',
        'title'        => esc_html__( 'Footer Version', 'front' ),
        'subtitle'     => esc_html__( 'Select the version for footer', 'front' ),
        'options'      => array(
            'v1'    => esc_html__( 'Version 1', 'front' ),
            'v2'    => esc_html__( 'Version 2', 'front' ),
            'v3'    => esc_html__( 'Version 3', 'front' ),
            'v4'    => esc_html__( 'Version 4', 'front' ),
            'v5'    => esc_html__( 'Version 5', 'front' ),
            'v6'    => esc_html__( 'Version 6', 'front' ),
            'v7'    => esc_html__( 'Version 7', 'front' ),
            'v8'    => esc_html__( 'Version 8', 'front' ),
            'v9'    => esc_html__( 'Version 9', 'front' ),
            'v10'   => esc_html__( 'Version 10', 'front' ),
            'v11'   => esc_html__( 'Version 11', 'front' ),
            'v12'   => esc_html__( 'Version 12', 'front' ),
            'v13'   => esc_html__( 'Version 13', 'front' ),
            'v14'   => esc_html__( 'Version 14', 'front' ),
            'v15'   => esc_html__( 'Version 15', 'front' ),
            'v16'   => esc_html__( 'Version 16', 'front' ),
            'v17'   => esc_html__( 'Version 17', 'front' ),
        ),
        'required' => array( 'footer_style', 'equals', 'default' ),
        'default'  => 'v1'
    ),

    array(
        'type'         => 'select',
        'id'           => 'footer_dark_version',
        'title'        => esc_html__( 'Footer Version', 'front' ),
        'subtitle'     => esc_html__( 'Select the version for footer', 'front' ),
        'options'      => array(
            'v1'    => esc_html__( 'Version 1', 'front' ),
            'v2'    => esc_html__( 'Version 2', 'front' ),
            'v3'    => esc_html__( 'Version 3', 'front' ),
            'v4'    => esc_html__( 'Version 4', 'front' ),
        ),
        'required' => array( 'footer_style', 'equals', 'dark-background' ),
        'default'  => 'v1'
    ),

    array(
        'type'         => 'select',
        'id'           => 'footer_primary_version',
        'title'        => esc_html__( 'Footer Version', 'front' ),
        'subtitle'     => esc_html__( 'Select the version for footer', 'front' ),
        'options'      => array(
            'v1'    => esc_html__( 'Version 1', 'front' ),
            'v2'    => esc_html__( 'Version 2', 'front' ),
            'v3'    => esc_html__( 'Version 3', 'front' ),
            'v4'    => esc_html__( 'Version 4', 'front' ),
            'v5'    => esc_html__( 'Version 5', 'front' ),
            'v6'    => esc_html__( 'Version 6', 'front' ),
        ),
        'required' => array( 'footer_style', 'equals', 'primary-background' ),
        'default'  => 'v1'
    ),

    array(
        'title'     => esc_html__( 'Primary Background', 'front' ),
        'subtitle'     => esc_html__( 'Enable to add primary background in footer', 'front' ),
        'id'        => 'bg_primary',
        'type'      => 'switch',
        'on'        => esc_html__('Enable', 'front'),
        'off'       => esc_html__('Disable', 'front'),
        'default'   => false,
        'required'     => array(
            array( 'footer_style', 'equals', 'primary-background' ),
            array( 'footer_primary_version', 'equals', 'v3' )
        ),
    ),

    array(
        'type'         => 'textarea',
        'id'           => 'footer_copyright_text',
        'title'        => esc_html__( 'Footer Copyright Text', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer copyright text', 'front' ),
    ),

    array(
        'type'         => 'textarea',
        'id'           => 'footer_site_description',
        'title'        => esc_html__( 'Footer Site Description', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer site description', 'front' ),
        'required'     => array(
            array( 'footer_style', 'equals', 'primary-background' ),
            array( 'footer_primary_version', 'equals', 'v1' )
        ),
    ),

    array(
        'id'        => 'enable_footer_static_block',
        'title'     => esc_html__( 'Show Static Blocks', 'front' ),
        'type'      => 'switch',
        'default'   => 1,
        // 'required' => array( 'footer_primary_version','equals', array('v4', 'v5') )

    ),


    array(
        'id'        => 'footer_static_block_id',
        'title'     => esc_html__( 'Footer Before Static Block', 'front' ),
        'subtitle'  => esc_html__( 'Choose a static block for footer before', 'front' ),
        'description' => wp_kses_post( '<p><strong>Default Footer <u>Style 2, 4 & 8</u> has footer before static content.</strong></p><p><strong>Primary Footer <u>Style 4 & 5</u> has footer before static content.</strong></p>' ),
        'type'      => 'select',
        'data'      => 'posts',
        'args'      => array(
            'post_type'         => 'mas_static_content',
            'posts_per_page'    => -1,
        ),
        'required'  => array( 'enable_footer_static_block', 'equals', true )
    ),

    array(
        'type'         => 'text',
        'id'           => 'footer_default_13_button_text',
        'title'        => esc_html__( 'Footer Button Text', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer button text', 'front' ),
        'required'     => array(
            array('footer_style','equals','default'),
            array('footer_default_version','equals','v13')
        ),
    ),

    array(
        'type'         => 'text',
        'id'           => 'footer_default_13_button_url',
        'title'        => esc_html__( 'Footer Button URL', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer button url', 'front' ),
        'required'     => array(
            array('footer_style','equals','default'),
            array('footer_default_version','equals','v13')
        ),
    ),

    array(
        'type'         => 'text',
        'id'           => 'primary_footer_v2_goto_icon_class',
        'title'        => esc_html__( 'Footer Goto Icon Class', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer goto icon class', 'front' ),
        'required'     => array(
            array( 'footer_style', 'equals', 'primary-background' ),
            array( 'footer_primary_version', 'equals', 'v2' )
        ),
    ),

    array(
        'type'         => 'text',
        'id'           => 'footer_primary_v6_form',
        'title'        => esc_html__( 'Footer Form Shortcode', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer form shortcode', 'front' ),
        'required'     => array(
            array( 'footer_primary_version', 'equals', 'v6' )
        ),
    ),

    array(
        'type'         => 'text',
        'id'           => 'footer_primary_title_v6',
        'title'        => esc_html__( 'Footer Title', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer title', 'front' ),
        'required'     => array(
            array( 'footer_primary_version', 'equals', 'v6' )
        ),
    ),

    array(
        'type'         => 'textarea',
        'id'           => 'footer_primary_description_v6',
        'title'        => esc_html__( 'Footer Description', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer description', 'front' ),
        'required'     => array(
            array( 'footer_primary_version', 'equals', 'v6' )
        ),
    ),

    array(
        'type'         => 'text',
        'id'           => 'footer_primary_description_link_text_v6',
        'title'        => esc_html__( 'Footer Description Link Text', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer description link text', 'front' ),
        'required'     => array(
            array( 'footer_primary_version', 'equals', 'v6' )
        ),
    ),

    array(
        'type'         => 'text',
        'id'           => 'footer_primary_description_link_v6',
        'title'        => esc_html__( 'Footer Description Link', 'front' ),
        'subtitle'     => esc_html__( 'Enter the footer description link', 'front' ),
        'required'     => array(
            array( 'footer_primary_version', 'equals', 'v6' )
        ),
    ),

    array(
        'id'        => 'footer_primary_contact_info_limit',
        'type'      => 'slider',
        'title'     => esc_html__( 'Footer No Of Contact Infos', 'front' ),
        'subtitle'  => esc_html__( 'How many contact info should be shown in footer?', 'front' ),
        'min'       => 1,
        'max'       => apply_filters( 'front_footer_primary_v6_contact_info_max_limit', 10 ),
        'default'   => 2,
        'required'  => array(
            array( 'footer_primary_version', 'equals', 'v6' )
        ),
    ),

    array(
        'id'        => 'footer_contact_block_start',
        'type'      => 'section',
        'indent'    => true,
        'title'     => esc_html__( 'Footer Contact Block', 'front' ),
        'subtitle'  => esc_html__( 'The Footer Contact Block is part of Footer widgets. However it is not available as a separate widget but are fully customizable with the options given below.', 'front' ),
        'required'  => array(
            array( 'footer_default_version', 'equals', 'v10' ),
        ),
    ),

    array(
        'id'        => 'show_footer_contact_block',
        'type'      => 'switch',
        'title'     => esc_html__( 'Show Footer Contact Block', 'front' ),
        'default'   => 1,
    ),

    array(
        'id'        => 'footer_contact_title',
        'type'      => 'text',
        'title'     => esc_html__( 'Contact Block Title', 'front' ),
        'default'   => esc_html__( 'contact us', 'front' ),
        'required'  => array( 'show_footer_contact_block', 'equals', 1 ),
    ),

    array(
        'id'        => 'footer_call_us_number',
        'type'      => 'text',
        'title'     => esc_html__( 'Call us Number', 'front' ),
        'default'   => '+1 (062) 109-9222',
        'required'  => array( 'show_footer_contact_block', 'equals', 1 ),
    ),

    array(
        'id'        => 'footer_mail_address',
        'type'      => 'text',
        'title'     => esc_html__( 'Mail Us', 'front' ),
        'default'    => '<a href="' . esc_url( home_url( '/' ) ) . '">' .  esc_html('support@htmlstream.com') . '</a>',
        'required'  => array( 'show_footer_contact_block', 'equals', 1 ),
    ),

    array(
        'id'        => 'footer_mail_address_url',
        'type'      => 'text',
        'title'     => esc_html__( 'Mail URL', 'front' ),
        'default'   => '#',
        'required'  => array( 'show_footer_contact_block', 'equals', 1 ),
    ),


    array(
        'id'        => 'footer_contact_block_end',
        'type'      => 'section',
        'indent'    => false,
        'required'  => array(
            array( 'footer_default_version', 'equals', 'v10' ),
        ),
    ),
);

$footer_general_fields = array_merge( $footer_options_fields, $footer_options_fields_footer_contact_info );

$footer_options = apply_filters( 'front_footer_options_args', array(
    'title'            => esc_html__( 'Footer', 'front' ),
    'id'               => 'footer',
    'desc'              => esc_html__( 'Options available for your footer. Please note these options will not work on pages that have custom Footer assigned.', 'front' ),
    'customizer_width' => '400px',
    'icon'             => 'far fa-arrow-alt-circle-up',
) );

$footer_general_options = apply_filters( 'front_footer_general_options_args', array(
    'title'            => esc_html__( 'General', 'front' ),
    'id'               => 'footer-general',
    'desc'             => esc_html__( 'Use the options below to set the general behaviour of your website\'s footer', 'front' ),
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => $footer_general_fields
) );

$footer_logo_options = apply_filters( 'front_footer_logo_options_args', array(
    'title'            => esc_html__( 'Logo', 'front' ),
    'id'               => 'footer-logo',
    'desc'             => esc_html__( 'Use the options below to set the logo behaviour of your website\'s footer', 'front' ),
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => $footer_options_fields_footer_logo_section
) );