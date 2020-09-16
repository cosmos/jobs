<?php
/**
 * Front Child
 *
 * @package front-child
 */

/**
 * Include all your custom code here
 */

add_action( 'wp_loaded', 'change_resume_labels', 20 );

function change_resume_labels()
{
  $p_object = get_post_type_object( 'resume' );
  $t_object = get_taxonomy( 'resume_category' );
  $t2_object = get_taxonomy( 'resume_skill' );

  if ( ! $p_object && $t_object && $t2_object )
  return FALSE;
  // see get_post_type_labels()
  $p_object->labels->name               = 'Contributors';
  $p_object->labels->singular_name      = 'Contributor';
  $p_object->labels->add_new            = 'Add contributor';
  $p_object->labels->add_new_item       = 'Add new contributor';
  $p_object->labels->all_items          = 'All contributors';
  $p_object->labels->edit_item          = 'Edit contributor';
  $p_object->labels->name_admin_bar     = 'Contributor';
  $p_object->labels->menu_name          = 'Contributor';
  $p_object->labels->new_item           = 'New contributor';
  $p_object->labels->not_found          = 'No contributors found';
  $p_object->labels->not_found_in_trash = 'No contributors found in trash';
  $p_object->labels->search_items       = 'Search contributors';
  $p_object->labels->view_item          = 'View contributor';

  $t_object->labels->name               = 'Contributors categories';
  $t_object->labels->singular_name      = 'Contributor category';
  $t_object->labels->add_new            = 'Add contributor category';
  $t_object->labels->add_new_item       = 'Add new contributor category';
  $t_object->labels->all_items          = 'All contributors categories';
  $t_object->labels->edit_item          = 'Edit contributor category';
  $t_object->labels->name_admin_bar     = 'Contributor category';
  $t_object->labels->menu_name					= 'Contributor categories';
  $t_object->labels->new_item           = 'New contributor category';
  $t_object->labels->not_found          = 'No contributors categories found';
  $t_object->labels->not_found_in_trash = 'No contributors categories found in trash';
  $t_object->labels->search_items       = 'Search contributors categories';
  $t_object->labels->view_item          = 'View contributor category';

  $t2_object->labels->name               = 'Contributors skills';
  $t2_object->labels->singular_name      = 'Contributor skill';
  $t2_object->labels->add_new            = 'Add contributor skill';
  $t2_object->labels->add_new_item       = 'Add new contributor skill';
  $t2_object->labels->all_items          = 'All contributors skills';
  $t2_object->labels->edit_item          = 'Edit contributor skill';
  $t2_object->labels->name_admin_bar     = 'Contributor skill';
  $t2_object->labels->menu_name					 = 'Contributor skills';
  $t2_object->labels->new_item           = 'New contributor skill';
  $t2_object->labels->not_found          = 'No contributors skills found';
  $t2_object->labels->not_found_in_trash = 'No contributors skills found in trash';
  $t2_object->labels->search_items       = 'Search contributors skills';
  $t2_object->labels->view_item          = 'View contributor skill';

  return TRUE;
}

