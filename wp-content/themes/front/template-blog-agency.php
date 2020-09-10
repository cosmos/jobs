<?php
/**
 * Template name: Blog Agency
 *
 * @package front
 */

get_header(); ?>

    <?php
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    ?>

    <?php
        global $wp_query, $post;
        $_wp_query = $wp_query;
        $_post     = $post;
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $blog_agency_query_args = apply_filters( 'blog_agency_query_args', array(
            'post_type'      => 'post', 
            'paged'          => $paged,
            'posts_per_page' => 16,
        ) );
        $wp_query = new WP_Query( $blog_agency_query_args );
    ?>

    <div class="bg-light">
        <div class="container u-cubeportfolio space-2 space-md-3"><?php
        
            if ( have_posts() ) :

                do_action( 'front_home_blog_agency_loop_before', $_post );

                get_template_part( 'templates/blog/home/agency/loop' );

                do_action( 'front_home_blog_agency_loop_after', $_post );

            else :

                get_template_part( 'templates/contents/content', 'none' );

            endif;

        ?></div>
    </div>

    <?php 
        wp_reset_postdata();
        $post     = $_post;
        $wp_query = $_wp_query;
    ?>

<?php

get_footer();