<?php
/**
 * Redux Framworks hooks
 *
 * @package Fron/ReduxFramework
 */

/**
 * General Hooks
 */
add_action( 'enqueue_block_editor_assets', 'front_redux_remove_custom_css_panel', 99 );

/**
 * General Filters
 */
add_filter( 'front_scroll_to_top_enable', 'front_redux_scroll_to_top_enable' );

/**
 * Header Filters
 */
add_filter( 'front_display_header_args', 'front_redux_apply_header_args', 9 );
add_filter( 'front_header_topbar_cart_view', 'front_redux_apply_header_cart_view_switcher', 10 );
add_filter( 'front_header_topbar_user_account_view', 'front_redux_apply_header_user_account_view_switcher', 10 );
add_filter( 'front_header_topbar_user_account_enable_user_name', 'front_redux_apply_header_user_account_enable_user_name', 10 );

add_filter( 'front_header_fullscreen_modal_address_title', 'front_redux_apply_header_fullscreen_modal_address_title', 10 );
add_filter( 'front_header_fullscreen_modal_address_lines', 'front_redux_apply_header_fullscreen_modal_address_lines', 10 );
add_filter( 'front_header_fullscreen_modal_social_links_title', 'front_redux_apply_header_fullscreen_modal_social_links_title', 10 );

add_filter( 'front_search_push_top_static_content_id', 'front_redux_apply_search_push_top_static_content_id', 10 );

add_filter( 'front_header_topbar_search_enable', 'front_redux_toggle_header_search_enable', 10 );
add_filter( 'front_header_topbar_cart_enable', 'front_redux_toggle_header_mini_cart_enable', 10 );
add_filter( 'front_header_header_user_account_enable', 'front_redux_toggle_header_user_account_enable', 10 );

/**
 * Header My Account Form Filters
 */
add_filter( 'front_user_account_not_login_text', 'front_redux_apply_user_account_not_login_text', 10 );
add_filter( 'front_user_account_not_login_description', 'front_redux_apply_user_account_not_login_description', 10 );

add_filter( 'front_user_account_register_text', 'front_redux_apply_user_account_register_text', 10 );
add_filter( 'front_user_account_register_description', 'front_redux_apply_user_account_register_description', 10 );

add_filter( 'front_user_account_recover_password_text', 'front_redux_apply_user_account_recover_password_text', 10 );
add_filter( 'front_user_account_recover_password_description', 'front_redux_apply_user_account_recover_password_description', 10 );

/**
 * My Account Form Filters
 */
add_filter( 'front_my_account_login_form_title', 'front_redux_apply_my_account_login_form_title', 10 );
add_filter( 'front_my_account_login_form_desc', 'front_redux_apply_my_account_login_form_desc', 10 );

add_filter( 'front_my_account_register_form_title', 'front_redux_apply_my_account_register_form_title', 10 );
add_filter( 'front_my_account_register_form_desc', 'front_redux_apply_my_account_register_form_desc', 10 );

add_filter( 'front_woocommerce_lost_password_form_title', 'front_redux_apply_woocommerce_lost_password_form_title', 10 );
add_filter( 'front_woocommerce_lost_password_message', 'front_redux_apply_woocommerce_lost_password_message', 10 );

/**
 * Footer Filters
 */
add_filter( 'front_enable_seperate_footer_logo', 'front_redux_toggle_separate_footer_logo', 10 );
add_filter( 'front_separate_footer_logo', 'front_redux_apply_separate_footer_logo', 10 );
add_filter( 'front_use_footer_svg_logo_light', 'front_redux_toggle_svg_logo_light', 10 );
add_filter( 'front_footer_site_description', 'front_redux_apply_footer_site_description', 10 );
add_filter( 'front_footer_style', 'front_redux_apply_footer_style', 9 );
add_filter( 'front_footer_version', 'front_redux_apply_footer_version', 9 );

add_filter( 'front_footer_copyright_text', 'front_redux_apply_footer_copyright_text', 20 );
add_filter( 'front_footer_default_13_button_text', 'front_redux_apply_footer_default_13_button', 30 );
add_filter( 'front_footer_default_13_button_url', 'front_redux_apply_footer_default_13_button_url', 30 );
add_filter( 'front_enable_footer_static_block', 'front_redux_toggle_footer_static_block', 30 );
add_filter( 'front_footer_static_block_id', 'front_redux_apply_footer_static_block_id', 30 );

add_filter( 'front_primary_footer_v2_goto_icon_class', 'front_redux_apply_primary_footer_v2_goto_icon_class', 10 );

add_filter( 'front_footer_primary_v6_form', 'front_redux_apply_primary_footer_primary_v6_form', 10 );
add_filter( 'front_footer_title_primary_v6', 'front_redux_apply_primary_footer_title_v6', 10 );
add_filter( 'front_footer_description_primary_v6', 'front_redux_apply_primary_footer_description_v6', 10 );
add_filter( 'front_footer_description_link_text_primary_v6', 'front_redux_apply_primary_footer_description_link_text_v6', 10 );
add_filter( 'front_footer_description_link_primary_v6', 'front_redux_apply_primary_footer_description_link_v6', 10 );
add_filter( 'front_footer_primary_v6_contact_info_limit', 'front_redux_apply_primary_footer_v6_contact_info_limit', 10 );
add_filter( 'front_footer_primary_v6_contact_info', 'front_redux_apply_primary_footer_contact_info', 10 );
add_filter( 'front_enable_bg_primary_v3', 'front_redux_apply_enable_bg_primary_v3', 10 );

add_filter( 'front_footer_contact_us',                  'front_redux_toggle_footer_contact_block',          40 );
add_filter( 'front_contact_block_title',            'front_redux_apply_footer_contact_block_title',         40 );
add_filter( 'front_footer_contact_number',          'front_redux_apply_footer_contact_block_number',            40 );
add_filter( 'front_footer_contact_support_address', 'front_redux_apply_footer_contact_block_mail',          40 );
add_filter( 'front_footer_contact_support_address_link',    'front_redux_apply_footer_contact_block_mail_url',          40 );

/*
 * Blog Theme Options and Hooks
 */
add_filter( 'front_single_post_style', 'front_redux_toggle_single_post_style', 10 );
add_filter( 'front_before_footer_static_content_id', 'front_redux_footer_blog_before_static_content_id', 10 );
add_filter( 'front_blog_layout', 'front_redux_change_front_blog_layout', 10 );
add_filter( 'front_blog_view', 'front_redux_change_front_blog_view', 10 );
add_filter( 'front_single_post_tags_enabled', 'front_redux_toggle_single_post_tags', 10 );
add_filter( 'front_single_post_share_enabled', 'front_redux_toggle_single_post_share', 10 );
add_filter( 'front_single_post_author_enabled', 'front_redux_toggle_single_post_author_info', 10 );
add_filter( 'front_single_post_nav_enabled', 'front_redux_toggle_single_post_navigation', 10 );
add_filter( 'front_single_related_posts_enabled', 'front_redux_toggle_single_post_related_posts', 10 );
add_filter( 'front_header_static_content_id', 'front_redux_single_post_header_static_block', 10 );

/*
 * Shop Header & Footer
 */
add_filter( 'front_header_static_content_id',               'front_redux_shop_header_static_block', 10 );
add_filter( 'front_footer_static_content_id',               'front_redux_shop_footer_static_block', 10 );

/*
 * Shop Filters
 */
add_filter( 'front_shop_jumbotron_id',                      'redux_apply_shop_jumbotron_id',                10 );
add_filter( 'front_shop_layout',                            'front_redux_change_shop_layout',               10 );
add_filter( 'front_get_shop_views_args',                    'redux_set_shop_view_args',                     10 );
add_filter( 'front_enable_related_products',                'redux_toggle_related_products_output',         10 );
add_filter( 'front_enable_cart_feature_list',               'redux_toggle_single_product_features_output',  10 );
add_filter( 'front_features_section_args',                  'redux_apply_single_product_feature',           10 );
add_filter( 'front_single_product_static_content_id',       'redux_apply_single_product_jumbotron_id',                10 );

/**
 * Portfolio Header & Footer
 */
add_filter( 'front_header_static_content_id',               'front_redux_portfolio_header_static_block', 10 );
add_filter( 'front_footer_static_content_id',               'front_redux_portfolio_footer_static_block', 10 );

/**
 * Portfolio General
 */
add_filter( 'front_portfolio_view', 'front_redux_change_portfolio_view', 10 );
add_filter( 'front_portfolio_layout', 'front_redux_change_portfolio_layout', 10 );
add_filter( 'front_portfolio_posts_per_page', 'front_redux_apply_portfolio_posts_per_page', 10 );
add_filter( 'front_portfolio_enable_filters', 'front_redux_toggle_portfolio_filters_enable', 10 );
add_filter( 'front_portfolio_enable_author', 'front_redux_toggle_portfolio_author_enable', 10 );
add_filter( 'front_portfolio_post_excerpt_enable', 'front_redux_toggle_portfolio_content_enable', 10 );

/*
 * Portfolio Hero
 */
add_filter( 'front_portfolio_enable_hero', 'front_redux_toggle_portfolio_hero_enable', 10 );
add_filter( 'front_portfolio_hero_title', 'front_redux_change_portfolio_hero_title', 10 );
add_filter( 'front_portfolio_hero_subtitle', 'front_redux_change_portfolio_hero_subtitle', 10 );

/*
 * Portfolio Related Works
 */
add_filter( 'front_portfolio_enable_related_works', 'front_redux_toggle_portfolio_related_works', 10 );

add_filter( 'front_portfolio_related_works_pretitle_enable', 'front_redux_toggle_portfolio_related_works_pretitle_enable', 10 );
add_filter( 'front_portfolio_related_works_pretitle', 'front_redux_change_portfolio_related_works_pretitle', 10 );
add_filter( 'front_portfolio_related_works_pretitle_color', 'front_redux_toggle_portfolio_related_works_pretitle_color', 10 );

add_filter( 'front_portfolio_related_works_title', 'front_redux_change_portfolio_related_works_title', 10 );
add_filter( 'front_portfolio_related_works_subtitle', 'front_redux_change_portfolio_related_works_subtitle', 10 );
add_filter( 'front_portfolio_related_works_view', 'front_redux_change_portfolio_related_works_view', 10 );

add_filter( 'front_portfolio_enable_author', 'front_redux_toggle_portfolio_realated_works_author_enable', 20 );
add_filter( 'front_portfolio_post_excerpt_enable', 'front_redux_toggle_portfolio_realated_works_content_enable', 20 );

/*
 * Portfolio Contact
 */
add_filter( 'front_portfolio_enable_contact', 'front_redux_toggle_portfolio_contact', 10 );
add_filter( 'front_portfolio_contact_section_title', 'front_redux_change_portfolio_contact_title', 10 );
add_filter( 'front_portfolio_contact_email', 'front_redux_change_portfolio_contact_email', 10 );
add_filter( 'front_portfolio_contact_sm_menu_id', 'front_redux_change_portfolio_contact_sm_menu_id', 10 );
add_filter( 'front_portfolio_contact_phone', 'front_redux_change_portfolio_contact_phone', 10 );
add_filter( 'front_portfolio_enable_static_content_block', 'front_redux_toggle_portfolio_static_content', 10 );
add_filter( 'front_portfolio_static_block_id', 'front_redux_portfolio_static_content', 10 );

/*
 * Job Header & Footer
 */
add_filter( 'front_header_static_content_id',               'front_redux_job_header_static_block', 10 );
add_filter( 'front_footer_static_content_id',               'front_redux_job_footer_static_block', 10 );

/*
 * Docs Header & Footer
 */
add_filter( 'front_header_static_content_id',               'front_redux_docs_header_static_block', 10 );
add_filter( 'front_footer_static_content_id',               'front_redux_docs_footer_static_block', 10 );

/*
 * Customer Story Header & Footer
 */
add_filter( 'front_header_static_content_id',               'front_redux_customer_story_header_static_block', 10 );
add_filter( 'front_footer_static_content_id',               'front_redux_customer_story_footer_static_block', 10 );

/*
 * Customer Story Single
 */
add_filter( 'front_single_customer_story_bg_image',         'front_redux_customer_story_single_bg_img',          10 );
add_filter( 'front_single_customer_story_enable_pretitle',  'front_redux_customer_story_single_enable_pretitle', 10 );
add_filter( 'front_single_customer_story_pretitle',         'front_redux_customer_story_single_pretitle',        10 );

/*
 * 404 Page Filters
 */
add_filter( 'front_header_static_content_id',               'front_redux_404_page_header_static_block',     10 );
add_filter( 'front_404_bg_image',                           'redux_apply_404_bg_img',                       10 );
add_filter( 'front_404_page_args',                          'redux_apply_404_page_args',                    10 );

/*
 * Style Filters
 */
add_filter( 'front_use_predefined_colors',                  'redux_toggle_use_predefined_colors',           10 );
// add_action( 'front_primary_color',                          'redux_apply_primary_color',                    10 );
add_filter( 'front_custom_primary_color',                   'redux_apply_custom_primary_color',             10 );
add_action( 'wp_enqueue_scripts',                           'redux_apply_custom_color_css',               	20 );
add_action( 'enqueue_block_assets',                         'redux_get_custom_color_admin_css',             10 );
add_filter( 'front_editor_color_palette_options',           'redux_apply_custom_editor_color_palette_options', 10 );
add_filter( 'redux/options/' . Front_Options::get_option_name() . '/compiler', 'redux_apply_compiler_action', 10, 3 );
add_filter( 'pre_http_request',                             'redux_apply_block_editor_custom_color_css',    10, 3 );
