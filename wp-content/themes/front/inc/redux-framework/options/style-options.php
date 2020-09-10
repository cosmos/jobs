<?php
/**
 * Options available for Styling sub menu of Theme Options
 *
 */

if( is_child_theme() && redux_apply_custom_color_css_external_file() ) {
    $include_custom_color = array(
        'id'          => 'include_custom_color',
        'title'       => esc_html__( 'How to include custom color ?', 'front' ),
        'type'        => 'radio',
        'compiler'    => true,
        'options'     => array(
            '1'  => esc_html__( 'Inline', 'front' ),
            '2'  => esc_html__( 'External File', 'front' )
        ),
        'default'     => '1',
        'required'    => array( 'use_predefined_color', 'equals', 0 ),
    );
} else {
    $include_custom_color = array(
        'id'        => 'external_file_css_info',
        'type'      => 'raw',
        'title'     => esc_html__( 'Custom Primary Color CSS', 'front' ),
        'content'   => esc_html__( 'Please activate child theme to load custom color CSS using "External File". Also you need to make custom-color.css file writable.', 'front' ),
        'required'  => array( 'use_predefined_color', 'equals', 0 ),
    );
}

$style_options  = apply_filters( 'front_style_options_args', array(
    'title'     => esc_html__( 'Styling', 'front' ),
    'icon'      => 'fas fa-edit',
    'fields'    => array(
        array(
            'id'        => 'styling_general_info_start',
            'type'      => 'section',
            'title'     => esc_html__( 'General', 'front' ),
            'subtitle'  => esc_html__( 'General Theme Style Settings', 'front' ),
            'indent'    => true,
        ),

        array(
            'title'     => esc_html__( 'Use a predefined color scheme', 'front' ),
            'on'        => esc_html__('Yes', 'front'),
            'off'       => esc_html__('No', 'front'),
            'type'      => 'switch',
            'default'   => 1,
            'id'        => 'use_predefined_color'
        ),

        // array(
        //     'title'     => esc_html__( 'Main Theme Color', 'front' ),
        //     'subtitle'  => esc_html__( 'The main color of the site.', 'front' ),
        //     'id'        => 'main_color',
        //     'type'      => 'select',
        //     'options'   => array(
        //         'blue'      => esc_html__( 'Blue', 'front' ),
        //     ),
        //     'default'   => 'blue',
        //     'required'  => array( 'use_predefined_color', 'equals', 1 ),
        // ),

        array(
            'id'          => 'custom_primary_color',
            'title'       => esc_html__( 'Custom Primary Color', 'front' ),
            'type'        => 'color',
            'compiler'    => true,
            'transparent' => false,
            'default'     => '#377dff',
            'required'    => array( 'use_predefined_color', 'equals', 0 ),
        ),

        array(
            'id'          => 'custom_secondary_color',
            'title'       => esc_html__( 'Custom Secondary Color', 'front' ),
            'type'        => 'color',
            'compiler'    => true,
            'transparent' => false,
            'default'     => '#77838f',
            'required'    => array( 'use_predefined_color', 'equals', 0 ),
        ),

        array(
            'id'          => 'custom_gradient_half_indigo_color',
            'title'       => esc_html__( 'Custom Indigo Gradient Color', 'front' ),
            'type'        => 'color',
            'compiler'    => true,
            'transparent' => false,
            'default'     => '#2d1582',
            'required'    => array( 'use_predefined_color', 'equals', 0 ),
        ),

        array(
            'id'          => 'custom_gradient_half_info_color',
            'title'       => esc_html__( 'Custom Info Gradient Color', 'front' ),
            'type'        => 'color',
            'compiler'    => true,
            'transparent' => false,
            'default'     => '#00dffc',
            'required'    => array( 'use_predefined_color', 'equals', 0 ),
        ),

        array(
            'id'          => 'custom_gradient_half_warning_color',
            'title'       => esc_html__( 'Custom Warning Gradient Color', 'front' ),
            'type'        => 'color',
            'compiler'    => true,
            'transparent' => false,
            'default'     => '#ffc107',
            'required'    => array( 'use_predefined_color', 'equals', 0 ),
        ),

        array(
            'id'          => 'custom_gradient_half_danger_color',
            'title'       => esc_html__( 'Custom Danger Gradient Color', 'front' ),
            'type'        => 'color',
            'compiler'    => true,
            'transparent' => false,
            'default'     => '#de4437',
            'required'    => array( 'use_predefined_color', 'equals', 0 ),
        ),

        array(
            'id'          => 'custom_gradient_overlay_half_white_color',
            'title'       => esc_html__( 'Custom White Gradient Color', 'front' ),
            'type'        => 'color',
            'compiler'    => true,
            'transparent' => false,
            'default'     => '#ffffff',
            'required'    => array( 'use_predefined_color', 'equals', 0 ),
        ),

        array(
            'id'          => 'custom_gradient_overlay_half_dark_color',
            'title'       => esc_html__( 'Custom Dark Gradient Color', 'front' ),
            'type'        => 'color',
            'compiler'    => true,
            'transparent' => false,
            'default'     => '#1e2022',
            'required'    => array( 'use_predefined_color', 'equals', 0 ),
        ),

        $include_custom_color,

        array(
            'id'        => 'styling_general_info_end',
            'type'      => 'section',
            'indent'    => false,
        ),
    )
) );
