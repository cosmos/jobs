<?php
/**
 * Footer Default Background v10
 *
 * @package Front
 */
?>
<footer class="container site-footer site-footer__default footer-default-v10">
    <div class="border-bottom space-2">
        <div class="row justify-content-lg-between">
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="column col-6 col-sm-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="column col-6 col-sm-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="column col-sm-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( apply_filters( 'front_footer_contact_us', true )) : ?>
                    <div class="column col-lg-5 text-right">
                        <?php front_footer_contact(); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row footer-bottom justify-content-sm-between align-items-md-center py-7">
        <div class="d-flex align-items-center col-sm-8 mb-4 mb-sm-0">
            <span class="font-size-1 pl-0 mr-2"><?php front_copyright_text(); ?></span>
            <?php front_footer_primary_menu(); ?>
        </div>

        <div class="col-sm-4 text-sm-right footer-logo">
            <?php front_footer_logo(); ?>
        </div>
    </div>
</footer>

