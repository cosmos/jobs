<?php
/**
 * Import Users plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMUSERS;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class UserInstall {

	protected static $instance = null,$smack_instance,$tables_instance;
	private static $db_updates = array();
	/**
	 * SmackCSVInstall Constructor
	 */
	public function __construct() {
		$this->plugin = Plugin::getInstance();
	}

	/**
	 * SmackCSVInstall Instance
	 */
	public static function getInstance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
			self::$smack_instance = new UserInstall();
		}
		return self::$instance;
	}

	/**
	 * @param $links
	 *
	 * @return array
	 */
	public function smack_uci_action_links( $links ) {
		$links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=sm-uci-settings') ) .'">Settings</a>';
		$links[] = '<a href="http://wp-buddy.com" target="_blank">More plugins by WP-Buddy</a>';
		return $links;
	}

	/**
	 * Show row meta on the plugin screen.
	 *
	 * @param       mixed $links Plugin Row Meta
	 * @param       mixed $file  Plugin Base file
	 * @return      array
	 */
	public function plugin_row_meta( $links, $file ) {
		$active_plugins = get_option('active_plugins');
		if(in_array('wp-ultimate-csv-importer/wp-ultimate-csv-importer.php', $active_plugins)){
			return $links;
		}
		else{
		$row_meta = array(
			'install_csv_importer' => '<a style="font-weight: bold;color: #d54e21;font-size: 105%;" href="' . esc_url( apply_filters( 'install_csv_importer',  'https://wordpress.org/plugins/wp-ultimate-csv-importer/' ) ) . '" title="' . esc_attr( __( 'Install CSV Importer', 'wp-ultimate-csv-importer' ) ) . '" target="_blank">' . __( 'Install CSV Importer', 'wp-ultimate-csv-importer' ) . '</a>'
	);

		return array_merge( $row_meta, $links );
	}
	}

}
