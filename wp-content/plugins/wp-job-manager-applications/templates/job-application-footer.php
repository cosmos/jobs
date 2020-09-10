<?php
/**
 * Footer shown below a job application.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-applications/job-application-footer.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager-applications
 * @category    Template
 * @version     2.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wp_post_statuses;

$resume_id         = get_job_application_resume_id( $application->ID );
$resume_share_link = $resume_id && function_exists( 'get_resume_share_link' ) ? get_resume_share_link( $resume_id ) : null;
$attachments       = get_job_application_attachments( $application->ID );
$email             = get_job_application_email( $application->ID );
?>
<ul class="meta">
	<li><?php echo esc_html( $wp_post_statuses[ $application->post_status ]->label ); ?></li>
	<li><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $application->post_date ) ) ); ?></li>
</ul>
<ul class="actions">
	<li class="content"><a href="#" title="<?php esc_attr_e( 'Details', 'wp-job-manager-applications' ); ?>" class="job-application-toggle-content"><span class="action-label"><?php esc_html_e( 'Details', 'wp-job-manager-applications' ); ?></span></a></li>

	<?php if ( $resume_id && 'publish' === get_post_status( $resume_id ) && $resume_share_link ) : ?>
		<li class="resume"><span class="action-label"><a href="<?php echo esc_attr( $resume_share_link ); ?>" target="_blank" class="job-application-resume"><?php echo esc_html( $resume_id ); ?></span></a></li>
	<?php endif; ?>

	<?php if ( $attachments ) : ?>
		<?php foreach ( $attachments as $attachment ) : ?>
			<li class="attachment"><a href="<?php echo esc_url( $attachment ); ?>" title="<?php echo esc_attr( get_job_application_attachment_name( $attachment ) ); ?>" class="job-application-attachment"><span class="action-label"><?php echo esc_html( get_job_application_attachment_name( $attachment, 20 ) ); ?></span></a></li>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ( $email ) : ?>
		<?php
			// translators: Placeholder %s is the job title.
			$email_subject = sprintf( __( 'Your job application for %s', 'wp-job-manager-applications' ), wp_strip_all_tags( get_the_title( $job_id ) ) );
			// translators: Placeholder %s is the applicant name.
			$email_body = sprintf( __( 'Hello %s', 'wp-job-manager-applications' ), get_the_title( $application->ID ) );
		?>
		<li class="email"><a href="mailto:<?php echo esc_attr( $email ); ?>?subject=<?php echo esc_attr( $email_subject ); ?>&amp;body=<?php echo esc_attr( $email_body ); ?>" title="<?php esc_attr_e( 'Email', 'wp-job-manager-applications' ); ?>" class="job-application-contact"><span class="action-label"><?php esc_html_e( 'Email', 'wp-job-manager-applications' ); ?></span></a></li>
	<?php endif; ?>

	<li class="notes <?php echo get_comments_number( $application->ID ) ? 'has-notes' : ''; ?>"><a href="#" title="<?php esc_attr_e( 'Notes', 'wp-job-manager-applications' ); ?>" class="job-application-toggle-notes"><span class="action-label"><?php esc_html_e( 'Notes', 'wp-job-manager-applications' ); ?></span></a></li>
	<li class="edit"><a href="#" title="<?php esc_attr_e( 'Edit', 'wp-job-manager-applications' ); ?>" class="job-application-toggle-edit"><span class="action-label"><?php esc_html_e( 'Edit', 'wp-job-manager-applications' ); ?></span></a></li>
</ul>
