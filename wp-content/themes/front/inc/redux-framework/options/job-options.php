<?php
/**
 * Options available for 404 Page of Theme Options
 * 
 */
$job_options = apply_filters( 'front_job_options_args', array(
    'title'            => esc_html__( 'Jobs', 'front' ),
    'desc'             => esc_html__( 'Options available for your jobs', 'front' ),
    'id'               => 'job',
    'customizer_width' => '400px',
    'icon'             => 'fas fa-briefcase'
) );

$job_header_options = apply_filters( 'front_job_header_options_args', array(
    'title'            => esc_html__( 'Header', 'front' ),
    'id'               => 'job-header',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_job_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for job', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for job ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_job_static_block_id',
            'title'     => esc_html__( 'Job Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for job', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_job_header', 'equals', 1 ),
        ),

        array(
            'id'        => 'enable_separate_single_job_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for single job', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for single job ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_single_job_static_block_id',
            'title'     => esc_html__( 'Job Single Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for single job', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_single_job_header', 'equals', 1 ),
        ),
    )
) );

$job_footer_options = apply_filters( 'front_job_footer_options_args', array(
    'title'            => esc_html__( 'Footer', 'front' ),
    'id'               => 'job-footer',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_job_footer',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate footer for job', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate footer for job ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'footer_job_static_block_id',
            'title'     => esc_html__( 'Job Footer', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block footer for job', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_job_footer', 'equals', 1 ),
        ),
    )
) );