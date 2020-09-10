<?php
/**
 * Template used to display Home Blog Business
 *
 * @package front
 */
?>
<article class="card d-block border-0 transition-3d-hover mt-1">
    <div class="card-body p-5">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <a class="btn btn-xs btn-icon btn-soft-danger rounded-circle" href="javascript:;">
                <span class="fas fa-arrow-down btn-icon__inner"></span>
            </a>
            <?php front_posted_on( '<small class="text-muted">', '</small>', 'text-muted', true, true ); ?>
        </header>
        <?php if ( has_post_thumbnail() ) : ?>
        <div class="mb-4">
            <?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid rounded' ) ); ?>
        </div>
        <?php endif; ?>
        <?php the_title( sprintf( '<h2 class="h5"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <p class="mb-0"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
    </div>
    <footer class="card-footer p-5">
        <div class="media align-items-center">
            <a class="u-sm-avatar position-relative mr-3" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
            </a>
            <div class="media-body">
                <h3 class="h6 mb-0">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
                </h3>
                <small class="d-block"><?php printf( esc_html__( 'on %s', 'front' ), front_get_category_link('<a class="text-secondary" href="%s">%s</a>' ) ); ?></small>
            </div>
        </div>        
    </footer>
</article>