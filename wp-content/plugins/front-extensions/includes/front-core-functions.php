<?php
/**
 * Front Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @package Front\Functions
 * @version 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require FRONT_EXTENSIONS_DIR . '/includes/front-formatting-functions.php';

/**
 * Display a WooCommerce help tip.
 *
 * @since  2.5.0
 *
 * @param  string $tip        Help tip text.
 * @param  bool   $allow_html Allow sanitized HTML if true or escape.
 * @return string
 */
function front_ext_help_tip( $tip, $allow_html = false ) {
    if ( $allow_html ) {
        $tip = front_sanitize_tooltip( $tip );
    } else {
        $tip = esc_attr( $tip );
    }
    
    return '<span class="front-help-tip" data-tip="' . $tip . '"></span>';
}

/**
 * Return the html selected attribute if stringified $value is found in array of stringified $options
 * or if stringified $value is the same as scalar stringified $options.
 *
 * @param string|int       $value   Value to find within options.
 * @param string|int|array $options Options to go through when looking for value.
 * @return string
 */
function front_selected( $value, $options ) {
    if ( is_array( $options ) ) {
        $options = array_map( 'strval', $options );
        return selected( in_array( (string) $value, $options, true ), true, false );
    }

    return selected( $value, $options, false );
}