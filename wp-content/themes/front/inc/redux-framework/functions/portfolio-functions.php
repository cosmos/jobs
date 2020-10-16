<?php 
if ( ! function_exists( 'front_redux_change_portfolio_view' ) ) {
    function front_redux_change_portfolio_view( $portfolio_view ) {

        global $front_options; 

        if ( isset( $front_options['portfolio_view'] ) ) {
            $portfolio_view = $front_options['portfolio_view'];
        }

        return $portfolio_view;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_layout' ) ) {
    function front_redux_change_portfolio_layout( $portfolio_layout ) {
        global $front_options;

        if ( isset( $front_options['portfolio_layout'] ) ) {
            $portfolio_layout = $front_options['portfolio_layout'];
        }

        return $portfolio_layout;
    }
}

if ( ! function_exists( 'front_redux_apply_portfolio_posts_per_page' ) ) {
    function front_redux_apply_portfolio_posts_per_page( $posts_per_page ) {
        global $front_options;

        if ( isset( $front_options['portfolio_posts_per_page'] ) ) {
            $posts_per_page = intval( $front_options['portfolio_posts_per_page'] );
        }

        return $posts_per_page;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_hero_title' ) ) {
    function front_redux_change_portfolio_hero_title( $portfolio_hero_title ) {
        global $front_options;

        if( isset( $front_options['portfolio_hero_title'] ) ) {
            $portfolio_hero_title = $front_options['portfolio_hero_title'];
        }

        return $portfolio_hero_title;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_hero_subtitle' ) ) {
    function front_redux_change_portfolio_hero_subtitle( $portfolio_hero_subtitle ) {
        global $front_options;

        if( isset( $front_options['portfolio_hero_subtitle'] ) ) {
            $portfolio_hero_subtitle = $front_options['portfolio_hero_subtitle'];
        }

        return $portfolio_hero_subtitle;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_related_works' ) ) {
    function front_redux_toggle_portfolio_related_works( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_enable_related_works'] ) ) {
            $enabled = (bool) $front_options['portfolio_enable_related_works'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_related_works_pretitle' ) ) {
    function front_redux_change_portfolio_related_works_pretitle( $related_works_pretitle ) {
        global $front_options;

        if( isset( $front_options['portfolio_related_works_pretitle'] ) ) {
            $related_works_pretitle = $front_options['portfolio_related_works_pretitle'];
        }

        return $related_works_pretitle;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_related_works_title' ) ) {
    function front_redux_change_portfolio_related_works_title( $related_works_title ) {
        global $front_options;

        if( isset( $front_options['portfolio_related_works_title'] ) ) {
            $related_works_title = $front_options['portfolio_related_works_title'];
        }

        return $related_works_title;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_related_works_subtitle' ) ) {
    function front_redux_change_portfolio_related_works_subtitle( $related_works_subtitle ) {
        global $front_options;

        if( isset( $front_options['portfolio_related_works_subtitle'] ) ) {
            $related_works_subtitle = $front_options['portfolio_related_works_subtitle'];
        }

        return $related_works_subtitle;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_related_works_view' ) ) {
    function front_redux_change_portfolio_related_works_view( $related_works_view ) {
        global $front_options;

        if ( isset( $front_options['portfolio_related_works_view'] ) ) {
            $related_works_view = $front_options['portfolio_related_works_view'];
        }

        return $related_works_view;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_contact' ) ) {
    function front_redux_toggle_portfolio_contact( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_enable_contact'] ) ) {
            $enabled = (bool) $front_options['portfolio_enable_contact'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_contact_title' ) ) {
    function front_redux_change_portfolio_contact_title( $portfolio_contact_title ) {
        global $front_options;

        $portfolio_title = '';

        if( isset( $front_options['portfolio_contact_title'] ) ) {
            $portfolio_title = $front_options['portfolio_contact_title'];
        }

        return $portfolio_title;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_contact_email' ) ) {
    function front_redux_change_portfolio_contact_email( $portfolio_contact_email ) {
        global $front_options;

        if( isset( $front_options['portfolio_contact_email'] ) ) {
            $portfolio_contact_email = $front_options['portfolio_contact_email'];
        }

        return $portfolio_contact_email;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_contact_sm_menu_id' ) ) {
    function front_redux_change_portfolio_contact_sm_menu_id( $portfolio_contact_sm_menu_id ) {
        global $front_options;

        if( isset( $front_options['portfolio_contact_sm_menu_id'] ) ) {
            $portfolio_contact_sm_menu_id = $front_options['portfolio_contact_sm_menu_id'];
        }

        return $portfolio_contact_sm_menu_id;
    }
}

if ( ! function_exists( 'front_redux_change_portfolio_contact_phone' ) ) {
    function front_redux_change_portfolio_contact_phone( $portfolio_contact_phone ) {
        global $front_options;

        if( isset( $front_options['portfolio_contact_phone'] ) ) {
            $portfolio_contact_phone = $front_options['portfolio_contact_phone'];
        }

        return $portfolio_contact_phone;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_static_content' ) ) {
    function front_redux_toggle_portfolio_static_content( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_enable_static_content_block'] ) ) {
            $enabled = (bool) $front_options['portfolio_enable_static_content_block'];
        }

        return $enabled;
    }
}

if( ! function_exists( 'front_redux_portfolio_static_content' ) ) {
    function front_redux_portfolio_static_content( $portfolio_static_block_id ) {
        global $front_options;

        $portfolio_enable_static_content_block = isset( $front_options['portfolio_enable_static_content_block'] ) && $front_options['portfolio_enable_static_content_block'];

        if( $portfolio_enable_static_content_block && isset( $front_options['portfolio_static_content_block'] ) && ( is_post_type_archive( 'jetpack-portfolio' ) || is_singular( 'jetpack-portfolio' ) ) ) {
            $portfolio_static_block_id = $front_options['portfolio_static_content_block'];
        }

        return $portfolio_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_toggle_separate_portfolio_header' ) ) {
    function front_redux_toggle_separate_portfolio_header( $enable_separate_portfolio_header ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_portfolio_header'] ) && $front_options['enable_separate_portfolio_header'] ) {
            $enable_separate_portfolio_header = true;
        } else {
            $enable_separate_portfolio_header = false;
        }

        return $enable_separate_portfolio_header;
    }
}

if( ! function_exists( 'front_redux_portfolio_header_static_block' ) ) {
    function front_redux_portfolio_header_static_block( $portfolio_static_block_id ) {
        global $front_options;

        $enable_separate_portfolio_header = isset( $front_options['enable_separate_portfolio_header'] ) && $front_options['enable_separate_potfolio_header'];

        if( $enable_separate_portfolio_header && isset( $front_options['header_portfolio_static_block_id'] ) && ( is_post_type_archive( 'jetpack-portfolio' ) || is_singular( 'jetpack-portfolio' ) ) ) {
            $portfolio_static_block_id = $front_options['header_portfolio_static_block_id'];
        }

        return $portfolio_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_toggle_separate_portfolio_footer' ) ) {
    function front_redux_toggle_separate_portfolio_footer( $enable_separate_portfolio_footer ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_portfolio_footer'] ) && $front_options['enable_separate_portfolio_footer'] ) {
            $enable_separate_portfolio_footer = true;
        } else {
            $enable_separate_portfolio_footer = false;
        }

        return $enable_separate_portfolio_footer;
    }
}

if( ! function_exists( 'front_redux_portfolio_footer_static_block' ) ) {
    function front_redux_portfolio_footer_static_block( $portfolio_static_block_id ) {
        global $front_options;

        $enable_separate_potfolio_footer = isset( $front_options['enable_separate_potfolio_footer'] ) && $front_options['enable_separate_potfolio_footer'];

        if( $enable_separate_potfolio_footer && isset( $front_options['header_portfolio_static_block_id'] ) && (is_post_type_archive( 'jetpack-portfolio' ) || is_singular( 'jetpack-portfolio' ) ) ) {
            $portfolio_static_block_id = $front_options['footer_portfolio_static_block_id'];
        }

        return $portfolio_static_block_id;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_related_works_pretitle_enable' ) ) {
    function front_redux_toggle_portfolio_related_works_pretitle_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_related_works_pretitle_enable'] ) ) {
            $enabled = (bool) $front_options['portfolio_related_works_pretitle_enable'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_related_works_pretitle_color' ) ) {
    function front_redux_toggle_portfolio_related_works_pretitle_color( $portfolio_pretitle_color ) {
        global $front_options;

        if ( isset( $front_options['portfolio_related_works_pretitle_color'] ) ) {
            $portfolio_pretitle_color = $front_options['portfolio_related_works_pretitle_color'];
        }

        return $portfolio_pretitle_color;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_hero_enable' ) ) {
    function front_redux_toggle_portfolio_hero_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_enable_hero'] ) ) {
            $enabled = (bool) $front_options['portfolio_enable_hero'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_filters_enable' ) ) {
    function front_redux_toggle_portfolio_filters_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_enable_filters'] ) ) {
            $enabled = (bool) $front_options['portfolio_enable_filters'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_author_enable' ) ) {
    function front_redux_toggle_portfolio_author_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_enable_author'] ) && is_post_type_archive('jetpack-portfolio') ) {
            $enabled = (bool) $front_options['portfolio_enable_author'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_realated_works_author_enable' ) ) {
    function front_redux_toggle_portfolio_realated_works_author_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_realated_works_enable_author'] ) && is_singular('jetpack-portfolio') ) {
            $enabled = (bool) $front_options['portfolio_realated_works_enable_author'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_content_enable' ) ) {
    function front_redux_toggle_portfolio_content_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_enable_content'] ) && is_post_type_archive('jetpack-portfolio') ) {
            $enabled = (bool) $front_options['portfolio_enable_content'];
        }

        return $enabled;
    }
}

if ( ! function_exists( 'front_redux_toggle_portfolio_realated_works_content_enable' ) ) {
    function front_redux_toggle_portfolio_realated_works_content_enable( $enabled ) {
        global $front_options;

        if ( isset( $front_options['portfolio_realated_works_enable_content'] ) && is_singular('jetpack-portfolio') ) {
            $enabled = (bool) $front_options['portfolio_realated_works_enable_content'];
        }

        return $enabled;
    }
}