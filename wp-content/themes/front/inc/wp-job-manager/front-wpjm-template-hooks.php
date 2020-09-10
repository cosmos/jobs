<?php
/*
 * WP Job Manager Custom Fields
 */
add_filter( 'submit_job_form_fields', 'front_wpjm_custom_submit_job_form_fields', 10 );
add_filter( 'submit_job_form_validate_fields', 'front_wpjm_custom_submit_job_form_validate_fields', 10, 3 );
add_filter( 'submit_job_form_fields_get_job_data', 'front_wpjm_custom_submit_job_form_fields_get_job_data', 10, 2 );
add_action( 'job_manager_update_job_data', 'front_wpjm_update_job_data', 10, 2 );

/*
 * Single Job
 */
add_action( 'single_job_listing_before', 'front_modify_single_job_listing_hooks' );
add_action( 'single_job_listing_before', 'front_single_job_listing_jetpack_sharing_filters' );

add_action( 'single_job_listing_content_area_before', 'front_single_job_listing_hero_section', 10 );
add_action( 'single_job_listing_start', 'front_single_job_listing_content_open', 10 );
add_action( 'single_job_listing', 'front_single_job_listing_content', 10 );
add_action( 'single_job_listing', 'front_single_job_listing_sidebar', 20 );
add_action( 'single_job_listing_end', 'front_single_job_listing_content_close', 10 );
add_action( 'single_job_listing_end', 'front_single_job_listing_related_jobs', 20 );

add_action( 'single_job_listing_job_header', 'front_single_job_listing_job_header_job_data', 10 );
add_action( 'single_job_listing_job_header', 'front_single_job_listing_views', 20 );

add_action( 'single_job_listing_job_header_job_data', 'front_single_job_listing_job_header_job_data_left', 10 );
add_action( 'single_job_listing_job_header_job_data', 'front_single_job_listing_job_header_job_data_right', 20 );

add_action( 'single_job_listing_content', 'front_single_job_listing_description', 10 );
add_action( 'single_job_listing_content', 'front_single_job_listing_skills', 20 );
add_action( 'single_job_listing_content', 'front_single_job_listing_responsibilities', 30 );
add_action( 'single_job_listing_content', 'front_single_job_listing_requirements', 40 );
add_action( 'single_job_listing_content', 'front_single_job_listing_bonus_points', 50 );
add_action( 'single_job_listing_content', 'front_single_job_listing_share', 60 );

add_action( 'single_job_listing_sidebar', 'front_single_job_listing_summary', 10 );
add_action( 'single_job_listing_sidebar', 'front_single_job_listing_report_job', 20 );
add_action( 'single_job_listing_sidebar', 'front_single_job_listing_company', 30 );
add_action( 'single_job_listing_sidebar', 'front_single_job_listing_contact_details', 40 );

//Single 2
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_content_max_width_open', 10 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_content_header', 20 );
add_action( 'single_job_listing_v2_content', 'wpjm_the_job_description', 30 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_additional_space_open', 40 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_skills', 50 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_additional_space_close', 60 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_additional_space_open', 70 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_responsibilities', 80 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_additional_space_close', 90 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_additional_space_open', 100 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_requirements', 110 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_additional_space_close', 120 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_bonus_points', 140 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_company_description', 170 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_content_max_width_close', 190 );
add_action( 'single_job_listing_v2_content', 'front_single_job_listing_v2_apply_job_form', 200 );

add_action( 'single_job_listing_v2_job_header_job_data', 'front_single_job_listing_v2_job_header_job_data_left', 10 );
add_action( 'single_job_listing_v2_job_header_job_data', 'front_single_job_listing_v2_job_header_job_data_right', 20 );

/*
 * Job Listings
 */
add_action( 'job_listing_before_loop', 'front_wpjm_setup_loop' );
add_action( 'job_listing_after_loop', 'front_wpjm_reset_loop', 999 );

add_action( 'job_listing_before_loop_content', 'front_job_listing_loop_header', 10 );
add_action( 'job_listing_before_loop_content', 'front_job_listing_loop_content_open', 20 );
add_action( 'job_listing_before_loop', 'front_job_listing_loop_controlbar', 10 );
add_action( 'job_listing_before_loop', 'front_job_listing_loop_sidebar_wrap_open', 20 );
add_action( 'job_listing_after_loop', 'front_wpjm_pagination', 10 );
add_action( 'job_listing_after_loop', 'front_job_listing_loop_sidebar_wrap_close', 20 );
add_action( 'job_listing_after_loop_content', 'front_job_listing_loop_content_close', 90 );

add_action( 'job_listing_sidebar', 'front_job_listing_sidebar', 10 );
add_action( 'job_listing_sidebar_widget_after', 'front_job_listing_remove_active_filters', 10 );

/*
 * Job Listing Item
 */
add_action( 'job_listing_list_content_area_before', 'front_job_listing_list_card_open', 10 );
add_action( 'job_listing_list_start', 'front_job_listing_list_card_body_open', 10 );
add_action( 'job_listing_list', 'front_job_listing_list_card_body_content', 10 );
add_action( 'job_listing_list_end', 'front_job_listing_list_card_body_close', 10 );
add_action( 'job_listing_list_content_area_after', 'front_job_listing_list_card_close', 10 );

add_action( 'job_listing_list_card_body_content_additional', 'front_job_listing_body_content_review', 10 );

add_action( 'job_listing_grid_content_area_before', 'front_job_listing_grid_card_open', 10 );
add_action( 'job_listing_grid_start', 'front_job_listing_grid_card_body_open', 10 );
add_action( 'job_listing_grid_start', 'front_job_listing_grid_card_body_content_head', 20 );
add_action( 'job_listing_grid', 'front_job_listing_grid_card_body_content', 10 );
add_action( 'job_listing_grid_end', 'front_job_listing_grid_card_body_close', 10 );
add_action( 'job_listing_grid_content_area_after', 'front_job_listing_grid_card_footer', 10 );
add_action( 'job_listing_grid_content_area_after', 'front_job_listing_grid_card_close', 20 );

add_action( 'job_listing_grid_card_body_content_head', 'front_job_listing_body_content_review', 10 );

add_action( 'job_listing_list_grid_content_area_before', 'front_job_listing_list_grid_card_open', 10 );
add_action( 'job_listing_list_grid_start', 'front_job_listing_list_grid_card_body_open', 10 );
add_action( 'job_listing_list_grid', 'front_job_listing_list_grid_card_body_content', 10 );
add_action( 'job_listing_list_grid_end', 'front_job_listing_list_grid_card_body_close', 10 );
add_action( 'job_listing_list_grid_content_area_after', 'front_job_listing_list_grid_card_close', 10 );

add_action( 'job_listing_list_small_content_area_before', 'front_job_listing_list_small_card_open', 10 );
add_action( 'job_listing_list_small_start', 'front_job_listing_list_small_card_body_open', 10 );
add_action( 'job_listing_list_small', 'front_job_listing_list_small_card_body_content', 10 );
add_action( 'job_listing_list_small_end', 'front_job_listing_list_small_card_body_close', 10 );
add_action( 'job_listing_list_small_content_area_after', 'front_job_listing_list_small_card_close', 10 );

add_action( 'job_listing_grid_small_content_area_before', 'front_job_listing_grid_small_card_open', 10 );
add_action( 'job_listing_grid_small_start', 'front_job_listing_grid_small_card_body_open', 10 );
add_action( 'job_listing_grid_small', 'front_job_listing_grid_small_card_body_content', 10 );
add_action( 'job_listing_grid_small_end', 'front_job_listing_grid_small_card_body_close', 10 );
add_action( 'job_listing_grid_small_content_area_after', 'front_job_listing_grid_small_card_close', 10 );
