<?php
$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
$object = get_entity($vars['item']->object_guid);
$url = $object->getURL();

$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";

// Facyla : easier to handle more subtype, if ever
$subtype = $object->getSubtype();
switch($subtype) {
  case "workexperience" :
    $itemType = elgg_echo("resume:experience:workexperiences");
    break;
  case "education" :
    $itemType = elgg_echo("resume:experience:education");
    break;
  case "language" :
    $itemType = elgg_echo("resume:experience:languages");
    break;
  case "research" :
    $itemType = elgg_echo("resume:experience:researches");
    break;
  case "publication" :
    $itemType = elgg_echo("resume:experience:publications");
    break;
  case "experience" :
    $itemType = elgg_echo("resume:experience:experiences");
    break;
  case "work" :
    $itemType = elgg_echo("resume:experience:work");
    break;
  case "academic" :
    $itemType = elgg_echo("resume:experience:academic");
    break;
  case "language" :
    $itemType = elgg_echo("resume:languages");
    break;
  case "rLanguage" :
    $itemType = elgg_echo("resume:languages");
    break;
  case "rReference" :
    $itemType = elgg_echo("resume:references");
    break;
  case "rWork" :
    $itemType = elgg_echo("resume:works");
    break;
  case "rAcademic" :
    $itemType = elgg_echo("resume:academics");
    break;
  case "rTraining" :
    $itemType = elgg_echo("resume:trainings");
    break;
  default:
    $itemType = elgg_echo("resume:river:$subtype");
}

$string = sprintf(elgg_echo("resume:river:updated"), $url, $itemType) . " ";
$string .= "<a href=\"{$vars['url']}pg/resumes/{$performed_by->username}\">" . elgg_echo('resume:menu:item'). "</a>";


echo $string;

