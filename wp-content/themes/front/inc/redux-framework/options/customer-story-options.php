<?php
/**
 * Options available for customer story Page of Theme Options
 * 
 */
$customer_story_options = apply_filters( 'front_customer_story_options_args', array(
    'title'            => esc_html__( 'Customer Story', 'front' ),
    'desc'             => esc_html__( 'Options available for your customer stories', 'front' ),
    'id'               => 'customer-story',
    'customizer_width' => '400px',
    'icon'             => 'fas fa-user'
) );

$customer_story_header_options = apply_filters( 'front_customer_story_header_options_args', array(
    'title'            => esc_html__( 'Header', 'front' ),
    'id'               => 'customer-story-header',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_customer_story_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for customer stories', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for customer stories ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_customer_story_static_block_id',
            'title'     => esc_html__( 'Customer Story Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for customer stories', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_customer_story_header', 'equals', 1 ),
        ),
    )
) );

$customer_story_single_options = apply_filters( 'front_customer_story_single_options_args', array(
    'title'            => esc_html__( 'Single', 'front' ),
    'id'               => 'customer-story-single',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'customer_story_single_enable_pretitle',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Customer Story Single Pretitle', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a Customer Story Single Pretitle ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 1,
        ),

        array(
            'id'       => 'customer_story_single_pretitle',
            'type'     => 'text',
            'title'    => __('Customer Story Single Pretitle Text', 'front'),
            'subtitle' => __('Enter the customer story single Pretitle Text', 'front'),
            'default'  =>  __('Customer success story', 'front'),
            'required' => array( 'customer_story_single_enable_pretitle', 'equals', 1 ),
        ),

        array(
            'id'        => 'customer_story_single_bg_img',
            'type'      => 'media',
            'title'     => esc_html__( 'Customer Story Single Background Image', 'front' ),
            'subtitle'  => esc_html__( 'Upload your customer story single page background image.', 'front' ),
        ),
    )
) );

$customer_story_footer_options = apply_filters( 'front_customer_story_footer_options_args', array(
    'title'            => esc_html__( 'Footer', 'front' ),
    'id'               => 'customer-story-footer',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_customer_story_footer',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate footer for customer stories', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate footer for customer stories ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'footer_customer_story_static_block_id',
            'title'     => esc_html__( 'Customer Story Footer', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block footer for customer stories', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_customer_story_footer', 'equals', 1 ),
        ),
    )
) );