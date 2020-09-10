<footer class="site-footer site-footer__default style-v16 border-top">
    <div class="container">
        <div class="border-bottom">
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
            <div class="row justify-content-lg-between space-2">
                <?php if ( is_active_sidebar( 'footer-1' ) ): ?>
                    <div class="col-6 col-sm-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    </div>
                <?php endif ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ): ?>
                    <div class="col-6 col-sm-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    </div>
                <?php endif ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ): ?>
                    <div class="col-sm-4 col-lg-2 mb-7 mb-lg-0">
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    </div>
                <?php endif ?>

                <?php if ( is_active_sidebar( 'footer-4' ) ): ?>
                    <div class="col-md-7 col-lg-5">
                        <div class="d-flex align-items-start flex-column h-100">
                            <?php dynamic_sidebar( 'footer-4' ); ?>
                        </div>
                    </div>
                <?php endif ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-center py-7">
            <p class="small text-muted mb-0"><?php front_copyright_text(); ?></p>
        </div>
    </div>
</footer>
