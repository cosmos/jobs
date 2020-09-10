<?php
/**
 * Footer Default Background v11
 *
 * @package Front
 */
?>
<footer class="border-top site-footer site-footer__default footer-default-v11">
    <div class="container space-2">
        <div class="row">
            <div class="column col-sm-6 col-lg-4">
                <div class="footer-logo">
                    <?php front_footer_logo(); ?>
                </div>
                <div class="mb-4">
                    <p class="small text-muted mb-0"><?php front_copyright_text(); ?></p>
                </div>
                <?php front_footer_social_menu(); ?>
            </div>
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) ) : ?>
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="column col-sm-3 col-lg-2 mb-4 mb-sm-0 ml-lg-auto">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="column col-sm-3 col-lg-2 mb-4 mb-sm-0">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</footer>
