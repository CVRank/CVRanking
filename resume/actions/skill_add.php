<?php

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


// proof if _edit or _add action is needed
 $guid = get_input('id');
 if ($guid) {
     
   // get the form input
   $guid = (int) $guid;

    if (can_edit_entity($guid)) {
      //get the object to replace the metadata
      $experience = get_entity($guid);
      $action = "update";
    }
 }
 else {
   // create a new object
   $experience = new ElggObject();
   $action = "create";
 }
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

$experience->title = $heading . ' (' . $skilltype . ')';
$experience->subtype = 'skill';

// allow access rights for the resume
$experience->access_id = $access_id;

// owner is logged in user
$experience->owner_guid = elgg_get_logged_in_user_guid();

// save to database
$experience->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', $action, elgg_get_logged_in_user_guid(), $experience->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "resumes/" . elgg_get_logged_in_user_entity()->username. "?tab=skill");
