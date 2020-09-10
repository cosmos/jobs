<?php

/*
 * Single Company
 */

add_action( 'single_company_before', 'front_single_company_remove_plugin_hooks', 10 );

add_action( 'single_company_start', 'front_single_company_content_open', 10 );
add_action( 'single_company', 'front_single_company_sidebar', 10 );
add_action( 'single_company', 'front_single_company_content', 20 );
add_action( 'single_company_end', 'front_single_company_content_close', 10 );

add_action( 'single_company_content', 'front_single_company_description', 10 );
add_action( 'single_company_content', 'front_single_company_comment', 20 );

add_action( 'single_company_sidebar', 'front_single_company_details', 10 );
add_action( 'single_company_sidebar', 'front_single_company_sidebar_svg_icon_block', 20 );
add_action( 'single_company_sidebar', 'front_single_company_linked_accounts', 30 );
add_action( 'single_company_sidebar', 'front_single_company_related_companies', 40 );

add_action( 'single_company_details_after', 'front_single_company_details_buttons', 10 );

add_action( 'single_company_details_buttons', 'front_single_company_details_open_position_link', 20 );

add_action( 'company_before_loop_content', 'front_company_loop_content_open', 10 );
add_action( 'company_after_loop_content', 'front_company_loop_content_close', 10 );

add_action( 'company_content_area_before', 'front_company_content_remove_plugin_hooks', 10 );

add_action( 'company_start', 'front_company_loop_open', 10 );
add_action( 'company', 'front_company_loop_content', 10 );
add_action( 'company_end', 'front_company_loop_close', 10 );