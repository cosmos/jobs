<footer class="container site-footer site-footer__default style-v15">
    <div class="row justify-content-lg-between space-2">
        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
            <?php if ( is_active_sidebar( 'footer-1' ) ): ?>
                <div class="col-6 col-md-4 col-lg-3 order-lg-2 ml-lg-auto mb-7 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
            <?php endif ?>

            <?php if ( is_active_sidebar( 'footer-2' ) ): ?>
                <div class="col-6 col-md-4 col-lg-3 order-lg-3 mb-7 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
            <?php endif ?>

            <?php if ( is_active_sidebar( 'footer-3' ) ): ?>
                <div class="col-md-4 col-lg-2 order-lg-4 mb-7 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </div>
            <?php endif ?>
        <?php endif; ?>
        <div class="col-lg-3 order-lg-1">
            <div class="d-flex align-items-start flex-column h-100 footer-logo">
                <?php front_footer_logo(); ?>
                <p class="small text-muted mb-0"><?php front_copyright_text(); ?></p>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="row align-items-md-center space-1">
        <div class="col-md-4 mb-4 mb-lg-0">
            <?php front_footer_social_menu(); ?>
        </div>
        <div class="col-md-8 text-md-right">
            <?php front_footer_primary_menu(); ?>
        </div>
    </div>
</footer>