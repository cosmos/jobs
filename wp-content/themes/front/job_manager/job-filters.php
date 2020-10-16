<?php
/**
 * Filters in `[jobs]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/job-filters.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

wp_enqueue_script( 'wp-job-manager-ajax-filters' );

do_action( 'job_manager_job_filters_before', $atts );

$args =  apply_filters( 'front_job_filters_args', array(
    'keywords_title_text'       => esc_html__( 'what', 'front' ),
    'keywords_subtitle_text'    => esc_html__( 'job title, keywords, or company', 'front' ),
    'keywords_placeholder_text' => esc_html__( 'Keyword or title', 'front' ),
    'location_title_text'       => esc_html__( 'where', 'front' ),
    'location_subtitle_text'    => esc_html__( 'city, state, or zip code', 'front' ),
    'location_placeholder_text' => esc_html__( 'City, state, or zip', 'front' ),
    'category_title_text'       => esc_html__( 'which', 'front' ),
    'category_subtitle_text'    => esc_html__( 'department, industry, or specialism', 'front' ),
    'category_placeholder_text' => esc_html__( 'All Category', 'front' ),
    'search_button_text'        => esc_html__( 'Find Jobs', 'front' ),
) );

?>

<div class="job-filters">
    <!-- Search Jobs Form -->
    <form class="job_filters">
        <?php do_action( 'job_manager_job_filters_start', $atts ); ?>
        <div class="search_jobs row align-items-md-center space-bottom-2 space-top-1">
            <?php do_action( 'job_manager_job_filters_search_jobs_start', $atts ); ?>

            <div class="search_keywords col-lg-4 mb-4 mb-lg-0">
                <!-- Input -->
                <div class="js-focus-state">
                    <label class="sr-only" for="search_keywords"><?php esc_html_e( 'Search Jobs', 'front' ) ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="searchJobs">
                                <span class="fas fa-search"></span>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="search_keywords" id="search_keywords" placeholder="<?php echo esc_attr( $args['keywords_placeholder_text'] ) ?>" aria-label="<?php echo esc_attr( $args['keywords_placeholder_text'] ) ?>" aria-describedby="searchJobs" value="<?php echo esc_attr( $keywords ); ?>" />
                    </div>
                </div>
                <!-- End Input -->
            </div>
            <div class="search_location col-sm-6 col-lg-3 mb-4 mb-lg-0">
                <!-- Input -->
                <div class="js-focus-state">
                    <label class="sr-only" for="search_location"><?php esc_html_e( 'Search Locations', 'front' ) ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="searchLocation">
                                <span class="fas fa-search"></span>
                            </span>
                        </div>
                        <input type="text" name="search_location" id="search_location" class="form-control" placeholder="<?php echo esc_attr( $args['location_placeholder_text'] ) ?>" aria-label="<?php echo esc_attr( $args['location_placeholder_text'] ) ?>" aria-describedby="searchLocation" value="<?php echo esc_attr( $location ); ?>" />
                    </div>
                </div>
                <!-- End Input -->
            </div>
            <?php if ( $categories ) : ?>
                <?php foreach ( $categories as $category ) : ?>
                    <input type="hidden" name="search_categories[]" value="<?php echo esc_attr( sanitize_title( $category ) ); ?>" />
                <?php endforeach; ?>
            <?php elseif ( $show_categories && ! is_tax( 'job_listing_category' ) && get_terms( array( 'taxonomy' => 'job_listing_category' ) ) ) : ?>
                <div class="search_categories col-sm-6 col-lg-3 mb-4 mb-lg-0">
                    <!-- Input -->
                    <div class="js-focus-state">
                        <label class="sr-only" for="search_categories"><?php esc_html_e( 'Select Category', 'front' ) ?></label>
                        <?php if ( $show_category_multiselect && apply_filters( 'front_job_search_filters_multi_select', true ) ) : ?>
                            <?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_category', 'hierarchical' => 1, 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category, 'hide_empty' => false ) ); ?>
                        <?php else : ?>
                            <?php job_manager_dropdown_categories( array( 'taxonomy' => 'job_listing_category', 'hierarchical' => 1, 'show_option_all' => esc_attr( $args['category_placeholder_text'] ), 'name' => 'search_categories', 'orderby' => 'name', 'selected' => $selected_category, 'multiple' => false, 'hide_empty' => false ) ); ?>
                        <?php endif; ?>
                    </div>
                    <!-- End Input -->
                </div>
            <?php endif; ?>
            <div class="showing_jobs col-lg-2 text-lg-right mb-4 mb-lg-0"></div>
            <?php do_action( 'job_manager_job_filters_search_jobs_end', $atts ); ?>
        </div>
        <?php do_action( 'job_manager_job_filters_end', $atts ); ?>
        <!-- End Checkbox -->
    </form>
    <!-- End Search Jobs Form -->
</div>

<?php do_action( 'job_manager_job_filters_after', $atts ); ?>

<noscript><?php esc_html_e( 'Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'front' ); ?></noscript>
