<?php

/**
 * Template Hooks used in WeDocs
 */

add_action( 'wedocs_before_main_content', 'front_wedocs_single_docs_remove_hooks', 5 );

add_filter( 'wedocs_post_type', 'front_wedocs_post_type_args', 10 );

add_action( 'wedocs_before_main_content', 'front_wedocs_docs_search_form', 10 );

add_action( 'front_wedocs_before_single_doc', 'front_wedocs_breadcrumbs', 10 );

add_action( 'front_wedocs_single_doc', 'front_wedocs_docs_entry_header', 10 );
add_action( 'front_wedocs_single_doc', 'front_wedocs_docs_entry_content', 20 );
add_action( 'front_wedocs_single_doc', 'front_wedocs_docs_entry_feedback', 30 );
add_action( 'front_wedocs_single_doc', 'front_wedocs_related_articles', 40 );

add_action( 'front_page_before', 'front_wedocs_docs_home_hooks', 5 );