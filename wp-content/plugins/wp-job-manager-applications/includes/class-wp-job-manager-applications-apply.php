<?php
/**
 * File containing the class WP_Job_Manager_Applications_Apply.
 *
 * @package wp-job-manager-applications
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Job_Manager_Applications_Apply class.
 */
class WP_Job_Manager_Applications_Apply extends WP_Job_Manager_Form {

	protected $fields          = [];
	private $error             = '';
	private static $secret_dir = '';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_filter( 'sanitize_file_name_chars', [ $this, 'sanitize_file_name_chars' ] );
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'wp', [ $this, 'application_form_handler' ] );
		add_filter( 'job_manager_locate_template', [ $this, 'disable_application_form' ], 10, 2 );
		add_filter( 'job_manager_enhanced_select_enabled', [ $this, 'enable_enhanced_select_for_job_application' ] );
		self::$secret_dir = uniqid();

		if ( $this->use_recaptcha_field() ) {
			add_action( 'job_application_form_fields_end', [ $this, 'display_recaptcha_field' ] );
			add_action( 'application_form_validate_fields', [ $this, 'validate_recaptcha_field' ] );
		}
	}

	/**
	 * Use reCAPTCHA field on the form?
	 *
	 * @return bool
	 */
	public function use_recaptcha_field() {
		if ( ! method_exists( $this, 'is_recaptcha_available' ) || ! $this->is_recaptcha_available() ) {
			return false;
		}

		return 1 === absint( get_option( 'job_application_enable_recaptcha_application_submission' ) );
	}

	/**
	 * Enqueue application scripts.
	 *
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts() {
		parent::enqueue_scripts();

		wp_register_script( 'wp-job-manager-applications', JOB_MANAGER_APPLICATIONS_PLUGIN_URL . '/assets/js/application.min.js', [ 'jquery' ], JOB_MANAGER_APPLICATIONS_VERSION, true );
		wp_localize_script(
			'wp-job-manager-applications',
			'job_manager_applications',
			[
				'i18n_required' => __( '"%s" is a required field', 'wp-job-manager-applications' ),
			]
		);
	}

	/**
	 * Enable enhanced select when viewing a job listing.
	 *
	 * @param bool $enhanced_select_used_on_page
	 *
	 * @return bool
	 */
	public function enable_enhanced_select_for_job_application( $enhanced_select_used_on_page ) {
		if ( is_wpjm_job_listing() ) {
			return true;
		}

		return $enhanced_select_used_on_page;
	}

	/**
	 * Chars which should be removed from file names
	 */
	public function sanitize_file_name_chars( $chars ) {
		$chars[] = '%';
		$chars[] = '^';
		return $chars;
	}

	/**
	 * Init application form
	 */
	public function init() {
		global $job_manager;

		if ( ! is_admin() ) {
			if ( get_option( 'job_application_form_for_email_method', '1' ) ) {
				add_action( 'job_manager_application_details_email', [ $this, 'application_form' ], 20 );

				// Unhook job manager apply details
				remove_action( 'job_manager_application_details_email', [ $job_manager->post_types, 'application_details_email' ] );
			}
			if ( get_option( 'job_application_form_for_url_method', '1' ) ) {
				add_action( 'job_manager_application_details_url', [ $this, 'application_form' ], 20 );

				// Unhook job manager apply details
				remove_action( 'job_manager_application_details_url', [ $job_manager->post_types, 'application_details_url' ] );
			}
		}
	}

	/**
	 * Returns the fields to display on the application form.
	 *
	 * @param string $key Unused parameter from parent instance.
	 * @return array
	 */
	public function get_fields( $key = '' ) {
		$this->init_fields();

		return $this->fields;
	}

	/**
	 * Sanitize a text field, but preserve the line breaks! Can handle arrays.
	 *
	 * @param  string $input
	 * @return string
	 */
	private function sanitize_text_field_with_linebreaks( $input ) {
		if ( is_array( $input ) ) {
			foreach ( $input as $k => $v ) {
				$input[ $k ] = $this->sanitize_text_field_with_linebreaks( $v );
			}
			return $input;
		}

		return str_replace( '[nl]', "\n", sanitize_text_field( str_replace( "\n", '[nl]', strip_tags( stripslashes( $input ) ) ) ) );
	}

	/**
	 * Init form fields
	 */
	public function init_fields() {
		if ( ! empty( $this->fields ) ) {
			return;
		}

		$current_user = is_user_logged_in() ? wp_get_current_user() : false;
		$this->fields = get_job_application_form_fields();

		// Handle values
		foreach ( $this->fields as $key => $field ) {
			if ( ! isset( $this->fields[ $key ]['value'] ) ) {
				$this->fields[ $key ]['value'] = '';
			}

			$field['rules'] = array_filter( isset( $field['rules'] ) ? (array) $field['rules'] : [] );

			// Special field type handling
			if ( in_array( 'from_name', $field['rules'] ) ) {
				if ( $current_user ) {
					$this->fields[ $key ]['value'] = $current_user->first_name . ' ' . $current_user->last_name;
				}
			}
			if ( in_array( 'from_email', $field['rules'] ) ) {
				if ( $current_user ) {
					$this->fields[ $key ]['value'] = $current_user->user_email;
				}
			}
			if ( 'select' === $field['type'] && ! $this->fields[ $key ]['required'] ) {
				$this->fields[ $key ]['options'] = array_merge( [ 0 => __( 'Choose an option', 'wp-job-manager-applications' ) ], $this->fields[ $key ]['options'] );
			}
			if ( 'resumes' === $field['type'] ) {
				if ( function_exists( 'get_resume_share_link' ) && is_user_logged_in() ) {
					$args         = apply_filters(
						'resume_manager_get_application_form_resumes_args',
						[
							'post_type'           => 'resume',
							'post_status'         => [ 'publish' ],
							'ignore_sticky_posts' => 1,
							'posts_per_page'      => -1,
							'orderby'             => 'date',
							'order'               => 'desc',
							'author'              => get_current_user_id(),
						]
					);
					$resumes      = [];
					$resume_posts = get_posts( $args );

					foreach ( $resume_posts as $resume ) {
						if ( function_exists( 'get_resume_select_label' ) ) {
							$label = get_resume_select_label( $resume );
						} elseif ( function_exists( 'get_the_candidate_title' ) && ( $resume_title = get_the_candidate_title( $resume ) ) ) {
							$label = $resume->post_title . ' (' . $resume_title . ')';
						} else {
							$label = $resume->post_title;
						}
						$resumes[ $resume->ID ] = $label;
					}
				} else {
					$resumes = null;
				}

				// No resumes? Don't show field.
				if ( ! $resumes ) {
					unset( $this->fields[ $key ] );
					continue;
				}

				// If resume field is required, and use has 1 only, hide the option (hidden input)
				if ( $this->fields[ $key ]['required'] && 1 === count( $resumes ) ) {
					$this->fields[ $key ]['type']        = 'single-resume';
					$this->fields[ $key ]['value']       = current( array_keys( $resumes ) );
					$this->fields[ $key ]['description'] = '<a href="' . esc_url( get_permalink( current( array_keys( $resumes ) ) ) ) . '" target="_blank">' . current( $resumes ) . '</a>';
				} else {
					if ( ! $this->fields[ $key ]['required'] ) {
						$resumes = [ 0 => __( 'Choose an online resume...', 'wp-job-manager-applications' ) ] + $resumes;
					}
					$this->fields[ $key ]['type']    = 'select';
					$this->fields[ $key ]['options'] = $resumes;
				}

				$this->fields[ $key ]['rules'][] = 'resume_id';
			}

			// Check for already posted values
			$this->fields[ $key ]['value'] = isset( $_POST[ $key ] ) ? $this->sanitize_text_field_with_linebreaks( $_POST[ $key ] ) : $this->fields[ $key ]['value'];
		}

		uasort(
			$this->fields,
			function ( $a, $b ) {
				return $a['priority'] - $b['priority'];
			}
		);
	}

	/**
	 * Get a field from either resume manager or job manager
	 */
	public static function get_field_template( $key, $field ) {
		switch ( $field['type'] ) {
			case 'single-resume':
				get_job_manager_template(
					'form-fields/single-resume-field.php',
					[
						'key'   => $key,
						'field' => $field,
					],
					'wp-job-manager-applications',
					JOB_MANAGER_APPLICATIONS_PLUGIN_DIR . '/templates/'
				);
				break;
			default:
				get_job_manager_template(
					'form-fields/' . $field['type'] . '-field.php',
					[
						'key'   => $key,
						'field' => $field,
					]
				);
				break;
		}
	}

	/**
	 * Disable application form if needed
	 */
	public function disable_application_form( $template, $template_name ) {
		global $post;

		if ( 'job-application.php' === $template_name && get_option( 'job_application_prevent_multiple_applications' ) && user_has_applied_for_job( get_current_user_id(), $post->ID ) ) {
			return locate_job_manager_template( 'application-form-applied.php', 'wp-job-manager-applications', JOB_MANAGER_APPLICATIONS_PLUGIN_DIR . '/templates/' );
		}
		return $template;
	}

	/**
	 * Allow users to apply to a job with a resume
	 */
	public function application_form() {
		if ( get_option( 'job_application_form_require_login', 0 ) && ! is_user_logged_in() ) {
			get_job_manager_template( 'application-form-login.php', [], 'wp-job-manager-applications', JOB_MANAGER_APPLICATIONS_PLUGIN_DIR . '/templates/' );

		} else {
			$this->init_fields();

			wp_enqueue_script( 'wp-job-manager-applications' );

			get_job_manager_template(
				'application-form.php',
				[
					'application_fields' => $this->fields,
					'class'              => $this,
				],
				'wp-job-manager-applications',
				JOB_MANAGER_APPLICATIONS_PLUGIN_DIR . '/templates/'
			);
		}
	}

	/**
	 * Send the application email if posted
	 */
	public function application_form_handler() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Input is used safely.
		if ( ! empty( $_GET['application_success'] ) ) {
			// Message to display.
			add_action( 'job_content_start', [ $this, 'application_form_success' ] );

			return;
		}

		if ( ! empty( $_POST['wp_job_manager_send_application'] ) ) {
			try {
				$fields = $this->get_fields();
				$values = [];
				$job_id = absint( $_POST['job_id'] );
				$job    = get_post( $job_id );
				$meta   = [];

				if ( empty( $job_id ) || ! $job || 'job_listing' !== $job->post_type ) {
					throw new Exception( __( 'Invalid job', 'wp-job-manager-applications' ) );
				}

				if ( 'publish' !== $job->post_status ) {
					throw new Exception( __( 'That job is not available', 'wp-job-manager-applications' ) );
				}

				if ( get_option( 'job_application_prevent_multiple_applications' ) && user_has_applied_for_job( get_current_user_id(), $job_id ) ) {
					throw new Exception( __( 'You have already applied for this job', 'wp-job-manager-applications' ) );
				}

				// Validate posted fields
				foreach ( $fields as $key => $field ) {
					$field['rules'] = array_filter( isset( $field['rules'] ) ? (array) $field['rules'] : [] );

					switch ( $field['type'] ) {
						case 'file':
							$values[ $key ] = $this->upload_file( $key, $field );

							if ( is_wp_error( $values[ $key ] ) ) {
								throw new Exception( $field['label'] . ': ' . $values[ $key ]->get_error_message() );
							}
							break;
						default:
							$values[ $key ] = isset( $_POST[ $key ] ) ? $this->sanitize_text_field_with_linebreaks( $_POST[ $key ] ) : '';
							break;
					}

					// Validate required
					if ( $field['required'] && empty( $values[ $key ] ) ) {
						throw new Exception( sprintf( __( '"%s" is a required field', 'wp-job-manager-applications' ), $field['label'] ) );
					}

					// Extra validation rules
					if ( ! empty( $field['rules'] ) && ! empty( $values[ $key ] ) ) {
						foreach ( $field['rules'] as $rule ) {
							switch ( $rule ) {
								case 'email':
								case 'from_email':
									if ( ! is_email( $values[ $key ] ) ) {
										throw new Exception( $field['label'] . ': ' . __( 'Please provide a valid email address', 'wp-job-manager-applications' ) );
									}
									break;
								case 'numeric':
									if ( ! is_numeric( $values[ $key ] ) ) {
										throw new Exception( $field['label'] . ': ' . __( 'Please enter a number', 'wp-job-manager-applications' ) );
									}
									break;
							}
						}
					}
				}

				// Validation hook
				$valid = apply_filters( 'application_form_validate_fields', true, $fields, $values );

				if ( is_wp_error( $valid ) ) {
					throw new Exception( $valid->get_error_message() );
				}

				// Prepare meta data to save
				$from_name                = [];
				$from_email               = '';
				$application_message      = [];
				$meta['_secret_dir']      = self::$secret_dir;
				$meta['_attachment']      = [];
				$meta['_attachment_file'] = [];

				foreach ( $fields as $key => $field ) {
					if ( empty( $values[ $key ] ) ) {
						continue;
					}

					$field['rules'] = array_filter( isset( $field['rules'] ) ? (array) $field['rules'] : [] );

					if ( in_array( 'from_name', $field['rules'] ) ) {
						$from_name[] = $values[ $key ];
					}

					if ( in_array( 'from_email', $field['rules'] ) ) {
						$from_email = $values[ $key ];
					}

					if ( in_array( 'message', $field['rules'] ) ) {
						$application_message[] = $values[ $key ];
					}

					if ( in_array( 'resume_id', $field['rules'] ) ) {
						$meta['_resume_id'] = absint( $values[ $key ] );
						continue;
					}

					if ( 'file' === $field['type'] ) {
						if ( ! empty( $values[ $key ] ) ) {
							$index = 1;
							foreach ( $values[ $key ] as $attachment ) {
								if ( ! is_wp_error( $attachment ) ) {
									if ( in_array( 'attachment', $field['rules'] ) ) {
										$meta['_attachment'][]      = $attachment->url;
										$meta['_attachment_file'][] = $attachment->file;
									} else {
										$meta[ $field['label'] . ' ' . $index ] = $attachment->url;
									}
								}
								$index ++;
							}
						}
					} elseif ( 'checkbox' === $field['type'] ) {
						$meta[ $field['label'] ] = $values[ $key ] ? __( 'Yes', 'wp-job-manager-applications' ) : __( 'No', 'wp-job-manager-applications' );
					} elseif ( is_array( $values[ $key ] ) ) {
						$meta[ $field['label'] ] = implode( ', ', $values[ $key ] );
					} else {
						$meta[ $field['label'] ] = $values[ $key ];
					}
				}

				$from_name           = implode( ' ', $from_name );
				$application_message = implode( "\n\n", $application_message );
				$meta                = apply_filters( 'job_application_form_posted_meta', $meta, $values );

				// Create application
				if ( ! $application_id = create_job_application( $job_id, $from_name, $from_email, $application_message, $meta ) ) {
					throw new Exception( __( 'Could not create job application', 'wp-job-manager-applications' ) );
				}

				// Candidate email
				$candidate_email_content = get_job_application_candidate_email_content();
				if ( $candidate_email_content ) {
					$existing_shortcode_tags = $GLOBALS['shortcode_tags'];
					remove_all_shortcodes();
					job_application_email_add_shortcodes(
						[
							'application_id'      => $application_id,
							'job_id'              => $job_id,
							'user_id'             => get_current_user_id(),
							'candidate_name'      => $from_name,
							'candidate_email'     => $from_email,
							'application_message' => $application_message,
							'meta'                => $meta,
						]
					);
					$subject = do_shortcode( get_job_application_candidate_email_subject() );
					$message = do_shortcode( $candidate_email_content );
					$message = str_replace( "\n\n\n\n", "\n\n", implode( "\n", array_map( 'trim', explode( "\n", $message ) ) ) );
					$is_html = ( $message != strip_tags( $message ) );

					// Does this message contain formatting already?
					if ( $is_html && ! strstr( $message, '<p' ) && ! strstr( $message, '<br' ) ) {
						$message = nl2br( $message );
					}

					$GLOBALS['shortcode_tags'] = $existing_shortcode_tags;
					$headers                   = [];
					$headers[]                 = $is_html ? 'Content-Type: text/html' : 'Content-Type: text/plain';
					$headers[]                 = 'charset=utf-8';

					wp_mail(
						apply_filters( 'create_job_application_candidate_notification_recipient', $from_email, $job_id, $application_id ),
						apply_filters( 'create_job_application_candidate_notification_subject', $subject, $job_id, $application_id ),
						apply_filters( 'create_job_application_candidate_notification_message', $message ),
						apply_filters( 'create_job_application_candidate_notification_headers', $headers, $job_id, $application_id ),
						apply_filters( 'create_job_application_candidate_notification_attachments', [], $job_id, $application_id )
					);
				}

				// Trigger action.
				do_action( 'new_job_application', $application_id, $job_id );

				// Redirect to show the success message and prevent duplicate submissions.
				if ( wp_safe_redirect( add_query_arg( 'application_success', '1', get_permalink( $job_id ) ) ) ) {
					exit;
				}
			} catch ( Exception $e ) {
				$this->error = $e->getMessage();
				add_action( 'job_content_start', [ $this, 'application_form_errors' ] );
			}
		}
	}

	/**
	 * Upload a file
	 *
	 * @return  string or array
	 */
	public function upload_file( $field_key, $field ) {
		if ( isset( $_FILES[ $field_key ] ) && ! empty( $_FILES[ $field_key ] ) && ! empty( $_FILES[ $field_key ]['name'] ) ) {
			if ( ! empty( $field['allowed_mime_types'] ) ) {
				$allowed_mime_types = $field['allowed_mime_types'];
			} elseif ( function_exists( 'job_manager_get_allowed_mime_types' ) ) {
				$allowed_mime_types = job_manager_get_allowed_mime_types( $field_key );
			} else {
				$allowed_mime_types = get_allowed_mime_types();
			}

			$files           = [];
			$files_to_upload = job_manager_prepare_uploaded_files( $_FILES[ $field_key ] );

			add_filter( 'job_manager_upload_dir', [ $this, 'upload_dir' ], 10, 2 );

			foreach ( $files_to_upload as $file_to_upload ) {
				$uploaded_file = job_manager_upload_file(
					$file_to_upload,
					[
						'file_key'           => $field_key,
						'allowed_mime_types' => $allowed_mime_types,
					]
				);

				if ( is_wp_error( $uploaded_file ) ) {
					throw new Exception( $uploaded_file->get_error_message() );
				} else {
					if ( ! isset( $uploaded_file->file ) ) {
						$uploaded_file->file = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $uploaded_file->url );
					}
					$files[] = $uploaded_file;
				}
			}

			remove_filter( 'job_manager_upload_dir', [ $this, 'upload_dir' ], 10, 2 );

			return $files;
		}
	}

	/**
	 * Filter the upload directory
	 */
	public static function upload_dir( $pathdata ) {
		return 'job_applications/' . self::$secret_dir;
	}

	/**
	 * Success message
	 */
	public function application_form_success() {
		get_job_manager_template( 'application-submitted.php', [], 'wp-job-manager-applications', JOB_MANAGER_APPLICATIONS_PLUGIN_DIR . '/templates/' );
	}

	/**
	 * Show errors
	 */
	public function application_form_errors() {
		if ( $this->error ) {
			echo '<p class="job-manager-error job-manager-applications-error">' . esc_html( $this->error ) . '</p>';
		}
	}
}

new WP_Job_Manager_Applications_Apply();
