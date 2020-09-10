<?php
/*
 * Single Company
 */

if( ! function_exists( 'front_single_company_remove_plugin_hooks' ) ) {
    function front_single_company_remove_plugin_hooks() {
        remove_action( 'single_company_start', 'mas_wpjmc_single_company_content_open', 10 );
        remove_action( 'single_company', 'mas_wpjmc_single_company_header', 10 );
        remove_action( 'single_company', 'mas_wpjmc_single_company_features', 20 );
        remove_action( 'single_company', 'mas_wpjmc_single_company_description', 30 );
        remove_action( 'single_company', 'mas_wpjmc_single_company_video', 40 );
        remove_action( 'single_company_end', 'mas_wpjmc_single_company_content_close', 10 );
    }
}

if( ! function_exists( 'front_single_company_content_open' ) ) {
    function front_single_company_content_open() {
        ?><div class="container space-2"><div class="row"><?php
    }
}

if( ! function_exists( 'front_single_company_content' ) ) {
    function front_single_company_content() {
        ?>
        <div class="col-lg-8">
            <div class="pl-lg-4">
                <?php do_action( 'single_company_content' ); ?>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_company_sidebar' ) ) {
    function front_single_company_sidebar() {
        ?>
        <div class="col-lg-4 mb-9 mb-lg-0">
            <div class="card shadow-sm p-5 mb-5">
                <?php do_action( 'single_company_sidebar' ); ?>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_company_content_close' ) ) {
    function front_single_company_content_close() {
        ?></div></div><?php
    }
}

if( ! function_exists( 'front_single_company_description' ) ) {
    function front_single_company_description() {
        if( !empty( get_the_content() ) ) : 
            ?>
            <div class="mb-4">
                <h2 class="h5"><?php esc_html_e( 'About Company', 'front' ) ?></h2>
            </div>
            <div class="border-bottom pb-5 mb-5">
                <?php the_content(); ?>
            </div>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_company_details' ) ) {
    function front_single_company_details() {
        ?>
        <div class="text-center">
            <div class="mb-3 mx-auto">
                <?php front_the_company_logo( 'thumbnail', 'company-logo img-fluid rounded-circle max-width-15' ); ?>
            </div>
            <?php
            the_title( '<h1 class="h5">', '</h1>' );

            if( front_is_mas_wp_job_manager_company_review_activated() && ( $review_average = mas_wpjmcr_get_reviews_average() ) ) :
                ?>
                <div class="reviews-average mb-2">
                    <span class='text-warning mr-2'>
                        <?php for ( $i = 0; $i < mas_wpjmcr_get_max_stars(); $i++ ) : ?>
                            <small class="<?php echo esc_attr( $i < $review_average ? 'fas' : 'far' ); ?> fa-star"></small>
                        <?php endfor; ?>
                    </span>
                    <span class="font-weight-semi-bold">
                        <?php echo number_format( $review_average, 2, '.', ''); ?>
                    </span>
                    <small class="text-muted">
                        (<?php echo sprintf( _n( '%s review', '%s reviews', intval( mas_wpjmcr_get_reviews_count() ), 'front' ), intval( mas_wpjmcr_get_reviews_count() ) ); ?>)
                    </small>
                </div><!-- .reviews-average -->
                <?php
            endif;

            if( ! empty( $website = front_get_the_meta_data( '_company_website', null, 'company' ) ) ) :
                ?>
                <div class="mb-4">
                    <a class="font-size-1" href="<?php echo esc_url( $website ); ?>">
                        <?php echo esc_html( front_get_the_meta_data( '_company_website', null, 'company', true ) ); ?>
                    </a>
                </div>
                <?php
            endif;

            do_action( 'single_company_details_after' );
            ?>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_single_company_details_buttons' ) ) {
    function front_single_company_details_buttons() {
        ?>
        <div class="mb-2">
            <?php do_action( 'single_company_details_buttons' ); ?>
        </div>
        <?php
    }
}


if( ! function_exists( 'front_single_company_details_open_position_link' ) ) {
    function front_single_company_details_open_position_link() {
         if ( defined( 'JOBS_IS_ON_FRONT' ) ) {
            $link = home_url( '/' );
        } else {
            $link = get_permalink( front_wpjm_get_page_id( 'jobs' ) );
        }

        $link .= '?company_id=' . get_the_ID();

        if( apply_filters( 'front_single_company_details_show_zero_open_position_link', true ) || mas_wpjmc_get_the_company_job_listing_count() > 0 ) :
            ?>
            <a class="company-job_listings__button btn btn-sm btn-soft-primary transition-3d-hover" href="<?php echo esc_url( $link ) ?>">
                <?php echo sprintf( _n( '%s Open Job', '%s Open Jobs', mas_wpjmc_get_the_company_job_listing_count(), 'front' ), mas_wpjmc_get_the_company_job_listing_count() ); ?>
            </a>
            <?php
        endif;
    }
}

if( ! function_exists( 'front_single_company_sidebar_svg_icon_block' ) ) {
    function front_single_company_sidebar_svg_icon_block() {
        $args = apply_filters( 'front_single_company_sidebar_svg_icon_block_elements_args', array(
            'company_location'  => array(
                'text_1' => front_get_the_meta_data( '_company_location', null, 'company' ),
                'text_2' => esc_html__( 'Headquarters', 'front' ),
                'svg'    => '/assets/svg/icons/icon-8.svg',
            ),
            'company_since'  => array(
                'text_1' => front_get_the_meta_data( '_company_since', null, 'company' ),
                'text_2' => esc_html__( 'Founded', 'front' ),
                'svg'    => '/assets/svg/icons/icon-11.svg',
            ),
            'company_strength'  => array(
                'text_1' => front_get_taxomony_data( 'company_strength' ),
                'text_2' => esc_html__( 'Employees', 'front' ),
                'svg'    => '/assets/svg/icons/icon-7.svg',
            ),
            'company_location'  => array(
                'text_1' => front_get_taxomony_data( 'company_location' ),
                'text_2' => esc_html__( 'Industry', 'front' ),
                'svg'    => '/assets/svg/icons/icon-13.svg',
            ),
            'company_revenue'  => array(
                'text_1' => front_get_taxomony_data( 'company_revenue' ),
                'text_2' => esc_html__( 'Revenue', 'front' ),
                'svg'    => '/assets/svg/icons/icon-22.svg',
            ),
            'company_average_salary'  => array(
                'text_1' => front_get_taxomony_data( 'company_average_salary' ),
                'text_2' => esc_html__( 'Avg. Salary', 'front' ),
                'svg'    => '/assets/svg/icons/icon-34.svg',
            ),
        ) );

        $args['dataParent'] = '#SVGCompanyStatsIcon';
        
        if( is_array( $args ) && count( $args ) > 0 ) {
            if( ! empty( front_single_sidebar_get_svg_icon_block_content( $args ) ) ) {
                ?><div class="border-top pt-5 mt-5"><div id="SVGCompanyStatsIcon" class="row"><?php
                    echo front_single_sidebar_get_svg_icon_block_content( $args );
                ?></div></div><?php
            }
        }
    }
}

if( ! function_exists( 'front_single_company_linked_accounts' ) ) {
    function front_single_company_linked_accounts() {
        $args = apply_filters( 'front_single_company_linked_accounts_args', array(
            'website'   => array(
                'text'  => get_the_title(),
                'link'  => front_get_the_meta_data( '_company_website', null, 'company', true ),
                'image' => get_the_company_logo( null, 'thumbnail') ? get_the_company_logo( null, 'thumbnail') : apply_filters( 'job_manager_default_company_logo', JOB_MANAGER_PLUGIN_URL . '/assets/images/company.png' ),
            ),
            'twitter'   => array(
                'text'  => esc_html__( 'Twitter', 'front' ),
                'link'  => front_get_the_meta_data( '_company_twitter', null, 'company', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img19.png',
            ),
            'facebook'  => array(
                'text'  => esc_html__( 'Facebook', 'front' ),
                'link'  => front_get_the_meta_data( '_company_facebook', null, 'company', true ),
                'image' => get_template_directory_uri() . '/assets/img/160x160/img20.png',
            ),
        ) );
        
        if( is_array( $args ) && count( $args ) > 0 ) {
            if( ! empty( front_single_get_linked_accounts_content( $args ) ) ) {
                ?>
                <div class="border-top pt-5 mt-5">
                    <h4 class="font-size-1 font-weight-semi-bold text-uppercase mb-3"><?php esc_html_e( 'Linked Accounts', 'front' ); ?></h4>
                    <?php echo front_single_get_linked_accounts_content( $args ); ?>
                </div>
                <?php
            }
        }
    }
}

if( ! function_exists( 'front_single_company_related_companies' ) ) {
    function front_single_company_related_companies() {
        global $post;

        $args = apply_filters( 'front_single_company_related_companies_default_args', array( 
            'posts_per_page'=> 5,
            'orderby'       => 'date',
            'order'         => 'DESC',
            'taxonomy'      => 'company_location',
        ) );

        extract( $args );

        $slugs = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'slugs' ) );

        if( is_array( $slugs ) && count( $slugs ) > 0 ) {
            $query_args = array(
                'post_type'     => 'company',
                'posts_per_page'=> $posts_per_page,
                'orderby'       => $orderby,
                'order'         => $order,
                'tax_query'     => array( 
                    array(
                        'taxonomy'  => $taxonomy,
                        'field'     => 'slug',
                        'terms'     => $slugs,
                        'operator'  => 'IN',
                    ),
                ),
                'post__not_in'  => array( $post->ID ),
            );

            $wp_query = new WP_Query( $query_args );
            
            if ( $wp_query->have_posts() ) :
                $posts = get_posts( $query_args );
                ?><div class="border-top pt-5 mt-5"><?php
                    ?><h4 class="font-size-1 font-weight-semi-bold text-uppercase mb-3"><?php esc_html_e( 'Job Seekers Also Viewed', 'front' ); ?></h4><?php
                    $i = 0;
                    foreach( $posts as $key => $post ) {
                        if( $i == 3 ) :
                            ?><div class="collapse" id="collapseRelatedCompanies"><?php
                        endif;
                        ?>
                        <div class="media align-items-center mb-3">
                            <div class="u-sm-avatar mr-3">
                                <?php front_the_company_logo(); ?>
                            </div>
                            <div class="media-body">
                                <h4 class="font-size-1 mb-0">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
                                <?php if( front_is_mas_wp_job_manager_company_review_activated() ) : ?>
                                    <?php $review_average = mas_wpjmcr_get_reviews_average(); ?>
                                    <div class="reviews-average d-md-flex align-items-md-center">
                                        <span class='text-warning small mr-2'>
                                            <?php for ( $i = 0; $i < mas_wpjmcr_get_max_stars(); $i++ ) : ?>
                                                <span class="<?php echo esc_attr( $i < $review_average ? 'fas' : 'far' ); ?> fa-star"></span>
                                            <?php endfor; ?>
                                        </span>
                                        <small class="text-muted">
                                            <?php echo sprintf( _n( '%s review', '%s reviews', intval( mas_wpjmcr_get_reviews_count() ), 'front' ), intval( mas_wpjmcr_get_reviews_count() ) ); ?>
                                        </small>
                                    </div><!-- .reviews-average -->
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                        if( $i >= 3 && $i == ( count( $posts ) - 1 ) ) :
                            ?>
                            </div>
                            <a class="link link-collapse small font-size-1 collapsed" data-toggle="collapse" href="#collapseRelatedCompanies" role="button" aria-expanded="false" aria-controls="collapseRelatedCompanies">
                                <span class="link-collapse__default"><?php esc_html_e( 'View more', 'front' ); ?></span>
                                <span class="link-collapse__active"><?php esc_html_e( 'View less', 'front' ); ?></span>
                                <span class="link__icon ml-1"><span class="link__icon-inner">+</span></span>
                            </a>
                            <?php
                        endif;
                        $i++;
                    }
                ?></div><?php
            endif;
            wp_reset_postdata();
        }
    }
}

if( ! function_exists( 'front_single_company_comment' ) ) {
    function front_single_company_comment() {
        if ( comments_open() || get_comments_number() ) {
            comments_template( '/mas-wp-job-manager-company/comments.php' );
        }
    }
}

if( ! function_exists( 'front_company_content_remove_plugin_hooks' ) ) {
    function front_company_content_remove_plugin_hooks() {
        remove_action( 'company_start', 'mas_wpjmc_company_loop_open', 10 );
        remove_action( 'company', 'mas_wpjmc_company_loop_content', 10 );
        remove_action( 'company_end', 'mas_wpjmc_company_loop_close', 10 );
    }
}

if( ! function_exists( 'front_company_loop_content_open' ) ) {
    function front_company_loop_content_open() {
        ?><div class="container space-2"><?php
    }
}

if( ! function_exists( 'front_company_loop_open' ) ) {
    function front_company_loop_open() {
        ?><div class="card mw-100 mt-0 p-0 h-100"><?php
    }
}

if( ! function_exists( 'front_company_loop_content' ) ) {
    function front_company_loop_content() {
        ?>
        <div class="card-body p-4">
            <div class="media">
                <div class="u-avatar mr-3 mb-3 mb-sm-0">
                    <?php front_the_company_logo( 'thumbnail', 'company-logo img-fluid' ); ?>
                </div>
                <div class="media-body">
                    <div class="mb-4">
                        <h3 class="h6 mb-0">
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
                                    (<?php echo sprintf( _n( '%s review', '%s reviews', intval( mas_wpjmcr_get_reviews_count() ), 'front' ), intval( mas_wpjmcr_get_reviews_count() ) ); ?>)
                                </span>
                            </a><!-- .reviews-average -->
                        <?php endif; ?>
                    </div>
                    <div class="mb-4">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="u-ver-divider pr-3 mr-3">
                            <a class="font-size-1 text-secondary font-weight-medium" href="<?php the_permalink(); ?>"><?php esc_html_e('Salaries', 'front') ?></a>
                        </div>
                        <div class="u-ver-divider pr-3 mr-3">
                            <a class="font-size-1 text-secondary font-weight-medium" href="<?php the_permalink(); ?>#respond"><?php esc_html_e('Q&A', 'front') ?></a>
                        </div>
                        <?php
                            if ( defined( 'JOBS_IS_ON_FRONT' ) ) {
                                $link = home_url( '/' );
                            } else {
                                $link = get_permalink( front_wpjm_get_page_id( 'jobs' ) );
                            }

                            $link .= '?company_id=' . get_the_ID();

                            if( apply_filters( 'front_single_company_details_show_zero_open_position_link', true ) || mas_wpjmc_get_the_company_job_listing_count() > 0 ) :
                                ?>
                                <a class="font-size-1 font-weight-medium" href="<?php echo esc_url( $link ) ?>">
                                    <?php echo sprintf( _n( 'Open Job - %s', 'Open Jobs - %s', mas_wpjmc_get_the_company_job_listing_count(), 'front' ), mas_wpjmc_get_the_company_job_listing_count() ); ?>
                                </a>
                                <?php
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if( ! function_exists( 'front_company_loop_close' ) ) {
    function front_company_loop_close() {
        ?></div><?php
    }
}

if( ! function_exists( 'front_company_loop_content_close' ) ) {
    function front_company_loop_content_close() {
        ?></div><?php
    }
}
