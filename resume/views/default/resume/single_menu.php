<?php
global $resume_menu;
if(!$resume_menu && elgg_get_context() != "resumes") {
  $page_owner = elgg_get_page_owner_entity();
  if ($page_owner === false || is_null($page_owner)) { $page_owner = elgg_get_logged_in_user_entity(); }
  // Add link to resume option once (some views may list more than one resume element fullview at a time)
  elgg_register_menu_item('page', array(
            'name' => 'chronogram',
            'text' => sprintf(elgg_echo('resume:user'), $page_owner->name),
            'href' => $CONFIG->wwwroot . "resumes/" . $page_owner->username
                ));
  if (elgg_is_active_plugin('protovis')) {
    elgg_register_menu_item('page', array(
            'name' => 'chronogram',
            'text' => elgg_echo('resume:chronogram'),
            'href' => $CONFIG->wwwroot . "mod/resume/chronogramme.php?id=" . $page_owner->guid
                ));
    //add_submenu_item(elgg_echo('resume:skillgraph'), $CONFIG->wwwroot . "mod/resume/skillgraph.php?id=" . $page_owner->guid, "main_resume"); // @todo
  }
  $resume_menu = true;
}
