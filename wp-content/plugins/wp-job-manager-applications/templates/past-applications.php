<?php
/**
 * xxxx
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-applications/past-applications.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager-applications
 * @category    Template
 * @version     2.1.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="job-manager-past-applications">
	<tr>
		<th><?php _e( 'Job', 'wp-job-manager-applications' ); ?></th>
		<th><?php _e( 'Date Applied', 'wp-job-manager-applications' ); ?></th>
		<th><?php _e( 'Status', 'wp-job-manager-applications' ); ?></th>
		<th><?php _e( 'Application Message', 'wp-job-manager-applications' ); ?></th>
	</tr>
	<?php
	foreach ( $applications as $application ) {
		global $wp_post_statuses;

		$application_id = $application->ID;
		$job_id         = wp_get_post_parent_id( $application_id );
		$job            = get_post( $job_id );
		$job_title      = get_post_meta( $application_id, '_job_applied_for', true );
		?>

		<tr>
			 <td>
				<?php if ( $job && $job->post_status == 'publish' ) { ?>
					 <a href="<?php echo esc_url( get_permalink( $job_id ) ); ?>"><?php echo esc_html( $job_title ); ?></a>
					<?php
				} else {
					echo esc_html( $job_title );
				}
				?>
			 </td>
			  <td>
				<?php echo esc_html( get_the_date( get_option( 'date_format' ), $application_id ) ); ?>
			 </td>
			 <td>
				<?php echo esc_html( $wp_post_statuses[ get_post_status( $application_id ) ]->label ); ?>
			 </td>
			 <td class="application-message">
				<?php echo wpautop( wp_kses_post( $application->post_content ) ); ?>
			 </td>
		</tr>

	<?php } ?>
</table>
<?php get_job_manager_template( 'pagination.php', [ 'max_num_pages' => $max_num_pages ] ); ?>

<?php wp_reset_postdata(); ?>
