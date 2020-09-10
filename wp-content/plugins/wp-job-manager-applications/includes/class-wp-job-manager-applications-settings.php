<?php
/**
 * File containing the class WP_Job_Manager_Applications_Settings.
 *
 * @package wp-job-manager-applications
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Job_Manager_Applications_Settings class.
 */
class WP_Job_Manager_Applications_Settings extends WP_Job_Manager_Settings {

	/**
	 * WP_Job_Manager_Applications_Settings constructor.
	 */
	public function __construct() {
		$this->settings_group = 'wp-job-manager-applications';
		add_action( 'admin_init', [ $this, 'register_settings' ] );

		// If this setting is enabled, add note on WP Job Manager core's settings page.
		if ( get_option( 'job_application_form_for_url_method', '1' ) ) {
			add_action( 'job_manager_settings', [ $this, 'add_notice_for_url_method' ] );
		}
	}

	/**
	 * Initializes the settings for the plugin.
	 */
	protected function init_settings() {
		$empty_trash_days = defined( 'EMPTY_TRASH_DAYS ' ) ? EMPTY_TRASH_DAYS : 30;
		if ( empty( $empty_trash_days ) || $empty_trash_days < 0 ) {
			$trash_description = ' ' . __( 'They will then need to be manually removed from the trash', 'wp-job-manager-applications' );
		} else {
			// translators: Placeholder %d is the number of days before items are removed from trash.
			$trash_description = ' ' . sprintf( __( 'They will then be permanently deleted after %d days.', 'wp-job-manager-applications' ), $empty_trash_days );
		}

		$this->settings = apply_filters(
			'job_manager_applications_settings',
			[
				'application_forms'      => [
					__( 'Application Forms', 'wp-job-manager-applications' ),
					[
						[
							'name'     => 'job_application_form_for_email_method',
							'std'      => '1',
							'label'    => __( 'Email Application Method', 'wp-job-manager-applications' ),
							'cb_label' => __( 'Use application form', 'wp-job-manager-applications' ),
							'desc'     => __( 'Show application form for jobs with an email application method. Disable to use the default application functionality, or another form plugin.', 'wp-job-manager-applications' ),
							'type'     => 'checkbox',
						],
						[
							'name'     => 'job_application_form_for_url_method',
							'std'      => '1',
							'label'    => __( 'Website URL Application Method', 'wp-job-manager-applications' ),
							'cb_label' => __( 'Use application form', 'wp-job-manager-applications' ),
							'desc'     => __( 'Show application form for jobs with a website URL application method. Disable to use the default application functionality, or another form plugin. <strong>Note: URLs entered for the <em>Application Method</em> will be ignored.</strong> ', 'wp-job-manager-applications' ),
							'type'     => 'checkbox',
						],
						[
							'name'     => 'job_application_form_require_login',
							'std'      => '0',
							'label'    => __( 'User Restriction', 'wp-job-manager-applications' ),
							'cb_label' => __( 'Only allow registered users to apply', 'wp-job-manager-applications' ),
							'desc'     => __( 'If enabled, only logged in users can apply. Non-logged in users will see the contents of the <code>application-form-login.php</code> file instead of a form.', 'wp-job-manager-applications' ),
							'type'     => 'checkbox',
						],
						[
							'name'     => 'job_application_prevent_multiple_applications',
							'std'      => '0',
							'label'    => __( 'Multiple Applications', 'wp-job-manager-applications' ),
							'cb_label' => __( 'Prevent users from applying to the same job multiple times', 'wp-job-manager-applications' ),
							'desc'     => __( 'If enabled, the apply form will be hidden after applying.', 'wp-job-manager-applications' ),
							'type'     => 'checkbox',
						],
						'recaptcha' => [
							'name'       => 'job_application_enable_recaptcha_application_submission',
							'std'        => '0',
							'label'      => __( 'reCAPTCHA', 'wp-job-manager-applications' ),
							'cb_label'   => __( 'Display a reCAPTCHA field on application submission form.', 'wp-job-manager-applications' ),
							'desc'       => sprintf(
								// translators: Placeholder %s is the URL to the page in WP Job Manager's settings to make the change.
								__( 'This will help prevent bots from applying for jobs. You must have entered a valid site key and secret key in <a href="%s">WP Job Manager\'s settings</a>.', 'wp-job-manager-applications' ),
								esc_url( admin_url( 'edit.php?post_type=job_listing&page=job-manager-settings#settings-recaptcha' ) )
							),
							'type'       => 'checkbox',
							'attributes' => [],
						],
					],
				],
				'application_management' => [
					__( 'Management', 'wp-job-manager-applications' ),
					[
						[
							'name'     => 'job_application_delete_with_job',
							'std'      => '0',
							'label'    => __( 'Delete with Jobs', 'wp-job-manager-applications' ),
							'cb_label' => __( 'Delete applications when a job is deleted', 'wp-job-manager-applications' ),
							'desc'     => __( 'If enabled, job applications will be deleted when the parent job listing is deleted. Otherwise they will be kept on file and visible in the backend.', 'wp-job-manager-applications' ),
							'type'     => 'checkbox',
						],
						[
							'name'        => 'job_application_purge_days',
							'std'         => '',
							'placeholder' => __( 'Do not purge data', 'wp-job-manager-applications' ),
							'label'       => __( 'Purge Applications', 'wp-job-manager-applications' ),
							'desc'        => __( 'Purge application data and files after X days. Leave blank to disable.', 'wp-job-manager-applications' ),
							'type'        => 'text',
						],
						[
							'name'       => 'job_application_erasure_request_removes_applications',
							'std'        => '0',
							'label'      => __( 'Personal Data Erasure', 'wp-job-manager-applications' ),
							'cb_label'   => __( 'Remove applications on account erasure requests', 'wp-job-manager-applications' ),
							'desc'       => sprintf(
								// translators: Placeholder %1$s is the URL to the WP Admin page that handles account erasure requests. %2$s is trash notification.
								__( 'If enabled, applications with a matching email address will be sent to the trash during <a href="%1$s">personal data erasure requests</a>. %2$s', 'wp-job-manager-applications' ),
								esc_url( admin_url( 'tools.php?page=remove_personal_data' ) ),
								$trash_description
							),
							'type'       => 'checkbox',
							'attributes' => [],
						],
					],
				],
			]
		);
	}

	/**
	 * Add note for application method when URL field will be ignored.
	 *
	 * @param array $settings Current WPJM core settings.
	 * @return array
	 */
	public function add_notice_for_url_method( $settings ) {
		if ( isset( $settings['job_submission'][1] ) ) {
			foreach ( $settings['job_submission'][1] as $index => $setting ) {
				if ( 'job_manager_allowed_application_method' !== $setting['name'] ) {
					continue;
				}

				$warning_text = sprintf(
					// translators: Placeholder is the URL to the settings page in Applications.
					__( 'The <a href="%s">Website URL Application Method</a> setting is enabled in the Applications plugin. URLs entered for the Application Method on the Job Submission form will be ignored unless your theme uses them elsewhere.', 'wp-job-manager-applications' ),
					esc_url( admin_url( 'edit.php?post_type=job_application&page=job-applications-settings#settings-application_forms' ) )
				);

				$settings['job_submission'][1][ $index ]['desc'] .= ' <div class="notice notice-warning inline"><p>' . $warning_text . '</p></div>';
				break;
			}
		}

		return $settings;
	}
}
