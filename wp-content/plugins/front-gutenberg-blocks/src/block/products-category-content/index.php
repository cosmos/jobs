<?php
/**
 * Server-side rendering of the `fgb/products-category-content` block.
 *
 * @package FrontGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renders the `fgb/products-category-content` block on server.
 *
 * @since 1.7
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */


if ( ! function_exists( 'frontgb_register_products_category_block' ) ) {
    /**
     * Registers the `fgb/products-category-content` block on server.
     */
    function frontgb_register_products_category_block() {
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type(
            'fgb/products-category-content',
            array(
                'attributes' => array (
                    'className' => array(
                        'type' => 'string',
                    ),
                    'categories' => array (
                        'type' => 'array',
                        'items' => array(
                            'type' => 'number'
                        ),
                        'default' =>[],
                        
                    ),
                    'category_args' => array(
                        'type'      => 'object',
                        'default'   => array(
                            'number'    => 3,
                            'orderby'   => 'id',
                            'order'     => 'DESC',
                            'hide_empty'=> false,
                        ),
                    ),
                    'design'=> array(
                        'type'      => 'string',
                        'default' => 'style-1',
                    ),
                ),
                'render_callback' => 'frontgb_products_category_block',
            )
        );
    }
    add_action( 'init', 'frontgb_register_products_category_block' );
}

if ( ! function_exists( 'frontgb_products_category_block' ) ) {
    function frontgb_products_category_block( $attributes ) {

        if ( ! class_exists( 'Front' ) ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'Front is not activated', FRONTGB_I18N ) . '</p>';
        } elseif ( function_exists( 'front_is_woocommerce_activated' ) && ! front_is_woocommerce_activated() ) {
            return '<p class="text-danger text-center font-size-2">' . __( 'WooCommerce is not activated', FRONTGB_I18N ) . '</p>';
        }

        $defaults = apply_filters( 'frontgb_products_category_block_args', array(
            'design'                => 'style-1',
            'category_args'         => array(
                'orderby'           => 'name',
                'order'             => 'ASC',
                'number'            => 3,
                'hide_empty'        => false,
                'include'           => '',
            ),
        ));
        $attributes = wp_parse_args( $attributes, $defaults );
        extract( $attributes );
        $category_args = wp_parse_args( $attributes['category_args'], $defaults['category_args'] );
        $category_args['include'] = $attributes['categories'];
        $categories = get_terms( 'product_cat', $category_args );

        ob_start(); ?>
            <div class="row">
           
               <?php foreach( $categories as $category ) :
                    $shortcode_atts['category']     = $category->slug;
                    $shortcode_atts['cat_operator'] = 'IN';
                    $shortcode_atts['visibility']   = 'visible';
                    $shortcode_atts['limit']        = 2;
                    $products                       = wc_get_products( $shortcode_atts ); 
                    $thumbnail_id                   = get_term_meta( $category->term_id, 'thumbnail_id', true ); ?>

                    <?php if ( !empty ( $design == 'style-1' ) ) { ?>
                       <div class="col-md-4 mb-5 mb-md-0">
                    <?php } else { ?>
                        <div class="col-6 col-lg-3 mb-5 mb-lg-0">
                    <?php } ?>
                        <div class="card d-block">
                            <div class="card-body d-flex align-items-center p-0">
                                <?php if ( $thumbnail_id ) {
                                    $image        = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
                                    $image        = $image[0];
                                } else {
                                    $image        = wc_placeholder_img_src();
                                } ?>
                                <?php if ( !empty ( $products ) && $design == 'style-1' ) : ?>
                                    <div class="w-65 border-right">
                                <?php elseif ( $design == 'style-1' ) : ?>
                                    <div class="w-65 mx-auto">
                                <?php endif; ?>
                                   <?php echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '"><img class="img-fluid" src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" /></a>'; ?>

                                  
                                <?php if ( !empty ( $products ) && $design == 'style-1' ) : ?>
                                    </div>
                                <?php elseif ( $design == 'style-1' ) : ?>
                                    </div>
                                <?php endif; ?>

                               <?php 
                               if ( !empty ( $products ) && $design == 'style-1' )  { ?>
                                    
                                <div class="w-35">
                                    <?php for( $i = 1; $i <= count( $products ); $i++) { ?>
                                        <?php if( $i <count( $products ) ): ?>
                                            <div class="border-bottom">
                                                <?php endif; ?>
                                                    <a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>">
                                                        <?php echo $products[$i-1]->get_image(); ?>
                                                    </a>
                                                <?php if( $i <count( $products ) ): ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            </div>

                            <div class="card-footer text-center py-4">
                                <h3 class="h5 mb-1"><?php echo esc_html( $category->name );?></h3>
                                <span class="d-block mb-3">
                                    <?php if ( !empty( $category->description ) ): ?>
                                        <span class= "category-description text-muted font-size-1"><?php echo esc_html( $category->description ); ?></span>
                                    <?php endif; ?>
                                </span>
                                 <a class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover px-5" href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>">
                                    <?php if ( $design == 'style-1' )  { 
                                        echo apply_filters( 'front_template_loop_category_button_text', wp_kses_post( sprintf( '%s %s', esc_html__( 'View All', FRONTGB_I18N ), esc_html( $category->name ) ) ) ); 
                                        } else {
                                            echo apply_filters( 'front_template_loop_category_button_text', wp_kses_post( sprintf( '%s', esc_html__( 'View All', FRONTGB_I18N ) ) ) ); 
                                        }
                                    ?>
                                </a>
                            </div>
                        </div>
                    </div>
               
               <?php endforeach; ?>
            </div>
       
         <?php
        return ob_get_clean();
    
    }
}



