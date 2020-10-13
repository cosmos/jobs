<?php
/**
 * Import Woocommerce plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMWC;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

require_once('ImportHelpers.php');

class WooCommerceMetaImport extends ImportHelpers{
	private static $woocommerce_meta_instance = null,$media_instance;

	public static function getInstance() {

		if (WooCommerceMetaImport::$woocommerce_meta_instance == null) {
			WooCommerceMetaImport::$woocommerce_meta_instance = new WooCommerceMetaImport;
			WooCommerceMetaImport::$media_instance = new MediaHandling();
			return WooCommerceMetaImport::$woocommerce_meta_instance;
		}
		return WooCommerceMetaImport::$woocommerce_meta_instance;
	}

	public function woocommerce_meta_import_function ($data_array, $pID , $import_type , $line_number, $header_array , $value_array) {
		global $wpdb;
		global $core_instance;

		$metaData = array();
		$order_item = array();
		foreach ($data_array as $ekey => $eval) {
			switch ($ekey) {
			case 'stock_qty' :
				$metaData['_stock'] = $data_array[$ekey];
				break;
			case 'visibility' :
				//Product visibility is taxonomy based instead of meta based in woocommerce 3.0.0 
				$plugininfo = get_plugin_data( WP_PLUGIN_DIR .'/'.'woocommerce/woocommerce.php');
				$versionOfWoocom = $plugininfo['Version'];
				$visibility = '';
				if ($data_array[$ekey] == 1) {
					$visibility = 'visible';
				}
				if ($data_array[$ekey] == 2) {
					$visibility = 'catalog';
				}
				if ($data_array[$ekey] == 3) {
					$visibility = 'search';
				}
				if ($data_array[$ekey] == 4) {
					$visibility = 'hidden';
				}
				if(empty($data_array[$ekey])){
					$visibility = 'visible';
				}
				if($versionOfWoocom >= 3){
					if ($product = wc_get_product($pID)) {
						$product->set_catalog_visibility($visibility);
						$product->save();
					}
				}
				else
					$metaData['_visibility'] = $visibility;
				break;
			case 'stock_status' :
				$stock_status = '';
				if ($data_array[$ekey] == 1) {
					$stock_status = 'instock';
				}
				if ($data_array[$ekey] == 2) {
					$stock_status = 'outofstock';
				}
				$metaData['_stock_status'] = $stock_status;
				break;
			case 'downloadable' :
				$metaData['_downloadable'] = $data_array[$ekey];
				break;
			case 'virtual' :
				$metaData['_virtual'] = $data_array[$ekey];
				break;
			case 'product_image_gallery' :
				$get_all_gallery_images = explode('|', $data_array[$ekey]);
				$gallery_image_ids = '';
				foreach($get_all_gallery_images as $gallery_image) {
					if(is_numeric($gallery_image)) {
						$gallery_image_ids .= $gallery_image . ',';
					} else {
						$attachmentId = WooCommerceMetaImport::$media_instance->media_handling($gallery_image, $pID, $data_array,'','','',$header_array ,$value_array);
						$gallery_image_ids .= $attachmentId . ',';
					}
				}
				$product_image_gallery[$ekey] = $gallery_image_ids;
				break;
			case 'regular_price' :
				$metaData['_regular_price'] = $data_array[$ekey];
				$metaData['_price']=$data_array[$ekey];
				break;
			case 'sale_price' :
				$metaData['_sale_price'] = $data_array[$ekey];
				if(empty($metaData['_sale_price'])){
					$metaData['_price']=$metaData['_regular_price'];
				}
				else{
					$metaData['_price'] = $data_array[$ekey];
				}
				break;
			case 'tax_status' :
				$tax_status = '';
				if ($data_array[$ekey] == 1) {
					$tax_status = 'taxable';
				}
				if ($data_array[$ekey] == 2) {
					$tax_status = 'shipping';
				}
				if ($data_array[$ekey] == 3) {
					$tax_status = 'none';
				}
				$metaData['_tax_status'] = $tax_status;
				break;
			case 'tax_class' :
				$tax_class = '';
				if ($data_array[$ekey] == 1) {
					$tax_class = '';
				}
				if ($data_array[$ekey] == 2) {
					$tax_class = 'reduced-rate';
				}
				if ($data_array[$ekey] == 3) {
					$tax_class = 'zero-rate';
				}
				$metaData['_tax_class'] = $tax_class;
				break;
			case 'purchase_note' :
				$metaData['_purchase_note'] = $data_array[$ekey];
				break;
			case 'featured_product' :
				if ($product = wc_get_product($pID)) {
					$product->set_featured( $data_array[$ekey] );
					$product->save();
				}
				break;

			case 'variation_description':
				$metaData['_variation_description'] = $data_array[$ekey];
				break;
			case 'weight' :
				$metaData['_weight'] = $data_array[$ekey];
				break;
			case 'length' :
				$metaData['_length'] = $data_array[$ekey];
				break;
			case 'width' :
				$metaData['_width'] = $data_array[$ekey];
				break;
			case 'height' :
				$metaData['_height'] = $data_array[$ekey];
				break;
			case 'product_attribute_name' :
				$attribute_names[$ekey] = $data_array[$ekey];
				break;
			case 'product_attribute_type' :
				$attribute_types[$ekey] = $data_array[$ekey];
				break;
			case 'product_attribute_value' :
				$attribute_values[$ekey] = $data_array[$ekey];
				break;
			case 'product_attribute_visible' :
				$attribute_visible[$ekey] = $data_array[$ekey];
				break;
			case 'product_attribute_variation' :
				$attribute_variation[$ekey] = $data_array[$ekey];
				break;
			case 'product_attribute_position' :
				$attribute_position[$ekey] = $data_array[$ekey];
				break;
			case 'product_attribute_taxonomy' :
				$attribute_taxonomy[$ekey] = $data_array[$ekey];
				break;
			case '_wc_pb_bundle_sell_ids' :
				if ($data_array[$ekey]) {
					$bundle_pro_ids = [];
					$bundle_product_names = explode(',', $data_array[$ekey]);
					foreach($bundle_product_names as $product_name){
						$bundle_pro_ids[] = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_title = '$product_name' ");
					}
					$metaData['_wc_pb_bundle_sell_ids'] = $bundle_pro_ids;
					break;
				}
			case '_wc_pb_bundle_sells_title' :
				$metaData['_wc_pb_bundle_sells_title'] = $data_array[$ekey];
				break;
			case '_wc_pb_bundle_sells_discount' :
				$metaData['_wc_pb_bundle_sells_discount'] = $data_array[$ekey];
				break;
			case 'sale_price_dates_from' :
				$metaData['_sale_price_dates_from'] = $data_array[$ekey];
				break;
			case 'sale_price_dates_to' :
				$metaData['_sale_price_dates_to'] = $data_array[$ekey];
				break;
			case 'backorders' :
				$backorders = '';
				if ($data_array[$ekey] == 1) {
					$backorders = 'no';
				}
				if ($data_array[$ekey] == 2) {
					$backorders = 'notify';
				}
				if ($data_array[$ekey] == 3) {
					$backorders = 'yes';
				}
				$metaData['_backorders'] = $backorders;
				break;
			case 'manage_stock' :
				$metaData['_manage_stock'] = $data_array[$ekey];
				break;
			case 'low_stock_threshold' :
				$metaData['_low_stock_amount'] = $data_array[$ekey];
				break;
			case 'file_paths' :
				$metaData['_file_paths'] = $data_array[$ekey];
				break;
			case 'download_limit' :
				$metaData['_download_limit'] = $data_array[$ekey];
				break;
			case 'comment_status' :
				$status = $data_array[$ekey];
				$wpdb->get_results("UPDATE {$wpdb->prefix}posts SET comment_status = '$status' WHERE id = '$pID' ");
				break;
			case 'menu_order' :
				$menu_order = $data_array[$ekey];
				$wpdb->get_results("UPDATE {$wpdb->prefix}posts SET menu_order = '$menu_order' WHERE id = '$pID' ");
				break;

			case 'download_expiry' :
				$metaData['_download_expiry'] = $data_array[$ekey];
				break;
			case 'download_type' :
				$metaData['_download_type'] = $data_array[$ekey];
				break;
			case 'product_url' :
				$metaData['_product_url'] = $data_array[$ekey];
				break;
			case 'button_text' :
				$metaData['_button_text'] = $data_array[$ekey];
				break;
			case 'product_type' :

				$product_type = 'simple';
				if ($data_array[$ekey] == 1) {
					$product_type = 'simple';
				}
				if ($data_array[$ekey] == 2) {
					$product_type = 'grouped';
				}
				if ($data_array[$ekey] == 3) {
					$product_type = 'external';
				}
				if ($data_array[$ekey] == 4) {
					$product_type = 'variable';
				}
				if ($data_array[$ekey] == 5) {
					$product_type = 'subscription';
				}
				if ($data_array[$ekey] == 6) {
					$product_type = 'variable-subscription';
				}
				$core_instance->detailed_log[$line_number]['Type of Product'] = $product_type;
				wp_set_object_terms($pID, $product_type, 'product_type');
				break;
			case 'product_shipping_class' :
			case 'variation_shipping_class' :
				$class_name = $data_array[$ekey];
				$class = $wpdb->get_results("SELECT term_id FROM {$wpdb->prefix}terms where name = '{$class_name}' ");
				$class_id = $class[0]->term_id;

				if ($product = wc_get_product($pID)) {
					$product->set_shipping_class_id($class_id);
					$product->save();
				}
				break;
			case 'sold_individually' :
				$metaData['_sold_individually'] = $data_array[$ekey];
				break;
			case 'default_attributes' :
				if ($data_array[$ekey]) {
					$dattribute = explode(',',$data_array[$ekey]);
					foreach($dattribute as $dattrkey){
						$def_attribute = explode('|',$dattrkey);
						$def_attr_label = $def_attribute[0];
						$attri_name = $wpdb->get_results( "SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies where attribute_label = '$def_attr_label' ");
						$def_attribute_lower = 'pa_' . $attri_name[0]->attribute_name;
						$defAttribute[$def_attribute_lower] = $def_attribute[1];
					}
				}
				break;
			case 'custom_attributes' :
				if ($data_array[$ekey]) {
					$cusattribute = explode(',',$data_array[$ekey]);
					foreach($cusattribute as $cusattrkey){
						$cus_attribute = explode('|',$cusattrkey);

						$cus_attribute_label = $cus_attribute[0];
						$attri_name = $wpdb->get_results( "SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies where attribute_label = '$cus_attribute_label' ");
						$cus_attribute_lower = 'pa_' . $attri_name[0]->attribute_name;
						$cusAttribute[$cus_attribute_lower] = $cus_attribute[1];
					}
				}
				break;
			case 'product_tag' :
				$tags[$ekey] = $data_array[$ekey];
				$core_instance->detailed_log[$line_number]['Tags'] = $data_array[$ekey];
				break;
			case 'product_category' :
				$categories[$ekey] = $data_array[$ekey];
				$core_instance->detailed_log[$line_number]['Categories'] = $data_array[$ekey];
				break;
			case 'downloadable_files' :
				$downloadable_files = '';
				if ($data_array[$ekey]) {
					$exp_key = array();
					$exploded_file_data = explode('|', $data_array[$ekey]);
					foreach($exploded_file_data as $file_datas){
						$exploded_separate = explode(',', $file_datas);
						$convert_value = $exploded_separate[1];
						$file_name = hash_hmac('md5', "$convert_value" , 'secret');

						$exp_key[$file_name]['id'] = $file_name;
						$exp_key[$file_name]['name'] = $exploded_separate[0];
						$exp_key[$file_name]['file'] = $exploded_separate[1];
						$downloadable_files = $exp_key;
					}
				}
				$metaData['_downloadable_files'] = $downloadable_files;
				break;
			case 'crosssell_ids' :
				$crosssellids = '';
				if ($data_array[$ekey]) {
					$exploded_crosssell_ids = explode(',', $data_array[$ekey]);
					$crosssellids = $exploded_crosssell_ids;
				}
				$metaData['_crosssell_ids'] = $crosssellids;
				break;
			case 'upsell_ids' :
				$upcellids = '';
				if ($data_array[$ekey]) {
					$exploded_upsell_ids = explode(',', $data_array[$ekey]);
					$upcellids = $exploded_upsell_ids;
				}
				$metaData['_upsell_ids'] = $upcellids;
				break;
			case 'sku' :
				$metaData['_sku'] = $data_array[$ekey];
				$core_instance->detailed_log[$line_number]['SKU'] = $data_array[$ekey];
				break;
			case 'variation_sku' :
				$metaData['_sku'] = $data_array[$ekey];
				$core_instance->detailed_log[$line_number]['SKU'] = $data_array[$ekey];
				break;
			case 'thumbnail_id' :
				if (is_numeric($data_array[$ekey])) {
					$metaData['_thumbnail_id'] = $data_array[$ekey];
				}else{
					#TODO thumbnail need to add
				}
				break;
				//WooCommerce Chained Products Fields
			case 'chained_product_detail' :
				$arr = array();
				$cpid_key = '';
				if ($data_array[$ekey]) {
					$chainedid = explode('|', $data_array[$ekey]);
					foreach ($chainedid as $unitid ) {
						$cpid = explode(',', $unitid);
						$id = $cpid[0];
						$query_result = $wpdb->get_results($wpdb->prepare("select post_title from $wpdb->posts where ID = %d",$id));
						$product_name = $query_result[0]->post_title;
						if(isset($product_name) && $product_name != '' ) {
							$cpid_key[$cpid[0]]['unit'] = $cpid[1];
							$cpid_key[$cpid[0]]['product_name'] = $product_name;
						}
						$arr[] = $cpid[0];
					}
					$chained_product_detail = $cpid_key;
				} else {
					$chained_product_detail = '';
				}
				$metaData['_chained_product_detail'] = $chained_product_detail;
				$metaData['_chained_product_ids'] = $arr;
				break;
			case 'chained_product_manage_stock' :
				$metaData['_chained_product_manage_stock'] = $data_array[$ekey];
				break;
				//WooCommerce Product Retailers Fields
			case 'wc_product_retailers_retailer_only_purchase' :
				$metaData['_wc_product_retailers_retailer_only_purchase'] = $data_array[$ekey];
				break;
			case 'wc_product_retailers_use_buttons' :
				$metaData['_wc_product_retailers_use_buttons'] = $data_array[$ekey];
				break;
			case 'wc_product_retailers_product_button_text' :
				$metaData['_wc_product_retailers_product_button_text'] = $data_array[$ekey];
				break;
			case 'wc_product_retailers_catalog_button_text' :
				$metaData['_wc_product_retailers_catalog_button_text'] = $data_array[$ekey];
				break;
			case 'wc_product_retailers_id' :
				$retailer_id[$ekey] = $data_array[$ekey];
				break;
			case 'wc_product_retailers_price' :
				$retailer_price[$ekey] = $data_array[$ekey];
				break;
			case 'wc_product_retailers_url' :
				$retailer_url[$ekey] = $data_array[$ekey];
				break;
				//WooCommerce Product Add-ons Fields
			case 'product_addons_exclude_global' :
				$metaData['_product_addons_exclude_global'] = $data_array[$ekey];
				break;
			case 'product_addons_group_name' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
			case 'product_addons_group_description' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
			case 'product_addons_type' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
			case 'product_addons_position' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
			case 'product_addons_required' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
			case 'product_addons_label_name' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
			case 'product_addons_price' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
			case 'product_addons_minimum' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
			case 'product_addons_maximum' :
				$product_addons[$ekey] = $data_array[$ekey];
				break;
				//WooCommerce Warranty Requests Fields
			case 'warranty_label' :
				$metaData['_warranty_label'] = $data_array[$ekey];
				break;
			case 'warranty_type' :
				$warranty[$ekey] = $data_array[$ekey];
				break;
			case 'warranty_length' :
				$warranty[$ekey] = $data_array[$ekey];
				break;
			case 'warranty_value' :
				$warranty[$ekey] = $data_array[$ekey];
				break;
			case 'warranty_duration' :
				$warranty[$ekey] = $data_array[$ekey];
				break;
			case 'warranty_addons_amount' :
				$warranty[$ekey] = $data_array[$ekey];
				break;
			case 'warranty_addons_value' :
				$warranty[$ekey] = $data_array[$ekey];
				break;
			case 'warranty_addons_duration' :
				$warranty[$ekey] = $data_array[$ekey];
				break;
			case 'no_warranty_option' :
				$warranty[$ekey] = $data_array[$ekey];
				break;
				//WooCommerce Pre-Orders Fields
			case 'preorders_enabled' :
				$metaData['_wc_pre_orders_enabled'] = $data_array[$ekey];
				break;
			case 'preorders_availability_datetime' :
				if ($data_array[$ekey]) {
					$datetime_value = strtotime($data_array[$ekey]);
				}
				else {
					$datetime_value = '';
				}
				$metaData['_wc_pre_orders_availability_datetime'] = $datetime_value;
				break;
			case 'preorders_fee' :
				$metaData['_wc_pre_orders_fee'] = $data_array[$ekey];
				break;
			case 'preorders_when_to_charge' :
				$metaData['_wc_pre_orders_when_to_charge'] = $data_array[$ekey];
				break;
				//woocommerce_coupons starting
			case 'discount_type' :
				$metaData['discount_type'] = $data_array[$ekey];
				break;
			case 'coupon_amount' :
				$metaData['coupon_amount'] = $data_array[$ekey];
				break;
			case 'individual_use' :
				$metaData['individual_use'] = $data_array[$ekey];
				break;
			case 'exclude_product_ids' :
				$metaData['exclude_product_ids'] = $data_array[$ekey];
				break;
			case 'product_ids' :
				$metaData['product_ids'] = $data_array[$ekey];
				break;
			case 'usage_limit' :
				$metaData['usage_limit'] = $data_array[$ekey];
				break;
			case 'usage_limit_per_user' :
				$metaData['usage_limit_per_user'] = $data_array[$ekey];
				break;
			case 'limit_usage_to_x_items' :
				$metaData['limit_usage_to_x_items'] = $data_array[$ekey];
				break;
			case 'expiry_date' :
				$metaData['date_expires'] = strtotime($data_array[$ekey]);
				break;
			case 'free_shipping' :
				$metaData['free_shipping'] = $data_array[$ekey];
				break;
			case 'exclude_sale_items' :
				$metaData['exclude_sale_items'] = $data_array[$ekey];
				break;
			case 'minimum_amount' :
				$metaData['minimum_amount'] = $data_array[$ekey];
				break;
			case 'maximum_amount' :
				$metaData['maximum_amount'] = $data_array[$ekey];
				break;
			case 'customer_email' :
				$customer_email[$ekey] = $data_array[$ekey];
				break;
			case 'exclude_product_categories' :
				$exclude_product[$ekey] = $data_array[$ekey];
				break;
			case 'product_categories' :
				$product_cate[$ekey] = $data_array[$ekey];
				break;
				//woocommerce_orders starting
			case 'payment_method_title' :
				$metaData['_payment_method_title'] = $data_array[$ekey];
				break;
			case 'payment_method' :
				$metaData['_payment_method'] = $data_array[$ekey];
				break;
			case 'transaction_id' :
				$metaData['_transaction_id'] = $data_array[$ekey];
				break;
			case 'billing_first_name' :
				$metaData['_billing_first_name'] = $data_array[$ekey];
				break;
			case 'billing_last_name' :
				$metaData['_billing_last_name'] = $data_array[$ekey];
				break;
			case 'billing_company' :
				$metaData['_billing_company'] = $data_array[$ekey];
				break;
			case 'billing_address_1' :
				$metaData['_billing_address_1'] = $data_array[$ekey];
				break;
			case 'billing_address_2' :
				$metaData['_billing_address_2'] = $data_array[$ekey];
				break;
			case 'billing_city' :
				$metaData['_billing_city'] = $data_array[$ekey];
				break;
			case 'billing_postcode' :
				$metaData['_billing_postcode'] = $data_array[$ekey];
				break;
			case 'billing_state' :
				$metaData['_billing_state'] = $data_array[$ekey];
				break;
			case 'billing_country' :
				$metaData['_billing_country'] = $data_array[$ekey];
				break;
			case 'billing_phone' :
				$metaData['_billing_phone'] = $data_array[$ekey];
				break;
			case 'billing_email' :
				$metaData['_billing_email'] = $data_array[$ekey];
				break;
			case 'shipping_first_name' :
				$metaData['_shipping_first_name'] = $data_array[$ekey];
				break;
			case 'shipping_last_name' :
				$metaData['_shipping_last_name'] = $data_array[$ekey];
				break;
			case 'shipping_company' :
				$metaData['_shipping_company'] = $data_array[$ekey];
				break;
			case 'shipping_address_1' :
				$metaData['_shipping_address_1'] = $data_array[$ekey];
				break;
			case 'shipping_address_2' :
				$metaData['_shipping_address_2'] = $data_array[$ekey];
				break;
			case 'shipping_city' :
				$metaData['_shipping_city'] = $data_array[$ekey];
				break;
			case 'shipping_postcode' :
				$metaData['_shipping_postcode'] = $data_array[$ekey];
				break;
			case 'shipping_state' :
				$metaData['_shipping_state'] = $data_array[$ekey];
				break;
			case 'shipping_country' :
				$metaData['_shipping_country'] = $data_array[$ekey];
				break;
			case 'customer_user' :
				$metaData['_customer_user'] = $data_array[$ekey];
				break;
			case 'order_currency' :
				$metaData['_order_currency'] = $data_array[$ekey];
				break;
			case 'item_name' :
				$orderItem['order_item_name'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_type' :
				$orderItem['order_item_type'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_product_id' :
				$Item_metaDatas['_product_id'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_variation_id' :
				$Item_metaDatas['_variation_id'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_line_subtotal' :
				$Item_metaDatas['_line_subtotal'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_line_subtotal_tax' :
				$Item_metaDatas['_line_subtotal_tax'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_line_total' :
				$Item_metaDatas['_line_total'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_line_tax' :
				$Item_metaDatas['_line_tax'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_line_tax_data' :
				$Item_metaDatas['_line_tax_data'] = explode('|', $data_array[$ekey]);
				break;
			case 'item_tax_class' :
				$Item_metaDatas['_tax_class'] = explode(',', $data_array[$ekey]);
				break;
			case 'item_qty' :
				$Item_metaDatas['_qty'] = explode(',', $data_array[$ekey]);
				break;
			case 'fee_name' :
				$orderFee['order_item_name'] = explode(',', $data_array[$ekey]);
				break;
			case 'fee_type' :
				$orderFee['order_item_type'] = explode(',', $data_array[$ekey]);
				break;
			case 'fee_tax_class' :
				$Fee_metaDatas['_tax_class'] = explode(',', $data_array[$ekey]);
				break;
			case 'fee_line_total' :
				$Fee_metaDatas['_line_total'] = explode(',', $data_array[$ekey]);
				break;
			case 'fee_line_tax' :
				$Fee_metaDatas['_line_tax'] = explode(',', $data_array[$ekey]);
				break;
			case 'fee_line_tax_data' :
				$Fee_metaDatas['_line_tax_data'] = explode('|', $data_array[$ekey]);
				break;
			case 'fee_line_subtotal' :
				$Fee_metaDatas['_line_subtotal'] = explode(',', $data_array[$ekey]);
				break;
			case 'fee_line_subtotal_tax' :
				$Fee_metaDatas['_line_subtotal_tax'] = explode(',', $data_array[$ekey]);
				break;
			case 'shipment_name' :
				$Shipment_name['order_item_name'] = explode(',', $data_array[$ekey]);
				break;
			case 'shipment_method_id' :
				$Shipment_metaDatas['method_id'] = explode(',', $data_array[$ekey]);
				break;
			case 'shipment_cost' :
				$Shipment_metaDatas['cost'] = explode(',', $data_array[$ekey]);
				break;
			case 'shipment_taxes' :
				$Shipment_metaDatas['taxes'] = explode('|', $data_array[$ekey]);
				break;
				//woocommerce_redunds starting
			case 'refund_amount' :
				$metaData['_refund_amount'] = $data_array[$ekey];
				break;
			case 'order_shipping_tax' :
				$metaData['_order_shipping_tax'] = $data_array[$ekey];
				break;
			case 'order_tax' :
				$metaData['_order_tax'] = $data_array[$ekey];
				break;
			case 'order_shipping' :
				$metaData['_order_shipping'] = $data_array[$ekey];
				break;
			case 'cart_discount' :
				$metaData['_cart_discount'] = $data_array[$ekey];
				break;
			case 'cart_discount_tax' :
				$metaData['_cart_discount_tax'] = $data_array[$ekey];
				break;
			case 'order_total' :
				$metaData['_order_total'] = $data_array[$ekey];
				break;
			default:
				$metaData[$ekey] = $data_array[$ekey];
				$metaData['_subscription_payment_sync_date'] = 'a:2:{s:3:"day";i:0;s:5:"month";i:0;}';
				break;
			}
		}

		if(is_array($orderItem)){	
			foreach ($orderItem['order_item_name'] as $key => $value) {
				$value_order_item[$key]['order_item_name'] = $orderItem['order_item_name'][$key];
				$value_order_item[$key]['order_item_type'] = $orderItem['order_item_type'][$key];
			}
			foreach ($orderItem['order_item_name'] as $key => $value) {
				foreach ($Item_metaDatas as $key1 => $value1) {
					$value_order_item_meta[$key][$key1] = $Item_metaDatas[$key1][$key];
				}
			}
			foreach ($value_order_item as $key => $value) {
				$oid = wc_add_order_item($pID, $value);
				foreach ($value_order_item_meta[$key] as $itemkey => $itemvalue) {
					wc_add_order_item_meta($oid, $itemkey, $itemvalue);
				}
			}
		}

		if(is_array($orderFee)){
			foreach ($orderFee['order_item_name'] as $key => $value) {

				$value_order_fee[$key]['order_item_name'] = $orderFee['order_item_name'][$key];
				$value_order_fee[$key]['order_item_type'] = $orderFee['order_item_type'][$key];
			}
			foreach ($orderFee['order_item_name'] as $key => $value) {
				foreach ($Fee_metaDatas as $key1 => $value1) {
					$value_order_fee_meta[$key][$key1] = $Fee_metaDatas[$key1][$key];
				}
			}
			foreach ($value_order_fee as $key => $value) {
				$oid = wc_add_order_item($pID, $value);
				foreach ($value_order_fee_meta[$key] as $feekey => $feevalue) {
					wc_add_order_item_meta($oid, $feekey, $feevalue);
				}
			}
		}

		if(is_array($Shipment_name)){
			foreach ($Shipment_name['order_item_name'] as $key => $value) {
				$value_shipment[$key]['order_item_name'] = $Shipment_name['order_item_name'][$key];
				$value_shipment[$key]['order_item_type'] = 'shipping';
			}
			foreach ($Shipment_name['order_item_name'] as $key => $value) {
				foreach ($Shipment_metaDatas as $key1 => $value1) {
					$value_shipment_meta[$key][$key1] = $Shipment_metaDatas[$key1][$key];
				}
			}
			foreach ($value_shipment as $key => $value) {
				$oid = wc_add_order_item($pID, $value);
				foreach ($value_shipment_meta[$key] as $shipkey => $shipvalue) {
					wc_add_order_item_meta($oid, $shipkey, $shipvalue);
				}
			}
		}

		if (!empty($customer_email)) {
			$exploded_email = explode(',', $customer_email['customer_email']);
			foreach ($exploded_email as $cus_email) {
				$metaData['customer_email'][] = $cus_email;
			}
		}
		if(!empty($exclude_product)) {
			$exploded_exclude = explode(',', $exclude_product['exclude_product_categories']);
			foreach ($exploded_exclude as $exp_cat) {
				$metaData['exclude_product_categories'][] = $exp_cat;
			}
		}
		if(!empty($product_cate)) {
			$exploded_cate = explode(',', $product_cate['product_categories']);
			foreach ($exploded_cate as $pro_cat) {
				$metaData['product_categories'][] = $pro_cat;
			}
		}
		if (!empty($product_image_gallery)) {
			$exploded_gallery_images = explode('|', $product_image_gallery['product_image_gallery']);
			$image_gallery = '';
			foreach ($exploded_gallery_images as $images) {
				$image_gallery .= $images . ',';
			}
			$Gallery = substr($image_gallery, 0, -1);
			$productImageGallery = $Gallery;
			if ($productImageGallery) {
				$metaData['_product_image_gallery'] = $productImageGallery;
			}
		}
		if (!empty($attribute_names)) {
			$exploded_att_names = explode('|', $attribute_names['product_attribute_name']);	
			foreach ($exploded_att_names as $attr_name) {
				$attri_name = $wpdb->get_results( "SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies where attribute_label = '$attr_name' ");

				if(empty($attri_name)){
					$attribute['name'][] = $attr_name;
				}
				else{
					$attribute['name'][] = 'pa_' . $attri_name[0]->attribute_name;
				}	
			}
		}

		if (!empty($attribute_values)) {
			$exploded_att_values = explode(',', $attribute_values['product_attribute_value']);
			foreach ($exploded_att_values as $attr_val) {
				$attribute['value'][] = $attr_val;
			}
		}
		if (!empty($attribute_visible)) {
			$exploded_att_visible = explode('|', $attribute_visible['product_attribute_visible']);
			foreach ($exploded_att_visible as $attr_visible) {
				$attribute['is_visible'][] = $attr_visible;
			}
		}
		if (!empty($attribute_types)) {
			$exploded_att_type= explode('|', $attribute_types['product_attribute_type']);
			foreach ($exploded_att_type as $attr_type) {
				$attribute['type'][] = $attr_type;
			}
		}
		if (!empty($attribute_variation)) {
			$exploded_att_variation = explode('|', $attribute_variation['product_attribute_variation']);
			foreach ($exploded_att_variation as $attr_variation) {
				$attribute['is_variation'][] = $attr_variation;
			}
		}
		if (!empty($attribute_position)) {
			$exploded_att_position = explode('|', $attribute_position['product_attribute_position']);
			foreach ($exploded_att_position as $attr_position) {
				$attribute['position'][] = $attr_position;
			}
		}
		if(!empty($attribute_taxonomy)) {
			$exploded_att_taxonomy = explode('|', $attribute_taxonomy['product_attribute_taxonomy']);
			foreach ($exploded_att_taxonomy as $attr_taxonomy) {
				$attribute['is_taxonomy'][] = $attr_taxonomy;
			}
		}

		//WooCommerce Product Retailers Fields
		if (!empty($retailer_id)) {
			$exploded_ret_id = explode('|', $retailer_id['wc_product_retailers_id']);
			foreach ($exploded_ret_id as $ret_id) {
				$product_retailer['id'][] = $ret_id;
			}
		}
		if (!empty($retailer_price)) {
			$exploded_ret_price = explode('|', $retailer_price['wc_product_retailers_price']);
			foreach ($exploded_ret_price as $ret_price) {
				$product_retailer['product_price'][] = $ret_price;
			}
		}
		if (!empty($retailer_url)) {
			$exploded_ret_url = explode('|', $retailer_url['wc_product_retailers_url']);
			foreach ($exploded_ret_url as $ret_url) {
				$product_retailer['product_url'][] = $ret_url;
			}
		}
		if (!empty($product_retailer)) {
			$retailers_detail = array();
			$count_value = count($product_retailer['id']);
			for ($at = 0; $at < $count_value; $at++) {
				if (isset($product_retailer['id']) && isset($product_retailer['id'][$at])) {
					$retailers_detail[$product_retailer['id'][$at]]['id'] = $product_retailer['id'][$at];
				}
				if (isset($product_retailer['product_price']) && isset($product_retailer['product_price'][$at])) {
					$retailers_detail[$product_retailer['id'][$at]]['product_price'] = $product_retailer['product_price'][$at];
				}
				if (isset($product_retailer['product_url']) && isset($product_retailer['product_url'][$at])) {
					$retailers_detail[$product_retailer['id'][$at]]['product_url'] = $product_retailer['product_url'][$at];
				}
			}
		}
		if (!empty($retailers_detail)) {
			$metaData['_wc_product_retailers'] = $retailers_detail;
		}

		//WooCommerce Product Add-ons
		if (!empty($product_addons)) {
			$exploded_lab_name = explode('|', $product_addons['product_addons_label_name']);
			$count_lab_name = count($exploded_lab_name);
			for ($i = 0; $i < $count_lab_name; $i++) {
				$exploded_label_name = explode(',', $exploded_lab_name[$i]);
				foreach ($exploded_label_name as $lname) {
					$addons_option['label'][$i][] = $lname;
				}
			}
			$explode_lab_price = explode('|', $product_addons['product_addons_price']);
			$count_lab_price = count($explode_lab_price);
			for ($i = 0; $i < $count_lab_price; $i++) {
				$exploded_price = explode(',', $explode_lab_price[$i]);
				foreach ($exploded_price as $lprice) {

					$addons_option['price'][$i][] = $lprice;
				}
			}
			$expl_min = explode('|', $product_addons['product_addons_minimum']);
			$count_min = count($expl_min);
			for ($i = 0; $i < $count_min; $i++) {
				$exploded_min = explode(',', $expl_min[$i]);
				foreach ($exploded_min as $min) {
					$addons_option['min'][$i][] = $min;
				}
			}
			$expl_mac = explode('|',$product_addons['product_addons_maximum']);
			$count_max = count($expl_mac);
			for($i = 0; $i < $count_max; $i++){
				$exploded_max = explode(',', $expl_mac[$i]);
				foreach ($exploded_max as $max) {
					$addons_option['max'][] = $max;
				}
			}
			if(!empty($addons_option)) {
				$options_array = array();
				$cv = count($addons_option['label']);
				for ($a = 0; $a < $cv; $a++) {
					if (isset($addons_option['label']) && isset($addons_option['label'][$a])){
						$options_array[$a]['label'] =$addons_option['label'][$a];
					}
					if (isset($addons_option['price']) && isset($addons_option['price'][$a])){
						$options_array[$a]['price'] =$addons_option['price'][$a];
					}
					if (isset($addons_option['min']) && isset($addons_option['min'][$a])) {
						$options_array[$a]['min'] =$addons_option['min'][$a];
					}
					if (isset($addons_option['max']) && isset($addons_option['max'][$a])) {
						$options_array[$a]['max'] =$addons_option['max'][$a];
					}
				}
			}
			$exploded_group_name = explode('|', $product_addons['product_addons_group_name']);
			foreach ($exploded_group_name as $gname) {
				$addons['name'][] = $gname;
			}
			$exploded_group_description = explode('|', $product_addons['product_addons_group_description']);
			foreach ($exploded_group_description as $gdes) {
				$addons['description'][] = $gdes;
			}
			$exploded_position = explode('|', $product_addons['product_addons_position']);
			foreach ($exploded_position as $pos) {
				$addons['position'][] = $pos;
			}
			$exploded_type = explode('|', $product_addons['product_addons_type']);
			foreach ($exploded_type as $type) {
				$addons['type'][] = $type;
			}
			$exploded_required = explode('|', $product_addons['product_addons_required']);
			foreach ($exploded_required as $req) {
				$addons['required'][] = $req;
			}
			if(!empty($addons)) {
				$addons_array = array();
				$cnt = count($addons['name']);
				for ($b = 0; $b < $cnt; $b++) {
					if (isset($addons['name']) && isset($addons['name'][$b])) {
						$addons_array[$addons['name'][$b]]['name'] = $addons['name'][$b];
					}
					if (isset($addons['description']) && isset($addons['description'][$b])) {
						$addons_array[$addons['name'][$b]]['description'] = $addons['description'][$b];
					}
					if (isset($addons['type']) && isset($addons['type'][$b])) {
						$addons_array[$addons['name'][$b]]['type'] = $addons['type'][$b];
					}
					if (isset($addons['position']) && isset($addons['position'][$b])) {
						$addons_array[$addons['name'][$b]]['position'] = $addons['position'][$b];
					}
					if (isset($addons_option['label']) && isset($addons_option['label'][$b])){
						for ($i = 0; $i < count($addons_option['label'][$b]); $i++) {
							$addons_array[$addons['name'][$b]]['options'][$i]['label'] = $addons_option['label'][$b][$i];
						}
					}
					if (isset($addons_option['price']) && isset($addons_option['price'][$b])){
						for ($i = 0; $i < count($addons_option['price'][$b]); $i++) {
							$addons_array[$addons['name'][$b]]['options'][$i]['price'] = $addons_option['price'][$b][$i];
						}
					}
					if (isset($addons_option['min']) && isset($addons_option['min'][$b])) {
						for ($i = 0; $i < count($addons_option['min'][$b]); $i++) {
							$addons_array[$addons['name'][$b]]['options'][$i]['min'] = $addons_option['min'][$b][$i];
						}
					}
					if (isset($addons_option['max']) && isset($addons_option['max'][$b])) {
						for ($i = 0; $i < count($addons_option['max'][$b]); $i++) {
							$addons_array[$addons['name'][$b]]['options'][$i]['max'] = $addons_option['max'][$b][$i];
						}
					}
					if (isset($addons['required']) && isset($addons['required'][$b])) {
						$addons_array[$addons['name'][$b]]['required'] =$addons['required'][$b];
					}
				}
			}
			if(!empty($addons_array)) {
				$metaData['_product_addons'] = $addons_array;
			}
		}
		//WooCommerce Warranty Requests
		if (!empty($warranty)) {
			if ($warranty['warranty_type'] == 'included_warranty') {
				$warranty_result['type'] = $warranty['warranty_type'];
				$warranty_result['length'] = $warranty['warranty_length'];
				$warranty_result['value'] = $warranty['warranty_value'];
				$warranty_result['duration'] = $warranty['warranty_duration'];
				$metaData['_warranty'] = $warranty_result;
			}else if ( $warranty['warranty_type'] == 'addon_warranty' ) {
				if($warranty['warranty_addons_amount'] != '') {
					$addon_amt = explode('|', $warranty['warranty_addons_amount']);
					foreach ($addon_amt as $amt) {
						$warranty_addons['amount'][] = $amt;
					}
				}
				if($warranty['warranty_addons_value'] != '') {
					$addon_val = explode('|', $warranty['warranty_addons_value']);
					foreach ($addon_val as $val) {
						$warranty_addons['value'][] = $val;
					}
				}
				if($warranty['warranty_addons_duration'] != '') {
					$addon_dur = explode('|', $warranty['warranty_addons_duration']);
					foreach ($addon_dur as $dur) {
						$warranty_addons['duration'][] = $dur;
					}
				}
				if (!empty($warranty_addons)) {
					$warranty_addons_detail = array();
					$addon_count = count($warranty_addons['amount']);
					for ($ad = 0; $ad < $addon_count; $ad++) {
						if (isset($warranty_addons['amount']) && isset($warranty_addons['amount'][$ad])) {
							$warranty_addons_detail[$warranty_addons['amount'][$ad]]['amount'] = $warranty_addons['amount'][$ad];
						}
						if (isset($warranty_addons['value']) && isset($warranty_addons['value'][$ad])) {
							$warranty_addons_detail[$warranty_addons['amount'][$ad]]['value'] = $warranty_addons['value'][$ad];
						}
						if (isset($warranty_addons['duration']) && isset($warranty_addons['duration'][$ad])) {
							$warranty_addons_detail[$warranty_addons['amount'][$ad]]['duration'] = $warranty_addons['duration'][$ad];
						}
					}
				}
				if (!empty($warranty_addons_detail)) {
					$warranty_result['type'] = $warranty['warranty_type'];
					$warranty_result['addons'] = $warranty_addons_detail;
					$warranty_result['no_warranty_option'] = $warranty['no_warranty_option'];
					$metaData['_warranty'] = $warranty_result;
				}
			}else {
				$metaData['_warranty'] = '';
			}
		}
		//attributes
		if (!empty($attribute)) {
			$product_attributes = $exploded_attribute_value = array();
			if(isset($attribute['name'])) {
				$attr_count = count($attribute['name']);}
			if(isset($attr_count)){
				for ($att = 0; $att < $attr_count; $att++) {
					$attrlabel = $attribute['name'][$att];
					$attrslug = wc_sanitize_taxonomy_name($attrlabel);
					if (isset($attribute['name']) && isset($attribute['name'][$att])) {
						$product_attributes[$attrlabel]['name'] = $attrlabel;
					}
					if (isset($attribute['type']) && isset($attribute['type'][$att])) {
						$product_attributes[$attrlabel]['type'] = $attribute['type'][$att];
					}
					if (isset($attribute['value']) && isset($attribute['value'][$att])) {
						$product_attributes[$attrlabel]['value'] = $attribute['value'][$att];
					} else {
						$product_attributes[$attrlabel]['value'] = '';
					}
					if (isset($attribute['position']) && isset($attribute['position'][$att])){
						$product_attributes[$attrlabel]['position'] = $attribute['position'][$att];
					} else {
						$product_attributes[$attrlabel]['position'] = 0;
					}
					if (isset($attribute['is_visible']) && isset($attribute['is_visible'][$att])) {
						$visible=$attribute['is_visible'][$att];
						$product_attributes[$attrlabel]['is_visible'] = intval($visible);
					}
					else
					{
						$product_attributes[$attrlabel]['is_visible'] = '';
					}

					if (isset($attribute['is_variation']) && isset($attribute['is_variation'][$att])) {
						$variation=$attribute['is_variation'][$att];

						$product_attributes[$attrlabel]['is_variation'] =intval($variation);
					}
					else
					{
						$product_attributes[$attrlabel]['is_variation'] = '';
					}

					if (isset($attribute['is_taxonomy']) && isset($attribute['is_taxonomy'][$att])) {
						$taxonomy=$attribute['is_taxonomy'][$att];
						$product_attributes[$attrlabel]['is_taxonomy'] =intval($taxonomy);
					}
					else
					{
						$product_attributes[$attrlabel]['is_taxonomy'] = 0;
					}

					// product attributes
					if (!empty($product_attributes)) {
						if($import_type == 'WooCommerce Product Variations'){
							$product_detail = $wpdb->get_col($wpdb->prepare("select post_parent from {$wpdb->prefix}posts where ID = %d", $pID));
							if(!empty($product_detail))
								$productID = $product_detail[0];
							else
								$productID = '';

							if($productID != '') {
								$explode_attr = explode('|' , $product_attributes[$attrlabel]['value']);
								$reg_attribute_id = wp_set_object_terms($productID, $explode_attr , $product_attributes[$attrlabel]['name']);
								$product_attributes[$attrlabel]['value'] = '';
								update_post_meta($productID, '_product_attributes', $product_attributes);
							}
						}
						else{
							$metaData['_product_attributes'] = $product_attributes;
						}
						//default attribute for variations
						if(!empty($defAttribute)){
							if($import_type == 'WooCommerce Product Variations'){
								$product_detail = $wpdb->get_col($wpdb->prepare("select post_parent from $wpdb->posts where ID = %d",$pID));
								if(!empty($product_detail))
									$productID = $product_detail[0];
								else
									$productID = '';
								if($productID != ''){
									update_post_meta($productID,'_default_attributes',$defAttribute);
								}
							}
						}
						//custom attribute for variations
						if(!empty($cusAttribute)){
							foreach($cusAttribute as $cusAttkey => $cusAttval){
								$metaData['attribute_'.$cusAttkey] = $cusAttval;
							}
						}

					}

				}
			} // WooCommerce attribute registration ends here
		}
		//start
		if (isset($metaData['_product_attributes']) && !empty($metaData['_product_attributes']) && $import_type !== 'WooCommerce Product Variations') {
			foreach($metaData['_product_attributes'] as $attrKey => $attrVal) {
				$attrVal['name'] = str_replace( 'pa_' , '' , $attrVal['name']);
				$get_attributeLabel = $wpdb->get_results( "SELECT attribute_id, attribute_label FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = '{$attrVal['name']}'" );                                                         

				$attrlabel = trim($attrVal['name']);
				$attrslug = strtolower($attrlabel);
				$attrslug = preg_replace("/[^a-zA-Z0-9._\s]/", "", $attrslug);
				$attrslug = preg_replace('/\s/', '-', $attrslug);
				$custom_attribute_name = "pa_" . $attrslug;
				$attrtypeval = $attrVal['type'];
				if(!empty($attrtypeval)){
					$attrtype = $attrtypeval;
				}
				else{
					$attrtype = 'text';
				}
				$attrordr = 'menu_order';
				$attr_data = $attrVal['value'];
				$get_transistent_atrributes = get_option('_transient_wc_attribute_taxonomies');
				$get_count_transistent_attr = count($get_transistent_atrributes);
				$count_transistent_attr = $get_count_transistent_attr + 1;

				if(!empty($get_transistent_atrributes)){
					foreach($get_transistent_atrributes as $tak => $tav) { 
						$new_trans_attr_list[$tak] = new \stdClass();
						foreach($tav as $attr_reg_key => $attr_reg_val) {
							$new_trans_attr_list[$tak]->$attr_reg_key = $attr_reg_val;
						}
					}
				} 
				if(empty($get_attributeLabel)){
				}else {
					if (is_plugin_active('variation-swatches-for-woocommerce/variation-swatches-for-woocommerce.php')) {	
						$attrId = $get_attributeLabel[0]->attribute_id;
						$custom_attribute_name = 'pa_' . $attrVal['name'];	
						$split_attr_value = explode('>', $attr_data);
						$split_line = explode('|', $split_attr_value[0]);
						$exploded_array = explode('|', $split_attr_value[1]);
						$meta_attr = array_combine($split_line,$exploded_array);
						$reg_attribute_id = wp_set_object_terms($pID, $split_line, $custom_attribute_name);		
						foreach ($meta_attr as $custom_meta => $custom_val){
							$term_meta_id = $wpdb->get_col($wpdb->prepare("select term_id from {$wpdb->prefix}terms where name = %s",$custom_meta));	
							$termmetaid = $term_meta_id[0];
							if(strpos($custom_val, "http://") !== false ){              
								$attachment_id = $wpdb->get_results("select ID from {$wpdb->prefix}posts where guid= '{$custom_val}'" ,ARRAY_A);	
								update_term_meta($termmetaid, 'image' , $attachment_id[0]['ID']);
							}	
							elseif(strpos($custom_val, "https://") !== false ){
								$attachment_id = $wpdb->get_results("select ID from {$wpdb->prefix}posts where guid= '{$custom_val}'" ,ARRAY_A);
								update_term_meta($termmetaid, 'image' , $attachment_id[0]['ID']);

							}		
							elseif(strpos($custom_val, "#") !== false ){
								update_term_meta($termmetaid, 'color' , $custom_val);
							}
							else{
								update_term_meta($termmetaid, 'label' , $custom_val);
							}							
						}
					}
					else{
						$attrId = $get_attributeLabel[0]->attribute_id;
						$custom_attribute_name = 'pa_' . $attrVal['name'];	
						$split_line = explode('|', $attr_data);
						$reg_attribute_id = wp_set_object_terms($pID, $split_line, $custom_attribute_name);
						$metaData['_product_attributes'][$attrKey]['value'] = '';
					}
				}                
			}
		}	

		//end 
		// Insert all meta information
		foreach ($metaData as $meta_key => $meta_value) {
			update_post_meta($pID, $meta_key, $meta_value);
		}
	}

}

