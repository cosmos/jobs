<?php
/**
 * Options available for 404 Page of Theme Options
 * 
 */
$error_page_options   = apply_filters( 'front_error_page_args', array(
    'title'     => esc_html__( '404 Page', 'front' ),
    'icon'      => 'fas fa-search',
    'fields'    => array(
        array(
            'id'        => 'enable_separate_404_page_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for 404 page', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for 404 page ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_404_page_static_block_id',
            'title'     => esc_html__( '404 Page Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for 404 page', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_404_page_header', 'equals', 1 ),
        ),

        array(
            'title'     => esc_html__( 'Background Image', 'front' ),
            'subtitle'  => esc_html__( 'Upload your 404 page background image.', 'front' ),
            'id'        => 'page_404_bg_img',
            'type'      => 'media',
        ),

        array(
            'title'     => esc_html__( 'Page Title', 'front' ),
            'id'        => '404_page_page_title',
            'type'      => 'text',
            'default'   => wp_kses_post( __( 'Page not <span class="font-weight-semi-bold">found</span>', 'front' ) ),
        ),

        array(
            'title'     => esc_html__( 'Sub Title', 'front' ),
            'id'        => '404_page_sub_titles',
            'type'      => 'multi_text',
            'default'   => array(
                wp_kses_post( __( 'Oops! Looks like you followed a bad link', 'front' ) ),
                wp_kses_post( __( 'If you think this is a problem with us, please <a href="#">tell us</a>.', 'front' ) ),
            ),
        ),

        array(
            'title'     => esc_html__( 'Button Text', 'front' ),
            'id'        => '404_page_contact_text',
            'type'      => 'text',
            'default'   => esc_html__( 'Go Back', 'front'),
        ),

        array(
            'title'     => esc_html__( 'Button Link', 'front' ),
            'id'        => '404_page_contact_link',
            'type'      => 'text',
            'default'   => home_url( '/' ),
        ),
    )
) );