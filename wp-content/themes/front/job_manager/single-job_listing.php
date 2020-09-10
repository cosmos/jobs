<?php
/**
 * The template for displaying all single posts.
 *
 * @package front
 */

get_header();

while ( have_posts() ) : the_post();

    do_action( 'single_job_listing_content_before' );

    get_job_manager_template( 'content-single-job_listing.php' );

    do_action( 'single_job_listing_content_after' );

endwhile;
// End of the loop.

get_footer();