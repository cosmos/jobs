<?php
/**
 * Front engine room
 *
 * @package front
 */

/**
 * Assign the Front version to a var
 */
$theme         = wp_get_theme( 'front' );
$front_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 980; /* pixels */
}

$front = (object) array(
    'version'    => $front_version,

    /**
     * Initialize all the things.
     */
    'main'       => require get_template_directory() . '/inc/class-front.php',
);

/**
 * Categories meta class.
 */
require get_template_directory() . '/classes/class-front-categories.php';

/**
 * TGM Plugin Activation class.
 */
require get_template_directory() . '/classes/class-tgm-plugin-activation.php';

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-front-svg-icons.php';

/**
 * Bootstrap Nav Menu Walker
 */
require get_template_directory() . '/classes/walkers/class-front-walker-bootstrap-nav-menu.php';

/**
 * Offcanvas Sidebar Menu Walker
 */
require get_template_directory() . '/classes/walkers/class-front-walker-offcanvas-sidebar-menu.php';

/**
 * Offcanvas Modal Menu Walker
 */
require get_template_directory() . '/classes/walkers/class-front-walker-offcanvas-modal-menu.php';

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/walkers/class-front-walker-comment.php';

/**
 * Social Media Navwalker
 */
require get_template_directory() . '/classes/walkers/class-front-walker-social-media.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/front-template-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/front-icon-functions.php';

/**
 * Nav Menu related functions.
 */
require get_template_directory() . '/inc/front-menu-functions.php';

/**
 * Functions used in Front
 */
require get_template_directory() . '/inc/front-functions.php';

/**
 * Hooks and Filters used in Front
 */
require get_template_directory() . '/inc/front-template-hooks.php';

require get_template_directory() . '/inc/customer-story/front-customer-story-functions.php';
require get_template_directory() . '/inc/customer-story/front-customer-story-template-functions.php';
require get_template_directory() . '/inc/customer-story/front-customer-story-template-hooks.php';

if ( front_is_ocdi_activated() ) {
    require get_template_directory() . '/inc/ocdi/hooks.php';
    require get_template_directory() . '/inc/ocdi/functions.php';
}

if ( front_is_woocommerce_activated() ) {
    $front->woocommerce = require get_template_directory() . '/inc/woocommerce/class-front-woocommerce.php';
    require get_template_directory() . '/inc/woocommerce/front-woocommerce-template-hooks.php';
    require get_template_directory() . '/inc/woocommerce/front-woocommerce-template-functions.php';
    require get_template_directory() . '/inc/woocommerce/front-wc-template-functions-overrides.php';
    require get_template_directory() . '/inc/woocommerce/integrations.php';
}

    $front->jetpack = require get_template_directory() . '/inc/jetpack/class-front-jetpack.php';
    require_once get_template_directory() . '/inc/jetpack/front-jetpack-functions.php';
    require_once get_template_directory() . '/inc/jetpack/front-jetpack-template-functions.php';
    require_once get_template_directory() . '/inc/jetpack/front-jetpack-template-hooks.php';
    require_once get_template_directory() . '/inc/jetpack/front-jetpack-functions.php';
    // if ( front_is_jetpack_portfolio() ) {
        // Jetpack portfolio taxonomy meta class.
        include_once get_template_directory() . '/inc/jetpack/class-front-jetpack-portfolio-taxonomies.php';
    // }

if ( front_is_redux_activated() ) {
    require_once get_template_directory() . '/inc/redux-framework/front-options.php';
    require_once get_template_directory() . '/inc/redux-framework/functions.php';
    require_once get_template_directory() . '/inc/redux-framework/hooks.php';
}

if ( front_is_wp_job_manager_activated() ) {
    $front->wpjm = require get_template_directory() . '/inc/wp-job-manager/class-front-wpjm.php';

    require get_template_directory() . '/inc/wp-job-manager/front-wpjm-functions.php';
    require get_template_directory() . '/inc/wp-job-manager/front-wpjm-template-hooks.php';
    require get_template_directory() . '/inc/wp-job-manager/front-wpjm-template-functions.php';
    require get_template_directory() . '/inc/wp-job-manager/front-wpjm-integrations.php';
}

if ( front_is_wp_resume_manager_activated() ) {
    $front->wpjmr = require get_template_directory() . '/inc/wp-job-manager-resumes/class-front-wpjmr.php';

    require get_template_directory() . '/inc/wp-job-manager-resumes/front-wpjmr-functions.php';
    require get_template_directory() . '/inc/wp-job-manager-resumes/front-wpjmr-template-hooks.php';
    require get_template_directory() . '/inc/wp-job-manager-resumes/front-wpjmr-template-functions.php';
}

if ( front_is_mas_wp_company_manager_activated() ) {
    $front->wpjmc = require get_template_directory() . '/inc/mas-wp-job-manager-company/class-front-wpjmc.php';

    require get_template_directory() . '/inc/mas-wp-job-manager-company/front-wpjmc-functions.php';
    require get_template_directory() . '/inc/mas-wp-job-manager-company/front-wpjmc-template-hooks.php';
    require get_template_directory() . '/inc/mas-wp-job-manager-company/front-wpjmc-template-functions.php';
    require get_template_directory() . '/inc/mas-wp-job-manager-company/class-front-walker-company-comment.php';
}

if ( front_is_wedocs_activated() ) {
    $front->wedocs = require get_template_directory() . '/inc/wedocs/class-front-wedocs.php';
    require get_template_directory() . '/inc/wedocs/front-wedocs-functions.php';
    require get_template_directory() . '/inc/wedocs/front-wedocs-template-hooks.php';
    require get_template_directory() . '/inc/wedocs/front-wedocs-template-functions.php';
}

if ( front_is_hivepress_activated() && apply_filters( 'front_use_hp_for_marketplace', true ) ) {
    $front->hp_marketplace = require get_template_directory() . '/inc/hivepress-marketplace/class-front-hp-marketplace.php';
    require get_template_directory() . '/inc/hivepress-marketplace/front-hp-marketplace-functions.php';
    require get_template_directory() . '/inc/hivepress-marketplace/front-hp-marketplace-template-hooks.php';
    require get_template_directory() . '/inc/hivepress-marketplace/front-hp-marketplace-template-functions.php';
}

define( 'CUSTOM_SIDEBAR_DISABLE_METABOXES', true );

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
