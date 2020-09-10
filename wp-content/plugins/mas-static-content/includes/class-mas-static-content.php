<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Mas_Static_Content' ) ) {
    /**
     * Main plugin class
     *
     * @class Mas_Static_Content
     * @version 1.0.0
     */
    final class Mas_Static_Content {
        /**
         * Version
         *
         * @var string
         */
        public $version = '1.0.2';

        /**
         * The single instance of the class.
         *
         * @var Mas_Static_Content
         */
        protected static $_instance = null;

        /**
         * Main Mas_Static_Content Instance.
         *
         * Ensures only one instance of Mas_Static_Content is loaded or can be loaded.
         *
         * @static
         * @return Mas_Static_Content - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Cloning is forbidden.
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'mas-static-content' ), '1.0.0' );
        }

        /**
         * Unserializing instances of this class is forbidden.
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'mas-static-content' ), '1.0.0' );
        }

        /**
         * Mas_Static_Content Constructor.
         */
        public function __construct() {
            $this->define_constants();
            $this->includes();
            $this->init_hooks();

            do_action( 'mas_static_content_loaded' );
        }

        /**
         * Define constants
         */
        private function define_constants() {
            $this->define( 'MAS_STATIC_CONTENT_ABSPATH', dirname( MAS_STATIC_CONTENT_PLUGIN_FILE ) . '/' );
            $this->define( 'MAS_STATIC_CONTENT_PLUGIN_BASENAME', plugin_basename( MAS_STATIC_CONTENT_PLUGIN_FILE ) );
            $this->define( 'MAS_STATIC_CONTENT_VERSION', $this->version );
            $this->define( 'MAS_STATIC_CONTENT_DELIMITER', '|' );
        }

        /**
         * Init Mas_Static_Content when Wordpress Initializes
         */
        public function includes() {
            /**
             * Core classes.
             */
            include_once MAS_STATIC_CONTENT_ABSPATH . 'includes/class-mas-static-content-post-types.php';
            include_once MAS_STATIC_CONTENT_ABSPATH . 'includes/class-mas-static-content-shortcodes.php';
        }

        /**
         * Init Mas_Static_Content when Wordpress Initializes
         */
        public function init_hooks() {
            add_action( 'init', array( $this, 'init' ), 0 );
            add_action( 'init', array( 'Mas_Static_Content_Shortcodes', 'init' ) );
        }

        /**
         * Init Mas_Static_Content when WordPress Initialises.
         */
        public function init() {
            // Before init action.
            do_action( 'before_mas_static_content_init' );

            // Set up localisation.
            $this->load_plugin_textdomain();

            // Init action.
            do_action( 'mas_static_content_init' );
        }

        /**
         * Load Localisation files.
         *
         * Note: the first-loaded translation file overrides any following ones if the same translation is present.
         *
         * Locales found in:
         *      - WP_LANG_DIR/mas-static-content/mas-static-content-LOCALE.mo
         *      - WP_LANG_DIR/plugins/mas-static-content-LOCALE.mo
         */
        public function load_plugin_textdomain() {
            $locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
            $locale = apply_filters( 'plugin_locale', $locale, 'mas-static-content' );

            unload_textdomain( 'mas-static-content' );
            load_textdomain( 'mas-static-content', WP_LANG_DIR . '/mas-static-content/mas-static-content-' . $locale . '.mo' );
            load_plugin_textdomain( 'mas-static-content', false, plugin_basename( dirname( MAS_STATIC_CONTENT_PLUGIN_FILE ) ) . '/languages' );
        }

        /**
         * Get the plugin url.
         * @return string
         */
        public function plugin_url() {
            return untrailingslashit( plugins_url( '/', MAS_STATIC_CONTENT_PLUGIN_FILE ) );
        }

        /**
         * Get the plugin path.
         * @return string
         */
        public function plugin_path() {
            return untrailingslashit( plugin_dir_path( MAS_STATIC_CONTENT_PLUGIN_FILE ) );
        }

        /**
         * Define constant if not already set.
         *
         * @param  string $name
         * @param  string|bool $value
         */
        private function define( $name, $value ) {
            if ( ! defined( $name ) ) {
                define( $name, $value );
            }
        }
    }
}