<?php
/**
 * The template for displaying all single posts.
 *
 * @package jobhunt
 */

get_header(); ?>

    <div id="primary" class="content-area">

        <?php while ( have_posts() ) : the_post();

            do_action( 'jobhunt_single_resume_before' );

            get_job_manager_template( 'content-single-resume.php' , array() , 'wp-job-manager-resumes' );

            do_action( 'jobhunt_single_resume_after' );
            
        endwhile; // End of the loop. ?>

    </div><!-- #primary -->

<?php
get_footer();