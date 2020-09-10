<?php

/**
 * Front HivePress for Marketplace Template Functions
 *
 */

if ( ! function_exists( 'front_hp_breadcrumbs' ) ) {

    /**
     * Override Listing Breadcrumb Function
     */
    function front_hp_breadcrumbs() {
        global $post;

        $html = '';
        $args = apply_filters( 'front_hp_breadcrumbs', array(
            'delimiter' => '',
            'home'      => esc_html__( 'Home', 'front' ),
            'before'    => '<li class="breadcrumb-item active" aria-current="page">',
            'after'     => '</li>'
        ) );

        $breadcrumb_position = 1;

        $space_class = ' mb-0';
        

        $html .= '<ol class="breadcrumb breadcrumb-no-gutter font-size-1' . $space_class . '" itemscope itemtype="http://schema.org/BreadcrumbList">';
        $html .= front_hp_get_breadcrumb_item( $args['home'], home_url( '/' ), $breadcrumb_position );
        $html .= $args['delimiter'];

        if( front_hp_is_listing_search() || front_hp_is_listing_taxonomy() ) {
            $html .= ' ' . $args['before'] . front_get_the_archive_title() . $args['after'];
        } else {
            $html .= ' ' . $args['before'] . get_the_title() . $args['after'];
        }

        $html .= '</ol>';

        if( front_hp_is_listing_single() ) {
            $html = '<nav class="d-inline-block rounded" aria-label="breadcrumb">' . $html . '</nav>';
        }

        echo apply_filters( 'front_hp_breadcrumbs_html', $html, $args );
    }

}


if ( ! function_exists( 'front_hp_get_breadcrumb_item' ) ) {

    /**
     * Schema.org breadcrumb item wrapper for a link
     *
     * @param  string  $label
     * @param  string  $permalink
     * @param  integer $position
     *
     * @return string
     */
    function front_hp_get_breadcrumb_item( $label, $permalink, $position = 1 ) {
        return '<li itemprop="itemListElement" class="breadcrumb-item" itemscope itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="' . esc_attr( $permalink ) . '">
            <span itemprop="name">' . esc_html( $label ) . '</span></a>
            <meta itemprop="position" content="' . $position . '" />
        </li>';
    }

}

if ( ! function_exists( 'front_hp_listing_breadcrumb_with_search' ) ) {
    /**
     * Breadcrumb with Search
     *
     */
    function front_hp_listing_breadcrumb_with_search() {
        ?>
        <div class="row align-items-md-center mb-10">
            <div class="col-md-5 mb-5 mb-md-0">
                <?php front_hp_breadcrumbs(); ?>
            </div>

            <div class="col-md-7 text-md-right">
                <?php front_hp_listing_search_form(); ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_hp_default_listing_tabs' ) ) {

    /**
     * Add default listing tabs to listing pages.
     *
     * @param array $tabs Array of tabs.
     * @return array
     */
    function front_hp_default_listing_tabs( $tabs = array(), $listing ) {
        global $post;

        // Description tab - shows listing content.
        if ( $post->post_content ) {
            $description_title = apply_filters( 'front_hp_default_listing_tabs_description_title', '<div class="d-md-flex justify-content-md-center align-items-md-center"><figure class="ie-height-40 d-none d-md-block w-100 max-width-5 mr-3"><img class="js-svg-injector" src="' . get_template_directory_uri() . '/assets/svg/icons/icon-24.svg" alt="' . esc_html__( 'SVG', 'front' ) . '" data-parent="#listing-tabs"></figure>' . esc_html__( 'App info', 'front' ) . '</div>' );
            $tabs['description'] = array(
                'title'    => $description_title,
                'priority' => 10,
                'callback' => 'front_hp_listing_description_tab',
            );
        }

        // Reviews tab - shows comments.
        if ( class_exists( 'HivePress\Models\Review' ) ) {
            $reviews_title = apply_filters( 'front_hp_default_listing_tabs_reviews_title', '<div class="d-md-flex justify-content-md-center align-items-md-center"><figure class="ie-height-40 d-none d-md-block w-100 max-width-5 mr-3"><img class="js-svg-injector" src="' . get_template_directory_uri() . '/assets/svg/icons/icon-7.svg" alt="' . esc_html__( 'SVG', 'front' ) . '" data-parent="#listing-tabs"></figure>' . esc_html__( 'Review', 'front' ) . '</div>' );
            $tabs['reviews'] = array(
                'title'    => $reviews_title,
                'priority' => 20,
                'callback' => 'front_hp_listing_reviews_tab',
            );
        }

        // Pricing tab - shows comments.
        if ( front_hp_listing_pricing_tab_has_content( $listing ) ) {
            $pricing_title = apply_filters( 'front_hp_default_listing_tabs_pricing_title', '<div class="d-md-flex justify-content-md-center align-items-md-center"><figure class="ie-height-40 d-none d-md-block w-100 max-width-5 mr-3"><img class="js-svg-injector" src="' . get_template_directory_uri() . '/assets/svg/icons/icon-22.svg" alt="' . esc_html__( 'SVG', 'front' ) . '" data-parent="#listing-tabs"></figure>' . esc_html__( 'Pricing', 'front' ) . '</div>' );
            $tabs['pricing'] = array(
                'title'    => $pricing_title,
                'priority' => 10,
                'callback' => 'front_hp_listing_pricing_tab',
            );
        }

        if ( $listing->_get_fields( 'view_page_primary' ) ) {
            $tabs['additional_info'] = array(
                'title'        => esc_html__( 'Additional Info', 'front' ),
                'priority'     => 30,
                'callback'     => 'front_hp_listing_additional_info',
            );
        }

        return $tabs;
    }
}

if ( ! function_exists( 'front_hp_listing_description_tab' ) ) {
    /**
     * Description tab
     *
     */
    function front_hp_listing_description_tab() {
        the_content();
    }
}

if ( ! function_exists( 'front_hp_listing_reviews_tab' ) ) {
    /**
     * Reviews tab
     *
     */
    function front_hp_listing_reviews_tab( $key, $listing_tab, $listing ) {
        $args = [
            'fields'  => [
                'listing' => [
                    'display_type' => 'hidden',
                    'value' => $listing->get_id(),
                ],
            ],
        ];
        $form = new HivePress\Forms\Review_Submit($args);
        // $form = new HivePress\Blocks\Review_Submit_Form($args);
        ?>
        <div class="d-sm-flex justify-content-sm-between align-items-sm-center border-bottom pb-3 mb-4">
            <div class="d-flex align-items-center mb-2 mb-sm-0">
                <h4 class="h5 font-weight-semi-bold mb-0"><?php echo esc_html__( 'Submit Review', 'front' ); ?></h4>
            </div>
        </div>
        <?php
        echo $form->render();

        // Set query.
        $review_query = HivePress\Models\Review::query()->filter(
            [
                'approved' => true,
                'listing' => $listing->get_id(),
            ]
        )->order( [ 'created_date' => 'desc' ] )
        ->limit( 1000 );

        // Query reviews.
        $reviews = $review_query->get();

        // Render reviews.
        if ( $reviews->count() ) {
            ?>
            <div class="d-sm-flex justify-content-sm-between align-items-sm-center border-bottom pb-3 mb-4">
                <div class="d-flex align-items-center mb-2 mb-sm-0">
                    <h4 class="h5 font-weight-semi-bold mb-0"><?php echo esc_html__( 'Reviews', 'front' ); ?> <small class="text-muted ml-1">(<?php echo esc_html( $listing->display_rating_count() ); ?>)</small></h4>
                </div>
            </div>
            <?php

            end($reviews);
            $last_key = key($reviews);
            reset($reviews);

            foreach ( $reviews as $key => $review ) {
                ?>
                <div class="media">
                    <div class="u-avatar mr-3">
                        <?php echo get_avatar( $review->get_author__id(), 100, '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
                    </div>
                    <div class="media-body mb-6<?php if( $key !== $last_key ) echo esc_attr( ' border-bottom pb-4' ); ?>">
                        <span class="h6 font-weight-semi-bold"><?php echo esc_html( $review->get_author__display_name() ); ?></span>
                        <div class="hp-review__rating hp-rating-stars my-2" data-component="rating" data-value="<?php echo esc_attr( $review->get_rating() ); ?>"></div>
                        <?php comment_text( $review->get_id() ); ?>
                        <?php if ( 0 ) : ?>
                        <small class="text-secondary mr-2">Was this review helpful?</small>
                        <a class="small mr-2" href="javascript:;">Yes</a>
                        <a class="small" href="javascript:;">No</a>

                        <!-- Reply -->
                        <div class="card bg-light p-3 mt-4">
                            <div class="media">
                                <div class="u-avatar mr-3">
                                    <img class="img-fluid" src="../../assets/img/160x160/img23.png" alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <span class="d-block font-weight-semi-bold">Google Drive</span>
                                    <p>Thanks for the review Maria! Let us know if you ever need anything.</p>
                                </div>
                            </div>
                        </div>
                        <!-- End Reply -->
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            }
        }
    }
}

if ( ! function_exists( 'front_hp_listing_pricing_tab_has_content' ) ) {
    /**
     * Check is Pricing tab has content
     *
     */
    function front_hp_listing_pricing_tab_has_content( $listing ) {
        $pricing_attribute_key = apply_filters( 'front_hp_listing_pricing_tab_attribute_key', 'pricing' );
        $fields = $listing->_get_fields();
        if ( isset( $fields[$pricing_attribute_key] ) ) {
            $content = $fields[$pricing_attribute_key]->get_value();
            if( ! empty( $content ) ) {
                return true;
            }
        }

        return false;
    }
}

if ( ! function_exists( 'front_hp_listing_pricing_tab' ) ) {
    /**
     * Pricing tab
     *
     */
    function front_hp_listing_pricing_tab( $key, $listing_tab, $listing ) {
        $pricing_attribute_key = apply_filters( 'front_hp_listing_pricing_tab_attribute_key', 'pricing' );
        $fields = $listing->_get_fields();
        if ( isset( $fields[$pricing_attribute_key] ) ) {
            $content = $fields[$pricing_attribute_key]->get_value();
            echo do_shortcode( $content );
        }
    }
}

if ( ! function_exists( 'front_hp_output_listing_data_tabs' ) ) {

    /**
     * Output the listing tabs.
     */
    function front_hp_output_listing_data_tabs( $listing ) {
        front_get_template( 'hivepress/listing/view/page/tabs.php', array( 'listing' => $listing, 'default_active_tab' => 'description' ) );
    }
}

if ( ! function_exists( 'front_hp_template_single_title' ) ) {

    /**
     * Output the listing title.
     */
    function front_hp_template_single_title( $listing ) {
        ?><div class="mb-5">
            <h2 class="font-weight-semi-bold">
                <?php the_title(); ?>
                <?php if ( $listing->is_verified() ): ?>
                <img class="ml-1" src="<?php echo esc_url( get_template_directory_uri() . '/assets/svg/components/top-vendor.svg' ); ?>" alt="<?php _e( 'Verified Icon', 'front' ); ?>" width="20">
                <?php endif; ?>
            </h2>
        </div><?php
    }
}

if ( ! function_exists( 'front_hp_template_single_listing_image' ) ) {
    /**
     * Output the listing image
     */
    function front_hp_template_single_listing_image( $listing ) {
        if ( has_post_thumbnail() ) {
            ?><div class="text-center mx-auto mb-3"><?php
                the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-fluid' ) );
            ?></div><?php
        }
    }
}

if ( ! function_exists( 'front_hp_template_single_listing_image_and_action' ) ) {
    /**
     * Outputs Listing Image and Action
     */
    function front_hp_template_single_listing_image_and_action( $listing ) {
        $fields = $listing->_get_fields();
        if ( isset( $fields['action_url_label'] ) ) {
            $action_text = $fields['action_url_label']->get_value();
        }
        $action_text = empty( $action_text ) ? apply_filters( 'front_hp_single_listing_action_text', esc_html__( 'Install Now', 'front' ) ) : $action_text;
        ?><div class="mb-7"><?php
            front_hp_template_single_listing_image( $listing );
            if ( isset( $fields['action_url'] ) ) {
                ?><a href="<?php echo esc_url( $fields['action_url']->get_value() ); ?>" class="btn btn-sm btn-block btn-primary transition-3d-hover"><?php echo esc_html( $action_text ); ?></a><?php
            }
        ?></div><?php
    }
}

if ( ! function_exists( 'front_hp_template_single_listing_categories' ) ) {
    /**
     * Outputs Listing Categories
     */
    function front_hp_template_single_listing_categories( $listing ) {
        if ( $listing->get_categories__id() ) :
            ?><div class="mb-md-7">
                <h3 class="h6 font-weight-semi-bold"><?php echo esc_html__( 'Categories', 'front' ); ?></h3>
                <?php foreach ( $listing->get_categories() as $category ) : ?>
                    <?php if( ! empty( $category ) ) : ?>
                        <span class="d-inline-block mr-1 mb-2">
                            <a class="btn btn-xs btn-soft-secondary" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_category_view_page', [ 'listing_category_id' => $category->get_id() ] ) ); ?>">
                                <?php echo esc_html( $category->get_name() ); ?>
                            </a>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div><?php
        endif;
    }
}

if ( ! function_exists( 'front_hp_template_single_listing_developer' ) ) {
    /**
     * Outputs Developer
     */
    function front_hp_template_single_listing_developer( $listing ) {
        $vendor = $listing->get_vendor();
        if ( $vendor ) :
            $is_vendor_display_enabled = get_option( 'hp_vendor_enable_display' );
            ?>
            <div class="d-none d-md-block mb-7">
                <h3 class="h6 font-weight-semi-bold"><?php echo esc_html__( 'Developer', 'front' ); ?></h3>
                <?php if( $is_vendor_display_enabled ) : ?>
                    <a class="d-inline-block text-secondary" href="<?php echo esc_url( hivepress()->router->get_url( 'vendor_view_page', [ 'vendor_id' => $vendor->get_id() ] ) ); ?>">
                <?php else : ?>
                    <div class="d-inline-block text-secondary">
                <?php endif; ?>
                    <div class="media align-items-center">
                        <div class="u-sm-avatar mr-3">
                            <?php if ( $vendor->get_image__url( 'hp_square_small' ) ) : ?>
                                <img src="<?php echo esc_url( $vendor->get_image__url( 'hp_square_small' ) ); ?>" alt="<?php echo esc_attr( $vendor->get_name() ); ?>">
                            <?php else : ?>
                                <img src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/user-square.svg' ); ?>" alt="<?php echo esc_attr( $vendor->get_name() ); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="media-body"><?php echo esc_html( $vendor->get_name() ); ?></div>
                    </div>
                <?php if( $is_vendor_display_enabled ) : ?>
                    </a>
                <?php else : ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        endif;
    }
}

if ( ! function_exists( 'front_hp_template_single_listing_developer_links' ) ) {
    /**
     * Outputs Developer Links
     */
    function front_hp_template_single_listing_developer_links( $listing ) {
        $vendor = $listing->get_vendor();
        if ( $vendor ) :
            $fields = $vendor->_get_fields();
            $links = array();
            foreach ( $fields as $key => $field ) {
                if( 'url' == $field->get_display_type() ) {
                    $links[] = array(
                        'name' => $field->get_name(),
                        'label' => $field->get_label(),
                        'value' => $field->get_value(),
                    );
                }
            }

            if( ! empty( $links ) ) :
                ?>
                <div class="d-none d-md-block mb-7">
                    <h3 class="h6 font-weight-semi-bold"><?php echo esc_html__( 'Developer Links', 'front' ); ?></h3>
                    <ul class="list-unstyled">
                        <?php foreach ( $links as $link ) : ?>
                            <li>
                                <a class="text-secondary font-size-1" href="<?php echo esc_url( $link['value'] ); ?>">
                                    <span class="fas fa-angle-right mr-1"></span> <?php echo esc_html( $link['label'] ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php
            endif;
        endif;
    }
}

if ( ! function_exists( 'front_hp_template_single_report_abuse' ) ) {
    /**
     * Outputs Report Abuse Link
     */
    function front_hp_template_single_report_abuse( $listing ) {
        ?><div class="d-none d-md-block">
            <a href="#<?php if ( is_user_logged_in() ) : ?>listing_report<?php else : ?>user_login<?php endif; ?>_modal" class="small text-secondary hp-listing__action hp-listing__action--report hp-link"><i class="hp-icon far fa-flag mr-1"></i><span><?php echo esc_html( hivepress()->translator->get_string( 'report_listing' ) ); ?></span></a>
        </div><?php
    }
}

if ( ! function_exists( 'front_hp_template_single_related_listings' ) ) {
    /**
     * Outputs Related Listings
     */
    function front_hp_template_single_related_listings( $listing ) {
        // Set query.
        $listing_query = HivePress\Models\Listing::query()->filter(
            [
                'status' => 'publish',
                'id__not_in' => [ $listing->get_id() ],
            ]
        )->order( 'random' )
        ->limit( 6 );

        // Set categories.
        if ( $listing->get_categories__id() ) {
            $listing_query->filter( [ 'categories__in' => $listing->get_categories__id() ] );
        }

        $posts = new \WP_Query( $listing_query->get_args() );

        if ( $posts->have_posts() ) {
            ?>
            <div class="container space-top-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="h5 font-weight-semi-bold mb-0"><?php echo hivepress()->translator->get_string( 'related_listings' ); ?></h3>
                    <a class="link-muted font-size-1" href="<?php echo get_post_type_archive_link( 'hp_listing' ); ?>"><?php echo esc_html__( 'View More', 'front' ); ?></a>
                </div>
                <div class="row mx-n2 mb-7">
                    <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                        <div class="col-sm-6 col-md-4 px-2 mb-3">
                        <?php
                            $_listing = HivePress\Models\Listing::query()->get_by_id( get_post() );
                            front_get_template( 'hivepress/listing/view/content-listing.php', array( 'listing' => $_listing ) );
                        ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'front_hp_listing_additional_info' ) ) {
    /**
     * Outputs Additional Info
     */
    function front_hp_listing_additional_info( $key, $tab, $listing ) {
        if ( $listing->_get_fields( 'view_page_primary' ) ) :
            ?>
            <div class="hp-listing__attributes hp-listing__attributes--primary hp-widget widget">
                <?php
                foreach ( $listing->_get_fields( 'view_page_primary' ) as $field ) :
                    if ( ! is_null( $field->get_value() ) ) :
                        ?>
                        <div class="hp-listing__attribute"><?php echo $field->display(); ?></div>
                        <?php
                    endif;
                endforeach;
                ?>
            </div>
            <?php
        endif;

        if ( $listing->_get_fields( 'view_page_secondary' ) ) :
            ?>
            <div class="hp-listing__attributes hp-listing__attributes--secondary">
                <div class="hp-row">
                    <?php
                    foreach ( $listing->_get_fields( 'view_page_secondary' ) as $field ) :
                        if ( ! is_null( $field->get_value() ) ) :
                            ?>
                            <div class="hp-col-lg-6 hp-col-xs-12">
                                <div class="hp-listing__attribute">
                                    <strong><?php echo esc_html( $field->get_label() ); ?>:</strong>
                                    <span><?php echo $field->display(); ?></span>
                                </div>
                            </div>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
            <?php
        endif;
    }
}

if ( ! function_exists( 'front_hp_template_loop_listing_link_open' ) ) {
    /**
	 * Insert the opening anchor tag for listings in the loop.
	 */
    function front_hp_template_loop_listing_link_open( $listing ) {
        ?><a class="card-body" href="<?php echo esc_url( hivepress()->router->get_url( 'listing_view_page', [ 'listing_id' => $listing->get_id() ] ) ); ?>"><?php
    }
}

if ( ! function_exists( 'front_hp_template_loop_listing_link_close' ) ) {
    /**
	 * Insert the closing anchor tag for listings in the loop.
	 */
    function front_hp_template_loop_listing_link_close( $listing ) {
        ?></a><?php
    }
}

if ( ! function_exists( 'front_hp_template_loop_listing_media' ) ) {
    /**
     * Outputs loop listing media
     */
    function front_hp_template_loop_listing_media( $listing ) {
        ?><div class="media align-items-center">
            <div class="u-sm-avatar mr-3">
                <?php
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'post-thumbnail', array( 'class' => 'img-fluid' ) );
                }
                ?>
            </div>
            <div class="media-body">
                <div class="d-flex align-items-center">
                    <span class="d-block text-dark font-weight-medium"><?php the_title(); ?></span>
                    <?php if ( $listing->is_verified() ): ?>
                    <img class="ml-2" src="<?php echo esc_url( get_template_directory_uri() . '/assets/svg/components/top-vendor.svg' ); ?>" alt="<?php _e( 'Verified Icon', 'front' ); ?>" width="20">
                    <?php endif; ?>
                </div>
                <?php if ( $listing->get_categories__id() ) :
                    $i = 0;
                    foreach ( $listing->get_categories() as $category ) :
                        if( ! empty( $category ) ) :
                        ?><small class="d-block text-secondary"><?php echo esc_html( $category->get_name() ); ?></small><?php
                        endif;
                        $i++;
                        if( $i == apply_filters( 'front_hp_template_loop_listing_display_categories_limit', 1 ) ) {
                            break;
                        }
                    endforeach;
                endif; ?>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'front_hp_listing_search_form' ) ) {
    /**
     * Outputs Listing Search Form
     */
    function front_hp_listing_search_form() {
        ?>
        <form action="<?php echo home_url( '/' ); ?>" method="GET" data-component="form" class="hp-form hp-form--listing-search">
            <div class="hp-form__messages" data-component="messages"></div>
            <input type="hidden" name="post_type" value="hp_listing" class="hp-field hp-field--hidden">
            <div class="d-flex align-items-center<?php if( ! is_single() ) echo esc_attr( ' mb-4' ); ?>">
                <div class="hp-form__field hp-form__field--search d-inline-block w-90 mr-2 mb-0">
                    <input type="search" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr__( 'Search for apps', 'front' ); ?>" maxlength="256" class="hp-field hp-field--search form-control">
                </div>
                <button type="submit" class="hp-form__button button alt button hp-field hp-field--submit btn btn-primary">
                    <span class="fas fa-search"></span>
                </button>
            </div>
        </form>
        <?php
    }
}

if ( ! function_exists( 'front_hp_listing_control_bar' ) ) {
    /**
     * Outputs Listing Control Bar
     */
    function front_hp_listing_control_bar() {
        ?><div class="mb-5 d-flex justify-content-between align-items-center">
            <div class="control-bar__left text-secondary"><?php front_hp_result_count(); ?></div>
            <div class="control-bar__right"><?php front_hp_catalog_ordering(); ?></div>
        </div><?php
    }
}

if ( ! function_exists( 'front_hp_result_count' ) ) {
    /**
     * Outputs HP Result Count
     */
    function front_hp_result_count() {
        echo ( new HivePress\Blocks\Result_Count() )->render();
    }
}


if ( ! function_exists( 'front_hp_catalog_ordering' ) ) {
    /**
     * Outputs HP Catalog Ordering
     */
    function front_hp_catalog_ordering() {
        //echo ( new HivePress\Forms\Listing_Sort() )->render();
    }
}

if ( ! function_exists( 'front_hp_listing_pagination' ) ) {
    /**
     * Display Pagination.
     */
    function front_hp_listing_pagination() {
        global $wp_query;
        $total   = $wp_query->max_num_pages;
        $current = max( 1, $wp_query->get( 'paged', 1 ) );
        $format  = '';
        $base    = esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) );

        if ( $total <= 1 ) {
            return;
        }

        ?>
        <nav class="front-hp-listing-pagination mt-5 jcc" aria-label="<?php echo esc_html__( 'Listings Navigation', 'front' ); ?>">
            <?php
                echo paginate_links( apply_filters( 'front_hp_listing_pagination_args', array( // WPCS: XSS ok.
                    'base'         => $base,
                    'format'       => $format,
                    'add_args'     => false,
                    'current'      => max( 1, $current ),
                    'total'        => $total,
                    'prev_text'    => '&larr;',
                    'next_text'    => '&rarr;',
                    'type'         => 'list',
                    'end_size'     => 3,
                    'mid_size'     => 3,
                ) ) );
            ?>
        </nav>
        <?php
    }
}
