<?php
/**
 * Filter functions for Header of Theme Options
 */

if ( ! function_exists( 'front_redux_toggle_separate_footer_logo' ) ) {
    function front_redux_toggle_separate_footer_logo( $enable_separate_footer_logo ) {
        global $front_options;

        if ( isset( $front_options['enable_separate_footer_logo'] ) && $front_options['enable_separate_footer_logo'] ) {
            $enable_separate_footer_logo = true;
        } else {
            $enable_separate_footer_logo = false;
        }

        return $enable_separate_footer_logo;
    }
}

if ( ! function_exists( 'front_redux_apply_separate_footer_logo' ) ) {
    function front_redux_apply_separate_footer_logo( $separate_footer_logo ) {
        global $front_options;

        if ( isset( $front_options['separate_footer_logo'] ) && is_array( $front_options['separate_footer_logo'] ) && ! empty( $front_options['separate_footer_logo']['id'] ) ) {
            $separate_footer_logo = $front_options['separate_footer_logo'];
        }

        return $separate_footer_logo;
    }
}

if ( ! function_exists( 'front_redux_toggle_svg_logo_light' ) ) {
    function front_redux_toggle_svg_logo_light( $enable_svg_logo_light ) {
        global $front_options;

        $enable_separate_footer_logo = isset( $front_options['enable_separate_footer_logo'] ) && $front_options['enable_separate_footer_logo'] ? $front_options['enable_separate_footer_logo'] : false;

        if ( ( ! $enable_separate_footer_logo ) && isset( $front_options['enable_svg_logo_light'] ) && $front_options['enable_svg_logo_light'] ) {
            $enable_svg_logo_light = true;
        } else {
            $enable_svg_logo_light = false;
        }

        return $enable_svg_logo_light;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_style' ) ) {
    function front_redux_apply_footer_style( $footer_style ) {
        global $front_options;

        if ( isset( $front_options['footer_style'] ) && ! empty( $front_options['footer_style'] ) ) {
            $footer_style = $front_options['footer_style'];
        } else {
            $footer_style = 'default';
        }

        return $footer_style;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_version' ) ) {
    function front_redux_apply_footer_version( $footer_version ) {
        global $front_options;

        $footer_style = isset( $front_options['footer_style'] ) ? $front_options['footer_style'] : 'default';

        if( $footer_style === 'dark-background' ) {
            $footer_version = isset( $front_options['footer_dark_version'] ) ? $front_options['footer_dark_version'] : 'v1';
        } elseif( $footer_style === 'primary-background' ) {
            $footer_version = isset( $front_options['footer_primary_version'] ) ? $front_options['footer_primary_version'] : 'v1';
        } else {
            $footer_version = isset( $front_options['footer_default_version'] ) ? $front_options['footer_default_version'] : 'v1';
        }

        if( empty( $footer_version ) ) {
            $footer_version = 'v1';
        }

        return $footer_version;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_copyright_text' ) ) {
    function front_redux_apply_footer_copyright_text( $footer_copyright_text ) {
        global $front_options;

        if ( isset( $front_options['footer_copyright_text'] ) && ( ! empty( $front_options['footer_copyright_text'] ) ) ) {
            $footer_copyright_text = $front_options['footer_copyright_text'];
        }

        return $footer_copyright_text;
    }
}

if ( ! function_exists( 'front_redux_toggle_footer_static_block' ) ) {
    function front_redux_toggle_footer_static_block( $enable ) {
        global $front_options;

        if ( ! isset( $front_options['enable_footer_static_block'] ) ) {
            $front_options['enable_footer_static_block'] = true;
        }

        if ( $front_options['enable_footer_static_block'] ) {
            $enable = true;
        } else {
            $enable = false;
        }

        return $enable;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_default_13_button' ) ) {
    function front_redux_apply_footer_default_13_button( $footer_default_13_button_text ) {

        global $front_options;

        if ( isset( $front_options['footer_default_13_button_text'] ) && ( ! empty( $front_options['footer_default_13_button_text'] ) ) ) {
            $footer_default_13_button_text = $front_options['footer_default_13_button_text'];
        }

        return $footer_default_13_button_text;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_default_13_button_url' ) ) {
    function front_redux_apply_footer_default_13_button_url( $footer_default_13_button_url ) {

        global $front_options;

        if ( isset( $front_options['footer_default_13_button_url'] ) && ( ! empty( $front_options['footer_default_13_button_url'] ) ) ) {
            $footer_default_13_button_url = $front_options['footer_default_13_button_url'];
        }

        return $footer_default_13_button_url;
    }
}

if( ! function_exists( 'front_redux_apply_footer_static_block_id' ) ) {
    function front_redux_apply_footer_static_block_id( $static_block_id ) {
        global $front_options;

        if( isset( $front_options['footer_static_block_id'] ) ) {
            $static_block_id = $front_options['footer_static_block_id'];
        }

        return $static_block_id;
    }
}

if ( ! function_exists( 'front_redux_apply_primary_footer_v2_goto_icon_class' ) ) {
    function front_redux_apply_primary_footer_v2_goto_icon_class( $primary_footer_v2_goto_icon_class ) {

        global $front_options;

        if ( isset( $front_options['primary_footer_v2_goto_icon_class'] ) && ( ! empty( $front_options['primary_footer_v2_goto_icon_class'] ) ) ) {
            $primary_footer_v2_goto_icon_class = $front_options['primary_footer_v2_goto_icon_class'];
        }

        return $primary_footer_v2_goto_icon_class;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_site_description' ) ) {
    function front_redux_apply_footer_site_description( $footer_site_description ) {
        global $front_options;
        if ( isset( $front_options['footer_site_description'] ) && ( ! empty( $front_options['footer_site_description'] ) ) ) {
            $footer_site_description = $front_options['footer_site_description'];
        }
        return $footer_site_description;
    }
}

if ( ! function_exists( 'front_redux_apply_primary_footer_primary_v6_form' ) ) {
    function front_redux_apply_primary_footer_primary_v6_form( $footer_primary_v6_form ) {
        global $front_options;
        if ( isset( $front_options['footer_primary_v6_form'] ) && ( ! empty( $front_options['footer_primary_v6_form'] ) ) ) {
            $footer_primary_v6_form = $front_options['footer_primary_v6_form'];
        }
        return $footer_primary_v6_form;
    }
}

if ( ! function_exists( 'front_redux_apply_primary_footer_title_v6' ) ) {
    function front_redux_apply_primary_footer_title_v6( $footer_primary_title_v6 ) {
        global $front_options;
        if ( isset( $front_options['footer_primary_title_v6'] ) && ( ! empty( $front_options['footer_primary_title_v6'] ) ) ) {
            $footer_primary_title_v6 = $front_options['footer_primary_title_v6'];
        }
        return $footer_primary_title_v6;
    }
}

if ( ! function_exists( 'front_redux_apply_primary_footer_description_v6' ) ) {
    function front_redux_apply_primary_footer_description_v6( $footer_primary_description_v6 ) {
        global $front_options;
        if ( isset( $front_options['footer_primary_description_v6'] ) && ( ! empty( $front_options['footer_primary_description_v6'] ) ) ) {
            $footer_primary_description_v6 = $front_options['footer_primary_description_v6'];
        }
        return $footer_primary_description_v6;
    }
}

if ( ! function_exists( 'front_redux_apply_primary_footer_description_link_text_v6' ) ) {
    function front_redux_apply_primary_footer_description_link_text_v6( $footer_primary_description_link_text_v6 ) {
        global $front_options;
        if ( isset( $front_options['footer_primary_description_link_text_v6'] ) && ( ! empty( $front_options['footer_primary_description_link_text_v6'] ) ) ) {
            $footer_primary_description_link_text_v6 = $front_options['footer_primary_description_link_text_v6'];
        }
        return $footer_primary_description_link_text_v6;
    }
}

if ( ! function_exists( 'front_redux_apply_primary_footer_description_link_v6' ) ) {
    function front_redux_apply_primary_footer_description_link_v6( $footer_primary_description_link_v6 ) {
        global $front_options;
        if ( isset( $front_options['footer_primary_description_link_v6'] ) && ( ! empty( $front_options['footer_primary_description_link_v6'] ) ) ) {
            $footer_primary_description_link_v6 = $front_options['footer_primary_description_link_v6'];
        }
        return $footer_primary_description_link_v6;
    }
}


if ( ! function_exists( 'front_redux_toggle_footer_contact_block' ) ) {
    function front_redux_toggle_footer_contact_block( $enable ) {
        global $front_options;

        if( isset( $front_options['show_footer_contact_block'] ) && $front_options['show_footer_contact_block'] ) {
            $enable = true;
        } else {
            $enable = false;
        }

        return $enable;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_contact_block_title' ) ) {
    function front_redux_apply_footer_contact_block_title( $text ) {
        global $front_options;

        if( isset( $front_options['footer_contact_title'] ) ) {
            $text = $front_options['footer_contact_title'];
        }

        return $text;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_contact_block_number' ) ) {
    function front_redux_apply_footer_contact_block_number( $number ) {
        global $front_options;

        if( isset( $front_options['footer_call_us_number'] ) ) {
            $number = $front_options['footer_call_us_number'];
        }

        return $number;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_contact_block_mail' ) ) {
    function front_redux_apply_footer_contact_block_mail( $text ) {
        global $front_options;

        if( isset( $front_options['footer_mail_address'] ) ) {
            $text = $front_options['footer_mail_address'];
        }

        return $text;
    }
}

if ( ! function_exists( 'front_redux_apply_footer_contact_block_mail_url' ) ) {
    function front_redux_apply_footer_contact_block_mail_url( $url ) {
        global $front_options;

        if( isset( $front_options['footer_mail_address_url'] ) ) {
            $url = $front_options['footer_mail_address_url'];
        }

        return $url;
    }
}

if ( ! function_exists( 'front_redux_apply_primary_footer_v6_contact_info_limit' ) ) {
    function front_redux_apply_primary_footer_v6_contact_info_limit( $footer_primary_contact_info_limit ) {

        global $front_options;

        if ( isset( $front_options['footer_primary_contact_info_limit'] ) && ( ! empty( $front_options['footer_primary_contact_info_limit'] ) ) ) {
            $footer_primary_contact_info_limit = $front_options['footer_primary_contact_info_limit'];
        }

        return $footer_primary_contact_info_limit;
    }
}

if ( ! function_exists( 'front_redux_apply_primary_footer_contact_info' ) ) {
    function front_redux_apply_primary_footer_contact_info( $footer_primary_contact_info ) {
        global $front_options;

        for ( $i = 0; $i <= $front_options['footer_primary_contact_info_limit'] - 1; $i++ ) {    

            if ( ! empty( $front_options['footer_primary_contact_info_icon' . $i ] ) ) {
                $footer_primary_contact_info[$i]['contact_icon'] = $front_options['footer_primary_contact_info_icon' . $i ];
            }

            if ( ! empty( $front_options['footer_primary_contact_info_title' . $i ] ) ) {
                $footer_primary_contact_info[$i]['contact_title'] = $front_options['footer_primary_contact_info_title' . $i ];
            }

            if ( ! empty( $front_options['footer_primary_contact_info_description' . $i ] ) ) {
                $footer_primary_contact_info[$i]['contact_desc'] = $front_options['footer_primary_contact_info_description' . $i ];
            }

            if ( ! empty( $front_options['footer_primary_contact_info_description_link' . $i ] ) ) {
                $footer_primary_contact_info[$i]['contact_link'] = $front_options['footer_primary_contact_info_description_link' . $i ];
            }
        }

        return $footer_primary_contact_info;
    }
}

if( ! function_exists( 'front_redux_apply_enable_bg_primary_v3' ) ) {
    function front_redux_apply_enable_bg_primary_v3() {
        global $front_options;

        if( isset( $front_options['bg_primary'] ) && $front_options['bg_primary'] == '1' ) {
            $bg_primary = true;
        } else {
            $bg_primary = false;
        }

        return $bg_primary;
    }
}