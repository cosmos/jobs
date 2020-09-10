<?php
/**
 * Editing listing screen.
 *
 * @since 1.0.0
 *
 * @package MAS Company Reviews For WP Job Manager
 * @category Core
 * @author Madras Themes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Edit Post.
 *
 * @since 1.0.0
 */
class MAS_WPJMCR_Post_Edit {

    /**
     * Constructor Class.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Add recalculate button in Listing post edit screen.
        add_action( 'admin_footer-post.php', array( $this, 'add_recalculate_checkbox' ) );

        // Process recalculate button.
        add_action( 'save_post', array( $this, 'process_recalculate_checkbox' ), 10, 3 );

        // Add URL param on recalculate reviews.
        add_filter( 'redirect_post_location', array( $this, 'redirect_post_location' ), 99, 2 );

        // Add admin notice.
        add_action( 'admin_notices', array( $this, 'recalculate_admin_notices' ) );
    }

    /**
     * Add Recalculate Checkbox.
     *
     * @since 1.0.0
     */
    public function add_recalculate_checkbox() {
        global $post_type;
        if ( 'company' !== $post_type ) {
            return;
        }
        ?>
        <script type="text/javascript">
        jQuery( document ).ready( function($) {
            $( '#add-new-comment' ).append( ' <label style="margin-left:10px;"><input type="checkbox" name="mas_wpjmcr_recalculate_reviews" value="<?php echo esc_attr( wp_create_nonce( 'mas_wpjmcr_recalculate_' . get_the_ID() ) ); ?>"> <?php echo esc_html__( 'Recalculate reviews', 'mas-wp-job-manager-company-reviews' ); ?></label>' );
        } );
        </script>
        <?php
    }

    /**
     * Process Recalculate Reviews on Save.
     *
     * @since 1.0.0
     *
     * @param int $post_id Post ID.
     * @param WP_Post $post Post Object
     */
    public function process_recalculate_checkbox( $post_id, $post ) {
        if ( 'company' !== $post->post_type || ! isset( $_POST['mas_wpjmcr_recalculate_reviews'] ) ) {
            return $post_id;
        }

        // Verify nonce.
        if ( ! wp_verify_nonce( $_POST['mas_wpjmcr_recalculate_reviews'], 'mas_wpjmcr_recalculate_' . $post_id ) ) {
            return $post_id;
        }

        // Today date.
        $today = date( "Ymd" ); // YYYYMMDD.

        // Remove data.
        delete_post_meta( $post_id, '_all_ratings' );
        delete_post_meta( $post_id, '_mas_wpjmcr_last_updated' );

        // Add new data.
        $reviews = mas_wpjmcr_get_reviews_db( $post_id );
        $updated = update_post_meta( $post_id, '_all_ratings', $reviews );
        update_post_meta( $post_id, '_mas_wpjmcr_last_updated', $today );
        mas_wpjmcr_update_reviews_average( $post_id );

        // Success temp data.
        if ( $updated ) {
            update_post_meta( $post_id, '_mas_wpjmcr_recalculate_review_status', 1 );
        } else {
            update_post_meta( $post_id, '_mas_wpjmcr_recalculate_review_status', 0 );
        }
    }

    /**
     * Redirect Post Location.
     *
     * @since 1.0.0
     *
     * @param string $location Post Location.
     * @param int    $post_id  Post ID.
     * @return string
     */
    public function redirect_post_location( $location, $post_id ) {
        $post = get_post( $post_id );
        if ( ! isset( $_POST['save'] ) ) {
            return $location;
        }
        if ( 'company' === $post->post_type && isset( $_POST['mas_wpjmcr_recalculate_reviews'] ) ) {
            $location = add_query_arg( 'mas_wpjmcr_recalculate', intval( get_post_meta( $post_id, '_mas_wpjmcr_recalculate_review_status' ) ), $location );
            delete_post_meta( $post_id, '_mas_wpjmcr_recalculate_review_status' );
        }
        return $location;
    }

    /**
     * Admin Notices.
     *
     * @since 1.0.0
     */
    public function recalculate_admin_notices() {
        global $pagenow, $post_type;
        if ( ! isset( $_GET['mas_wpjmcr_recalculate'], $_GET['action'] ) || 'post.php' !== $pagenow || 'company' !== $post_type ) {
            return;
        }
        if ( '1' === $_GET['mas_wpjmcr_recalculate'] ) {
            echo '<div class="updated notice notice-success is-dismissible">' . wpautop( esc_html__( 'Reviews count recalculated.', 'mas-wp-job-manager-company-reviews' ) ) . '</div>';
        } elseif ( '0' === $_GET['mas_wpjmcr_recalculate'] ) {
            echo '<div class="notice notice-warning">' . wpautop( esc_html__( 'Fail to recalculate reviews. Please try again.', 'mas-wp-job-manager-company-reviews' ) ) . '</div>';
        }
    }

}
