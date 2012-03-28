<?php

// only logged in users can add and object
gatekeeper();

// get the form input
$access_id = get_input('access_id');
$heading = get_input('heading');

$gweights = get_input('gweights'); 
$time = get_input('time'); 

for( $i = 0; $i < 3; $i++ ) { 
   ${fields.$i} = get_input('fields'.$i);
   ${sectors.$i} = get_input('sectors'.$i);
 }
 
$fweights = get_input('fweights');
$sweights = get_input('sweights');

for( $i = 0; $i < 2; $i++ ) { 
   ${countries.$i} = get_input('countries'.$i);
   ${edudbs.$i} = get_input('edudbs'.$i);
   ${credittypes.$i} = get_input('credittypes'.$i);
   ${edutypes.$i} = get_input('edutypes'.$i);
   
   ${wcountries.$i} = get_input('wcountries'.$i);
   ${workdbs.$i} = get_input('workdbs'.$i);
   ${sectortypes.$i} = get_input('sectortypes'.$i);
   
   ${languages.$i} = get_input('languages'.$i);
   ${langdbs.$i} = get_input('langdbs'.$i);
   
   ${resfields.$i} = get_input('resfields'.$i);
   ${pubfields.$i} = get_input('pubfields'.$i);
   ${skilltypes.$i} = get_input('skilltypes'.$i);
 }
 
$cweights = get_input('cweights');
$eweights = get_input('eweights');
$crweights = get_input('crweights');
$etweights = get_input('etweights');

$wcweights = get_input('wcweights');
$wweights = get_input('wweights');
$stweights = get_input('stweights');

$lweights = get_input('lweights');
$ldbweights = get_input('ldbweights');

$rfweights = get_input('rfweights');
$pfweights = get_input('pfweights');
$skweights = get_input('skweights');
 
for( $i = 0; $i < 3; $i++ ) { 
   ${cvrtypes.$i} = get_input('cvrtypes'.$i);
   ${orders.$i} = get_input('orders'.$i);
 }
 
 $users = get_input('users');
 
 $advanceds = get_input('advanceds');
 $aweights = get_input('aweights');
 
// proof if _edit or _add action is needed
 $guid = get_input('id');
 if ($guid) {
     
   // get the form input
   $guid = (int) $guid;

    if (can_edit_entity($guid)) {
      //get the object to replace the metadata
      $cvranking = get_entity($guid);
      $action = "update";
    }
 }
 else {
   // create a new object
   $cvranking = new ElggObject();
   $action = "create";
 }

   $cvranking->heading = $heading;

   $cvranking->gweights = $gweights;
   $cvranking->time = $time;
   
for( $i = 0; $i < 3; $i++ ) {
   $fieldi = 'fields'.$i;
   $cvranking->$fieldi = ${fields.$i};
   
   $sectori = 'sectors'.$i;
   $cvranking->$sectori = ${sectors.$i};
}
   $cvranking->fweights = $fweights;
   $cvranking->sweights = $sweights;
   
for( $i = 0; $i < 2; $i++ ) {
   $countryi = 'countries'.$i;
   $edudbi = 'edudbs'.$i;
   $credittypei = 'credittypes'.$i;
   $edutypei = 'edutypes'.$i;
   
   $wcountryi = 'wcountries'.$i;
   $workdbi = 'workdbs'.$i;
   $sectortypei = 'sectortypes'.$i;
   
   $languagei = 'languages'.$i;
   $langdbi = 'langdbs'.$i;
   
   $resfieldi = 'resfields'.$i;
   $pubfieldi = 'pubfields'.$i;
   $skilltypei = 'skilltypes'.$i;
   
   $cvranking->$countryi = ${countries.$i};
   $cvranking->$edudbi = ${edudbs.$i};
   $cvranking->$credittypei = ${credittypes.$i};
   $cvranking->$edutypei = ${edutypes.$i};
   
   $cvranking->$wcountryi = ${wcountries.$i};
   $cvranking->$workdbi = ${workdbs.$i};
   $cvranking->$sectortypei = ${sectortypes.$i};
   
   $cvranking->$languagei = ${languages.$i};
   $cvranking->$langdbi = ${langdbs.$i};
   
   $cvranking->$resfieldi = ${resfields.$i};
   $cvranking->$pubfieldi = ${pubfields.$i};
   $cvranking->$skilltypei = ${skilltypes.$i};
}

   $cvranking->cweights = $cweights;
   $cvranking->eweights = $eweights;
   $cvranking->crweights = $crweights;
   $cvranking->etweights = $etweights;
   
   $cvranking->wcweights = $wcweights;
   $cvranking->wweights = $wweights;
   $cvranking->stweights = $stweights;
   
   $cvranking->lweights = $lweights;
   $cvranking->ldbweights = $ldbweights;
   
   $cvranking->rfweights = $rfweights;
   $cvranking->pfweights = $pfweights;
   
   $cvranking->skweights = $skweights;

for( $i = 0; $i < 3; $i++ ) {
   $cvrtypei = 'cvrtypes'.$i;
   $orderi = 'orders'.$i;
   
   $cvranking->$cvrtypei = ${cvrtypes.$i};
   $cvranking->$orderi = ${orders.$i};
}

$cvranking->users = $users;

$cvranking->advanceds = $advanceds;
$cvranking->aweights = $aweights;

$cvranking->title = $heading;
$cvranking->subtype = 'cvranking';

// allow access rights for the resume
$cvranking->access_id = $access_id;

// owner is logged in user
$cvranking->owner_guid = elgg_get_logged_in_user_guid();

// save to database
$cvranking->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', $action, elgg_get_logged_in_user_guid(), $cvranking->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "resumes/" . elgg_get_logged_in_user_entity()->username. "?tab=cvranking");
