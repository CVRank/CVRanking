<?php
/**
 * CVRanking navigation
 */

/**
 * @todo : Allow import/export of objects through pageshell (e.g. XML).
 * @todo : Add buttons "import" and "export".
 */


$CONFIG;

$page_owner = $vars['owner'];

$object = array('owner' => $page_owner);

$tab = get_input('tab');

$tabs = array();

if (elgg_get_plugin_setting('cvranking') == 'yes') {
    if (!$tab) $tab = 'resume';
    $tabs[] = array(
                        'title' => elgg_echo('resume:label:resume'), 
                        'url' => "$url" . '?tab=resume', 
                        'selected' => ($tab == 'resume')
                        );
}
    
if (elgg_get_plugin_setting('education') == 'yes') {
    if (!$tab) $tab = 'education';
    $tabs[] = array(
                        'title' => elgg_echo('resume:label:education'), 
                        'url' => "$url" . '?tab=education', 
                        'selected' => ($tab == 'education')
                        );
    }
    
 if (elgg_get_plugin_setting('workexperience') == 'yes') {
    if (!$tab) $tab = 'workexperience';
    $tabs[] = array(
                        'title' => elgg_echo('resume:label:workexperience'), 
                        'url' => "$url" . '?tab=workexperience', 
                        'selected' => ($tab == 'workexperience')
                        );
    }
    
 if (elgg_get_plugin_setting('language') == 'yes') {  
    if (!$tab) $tab = 'language'; 
    $tabs[] = array(
                        'title' => elgg_echo('resume:label:language'), 
                        'url' => "$url" . '?tab=language', 
                        'selected' => ($tab == 'language')
                        );
    }
    
 if (elgg_get_plugin_setting('research') == 'yes') { 
    if (!$tab) $tab = 'research';
    $tabs[] = array(
                        'title' => elgg_echo('resume:label:research'), 
                        'url' => "$url" . '?tab=research', 
                        'selected' => ($tab == 'research')
                        );
    }
    
 if (elgg_get_plugin_setting('publication') == 'yes') { 
    if (!$tab) $tab = 'publication';
    $tabs[] = array(
                        'title' => elgg_echo('resume:label:publication'), 
                        'url' => "$url" . '?tab=publication', 
                        'selected' => ($tab == 'publication')
                        );
    }
    
 if (elgg_get_plugin_setting('skill') == 'yes') { 
    if (!$tab) $tab = 'skill';
    $tabs[] = array(
                        'title' => elgg_echo('resume:label:skill'), 
                        'url' => "$url" . '?tab=skill', 
                        'selected' => ($tab == 'skill')
                        );
    }
    
 if (elgg_get_plugin_setting('CVR') == 'yes') { 
    if (!$tab) $tab = 'CVR';
    $tabs[] = array(
                        'title' => elgg_echo('resume:label:cvranking'), 
                        'url' => "$url" . '?tab=cvranking', 
                        'selected' => ($tab == 'cvranking')
                        );
    }
    
$params = array('tabs' => $tabs);
    
echo elgg_view('navigation/tabs', $params);

if ($tab != "resume") 
echo '<a class="elgg-button elgg-button-action" style="float:right;margin-bottom:5px" href="' 
    . $CONFIG->wwwroot . 'mod/resume/' . $tab . '.php">Add New</a>';

switch($tab) {
    case 'resume':
            echo elgg_view('resume/tab/resume', $object);
            break;
    case 'education':
            echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'education', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false));
            break;
    case 'workexperience':
            echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'workexperience', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false));
            break;
    case 'language':
            echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'language', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false));
            break;
    case 'research':
            echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'research', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false));
            break;
    case 'publication':
            echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'publication', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false));
            break;
    case 'skill':
            echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'skill', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false));
            break;
    case 'cvranking':
            echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'cvranking', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false));
            break;
    default :
            break;

}
