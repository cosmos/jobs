<?php

add_filter( 'pt-ocdi/import_files', 'front_ocdi_import_files' );

add_action( 'pt-ocdi/after_import', 'front_ocdi_after_import_setup' );

add_action( 'pt-ocdi/before_widgets_import', 'front_ocdi_before_widgets_import' );

add_action( 'pt-ocdi/before_content_import', 'front_ocdi_before_content_import', 99 );

add_filter( 'pt-ocdi/confirmation_dialog_options', 'front_ocdi_confirmation_dialog_options', 10 );

add_filter( 'pt-ocdi/plugin_intro_text', 'front_ocdi_plugin_intro_text' );

add_action( 'admin_init', 'front_tgmpa_demo_selector_update' );

add_action( 'admin_enqueue_scripts', 'front_ocdi_admin_styles' );

add_filter( 'wp_import_post_data_processed', 'front_wp_import_post_data_processed', 99, 2 );

add_filter( 'wxr_importer.pre_process.post_meta', 'front_wp_import_post_meta_data_processed', 99, 2 );