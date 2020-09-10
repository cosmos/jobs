<?php
/**
 * Notice shown when user is required to log in before applying for a job.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-applications/application-form-login.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager-applications
 * @category    Template
 * @version     1.4.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<p><?php echo apply_filters( 'job_manager_job_applications_login_required_message', sprintf( __( 'You must <a href="%s">sign in</a> to apply for this position.', 'wp-job-manager-applications' ), wp_login_url( get_permalink() ) ) ); ?></p>
