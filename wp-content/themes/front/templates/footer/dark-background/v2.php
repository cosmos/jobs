<?php
/**
 * Footer Dark Background v2
 *
 * @package Front
 */
?>
<footer class="site-footer site-footer__dark footer-dark-v2 bg-dark">
    <div class="container space-top-2">
        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
            <div class="row justify-content-lg-between mb-7">
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="col-6 col-md-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="col-6 col-md-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="col-6 col-md-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                    <div class="col-sm-6 col-md-5 col-lg-3 col-lg-3">
                        <?php dynamic_sidebar( 'footer-4' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="row justify-content-between align-items-center space-1">
            <div class="col-5">
                <?php front_footer_logo(); ?>
            </div>
            <div class="col-6 text-right">
                <p class="small mb-0 text-secondary"><?php front_copyright_text(); ?></p>
            </div>
        </div>
    </div>
</footer>