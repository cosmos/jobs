<?php
/**
 * File containing the class WP_Job_Manager_Applications_Post_Types.
 *
 * @package wp-job-manager-applications
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Job_Manager_Applications_Post_Types class.
 */
class WP_Job_Manager_Applications_Post_Types {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'wpjm_the_job_title', [ $this, 'already_applied_title' ], 10, 2 );
		add_action( 'single_job_listing_meta_after', [ $this, 'already_applied_message' ] );
		add_action( 'init', [ $this, 'register_post_types' ], 20 );
		if ( get_option( 'job_application_delete_with_job', 0 ) ) {
			add_action( 'delete_post', [ $this, 'delete_post' ] );
			add_action( 'wp_trash_post', [ $this, 'trash_post' ] );
			add_action( 'untrash_post', [ $this, 'untrash_post' ] );
		}
		add_action( 'before_delete_post', [ $this, 'delete_application_files' ] );
		add_action( 'job_applications_purge', [ $this, 'job_applications_purge' ] );
		add_filter( 'post_class', [ $this, 'add_applied_post_class' ], 10, 3 );
		add_action( 'transition_post_status', [ $this, 'transition_post_status' ], 10, 3 );
	}

	/**
	 * Append 'Applied' on jobs that have already been applied for.
	 *
	 * @param string      $title
	 * @param WP_Post|int $post
	 * @return string
	 */
	public function already_applied_title( $title, $post = null ) {
		if ( ! is_admin()
			 && ( $post = get_post( $post ) )
			 && 'job_listing' === get_post_type( $post )
			 && ! is_single()
			 && empty( $_POST['wp_job_manager_resumes_apply_with_resume'] )
			 && empty( $_GET['download-csv'] )
			 && user_has_applied_for_job( get_current_user_id(), $post )
		) {
			$title .= ' <span class="job-manager-applications-applied-notice">' . __( 'Applied', 'wp-job-manager-applications' ) . '</span>';
		}
		return $title;
	}

	/**
	 * Show message if already applied
	 */
	public function already_applied_message() {
		global $post;

		if ( user_has_applied_for_job( get_current_user_id(), $post->ID ) ) {
			 get_job_manager_template( 'applied-notice.php', [], 'wp-job-manager-applications', JOB_MANAGER_APPLICATIONS_PLUGIN_DIR . '/templates/' );
		}
	}

	/**
	 * register_post_types function.
	 */
	public function register_post_types() {
		if ( post_type_exists( 'job_application' ) ) {
			return;
		}

		$plural   = __( 'Job Applications', 'wp-job-manager-applications' );
		$singular = __( 'Application', 'wp-job-manager-applications' );

		register_post_type(
			'job_application',
			apply_filters(
				'register_post_type_job_application',
				[
					'labels'              => [
						'name'               => $plural,
						'singular_name'      => $singular,
						'menu_name'          => $plural,
						'all_items'          => sprintf( __( 'All %s', 'wp-job-manager-applications' ), $plural ),
						'add_new'            => __( 'Add New', 'wp-job-manager-applications' ),
						'add_new_item'       => sprintf( __( 'Add %s', 'wp-job-manager-applications' ), $singular ),
						'edit'               => __( 'Edit', 'wp-job-manager-applications' ),
						'edit_item'          => sprintf( __( 'Edit %s', 'wp-job-manager-applications' ), $singular ),
						'new_item'           => sprintf( __( 'New %s', 'wp-job-manager-applications' ), $singular ),
						'view'               => sprintf( __( 'View %s', 'wp-job-manager-applications' ), $singular ),
						'view_item'          => sprintf( __( 'View %s', 'wp-job-manager-applications' ), $singular ),
						'search_items'       => sprintf( __( 'Search %s', 'wp-job-manager-applications' ), $plural ),
						'not_found'          => sprintf( __( 'No %s found', 'wp-job-manager-applications' ), $plural ),
						'not_found_in_trash' => sprintf( __( 'No %s found in trash', 'wp-job-manager-applications' ), $plural ),
						'parent'             => sprintf( __( 'Parent %s', 'wp-job-manager-applications' ), $singular ),
					],
					'description'         => __( 'This is where you can edit and view applications.', 'wp-job-manager-applications' ),
					'public'              => false,
					'show_ui'             => true,
					'capability_type'     => 'job_application',
					'map_meta_cap'        => true,
					'publicly_queryable'  => false,
					'exclude_from_search' => true,
					'hierarchical'        => false,
					'rewrite'             => false,
					'query_var'           => false,
					'supports'            => [ 'title', 'custom-fields', 'editor' ],
					'has_archive'         => false,
					'show_in_nav_menus'   => false,
					'delete_with_user'    => true,
					'menu_position'       => 31,
				]
			)
		);

		$applicaton_statuses = get_job_application_statuses();

		foreach ( $applicaton_statuses as $name => $label ) {
			register_post_status(
				$name,
				apply_filters(
					'register_job_application_status',
					[
						'label'                     => $label,
						'public'                    => true,
						'exclude_from_search'       => 'archived' === $name ? true : false,
						'show_in_admin_all_list'    => 'archived' === $name ? false : true,
						'show_in_admin_status_list' => true,
						'label_count'               => _n_noop( $label . ' <span class="count">(%s)</span>', $label . ' <span class="count">(%s)</span>', 'wp-job-manager-applications' ),
					],
					$name
				)
			);
		}
	}

	/**
	 * Delete applications when deleting a job.
	 *
	 * @param int $id Post ID.
	 */
	public function delete_post( $id ) {
		if ( $id > 0 ) {

			$post_type = get_post_type( $id );

			if ( 'job_listing' === $post_type ) {
				$applications = get_children( 'post_parent=' . $id . '&post_type=job_application&post_status=trash,any' );

				if ( $applications ) {
					foreach ( $applications as $application ) {
						wp_delete_post( $application->ID, true );
					}
				}
			}
		}
	}

	/**
	 * Trashes applications when trashing the job.
	 *
	 * @since 2.2.4
	 *
	 * @param int $id Post ID.
	 */
	public function trash_post( $id ) {
		if ( $id > 0 ) {
			$post_type = get_post_type( $id );
			if ( 'job_listing' === $post_type ) {
				$published_apps = [];
				$applications   = get_children( 'post_parent=' . $id . '&post_type=job_application' );
				if ( $applications ) {
					foreach ( $applications as $application ) {
						$published_apps[] = $application->ID;
						wp_trash_post( $application->ID );
					}
				}
				add_post_meta( $id, '_trashed_published_applications', $published_apps, true );
			}
		}
	}

	/**
	 * Restores applications when restoring the job.
	 *
	 * @since 2.2.4
	 *
	 * @param int $id Post ID.
	 */
	public function untrash_post( $id ) {
		if ( $id > 0 ) {
			$post_type = get_post_type( $id );

			if ( 'job_listing' === $post_type ) {
				$applications = get_post_meta( $id, '_trashed_published_applications', true );
				if ( $applications ) {
					foreach ( $applications as $application_id ) {
						wp_untrash_post( $application_id );
					}
				}
				delete_post_meta( $id, '_trashed_published_applications' );
			}
		}
	}

	/**
	 * recursive_rmdir function
	 */
	public function recursive_rmdir( $directory ) {
		foreach ( glob( "{$directory}/*" ) as $file ) {
			if ( is_dir( $file ) ) {
				$this->recursive_rmdir( $file );
			} else {
				unlink( $file );
			}
		}
		rmdir( $directory );
	}

	/**
	 * Delete application files upon deletion.
	 *
	 * @param int $id Post ID.
	 */
	public function delete_application_files( $id ) {
		if ( $id > 0 ) {
			$post_type = get_post_type( $id );

			if ( 'job_application' === $post_type ) {
				$upload_dir = wp_upload_dir();
				$secret_dir = get_post_meta( $id, '_secret_dir', true );
				$dir_path   = trailingslashit( $upload_dir['basedir'] ) . 'job_applications/' . $secret_dir;
				if ( $secret_dir && is_dir( $dir_path ) ) {
					$this->recursive_rmdir( $dir_path );
				}
			}
		}
	}

	/**
	 * Purge applications after x days
	 */
	public function job_applications_purge() {
		$days = absint( get_option( 'job_application_purge_days' ) );

		if ( ! $days ) {
			return;
		}

		global $wpdb;

		$application_ids = $wpdb->get_col(
			$wpdb->prepare(
				"
			SELECT ID FROM {$wpdb->posts} as posts
			WHERE posts.post_type = 'job_application'
			AND DATEDIFF( NOW(), posts.post_date ) > %d
		",
				$days
			)
		);

		if ( $application_ids ) {
			foreach ( $application_ids as $application_id ) {
				wp_delete_post( $application_id, true );
			}
		}
	}

	/**
	 * When the status changes
	 */
	public function transition_post_status( $new_status, $old_status, $post ) {
		if ( 'job_application' !== $post->post_type ) {
			return;
		}

		$statuses = get_job_application_statuses();

		// Add a note
		if ( $old_status !== $new_status && array_key_exists( $old_status, $statuses ) && array_key_exists( $new_status, $statuses ) ) {
			$user                 = get_user_by( 'id', get_current_user_id() );
			$comment_author       = $user->display_name;
			$comment_author_email = $user->user_email;
			$comment_post_ID      = $post->ID;
			$comment_author_url   = '';
			$comment_content      = sprintf( __( 'Application status changed from "%1$s" to "%2$s"', 'wp-job-manager-applications' ), $statuses[ $old_status ], $statuses[ $new_status ] );
			$comment_agent        = 'WP Job Manager';
			$comment_type         = 'job_application_note';
			$comment_parent       = 0;
			$comment_approved     = 1;
			$commentdata          = apply_filters( 'job_application_note_data', compact( 'comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_agent', 'comment_type', 'comment_parent', 'comment_approved' ), $post->ID );
			$comment_id           = wp_insert_comment( $commentdata );
		}

		/**
		 * When hiring an applicant, mark the job as filled.
		 *
		 * @since 2.2.4
		 *
		 * @param bool Hiring an applicant fills a job. Default true.
		 */
		if ( 'hired' === $new_status && apply_filters( 'job_application_hired_fills_job', true ) ) {
			update_post_meta( wp_get_post_parent_id( $post->ID ), '_filled', 1 );
		}
	}

	/**
	 * Adds `job-applied` class to applied job listings.
	 *
	 * @since 2.5.0
	 *
	 * @param array $classes An array of post classes.
	 * @param array $class   An array of additional classes added to the post.
	 * @param int   $post_id The post ID.
	 * @return array
	 */
	public function add_applied_post_class( $classes, $class, $post_id ) {
		if ( 'job_listing' !== get_post_type( $post_id ) || ! is_user_logged_in() ) {
			return $classes;
		}

		if ( user_has_applied_for_job( get_current_user_id(), $post_id ) ) {
			$classes[] = 'job-applied';
		}

		return $classes;
	}

}
