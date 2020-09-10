<?php
/**
 * Template name: Sidebar Left
 *
 * @package front
 */

get_header(); 
    
    while ( have_posts() ) : the_post();

        do_action( 'front_sidebar_left_before' );

        get_template_part( 'templates/contents/content', 'page' );

        do_action( 'front_sidebar_left_after' );
    endwhile; // End of the loop.

get_footer();