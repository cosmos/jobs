<?php
/**
 * Options available for docs Page of Theme Options
 * 
 */
$docs_options = apply_filters( 'front_docs_options_args', array(
    'title'            => esc_html__( 'Docs', 'front' ),
    'desc'             => esc_html__( 'Options available for your docs', 'front' ),
    'id'               => 'docs',
    'customizer_width' => '400px',
    'icon'             => 'fas fa-file'
) );

$docs_header_options = apply_filters( 'front_docs_header_options_args', array(
    'title'            => esc_html__( 'Header', 'front' ),
    'id'               => 'docs-header',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_docs_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for docs', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for docs ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_docs_static_block_id',
            'title'     => esc_html__( 'Docs Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for docs', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_docs_header', 'equals', 1 ),
        ),
    )
) );

$docs_footer_options = apply_filters( 'front_docs_footer_options_args', array(
    'title'            => esc_html__( 'Footer', 'front' ),
    'id'               => 'docs-footer',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_docs_footer',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate footer for docs', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate footer for docs ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'footer_docs_static_block_id',
            'title'     => esc_html__( 'Docs Footer', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block footer for docs', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_docs_footer', 'equals', 1 ),
        ),
    )
) );