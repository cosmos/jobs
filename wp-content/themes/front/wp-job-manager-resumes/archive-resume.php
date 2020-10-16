<?php
$layout = front_get_wpjmr_resume_listing_layout();

get_header();

do_action( 'resume_listing_before_loop_content' );

if( have_posts() ) {

    if ( ! resume_manager_user_can_browse_resumes() ) {
        get_job_manager_template_part( 'access-denied', 'browse-resumes', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );
    } else {

        do_action( 'resume_listing_before_loop' );
        
        get_job_manager_template( 'resumes-start.php' , array( 'layout' => $layout ) , 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );

        do_action( 'resume_listing_loop_start' );
        
        while ( have_posts() ) : the_post();

            do_action( 'resume_listing_loop' );

            get_job_manager_template_part( 'content', 'resume', 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );

        endwhile; // End of the loop.

        do_action( 'resume_listing_loop_end' );

        get_job_manager_template( 'resumes-end.php' , array( 'layout' => $layout ) , 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' );

        do_action( 'resume_listing_after_loop' );
    }

} else {
    do_action( 'resume_manager_output_resumes_no_results' );
}

do_action( 'resume_listing_after_loop_content' );

get_footer();