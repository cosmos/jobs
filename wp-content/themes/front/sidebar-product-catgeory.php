<?php
/**
 * The sidebar containing the product sidebar sidebar widget area.
 *
 * @package front
 */

if ( ! is_active_sidebar( 'sidebar-product-catgeory' ) ) {
    return;
}

$sidebar_class = 'col-lg-3';

?>

<div id="secondary" class="widget-area shop-sidebar product-category-sidebar <?php echo esc_attr( $sidebar_class ); ?>" role="complementary">
    <?php dynamic_sidebar( 'sidebar-product-catgeory' ); ?>
</div><!-- #secondary -->
