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
            $blog_modern_classes = 'blog-modern col-lg-9 mb-9 mb-lg-0';

            if ( $blog_layout === 'sidebar-left' ) {
                $blog_modern_classes .= ' order-lg-2';
            }

        ?>

        <div class="<?php echo esc_attr( $blog_modern_classes ); ?>">

    <?php else : ?>

    <div class="blog-modern">

    <?php endif; ?>

    <?php

        do_action( 'front_blog_modern_loop_before' ); ?>

        <div class="row mx-gutters-2">

        <?php

        $count = 0;

        global $wp_query;
        $total = count( $wp_query->posts );
        $width = array( 7, 5, 6, 6, 5, 7, 6, 6, 12, 6, 6 );

        while ( have_posts() ) :

            the_post();

            $index = $count % 11;
            $col   = $width[ $index ] === 12 ? 'col-12' : 'col-md-'. $width[ $index ];
            $img_sz_name = front_get_image_size( 'blog_modern_thumbnail_1', 'post-thumbnail' );
            /**
             * Image Size: 400x500-crop
             * Image Size: 900x450-crop
             */
            if ( $count === $total - 1 && ( $index === 9 || ( $index < 8 && $index % 2 == 0 ) ) ) {
                $col = 'col-12';
            }

            if ( $col == 'col-12' ) {
                $img_sz_name = front_get_image_size( 'blog_modern_thumbnail_2', 'post-thumbnail' );
            }

            ?>

            <div class="<?php echo esc_attr( $col ); ?> mb-3"><?php

                front_get_template( 'templates/blog/modern/content.php', array( 'img_sz_name' => $img_sz_name ) );

            ?></div><?php

            $count++;

        endwhile; ?>

        </div><!-- /.row -->

        <?php

        /**
         * Functions hooked in to front_paging_nav action
         *
         * @hooked front_paging_nav - 10
         */
        do_action( 'front_blog_modern_loop_after' ); ?>

    <?php if ( front_blog_has_sidebar() ) : ?>

        </div><!-- /.blog-modern -->

        <?php get_sidebar(); ?>

    </div><!-- /.row -->

    <?php else : ?>

    </div><!-- /.blog-modern -->

    <?php endif; ?>

</div>
