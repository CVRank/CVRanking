<?php

// only logged in users can add and object
gatekeeper();

// get the form input
$startdate = get_input('startdate');
$enddate = get_input('enddate');
$ongoing = get_input('ongoing');
$heading = get_input('heading');
$structure = get_input('structure');

$level = get_input('level');
$field = get_input('field');
$prizes = get_input('prizes');

$articles = get_input('articles');
$citations = get_input('citations');
$maxcitations = get_input('maxcitations');
$journals = get_input('journals');
$impacts = get_input('impacts');
$maximpacts = get_input('maximpacts');
$eigens = get_input('eigens');
$maxeigens = get_input('maxeigens');
$authors = get_input('authors');
$positions = get_input('positions');

$counted_articles = count($articles);

for( $i = 0; $i < $counted_articles; $i++ ) {
      $ends[] = get_input('ends'.$i);
 }

$description = get_input('description');
$contact = get_input('contact');
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
$experience->structure = $structure;

$experience->description = $description;
$experience->contact = $contact;

$experience->level = $level;
$experience->field = $field;
$experience->prizes = $prizes;

$experience->articles = $articles;
$experience->citations = $citations;
$experience->maxcitations = $maxcitations;
$experience->journals = $journals;
$experience->impacts = $impacts;
$experience->maximpacts = $maximpacts;
$experience->eigens = $eigens;
$experience->maxeigens = $maxeigens;
$experience->authors = $authors;
$experience->positions = $positions;
$experience->ends = $ends;
$experience->contact = $contact;
$experience->description = $description;

// Titre déduit des autres infos = (typology :) jobtitle @ organisation
$experience->title = $heading . ' @ ' . $structure;
$experience->subtype = 'research';

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
forward($CONFIG->wwwroot . "resumes/" . elgg_get_logged_in_user_entity()->username. "?tab=research");
