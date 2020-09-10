<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

global $product;
?>

<div class="yith-wcwl-add-button">
    <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id, $base_url ) )?>" rel="nofollow" data-product-id="<?php echo $product_id ?>" data-product-type="<?php echo $product_type?>" data-original-product-id="<?php echo $parent_product_id ?>" class="<?php echo $link_classes ?>">
    	<?php echo $icon ?>
        <span class="wishlist-text"><?php echo $label ?></span>
    </a>
</div>