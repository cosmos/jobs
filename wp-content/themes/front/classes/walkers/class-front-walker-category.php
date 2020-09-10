<?php
/**
 * Front Page Walker to create HTML for list of categories
 */
class Front_Walker_Category extends Walker_Category {

    private $current_cat_id = '';

    private $is_current_cat = false;

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' != $args['style'] )
            return;

        $indent = str_repeat("\t", $depth);

        $children_id = '';
        if ( ! empty( $this->current_cat_id ) ) {
            $children_id = 'id="children-of-cat-' . $this->current_cat_id . '"';
        }

        $children_class = 'list-group list-group-flush list-group-borderless collapse children';

        if ( $this->is_current_cat ) {
            $children_class .= ' show';
        }

        $output .= "$indent<ul $children_id class='$children_class'>\n";
    }

    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

        $child_indicator      = '';
        $count                = '';
        $this->current_cat_id = $category->term_id;
        $this->is_current_cat = false;

        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );

        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }

        if ( ! empty( $args['show_count'] ) ) {
            $count = '<span class="count badge bg-soft-secondary badge-pill ml-2">' . number_format_i18n( $category->count ) . '</span>';
        }

        $link = '<a class="list-group-item list-group-item-action" href="' . esc_url( get_term_link( $category ) ) . '" ';
        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string $description Category description.
             * @param object $category    Category object.
             */
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        }

        $link .= '>';
        $link .= $cat_name . $count . '</a>';

        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';

            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }

            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

            if ( empty( $args['feed'] ) ) {
                $alt = ' alt="' . sprintf( esc_attr__( 'Feed for all posts filed under %s', 'front' ), $cat_name ) . '"';
            } else {
                $alt = ' alt="' . esc_attr( $args['feed'] ) . '"';
                $name = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : $args['title'];
            }

            $link .= '>';

            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . esc_attr( $args['feed_image'] ) . "'$alt" . ' />';
            }
            $link .= '</a>';

            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }

        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id
            );

            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );

                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                        $this->is_current_cat  = true;
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                        $this->is_current_cat  = true;
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] =  'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }

            if ( $args['has_children'] && $args['hierarchical'] ) {
                $css_classes[] = 'cat-parent';

                $collapsed_class = 'collapsed';
                if ( $this->is_current_cat ) {
                    $collapsed_class = '';
                }

                $child_indicator = '<a href="#" data-toggle="collapse" data-target="#children-of-cat-' . $category->term_id . '" class="ml-auto list-group-item text-secondary child-indicator ' . $collapsed_class . '"><small><i class="fas fa-angle-right"></i></small></a>';
            }

            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

            $output .=  ' class="' . $css_classes . '"';
            $output .= "><div class='cat-item-inner d-flex align-items-center'>$link $child_indicator</div>\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}