<?php
/**
 * Front Class
 *
 * @since    1.0.0
 * @package  front
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Front' ) ) :

    /**
     * The main Front class
     */
    class Front {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            add_action( 'after_switch_theme', array( $this, 'switch_theme' ) );
            add_action( 'after_setup_theme', array( $this, 'setup' ) );
            add_action( 'after_setup_theme', array( $this, 'front_template_debug_mode' ) );
            add_action( 'after_setup_theme', array( $this, 'register_image_sizes' ) );
            add_action( 'widgets_init', array( $this, 'widgets_init' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
            add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 30 ); // After WooCommerce.
            add_action( 'enqueue_block_editor_assets',  array( $this, 'block_editor_assets' ) );
            add_action( 'enqueue_block_assets',         array( $this, 'block_assets' ) );
            add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
            add_filter( 'body_class', array( $this, 'body_classes' ) );
            add_filter( 'front_display_header_args', array( $this, 'header_args' ) );
        }

        /**
         * Sets up theme default settings.
         */
        public function switch_theme() {
            // WP Job Manager
            update_option( 'job_manager_enable_categories', '1' );
            update_option( 'job_manager_enable_types', '1' );

            // WP Job Manager Resumes
            update_option( 'resume_manager_enable_categories', '1' );
            update_option( 'resume_manager_enable_skills', '1' );

            // Enable Porfolio
            if ( class_exists( 'Jetpack_Portfolio' ) ) {
                update_option( Jetpack_Portfolio::OPTION_NAME, '1' );
            }

            // Enable Testimonial
            if ( class_exists( 'Jetpack_Testimonial' ) ) {
                update_option( Jetpack_Testimonial::OPTION_NAME, '1' );
            }
        }

        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        public function setup() {
            /*
             * Load Localisation files.
             *
             * Note: the first-loaded translation file overrides any following ones if the same translation is present.
             */

            // Loads wp-content/languages/themes/front-it_IT.mo.
            load_theme_textdomain( 'front', trailingslashit( WP_LANG_DIR ) . 'themes' );

            // Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
            load_theme_textdomain( 'front', get_stylesheet_directory() . '/languages' );

            // Loads wp-content/themes/front/languages/it_IT.mo.
            load_theme_textdomain( 'front', get_template_directory() . '/languages' );

            /**
             * Add default posts and comments RSS feed links to head.
             */
            add_theme_support( 'automatic-feed-links' );

            /*
             * Enable support for Post Thumbnails on posts and pages.
             *
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
             */
            add_theme_support( 'post-thumbnails' );

            /*
             * Enable support for Post Formats.
            */
            add_theme_support(
                'post-formats',
                array(
                    'aside',
                    'image',
                    'video',
                    'quote',
                    'link',
                    'gallery',
                    'status',
                    'audio',
                )
            );

            /**
             * Enable support for site logo.
             */
            add_theme_support(
                'custom-logo', apply_filters(
                    'front_custom_logo_args', array(
                        'height'      => 57,
                        'width'       => 150,
                        'flex-width'  => true,
                        'flex-height' => true,
                    )
                )
            );

            // Declare WooCommerce support.
            add_theme_support( 'woocommerce', apply_filters( 'front_woocommerce_args', array(
                'thumbnail_image_width' => 350,
                'product_grid'          => array(
                    'default_columns' => 3,
                    'default_rows'    => 4,
                    'min_columns'     => 1,
                    'max_columns'     => 6,
                    'min_rows'        => 1
                )
            ) ) );

            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );

            // Declare WP Job Manager Templates support.
            add_theme_support( 'job-manager-templates' );

            // Declare WP Job Manager Archive support.
            add_theme_support( 'job-manager-archive' );

            // Declare WP Resume Manager Templates support.
            add_theme_support( 'resume-manager-templates' );

            // Declare WP Resume Manager Archive support.
            add_theme_support( 'resume-manager-archive' );

            // Declare MAS WP Job Manager Company Archive support.
            add_theme_support( 'mas-wp-job-manager-company-archive' );

            /**
             * Register menu locations.
             */
            register_nav_menus(
                apply_filters(
                    'front_register_nav_menus', array(
                        'primary'                          => esc_html__( 'Primary Menu', 'front' ),
                        'topbar_left'                      => esc_html__( 'Topbar Links - Left', 'front' ),
                        'topbar_right'                     => esc_html__( 'Topbar Links - Right', 'front' ),
                        'topbar_mobile'                    => esc_html__( 'Topbar Links - Mobile', 'front' ),
                        'user_account_menu'                => esc_html__( 'Header User Account Menu', 'front' ),
                        'sidebar_footer_menu'              => esc_html__( 'Header Sidebar Footer Menu', 'front' ),
                        'offcanvas_menu'                   => esc_html__( 'Header Offcanvas Menu', 'front' ),
                        'footer_social_menu'               => esc_html__( 'Footer Social Menu', 'front' ),
                        'footer_primary_menu'              => esc_html__( 'Footer Primary Menu', 'front' ),
                    )
                )
            );

            /*
             * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
             * to output valid HTML5.
             */
            add_theme_support(
                'html5', apply_filters(
                    'front_html5_args', array(
                        'search-form',
                        'comment-form',
                        'comment-list',
                        'gallery',
                        'caption',
                        'widgets',
                    )
                )
            );

            /**
             *  Add support for the Site Logo plugin and the site logo functionality in JetPack
             *  https://github.com/automattic/site-logo
             *  http://jetpack.me/
             */
            add_theme_support(
                'site-logo', apply_filters(
                    'front_site_logo_args', array(
                        'size' => 'full',
                    )
                )
            );

            /**
             * Declare support for title theme feature.
             */
            add_theme_support( 'title-tag' );

            /**
             * Declare support for selective refreshing of widgets.
             */
            add_theme_support( 'customize-selective-refresh-widgets' );

            /**
             * Add support for Block Styles.
             */
            add_theme_support( 'wp-block-styles' );

            /**
             * Add support for full and wide align images.
             */
            add_theme_support( 'align-wide' );

            /**
             * Add support for editor styles.
             */
            add_theme_support( 'editor-styles' );

            /**
             * Add support for disable editor custom colors.
             */
            add_theme_support( 'disable-custom-colors' );

            /**
             * Add support for editor color palette.
             */
            add_theme_support( 'editor-color-palette', apply_filters( 'front_editor_color_palette_options', array(
                array(
                    'name'  => esc_html__( 'Primary', 'front' ),
                    'slug'  => 'primary',
                    'color' => '#377dff',
                ),
                array(
                    'name'  => esc_html__( 'Secondary', 'front' ),
                    'slug'  => 'secondary',
                    'color' => '#77838f',
                ),
                array(
                    'name'  => esc_html__( 'Success', 'front' ),
                    'slug'  => 'success',
                    'color' => '#00c9a7',
                ),
                array(
                    'name'  => esc_html__( 'Danger', 'front' ),
                    'slug'  => 'danger',
                    'color' => '#de4437',
                ),
                array(
                    'name'  => esc_html__( 'Warning', 'front' ),
                    'slug'  => 'warning',
                    'color' => '#ffc107',
                ),
                array(
                    'name'  => esc_html__( 'Info', 'front' ),
                    'slug'  => 'info',
                    'color' => '#00dffc',
                ),
                array(
                    'name'  => esc_html__( 'Dark', 'front' ),
                    'slug'  => 'dark',
                    'color' => '#1e2022',
                ),
                array(
                    'name'  => esc_html__( 'Light', 'front' ),
                    'slug'  => 'light',
                    'color' => '#f8f9fa',
                ),
                array(
                    'name'  => esc_html__( 'Indigo', 'front' ),
                    'slug'  => 'indigo',
                    'color' => '#2d1582',
                ),
                array(
                    'name'  => esc_html__( 'White', 'front' ),
                    'slug'  => 'white',
                    'color' => '#fff',
                ),
            ) ) );

            /**
             * Enqueue editor styles.
             */
            if( apply_filters( 'front_use_predefined_colors', true ) ) {
                $color_css_file = apply_filters( 'front_primary_color', 'blue' );
                $color_css_url = get_template_directory_uri() . '/assets/css/colors/' . $color_css_file . '.css';
            } else {
                $custom_color_css_external_file = redux_apply_custom_color_css_external_file();
                if ( $custom_color_css_external_file ) {
                    $color_css_url = $custom_color_css_external_file['url'];
                } else {
                    $color_css_url = content_url( '/custom_theme_color_css' );;
                }
            }

            if ( is_rtl() ) {
                add_editor_style( array( 'assets/css/gutenberg-editor-rtl.css', $color_css_url, $this->google_fonts() ) );
            } else {
                add_editor_style( array( 'assets/css/gutenberg-editor.css', $color_css_url, $this->google_fonts() ) );
            }

            /**
             * Add support for responsive embedded content.
             */
            add_theme_support( 'responsive-embeds' );
        }

        /**
         * Register image sizes.
         */
        public function register_image_sizes() {
            $image_sizes = front_get_available_image_sizes();
            foreach ( $image_sizes as $image_size ) {
                if ( $image_size['enabled'] ) {
                    add_image_size( $image_size['name'], $image_size['width'], $image_size['height'], $image_size['crop'] );
                }
            }

            $blog_view = front_get_blog_view();

            if ( isset( $image_sizes[ 'blog_' . $blog_view . '_thumbnail' ] ) ) {
                $width  = $image_sizes[ 'blog_' . $blog_view . '_thumbnail' ]['width'];
                $height = $image_sizes[ 'blog_' . $blog_view . '_thumbnail' ]['height'];
                $crop   = $image_sizes[ 'blog_' . $blog_view . '_thumbnail' ]['crop'];
            } else {
                $width  = 380;
                $height = 0;
                $crop   = false;
            }

            set_post_thumbnail_size( $width, $height, $crop );
        }

        /**
         * Register widget area.
         *
         * @link https://codex.wordpress.org/Function_Reference/register_sidebar
         */
        public function widgets_init() {

            $sidebar_args['sidebar_blog'] = array(
                'name'          => esc_html__( 'Blog Sidebar', 'front' ),
                'id'            => 'sidebar-blog',
                'description'   => '',
                'before_title'  => '<h3 class="widget__title h5 text-primary font-weight-semi-bold mb-4">',
                'after_title'   => '</h3>',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div><hr class="my-7">',
            );

            $sidebar_args['sidebar_shop'] = array(
                'name'          => esc_html__( 'Shop Sidebar', 'front' ),
                'id'            => 'sidebar-shop',
                'description'   => '',
                'before_widget' => '<div id="%1$s" class="widget %2$s border-bottom pb-4 mb-4">',
                'after_widget'  => '</div>',
                'before_title'  => '<h4 class="widget-title h6 mb-3">',
                'after_title'   => '</h4>',
            );

            $sidebar_args['sidebar_category'] = array(
                'name'          => esc_html__( 'Product Category Sidebar', 'front' ),
                'id'            => 'sidebar-product-catgeory',
                'description'   => '',
                'before_widget' => '<div id="%1$s" class="widget %2$s pb-4 mb-4">',
                'after_widget'  => '</div>',
                'before_title'  => '<h4 class="widget-title h6 mb-3">',
                'after_title'   => '</h4>',
            );

            $sidebar_args['sidebar_hp_listings'] = array(
                'name'          => esc_html__( 'Listings Sidebar', 'front' ),
                'id'            => 'sidebar-hp-listings',
                'description'   => '',
                'before_title'  => '<h3 class="h6 font-weight-semi-bold">',
                'after_title'   => '</h3>',
                'before_widget' => '<div id="%1$s" class="widget mb-5 %2$s">',
                'after_widget'  => '</div>',
            );

            $rows    = intval( apply_filters( 'front_footer_widget_rows', 1 ) );
            $regions = intval( apply_filters( 'front_footer_widget_columns', 5 ) );

            for ( $row = 1; $row <= $rows; $row++ ) {
                for ( $region = 1; $region <= $regions; $region++ ) {
                    $footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
                    $footer   = sprintf( 'footer_%d', $footer_n );

                    if ( 1 === $rows ) {
                        /* translators: 1: column number */
                        $footer_region_name = sprintf( esc_html__( 'Footer Column %1$d', 'front' ), $region );

                        /* translators: 1: column number */
                        $footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of the footer.', 'front' ), $region );
                    } else {
                        /* translators: 1: row number, 2: column number */
                        $footer_region_name = sprintf( esc_html__( 'Footer Row %1$d - Column %2$d', 'front' ), $row, $region );

                        /* translators: 1: column number, 2: row number */
                        $footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'front' ), $region, $row );
                    }

                    $sidebar_args[ $footer ] = array(
                        'name'        => $footer_region_name,
                        'id'          => sprintf( 'footer-%d', $footer_n ),
                        'description' => $footer_region_description,
                        'before_title'  => '<h3 class="h6 widget__title">',
                        'after_title'   => '</h3>'
                    );
                }
            }


            $sidebar_args = apply_filters( 'front_sidebar_args', $sidebar_args );

            foreach ( $sidebar_args as $sidebar => $args ) {
                $widget_tags = array(
                    'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
                    'after_widget'  => '</div>',
                );

                /**
                 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
                 *
                 * 'front_sidebar_blog_widget_tags'
                 *
                 * 'front_footer_1_widget_tags'
                 * 'front_footer_2_widget_tags'
                 * 'front_footer_3_widget_tags'
                 * 'front_footer_4_widget_tags'
                 */
                $filter_hook = sprintf( 'front_%s_widget_tags', $sidebar );
                $widget_tags = apply_filters( $filter_hook, $widget_tags );

                if ( is_array( $widget_tags ) ) {
                    register_sidebar( $args + $widget_tags );
                }
            }
        }

        /**
         * Get all Front scripts.
         */
        private static function get_theme_scripts() {
            $vendors_path = get_template_directory_uri() . '/assets/vendor/';
            $js_vendors = apply_filters( 'front_js_vendors', array(
                'popper' => array(
                    'src' => $vendors_path . 'popper.js/dist/umd/popper.min.js',
                    'dep' => array( 'jquery' )
                ),
                'bootstrap' => array(
                    'src' => $vendors_path . 'bootstrap/bootstrap.min.js',
                    'dep' => array( 'jquery', 'popper' )
                ),
                'appear' => array(
                    'src' => $vendors_path . 'appear.js',
                    'dep' => array( 'jquery' )
                ),
                'circles' => array(
                    'src' => $vendors_path . 'circles/circles.min.js',
                    'dep' => array( 'jquery' )
                ),
                'chartist' => array(
                    'src' => $vendors_path . 'chartist/dist/chartist.min.js',
                    'dep' => array( 'jquery' )
                ),
                'chartist-tooltip' => array(
                    'src' => $vendors_path . 'chartist-js-tooltip/chartist-plugin-tooltip.js',
                    'dep' => array( 'jquery' )
                ),
                'megamenu' => array(
                    'src' => $vendors_path . 'hs-megamenu/src/hs.megamenu.js',
                    'dep' => array( 'jquery' )
                ),
                'slick-carousel' => array(
                    'src' => $vendors_path . 'slick-carousel/slick/slick.js',
                    'dep' => array( 'jquery' )
                ),
                'svg-injector' => array(
                    'src' => $vendors_path . 'svg-injector/dist/svg-injector.min.js',
                    'dep' => array( 'jquery' )
                ),
                'typed' => array(
                    'src' => $vendors_path . 'typed.js/lib/typed.min.js',
                    'dep' => array( 'jquery' )
                ),
                'jquery-fancybox' => array(
                    'src' => $vendors_path . 'fancybox/jquery.fancybox.min.js',
                    'dep' => array( 'jquery' )
                ),
                'jquery-mCustomScrollbar-concat' => array(
                    'src' => $vendors_path . 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
                    'dep' => array( 'jquery' )
                ),
                'dzsparallaxer' => array(
                    'src' => $vendors_path . 'dzsparallaxer/dzsparallaxer.js',
                    'dep' => array( 'jquery' )
                ),
                'bootstrap-select' => array(
                    'src' => $vendors_path . 'bootstrap-select/dist/js/bootstrap-select.min.js',
                    'dep' => array( 'jquery', 'bootstrap' )
                ),
                'bootstrap-tagsinput' => array(
                    'src' => $vendors_path . 'bootstrap-tagsinput/js/bootstrap-tagsinput.min.js',
                    'dep' => array( 'jquery', 'bootstrap' )
                ),
                'ion-rangeslider' => array(
                    'src' => $vendors_path . 'ion-rangeslider/js/ion.rangeSlider.min.js',
                    'dep' => array( 'jquery' )
                ),
                'custombox' => array(
                    'src' => $vendors_path . 'custombox/dist/custombox.min.js',
                    'dep' => array( 'jquery' )
                ),
                'custombox-legacy' => array(
                    'src' => $vendors_path . 'custombox/dist/custombox.legacy.min.js',
                    'dep' => array( 'jquery' )
                ),
                'cubeportfolio' => array(
                    'src' => $vendors_path . 'cubeportfolio/js/jquery.cubeportfolio.min.js',
                    'dep' => array( 'jquery' )
                ),
                'video-player' => array(
                    'src' => $vendors_path . 'player.js/dist/player.min.js',
                    'dep' => array( 'jquery' )
                ),
                'jquery-countdown' => array(
                    'src' => $vendors_path .'jquery.countdown.min.js',
                    'dep' => array( 'jquery' )
                ),
                'bg-video' => array(
                    'src' => $vendors_path . 'hs-bg-video/hs-bg-video.js',
                    'dep' => array( 'jquery' )
                ),
                'bg-video-player' => array(
                    'src' => $vendors_path . 'hs-bg-video/vendor/player.min.js',
                    'dep' => array( 'jquery' )
                ),
                'jquery-validation' => array(
                    'src' => $vendors_path . 'jquery-validation/dist/jquery.validate.min.js',
                    'dep' => array( 'jquery' )
                ),

            ) );

            $hs_components_path = get_template_directory_uri() . '/assets/js/components/';
            $front_hs_components = apply_filters( 'front_hs_components', array(
                'front-hs-core'             => array(
                    'src' => get_template_directory_uri() . '/assets/js/hs.core.js',
                    'dep' => array( 'bootstrap' )
                ),
                'front-hs-chart-pie'        => array(
                    'src' => $hs_components_path . 'hs.chart-pie.js',
                    'dep' => array( 'front-hs-core', 'appear', 'circles' )
                ),
                'front-hs-chartist'         => array(
                    'src' => $hs_components_path . 'hs.chartist-area-chart.js',
                    'dep' => array( 'front-hs-core', 'chartist', 'chartist-tooltip' )
                ),
                'front-hs-chartist-bar-chart' => array(
                    'src' => $hs_components_path . 'hs.chartist-bar-chart.js',
                    'dep' => array( 'front-hs-core', 'chartist', 'chartist-tooltip' )
                ),
                'front-hs-header'           => array(
                    'src' => $hs_components_path . 'hs.header.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-hamburgers'         => array(
                    'src' => $hs_components_path . 'hs.hamburgers.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-header-fullscreen'  => array(
                    'src' => $hs_components_path . 'hs.header-fullscreen.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-unfold'           => array(
                    'src' => $hs_components_path . 'hs.unfold.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-focus-state'      => array(
                    'src' => $hs_components_path . 'hs.focus-state.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-fancybox' => array(
                    'src' => $hs_components_path . 'hs.fancybox.js',
                    'dep' => array( 'front-hs-core', 'jquery-fancybox' )
                ),
                'front-hs-focus-state'      => array(
                    'src' => $hs_components_path . 'hs.focus-state.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-show-animation'   => array(
                    'src' => $hs_components_path . 'hs.show-animation.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-slick-carousel'   => array(
                    'src' => $hs_components_path . 'hs.slick-carousel.js',
                    'dep' => array( 'front-hs-core', 'slick-carousel' )
                ),
                'front-hs-svg-injector'     => array(
                    'src' => $hs_components_path . 'hs.svg-injector.js',
                    'dep' => array( 'front-hs-core', 'svg-injector' )
                ),
                'front-hs-go-to'            => array(
                    'src' => $hs_components_path . 'hs.go-to.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-range-slider'     => array(
                    'src' => $hs_components_path . 'hs.range-slider.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-sticky-block'     => array(
                    'src' => $hs_components_path . 'hs.sticky-block.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-scroll-nav'       => array(
                    'src' => $hs_components_path . 'hs.scroll-nav.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-progress-bar'     => array(
                    'src' => $hs_components_path . 'hs.progress-bar.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-modal-window'     => array(
                    'src' => $hs_components_path . 'hs.modal-window.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-quantity-counter' => array(
                    'src' => $hs_components_path . 'hs.quantity-counter.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-video-player' => array(
                    'src' => $hs_components_path . 'hs.video-player.js',
                    'dep' => array( 'front-hs-core', 'video-player' )
                ),
                'front-hs-selectpicker' => array(
                    'src' => $hs_components_path . 'hs.selectpicker.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-countdown'        => array(
                    'src' => $hs_components_path . 'hs.countdown.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-bg-video'        => array(
                    'src' => $hs_components_path . 'hs.bg-video.js',
                    'dep' => array( 'front-hs-core' )
                ),
                'front-hs-cubeportfolio'     => array(
                    'src' => $hs_components_path . 'hs.cubeportfolio.js',
                    'dep' => array( 'front-hs-core', 'cubeportfolio' )
                ),
                'front-hs-validation'     => array(
                    'src' => $hs_components_path . 'hs.validation.js',
                    'dep' => array( 'front-hs-core', 'jquery-validation' )
                ),
                'front-hs-malihu-scrollbar'     => array(
                    'src' => $hs_components_path . 'hs.malihu-scrollbar.js',
                    'dep' => array( 'front-hs-core', 'jquery-mCustomScrollbar-concat' )
                ),
            ) );

            return array_merge( $js_vendors, $front_hs_components );
        }

        /**
         * Register all Front scripts.
         */
        private static function register_scripts() {
            global $front_version;

            $register_scripts = self::get_theme_scripts();
            foreach ( $register_scripts as $handle => $props ) {
                wp_register_script( $handle, $props['src'], $props['dep'], $front_version );
            }
        }

        /**
         * Enqueue scripts and styles.
         *
         * @since  1.0.0
         */
        public function scripts() {
            global $front_version;

            /**
             * Styles
             */
            $vendors = apply_filters( 'front_vendor_styles', array(
                'fontawesome'             => 'font-awesome/css/fontawesome-all.min.css',
                'animate'                 => 'animate.css/animate.min.css',
                'megamenu'                => 'hs-megamenu/src/hs.megamenu.css',
                'jquery-mCustomScrollbar' => 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css',
                'bootstrap-select'        => 'bootstrap-select/dist/css/bootstrap-select.min.css',
                'bootstrap-tagsinput'     => 'bootstrap-tagsinput/css/bootstrap-tagsinput.css',
                'jquery-fancybox'         => 'fancybox/jquery.fancybox.css',
                'dzsparallaxer'           => 'dzsparallaxer/dzsparallaxer.css',
                'slick-carousel'          => 'slick-carousel/slick/slick.css',
                'ion-rangeslider'         => 'ion-rangeslider/css/ion.rangeSlider.css',
                'custombox'               => 'custombox/dist/custombox.min.css',
                'bg-video'                => 'hs-bg-video/hs-bg-video.css',
                'cubeportfolio'           => 'cubeportfolio/css/cubeportfolio.min.css',
                'chartist'                => 'chartist/dist/chartist.min.css',
                'chartist-tooltip'        => 'chartist-js-tooltip/chartist-plugin-tooltip.css'
            ) );

            foreach( $vendors as $key => $vendor ) {
                wp_enqueue_style( $key, get_template_directory_uri() . '/assets/vendor/' . $vendor, '', $front_version );

                if( in_array( $key, array( 'megamenu' ) ) ) {
                    wp_style_add_data( $key, 'rtl', 'replace' );
                }
            }

            wp_enqueue_style( 'front-style', get_template_directory_uri() . '/style.css', '', $front_version );
            wp_style_add_data( 'front-style', 'rtl', 'replace' );

            if( apply_filters( 'front_use_predefined_colors', true ) ) {
                $color_css_file = apply_filters( 'front_primary_color', 'blue' );
                wp_enqueue_style( 'front-color', get_template_directory_uri() . '/assets/css/colors/' . $color_css_file . '.css', '', $front_version );
            }

            if ( function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated() ) {
                wp_enqueue_style( 'front-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', '', $front_version );
                wp_style_add_data( 'front-woocommerce-style', 'rtl', 'replace' );
            }

            if ( function_exists( 'front_is_hivepress_activated' ) && front_is_hivepress_activated() ) {
                wp_enqueue_style( 'front-hp-listing-style', get_template_directory_uri() . '/assets/css/hivepress.css', '', $front_version );
                wp_style_add_data( 'front-hp-listing-style', 'rtl', 'replace' );
            }

            if ( function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated() ) {
                wp_enqueue_style( 'front-wp-job-manager-style', get_template_directory_uri() . '/assets/css/wp-job-manager.css', '', $front_version );
                wp_style_add_data( 'front-wp-job-manager-style', 'rtl', 'replace' );
            }

            /**
             * Fonts
             */
            wp_enqueue_style( 'front-fonts', $this->google_fonts(), array(), null );

            /**
             * Scripts
             */
            self::register_scripts();

            // JS Global Compulsory
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

            if ( is_singular( 'post' ) ) {
                wp_enqueue_script( 'dzsparallaxer' );
            }

            if ( front_is_woocommerce_activated() ) {
                wp_enqueue_script( 'front-hs-quantity-counter' );
            }

            if ( front_is_woocommerce_activated() || front_is_wp_job_manager_activated() || front_is_wp_resume_manager_activated() || front_is_mas_wp_company_manager_activated() ) {
                wp_enqueue_script( 'front-hs-modal-window' );
                wp_enqueue_script( 'front-hs-validation' );
                wp_enqueue_script( 'custombox' );
                wp_enqueue_script( 'custombox-legacy' );
                wp_enqueue_script( 'jquery-mCustomScrollbar-concat' );
                wp_enqueue_script( 'front-hs-malihu-scrollbar' );
                wp_enqueue_script( 'front-hs-show-animation' );
            }

            if ( front_is_woocommerce_activated() && is_shop() ) {
                wp_enqueue_script( 'front-hs-selectpicker' );
                wp_enqueue_script( 'bootstrap-select' );
                wp_enqueue_script( 'front-hidemaxlistitem', get_template_directory_uri() . '/assets/js/hideMaxListItem-min.js', array( 'jquery' ), $front_version, true );
            }

            if ( is_page_template( 'template-terms-conditions.php' ) ) {
                wp_enqueue_script( 'front-hs-scroll-nav' );
                wp_enqueue_script( 'front-anchor', get_template_directory_uri() . '/assets/js/anchor.js', array( 'front-hs-core' ), $front_version, true );
                wp_enqueue_script( 'front-term', get_template_directory_uri() . '/assets/js/term.js', array( 'front-hs-core', 'front-anchor' ), $front_version, true );
                wp_enqueue_script( 'front-hs-sticky-block' );
            }

            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
            }

            $admin_ajax_url = admin_url( 'admin-ajax.php' );
            $current_lang   = apply_filters( 'wpml_current_language', NULL );
            if ( $current_lang ) {
                $admin_ajax_url = add_query_arg( 'lang', $current_lang, $admin_ajax_url );
            }

            wp_enqueue_script( 'front-scripts', get_template_directory_uri() . '/assets/js/front.js', array( 'front-hs-core' ), $front_version, true );

            $front_options = apply_filters( 'front_localize_script_data', array(
                'rtl'                       => is_rtl() ? '1' : '0',
                'ajax_url'                  => $admin_ajax_url,
                'ajax_loader_url'           => get_template_directory_uri() . '/assets/svg/preloaders/circle-preloader.svg',
                'wp_job_manager_submission' => array(
                    'i18n_confirm_remove' => esc_html__( 'Are you sure you want to remove this item?', 'front' ),
                ),
                'hide_max_list_items_args'  => array(
                    'max'       => 5,
                    'speed'     => 500,
                    'moreText'  => esc_html__( 'View more', 'front' ),
                    'lessText'  => esc_html__( 'View less', 'front' ),
                    'moreHTML'  => '<p class="maxlist-more"><a class="link" href="#"></a></p>'
                ),
            ) );

            wp_localize_script( 'front-scripts', 'front_options', $front_options );
        }

        /**
         * Register Google fonts.
         *
         * @since 1.0.0
         * @return string Google fonts URL for the theme.
         */
        public function google_fonts() {
            $google_fonts = apply_filters(
                'front_google_font_families', array(
                    'poppins' => 'Poppins:300,400,500,600,700',
                )
            );

            $query_args = array(
                'family' => implode( '|', $google_fonts ),
                'subset' => rawurlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

            return $fonts_url;
        }

        /**
         * Enqueue supplemental block editor assets.
         *
         * @since 1.0.0
         */
        public function block_editor_assets() {
            global $front_version;

            // Styles.
            $vendors = apply_filters( 'front_editor_vendor_styles', array(
                'fontawesome'             => 'font-awesome/css/fontawesome-all.min.css',
                'jquery-fancybox'         => 'fancybox/jquery.fancybox.css',
                'dzsparallaxer'           => 'dzsparallaxer/dzsparallaxer.css',
                'slick-carousel'          => 'slick-carousel/slick/slick.css',
                'cubeportfolio'           => 'cubeportfolio/css/cubeportfolio.min.css',
                'ion-rangeslider'         => 'ion-rangeslider/css/ion.rangeSlider.css',
            ) );

            foreach( $vendors as $key => $vendor ) {
                wp_enqueue_style( $key, get_template_directory_uri() . '/assets/vendor/' . $vendor, '', $front_version );
            }

            // Scripts
            $theme_scripts = self::get_theme_scripts();
            foreach ( $theme_scripts as $handle => $props ) {
                if( in_array( $handle, array( 'bg-video', 'custombox-legacy' ) ) ) {
                    continue;
                }
                wp_enqueue_script( $handle, $props['src'], $props['dep'], $front_version );
            }
        }

        /**
         * Enqueue supplemental block editor assets.
         *
         * @since 1.0.0
         */
        public function block_assets() {
            global $front_version;

            // Scripts
            self::register_scripts();

            // Styles.
        }

        /**
         * Enqueue child theme stylesheet.
         * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
         * primary css and the separate WooCommerce css.
         *
         * @since  1.5.3
         */
        public function child_scripts() {
            if ( is_child_theme() ) {
                $child_theme = wp_get_theme( get_stylesheet() );
                wp_enqueue_style( 'front-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );
            }
        }

        /**
         * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
         *
         * @param array $args Configuration arguments.
         * @return array
         */
        public function page_menu_args( $args ) {
            $args['show_home'] = true;
            return $args;
        }

        /**
         * Adds custom classes to the array of body classes.
         *
         * @param array $classes Classes for the body element.
         * @return array
         */
        public function body_classes( $classes ) {
            global $post;

            if ( is_404() ) {
                $classes[] = 'bg-img-hero-fixed';
            }

            if ( is_page() && isset( $post->ID ) ) {
                $clean_page_meta_values = get_post_meta( $post->ID, '_front_options', true );
                $page_meta_values = json_decode( stripslashes( $clean_page_meta_values ), true );

                if ( ! empty( $page_meta_values['bodyClasses'] ) ) {
                    $classes[] = $page_meta_values['bodyClasses'];
                }
            }

            /**
             * What is this?!
             * Take the blue pill, close this file and forget you saw the following code.
             * Or take the red pill, filter front_make_me_cute and see how deep the rabbit hole goes...
             */
            $cute = apply_filters( 'front_make_me_cute', false );

            if ( true === $cute ) {
                $classes[] = 'front-cute';
            }

            // Add class when using homepage template + featured image.
            if ( is_page_template( 'template-homepage.php' ) && has_post_thumbnail() ) {
                $classes[] = 'has-post-thumbnail';
            }

            // Add class when Secondary Navigation is in use.
            if ( has_nav_menu( 'secondary' ) ) {
                $classes[] = 'front-secondary-navigation';
            }

            // Add class if align-wide is supported.
            if ( current_theme_supports( 'align-wide' ) ) {
                $classes[] = 'front-align-wide';
            }

            if ( is_admin_bar_showing() ) {
                $classes[] = 'position-relative';
            }

            return $classes;
        }

        /**
         * Adds a custom parameter to the editor settings that is used
         * to track whether the main sidebar has widgets.
         *
         * @since 2.4.3
         * @param array   $settings Default editor settings.
         * @param WP_Post $post Post being edited.
         *
         * @return array Filtered block editor settings.
         */
        public function custom_editor_settings( $settings, $post ) {
            $settings['mainSidebarActive'] = false;

            if ( is_active_sidebar( 'sidebar-1' ) ) {
                $settings['mainSidebarActive'] = true;
            }

            return $settings;
        }

        /**
         * Custom navigation markup template hooked into `navigation_markup_template` filter hook.
         */
        public function navigation_markup_template() {
            $template  = '<nav id="post-navigation" class="navigation %1$s" role="navigation" aria-label="' . esc_html__( 'Post Navigation', 'front' ) . '">';
            $template .= '<h2 class="screen-reader-text">%2$s</h2>';
            $template .= '<div class="nav-links">%3$s</div>';
            $template .= '</nav>';

            return apply_filters( 'front_navigation_markup_template', $template );
        }

        /**
         * Enables template debug mode
         */
        public function front_template_debug_mode() {
            if ( ! defined( 'FRONT_TEMPLATE_DEBUG_MODE' ) ) {
                $status_options = get_option( 'woocommerce_status_options', array() );
                if ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) {
                    define( 'FRONT_TEMPLATE_DEBUG_MODE', true );
                } else {
                    define( 'FRONT_TEMPLATE_DEBUG_MODE', false );
                }
            }
        }

        /**
         * Register the required plugins for this theme.
         *
         * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
         */
        public function register_required_plugins() {
            /*
             * Array of plugin arrays. Required keys are name and slug.
             * If the source is NOT from the .org repo, then source is also required.
             */
            global $front_version;

            $plugins = array(

                array(
                    'name'                  => esc_html__( 'Front Extensions', 'front' ),
                    'slug'                  => 'front-extensions',
                    'source'                => 'https://transvelo.github.io/included-plugins/front-extensions.zip',
                    'version'               => $front_version,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => true
                ),

                array(
                    'name'                  => esc_html__( 'Front Gutenberg Blocks', 'front' ),
                    'slug'                  => 'front-gutenberg-blocks',
                    'source'                => 'https://transvelo.github.io/included-plugins/front-gutenberg-blocks.zip',
                    'version'               => $front_version,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => true
                ),

                array(
                    'name'                  => esc_html__( 'MAS Static Content', 'front' ),
                    'slug'                  => 'mas-static-content',
                    'version'               => '1.0.2',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => true,
                ),

                array(
                    'name'                  => esc_html__( 'One Click Demo Import', 'front' ),
                    'slug'                  => 'one-click-demo-import',
                    'version'               => '2.6.1',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => false,
                ),

                array(
                    'name'                  => esc_html__( 'Redux Framework', 'front' ),
                    'slug'                  => 'redux-framework',
                    'version'               => '4.1.15',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => false,
                ),

                array(
                    'name'                  => esc_html__( 'WPForms Lite', 'front' ),
                    'slug'                  => 'wpforms-lite',
                    'version'               => '1.6.2.2',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => false,
                ),

            );

            $selected_demo = get_option( 'front_tgmpa_selected_demo', 'simple' );

            if( $selected_demo != 'simple' ) {
                $more_plugins = array(

                    array(
                        'name'                  => esc_html__( 'Custom Sidebars', 'front' ),
                        'slug'                  => 'custom-sidebars',
                        'version'               => '3.2.3',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                        'required'              => false,
                    ),

                    array(
                        'name'                  => esc_html__( 'Envato Market', 'front' ),
                        'slug'                  => 'envato-market',
                        'source'                => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
                        'required'              => false,
                        'version'               => '2.0.4',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                        'external_url'          => '',
                    ),

                    array(
                        'name'                  => esc_html__( 'Jetpack by WordPress.com', 'front' ),
                        'slug'                  => 'jetpack',
                        'version'               => '8.8.2',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                        'required'              => false,
                    ),

                    array(
                        'name'                  => esc_html__( 'Menu Image', 'front' ),
                        'slug'                  => 'menu-image',
                        'version'               => '2.9.7',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                        'required'              => false,
                    ),

                    array(
                        'name'                  => esc_html__( 'Safe SVG', 'front' ),
                        'slug'                  => 'safe-svg',
                        'version'               => '1.9.9',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                        'required'              => false,
                    ),

                    array(
                        'name'                  => esc_html__( 'User Profile Picture', 'front' ),
                        'slug'                  => 'metronet-profile-picture',
                        'version'               => '2.3.11',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                        'required'              => false,
                    ),
                );

                $plugins = wp_parse_args( $more_plugins, $plugins );
            }

            switch ( $selected_demo ) {
                case 'main':
                    $plugins[] = array(
                        'name'                  => esc_html__( 'WooCommerce', 'front' ),
                        'slug'                  => 'woocommerce',
                        'version'               => '4.4.1',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                        'required'              => false,
                    );

                    $plugins[] = array(
                        'name'                  => esc_html__( 'WP Job Manager', 'front' ),
                        'slug'                  => 'wp-job-manager',
                        'required'              => false,
                        'version'               => '1.34.3',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                    );
                    break;

                case 'jobs':
                    $plugins[] = array(
                        'name'                  => esc_html__( 'MAS Companies For WP Job Manager', 'front' ),
                        'slug'                  => 'mas-wp-job-manager-company',
                        'required'              => false,
                        'version'               => '1.0.1',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                    );

                    $plugins[] = array(
                        'name'                  => esc_html__( 'MAS Company Reviews For WP Job Manager', 'front' ),
                        'slug'                  => 'mas-wp-job-manager-company-reviews',
                        'required'              => false,
                        'version'               => '1.0.1',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                    );

                    $plugins[] = array(
                        'name'                  => esc_html__( 'WooCommerce', 'front' ),
                        'slug'                  => 'woocommerce',
                        'version'               => '4.4.1',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                        'required'              => false,
                    );

                    $plugins[] = array(
                        'name'                  => esc_html__( 'WP Job Manager', 'front' ),
                        'slug'                  => 'wp-job-manager',
                        'required'              => false,
                        'version'               => '1.34.3',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                    );
                    break;

                case 'help-desk':
                    $plugins[] = array(
                        'name'                  => esc_html__( 'weDocs', 'front' ),
                        'slug'                  => 'wedocs',
                        'required'              => false,
                        'version'               => '1.6.1',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                    );
                    break;

                case 'app-marketplace':
                    $plugins[] = array(
                        'name'                  => esc_html__( 'HivePress', 'front' ),
                        'slug'                  => 'hivepress',
                        'required'              => false,
                        'version'               => '1.3.12',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                    );

                    $plugins[] = array(
                        'name'                  => esc_html__( 'HivePress Reviews', 'front' ),
                        'slug'                  => 'hivepress-reviews',
                        'required'              => false,
                        'version'               => '1.2.4',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                    );
                    break;

                case 'real-estate':
                    $plugins[] = array(
                        'name'                  => esc_html__( 'Essential Real Estate', 'front' ),
                        'slug'                  => 'essential-real-estate',
                        'required'              => false,
                        'version'               => '3.1.6',
                        'force_activation'      => false,
                        'force_deactivation'    => false,
                    );
                    break;

                default:
                    break;
            }

            $config = array(
                'id'           => 'front',                 // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',                      // Default absolute path to bundled plugins.
                'menu'         => 'tgmpa-install-plugins', // Menu slug.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => false,                   // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
            );

            tgmpa( $plugins, $config );
        }

        public function header_args( $args ) {
            if ( apply_filters( 'front_enable_single_header_args', true ) && is_single() ) {
                $args = wp_parse_args( array(), $args );
            } elseif ( apply_filters( 'front_enable_404_header_args', true ) && is_404() ) {
                $args = wp_parse_args( array(
                    'menuStyle' => 'logo-only',
                    'enablePostion' => true,
                    'position' => 'abs-top',
                    'positionScreen' => 'all-screens',
                    'enableTransparent' => true,
                    'transparentBreakpoint' => 'all-screens',
                    'enableTopBar' => false,
                ), $args );
            } elseif ( apply_filters( 'front_enable_template_blog_business_header_args', true ) && is_page_template( 'template-blog-business.php' ) ) {
                $args = wp_parse_args( array(
                    'menuStyle' => 'full-screen',
                    'enablePostion' => true,
                    'position' => 'abs-top',
                    'positionScreen' => 'all-screens',
                    'enableTransparent' => true,
                    'transparentBreakpoint' => 'all-screens',
                    'enableTopBar' => false,
                    'enableWhiteNavLinks' => true,
                    'whiteNavLinksBreakpoint' => 'all-screens',
                    'enableLogoWhite' => true,
                ), $args );
            } elseif ( apply_filters( 'front_enable_template_blog_startup_header_args', true ) && is_page_template( 'template-blog-startup.php' ) ) {
                $args = wp_parse_args( array(), $args );
            }

            return $args;
        }
    }
endif;

return new Front();
