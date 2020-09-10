<?php
/**
 * The loop template file.
 *
 * Included on pages like index.php, archive.php and search.php to display a loop of posts
 * Learn more: https://codex.wordpress.org/The_Loop
 *
 * @package front
 */

$blog_layout = front_get_blog_layout();

?>
<div class="container space-2 space-top-md-5 space-top-lg-4">

    <div class="w-md-80 w-lg-60 mb-9">
        <?php the_archive_title( '<h1 class="font-weight-normal page-title">', '</h1>' ); ?>
    </div>

    <?php if ( front_blog_has_sidebar() ) : ?>

    <div class="row">
        <?php
            $blog_masonry_classes = 'blog-masonry col-lg-9 mb-9 mb-lg-0';

            if ( $blog_layout === 'sidebar-left' ) {
                $blog_masonry_classes .= ' order-lg-2';
            }

        ?>

        <div class="<?php echo esc_attr( $blog_masonry_classes ); ?>">

    <?php else : ?>

    <div class="blog-masonry">

    <?php endif; ?>

        <?php

        do_action( 'front_blog_masonry_loop_before' ); ?>

        <?php if ( $blog_layout === 'full-width' ): ?>

        <div class="card-sm-columns card-sm-2-count card-lg-3-count">

        <?php endif; ?>

        <?php

        $count = 1;
        $index = 0;

        while ( have_posts() ) :

            the_post();

            if ( $blog_layout === 'sidebar-left' || $blog_layout === 'sidebar-right' ) {

                if ( $count === 2 ) {
                    ?><div class="card-sm-columns card-sm-2-count card-lg-3-count"><?php
                }
            }

            /**
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            if ( ( $blog_layout === 'sidebar-left' || $blog_layout === 'sidebar-right' ) && $count === 1 ) {
                get_template_part( 'templates/blog/masonry/content', 'first' );
            } else {
                $img_index_arr = array( 3, 3, 4, 5, 5, 2, 2, 2, 2, 2 );
                $i = $index%10;
                $img_index     = $img_index_arr[ $i ];
                /**
                 * Image Size: 500x280-crop * 2
                 * Image Size: 500x550-crop * 2
                 * Image Size: 380x360-crop * 1
                 * Image Size: 480x320-crop * 5
                 */
                $img_sz_name = front_get_image_size( 'blog_masonry_thumbnail_' . $img_index , 'medium' );
                front_get_template( 'templates/blog/masonry/content.php', array( 'img_sz_name' => $img_sz_name ) );
                $index++;
            }

            if ( $blog_layout === 'sidebar-left' || $blog_layout === 'sidebar-right' ) {
                $count++;
            }

        endwhile; ?>

        </div><!-- /.card-sm-columns -->

        <?php

        /**
         * Functions hooked in to front_paging_nav action
         *
         * @hooked front_paging_nav - 10
         */
        do_action( 'front_blog_masonry_loop_after' ); ?>

    <?php if ( front_blog_has_sidebar() ) : ?>

        </div><!-- /.blog-masonry -->

    <?php get_sidebar(); ?>

    </div><!-- /.row -->

    <?php else : ?>

    </div><!-- /.blog-masonry -->

    <?php endif; ?>
</div>
