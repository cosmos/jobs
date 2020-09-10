<?php
/**
 * The template for displaying all single posts.
 *
 * @package front
 */

get_header();
    
    do_action( 'front_single_before_portfolio' );
            
    while ( have_posts() ) :
    
        the_post();

        do_action( 'front_portfolio_single_post_before' );

        get_template_part( 'templates/portfolio/content', 'single' );

        do_action( 'front_portfolio_single_post_after' );

    endwhile; // End of the loop.
    
    do_action( 'front_single_after_portfolio' );?>
<?php

get_footer();