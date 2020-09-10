<?php
/**
 * The template for displaying all single posts.
 *
 * @package front
 */
$single_post_style = front_single_post_style();

get_header();

    while ( have_posts() ) :
            
        the_post();

        do_action( 'front_single_post_before' );

        get_template_part( 'templates/blog/single/' . $single_post_style . '/content', 'single' );

        do_action( 'front_single_post_after' );

    endwhile; // End of the loop.

get_footer();