<?php
/**
 * WP Ultimate CSV Importer.
 *
 * WP Ultimate CSV Importer plugin file.
 *
 * @package   Smackcoders\FCSV
 * @copyright Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 or higher
 *
 * @wordpress-plugin
 * Plugin Name: WP Ultimate CSV Importer
 * Version:     6.1.9
 * Plugin URI:  https://www.smackcoders.com/wp-ultimate-csv-importer-pro.html
 * Description: Seamlessly create posts, custom posts, pages, media, SEO and more from your CSV data with ease.
 * Author:      Smackcoders
 * Author URI:  https://www.smackcoders.com/wordpress.html
 * Text Domain: wp-ultimate-csv-importer
 * Domain Path: /languages
 * License:     GPL v3
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

include_once('Plugin.php');

include_once('extensionModules/MappingExtension.php');
include_once('SmackCSVImporterInstall.php');
include_once('languages/LangIT.php');
include_once('languages/LangEN.php');
include_once('languages/LangGE.php');
include_once('languages/LangFR.php');
include_once('languages/LangRU.php');
include_once('languages/LangPT.php');
include_once('languages/LangTR.php');
include_once('languages/LangES.php');
include_once('languages/LangJA.php');
include_once('languages/LangNL.php');
include_once('languages/LangenGB.php');
include_once('languages/LangenCA.php');
include_once('languages/LangenZA.php');
include_once('Tables.php');
include_once('SmackCSVImporterUninstall.php');
include_once('InstallAddons.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('wp-ultimate-csv-importer/wp-ultimate-csv-importer.php')) {

	$plugin_pages = ['com.smackcoders.csvimporternew.menu'];
	define('FCSVPLUGINDIR', plugin_dir_path(__FILE__));
	include __DIR__ . '/wp-csv-hooks.php';
	global $plugin_ajax_hooks;

	$request_page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
	$request_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	
	if (in_array($request_page, $plugin_pages) || in_array($request_action, $plugin_ajax_hooks)) {
		$extension_uploader = glob( __DIR__ . '/extensionUploader/*.php');
		foreach ($extension_uploader as $extension_upload_value) {
			include_once($extension_upload_value);
		}

		$upload_modules = glob( __DIR__ . '/uploadModules/*.php');
		foreach ($upload_modules as $upload_module_value) {
			include_once($upload_module_value);
		}

		$extension_modules = glob( __DIR__ . '/extensionModules/*.php');
		foreach ($extension_modules as $extension_module_value) {
			include_once($extension_module_value);
		}

		$manager_extension = glob( __DIR__ . '/managerExtensions/*.php');
		foreach ($manager_extension as $manager_extension_value) {
			include_once($manager_extension_value);
		}

		$import_extensions = glob( __DIR__ . '/importExtensions/*.php');
		foreach ($import_extensions as $import_extension_value) {
			include_once($import_extension_value);
		}

		$export_extensions = glob( __DIR__ . '/exportExtensions/*.php');
		foreach ($export_extensions as $export_extension_value) {
			include_once($export_extension_value);
		}

		include_once('SaveMapping.php');
		include_once('MediaHandling.php');
		include_once('ImportConfiguration.php');
		include_once('Dashboard.php');
		include_once('DragandDropExtension.php');
		include_once('controllers/DBOptimizer.php');
		include_once('controllers/SendPassword.php');
		include_once('controllers/SupportMail.php');
		include_once('controllers/Security.php');
	}
}
class SmackCSV extends MappingExtension{

	protected static $instance = null;
	private static $table_instance = null;
	private static $desktop_upload_instance = null;
	private static $url_upload_instance = null;
	private static $xml_instance = null;
	protected static $mapping_instance = null;
	private static $extension_instance = null;
	private static $save_mapping_instance = null;
	private static $plugin_instance = null;
	private static $import_config_instance = null;
	private static $dashboard_instance = null;
	private static $drag_drop_instance = null;
	private static $log_manager_instance = null;
	private static $media_instance = null;
	private static $db_optimizer = null;
	private static $send_password = null ; 
	private static $security = null ;
	private static $support_instance = null ;
	private static $uninstall = null ;
	private static $install = null ;
	private static $export_instance = null ;
	private static $en_instance = null ;
	private static $en_CA_instance = null ;
	private static $en_GB_instance = null ;
	private static $italy_instance = null ;
	private static $france_instance = null ;
	private static $german_instance = null ;
	private static $spanish_instance = null;
	private static $russian_instance = null;
	private	static $portuguese_instance = null;
	private static $turkish_instance = null;
	private static $japanese_instance = null;
    private static $dutch_instance = null;
	private static $en_ZA_instance = null;
	private static $addon_instance = null;
	public $version = '6.1.9';

	public function __construct(){ 
		add_action('init', array(__CLASS__, 'show_admin_menus'));
	}

	public static function show_admin_menus(){
		$ucisettings = get_option('sm_uci_pro_settings');
		if( is_user_logged_in() ) {
			$user = wp_get_current_user();
			$role = ( array ) $user->roles;
		} 
		if(!empty($role) && !empty($role[0]=='administrator')){
			if ( is_user_logged_in() &&  current_user_can('administrator') ) {
				add_action('admin_menu',array(__CLASS__,'testing_function'));
			}
		}else{
			if ( is_user_logged_in() && ( current_user_can( 'author') || current_user_can('editor') ) && $ucisettings['author_editor_access'] == "true" ) {
				add_action('admin_menu',array(__CLASS__,'editor_menu'));
			}
		}

		$first_activate = get_option("WP_ULTIMATE_CSV_FIRST_ACTIVATE");
		if($first_activate == 'On'){
			delete_option("WP_ULTIMATE_CSV_FIRST_ACTIVATE");	
			exit(wp_redirect(admin_url().'admin.php?page=wp-addons-page'));
		}
	}

	public static function getInstance() {
		if (SmackCSV::$instance == null) {
			SmackCSV::$instance = new SmackCSV;
			SmackCSV::$addon_instance = InstallAddons::getInstance();
			SmackCSV::$table_instance = Tables::getInstance();
			SmackCSV::$desktop_upload_instance = DesktopUpload::getInstance(); 
			SmackCSV::$url_upload_instance = UrlUpload::getInstance(); 
			SmackCSV::$xml_instance = XmlHandler::getInstance();
			SmackCSV::$mapping_instance = MappingExtension::getInstance();
			SmackCSV::$extension_instance = new ExtensionHandler;
			SmackCSV::$save_mapping_instance = SaveMapping::getInstance();
			SmackCSV::$media_instance = MediaHandling::getInstance();
			SmackCSV::$import_config_instance = ImportConfiguration::getInstance();
			SmackCSV::$dashboard_instance = Dashboard::getInstance();
			SmackCSV::$drag_drop_instance = DragandDropExtension::getInstance();
			SmackCSV::$log_manager_instance = LogManager::getInstance();
			SmackCSV::$plugin_instance = Plugin::getInstance();
			SmackCSV::$db_optimizer = DBOptimizer::getInstance();
			SmackCSV::$send_password = SendPassword::getInstance();
			SmackCSV::$security = Security::getInstance();
			SmackCSV::$support_instance = SupportMail::getInstance();
			SmackCSV::$uninstall = SmackUCIUnInstall::getInstance();
			SmackCSV::$install = SmackCSVInstall::getInstance();
			SmackCSV::$export_instance = ExportExtension::getInstance();
			SmackCSV::$italy_instance = LangIT::getInstance();
			SmackCSV::$france_instance = LangFR::getInstance();
			SmackCSV::$german_instance = LangGE::getInstance();
			SmackCSV::$en_instance = LangEN::getInstance();
			SmackCSV::$en_CA_instance = LangEN_CA::getInstance();
			SmackCSV::$en_GB_instance = LangEN_GB::getInstance();
			SmackCSV::$spanish_instance = LangES::getInstance();
			SmackCSV::$russian_instance = LangRU::getInstance();
			SmackCSV::$portuguese_instance = LangPT::getInstance();
			SmackCSV::$japanese_instance = LangJA::getInstance();
			SmackCSV::$dutch_instance = LangNL::getInstance();
			SmackCSV::$turkish_instance = LangJA::getInstance();
			SmackCSV::$en_ZA_instance = LangEN_ZA::getInstance();
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ),  array(SmackCSV::$install, 'plugin_row_meta'), 10, 2 );
			add_filter('https_local_ssl_verify', '__return_false' );
			add_filter('https_ssl_verify', '__return_false');
			add_filter('http_request_args', array(__CLASS__, 'curlArgs'));
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			if ( is_plugin_active('wp-ultimate-csv-importer-pro/wp-ultimate-csv-importer-pro.php') ) {
				add_action( 'admin_notices', array( SmackCSV::$install, 'wp_ultimate_csv_importer_notice' ) );
				add_action( 'admin_notices', array(SmackCSV::$install, 'important_cron_notice') );
			}
			self::init_hooks();
			
            
			return SmackCSV::$instance;
		}
		return SmackCSV::$instance;
	}


	public static function init_hooks() {																																												
		$ucisettings = get_option('sm_uci_pro_settings');
		if(isset($ucisettings['enable_main_mode']) && $ucisettings['enable_main_mode'] == 'true') {
			add_action( 'admin_bar_menu', array(SmackCSV::$instance,'admin_bar_menu'));
			add_action('wp_head', array(SmackCSV::$instance,'activate_maintenance_mode'));		
		}
		register_deactivation_hook( __FILE__, array( SmackCSV::$uninstall, 'unInstall' ) );
	}

	public static function testing_function (){
		remove_menu_page('com.smackcoders.csvimporternew.menu');
		$my_page = add_menu_page('Ultimate CSV Importer Free', 'Ultimate CSV Importer Free', 'manage_options',
			'com.smackcoders.csvimporternew.menu',array(__CLASS__,'menu_testing_function'),plugins_url("assets/images/wp-ultimate-csv-importer.png",__FILE__));
			add_submenu_page( "com.smackcoders.csvimporternew.menu", "Recommended Addons", '<span style="color:#00a699">'.__('Recommended Addons').'</span>', "manage_options", "wp-addons-page", array(__CLASS__,'importer_addons_page') );
			add_submenu_page( "com.smackcoders.csvimporternew.menu", "Upgrade to PRO", '<span style="color:#00a699">'.__('Upgrade to PRO').'</span>', "manage_options", "wp-pro-page", array(__CLASS__,'importer_pro_page') );
			add_submenu_page( "com.smackcoders.csvimporternew.menu", "Hire Us", '<span style="color:#00a699">'.__('HIRE US').'</span>', "manage_options", "wp-hireus-page", array(__CLASS__,'importer_hireus_page') );
			
			add_action('load-'.$my_page, array(__CLASS__, 'load_admin_js'));
	}

	public static function importer_pro_page() {
		include_once('upgrade-to-pro.php');
	}

	public static	function importer_hireus_page() {		
		include_once('hire-us.php');
	}

	public static function importer_addons_page(){
		include_once('recommended-addons.php');
	}

	public static function load_admin_js() {
		add_action('admin_enqueue_scripts',array(__CLASS__,'csv_enqueue_function'));
	}

	public function editor_menu (){
		
		remove_menu_page('com.smackcoders.csvimporternew.menu');
		$my_page = add_menu_page('Ultimate CSV Importer Free', 'Ultimate CSV Importer Free', '2',
			'com.smackcoders.csvimporternew.menu',array(__CLASS__,'menu_testing_function'),plugins_url("assets/images/wp-ultimate-csv-importer.png",__FILE__));
			add_action('load-'.$my_page, array(__CLASS__, 'load_admin_js'));
	}

	public static function menu_testing_function(){
		?><div id="wp-csv-importer-admin"></div><?php
	}

	public function curlArgs($response) {
        $response['sslverify'] = false;
        return $response;
	}
	
	public static function csv_enqueue_function(){
		$upload = wp_upload_dir();
		$upload_base_url = $upload['baseurl'];       
		wp_register_script(SmackCSV::$plugin_instance->getPluginSlug().'jquery-ui-js',plugins_url( 'assets/js/deps/jquery-ui.min.js', __FILE__), array('jquery'));
		wp_enqueue_script(SmackCSV::$plugin_instance->getPluginSlug().'jquery-ui-js');
		wp_register_script(SmackCSV::$plugin_instance->getPluginSlug().'popper',plugins_url( 'assets/js/deps/popper.js', __FILE__), array('jquery'));
		wp_enqueue_script(SmackCSV::$plugin_instance->getPluginSlug().'popper');
		wp_register_script(SmackCSV::$plugin_instance->getPluginSlug().'bootstrap',plugins_url( 'assets/js/deps/bootstrap.min.js', __FILE__), array('jquery'));
		wp_enqueue_script(SmackCSV::$plugin_instance->getPluginSlug().'bootstrap');
		wp_register_script(SmackCSV::$plugin_instance->getPluginSlug().'main-js',plugins_url( 'assets/js/deps/main.js', __FILE__), array('jquery'));
		wp_enqueue_script(SmackCSV::$plugin_instance->getPluginSlug().'main-js');
		wp_register_script(SmackCSV::$plugin_instance->getPluginSlug().'file-tree',plugins_url( 'assets/js/deps/jQueryFileTree.min.js', __FILE__), array('jquery'));
		wp_enqueue_script(SmackCSV::$plugin_instance->getPluginSlug().'file-tree');
		wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug().'script_csv_importer', 'wpr_object', array('imagePath' => plugins_url('/assets/images/', __FILE__)  ));
		$upload_url = $upload_base_url . '/smack_uci_uploads/imports';
		wp_enqueue_style(SmackCSV::$plugin_instance->getPluginSlug().'bootstrap-css', plugins_url( 'assets/css/deps/bootstrap.min.css', __FILE__));
		wp_enqueue_style(SmackCSV::$plugin_instance->getPluginSlug().'filepond-css', plugins_url( 'assets/css/deps/filepond.min.css', __FILE__));
		wp_enqueue_style(SmackCSV::$plugin_instance->getPluginSlug().'react-datepicker-css', plugins_url( 'assets/css/deps/react-datepicker.css', __FILE__));
		wp_enqueue_style(SmackCSV::$plugin_instance->getPluginSlug().'react-toasty-css', plugins_url( 'assets/css/deps/ReactToastify.min.css', __FILE__));	
		wp_enqueue_style(SmackCSV::$plugin_instance->getPluginSlug().'csv-importer-css', plugins_url( 'assets/css/deps/csv-importer-free.css', __FILE__));
		wp_enqueue_style(SmackCSV::$plugin_instance->getPluginSlug() . 'style-css', plugins_url('assets/css/deps/style.css', __FILE__));
		wp_register_script(SmackCSV::$plugin_instance->getPluginSlug().'main-js',plugins_url( 'assets/js/deps/main.js', __FILE__), array('jquery'));
		wp_enqueue_script(SmackCSV::$plugin_instance->getPluginSlug().'main-js');
		wp_register_script(SmackCSV::$plugin_instance->getPluginSlug().'script_csv_importer',plugins_url( 'assets/js/admin-v6.1.js', __FILE__), array('jquery'));
		wp_enqueue_script(SmackCSV::$plugin_instance->getPluginSlug().'script_csv_importer');
		$language = get_locale();
		if($language == 'it_IT'){
			$contents = SmackCSV::$italy_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug().'script_csv_importer', 'wpr_object', array( 'file' => $response,__FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif($language == 'fr_FR' || $language == 'fr_BE'){
			$contents = SmackCSV::$france_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug().'script_csv_importer', 'wpr_object', array( 'file' => $response,__FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif($language == 'de_DE' || $language == 'de_AT'){
			$contents = SmackCSV::$german_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug().'script_csv_importer', 'wpr_object', array( 'file' => $response,__FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif ($language == 'es_ES') {
			$contents = SmackCSV::$spanish_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif ($language == 'en_CA') {
			$contents = SmackCSV::$en_CA_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif ($language == 'en_GB') {
			$contents = SmackCSV::$en_GB_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif ($language == 'tr_TR') {
			$contents = SmackCSV::$turkish_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif ($language == 'en_ZA') {
			$contents = SmackCSV::$en_ZA_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif ($language == 'ru_RU') {
			$contents = SmackCSV::$russian_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif($language == 'pt_BR') {
			$contents = SmackCSV::$portuguese_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
		elseif ($language == 'ja') {
            $contents = SmackCSV::$japanese_instance->contents();
            $response = wp_json_encode($contents);
            wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
        }
        elseif ($language == 'nl_NL') {
            $contents = SmackCSV::$dutch_instance->contents();
            $response = wp_json_encode($contents);
            wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug() . 'script_csv_importer', 'wpr_object', array('file' => $response, __FILE__, 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
        }
		else{
			$contents = SmackCSV::$en_instance->contents();
			$response = wp_json_encode($contents);
			wp_localize_script(SmackCSV::$plugin_instance->getPluginSlug().'script_csv_importer', 'wpr_object', array( 'file' => $response,__FILE__ , 'imagePath' => plugins_url('/assets/images/', __FILE__),'logfielpath' => $upload_url));
		}
	}


	/**
	 * Generates unique key for each file.
	 * @param string $value - filename
	 * @return string hashkey
	 */
	public function convert_string2hash_key($value) {
		$file_name = hash_hmac('md5', "$value" . time() , 'secret');
		return $file_name;
	}


	/**
	 * Creates a folder in uploads.
	 * @return string path to that folder
	 */
	public function create_upload_dir(){

		$upload = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		if(!is_dir($upload_dir)){
			return false;
		}else{
			$upload_dir = $upload_dir . '/smack_uci_uploads/imports/';	
			if (!is_dir($upload_dir)) {
				wp_mkdir_p( $upload_dir);
			}
			chmod($upload_dir, 0777);		
			return $upload_dir;
		}
		chmod($upload_dir, 0777);		
		return $upload_dir;
	}

	public function delete_image_schedule()
	{

		global $wpdb;
		$wpdb->get_results("DELETE FROM {$wpdb->prefix}ultimate_csv_importer_shortcode_manager");
	}

	public function image_schedule()
	{

		global $wpdb;
		$get_result = $wpdb->get_results("SELECT DISTINCT post_id FROM {$wpdb->prefix}ultimate_csv_importer_shortcode_manager", ARRAY_A);
		$records = array_column($get_result, 'post_id');

		foreach ($records as $title => $id) {
			$core_instance = CoreFieldsImport::getInstance();
			$post_id = $core_instance->image_handling($id);
		}
	}

	public function admin_bar_menu(){
		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array(
			'id'     => 'debug-bar',
			'href' => admin_url().'admin.php?page=com.smackcoders.csvimporternew.menu',
			'parent' => 'top-secondary',
			'title'  => apply_filters( 'debug_bar_title', __('Maintenance Mode', 'ultimate-maintenance-mode') ),
			'meta'   => array( 'class' => 'smack-main-mode' ),
		) );
	}

	public function activate_maintenance_mode() { 
		include(ABSPATH . "wp-includes/pluggable.php");
		global $maintainance_text;
		$maintainance_text = "Site is under maintenance mode. Please wait few min!";
		if(!current_user_can('manage_options')) {
?> 
			<div class="main-mode-front"> <span> <?php echo $maintainance_text; ?> </span> </div> 
<?php }
	} 
}

global $csv_class;
$csv_class = new SmackCSV();

$activate_plugin = new SmackCSVInstall();
register_activation_hook( __FILE__, array($activate_plugin,'install'));
add_action( 'plugins_loaded', 'Smackcoders\\FCSV\\onpluginsload' );

function onpluginsload(){
	$plugin_pages = ['com.smackcoders.csvimporternew.menu'];
  include __DIR__ . '/wp-csv-hooks.php';
	global $plugin_ajax_hooks;
		
	$request_page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
	$request_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	if (in_array($request_page, $plugin_pages) || in_array($request_action, $plugin_ajax_hooks)) {	
		$plugin = SmackCSV::getInstance();	
	}
}

?>