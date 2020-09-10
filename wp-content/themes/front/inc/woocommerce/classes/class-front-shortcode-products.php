<?php
/**
 * Kidos Products shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Products shortcode class.
 */
class Front_Shortcode_Products extends WC_Shortcode_Products {

    private $original_post;

    /**
     * Get shortcode content.
     *
     * @since  1.0.0
     * @return string
     */
    public function get_products() {
        return $this->get_query_results();
    }

    /**
     * Get shortcode content.
     *
     * @since  1.0.0
     * @return string
     */
    public function product_loop_start() {
        $columns  = absint( $this->attributes['columns'] );
        $classes  = $this->get_wrapper_classes( $columns );
        $products = $this->get_query_results();

        // Prime meta cache to reduce future queries.
        update_meta_cache( 'post', $products->ids );
        update_object_term_cache( $products->ids, 'product' );

        // Setup the loop.
        wc_setup_loop( array(
            'columns'      => $columns,
            'name'         => $this->type,
            'is_shortcode' => true,
            'is_search'    => false,
            'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
            'total'        => $products->total,
            'total_pages'  => $products->total_pages,
            'per_page'     => $products->per_page,
            'current_page' => $products->current_page,
        ) );

        $this->original_post = $GLOBALS['post'];

        echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';

        do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

        // Fire standard shop loop hooks when paginating results so we can show result counts and so on.
        if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
            do_action( 'woocommerce_before_shop_loop' );
        }

        woocommerce_product_loop_start();
    }

    /**
     * Get shortcode content.
     *
     * @since  1.0.0
     * @return string
     */
    public function product_loop_end() {
        woocommerce_product_loop_end();

        $GLOBALS['post'] = $this->original_post; // WPCS: override ok.

        // Fire standard shop loop hooks when paginating results so we can show result counts and so on.
        if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
            do_action( 'woocommerce_after_shop_loop' );
        }

        do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

        echo '</div>';

        wp_reset_postdata();
        wc_reset_loop();
    }

}
