<?php
/**
 * Front Theme Options
 */
if ( ! class_exists( 'ReduxFramework' ) ) {
    return;
}

if ( ! class_exists( 'Front_Options' ) ) {

    class Front_Options {
        public function __construct( ) {
            add_action( 'after_setup_theme', array( $this, 'load_config' ) );
            add_action( 'init',  array( $this, 'remove_demo_mode_link' ) );
            add_action( 'redux/loaded', array( $this, 'redux_disable_dev_mode_and_remove_admin_notices' ) );
            add_action( 'redux/page/front_options/enqueue', array( $this, 'queue_font_awesome' ) );
        }

        public static function get_option_name() {
            return 'front_options';
        }

        public function load_config() {
            $opt_name   = Front_Options::get_option_name();
            $theme      = wp_get_theme();
            $args       = array(
                'opt_name'          => $opt_name,
                'display_name'      => $theme->get( 'Name' ),
                'display_version'   => $theme->get( 'Version' ),
                'allow_sub_menu'    => true,
                'menu_title'        => esc_html__( 'Front', 'front' ),
                'page_priority'     => 3,
                'page_slug'         => 'theme_options',
                'intro_text'        => '',
                'dev_mode'          => false,
                'customizer'        => true,
                'footer_credit'     => '&nbsp;',
            );

            $options = array( 'general', 'header', 'footer', 'blog', 'shop', 'portfolio', 'job', 'docs', 'customer-story', '404', 'style', 'typography' );

            $options_dir    = get_template_directory() . '/inc/redux-framework/options';
            
            foreach ( $options as $option ) {
                $options_file = $option . '-options.php';
                require_once $options_dir . '/' . $options_file ;
            }

            $sections   = apply_filters( 'front_options_sections_args', 
                array( 
                    $general_options, 
                    $general_my_account_options, 
                    $header_options, 
                    $header_general_options, 
                    $header_background_options, 
                    $header_topbar_options, 
                    $header_logo_options, 
                    $header_navbar_options, 
                    $header_button_options, 
                    $header_fullscreen_modal_options, 
                    $header_search_options, 
                    $footer_options, 
                    $footer_general_options,
                    $footer_logo_options,
                    $blog_options, 
                    $blog_general_options, 
                    $blog_single_post_options, 
                ) 
            );

            if ( function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated() ) {
                array_push( $sections, $shop_options );
                array_push( $sections, $shop_header_options );
                array_push( $sections, $shop_footer_options );
                array_push( $sections, $shop_general_options );
                array_push( $sections, $shop_product_single_options );
            }

            array_push( $sections, $portfolio_options );
            array_push( $sections, $portfolio_header_options );
            array_push( $sections, $portfolio_footer_options );
            array_push( $sections, $portfolio_general_options );
            array_push( $sections, $portfolio_hero_block_options );
            array_push( $sections, $portfolio_related_projects_options );
            array_push( $sections, $portfolio_contact_options );
            array_push( $sections, $portfolio_static_content_options );

            if ( function_exists( 'front_is_wp_job_manager_activated' ) && front_is_wp_job_manager_activated() ) {
                array_push( $sections, $job_options );
                array_push( $sections, $job_header_options );
                array_push( $sections, $job_footer_options );
            }

            if ( function_exists( 'front_is_wedocs_activated' ) && front_is_wedocs_activated() ) {
                array_push( $sections, $docs_options );
                array_push( $sections, $docs_header_options );
                array_push( $sections, $docs_footer_options );
            }

            if( apply_filters( 'front_extensions_enable_customer_story_post_type', true ) ) {
                array_push( $sections, $customer_story_options );
                array_push( $sections, $customer_story_header_options );
                array_push( $sections, $customer_story_single_options );
                array_push( $sections, $customer_story_footer_options );
            }

            array_push( $sections, $error_page_options );

            array_push( $sections, $style_options );

            array_push( $sections, $typography_options );

            $ReduxFramework = new ReduxFramework( $sections, $args );
        }

        public function remove_demo_mode_link() {
            if ( class_exists('ReduxFrameworkPlugin') ) {
                remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
            }
        }

        public function redux_disable_dev_mode_and_remove_admin_notices( $redux ) {
            remove_action( 'admin_notices', array( $redux, '_admin_notices' ), 99 );
            $redux->args['dev_mode'] = false;
            $redux->args['forced_dev_mode_off'] = false;
        }

        /**
         * Enqueues font awesome for Redux Theme Options
         * 
         * @return front
         */
        public function queue_font_awesome() {
            wp_register_style( 'fontawesome', get_template_directory_uri() . '/assets/vendor/font-awesome/css/fontawesome-all.min.css', array(), time(), 'all' );
            wp_enqueue_style( 'fontawesome' );
        }

    }

    new Front_Options();
}

if( ! array_key_exists( 'front_options' , $GLOBALS ) ) {
    $GLOBALS['front_options'] = get_option( 'front_options', array() );
}