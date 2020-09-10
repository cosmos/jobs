<?php
/**
 * Plugin Name: WP Job Manager - Bookmarks
 * Plugin URI: https://wpjobmanager.com/add-ons/bookmarks/
 * Description: Allow logged in candidates and employers to bookmark jobs and resumes along with an added note.
 * Version: 1.4.1
 * Author: Automattic
 * Author URI: https://wpjobmanager.com
 * Requires at least: 4.1
 * Tested up to: 4.9
 *
 * WPJM-Product: wp-job-manager-bookmarks
 *
 * Copyright: 2018 Automattic
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Job_Manager_Bookmarks class.
 */
class WP_Job_Manager_Bookmarks {
	const JOB_MANAGER_CORE_MIN_VERSION = '1.29.0';

	/**
	 * Constructor
	 */
	public function __construct() {
		// Define constants
		define( 'JOB_MANAGER_BOOKMARKS_VERSION', '1.4.1' );
		define( 'JOB_MANAGER_BOOKMARKS_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'JOB_MANAGER_BOOKMARKS_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

		// Activate
		register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), array( $this, 'install' ) );

		// Set up startup actions
		add_action( 'plugins_loaded', array( $this, 'load_text_domain' ), 12 );
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ), 13 );
		add_action( 'admin_notices', array( $this, 'version_check' ) );
		add_action( 'job_manager_shortcodes', array( $this, 'maybe_add_bookmark_shortcodes' ) );
	}

	/**
	 * Initializes plugin.
	 */
	public function init_plugin() {
		if ( ! class_exists( 'WP_Job_Manager' ) ) {
			return;
		}

		// Add actions
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'wp', array( $this, 'bookmark_handler' ) );
		add_action( 'single_job_listing_meta_after', array( $this, 'bookmark_form' ) );
		add_action( 'single_resume_start', array( $this, 'bookmark_form' ) );
		add_shortcode( 'my_bookmarks', array( $this, 'my_bookmarks' ) );
		add_filter( 'post_class', array( $this, 'already_bookmarked_post_class' ), 20, 2 );
	}

	/**
	 * Localisation
	 */
	public function load_text_domain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'wp-job-manager-bookmarks' );
		load_textdomain( 'wp-job-manager-bookmarks', WP_LANG_DIR . "/wp-job-manager-bookmarks/wp-job-manager-bookmarks-$locale.mo" );
		load_plugin_textdomain( 'wp-job-manager-bookmarks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Checks WPJM core version.
	 */
	public function version_check() {
		if ( ! class_exists( 'WP_Job_Manager' ) || ! defined( 'JOB_MANAGER_VERSION' ) ) {
			$screen = get_current_screen();
			if ( null !== $screen && 'plugins' === $screen->id ) {
				$this->display_error( __( '<em>WP Job Manager - Bookmarks</em> requires WP Job Manager to be installed and activated.', 'wp-job-manager-bookmarks' ) );
			}
		} elseif (
			/**
			 * Filters if WPJM core's version should be checked.
			 *
			 * @since 1.3.0
			 *
			 * @param bool   $do_check                       True if the add-on should do a core version check.
			 * @param string $minimum_required_core_version  Minimum version the plugin is reporting it requires.
			 */
			apply_filters( 'job_manager_addon_core_version_check', true, self::JOB_MANAGER_CORE_MIN_VERSION )
			&& version_compare( JOB_MANAGER_VERSION, self::JOB_MANAGER_CORE_MIN_VERSION, '<' )
		) {
			$this->display_error( sprintf( __( '<em>WP Job Manager - Bookmarks</em> requires WP Job Manager %s (you are using %s).', 'wp-job-manager-bookmarks' ), self::JOB_MANAGER_CORE_MIN_VERSION, JOB_MANAGER_VERSION ) );
		}
	}

	/**
	 * Display error message notice in the admin.
	 *
	 * @param string $message
	 */
	private function display_error( $message ) {
		echo '<div class="error">';
		echo '<p>' . $message . '</p>';
		echo '</div>';
	}

	/**
	 * frontend_scripts function.
	 *
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {
		wp_register_script( 'wp-job-manager-bookmarks-bookmark-js', JOB_MANAGER_BOOKMARKS_PLUGIN_URL . '/assets/js/bookmark.min.js', array( 'jquery' ), JOB_MANAGER_BOOKMARKS_VERSION, true );
		wp_register_style( 'wp-job-manager-bookmarks-frontend', JOB_MANAGER_BOOKMARKS_PLUGIN_URL . '/assets/css/frontend.css', array(), JOB_MANAGER_BOOKMARKS_VERSION );

		wp_localize_script( 'wp-job-manager-bookmarks-bookmark-js', 'job_manager_bookmarks', array(
			'i18n_confirm_delete'  => __( 'Are you sure you want to delete this bookmark?', 'wp-job-manager-bookmarks' ),
			'i18n_add_bookmark'    => __( 'Add Bookmark', 'wp-job-manager-bookmarks' ),
			'i18n_update_bookmark' => __( 'Update Bookmark', 'wp-job-manager-bookmarks' ),
			'spinner_url'          => includes_url( 'images/spinner.gif' ),
		) );
	}

	/**
	 * Install
	 */
	public function install() {
		global $wpdb;

		$wpdb->hide_errors();

		$collate = '';
	    if ( $wpdb->has_cap( 'collation' ) ) {
			if( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
	    }

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	    $sql = "
CREATE TABLE {$wpdb->prefix}job_manager_bookmarks (
  id bigint(20) NOT NULL auto_increment,
  user_id bigint(20) NOT NULL,
  post_id bigint(20) NOT NULL,
  bookmark_note longtext NULL,
  date_created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) $collate;
";
	    dbDelta( $sql );
	}

	/**
	 * Get a user's bookmarks
	 * @param  integer $user_id
	 * @param  integer $limit
	 * @param  integer $offset
	 * @param  string  $orderby_key
	 * @param  string  $order_dir
	 * @return array|object
	 */
	public function get_user_bookmarks( $user_id = 0, $limit = 0, $offset = 0, $orderby_key = 'date', $order_dir = 'ASC' ) {
		global $wpdb;

		if ( ! $user_id && is_user_logged_in() ) {
			$user_id = get_current_user_id();
		} elseif ( ! $user_id ) {
			return false;
		}

		$order_options = array(
			'date'       => '`bm`.`date_created`',
			'post_title' => '`p`.`post_title`',
			'post_date'  => '`p`.`post_date`',
		);

		$order_by = $order_options['date'];
		if ( isset( $order_options[ $orderby_key ] ) ) {
			$order_by = $order_options[ $orderby_key ];
		}

		$order_dir = in_array( strtoupper( $order_dir ), array( 'ASC', 'DESC' ), true ) ? strtoupper( $order_dir ) : 'ASC';

		if ( $limit > 0 ) {
			$sql_query = $wpdb->prepare( "SELECT SQL_CALC_FOUND_ROWS `bm`.* FROM `{$wpdb->prefix}job_manager_bookmarks` `bm` " .
							"LEFT JOIN `{$wpdb->posts}` `p` ON `bm`.`post_id`=`p`.`ID` " .
							"WHERE `user_id` = %d  AND `p`.`post_status` = 'publish' " .
							"ORDER BY {$order_by} {$order_dir} ".
							"LIMIT %d, %d;", $user_id, $offset, $limit );
			$results     = $wpdb->get_results( $sql_query );
			$max_results = $wpdb->get_var( "SELECT FOUND_ROWS()" );

			return (object) array(
				'max_found_rows' => $max_results,
				'max_num_pages'  => ceil( $max_results / $limit ),
				'results'        => $results
			);
		} else {
			$sql_query = $wpdb->prepare( "SELECT `bm`.* FROM `{$wpdb->prefix}job_manager_bookmarks` `bm` " .
										 "LEFT JOIN `{$wpdb->posts}` `p` ON `bm`.`post_id`=`p`.`ID` " .
										 "WHERE `user_id` = %d AND `p`.`post_status` = 'publish' " .
										 "ORDER BY {$order_by} {$order_dir}", $user_id );
			return $wpdb->get_results( $sql_query );
		}
	}

	/**
	 * See if a post is bookmarked by ID
	 * @param  int post ID
	 * @return boolean
	 */
	public function is_bookmarked( $post_id ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$wpdb->prefix}job_manager_bookmarks WHERE post_id = %d AND user_id = %d;", $post_id, get_current_user_id() ) ) ? true : false;
	}

	/**
	 * Get the total number of bookmarks for a post by ID
	 * @param  int $post_id
	 * @return int
	 */
	public function bookmark_count( $post_id ) {
		global $wpdb;

		if ( false === ( $bookmark_count = get_transient( 'bookmark_count_' . $post_id ) ) ) {
			$bookmark_count = absint( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( id ) FROM {$wpdb->prefix}job_manager_bookmarks WHERE post_id = %d;", $post_id ) ) );
			set_transient( 'bookmark_count_' . $post_id, $bookmark_count, YEAR_IN_SECONDS );
		}

		return absint( $bookmark_count );
	}

	/**
	 * Get a bookmark's note
	 * @param  int post ID
	 * @return string
	 */
	public function get_note( $post_id ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT bookmark_note FROM {$wpdb->prefix}job_manager_bookmarks WHERE post_id = %d AND user_id = %d;", $post_id, get_current_user_id() ) );
	}

	/**
	 * Handle the book mark form
	 */
	public function bookmark_handler() {
		global $wpdb;

		if ( ! is_user_logged_in() ) {
			return;
		}

		$action_data = null;

		if ( ! empty( $_POST['submit_bookmark'] ) ) {
			if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'update_bookmark' ) ) {
				$action_data = array(
					'error_code' => 400,
					'error' => __( 'Bad request', 'wp-job-manager-bookmarks' ),
				);
			} else {
				$post_id = absint( $_POST[ 'bookmark_post_id' ] );
				$note    = wp_kses_post( stripslashes( $_POST[ 'bookmark_notes' ] ) );

				if ( $post_id && in_array( get_post_type( $post_id ), array( 'job_listing', 'resume' ) ) ) {
					if ( ! $this->is_bookmarked( $post_id ) ) {
						$wpdb->insert(
							"{$wpdb->prefix}job_manager_bookmarks",
							array(
								'user_id'       => get_current_user_id(),
								'post_id'       => $post_id,
								'bookmark_note' => $note,
								'date_created'  => current_time( 'mysql' )
							)
						);
					} else {
						$wpdb->update(
							"{$wpdb->prefix}job_manager_bookmarks",
							array(
								'bookmark_note' => $note
							),
							array(
								'post_id' => $post_id,
								'user_id' => get_current_user_id()
							)
						);
					}

					delete_transient( 'bookmark_count_' . $post_id );
					$action_data = array( 'success' => true, 'note' =>  $note );
				}
			}
		}

		if ( ! empty( $_GET['remove_bookmark'] ) ) {
			if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'remove_bookmark' ) ) {
				$action_data = array(
					'error_code' => 400,
					'error' => __( 'Bad request', 'wp-job-manager-bookmarks' ),
				);
			} else {
				$post_id = absint( $_GET[ 'remove_bookmark' ] );

				$wpdb->delete(
					"{$wpdb->prefix}job_manager_bookmarks",
					array(
						'post_id' => $post_id,
						'user_id' => get_current_user_id()
					)
				);

				delete_transient( 'bookmark_count_' . $post_id );
				$action_data = array( 'success' => true );
			}
		}

		if ( null === $action_data ) {
			return;
		}
		if ( ! empty( $_REQUEST['wpjm-ajax'] ) && ! defined( 'DOING_AJAX' ) ) {
			define( 'DOING_AJAX', true );
		}
		if ( wp_doing_ajax() ) {
			wp_send_json( $action_data, ! empty( $action_data['error_code'] ) ? $action_data['error_code'] : 200 );
		} else {
			wp_redirect( remove_query_arg( array( 'submit_bookmark', 'remove_bookmark', '_wpnonce', 'wpjm-ajax' ) ) );
		}
	}

	/**
	 * Show the bookmark form
	 */
	public function bookmark_form() {
		global $post, $resume_preview, $job_preview;

		if ( $resume_preview || $job_preview ) {
			return;
		}

		ob_start();

		$post_type = get_post_type_object( $post->post_type );

		if ( ! is_user_logged_in() ) {
			get_job_manager_template( 'logged-out-bookmark-form.php', array(
				'post_type'     => $post_type,
				'post'          => $post
			), 'wp-job-manager-bookmarks', JOB_MANAGER_BOOKMARKS_PLUGIN_DIR . '/templates/' );
		} else {
			$is_bookmarked = $this->is_bookmarked( $post->ID );

			if ( $is_bookmarked ) {
				$note = $this->get_note( $post->ID );
			} else {
				$note = '';
			}

			wp_enqueue_script( 'wp-job-manager-bookmarks-bookmark-js' );
			wp_enqueue_style( 'wp-job-manager-bookmarks-frontend' );

			get_job_manager_template( 'bookmark-form.php', array(
				'post_type'     => $post_type,
				'post'          => $post,
				'is_bookmarked' => $is_bookmarked ,
				'note'          => $note
			), 'wp-job-manager-bookmarks', JOB_MANAGER_BOOKMARKS_PLUGIN_DIR . '/templates/' );
		}

		echo ob_get_clean();
	}

	/**
	 * User bookmarks shortcode
	 */
	public function my_bookmarks( $atts ) {
		if ( ! is_user_logged_in() ) {
			return __( 'You need to be signed in to manage your bookmarks.', 'wp-job-manager-bookmarks' );
		}

		$atts = shortcode_atts( array(
			'posts_per_page' => '25',
			'orderby'        => 'date', // Options: date, post_date, post_title
			'order'          => 'DESC',
		), $atts );

		ob_start();

		wp_enqueue_script( 'wp-job-manager-bookmarks-bookmark-js' );
		wp_enqueue_style( 'wp-job-manager-bookmarks-frontend' );

		if ( $atts['posts_per_page'] >= 0 ) {
			$bookmarks = $this->get_user_bookmarks( get_current_user_id(), $atts['posts_per_page'], ( max( 1, get_query_var('paged') ) - 1 ) *  $atts['posts_per_page'], $atts['orderby'], $atts['order'] );

			get_job_manager_template( 'my-bookmarks.php', array(
				'bookmarks'     => $bookmarks->results,
				'max_num_pages' => $bookmarks->max_num_pages
			), 'wp-job-manager-bookmarks', JOB_MANAGER_BOOKMARKS_PLUGIN_DIR . '/templates/' );
		} else {
			$bookmarks = $this->get_user_bookmarks( get_current_user_id(), 0, 0, $atts['orderby'], $atts['order'] );

			get_job_manager_template( 'my-bookmarks.php', array(
				'bookmarks'     => $bookmarks,
				'max_num_pages' => 1
			), 'wp-job-manager-bookmarks', JOB_MANAGER_BOOKMARKS_PLUGIN_DIR . '/templates/' );
		}

		return ob_get_clean();
	}

	/**
	 * Add note that the listing is bookmarked
	 */
	public function already_bookmarked_post_class( $classes ) {
		global $post;

		if ( is_user_logged_in() && $this->is_bookmarked( $post->ID ) ) {
			$classes[] = 'listing-bookmarked';
		}

		return $classes;
	}

	/**
	 *
	 * Adds the shortcode to the job manager shortcodes list if not there.
	 *
	 * @since 1.4.1
	 */
	public function maybe_add_bookmark_shortcodes( $shortcode_list = array() ) {
		if ( ! in_array( 'my_bookmarks', $shortcode_list, true ) ) {
			$shortcode_list[] = 'my_bookmarks';
		}

		return $shortcode_list;
	}
}

$GLOBALS['job_manager_bookmarks'] = new WP_Job_Manager_Bookmarks();
