<?php
/**
 * Server-side rendering of the `products-carousel-block` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `products-carousel-block` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */


if ( ! function_exists( 'frontgb_register_products_carousel_block' ) ) {
    /**
     * Registers the `products-carousel-block` block on server.
     */
    function frontgb_register_products_carousel_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/products-carousel-block',
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
                    'enableCarousel' => array (
                        'type' => 'boolean',
                        'default' => false
                    ),
                    'shortcode_tag' => array (
                        'type' => 'string',
                        'default' => 'recent_products',
                    ),
                    'carousel_args' => array(
                        'type'      => 'object',
                        'default'   => array(
                            'slidesToShow'  => 4,
                            'slidesToScroll'=> 1,
                            'dots'          => false,
                            'arrows'        => false,
                            'autoplay'      => false,
                            'infinite'      => false,
                        ),
                    ),
                    'shortcode_atts'=> array (
                        'type'      => 'object',
                        'default'   => array(
                            'limit'         => 4,
                            'columns'       => 4,
                            'orderby'       => 'date',
                            'order'         => 'DESC',
                        ),
                    ),
                ),
                'render_callback' => 'frontgb_products_carousel_blocks',
            )
        );
    }
    add_action( 'init', 'frontgb_register_products_carousel_block' );
}

if ( ! function_exists( 'frontgb_products_carousel_blocks' ) ) {
    function frontgb_products_carousel_blocks( $args ) {

        if ( ! class_exists( 'Front' ) ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'Front is not activated', FRONTGB_I18N ) . '</p>';
        } elseif ( function_exists( 'front_is_woocommerce_activated' ) && ! front_is_woocommerce_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'WooCommerce is not activated', FRONTGB_I18N ) . '</p>';
        }

        $defaults = apply_filters( 'frontgb_products_blocks_default_args', array(
            'enableCarousel'   => false, 
            'shortcode_tag'     => 'recent_products',
            'shortcode_atts'        => array(
                'columns'               => '4',
                'limit'                 => '4',
            ),
            'carousel_args'     => array(
                'infinite'          => false,
                'slidesToShow'      => 4,
                'slidesToScroll'    => 4,
                'dots'              => false,
                'arrows'            => false,

            ),
        ) );


        $args = wp_parse_args( $args, $defaults );

        extract( $args );
        //$shortcode_atts['columns'] = $carousel_args['slidesToShow'];

        $carousel_args['responsive'] = apply_filters( 'front_products_carousel_responsive_args', array(
                array(
                    'breakpoint'    => 992,
                    'settings'      => array(
                        'slidesToShow'      => 3,
                        'slidesToScroll'    => 1
                    )
                ),
                array(
                    'breakpoint'    => 720,
                    'settings'      => array(
                        'slidesToShow'      => 2,
                        'slidesToScroll'    => 1
                    )
                ),
                array(
                    'breakpoint'    => 480,
                    'settings'      => array(
                        'slidesToShow'      => 1,
                        'slidesToScroll'    => 1
                    )
                ),
            ) );
        
        ob_start(); ?>
        
        <?php if ( $args['enableCarousel'] == true) { ?>
            <div class="front-slick-carousel" data-ride="front-slick-carousel" data-wrap=".products" data-slick="<?php echo htmlspecialchars( json_encode( $carousel_args ), ENT_QUOTES, 'UTF-8' ); ?>">
        <?php } else { ?>
            <div class="row mx-n2 mx-sm-n3 mb-4">
       <?php } ?>
            <div class="products-block">
                 <?php echo front_do_shortcode( 'products' , $shortcode_atts ); ?>
             </div>
            </div>
         <?php
        return ob_get_clean();
    
    }
}

