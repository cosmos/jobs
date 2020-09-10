<?php
/**
 * The sidebar containing the shop sidebar widget area.
 *
 * @package front
 */

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
    return;
}

$sidebar_class = 'col-lg-3';

?>

<div id="secondary" class="widget-area shop-sidebar <?php echo esc_attr( $sidebar_class ); ?>" role="complementary">
    <?php dynamic_sidebar( 'sidebar-shop' ); ?>
</div><!-- #secondary -->
