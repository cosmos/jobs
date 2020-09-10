<?php
/**
 * Template used to display Home Blog Agency
 *
 * @package front
 */
?>
<article class="card border-0">
    <?php
        /**
         * Image Size: 450x450-crop
         */
        the_post_thumbnail( $img_sz_name, array( 'class' => 'card-img-top' ) );
    ?>

    <div class="card-body p-5">
        <!-- Post Info -->
        <ul class="list-inline small text-muted mb-1">
            <li class="list-inline-item mr-0"><?php
                printf(
                    '<a href="%1$s" class="text-muted" rel="author">%2$s</a>',
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    esc_html( get_the_author() )
                );
            ?></li>
            <li class="list-inline-item mx-2">&#8211;</li>
            <li class="list-inline-item"><?php front_posted_on( '', '', 'text-muted', true, true ); ?></li>
        </ul>
        <!-- End Post Info -->

        <!-- Info -->
        <div class="mb-4">
            <?php the_title( sprintf( '<h3 class="h5 mb-0"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
        </div>
        <!-- End Info -->

        <?php front_blog_agency_tag_list(); ?>

    </div>
</article>
