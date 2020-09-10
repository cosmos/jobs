<footer id="SVGwave7BottomShape" class="site-footer position-relative site-footer__default style-v13 border-top">
    <div class="container space-top-2 space-top-md-3 space-bottom-2 footer-logo">
        <?php front_footer_logo(); ?>
        <div class="row">
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
            <?php if ( is_active_sidebar( 'footer-1' ) ): ?>
                <div class="col-sm-6 col-lg-4 mb-7 mb-sm-0">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                    <?php front_display_button_component( $defaults = array( 'text' => apply_filters( 'front_footer_default_13_button_text', 'Start a New Project' ), 'url' => apply_filters( 'front_footer_default_13_button_url', '#' ) ) ); ?>
                </div>
            <?php endif ?>

            <?php if ( is_active_sidebar( 'footer-2' ) ): ?>
                <div class="col-sm-3 col-lg-2 mb-4 mb-sm-0 ml-lg-auto">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
            <?php endif ?>

            <?php if ( is_active_sidebar( 'footer-3' ) ): ?>
                <div class="col-sm-3 col-lg-2">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </div>
            <?php endif ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="container space-1">
        <div class="row justify-content-end">
            <div class="col-md-5 text-right">
                <?php front_footer_social_menu(); ?>
            </div>
        </div>
    </div>
    <figure class="ie-wave-7-bottom w-80 w-md-65 w-lg-50 position-absolute bottom-0 left-0 z-index-n1">
        <img class="injected-svg js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/wave-7-bottom.svg'; ?>" alt="Image Description" data-parent="#SVGwave7BottomShape">
    </figure>
</footer>
