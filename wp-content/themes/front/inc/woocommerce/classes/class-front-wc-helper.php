<?php
/**
 * Front Helper Class for WooCommerce
 */

class Front_WC_Helper {

    public static function init() {
        add_filter( 'comments_template',    array( __CLASS__, 'comments_template_loader' ), 20 );
    }

    public static function comments_template_loader( $template ) {

        if ( get_post_type() !== 'product' || ! apply_filters( 'front_use_advanced_reviews', true ) ) {
            return $template;
        }

        $check_dirs = array(
            trailingslashit( get_stylesheet_directory() ) . 'templates/shop/',
            trailingslashit( get_template_directory() ) . 'templates/shop/',
            trailingslashit( get_stylesheet_directory() ) . WC()->template_path(),
            trailingslashit( get_template_directory() ) . WC()->template_path(),
            trailingslashit( get_stylesheet_directory() ),
            trailingslashit( get_template_directory() ),
            trailingslashit( WC()->plugin_path() ) . 'templates/'
        );

        if ( WC_TEMPLATE_DEBUG_MODE ) {
            $check_dirs = array( array_pop( $check_dirs ) );
        }

        foreach ( $check_dirs as $dir ) {
            if ( file_exists( trailingslashit( $dir ) . 'single-product-advanced-reviews.php' ) ) {
                return trailingslashit( $dir ) . 'single-product-advanced-reviews.php';
            }
        }

        return $template;
    }

    public static function get_ratings_counts( $product ) {
        global $wpdb;

        $product_id = $product->get_id();
        $counts     = array();
        $raw_counts = $wpdb->get_results( $wpdb->prepare("
                SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
                LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                WHERE meta_key = 'rating'
                AND comment_post_ID = %d
                AND comment_approved = '1'
                AND meta_value > 0
                GROUP BY meta_value
            ", $product_id ) );

        foreach ( $raw_counts as $count ) {
            $counts[ $count->meta_value ] = $count->meta_value_count;
        }

        return $counts;
    }
}

Front_WC_Helper::init();
