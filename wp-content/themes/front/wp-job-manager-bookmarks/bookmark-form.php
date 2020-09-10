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
$uniqID = uniqid();
?>
<form method="post" action="<?php echo defined( 'DOING_AJAX' ) ? '' : esc_url( remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) ) ); ?>" class="job-manager-form my-0 <?php echo esc_attr( $is_bookmarked ? 'has-bookmark' : '' ); ?>">
    
    <div class="position-relative">
        <a id="bookmarkDropdownInvoker-<?php echo esc_attr( $uniqID ) ?>" class="btn btn-sm btn-icon rounded-circle btn-bg-transparent <?php echo esc_attr( $is_bookmarked ? 'btn-soft-primary' : 'btn-soft-secondary ' ) ?>" href="javascript:;" role="button" aria-controls="bookmarkSettingsDropdown-<?php echo esc_attr( $uniqID ) ?>" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-target="#bookmarkSettingsDropdown-<?php echo esc_attr( $uniqID ) ?>" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
            <span class="far fa-bookmark btn-icon__inner"></span>
        </a>
        <div id="bookmarkSettingsDropdown-<?php echo esc_attr( $uniqID ) ?>" class="bookmark-details p-5 dropdown-menu dropdown-unfold dropdown-menu-right u-unfold--css-animation u-unfold--hidden" aria-labelledby="bookmarkDropdownInvoker-<?php echo esc_attr( $uniqID ) ?>" style="min-width: 260px;">
            <p class="mb-4">
                <label for="bookmark_notes-<?php echo esc_attr( $uniqID ) ?>" class="form-label"><?php esc_html_e( 'Notes:', 'front' ); ?></label>
                <textarea name="bookmark_notes" id="bookmark_notes-<?php echo esc_attr( $uniqID ) ?>" class="form-control" rows="3" cols="30"><?php echo esc_textarea( $note ); ?></textarea>
            </p>
            <p class="mb-0">
                <?php wp_nonce_field( 'update_bookmark' ); ?>
                <input type="hidden" name="bookmark_post_id" value="<?php echo absint( $post->ID ); ?>" />
                <input type="submit" class="submit-bookmark-button btn-sm btn-block" name="submit_bookmark" value="<?php echo esc_attr( $is_bookmarked ? __( 'Update Bookmark', 'front' ) : __( 'Add Bookmark', 'front' ) ); ?>" />
                <span class="spinner" style="background-image: url(<?php echo includes_url( 'images/spinner.gif' ); ?>);"></span>
            </p>
            <?php if( $is_bookmarked ) : ?>
                <p class="mb-0 mt-2 text-right">
                    <a class="remove-bookmark text-danger" href="<?php echo wp_nonce_url( add_query_arg( 'remove_bookmark', absint( $post->ID ), get_permalink() ), 'remove_bookmark' ); ?>">
                        <?php esc_html_e( 'Remove Bookmark', 'front' ); ?>
                    </a>
                </p>
            <?php endif; ?>
        </div>
    </div>
</form>