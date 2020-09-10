<?php
/**
 * Template Hooks used in Single Product
 *
 * @package front
 */
add_action( 'woocommerce_before_single_product', 'front_print_notices_wrap_open', 9 );
add_action( 'woocommerce_before_single_product', 'front_print_notices_wrap_close', 11 );
add_action( 'woocommerce_before_single_product_summary', 'front_wc_single_product_hero_start',     0 );
add_action( 'woocommerce_before_single_product_summary', 'front_wc_single_product_image_start',    3 );
add_action( 'woocommerce_before_single_product_summary', 'front_wc_single_product_image_end',     30 );
add_action( 'woocommerce_before_single_product_summary', 'front_wc_single_product_summary_start', 35 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title',    5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating',  10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price',   10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_before_single_product_summary', 'front_wc_show_product_images', 20 );
add_action( 'woocommerce_single_product_summary', 'front_wc_template_single_rating',         5 );
add_action( 'woocommerce_single_product_summary', 'front_wc_template_single_title_excerpt', 10 );
add_action( 'woocommerce_single_product_summary', 'front_wc_template_single_price',         20 );
add_action( 'woocommerce_single_product_summary', 'front_features_section', 				35 );

add_action( 'woocommerce_after_single_product_summary', 'front_wc_single_product_summary_end', 0 );
add_action( 'woocommerce_after_single_product_summary', 'front_wc_single_product_hero_end',    5 );
add_action( 'woocommerce_after_single_product_summary', 'front_output_product_data_tabs',      10 );

add_action( 'woocommerce_before_add_to_cart_quantity', 'front_wc_before_add_to_cart_quantity', 10 );
add_action( 'woocommerce_after_add_to_cart_quantity',  'front_wc_after_add_to_cart_quantity',  10 );

add_filter( 'woocommerce_single_product_carousel_options', 'front_single_product_carousel_options');

add_action( 'woocommerce_before_single_product_summary', 	'front_product_loop_sale_wrap_open', 9);
add_action( 'woocommerce_before_single_product_summary', 	'front_product_loop_sale_wrap_close', 11);
add_action( 'woocommerce_after_single_product_summary',     'front_wc_single_product_before_footer_content',       21);

add_filter( 'woocommerce_product_tabs', 'front_wc_product_tabs', 20 );