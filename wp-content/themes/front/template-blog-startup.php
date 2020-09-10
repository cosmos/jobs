<?php
/**
 * Template name: Blog Start-up
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
        global $wp_query;
        $_wp_query = $wp_query;
        $_post     = $post;
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $blog_startup_query_args = apply_filters( 'blog_startup_query_args', array(
            'post_type'      => 'post', 
            'paged'          => $paged,
            'posts_per_page' => 3,
        ) );
        $wp_query = new WP_Query( $blog_startup_query_args );
    ?>

    <div class="container space-2 space-md-3">
        <div class="row justify-content-center">
            <div class="col-lg-7"><?php

                if ( have_posts() ) :

                    do_action( 'front_home_blog_startup_loop_before' );

                    get_template_part( 'templates/blog/home/startup/loop' );

                    front_paging_nav( 'justify-content-center' );

                    do_action( 'front_home_blog_startup_loop_after' );

                else :

                    get_template_part( 'templates/contents/content', 'none' );

                endif;
                
            ?></div>
        </div>
    </div>

    <?php 
        wp_reset_postdata();
        $post     = $_post;
        $wp_query = $_wp_query;
    ?>

<?php

get_footer();