<?php
/**
 * Template tags used in product archive page
 */

if ( ! function_exists( 'front_remove_loop_start_subcatgories' ) ) {
    function front_remove_loop_start_subcatgories( $loop_html = '' ) {
        ob_start();

        wc_set_loop_prop( 'loop', 0 );

        wc_get_template( 'loop/loop-start.php' );

        return ob_get_clean();
    }
}

if ( ! function_exists( 'front_product_loop_start' ) ) {
    function front_product_loop_start( $loop_start_html ) {
        $loop_start_html = '<ul class="list-unstyled mb-2 products columns-' . esc_attr( wc_get_loop_prop( 'columns' ) ) . '">';
        return $loop_start_html;
    }
}

if ( ! function_exists( 'front_product_post_class' ) ) {
    function front_product_post_class( $classes, $class = '', $post_id = 0 ) {
        if ( ! $post_id || is_product() || ! in_array( get_post_type( $post_id ), array( 'product', 'product_variation' ), true ) ) {
            return $classes;
        }

        $columns = wc_get_loop_prop( 'columns' );

        switch( $columns ) {
            case 2:
                $classes[] = 'col-lg-2';
            case 3:
                $classes[] = 'col-lg-4';
            break;
            case 4:
                $classes[] = 'col-lg-3';
            break;
        }

        $classes[] = 'col-6';
        $classes[] = 'px-2';
        $classes[] = 'mb-3';

        return $classes;
    }
}


if ( ! function_exists( 'front_product_loop_title_classes' ) ) {
    function front_product_loop_title_classes( $product_loop_title_class ) {
        $product_loop_title_class .= ' font-size-1 font-weight-semi-bold';
        return $product_loop_title_class;
    }
}

if ( ! function_exists( 'front_loop_add_to_cart_args' ) ) {
    function front_loop_add_to_cart_args( $args, $product ) {
        $args['class'] .= ' btn btn-sm btn-outline-primary btn-sm-wide btn-pill transition-3d-hover';
        $args['attributes']['role'] = 'button';
        return $args;
    }
}

if ( ! function_exists( 'front_product_loop_wrap_open' ) ) {
    function front_product_loop_wrap_open() {
        ?><div class="card text-center h-100"><?php
    }
}

if ( ! function_exists( 'front_product_loop_wrap_close' ) ) {
    function front_product_loop_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'front_product_loop_thumbnail_wrap_open' ) ) {
    function front_product_loop_thumbnail_wrap_open() {
        ?><div class="position-relative"><?php
    }
}

if ( ! function_exists( 'front_product_loop_thumbnail_wrap_close' ) ) {
    function front_product_loop_thumbnail_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'front_product_loop_card_body_open' ) ) {
    function front_product_loop_card_body_open() {
        ?><div class="card-body pt-4 px-4 pb-0"><div class="mb-2"><?php
    }
}

if ( ! function_exists( 'front_product_loop_card_body_close' ) ) {
    function front_product_loop_card_body_close() {
        ?></div></div><?php
    }
}

if ( ! function_exists( 'front_product_loop_card_footer_open' ) ) {
    function front_product_loop_card_footer_open() {
        ?><div class="card-footer border-0 pt-0 pb-4 px-4"><?php
    }
}

if ( ! function_exists( 'front_product_loop_card_footer_close' ) ) {
    function front_product_loop_card_footer_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'front_product_loop_sale_wrap_open' ) ) {
    function front_product_loop_sale_wrap_open() {
        global $product;
        if ( $product->is_on_sale() ) : ?>
            <div class="position-absolute top-0 left-0 pt-3 pl-3">
        <?php endif;
    }
}

if ( ! function_exists( 'front_product_loop_sale_wrap_close' ) ) {
    function front_product_loop_sale_wrap_close() {
        global $product;
        if ( $product->is_on_sale() ) : ?>
            </div>
        <?php endif;
    }
}

if ( ! function_exists( 'front_product_loop_sold_out' ) ) {
    function front_product_loop_sold_out() {
     global $product;

         if ( !$product->is_in_stock() ) {
            ?>
            <div class="position-absolute top-0 left-0 pt-3 pl-3">
                <span class="badge badge-danger badge-pill"><?php echo esc_html__('Sold Out', 'front' ); ?></span>
            </div><?php
         }
     }
 }

if ( ! function_exists( 'front_wc_format_sale_price' ) ) {
    function front_wc_format_sale_price( $price, $regular_price, $sale_price ) {
        $price = '<span class="font-weight-medium">' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</span><span class="text-secondary ml-1"><del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del></span>';
        return $price;
    }
}

if ( ! function_exists( 'front_wc_get_price_html' ) ) {
    function front_wc_get_price_html( $price, $product ) {
        if ( '' !== $product->get_price() && ! $product->is_on_sale() ) {
            $price = '<span class="font-weight-medium">' . $price . '</span>';
        }

        return $price;
    }
}

if ( ! function_exists( 'front_shop_control_bar' ) ) {
    function front_shop_control_bar() {

        if ( ! woocommerce_products_will_display()) {
            return;
        }

        ?><div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <?php woocommerce_result_count(); ?>
            </div>

            <div class="col-lg-6 align-self-lg-end text-lg-right">
                <ul class="list-inline mb-0 shop-view-switcher nav d-block">
                    <li class="list-inline-item">
                        <?php woocommerce_catalog_ordering(); ?>
                    </li>
                    <?php if( function_exists( 'front_woocommerce_catalog_ordering' ) ) : ?>
                    <li class="list-inline-item">
                        <?php front_woocommerce_catalog_ordering(); ?>
                    </li>
                    <?php endif; ?>

                    <?php front_shop_view_switcher(); ?>
                </ul>
            </div>
            <?php
            /**
             * @hooked front_shop_view_switcher - 10
             * @hooked woocommerce_sorting - 20
             */
            do_action( 'front_shop_control_bar' );
            ?>
        </div><?php
    }
}


if ( ! function_exists( 'front_shop_view_switcher' ) ) {
    /**
     * Outputs view switcher
     */
    function front_shop_view_switcher() {

        global $wp_query;

        if ( 1 === $wp_query->found_posts || ! woocommerce_products_will_display() ) {
            return;
        }

        $shop_views = front_get_shop_views();
        ?>
        <?php foreach( $shop_views as $view_id => $shop_view ) : ?>
            <li class="nav-item list-inline-item"><a class="nav-link btn btn-xs btn-soft-secondary <?php $active_class = $shop_view[ 'active' ] ? 'active': ''; echo esc_attr( $active_class ); ?>" data-archive-class="<?php echo esc_attr( $view_id );?>" data-toggle="tab" title="<?php echo esc_attr( $shop_view[ 'label' ] ); ?>" href="#<?php echo esc_attr( $view_id );?>"><span class="<?php echo esc_attr( $shop_view[ 'icon' ] ); ?>"></span></a></li>
        <?php endforeach; ?>
        <?php
    }
}


if ( ! function_exists( 'front_shop_view_content_wrapper_open' ) ) {
    /**
     * Product show view content wrapper
     *
     * @since   1.0.0
     * @return  void
     */
    function front_shop_view_content_wrapper_open() {
        if ( ! WC()->query->get_main_query()->post_count ) { // WPCS: input var ok, CSRF ok.
            return;
        }

        $data_attr = 'shop-products';
        $class = 'grid-view';
        $data_view = 'grid';
        $shop_views = front_get_shop_views();
        foreach( $shop_views as $shop_view => $shop_view_args) {
            if ( $shop_view_args['active'] ) {
                $class = $shop_view . '-view';
                $data_view = $shop_view;
                break;
            }
        }

        echo '<div data-view="' . esc_attr( $data_view ) . '" data-toggle="' . esc_attr( $data_attr ) . '" class="products">';
    }
}

if ( ! function_exists( 'front_get_shop_views' ) ) {
    /**
     * Get shop views available by front
     */
    function front_get_shop_views() {

        $shop_views = apply_filters( 'front_get_shop_views_args', array(
            'grid'              => array(
                'label'         => esc_html__( 'Grid View', 'front' ),
                'icon'          => 'fas fa-th-large',
                'enabled'       => true,
                'active'        => true,
            ),
            'list'          => array(
                'label'         => esc_html__( 'List View', 'front' ),
                'icon'          => 'fas fa-list',
                'enabled'       => true,
                'active'        => false,

            )
        ) );

        return $shop_views;
    }
}

if ( ! function_exists( 'front_shop_view_content_wrapper_close' ) ) {
    /**
     * Product show view content wrapper close
     *
     * @since   1.0.0
     * @return  void
     */
    function front_shop_view_content_wrapper_close() {
        if ( ! WC()->query->get_main_query()->post_count ) { // WPCS: input var ok, CSRF ok.
            return;
        }

        ?></div><!-- /#front-shop-view-content --><?php
    }
}

if ( ! function_exists( 'front_template_loop_categories' ) ) {
    /**
     * Output Product Categories
     *
     */
    function front_template_loop_categories() {
        global $product;
        $product_id = $product->get_id();
        $terms = get_the_terms( $product_id, 'product_cat' );
        $terms_html = [];

        foreach ( $terms as $term ) {
            $link = get_term_link( $term, 'product_cat' );
            $terms_html[] .= '<a class="d-inline-block text-secondary small font-weight-normal mb-1" href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';
        }

        echo apply_filters( 'front_template_loop_categories_html', wp_kses_post( sprintf( '<span class="woocommerce-loop-product__categories text-secondary">%s</span>', implode( ', ',$terms_html ) ) ));
    }
}

add_filter( 'woocommerce_product_get_rating_html', 'front_product_get_rating_html', 10, 3 );

function front_product_get_rating_html( $html, $rating, $count ) {
    global $product;

    if ( empty ( $count ) && $product ) {
        $count = $product->get_rating_count();
    }
    ob_start();
    ?>
    <div class="mb-3">
        <a href="#" class="d-inline-flex align-items-center small">
            <div class="text-warning mr-2">
                <?php echo front_get_rating_html( $html, $rating ); ?>
            </div>
            <span class="text-secondary"><?php echo esc_html( $count ); ?></span>
        </a>
    </div>
    <?php
    return ob_get_clean();
}

function front_get_rating_html( $html = '', $rating, $tag = 'small' ) {
    ob_start();
    ?>
    <<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $rating >= 1 ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></<?php echo esc_attr( $tag ); ?>>
    <<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $rating >= 2 ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></<?php echo esc_attr( $tag ); ?>>
    <<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $rating >= 3 ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></<?php echo esc_attr( $tag ); ?>>
    <<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $rating >= 4 ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></<?php echo esc_attr( $tag ); ?>>
    <<?php echo esc_attr( $tag ); ?> class="<?php echo esc_attr( $rating >= 5 ? 'fas fa-star' : 'text-muted far fa-star' ); ?>"></<?php echo esc_attr( $tag ); ?>>
    <?php
    return ob_get_clean();

}


if ( ! function_exists( 'front_pagination' ) ) {
    /**
     * Displays an advanced pagination
     */
    function front_pagination() {

        global $wp_query, $wp_rewrite;

        if ( $wp_query->max_num_pages <= 1 ) {
            return;
        }

        // Setting up default values based on the current URL.
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $url_parts    = explode( '?', $pagenum_link );

        // Get max pages and current page out of the current query, if available.
        $total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
        $current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

        // URL base depends on permalink settings.
        $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

        $base       = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
        $add_args   = false;

        $output = '';
        $prev_text = '&#171; Prev';
        $next_text = 'Next &#187;';

        if ( $current && 1 < $current ) :
            $link = str_replace( '%_%', 2 == $current ? '' : $format, $base );
            $link = str_replace( '%#%', $current - 1, $link );
            $output .= '<li class="page-item ml-0"><a class="page-link prev page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $prev_text . '</a></li>';
        endif;

        $number_input = '<li class="page-item">
            <div class="d-flex align-items-center">
                <span class="d-none d-sm-inline-block text-secondary">' . esc_html__('Page:', 'front'). '</span><select class="custom-select custom-select-sm w-auto mx-2 form-adv-pagination" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">';
                for( $i=1; $i<=$total; $i++) {
                    $link = str_replace( '%_%', $format, $base );
                    $link = str_replace( '%#%', $i, $link );
                    $number_input .= '<option value="' . esc_url($link) . '"' . ( $i == $current ? "selected" : "" ). '>' . esc_html($i) . '</option>';
                }

        $number_input .=   '</select><span class="d-none d-sm-inline-block text-secondary">' . esc_html__('of', 'front') . ' ' . esc_attr ($total) . '</span></div></li>';
        $output .= sprintf( esc_html__( '%s', 'front' ), $number_input );


        if ( $current && ( $current < $total || -1 == $total ) ) :
            $link = str_replace( '%_%', $format, $base );
            $link = str_replace( '%#%', $current + 1, $link );
            $output .= '<li class="page-item"><a class="page-link next page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $next_text . '</a></li>';
        endif;

        $link = str_replace( '%_%', $format, $base );
        ?>
        <ul class="pagination justify-content-between align-items-center">
            <?php echo wp_kses_post( $output ); ?>
        </ul>
        <?php
    }
}

if ( ! function_exists( 'front_shop_loop_spacing' ) ) {
    function front_shop_loop_spacing() {
        if ( ! WC()->query->get_main_query()->post_count ) { // WPCS: input var ok, CSRF ok.
            return;
        }

        ?><div class="py-3"></div><?php
    }
}

if ( ! function_exists( 'front_wc_catalog_orderby' ) ) {
    function front_wc_catalog_orderby( $options ) {
        $options = array(
            'menu_order' => esc_html__( 'Sort by', 'front' ),
            'popularity' => esc_html__( 'Popularity', 'front' ),
            'rating'     => esc_html__( 'Average rating', 'front' ),
            'date'       => esc_html__( 'Newness', 'front' ),
            'price'      => esc_html__( 'Price (high - low)', 'front' ),
            'price-desc' => esc_html__( 'Price (low - high)', 'front' ),
        );
        return $options;
    }
}

if ( ! function_exists( 'front_product_loop_list_view_wrap_open' ) ) {
    function front_product_loop_list_view_wrap_open() {
        ?>
        <div class="row">
        <?php
    }
}

if ( ! function_exists( 'front_product_loop_list_view_wrap_close' ) ) {
    function front_product_loop_list_view_wrap_close() {
        ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_product_loop_list_view_thumbnail_wrap_open' ) ) {
    function front_product_loop_list_view_thumbnail_wrap_open() {
        ?>
        <div class="col-4 pr-0">
        <?php
    }
}

if ( ! function_exists( 'front_product_loop_list_view_thumbnail_wrap_close' ) ) {
    function front_product_loop_list_view_thumbnail_wrap_close() {
        ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_product_loop_list_view_card_body_outer_wrap_open' ) ) {
    function front_product_loop_list_view_card_body_outer_wrap_open() {
        ?>
        <div class="col-8"><div class="card-body py-5 px-md-4">
        <?php

    }
}

if ( ! function_exists( 'front_product_loop_list_view_card_body_inner_wrap_open' ) ) {
    function front_product_loop_list_view_card_body_inner_wrap_open() {
        ?>
        <div class="mb-2">
        <?php

    }
}


if ( ! function_exists( 'front_product_loop_list_view_card_body_inner_wrap_close' ) ) {
    function front_product_loop_list_view_card_body_inner_wrap_close() {
        ?>
        </div>
        <?php

    }
}

if ( ! function_exists( 'front_product_loop_list_view_rating_wrap_open' ) ) {
    function front_product_loop_list_view_rating_wrap_open() {
        ?>
        <div class="mb-3">
        <?php

    }
}

if ( ! function_exists( 'front_product_loop_list_view_rating_wrap_close' ) ) {
    function front_product_loop_list_view_rating_wrap_close() {
        ?>
        </div>
        <?php

    }
}


if ( ! function_exists( 'front_product_loop_list_view_card_body_outer_wrap_close' ) ) {
    function front_product_loop_list_view_card_body_outer_wrap_close() {
        ?>
        </div></div>
        <?php

    }
}

if ( ! function_exists( 'front_template_loop_product_excerpt' ) ) {
    /**
     *
     */
    function front_template_loop_product_excerpt() {
        global $post;

        if ( ! is_object( $post ) || ! $post->post_excerpt ) {
            return;
        }

        ?>
        <div class="product-short-description text-secondary font-size-1">
            <?php
                $product_excerpt = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

                if ( apply_filters( 'front_esc_excerpt', false ) ) {
                    $product_excerpt = esc_html( $product_excerpt );
                }

                echo wp_kses_post( $product_excerpt );
            ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_wc_get_sidebar' ) ) {
    function front_wc_get_sidebar() {
        $layout = front_get_layout();
        $display_type = woocommerce_get_loop_display_mode();

        if ( 'subcategories' === $display_type ) {
            get_sidebar( 'product-catgeory' );
        } elseif ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) {
            woocommerce_get_sidebar();
        }
    }
}

if ( ! function_exists( 'front_wc_maybe_show_product_subcategories' ) ) {
    function front_wc_maybe_show_product_subcategories() {
        wc_set_loop_prop( 'loop', 0 );
        $product_cat_columns = apply_filters( 'front_product_cat_columns', 2 );
        $product_columns     = absint( max( 1, wc_get_loop_prop( 'columns', wc_get_default_products_per_row() ) ) );
        wc_set_loop_prop( 'columns', $product_cat_columns );
        $wc_sub_categories = woocommerce_maybe_show_product_subcategories( '' );
        wc_set_loop_prop( 'columns', $product_columns );
        if ( ! empty( $wc_sub_categories ) ) {
            ?><section class="section-product-categories">
                <div class="d-none w-md-80 w-lg-40 text-center mx-md-auto mb-9">
                    <h2 class="section-title h3 font-weight-medium"><?php echo sprintf( esc_html__( '%s Categories', 'front' ), woocommerce_page_title( false ) ); ?></h2>
                </div>

                <ul class="list-unstyled loop-product-categories row columns-<?php echo esc_attr( $product_cat_columns ); ?>"><?php echo wp_kses_post(  $wc_sub_categories ); ?></ul></section><?php
        }
    }
}

if ( ! function_exists( 'front_template_loop_category_body_wrap_open' ) ) {
    function front_template_loop_category_body_wrap_open() {
        ?>

        <div class="card-body d-flex align-items-center p-0">
        <?php
    }
}

if ( ! function_exists( 'front_template_loop_category_body_wrap_close' ) ) {
    function front_template_loop_category_body_wrap_close() {
        ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_template_loop_category_image_wrap_open' ) ) {
    function front_template_loop_category_image_wrap_open() {
        ?>
        <div class="w-65 border-right">
        <?php
    }
}

if ( ! function_exists( 'front_template_loop_category_image_wrap_close' ) ) {
    function front_template_loop_category_image_wrap_close() {
        ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_template_loop_category_footer_wrap_open' ) ) {
    function front_template_loop_category_footer_wrap_open() {
        ?>
        <div class="card-footer text-center py-4">
        <?php
    }
}

if ( ! function_exists( 'front_template_loop_category_footer_wrap_close' ) ) {
    function front_template_loop_category_footer_wrap_close() {
        ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_template_loop_category_wrap_open' ) ) {
    function front_template_loop_category_wrap_open() {
        ?>
        <div class="card d-block">
        <?php
    }
}

if ( ! function_exists( 'front_template_loop_category_wrap_close' ) ) {
    function front_template_loop_category_wrap_close() {
        ?>
        </div>
        <?php
    }
}


if ( ! function_exists( 'front_template_loop_category_products_block' ) ) {
    function front_template_loop_category_products_block( $category ) {

        if( ! empty( $category ) ) {
            $shortcode_atts['category'] = $category->slug;
            $shortcode_atts['cat_operator'] = 'IN';
            $shortcode_atts['visibility'] = 'visible';
            $shortcode_atts['limit'] = 2;
        }

        $products = wc_get_products( $shortcode_atts );


        ?>
        <div class="w-35">
            <?php for( $i = 1; $i <= count( $products ); $i++) { ?>
                <?php if( $i <count( $products ) ): ?>
                    <div class="border-bottom">
                        <?php endif; ?>
                            <a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>">
                                <?php echo wp_kses_post( $products[$i-1]->get_image() ); ?>
                            </a>
                        <?php if( $i <count( $products ) ): ?>
                    </div>
                <?php endif; ?>
            <?php } ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'front_template_loop_category_content' ) ) {
    function front_template_loop_category_content( $category ) {
        ?>
        <span class="d-block mb-3">
            <?php if ( !empty( $category->description ) ): ?>
                <span class= "category-description text-muted font-size-1"><?php echo esc_html( $category->description ); ?></span>
            <?php endif; ?>
        </span>

        <a class="btn btn-sm btn-outline-primary btn-pill transition-3d-hover px-5" href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>">
            <?php echo apply_filters( 'front_template_loop_category_button_text', wp_kses_post( sprintf( '%s %s', esc_html__( 'View All', 'front' ), esc_html( $category->name ) ) ) ); ?>
        </a>
        <?php
    }
}

if ( ! function_exists( 'front_product_category_loop_classes' ) ) {
    function front_product_category_loop_classes( $classes, $class, $category ) {

        $classes[] = 'col-lg-6 mb-5';

        return $classes;
    }
}

if ( ! function_exists( 'front_get_brands_taxonomy' ) ) {
    /**
     * Products Brand Taxonomy
     *
     * @return string
     */
    function front_get_brands_taxonomy() {
        return apply_filters( 'front_product_brand_taxonomy', '' );
    }
}

if ( ! function_exists( 'front_shop_archive_header' ) ) {
    function front_shop_archive_header() {
        $static_block_id = '';

        if( is_shop() ) {
            $static_block_id = apply_filters( 'front_shop_jumbotron_id', '' );
        } else if ( is_product_category() || is_tax( $brands_taxonomy ) ) {
            $term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
            if ( isset( $term->term_id ) ) {
                $term_id            = $term->term_id;
                $static_block_id    = get_term_meta( $term_id, 'static_block_id', true );
            }
        }

        if( front_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {
            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<div class="archive-top-jumbotron">' . apply_filters( 'the_content', $content ) . '</div>';
        }
    }
}

if( ! function_exists( 'front_archive_middle_jumbotron' ) ) {
    function front_archive_middle_jumbotron() {
        $static_block_id = '';

        if( is_shop() ) {
            $static_block_id = apply_filters( 'front_archive_middle_jumbotron_id', '' );
        } else if ( is_product_category() || is_tax( $brands_taxonomy ) ) {
            $term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
            if ( isset( $term->term_id ) ) {
                $term_id            = $term->term_id;
                $static_block_id    = get_term_meta( $term_id, 'static_block_middle_id', true );
            }
        }

        if( front_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {
            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<li class="archive-middle-jumbotron">' . apply_filters( 'the_content', $content ) . '</li>';
        }
    }
}

if ( ! function_exists( 'front_archive_bottom_jumbotron' ) ) {
    function front_archive_bottom_jumbotron() {

        $static_block_id = '';

        if( is_shop() ) {
            $static_block_id = apply_filters( 'front_archive_bottom_jumbotron_id', '' );
        } else if ( is_product_category() || is_tax( $brands_taxonomy ) ) {
            $term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
            if ( isset( $term->term_id ) ) {
                $term_id            = $term->term_id;
                $static_block_id    = get_term_meta( $term_id, 'static_block_bottom_id', true );
            }
        }

        if( front_is_mas_static_content_activated() && ! empty( $static_block_id ) && is_product_category()) {
            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<div class="archive-bottom-jumbotron">' . apply_filters( 'the_content', $content ) . '</div>';
        }
    }
}

if ( ! function_exists( 'front_woocommerce_layered_nav_count' ) ) {
    function front_woocommerce_layered_nav_count( $term_html, $count, $term ) {
        $term_html = '<span class="count">' . absint( $count ) . '</span>';
        return $term_html;
        }
}

if ( ! function_exists( 'front_rating_filter_count' ) ) {
    function front_rating_filter_count( $count_html, $count, $rating ){
       $count_html = $count;
        return $count_html;
    }
}
