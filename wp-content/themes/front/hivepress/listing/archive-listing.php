<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="container space-2">
    <div class="row">
        <?php if( is_active_sidebar( 'sidebar-hp-listings' ) ) : ?>
            <div class="col-lg-3 u-ver-divider u-ver-divider--none-lg mb-7 mb-lg-0">
                <div class="mr-lg-3">
                    <div class="navbar-expand-lg navbar-expand-lg-collapse-block">
                        <button class="btn btn-block btn-gray d-lg-none collapsed" type="button" data-toggle="collapse" data-target="#sidebar-nav" aria-controls="sidebar-nav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="d-flex justify-content-between align-items-center">
                                <span><?php echo apply_filters( 'front_sidebar_hp_listing_btn_title', esc_html( 'View all categories', 'front' ) ); ?></span>
                                <span class="fas fa-angle-right"></span>
                            </span>
                        </button>
                        <div id="sidebar-nav" class="hp-listing-sidebar navbar-collapse collapse">
                            <?php dynamic_sidebar( 'sidebar-hp-listings' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-lg-9">
            <div class="ml-lg-2">
                <?php
                do_action( 'front_hp_before_listing_loop' );
                ?>
                <?php if ( have_posts() ) :  ?>
                <div class="row mx-n2 mb-3">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-sm-6 col-md-4 px-2 mb-3">
                    <?php
                        $listing = HivePress\Models\Listing::query()->get_by_id( get_post() );
                        front_get_template( 'hivepress/listing/view/content-listing.php', array( 'listing' => $listing ) );
                    ?>
                    </div>
                <?php endwhile; ?>
                </div>
                <?php endif; ?>
                <?php
                do_action( 'front_hp_after_listing_loop' );
                ?>
            </div>
        </div>
    </div>
</div>
