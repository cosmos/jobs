<?php
/**
 * Template for resume content inside a list of resumes.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/content-resume.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Resume Manager
 * @category    Template
 * @version     1.13.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<li <?php resume_class(); ?>>
    <?php
        do_action( 'resume_listing_list_content_area_before' );
        do_action( 'resume_listing_list_start' );
        do_action( 'resume_listing_list' );
        do_action( 'resume_listing_list_end' );
        do_action( 'resume_listing_list_content_area_after' );
        do_action( 'resume_listing_grid_content_area_before' );
        do_action( 'resume_listing_grid_start' );
        do_action( 'resume_listing_grid' );
        do_action( 'resume_listing_grid_end' );
        do_action( 'resume_listing_grid_content_area_after' );
    ?>
</li>