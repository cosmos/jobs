<?php

/**
 * Front WeDocs Functions
 */

if ( ! function_exists( 'front_wedocs_post_type_args' ) ) :
/**
 * Override register post type args
 */
function front_wedocs_post_type_args( $args ) {

    $args['supports'][] = 'author';
    $args['supports'][] = 'excerpt';

    return $args;
}

endif;

if ( ! function_exists( 'front_wedocs_docs_home_hooks' ) ) :
/**
 * Remove page header from docs home
 */
function front_wedocs_docs_home_hooks() {
    if ( front_wedocs_is_docs_home() ) {
        remove_action( 'front_page', 'front_page_header', 10 ); // Remove Header
        add_action( 'front_page_before', 'front_wedocs_docs_search_form', 20 );
        add_action( 'front_page_before', 'front_wedocs_breadcrumbs', 30 );
        add_action( 'front_page', 'front_wedocs_container_start', 15 );
        add_action( 'front_page', 'front_wedocs_container_end', 25 );
    }
}

endif;

if ( ! function_exists( 'front_wedocs_is_docs_home' ) ) : 
/**
 * Returns if a page is docs home or not
 */
function front_wedocs_is_docs_home() {
    global $post;
    $docs_home = wedocs_get_option( 'docs_home', 'wedocs_settings' );

    return ( is_page() && $docs_home == $post->ID );
}
endif;

if ( ! function_exists( 'front_wedocs_is_docs_search' ) ) : 
/**
 * Returns if a page is docs search or not
 */
function front_wedocs_is_docs_search() {
    return ( is_search() && get_post_type() == 'docs' );
}
endif;

if ( ! function_exists( 'front_wedocs_is_docs_taxonomy' ) ) : 
/**
 * Returns if a page is docs taxonomy or not
 */
function front_wedocs_is_docs_taxonomy() {
    return is_tax( get_object_taxonomies( 'docs' ) );
}
endif;

if ( ! function_exists( 'front_wedocs_breadcrumbs' ) ) :
/**
 * Override WeDocs Breadcrum Function
 */
function front_wedocs_breadcrumbs() {
    global $post;

    $html = '';
    $args = apply_filters( 'wedocs_breadcrumbs', array(
        'delimiter' => '',
        'home'      => esc_html__( 'Home', 'front' ),
        'before'    => '<li class="breadcrumb-item active" aria-current="page">',
        'after'     => '</li>'
    ) );

    $breadcrumb_position = 1;

    if( front_wedocs_is_docs_home() || front_wedocs_is_docs_search() || front_wedocs_is_docs_taxonomy() ) {
        $space_class = '';
    } else {
        $space_class = ' space-1';
    }
    

    $html .= '<ol class="breadcrumb breadcrumb-no-gutter font-size-1' . $space_class . '" itemscope itemtype="http://schema.org/BreadcrumbList">';
    $html .= front_wedocs_get_breadcrumb_item( $args['home'], home_url( '/' ), $breadcrumb_position );
    $html .= $args['delimiter'];

    $docs_home = wedocs_get_option( 'docs_home', 'wedocs_settings' );

    if ( $docs_home ) {
        $breadcrumb_position++;

        $html .= front_wedocs_get_breadcrumb_item( esc_html__( 'Docs', 'front' ), get_permalink( $docs_home ), $breadcrumb_position );
        $html .= $args['delimiter'];
    }

    if( front_wedocs_is_docs_search() || front_wedocs_is_docs_taxonomy() ) {
        $html .= ' ' . $args['before'] . front_get_the_archive_title() . $args['after'];
    } else {
        if ( $post->post_type == 'docs' && $post->post_parent ) {
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();

            while ($parent_id) {
                $breadcrumb_position++;

                $page          = get_post($parent_id);
                $breadcrumbs[] = front_wedocs_get_breadcrumb_item( get_the_title( $page->ID ), get_permalink( $page->ID ), $breadcrumb_position );
                $parent_id     = $page->post_parent;
            }

            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                $html .= $breadcrumbs[$i];
                $html .= ' ' . $args['delimiter'] . ' ';
            }

        }

        $html .= ' ' . $args['before'] . get_the_title() . $args['after'];
    }

    $html .= '</ol>';

    if( front_wedocs_is_docs_home() || front_wedocs_is_docs_search() || front_wedocs_is_docs_taxonomy() ) {
        $html = '<div class="container space-1"><div class="w-lg-80 mx-lg-auto">' . $html . '</div></div>';
    }

    echo apply_filters( 'wedocs_breadcrumbs_html', $html, $args );
}

endif;


if ( ! function_exists( 'front_wedocs_get_breadcrumb_item' ) ) :

/**
 * Schema.org breadcrumb item wrapper for a link
 *
 * @param  string  $label
 * @param  string  $permalink
 * @param  integer $position
 *
 * @return string
 */
function front_wedocs_get_breadcrumb_item( $label, $permalink, $position = 1 ) {
    return '<li itemprop="itemListElement" class="breadcrumb-item" itemscope itemtype="http://schema.org/ListItem">
        <a itemprop="item" href="' . esc_attr( $permalink ) . '">
        <span itemprop="name">' . esc_html( $label ) . '</span></a>
        <meta itemprop="position" content="' . $position . '" />
    </li>';
}

endif;

function front_wedocs_child_page_css_class( $css_class, $page, $depth, $args, $current_page ) {
    $css_class[] = 'pb-3';
    return $css_class;
}

class WeDocs_Page_Walker extends Walker_Page {
    /**
     * Outputs the beginning of the current level in the tree before elements are output.
     *
     * @since 2.1.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int    $depth  Optional. Depth of page. Used for padding. Default 0.
     * @param array  $args   Optional. Arguments for outputting the next level.
     *                       Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        $indent  = str_repeat( $t, $depth );
        $output .= "{$n}{$indent}<ul class='list-unstyled children'>{$n}";
    }

    /**
     * Outputs the beginning of the current element in the tree.
     *
     * @see Walker::start_el()
     * @since 2.1.0
     *
     * @param string  $output       Used to append additional content. Passed by reference.
     * @param WP_Post $page         Page data object.
     * @param int     $depth        Optional. Depth of page. Used for padding. Default 0.
     * @param array   $args         Optional. Array of arguments. Default empty array.
     * @param int     $current_page Optional. Page ID. Default 0.
     */
    public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
        if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        if ( $depth ) {
            $indent = str_repeat( $t, $depth );
        } else {
            $indent = '';
        }

        $css_class = array( 'page_item', 'page-item-' . $page->ID );

        if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
            $css_class[] = 'page_item_has_children';
        }

        if ( ! empty( $current_page ) ) {
            $_current_page = get_post( $current_page );
            if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
                $css_class[] = 'current_page_ancestor';
            }
            if ( $page->ID == $current_page ) {
                $css_class[] = 'current_page_item';
            } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
                $css_class[] = 'current_page_parent';
            }
        } elseif ( $page->ID == get_option( 'page_for_posts' ) ) {
            $css_class[] = 'current_page_parent';
        }

        $css_class[] = 'pb-3';

        /**
         * Filters the list of CSS classes to include with each page item in the list.
         *
         * @since 2.8.0
         *
         * @see wp_list_pages()
         *
         * @param string[] $css_class    An array of CSS classes to be applied to each list item.
         * @param WP_Post  $page         Page data object.
         * @param int      $depth        Depth of page, used for padding.
         * @param array    $args         An array of arguments.
         * @param int      $current_page ID of the current page.
         */
        $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );
        $css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';

        if ( '' === $page->post_title ) {
            /* translators: %d: ID of a post */
            $page->post_title = sprintf( esc_html__( '#%d (no title)', 'front' ), $page->ID );
        }

        $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
        $args['link_after']  = empty( $args['link_after'] ) ? '' : $args['link_after'];

        $atts                 = array();
        $atts['href']         = get_permalink( $page->ID );
        $atts['aria-current'] = ( $page->ID == $current_page ) ? 'page' : '';

        if ( ! isset( $args['pages_with_children'][ $page->ID ] ) ) {
            $atts['class']       = 'link-muted';
            $args['link_before'] = '';
            $args['link_after']  = '';
        } else {
            $atts['class']       = 'text-dark';
            $args['link_before'] = '<div class="mb-4"><h3 class="h5 font-weight-medium">';
            $args['link_after']  = '</h3></div>';
        }

        /**
         * Filters the HTML attributes applied to a page menu item's anchor element.
         *
         * @since 4.8.0
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $href         The href attribute.
         *     @type string $aria_current The aria-current attribute.
         * }
         * @param WP_Post $page         Page data object.
         * @param int     $depth        Depth of page, used for padding.
         * @param array   $args         An array of arguments.
         * @param int     $current_page ID of the current page.
         */
        $atts = apply_filters( 'page_menu_link_attributes', $atts, $page, $depth, $args, $current_page );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $output .= $indent . sprintf(
            '<li%s><a%s>%s%s%s</a>',
            $css_classes,
            $attributes,
            $args['link_before'],
            /** This filter is documented in wp-includes/post-template.php */
            apply_filters( 'the_title', $page->post_title, $page->ID ),
            $args['link_after']
        );

        if ( ! empty( $args['show_date'] ) ) {
            if ( 'modified' == $args['show_date'] ) {
                $time = $page->post_modified;
            } else {
                $time = $page->post_date;
            }

            $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
            $output     .= ' ' . mysql2date( $date_format, $time );
        }
    }
}