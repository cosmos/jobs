<?php
/**
 * Front Meta Boxes
 *
 * Sets up the write panels used by products and orders (custom post types).
 *
 * @author      MadrasThemes
 * @category    Admin
 * @package     Front/Admin/Meta Boxes
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Front_Admin_Meta_Boxes.
 */
class Front_Admin_Meta_Boxes {

    /**
     * Is meta boxes saved once?
     *
     * @var boolean
     */
    private static $saved_meta_boxes = false;

    /**
     * Meta box error messages.
     *
     * @var array
     */
    public static $meta_box_errors = array();

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 30 );
        add_action( 'save_post', array( $this, 'save_meta_boxes' ), 1, 2 );

        add_action( 'front_process_jetpack-portfolio_meta', 'Front_Meta_Box_Portfolio_Images::save', 20, 2 );

        // Error handling (for showing errors from meta boxes on next page load).
        add_action( 'admin_notices', array( $this, 'output_errors' ) );
        add_action( 'shutdown', array( $this, 'save_errors' ) );
    }

    /**
     * Add an error message.
     *
     * @param string $text
     */
    public static function add_error( $text ) {
        self::$meta_box_errors[] = $text;
    }

    /**
     * Save errors to an option.
     */
    public function save_errors() {
        update_option( 'front_meta_box_errors', self::$meta_box_errors );
    }

    /**
     * Show any stored error messages.
     */
    public function output_errors() {
        $errors = array_filter( (array) get_option( 'front_meta_box_errors' ) );

        if ( ! empty( $errors ) ) {

            echo '<div id="woocommerce_errors" class="error notice is-dismissible">';

            foreach ( $errors as $error ) {
                echo '<p>' . wp_kses_post( $error ) . '</p>';
            }

            echo '</div>';

            // Clear
            delete_option( 'front_meta_box_errors' );
        }
    }

    /**
     * Add Front Meta boxes.
     */
    public function add_meta_boxes() {
        $screen    = get_current_screen();
        $screen_id = $screen ? $screen->id : '';

        // Products.
        add_meta_box( 'front-portfolio-images', esc_html__( 'Portfolio gallery', 'front-extensions' ), 'Front_Meta_Box_Portfolio_Images::output', 'jetpack-portfolio', 'side', 'low' );
    }

    /**
     * Check if we're saving, the trigger an action based on the post type.
     *
     * @param  int    $post_id
     * @param  object $post
     */
    public function save_meta_boxes( $post_id, $post ) {
        // $post_id and $post are required
        if ( empty( $post_id ) || empty( $post ) || self::$saved_meta_boxes ) {
            return;
        }

        // Dont' save meta boxes for revisions or autosaves
        if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
            return;
        }

        // Check the nonce
        if ( empty( $_POST['front_meta_nonce'] ) || ! wp_verify_nonce( $_POST['front_meta_nonce'], 'front_save_data' ) ) {
            return;
        }

        // Check the post being saved == the $post_id to prevent triggering this call for other save_post events
        if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
            return;
        }

        // Check user has permission to edit
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // We need this save event to run once to avoid potential endless loops. This would have been perfect:
        // remove_action( current_filter(), __METHOD__ );
        // But cannot be used due to https://github.com/woocommerce/woocommerce/issues/6485
        // When that is patched in core we can use the above. For now:
        self::$saved_meta_boxes = true;

        // Check the post type
        
        if ( in_array( $post->post_type, array( 'jetpack-portfolio' ) ) ) {
            do_action( 'front_process_' . $post->post_type . '_meta', $post_id, $post );
        }
    }
}

new Front_Admin_Meta_Boxes();