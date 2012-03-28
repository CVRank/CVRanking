<?php
/**
 * cvranking object
 */

global $CONFIG;
$page_owner = elgg_get_page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
  $page_owner = elgg_get_logged_in_user_entity();
  elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
}

$full = (elgg_get_context () != "view") ? false : true;
// compact is for very compact listings with edit and delete links ; disables full view
$compact = (elgg_get_context () != "index") ? false : true;
$url = $CONFIG->url;

// Full and listing views
if (!$compact) {
  echo elgg_view('resume/single_menu');
  ?>
  <div>
    <p>
      <h3><a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo $vars['entity']->heading; ?></a></h3>
    </p>
    
    <?php
    if ($full) {
      // Full view
      echo '<br />';
      
      // set values
      $cvr_array = set_cvrvalues ($vars['entity']);
      
      // get object data
      $users = $vars['entity']->users;
      $gweights = $vars['entity']->gweights; 
      foreach ($gweights as $gwkey => $gwvalue) {
          $gwvalue = $gwvalue/100;
          $gweights[$gwkey] = $gwvalue;
      }
      
       // CVRANKING BEGINS
  for( $i = 0; $i < 3; $i++ ) { 
       $cvrtypei = 'cvrtypes'.$i;
       $orderi = 'orders'.$i;
   
      $cvrtypes = $vars['entity']->$cvrtypei;
        //convert into array:
       if (!is_array($cvrtypes)) $cvrtypes = array(0=>$cvrtypes);
       $order = $vars['entity']->$orderi; 
      
     //initialize or reset CVRs
      $CVRs = array();
    // begin loop only if array cvrtype is set
      if ($cvrtypes) {
       foreach ($users as $keyuser => $user) {
       // prove that $user is not blank before looping
         if ($user != "") {
           // take user guid
           $query = "SELECT * FROM {$CONFIG->dbprefix}users_entity WHERE name='$user'";
           $user_object = get_data_row($query);
           $user_guid = $user_object->guid;
           // reset CVRs first
               $eduCVR = 0; 
               $workCVR = 0;  
               $langCVR = 0;  
               $resCVR = 0; 
               $pubCVR = 0; 
               $skillCVR = 0;
          // prove that user wants education to be evaluated, and that education gweights[] is not 0:
          foreach ($cvrtypes as $cvrtkey => $cvrtval) {
          
            if (($cvrtval == 'education') && ($gweights[0] != 0)) {
               
               $edu_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'education', 'owner_guids' => $user_guid, 'limit' => 0));
                 
               foreach ($edu_array as $key => $value) {
               //$total_cvedu[$user] += educvrate($value, $cvr_array);
                 
                 $eduCVR += educvrate($value, $cvr_array);
               }
            }
               // prove that workexprience and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'workexperience') && ($gweights[1] != 0)) {
               
              $work_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'workexperience', 'owner_guids' => $user_guid, 'limit' => 0));
               
              foreach ($work_array as $key => $value) {
                 $workCVR += workcvrate($value, $cvr_array);
               }
            }
               // prove that language and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'language') && ($gweights[2] != 0)) {
               
              $lang_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'language', 'owner_guids' => $user_guid, 'limit' => 0));
               
              foreach ($lang_array as $key => $value) {
                 $langCVR += langcvrate($value, $cvr_array, $lang_array);
               }
            }
               // prove that research and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'research') && ($gweights[3] != 0)) {
               
              $res_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'research', 'owner_guids' => $user_guid, 'limit' => 0));
               
              foreach ($res_array as $key => $value) {
                  
                 $resCVR += rescvrate($value, $cvr_array);
               }
            }
               // prove that publication and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'publication') && ($gweights[4] != 0)) {
               
              $pub_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'publication', 'owner_guids' => $user_guid, 'limit' => 0));
               
              foreach ($pub_array as $key => $value) {
                  
                 $pubCVR += pubcvrate($value, $cvr_array);
               }
            }
               // prove that publication and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'skill') && ($gweights[5] != 0)) {
               
              $skill_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'skill', 'owner_guids' => $user_guid, 'limit' => 0));
               
              foreach ($skill_array as $key => $value) {
                  
                 $skillCVR += skillcvrate($value, $cvr_array, $skill_array);
               }
            }
         }
         // ADD all CVR of each user, and store it in array $CVRs
           // For Elgg 1.7.x
           //$userobject = get_user_entity_as_row ($user);
           //  if (!$userobject) $userobject = get_group_entity_as_row ($user);
           //$username = $userobject->name;
           $CVRs[$user] = $eduCVR * $gweights[0] + $workCVR * $gweights[1]
                           + $langCVR * $gweights[2] + $resCVR * $gweights[3]
                           + $pubCVR * $gweights[4] + $skillCVR * $gweights[5];
           
           //PROOF
            //echo $user; 
            //echo ": ";
            //print_r($CVRs[$username]);
          
         }
       }
       
     // Sort user array
     
       if ($order == "CVRasc") {
          arsort($CVRs);
       }
       elseif ($order == "CVRdesc") {
          asort($CVRs);
       }
       elseif (($order == "Alfaasc") || ($order == "Alfadesc")) {
          uksort($CVRs, 'strnatcasecmp');
          
          if ($order == "Alfadesc") {
          uksort($CVRs, 'strnatcasecmp');
          array_reverse ($sorted_CVR, true);
          }
       }
       $k = 1;
       $maxCVR = max($CVRs);
       
      // Print array
  $title = 'resume:cvranking:CVR';
  $title2 = $i + 1;
  echo collapsiblebox("cvranking".$i, $title, false, false, false, 30, $title2);
        foreach ($CVRs as $cvkey => $cvval) {
        echo "$k. $cvkey:";
        $meanval = $cvval/$maxCVR * 100;
        $meanval = round_two($meanval);
        echo elgg_view('resume/progressbar', array('importance' => $meanval,  
            'position' => "float:right;",
            'text' => "CVR: $meanval/100"));
        echo "<br /><br />";
        $k++;
        }
        echo '</div></div></div>';
      }
    }
    echo '<div class="clearfloat"></div> <br />';
    
        echo $vars['owner'];
   
    } else {
       //Listing view
      echo '<strong><a href="' . $vars['entity']->getURL() . '">';
      echo elgg_echo('resume:view:more');
      echo '</a></strong>';
    }
   
    echo '<p>';
      // Edit & delete links
      if (($page_owner->guid == elgg_get_logged_in_user_entity()->guid) && (elgg_get_context() != "profileprint")) {
        echo '<a href="' . $vars['url'] . 'mod/resume/cvranking.php?id=' . $vars['entity']->getGUID() . '">' . elgg_echo('resume:edit') . '</a>&nbsp; ';
        echo elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(),
            'text' => elgg_echo('resume:delete'), 'confirm' => elgg_echo('resume:delete:element'), )) . '&nbsp; ';
        echo elgg_view("editmenu", array('entity' => $vars['entity'])); // Allow the menu to be extended
      }
      if (!$full && (elgg_get_context () != "profileprint")) {
        $num_comments = $vars['entity']->countComments();
        echo '<a href="' . $vars['entity']->getURL() . '">' . sprintf(elgg_echo("comments")) . ' (' . $num_comments . ')</a><br />';
      }
    echo '</p>';
    ?>
    
    <!-- Comments features -->
    <?php if ($full) { echo elgg_view_comments($vars['entity']); } ?>
    <!-- End of Comments features -->
    
  </div>
  
  <?php
} else {
  // Compact view : edit & delete links
  if ($page_owner->guid == elgg_get_logged_in_user_entity()->guid) {
    echo '<a href="' . $vars['url'] . 'mod/resume/cvranking.php?id=' . $vars['entity']->getGUID() . '" title="' . elgg_echo('edit') . '">' . date('m/Y', $vars['entity']->startdate) . " &rarr; ";
    if ($vars['entity']->ongoing == 'ongoing') echo elgg_echo('resume:date:now'); else echo date('d/m/Y', $vars['entity']->enddate);
    echo '&nbsp;: ' . $vars['entity']->heading . '</a> &nbsp; ' 
      . '<b>' . elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(), 'text' => 'x', 'confirm' => elgg_echo('resume:delete:element'), 'title' => elgg_echo('delete'))) . '</b>';
  } else {
    echo '<a href="' . $vars['entity']->getURL() . '">' . $vars['entity']->heading . '</a>';
  }
}

