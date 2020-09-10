<?php
/**
 * Front Page Walker to create HTML for list of pages
 */
class Front_Walker_Page extends Walker_Page {

    private $current_page_id = '';

    private $is_current_page = false;

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset( $args['item_spacing'] ) && 'preserve' === $args['item_spacing'] ) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        $indent = str_repeat( $t, $depth );

        $children_id = '';
        if ( ! empty( $this->current_page_id ) ) {
            $children_id = 'id="children-of-page-' . $this->current_page_id . '"';
        }
        $children_class = 'list-group list-group-flush list-group-borderless collapse children';

        if ( $this->is_current_page ) {
            $children_class .= ' show';
        }

        $output .= "{$n}{$indent}<ul $children_id class='$children_class'>{$n}";
    }

    public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {

        $child_indicator       = '';
        $count                 = '';
        $this->current_page_id = $page->ID;
        $this->is_current_page = false;

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

        if ( ! empty( $current_page ) ) {
            $_current_page = get_post( $current_page );
            if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {
                $css_class[] = 'current_page_ancestor';
            }
            if ( $page->ID == $current_page ) {
                $css_class[] = 'current_page_item';
                $this->is_current_page = true;
            } elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {
                $css_class[] = 'current_page_parent';
                $this->is_current_page = true;
            }
        } elseif ( $page->ID == get_option('page_for_posts') ) {
            $css_class[] = 'current_page_parent';
            $this->is_current_page = true;
        }

        if ( isset( $args['pages_with_children'][ $page->ID ] ) ) {
            $css_class[] = 'page_item_has_children';
            $collapsed_class = ' collapsed';

            if ( $this->is_current_page ) {
                $collapsed_class = '';
            }

            $child_indicator = '<a href="#" data-toggle="collapse" data-target="#children-of-page-' . $page->ID . '" class="ml-auto list-group-item text-secondary child-indicator ' . $collapsed_class . '"><small><i class="fas fa-angle-right"></i></small></a>';
        }

        /**
         * Filters the list of CSS classes to include with each page item in the list.
         *
         * @since 2.8.0
         *
         * @see wp_list_pages()
         *
         * @param array   $css_class    An array of CSS classes to be applied
         *                              to each list item.
         * @param WP_Post $page         Page data object.
         * @param int     $depth        Depth of page, used for padding.
         * @param array   $args         An array of arguments.
         * @param int     $current_page ID of the current page.
         */
        $css_classes = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

        if ( '' === $page->post_title ) {
            /* translators: %d: ID of a post */
            $page->post_title = sprintf( esc_html__( '#%d (no title)', 'front' ), $page->ID );
        }

        $args['link_before'] = empty( $args['link_before'] ) ? '' : $args['link_before'];
        $args['link_after'] = empty( $args['link_after'] ) ? '' : $args['link_after'];

        $atts          = array();
        $atts['href']  = get_permalink( $page->ID );
        $atts['class'] = 'list-group-item list-group-item-action';

        /**
         * Filters the HTML attributes applied to a page menu item's anchor element.
         *
         * @since 4.8.0
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $href The href attribute.
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
                $value = esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $output .= $indent . sprintf(
            '<li class="%s"><div class="page-item-inner d-flex align-items-center"><a%s>%s%s%s</a>%s</div>',
            $css_classes,
            $attributes,
            $args['link_before'],
            /** This filter is documented in wp-includes/post-template.php */
            apply_filters( 'the_title', $page->post_title, $page->ID ),
            $args['link_after'],
            $child_indicator
        );

        if ( ! empty( $args['show_date'] ) ) {
            if ( 'modified' == $args['show_date'] ) {
                $time = $page->post_modified;
            } else {
                $time = $page->post_date;
            }

            $date_format = empty( $args['date_format'] ) ? '' : $args['date_format'];
            $output .= " " . mysql2date( $date_format, $time );
        }
    }
}
