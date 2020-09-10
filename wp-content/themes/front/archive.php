<?php
/**
 * The template for displaying archive pages.
 *
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