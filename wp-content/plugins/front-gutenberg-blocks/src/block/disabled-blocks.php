<?php
/**
 * This is in charge of enabling/disabling blocks WP-side.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'frontgb_get_disabled_blocks' ) ) {

	/**
	 * Gets the list of block names of the disabled blocks.
	 *
	 * @return Array
	 */
	function frontgb_get_disabled_blocks() {
		$disabled_blocks = get_option( 'frontgb_disabled_blocks' );
		if ( false === $disabled_blocks ) {
			$disabled_blocks = array();
		}

		if ( function_exists( 'front_is_wp_job_manager_activated' ) && ! front_is_wp_job_manager_activated() ) {
			$disabled_blocks[] = 'fgb/jobs';
			$disabled_blocks[] = 'fgb/jobs-content';
			$disabled_blocks[] = 'fgb/jobs-hero-search';
			$disabled_blocks[] = 'fgb/jobs-hero-search-form';
		}

		if ( function_exists( 'front_is_mas_wp_company_manager_activated' ) && ! front_is_mas_wp_company_manager_activated() ) {
			$disabled_blocks[] = 'fgb/companies';
			$disabled_blocks[] = 'fgb/companies-content';
			$disabled_blocks[] = 'fgb/companies-search-form';
		}

		if ( function_exists( 'front_is_wp_jetpack_activated' ) && ! front_is_wp_jetpack_activated() ) {
			$disabled_blocks[] = 'fgb/portfolio';
		}

		if ( function_exists( 'front_is_wedocs_activated' ) && ! front_is_wedocs_activated() ) {
			$disabled_blocks[] = 'fgb/docs';
			$disabled_blocks[] = 'fgb/docs-content';
			$disabled_blocks[] = 'fgb/docs-list';
			$disabled_blocks[] = 'fgb/docs-list-content';
			$disabled_blocks[] = 'fgb/docs-posts-list';
		}

		if ( function_exists( 'front_is_woocommerce_activated' ) && ! front_is_woocommerce_activated() ) {
			$disabled_blocks[] = 'fgb/deals-product';
			$disabled_blocks[] = 'fgb/products-block';
			$disabled_blocks[] = 'fgb/products-block-content';
			$disabled_blocks[] = 'fgb/products-carousel-block';
			$disabled_blocks[] = 'fgb/products-category';
			$disabled_blocks[] = 'fgb/products-category-content';
			$disabled_blocks[] = 'fgb/shop-hero-slider';
		}

		return $disabled_blocks;
	}
}

if ( ! function_exists( 'frontgb_ajax_update_disable_blocks' ) ) {

	/**
	 * Ajax handler for saving the list of disabled blocks.
	 */
	function frontgb_ajax_update_disable_blocks() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_key( $_POST['nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, 'frontgb_disable_blocks' ) ) {
			wp_send_json_error( __( 'Security error, please refresh the page and try again.', FRONTGB_I18N ) );
		}

		$disabled_blocks = isset( $_POST['disabledBlocks'] ) ? $_POST['disabledBlocks'] : array();
		update_option( 'frontgb_disabled_blocks', $disabled_blocks );
		wp_send_json_success();
	}
	add_action( 'wp_ajax_frontgb_update_disable_blocks', 'frontgb_ajax_update_disable_blocks' );
}

if ( ! function_exists( 'frontgb_get_disabled_blocks_nonce' ) ) {

	/**
	 * Create a nonce for disabling blocks.
	 *
	 * @return String
	 */
	function frontgb_get_disabled_blocks_nonce() {
		return wp_create_nonce( 'frontgb_disable_blocks' );
	}
}
