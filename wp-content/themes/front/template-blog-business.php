<?php
/**
 * Template name: Blog Business
 *
 * @package front
 */
if ( isset( $_GET['ajax'] ) && $_GET['ajax'] == '1' ) :

    global $wp_query;
    $_wp_query = $wp_query;
    $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
    $blog_business_query_args = apply_filters( 'blog_business_query_args', array(
        'post_type'      => 'post', 
        'paged'          => $paged,
        'posts_per_page' => 16,
    ) );
    $wp_query = new WP_Query( $blog_business_query_args );

    get_template_part( 'templates/blog/home/business/loop' );

    wp_reset_postdata();
    $wp_query = $_wp_query;

else :

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
        $blog_business_query_args = apply_filters( 'blog_business_query_args', array(
            'post_type'      => 'post', 
            'paged'          => $paged,
            'posts_per_page' => 16,
        ) );
        $wp_query = new WP_Query( $blog_business_query_args );
    ?>
    <div class="bg-light space-bottom-2">
        <div class="container-fluid u-cubeportfolio py-3">
        <?php

            if ( have_posts() ) :

                do_action( 'front_home_blog_business_loop_before', $_post );

                get_template_part( 'templates/blog/home/business/loop' );

                do_action( 'front_home_blog_business_loop_after', $_post );

            else :

                get_template_part( 'templates/contents/content', 'none' );

            endif;
            
        ?>
        </div><!-- /.u-cubeportfolio -->
    </div><!-- /.bg-light -->

    <?php 
        wp_reset_postdata();
        $post     = $_post;
        $wp_query = $_wp_query;
    ?>

    <?php

    get_footer();

endif;