<?php
/**
 * Content that is shown at the beginning of a resume list.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/resumes-start.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Resume Manager
 * @category    Template
 * @version     1.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$resume_listing_view = front_get_wpjmr_resume_listing_style() . '-view';

if ( isset( $layout ) && $layout != 'fullwidth' ) {
    $resume_listing_view .= ' has-resume-sidebar';
}

?>
<ul class="resume_listings row d-block d-lg-flex list-unstyled mb-0 <?php echo esc_attr( $resume_listing_view ); ?>">