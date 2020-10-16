<?php
/**
 * The template for displaying all single posts.
 *
 * @package front
 */

get_header();

while ( have_posts() ) : the_post();

    do_action( 'single_company_content_before' );

    get_job_manager_template( 'content-single-company.php', array(), 'mas-wp-job-manager-company' );

    do_action( 'single_company_content_after' );

endwhile; 
// End of the loop.

get_footer();