<?php
/**
 * Single job listing.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.0.0
 * @version     1.28.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post;

do_action( 'single_job_listing_before' );

if ( get_option( 'job_manager_hide_expired_content', 1 ) && 'expired' === $post->post_status ) :
    ?><div class="container"><div class="space-2"><div class="job-manager-info"><?php esc_html_e( 'This listing has expired.', 'front' ); ?></div></div></div><?php
else :
    do_action( 'single_job_listing_content_area_before' );
    do_action( 'single_job_listing_start' );
    do_action( 'single_job_listing' );
    do_action( 'single_job_listing_end' );
    do_action( 'single_job_listing_content_area_after' );
endif;

do_action( 'single_job_listing_before' );
