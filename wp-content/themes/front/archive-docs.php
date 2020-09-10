<?php
/**
 * The template for displaying the Docs archive page.
 *
 * @package front
 */

add_action( 'front_docs_before', 'front_wedocs_docs_search_form', 20 );
add_action( 'front_docs_before', 'front_wedocs_breadcrumbs', 30 );
add_action( 'front_docs_before', 'front_wedocs_container_start', 99 );
add_action( 'front_docs_after', 'front_wedocs_container_end', 99 );

get_header(); ?>

    <div id="primary" class="content-area">

        <?php
        if ( have_posts() ) :

            do_action( 'front_docs_before' );

            while ( have_posts() ) :
                
                the_post();

                get_template_part( 'templates/docs/content', 'docs' );

            endwhile; // End of the loop.

            do_action( 'front_docs_after' );

        else :

            get_template_part( 'templates/contents/content', 'none' );

        endif;
        ?>
        
    </div><!-- #primary -->
        
<?php
get_footer();