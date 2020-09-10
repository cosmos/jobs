<?php
/**
 * Options available for Typography sub menu of Theme Options
 * 
 */

$typography_options     = apply_filters( 'front_typography_options_args', array(
    'title'            => esc_html__( 'Typography', 'front' ),
    'desc'             => esc_html__( 'Typography Options available in theme', 'front' ),
    'id'               => 'typography',
    'customizer_width' => '400px',
    'icon'             => 'fas fa-font',
    'fields'    => array(
        array(
            'title'         => esc_html__( 'Use default font scheme ?', 'front' ),
            'on'            => esc_html__('Yes', 'front'),
            'off'           => esc_html__('No', 'front'),
            'type'          => 'switch',
            'default'       => true,
            'id'            => 'use_predefined_font',
        ),

        array(
            'title'         => esc_html__( 'Title Font Family', 'front' ),
            'type'          => 'typography',
            'id'            => 'custom_title_font',
            'google'        => true,
            'font-weight'   => false,
            'text-align'    => false,
            'font-style'    => false,
            'font-size'     => false,
            'line-height'   => false,
            'color'         => false,
            'output'        => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ),
            'default'       => array(
                'font-family'   => 'Poppins',
                'subsets'       => 'latin',
            ),
            'required'      => array( 'use_predefined_font', 'equals', false ),
        ),

        array(
            'title'         => esc_html__( 'Content Font Family', 'front' ),
            'type'          => 'typography',
            'id'            => 'custom_body_font',
            'google'        => true,
            'text-align'    => false,
            'font-style'    => false,
            'font-size'     => false,
            'line-height'   => false,
            'color'         => false,
            'output'        => array( 'body' ),
            'default'       => array(
                'font-family'   => 'Poppins',
                'subsets'       => 'latin',
            ),
            'required'      => array( 'use_predefined_font', 'equals', false ),
        ),
    )
) );