<footer id="SVGfooterTopShape" class="site-footer site-footer__primary style-v5 svg-preloader position-relative gradient-half-primary-v5">
    <div class="container space-top-4 space-bottom-2">
        <?php front_footer_static_content(); ?>
        <hr class="opacity-md my-7">
        <div class="row align-items-lg-center">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <p class="small text-white-70 mb-0"><?php front_copyright_text(); ?></p>
            </div>
            <div class="col-md-8 col-lg-6 mb-4 mb-md-0">
                <?php front_footer_primary_menu(); ?>
            </div>
            <div class="col-md-4 col-lg-3">
                <?php front_footer_social_menu(); ?>
            </div>
        </div>
    </div>
    <figure class="position-absolute top-0 right-0 left-0">
        <img class="js-svg-injector" src="<?php echo get_template_directory_uri() . '/assets/svg/components/wave-1-top-sm.svg'; ?>" alt="Svg" data-parent="#SVGfooterTopShape">
    </figure>
</footer>