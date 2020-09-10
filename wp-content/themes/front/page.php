<?php
/**
 * The template for displaying all single page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package Front
 * @since 1.0.0
 */

get_header(); ?>

    <div id="primary" class="content-area">

        <?php
        while ( have_posts() ) :
            
            the_post();

            do_action( 'front_page_before' );

            get_template_part( 'templates/contents/content', 'page' );

            /**
             * Functions hooked in to front_page_after action
             *
             * @hooked front_display_comments - 10
             */
            do_action( 'front_page_after' );

        endwhile; // End of the loop.
        ?>
        
    </div><!-- #primary -->
        
<?php
get_footer();