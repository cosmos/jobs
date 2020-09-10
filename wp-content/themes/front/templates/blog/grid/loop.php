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

    <div class="w-md-80 w-lg-60 mb-9">
        <?php the_archive_title( '<h1 class="font-weight-normal page-title">', '</h1>' ); ?>
    </div>

    <?php if ( front_blog_has_sidebar() ) : ?>
    
    <div class="row">
        <?php
            $blog_grid_classes = 'blog-grid col-lg-9 mb-9 mb-lg-0';
            $blog_layout     = front_get_blog_layout();

            if ( $blog_layout === 'sidebar-left' ) {
                $blog_grid_classes .= ' order-lg-2';
            }

        ?>

        <div class="<?php echo esc_attr( $blog_grid_classes ); ?>">
    
    <?php else : ?>

    <div id="posts-content" class="blog-grid">

    <?php endif; ?>

        <?php 
    
        do_action( 'front_blog_grid_loop_before' );

        $loop_count   = 1;
        $grid_columns = apply_filters( 'front_blog_grid_columns',  front_blog_has_sidebar() ? 2 : 3 );
        $is_open      = false;

        while ( have_posts() ) :

            if ( is_sticky() || $loop_count % $grid_columns == 1 ) :
                
                $is_open = true;
            ?>

            <div class="card-deck d-block d-md-flex card-md-gutters-2">

            <?php endif; 

            the_post();

            /**
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part( 'templates/blog/grid/content', get_post_format() );

            if ( is_sticky() || $loop_count % $grid_columns == 0 ) : ?>

            </div><!-- /.card-deck -->

            <?php 

                $is_open = false;

            endif; 

            if ( ! is_sticky() ) {
                $loop_count++;
            }

        endwhile;

        if ( $is_open ) {
            ?></div><!-- /.card-deck --><?php
        }

        /**
         * Functions hooked in to front_paging_nav action
         *
         * @hooked front_paging_nav - 10
         */
        do_action( 'front_blog_grid_loop_after' ); ?>

    <?php if ( front_blog_has_sidebar() ) : ?>
    
        </div><!-- /.blog-grid -->
    
        <?php get_sidebar(); ?>

    </div><!-- /.row -->
    
    <?php else : ?>
    
    </div><!-- /.blog-grid -->
    
    <?php endif; ?>
</div>