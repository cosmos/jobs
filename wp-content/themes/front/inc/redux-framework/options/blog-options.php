<?php

$blog_options   = apply_filters( 'front_blog_options_args', array(
    'title'            => esc_html__( 'Blog', 'front' ),
    'desc'             => esc_html__( 'Options available for your Blog, Single Post and Post Archive pages', 'front' ),
    'id'               => 'blog',
    'customizer_width' => '400px',
    'icon'             => 'fas fa-blog'
) );

$blog_general_options   = apply_filters( 'front_blog_general_options_args', array(
    'title'            => esc_html__( 'General', 'front' ),
    'id'               => 'blog-general',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'type'         => 'select',
            'id'           => 'front_blog_view',
            'title'        => esc_html__( 'Style', 'front' ),
            'subtitle'     => esc_html__( 'Select your Blog style', 'front' ),
            'options'      => array(
                'classic'      => esc_html__( 'Classic', 'front' ),
                'grid'         => esc_html__( 'Grid',    'front' ),
                'list'         => esc_html__( 'List',    'front' ),
                'masonry'      => esc_html__( 'Masonry', 'front' ),
                'modern'       => esc_html__( 'Modern',  'front' ),
            ),
            'default'      => 'grid'
        ),

        array(
            'type'         => 'select',
            'id'           => 'front_blog_layout',
            'title'        => esc_html__( 'Layout', 'front' ),
            'subtitle'     => esc_html__( 'Select your Blog layout', 'front' ),
            'options'      => array(
                'sidebar-right'     => esc_html__( 'Right Sidebar', 'front' ),
                'sidebar-left'      => esc_html__( 'Left Sidebar',  'front' ),
                'full-width'        => esc_html__( 'Fullwidth',     'front' ),
            ),
            'default'      => 'full-width'
        ),
    )
) );

$blog_single_post_options   = apply_filters( 'front_blog_single_post_options_args', array(
    'title'            => esc_html__( 'Single Post', 'front' ),
    'id'               => 'blog-single-post',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'type'         => 'select',
            'id'           => 'single_post_style',
            'title'        => esc_html__( 'Style', 'front' ),
            'subtitle'     => esc_html__( 'Select the style for single post', 'front' ),
            'options'      => array(
                'classic'      => esc_html__( 'Classic', 'front' ),
                'simple'       => esc_html__( 'Simple',  'front' ),
            ),
            'default'      => 'classic'
        ),

        array(
            'id'        => 'enable_classic_single_post_tags',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Tags', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to enable tags in Single Post ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 1,
            'required'  => array( 'single_post_style', 'equals', 'classic' )
        ),

        array(
            'id'        => 'enable_classic_single_post_share',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Sharing', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to enable share block in Single Post ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 1,
            'required'  => array( 'single_post_style', 'equals', 'classic' )
        ),

        array(
            'id'        => 'enable_classic_single_post_author_info',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Author Info', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to enable author info block in Single Post ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 1,
        ),

        array(
            'id'        => 'enable_classic_single_post_navigation',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Single Post Navigation', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to enable post navigation in Single Post ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
            'required'  => array( 'single_post_style', 'equals', 'classic' )
        ),

        array(
            'id'        => 'enable_classic_single_post_related_posts',
            'type'      => 'switch',
            'title'     => esc_html__( 'Enable Related Posts', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to enable related posts in Single Post ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 1,
        ),

        array(
            'id'        => 'footer_before_static_block_id',
            'title'     => esc_html__( 'Footer Before Content', 'front' ),
            'subtitle'  => esc_html__( 'Choose a Static Block to display above footer in Single Blog Post', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
        ),

        array(
            'id'        => 'enable_separate_single_post_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for single post', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for single post ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_single_post_static_block_id',
            'title'     => esc_html__( 'Single Post Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for single post', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_single_post_header', 'equals', 1 ),
        ),
    )
) );