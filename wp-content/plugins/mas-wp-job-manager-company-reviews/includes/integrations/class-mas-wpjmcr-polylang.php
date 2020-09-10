<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Polylang Support.
 *
 * @since 1.0.0
 */
class MAS_WPJMCR_Polylang {

    /**
     * Constructor Class.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Register polylang string.
        add_action( 'init', array( $this, 'register_strings' ), 5 );

        // Make category label translateable.
        add_filter( 'mas_wpjmcr_category_label', array( $this, 'translate_category_label' ) );
    }

    /**
     * Register Polylang String.
     *
     * @since 1.0.0
     * @return void
     */
    public function register_strings() {
        // Var.
        $strings = array();

        // Add Categories as translateable strings.
        $categories = mas_wpjmcr_get_categories();
        foreach ( $categories as $category ) {
            $strings[] = $category;
        }

        // Make filterable.
        $strings = apply_filters( 'mas_wpjmcr_ppl_strings', $strings );

        // Register each strings.
        foreach ( $strings as $string ) {
            pll_register_string( esc_html__( 'MAS Company Reviews For WP Job Manager', 'mas-wp-job-manager-company-reviews' ), $string, esc_html__( 'MAS Company Reviews For WP Job Manager', 'mas-wp-job-manager-company-reviews' ) );
        }
    }

    /**
     * Translate category label.
     *
     * @since 1.0.0
     *
     * @param string $category Category label.
     * @return string
     */
    public function translate_category_label( $category ) {
        return pll__( $category );
    }

}

