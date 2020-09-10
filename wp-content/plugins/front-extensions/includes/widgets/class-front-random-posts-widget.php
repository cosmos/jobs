<?php
/*-----------------------------------------------------------------------------------*/
/*  Random Posts Widget Class
/*-----------------------------------------------------------------------------------*/
class Front_Random_Posts_Widget extends WP_Widget {

    public $defaults;

    public function __construct() {

        $widget_ops = array(
            'classname'   => 'front_posts_widget',
            'description' => esc_html__( 'Your site&#8217;s most random Posts.', 'front-extensions' )
        );

        parent::__construct( 'front_random_posts_widget', esc_html__('Front Posts Widget', 'front-extensions'), $widget_ops );
    }

    public function widget( $args, $instance ) {

        global $post;

        if ( is_object( $post ) ) {
            $current_post_id = $post->ID;
        } else {
            $current_post_id = 0;
        }

        $cache = wp_cache_get( 'widget_random_posts', 'widget' );

        if ( !is_array( $cache ) )
            $cache = array();

        if ( isset( $cache[$args['widget_id']] ) ) {
            echo wp_kses_post( $cache[$args['widget_id']] );
            return;
        }

        if ( $cache ) {
            ob_start();
        }

        extract( $args );

        $title   = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $number  = empty($instance['number']) ? -1 : $instance['number'];
        $sticky  = $instance['sticky'];
        $order   = $instance['order'];
        $orderby = $instance['orderby'];
        $meta_key = $instance['meta_key'];

        if( ! empty( $instance['cats'] ) ) {
            $cats = is_array( $instance['cats'] ) ? explode( ',', $instance['cats'] ) : $instance['cats'];
        }

        // Sticky posts
        if ($sticky == 'only') {
            $sticky_query = array( 'post__in' => get_option( 'sticky_posts' ) );
        } elseif ($sticky == 'hide') {
            $sticky_query = array( 'post__not_in' => get_option( 'sticky_posts' ) );
        } else {
            $sticky_query = null;
        }

        echo wp_kses_post( $before_widget );

        if ( $title ) {
            echo wp_kses_post( $before_title );
            echo wp_kses_post( $title );
            echo wp_kses_post( $after_title );
        }

        $args = array(
            'posts_per_page' => $number,
            'order'          => $order,
            'orderby'        => $orderby,
            'post_type'      => 'post'
        );

        if( ! empty( $cats ) ) {
            $args['category__in'] = $cats;
        }

        if ( $orderby === 'meta_value' ) {
            $args['meta_key'] = $meta_key;
        }

        if (!empty($sticky_query)) {
            $args[key($sticky_query)] = reset($sticky_query);
        }

        $args = apply_filters('fpw_wp_query_args', $args, $instance, $this->id_base);

        $fpw_query = new WP_Query($args);

        front_get_template( 'widgets/front-posts-widget.php', array( 'fpw_query' => $fpw_query, 'args' => $args,'instance' => $instance, 'current_post_id' => $current_post_id ) );

        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        echo wp_kses_post( $after_widget );

        if ( $cache ) {
            $cache[$args['widget_id']] = ob_get_flush();
        }
        wp_cache_set( 'widget_random_posts', $cache, 'widget' );
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']   = strip_tags( $new_instance['title'] );
        $instance['number']  = strip_tags( $new_instance['number'] );
        $instance['cats']    = (isset( $new_instance['cats'] )) ? implode(',', (array) $new_instance['cats']) : '';
        $instance['sticky']  = $new_instance['sticky'];
        $instance['order']   = $new_instance['order'];
        $instance['orderby'] = $new_instance['orderby'];
        $instance['meta_key'] = $new_instance['meta_key'];

        if (current_user_can('unfiltered_html')) {
            $instance['before_posts'] =  $new_instance['before_posts'];
            $instance['after_posts']  =  $new_instance['after_posts'];
        } else {
            $instance['before_posts'] = wp_filter_post_kses($new_instance['before_posts']);
            $instance['after_posts']  = wp_filter_post_kses($new_instance['after_posts']);
        }

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset( $alloptions['front_posts_widget'] ) )
            delete_option( 'front_posts_widget' );

        return $instance;
    }

    public function flush_widget_cache() {

        wp_cache_delete( 'front_posts_widget', 'front-extensions' );

    }

    public function form( $instance ) {

        // Set default arguments
        $instance = wp_parse_args( (array) $instance, array(
            'title'   => esc_html__( 'Front Post Widget', 'front-extensions' ),
            'number'  => '3',
            'cats'    => '',
            'order'   => 'DESC',
            'orderby' => 'date',
            'meta_key' => '',
            'sticky'  => 'show',
        ) );

        // Or use the instance
        $title   = strip_tags( $instance['title'] );
        $number  = strip_tags( $instance['number'] );
        $cats    = $instance['cats'];
        $order   = $instance['order'];
        $orderby = $instance['orderby'];
        $meta_key = $instance['meta_key'];
        $sticky  = $instance['sticky'];

        // Let's turn  $cats into an array if they are set
        if ( ! empty( $cats ) && ! is_array( $cats ) ) $cats = explode( ',', $cats );


        // Count number of categories for select box sizing
        $cat_list = get_categories( 'hide_empty=0' );
        if ($cat_list) {
            foreach ($cat_list as $cat) {
                $cat_ar[] = $cat;
            }
            $c = count($cat_ar);
            if($c > 6) { $c = 6; }
        } else {
            $c = 3;
        } ?>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title', 'front-extensions' ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php echo esc_html__( 'Number of posts', 'front-extensions' ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" value="<?php echo esc_attr( $number ); ?>" min="-1" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('cats') ); ?>"><?php echo esc_html__( 'Categories', 'front-extensions' ); ?>:</label>
                <select name="<?php echo esc_attr( $this->get_field_name('cats') ); ?>[]" id="<?php echo esc_attr( $this->get_field_id('cats') ); ?>" class="widefat" style="height: auto;" size="<?php echo esc_attr( $c ); ?>" multiple>
                    <option value="" <?php if (empty($cats)) echo 'selected="selected"'; ?>><?php echo esc_html__( '&ndash; Show All &ndash;', 'front-extensions' ); ?></option>
                    <?php
                    $categories = get_categories( 'hide_empty=0' );
                    foreach ( $categories as $category ) { ?>
                        <option value="<?php echo esc_attr( $category->term_id ); ?>" <?php if( is_array( $cats ) && in_array( $category->term_id, $cats ) ) echo 'selected="selected"'; ?>><?php echo esc_html( $category->cat_name ); ?></option>
                    <?php } ?>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('sticky') ); ?>"><?php echo esc_html__( 'Sticky posts', 'front-extensions' ); ?>:</label>
                <select name="<?php echo esc_attr( $this->get_field_name('sticky') ); ?>" id="<?php echo esc_attr( $this->get_field_id('sticky') ); ?>" class="widefat">
                    <option value="show"<?php if( $sticky === 'show') echo ' selected'; ?>><?php echo esc_html__( 'Show All Posts', 'front-extensions' ); ?></option>
                    <option value="hide"<?php if( $sticky == 'hide') echo ' selected'; ?>><?php echo esc_html__( 'Hide Sticky Posts', 'front-extensions' ); ?></option>
                    <option value="only"<?php if( $sticky == 'only') echo ' selected'; ?>><?php echo esc_html__( 'Show Only Sticky Posts', 'front-extensions' ); ?></option>
                </select>
            </p>


            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('orderby') ); ?>"><?php echo esc_html__( 'Order by', 'front-extensions' ); ?>:</label>
                <select name="<?php echo esc_attr( $this->get_field_name('orderby') ); ?>" id="<?php echo esc_attr( $this->get_field_id('orderby') ); ?>" class="widefat">
                    <option value="date"<?php if( $orderby == 'date') echo ' selected'; ?>><?php echo esc_html__( 'Published Date', 'front-extensions' ); ?></option>
                    <option value="title"<?php if( $orderby == 'title') echo ' selected'; ?>><?php echo esc_html__( 'Title', 'front-extensions' ); ?></option>
                    <option value="comment_count"<?php if( $orderby == 'comment_count') echo ' selected'; ?>><?php echo esc_html__( 'Comment Count', 'front-extensions' ); ?></option>
                    <option value="rand"<?php if( $orderby == 'rand') echo ' selected'; ?>><?php echo esc_html__( 'Random', 'front-extensions' ); ?></option>
                    <option value="meta_value"<?php if( $orderby == 'meta_value') echo ' selected'; ?>><?php echo esc_html__( 'Custom Field', 'front-extensions' ); ?></option>
                    <option value="menu_order"<?php if( $orderby == 'menu_order') echo ' selected'; ?>><?php echo esc_html__( 'Menu Order', 'front-extensions' ); ?></option>
                </select>
            </p>

            <p<?php if ($orderby !== 'meta_value') echo ' style="display:none;"'; ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'meta_key' ) ); ?>"><?php echo esc_html__( 'Custom field', 'front-extensions' ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('meta_key') ); ?>" name="<?php echo esc_attr( $this->get_field_name('meta_key') ); ?>" type="text" value="<?php echo esc_attr( $meta_key ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('order') ); ?>"><?php echo esc_html__( 'Order', 'front-extensions' ); ?>:</label>
                <select name="<?php echo esc_attr( $this->get_field_name('order') ); ?>" id="<?php echo esc_attr( $this->get_field_id('order') ); ?>" class="widefat">
                    <option value="DESC"<?php if( $order == 'DESC') echo ' selected'; ?>><?php echo esc_html__( 'Descending', 'front-extensions' ); ?></option>
                    <option value="ASC"<?php if( $order == 'ASC') echo ' selected'; ?>><?php echo esc_html__( 'Ascending', 'front-extensions' ); ?></option>
                </select>
            </p>
        <?php
    }
}