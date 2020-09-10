<?php
/**
 * WooCommerce Third Party Plugin Compatibility
 *
 * @package front
 */
if ( ! function_exists( 'front_shipping_icons_descriptions_shipping_description' ) ) {
    function front_shipping_icons_descriptions_shipping_description( $label, $method ) {
        if ( '' != ( $desc = alg_wc_shipping_icons_descs()->core->get_value( 'description', $method ) ) ) {
            $label .= '</span>' . '<span class="d-block text-muted">' . $desc . '</span>';
        }

        return $label;
    }
}

if ( front_is_yith_wcwl_activated() ) {

	global $yith_wcwl;

	// Dequeue YITH styles.
	add_action( 'wp_print_styles', 'front_yith_wcwl_dequeue_styles', 20 );

	if( ! function_exists( 'front_yith_wcwl_dequeue_styles' ) ){
		function front_yith_wcwl_dequeue_styles() {
			wp_dequeue_style( 'yith-wcwl-main' );
		}
	}

	function front_add_to_wishlist_button() {
		echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}

	// check if Add to wishlist button is enabled for loop
	$enabled_on_loop = 'yes' == get_option( 'yith_wcwl_show_on_loop', 'no' );

	if( $enabled_on_loop ){
		add_action( 'woocommerce_before_shop_loop_item_title', 'front_add_to_wishlist_button', 25 );
		add_action( 'woocommerce_after_shop_loop_item', 	    'front_add_to_wishlist_button', 210 );
	}

	add_action( 'woocommerce_single_product_summary', 'front_add_to_wishlist_button',         3 );

	if( property_exists( $yith_wcwl, 'wcwl_init' ) ) {
		remove_action( 'wp_enqueue_scripts', array( $yith_wcwl->wcwl_init, 'enqueue_styles_and_stuffs' ) );
	}

	if( ! function_exists( 'front_get_wishlist_page_id' ) ){
		/**
		 * Gets the page ID of wishlist page
		 *
		 * @return int
		 */
		function front_get_wishlist_page_id() {
			$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
			return $wishlist_page_id;
		}
	}

	if( ! function_exists( 'front_is_wishlist_page' ) ) {
		/**
		 * Conditional tag to determine if a page is a wishlist page or not
		 *
		 * @return boolean
		 */
		function front_is_wishlist_page() {
			$wishlist_page_id = front_get_wishlist_page_id();
			return is_page( $wishlist_page_id );
		}
	}

	if( ! function_exists( 'front_get_wishlist_url') ) {
		/**
		 * Returns URL of wishlist page
		 *
		 * @return string
		 */
		function front_get_wishlist_url(){
			$wishlist_page_id = front_get_wishlist_page_id();
			return get_permalink( $wishlist_page_id );
		}
	}
}