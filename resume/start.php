<?php
/**
 * CVRanking Resume  
 * 
 * @package Resume
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @author Facyla <admin@facyla.fr>
 * @author Carlos Quiles <cquiles@cvrank.org>
 * @copyright 2010-2011 Consultora Nivel7 Ltda.
 * @copyright 2010-2011 FormaVia
 * @copyright 2011-2012 CVRank
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @link http://cvrank.org/
 */

elgg_register_event_handler('init', 'system', 'resume_init');
  
	require_once(dirname(__FILE__) . "/lib/css.php");
	require_once(dirname(__FILE__) . "/lib/arrays.php");
	require_once(dirname(__FILE__) . "/lib/setters.php");
	require_once(dirname(__FILE__) . "/lib/grades.php");
	require_once(dirname(__FILE__) . "/lib/cvranking.php");
	require_once(dirname(__FILE__) . "/lib/education.php");
	require_once(dirname(__FILE__) . "/lib/workexperience.php");
	require_once(dirname(__FILE__) . "/lib/language.php");
	require_once(dirname(__FILE__) . "/lib/research.php");
	require_once(dirname(__FILE__) . "/lib/publication.php");
	require_once(dirname(__FILE__) . "/lib/skill.php");

function resume_init() {
    
  // Add menu item to logged users
  if (elgg_is_logged_in ()) { 
    elgg_register_menu_item('site', array(
            'name' => 'resume',
            'text' => elgg_echo('resume:menu:item'),
            'href' => 'resumes/' . elgg_get_logged_in_user_entity()->username
        ));
    elgg_register_menu_item('topbar', array(
            'name' => 'resume',
            'text' => elgg_echo('resume:menu:item'),
            //'text' => '<img src="' . elgg_get_site_url() .'mod/resume/graphics/curriculum_vitae_18.png" />',
            'href' => 'resumes/' . elgg_get_logged_in_user_entity()->username
        ));
  }
  // elgg_unregister_menu_item('topbar', 'elgg_logo');
  
  // Extend profile menu to include resume item - doesn't work?
  // elgg_extend_view('profile/menu/links', 'resume/menu');
  
  // add resume link to profile menu
  elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'resume_owner_block_menu');
  
  // add CVRanking view to profile -- seems to get double content?
  //elgg_extend_view('profile/status', 'resume/tab/resume');

// Extend CSS with plugin's CSS
   $css_url = 'mod/resume/views/default/css/main.css';
   elgg_register_css('special', $css_url);
   elgg_load_css('special');
  
  // Extend js with plugin's js
  // elgg_register_simplecache_view('js/resume/education');
  // $url = elgg_get_simplecache_url('js', 'resume/education');
  // elgg_extend_view('metatags', 'resume/metatags');
  
  // Extend search
  if (elgg_get_plugin_setting('cvranking') == 'yes') elgg_register_entity_type('object', 'cvranking');
  if (elgg_get_plugin_setting('education') == 'yes') elgg_register_entity_type('object', 'education');
  if (elgg_get_plugin_setting('workexperience') == 'yes') elgg_register_entity_type('object', 'workexperience');
  if (elgg_get_plugin_setting('language') == 'yes') elgg_register_entity_type('object', 'language');
  if (elgg_get_plugin_setting('research') == 'yes') elgg_register_entity_type('object', 'research');
  if (elgg_get_plugin_setting('publication') == 'yes') elgg_register_entity_type('object', 'publication');
  if (elgg_get_plugin_setting('experience') == 'yes') elgg_register_entity_type('object', 'experience');
  if (elgg_get_plugin_setting('skill') == 'yes') elgg_register_entity_type('object', 'skill');
  if (elgg_get_plugin_setting('skill_ciiee') == 'yes') elgg_register_entity_type('object', 'skill_ciiee');
}

function resume_pagesetup() {
  $page_owner = elgg_get_page_owner_entity();
  $loggedin_username = elgg_get_logged_in_user_entity()->username;

  //Add submenu items to the page
  if (elgg_get_context() == "resumes") {
    // Add page owner's exclusive items to menu
    if ($page_owner->guid == elgg_get_logged_in_user_entity()->guid) {
      if (elgg_get_plugin_setting('cvranking') == 'yes') elgg_register_menu_item('page', array(
            'name' => '8',
            'text' => elgg_echo('resume:add:cvranking'),
            'href' => "mod/resume/cvranking.php",
            'priority' => "1",
                    ));
      if (elgg_get_plugin_setting('education') == 'yes') elgg_register_menu_item('page', array(
            'name' => '2',
            'text' => elgg_echo('resume:add:education'),
            'href' => "mod/resume/education.php",
            'priority' => "1",
                    ));
      if (elgg_get_plugin_setting('workexperience') == 'yes') elgg_register_menu_item('page', array(
            'name' => '3',
            'text' => elgg_echo('resume:add:workexperience'),
            'href' => "mod/resume/workexperience.php",
            'priority' => "1",
                    ));
      if (elgg_get_plugin_setting('language') == 'yes') elgg_register_menu_item('page', array(
            'name' => '4',
            'text' => elgg_echo('resume:add:language'),
            'href' => "mod/resume/language.php",
            'priority' => "1",
                    ));
      if (elgg_get_plugin_setting('research') == 'yes') elgg_register_menu_item('page', array(
            'name' => '5',
            'text' => elgg_echo('resume:add:research'),
            'href' => "mod/resume/research.php",
            'priority' => "1",
                    ));
      if (elgg_get_plugin_setting('publication') == 'yes') elgg_register_menu_item('page', array(
            'name' => '6',
            'text' => elgg_echo('resume:add:publication'),
            'href' => "mod/resume/publication.php",
            'priority' => "1",
                    ));
      if (elgg_get_plugin_setting('skill') == 'yes') elgg_register_menu_item('page', array(
            'name' => '7',
            'text' => elgg_echo('resume:add:skill'),
            'href' => "mod/resume/skill.php",
            'priority' => "1",
                    ));
      if (elgg_is_active_plugin('protovis')) {
        elgg_register_menu_item('page', array(
            'name' => 'chronogram',
            'text' => elgg_echo('resume:chronogram'),
            'href' => "mod/resume/chronogramme.php?id=" . $page_owner->guid
                ));
        //elgg_register_menu_item(elgg_echo('resume:skillgraph'), $CONFIG->wwwroot . "mod/resume/skillgraph.php"); // @todo
      }
      
    } else if (elgg_is_logged_in ()) {
      // Not "Page owner's" exclusive items
      elgg_register_menu_item('userprofile', array(
            'name' => 'goto',
            'text' => elgg_echo('resume:menu:goto'),
            'href' => "resumes/" . $loggedin_username
                    ));
      if (elgg_is_active_plugin('protovis')) {
        elgg_register_menu_item(elgg_echo('resume:chronogram'), "mod/resume/chronogramme.php?id=" . $page_owner->guid, "main_resume");
      } 
    }
    
  }
 
  // Add "cancel" option if the user is in a create/edit form
  if (elgg_get_context() == "resumes_form") {
        elgg_register_menu_item('page', array(
            'name' => 'cancel',
            'text' => elgg_echo('resume:menu:cancel'),
            'href' => "resumes/" . $loggedin_username
                ));
  }
  
}

function resume_page_handler($page) {
    
  $base = elgg_get_plugins_path() . 'resume';
  
  $vars = array();
        
  if (isset($page[0])) {
        $vars['page'] = $page[0];
    } elseif (elgg_is_logged_in()) {
        $vars['page'] = elgg_get_logged_in_user_entity()->username;
    } else {
        return false;
    }

  require_once "$base/index.php";
  
    return true;
}

function resume_owner_block_menu($hook, $type, $return, $params) {
		$url = "resumes/{$params['entity']->username}";
		$item = new ElggMenuItem('resume', elgg_echo('resume:menu:item'), $url);
                //doesn't work as it should?
                //$item->setPriority(1);
		$return[] = $item;
	return $return;
}

/* Printed profile page */
function printed_page_handler($page) {
  echo elgg_view("page_elements/header"); ?>
  <div class="resume_body_printer">
    <?php

    elgg_set_context("profileprint");
    // determine wich user resume are we showing
    if (isset($page[0]) && !empty($page[0])) {
      $username = $page[0];
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
      echo elgg_view('resume/printed', array('owner' => $page_owner));
    }
  echo '</div><!-- /#resume_body_printer -->';
}

/* Décode les entités HTML ; nécessaire pour le flux XML qui n'apprécie pas vraiment les entités HTML, et évite de répéter les 2 fonctions à chaque fois..
Note : il faut parfois aussi également encoder en UTF-8 avec utf8_encode($txt)
*/
if (!function_exists('unhtmlentities')) {
  function unhtmlentities($chaineHtml) {
    $tmp = get_html_translation_table(HTML_ENTITIES);
    $tmp = array_flip ($tmp);
    $chaineTmp = strtr ($chaineHtml, $tmp);
    return $chaineTmp; 
  }
}
  
// ******************** REGISTER ACTIONS ******************
elgg_register_action("resume/delete", elgg_get_plugins_path() . "resume/actions/delete.php");
elgg_register_action("resume/edit", elgg_get_plugins_path() . "resume/actions/edit.php");

if (elgg_get_plugin_setting('cvranking') == 'yes') { elgg_register_action("resume/cvranking_add", elgg_get_plugins_path() . "resume/actions/cvranking_add.php"); }
if (elgg_get_plugin_setting('education') == 'yes') { elgg_register_action("resume/education_add", elgg_get_plugins_path() . "resume/actions/education_add.php"); }
if (elgg_get_plugin_setting('workexperience') == 'yes') { elgg_register_action("resume/workexperience_add", elgg_get_plugins_path() . "resume/actions/workexperience_add.php"); }
if (elgg_get_plugin_setting('language') == 'yes') { elgg_register_action("resume/language_add", elgg_get_plugins_path() . "resume/actions/language_add.php"); }
if (elgg_get_plugin_setting('research') == 'yes') { elgg_register_action("resume/research_add", elgg_get_plugins_path() . "resume/actions/research_add.php"); }
if (elgg_get_plugin_setting('publication') == 'yes') { elgg_register_action("resume/publication_add", elgg_get_plugins_path() . "resume/actions/publication_add.php"); }
if (elgg_get_plugin_setting('skill') == 'yes') { elgg_register_action("resume/skill_add", elgg_get_plugins_path() . "resume/actions/skill_add.php"); }

// ******************** REGISTER PAGE HANDLER ******************
elgg_register_page_handler('resumes', 'resume_page_handler');
elgg_register_page_handler('resumesprintversion', 'printed_page_handler');


// ******************** REGISTER EVENT HANDLERS ******************
elgg_register_event_handler('pagesetup', 'system', 'resume_pagesetup');
elgg_register_event_handler('init', 'system', 'resume_init');
