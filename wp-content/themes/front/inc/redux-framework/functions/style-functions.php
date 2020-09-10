<?php
/**
 * Filter functions for Styling Section of Theme Options
 */

if ( ! function_exists( 'sass_darken' ) ) {
    function sass_darken( $hex, $percent ) {
        preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $front_primary_color );
        str_replace( '%', '', $percent );
        $percent = (int) $percent;
        $color = "#";
        for( $i = 1; $i <= 3; $i++ ) {
            $front_primary_color[$i] = hexdec( $front_primary_color[$i] );
            if ( $percent > 50 ) $percent = 50;
            $dv = 100 - ( $percent * 2 );
            $front_primary_color[$i] = round( $front_primary_color[$i] * ( $dv ) / 100 );
            $color .= str_pad( dechex( $front_primary_color[$i] ), 2, '0', STR_PAD_LEFT );
        }
        return $color;
    }
}

if ( ! function_exists( 'sass_hex_to_rgba' ) ) {
    function sass_hex_to_rgba( $hex, $alpa = '' ) {
        preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $primary_colors);
        for($i = 1; $i <= 3; $i++) {
            $primary_colors[$i] = hexdec($primary_colors[$i]);
        }
        if( !empty( $alpa ) ) {
            $rgb = 'rgba(' . $primary_colors[1] . ', ' . $primary_colors[2] . ', ' . $primary_colors[3] . ', ' . $alpa .')';
        } else {
            $rgb = 'rgba(' . $primary_colors[1] . ', ' . $primary_colors[2] . ', ' . $primary_colors[3] . ')';
        }
        return $rgb;
    }
}

if ( ! function_exists( 'sass_darken' ) ) {
    function sass_darken( $hex, $percent ) {
        preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $front_primary_color );
        str_replace( '%', '', $percent );
        $percent = (int) $percent;
        $color = "#";
        for( $i = 1; $i <= 3; $i++ ) {
            $front_primary_color[$i] = hexdec( $front_primary_color[$i] );
            if ( $percent > 50 ) $percent = 50;
            $dv = 100 - ( $percent * 2 );
            $front_primary_color[$i] = round( $front_primary_color[$i] * ( $dv ) / 100 );
            $color .= str_pad( dechex( $front_primary_color[$i] ), 2, '0', STR_PAD_LEFT );
        }
        return $color;
    }
}

if ( ! function_exists( 'sass_lighten' ) ) {
    function sass_lighten( $hex, $percent ) {
        preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $front_primary_color);
        str_replace('%', '', $percent);
        $percent = (int) $percent;
        $color = "#";
        for($i = 1; $i <= 3; $i++) {
            $front_primary_color[$i] = hexdec($front_primary_color[$i]);
            $front_primary_color[$i] = round($front_primary_color[$i] * (100+($percent*2))/100);
            $color .= str_pad(dechex($front_primary_color[$i]), 2, '0', STR_PAD_LEFT);
        }
        return $color;
    }
}

if ( ! function_exists( 'redux_toggle_use_predefined_colors' ) ) {
    function redux_toggle_use_predefined_colors( $enable ) {
        global $front_options;

        if ( isset( $front_options['use_predefined_color'] ) && $front_options['use_predefined_color'] ) {
            $enable = true;
        } else {
            $enable = false;
        }

        return $enable;
    }
}

if( ! function_exists( 'redux_apply_primary_color' ) ) {
    function redux_apply_primary_color( $color ) {
        global $front_options;

        if ( isset( $front_options['main_color'] ) ) {
            $color = $front_options['main_color'];
        }

        return $color;
    }
}

if( ! function_exists( 'redux_apply_custom_primary_color' ) ) {
    function redux_apply_custom_primary_color( $color ) {
        global $front_options;

        if ( !( isset( $front_options['use_predefined_color'] ) && $front_options['use_predefined_color'] ) && isset( $front_options['custom_primary_color'] ) ) {
            $color = $front_options['custom_primary_color'];
        }

        return $color;
    }
}

if ( ! function_exists( 'redux_get_custom_color_css' ) ) {
    function redux_get_custom_color_css() {
        global $front_options;

        $primary_color                 = isset( $front_options['custom_primary_color'] ) ? $front_options['custom_primary_color'] : '#377dff';
        $secondary_color               = isset( $front_options['custom_secondary_color'] ) ? $front_options['custom_secondary_color'] : '#77838f';
        $gradient_half_indigo          = isset( $front_options['custom_gradient_half_indigo_color'] ) ? $front_options['custom_gradient_half_indigo_color'] : '#2d1582';
        $gradient_half_info            = isset( $front_options['custom_gradient_half_info_color'] ) ? $front_options['custom_gradient_half_info_color'] : '#00dffc';
        $gradient_half_warning         = isset( $front_options['custom_gradient_half_warning_color'] ) ? $front_options['custom_gradient_half_warning_color'] : '#ffc107';
        $gradient_half_danger          = isset( $front_options['custom_gradient_half_danger_color'] ) ? $front_options['custom_gradient_half_danger_color'] : '#de4437';
        $gradient_overlay_half_white   = isset( $front_options['custom_gradient_overlay_half_white_color'] ) ? $front_options['custom_gradient_overlay_half_white_color'] : '#fff';
        $gradient_overlay_half_dark    = isset( $front_options['custom_gradient_overlay_half_dark_color'] ) ? $front_options['custom_gradient_overlay_half_dark_color'] : '#1e2022';

        $primary_darker                = sass_darken( $primary_color, '5.8%' );
        $primary_lighter               = sass_darken( $primary_color, '5.6%' );
        $gradient_half_warning_darker  = sass_darken( $gradient_half_warning, '4.6%' );

        $styles             = 
'a,
.site-footer.site-footer__default .product-categories .cat-item-link:hover,
.site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .active > .woocommerce-widget-layered-nav-list__item, 
.blog-sidebar .widget_meta ul .site-footer .widget .active > .woocommerce-widget-layered-nav-list__item,
.site-footer .widget .blog-sidebar .widget_meta ul .active > .woocommerce-widget-layered-nav-list__item, 
.page-template-template-terms-conditions .list-group ul .site-footer .widget .active > .woocommerce-widget-layered-nav-list__item, 
.site-footer .widget .page-template-template-terms-conditions .list-group ul .active > .woocommerce-widget-layered-nav-list__item, 
.site-footer .widget .blog-sidebar .widget_meta ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) li .active > a, 
.blog-sidebar .widget .widget_meta ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) li .active > a, 
.blog-sidebar .widget_meta .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) li .active > a, 
.blog-sidebar .widget_meta ul li .active > a, 
.site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .active > .list-group-item, 
.blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .active > .list-group-item, 
.blog-sidebar .widget_meta ul .active > .list-group-item, 
.page-template-template-terms-conditions .list-group ul .active > .list-group-item, 
.site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .wp-block-categories-list .active > a, 
.wp-block-categories-list .site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .active > a, 
.blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .wp-block-categories-list .active > a, 
.wp-block-categories-list .blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .active > a,
.blog-sidebar .widget_meta ul .wp-block-categories-list .active > a, 
.wp-block-categories-list .blog-sidebar .widget_meta ul .active > a, 
.page-template-template-terms-conditions .list-group ul .wp-block-categories-list .active > a, 
.wp-block-categories-list .page-template-template-terms-conditions .list-group ul .active > a,
.front-user-account-menu-sidebar li a.active,
.front-user-account-menu-sidebar li a:hover,
.front-user-account-menu-sidebar li a.active span,
.front-user-account-menu-sidebar li a:hover span,
.front-wpjm-pages .bootstrap-select > .bs-placeholder:not(:hover),
.front-wpjmr-pages .bootstrap-select > .bs-placeholder:not(:hover),
.mas-wpjmc-pages .bootstrap-select > .bs-placeholder:not(:hover),
.job-manager-alert-pages .bootstrap-select > .bs-placeholder:not(:hover),
.u-header-collapse__nav-link.active, 
.u-header-collapse__submenu-nav-link.active,
.u-header__navbar-brand-text, 
.u-header__navbar-brand-text:focus, 
.u-header__navbar-brand-text:hover,
.site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .active.woocommerce-widget-layered-nav-list__item,
.site-footer .widget .blog-sidebar .widget_meta ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) li a.active,
blog-sidebar .widget_meta .site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) li a.active,
site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .list-group-item.active,
site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .wp-block-categories-list a.active,
.wp-block-categories-list .site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) a.active,
.site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .wp-block-categories__list a.active,
.wp-block-categories__list .site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) a.active,
.site-footer.site-footer__primary.style-v5 .footer-primary-menu .widget .active.woocommerce-widget-layered-nav-list__item, 
.site-footer.site-footer__primary.style-v5 .widget .footer-primary-menu .active.woocommerce-widget-layered-nav-list__item, 
.site-footer.site-footer__primary.style-v5 .footer-primary-menu .blog-sidebar .widget_meta ul li a.active, 
.blog-sidebar .widget_meta ul li .site-footer.site-footer__primary.style-v5 .footer-primary-menu a.active, 
.site-footer.site-footer__primary.style-v5 .footer-primary-menu .list-group-item.active, 
.site-footer.site-footer__primary.style-v5 .footer-primary-menu .wp-block-categories-list a.active, 
.wp-block-categories-list .site-footer.site-footer__primary.style-v5 .footer-primary-menu a.active, 
.site-footer.site-footer__primary.style-v5 .footer-primary-menu .wp-block-categories__list a.active, 
.wp-block-categories__list .site-footer.site-footer__primary.style-v5 .footer-primary-menu a.active, 
.blog-sidebar .site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .active.woocommerce-widget-layered-nav-list__item, 
.site-footer .blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .active.woocommerce-widget-layered-nav-list__item, 
.blog-sidebar .widget .widget_meta ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) li a.active, 
.blog-sidebar .widget_meta .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) li a.active, 
.blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .list-group-item.active, 
.blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .wp-block-categories-list a.active, 
.wp-block-categories-list .blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) a.active, 
.blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) .wp-block-categories__list a.active, 
.wp-block-categories__list .blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) a.active, 
.blog-sidebar .widget_meta ul .site-footer .widget .active.woocommerce-widget-layered-nav-list__item, 
.site-footer .widget .blog-sidebar .widget_meta ul .active.woocommerce-widget-layered-nav-list__item, 
.blog-sidebar .widget_meta ul li a.active, .blog-sidebar .widget_meta ul .list-group-item.active, 
.blog-sidebar .widget_meta ul .wp-block-categories-list a.active, 
.wp-block-categories-list .blog-sidebar .widget_meta ul a.active, 
.blog-sidebar .widget_meta ul .wp-block-categories__list a.active, 
.wp-block-categories__list .blog-sidebar .widget_meta ul a.active,
.single-product .flex-direction-nav .flex-prev:hover,
.single-product .flex-direction-nav .flex-next:hover,
.single-product .flex-direction-nav .flex-prev,
.single-product .flex-direction-nav .flex-next,
.wpjm-pagination .page-numbers:hover,
.wpjmr-pagination .page-numbers:hover, 
.mas-wpjmc-pagination ul .page-numbers:hover,
.btn-outline-primary, 
.wp-block-button.is-style-outline .wp-block-button__link,
h1 > a:hover,
h2 > a:hover,
h3 > a:hover, 
h4 > a:hover, 
h5 > a:hover, 
h6 > a:hover, 
.h1 > a:hover, 
.h2 > a:hover, 
.h3 > a:hover, 
.h4 > a:hover, 
.h5 > a:hover, 
.page-template-template-terms-conditions #content h2 > a:hover, 
.page-template-template-terms-conditions #content h3 > a:hover, 
.page-template-template-privacy-policy #content h2 > a:hover, 
.page-template-template-privacy-policy #content h3 > a:hover, 
.h6 > a:hover, .comment-list .comment-reply-title a > a:hover, 
.pingback .url > a:hover, .trackback .url > a:hover, 
.blog-sidebar .wp-block-latest-posts > li a > a:hover, 
.blog-sidebar .wp-block-latest-comments > li a > a:hover, 
.blog-sidebar #recentcomments > li a > a:hover, 
.blog-sidebar .widget_recent_entries .widget__title + ul > li a > a:hover, 
.blog-sidebar .widget_rss li .rsswidget > a:hover, 
.page-template-template-terms-conditions #content h4 > a:hover, 
.page-template-template-privacy-policy #content h4 > a:hover,
.link__icon,
.site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) a:hover, 
.site-footer .widget .woocommerce-widget-layered-nav-list__item:hover, 
.blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) a:hover, 
.site-footer.site-footer__primary.style-v5 .footer-social-menu li a:hover, 
.blog-sidebar .widget_meta ul li a:hover, .site-footer .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) a:focus, 
.site-footer .widget .woocommerce-widget-layered-nav-list__item:focus, 
.blog-sidebar .widget ul:not(.widget_recent_entries):not(.widget_recent_comments):not(.wp-tag-cloud):not(.social-icon-menu) a:focus, 
.site-footer.site-footer__primary.style-v5 .footer-social-menu li a:focus, 
.blog-sidebar .widget_meta ul li a:focus,
.u-header__nav-item:hover .u-header__nav-link, 
.u-header__nav-item:focus .u-header__nav-link,
.u-header .active > .u-header__nav-link,
.u-header__product-banner-title,
.btn.btn-soft-primary,
.btn-soft-primary,
.list-group-item-action:hover,
.wp-block-categories-list a:hover, 
.wp-block-categories__list a:hover, 
.list-group-item-action:focus, 
.wp-block-categories-list a:focus, 
.wp-block-categories__list a:focus,
.u-slick__arrow:not(.u-slick__arrow--flat-white):not(:hover),
.btn-custom-toggle-primary:hover,
.u-header__promo-link:hover .u-header__promo-title,
.u-sidebar--account__toggle-bg:hover .u-sidebar--account__toggle-text,
.u-media-player:hover .u-media-player__icon:not(.u-media-player__icon--success), 
.u-media-player:focus .u-media-player__icon:not(.u-media-player__icon--success),
.u-go-to-ver-arrow,
.u-cubeportfolio .u-cubeportfolio__item.cbp-filter-item-active,
.card-btn-arrow,
.nav-box .nav-link.active,
.nav-white .nav-link.active,
.nav-classic .nav-link.active,
.nav-classic .nav-link:hover,
.page-link:hover, 
ul.page-numbers > li > a:hover, 
ul.page-numbers > li > span:hover,
.u-header__sub-menu .active > .u-header__sub-menu-nav-link,
.card-text-dark:hover,
.u-slick__arrow--flat-white:hover,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist a.add_to_wishlist,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a span.icon:before, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a span.icon:before, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist a.add_to_wishlist span.icon:before,
.btn-soft-primary[href].disabled, .btn-soft-primary[href]:disabled, 
.btn-soft-primary[type].disabled, .btn-soft-primary[type]:disabled,
.shop-sidebar .widget.woocommerce-widget-layered-nav .maxlist-more .link:not(:hover),
.u-slick--pagination-interactive .slick-center .u-slick--pagination-interactive__title,
.u-go-to-modern,
.site-footer__default.style-v2 .social-icon-menu a:not(:hover),
.dropdown-item:hover,
.u-sidebar--account__list-link.active,
.u-sidebar--account__list-link:hover,
.u-sidebar--account__list-link.active .u-sidebar--account__list-icon, 
.u-sidebar--account__list-link:hover .u-sidebar--account__list-icon,
.brand-primary, 
.brand-primary:focus, 
.brand-primary:hover,
.dropdown-item.active,
.list-group .active > .list-group-item, 
.list-group .wp-block-categories-list .active > a, 
.wp-block-categories-list .list-group .active > a,
.list-group .wp-block-categories__list .active > a, 
.wp-block-categories__list .list-group .active > a,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist i.yith-wcwl-icon,
.has-primary-color {
    color: ' . $primary_color . ';
}

.text-primary, 
.site-footer.site-footer__primary .widget_tag_cloud .tag-cloud-link, 
.site-footer.footer-default-v10 .footer-primary-menu li a:hover, 
.page-template-template-privacy-policy #content h2, 
.page-template-template-privacy-policy #content h3, 
.page-template-template-privacy-policy #content h4, 
.page-template-template-privacy-policy #content h5, 
.page-template-template-privacy-policy #content h6,
a.text-primary:hover, 
.site-footer.site-footer__primary .widget_tag_cloud a.tag-cloud-link:hover, 
.site-footer.footer-default-v10 .footer-primary-menu li a:hover, 
a.text-primary:focus, 
.site-footer.site-footer__primary .widget_tag_cloud a.tag-cloud-link:focus, 
.site-footer.footer-default-v10 .footer-primary-menu li a:focus:hover {
    color: ' . $primary_color . ' !important;
}

a:hover,
.btn-link:hover,
.single-product .product_meta a:hover {
    color: '. sass_darken( $primary_color, '15%' ) .';
}

table.wishlist_table .product-name a:hover,
.header-nav-menu-block li a:hover,
.hero-form-6 .small span a:hover,
.hero-form-7 .small span a:hover,
.header-nav-menu-block li a:hover {
    color: ' . sass_darken(  $primary_color, '15%' ) . ' !important;
}

.u-hero-v1__last-next {
    color: ' . sass_darken( $primary_color, '20%' ) . ';
}

ul.page-numbers > li > a.current,
ul.page-numbers > li > span.current,
.hp-listing-dashboard .hp-pagination .page-numbers.current,
.demo_store,
.badge-primary,
.bg-primary,
.btn-primary,
.btn-outline-primary:hover, 
.wp-block-button.is-style-outline .wp-block-button__link:hover,
.footer-button-link a:not(:hover), input:not(:hover)[type="submit"], 
.wp-block-file__button:not(:hover), 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(:hover), 
.widget.widget_price_filter button:not(:hover), 
.widget.widget_layered_nav button:not(:hover), 
.shop-sidebar .widget.widget_search .search-submit:not(:hover), 
.shop-sidebar .widget.woocommerce.widget_product_search button:not(:hover)[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:hover)[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:not(:hover)[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:hover)[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:not(:hover)[type=submit],
.widget_price_filter .ui-slider .ui-slider-range,
.front_widget_price_filter .u-range-slider .ui-slider-range,
.footer-button-link a:hover, 
input:hover[type="submit"], 
.wp-block-file__button:hover, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:hover, 
.widget.widget_price_filter button:hover, 
.widget.widget_layered_nav button:hover, 
.shop-sidebar .widget.widget_search .search-submit:hover, 
.shop-sidebar .widget.woocommerce.widget_product_search button:hover[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:hover[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:hover[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:hover[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:hover[type=submit],
.btn-primary:hover,
.btn-soft-primary[href]:hover, 
.btn-soft-primary[href]:focus, 
.btn-soft-primary[href]:active, 
.btn-soft-primary[href].active, 
.btn-soft-primary[type]:hover, 
.btn-soft-primary[type]:focus, 
.btn-soft-primary[type]:active, 
.btn-soft-primary[type].active,
.u-slick__arrow:not(.u-slick__arrow--flat-white):hover,
.u-slick__pagination li span,
.btn-custom-toggle-primary:not(:disabled):not(.disabled):active, 
.btn-custom-toggle-primary:not(:disabled):not(.disabled).active, 
.btn-custom-toggle-primary:not(:disabled):not(.disabled):active, 
.btn-custom-toggle-primary:not(:disabled):not(.disabled).active,
.u-go-to,
.u-slick__arrow-classic:hover,
.u-media-viewer__icon,
.btn-outline-primary:not(:disabled):not(.disabled):active, 
.wp-block-button.is-style-outline .wp-block-button__link:not(:disabled):not(.disabled):active, 
.btn-outline-primary:not(:disabled):not(.disabled).active, 
.wp-block-button.is-style-outline .wp-block-button__link:not(:disabled):not(.disabled).active, 
.show > .btn-outline-primary.dropdown-toggle, 
.wp-block-button.is-style-outline .show > .dropdown-toggle.wp-block-button__link,
.contact-form.wpforms-container .wpforms-field-checkbox li.wpforms-selected label:before, 
div.wpforms-container-full.contact-form .wpforms-field-checkbox li.wpforms-selected label:before, 
.subscribe-form.wpforms-container .wpforms-field-checkbox li.wpforms-selected label:before, 
div.wpforms-container-full.subscribe-form .wpforms-field-checkbox li.wpforms-selected label:before,
.contact-form.wpforms-container .wpforms-field-radio li.wpforms-selected label:before, 
div.wpforms-container-full.contact-form .wpforms-field-radio li.wpforms-selected label:before, 
.subscribe-form.wpforms-container .wpforms-field-radio li.wpforms-selected label:before, 
div.wpforms-container-full.subscribe-form .wpforms-field-radio li.wpforms-selected label:before,
.page-item.active .page-link, ul.page-numbers > li.active .page-link, 
.page-item.active ul.page-numbers > li > a, 
ul.page-numbers > li.active ul.page-numbers > li > a, 
.page-item.active ul.page-numbers > li > span, 
ul.page-numbers > li.active ul.page-numbers > li > span,
.custom-control-input:checked ~ .custom-control-label::before,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:focus, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:focus, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist a.add_to_wishlist:focus, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist a.add_to_wishlist:hover,
.progress-bar,
.btn-soft-primary[href]:not(:disabled):not(.disabled):active, 
.btn-soft-primary[href]:not(:disabled):not(.disabled).active, 
.show > .btn-soft-primary[href].dropdown-toggle, 
.btn-soft-primary[type]:not(:disabled):not(.disabled):active, 
.btn-soft-primary[type]:not(:disabled):not(.disabled).active, 
.show > .btn-soft-primary[type].dropdown-toggle,
.front-slick-carousel .slick-dots li,
.shop-sidebar .widget.woocommerce-widget-layered-nav ul li.chosen a:before, 
.shop-sidebar .widget.widget_rating_filter ul li.chosen a:before,
.wpjm-pagination .page-numbers.current, 
.wpjmr-pagination .page-numbers.current, 
.mas-wpjmc-pagination ul .page-numbers.current,
.site-footer__default.style-v2 .social-icon-menu a[href]:hover, 
.site-footer__default.style-v2 .social-icon-menu a[href]:focus, 
.site-footer__default.style-v2 .social-icon-menu a[href]:active, 
.site-footer__default.style-v2 .social-icon-menu a[href].active, 
.site-footer__default.style-v2 .social-icon-menu a[type]:hover, 
.site-footer__default.style-v2 .social-icon-menu a[type]:focus, 
.site-footer__default.style-v2 .social-icon-menu a[type]:active, 
.site-footer__default.style-v2 .social-icon-menu a[type].active,
.u-range-slider .irs-bar,
.u-range-slider .irs-bar-edge,
.u-hamburger:hover .u-hamburger__inner, 
.u-hamburger:hover .u-hamburger__inner::before, 
.u-hamburger:hover .u-hamburger__inner::after,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist i.yith-wcwl-icon:hover,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist i.yith-wcwl-icon:focus {
    background: ' . $primary_color . ';
}

.btn-primary,
.btn-primary:hover {
    background: ' . $primary_color . ' !important;
}

.has-primary-background-color {
    background-color: ' . $primary_color . ';
}

.bg-primary,
.select2-container.select2-container--default .select2-results__option--highlighted, 
.site-footer .widget.widget_product_search .woocommerce-product-search button[type="submit"],
.wp-block-pullquote:not(.is-style-solid-color) blockquote {
    background-color: ' . $primary_color . ' !important;
}

.u-blog-thumb-minimal:hover {
    background-color: ' . sass_darken( $primary_color, '5.85%' ) . ';
}

a.bg-primary:hover, 
.select2-container.select2-container--default a.select2-results__option--highlighted:hover, 
a.bg-primary:focus, 
.select2-container.select2-container--default a.select2-results__option--highlighted:focus, 
button.bg-primary:hover, 
.select2-container.select2-container--default button.select2-results__option--highlighted:hover, 
.site-footer .widget.widget_product_search .woocommerce-product-search button:hover[type="submit"], 
button.bg-primary:focus, 
.select2-container.select2-container--default button.select2-results__option--highlighted:focus, 
.site-footer .widget.widget_product_search .woocommerce-product-search button:focus[type="submit"] {
    background: ' . sass_darken( $primary_color, '10%' ) . ' !important;
}

.footer-button-link a:not(:disabled):not(.disabled):active, 
input:not(:disabled):not(.disabled):active[type="submit"], 
.wp-block-file__button:not(:disabled):not(.disabled):active, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(:disabled):not(.disabled):active, 
.widget.widget_price_filter button:not(:disabled):not(.disabled):active, 
.widget.widget_layered_nav button:not(:disabled):not(.disabled):active, 
.shop-sidebar .widget.widget_search .search-submit:not(:disabled):not(.disabled):active, 
.shop-sidebar .widget.woocommerce.widget_product_search button:not(:disabled):not(.disabled):active[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled):active[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled):active[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled):active[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled):active[type=submit], 
.footer-button-link a:not(:disabled):not(.disabled).active, input:not(:disabled):not(.disabled).active[type="submit"], 
.wp-block-file__button:not(:disabled):not(.disabled).active, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(:disabled):not(.disabled).active, 
.widget.widget_price_filter button:not(:disabled):not(.disabled).active, 
.widget.widget_layered_nav button:not(:disabled):not(.disabled).active, 
.shop-sidebar .widget.widget_search .search-submit:not(:disabled):not(.disabled).active, 
.shop-sidebar .widget.woocommerce.widget_product_search button:not(:disabled):not(.disabled).active[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled).active[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled).active[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled).active[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled).active[type=submit], 
.footer-button-link .show > a.dropdown-toggle, .show > input.dropdown-toggle[type="submit"], 
.show > .dropdown-toggle.wp-block-file__button, 
.wp-block-button:not(.is-style-outline) .show > .dropdown-toggle.wp-block-button__link, 
.widget.widget_price_filter .show > button.dropdown-toggle, 
.widget.widget_layered_nav .show > button.dropdown-toggle, 
.shop-sidebar .widget.widget_search .show > .dropdown-toggle.search-submit, 
.shop-sidebar .widget.woocommerce.widget_product_search .show > button.dropdown-toggle[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container .show > button.dropdown-toggle.btn-primary[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form .show > button.dropdown-toggle.btn-primary[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container .show > button.dropdown-toggle.btn-primary[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form .show > button.dropdown-toggle.btn-primary[type=submit],
.btn-primary:not(:disabled):not(.disabled):active, 
.btn-primary:not(:disabled):not(.disabled).active, 
.show > .btn-primary.dropdown-toggle {
    background-color: ' . sass_darken( $primary_color, '10%' ) . ';
}

.btn-primary:not(:disabled):not(.disabled):active, 
.btn-primary:not(:disabled):not(.disabled).active {
    background-color: ' . sass_darken( $primary_color, '10%' ) . ' !important;
}

.front-user-account-menu-sidebar li a.active,
.front-user-account-menu-sidebar li a:hover,
.front-wpjm-pages .bootstrap-select > .bs-placeholder:not(:hover),
.front-wpjmr-pages .bootstrap-select > .bs-placeholder:not(:hover),
.mas-wpjmc-pages .bootstrap-select > .bs-placeholder:not(:hover),
.job-manager-alert-pages .bootstrap-select > .bs-placeholder:not(:hover),
.wpjm-pagination .page-numbers:hover, 
.wpjmr-pagination .page-numbers:hover,
.mas-wpjmc-pagination ul .page-numbers:hover,
.link__icon,
.btn-soft-primary,
.u-slick__arrow:not(.u-slick__arrow--flat-white),
.u-go-to-ver-arrow ,
.page-link:hover, 
ul.page-numbers > li > a:hover, 
ul.page-numbers > li > span:hover,
.btn-soft-primary[href].disabled, 
.btn-soft-primary[href]:disabled, 
.btn-soft-primary[type].disabled, 
.btn-soft-primary[type]:disabled,
.shop-sidebar .widget.woocommerce-widget-layered-nav .maxlist-more .link:after,
.site-footer__default.style-v2 .social-icon-menu a:not(:hover),
.u-sidebar--account__list-link.active, 
.u-sidebar--account__list-link:hover {
    background-color: '. sass_hex_to_rgba($primary_color, .1) . ';
}

ul.page-numbers > li > a.current, ul.page-numbers > li > span.current,
.btn-outline-primary,
.btn-outline-primary:hover, 
.wp-block-button.is-style-outline .wp-block-button__link:hover,
.footer-button-link a, 
input[type="submit"], 
.wp-block-file__button, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link, 
.widget.widget_price_filter button, 
.widget.widget_layered_nav button, 
.shop-sidebar .widget.widget_search .search-submit, 
.shop-sidebar .widget.woocommerce.widget_product_search button[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary[type=submit],
.footer-button-link a:hover, input:hover[type="submit"], 
.wp-block-file__button:hover, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:hover, 
.widget.widget_price_filter button:hover, .widget.widget_layered_nav button:hover, 
.shop-sidebar .widget.widget_search .search-submit:hover, 
.shop-sidebar .widget.woocommerce.widget_product_search button:hover[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:hover[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:hover[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:hover[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:hover[type=submit],
.btn-primary:hover,
.btn-primary,
.u-slick__pagination li.slick-active span,
.btn-custom-toggle-primary:not(:disabled):not(.disabled):active, 
.btn-custom-toggle-primary:not(:disabled):not(.disabled).active, 
.btn-custom-toggle-primary:not(:disabled):not(.disabled):active, 
.btn-custom-toggle-primary:not(:disabled):not(.disabled).active,
.btn-custom-toggle-primary:hover,
.btn-outline-primary:not(:disabled):not(.disabled):active, 
.wp-block-button.is-style-outline .wp-block-button__link:not(:disabled):not(.disabled):active, 
.btn-outline-primary:not(:disabled):not(.disabled).active, 
.wp-block-button.is-style-outline .wp-block-button__link:not(:disabled):not(.disabled).active, 
.show > .btn-outline-primary.dropdown-toggle, 
.wp-block-button.is-style-outline .show > .dropdown-toggle.wp-block-button__link,
.contact-form.wpforms-container .wpforms-field-checkbox li.wpforms-selected label:before, 
div.wpforms-container-full.contact-form .wpforms-field-checkbox li.wpforms-selected label:before,
.subscribe-form.wpforms-container .wpforms-field-checkbox li.wpforms-selected label:before, 
div.wpforms-container-full.subscribe-form .wpforms-field-checkbox li.wpforms-selected label:before,
.contact-form.wpforms-container .wpforms-field-radio li.wpforms-selected label:before, 
div.wpforms-container-full.contact-form .wpforms-field-radio li.wpforms-selected label:before,
.subscribe-form.wpforms-container .wpforms-field-radio li.wpforms-selected label:before, 
div.wpforms-container-full.subscribe-form .wpforms-field-radio li.wpforms-selected label:before,
.page-item.active .page-link, ul.page-numbers > li.active .page-link, 
.page-item.active ul.page-numbers > li > a,
ul.page-numbers > li.active ul.page-numbers > li > a, 
.page-item.active ul.page-numbers > li > span, 
ul.page-numbers > li.active ul.page-numbers > li > span,
.custom-control-input:checked ~ .custom-control-label::before,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist a.add_to_wishlist,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:focus, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:focus, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist a.add_to_wishlist:focus, 
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist a.add_to_wishlist:hover,
.front-slick-carousel .slick-dots li.slick-active,
.shop-sidebar .widget.woocommerce-widget-layered-nav ul li.chosen a:before, 
.shop-sidebar .widget.widget_rating_filter ul li.chosen a:before,
.wpjm-pagination .page-numbers.current, 
.wpjmr-pagination .page-numbers.current, 
.mas-wpjmc-pagination ul .page-numbers.current,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist i.yith-wcwl-icon,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist i.yith-wcwl-icon:hover,
.shop-hero-slider .js-slide .yith-wcwl-add-to-wishlist i.yith-wcwl-icon:focus {
    border-color: ' . $primary_color . ';
}

.btn-primary:hover,
.btn-primary {
    border-color: ' . $primary_color . ' !important;
}

.select2.select2-container.select2-container--focus .select2-selection--multiple,
.custom-select:focus, 
select:focus, 
.select2.select2-container .select2-selection--single:focus, 
.select2.select2-container .select2-selection--multiple:focus, 
.form-control:focus,
.shop-sidebar .widget .search-field:focus, 
.widget_price_filter .price_label .from:focus, 
.widget_price_filter .price_label .to:focus, 
.input-text:focus, 
.input-date:focus, 
textarea:focus, 
.subscribe-form.wpforms-container .wpforms-field-text input[type=text]:focus,
 .subscribe-form.wpforms-container .wpforms-field-email input[type=email]:focus, 
 .subscribe-form.wpforms-container .wpforms-field-name input[type=text]:focus, 
 .subscribe-form.wpforms-container .wpforms-field-select select:focus, 
 .subscribe-form.wpforms-container .wpforms-field-number input[type=number]:focus, 
 div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-text input[type=text]:focus, 
 div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-email input[type=email]:focus, 
 div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-name input[type=text]:focus, 
 div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-select select:focus, 
 div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-number input[type=text]:focus, 
 .subscribe-form.wpforms-container textarea:focus, div.wpforms-container-full.subscribe-form textarea:focus, 
 .contact-form.wpforms-container .wpforms-field-text input[type=text]:focus, 
 .contact-form.wpforms-container .wpforms-field-email input[type=email]:focus, 
 .contact-form.wpforms-container .wpforms-field-name input[type=text]:focus, 
 .contact-form.wpforms-container .wpforms-field-select select:focus, 
 .contact-form.wpforms-container .wpforms-field-number input[type=number]:focus, 
 div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-text input[type=text]:focus, 
 div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-email input[type=email]:focus, 
 div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-name input[type=text]:focus, 
 div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-select select:focus, 
 div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-number input[type=text]:focus, 
.contact-form.wpforms-container textarea:focus,
 div.wpforms-container-full.contact-form textarea:focus {
    border-color: '. sass_hex_to_rgba($primary_color, .5) . ';
}

.single-product .product_meta a:hover {
    border-color: ' . sass_darken( $primary_color, '15%' ) . ';
}

.footer-button-link a:not(:disabled):not(.disabled):active, 
input:not(:disabled):not(.disabled):active[type="submit"], 
.wp-block-file__button:not(:disabled):not(.disabled):active, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(:disabled):not(.disabled):active, 
.widget.widget_price_filter button:not(:disabled):not(.disabled):active, 
.widget.widget_layered_nav button:not(:disabled):not(.disabled):active, 
.shop-sidebar .widget.widget_search .search-submit:not(:disabled):not(.disabled):active, 
.shop-sidebar .widget.woocommerce.widget_product_search button:not(:disabled):not(.disabled):active[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled):active[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled):active[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled):active[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled):active[type=submit], 
.footer-button-link a:not(:disabled):not(.disabled).active, input:not(:disabled):not(.disabled).active[type="submit"], 
.wp-block-file__button:not(:disabled):not(.disabled).active, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(:disabled):not(.disabled).active, 
.widget.widget_price_filter button:not(:disabled):not(.disabled).active, 
.widget.widget_layered_nav button:not(:disabled):not(.disabled).active, 
.shop-sidebar .widget.widget_search .search-submit:not(:disabled):not(.disabled).active, 
.shop-sidebar .widget.woocommerce.widget_product_search button:not(:disabled):not(.disabled).active[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled).active[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled).active[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled).active[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled).active[type=submit], 
.footer-button-link .show > a.dropdown-toggle, .show > input.dropdown-toggle[type="submit"], 
.show > .dropdown-toggle.wp-block-file__button, 
.wp-block-button:not(.is-style-outline) .show > .dropdown-toggle.wp-block-button__link, 
.widget.widget_price_filter .show > button.dropdown-toggle, 
.widget.widget_layered_nav .show > button.dropdown-toggle, 
.shop-sidebar .widget.widget_search .show > .dropdown-toggle.search-submit, 
.shop-sidebar .widget.woocommerce.widget_product_search .show > button.dropdown-toggle[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container .show > button.dropdown-toggle.btn-primary[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form .show > button.dropdown-toggle.btn-primary[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container .show > button.dropdown-toggle.btn-primary[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form .show > button.dropdown-toggle.btn-primary[type=submit] {
    border-color: ' . sass_darken( $primary_color, '10%' ) . ';
}

.btn-primary:not(:disabled):not(.disabled):active, 
.btn-primary:not(:disabled):not(.disabled).active, 
.show > .btn-primary.dropdown-toggle {
    border-color: ' . sass_darken( $primary_color, '12.6%' ) . ';
}

ul.job_listings .job_listing.job_position_featured>.card,
ul.resume_listings .resume.resume_featured>.card,
.card-frame-highlighted, .card-frame:hover {
    border-color: '. sass_hex_to_rgba($primary_color, .3) . ';
}

.navbar-expand-md .u-header__navbar-nav .u-header__sub-menu {
    border-top-color: ' . $primary_color . ';
}

.nav-classic .nav-link.active {
    border-bottom-color: ' . $primary_color . ';
}

.wpjm-pagination .page-numbers:hover, 
.wpjmr-pagination .page-numbers:hover,
.mas-wpjmc-pagination ul .page-numbers:hover,
.page-link:hover, 
ul.page-numbers > li > a:hover, 
ul.page-numbers > li > span:hover {
    border-color: '. sass_hex_to_rgba($primary_color, .1) . ';
}

.u-header-collapse__submenu .u-header-collapse__nav-list,
.u-header-collapse__submenu-list {
    border-left-color: ' . $primary_color . ';
}

.front-wpjm-pages .bootstrap-select > .bs-placeholder,
.front-wpjmr-pages .bootstrap-select > .bs-placeholder,
.mas-wpjmc-pages .bootstrap-select > .bs-placeholder,
.job-manager-alert-pages .bootstrap-select > .bs-placeholder {
    color: ' . $primary_color . ';
    background: ' . $primary_color . ';

}

.front-wpjm-pages .bootstrap-select > .bs-placeholder:hover,
.front-wpjmr-pages .bootstrap-select > .bs-placeholder:hover,
.mas-wpjmc-pages .bootstrap-select > .bs-placeholder:hover,
.job-manager-alert-pages .bootstrap-select > .bs-placeholder:hover,
 .front-wpjm-pages .bootstrap-select > .bs-placeholder:focus,
.front-wpjmr-pages .bootstrap-select > .bs-placeholder:focus,
.mas-wpjmc-pages .bootstrap-select > .bs-placeholder:focus,
.job-manager-alert-pages .bootstrap-select > .bs-placeholder:focus,
 .front-wpjm-pages .bootstrap-select > .bs-placeholder:active,
.front-wpjmr-pages .bootstrap-select > .bs-placeholder:active,
.mas-wpjmc-pages .bootstrap-select > .bs-placeholder:active,
.job-manager-alert-pages .bootstrap-select > .bs-placeholder:active {
    color: #fff;
    background: ' . $primary_color . ';
    box-shadow: 0 4px 11px '. sass_hex_to_rgba($primary_color, .35) . '; 

}

.added_to_cart {
    color: ' . $primary_color . ';
    border-color: ' . $primary_color . ';
}

.added_to_cart:hover,
.added_to_cart:focus,
.added_to_cart:active {
    color: #fff;
    background-color: ' . $primary_color . ';
    border-color: ' . $primary_color . ';
}

.footer-button-link a[href]:hover, 
input[href]:hover[type="submit"], 
.wp-block-file__button[href]:hover, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link[href]:hover, 
.widget.widget_price_filter button[href]:hover, 
.widget.widget_layered_nav button[href]:hover, 
.shop-sidebar .widget.widget_search .search-submit[href]:hover, 
.shop-sidebar .widget.woocommerce.widget_product_search button[href]:hover[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary[href]:hover[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary[href]:hover[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary[href]:hover[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary[href]:hover[type=submit], 
.footer-button-link a[href]:focus, input[href]:focus[type="submit"], .wp-block-file__button[href]:focus, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link[href]:focus, 
.widget.widget_price_filter button[href]:focus, .widget.widget_layered_nav button[href]:focus,
.shop-sidebar .widget.widget_search .search-submit[href]:focus, 
.shop-sidebar .widget.woocommerce.widget_product_search button[href]:focus[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary[href]:focus[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary[href]:focus[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary[href]:focus[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary[href]:focus[type=submit], 
.footer-button-link a[href]:active, input[href]:active[type="submit"], .wp-block-file__button[href]:active, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link[href]:active, 
.widget.widget_price_filter button[href]:active, .widget.widget_layered_nav button[href]:active, 
.shop-sidebar .widget.widget_search .search-submit[href]:active, 
.shop-sidebar .widget.woocommerce.widget_product_search button[href]:active[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary[href]:active[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary[href]:active[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary[href]:active[type=submit],
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary[href]:active[type=submit], 
.footer-button-link a[type]:hover, input[type]:hover[type="submit"], .wp-block-file__button[type]:hover, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link[type]:hover, 
.widget.widget_price_filter button[type]:hover, .widget.widget_layered_nav button[type]:hover, 
.shop-sidebar .widget.widget_search .search-submit[type]:hover, 
.shop-sidebar .widget.woocommerce.widget_product_search button[type]:hover[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary[type]:hover[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary[type]:hover[type=submit],
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary[type]:hover[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary[type]:hover[type=submit], 
.footer-button-link a[type]:focus, input[type]:focus[type="submit"], .wp-block-file__button[type]:focus, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link[type]:focus, 
.widget.widget_price_filter button[type]:focus, .widget.widget_layered_nav button[type]:focus, 
.shop-sidebar .widget.widget_search .search-submit[type]:focus, 
.shop-sidebar .widget.woocommerce.widget_product_search button[type]:focus[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary[type]:focus[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary[type]:focus[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary[type]:focus[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary[type]:focus[type=submit], 
.footer-button-link a[type]:active, input[type]:active[type="submit"], .wp-block-file__button[type]:active, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link[type]:active, 
.widget.widget_price_filter button[type]:active, .widget.widget_layered_nav button[type]:active, 
.shop-sidebar .widget.widget_search .search-submit[type]:active, 
.shop-sidebar .widget.woocommerce.widget_product_search button[type]:active[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary[type]:active[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary[type]:active[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary[type]:active[type=submit],
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary[type]:active[type=submit],
.btn-primary[href]:hover, 
.btn-primary[href]:focus, 
.btn-primary[href]:active, 
.btn-primary[type]:hover, 
.btn-primary[type]:focus, 
.btn-primary[type]:active,
.btn-soft-primary[href]:hover, 
.btn-soft-primary[href]:focus, 
.btn-soft-primary[href]:active, 
.btn-soft-primary[href].active, 
.btn-soft-primary[type]:hover, 
.btn-soft-primary[type]:focus, 
.btn-soft-primary[type]:active, 
.btn-soft-primary[type].active,
.site-footer__default.style-v2 .social-icon-menu a[href]:hover, 
.site-footer__default.style-v2 .social-icon-menu a[href]:focus, 
.site-footer__default.style-v2 .social-icon-menu a[href]:active, 
.site-footer__default.style-v2 .social-icon-menu a[href].active, 
.site-footer__default.style-v2 .social-icon-menu a[type]:hover, 
.site-footer__default.style-v2 .social-icon-menu a[type]:focus, 
.site-footer__default.style-v2 .social-icon-menu a[type]:active, 
.site-footer__default.style-v2 .social-icon-menu a[type].active {
    box-shadow: 0 4px 11px '. sass_hex_to_rgba($primary_color, 0.35) . '; 
 }

ul.job_listings .job_listing.job_position_featured>.card,
ul.resume_listings .resume.resume_featured>.card,
.card-frame-highlighted, .card-frame:hover {
    box-shadow: 0 0 35px '. sass_hex_to_rgba($primary_color, .125) . '; 
}

.shadow-primary-lg, 
.wp-block-pullquote:not(.is-style-solid-color) blockquote {
    box-shadow: 0 0 50px '. sass_hex_to_rgba($primary_color, 0.4) . '!important;
}

.shop-sidebar .widget .search-field:focus, 
.widget_price_filter .price_label .from:focus, 
.widget_price_filter .price_label .to:focus, 
.input-text:focus, 
.input-date:focus, 
textarea:focus, 
.subscribe-form.wpforms-container .wpforms-field-text input[type=text]:focus, 
.subscribe-form.wpforms-container .wpforms-field-email input[type=email]:focus, 
.subscribe-form.wpforms-container .wpforms-field-name input[type=text]:focus,
.subscribe-form.wpforms-container .wpforms-field-select select:focus, 
.subscribe-form.wpforms-container .wpforms-field-number input[type=number]:focus, 
div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-text input[type=text]:focus, 
div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-email input[type=email]:focus, 
div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-name input[type=text]:focus, 
div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-select select:focus, 
div.wpforms-container-full.subscribe-form .wpforms-form .wpforms-field-number input[type=text]:focus, 
.subscribe-form.wpforms-container textarea:focus, 
div.wpforms-container-full.subscribe-form textarea:focus, 
.contact-form.wpforms-container .wpforms-field-text input[type=text]:focus, 
.contact-form.wpforms-container .wpforms-field-email input[type=email]:focus, 
.contact-form.wpforms-container .wpforms-field-name input[type=text]:focus, 
.contact-form.wpforms-container .wpforms-field-select select:focus, 
.contact-form.wpforms-container .wpforms-field-number input[type=number]:focus, 
div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-text input[type=text]:focus, 
div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-email input[type=email]:focus, 
div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-name input[type=text]:focus, 
div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-select select:focus, 
div.wpforms-container-full.contact-form .wpforms-form .wpforms-field-number input[type=text]:focus, 
.contact-form.wpforms-container textarea:focus, 
div.wpforms-container-full.contact-form textarea:focus {
    box-shadow: 0 0 10px '. sass_hex_to_rgba($primary_color, 0.1) . '; 
}

.footer-button-link a:not(:disabled):not(.disabled):active:focus, 
input:not(:disabled):not(.disabled):active:focus[type="submit"], 
.wp-block-file__button:not(:disabled):not(.disabled):active:focus, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(:disabled):not(.disabled):active:focus, 
.widget.widget_price_filter button:not(:disabled):not(.disabled):active:focus, 
.widget.widget_layered_nav button:not(:disabled):not(.disabled):active:focus, 
.shop-sidebar .widget.widget_search .search-submit:not(:disabled):not(.disabled):active:focus, 
.shop-sidebar .widget.woocommerce.widget_product_search button:not(:disabled):not(.disabled):active:focus[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled):active:focus[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled):active:focus[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled):active:focus[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled):active:focus[type=submit], 
.footer-button-link a:not(:disabled):not(.disabled).active:focus, 
input:not(:disabled):not(.disabled).active:focus[type="submit"], 
.wp-block-file__button:not(:disabled):not(.disabled).active:focus, 
.wp-block-button:not(.is-style-outline) .wp-block-button__link:not(:disabled):not(.disabled).active:focus, 
.widget.widget_price_filter button:not(:disabled):not(.disabled).active:focus, 
.widget.widget_layered_nav button:not(:disabled):not(.disabled).active:focus, 
.shop-sidebar .widget.widget_search .search-submit:not(:disabled):not(.disabled).active:focus, 
.shop-sidebar .widget.woocommerce.widget_product_search button:not(:disabled):not(.disabled).active:focus[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled).active:focus[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled).active:focus[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container button.btn-primary:not(:disabled):not(.disabled).active:focus[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form button.btn-primary:not(:disabled):not(.disabled).active:focus[type=submit], 
.footer-button-link .show > a.dropdown-toggle:focus, 
.show > input.dropdown-toggle:focus[type="submit"], 
.show > .dropdown-toggle.wp-block-file__button:focus, 
.wp-block-button:not(.is-style-outline) .show > .dropdown-toggle.wp-block-button__link:focus, 
.widget.widget_price_filter .show > button.dropdown-toggle:focus, 
.widget.widget_layered_nav .show > button.dropdown-toggle:focus, 
.shop-sidebar .widget.widget_search .show > .dropdown-toggle.search-submit:focus, 
.shop-sidebar .widget.woocommerce.widget_product_search .show > button.dropdown-toggle:focus[type="submit"], 
.subscribe-form.wpforms-container .wpforms-submit-container .show > button.dropdown-toggle.btn-primary:focus[type=submit], 
div.wpforms-container-full.subscribe-form .wpforms-form .show > button.dropdown-toggle.btn-primary:focus[type=submit], 
.contact-form.wpforms-container .wpforms-submit-container .show > button.dropdown-toggle.btn-primary:focus[type=submit], 
div.wpforms-container-full.contact-form .wpforms-form .show > button.dropdown-toggle.btn-primary:focus[type=submit],
.added_to_cart:focus {
    box-shadow: 0 0 0 0.2rem '. sass_hex_to_rgba($primary_color, 0.5) . '; 
}

.wpjm-pagination .page-numbers:focus, 
.wpjmr-pagination .page-numbers:focus, 
.mas-wpjmc-pagination ul .page-numbers:focus {
    box-shadow: 0 0 0 0.2rem '. sass_hex_to_rgba($primary_color, .25) . ';
}

.site-footer.site-footer__default .product-categories .cat-item-link,
.header-nav-menu-block li a,
.text-secondary {
    color: ' . $secondary_color . ' !important;
}

p,
.single-product__price del span.amount, 
.single-product .woocommerce-variation-price .price del span.amount,
.single-product .summary .yith-wcwl-add-to-wishlist a.add_to_wishlist, 
.single-product .summary .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a, 
.single-product .summary .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
[data-view=list] ul.products li.product .product-short-description ul,
.shop-sidebar .widget ul li,
.shop-sidebar .widget:not(.widget_product_categories) ul li a,
.contact-form.contact-form-1.wpforms-container .wpforms-head-container .wpforms-description, 
div.wpforms-container-full.contact-form.contact-form-1 .wpforms-head-container .wpforms-description,
.offcanvas-menu-sidebar.u-header-collapse__nav .u-header-collapse__nav-link.text-secondary-color:not(:hover),
.u-header-collapse__nav-link:not(:hover),
table.wishlist_table td.product-remove a.remove:before,
.u-header__sub-menu-nav-link,
.u-header-collapse__submenu-nav-link,
.u-header-collapse__submenu-list-link,
.u-header__navbar-link,
.list-group .disabled .u-icon,
.u-area-chart__tooltip,
.u-header__nav-link,
dl,
ul,
ol,
address,
table,
pre,
.has-secondary-color {
    color: ' . $secondary_color . ';
}

.has-secondary-background-color {
    background-color: ' . $secondary_color . ';
}

a.text-secondary:hover, 
a.text-secondary:focus {
  color: ' . sass_darken( $secondary_color, '15%' ) . ' !important;
}

.list-group .disabled .u-icon {
    background-color: '. sass_hex_to_rgba($secondary_color, .1) . '; 
}

.site-footer.site-footer__default.style-v3 .footer-social-menu a:hover, 
.site-footer.site-footer__default.style-v6 .footer-social-menu a:hover, 
.site-footer.site-footer__default.style-v4 .footer-social-menu a:hover, 
.site-footer.site-footer__default.style-v12 .footer-social-menu a:hover, 
.site-footer.site-footer__default.style-v13 .footer-social-menu a:hover, 
.site-footer.site-footer__default.style-v14 .footer-social-menu a:hover, 
.site-footer.site-footer__default.style-v15 .footer-social-menu a:hover {
    background: ' . $secondary_color . ' !important;
}

.fill-primary  {
    fill: ' . $primary_color . ' !important;
}

.fill-primary-darker  {
    fill: ' . $primary_darker . ' !important;
}

.fill-primary-lighter  {
    fill: ' . $primary_lighter . ' !important;
}

.stroke-primary {
    stroke: ' . $primary_color . ' !important;
}

.stop-color-primary {
    stop-color: ' . $primary_color . ' !important;
}

.stop-color-primary-darker {
    stop-color: ' . $primary_darker . ' !important;
}

.stop-color-primary-lighter {
    stop-color: ' . $primary_lighter . ' !important;
}

.gradient-half-primary-body-v1,
.gradient-half-primary-v1,
.gradient-half-primary-v1:before  {
    background-image: linear-gradient(150deg, ' . $gradient_half_indigo . ' 0%, ' . $primary_lighter . ' 100%);

}

.gradient-half-primary-v2 {
    background-image: linear-gradient(0deg, '. sass_hex_to_rgba($primary_color, .05) . ' 0%, transparent 100%);
}

.gradient-half-primary-v3,
.gradient-half-primary-v3:before {
    background-image: linear-gradient(0deg, '. sass_hex_to_rgba($primary_color, 0.1) . ' 0%, transparent 100%);
}

.gradient-half-primary-v4 {
    background-image: linear-gradient(150deg, ' . $gradient_half_indigo . ' 0%, ' . $primary_lighter . ' 85%);
}

.gradient-half-primary-v5 {
    background-image: linear-gradient(150deg, ' . $primary_color . ' 0%, ' . $gradient_half_indigo . ' 100%);
}

.gradient-half-info-v1 {
    background-image: linear-gradient(0deg,' . $primary_color . ' 0%,' . $gradient_half_info . ' 100%);
}

.gradient-half-warning-v1 {
    background-image: linear-gradient(25deg,' . $gradient_half_warning . ' 30%,' . $gradient_half_danger . ' 100%);
}

.gradient-half-warning-v2 {
    background-image: linear-gradient(150deg,' . $gradient_half_warning . ' 0%,' . $gradient_half_warning_darker . ' 100%);
}

.gradient-half-warning-v3 {
    background-image: linear-gradient(150deg,' . $gradient_half_warning . ' 0%,' . $gradient_half_danger . ' 100%);
}

.gradient-overlay-half-primary-video-v1:before,
.gradient-overlay-half-primary-v1:before {
    background-image: linear-gradient(150deg, '. sass_hex_to_rgba($gradient_half_indigo, .9) . ' 0%, ' . sass_hex_to_rgba($primary_lighter, .85) . ' 100%);
    
}

.gradient-overlay-half-primary-v2:before {
    background-image: linear-gradient(30deg, '. sass_hex_to_rgba($primary_lighter, .85) . ' 0%, ' . sass_hex_to_rgba($gradient_half_indigo, .9) . ' 100%);
}

.gradient-overlay-half-primary-v3:before {
    background-image: linear-gradient(90deg, ' . $primary_color . ' 0%, ' . $primary_darker . ' 100%);
}

.gradient-overlay-half-primary-v4:before {
    background-image: linear-gradient(0deg, '. sass_hex_to_rgba($primary_color, .025) . ' 0%, ' . $gradient_overlay_half_white . ' 100%);
}

.gradient-overlay-half-indigo-v1:before {
    background-image: linear-gradient(45deg, transparent 50%, '. sass_hex_to_rgba($gradient_half_indigo, 0.1) . ' 100%);
}

.gradient-overlay-half-info-v1:before {
    background-image: linear-gradient(0deg, '. sass_hex_to_rgba($primary_color, .92) . ' 0%, '. sass_hex_to_rgba($gradient_half_info, .92) . ' 100%);
}

.gradient-overlay-half-dark-v1:before {
    background-image: linear-gradient(0deg, ' . $gradient_overlay_half_dark . ' 0%, transparent 75%);
}

.gradient-overlay-half-dark-v2:before {
    background-image: linear-gradient(150deg, '. sass_hex_to_rgba($primary_color, .35) . ' 0%, '. sass_hex_to_rgba($gradient_overlay_half_dark, 0.3) . ' 100%);
}

.u-fullscreen__overlay {
    background-image: linear-gradient(150deg, '. sass_hex_to_rgba($gradient_half_indigo, 0.95) . ' 0%,  '. sass_hex_to_rgba($primary_lighter, 0.95) . ' 100%)
}';

        return $styles;
    }
}

if ( ! function_exists( 'redux_get_custom_color_admin_css' ) ) {
    function redux_get_custom_color_admin_css() {
        global $front_options;

        if ( isset( $front_options['use_predefined_color'] ) && $front_options['use_predefined_color'] ) {
            return false;
        }

        $primary_color = isset( $front_options['custom_primary_color'] ) ? $front_options['custom_primary_color'] : '#377dff';
        $secondary_color = isset( $front_options['custom_secondary_color'] ) ? $front_options['custom_secondary_color'] : '#77838f';
        $editor_styles =
'
.components-panel__body > .components-panel__body-title svg.components-panel__icon {
color: ' . $primary_color . ';
}

svg[fill="url(#frontgb-gradient)"] path {
fill: ' . $primary_color . ' !important;
}

.frontgb-radiobutton-bg .components-radio-control__option input[value="primary"],
.frontgb-radiobutton-bg .components-radio-control__option input[value="bg-primary"],
.frontgb-radiobutton-bg .components-radio-control__option input[value="text-primary"] {
background-color: ' . $primary_color . ' !important;
}

.frontgb-radiobutton-bg .components-radio-control__option input[value=secondary],
.frontgb-radiobutton-bg .components-radio-control__option input[value=bg-secondary],
.frontgb-radiobutton-bg .components-radio-control__option input[value="text-secondary"] {
background-color: ' . $secondary_color . ' !important;
}
';
        wp_add_inline_style( 'fgb-block-editor-css', $editor_styles );
    }
}

if ( ! function_exists( 'redux_apply_custom_color_css' ) ) {
    function redux_apply_custom_color_css() {
        global $front_options;

        if ( isset( $front_options['use_predefined_color'] ) && $front_options['use_predefined_color'] ) {
            return;
        }

        $how_to_include = isset( $front_options['include_custom_color'] ) ? $front_options['include_custom_color'] : '1';

        $custom_color_css_external_file = redux_apply_custom_color_css_external_file();
        if ( $custom_color_css_external_file && $how_to_include != '1' ) {
            wp_enqueue_style( 'front-custom-color', $custom_color_css_external_file['url'] );
        } else {
            $css = redux_get_custom_color_css();
            $handle = 'front-style';
            wp_add_inline_style( $handle, $css );
        }
    }
}

if ( ! function_exists( 'redux_apply_custom_editor_color_palette_options' ) ) {
    function redux_apply_custom_editor_color_palette_options( $colors ) {
        global $front_options;

        if ( isset( $front_options['use_predefined_color'] ) && $front_options['use_predefined_color'] ) {
            return $colors;
        }

        $primary_color      = isset( $front_options['custom_primary_color'] ) ? $front_options['custom_primary_color'] : '#377dff';
        $secondary_color    = isset( $front_options['custom_secondary_color'] ) ? $front_options['custom_secondary_color'] : '#77838f';

        foreach ( $colors as $key => $color ) {
            if( $color['slug'] == 'primary' ) {
                $colors[$key]['color'] = $primary_color;
            } elseif( $color['slug'] == 'secondary' ) {
                $colors[$key]['color'] = $secondary_color;
            }
        }

        return $colors;
    }
}

function redux_apply_compiler_action( $options, $css, $changed_values ) {
    $custom_color_css_external_file = redux_apply_custom_color_css_external_file();
    if( $custom_color_css_external_file ) {
        Redux_Functions::initWpFilesystem();

        $css = redux_get_custom_color_css();

        $filename = $custom_color_css_external_file['filename'];

        global $wp_filesystem;

        if( $wp_filesystem ) {
            $wp_filesystem->put_contents( $filename, $css );
        }
    }
}

function redux_apply_custom_color_css_external_file() {
    $parent_theme_filename = get_template_directory() . '/assets/css/colors/custom-color.css';
    $parent_theme_fileurl = get_template_directory_uri() . '/assets/css/colors/custom-color.css';
    if( is_child_theme() ) {
        $child_theme_filename = get_stylesheet_directory() . '/custom-color.css';
        $child_theme_fileurl = get_stylesheet_directory_uri() . '/custom-color.css';
    }
    if( isset( $child_theme_filename ) && is_writable( $child_theme_filename ) ) {
        return array( 'filename' => $child_theme_filename, 'url' => $child_theme_fileurl );
    } elseif( isset( $parent_theme_filename ) && is_writable( $parent_theme_filename ) ) {
        return array( 'filename' => $parent_theme_filename, 'url' => $parent_theme_fileurl );
    }

    return false;
}

if( ! function_exists( 'redux_apply_block_editor_custom_color_css' ) ) {
    function redux_apply_block_editor_custom_color_css( $response, $parsed_args, $url ) {
        global $front_options;
        if ( isset( $front_options['use_predefined_color'] ) && $front_options['use_predefined_color'] ) {
            return false;
        }

        $how_to_include = isset( $front_options['include_custom_color'] ) ? $front_options['include_custom_color'] : '1';
        $custom_color_css_external_file = redux_apply_custom_color_css_external_file();

        if ( ! ($custom_color_css_external_file && $how_to_include != '1' ) && content_url( '/custom_theme_color_css' ) === $url ) {
            $response = array(
                'body'      => redux_get_custom_color_css(), // E.g. 'body { background-color: #fbca04; }'
                'headers'   => new Requests_Utility_CaseInsensitiveDictionary(),
                'response'  => array(
                    'code'      => 200,
                    'message'   => 'OK',
                ),
                'cookies'   => array(),
                'filename'  => null,
            );
        }

        return $response;
    }
}
