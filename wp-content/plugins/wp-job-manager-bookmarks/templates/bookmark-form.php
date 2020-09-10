<?php
/**
 * Form for adding and removing a bookmark.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-bookmarks/bookmark-form.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Bookmarks
 * @category    Template
 * @version     1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp;
?>
<form method="post" action="<?php echo defined( 'DOING_AJAX' ) ? '' : esc_url( remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) ) ); ?>" class="job-manager-form wp-job-manager-bookmarks-form <?php echo $is_bookmarked ? 'has-bookmark' : ''; ?>">
	<div class="remove-bookmark-wrapper"><a class="remove-bookmark" href="<?php echo wp_nonce_url( add_query_arg( 'remove_bookmark', absint( $post->ID ), get_permalink() ), 'remove_bookmark' ); ?>"><?php _e( 'Remove Bookmark', 'wp-job-manager-bookmarks' ); ?></a> <a class="bookmark-notice bookmarked" href="#"><?php printf( __( 'This %s is bookmarked!', 'wp-job-manager-bookmarks' ), $post_type->labels->singular_name ); ?></a></div>
	<div class="add-bookmark-wrapper"><a class="bookmark-notice" href="#"><?php printf( __( 'Bookmark This %s', 'wp-job-manager-bookmarks' ), ucwords( $post_type->labels->singular_name ) ); ?></a></div>
	<div class="bookmark-details">
		<p><label for="bookmark_notes"><?php _e( 'Notes:', 'wp-job-manager-bookmarks' ); ?></label><textarea name="bookmark_notes" id="bookmark_notes" cols="25" rows="3"><?php echo esc_textarea( $note ); ?></textarea></p>
		<p>
			<?php wp_nonce_field( 'update_bookmark' ); ?>
			<input type="hidden" name="bookmark_post_id" value="<?php echo absint( $post->ID ); ?>" />
			<input type="submit" class="submit-bookmark-button" name="submit_bookmark" value="<?php echo $is_bookmarked ? __( 'Update Bookmark', 'wp-job-manager-bookmarks' ) : __( 'Add Bookmark', 'wp-job-manager-bookmarks' ); ?>" />
			<span class="spinner" style="background-image: url(<?php echo includes_url( 'images/spinner.gif' ); ?>);"></span>
		</p>
	</div>
</form>
