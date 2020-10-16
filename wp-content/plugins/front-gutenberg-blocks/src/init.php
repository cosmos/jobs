<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   0.1
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'frontgb_block_assets' ) ) {

    /**
    * Enqueue block assets for both frontend + backend.
    *
    * @since 0.1
    */
    function frontgb_block_assets() {
        global $front_version;

        // Frontend block styles.
        wp_enqueue_style(
            'fgb-style-css',
            plugins_url( 'dist/frontend_blocks.css', FRONTGB_FILE ),
            array(),
            FRONTGB_VERSION
        );

        // Frontend only scripts.
        if ( ! is_admin() ) {
            wp_enqueue_script(
                'fgb-block-frontend-js',
                plugins_url( 'dist/frontend_blocks.js', FRONTGB_FILE ),
                array(),
                FRONTGB_VERSION
            );
        }

        wp_enqueue_script( 'popper' );
        wp_enqueue_script( 'bootstrap' );

        wp_enqueue_script( 'megamenu' );
        wp_enqueue_script( 'slick-carousel' );
        wp_enqueue_script( 'svg-injector' );
        wp_enqueue_script( 'cubeportfolio' );

        wp_enqueue_script( 'front-hs-header' );
        wp_enqueue_script( 'front-hs-unfold' );
        wp_enqueue_script( 'front-hs-hamburgers' );
        wp_enqueue_script( 'front-hs-header-fullscreen' );
        wp_enqueue_script( 'front-hs-core' );
        wp_enqueue_script( 'front-hs-slick-carousel' );
        wp_enqueue_script( 'front-hs-svg-injector' );
        wp_enqueue_script( 'front-hs-cubeportfolio' );

        wp_enqueue_script( 'cubeportfolio' );
        wp_enqueue_script( 'front-hs-cubeportfolio' );

        wp_enqueue_script( 'front-hs-sticky-block' );

        wp_enqueue_script( 'front-hs-go-to' );

        wp_enqueue_script( 'appear' );
        wp_enqueue_script( 'front-hs-scroll-nav' );

        if( has_block( 'fgb/stats-interactive-1' ) ) {
            wp_enqueue_script( 'chartist' );
            wp_enqueue_script( 'chartist-tooltip' );
            wp_enqueue_script( 'front-hs-chartist' );
        }

        if( has_block( 'fgb/stats-interactive-2' ) ) {
            wp_enqueue_script( 'appear' );
            wp_enqueue_script( 'chartist' );
            wp_enqueue_script( 'chartist-tooltip' );
            wp_enqueue_script( 'front-hs-progress-bar' );
            wp_enqueue_script( 'front-hs-chartist-bar-chart' );
        }

        if( has_block( 'fgb/stats-interactive-3' ) ) {
            wp_enqueue_script( 'appear' );
            wp_enqueue_script( 'circles' );
            wp_enqueue_script( 'front-hs-chart-pie' );
            wp_enqueue_script( 'front-hs-go-to' );
        }

        if( has_block( 'fgb/video' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
            wp_enqueue_script( 'video-player' );
            wp_enqueue_script( 'front-hs-video-player' );
        }

        if( has_block( 'fgb/hero-post-2' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
            wp_enqueue_script( 'video-player' );
            wp_enqueue_script( 'front-hs-video-player' );
        }

        if( has_block( 'fgb/info-section-17' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/news-blog' ) ) {
            wp_enqueue_script( 'cubeportfolio' );
            wp_enqueue_script( 'front-hs-cubeportfolio' );
        }

        if( has_block( 'fgb/portfolio' ) ) {
            wp_enqueue_script( 'cubeportfolio' );
            wp_enqueue_script( 'front-hs-cubeportfolio' );
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/deals-product' ) ) {
            wp_enqueue_script( 'jquery-countdown' );
            wp_enqueue_script( 'front-hs-countdown' );
        }

        if( has_block( 'fgb/hero' ) ) {
            wp_enqueue_script( 'dzsparallaxer' );
            wp_enqueue_script( 'typed' );
        }

        if( has_block( 'fgb/clients' ) ) {
            wp_enqueue_script( 'dzsparallaxer' );
        }

        if( has_block( 'fgb/hero-carousel-1' ) ) {
            wp_enqueue_script( 'front-hs-go-to' );
        }

        if( has_block( 'fgb/hero-carousel-5' ) ) {
            wp_enqueue_script( 'front-hs-go-to' );
        }

        if( has_block( 'fgb/hero-carousel-6' ) ) {
            wp_enqueue_script( 'dzsparallaxer' );
        }

        if( has_block( 'fgb/pricing-interactive-1' ) ) {
            wp_enqueue_script( 'front-hs-show-animation' );
        }

        if( has_block( 'fgb/pricing-interactive-2' ) ) {
            wp_enqueue_script( 'front-hs-sticky-block' );
        }

        if( has_block( 'fgb/description-sticky' ) ) {
            wp_enqueue_script( 'front-hs-sticky-block' );
        }

        if( has_block( 'fgb/pricing-interactive-3' ) ) {
            wp_enqueue_script( 'dzsparallaxer' );
            wp_enqueue_script( 'ion-rangeslider' );
            wp_enqueue_script( 'front-hs-range-slider' );
            wp_enqueue_script( 'front-hs-show-animation' );
        }

        if( has_block( 'fgb/hero-fancybox' ) ) {
            wp_enqueue_script( 'typed' );
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/hero-form-3' ) ) {
            if ( ! is_admin() ) {
                wp_enqueue_script( 'bg-video' );
            }
            wp_enqueue_script( 'bg-video-player' );
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-bg-video' );
            wp_enqueue_script( 'front-hs-fancybox' );

            if ( ! is_admin() ) {
                wp_deregister_script( 'jquery' );
                wp_deregister_script( 'jquery-core' );
                wp_deregister_script( 'jquery-migrate' );
                wp_register_script( 'jquery-core', get_template_directory_uri() . '/assets/vendor/jquery/dist/jquery.min.js', array(), '3.3.1' );
                wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js', array(), '3.0.1' );
                wp_register_script( 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), null, false );
                wp_enqueue_script( 'jquery' );
            }
        }

        if( has_block( 'fgb/hero-form-6' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/simple-video-block' ) ) {
            if ( ! is_admin() ) {
                wp_enqueue_script( 'bg-video' );
            }
            wp_enqueue_script( 'bg-video-player' );
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-bg-video' );
            wp_enqueue_script( 'front-hs-fancybox' );

            if ( ! is_admin() ) {
                wp_deregister_script( 'jquery' );
                wp_deregister_script( 'jquery-core' );
                wp_deregister_script( 'jquery-migrate' );
                wp_register_script( 'jquery-core', get_template_directory_uri() . '/assets/vendor/jquery/dist/jquery.min.js', array(), '3.3.1' );
                wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js', array(), '3.0.1' );
                wp_register_script( 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), null, false );
                wp_enqueue_script( 'jquery' );
            }
        }

        if( has_block( 'fgb/hero-form-7'  ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/call-to-action'  ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/hero-actions' ) ) {
            wp_enqueue_script( 'typed' );
        }

        if( has_block( 'fgb/hero-video' ) ) {
            wp_enqueue_script( 'dzsparallaxer' );
            wp_enqueue_script( 'typed' );
            if ( ! is_admin() ) {
                wp_enqueue_script( 'bg-video' );
            }
            wp_enqueue_script( 'bg-video-player' );
            wp_enqueue_script( 'front-hs-bg-video' );

            if ( ! is_admin() ) {
                wp_deregister_script( 'jquery' );
                wp_deregister_script( 'jquery-core' );
                wp_deregister_script( 'jquery-migrate' );
                wp_register_script( 'jquery-core', get_template_directory_uri() . '/assets/vendor/jquery/dist/jquery.min.js', array(), '3.3.1' );
                wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js', array(), '3.0.1' );
                wp_register_script( 'jquery', false, array( 'jquery-core', 'jquery-migrate' ), null, false );
                wp_enqueue_script( 'jquery' );
            }
        }

        if( has_block( 'fgb/gallery-grid' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/gallery-masonry' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
            wp_enqueue_script( 'cubeportfolio' );
            wp_enqueue_script( 'front-hs-cubeportfolio' );
            wp_enqueue_script( 'dzsparallaxer' );
        }

        if( has_block( 'fgb/hero-form-39' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/info-section-8' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/info-colorfull' ) ) {
            wp_enqueue_script( 'jquery-fancybox' );
            wp_enqueue_script( 'front-hs-fancybox' );
        }

        if( has_block( 'fgb/list-group' ) ) {
            wp_enqueue_script( 'front-hs-scroll-nav' );
            wp_enqueue_script( 'front-hs-sticky-block' );
            wp_enqueue_script( 'front-anchor', get_template_directory_uri() . '/assets/js/anchor.js', array( 'front-hs-core' ), $front_version, true );
            wp_enqueue_script( 'front-term', get_template_directory_uri() . '/assets/js/term.js', array( 'front-hs-core', 'front-anchor-js' ), $front_version, true );
        }

        if( has_block( 'fgb/stats-interactive-4' ) ) {
            wp_enqueue_script( 'jquery-countdown' );
            wp_enqueue_script( 'front-hs-countdown' );
        }

        if( has_block( 'fgb/parallaxer-image' ) ) {
            wp_enqueue_script( 'dzsparallaxer' );
        }

        if( has_block( 'fgb/career-title' ) ) {
            wp_enqueue_script( 'front-hs-go-to' );
        }
    }

    add_action( 'enqueue_block_assets', 'frontgb_block_assets', 20 );
}

if ( ! function_exists( 'frontgb_block_editor_assets' ) ) {

    /**
     * Enqueue block assets for backend editor.
     *
     * @since 0.1
     */
    function frontgb_block_editor_assets() {

        // Backend editor scripts: common vendor files.
        wp_enqueue_script(
            'fgb-block-js-vendor',
            plugins_url( 'dist/editor_vendor.js', FRONTGB_FILE ),
            array(),
            FRONTGB_VERSION
        );

        // Backend editor scripts: blocks.
        wp_enqueue_script(
            'fgb-block-js',
            plugins_url( 'dist/editor_blocks.js', FRONTGB_FILE ),
            array( 'fgb-block-js-vendor', 'code-editor', 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-util', 'wp-plugins', 'wp-edit-post', 'wp-i18n', 'wp-api', 'front-hs-slick-carousel', 'front-hs-svg-injector' ),
            FRONTGB_VERSION
        );

        // Add translations.
        wp_set_script_translations( 'fgb-block-js', FRONTGB_I18N );

        // Backend editor only styles.
        wp_enqueue_style(
            'fgb-block-editor-css',
            plugins_url( 'dist/editor_blocks.css', FRONTGB_FILE ),
            array( 'wp-edit-blocks' ),
            FRONTGB_VERSION
        );

        global $content_width, $wp_registered_sidebars;
        $frontgb_script_data = array(
            'homeUrl'               => get_home_url(),
            'srcUrl'                => untrailingslashit( plugins_url( '/', FRONTGB_FILE ) ),
            'themeAssetsURL'        => front_get_assets_url(),
            'pluginAssetsURL'       => frontgb_get_assets_url(),
            'contentWidth'          => isset( $content_width ) ? $content_width : 900,
            'i18n'                  => FRONTGB_I18N,
            'disabledBlocks'        => frontgb_get_disabled_blocks(),
            'hasCustomLogo'         => has_custom_logo(),
            'isWoocommerceActive'   => function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated(),
            'wpRegisteredSidebars'  => json_encode( $wp_registered_sidebars ),
            // Overridable default primary color for buttons and other blocks.
            'primaryColor'          => get_theme_mod( 's_primary_color', '#2091e1' ),
            // Premium related variables. TODO: Remove
            'isPro'                 => false,
            'showProNotice'         => false,
            'pricingURL'            => '#',
            'planName'              => 'starter',
            'isRTL'                 => is_rtl(),
            'wpVersion'             => get_bloginfo('version')
        );
        wp_localize_script( 'fgb-block-js', 'frontgb', $frontgb_script_data );
    }
    add_action( 'enqueue_block_editor_assets', 'frontgb_block_editor_assets', 10 );
}

if ( ! function_exists( 'front_get_assets_url' ) ) {
    function front_get_assets_url() {
        return get_template_directory_uri() . '/assets/';
    }
}

if ( ! function_exists( 'frontgb_get_assets_url' ) ) {
    function frontgb_get_assets_url() {
        return untrailingslashit( plugins_url( '/', FRONTGB_FILE ) ) . '/assets/';
    }
}

if ( ! function_exists( 'frontgb_block_category' ) ) {

    /**
     * Add our custom block category for FrontGB blocks.
     *
     * @since 0.6
     */
    function frontgb_block_category( $categories, $post ) {
        return array_merge(
            $categories,
            array(
                array(
                    'slug'  => 'frontgb',
                    'title' => __( 'FrontGB', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-products',
                    'title' => __( 'FrontGB Products', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-info-blocks',
                    'title' => __( 'FrontGB Info Blocks', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-jobs',
                    'title' => __( 'FrontGB Jobs', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-hero',
                    'title' => __( 'FrontGB Hero', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-hero-carousel',
                    'title' => __( 'FrontGB Hero Carousel', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-hero-form',
                    'title' => __( 'FrontGB Hero Form', FRONTGB_I18N ),
                ),
                array(
                    'slug' => 'frontgb-pricing',
                    'title' => __( 'FrontGB Pricing', FRONTGB_I18N ),
                ),
                array(
                    'slug' => 'frontgb-gallery',
                    'title' => __( 'FrontGB Gallery', FRONTGB_I18N ),
                ),
                array(
                    'slug' => 'frontgb-contact-form',
                    'title' => __( 'FrontGB Contact Form', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-docs',
                    'title' => __( 'FrontGB Docs', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-listing',
                    'title' => __( 'FrontGB Listing', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-footer',
                    'title' => __( 'FrontGB Footer', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-portfolio',
                    'title' => __( 'FrontGB Portfolio', FRONTGB_I18N ),
                ),
                array(
                    'slug'  => 'frontgb-stats',
                    'title' => __( 'FrontGB Stats', FRONTGB_I18N ),
                ),
            )
        );
    }
    add_filter( 'block_categories', 'frontgb_block_category', 10, 2 );
}

if ( ! function_exists( 'frontgb_add_required_block_styles' ) ) {

    /**
     * Adds the required global styles for FrontGB blocks.
     *
     * @since 1.3
     */
    function frontgb_add_required_block_styles() {
        global $content_width;
        $full_width_block_inner_width = isset( $content_width ) ? $content_width : 900;

        $custom_css = ':root {
            --content-width: ' . esc_attr( $full_width_block_inner_width ) . 'px;
        }';
        wp_add_inline_style( 'fgb-style-css', $custom_css );
    }
    add_action( 'enqueue_block_assets', 'frontgb_add_required_block_styles', 11 );
}
