<?php
/**
 * Front Admin
 *
 * @class    Front_Admin
 * @author   MadrasThemes
 * @category Admin
 * @package  FrontExtensions/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Front_Admin class.
 */
class Front_Admin {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'init', array( $this, 'includes' ) );
        add_action( 'admin_init', array( $this, 'buffer' ), 1 );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

    }

    /**
     * Output buffering allows admin screens to make redirects later on.
     */
    public function buffer() {
        ob_start();
    }

    /**
     * Include any classes we need within admin.
     */
    public function includes() {
        include_once dirname( __FILE__ ) . '/front-meta-box-functions.php';
        include_once dirname( __FILE__ ) . '/class-front-admin-meta-boxes.php';
    }

    /**
     * Enqueue style.
     */
    public function admin_styles() {

        $screen    = get_current_screen();
        $screen_id = $screen ? $screen->id : '';

        /*if ( in_array( $screen_id, array( 'jetpack-portfolio' ) ) ) {

            wp_register_style( 'front_admin_styles', Front_Extensions()->plugin_url() . '/assets/css/admin/admin.css', array(), FRONT_VERSION );
            wp_enqueue_style( 'front_admin_styles' );
        }*/
        wp_register_style( 'front_admin_styles', Front_Extensions()->plugin_url() . '/assets/css/admin/admin.css', array(), FRONT_VERSION );
        wp_enqueue_style( 'front_admin_styles' );
    }

    /**
     * Enqueue scripts.
     */
    public function admin_scripts() {
        global $wp_query, $post;

        $screen          = get_current_screen();
        $screen_id       = $screen ? $screen->id : '';
        $front_screen_id = sanitize_title( __( 'Front', 'front-extensions' ) );
        $suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        if ( in_array( $screen_id, array( 'jetpack-portfolio' ) ) ) {
            wp_enqueue_media();
            wp_register_script( 'front-admin-portfolio-meta-boxes', Front_Extensions()->plugin_url() . '/assets/js/admin/meta-boxes-portfolio' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable', 'media-models' ), FRONT_VERSION );
            wp_enqueue_script( 'front-admin-portfolio-meta-boxes' );
        }
    }

    /**
     * Include admin files conditionally.
     */
    public function conditional_includes() {
        if ( ! $screen = get_current_screen() ) {
            return;
        }
    }
}

return new Front_Admin();