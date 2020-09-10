<?php
/**
 * Front Formatting
 *
 * Functions for formatting data.
 *
 * @package Front/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Format a decimal with PHP Locale settings.
 *
 * @param  string $value Decimal to localize.
 * @return string
 */
function front_format_localized_decimal( $value ) {
    $locale = localeconv();
    return apply_filters( 'front_format_localized_decimal', str_replace( '.', $locale['decimal_point'], strval( $value ) ), $value );
}

/**
 * Implode and escape HTML attributes for output.
 *
 * @since 1.0.0
 * @param array $raw_attributes Attribute name value pairs.
 * @return string
 */
function front_implode_html_attributes( $raw_attributes ) {
    $attributes = array();
    foreach ( $raw_attributes as $name => $value ) {
        $attributes[] = esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
    }
    return implode( ' ', $attributes );
}

/**
 * Sanitize a string destined to be a tooltip.
 *
 * @since  2.3.10 Tooltips are encoded with htmlspecialchars to prevent XSS. Should not be used in conjunction with esc_attr()
 * @param  string $var Data to sanitize.
 * @return string
 */
function front_sanitize_tooltip( $var ) {
    return htmlspecialchars(
        wp_kses(
            html_entity_decode( $var ),
            array(
                'br'     => array(),
                'em'     => array(),
                'strong' => array(),
                'small'  => array(),
                'span'   => array(),
                'ul'     => array(),
                'li'     => array(),
                'ol'     => array(),
                'p'      => array(),
            )
        )
    );
}