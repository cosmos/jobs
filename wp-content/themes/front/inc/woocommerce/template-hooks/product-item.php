<?php
/**
 * Template hooks used in Product Item i.e. content-product.php
 */

// Remove default subcatgories
add_filter( 'woocommerce_product_loop_start', 'front_remove_loop_start_subcatgories' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',       20 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',     20 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 ); 
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_sidebar', 'front_wc_get_sidebar', 10 );

add_filter( 'woocommerce_product_loop_title_classes', 'front_product_loop_title_classes', 10 );
add_filter( 'woocommerce_loop_add_to_cart_args',      'front_loop_add_to_cart_args',      10, 3 );
add_filter( 'woocommerce_format_sale_price',          'front_wc_format_sale_price',       10, 3 );
add_filter( 'woocommerce_get_price_html',             'front_wc_get_price_html',          10, 2 );
//add_filter( 'yith-wcwl-browse-wishlist-label',        'front_wcwl_browse_wishlist_label', 10, 2 );
add_filter( 'woocommerce_catalog_orderby', 'front_wc_catalog_orderby', 10 );

add_action( 'woocommerce_before_shop_loop',         	'front_wc_maybe_show_product_subcategories', 5 );
add_action( 'woocommerce_before_shop_loop',			    'front_shop_control_bar',		     12 );
add_action( 'woocommerce_before_shop_loop',         	'front_shop_view_content_wrapper_open',    50 );
add_action( 'woocommerce_after_shop_loop',  			'front_shop_view_content_wrapper_close',  PHP_INT_MAX );

add_action( 'woocommerce_before_shop_loop_item', 		'front_product_loop_wrap_open',  0 );
add_action( 'woocommerce_after_shop_loop_item', 		'front_product_loop_wrap_close', 50 );
add_action( 'woocommerce_before_shop_loop_item_title', 	'front_product_loop_thumbnail_wrap_open', 8 );
add_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_template_loop_product_link_open', 9 ); 
add_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_template_loop_product_link_close', 11 ); 
add_action( 'woocommerce_before_shop_loop_item_title', 	'front_product_loop_sale_wrap_open', 12);
add_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_show_product_loop_sale_flash', 15 ); 
add_action( 'woocommerce_before_shop_loop_item_title', 	'front_product_loop_sale_wrap_close', 18 );
add_action( 'woocommerce_before_shop_loop_item_title', 	'front_product_loop_sold_out', 20 );
add_action( 'woocommerce_before_shop_loop_item_title', 	'front_product_loop_thumbnail_wrap_close', 30 );
add_action( 'woocommerce_before_shop_loop_item_title', 	'front_product_loop_card_body_open', 90 );
add_action( 'woocommerce_shop_loop_item_title',         'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 		'front_template_loop_categories', 5 );
add_action( 'woocommerce_after_shop_loop_item_title',   'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 	'front_product_loop_card_body_close', 20 );
add_action( 'woocommerce_after_shop_loop_item_title', 	'front_product_loop_card_footer_open', 25 );
add_action( 'woocommerce_after_shop_loop_item_title', 	'woocommerce_template_loop_rating', 30 );

add_action( 'woocommerce_after_shop_loop_item', 		'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'woocommerce_after_shop_loop_item', 		'front_product_loop_card_footer_close', 20 );

add_action( 'woocommerce_after_shop_loop_item', 		'front_product_loop_list_view_wrap_open', 60 );
add_action( 'woocommerce_after_shop_loop_item', 		'front_product_loop_list_view_thumbnail_wrap_open', 70 );
add_action( 'woocommerce_after_shop_loop_item',         'woocommerce_template_loop_product_link_open', 75 ); 
add_action( 'woocommerce_after_shop_loop_item',         'woocommerce_template_loop_product_thumbnail', 80 );
add_action( 'woocommerce_after_shop_loop_item',         'woocommerce_template_loop_product_link_close', 85 );
add_action( 'woocommerce_after_shop_loop_item', 		'front_product_loop_list_view_thumbnail_wrap_close', 90 );
add_action( 'woocommerce_after_shop_loop_item', 	    'front_product_loop_list_view_card_body_outer_wrap_open', 100 );
add_action( 'woocommerce_after_shop_loop_item', 	    'front_product_loop_list_view_card_body_inner_wrap_open', 110 );
add_action( 'woocommerce_after_shop_loop_item', 	    'front_template_loop_categories', 120 );
add_action( 'woocommerce_after_shop_loop_item', 	    'woocommerce_template_loop_product_title', 130 );
add_action( 'woocommerce_after_shop_loop_item', 	    'front_template_loop_product_excerpt', 140 );
add_action( 'woocommerce_after_shop_loop_item', 	    'woocommerce_template_loop_price', 150 );
add_action( 'woocommerce_after_shop_loop_item', 	    'front_product_loop_list_view_card_body_inner_wrap_close', 160 );
add_action( 'woocommerce_after_shop_loop_item', 	    'front_product_loop_list_view_rating_wrap_open', 170 );
add_action( 'woocommerce_after_shop_loop_item', 	    'woocommerce_template_loop_rating', 180 );
add_action( 'woocommerce_after_shop_loop_item', 	    'front_product_loop_list_view_rating_wrap_close', 190 );
add_action( 'woocommerce_after_shop_loop_item', 	    'woocommerce_template_loop_add_to_cart', 200 );

add_action( 'woocommerce_after_shop_loop_item', 	    'front_product_loop_list_view_card_body_outer_wrap_close', 220 );

add_action( 'woocommerce_after_shop_loop_item', 		'front_product_loop_list_view_wrap_close', 230 );

add_action( 'woocommerce_after_shop_loop',              'front_shop_loop_spacing', 5 );
add_action( 'woocommerce_before_shop_loop',         	'front_shop_archive_header', 1 );

/**
 * Template hooks used in Category Page i.e. content-product-cat.php
 */
add_filter( 'product_cat_class', 'front_product_category_loop_classes', 10, 3 );

remove_action( 'woocommerce_after_subcategory',     'woocommerce_template_loop_category_link_close', 10 );

add_action( 'woocommerce_before_subcategory',           'front_template_loop_category_wrap_open', 1 );
add_action( 'woocommerce_before_subcategory',     		'front_template_loop_category_body_wrap_open', 5 );

add_action( 'woocommerce_before_subcategory',     		'front_template_loop_category_image_wrap_open', 6 );

add_action( 'woocommerce_before_subcategory_title',     'woocommerce_template_loop_category_link_close', 19 );

add_action( 'woocommerce_before_subcategory_title',     'front_template_loop_category_image_wrap_close', 20 );

add_action( 'woocommerce_before_subcategory_title',     'front_template_loop_category_products_block', 25 );
add_action( 'woocommerce_before_subcategory_title',     'front_template_loop_category_body_wrap_close', 30 );
add_action( 'woocommerce_before_subcategory_title',     'front_template_loop_category_footer_wrap_open', 30 );

add_action( 'woocommerce_shop_loop_subcategory_title',  'woocommerce_template_loop_category_link_open', 5 );
add_action( 'woocommerce_shop_loop_subcategory_title',  'woocommerce_template_loop_category_link_close', 15 );

add_action( 'woocommerce_shop_loop_subcategory_title',  'front_template_loop_category_content', 20 );
add_action( 'woocommerce_after_subcategory_title',      'front_template_loop_category_footer_wrap_close', 10 );
add_action( 'woocommerce_after_subcategory',            'front_template_loop_category_wrap_close', 10 );

add_action( 'front_archive_main_content_after', 'front_archive_bottom_jumbotron', 10 );

add_filter( 'woocommerce_layered_nav_count', 'front_woocommerce_layered_nav_count', 10, 3 );
add_filter( 'woocommerce_rating_filter_count', 'front_rating_filter_count', 10, 3 );