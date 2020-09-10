<?php

// Apply Job Form Integration with Resume Manager
if( front_is_wp_job_manager_applications_activated() && front_is_wp_resume_manager_activated() && ! get_option( 'resume_manager_force_application' ) ) {
    if ( ! function_exists( 'front_wpjm_remove_apply_with_resume' ) ) {
        function front_wpjm_remove_apply_with_resume() {
            global $resume_manager;
            remove_action( 'job_manager_application_details_email', array( $resume_manager->apply, 'apply_with_resume' ), 20 );
            remove_action( 'job_manager_application_details_url', array( $resume_manager->apply, 'apply_with_resume' ), 20 );
        }
    }

    add_action( 'wp', 'front_wpjm_remove_apply_with_resume', 30 );
}

// WP Job Manager Bookmarks Integration
if( front_is_wp_job_manager_bookmarks_activated() ) {
    global $job_manager_bookmarks;
    remove_action( 'single_job_listing_meta_after', array( $job_manager_bookmarks, 'bookmark_form' ) );
    remove_action( 'single_resume_start', array( $job_manager_bookmarks, 'bookmark_form' ) );
    add_action( 'job_listing_list_card_body_content_additional', 'front_job_listing_body_content_bookmark', 20 );
    add_action( 'job_listing_grid_card_body_content_head', 'front_job_listing_body_content_bookmark', 20 );
    add_action( 'single_job_listing_job_header_job_apply_before', 'front_single_job_listing_bookmark', 10 );

    if( front_is_wp_resume_manager_activated() ) {
        add_action( 'resume_listing_list_card_body_content_bookmark', 'front_resume_listing_body_content_bookmark', 20 );
        add_action( 'resume_listing_grid_card_body_content_head', 'front_resume_listing_body_content_bookmark', 20 );
    }
}

// WP Job Manager Alerts Integration
if ( front_is_wp_job_manager_alert_activated() ) {
    global $job_manager_alerts;
    remove_action( 'single_job_listing_end', array( $job_manager_alerts, 'single_alert_link' ) );
    add_filter( 'body_class', 'front_wp_job_manager_alert_form_body_class' );
    add_filter( 'job_manager_job_filters_showing_jobs_links', 'front_wpjm_alert_link', 20, 2 );
    add_action( 'single_job_listing_sidebar', 'front_wpjm_single_alert_link', 50 );
    add_action( 'single_job_listing_v2_content', 'front_wpjm_single_alert_link', 195 );
}

// WP Job Manager Indeed & WP Job Manager ZipRecruiter Integration
if ( front_is_wp_job_manager_indeed_activated() || front_is_wp_job_manager_ziprecruiter_activated() ) {  
    if( ! function_exists( 'front_wp_job_manager_get_listings_result_start' ) ) {
        function front_wp_job_manager_get_listings_result_start() {
            ob_start();
        }
    }

    if( ! function_exists( 'front_wp_job_manager_get_listings_result_end' ) ) {
        function front_wp_job_manager_get_listings_result_end() {
            global $wp_query, $front_wpjm_loop;

            $result = array();

            if( ! have_posts() ) {
                $no_jobs_found = ob_get_clean();
                $result['html'] = '';
            } else {
                $result['html'] = ob_get_clean();
            }

            if ( $front_wpjm_loop['total'] > 0 ){
                $result['found_jobs'] = true;
            } else {
                $result['found_jobs'] = false;
            }

            $result['max_num_pages'] = $front_wpjm_loop['total_pages'];
            $default_job_type = front_is_wp_job_manager_indeed_activated() ? (array) get_job_listing_types( 'names' ) : array();

            $_REQUEST['page']    = $front_wpjm_loop['current_page'];
            $_REQUEST['filter_job_type']   = isset( $_GET[ 'filter_job_listing_type' ] ) ? explode( ',', front_clean( wp_unslash( $_GET[ 'filter_job_listing_type' ] ) ) ) : $default_job_type;
            $_REQUEST['search_location']   = isset( $_GET['search_location'] ) ? front_clean( wp_unslash( $_GET['search_location'] ) ) : null;
            $_REQUEST['search_categories'] = isset( $_GET[ 'search_category' ] ) ? explode( ',', front_clean( wp_unslash( $_GET[ 'search_category' ] ) ) ) : array();

            if( isset( $_GET['search_keywords'] ) ) {
                $search_keywords = front_clean( wp_unslash( $_GET['search_keywords'] ) );
            } elseif( isset( $_GET['s'] ) ) {
                $search_keywords = front_clean( wp_unslash( $_GET['search_keywords'] ) );
            } else {
                $search_keywords = null;
            }

            $_REQUEST['search_keywords']   = $search_keywords;

            $output = WP_Job_Manager_Importer_Integration::job_manager_get_listings_result( $result, $wp_query );
            if( ! have_posts() ) {
                if( ! empty( $output['html'] ) ) {
                    get_job_manager_template( 'job-listings-start.php' );
                    echo $output['html'];
                    get_job_manager_template( 'job-listings-end.php' );
                } else {
                    echo $no_jobs_found;
                }
            } else {
                echo $output['html'];
            }
        }
    }

    add_filter( 'job_manager_indeed_geolocate_country', '__return_false' );

    add_action( 'job_listing_loop_start', 'front_wp_job_manager_get_listings_result_start', 0 );
    add_action( 'job_listing_loop_end', 'front_wp_job_manager_get_listings_result_end', 999 );

    add_action( 'job_manager_output_jobs_no_results', 'front_wp_job_manager_get_listings_result_start', 0 );
    add_action( 'job_manager_output_jobs_no_results', 'front_wp_job_manager_get_listings_result_end', 999 );
}
