<?php
/**
 * This template is for displaying single listing page
 *
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

/**
 * Hook: front_hp_before_single_listing.
 *
 */
do_action( 'front_hp_before_single_listing', $listing );

?>
<div id="listing-<?php the_ID(); ?>" class="container space-2">
    <?php
    /**
     * Hook: front_hp_before_single_listing_summary.
     */
    do_action( 'front_hp_before_single_listing_summary', $listing );
    ?>
    <div class="row">
        <div class="col-md-4 col-lg-3 u-ver-divider u-ver-divider--none-md mb-9 mb-md-0">
            <div class="mr-lg-2">
                <?php
                /**
                 * Hook: front_hp_single_listing_summary_sidebar.
                 */
                do_action( 'front_hp_single_listing_summary_sidebar', $listing );
            	?>
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="ml-lg-2">
                <?php
                /**
                 * Hook: front_hp_single_listing_summary.
                 */
                do_action( 'front_hp_single_listing_summary', $listing );
                ?>
            </div>
        </div>
    </div>
    <?php
    /**
     * Hook: front_hp_after_single_listing_summary.
     */
    do_action( 'front_hp_after_single_listing_summary', $listing );
    ?>
</div>
<?php

/**
 * Hook: front_hp_after_single_listing.
 */
do_action( 'front_hp_after_single_listing', $listing );
