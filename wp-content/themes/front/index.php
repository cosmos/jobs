<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package front
 */

$blog_view = front_get_blog_view();

get_header(); 
    
    if ( have_posts() ) :

        do_action( 'front_posts_loop_before' );

        get_template_part( 'templates/blog/' . $blog_view . '/loop' );

        do_action( 'front_posts_loop_after' );

    else :

        get_template_part( 'templates/contents/content', 'none' );

    endif;

get_footer();