<?php

$enable_bg = apply_filters(  'front_enable_bg_primary_v3', false );

$main_class = $enable_bg == true ? ' bg-primary' : ' u-sticky-footer';

?>

<footer class="site-footer site-footer__primary style-v3<?php echo esc_attr( $main_class ); ?>">
    <div class="container<?php echo esc_attr( $enable_bg == true ? ' space-1' : ' space-bottom-1' ); ?>">
        <div class="row justify-content-between align-items-center">
            <div class="col-sm-5 mb-3 mb-sm-0">
                <p class="small text-white-70 mb-0"><?php front_copyright_text(); ?></p>
            </div>
            <div class="col-sm-6 text-sm-right">
                <?php front_footer_social_menu(); ?>
            </div>
        </div>
    </div>
</footer>