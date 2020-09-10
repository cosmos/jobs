<footer class="site-footer site-footer__primary gradient-half-primary-v1 primary-bg style-v1">
    <div class="container space-top-2 space-bottom-1">
        <div class="row justify-content-lg-start mb-7">
            <div class="column col-sm-9 col-lg-4 mb-7">
                <?php front_footer_logo(); ?>
                <p class="small text-white-70 mb-3"><?php echo apply_filters( 'front_footer_site_description', esc_html( get_bloginfo( 'description' ) ) ); ?></p>
            </div>
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                <?php if ( is_active_sidebar( 'footer-1' ) ): ?>
                    <div class="column col-6 col-sm-4 col-lg-2 ml-lg-auto mb-4">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ): ?>
                    <div class="column col-6 col-sm-4 col-lg-2 mb-4">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ): ?>
                    <div class="column col-6 col-sm-4 col-lg-2 mb-4">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif ?>
            <?php endif; ?>
        </div>
        <div class="row align-items-center">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <?php front_footer_social_menu(); ?>
            </div>
            <div class="col-sm-6 text-sm-right">
                <p class="small text-white-70 mb-0"><?php front_copyright_text(); ?></p>
            </div>
        </div>
    </div>
</footer>