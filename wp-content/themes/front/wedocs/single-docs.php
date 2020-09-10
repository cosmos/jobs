<?php
/**
 * The template for displaying a single doc
 *
 * To customize this template, create a folder in your current theme named "wedocs" and copy it there.
 *
 * @package weDocs
 */

get_header(); ?>

    <?php
        /**
         * @since 1.4
         *
         * @hooked wedocs_template_wrapper_start - 10
         */
        do_action( 'wedocs_before_main_content' );
    ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <div class="container space-bottom-2">
            <div class="w-lg-80 mx-lg-auto">

                <?php do_action( 'front_wedocs_before_single_doc' ); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'card shadow-sm p-7' ); ?> itemscope itemtype="http://schema.org/Article">
                    <?php do_action( 'front_wedocs_single_doc' ); ?>
                </article>

                <?php do_action( 'front_wedocs_after_single_doc' ); ?>

            </div>
        </div>

    
    <?php endwhile; ?>

    <?php
        /**
         * @since 1.4
         *
         * @hooked wedocs_template_wrapper_end - 10
         */
        do_action( 'wedocs_after_main_content' );
    ?>

<?php get_footer();