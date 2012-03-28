<?php
global $CONFIG;
$yesno_opt = array('no' => elgg_echo('resume:settings:no'), 'yes' => elgg_echo('resume:settings:yes'));

// cvranking
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:cvranking') . '</label> ';
echo elgg_view('input/dropdown', array('name' => 'params[cvranking]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->cvranking));
echo '<p>' . elgg_echo('resume:settings:cvranking:help') . '</p>';

// education
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:education') . '</label> ';
echo elgg_view('input/dropdown', array('name' => 'params[education]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->education));
echo '<p>' . elgg_echo('resume:settings:education:help') . '</p>';

// workexperience
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:workexperience') . '</label> ';
echo elgg_view('input/dropdown', array('name' => 'params[workexperience]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->workexperience));
echo '<p>' . elgg_echo('resume:settings:workexperience:help') . '</p>';

// language
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:language') . '</label> ';
echo elgg_view('input/dropdown', array('name' => 'params[language]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->language));
echo '<p>' . elgg_echo('resume:settings:language:help') . '</p>';

// research 
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:research') . '</label> ';
echo elgg_view('input/dropdown', array('name' => 'params[research]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->research));
echo '<p>' . elgg_echo('resume:settings:research:help') . '</p>';

// publication
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:publication') . '</label> ';
echo elgg_view('input/dropdown', array('name' => 'params[publication]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->publication));
echo '<p>' . elgg_echo('resume:settings:publication:help') . '</p>';

// skill
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:skill') . '</label> ';
echo elgg_view('input/dropdown', array('name' => 'params[skill]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->skill));
echo '<p>' . elgg_echo('resume:settings:skill:help') . '</p>';

// CVR
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:CVR') . '</label> ';
echo elgg_view('input/dropdown', array('name' => 'params[CVR]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->CVR));
echo '<p>' . elgg_echo('resume:settings:CVR:help') . '</p>';
