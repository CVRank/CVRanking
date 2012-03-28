<?php
global $CONFIG;
$yesno_opt = array('no' => elgg_echo('resume:settings:no'), 'yes' => elgg_echo('resume:settings:yes'));

// cvranking
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:cvranking') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[cvranking]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->cvranking));
echo '<p>' . elgg_echo('resume:settings:cvranking:help') . '</p><br />';

// education
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:education') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[education]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->education));
echo '<p>' . elgg_echo('resume:settings:education:help') . '</p><br />';

// workexperience
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:workexperience') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[workexperience]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->workexperience));
echo '<p>' . elgg_echo('resume:settings:workexperience:help') . '</p><br />';

// language
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:language') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[language]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->language));
echo '<p>' . elgg_echo('resume:settings:language:help') . '</p><br />';

// research 
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:research') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[research]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->research));
echo '<p>' . elgg_echo('resume:settings:research:help') . '</p><br />';

// publication
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:publication') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[publication]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->publication));
echo '<p>' . elgg_echo('resume:settings:publication:help') . '</p><br />';

// skill
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:skill') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[skill]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->skill));
echo '<p>' . elgg_echo('resume:settings:skill:help') . '</p><br />';
