<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

$username = $vars['page'];

// forward away if invalid user.
if (!$user = get_user_by_username($username)) {
  register_error('blog:error:unknown_username');
  forward($_SERVER['HTTP_REFERER']);
}

// set the page owner to show the right content
elgg_set_page_owner_guid($user->getGUID());
$page_owner = elgg_get_page_owner_entity();

if ($page_owner === false || is_null($page_owner)) {
  $page_owner = elgg_get_logged_in_user_entity();
  elgg_set_page_owner_guid(elgg_get_logged_in_user_entity());
}

if ($page_owner->guid == elgg_get_logged_in_user_entity()->guid) 
    $title = elgg_echo('resume:my'); 
else  $title = sprintf(elgg_echo('resume:user'), $page_owner->name); 

$object = array('owner' => $page_owner);

// problem with title: a straight approach to class="elgg-heading-main" should be preferred...
$content = '<div class="titlebottom"></div>'; 

$content .= elgg_view('resume/resume', $object);

      // Add sidebar search
      //$area0 = elgg_view("resume/search");

set_input('id', $page_owner->guid);

elgg_set_context('resumes');

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('resume/sidebar', $object),
	'title' => $title
);

//elgg_view('resume/chronogram');

$body = elgg_view('page/layouts/one_sidebar', $params);

echo elgg_view_page($title, $body);
