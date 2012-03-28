<?php

// only logged in users can add and object
gatekeeper();

// get the form input
$startdate = get_input('startdate');
$enddate = get_input('enddate');
$ongoing = get_input('ongoing');
$heading = get_input('heading');
$level = get_input('level');
$orientation = get_input('orientation');
$field = get_input('field');
$edutype = get_input('edutype');
$structure = get_input('structure');
$contact = get_input('contact');
$hourtype = get_input('hourtype');
$gradetype = get_input('gradetype');
$classrank = get_input('classrank');
$prizes = get_input('prizes');
$subjects = get_input('subjects');
$scores = get_input('scores');
$hours = get_input('hours');
$types = get_input('types');

$counted_subjects = count($subjects);

for( $i = 0; $i < $counted_subjects; $i++ ) {
      $starts[] = get_input('starts'.$i);
      $ends[] = get_input('ends'.$i);
 }
 
$description = get_input('description');
$access_id = get_input('access_id');

$structure2 = get_input('structure2');
$insttype = get_input('insttype');
$country = get_input('country');
$budget = get_input('budget');
$professors = get_input('professors');
$students = get_input('students');

     // Convert all numbers to integers
       $budget = intval($budget);
       $professors = intval($professors);
       $students = intval($students);
       
    // ADD TO DATABASE ONLY IF COUNTRY IS SET, TO AVOID DUPLICITY!
    if (($structure2) && ($country)) {
          $query = "SELECT * FROM {$CONFIG->dbprefix}university_entity
          WHERE name='$structure2'";
          $university = get_data_row($query);
          $unicountry = $university->country; 
          // Only if it is NOT ALREADY in the DB
          if (!($university) || ($unicountry != $country)) {
  	      $query = "INSERT INTO university_entity 
          	  SET name='$structure2', type='$insttype', country='$country', 
                      budget='$budget', professors='$professors', students='$students', 
                      ranked='0'";
              insert_data($query);
          }
    }
    
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
$experience->orientation = $orientation;
$experience->field = $field;
$experience->edutype = $edutype;
$experience->structure = $structure;
$experience->contact = $contact;
$experience->hourtype = $hourtype;
$experience->gradetype = $gradetype;
$experience->classrank = $classrank;
$experience->prizes = $prizes;
$experience->subjects = $subjects;
$experience->scores = $scores;
$experience->hours = $hours;
$experience->types = $types;
$experience->starts = $starts;
$experience->ends = $ends;
$experience->description = $description;

// Titre déduit des autres infos = (typology :) jobtitle @ organisation
$experience->title = $heading . ' @ ' . $structure;
$experience->subtype = 'education';
      
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
forward($CONFIG->wwwroot . "resumes/" . elgg_get_logged_in_user_entity()->username. "?tab=education");
