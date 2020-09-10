<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit; ?>

<div class="container space-1 space-md-2">

    <?php do_action( 'woocommerce_before_cart' ); ?>

    <div class="row">
        <div class="col-lg-8 mb-7 mb-lg-0">

            <div class="d-flex justify-content-between align-items-end border-bottom pb-3 mb-7">
                <?php the_title( '<h1 class="h4 mb-0">', '</h1>' ); ?>
                <span><?php printf( esc_html__( '%s items', 'front' ), WC()->cart->get_cart_contents_count() ); ?></span>
            </div>

            <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            
                <?php do_action( 'woocommerce_before_cart_table' ); ?>

                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents d-block border-0">
                    <thead class="d-none">
                        <tr>
                            <th class="product-remove">&nbsp;</th>
                            <th class="product-thumbnail">&nbsp;</th>
                            <th class="product-name"><?php esc_html_e( 'Product', 'front' ); ?></th>
                            <th class="product-price"><?php esc_html_e( 'Price', 'front' ); ?></th>
                            <th class="product-quantity"><?php esc_html_e( 'Quantity', 'front' ); ?></th>
                            <th class="product-subtotal"><?php esc_html_e( 'Total', 'front' ); ?></th>
                        </tr>
                    </thead>
                    <tbody class="d-block">
                        
                        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                        <?php
                        $cart_count = count( WC()->cart->get_cart() );
                        $cart_row   = 0;

                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $cart_row++;
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                ?>
                                <tr class="d-block border-0 woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                    <td class="d-block border-0 p-0">

                                        <div class="<?php if ( $cart_count == $cart_row ) : ?>mb-10<?php else: ?>border-bottom pb-5 mb-5<?php endif; ?>">
                                            <div class="row">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                        
                                                    <div class="media">
                                                        <div class="max-width-15 w-100 mr-3">
                                                            <?php
                                                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                                                if ( ! $product_permalink ) {
                                                                    echo wp_kses_post( $thumbnail ); // PHPCS: XSS ok.
                                                                } else {
                                                                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                                                }
                                                                ?>
                                                        </div>
                                                        <div class="media-body">
                                                            <?php
                                                            if ( ! $product_permalink ) {
                                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<h2 class="h6">%s</h6>', esc_html( $_product->get_name() ) ), $cart_item, $cart_item_key ) . '&nbsp;' );
                                                            } else {
                                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<h2 class="h6"><a href="%s">%s</a></h2>', esc_url( $product_permalink ), esc_html( $_product->get_name() ) ), $cart_item, $cart_item_key ) );
                                                            }

                                                            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                                            // Meta data.
                                                            echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                                            // Backorder notification.
                                                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'front' ) . '</p>', $product_id ) );
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-5 col-md-3 offset-md-1">
                                                    
                                                    <?php
                                                    if ( $_product->is_sold_individually() ) {
                                                        $max_value = 1;
                                                    } else {
                                                        $max_value = $_product->get_max_purchase_quantity();
                                                    }

                                                    $product_quantity = woocommerce_quantity_input( array(
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'max_value'    => $max_value,
                                                        'min_value'    => '0',
                                                        'product_name' => $_product->get_name(),
                                                        'input_field'  => 'select',
                                                        'classes'      => array( 'custom-select', 'custom-select-sm', 'w-auto', 'mb-3' ),
                                                    ), $_product, false );

                                                    echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                                    ?>

                                                    <?php
                                                        // @codingStandardsIgnoreLine
                                                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                                            '<a href="%s" class="d-block text-secondary font-size-1 mb-1 remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="far fa-trash-alt mr-1"></span><span>%s</span></a>',
                                                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                            esc_html__( 'Remove this item', 'front' ),
                                                            esc_attr( $product_id ),
                                                            esc_attr( $_product->get_sku() ),
                                                            esc_html__( 'Remove', 'front' )
                                                        ), $cart_item_key );
                                                    ?>

                                                </div>
                                                <div class="col-6 col-md-2 text-md-right">
                                                    <span class="font-weight-medium">
                                                    <?php
                                                        echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                                    ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        <?php do_action( 'woocommerce_cart_contents' ); ?>

                        <tr class="d-block">
                            <td colspan="6" class="actions d-block border-0 d-flex justify-content-end p-0">

                                <button type="submit" class="button btn btn-soft-primary" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'front' ); ?>"><?php esc_html_e( 'Update cart', 'front' ); ?></button>

                                <?php do_action( 'woocommerce_cart_actions' ); ?>

                                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                            </td>
                        </tr>

                        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                    </tbody>
                </table>

                <?php do_action( 'woocommerce_after_cart_table' ); ?>

            </form>

        </div>

        <div class="col-lg-4">
            <div class="pl-lg-4">
                <div class="border shadow-soft rounded p-5 mb-4">

                    <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

                    <div class="cart-collaterals">
                        <?php
                            /**
                             * Cart collaterals hook.
                             *
                             * @hooked woocommerce_cart_totals - 10
                             */
                            do_action( 'woocommerce_cart_collaterals' );
                        ?>
                    </div>
                </div>

                <?php if ( wc_coupons_enabled() ) { ?>
                    <div id="shopCartAccordion" class="accordion rounded shadow-soft mb-4">
                        <div class="card rounded">
                            <div id="shopCartHeadingOne" class="card-header card-collapse">
                                <h3 class="mb-0">
                                    <button type="button" class="btn btn-link btn-block card-btn font-weight-medium collapsed" data-toggle="collapse" data-target="#shopCartOne" aria-expanded="false" aria-controls="shopCartOne">
                                        <?php esc_html_e( 'Promo Code?', 'front' ); ?>
                                    </button>
                                </h3>
                            </div>
                            <div id="shopCartOne" class="collapse" aria-labelledby="shopCartHeadingOne" data-parent="#shopCartAccordion">
                                <form class="p-5" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                                    <div class="input-group input-group-pill mb-3 coupon">
                                        <label for="coupon_code" class="sr-only"><?php esc_html_e( 'Promo Code?', 'front' ); ?></label>
                                        <input type="text" name="coupon_code" class="input-text form-control" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Promo code', 'front' ); ?>" aria-label="<?php esc_attr_e( 'Promo code', 'front' ); ?>" />
                                        <div class="input-group-append">
                                            <button type="submit" class="button btn btn-block btn-primary btn-pill" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'front' ); ?>"><?php esc_attr_e( 'Apply', 'front' ); ?></button>
                                        </div>
                                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                    </div>
                                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div><!-- /.row -->

    <?php do_action( 'woocommerce_after_cart' ); ?>

</div>