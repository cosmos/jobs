<?php
/**
 * Jetpack Integration
 *
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ){
    exit;
}

// Disable jetpack comment in company post type.
add_filter( 'jetpack_comment_form_enabled_for_company', '__return_false' );
