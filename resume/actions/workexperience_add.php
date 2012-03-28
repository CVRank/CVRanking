<?php

// only logged in users can add and object
gatekeeper();

// get the form input
$startdate = get_input('startdate');
$enddate = get_input('enddate');
$ongoing = get_input('ongoing');
$heading = get_input('heading');
$sector = get_input('sector');
$level = get_input('level');
$structure = get_input('structure');
$currency = get_input('currency');
$industryclass = get_input('industryclass');
$contact = get_input('contact');
$positions = get_input('positions');
$wages = get_input('wages');
$hours = get_input('hours');
$weeks = get_input('weeks');

$counted_positions = count($positions);

for( $i = 0; $i < $counted_positions; $i++ ) {
      $starts[] = get_input('starts'.$i);
      $ends[] = get_input('ends'.$i);
 } 
 
$description = get_input('description');
$access_id = get_input('access_id');

$structure2 = get_input('structure2');
$country = get_input('country');
$currencycap = get_input('currencycap');
$incomecap = get_input('incomecap');
$assetcap = get_input('assetcap');
$marketcap = get_input('marketcap');
$workers = get_input('workers');
$industryclass2 = get_input('industryclass2');

     // Convert all numbers to integers
     $incomecap = intval($incomecap);
     $assetcap = intval($assetcap);
     $marketcap = intval($marketcap);
     $workers = intval($workers);  
     
// Take arrays and do calculations only if data with _cap are added
if (($incomecap) || ($assetcap) || ($marketcap)) {
         $arrays = set_defaultcvr();
     // NEED TO CONVERT TO DOLLARS!!
     // We save it here so that no constant calculations of TOTALS are necessary in CVR.
     // We can re-calculate total with new Mac Index in the future...
         $currencies = $arrays['currencies'];
         $currval = $currencies[$currencycap];
         $total = ($incomecap + $assetcap + $marketcap)/3;
         $total = $total * $currval;
     
    // INDUSTRYCLASS2 number to letter
    if (is_numeric($industryclass2)) {
        // get first two numbers, if number is bigger
        if ((strlen($industryclass2)) > 2) {
           $industryclass2 = substr($industryclass2, 0, 2);
        }
        // now get the sector group
        if (($industryclass2 == "01") || ($industryclass2 == "02") || ($industryclass2 == "03")) {
            $industryclass2 = "A";
        }
        elseif (($industryclass2 == "05") || ($industryclass2 == "06") || ($industryclass2 == "07")
                || ($industryclass2 == "08") || ($industryclass2 == "09")) {
            $industryclass2 = "B";
        }
        elseif ($industryclass2 == "35") {
            $industryclass2 = "D";
        }
        elseif (($industryclass2 == "36") || ($industryclass2 == "37")
                || ($industryclass2 == "38") || ($industryclass2 == "39")) {
            $industryclass2 = "E";
        }
        elseif (($industryclass2 == "41") || ($industryclass2 == "42")
                || ($industryclass2 == "43")) {
            $industryclass2 = "F";
        }
        elseif (($industryclass2 == "45") || ($industryclass2 == "46")
                || ($industryclass2 == "47")) {
            $industryclass2 = "G";
        }
        elseif (($industryclass2 == "49") || ($industryclass2 == "50") || ($industryclass2 == "51")
                || ($industryclass2 == "52") || ($industryclass2 == "53")) {
            $industryclass2 = "H";
        }
        elseif (($industryclass2 == "55") || ($industryclass2 == "56")) {
            $industryclass2 = "I";
        }
        elseif (($industryclass2 == "58") || ($industryclass2 == "59") || ($industryclass2 == "60")
                || ($industryclass2 == "61") || ($industryclass2 == "62") || ($industryclass2 == "63")) {
            $industryclass2 = "J";
        }
        elseif (($industryclass2 == "64") || ($industryclass2 == "65")
                || ($industryclass2 == "6")) {
            $industryclass2 = "K";
        }
        elseif ($industryclass2 == "68") {
            $industryclass2 = "L";
        }
        elseif (($industryclass2 == "69") || ($industryclass2 == "70") || ($industryclass2 == "71")
                || ($industryclass2 == "72") || ($industryclass2 == "73") || ($industryclass2 == "74")
                || ($industryclass2 == "75")) {
            $industryclass2 = "M";
        }
        elseif (($industryclass2 == "77") || ($industryclass2 == "78") || ($industryclass2 == "79")
                || ($industryclass2 == "80") || ($industryclass2 == "81") || ($industryclass2 == "82")
                || ($industryclass2 == "83")) {
            $industryclass2 = "N";
        }
        elseif ($industryclass2 == "84") {
            $industryclass2 = "O";
        }
        elseif ($industryclass2 == "85") {
            $industryclass2 = "P";
        }
        elseif (($industryclass2 == "86") || ($industryclass2 == "87") || ($industryclass2 == "88")) {
            $industryclass2 = "Q";
        }
        elseif (($industryclass2 == "90") || ($industryclass2 == "91") || ($industryclass2 == "92")
                || ($industryclass2 == "93")) {
            $industryclass2 = "R";
        }
        elseif (($industryclass2 == "94") || ($industryclass2 == "95") || ($industryclass2 == "96")) {
            $industryclass2 = "S";
        }
        elseif (($industryclass2 == "97") || ($industryclass2 == "98")) {
            $industryclass2 = "T";
        }
        elseif ($industryclass2 == "99") {
            $industryclass2 = "U";
        }
        else {
            $industryclass2 = "C";
        }
    }
    
    // ADD TO DATABASE ONLY IF COUNTRY IS SET, TO AVOID DUPLICITY!
   if (($structure2) && ($country)) {
          $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_company_entity
          WHERE name='$structure2'";
          $company = get_data_row($query);
          $comcountry = $company->country; 
          // Only if it is NOT ALREADY in the DB
          if (!($company) || ($comcountry != $country)) {
  	      $query = "INSERT INTO {$CONFIG->dbprefix}CVR_company_entity 
          	  SET name='$structure2', country='$country', 
                      incomecap='$incomecap', assetcap='$assetcap', marketcap='$marketcap', 
                      workers='$workers', industryclass='$industryclass2', total='$total', 
                      currencycap='$currencycap', ranked='0'";
              insert_data($query);
          }
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
$experience->description = $description;
$experience->sector = $sector;
$experience->level = $level;
$experience->structure = $structure;
$experience->currency = $currency;
$experience->industryclass = $industryclass;
$experience->contact = $contact;

$experience->positions = $positions;
$experience->wages = $wages;
$experience->hours = $hours;
$experience->weeks = $weeks;
$experience->starts = $starts;
$experience->ends = $ends;

// Titre déduit des autres infos = (typology :) jobtitle @ organisation
$experience->title = $heading . ' @ ' . $structure;
$experience->subtype = 'workexperience';

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
forward($CONFIG->wwwroot . "resumes/" . elgg_get_logged_in_user_entity()->username. "?tab=workexperience");