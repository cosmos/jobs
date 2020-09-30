<?php
// Removes items from the woocommerce my-account navigation
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

// Adds woocommerce links to the my-account navigation
add_filter ( 'woocommerce_account_menu_items', 'cosmos_log_history_link', 40 );
function cosmos_log_history_link( $menu_links ){
	$menu_links = array_slice( $menu_links, 0, 5, true ) 
	+ array( 'candidate-dashboard' => 'Contributor Dashboard' )
	+ array_slice( $menu_links, 5, NULL, true );
	return $menu_links;
}

// TAS 
// add_action( 'init', 'cosmos_add_endpoint' );
// function cosmos_add_endpoint() {
// 	add_rewrite_endpoint( 'candidate-dashboard', EP_PAGES );
// }

add_action( 'woocommerce_account_log-history_endpoint', 'cosmos_my_account_endpoint_content' );
function cosmos_my_account_endpoint_content() {
	echo 'Last time you logged in: yesterday from Safari.';
}