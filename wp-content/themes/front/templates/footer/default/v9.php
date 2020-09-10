<?php
/**
 * Footer Default Background v9
 *
 * @package Front
 */
?>
<footer class="container space-2 space-top-lg-3 site-footer site-footer__default footer-default-v9">
    <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
        <div class="row mb-11 footer-widgets">

            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <div class="column col-lg-3 mb-5 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <div class="column col-sm-4 col-lg-3">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="column col-sm-4 col-lg-3">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                <div class="column col-sm-4 col-lg-3">
                    <?php dynamic_sidebar( 'footer-4' ); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="row align-items-lg-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <p class="small mb-0"><?php front_copyright_text(); ?></p>
        </div>

        <div class="col-lg-6 text-lg-right">
            <?php front_footer_social_menu(); ?>
        </div>
    </div>
</footer>
