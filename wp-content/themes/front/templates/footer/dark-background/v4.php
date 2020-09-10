<?php
/**
 * Footer Dark Background v4
 *
 * @package Front
 */
?>
<footer class="site-footer site-footer__dark footer-dark-v4 bg-dark">
    <div class="container space-2">
        <div class="row mb-7">
            <div class="col-lg-3 mb-5 mb-lg-0">
                <?php front_footer_logo(); ?>
            </div>
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="col-6 col-lg-2 mb-5 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="col-6 col-lg-2 mb-5 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="col-lg-5">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <p class="small text-white-70 mb-0"><?php front_copyright_text(); ?></p>
    </div>
</footer>
