<?php
/**
 * Template for Footer v1 widgets area
 *
 * @since 1.0.0
 */
if ( ! is_active_sidebar( 'footer-1' ) && 
     ! is_active_sidebar( 'footer-2' ) && 
     ! is_active_sidebar( 'footer-3' ) && 
     ! is_active_sidebar( 'footer-4' ) 
 ) {
    return;
}

?>
<div class="footer-widgets border-bottom">
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
</div>