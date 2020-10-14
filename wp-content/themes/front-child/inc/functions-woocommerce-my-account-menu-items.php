<?php
// Removes items from the woocommerce my-account navigation https://rudrastyh.com/woocommerce/my-account-menu.html
add_filter ( 'woocommerce_account_menu_items', 'cosmos_remove_my_account_links' );
function cosmos_remove_my_account_links( $menu_links ){
	unset( $menu_links['edit-address'] ); // Addresses
	unset( $menu_links['payment-methods'] ); // Remove Payment Methods
	unset( $menu_links['orders'] ); // Remove Orders
	unset( $menu_links['downloads'] ); // Disable Downloads
	//unset( $menu_links['edit-account'] ); // Remove Account details tab
	//unset( $menu_links['customer-logout'] ); // Remove Logout link
	//unset( $menu_links['dashboard'] ); // Remove Dashboard
	return $menu_links;
}

// Changes the name of the woocommerce menu items
// add_filter ( 'woocommerce_account_menu_items', 'cosmos_rename_menu_items' );
// function cosmos_rename_menu_items( $menu_links ){
// 	// $menu_links['TAB ID HERE'] = 'NEW TAB NAME HERE';
// 	$menu_links['downloads'] = 'My Files';
// 	return $menu_links;
// }

// TAS https://rudrastyh.com/woocommerce/my-account-menu.html
// add_action( 'init', 'cosmos_add_endpoint' );
// function cosmos_add_endpoint() {
// 	add_rewrite_endpoint( 'candidate-dashboard', EP_PAGES );
// }

// Adds the content to the endpoints https://rudrastyh.com/woocommerce/my-account-menu.html
// add_action( 'woocommerce_account_log-history_endpoint', 'cosmos_my_account_endpoint_content' );
// function cosmos_my_account_endpoint_content() {
// 	echo 'Last time you logged in: yesterday from Safari.';
// }	


?>

