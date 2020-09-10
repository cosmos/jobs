<?php
/**
 * WooCommerce Template Function Overrides
 *
 * @package woocommerce
 */

/**
 * Insert the opening anchor tag for products in the loop.
 */
function woocommerce_template_loop_product_link_open() {
    global $product;

    $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

    echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block card card-text-dark border-0 text-center transition-3d-hover">';
}

/**
 * Get the product thumbnail, or the placeholder if not set.
 *
 * @param string $size (default: 'woocommerce_thumbnail').
 * @param int    $deprecated1 Deprecated since WooCommerce 2.0 (default: 0).
 * @param int    $deprecated2 Deprecated since WooCommerce 2.0 (default: 0).
 * @return string
 */
function woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0 ) {
    global $product;

    $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

    return $product ? $product->get_image( $image_size, array( 'class' => 'attachment-woocommerce_thumbnail' ) ) : '';
}

if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {

    /**
     * Show the product title in the product loop. By default this is an H2.
     */
    function woocommerce_template_loop_product_title() {
        global $post, $product;
        $sale_badge = '';
        $sold_out_badge = '';

        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
        if ( $product->is_on_sale() ) : 
            $sale_badge = apply_filters( 'woocommerce_sale_flash', '<span class="sale-badge badge badge-success badge-pill ml-1">' . esc_html__( 'Sale!', 'front' ) . '</span>', $post, $product ); 
        endif;

        if ( !$product->is_in_stock() ) :
            $sold_out_badge = '<span class="sold-out-badge badge badge-danger badge-pill ml-1">' . esc_html__('Sold Out', 'front' ) . '</span>';
        endif;
        echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">'. get_the_title() . '</a>' . wp_kses_post( $sale_badge ) . wp_kses_post( $sold_out_badge ) . '</h3>';
             // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

if ( ! function_exists( 'woocommerce_product_loop_start' ) ) {

    /**
     * Output the start of a product loop. By default this is a UL.
     *
     * @param bool $echo Should echo?.
     * @return string
     */
    function woocommerce_product_loop_start( $echo = true , $class = '') {
        ob_start();

        wc_set_loop_prop( 'loop', 0 );

        wc_get_template( 'loop/loop-start.php', array( 'class' => $class ) );

        $loop_start = apply_filters( 'woocommerce_product_loop_start', ob_get_clean() );

        if ( $echo ) {
            echo wp_kses_post( $loop_start ); // WPCS: XSS ok.
        } else {
            return $loop_start;
        }
    }
}

/**
 * Get the product price for the loop.
 */
function woocommerce_template_loop_price() {
    global $product;
    
    if ( $price_html = $product->get_price_html() ) : ?>
    <div class="d-block price"><?php echo wp_kses_post( $price_html ); ?></div>
    <?php endif;
}


/**
 * Output the view cart button.
 */
function woocommerce_widget_shopping_cart_button_view_cart() {
    echo '<div class="mb-2"><a href="' . esc_url( wc_get_cart_url() ) . '" class="btn btn-sm btn-soft-primary transition-3d-hover button wc-forward">' . esc_html__( 'View cart', 'front' ) . '</a></div>';
}

/**
 * Output the proceed to checkout button.
 */
function woocommerce_widget_shopping_cart_proceed_to_checkout() {
    echo '<p class="small mb-0"><a href="' . esc_url( wc_get_checkout_url() ) . '" class="link-muted button checkout wc-forward">' . esc_html__( 'Checkout', 'front' ) . '</a></p>';
}

if ( ! function_exists( 'woocommerce_template_loop_category_title' ) ) {

    /**
     * Show the subcategory title in the product loop.
     *
     * @param object $category Category object.
     */
    function woocommerce_template_loop_category_title( $category ) {
        ?>
        <h2 class="woocommerce-loop-category__title h5 mb-1">
            <?php
            echo esc_html( $category->name );
            ?>
        </h2>
        <?php
    }
}

if ( ! function_exists( 'woocommerce_output_product_categories' ) ) {
    /**
     * Display product sub categories as thumbnails.
     *
     * This is a replacement for woocommerce_product_subcategories which also does some logic
     * based on the loop. This function however just outputs when called.
     *
     * @since 3.3.1
     * @param array $args Arguments.
     * @return boolean
     */
    function woocommerce_output_product_categories( $args = array() ) {
        $args = wp_parse_args(
            $args,
            array(
                'before'    => apply_filters( 'woocommerce_before_output_product_categories', '' ),
                'after'     => apply_filters( 'woocommerce_after_output_product_categories', '' ),
                'parent_id' => 0,
            )
        );

        $product_categories = woocommerce_get_product_subcategories( $args['parent_id'] );

        if ( ! $product_categories ) {
            return false;
        }

        echo wp_kses_post( $args['before'] ); // WPCS: XSS ok.

       $i = 0;
        foreach ( $product_categories as $category ) {
            $i++;
            wc_get_template(
                'content-product_cat.php',
                array(
                    'category' => $category,
                )
            );

            if ( $i == 2 ){
                front_archive_middle_jumbotron();
            } 
        }

        echo wp_kses_post( $args['after'] ); // WPCS: XSS ok.

        return true;
    }
}



/**
 * Outputs a checkout/address form field.
 *
 * @param string $key Key.
 * @param mixed  $args Arguments.
 * @param string $value (default: null).
 * @return string
 */
function woocommerce_form_field( $key, $args, $value = null ) {
    $defaults = array(
        'type'              => 'text',
        'label'             => '',
        'description'       => '',
        'placeholder'       => '',
        'maxlength'         => false,
        'required'          => false,
        'autocomplete'      => false,
        'id'                => $key,
        'class'             => array(),
        'label_class'       => array(),
        'input_class'       => array(),
        'return'            => false,
        'options'           => array(),
        'custom_attributes' => array(),
        'validate'          => array(),
        'default'           => '',
        'autofocus'         => '',
        'priority'          => '',
        'before'            => '',
        'after'             => '',
    );

    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

    if ( $args['required'] ) {
        $args['class'][] = 'validate-required';
        $required        = '&nbsp;<span class="required text-danger" title="' . esc_attr__( 'required', 'front' ) . '">*</span>';
    } else {
        $required = '';
    }

    if ( is_string( $args['label_class'] ) ) {
        $args['label_class'] = array( $args['label_class'] );
    }

    if ( is_null( $value ) ) {
        $value = $args['default'];
    }

    // Custom attribute handling.
    $custom_attributes         = array();
    $args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

    if ( $args['maxlength'] ) {
        $args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
    }

    if ( ! empty( $args['autocomplete'] ) ) {
        $args['custom_attributes']['autocomplete'] = $args['autocomplete'];
    }

    if ( true === $args['autofocus'] ) {
        $args['custom_attributes']['autofocus'] = 'autofocus';
    }

    if ( $args['description'] ) {
        $args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
    }

    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
        foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
        }
    }

    if ( ! empty( $args['validate'] ) ) {
        foreach ( $args['validate'] as $validate ) {
            $args['class'][] = 'validate-' . $validate;
        }
    }

    $field           = '';
    $label_id        = $args['id'];
    $sort            = $args['priority'] ? $args['priority'] : '';
    $field_container = '<div class="%1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%4$s%3$s%5$s</div>';
    $before          = $args['before'] ? $args['before'] : '';
    $after           = $args['after'] ? $args['after'] : '';

    switch ( $args['type'] ) {
        case 'country':
            $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

            if ( 1 === count( $countries ) ) {

                $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

                $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" readonly="readonly" />';

            } else {

                $field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '><option value="">' . esc_html__( 'Select a country&hellip;', 'front' ) . '</option>';

                foreach ( $countries as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
                }

                $field .= '</select>';

                $field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'front' ) . '">' . esc_html__( 'Update country', 'front' ) . '</button></noscript>';

            }

            break;
        case 'state':
            /* Get country this state field is representing */
            $for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
            $states      = WC()->countries->get_states( $for_country );

            if ( is_array( $states ) && empty( $states ) ) {

                $field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';

                $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" readonly="readonly" />';

            } elseif ( ! is_null( $for_country ) && is_array( $states ) ) {

                $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ? $args['placeholder'] : esc_html__( 'Select an option&hellip;', 'front' ) ) . '">
                    <option value="">' . esc_html__( 'Select an option&hellip;', 'front' ) . '</option>';

                foreach ( $states as $ckey => $cvalue ) {
                    $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
                }

                $field .= '</select>';

            } else {

                $field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

            }

            break;
        case 'textarea':
            $field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>';

            break;
        case 'checkbox':
            $field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
                    <input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

            break;
        case 'text':
        case 'password':
        case 'datetime':
        case 'datetime-local':
        case 'date':
        case 'month':
        case 'time':
        case 'week':
        case 'number':
        case 'email':
        case 'url':
        case 'tel':
            $field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

            break;
        case 'select':
            $field   = '';
            $options = '';

            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    if ( '' === $option_key ) {
                        // If we have a blank option, select2 needs a placeholder.
                        if ( empty( $args['placeholder'] ) ) {
                            $args['placeholder'] = $option_text ? $option_text : esc_html__( 'Choose an option', 'front' );
                        }
                        $custom_attributes[] = 'data-allow_clear="true"';
                    }
                    $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
                }

                $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
                        ' . $options . '
                    </select>';
            }

            break;
        case 'radio':
            $label_id .= '_' . current( array_keys( $args['options'] ) );

            if ( ! empty( $args['options'] ) ) {
                foreach ( $args['options'] as $option_key => $option_text ) {
                    $field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
                    $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label>';
                }
            }

            break;
    }

    if ( ! empty( $field ) ) {
        $field_html = '';

        if ( $args['label'] && 'checkbox' !== $args['type'] ) {
            $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>';
        }

        $field_html .= $field;

        if ( $args['description'] ) {
            $field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
        }

        $container_class = esc_attr( implode( ' ', $args['class'] ) );
        $container_id    = esc_attr( $args['id'] ) . '_field';
        $field           = sprintf( $field_container, $container_class, $container_id, $field_html, $before, $after );
    }

    /**
     * Filter by type.
     */
    $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

    /**
     * General filter on form fields.
     *
     * @since 3.4.0
     */
    $field = apply_filters( 'woocommerce_form_field', $field, $key, $args, $value );

    if ( $args['return'] ) {
        return $field;
    } else {
        echo apply_filters( 'the_content', $field ); // WPCS: XSS ok.
    }
}