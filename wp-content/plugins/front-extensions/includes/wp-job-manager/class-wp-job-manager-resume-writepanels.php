<?php

class Front_WPJM_Resume_Writepanels {
    public function __construct() {
        add_filter( 'resume_manager_resume_fields', array( $this, 'resume_manager_resume_fields' ) );
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'resume_manager_save_resume', array( $this, 'save_resume_data' ), 1, 2 );

    }

    function resume_manager_resume_fields( $fields ) {
        $fields['_candidate_pay_scale'] = array(
            'label'       => __( 'Salary', 'front-extensions' ),
            'placeholder' => __( 'expected salery per hr/m/a', 'front-extensions' ),
        );
        $fields['_candidate_work_done'] = array(
            'label'       => __( 'Jobs Done', 'front-extensions' ),
            'placeholder' => __( 'works done yet', 'front-extensions' ),
        );
        $fields['_candidate_success_rate'] = array(
            'label'       => __( 'Success rate', 'front-extensions' ),
            'placeholder' => __( 'rate of successful jobs yet', 'front-extensions' ),
        );
        $fields['_candidate_clients'] = array(
            'label'       => __( 'Clients', 'front-extensions' ),
            'placeholder' => __( 'number clients you worked with', 'front-extensions' ),
        );
        $fields['_candidate_website'] = array(
            'label'       => __( 'Website', 'front-extensions' ),
            'placeholder' => __( 'your website link', 'front-extensions' ),
        );
        $fields['_candidate_twitter'] = array(
            'label'       => __( 'Twitter', 'front-extensions' ),
            'placeholder' => __( 'your twitter page link', 'front-extensions' ),
        );
        $fields['_candidate_facebook'] = array(
            'label'       => __( 'Facebook', 'front-extensions' ),
            'placeholder' => __( 'your facebook page link', 'front-extensions' ),
        );
        $fields['_candidate_bio'] = array(
            'label'       => __( 'Candidate Bio', 'front-extensions' ),
            'type'        => 'textarea',
            'placeholder' => __( 'write short notes about your self', 'front-extensions' ),
        );
        return $fields;
    }

    public function add_meta_boxes() {
        add_meta_box( 'candidate_reward_data', esc_html__( 'Rewards', 'front-extensions' ), array( $this, 'reward_data' ), 'resume', 'normal' );
        add_meta_box( 'candidate_language_data', esc_html__( 'Languages', 'front-extensions' ), array( $this, 'language_data' ), 'resume', 'normal' );
    }

    public function reward_data( $post ) {
        $fields = $this->candidate_reward_fields();
        WP_Resume_Manager_Writepanels::repeated_rows_html( esc_html__( 'Rewards', 'front-extensions' ), $fields, get_post_meta( $post->ID, '_candidate_rewards', true ) );
    }

    public function language_data( $post ) {
        $fields = $this->candidate_language_fields();
        WP_Resume_Manager_Writepanels::repeated_rows_html( esc_html__( 'Languages', 'front-extensions' ), $fields, get_post_meta( $post->ID, '_candidate_languages', true ) );
    }

    public function candidate_reward_fields() {
        return apply_filters( 'resume_manager_candidate_reward_fields', array(
            'reward_title' => array(
                'label'       => __( 'Reward Title', 'front-extensions' ),
                'name'        => 'candidate_reward_title[]',
                'placeholder' => '',
                'description' => '',
                'required'    => true,
            ),
            'reward_image' => array(
                'label'       => __( 'Reward Image', 'front-extensions' ),
                'name'        => 'candidate_reward_date[]',
                'type'        => 'file',
                'required'    => true,
            ),
        ) );
    }

    public function candidate_language_fields() {
        return apply_filters( 'resume_manager_candidate_language_fields', array(
            'language_name' => array(
                'label'       => __( 'Language', 'front-extensions' ),
                'name'        => 'candidate_language_name[]',
                'placeholder' => '',
                'description' => ''
            ),
            'language_level' => array(
                'label'       => __( 'Level of known', 'front-extensions' ),
                'name'        => 'candidate_language_level[]',
                'placeholder' => '',
                'description' => ''
            ),
        ) );
    }

    public function save_resume_data( $post_id, $post ) {
        global $wpdb;

        $save_repeated_fields = array(
            '_candidate_rewards' => $this->candidate_reward_fields(),
            '_candidate_languages' => $this->candidate_language_fields(),
        );

        foreach ( $save_repeated_fields as $meta_key => $fields ) {
            WP_Resume_Manager_Writepanels::save_repeated_row( $post_id, $meta_key, $fields );
        }
    }
}

new Front_WPJM_Resume_Writepanels();