<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'WP_Job_Manager_Writepanels' ) ) {
    include( JOB_MANAGER_PLUGIN_DIR . '/includes/admin/class-wp-job-manager-writepanels.php' );
}

class Front_WPJM_Job_Writepanels extends WP_Job_Manager_Writepanels {

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {
        add_filter( 'job_manager_job_listing_data_fields', array( $this, 'job_manager_job_listing_data_fields' ) );
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post' ), 1, 2 );
        add_action( 'job_manager_save_job_listing', array( $this, 'save_job_listing_data' ), 30, 3 );
    }

    /**
     * job_manager_job_listing_data_fields function.
     */
    public function job_manager_job_listing_data_fields( $fields ) {
        $fields['_job_about'] = array(
            'label'         => __( 'About Job', 'front-extensions' ),
            'type'          => 'textarea',
            'placeholder'   => __( 'short description about job', 'front-extensions' ),
            'priority'      => 0,
        );

        $fields['_contact_address'] = array(
            'label'       => esc_html__( 'Contact Address', 'front-extensions' ),
            'type'        => 'textarea',
            'placeholder' => esc_html__( 'Enter contact address', 'front-extensions' ),
            'priority'    => 0,
        );

        $fields['_contact_email'] = array(
            'label'       => esc_html__( 'Contact Email', 'front-extensions' ),
            'placeholder' => esc_html__( 'e.g. "yourname@domain.com"', 'front-extensions' ),
            'priority'    => 1,
        );

        $fields['_contact_phone'] = array(
            'label'       => esc_html__( 'Contact No.', 'front-extensions' ),
            'placeholder' => esc_html__( 'company phone number', 'front-extensions' ),
            'priority'    => 1,
        );

        $fields['_job_qualification'] = array(
            'label'       => esc_html__( 'Qualification', 'front-extensions' ),
            'placeholder' => esc_html__( 'Qualification for apply this job', 'front-extensions' ),
            'priority'    => 2,
        );

        $fields['_company_about'] = array(
            'label'       => esc_html__( 'About Company', 'front-extensions' ),
            'type'          => 'textarea',
            'placeholder' => esc_html__( 'short description about company', 'front-extensions' ),
            'priority'    => 4,
        );

        return $fields;
    }

    /**
     * add_meta_boxes function.
     */
    public function add_meta_boxes() {
        add_meta_box( 'job_listing_responsibility_data', __( 'Responsibilties', 'front-extensions' ), array( $this, 'responsibility_data' ), 'job_listing', 'normal', 'low' );
        add_meta_box( 'job_listing_requirement_data', __( 'Requirements', 'front-extensions' ), array( $this, 'requirement_data' ), 'job_listing', 'normal', 'low' );
        add_meta_box( 'job_listing_bonus_point_data', __( 'Bonus Points', 'front-extensions' ), array( $this, 'bonus_point_data' ), 'job_listing', 'normal', 'low' );
    }

    /**
     * Output repeated rows
     */
    public static function repeated_rows_html( $group_name, $fields, $data ) {
        ?>
        <table class="wp-job-manager-repeated-rows">
            <thead>
                <tr>
                    <th class="sort-column">&nbsp;</th>
                    <?php foreach ( $fields as $field ) : ?>
                        <th><label><?php echo esc_html( $field['label'] ); ?></label></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="<?php echo sizeof( $fields ) + 1; ?>">
                        <div class="submit">
                            <input type="submit" class="button job_manager_add_row" value="<?php printf( __( 'Add %s', 'front-extensions' ), $group_name ); ?>" data-row="<?php
                                ob_start();
                                echo '<tr>';
                                echo '<td class="sort-column" width="1%">&nbsp;</td>';
                                foreach ( $fields as $key => $field ) {
                                    echo '<td>';
                                    $type           = ! empty( $field['type'] ) ? $field['type'] : 'text';
                                    $field['value'] = '';

                                    if ( method_exists( __CLASS__, 'input_' . $type ) ) {
                                        call_user_func( array( __CLASS__, 'input_' . $type ), $key, $field );
                                    } else {
                                        do_action( 'job_manager_input_' . $type, $key, $field );
                                    }
                                    echo '</td>';
                                }
                                echo '</tr>';
                                echo esc_attr( ob_get_clean() );
                            ?>" />
                        </div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <?php
                    if ( $data ) {
                        foreach ( $data as $item ) {
                            echo '<tr>';
                            echo '<td class="sort-column" width="1%">&nbsp;</td>';
                            foreach ( $fields as $key => $field ) {
                                echo '<td>';
                                $type           = ! empty( $field['type'] ) ? $field['type'] : 'text';
                                $field['value'] = isset( $item[ $key ] ) ? $item[ $key ] : '';

                                if ( method_exists( __CLASS__, 'input_' . $type ) ) {
                                    call_user_func( array( __CLASS__, 'input_' . $type ), $key, $field );
                                } else {
                                    do_action( 'job_manager_input_' . $type, $key, $field );
                                }
                                echo '</td>';
                            }
                            echo '</tr>';
                        }
                    }
                ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Resume fields
     * @return array
     */
    public static function job_listing_responsibility_fields() {
        return apply_filters( 'job_manager_job_listing_responsibility_fields', array(
            'notes' => array(
                'label'       => __( 'Responsibilty', 'front-extensions' ),
                'name'        => 'job_listing_responsibility_notes[]',
                'placeholder' => '',
                'description' => '',
                'type'        => 'textarea',
                'required'    => true,
            )
        ) );
    }

    public static function job_listing_requirement_fields() {
        return apply_filters( 'job_manager_job_listing_requirement_fields', array(
            'notes' => array(
                'label'       => __( 'Requirement', 'front-extensions' ),
                'name'        => 'job_listing_requirement_notes[]',
                'placeholder' => '',
                'description' => '',
                'type'        => 'textarea',
                'required'    => true,
            )
        ) );
    }

    public static function job_listing_bonus_point_fields() {
        return apply_filters( 'job_manager_job_listing_bonus_point_fields', array(
            'notes' => array(
                'label'       => __( 'Bonus Points', 'front-extensions' ),
                'name'        => 'job_listing_bonus_point_notes[]',
                'placeholder' => '',
                'description' => '',
                'type'        => 'textarea',
                'required'    => true,
            )
        ) );
    }

    /**
     * Job Resposibility data
     *
     * @param mixed $post
     */
    public function responsibility_data( $post ) {
        $fields = $this->job_listing_responsibility_fields();
        $this->repeated_rows_html( __( 'Responsibilities', 'front-extensions' ), $fields, get_post_meta( $post->ID, '_job_responsibility', true ) );
    }

    /**
     * Job Requirement data
     *
     * @param mixed $post
     */
    public function requirement_data( $post ) {
        $fields = $this->job_listing_requirement_fields();
        $this->repeated_rows_html( __( 'Reqiurements', 'front-extensions' ), $fields, get_post_meta( $post->ID, '_job_requirement', true ) );
    }

    /**
     * Job Bonus Point data
     *
     * @param mixed $post
     */
    public function bonus_point_data( $post ) {
        $fields = $this->job_listing_bonus_point_fields();
        $this->repeated_rows_html( __( 'Bonus Points', 'front-extensions' ), $fields, get_post_meta( $post->ID, '_job_bonus_point', true ) );
    }

    /**
     * Triggered on Save Post
     *
     * @param mixed $post_id
     * @param mixed $post
     */
    public function save_post( $post_id, $post ) {
        if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) {
            return;
        }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        if ( is_int( wp_is_post_revision( $post ) ) ) {
            return;
        }
        if ( is_int( wp_is_post_autosave( $post ) ) ) {
            return;
        }
        if ( empty( $_POST['job_manager_nonce'] ) || ! wp_verify_nonce( $_POST['job_manager_nonce'], 'save_meta_data' ) ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        if ( 'job_listing' !== $post->post_type ) {
            return;
        }

        do_action( 'job_manager_save_job_listing', $post_id, $post );
    }

    /**
     * Save Job Meta
     *
     * @param mixed $post_id
     * @param mixed $post
     */
    public function save_job_listing_data( $post_id, $post ) {
        $save_repeated_fields = array(
            '_job_responsibility'  => $this->job_listing_responsibility_fields(),
            '_job_requirement' => $this->job_listing_requirement_fields(),
            '_job_bonus_point' => $this->job_listing_bonus_point_fields(),
        );

        foreach ( $save_repeated_fields as $meta_key => $fields ) {
            $this->save_repeated_row( $post_id, $meta_key, $fields );
        }
    }

    /**
     * Save repeated rows
     */
    public static function save_repeated_row( $post_id, $meta_key, $fields ) {
        $items            = array();
        $first_field      = current( $fields );
        $first_field_name = str_replace( '[]', '', $first_field['name'] );

        if ( ! empty( $_POST[ $first_field_name ] ) && is_array( $_POST[ $first_field_name ] ) ) {
            $keys = array_keys( $_POST[ $first_field_name ] );
            foreach ( $keys as $posted_key ) {
                $item = array();
                foreach ( $fields as $key => $field ) {
                    $input_name = str_replace( '[]', '', $field['name'] );
                    $type       = ! empty( $field['type'] ) ? $field['type'] : 'text';

                    switch ( $type ) {
                        case 'textarea' :
                            $item[ $key ] = wp_kses_post( stripslashes( $_POST[ $input_name ][ $posted_key ] ) );
                        break;
                        default :
                            if ( is_array( $_POST[ $input_name ][ $posted_key ] ) ) {
                                $item[ $key ] = array_filter( array_map( 'sanitize_text_field', array_map( 'stripslashes', $_POST[ $input_name ][ $posted_key ] ) ) );
                            } else {
                                $item[ $key ] = sanitize_text_field( stripslashes( $_POST[ $input_name ][ $posted_key ] ) );
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
        update_post_meta( $post_id, $meta_key, $items );
    }
}

new Front_WPJM_Job_Writepanels();