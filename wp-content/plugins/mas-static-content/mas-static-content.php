<?php
/**
 * Plugin Name: MAS Static Content
 * Plugin URI: https://github.com/madrasthemes/mas-static-content
 * Description: This plugin helps to create a custom post type static content and use it with shortcode.
 * Version: 1.0.2
 * Author: MadrasThemes
 * Author URI: https://madrasthemes.com/
 * Text Domain: mas-static-content
 * Domain Path: /languages/
 *
 * @package Mas_Static_Content
 * @category Core
 * @author Madras Themes
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define MAS_STATIC_CONTENT_PLUGIN_FILE.
if ( ! defined( 'MAS_STATIC_CONTENT_PLUGIN_FILE' ) ) {
    define( 'MAS_STATIC_CONTENT_PLUGIN_FILE', __FILE__ );
}

// Include the main Mas_Static_Content class.
if ( ! class_exists( 'Mas_Static_Content' ) ) {
    include_once dirname( MAS_STATIC_CONTENT_PLUGIN_FILE ) . '/includes/class-mas-static-content.php';
}

/**
 * Unique access instance for Mas_Static_Content class
 */
function Mas_Static_Content() {
    return Mas_Static_Content::instance();
}

// Global for backwards compatibility.
$GLOBALS['mas_static_content'] = Mas_Static_Content();