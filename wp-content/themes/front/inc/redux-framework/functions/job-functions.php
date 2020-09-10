<?php
/**
 * Filter functions for Job Section of Theme Options
 */

if ( ! function_exists( 'front_redux_toggle_separate_job_header' ) ) {
    function front_redux_toggle_separate_job_header( $enable_separate_job_header ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_job_header'] ) && $front_options['enable_separate_job_header'] ) {
            $enable_separate_job_header = true;
        } else {
            $enable_separate_job_header = false;
        }

        return $enable_separate_job_header;
    }
}

if( ! function_exists( 'front_redux_job_header_static_block' ) ) {
    function front_redux_job_header_static_block( $job_static_block_id ) {
        global $front_options;

        $job = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        $job_resume_manager = function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated();

        $job_company_manager = function_exists( 'front_is_mas_wp_company_manager_activated' ) && front_is_mas_wp_company_manager_activated();

        $job_pages = ( $job && ( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) || is_page( front_wpjm_get_page_id( 'jobs-dashboard' ) ) || is_page( front_wpjm_get_page_id( 'post-a-job' ) ) || front_is_job_listing_taxonomy() || is_singular( 'job_listing' ) ) );

        $job_resume = ( $job_resume_manager && ( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'jobs' ) ) || is_page( front_wpjmr_get_page_id( 'candidate_dashboard' ) ) || is_page( front_wpjmr_get_page_id( 'submit_resume_form' ) ) || front_is_job_listing_taxonomy() || is_singular( 'resume' ) ) );

        $job_company = ( $job_company_manager && ( is_post_type_archive( 'company' ) || is_page( mas_wpjmc_get_page_id( 'companies' ) ) || is_page( mas_wpjmc_get_page_id( 'company_dashboard' ) ) || is_page( mas_wpjmc_get_page_id( 'submit_company_form' ) ) || mas_wpjmc_is_company_taxonomy() || is_singular( 'company' ) ) );

        $enable_separate_job_header = isset( $front_options['enable_separate_job_header'] ) && $front_options['enable_separate_job_header'];

        if( $enable_separate_job_header && isset( $front_options['header_job_static_block_id'] ) && $job && ( $job_pages || $job_resume || $job_company ) ) {
            $job_static_block_id = $front_options['header_job_static_block_id'];
        }

        $enable_separate_single_job_header = isset( $front_options['enable_separate_single_job_header'] ) && $front_options['enable_separate_single_job_header'];

        if( $enable_separate_single_job_header && isset( $front_options['header_single_job_static_block_id'] ) && $job && is_singular( 'job_listing' ) ) {
            $job_static_block_id = $front_options['header_single_job_static_block_id'];
        }

        return $job_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_toggle_separate_job_footer' ) ) {
    function front_redux_toggle_separate_job_footer( $enable_separate_job_footer ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_job_footer'] ) && $front_options['enable_separate_job_footer'] ) {
            $enable_separate_job_footer = true;
        } else {
            $enable_separate_job_footer = false;
        }

        return $enable_separate_job_footer;
    }
}

if( ! function_exists( 'front_redux_job_footer_static_block' ) ) {
    function front_redux_job_footer_static_block( $job_static_block_id ) {
        global $front_options;

        $job = function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated();

        $job_resume_manager = function_exists( 'front_is_wp_resume_manager_activated' ) && front_is_wp_resume_manager_activated();

        $job_company_manager = function_exists( 'front_is_mas_wp_company_manager_activated' ) && front_is_mas_wp_company_manager_activated();

        $job_pages = ( $job && ( is_post_type_archive( 'job_listing' ) || is_page( front_wpjm_get_page_id( 'jobs' ) ) || is_page( front_wpjm_get_page_id( 'jobs-dashboard' ) ) || is_page( front_wpjm_get_page_id( 'post-a-job' ) ) || front_is_job_listing_taxonomy() || is_singular( 'job_listing' ) ) );

        $job_resume = ( $job_resume_manager && ( is_post_type_archive( 'resume' ) || is_page( front_wpjmr_get_page_id( 'jobs' ) ) || is_page( front_wpjmr_get_page_id( 'candidate_dashboard' ) ) || is_page( front_wpjmr_get_page_id( 'submit_resume_form' ) ) || front_is_job_listing_taxonomy() || is_singular( 'resume' ) ) );

        $job_company = ( $job_company_manager && ( is_post_type_archive( 'company' ) || is_page( mas_wpjmc_get_page_id( 'companies' ) ) || is_page( mas_wpjmc_get_page_id( 'company_dashboard' ) ) || is_page( mas_wpjmc_get_page_id( 'submit_company_form' ) ) || mas_wpjmc_is_company_taxonomy() || is_singular( 'company' ) ) );

        $enable_separate_job_footer = isset( $front_options['enable_separate_job_footer'] ) && $front_options['enable_separate_job_footer'];

        if( $enable_separate_job_footer && isset( $front_options['header_job_static_block_id'] ) && $job && ( $job_pages || $job_resume || $job_company ) ) {
            $job_static_block_id = $front_options['footer_job_static_block_id'];
        }

        return $job_static_block_id;
    }
}