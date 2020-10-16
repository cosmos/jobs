<?php
/**
 * Plugin Name:     Front Extensions
 * Plugin URI:      https://madrasthemes.com/front
 * Description:     This selection of extensions compliment our lean and mean theme front. Please note: they don’t work with any WordPress theme, just front.
 * Author:          MadrasThemes
 * Author URI:      https://madrasthemes.com/
 * Version:         1.1.2
 * Text Domain:     front-extensions
 * Domain Path:     /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define FRONT_PLUGIN_FILE.
if ( ! defined( 'FRONT_PLUGIN_FILE' ) ) {
    define( 'FRONT_PLUGIN_FILE', __FILE__ );
}

if( ! class_exists( 'Front_Extensions' ) ) {
    /**
     * Main Front_Extensions Class
     *
     * @class Front_Extensions
     * @version 1.0.0
     * @since 1.0.0
     * @package Front
     * @author MadrasThemes
     */
    final class Front_Extensions {

        /**
         * Front_Extensions The single instance of Front_Extensions.
         * @var     object
         * @access  private
         * @since   1.0.0
         */
        private static $_instance = null;

        /**
         * The token.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $token;

        /**
         * The version number.
         * @var     string
         * @access  public
         * @since   1.0.0
         */
        public $version;

        /**
         * Constructor function.
         * @access  public
         * @since   1.0.0
         * @return  void
         */
        public function __construct () {

            $this->token    = 'front-extensions';
            $this->version  = '1.0.0';

            add_action( 'plugins_loaded',       array( $this, 'setup_constants' ),              10 );
            add_action( 'plugins_loaded',       array( $this, 'includes' ),                     20 );
            add_action( 'after_setup_theme',    array( $this, 'include_template_functions' ),   11 );
        }

        /**
         * Main Front_Extensions Instance
         *
         * Ensures only one instance of Front_Extensions is loaded or can be loaded.
         *
         * @since 1.0.0
         * @static
         * @see Front_Extensions()
         * @return Main Front instance
         */
        public static function instance () {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Setup plugin constants
         *
         * @access public
         * @since  1.0.0
         * @return void
         */
        public function setup_constants() {

            // Plugin Folder Path
            if ( ! defined( 'FRONT_EXTENSIONS_DIR' ) ) {
                define( 'FRONT_EXTENSIONS_DIR', plugin_dir_path( __FILE__ ) );
            }

            // Plugin Folder URL
            if ( ! defined( 'FRONT_EXTENSIONS_URL' ) ) {
                define( 'FRONT_EXTENSIONS_URL', plugin_dir_url( __FILE__ ) );
            }

            // Plugin Root File
            if ( ! defined( 'FRONT_EXTENSIONS_FILE' ) ) {
                define( 'FRONT_EXTENSIONS_FILE', __FILE__ );
            }

            $this->define( 'FRONT_ABSPATH', dirname( FRONT_EXTENSIONS_FILE ) . '/' );
            $this->define( 'FRONT_VERSION', $this->version );
        }

        /**
         * Define constant if not already set.
         *
         * @param string      $name  Constant name.
         * @param string|bool $value Constant value.
         */
        private function define( $name, $value ) {
            if ( ! defined( $name ) ) {
                define( $name, $value );
            }
        }

        /**
         * What type of request is this?
         *
         * @param  string $type admin, ajax, cron or frontend.
         * @return bool
         */
        private function is_request( $type ) {
            switch ( $type ) {
                case 'admin':
                    return is_admin();
                case 'ajax':
                    return defined( 'DOING_AJAX' );
                case 'cron':
                    return defined( 'DOING_CRON' );
                case 'frontend':
                    return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) && ! $this->is_rest_api_request();
            }
        }

        /**
         * Include required files
         *
         * @access public
         * @since  1.0.0
         * @return void
         */
        public function includes() {
            /**
             * Class autoloader.
             */
            include_once FRONT_EXTENSIONS_DIR . '/includes/class-front-autoloader.php';

            /**
             * Core classes.
             */
            include_once FRONT_EXTENSIONS_DIR . '/includes/class-front-post-types.php';

            require FRONT_EXTENSIONS_DIR . '/includes/functions.php';
            require FRONT_EXTENSIONS_DIR . '/includes/front-core-functions.php';

            /**
             * WP Job Manger.
             */
            require_once FRONT_EXTENSIONS_DIR . '/includes/wp-job-manager/class-front-wpjm-job-manager.php';

            if ( $this->is_request( 'admin' ) ) {
                include_once FRONT_EXTENSIONS_DIR . '/includes/admin/class-front-admin.php';
            }

            /**
             * HivePress.
             */
            // require_once FRONT_EXTENSIONS_DIR . '/includes/hivepress-marketplace/class-front-hp-marketplace-extend.php';

            /**
             * Custom Post Types
             */
            require FRONT_EXTENSIONS_DIR . '/includes/custom-post-types/portfolios.php';
        }

        /**
         * Function used to Init MasVideos Template Functions - This makes them pluggable by plugins and themes.
         */
        public function include_template_functions() {
            require FRONT_EXTENSIONS_DIR . '/includes/template-functions.php';
        }

        /**
         * Get the plugin url.
         *
         * @return string
         */
        public function plugin_url() {
            return untrailingslashit( plugins_url( '/', FRONT_PLUGIN_FILE ) );
        }

        /**
         * Cloning is forbidden.
         *
         * @since 1.0.0
         */
        public function __clone () {
            _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'front-extensions' ), '1.0.0' );
        }

        /**
         * Unserializing instances of this class is forbidden.
         *
         * @since 1.0.0
         */
        public function __wakeup () {
            _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'front-extensions' ), '1.0.0' );
        }
    }
}

/**
 * Returns the main instance of Front_Extensions to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Front_Extensions
 */
function Front_Extensions() {
    return Front_Extensions::instance();
}

/**
 * Initialise the plugin
 */
Front_Extensions();
