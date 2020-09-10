<?php
/**
 * Footer Default v3
 *
 * @package Front
 */
?>

<footer class="site-footer site-footer__default style-v3 container space-top-2 space-top-md-3">
    <div class="border-bottom">
        <div class="row mb-7">
            <div class="col-6 col-lg-3 mb-7 mb-lg-0 column">
                <?php front_footer_logo(); ?>
            </div>
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) :
                if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 mb-md-0 column">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 mb-md-0 column">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="col-sm-4 col-md-3 col-lg-2 mb-4 mb-md-0 column">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </div>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                <div class="col-md-3 col-lg-2 column">
                    <?php dynamic_sidebar( 'footer-4' ); ?>
                </div>
                <?php endif;
            endif; ?>
        </div>
    </div>
        
    <div class="d-flex justify-content-between align-items-center py-7">
        <p class="small text-muted mb-0"><?php front_copyright_text(); ?></p>
        <?php front_footer_social_menu(); ?>
    </div>
</footer>