<?php
/**
 * Footer Default v2
 *
 * @package Front
 */
?>

<footer class="container site-footer site-footer__default style-v2">
    <div class="footer-static-v2">
        <?php front_footer_static_content(); ?>
    </div>
    <hr class="my-0">
    <div class="row space-2"> 
        <div class="col-6 col-lg-3 mb-7 mb-lg-0">
           <?php front_footer_logo(); ?>
           <p class="small text-muted"><?php front_copyright_text(); ?></p>
        </div>
        <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) :
            if ( is_active_sidebar( 'footer-1' ) ) : ?>
            <div class="col-6 col-lg-3 mb-7 mb-lg-0">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
            <div class="col-6 col-lg-3 mb-7 mb-lg-0">
                <?php dynamic_sidebar( 'footer-2' ); ?>
            </div>
            <?php endif; ?>

            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
            <div class="col-6 col-lg-3 mb-7 mb-lg-0">
                <?php dynamic_sidebar( 'footer-3' ); ?>
            </div>
            <?php endif;
        endif; ?>
    </div>
</footer>
