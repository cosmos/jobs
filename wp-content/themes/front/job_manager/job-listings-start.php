<?php
/**
 * Content shown before job listings in `[jobs]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-listings-start.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.15.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $front_wpjm_job_view;

if ( ! empty ( $front_wpjm_job_view ) ) {
    $job_listing_view = $front_wpjm_job_view . '-view';
} else {
    $job_listing_view = front_get_wpjm_job_listing_style() . '-view';

    if ( isset( $layout ) && $layout != 'fullwidth' ) {
        $job_listing_view .= ' has-job-sidebar';
    }
}

?>
<ul class="job_listings row d-block d-lg-flex list-unstyled mb-0 <?php echo esc_attr( $job_listing_view ); ?>">