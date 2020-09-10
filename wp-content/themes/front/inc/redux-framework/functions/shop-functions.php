<?php
/**
 * Filter functions for Shop Section of Theme Options
 */

if( ! function_exists( 'redux_toggle_shop_catalog_mode' ) ) {
	function redux_toggle_shop_catalog_mode() {
		global $front_options;

		if( isset( $front_options['catalog_mode'] ) && $front_options['catalog_mode'] == '1' ) {
			$catalog_mode = true;
		} else {
			$catalog_mode = false;
		}

		return $catalog_mode;
	}
}

function redux_apply_catalog_mode_for_product_loop( $product_link, $product ) {
	global $front_options;

	$product_id = $product->get_id();
	$product_type = $product->get_type();

	if( isset( $front_options['catalog_mode'] ) && $front_options['catalog_mode'] == '1' ) {
		$product_link = sprintf( '<a href="%s" class="button product_type_%s">%s</a>',
			get_permalink( $product_id ),
			esc_attr( $product_type ),
			apply_filters( 'front_catalog_mode_button_text', esc_html__( 'View Product', 'front' ) )
		);
	}

	return $product_link;
}

if ( ! function_exists( 'front_redux_change_shop_layout' ) ) {
    function front_redux_change_shop_layout( $shop_layout ) {
        global $front_options;

        if ( isset( $front_options['shop_layout'] ) ) {
            $shop_layout = $front_options['shop_layout'];
        }

        return $shop_layout;
    }
}

if( ! function_exists( 'redux_apply_shop_jumbotron_id' ) ) {
	function redux_apply_shop_jumbotron_id( $static_block_id ) {
		global $front_options;

		if( isset( $front_options['shop_jumbotron_id'] ) ) {
			$static_block_id = $front_options['shop_jumbotron_id'];
		}

		return $static_block_id;
	}
}

if ( ! function_exists( 'redux_set_shop_view_args' ) ) {
	function redux_set_shop_view_args( $shop_view_args ) {
		global $front_options;

		if ( isset( $front_options['product_archive_enabled_views'] ) ) {
			$shop_views = $front_options['product_archive_enabled_views']['enabled'];

			if ( $shop_views ) {
				$new_shop_view_args = array();
				$count = 0;
				
				foreach( $shop_views as $key => $shop_view ) {
					
					if ( isset( $shop_view_args[ $key ] ) ) {
						$new_shop_view_args[ $key ] = $shop_view_args[ $key ];

						if ( 0 == $count ) {
							$new_shop_view_args[ $key ]['active'] = true;
						} else {
							$new_shop_view_args[ $key ]['active'] = false;
						}

						$count++;
					}
				}

				return $new_shop_view_args;
			}
		}

		return $shop_view_args;
	}
}

if ( ! function_exists( 'redux_toggle_related_products_output' ) ) {
	function redux_toggle_related_products_output( $enable ) {
		global $front_options;

		if ( ! isset( $front_options['enable_related_products'] ) ) {
			$front_options['enable_related_products'] = true;
		}

		if ( $front_options['enable_related_products'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_toggle_single_product_features_output' ) ) {
	function redux_toggle_single_product_features_output( $enable ) {
		global $front_options;

		if ( isset( $front_options['single_product_features_show'] ) && $front_options['single_product_features_show'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_apply_single_product_feature' ) ) {
	function redux_apply_single_product_feature( $features ) {
		global $front_options;

		if( ! empty( $front_options['single_product_feature_list_title'] ) ) {

			$info = array();

			foreach( $front_options['single_product_feature_list_title'] as $key => $title ) {
				if ( ! empty( $title ) ) {
					$feature_desc = '';
					$icon = '';


					if ( ! empty( $front_options['single_product_feature_list_icon'][$key] ) ) {
		                $icon = $front_options['single_product_feature_list_icon'][$key];
		        	}


					if ( ! empty( $front_options['single_product_feature_list_text'][$key] ) ) {
						$feature_desc = $front_options['single_product_feature_list_text'][$key];
					}

					$info[] = array(
						'feature_title' => $title,
						'feature_desc'  => $feature_desc,
						'icon' => $icon
					);
				}
			}

			if( ! empty( $info ) ) {
				$features = $info;
			}
		}

		return $features;
	}
}

if ( ! function_exists( 'front_redux_toggle_separate_shop_header' ) ) {
    function front_redux_toggle_separate_shop_header( $enable_separate_shop_header ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_shop_header'] ) && $front_options['enable_separate_shop_header'] ) {
            $enable_separate_shop_header = true;
        } else {
            $enable_separate_shop_header = false;
        }

        return $enable_separate_shop_header;
    }
}

if( ! function_exists( 'front_redux_shop_header_static_block' ) ) {
    function front_redux_shop_header_static_block( $shop_static_block_id ) {
        global $front_options;

        $woocommerce = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $enable_separate_shop_header = isset( $front_options['enable_separate_shop_header'] ) && $front_options['enable_separate_shop_header'];

        if( $enable_separate_shop_header && isset( $front_options['header_shop_static_block_id'] ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
            $shop_static_block_id = $front_options['header_shop_static_block_id'];
        }

        return $shop_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_toggle_separate_shop_footer' ) ) {
    function front_redux_toggle_separate_shop_footer( $enable_separate_shop_footer ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_shop_footer'] ) && $front_options['enable_separate_shop_footer'] ) {
            $enable_separate_shop_footer = true;
        } else {
            $enable_separate_shop_footer = false;
        }

        return $enable_separate_shop_footer;
    }
}

if( ! function_exists( 'front_redux_shop_footer_static_block' ) ) {
    function front_redux_shop_footer_static_block( $shop_static_block_id ) {
        global $front_options;

        $woocommerce = function_exists( 'front_is_woocommerce_activated' ) && front_is_woocommerce_activated();

        $enable_separate_shop_footer = isset( $front_options['enable_separate_shop_footer'] ) && $front_options['enable_separate_shop_footer'];

        if( $enable_separate_shop_footer && isset( $front_options['footer_shop_static_block_id'] ) && $woocommerce && ( is_shop() || is_product() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page() ) ) {
            $shop_static_block_id = $front_options['footer_shop_static_block_id'];
        }

        return $shop_static_block_id;
    }
}

if( ! function_exists( 'redux_apply_single_product_jumbotron_id' ) ) {
	function redux_apply_single_product_jumbotron_id( $single_product_static_block_id ) {
		global $front_options;

		if( isset( $front_options['single_product_jumbotron_id'] ) ) {
			$single_product_static_block_id = $front_options['single_product_jumbotron_id'];
		}

		return $single_product_static_block_id;
	}
}