<?php
/**
 * The template for displaying listing content within loops
 *
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="card card-frame h-100">
    <?php
	/**
	 * Hook: front_hp_before_listing_loop_item_header.
	 *
	 * @hooked front_hp_show_listing_loop_sale_flash - 10
	 * @hooked front_hp_template_loop_listing_thumbnail - 10
	 */
	do_action( 'front_hp_before_listing_loop_item_header', $listing );

	/**
	 * Hook: front_hp_listing_loop_item_body.
	 *
	 * @hooked front_hp_template_loop_listing_title - 10
	 */
	do_action( 'front_hp_listing_loop_item_body', $listing );

	/**
	 * Hook: front_hp_after_listing_loop_item_footer.
	 *
	 * @hooked front_hp_template_loop_rating - 5
	 * @hooked front_hp_template_loop_price - 10
	 */
	do_action( 'front_hp_after_listing_loop_item_footer', $listing );

	?>
</div>
