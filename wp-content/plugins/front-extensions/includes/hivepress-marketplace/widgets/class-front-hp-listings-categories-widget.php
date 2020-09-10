<?php
/*-----------------------------------------------------------------------------------*/
/*  Listings Categories Widget Class
/*-----------------------------------------------------------------------------------*/
class Front_HP_Listings_Categories_Widget extends WP_Widget {

    /**
     * category ancestors.
     *
     * @var array
     */
    public $category_ancestors;

    /**
     * Current category.
     *
     * @var bool
     */
    public $current_category;

    public $settings;

    public function __construct() {

        $this->settings           = array(
            'title'              => array(
                'type'  => 'text',
                'std'   => __( 'Listings categories', 'front-extensions' ),
                'label' => __( 'Title', 'front-extensions' ),
            ),
            'orderby'            => array(
                'type'    => 'select',
                'std'     => 'name',
                'label'   => __( 'Order by', 'front-extensions' ),
                'options' => array(
                    'order' => __( 'category order', 'front-extensions' ),
                    'name'  => __( 'Name', 'front-extensions' ),
                ),
            ),
            'count'              => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Show counts', 'front-extensions' ),
            ),
            'hierarchical'       => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => __( 'Show hierarchy', 'front-extensions' ),
            ),
            'show_children_only' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Only show children of the current category', 'front-extensions' ),
            ),
            'hide_empty'         => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Hide empty categories', 'front-extensions' ),
            ),
            'max_depth'          => array(
                'type'  => 'text',
                'std'   => '',
                'label' => __( 'Maximum depth', 'front-extensions' ),
            ),
        );

        $widget_ops = array(
            'classname'   => 'front_hp_listings_categories_widget',
            'description' => esc_html__( 'A list of listings categories.', 'front-extensions' )
        );

        parent::__construct( 'front_hp_listings_categories_widget', esc_html__('Front HP Listing Categories Widget', 'front-extensions'), $widget_ops );
    }

    public function widget( $args, $instance ) {
        global $wp_query, $post;

        $cache = wp_cache_get( 'front_hp_listings_categories_widget', 'widget' );

        if ( !is_array( $cache ) )
            $cache = array();

        if ( isset( $cache[$args['widget_id']] ) ) {
            echo wp_kses_post( $cache[$args['widget_id']] );
            return;
        }

        if ( $cache ) {
            ob_start();
        }

        $count              = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
        $hierarchical       = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
        $show_children_only = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : $this->settings['show_children_only']['std'];
        $orderby            = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
        $hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];

        $list_args          = array(
            'show_count'   => $count,
            'hierarchical' => $hierarchical,
            'taxonomy'     => 'hp_listing_category',
            'hide_empty'   => $hide_empty,
        );
        $max_depth          = absint( isset( $instance['max_depth'] ) ? $instance['max_depth'] : $this->settings['max_depth']['std'] );

        $list_args['menu_order'] = false;
        $list_args['depth']      = $max_depth;

        if ( 'order' === $orderby ) {
            $list_args['menu_order'] = 'asc';
        } else {
            $list_args['orderby'] = 'title';
        }

        $this->current_category   = false;
        $this->category_ancestors = array();

        if ( is_tax( 'hp_listing_category' ) ) {
            $this->current_category   = $wp_query->queried_object;
            $this->category_ancestors = get_ancestors( $this->current_category->term_id, 'hp_listing_category' );
        }

        // Show Siblings and Children Only.
        if ( $show_children_only && $this->current_category ) {
            if ( $hierarchical ) {
                $include = array_merge(
                    $this->category_ancestors,
                    array( $this->current_category->term_id ),
                    get_terms(
                        'hp_listing_category',
                        array(
                            'fields'       => 'ids',
                            'parent'       => 0,
                            'hierarchical' => true,
                            'hide_empty'   => false,
                        )
                    ),
                    get_terms(
                        'hp_listing_category',
                        array(
                            'fields'       => 'ids',
                            'parent'       => $this->current_category->term_id,
                            'hierarchical' => true,
                            'hide_empty'   => false,
                        )
                    )
                );
                // Gather siblings of ancestors.
                if ( $this->category_ancestors ) {
                    foreach ( $this->category_ancestors as $ancestor ) {
                        $include = array_merge(
                            $include, get_terms(
                                'hp_listing_category',
                                array(
                                    'fields'       => 'ids',
                                    'parent'       => $ancestor,
                                    'hierarchical' => false,
                                    'hide_empty'   => false,
                                )
                            )
                        );
                    }
                }
            } else {
                // Direct children.
                $include = get_terms(
                    'hp_listing_category',
                    array(
                        'fields'       => 'ids',
                        'parent'       => $this->current_category->term_id,
                        'hierarchical' => true,
                        'hide_empty'   => false,
                    )
                );
            }

            $list_args['include']     = implode( ',', $include );

            if ( empty( $include ) ) {
                return;
            }
        } elseif ( $show_children_only ) {
            $list_args['depth']            = 1;
            $list_args['child_of']         = 0;
            $list_args['hierarchical']     = 1;
        }

        $list_args['title_li']                   = '';
        $list_args['pad_counts']                 = 1;
        $list_args['show_option_none']           = __( 'No categories exist.', 'front-extensions' );
        $list_args['current_category']           = ( $this->current_category ) ? $this->current_category->term_id : '';
        $list_args['current_category_ancestors'] = $this->category_ancestors;
        $list_args['max_depth']                  = $max_depth;

        echo wp_kses_post( $args['before_widget'] );

        if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base ) ) {
            echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
        }

        echo '<ul class="categories">';

        wp_list_categories( apply_filters( 'front_hp_listings_categories_widget_list_args', $list_args, $instance ) );

        echo '</ul>';

        echo wp_kses_post( $args['after_widget'] );

        if ( $cache ) {
            $cache[$args['widget_id']] = ob_get_flush();
        }
        wp_cache_set( 'front_hp_listings_categories_widget', $cache, 'widget' );
    }

    public function flush_widget_cache() {

        wp_cache_delete( 'front_hp_listings_categories_widget', 'front-extensions' );

    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        if ( empty( $this->settings ) ) {
            return $instance;
        }

        // Loop settings and get values to save.
        foreach ( $this->settings as $key => $setting ) {
            if ( ! isset( $setting['type'] ) ) {
                continue;
            }

            // Format the value based on settings type.
            switch ( $setting['type'] ) {
                case 'number':
                    $instance[ $key ] = absint( $new_instance[ $key ] );

                    if ( isset( $setting['min'] ) && '' !== $setting['min'] ) {
                        $instance[ $key ] = max( $instance[ $key ], $setting['min'] );
                    }

                    if ( isset( $setting['max'] ) && '' !== $setting['max'] ) {
                        $instance[ $key ] = min( $instance[ $key ], $setting['max'] );
                    }
                    break;
                case 'textarea':
                    $instance[ $key ] = wp_kses( trim( wp_unslash( $new_instance[ $key ] ) ), wp_kses_allowed_html( 'post' ) );
                    break;
                case 'checkbox':
                    $instance[ $key ] = empty( $new_instance[ $key ] ) ? 0 : 1;
                    break;
                default:
                    $instance[ $key ] = isset( $new_instance[ $key ] ) ? sanitize_text_field( $new_instance[ $key ] ) : $setting['std'];
                    break;
            }

            /**
             * Sanitize the value of a setting.
             */
            $instance[ $key ] = apply_filters( 'front_hp_listings_categories_widget_settings_sanitize_option', $instance[ $key ], $new_instance, $key, $setting );
        }

        $this->flush_widget_cache();

        return $instance;
    }

    public function form( $instance ) {

        if ( empty( $this->settings ) ) {
            return;
        }

        foreach ( $this->settings as $key => $setting ) {

            $class = isset( $setting['class'] ) ? $setting['class'] : '';
            $value = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting['std'];

            switch ( $setting['type'] ) {

                case 'text':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; ?></label><?php // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped ?>
                        <input class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" />
                    </p>
                    <?php
                    break;

                case 'number':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                        <input class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="number" step="<?php echo esc_attr( $setting['step'] ); ?>" min="<?php echo esc_attr( $setting['min'] ); ?>" max="<?php echo esc_attr( $setting['max'] ); ?>" value="<?php echo esc_attr( $value ); ?>" />
                    </p>
                    <?php
                    break;

                case 'select':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                        <select class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>">
                            <?php foreach ( $setting['options'] as $option_key => $option_value ) : ?>
                                <option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $value ); ?>><?php echo esc_html( $option_value ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <?php
                    break;

                case 'textarea':
                    ?>
                    <p>
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                        <textarea class="widefat <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" cols="20" rows="3"><?php echo esc_textarea( $value ); ?></textarea>
                        <?php if ( isset( $setting['desc'] ) ) : ?>
                            <small><?php echo esc_html( $setting['desc'] ); ?></small>
                        <?php endif; ?>
                    </p>
                    <?php
                    break;

                case 'checkbox':
                    ?>
                    <p>
                        <input class="checkbox <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="checkbox" value="1" <?php checked( $value, 1 ); ?> />
                        <label for="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"><?php echo $setting['label']; /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?></label>
                    </p>
                    <?php
                    break;

                // Default: run an action.
                default:
                    do_action( 'front_hp_listings_categories_widget_field_' . $setting['type'], $key, $value, $setting, $instance );
                    break;
            }
        }
    }
}