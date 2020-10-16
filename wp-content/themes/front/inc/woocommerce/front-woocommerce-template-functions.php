<?php
/**
 * WooCommerce Template Functions.
 *
 * @package front
 */

require_once get_template_directory() . '/inc/woocommerce/template-tags/product-item.php';
require_once get_template_directory() . '/inc/woocommerce/template-tags/single-product.php';
require_once get_template_directory() . '/inc/woocommerce/template-tags/my-account.php';

/**
 * Cart Functions
 */
if ( ! function_exists( 'front_output_cross_sell_products' ) ) {
    function front_output_cross_sell_products() {
        if ( apply_filters( 'front_enable_cross_sell_products', true ) ) {
            woocommerce_cross_sell_display( 4, 4 );
        }
    }
}

if ( ! function_exists( 'front_wc_cart_shipping_method_full_label' ) ) {
    /**
     * Changes the way Shipping method label is displayed
     *
     */
    function front_wc_cart_shipping_method_full_label( $label, $method ) {
        $label     = $method->get_label();
        $cost      = '';
        $has_cost  = 0 < $method->cost;
        $hide_cost = ! $has_cost && in_array( $method->get_method_id(), array( 'free_shipping', 'local_pickup' ), true );

        if ( $has_cost && ! $hide_cost ) {
            if ( WC()->cart->display_prices_including_tax() ) {
                $cost .= wc_price( $method->cost + $method->get_shipping_tax() );
                if ( $method->get_shipping_tax() > 0 && ! wc_prices_include_tax() ) {
                    $cost .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
                }
            } else {
                $cost .= wc_price( $method->cost );
                if ( $method->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
                    $cost .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
                }
            }

            $label = $cost . ' - ' . $label; 
        }

        return $label;
    }
}

/**
 * Mini Cart Functions
 *
 */
if ( ! function_exists( 'front_user_account_link_fragment' ) ) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     * @return array            Fragments to refresh via AJAX
     */
    function front_cart_link_fragment( $fragments ) {
        global $woocommerce;
        
        ob_start();
        front_cart_link_count();
        $fragments['span.cart-contents-count'] = ob_get_clean();

        ob_start();
        front_mini_cart_content();
        $fragments['div.u-sidebar__cart--content'] = ob_get_clean();

        ob_start();
        front_mini_cart_footer();
        $fragments['div.u-sidebar__cart--footer'] = ob_get_clean();

        return $fragments;
    }
}

if ( ! function_exists( 'front_header_cart' ) ) {
    /**
     * Display Header Cart
     *
     * @since  1.0.0
     * @uses   front_is_woocommerce_activated() check if WooCommerce is activated
     * @return void
     */
    function front_header_cart() {
        $header_enable_cart = apply_filters( 'front_header_topbar_cart_enable', true );

        $header_cart_view = apply_filters( 'front_header_topbar_cart_view', 'dropdown' );

        if ( front_is_woocommerce_activated() && $header_enable_cart == true ) : 

            if ( method_exists( WC()->cart, 'is_empty' ) && ! WC()->cart->is_empty() ) {
                $dd_menu_class = 'products-in-cart p-0';
            } else {
                $dd_menu_class = 'empty-cart text-center p-7';
            }

            ?>
            <li class="list-inline-item position-relative">
                
                <?php front_cart_link();
                
                if ( $header_cart_view == 'dropdown'  ): ?>
                    <div id="shoppingCartDropdown" class="dropdown-menu dropdown-unfold dropdown-menu-right <?php echo esc_attr( $dd_menu_class ); ?>" aria-labelledby="shoppingCartDropdownInvoker">
                        <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                    </div>
                <?php endif ?>
            </li>
        <?php endif;
    }
}

if ( ! function_exists( 'front_cart_modal_popup' ) ) {
    function front_cart_modal_popup() { 
        $header_cart_view = apply_filters( 'front_header_topbar_cart_view', 'dropdown' );

        if ( front_is_woocommerce_activated() && $header_cart_view == 'modal' && ! is_cart() && ! is_checkout() ) : ?>
            <div id="shoppingCartModal" class="js-modal-window u-modal-window" style="width: 370px;">
                <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
            </div><?php
        endif;
    }
}

if ( ! function_exists( 'front_cart_link' ) ) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return void
     * @since  1.0.0
     */
    function front_cart_link() {
        $header_cart_view = apply_filters( 'front_header_topbar_cart_view', 'dropdown' );

        if ( $header_cart_view == 'modal' ) {
            $cart_link = '#shoppingCartModal';
        } else {
            $cart_link = wc_get_cart_url();
        }

        if ( $header_cart_view == 'dropdown' ) {
            $header_cart_id = 'shoppingCartDropdownInvoker';
        } 
        else if ( $header_cart_view == 'sidebar-right' || $header_cart_view == 'sidebar-left' ) {
            $header_cart_id = 'sidebarNavToggler';
        } 
        else {
            $header_cart_id = NULL;
        }

        $atts = apply_filters( 'front_cart_link_atts', array(
            'id'    => $header_cart_id,
            'class' => 'cart-contents btn btn-xs btn-icon btn-text-secondary' . ( ( $header_cart_view == 'sidebar-right' || $header_cart_view == 'sidebar-left' ) ? ' ml-1 target-of-invoker-has-unfolds' : '' ),
            'href'  => $cart_link,
            'role'  => 'button',
        ) );

        if ( $header_cart_view == 'modal' ) {
            $atts['data-modal-target'] ="#shoppingCartModal";
            $atts['data-overlay-color'] = '#111722';
        }

        if ( $header_cart_view == 'dropdown' || $header_cart_view == 'sidebar-right' || $header_cart_view == 'sidebar-left' ) {

            if ( $header_cart_view == 'sidebar-left' ) {
                $animation_in = 'fadeInLeft';
                $animation_out = 'fadeOutLeft';
            }
            else if ( $header_cart_view == 'sidebar-right' ) {
                $animation_in = 'fadeInRight';
                $animation_out = 'fadeOutRight';
            }
            else {
                $animation_in = 'slideInUp';
                $animation_out = 'fadeOut';
            }

            $atts['title'] = $header_cart_view == 'dropdown' ? esc_html__( 'View your shopping cart', 'front' ) : NULL;
            $atts['aria-controls'] = $header_cart_view == 'dropdown' ? 'shoppingCartDropdown' : 'sidebarContent';
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
            $atts['data-unfold-event'] = $header_cart_view == 'dropdown' ? 'hover' : 'click';
            $atts['data-unfold-target'] = $header_cart_view == 'dropdown' ? '#shoppingCartDropdown' : '#sidebarContent';
            $atts['data-unfold-type'] = 'css-animation';
            $atts['data-unfold-duration'] = $header_cart_view == 'dropdown' ? '300' : '500';
            $atts['data-unfold-delay'] = $header_cart_view == 'dropdown' ? '300' : NULL;
            $atts['data-unfold-hide-on-scroll'] = $header_cart_view == 'dropdown' ? 'true' : 'false';
            $atts['data-unfold-animation-in'] = $animation_in;
            $atts['data-unfold-animation-out']  = $animation_out;
        }

        ?>
            <a<?php printf( front_get_attributes( $atts ) ); ?>>
                <span class="<?php echo esc_attr( apply_filters( 'front_shopping_cart_icon', 'fas fa-shopping-cart' ) );?> btn-icon__inner"></span>
                <?php front_cart_link_count(); ?>
            </a>
        <?php
    }
}

if ( ! function_exists( 'front_cart_link_count' ) ) {
    function front_cart_link_count() {
        ?><span class="cart-contents-count"><?php
        if ( method_exists( WC()->cart, 'get_cart_contents_count' ) && WC()->cart->get_cart_contents_count() > 0 ) {
            ?><span class="badge badge-sm badge-primary badge-pos rounded-circle"><?php echo WC()->cart->get_cart_contents_count(); ?></span><?php
        }
        ?></span><?php
    }
}

if ( ! function_exists( 'front_cart_content_sidebar' ) ) {
    function front_cart_content_sidebar() {
        $header_cart_view = apply_filters( 'front_header_topbar_cart_view', 'dropdown' );
        
        if ( front_is_woocommerce_activated() && ( $header_cart_view == 'sidebar-right' || $header_cart_view == 'sidebar-left' ) ) :

            if ( $header_cart_view == 'sidebar-left' ) {
                $animation_in = 'fadeInLeft';
                $animation_out = 'fadeOutLeft';
            }
            else {
                $animation_in = 'fadeInRight';
                $animation_out = 'fadeOutRight';
            }

            if(is_rtl()) { 
                if( $header_cart_view == 'sidebar-right' ) {
                    $sidebar_cart_additional_class  = ' left-0';
                } else {
                    $sidebar_cart_additional_class  = '';
                }
            } else {
                if( $header_cart_view == 'sidebar-right' ) {
                    $sidebar_cart_additional_class  = '';
                }
                else {
                    $sidebar_cart_additional_class  = ' left-0';
                }
            } 
            ?>
            <!-- ========== SECONDARY CONTENTS ========== -->
            <aside id="sidebarContent" class="sidebar-cart u-sidebar<?php echo esc_attr( $sidebar_cart_additional_class ); ?>" aria-labelledby="sidebarNavToggler">
                <div class="u-sidebar__scroller">
                    <div class="u-sidebar__container">
                        <div class="u-sidebar__cart-footer-offset">
                            <!-- Header -->
                            <header class="card-header bg-light py-3 px-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="h6 mb-0"><?php echo esc_html__( 'Your Shopping Cart', 'front' ); ?></h3>

                                    <button type="button" class="close"
                                        aria-controls="sidebarContent"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        data-unfold-event="click"
                                        data-unfold-hide-on-scroll="false"
                                        data-unfold-target="#sidebarContent"
                                        data-unfold-type="css-animation"
                                        data-unfold-animation-in="<?php echo esc_attr( $animation_in ); ?>"
                                        data-unfold-animation-out="<?php echo esc_attr( $animation_out ) ?>"
                                        data-unfold-duration="500">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </header>
                            <!-- End Header -->

                            <?php front_mini_cart_content(); ?>
                        </div>
                    </div>
                </div>
                <!-- End Content -->

                <?php if ( $header_cart_view == 'sidebar-right' || $header_cart_view == 'sidebar-left' ): ?>
                    <div class="u-sidebar__footer u-sidebar__footer--cart">
                <?php endif ?>
                <?php front_mini_cart_footer(); ?>
                <?php if ( $header_cart_view == 'sidebar-right' || $header_cart_view == 'sidebar-left' ): ?>
                    </div> 
                <?php endif ?>
            </aside>
        <?php endif; ?>
        <!-- ========== END SECONDARY CONTENTS ========== --><?php
    }
}

if ( ! function_exists( 'front_mini_cart_content' ) ) {
    function front_mini_cart_content() {
        ?>
        <div class="u-sidebar__cart--content <?php echo esc_attr( ! WC()->cart->is_empty() ? 'js-scrollbar ' : '' ); ?> u-sidebar__body">
            <div class="<?php echo esc_attr( WC()->cart->is_empty() ? 'd-flex justify-content-center align-items-center ' : '' ); ?>u-sidebar__content">
                <?php if ( ! WC()->cart->is_empty() ) :
                    front_mini_cart_body();
                else: ?>
                    <div class="card-body text-center p-5">
                        <span class="btn btn-icon btn-soft-primary rounded-circle">
                            <span class="fas fa-shopping-basket btn-icon__inner"></span>
                        </span>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_mini_cart_body' ) ) {
    /**
     * Displays content used in mini cart body
     *
     */
    function front_mini_cart_body() { ?>
        <div class="card-body p-5">

            <?php do_action( 'woocommerce_before_mini_cart_contents' ); ?>
        
            <?php 

            $i = 0;

            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>

            <?php 
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
                    $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                    $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'img-fluid rounded' ) ), $cart_item, $cart_item_key );
                    $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                    ?>

            <div class="media woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
                <div class="u-avatar mr-3">
                    <?php printf( $thumbnail ); ?>
                </div>
                <div class="media-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="d-block font-weight-semi-bold"><?php printf( $product_name ); ?></span>
                        <?php
                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove remove_from_cart_button close" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><span aria-hidden="true">&times;</span></a>',
                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                            esc_attr__( 'Remove this item', 'front' ),
                            esc_attr( $product_id ),
                            esc_attr( $cart_item_key ),
                            esc_attr( $_product->get_sku() )
                        ), $cart_item_key );
                        ?>
                    </div>
                    <?php if ( empty( $product_permalink ) ) : ?>
                    <span class="d-block font-size-1"><?php printf( $product_name ); ?></span>
                    <?php else: ?>
                    <a href="<?php echo esc_url( $product_permalink ); ?>" class="d-block font-size-1"><?php printf( $product_name ); ?></a>
                    <?php endif; ?>
                    <span class="d-block text-primary font-weight-semi-bold"><?php printf( $product_price ); ?></span>
                    <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
                    <small class="d-block text-muted"><?php echo sprintf( esc_html__( 'Quantity: %s', 'front' ), $cart_item['quantity'] ); ?></small>
                </div>
            </div>

            <?php if ( $i < count( WC()->cart->get_cart() ) - 1 ) : ?>

            <hr />

            <?php endif; ?>
            
            <?php endif;

            $i++;

            endforeach; ?>

            <?php do_action( 'woocommerce_mini_cart_contents' ); ?>
        
        </div>
        <!-- End Body --><?php
    }
}

if ( ! function_exists( 'front_mini_cart_footer' ) ) {
    /**
     * Front Mini Cart Footer
     *
     */
    function front_mini_cart_footer() {
        ?>
        <div class="u-sidebar__cart--footer card-footer text-center p-5">
            <div class="mb-3">
                <span class="d-block font-weight-semi-bold woocommerce-mini-cart__total total"><?php esc_html_e( 'Order Subtotal', 'front' ); ?></span>
                <span class="d-block"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
            </div>

            <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
            
            <div class="woocommerce-mini-cart__buttons buttons">
                <?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_wc_get_shipping_method_cost') ) {
    function front_wc_get_shipping_method_cost( $method ) {
        $cost      = '';
        $has_cost  = 0 < $method->cost;
        $hide_cost = ! $has_cost && in_array( $method->get_method_id(), array( 'free_shipping', 'local_pickup' ), true );

        if ( $has_cost && ! $hide_cost ) {
            if ( WC()->cart->display_prices_including_tax() ) {
                $cost = wc_price( $method->cost + $method->get_shipping_tax() );
            } else {
                $cost = wc_price( $method->cost );
                if ( $method->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
                    $cost .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
                }
            }
        }

        return apply_filters( 'front_wc_get_shipping_method_cost', $cost, $method );
    }
}

if ( ! function_exists( 'front_modify_wc_product_cat_widget_args' ) ) {
    function front_modify_wc_product_cat_widget_args( $args ) {
        require_once get_template_directory() . '/inc/woocommerce/classes/class-front-product-cat-list-walker.php';
        $args['walker'] = new Front_WC_Product_Cat_List_Walker;
        return $args;
    }
}

if ( ! function_exists( 'front_mini_cart_view_cart_button' ) ) {
    // Custom cart button
    function front_mini_cart_view_cart_button() {
        $cart_button_class = ( WC()->cart->is_empty() ? 'disabled ' : '' ) . 'btn btn-sm btn-soft-primary transition-3d-hover'
        ?>
        <div class="mb-2">
            <a class="<?php echo esc_attr( $cart_button_class ); ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php echo esc_html__( 'Review Bag and Checkout', 'front' ); ?></a>
        </div><?php
    }
}

if ( ! function_exists( 'front_mini_cart_view_shop_button' ) ) {
    // Custom Checkout button
    function front_mini_cart_view_shop_button() {
        $shop_page_link = wc_get_page_id( 'shop' ) > 0 ? get_permalink( wc_get_page_id( 'shop' ) ) : get_post_type_archive_link( 'product' );
        ?>
        <p class="small mb-0">
            <a class="link-muted" href="<?php echo esc_url( $shop_page_link ); ?>"><?php echo esc_html__( ( ! WC()->cart->is_empty() ? 'Continue ' : 'Start ' ) . 'Shopping', 'front' ); ?></a>
        </p><?php
    }
}
