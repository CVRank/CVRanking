<?php

$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
$object = get_entity($vars['item']->object_guid);
$url = $object->getURL();
$action_type = $vars['item']->action_type;

$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";

// Facyla : easier to handle more subtype, if ever
$subtype = $object->getSubtype();
switch($subtype) {
  case "education" :
    $itemType = elgg_echo("resume:river:education");
    break;
  case "workexperience" :
    $itemType = elgg_echo("resume:river:workexperience");
    break;
  case "language" :
    $itemType = elgg_echo("resume:river:language");
    break;
  case "research" :
    $itemType = elgg_echo("resume:river:research");
    break;
  case "publication" :
    $itemType = elgg_echo("resume:river:publication");
    break;
  case "skill" :
    $itemType = elgg_echo("resume:river:skill");
    break;
  default:
    $itemType = elgg_echo("resume:river:$subtype");
}

if ($action_type == "update") $action = "updated";
else $action = "created";

$string = sprintf(elgg_echo("resume:river:$action"), $url, $itemType) . " ";
$string .= "<a href=\"{$vars['url']}resumes/{$performed_by->username}\">" . elgg_echo('resume:menu:item'). "</a>";

echo $string;