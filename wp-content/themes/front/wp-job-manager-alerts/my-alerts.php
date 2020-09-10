<?php
/**
 * Lists job listing alerts for the `[job_alerts]` shortcode.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-alerts/my-alerts.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager - Alerts
 * @category    Template
 * @version     1.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="job-manager-alerts" class="table-responsive-md">
	<p><?php printf( esc_html__( 'Your job alerts are shown in the table below and will be emailed to %s.', 'front' ), $user->user_email ); ?></p>
	<table class="job-manager-alerts table">
		<thead>
			<tr>
				<th class="text-nowrap"><?php esc_html_e( 'Alert Name', 'front' ); ?></th>
				<th class="text-nowrap"><?php esc_html_e( 'Keywords', 'front' ); ?></th>
				<?php if ( get_option( 'job_manager_enable_categories' ) && wp_count_terms( 'job_listing_category' ) > 0 ) : ?>
					<th class="text-nowrap"><?php esc_html_e( 'Categories', 'front' ); ?></th>
				<?php endif; ?>
				<?php if ( taxonomy_exists( 'job_listing_tag' ) ) : ?>
					<th class="text-nowrap"><?php esc_html_e( 'Tags', 'front' ); ?></th>
				<?php endif; ?>
				<th class="text-nowrap"><?php esc_html_e( 'Location', 'front' ); ?></th>
				<th class="text-nowrap"><?php esc_html_e( 'Frequency', 'front' ); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<a class="btn btn-sm btn-primary" href="<?php echo remove_query_arg( 'updated', add_query_arg( 'action', 'add_alert' ) ); ?>"><?php esc_html_e( 'Add alert', 'front' ); ?></a>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ( $alerts as $alert ) : ?>
				<?php
				$search_terms = WP_Job_Manager_Alerts_Post_Types::get_alert_search_terms( $alert->ID );
				?>
				<tr class="alert-<?php echo 'draft' === $alert->post_status ? 'disabled' : 'enabled'; ?>">
					<td class="text-nowrap">
						<?php echo esc_html( $alert->post_title ); ?>
						<ul class="job-alert-actions d-flex list-inline mb-0 align-items-md-center">
							<?php
								$actions = apply_filters( 'job_manager_alert_actions', array(
									'view' => array(
										'label' => esc_html__( 'Results', 'front' ),
										'nonce' => false
									),
									'email' => array(
										'label' => esc_html__( 'Send&nbsp;Now', 'front' ),
										'nonce' => true
									),
									'edit' => array(
										'label' => esc_html__( 'Edit', 'front' ),
										'nonce' => false
									),
									'toggle_status' => array(
										'label' => $alert->post_status == 'draft' ? esc_html__( 'Enable', 'front' ) : esc_html__( 'Disable', 'front' ),
										'nonce' => true
									),
									'delete' => array(
										'label' => esc_html__( 'Delete', 'front' ),
										'nonce' => true
									)
								), $alert );

								foreach ( $actions as $action => $value ) {
									$action_url = remove_query_arg( 'updated', add_query_arg( array( 'action' => $action, 'alert_id' => $alert->ID ) ) );

									if ( $value['nonce'] )
										$action_url = wp_nonce_url( $action_url, 'job_manager_alert_actions' );

									echo '<li class="list-inline-item"><a href="' . $action_url . '" class="job-alerts-action-' . $action . ' ' . esc_attr( $action === "delete" ? "text-danger" : "text-secondary" ) . ' small">' . $value['label'] . '</a></li>';
								}
							?>
						</ul>
					</td>
					<td class="alert_keyword"><?php
						if ( $value = get_post_meta( $alert->ID, 'alert_keyword', true ) )
							echo esc_html( $value );
						else
							echo '&ndash;';
					?></td>
					<?php if ( get_option( 'job_manager_enable_categories' ) && wp_count_terms( 'job_listing_category' ) > 0 ) : ?>
						<td class="alert_category"><?php
							$term_ids = ! empty( $search_terms['categories'] ) ? $search_terms['categories'] : array();
							$terms = array();
							if ( ! empty( $term_ids ) ) {
								$terms = get_terms( array(
									'taxonomy'         => 'job_listing_category',
									'fields'           => 'names',
									'include'          => $term_ids,
									'hide_empty'       => false,
								) );
							}
							echo ! empty( $terms ) ? esc_html( implode( ', ', $terms ) ) : '&ndash;';
						?></td>
					<?php endif; ?>
					<?php if ( taxonomy_exists( 'job_listing_tag' ) ) : ?>
						<td class="alert_tag"><?php
							$term_ids = ! empty( $search_terms['tags'] ) ? $search_terms['tags'] : array();
							$terms = array();
							if ( ! empty( $term_ids ) ) {
								$terms = get_terms( array(
									'taxonomy'         => 'job_listing_tag',
									'fields'           => 'names',
									'include'          => $term_ids,
									'hide_empty'       => false,
								) );
							}
							echo ! empty( $terms ) ? esc_html( implode( ', ', $terms ) ) : '&ndash;';
						?></td>
					<?php endif; ?>
					<td class="alert_location"><?php
						if ( taxonomy_exists( 'job_listing_region' ) && wp_count_terms( 'job_listing_region' ) > 0 ) {
							$term_ids = ! empty( $search_terms['regions'] ) ? $search_terms['regions'] : array();
							$terms = array();
							if ( ! empty( $term_ids ) ) {
								$terms = get_terms( array(
									'taxonomy'         => 'job_listing_region',
									'fields'           => 'names',
									'include'          => $term_ids,
									'hide_empty'       => false,
								) );
							}
							echo ! empty( $terms ) ? esc_html( implode( ', ', $terms ) ) : '&ndash;';
						} else {
							$value = get_post_meta( $alert->ID, 'alert_location', true );
							echo ! empty( $value ) ? esc_html( $value ) : '&ndash;';
						}
					?></td>
					<td class="alert_frequency"><?php
						$schedules = WP_Job_Manager_Alerts_Notifier::get_alert_schedules();
						$freq      = get_post_meta( $alert->ID, 'alert_frequency', true );

						if ( ! empty( $schedules[ $freq ] ) ) {
							echo esc_html( $schedules[ $freq ]['display'] );
						}

						echo wp_kses_post( '<small class="d-block">' . sprintf( __( 'Next: %s at %s', 'front' ), date_i18n( get_option( 'date_format' ), wp_next_scheduled( 'job-manager-alert', array( $alert->ID ) ) ),  date_i18n( get_option( 'time_format' ), wp_next_scheduled( 'job-manager-alert', array( $alert->ID ) ) ) ) . '</small>' );
					?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
