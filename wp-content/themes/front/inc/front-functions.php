<?php
/**
 * Front functions.
 *
 * @package front
 */

if( ! function_exists( 'front_is_ocdi_activated' ) ) {
    /**
     * Check if One Click Demo Import is activated
     */
    function front_is_ocdi_activated() {
        return class_exists( 'OCDI_Plugin' ) ? true : false;
    }
}

if ( ! function_exists( 'front_is_woocommerce_activated' ) ) {
    /**
     * Query WooCommerce activation
     */
    function front_is_woocommerce_activated() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
}

if ( ! function_exists( 'front_is_jetpack_activated' ) ) {
    /**
     * Query JetPack activation
     */
    function front_is_jetpack_activated() {
        return class_exists( 'Jetpack' ) ? true : false;
    }
}

if ( ! function_exists( 'front_is_redux_activated' ) ) {
    function front_is_redux_activated() {
        /**
         * Query Redux Framework activation
         */
        return class_exists( 'ReduxFramework' );
    }
}

if ( ! function_exists( 'front_is_wp_job_manager_activated' ) ) {
    /**
     * Query WP Job Mananger activation
     */
    function front_is_wp_job_manager_activated() {
        return class_exists( 'WP_Job_Manager' ) ? true : false;
    }
}

if ( ! function_exists( 'front_is_wp_resume_manager_activated' ) ) {
    /**
     * Check if WP Resume Manager is activated
     */
    function front_is_wp_resume_manager_activated() {
        return front_is_wp_job_manager_extension_activated( 'WP_Resume_Manager' );
    }
}

if ( ! function_exists( 'front_is_mas_wp_company_manager_activated' ) ) {
    /**
     * Check if MAS WP Job Manager Company is activated
     */
    function front_is_mas_wp_company_manager_activated() {
        return front_is_wp_job_manager_extension_activated( 'MAS_WP_Job_Manager_Company' );
    }
}

if ( ! function_exists( 'front_is_mas_wp_job_manager_company_review_activated' ) ) {
    /**
     * Check if MAS Reviews For Company is activated
     */
    function front_is_mas_wp_job_manager_company_review_activated() {
        return front_is_wp_job_manager_extension_activated( 'MAS_WP_Job_Manager_Company_Reviews' );
    }
}

if ( ! function_exists( 'front_is_wp_job_manager_applications_activated' ) ) {
    /**
     * Check if WP Job Manager Applications is activated
     */
    function front_is_wp_job_manager_applications_activated() {
        return front_is_wp_job_manager_extension_activated( 'WP_Job_Manager_Applications' );
    }
}

if ( ! function_exists( 'front_is_wp_job_manager_bookmarks_activated' ) ) {
    /**
     * Check if WP Job Manager Bookmarks is activated
     */
    function front_is_wp_job_manager_bookmarks_activated() {
        return front_is_wp_job_manager_extension_activated( 'WP_Job_Manager_Bookmarks' );
    }
}

if ( ! function_exists( 'front_is_wp_job_manager_alert_activated' ) ) {
    /**
     * Check if WP Job Manager Alerts is activated
     */
    function front_is_wp_job_manager_alert_activated() {
        return front_is_wp_job_manager_extension_activated( 'WP_Job_Manager_Alerts' );
    }
}

if ( ! function_exists( 'front_is_wp_job_manager_indeed_activated' ) ) {
    /**
     * Check if WP Job Manager Indeed is activated
     */
    function front_is_wp_job_manager_indeed_activated() {
        return front_is_wp_job_manager_extension_activated( 'WP_Job_Manager_Indeed_Integration' );
    }
}

if ( ! function_exists( 'front_is_wp_job_manager_ziprecruiter_activated' ) ) {
    /**
     * Check if WP Job Manager ZipRecruiter is activated
     */
    function front_is_wp_job_manager_ziprecruiter_activated() {
        return front_is_wp_job_manager_extension_activated( 'WP_Job_Manager_ZipRecruiter_Integration' );
    }
}

if ( ! function_exists( 'front_is_hivepress_activated' ) ) {
    /**
     * Check if HivePress is activated
     */
    function front_is_hivepress_activated() {
        return function_exists( 'hivepress' );
    }
}

/**
 * Query WP Job Manager Extension ( Add-ons ) Activation.
 * @var  $extension main extension class name
 * @return boolean
 */
function front_is_wp_job_manager_extension_activated( $extension ) {

    if( front_is_wp_job_manager_activated() ) {
        $is_activated = class_exists( $extension ) ? true : false;
    } else {
        $is_activated = false;
    }

    return $is_activated;
}

/**
 * Query WooCommerce Extension Activation.
 * @var  $extension main extension class name
 * @return boolean
 */
function front_is_woocommerce_extension_activated( $extension ) {

    if( front_is_woocommerce_activated() ) {
        $is_activated = class_exists( $extension ) ? true : false;
    } else {
        $is_activated = false;
    }

    return $is_activated;
}

if( ! function_exists( 'front_is_yith_wcwl_activated' ) ) {
    /**
     * Checks if YITH Wishlist is activated
     *
     * @return boolean
     */
    function front_is_yith_wcwl_activated() {
        return front_is_woocommerce_extension_activated( 'YITH_WCWL' );
    }
}

function front_can_show_post_thumbnail() {
    return apply_filters( 'front_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

if ( ! function_exists( 'front_is_wedocs_activated' ) ) {
    /**
     * Checks if WeDocs plugin is activated
     *
     * @return boolean
     */
    function front_is_wedocs_activated() {
        return class_exists( 'WeDocs' );
    }
}

if ( ! function_exists( 'front_is_mas_static_content_activated' ) ) {
    function front_is_mas_static_content_activated() {
        return class_exists( 'Mas_Static_Content' ) ? true : false;
    }
}

/**
 * @param WP_Query|null $wp_query
 * @param bool $echo
 *
 * @return string
 * Accepts a WP_Query instance to build pagination (for custom wp_query()),
 * or nothing to use the current global $wp_query (eg: taxonomy term page)
 * - Tested on WP 4.9.5
 * - Tested with Bootstrap 4.1
 * - Tested on Sage 9
 *
 * USAGE:
 *     <?php echo front_bootstrap_pagination(); ?> //uses global $wp_query
 * or with custom WP_Query():
 *     <?php
 *      $query = new \WP_Query($args);
 *       ... while(have_posts()), $query->posts stuff ...
 *       echo front_bootstrap_pagination($query);
 *     ?>
 */
function front_bootstrap_pagination( \WP_Query $wp_query = null, $echo = true, $ul_class = '' ) {

    if ( null === $wp_query ) {
        global $wp_query;
    }

    $pages = paginate_links( [
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'format'       => '?paged=%#%',
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'total'        => $wp_query->max_num_pages,
            'type'         => 'array',
            'show_all'     => false,
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => esc_html__( '&laquo; Prev', 'front' ),
            'next_text'    => esc_html__( 'Next &raquo;', 'front' ),
            'add_args'     => false,
            'add_fragment' => ''
        ]
    );

    if ( is_array( $pages ) ) {

        if ( ! empty( $ul_class ) ) {
            $ul_class = ' ' . $ul_class;
        }

        $pagination = '<nav aria-label="' . esc_attr__( 'Page navigation', 'front' ) . '"><ul class="pagination' . esc_attr( $ul_class ) . '">';

        foreach ( $pages as $page ) {
            $pagination .= '<li class="page-item ' . ( strpos( $page, 'current' ) !== false ? 'active' : '' ) . '">' . str_replace( 'page-numbers', 'page-link', $page ) . '</li>';
        }

        $pagination .= '</ul></nav>';

        if ( $echo ) {
            echo wp_kses_post( $pagination );
        } else {
            return $pagination;
        }
    }

    return null;
}

/**
 * Filters the default archive titles.
 */
function front_get_the_archive_title() {
    if ( is_category() ) {
        $title = esc_html__( 'Category Archives - ', 'front' ) . '<span class="page-description text-primary font-weight-semi-bold">' . single_term_title( '', false ) . '</span>';
    } elseif ( is_tag() ) {
        $title = esc_html__( 'Tag Archives - ', 'front' ) . '<span class="page-description text-primary font-weight-semi-bold">' . single_term_title( '', false ) . '</span>';
    } elseif ( is_author() ) {
        $title = esc_html__( 'Author Archives - ', 'front' ) . '<span class="page-description text-primary font-weight-semi-bold">' . get_the_author_meta( 'display_name' ) . '</span>';
    } elseif ( is_year() ) {
        $title = esc_html__( 'Yearly Archives - ', 'front' ) . '<span class="page-description text-primary font-weight-semi-bold">' . get_the_date( _x( 'Y', 'yearly archives date format', 'front' ) ) . '</span>';
    } elseif ( is_month() ) {
        $title = esc_html__( 'Monthly Archives - ', 'front' ) . '<span class="page-description text-primary font-weight-semi-bold">' . get_the_date( _x( 'F Y', 'monthly archives date format', 'front' ) ) . '</span>';
    } elseif ( is_day() ) {
        $title = esc_html__( 'Daily Archives - ', 'front' ) . '<span class="page-description text-primary font-weight-semi-bold">' . get_the_date() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = esc_html__( 'Post Type Archives - ', 'front' ) . '<span class="page-description text-primary font-weight-semi-bold">' . post_type_archive_title( '', false ) . '</span>';
    } elseif ( is_tax() ) {
        $tax = get_taxonomy( get_queried_object()->taxonomy );
        /* translators: %s: Taxonomy singular name */
        $title = sprintf( esc_html__( 'Archives - %s', 'front' ), '<span class="page-description text-primary font-weight-semi-bold">' . $tax->labels->singular_name . '</span>' );
    } elseif ( is_search() ) {
        $title = sprintf( esc_html__( 'Search results for - %s', 'front' ), '<span class="page-description text-primary font-weight-semi-bold">' . get_search_query() . '</span>' );
    } else {
        $title = esc_html__( 'Blog', 'front' );
    }
    return $title;
}

/**
 * Changes the excerpt more
 */
function front_excerpt_more( $more ) {
    return '...';
}

/**
 * Returns if a sidebar for Blog is available or not
 */
function front_blog_has_sidebar() {
    $layout = front_get_blog_layout();

    return $layout !== 'full-width';
}

/**
 * Returns if a sidebar for Shop is available or not
 */
function front_shop_has_sidebar() {
    $layout = front_get_layout();

    return $layout !== 'full-width';
}


/**
 * Returns the layout of Blog pages chosen by user
 */
function front_get_blog_layout() {
    $available_layouts = array( 'sidebar-left', 'sidebar-right', 'full-width' );

    if ( is_active_sidebar( 'sidebar-blog' ) ) {
        $layout = apply_filters( 'front_blog_layout', 'sidebar-right' );
        if( is_category() ) {
            $term               = get_queried_object();
            $term_id            = $term->term_id;
            $cat_blog_layout    = get_term_meta( $term_id, 'blog_layout', true );

            if ( in_array( $cat_blog_layout, $available_layouts ) ) {
                $layout = $cat_blog_layout;
            }
        }
    } else {
        $layout = 'full-width';
    }

    if ( ! in_array( $layout, $available_layouts ) ) {
        $layout = 'sidebar-right';
    }

    return $layout;
}

/**
 * Returns the layout of pages chosen by user
 */

function front_get_layout() {
    $available_layouts = array( 'sidebar-left', 'sidebar-right', 'full-width' );
    if ( front_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_tax( 'product_label' ) || is_tax( get_object_taxonomies( 'product' ) ) ) ) {
        if( is_active_sidebar( 'sidebar-shop' ) ) {
            $layout = apply_filters( 'front_shop_layout', 'sidebar-right' );
        } else {
            $layout = 'full-width';
        }
    } else {
        $layout = 'sidebar-left';
    }

    if ( ! in_array( $layout, $available_layouts ) ) {
        $layout = 'sidebar-right';
    }

    return $layout;
}

/**
 * Returns the view of Blog Pages chosen by user
 */
function front_get_blog_view() {
    $available_views = array( 'classic', 'grid', 'list', 'modern', 'masonry' );
    $blog_view  = apply_filters( 'front_blog_view', 'list' );
    if( is_category() ) {
        $term           = get_queried_object();
        $term_id        = $term->term_id;
        $cat_blog_view  = get_term_meta( $term_id, 'blog_view', true );

        if ( in_array( $cat_blog_view, $available_views ) ) {
            $blog_view = $cat_blog_view;
        }
    }

    if ( ! in_array( $blog_view, $available_views ) ) {
        $blog_view = 'grid';
    }

    return $blog_view;
}

/**
 * Returns single post style
 */
function front_single_post_style() {
    $post_style = get_post_meta( get_the_ID(), '_post_style', true );
    $post_style = ! empty( $post_style ) ? $post_style : apply_filters( 'front_single_post_style', 'classic' );
    $post_styles = array( 'classic', 'simple' );

    if ( ! in_array( $post_style, $post_styles ) ) {
        $post_style = 'classic';
    }

    return $post_style;
}

function front_tag_style_term_links( $links ) {

    $soft_buttons = array( 'btn-soft-primary', 'btn-soft-secondary',  'btn-soft-success',  'btn-soft-danger',  'btn-soft-warning',  'btn-soft-info',  'btn-soft-indigo',  'btn-soft-dark' );

    foreach( $links as $key => $link ) {
        if ( ! is_single() ) {

            if ( has_post_thumbnail() ) {
                shuffle( $soft_buttons );
                $btn_color = $soft_buttons[ $key ];
            } else {
                $btn_color = 'btn-soft-white';
            }

            $links[ $key ] = str_replace( 'rel="tag"', 'class="btn btn-xs ' . $btn_color . ' btn-pill" rel="tag"', $link );
        } else {
            $links[ $key ] = str_replace( 'rel="tag"', 'class="btn btn-xs btn-gray btn-pill" rel="tag"', $link );
        }
    }

    return $links;
}

/**
 * Returns information about the current post's discussion, with cache support.
 */
function front_get_discussion_data() {
    static $discussion, $post_id;

    $current_post_id = get_the_ID();
    if ( $current_post_id === $post_id ) {
        return $discussion; /* If we have discussion information for post ID, return cached object */
    } else {
        $post_id = $current_post_id;
    }

    $comments = get_comments(
        array(
            'post_id' => $current_post_id,
            'orderby' => 'comment_date_gmt',
            'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings > Discussion. */
            'status'  => 'approve',
            'number'  => 20, /* Only retrieve the last 20 comments, as the end goal is just 6 unique authors */
        )
    );

    $authors = array();
    foreach ( $comments as $comment ) {
        $authors[] = ( (int) $comment->user_id > 0 ) ? (int) $comment->user_id : $comment->comment_author_email;
    }

    $authors    = array_unique( $authors );
    $discussion = (object) array(
        'authors'   => array_slice( $authors, 0, 6 ),           /* Six unique authors commenting on the post. */
        'responses' => get_comments_number( $current_post_id ), /* Number of responses. */
    );

    return $discussion;
}

/**
 * Returns the size for avatars used in the theme.
 */
function front_get_avatar_size() {
    return 50;
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function front_is_comment_by_post_author( $comment = null ) {
    if ( is_object( $comment ) && $comment->user_id > 0 ) {
        $user = get_userdata( $comment->user_id );
        $post = get_post( $comment->comment_post_ID );
        if ( ! empty( $user ) && ! empty( $post ) ) {
            return $comment->user_id === $post->post_author;
        }
    }
    return false;
}

/**
 * Top Bar Search Style
 *
 */
function front_get_topbar_search_style() {
    $style_options = array( 'push_from_top', 'classic' );
    $topbar_search_style = apply_filters( 'front_topbar_search_style', 'push_from_top' );

    if ( ! in_array( $topbar_search_style, $style_options ) ) {
        $topbar_search_style = 'classic';
    }

    return $topbar_search_style;
}

/**
 * Get attributes string from atts arary
 */
function front_get_attributes( $atts ) {
    $attributes = '';
    foreach ( $atts as $attr => $value ) {
        if ( $value === "0" || ! empty( $value ) ) {
            $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
            $attributes .= ' ' . $attr . '="' . $value . '"';
        }
    }
    return $attributes;
}

/**
 * Find any custom linkmod or icon classes and store in their holder
 * arrays then remove them from the main classes array.
 *
 * Supported linkmods: .disabled, .dropdown-header, .dropdown-divider, .sr-only
 * Supported iconsets: Font Awesome 4/5, Glypicons
 *
 * NOTE: This accepts the linkmod and icon arrays by reference.
 *
 * @since 4.0.0
 *
 * @param array   $classes         an array of classes currently assigned to the item.
 * @param array   $linkmod_classes an array to hold linkmod classes.
 * @param array   $icon_classes    an array to hold icon classes.
 * @param integer $depth           an integer holding current depth level.
 *
 * @return array  $classes         a maybe modified array of classnames.
 */
function front_separate_linkmods_and_icons_from_classes( $classes, &$linkmod_classes, &$icon_classes, &$btn_classes, $depth ) {
    // Loop through $classes array to find linkmod or icon classes.
    foreach ( $classes as $key => $class ) {
        // If any special classes are found, store the class in it's
        // holder array and and unset the item from $classes.
        if ( preg_match( '/^disabled|^sr-only/i', $class ) ) {
            // Test for .disabled or .sr-only classes.
            $linkmod_classes[] = $class;
            unset( $classes[ $key ] );
        } elseif ( preg_match( '/^dropdown-header|^dropdown-divider|^dropdown-item-text/i', $class ) && $depth > 0 ) {
            // Test for .dropdown-header or .dropdown-divider and a
            // depth greater than 0 - IE inside a dropdown.
            $linkmod_classes[] = $class;
            unset( $classes[ $key ] );
        } elseif ( preg_match( '/^fa-(\S*)?|^fa(s|r|l|b)?(\s?)?$/i', $class ) ) {
            // Font Awesome.
            $icon_classes[] = $class;
            unset( $classes[ $key ] );
        } elseif ( preg_match( '/^glyphicon-(\S*)?|^glyphicon(\s?)$/i', $class ) ) {
            // Glyphicons.
            $icon_classes[] = $class;
            unset( $classes[ $key ] );
        } elseif ( preg_match( '/^transition-3d-hover|^shadow-(\s?)|^text-(\s?)|^btn|^btn-(\s?)$/i', $class ) ) {
            $btn_classes[] = $class;
            unset( $classes[ $key ] );
        }
    }

    return $classes;
}

if ( ! function_exists( 'front_clean' ) ) {
    /**
     * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
     * Non-scalar values are ignored.
     *
     * @param string|array $var Data to sanitize.
     * @return string|array
     */
    function front_clean( $var ) {
        if ( is_array( $var ) ) {
            return array_map( 'front_clean', $var );
        } else {
            return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
        }
    }
}

if ( ! function_exists( 'front_strlen' ) ) {
    function front_strlen( $var ) {
        if ( is_array( $var ) ) {
            return array_map( 'front_strlen', $var );
        } else {
            return strlen( $var );
        }
    }
}

function front_number_format_i18n( $n ) {
    // first strip any formatting;
    $n = ( 0 + str_replace( ",", "", $n ) );

    // is this a number?
    if( ! is_numeric( $n ) ) {
        return $n;
    }

    // now filter it;
    if( $n >= 1000000000000 ) {
        return round( ( $n/1000000000000 ), 1 ) . 'T';
    } elseif( $n >= 1000000000 ) {
        return round( ( $n/1000000000 ), 1 ) . 'B';
    } elseif( $n >= 1000000 ) {
        return round( ( $n/1000000 ), 1 ) . 'M';
    } elseif( $n >= 10000 ) {
        return round( ( $n/10000 ), 10 ) . 'K';
    }

    return number_format_i18n( $n );
}

if ( ! function_exists( 'front_pr' ) ) {
    function front_pr( $var ) {
        echo '<pre>' . print_r( $var, 1 ) . '</pre>';
    }
}

/**
 * Enables template debug mode
 *
 */
function front_template_debug_mode() {
    if ( ! defined( 'FRONT_TEMPLATE_DEBUG_MODE' ) ) {
        $status_options = get_option( 'woocommerce_status_options', array() );
        if ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) {
            define( 'FRONT_TEMPLATE_DEBUG_MODE', true );
        } else {
            define( 'FRONT_TEMPLATE_DEBUG_MODE', false );
        }
    }
}
add_action( 'after_setup_theme', 'front_template_debug_mode', 10 );

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function front_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $located = front_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
        return;
    }

    // Allow 3rd party plugin filter template file from their plugin
    $located = apply_filters( 'front_get_template', $located, $template_name, $args, $template_path, $default_path );

    do_action( 'front_before_template_part', $template_name, $template_path, $located, $args );

    include( $located );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *      yourtheme       /   $template_path  /   $template_name
 *      yourtheme       /   $template_name
 *      $default_path   /   $template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function front_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    if ( ! $template_path ) {
        $template_path = 'templates/';
    }

    if ( ! $default_path ) {
        $default_path = 'templates/';
    }

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name
        )
    );

    // Get default template
    if ( ! $template || FRONT_TEMPLATE_DEBUG_MODE ) {
        $template = $default_path . $template_name;
    }

    // Return what we found
    return apply_filters( 'front_locate_template', $template, $template_name, $template_path );
}

/**
 * Call a shortcode function by tag name.
 *
 * @since  1.4.6
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function front_do_shortcode( $tag, array $atts = array(), $content = null ) {
    global $shortcode_tags;

    if ( ! isset( $shortcode_tags[ $tag ] ) ) {
        return false;
    }

    return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

if ( ! function_exists( 'front_kses_post_svg' ) ) {
    function front_kses_post_svg( $content ) {
        $kses_defaults = wp_kses_allowed_html( 'post' );

        $svg_args = array(
            'svg'       => array(
                'class'             => true,
                'aria-hidden'       => true,
                'aria-labelledby'   => true,
                'role'              => true,
                'xmlns'             => true,
                'width'             => true,
                'height'            => true,
                'viewbox'           => true,
                'style'             => true,
                'x'                 => true,
                'y'                 => true,
                'xmlns:xlink'       => true,
                'xml:space'         => true,
            ),
            'g'         => array(
                'fill'              => true,
            ),
            'title'     => array(
                'title'             => true,
            ),
            'path'      => array(
                'class'             => true,
                'd'                 => true,
                'fill'              => true,
                'opacity'           => true,
            ),
            'style'     => array(
                'type'              => true,
            ),
        );

        $allowed_tags = array_merge( $kses_defaults, $svg_args );

        echo wp_kses( $content, $allowed_tags );
    }
}

if ( ! function_exists( 'front_body_styles' ) ) {
    function front_body_styles( $style = '' ) {
        $styles = front_get_body_styles( $style );
        if ( ! empty( $styles ) ) {
            echo 'style="' . join( ';', $styles ) . '"';
        }
    }
}

if ( ! function_exists( 'front_get_body_styles' ) ) {
    function front_get_body_styles( $style = '') {

        $styles = array();

        if ( is_404() ) {
            $bg_image = apply_filters( 'front_404_bg_image', get_template_directory_uri() . '/assets/svg/illustrations/error-404.svg' );
            $styles[] = 'background-image: url( ' . esc_url( $bg_image ) . ' )';
        }

        if ( ! empty( $style ) ) {
            if ( ! is_array( $style ) ) {
                $style = preg_split( '#\s+#', $style );
            }
            $styles = array_merge( $styles, $class );
        } else {
            $style = array();
        }

        $styles = array_map( 'esc_attr', $styles );
        $styles = apply_filters( 'front_body_style', $styles, $style );

        return array_unique( $styles );
    }
}

if ( ! function_exists( 'front_natural_language_join' ) ) :
    function front_natural_language_join( array $list, $conjunction = 'and' ) {
        $last = array_pop( $list );

        if ( $list ) {
            return implode(', ', $list) . ' ' . $conjunction . ' ' . $last;
        }

        return $last;
    }
endif;


if ( ! function_exists( 'front_modify_tag_cloud_args' ) ) :
    function front_modify_tag_cloud_args( $args ) {
        $args['format']   = 'list';
        $args['smallest'] = 0.6875;
        $args['largest']  = 0.6875;
        $args['unit']     = 'rem';
        return $args;
    }
endif;

if ( ! function_exists( 'front_generate_tag_cloud' ) ) :
function front_generate_tag_cloud( $return, $tags, $args ) {
    if ( $args['format'] == 'list' ) {
        $return = str_replace( 'wp-tag-cloud', 'wp-tag-cloud list-inline mb-0', $return );
        $return = str_replace( '<li>', '<li class="list-inline-item pb-3">', $return );
    }

    return $return;
}
endif;

if ( ! function_exists( 'front_generate_tag_cloud_data' ) ) :
function front_generate_tag_cloud_data( $tags_data ) {
    foreach ( $tags_data as $key => $tag_data ) {
        $tags_data[$key]['class'] = $tag_data['class'].' btn btn-xs btn-gray btn-pill';
    }

    return $tags_data;
}
endif;

if ( ! function_exists( 'front_get_category_link' ) ) {
    function front_get_category_link( $template = '<a href="%s">%s</a>' ) {
        global $post;
        $perma_cat = get_post_meta( $post->ID , '_category_permalink', true );

        $category = null;

        if ( $perma_cat != null ) {
            $cat_id   = $perma_cat['category'];
            $category = get_category( $cat_id );
        } else {
            $cat_id = get_post_meta( $post->ID , 'category_permalink', true );
            if ( ! empty( $cat_id ) ) {
                $category = get_category( $cat_id );
            }
        }

        if ( is_null( $category ) ) {
            $categories = get_the_category();
            if( isset( $categories[0] ) ) {
                $category = $categories[0];
            }
        }

        $category_link = get_category_link( $category );
        $category_name = isset( $category->name ) ? $category->name : '';

        return sprintf( $template, esc_url( $category_link ), esc_html( $category_name ) );
    }
}

if ( ! function_exists( 'front_apply_single_post_classes' ) ) :
/**
 * Adds Front Single Post Classes to Post Content
 */
function front_apply_single_post_classes( $content ) {

    if ( is_singular( 'post' ) ) {
        /*$content = str_replace( '<h1>', '<h1 class="mt-5 mb-3">', $content );
        $content = str_replace( '<h2>', '<h2 class="mt-5 mb-3">', $content );
        $content = str_replace( '<h3>', '<h3 class="mt-5 mb-3">', $content );
        $content = str_replace( '<h4>', '<h4 class="mt-5 mb-3">', $content );
        $content = str_replace( '<h5>', '<h5 class="mt-5 mb-3">', $content );
        $content = str_replace( '<h6>', '<h6 class="mt-5 mb-3">', $content );
        $content = str_replace( '<ul>', '<ul class="text-secondary">', $content );
        $content = str_replace( '<dl>', '<dl class="text-secondary">', $content );*/
    }

    return $content;
}
endif;

if ( ! function_exists( 'front_get_icon_path' ) ) {
    function front_get_icon_path( $icon ) {
        if( ! empty( $icon ) ) {
            return get_template_directory_uri() . '/assets/svg/icons/' . str_replace( substr( $icon, 0, 4 ), '', $icon ) . '.svg';
        }

        return get_template_directory_uri() . '/assets/svg/icons/icon-1.svg';
    }
}

if ( ! function_exists( 'front_display_button_component' ) ) {
    function front_display_button_component( $args = array() ) {
        $defaults = array(
            'className' => '',
            'align' => 'center',
            'background' => 'primary',
            'design' => 'default',
            'size' => 'default',
            'isWide' => false,
            'isWideSM' => false,
            'isDisable' => false,
            'isBlock' => false,
            'borderRadius' => 'default',
            'isTransition' => true,
            'url' => '',
            'newTab' => false,
            'text' => '',
            'icon' => null,
            'isIconAfterText' => false,
            'isIconButton' => false,
        );

        $args = wp_parse_args( $args, $defaults );
        extract( $args );

        $mainClasses = array( 'fgb-button', 'btn' );
        if( $align ) {
            $mainClasses[] = 'fgb-button--align-' . $align;
        }
        if( $design == 'default' ) {
            $mainClasses[] = 'btn-' . $background;
        } else {
            $mainClasses[] = 'btn-' . $design . '-' . $background;
        }
        if( $size != 'default' ) {
            $mainClasses[] = $size;
        }
        if( $icon && substr( $icon, 0, 3 ) === "fgb" ) {
            $mainClasses[] = 'fgb-icon';
        }
        if( $isIconButton ) {
            $mainClasses[] = 'btn-icon';
        }
        if( $isWide ) {
            $mainClasses[] = 'btn-wide';
        }
        if( $isWideSM ) {
            $mainClasses[] = 'btn-sm-wide';
        }
        if( $isDisable ) {
            $mainClasses[] = 'disabled btn-white';
        }
        if( $isBlock ) {
            $mainClasses[] = 'btn-block';
        }
        if( $isTransition ) {
            $mainClasses[] = 'transition-3d-hover';
        }
        if( $borderRadius != 'default' ) {
            $mainClasses[] = $borderRadius;
        }
        if( ! empty( $className ) ) {
            $mainClasses[] = $className;
        }

        $iconContent = false;
        if( $icon ) {
            $iconClasses = array();
            if( $isIconButton ) {
                $iconClasses[] = 'btn-icon__inner';
            } else {
                $iconClasses[] = $isIconAfterText ? 'ml-sm-1': 'mr-sm-1';
            }

            $iconPrefix = substr( $icon, 0, 3 );
            if( $iconPrefix == "fgb" ) {
                $iconClasses[] = 'ie-height-20';
                $iconClasses[] = 'max-width-4';
                $iconClasses[] = 'button-width';
                $buttonIconPath = front_get_icon_path( $icon );
                $iconContent = '<figure class="' . esc_attr( implode( ' ', $iconClasses ) ) . '"><img class="js-svg-injector" src="' . esc_url( $buttonIconPath ) . '" alt="' . esc_attr__( 'SVG', 'front' ) . '" /></figure>';
            } else {
                $iconClasses[] = str_replace( $iconPrefix, $iconPrefix . ' fa', $icon );
                $iconContent = '<span class="' . esc_attr( implode( ' ', $iconClasses ) ) . '"></span>';
            }
        }

        ?>
        <a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( implode( ' ', $mainClasses ) ); ?>" <?php if( $newTab ) { echo 'target="_blank" rel="noopener noreferrer"'; } ?>>
            <?php if( $icon && ! $isIconAfterText ) {
                echo wp_kses_post( $iconContent );
            } ?>
            <?php if( ! $isIconButton ) {
                echo '<div class="fgb-button--inner">' . wp_kses_post( $text ) . '</div>';
            } ?>
            <?php if( $icon && $isIconAfterText ) {
                echo wp_kses_post( $iconContent );
            } ?>
        </a>
        <?php
    }
}

if ( ! function_exists( 'front_get_available_image_sizes' ) ) {
    /**
     * Returns all available image sizes as an array
     */
    function front_get_available_image_sizes() {
        $image_sizes = array(
            'blog_classic_thumbnail' => array(
                'enabled' => true, 'name' => '500x280-crop', 'width' => 500, 'height' => 280, 'crop' => true
            ),
            'blog_list_thumbnail' => array(
                'enabled' => true, 'name' => '480x320-crop', 'width' => 480, 'height' => 320, 'crop' => true
            ),
            'blog_modern_thumbnail_1' => array(
                'enabled' => true, 'name' => '400x500-crop', 'width' => 400, 'height' => 500, 'crop' => true
            ),
            'blog_modern_thumbnail_2' => array(
                'enabled' => true, 'name' => '900x450-crop', 'width' => 900, 'height' => 450, 'crop' => true
            ),
            'blog_masonry_thumbnail_1' => array(
                'enabled' => true, 'name' => '900x450-crop', 'width' => 900, 'height' => 450, 'crop' => true
            ),
            'blog_masonry_thumbnail_2' => array(
                'enabled' => true, 'name' => '480x320-crop', 'width' => 480, 'height' => 320, 'crop' => true
            ),
            'blog_masonry_thumbnail_3' => array(
                'enabled' => true, 'name' => '500x550-crop', 'width' => 500, 'height' => 550, 'crop' => true
            ),
            'blog_masonry_thumbnail_4' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'blog_masonry_thumbnail_5' => array(
                'enabled' => true, 'name' => '500x280-crop', 'width' => 500, 'height' => 280, 'crop' => true
            ),
            'blog_startup_thumbnail' => array(
                'enabled' => true, 'name' => '900x450-crop', 'width' => 900, 'height' => 450, 'crop' => true
            ),
            'blog_business_thumbnail_1' => array(
                'enabled' => true, 'name' => '500x280-crop', 'width' => 500, 'height' => 280, 'crop' => true
            ),
            'blog_business_thumbnail_2' => array(
                'enabled' => true, 'name' => '500x550-crop', 'width' => 500, 'height' => 550, 'crop' => true
            ),
            'blog_agency_thumbnail_1' => array(
                'enabled' => true, 'name' => '500x550-crop', 'width' => 500, 'height' => 550, 'crop' => true
            ),
            'blog_agency_thumbnail_2' => array(
                'enabled' => true, 'name' => '450x450-crop', 'width' => 450, 'height' => 450, 'crop' => true
            ),
            'blog_agency_thumbnail_3' => array(
                'enabled' => true, 'name' => '500x280-crop', 'width' => 500, 'height' => 280, 'crop' => true
            ),
            'blog_agency_thumbnail_4' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'blog_classic_agency_thumbnail' => array(
                'enabled' => true, 'name' => '400x500-crop', 'width' => 400, 'height' => 500, 'crop' => true
            ),
            'blog_crypto_demo_thumbnail' => array(
                'enabled' => true, 'name' => '500x550-crop', 'width' => 500, 'height' => 550, 'crop' => true
            ),
            'portfolio_corporate_startup_thumbnail_1' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'portfolio_corporate_startup_thumbnail_2' => array(
                'enabled' => true, 'name' => '380x740-crop', 'width' => 380, 'height' => 740, 'crop' => true
            ),
            'portfolio_agency_thumbnail_1' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'portfolio_agency_thumbnail_2' => array(
                'enabled' => true, 'name' => '380x740-crop', 'width' => 380, 'height' => 740, 'crop' => true
            ),
            'portfolio_profile_thumbnail_1' => array(
                'enabled' => true, 'name' => '500x700-crop', 'width' => 500, 'height' => 700, 'crop' => true
            ),
            'portfolio_profile_thumbnail_2' => array(
                'enabled' => true, 'name' => '480x320-crop', 'width' => 480, 'height' => 320, 'crop' => true
            ),
            'portfolio_profile_thumbnail_3' => array(
                'enabled' => true, 'name' => '380x250-crop', 'width' => 380, 'height' => 250, 'crop' => true
            ),
            'portfolio_profile_thumbnail_4' => array(
                'enabled' => true, 'name' => '450x450-crop', 'width' => 450, 'height' => 450, 'crop' => true
            ),
            'portfolio_profile_thumbnail_5' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'portfolio_classic_thumbnail' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'portfolio_grid_thumbnail' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'portfolio_masonry_thumbnail_1' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'portfolio_masonry_thumbnail_2' => array(
                'enabled' => true, 'name' => '380x270-crop', 'width' => 380, 'height' => 270, 'crop' => true
            ),
            'portfolio_modern_thumbnail_1' => array(
                'enabled' => true, 'name' => '380x360-crop', 'width' => 380, 'height' => 360, 'crop' => true
            ),
            'portfolio_modern_thumbnail_2' => array(
                'enabled' => true, 'name' => '380x270-crop', 'width' => 380, 'height' => 270, 'crop' => true
            ),
            'portfolio_single_simple_thumbnail' => array(
                'enabled' => true, 'name' => '600x600-crop', 'width' => 600, 'height' => 600, 'crop' => true
            ),
            'portfolio_single_grid_thumbnail' => array(
                'enabled' => true, 'name' => '600x600-crop', 'width' => 600, 'height' => 600, 'crop' => true
            ),
            'portfolio_single_masonry_thumbnail_1' => array(
                'enabled' => true, 'name' => '600x400-crop', 'width' => 600, 'height' => 400, 'crop' => true
            ),
            'portfolio_single_masonry_thumbnail_2' => array(
                'enabled' => true, 'name' => '400x600-crop', 'width' => 400, 'height' => 600, 'crop' => true
            ),
            'portfolio_single_masonry_thumbnail_3' => array(
                'enabled' => true, 'name' => '600x435-crop', 'width' => 600, 'height' => 435, 'crop' => true
            ),
            'portfolio_single_masonry_thumbnail_4' => array(
                'enabled' => true, 'name' => '600x600-crop', 'width' => 600, 'height' => 600, 'crop' => true
            ),
            'portfolio_browse_projects_thumbnail' => array(
                'enabled' => true, 'name' => '600x400-crop', 'width' => 600, 'height' => 400, 'crop' => true
            )
        );
        return apply_filters( 'front_image_sizes', $image_sizes );
    }
}

if ( ! function_exists( 'front_navbar_dropdown_trigger_toggle_click' ) ) {
    function front_navbar_dropdown_trigger_toggle_click( $trigger ) {
        return 'click';
    }
}

if ( ! function_exists( 'front_get_image_size' ) ) {
    /**
     * Returns image size name and if not enabled, the fallback
     */
    function front_get_image_size( $img_sz_name, $fallback_img_sz_name ) {
        $image_sizes = front_get_available_image_sizes();

        if ( isset( $image_sizes[ $img_sz_name ] ) && $image_sizes[ $img_sz_name ]['enabled'] ) {
            $image_size = $image_sizes[ $img_sz_name ]['name'];
        } else {
            $image_size = $fallback_img_sz_name;
        }

        return apply_filters( 'front_get_image_size', $image_size, $img_sz_name, $fallback_img_sz_name );
    }
}
