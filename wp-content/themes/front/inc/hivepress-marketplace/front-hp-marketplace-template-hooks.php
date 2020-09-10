<?php
/**
 * Front HivePress Marketplace Hooks
 */

add_action( 'pre_get_posts', 'front_hp_listing_pre_get_posts', 20 );

add_action( 'init', 'front_hp_listing_add_post_type_support' );

add_filter( 'use_block_editor_for_post_type', 'front_hp_listing_use_block_editor_for_post_type_args', 10, 2 );
add_filter( 'register_post_type_args', 'front_hp_listing_post_type_args', 10, 2 );
add_filter( 'register_taxonomy_args', 'front_hp_listing_taxonomy_args', 10, 2 );

add_action( 'pre_get_posts', 'front_hp_listing_pre_get_posts', 20 );


add_filter( 'front_hp_listing_tabs', 'front_hp_default_listing_tabs', 10, 2 );

/**
 * Single Listing
 */
add_action( 'front_hp_before_single_listing_summary', 'front_hp_listing_breadcrumb_with_search', 10 );

add_action( 'front_hp_single_listing_summary_sidebar', 'front_hp_template_single_listing_image_and_action', 10 );
add_action( 'front_hp_single_listing_summary_sidebar', 'front_hp_template_single_listing_categories', 10 );
add_action( 'front_hp_single_listing_summary_sidebar', 'front_hp_template_single_listing_developer', 20 );
add_action( 'front_hp_single_listing_summary_sidebar', 'front_hp_template_single_listing_developer_links', 30 );
add_action( 'front_hp_single_listing_summary_sidebar', 'front_hp_template_single_report_abuse', 40 );

add_action( 'front_hp_single_listing_summary', 'front_hp_template_single_title', 10 );
add_action( 'front_hp_single_listing_summary', 'front_hp_output_listing_data_tabs', 20 );

add_action( 'front_hp_after_single_listing', 'front_hp_template_single_related_listings', 10 );

/**
 * Listing Loop
 */
add_action( 'front_hp_before_listing_loop', 'front_hp_listing_search_form', 10 );
add_action( 'front_hp_before_listing_loop', 'front_hp_listing_control_bar', 20 );

add_action( 'front_hp_listing_loop_item_body', 'front_hp_template_loop_listing_link_open', 10 );
add_action( 'front_hp_listing_loop_item_body', 'front_hp_template_loop_listing_media', 20 );
add_action( 'front_hp_listing_loop_item_body', 'front_hp_template_loop_listing_link_close', 30 );

add_action( 'front_hp_after_listing_loop', 'front_hp_listing_pagination', 10 );
