<?php
/**
 * Resume
 *
 * @package Resume
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @copyright Consultora Nivel7 Ltda.
 * @link http://www.nivel7.net
 */
// only logged in users can add and object
gatekeeper();

// get the form input
$startdate = get_input('startdate');
$enddate = get_input('enddate');
$ongoing = get_input('ongoing');
$heading = get_input('heading');
$level = get_input('level');
$skilltype = get_input('skilltype');

$certs = get_input('certs');
$scores = get_input('scores');
$structures = get_input('structures');

$counted_certs = count($certs);

for( $i = 0; $i < $counted_certs; $i++ ) {
      $starts[] = get_input('starts'.$i);
      $ends[] = get_input('ends'.$i);
 }
 
$contact = get_input('contact');
$description = get_input('description');

$access_id = get_input('access_id');
$access_id = get_input('access_id');

// create a new object
$experience = new ElggObject();
$experience->startdate = $startdate;
$experience->enddate = $enddate;
$experience->ongoing = $ongoing;
$experience->heading = $heading;
$experience->level = $level;
$experience->skilltype = $skilltype;

$experience->certs = $certs;
$experience->scores = $scores;
$experience->structures = $structures;
$experience->starts = $starts;
$experience->ends = $ends;

$experience->contact = $contact;
$experience->description = $description;

$experience->title = $heading . ' (' . $typology . ')';
$experience->subtype = 'skill';

// allow access rights for the resume
$experience->access_id = $access_id;

// owner is logged in user
$experience->owner_guid = get_loggedin_userid();

// save to database
$experience->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', 'create', get_loggedin_userid(), $skill->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
