<?php
/**
 * Footer Default Background v8
 *
 * @package Front
 */
?>
<footer id="SVGFooter" class="svg-preloader gradient-overlay-half-indigo-v1 overflow-hidden site-footer site-footer__default footer-default-v8">
    <div class="container space-2">
        <?php front_footer_static_content(); ?>

        <?php if ( apply_filters( 'front_enable_footer_static_block', true )) : ?>
            <hr class="my-9">
        <?php endif; ?> 
        <div class="row footer-widgets">

            <div class="column col-6 col-lg-3 mb-7 mb-lg-0">
               <?php front_footer_logo(); ?>
            </div>

            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) :
                if ( is_active_sidebar( 'footer-1' ) ) : ?>
                    <div class="column col-6 col-lg-3 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                    <div class="column col-6 col-lg-3 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                    <div class="column col-6 col-lg-3">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif;
            endif; ?>
        </div>
    </div>

    <figure class="ie-half-circle-1-1 w-35 position-absolute top-0 right-0 z-index-n1 mt-n11 mr-n11">
        <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/half-circle-1.svg'; ?>" alt="Image Description" data-parent="#SVGFooter">
    </figure>

    <figure class="ie-half-circle-2-1 w-25 position-absolute bottom-0 left-0 z-index-n1 mb-n11 ml-n11">
        <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/half-circle-2.svg'; ?>" alt="Image Description" data-parent="#SVGFooter">
    </figure>
</footer>
