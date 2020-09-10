<?php
/**
 * File containing the class Front_WPJM_Form.
 *
 * @package wp-job-manager
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WP_Job_Manager_Form' ) ) {
    include( JOB_MANAGER_PLUGIN_DIR . '/includes/abstracts/abstract-wp-job-manager-form.php' );
}

/**
 *
 * @since 1.0.0
 * @extends WP_Job_Manager_Form
 */
class Front_WPJM_Form extends WP_Job_Manager_Form {
    /**
     * The single instance of the class.
     *
     * @var self
     * @since  1.26.0
     */
    private static $_instance = null;

    /**
     * Allows for accessing single instance of class. Class should only be constructed once per call.
     *
     * @since  1.26.0
     * @static
     * @return self Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor.
     */
    public function __construct() {
        add_filter( 'job_manager_get_posted_repeated_field', array( $this, 'front_wpjm_repeated_field' ), 10 );
    }

    public function front_wpjm_repeated_field() {
        return array( $this, 'get_posted_repeated_field' );
    }

    /**
     * Get the value of a repeated fields (e.g. education, links)
     * @param  array $fields
     * @return array
     */
    public function get_repeated_field( $field_prefix, $fields ) {
        $items       = array();
        $field_keys  = array_keys( $fields );

        if ( ! empty( $_POST[ 'repeated-row-' . $field_prefix ] ) && is_array( $_POST[ 'repeated-row-' . $field_prefix ] ) ) {
            $indexes = array_map( 'absint', $_POST[ 'repeated-row-' . $field_prefix ] );
            foreach ( $indexes as $index ) {
                $item = array();
                foreach ( $fields as $key => $field ) {
                    $field_name = $field_prefix . '_' . $key . '_' . $index;

                    switch ( $field['type'] ) {
                        case 'textarea' :
                            $item[ $key ] = wp_kses_post( stripslashes( $_POST[ $field_name ] ) );
                        break;
                        case 'file' :
                            $file = $this->upload_file( $field_name, $field );

                            if ( ! $file ) {
                                $file = $this->get_posted_field( 'current_' . $field_name, $field );
                            } elseif ( is_array( $file ) ) {
                                $file = array_filter( array_merge( $file, (array) $this->get_posted_field( 'current_' . $field_name, $field ) ) );
                            }

                            $item[ $key ] = $file;
                        break;
                        default :
                            if ( is_array( $_POST[ $field_name ] ) ) {
                                $item[ $key ] = array_filter( array_map( 'sanitize_text_field', array_map( 'stripslashes', $_POST[ $field_name ] ) ) );
                            } else {
                                $item[ $key ] = sanitize_text_field( stripslashes( $_POST[ $field_name ] ) );
                            }
                        break;
                    }
                    if ( empty( $item[ $key ] ) && ! empty( $field['required'] ) ) {
                        continue 2;
                    }
                }
                $items[] = $item;
            }
        }
        return $items;
    }

    /**
     * Get the value of a posted repeated field
     * @since  1.22.4
     * @param  string $key
     * @param  array $field
     * @return string
     */
    function get_posted_repeated_field( $key, $field ) {
        return apply_filters( 'submit_job_form_fields_get_repeated_field_data', $this->get_repeated_field( $key, $field['fields'] ) );
    }
}
new Front_WPJM_Form();