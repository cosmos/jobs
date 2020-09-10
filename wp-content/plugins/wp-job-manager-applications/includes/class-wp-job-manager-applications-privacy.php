<?php
/**
 * File containing the class WP_Job_Manager_Applications_Privacy.
 *
 * @package wp-job-manager-applications
 * @since   2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the user data export.
 *
 * @package
 * @since
 */
class WP_Job_Manager_Applications_Privacy {
	const EXPORT_PER_PAGE = 10;
	const ERASE_PER_PAGE  = 50;

	/**
	 * Sets up initial hooks.
	 *
	 * @static
	 */
	public static function init() {
		add_filter( 'wp_privacy_personal_data_exporters', [ __CLASS__, 'register_user_data_exporter' ] );
		add_filter( 'wp_privacy_personal_data_erasers', [ __CLASS__, 'register_user_data_eraser' ] );
	}

	/**
	 * Register the user data exporter method.
	 *
	 * @param array $exporters The exporter array.
	 * @return array $exporters The exporter array.
	 */
	public static function register_user_data_exporter( $exporters ) {
		$exporters['wp-job-manager-applications'] = [
			'exporter_friendly_name' => __( 'WP Job Manager - Applications', 'wp-job-manager-applications' ),
			'callback'               => [ __CLASS__, 'user_data_exporter' ],
		];
		return $exporters;
	}

	/**
	 * Register the user data eraser method.
	 *
	 * @param array $erasers The eraser array.
	 * @return array $erasers The eraser array.
	 */
	public static function register_user_data_eraser( $erasers ) {
		if ( ! self::is_application_personal_data_erasure_enabled() ) {
			return $erasers;
		}
		$erasers['wp-job-manager-applications'] = [
			'eraser_friendly_name' => __( 'WP Job Manager - Applications', 'wp-job-manager-applications' ),
			'callback'             => [ __CLASS__, 'user_data_eraser' ],
		];
		return $erasers;
	}

	/**
	 * Data exporter
	 *
	 * @param string $email_address User email address.
	 * @param int    $page          Page number.
	 * @return array
	 */
	public static function user_data_exporter( $email_address, $page ) {
		$per_page       = self::EXPORT_PER_PAGE;
		$page           = (int) $page;
		$data_to_export = [];

		$application_ids = self::get_personal_data_post_ids_by_email( $email_address, $per_page, $page );
		foreach ( $application_ids as $application_id ) {
			$application      = get_post( $application_id );
			$data_to_export[] = [
				'group_id'    => 'wp_job_manager_applications',
				'group_label' => __( 'Job Applications', 'wp-job-manager-applications' ),
				'item_id'     => 'job-application-' . $application->ID,
				'data'        => self::get_application_personal_data( $application ),
			];
		}

		$done = $per_page > count( $data_to_export );

		return [
			'data' => $data_to_export,
			'done' => $done,
		];
	}

	/**
	 * Get the personal data from an application.
	 *
	 * @param WP_Post $application
	 * @return array
	 */
	public static function get_application_personal_data( WP_Post $application ) {
		$personal_data   = [];
		$props_to_export = self::get_personal_data_fields( $application );

		foreach ( $props_to_export as $field ) {
			if ( ! isset( $field['name'] ) || ! isset( $field['key'] ) ) {
				continue;
			}

			$field = array_merge(
				[
					'type'     => 'meta',
					'callback' => false,
				],
				$field
			);
			$value = self::get_field_value( $application, $field );

			/**
			 * Filter the value of a particular field for personal data export.
			 *
			 * @since 2.4.0
			 *
			 * @param mixed   $value  Value to be filtered.
			 * @param string  $field  Field name.
			 * @param WP_Post $application Post object.
			 */
			$value = apply_filters( 'job_application_privacy_export_personal_data_value', $value, $field, $application );

			if ( $value ) {
				$personal_data[] = [
					'name'  => $field['name'],
					'value' => $value,
				];
			}
		}

		return $personal_data;
	}

	/**
	 * Get the field value for a personal data export.
	 *
	 * @param WP_Post $post  Post object.
	 * @param array   $field Field configuration.
	 *
	 * @return mixed|string
	 */
	protected static function get_field_value( $post, $field ) {
		$raw_value = self::get_field_raw_value( $post, $field );
		if ( $field['callback'] && is_callable( $field['callback'] ) ) {
			return call_user_func( $field['callback'], $raw_value, $post, $field );
		}
		return esc_html( $raw_value );
	}

	/**
	 * Get the raw value for a field.
	 *
	 * @param WP_Post $post  Post object.
	 * @param array   $field Field configuration.
	 *
	 * @return mixed
	 */
	protected static function get_field_raw_value( $post, $field ) {
		if ( 'raw' === $field['type'] ) {
			if ( ! isset( $field['value'] ) ) {
				$field['value'] = '';
			}
			return $field['value'];
		}
		if ( 'meta' === $field['type'] ) {
			return get_post_meta( $post->ID, $field['key'], true );
		}
		if ( 'post' === $field['type'] ) {
			return $post->{$field['key']};
		}
		if ( 'post_parent' === $field['type'] && ! empty( $post->post_parent ) ) {
			$post_parent = get_post( $post->post_parent );
			if ( ! empty( $post_parent ) && ! empty( $post_parent->{$field['key']} ) ) {
				return $post_parent->{$field['key']};
			}
		}
		if ( 'taxonomy' === $field['type'] && taxonomy_exists( $field['key'] ) ) {
			$terms = wp_get_post_terms( $post->ID, $field['key'], [ 'fields' => 'names' ] );
			if ( ! is_wp_error( $terms ) ) {
				return $terms;
			}
		}
		return '';
	}

	/**
	 * Export the value from a education field.
	 *
	 * @param mixed   $raw_value
	 * @param WP_Post $application
	 * @param array   $field
	 *
	 * @return string
	 */
	public static function export_field_attachments( $raw_value, $application, $field ) {
		$value       = '';
		$attachments = [];
		if ( ! empty( $raw_value ) && is_array( $raw_value ) ) {
			foreach ( $raw_value as $attachment ) {
				$attachments[] = sprintf( '<a href="%1$s" target="_blank" rel="noreferrer noopener">%1$s</a>', esc_url( $attachment ) );
			}
			$value = implode( '<br />', $attachments );
		}
		return $value;
	}

	/**
	 * Export the name of the job that was applied for.
	 *
	 * @param mixed   $raw_value
	 * @param WP_Post $application
	 * @param array   $field
	 *
	 * @return string
	 */
	public static function export_field_job_name( $raw_value, $application, $field ) {
		if ( empty( $raw_value ) ) {
			return '';
		}
		$value = esc_html( $raw_value );
		if ( ! empty( $application->post_parent ) && 'publish' === get_post_status( $application->post_parent ) ) {
			$post_parent_permalink = get_permalink( $application->post_parent );
			if ( ! empty( $post_parent_permalink ) ) {
				$value = sprintf( '<a href="%1$s" target="_blank" rel="noreferrer noopener">%2$s</a>', $post_parent_permalink, $value );
			}
		}
		return $value;
	}

	/**
	 * Gets the fields that are exported with personal data.
	 *
	 * @param WP_Post $application Application post object.
	 * @return array
	 */
	public static function get_personal_data_fields( $application ) {
		$meta   = get_post_custom( $application->ID );
		$fields = [
			'job_name' => [
				'name'     => __( 'Job Name', 'wp-job-manager-applications' ),
				'key'      => 'post_title',
				'type'     => 'post_parent',
				'callback' => [ __CLASS__, 'export_field_job_name' ],
			],
		];

		if ( $meta ) {
			foreach ( $meta as $key => $value ) {
				// Do not include private values
				if ( 0 === strpos( $key, '_' ) ) {
					continue;
				}
				$field             = [];
				$field['name']     = $key;
				$field['key']      = $key;
				$field['type']     = 'raw';
				$field['value']    = implode( ', ', $value );
				$field['callback'] = false;
				$fields[ $key ]    = $field;
			}
		}

		if ( ! empty( $meta['_attachment'] ) ) {
			$fields['attachment'] = [
				'name'     => __( 'Attachments', 'wp-job-manager-applications' ),
				'type'     => 'meta',
				'key'      => '_attachment',
				'callback' => [ __CLASS__, 'export_field_attachments' ],
			];
		}

		/**
		 * Allows filtering on what fields are considered personal data from someone's application record.
		 *
		 * @since 2.4.0
		 *
		 * @param $fields array   List of fields (key => name).
		 * @param $application WP_Post Application post object.
		 */
		return apply_filters( 'job_application_privacy_export_personal_data_fields', $fields, $application );
	}

	/**
	 * Get the post IDs related to a particular email address.
	 *
	 * @param string $email_address
	 * @param int    $per_page
	 * @param int    $page
	 * @param bool   $include_trashed Defaults to false.
	 * @return array Post IDs.
	 */
	public static function get_personal_data_post_ids_by_email( $email_address, $per_page, $page, $include_trashed = false ) {
		if ( empty( $email_address ) ) {
			return [];
		}

		$post_statuses = array_keys( get_job_application_statuses() );
		if ( $include_trashed ) {
			$post_statuses[] = 'trash';
		}

		$application_query_args = [
			'post_type'      => 'job_application',
			'posts_per_page' => $per_page,
			'paged'          => $page,
			'post_status'    => $post_statuses,
			'orderby'        => 'ID',
			'order'          => 'DESC',
			'fields'         => 'ids',
			'meta_query'     => [
				[
					'key'   => '_candidate_email',
					'value' => $email_address,
				],
			],
		];

		$application_query = new WP_Query( $application_query_args );
		return $application_query->get_posts();
	}

	/**
	 * Data eraser.
	 *
	 * @param string $email_address User email address.
	 * @param int    $page          Page number.
	 * @return array
	 */
	public static function user_data_eraser( $email_address, $page ) {
		$per_page       = self::ERASE_PER_PAGE;
		$items_removed  = 0;
		$items_retained = 0;
		$messages       = [];

		$application_ids = self::get_personal_data_post_ids_by_email( $email_address, $per_page, $page, true );
		foreach ( $application_ids as $application_id ) {
			if ( 'trash' === get_post_status( $application_id ) ) {
				// Don't include it as removed or retained.
				continue;
			}

			/**
			 * Allows the prevention of application deletion on user request.
			 *
			 * @since 2.4.0
			 *
			 * @param bool $trash_post
			 * @param int  $application_id
			 */
			$trash_post = apply_filters( 'job_application_privacy_erase_user_data_application', true, $application_id );

			if ( $trash_post && self::trash_post( $application_id ) ) {
				$items_removed++;
			} else {
				$items_retained++;
				$messages[] = sprintf(
					// translators: Placeholder %d is the post ID for the application that couldn't be removed.
					__( 'Application ID %d could not be removed at this time.', 'wp-job-manager-applications' ),
					$application_id
				);
			}
		}

		$response = [
			'items_removed'  => $items_removed > 0,
			'items_retained' => $items_retained > 0,
			'messages'       => $messages,
			'done'           => $per_page > count( $application_ids ),
		];
		return $response;
	}

	/**
	 * If trash is enabled with standard garbage collection, use standard `wp_trash_post()`, otherwise set to trash manually.
	 *
	 * @param int $post_id
	 * @return bool
	 */
	private static function trash_post( $post_id ) {
		if ( EMPTY_TRASH_DAYS > 0 ) {
			wp_trash_post( $post_id );
			return 'trash' === get_post_status( $post_id );
		}

		// Post trash is disabled. Permanent removal will require manual trash emptying.
		$result = wp_update_post(
			[
				'ID'          => $post_id,
				'post_status' => 'trash',
			]
		);
		return ! is_wp_error( $result );
	}

	/**
	 * Checks if applications should be removed on personal data erasure requests.
	 *
	 * @return bool
	 */
	public static function is_application_personal_data_erasure_enabled() {
		return (bool) get_option( 'job_application_erasure_request_removes_applications', false );
	}
}
