<?php
/**
 * Template name: Sidebar Right
 *
 * @package front
 */

get_header(); 
    
    while ( have_posts() ) : the_post();

        do_action( 'front_sidebar_right_before' );

        get_template_part( 'templates/contents/content', 'page' );

        do_action( 'front_sidebar_right_after' );
    endwhile; // End of the loop.

get_footer();