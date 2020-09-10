<footer class="site-footer site-footer__primary style-v2 position-relative text-center mx-auto">
    <a class="js-go-to" 
        href="javascript:;"
         data-type="absolute"
        data-position='{
            "bottom": 86,
            "right": 0,
            "left": 0
        }'
        data-compensation="#header"
        data-show-effect="slideInUp"
        data-hide-effect="slideOutDown">

        <figure class="u-go-to-wave ie-go-to-wave">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 208 44" style="margin-bottom: -33px; enable-background:new 0 0 208 44;" xml:space="preserve">
            <path class="fill-primary" d="M0,43c0,0,22.9,2.2,54-18.7S95.1,1.5,95.1,1.5s11.2-3.5,20.1,0.1s10.4,3.7,19.2,9.3c7.7,4.8,15,10.1,22.8,14.9
            c10.1,6.2,21.5,11.7,33,14.8C191.6,41,208,44,208,43c0,0,0,1,0,1H0V43z"/>
            </svg>
            <span class="<?php echo apply_filters( 'front_primary_footer_v2_goto_icon_class', esc_attr( 'fas fa-angle-double-up', 'front' ) ); ?> text-white u-go-to-wave__icon"></span>
        </figure>
    </a>

    <div class="bg-primary">
        <div class="container space-1">
            <p class="small text-white-70 mb-0"><?php front_copyright_text(); ?></p>
        </div>
    </div>
</footer>