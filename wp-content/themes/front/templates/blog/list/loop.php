<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package front
 */

?>
<div class="container space-2 space-top-md-5 space-top-lg-4">

    <?php if ( front_blog_has_sidebar() ) : ?>
    
    <div class="w-md-80 w-lg-60 mb-9">
        <?php the_archive_title( '<h1 class="font-weight-normal page-title">', '</h1>' ); ?>
    </div>

    <div class="row">
        <?php
            $blog_list_classes = 'blog-list col-lg-9 mb-9 mb-lg-0';
            $blog_layout     = front_get_blog_layout();

            if ( $blog_layout === 'sidebar-left' ) {
                $blog_list_classes .= ' order-lg-2';
            }

        ?>

        <div class="<?php echo esc_attr( $blog_list_classes ); ?>">
    
    <?php else : ?>

    <div class="w-lg-80 mx-auto mb-9">
        <?php the_archive_title( '<h1 class="font-weight-normal page-title">', '</h1>' ); ?>
    </div>

    <div id="posts-content" class="blog-list w-lg-80 mx-auto">

    <?php endif; ?>
        <?php 
    
        do_action( 'front_blog_list_loop_before' );

        while ( have_posts() ) :
            the_post();

            /**
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part( 'templates/blog/list/content', get_post_format() );

        endwhile;

        /**
         * Functions hooked in to front_paging_nav action
         *
         * @hooked front_paging_nav - 10
         */
        do_action( 'front_blog_list_loop_after' ); ?>

    <?php if ( front_blog_has_sidebar() ) : ?>
    
        </div><!-- /.blog-list -->
    
        <?php get_sidebar(); ?>

    </div><!-- /.row -->
    
    <?php else : ?>
    
    </div><!-- /.blog-list -->
    
    <?php endif; ?>
</div>