<?php
$layout = front_get_wpjm_job_listing_layout();

$template = apply_filters( 'front_wpjm_job_listing_archive_template', 'default' );

get_header();

do_action( 'job_listing_before_loop_content' );

if( have_posts() ) {

    do_action( 'job_listing_before_loop' );

    get_job_manager_template( 'job-listings-start.php', array( 'layout' => $layout ) );

    do_action( 'job_listing_loop_start' );

    while ( have_posts() ) : the_post();

        do_action( 'job_listing_loop' );

        get_job_manager_template_part( 'content-job_listing', $template );

    endwhile; // End of the loop. 

    do_action( 'job_listing_loop_end' );

    get_job_manager_template( 'job-listings-end.php', array( 'layout' => $layout ) );

    do_action( 'job_listing_after_loop' );

} else {
    do_action( 'job_manager_output_jobs_no_results' );
}

do_action( 'job_listing_after_loop_content' );

get_footer();