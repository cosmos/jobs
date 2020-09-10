<?php
/**
 * Template for default v1
 * @since 1.0.0
 */
?>
<footer class="site-footer site-footer__default style-v1">
    <div class="footer-widgets border-bottom">
        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
        <div class="container space-2">
            <div class="row justify-content-md-between">
                <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <div class="col-sm-4 col-lg-2 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <div class="col-sm-4 col-lg-2 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="col-sm-4 col-lg-2 mb-lg-0">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </div>
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                <div class="col-md-6 col-lg-4">
                    <?php dynamic_sidebar( 'footer-4' ); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="container text-center space-1">
    	<?php front_footer_logo(); ?>
    	<p class="small text-muted"><?php front_copyright_text(); ?></p>
    </div>
</footer>