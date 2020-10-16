<?php
/**
 * Template Tags used in Single Product Page
 *
 * @package front
 */

if ( ! function_exists( 'front_wc_single_product_hero_start' ) ) {
    /**
     * Single Product Hero Section Start
     */
    function front_wc_single_product_hero_start() {
        ?><div class="single_product__hero container space-top-1 space-top-sm-2">
            <div class="row"><?php
    }
}

if ( ! function_exists( 'front_wc_single_product_image_start' ) ) {
    /**
     * Single Product Image Block Start
     */
    function front_wc_single_product_image_start() {
        ?><div class="single-product__image col-lg-7 mb-7 mb-lg-0">
            <div class="pr-lg-4">
                <div class="position-relative"><?php
    }
}

if ( ! function_exists( 'front_wc_single_product_image_end' ) ) {
    /**
     * Single Product Image Block End
     */
    function front_wc_single_product_image_end() {
                ?></div>
            </div>
        </div><!-- /.single-product__image --><?php
    }
}

if ( ! function_exists( 'front_wc_single_product_summary_start' ) ) {
    /**
     * Single Product Summary Block Start
     */
    function front_wc_single_product_summary_start() {
        ?><div class="single-product__summary col-lg-5"><?php
    }
}

if ( ! function_exists( 'front_wc_single_product_summary_end' ) ) {
    /**
     * Single Product Summary Block End
     */
    function front_wc_single_product_summary_end() {
        ?></div><!-- /.single-product__summary --><?php
    }
}

if ( ! function_exists( 'front_wc_single_product_hero_end') ) {
    /**
     * Single Product Hero End
     */
    function front_wc_single_product_hero_end() {
        ?></div>
    </div><!-- /.single-product__hero --><?php
    }
}

if ( ! function_exists( 'front_wc_template_single_rating' ) ) {
    function front_wc_template_single_rating() {
        global $product;

        if ( ! wc_review_ratings_enabled() ) {
            return;
        }

        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();

        ?><div class="d-flex align-items-center small mb-2 woocommerce-product-rating single-product__rating">
            <?php if ( $rating_count > 0 ) : ?>
            <div class="text-warning mr-2">
                <small class="fas fa-star"></small>
                <small class="fas fa-star"></small>
                <small class="fas fa-star"></small>
                <small class="fas fa-star"></small>
                <small class="fas fa-star"></small>
            </div>
            <?php endif; ?>
            <a class="js-go-to link-muted" href="#reviews" rel="nofollow" data-target="#reviews" data-compensation="#header" data-type="static">
            <?php
                if ( $rating_count === 0 ) {
                    echo esc_html__( 'Write a review', 'front' );
                } else {
                    printf( _n( 'Read %s review', 'Read all %s reviews', $review_count, 'front' ), '<span class="count">' . esc_html( $review_count ) . '</span>' );
                }
            ?>
            </a>
        </div><?php
    }
}

if ( ! function_exists( 'front_wc_template_single_title_excerpt' ) ) {
    function front_wc_template_single_title_excerpt() {
        global $post;
        $short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
        ?><div class="mb-5">
            <?php the_title( '<h1 class="product_title entry-title single-product__title h3 font-weight-medium">', '</h1>' ); ?>
            <div class="woocommerce-product-details__short-description single-product__excerpt">
                <?php echo wp_kses_post( $short_description ); // WPCS: XSS ok. ?>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'front_wc_template_single_price' ) ) {
    function front_wc_template_single_price() {
        global $product;
        ?><div class="mb-5 single-product__price">
            <h2 class="font-size-1 text-secondary font-weight-medium mb-0"><?php echo esc_html__( 'Total price:', 'front' ); ?></h2>
            <?php echo wp_kses_post( $product->get_price_html() ); ?>
        </div><?php
    }
}

if ( ! function_exists( 'front_wc_before_add_to_cart_quantity' ) ) {
    function front_wc_before_add_to_cart_quantity() {
        global $product;
        $min_value = apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product );
        $max_value = apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product );
        if ( $max_value && $min_value === $max_value ) {
            return;
        }

        ?><div class="border rounded py-2 px-3 mb-3">
            <div class="js-quantity row align-items-center">
                <div class="col-7">
                    <small class="d-block text-secondary font-weight-medium"><?php echo esc_html__( 'Select quantity', 'front' ); ?></small><?php
    }
}

if ( ! function_exists( 'front_wc_after_add_to_cart_quantity' ) ) {
    function front_wc_after_add_to_cart_quantity() {
        global $product;
        $min_value = apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product );
        $max_value = apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product );
        if ( $max_value && $min_value === $max_value ) {
            return;
        }

                ?></div>
                <div class="col-5 text-right">
                    <a class="js-minus btn btn-icon btn-xs btn-outline-secondary rounded-circle" href="javascript:;">
                      <small class="fas fa-minus btn-icon__inner"></small>
                    </a>
                    <a class="js-plus btn btn-icon btn-xs btn-outline-secondary rounded-circle" href="javascript:;">
                      <small class="fas fa-plus btn-icon__inner"></small>
                    </a>
                </div>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'front_single_product_carousel_options' ) ) {
    function front_single_product_carousel_options( $args ) {
        $args['directionNav'] = true;
        return $args;
    }
}

if ( ! function_exists( 'front_features_section' ) ) {
    /**
     * Display Features list
     */
    function front_features_section( $args = array() ) {

        $features =  apply_filters( 'front_features_section_args', array(
            array(
                'icon'              => 'fgb-icon-65',
                'feature_title'     => esc_html__( 'Free Shipping', 'front' ),
                'feature_desc'      => esc_html__( 'We offer free shipping anywhere in the U.S. A skilled delivery team will bring the boxes into your office.', 'front' ),
            ),
            array(
                'icon'              => 'fgb-icon-64',
                'feature_title'     => esc_html__( '30 Days return', 'front' ),
                'feature_desc'      => esc_html__( 'We offer free shipping anywhere in the U.S. A skilled delivery team will bring the boxes into your office.', 'front' ),
            )
        ));

        if ( ! empty( $features ) && apply_filters( 'front_enable_cart_feature_list', true ) ) {
        ?>

        <div id="shopCartAccordion" class="accordion mb-5">
            <?php $id = '-' . uniqid(); ?>
            <?php foreach( $features as $key => $feature ) : ?>
            <?php $accordion_id = $id . $key; ?>
            <?php if ( ! empty( $feature['feature_title'] ) ) : ?>
                <div class="card">
                    <div class="card-header card-collapse" id="shopCardHeadingOne-<?php echo esc_attr( $accordion_id ); ?>">
                        <h3 class="mb-0">
                            <button type="button" class="btn btn-link btn-block card-btn collapsed"
                                    data-toggle="collapse"
                                    data-target="#shopCardOne-<?php echo esc_attr( $accordion_id ); ?>"
                                    aria-expanded="false"
                                    aria-controls="shopCardOne-<?php echo esc_attr( $accordion_id ); ?>">
                                <span class="row align-items-center">
                                    <span class="col-9">
                                        <span class="media align-items-center">
                                            <?php if ( ! empty( $feature['icon'] ) ) : ?>

                                                <?php $iconContent = false;
                                                $icon = $feature['icon'];

                                                if( $icon ) {
                                                    $iconClasses = array();
                                                    $iconPrefix = substr( $icon, 0, 3 );
                                                    if( $iconPrefix == "fgb" ) {
                                                        $iconClasses[] = 'ie-height-48';
                                                        $iconClasses[] = 'w-100';
                                                        $iconClasses[] = 'max-width-6';
                                                        $iconClasses[] = 'mr-3';
                                                        $buttonIconPath = front_get_icon_path( $icon );
                                                        $iconContent = '<img class="js-svg-injector" src="' . esc_url( $buttonIconPath ) . '" alt="' . esc_attr__( 'SVG', 'front' ) . '" />';
                                                    } else {
                                                        $iconClasses[] = str_replace( $iconPrefix, $iconPrefix . ' fa', $icon );
                                                        $iconContent = '<span class="' . esc_attr( implode( ' ', $iconClasses ) ) . '"></span>';
                                                    }
                                                }
                                                ?>
                                                <span id="icon<?php echo esc_attr( $accordion_id ); ?>" class="ie-height-48 w-100 max-width-6 mr-3">
                                                     <?php if( $icon ) {
                                                        echo wp_kses_post( $iconContent );

                                                    } ?>
                                                </span>
                                            <?php endif; ?>
                                            <span class="media-body">
                                                <?php
                                                if( ! empty( $feature['feature_title'] ) ) {
                                                    echo '<span class="d-block font-size-1 font-weight-medium">' . wp_kses_post( $feature['feature_title'] ) . '</span>' ;
                                                } ?>

                                            </span>
                                        </span>
                                    </span>
                                    <span class="col-3 text-right">
                                        <span class="card-btn-arrow">
                                            <span class="fas fa-arrow-down small"></span>
                                        </span>
                                    </span>
                                </span>
                            </button>
                        </h3>
                    </div>

                    <div id="shopCardOne-<?php echo esc_attr( $accordion_id ); ?>" class="collapse" aria-labelledby="shopCardHeadingOne-<?php echo esc_attr( $accordion_id ); ?>" data-parent="#shopCartAccordion">
                        <div class="card-body">
                            <?php if( ! empty( $feature['feature_desc'] ) ) {
                            echo '<p class="small mb-0">' . wp_kses_post( $feature['feature_desc'] ) . '</p>' ;

                            } ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
        <?php
        }

    }
}

if ( ! function_exists( 'front_wc_show_product_images' ) ) {
    function front_wc_show_product_images() {
        global $product;

        $columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
        $post_thumbnail_id = $product->get_image_id();
        $attachment_ids    = $product->get_gallery_image_ids();
        $wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
            'woocommerce-product-gallery',
            'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
            'woocommerce-product-gallery--columns-' . absint( $columns ),
            'woocommerce-thumb-count-' . count( $attachment_ids ),
            'images',
        ) );
        $image_ids         = $attachment_ids;
        array_unshift($image_ids, $post_thumbnail_id );

        ?>
        <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
            <!-- Main Slider -->
            <div id="heroSlider" class="js-slick-carousel u-slick border rounded"
               data-fade="true"
               data-infinite="true"
               data-autoplay-speed="7000"
               data-arrows-classes="d-none d-sm-inline-block u-slick__arrow u-slick__arrow--flat-white content-centered-y shadow-soft rounded-circle"
               data-arrow-left-classes="fas fa-arrow-left u-slick__arrow-inner u-slick__arrow-inner--left ml-3"
               data-arrow-right-classes="fas fa-arrow-right u-slick__arrow-inner u-slick__arrow-inner--right mr-3"
               data-nav-for="#heroSliderNav">
                <?php foreach( $image_ids as $image_id ) :

                    if ( $image_id ) {
                        ?>
                        <div class="js-slide">
                            <?php echo wc_get_gallery_image_html( $image_id, true ); ?>
                        </div>
                        <?php
                    } else {
                        echo '<div class="front-wc-product-gallery__image--placeholder">';
                        echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_attr__( 'Awaiting product image', 'front' ) );
                        echo '</div>';
                    }

                endforeach; ?>


            </div>
            <!-- End Main Slider -->
            <?php if( count( $attachment_ids ) > 0 ) : ?>
            <!-- Slider Nav -->
            <div class="position-absolute bottom-0 right-0 left-0 px-4 py-3">
                <div id="heroSliderNav" class="js-slick-carousel u-slick u-slick--gutters-1 u-slick--transform-off max-width-27 mx-auto"
                     data-slides-show="3"
                     data-infinite="true"
                     data-autoplay-speed="7000"
                     data-is-thumbs="true"
                     data-is-thumbs-progress="true"
                     data-thumbs-progress-options='{
                       "color": "<?php echo apply_filters('front_custom_primary_color', '#377dff');?>",
                       "width": 8
                     }'
                     data-thumbs-progress-container=".js-slick-thumb-progress"
                     data-nav-for="#heroSlider">
                    <?php foreach( $image_ids as $image_id ) :
                        if ( $image_id ) {
                            echo front_wc_get_gallery_image_html( $image_id );

                        } else {
                            echo '<div class="front-wc-product-gallery__image--placeholder">';
                            echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src()), esc_attr__( 'Awaiting product image', 'front' ) );
                            echo '</div>';
                        }

                    endforeach; ?>

                </div>
            </div>
             <!-- End Slider Nav -->
            <?php endif; ?>

            <?php
                if( apply_filters( 'front_wc_show_product_images_pause_autoplay', true ) ) {
                    $custom_script = "
                        jQuery(document).ready( function($){
                            $( 'body' ).on( 'woocommerce_gallery_init_zoom', function( e ) {
                                $( '.woocommerce-product-gallery .js-slick-carousel' ).slick( 'slickGoTo', 0 );
                                $( '.woocommerce-product-gallery .js-slick-carousel' ).slick( 'refresh' );
                                $( '.woocommerce-product-gallery .js-slick-carousel' ).slick( 'slickPause' );
                            } );
                        } );
                    ";
                } else {
                    $custom_script = "
                        jQuery(document).ready( function($){
                            $( 'body' ).on( 'woocommerce_gallery_init_zoom', function( e ) {
                                $( '.woocommerce-product-gallery .js-slick-carousel' ).slick( 'slickGoTo', 0 );
                                $( '.woocommerce-product-gallery .js-slick-carousel' ).slick( 'refresh' );
                            } );
                        } );
                    ";
                }
                wp_add_inline_script( 'front-scripts', $custom_script );
            ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_wc_get_gallery_image_html' ) ) {
    function front_wc_get_gallery_image_html( $attachment_id, $main_image = false ) {
        $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
        $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
        $image_size        = apply_filters( 'woocommerce_gallery_image_size', $main_image ? 'woocommerce_single': $thumbnail_size );
        $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
        $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
        $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
        $image             = wp_get_attachment_image( $attachment_id, $image_size, false, array(
            'title'                   => get_post_field( 'post_title', $attachment_id ),
            'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
            'data-src'                => $full_src[0],
            'data-large_image'        => $full_src[0],
            'data-large_image_width'  => $full_src[1],
            'data-large_image_height' => $full_src[2],
            'class'                   => $main_image ? 'wp-post-image' : '',
        ) );

        return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="js-slide p-1 front-wc-product-gallery__image">' . '<a class="js-slick-thumb-progress position-relative d-block u-avatar border rounded-circle p-1" href="javascript:;">' . $image . '</a>' . '</div>';
    }
}

if ( ! function_exists( 'front_output_product_data_tabs' ) ) {
    function front_output_product_data_tabs() {
        front_get_template( 'shop/single-product/tabs/front-tabs.php' );
    }
}

if ( ! function_exists( 'front_print_notices_wrap_open' ) ) {
    function front_print_notices_wrap_open() {
        ?>
        <div class="container"><?php
    }
}

if ( ! function_exists( 'front_print_notices_wrap_close' ) ) {
    function front_print_notices_wrap_close() {
        ?>
        </div><?php
    }
}

if ( ! function_exists( 'front_output_upsell_products' ) ) {
    function front_output_upsell_products() {
        woocommerce_upsell_display();
    }
}

if ( ! function_exists( 'front_output_related_products' ) ) {
    function front_output_related_products() {
        if ( apply_filters( 'front_enable_related_products', true ) ) {
            woocommerce_output_related_products();
        }
    }
}

if ( ! function_exists( 'front_wc_single_product_before_footer_content' ) ) {
    function front_wc_single_product_before_footer_content() {
        $static_block_id = '';

        if( is_singular( 'product' ) ) {
            $static_block_id = apply_filters( 'front_single_product_static_content_id', '' );
        }

        if( front_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {
            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<div class="single-product-before-footer-content">' . apply_filters( 'the_content', $content ) . '</div>';
        }
    }
}

if ( ! function_exists( 'front_wc_product_tabs' ) ) {
    function front_wc_product_tabs( $tabs = array() ) {
        global $product;

        $upsells = $product->get_upsell_ids();

        if ( count( $upsells ) > 0 ) {
            $tabs['upsell_products'] = array(
                'title'    => esc_html__( 'Upsell Products', 'front' ),
                'priority' => 24,
                'callback' => 'front_output_upsell_products',
            );
        }

        $tabs['related_products'] = array(
            'title'    => esc_html__( 'Related Products', 'front' ),
            'priority' => 25,
            'callback' => 'front_output_related_products',
        );

        return $tabs;
    }
}
