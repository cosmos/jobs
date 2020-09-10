<?php
/**
 * Template used to display post content in Blog Modern
 *
 * @package front
 */
?>
<a class="d-flex align-items-end bg-img-hero gradient-overlay-half-dark-v1 transition-3d-hover height-450 rounded-pseudo" href="<?php echo esc_url( get_permalink() ); ?>" <?php if ( has_post_thumbnail() ) : ?>style="background-image: url( <?php the_post_thumbnail_url( $img_sz_name ); ?> );"<?php endif; ?>>
    <article class="w-100 text-center p-6">
        <?php the_title( '<h2 class="h4 text-white">', front_sticky_indicator() . '</h2>' ); ?>
        <div class="mt-4">
            <strong class="d-block text-white-70 mb-2"><?php echo esc_html ( get_the_author() ); ?></strong>
            <div class="u-avatar mx-auto">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
            </div>
        </div>
    </article>
</a>
