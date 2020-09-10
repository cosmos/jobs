<?php
/**
 * The template for displaying all single posts.
 *
 * @package front
 */

get_header();
    
    do_action( 'front_single_before_customer_story' );
            
    while ( have_posts() ) :
    
        the_post();

        do_action( 'front_customer_story_single_post_before' );

        do_action( 'front_customer_story_single_post' );

        do_action( 'front_customer_story_single_post_after' );

    endwhile; // End of the loop.
    
    do_action( 'front_single_after_customer_story' );?>
<?php

get_footer();