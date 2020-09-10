<?php
/**
 * Plugin Name: WP Job Manager - Embeddable Job Widget
 * Plugin URI: https://wpjobmanager.com/add-ons/embeddable-job-widget
 * Description: Lets users generate and embed a widget containing your job listings on their own sites via a form added to your site with the shortcode [embeddable_job_widget_generator].
 * Version: 1.1.2
 * Author: Automattic
 * Author URI: https://wpjobmanager.com
 * Requires at least: 5.0
 * Tested up to: 5.5
 * Requires PHP: 7.0
 *
 * WPJM-Product: wp-job-manager-embeddable-job-widget
 *
 * Copyright: 2020 Automattic
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Job_Manager_Embeddable_Job_Widget class.
 */
class WP_Job_Manager_Embeddable_Job_Widget {
	const JOB_MANAGER_CORE_MIN_VERSION = '1.29.0';

	/**
	 * __construct function.
	 */
	public function __construct() {
		// Define constants
		define( 'JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_VERSION', '1.1.2' );
		define( 'JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

		// Set up startup actions
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ), 12 );
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ), 13 );
		add_action( 'admin_notices', array( $this, 'version_check' ) );
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
		add_filter( 'job_manager_enqueue_frontend_style', array( $this, 'use_wpjm_core_frontend_style' ) );
		add_filter( 'job_manager_enhanced_select_enabled', array( $this, 'use_enhanced_select' ) );
		add_action( 'wp', array( $this, 'job_widget_js' ) );
		add_shortcode( 'embeddable_job_widget_generator', array( $this, 'embed_code_generator' ) );
	}

	/**
	 * Checks WPJM core version.
	 */
	public function version_check() {
		if ( ! class_exists( 'WP_Job_Manager' ) || ! defined( 'JOB_MANAGER_VERSION' ) ) {
			$screen = get_current_screen();
			if ( null !== $screen && 'plugins' === $screen->id ) {
				$this->display_error( __( '<em>WP Job Manager - Embeddable Job Widget</em> requires WP Job Manager to be installed and activated.', 'wp-job-manager-embeddable-job-widget' ) );
			}
		} elseif (
			/**
			 * Filters if WPJM core's version should be checked.
			 *
			 * @since 1.16.0
			 *
			 * @param bool   $do_check                       True if the add-on should do a core version check.
			 * @param string $minimum_required_core_version  Minimum version the plugin is reporting it requires.
			 */
			apply_filters( 'job_manager_addon_core_version_check', true, self::JOB_MANAGER_CORE_MIN_VERSION )
			&& version_compare( JOB_MANAGER_VERSION, self::JOB_MANAGER_CORE_MIN_VERSION, '<' )
		) {
			$this->display_error( sprintf( __( '<em>WP Job Manager - Embeddable Job Widget</em> requires WP Job Manager %s (you are using %s).', 'wp-job-manager-embeddable-job-widget' ), self::JOB_MANAGER_CORE_MIN_VERSION, JOB_MANAGER_VERSION ) );
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
	 * Localisation
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'wp-job-manager-embeddable-job-widget' );
		load_textdomain( 'wp-job-manager-embeddable-job-widget', WP_LANG_DIR . "/wp-job-manager/wp-job-manager-embeddable-job-widget-$locale.mo" );
		load_plugin_textdomain( 'wp-job-manager-embeddable-job-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * frontend_scripts function.
	 *
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {
		wp_register_script( 'embeddable-job-widget', JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_URL . '/assets/js/form.js', array( 'jquery', 'select2' ), JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_VERSION, true );
		wp_enqueue_style( 'embeddable-job-widget-frontend', JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_URL . '/assets/css/frontend.css' );

		ob_start();
		get_job_manager_template( 'embed-code.php', array(), 'wp-job-manager-embeddable-job-widget', JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_DIR . '/templates/' );
		$code = ob_get_clean();

		ob_start();
		get_job_manager_template( 'embed-code-css.php', array(), 'wp-job-manager-embeddable-job-widget', JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_DIR . '/templates/' );
		$css = ob_get_clean();

		wp_localize_script( 'embeddable-job-widget', 'embeddable_job_widget_form_args', array(
			'code'       => $code,
			'css'        => $css,
			'theme_dark' => '',
			'script_url' => home_url( '/?embed=wp_job_manager_widget' ),
			'is_rtl'     => is_rtl(),
		) );
	}

	/**
	 * Outputs Javascript for the widget itself.
	 */
	public function job_widget_js() {
		if ( ! empty( $_GET['embed'] ) && 'wp_job_manager_widget' === $_GET['embed'] ) {
			$categories = array_filter( array_map( 'absint', explode( ',', $_GET['categories'] ) ) );
			$job_types  = array_filter( array_map( 'sanitize_text_field', explode( ',', $_GET['job_type'] ) ) );
			$page       = absint( isset( $_GET['page'] ) ? $_GET['page'] : 1 );
			$per_page   = absint( $_GET['per_page'] );
			$jobs       = get_job_listings( apply_filters( 'job_manager_embeddable_job_widget_query_args', array(
				'search_location'   => sanitize_text_field( $_GET['location'] ),
				'search_keywords'   => sanitize_text_field( $_GET['keywords'] ),
				'search_categories' => $categories,
				'job_types'         => sizeof( $job_types ) === 0 ? '' : $job_types + array( 0 ),
				'posts_per_page'    => $per_page,
				'offset'            => ( $page - 1 ) * $per_page
			) ) );

			ob_start();

			echo '<div class="embeddable-job-widget-content">';
			echo '<ul class="embeddable-job-widget-listings">';

			if ( $jobs->have_posts() ) : ?>
				<?php while ( $jobs->have_posts() ) : $jobs->the_post(); ?>
					<?php get_job_manager_template_part( 'content-embeddable-widget', 'job_listing', 'wp-job-manager-embeddable-job-widget', JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_DIR . '/templates/' ); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<li class="no-results"><?php _e( 'No matching jobs found', 'wp-job-manager-embeddable-job-widget' ); ?></li>
			<?php endif;

			echo '</ul>';

			if ( ! empty( $_GET['pagination'] ) ) {
				echo '<div id="embeddable-job-widget-pagination">';
				if ( $page > 1 ) {
					echo '<a href="#" class="embeddable-job-widget-prev" onclick="window.embeddable_job_widget.prev_page(); return false;">' . __( 'Previous', 'wp-job-manager-embeddable-job-widget' ) . '</a>';
				}
				if ( $page < $jobs->max_num_pages ) {
					echo '<a href="#" class="embeddable-job-widget-next" onclick="window.embeddable_job_widget.next_page(); return false;">' . __( 'Next', 'wp-job-manager-embeddable-job-widget' ) . '</a>';
				}
				echo '</div>';
			}

			echo '</div>';

			$content = ob_get_clean();

			header( "Content-Type: text/javascript; charset=" . get_bloginfo( 'charset' ) );
			header( "Vary: Accept-Encoding" ); // Handle proxies
			header( "Expires: " . gmdate( "D, d M Y H:i:s", time() + DAY_IN_SECONDS ) . " GMT" );
			?>
			if ( window['embeddable_job_widget'] != undefined ) {
				window['embeddable_job_widget']['show_jobs']( 'embeddable-job-widget-content', '<?php echo esc_js( $content ); ?>' );
			}
			<?php
			exit;
		}
	}

	/**
	 * Form users can generate some embed code
	 */
	public function embed_code_generator() {
		wp_enqueue_script( 'embeddable-job-widget' );
		ob_start();
		get_job_manager_template( 'form-embed-code-generator.php', array(), 'wp-job-manager-embeddable-job-widget', JOB_MANAGER_EMBEDDABLE_JOB_WIDGET_PLUGIN_DIR . '/templates/' );
		return ob_get_clean();
	}

	/**
	 * Check if we should have WPJM core enqueue its frontend styles.
	 *
	 * @param bool $use_frontend_style True if we should have WPJM core enqueue frontend styles.
	 * @return bool
	 */
	public function use_wpjm_core_frontend_style( $use_frontend_style ) {
		if ( $this->is_shortcode_page() ) {
			return true;
		}

		return $use_frontend_style;
	}

	/**
	 * Check if we should have WPJM core enqueue enhanced select.
	 *
	 * @param bool $use_enhanced_select True if we should have WPJM core use enhanced select.
	 * @return bool
	 */
	public function use_enhanced_select( $use_enhanced_select ) {
		if ( $this->is_shortcode_page() ) {
			return true;
		}
		return $use_enhanced_select;
	}

	/**
	 * Checks if the current page has one of our shortcodes.
	 *
	 * @return bool
	 */
	private function is_shortcode_page() {
		global $post;

		$content = null;
		if ( is_singular() && is_a( $post, 'WP_Post' ) ) {
			$content = $post->post_content;
		}

		if ( has_shortcode( $content, 'embeddable_job_widget_generator' ) ) {
			return true;
		}

		return false;
	}
}

$GLOBALS['job_manager_embeddable_job_widget'] = new WP_Job_Manager_Embeddable_Job_Widget();
