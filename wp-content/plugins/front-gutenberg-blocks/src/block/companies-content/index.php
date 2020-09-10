<?php
/**
 * Server-side rendering of the `fgb/companies-content` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `fgb/companies-content` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */
if ( ! function_exists( 'frontgb_render_companies_content_block' ) ) {
    function frontgb_render_companies_content_block( $attributes ) {

        if ( ! class_exists( 'Front' ) ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'Front is not activated', FRONTGB_I18N ) . '</p>';
        } elseif ( function_exists( 'front_is_wp_job_manager_activated' ) && ! front_is_wp_job_manager_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'WP Job Manager is not activated', FRONTGB_I18N ) . '</p>';
        } elseif ( function_exists( 'front_is_mas_wp_company_manager_activated' ) && ! front_is_mas_wp_company_manager_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'MAS WP Job Manager Company is not activated', FRONTGB_I18N ) . '</p>';
        }

        extract( $attributes );

        $default_args = apply_filters( 'mas_job_manager_company_gutenberg_default_args', array(
            'post_status'       => 'publish',
            'per_page'          => get_option( 'job_manager_companies_per_page', 10 ),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'categories'        => '',
        ) );

        $args = wp_parse_args( $shortcode_atts, $default_args );
        extract( $args );

        $category = is_array( $categories ) ? $categories : array_filter( array_map( 'trim', explode( ',', $categories ) ) );

        $companies = mas_wpjmc_get_companies( apply_filters( 'mas_job_manager_company_gutenberg_output_companies_args', array(
            'post_status'       => $post_status,
            'category'          => $category,
            'orderby'           => $orderby,
            'order'             => $order,
            'posts_per_page'    => $per_page,
        ) ) );

        $company_class = ( $view === 'list-small' ) ? 'col-12 col-lg-4 mb-3' : 'col-12 col-lg-6 mb-3';

        ob_start();

        if ( $companies->have_posts() ) : ?>

            <?php do_action( 'mas_wpjmc_before_shortcode_company_start', $companies, $attributes ); ?>
            
            <ul class="wpjmc-companies list-unstyled row mx-gutters-2 mb-n3">
                <?php while ( $companies->have_posts() ) : $companies->the_post(); ?>
                    <li <?php mas_wpjmc_company_class( $company_class ); ?>>
                        <div class="card mw-100 mt-0 p-0 h-100">
                            <div class="card-body p-4">
                                <div class="media">
                                    <div class="u-avatar mr-3<?php ( $view !== 'list-small' ) ? ' mb-3 mb-sm-0' : '' ?>">
                                        <?php front_the_company_logo( 'thumbnail', 'company-logo img-fluid' ); ?>
                                    </div>
                                    <div class="media-body">
                                        <div class="<?php echo esc_attr( ( function_exists( 'front_is_mas_wp_job_manager_company_review_activated' ) && front_is_mas_wp_job_manager_company_review_activated() && ( $review_average = mas_wpjmcr_get_reviews_average() ) ) ? 'mb-4' : 'mb-1' ); ?>">
                                            <h3 class="<?php echo esc_attr( $view === 'list-small' ? 'h6' : 'h5' ) ?> mb-0">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <?php if( function_exists( 'front_is_mas_wp_job_manager_company_review_activated' ) && front_is_mas_wp_job_manager_company_review_activated() && ( $review_average = mas_wpjmcr_get_reviews_average() ) ) : ?>
                                                <a class="reviews-average d-inline-block small" href="<?php the_permalink(); ?>#comments">
                                                    <span class='text-warning'>
                                                        <?php for ( $i = 0; $i < mas_wpjmcr_get_max_stars(); $i++ ) : ?>
                                                            <small class="<?php echo esc_attr( $i < $review_average ? 'fas' : 'far' ); ?> fa-star"></small>
                                                        <?php endfor; ?>
                                                    </span>
                                                    <span class="text-dark font-weight-semi-bold ml-2">
                                                        <?php echo number_format( $review_average, 2, '.', ''); ?>
                                                    </span>
                                                    <span class="text-muted">
                                                        (<?php echo sprintf( _n( '%s review', '%s reviews', intval( mas_wpjmcr_get_reviews_count() ), FRONTGB_I18N ), intval( mas_wpjmcr_get_reviews_count() ) ); ?>)
                                                    </span>
                                                </a><!-- .reviews-average -->
                                            <?php endif; ?>
                                        </div>
                                        <?php if( $view !== 'list-small' ) : ?>
                                            <div class="mb-4">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex align-items-center">
                                            <div class="u-ver-divider pr-3 mr-3">
                                                <a class="font-size-1 text-secondary font-weight-medium" href="<?php the_permalink(); ?>"><?php esc_html_e('Salaries', FRONTGB_I18N) ?></a>
                                            </div>
                                            <?php
                                                if( $view !== 'list-small' ) :
                                                    ?>
                                                    <div class="u-ver-divider pr-3 mr-3">
                                                        <a class="font-size-1 text-secondary font-weight-medium" href="<?php the_permalink(); ?>#respond"><?php esc_html_e('Q&A', FRONTGB_I18N) ?></a>
                                                    </div>
                                                    <?php
                                                endif;
                                                if ( defined( 'JOBS_IS_ON_FRONT' ) ) {
                                                    $link = home_url( '/' );
                                                } else {
                                                    $link = get_permalink( front_wpjm_get_page_id( 'jobs' ) );
                                                }

                                                $link .= '?company_id=' . get_the_ID();

                                                if( apply_filters( 'front_single_company_details_show_zero_open_position_link', true ) || mas_wpjmc_get_the_company_job_listing_count() > 0 ) :
                                                    ?>
                                                    <a class="font-size-1 font-weight-medium" href="<?php echo esc_url( $link ) ?>">
                                                        <?php echo sprintf( _n( 'Open Job - %s', 'Open Jobs - %s', mas_wpjmc_get_the_company_job_listing_count(), FRONTGB_I18N ), mas_wpjmc_get_the_company_job_listing_count() ); ?>
                                                    </a>
                                                    <?php
                                                endif;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>

        <?php else :
            do_action( 'job_manager_output_jobs_no_results' );
        endif;

        wp_reset_postdata();

        return apply_filters( 'mas_job_manager_companies_output', ob_get_clean() );
    }
}

if ( ! function_exists( 'frontgb_register_companies_content_block' ) ) {
    /**
     * Registers the `fgb/companies-content` block on server.
     */
    function frontgb_register_companies_content_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/companies-content',
            array(
                'attributes' => array(
                    'shortcode_atts'=> array(
                        'type'      => 'object',
                        'default'   => array(
                            'per_page'      => 9,
                            'orderby'       => 'date',
                            'order'         => 'DESC',
                        ),
                    ),
                    'view'          => array(
                        'type'      => 'string',
                        'default'   => 'list-small',
                    ),
                ),
                'render_callback' => 'frontgb_render_companies_content_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_companies_content_block' );
}