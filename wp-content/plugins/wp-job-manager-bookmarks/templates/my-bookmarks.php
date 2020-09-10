<?php
/**
 * Lists a users bookmarks.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-bookmarks/my-bookmarks.php.
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
?>
<div id="job-manager-bookmarks">
	<table class="job-manager-bookmarks">
		<thead>
			<tr>
				<th><?php _e( 'Bookmark', 'wp-job-manager-bookmarks' ); ?></th>
				<th><?php _e( 'Notes', 'wp-job-manager-bookmarks' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $bookmarks as $bookmark ) : ?>
				<tr>
					<td width="50%">
						<a href="<?php the_permalink( $bookmark->post_id ); ?>">
							<?php
							$post_type = get_post_type( $bookmark->post_id );
							if ( function_exists( 'the_candidate_photo' ) && 'resume' === $post_type ) {
								the_candidate_photo( 'thumbnail', null, $bookmark->post_id );
							} elseif ( function_exists( 'the_company_logo' ) && 'job_listing' === $post_type ) {
								the_company_logo( 'thumbnail', null, $bookmark->post_id );
							}
							?>
							<?php echo get_the_title( $bookmark->post_id ); ?>
						</a>
						<ul class="job-manager-bookmark-actions">
							<?php
								$actions = apply_filters( 'job_manager_bookmark_actions', array(
									'delete' => array(
										'label' => __( 'Delete', 'wp-job-manager-bookmarks' ),
										'url'   =>  wp_nonce_url( add_query_arg( 'remove_bookmark', $bookmark->post_id ), 'remove_bookmark' )
									)
								), $bookmark );

								foreach ( $actions as $action => $value ) {
									echo '<li><a href="' . esc_url( $value['url'] ) . '" class="job-manager-bookmark-action-' . $action . '">' . $value['label'] . '</a></li>';
								}
							?>
						</ul>
					</td>
					<td width="50%">
						<?php echo wpautop( wp_kses_post( $bookmark->bookmark_note ) ); ?>
					</td>
				</tr>
			<?php endforeach; ?>

			<tr class="no-bookmarks-notice">
				<td colspan="2" ><?php _e( 'You currently have no bookmarks', 'wp-job-manager-bookmarks' ); ?></td>
			</tr>
		</tbody>
	</table>
	<?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
</div>
