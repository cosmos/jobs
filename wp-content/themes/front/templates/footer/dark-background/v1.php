<?php
/**
 * Footer Dark Background v1
 *
 * @package Front
 */
?>
<footer id="SVGcurvedShape" class="site-footer site-footer__dark footer-dark-v1 svg-preloader">
    <figure class="bg-light">
        <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/curved-2.svg'; ?>" alt="Image Description" data-parent="#SVGcurvedShape">
    </figure>
    <div class="bg-dark">
        <div class="container space-2 space-md-3">
            <div class="row justify-content-lg-between">
                <div class="col-lg-4 d-flex align-items-start flex-column mb-7 mb-lg-0">
                    <?php front_footer_logo(); ?>
                    <p class="small text-white-50 mb-0 mt-lg-auto"><?php front_copyright_text(); ?></p>
                </div>
                <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <div class="col-6 col-md-4 col-lg-2 mb-7 mb-md-0">
                            <?php dynamic_sidebar( 'footer-1' ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        <div class="col-6 col-md-4 col-lg-2 mb-7 mb-md-0">
                            <?php dynamic_sidebar( 'footer-2' ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>
