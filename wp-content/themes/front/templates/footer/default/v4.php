<?php
/**
 * Footer Default v4
 *
 * @package Front
 */
?>

<footer class="container space-2 site-footer site-footer__default style-v4">
    <div class="text-center">
        <?php front_footer_static_content(); ?>
    </div>
    <hr class="my-7">
    <div class="row align-items-md-center">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="d-flex align-items-center logo-v4">
                <?php front_footer_logo(); ?>
                <p class="small mb-0"><?php front_copyright_text(); ?></p>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 mb-4 mb-sm-0">
            <?php front_footer_primary_menu(); ?>
        </div>
        <div class="col-sm-6 col-md-4">
            <?php front_footer_social_menu(); ?>
        </div>
    </div>
</footer>
