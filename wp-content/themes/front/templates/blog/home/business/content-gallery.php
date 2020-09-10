<?php
/**
 * Template used to display Home Blog Business Gallery post
 *
 * @package front
 */
?>
<article class="d-flex align-items-start flex-wrap height-380 gradient-overlay-half-dark-v2 bg-img-hero rounded-pseudo transition-3d-hover p-5 mt-1" <?php if ( has_post_thumbnail() ) : ?>style="background-image: url( <?php the_post_thumbnail_url( 'full' ); ?> );"<?php endif; ?>>
    <header class="w-100 d-flex justify-content-between mb-3">
        <!-- Author -->
        <div class="media align-items-center">
            <a class="u-sm-avatar position-relative mr-3" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
            </a>
            <div class="media-body">
                <h3 class="h6 text-white mb-0">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
                </h3>
                <small class="d-block text-white"><?php printf( esc_html__( 'on %s', 'front' ), front_get_category_link('<a class="text-white-70" href="%s">%s</a>' ) ); ?></small>
            </div>
        </div>
        <!-- End Author -->
        <?php front_posted_on( '<small class="d-block text-white-70">', '</small>', 'text-white-70', true, true ); ?>
    </header>

    <!-- Info -->
    <div class="mt-auto">
        <?php the_title( sprintf( '<h2 class="h5 text-white"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <p class="text-white-70 mb-0"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
    </div>
    <!-- End Info -->
</article>