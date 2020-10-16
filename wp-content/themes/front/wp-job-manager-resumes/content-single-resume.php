<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
do_action( 'single_resume_before' );
if ( resume_manager_user_can_view_resume( $post->ID ) ) :
    do_action( 'single_resume_content_area_before' );
    do_action( 'single_resume_start' );
    do_action( 'single_resume' );
    do_action( 'single_resume_end' );
    do_action( 'single_resume_content_area_after' );

else :
    get_job_manager_template_part( 'access-denied', 'single-resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
endif;
do_action( 'single_resume_after' );