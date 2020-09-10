<?php
/**
 * Listings Attributes Filter widget
 *
 * @package Widgets
 * @version 1.0.0
 */

use HivePress\Helpers as hp;

defined( 'ABSPATH' ) || exit;

/**
 * Widget Listings Attributes Filter class.
 */
class Front_HP_Listings_Attributes_Filter_Widget extends WP_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $widget_ops = array( 'description' => esc_html__( 'Add HP listings attributes filter widgets to your sidebar.', 'front-extensions' ) );
        parent::__construct( 'front_hp_listings_attributes_filter', esc_html__( 'Front HP Listings Attributes Filter', 'front-extensions' ), $widget_ops );
    }

    /**
     * Updates a particular instance of a widget.
     *
     * @see WP_Widget->update
     *
     * @param array $new_instance New Instance.
     * @param array $old_instance Old Instance.
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
        }
        return $instance;
    }

    /**
     * Outputs the settings update form.
     *
     * @see WP_Widget->form
     *
     * @param array $instance Instance.
     */
    public function form( $instance ) {
        global $wp_registered_sidebars;

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Filters', 'front-extensions' );

        // If no sidebars exists.
        if ( ! $wp_registered_sidebars ) {
            echo '<p>'. esc_html__('No sidebars are available.', 'front-extensions' ) .'</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'front-extensions' ) ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args Arguments.
     * @param array $instance Instance.
     */
    public function widget( $args, $instance ) {
        ob_start();

        echo wp_kses_post( $args['before_widget'] );

        if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
            echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
        }

        $this->output();

        echo wp_kses_post( $args['after_widget'] );

        echo ob_get_clean();
    }

    /**
     * Return the available filter values.
     *
     * @return string
     */
    protected function get_available_filters() {
        // Get model.
        $model = 'listing';

        // Get category IDs.
        $category_ids = wp_get_post_terms( get_the_ID(), hp\prefix( $model . '_category' ), [ 'fields' => 'ids' ] );

        $attribute_obj = hivepress()->get_components()['attribute'];
        $attributes = $attribute_obj->get_attributes( $model, $category_ids );

        $args = array();

        if( ! empty( $attributes ) && is_array( $attributes ) && ! is_wp_error( $attributes ) ) {
            foreach ( $attribute_obj->get_attributes( $model, $category_ids ) as $attribute_name => $attribute ) {
                if ( ! $attribute['protected'] && ! isset( $meta_box['fields'][ $attribute_name ] ) && ! isset( $attribute['edit_field']['options'] ) && ( isset( $attribute['edit_field']['type'] ) && $attribute['edit_field']['type'] === 'checkbox' ) ) {
                    $args[$attribute_name] = $attribute['label'];
                }
            }
        }

        return apply_filters( 'front_hp_listings_attributes_filter_widget_avilable_filter_options', $args );
    }

    /**
     * Show verifcation list html.
     *
     * @param  array  $terms Terms.
     * @param  string $taxonomy Taxonomy.
     * @param  string $query_type Query Type.
     * @return bool   Will nav display?
     */
    protected function output() {
        if ( function_exists( 'front_hp_is_listing_taxonomy' ) && front_hp_is_listing_taxonomy() ) {
            $queried_object = get_queried_object();
            $current_url = get_term_link( $queried_object->slug, $queried_object->taxonomy );
        } else {
            $current_url = get_post_type_archive_link( 'hp_listing' );
        }

        $avilable_filter_options = $this->get_available_filters();

        if( isset( $_GET ) ) {
            foreach( $_GET as $key => $value ) {
                if( $key !== 'pagename' && ! empty( $value ) ) {
                    $current_url = add_query_arg( $key, $value, $current_url );
                }
            }
        }

        $applied_filters = isset( $_GET['hp_listings_attributes'] ) ? explode( ',', front_clean( wp_unslash( $_GET['hp_listings_attributes'] ) ) ) : array();

        echo '<ul class="front-hp-listings-attributes-filter-widget list-group list-group-flush list-group-borderless mb-0">';
        foreach ( $avilable_filter_options as $value => $name ) {
            $active_class = '';
            if( ! empty( $applied_filters ) ) {
                $link = remove_query_arg( 'hp_listings_attributes', $current_url );
                $current_filters = $applied_filters;
                if( in_array( $value, $current_filters ) ) {
                    $active_class = ' active';
                    if ( ( $key = array_search( $value, $current_filters ) ) !== false ) {
                        unset( $current_filters[$key] );
                    }
                    if( ! empty( $current_filters ) ) {
                        $link = add_query_arg( 'hp_listings_attributes', implode( ',', $current_filters ), $link );
                    }
                } else {
                    $current_filters[] = $value;
                    $link = add_query_arg( 'hp_listings_attributes', implode( ',', $current_filters ), $link );
                }
            } else {
                $link = add_query_arg( 'hp_listings_attributes', $value, $current_url );
            }

            $link = str_replace( '%2C', ',', $link );

            ?><li><a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?php echo esc_attr( $active_class ); ?>" href="<?php echo esc_url( $link ); ?>"><?php
                echo esc_html( $name );
            ?></a></li><?php
        }
        echo '</ul>';
    }
}
