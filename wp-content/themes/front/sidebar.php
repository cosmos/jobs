<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package front
 */

if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
    return;
}

$sidebar_class = 'blog-sidebar col-lg-3';
$blog_layout   = front_get_blog_layout();

if ( $blog_layout === 'sidebar-right' ) {
    $sidebar_class .= ' order-lg-1';
}
?>

<div id="stickyBlockStartPoint" class="<?php echo esc_attr( $sidebar_class ); ?>">
    <div class="js-sticky-block"
           data-offset-target="#logoAndNav"
           data-parent="#stickyBlockStartPoint"
           data-sticky-view="lg"
           data-start-point="#stickyBlockStartPoint"
           data-end-point="#stickyBlockEndPoint"
           data-offset-top="32"
           data-offset-bottom="170">
        <?php dynamic_sidebar( 'sidebar-blog' ); ?>
    </div>
</div>