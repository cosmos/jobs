<footer class="site-footer site-footer__primary style-v4 gradient-half-primary-v4">
    <div class="container">
        <?php front_footer_static_content(); ?>
        <hr class="opacity-md my-0">
        <div class="row justify-content-md-between space-2">
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
                <?php if ( is_active_sidebar( 'footer-1' ) ): ?>
                <div class="col-6 col-sm-4 col-lg-2 order-lg-2 mb-7 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div> 
                <?php endif ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ): ?>
                <div class="col-6 col-sm-4 col-lg-2 order-lg-3 mb-7 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
                <?php endif ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ): ?>
                <div class="col-sm-4 col-lg-2 order-lg-4 mb-7 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </div>
                <?php endif ?>

                <?php if ( is_active_sidebar( 'footer-4' ) ): ?>
                <div class="col-sm-6 col-md-5 col-lg-3 order-lg-5 mb-6 mb-sm-0">
                    <?php dynamic_sidebar( 'footer-4' ); ?>
                </div>
                <?php endif ?>
            <?php endif; ?>

            <div class="col-sm-6 col-md-5 col-lg-3 order-lg-1">
                <div class="d-flex align-self-start flex-column h-100">
                    <?php front_footer_logo(); ?>
                    <p class="small text-white-70 mt-lg-auto mb-0"><?php front_copyright_text(); ?></p>
                </div>
            </div>
        </div>
    </div>
</footer>