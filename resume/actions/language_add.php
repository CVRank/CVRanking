<?php

// only logged in users can add and object
gatekeeper();

// get the form input
$startdate = get_input('startdate');
$enddate = get_input('enddate');
$lang_id = get_input('language');
$langtype = get_input('langtype');

$listening = get_input('listening');
$reading = get_input('reading');
$spokeninteraction = get_input('spokeninteraction');
$spokenproduction = get_input('spokenproduction');
$writing = get_input('writing');

$experience = get_input('experience');

$exams = get_input('exams');
$grades = get_input('grades');
$hours = get_input('hours');
$countries = get_input('countries');

$counted_exams = count($exams);

for( $i = 0; $i < $counted_exams; $i++ ) {
      $starts[] = get_input('starts'.$i);
      $ends[] = get_input('ends'.$i);
 } 

$exam2 = get_input('exam2');
$level = get_input('level');
$students = get_input('students');
$official = get_input('official');
$valid = get_input('valid');
$country = get_input('country');

     // Convert all numbers to integers
     $students = intval($students);
     $official = intval($official);
     $valid = intval($valid);
     
      // ADD TO DATABASE IF EXAM2 IS SET
   if ($exam2) {
          $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_language_entity
          WHERE name='$exam2'";
          $language = get_data_row($query);
          // Only if it is NOT ALREADY in the DB
          if (!($language)) {
  	      $query = "INSERT INTO {$CONFIG->dbprefix}CVR_language_entity 
          	  SET name='$exam2', level='$level',
                      students='$students', official='$official', valid='$valid',  
                      country='$country'";
              insert_data($query);
          }
   }
   
$contact = get_input('contact');
$description = get_input('description');
$access_id = get_input('access_id');

// proof if _edit or _add action is needed
 $guid = get_input('id');
 if ($guid) {
     
   // get the form input
   $guid = (int) $guid;

    if (can_edit_entity($guid)) {
      //get the object to replace the metadata
      $language = get_entity($guid);
      $action = "update";
    }
 }
 else {
   // create a new object
   $language = new ElggObject();
      $action = "create";
 }
$language->startdate = $startdate;
$language->enddate = $enddate;
$language->language = $lang_id;
$language->langtype = $langtype;
$language->listening = $listening;
$language->reading = $reading;
$language->spokeninteraction = $spokeninteraction;
$language->spokenproduction = $spokenproduction;
$language->writing = $writing;

$language->experience = $experience;
$language->exams = $exams;
$language->grades = $grades;
$language->hours = $hours;
$language->starts = $starts;
$language->ends = $ends;
$language->countries = $countries;

$language->contact = $contact;
$language->description = $description;

// allow access rights for the resume
$experience->title = $lang_id . ' (' . $structure . ')';
$language->subtype = 'language';

$language->access_id = $access_id;

// owner is logged in user
$language->owner_guid = elgg_get_logged_in_user_guid();

// save to database
$language->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', $action, elgg_get_logged_in_user_guid(), $language->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "resumes/" . elgg_get_logged_in_user_entity()->username. "?tab=language");
