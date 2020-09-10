<?php
/**
 * Single Listing tabs
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see front_hp_default_listing_tabs()
 */

$default_active_tab = empty( $default_active_tab ) ? 0 : $default_active_tab;
$listing_tabs = apply_filters( 'front_hp_listing_tabs', array(), $listing );

if ( ! empty( $listing_tabs ) ) : ?>
<div id="listing-tabs" class="listing-tabs">
    <ul id="pills-listing-tab" class="nav nav-classic nav-rounded nav-justified border" role="tablist">
        <?php foreach ( $listing_tabs as $key => $listing_tab ) : ?>
            <li class="<?php echo esc_attr( $key ); ?>_tab nav-item" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                <a href="#tab-<?php echo esc_attr( $key ); ?>" class="nav-link font-weight-medium<?php if ( $key == $default_active_tab ) echo esc_attr( ' active show' ); ?>" data-toggle="pill">
                    <?php echo wp_kses_post( apply_filters( 'front_hp_listing_' . $key . '_tab_title', $listing_tab['title'], $key ) ); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div id="pills-listing-tab-content" class="tab-content">
        <?php foreach ( $listing_tabs as $key => $listing_tab ) : ?>
            <div class="tab-pane fade pt-6<?php if ( $key == $default_active_tab ) echo esc_attr( ' active show' ); ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
                <?php
                if ( isset( $listing_tab['callback'] ) ) {
                	call_user_func( $listing_tab['callback'], $key, $listing_tab, $listing );
                }
                ?>
            </div>
        <?php endforeach; ?>

        <?php do_action( 'front_hp_listing_after_tabs' ); ?>
    </div>
</div>
<?php endif; ?>
