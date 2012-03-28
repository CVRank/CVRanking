<?php

// Load Elgg engine
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// make sure only logged in users can see this page
gatekeeper();
// set context to add a "cancel" option
elgg_set_context('resumes_form');

//set_page_owner(get_loggedin_user()->getGUID());
elgg_set_page_owner_guid($_SESSION['user']->guid);

// set the titlev
$title = elgg_echo('resume:add:education');

// start building the main column of the page
$area2 = elgg_view_title($title);

/*
 * If we want to create specific menus here:
$sidebar = '<a href="javascript:history.back()">';
$sidebar .= elgg_echo('resume:menu:goto');
$sidebar .= '</a>';
*/

// Add the form to this section
if (get_input('id')) {
  $gid = (int) get_input('id');
  $education = get_entity($gid);
  $area2 .= elgg_view("resume/form/education_form", array('entity' => $education));
} else {
  $area2 .= elgg_view("resume/form/education_form");
}
// layout the page
$body = elgg_view('page/layouts/one_sidebar', array('content' => $area2, 'sidebar' => $sidebar));
// draw the page
echo elgg_view_page ($title, $body);
