<?php
/**
 * Options available for Shop sub menu of Theme Options
 * 
 */
$shop_options   = apply_filters( 'front_shop_options_args', array(
    'title'            => esc_html__( 'Shop', 'front' ),
    'desc'             => esc_html__( 'Options available for your shop', 'front' ),
    'id'               => 'shop',
    'customizer_width' => '400px',
    'icon'             => 'fas fa-shopping-cart'
) );

$shop_header_options = apply_filters( 'front_shop_header_options_args', array(
    'title'            => esc_html__( 'Header', 'front' ),
    'id'               => 'shop-header',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_shop_header',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate header for shop', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate header for shop ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'header_shop_static_block_id',
            'title'     => esc_html__( 'Shop Header', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block header for shop', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_shop_header', 'equals', 1 ),
        ),
    )
) );

$shop_footer_options = apply_filters( 'front_shop_footer_options_args', array(
    'title'            => esc_html__( 'Footer', 'front' ),
    'id'               => 'shop-footer',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_separate_shop_footer',
            'type'      => 'switch',
            'title'     => esc_html__( 'Use separate footer for shop', 'front' ),
            'subtitle'  => esc_html__( 'Do you want to display a separate footer for shop ?', 'front' ),
            'on'        => esc_html__( 'Yes', 'front' ),
            'off'       => esc_html__( 'No', 'front' ),
            'default'   => 0,
        ),

        array(
            'id'        => 'footer_shop_static_block_id',
            'title'     => esc_html__( 'Shop Footer', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block footer for shop', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            ),
            'required'  => array( 'enable_separate_shop_footer', 'equals', 1 ),
        ),
    )
) );

$shop_general_options = apply_filters( 'front_shop_general_options_args', array(
    'title'            => esc_html__( 'General', 'front' ),
    'id'               => 'shop-general',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'shop_jumbotron_id',
            'title'     => esc_html__( 'Shop Page Jumbotron', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block that will be the jumbotron element for shop page', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            )
        ),

        array(
            'type'     => 'select',
            'id'       => 'shop_layout',
            'title'    => esc_html__( 'Shop Layout', 'front' ),
            'subtitle' => esc_html__( 'Select from the two available layouts for shop', 'front' ),
            'options'      => array(
                'sidebar-right'     => esc_html__( 'Right Sidebar', 'front' ),
                'sidebar-left'      => esc_html__( 'Left Sidebar',  'front' ),
                'full-width'        => esc_html__( 'Fullwidth',     'front' ),    
            ),
            'default'      => 'sidebar-right'
        ),

        array(
            'id'        => 'product_archive_enabled_views',
            'type'      => 'sorter',
            'title'     => esc_html__( 'Product archive views', 'front' ),
            'subtitle'  => esc_html__( 'Please drag and arrange the views. Top most view will be the default view', 'front' ),
            'options'   => array(
                'enabled' => array(
                    'grid'            => esc_html__( 'Grid', 'front' ),
                    'list'           => esc_html__( 'List', 'front' ),
                ),
                'disabled' => array()
            )
        ),
    )
) );

$shop_product_single_options = apply_filters( 'front_shop_product_single_options_args', array(
    'title'            => esc_html__( 'Single Product', 'front' ),
    'id'               => 'shop-product-single',
    'subsection'       => true,
    'customizer_width' => '450px',
    'fields'           => array(
        array(
            'id'        => 'enable_related_products',
            'title'     => esc_html__( 'Enable Related Products', 'front' ),
            'type'      => 'switch',
            'default'   => 1,
        ),

        array(
            'id'        => 'single_product_jumbotron_id',
            'title'     => esc_html__( 'Single Product Before Footer Content', 'front' ),
            'subtitle'  => esc_html__( 'Choose a static block that will be the jumbotron element for single product page', 'front' ),
            'type'      => 'select',
            'data'      => 'posts',
            'args'      => array(
                'post_type'         => 'mas_static_content',
                'posts_per_page'    => -1,
            )
        ),

        array(
            'id'        => 'single_product_features_show',
            'title'     => esc_html__( 'Show Single Product Features List', 'front' ),
            'type'      => 'switch',
            'default'   => 1,
        ),

        array(
            'id'        => 'single_product_feature_list_icon',
            'title'     => esc_html__('Feature List Icon', 'front'),
            'subtitle'  => esc_html__('Upload Image', 'front'),
            'type'      => 'multi_text',
            'default'   => array(
                esc_html__( 'fgb-icon-65', 'front' ),
                esc_html__( 'fgb-icon-64', 'front' ),
            ),
            'required'  => array( 'single_product_features_show', 'equals', 1 ),

        ),

        array(
            'id'        => 'single_product_feature_list_title',
            'type'      => 'multi_text',
            'title'     => esc_html__('Feature List Title', 'front'),
            'subtitle'  => esc_html__('Add Title', 'front'),
            'default'   => array(
                esc_html__( 'Free Shipping', 'front' ),
                esc_html__( '30 Days return', 'front' ),
            ),
            'required'  => array( 'single_product_features_show', 'equals', 1 )
        ),

        array(
            'id'        => 'single_product_feature_list_text',
            'type'      => 'multi_text',
            'title'     => esc_html__('Feature List Text', 'front'),
            'subtitle'  => esc_html__('Add Description', 'front'),
            'default'   => array(
                esc_html__( 'We offer free shipping anywhere in the U.S. A skilled delivery team will bring the boxes into your office.', 'front' ),
                esc_html__( 'We offer free shipping anywhere in the U.S. A skilled delivery team will bring the boxes into your office.', 'front' ),
            ),
            'required'  => array( 'single_product_features_show', 'equals', 1 )
        ),
    )
) );