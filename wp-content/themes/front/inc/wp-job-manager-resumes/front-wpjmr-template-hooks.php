<?php
/*
 * WP Job Manager Resume Custom Fields
 */
add_filter( 'submit_resume_form_fields', 'front_wpjmr_custom_submit_resume_form_fields' );
add_filter( 'submit_resume_form_fields_get_resume_data', 'front_submit_resume_form_fields_get_resume_data', 10, 2 );

/*
 * Single Resume
 */

add_action( 'single_resume_start', 'front_single_resume_content_open', 10 );
add_action( 'single_resume', 'front_single_resume_sidebar', 10 );
add_action( 'single_resume', 'front_single_resume_content', 20 );
add_action( 'single_resume_end', 'front_single_resume_content_close', 10 );

add_action( 'single_resume_content', 'front_single_resume_description', 10 );
add_action( 'single_resume_content', 'front_single_resume_education', 20 );
add_action( 'single_resume_content', 'front_single_resume_experience', 30 );
// add_action( 'single_resume_content', 'front_single_resume_comment', 20 );

add_action( 'single_resume_sidebar', 'front_single_resume_sidebar_details', 10 );
add_action( 'single_resume_sidebar', 'front_single_resume_sidebar_svg_icon_block', 20 );
add_action( 'single_resume_sidebar', 'front_single_resume_sidebar_bio', 30 );
add_action( 'single_resume_sidebar', 'front_single_resume_sidebar_languages', 40 );
add_action( 'single_resume_sidebar', 'front_single_resume_sidebar_skills', 50 );
add_action( 'single_resume_sidebar', 'front_single_resume_sidebar_rewards_categories', 60 );
add_action( 'single_resume_sidebar', 'front_single_resume_linked_accounts', 90 );

/*
 * Resume Listings
 */
add_action( 'resume_listing_before_loop', 'front_wpjmr_setup_loop' );
add_action( 'resume_listing_after_loop', 'front_wpjmr_reset_loop', 999 );

add_action( 'resume_listing_before_loop_content', 'front_resume_listing_loop_header', 10 );
add_action( 'resume_listing_before_loop_content', 'front_resume_listing_loop_content_open', 20 );
add_action( 'resume_listing_before_loop', 'front_resume_listing_loop_controlbar', 10 );
add_action( 'resume_listing_before_loop', 'front_resume_listing_loop_sidebar_wrap_open', 20 );
add_action( 'resume_listing_after_loop', 'front_wpjmr_pagination', 10 );
add_action( 'resume_listing_after_loop', 'front_resume_listing_loop_sidebar_wrap_close', 20 );
add_action( 'resume_listing_after_loop_content', 'front_resume_listing_loop_content_close', 90 );

add_action( 'resume_listing_sidebar_widget_after', 'front_resume_listing_remove_active_filters', 10 );

/*
 * Resume Listing Item
 */
add_action( 'resume_listing_list_content_area_before', 'front_resume_listing_list_card_open', 10 );
add_action( 'resume_listing_list_start', 'front_resume_listing_list_card_body_open', 10 );
add_action( 'resume_listing_list', 'front_resume_listing_list_card_body_content', 10 );
add_action( 'resume_listing_list_end', 'front_resume_listing_list_card_body_close', 10 );
add_action( 'resume_listing_list_content_area_after', 'front_resume_listing_list_card_footer', 10 );
add_action( 'resume_listing_list_content_area_after', 'front_resume_listing_list_card_close', 20 );

add_action( 'resume_listing_grid_content_area_before', 'front_resume_listing_grid_card_open', 10 );
add_action( 'resume_listing_grid_start', 'front_resume_listing_grid_card_body_open', 10 );
add_action( 'resume_listing_grid_start', 'front_resume_listing_grid_card_body_content_head', 20 );
add_action( 'resume_listing_grid', 'front_resume_listing_grid_card_body_content', 10 );
add_action( 'resume_listing_grid_end', 'front_resume_listing_grid_card_body_close', 10 );
add_action( 'resume_listing_grid_content_area_after', 'front_resume_listing_grid_card_footer', 10 );
add_action( 'resume_listing_grid_content_area_after', 'front_resume_listing_grid_card_close', 20 );


add_action( 'resume_listing_sidebar', 'front_resume_listing_sidebar', 10 );