<?php

$performed_by = get_entity($vars['item']->subject_guid);
$object = get_entity($vars['item']->object_guid);
$subtype = $object->getSubtype();
$itemType = elgg_echo("resume:river:$subtype");

$url = '<a href="'.$performed_by->getURL().'">'.$performed_by->name.'</a>';

$string = sprintf(elgg_echo("resume:river:annotated"), $url, $itemType) . " ";
$string .= elgg_echo('resume:menu:item') . '</a> : ';
$string .= '<a href="' . $object->getURL() . '">' . $object->title . '</a>';

echo $string;
