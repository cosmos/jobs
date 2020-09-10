<?php
/**
 * The sidebar containing the Job sidebar widget area.
 *
 * @package front
 */

if ( ! is_active_sidebar( 'sidebar-resume' ) ) {
    return;
}

$sidebar_class = 'col-lg-3';

?>

<div id="secondary" class="widget-area sidebar-resume <?php echo esc_attr( $sidebar_class ); ?>" role="complementary">
    <div class="widget-area-inner">
        <?php
            do_action( 'resume_listing_sidebar_widget_before' );
            dynamic_sidebar( 'sidebar-resume' );
            do_action( 'resume_listing_sidebar_widget_after' );
        ?>
    </div><!-- /.widget-area-inner -->
</div><!-- #secondary -->
