<?php
/**
 * Server-side rendering of the `fgb/shop-hero-slider` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/shop-hero-slider` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */


if ( ! function_exists( 'frontgb_register_shop_hero_block' ) ) {
    /**
     * Registers the `fgb/shop-hero-slider` block on server.
     */
    function frontgb_register_shop_hero_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/shop-hero-slider',
            array(
                'attributes' => array (
                    'className' => array(
                        'type' => 'string',
                    ),
                    'posts' => array (
                        'type' => 'array',
                        'items' => array(
                            'type' => 'object'
                        ),
                        'default' =>[],
                    ),
                    'shortcode_tag' => array (
                        'type' => 'string',
                        'default' => 'recent_products',
                    ),
                    'shortcode_atts'=> array (
                        'type'      => 'object',
                        'default'   => array(
                            'limit'         => 3,
                            'columns'       => 1,
                            'orderby'       => 'date',
                            'order'         => 'DESC',
                        ),
                    ),
                ),
                'render_callback' => 'frontgb_hero_slider_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_shop_hero_block' );
}

if ( ! function_exists( 'frontgb_hero_slider_block' ) ) {
    function frontgb_hero_slider_block( $args ) {

        if ( ! class_exists( 'Front' ) ) {
          return '<p class="text-danger text-center font-size-2">' . __( 'Front is not activated', FRONTGB_I18N ) . '</p>';
        } elseif ( function_exists( 'front_is_woocommerce_activated' ) && ! front_is_woocommerce_activated() ) {
          return '<p class="text-danger text-center font-size-2">' . __( 'WooCommerce is not activated', FRONTGB_I18N ) . '</p>';
        }

        $defaults = apply_filters( 'frontgb_hero_slider_block_default_args', array(
            'shortcode_tag'     => 'recent_products',
            'shortcode_atts'        => array(
                'columns'               => '1',
                'limit'                 => '3',
            ),
        ) );


        $args = wp_parse_args( $args, $defaults );

        extract( $args );

        $default_atts       = array( 'columns' => 1 );
        $shortcode_atts     = wp_parse_args( $default_atts, $shortcode_atts );
        $shortcode_tag      = $shortcode_tag  ? $shortcode_tag : 'recent_products';
        $shortcode_products = new Front_Shortcode_Products( $shortcode_atts, $shortcode_tag );
        $products           = $shortcode_products->get_products();
        $price_short_desc   =  '';

        ob_start();
         
           if ( $products && $products->ids ) : 
            ?><div class="shop-hero-slider"><div class="position-relative">
                <div id="heroSlider" class="js-slick-carousel u-slick u-slick--equal-height bg-light"
                   data-fade="true"
                   data-infinite="true"
                   data-autoplay-speed="7000"
                   data-arrows-classes="d-none d-lg-inline-block u-slick__arrow u-slick__arrow--flat-white u-slick__arrow-centered--y shadow-soft rounded-circle"
                   data-arrow-left-classes="fas fa-arrow-left u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-5"
                   data-arrow-right-classes="fas fa-arrow-right u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-5"
                   data-nav-for="#heroSliderNav">
                   <?php foreach ( $products->ids as $product_id ) : 
                    $GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
                    setup_postdata( $GLOBALS['post'] );
                    global $product;?>
                    
                    <div class="js-slide col-auto">
                      <div class="container space-top-2 space-bottom-3">
                        <div class="row align-items-lg-center">
                            <div class="col-lg-5 order-lg-2 mb-7 mb-lg-0">
                                <div class="mb-6">
                                    <h2 class="display-4 font-size-md-down-5 font-weight-semi-bold mb-4"><a href="<?php echo get_permalink($product_id); ?>"><?php echo $product->get_name();?></a></h2>

                                    <?php if ( $price_short_desc = $product->get_short_description()) : ?>
                                        <p><?php echo $price_short_desc; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex align-items-center">

                                    <?php echo apply_filters( 'front_loop_add_to_cart_link',
                                    sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                                        esc_url( $product->add_to_cart_url() ),
                                        1,
                                        implode(
                                          ' ',
                                          array_filter(
                                            array(
                                              'btn',
                                              'btn-primary',
                                              'btn-pill',
                                              'transition-3d-hover',
                                              'px-5',
                                              'mr-2',
                                              'button',
                                              'product_type_' . $product->get_type(),
                                              $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                              $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                                            )
                                          )
                                        ),
                                        wc_implode_html_attributes( array(
                                          'data-product_id'  => $product->get_id(),
                                          'data-product_sku' => $product->get_sku(),
                                          'aria-label'       => wp_strip_all_tags( $product->add_to_cart_description() ),
                                          'rel'              => 'nofollow',
                                        ) ),
                                        wp_kses_post( $product->get_price_html()  ? $product->get_price_html() . ' - ' . $product->add_to_cart_text() : $product->add_to_cart_text() )
                                    ), $product ); ?>

                                    <?php if ( front_is_yith_wcwl_activated() ) {
                                        echo do_shortcode( "[yith_wcwl_add_to_wishlist]" ); 
                                    } ?>
                            </div>


                           </div>

                            <div class="col-lg-6 order-lg-1">
                                <div class="w-85 mx-auto">

                                  <?php
                                    $full_src = get_the_post_thumbnail_url( $product_id, 'full' );
                                    echo ( $product->get_image( 'woocommerce_single', array( 'data-large_image' => $full_src ), true ) );
                                ?>

                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="position-absolute bottom-0 w-100">
                    <div class="container space-bottom-1">
                        <div id="heroSliderNav" class="js-slick-carousel u-slick u-slick--transform-off max-width-27 mx-auto"
                           data-slides-show="3"
                           data-autoplay-speed="7000"
                           data-infinite="true"
                           data-is-thumbs="true"
                           data-is-thumbs-progress="true"
                           data-thumbs-progress-options='{
                             "color": "<?php echo apply_filters('front_custom_primary_color', '#377dff');?>",
                             "width": 8
                           }'
                           data-thumbs-progress-container=".js-slick-thumb-progress"
                           data-nav-for="#heroSlider">
                           <?php foreach ( $products->ids as $product_id ) : 
                            $GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
                            setup_postdata( $GLOBALS['post'] );
                            global $product;?>
                            <div class="js-slide p-1">
                              <a class="js-slick-thumb-progress position-relative d-block u-avatar border rounded-circle p-1" href="javascript:;">
                                <?php
                                    $thumbnail_src = get_the_post_thumbnail_url( $product_id, 'medium' );
                                    echo ( $product->get_image( 'woocommerce_thumbnail', array( 'data-large_image' => $thumbnail_src ), true ) );
                                ?>
                              </a>
                            </div>
                         <?php endforeach; ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        
            <?php endif;
       return ob_get_clean();
    
    }
}


