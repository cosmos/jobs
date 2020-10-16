<?php
/**
 * Redux Framework functions
 *
 * @package FRONT/ReduxFramework
 */

/**
 * Setup functions for theme options
 */
require_once get_template_directory() . '/inc/redux-framework/functions/general-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/header-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/footer-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/blog-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/shop-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/portfolio-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/job-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/docs-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/customer-story-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/404-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/style-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/typography-functions.php';

if ( ! function_exists( 'front_redux_remove_custom_css_panel' ) ) {
	function front_redux_remove_custom_css_panel() {
		$custom_script = '
			wp.domReady( function() {
				wp.hooks.removeFilter( "editor.BlockEdit", "redux-custom-css/with-inspector-controls" );
			} );
		';

		wp_add_inline_script( 'wp-blocks', $custom_script );
	}
}