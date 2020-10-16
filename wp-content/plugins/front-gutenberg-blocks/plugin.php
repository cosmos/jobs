<?php
/**
 * Plugin Name: Front Gutenberg Blocks
 * Plugin URI: https://themeforest.net/user/madrasthemes/portfolio
 * Description: Gutenberg Blocks for Front WordPress Theme
 * Author: MadrasThemes
 * Author URI: https://themeforest.net/user/madrasthemes/portfolio
 * Version: 1.1.2
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Freemius SDK: Auto deactivate the free version when activating the paid one.
if ( function_exists( 'sugb_fs' ) ) {
	sugb_fs()->set_basename( true, __FILE__ );
	return;
}

defined( 'FRONTGB_VERSION' ) || define( 'FRONTGB_VERSION', '1.1.2' );
defined( 'FRONTGB_FILE' ) || define( 'FRONTGB_FILE', __FILE__ );
defined( 'FRONTGB_I18N' ) || define( 'FRONTGB_I18N', 'front-gutenberg-blocks' ); // Plugin slug.

/********************************************************************************************
 * Activation & PHP version checks.
 ********************************************************************************************/

if ( ! function_exists( 'frontgb_php_requirement_activation_check' ) ) {

	/**
	 * Upon activation, check if we have the proper PHP version.
	 * Show an error if needed and don't continue with the plugin.
	 *
	 * @since 1.9
	 */
	function frontgb_php_requirement_activation_check() {
		if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				sprintf(
					__( '%s"FrontGB" can not be activated. %s It requires PHP version 5.3.0 or higher, but PHP version %s is used on the site. Please upgrade your PHP version first ✌️ %s Back %s', 'frontgb' ),
					'<strong>',
					'</strong><br><br>',
					PHP_VERSION,
					'<br /><br /><a href="' . esc_url( get_dashboard_url( get_current_user_id(), 'plugins.php' ) ) . '" class="button button-primary">',
					'</a>'
				)
			);
		}
	}
	register_activation_hook( __FILE__, 'frontgb_php_requirement_activation_check' );
}

/**
 * Always check the PHP version at the start.
 * If the PHP version isn't sufficient, don't continue to prevent any unwanted errors.
 *
 * @since 1.9
 */
if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
	if ( ! function_exists( 'frontgb_php_requirement_notice' ) ) {
		function frontgb_php_requirement_notice() {
	        printf(
	            '<div class="notice notice-error"><p>%s</p></div>',
	            sprintf( __( '"FrontGB" requires PHP version 5.3.0 or higher, but PHP version %s is used on the site.', 'frontgb' ), PHP_VERSION )
	        );
		}
	}
	add_action( 'admin_notices', 'frontgb_php_requirement_notice' );
	return;
}

/********************************************************************************************
 * END Activation & PHP version checks.
 ********************************************************************************************/

/**
 * Block Initializer.
 */
require_once( plugin_dir_path( __FILE__ ) . 'src/block/default-footer/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/dark-footer/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/primary-footer/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/metabox.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/disabled-blocks.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/init.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/header/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/news-blogs/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/news-blogs/designs.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/more-projects/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/testimonials-static/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/testimonials-static/designs.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/nav-menu/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/hero-post-subblock/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/portfolio/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/hero-post-1/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/testimonials-carousel/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/testimonials-carousel/designs.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/shop-hero-slider/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/shortcode/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/sidebar/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/products-block-content/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/products-carousel-block/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/products-category-content/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/jobs-content/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/jobs-hero-search-form/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/docs-content/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/docs-posts-list/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/companies-content/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/companies-search-form/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/case-studies-simple-footer/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/customer-stories-content/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/megamenu-nav-menu/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/hp-listings-content/index.php' );
