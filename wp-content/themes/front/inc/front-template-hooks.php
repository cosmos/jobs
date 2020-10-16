<?php
/**
 * Front hooks
 *
 * @package front
 */

add_filter( 'get_the_archive_title', 'front_get_the_archive_title', 10 );
add_filter( 'excerpt_more', 'front_excerpt_more', 10 );
add_filter( 'term_links-post_tag', 'front_tag_style_term_links', 10 );

/**
 * Protected Post Custom Password Form
 */
add_filter( 'the_password_form', 'front_post_protected_password_form' );

/**
 * Nav Menu Widget Handle Custom Fields
 */
add_filter( 'in_widget_form', 'front_custom_widget_nav_menu_options', 10, 3 );
add_filter( 'widget_update_callback', 'front_custom_widget_nav_menu_options_update', 10, 4 );
add_filter( 'widget_nav_menu_args', 'front_custom_widget_nav_menu_args', 20, 4 );

/**
 * Header
 */
add_action( 'front_before_header_content', 'front_search_push_top', 10 );
add_action( 'front_header', 'front_header', 20 );

add_action( 'front_topbar_left', 'front_topbar_language_links_left', 10 );
add_action( 'front_topbar_left', 'front_topbar_links_left', 20 );

add_action( 'front_topbar_right', 'front_topbar_links_mobile', 10 );
add_action( 'front_topbar_right', 'front_topbar_links_right', 20 );
add_action( 'front_topbar_icons', 'front_topbar_search_icon', 10 );
add_action( 'front_topbar_icons', 'front_header_user_account', 30 );

/**
 * Popup & Sidebar Header User Account
 */
add_action( 'wp_footer', 'front_header_user_account_modal_popup', 996 );
add_action( 'wp_footer', 'front_header_user_account_content_sidebar', 997 );

add_action( 'front_navbar_content', 'front_navbar_brand', 10 );
add_action( 'front_navbar_content', 'front_navbar_toggler', 20 );
add_action( 'front_navbar_content', 'front_navbar_nav', 30 );

/**
 * Footer
 */
add_action( 'front_before_footer', 'front_before_footer_static_content', 20 );
add_action( 'front_footer', 'front_footer', 20 );

add_filter( 'front_footer_style', 'front_get_default_footer_style', 10 );
add_filter( 'front_footer_version', 'front_get_default_footer_version', 10 );

/**
 * Blog Classic
 */
add_action( 'front_blog_classic_loop_after', 'front_blog_list_pagination_spacing', 10 );
add_action( 'front_blog_classic_loop_after', 'front_paging_nav', 20 );

/**
 * Blog Grid
 */
add_action( 'front_blog_grid_loop_after', 'front_blog_list_pagination_spacing', 10 );
add_action( 'front_blog_grid_loop_after', 'front_paging_nav', 20 );

/**
 * Blog List
 */
add_action( 'front_blog_list_loop_post', 'front_blog_list_post_thumbnail', 10 );
add_action( 'front_blog_list_loop_post', 'front_blog_list_post_body', 20 );
add_action( 'front_blog_list_loop_after', 'front_blog_list_pagination_spacing', 10 );
add_action( 'front_blog_list_loop_after', 'front_paging_nav', 20 );

/**
 * Blog Modern
 */
add_action( 'front_blog_modern_loop_after', 'front_blog_list_pagination_spacing', 10 );
add_action( 'front_blog_modern_loop_after', 'front_paging_nav', 20 );

/**
 * Blog Masonry
 */
add_action( 'front_blog_masonry_loop_after', 'front_blog_list_pagination_spacing', 10 );
add_action( 'front_blog_masonry_loop_after', 'front_paging_nav', 20 );

/**
 * Page
 */
add_action( 'front_page', 'front_page_header', 10 );
add_action( 'front_page', 'front_page_content', 20 );

add_action( 'front_page_after', 'front_display_comments', 10 );


/**
 * Single Post Classic
 */
add_action( 'front_single_post_classic_top',    'front_single_post_classic_header',   10 );

add_action( 'front_single_post_classic', 'front_single_post_classic_content',  10 );
add_action( 'front_single_post_classic', 'front_single_post_classic_footer',   20 );

add_action( 'front_single_post_classic_bottom', 'front_single_related_posts', 10 );
add_action( 'front_single_post_classic_bottom', 'front_single_post_comment',  20 );

/**
 * Single Post Simple
 */
add_action( 'front_single_post_simple_top',    'front_single_post_simple_header',   10 );

add_action( 'front_single_post_simple', 'front_single_post_simple_content', 10 );
add_action( 'front_single_post_simple', 'front_single_post_simple_footer', 20 );

add_action( 'front_single_post_simple_bottom', 'front_single_related_posts', 10 );
add_action( 'front_single_post_simple_bottom', 'front_single_post_comment',  20 );

add_action( 'front_posts_loop_after', 'front_sticky_block_endpoint', 10 );
add_filter( 'the_content', 'front_apply_single_post_classes', 10 );

/**
 * Widgets
 */
add_filter( 'widget_tag_cloud_args', 'front_modify_tag_cloud_args', 10 );
add_filter( 'wp_generate_tag_cloud', 'front_generate_tag_cloud', 10, 3 );
add_filter( 'wp_generate_tag_cloud_data', 'front_generate_tag_cloud_data', 10, 3 );
add_filter( 'widget_pages_args', 'front_modify_widget_pages_args', 10, 2 );
add_filter( 'widget_categories_args', 'front_modify_widget_categories_args', 10, 2 );
add_filter( 'front_hp_listings_categories_widget_list_args', 'front_modify_widget_categories_args', 10, 2 );
add_filter( 'widget_nav_menu_args', 'front_modify_widget_nav_menu_args', 10, 4 );
add_filter( 'get_archives_link', 'front_modify_archives_link', 10, 7 );
add_filter( 'cs_sidebar_params', 'front_custom_sidebar_widget_wrapper' );

/**
 * Home Blogs
 */
// Blog Agency
add_action( 'front_home_blog_agency_loop_before', 'front_blog_agency_cbp_wrap_start', 10 );
add_action( 'front_home_blog_agency_loop_after', 'front_blog_agency_cbp_wrap_end', 10 );
add_action( 'front_home_blog_agency_loop_after', 'front_blog_list_pagination_spacing', 20 );
add_action( 'front_home_blog_agency_loop_after', 'front_paging_nav_center', 20 );


// Blog Business
add_action( 'front_home_blog_business_loop_before', 'front_blog_business_cbp_wrap_start', 10 );
add_action( 'front_home_blog_business_loop_after', 'front_blog_business_cbp_wrap_end', 10 );
add_action( 'front_home_blog_business_loop_after', 'front_blog_list_pagination_spacing', 20 );
add_action( 'front_home_blog_business_loop_after', 'front_paging_nav_center', 20 );

// Scroll To Top
add_action( 'wp_footer', 'front_scroll_to_top', 1000 );
