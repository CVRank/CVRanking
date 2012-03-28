<?php

/* Object's default view. "Edit" and "Delete" links are added based on object's ownership */

global $CONFIG;
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
  $page_owner = get_loggedin_user();
  set_page_owner(get_loggedin_userid());
}

$full = (get_context () != "view") ? false : true;
// compact is for very compact listings with edit and delete links ; disables full view
$compact = (get_context () != "index") ? false : true;
$url = $CONFIG->url;


// Full and listing views
if (!$compact) {
  echo elgg_view('resume/single_menu');
  ?>
  <div>
    <p>
      <strong><a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo $vars['entity']->header; ?></a></strong>
    </p>
    
    <?php
    if ($full) {
      // Full view
      echo '<br /><br />';
      if ($vars['entity']->header) { echo '<p><strong>' . elgg_echo('resume:cvranking:heading') . ' :</strong> ' . $vars['entity']->header . '</p>'; } 
      
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
               
               $edu_array = get_user_objects ($user, 'education', 0, false, false, false);
                 
               foreach ($edu_array as $key => $value) {
               //$total_cvedu[$user] += educvrate($value, $cvr_array);
                 
                 $eduCVR += educvrate($value, $cvr_array);
               }
            }
               // prove that workexprience and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'workexperience') && ($gweights[1] != 0)) {
               
              $work_array = get_user_objects ($user, 'workexperience', 0, false, false, false);
               
              foreach ($work_array as $key => $value) {
                 $workCVR += workcvrate($value, $cvr_array);
               }
            }
               // prove that language and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'language') && ($gweights[2] != 0)) {
               
              $lang_array = get_user_objects ($user, 'language', 0, false, false, false);
               
              foreach ($lang_array as $key => $value) {
                 $langCVR += langcvrate($value, $cvr_array, $lang_array);
               }
            }
               // prove that research and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'research') && ($gweights[3] != 0)) {
               
              $res_array = get_user_objects ($user, 'research', 0, false, false, false);
               
              foreach ($res_array as $key => $value) {
                  
                 $resCVR += rescvrate($value, $cvr_array);
               }
            }
               // prove that publication and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'publication') && ($gweights[4] != 0)) {
               
              $pub_array = get_user_objects ($user, 'publication', 0, false, false, false);
               
              foreach ($pub_array as $key => $value) {
                  
                 $pubCVR += pubcvrate($value, $cvr_array);
               }
            }
               // prove that publication and gweights[] is not 0 to evaluate
            elseif (($cvrtval == 'skill') && ($gweights[5] != 0)) {
               
              $skill_array = get_user_objects ($user, 'skill', 0, false, false, false);
               
              foreach ($skill_array as $key => $value) {
                  
                 $skillCVR += skillcvrate($value, $cvr_array, $skill_array);
               }
            }
         }
          // ADD ALL CVR IN ARRAY WITH REAL NAME
           $userobject = get_user_entity_as_row ($user);
              if (!$userobject) $userobject = get_group_entity_as_row ($user);
           $username = $userobject->name;
           $CVRs[$username] = $eduCVR * $gweights[0] + $workCVR * $gweights[1]
                           + $langCVR * $gweights[2] + $resCVR * $gweights[3]
                           + $pubCVR * $gweights[4] + $skillCVR * $gweights[5];
           
           echo $username; 
           echo ": ";
           print_r($CVRs[$username]);
          
           echo "<br />";
        
         }
       }
       
  
    // AFTER ADDING ALL CVR FOR EACH USER
    // 
    // 1ST TURN USER_ID INTO USER_NAME
     
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
        echo '<div style="float:left; width:32%; padding-left:5px;';
         if (!($i%2)) {
            echo 'background-color:#ccc;">'; 
         } 
         else {
            echo 'background-color:#f3f3f3;">';
         }
        foreach ($CVRs as $cvkey => $cvval) {
        echo "$k. $cvkey:";
        $meanval = $cvval/$maxCVR * 100;
        $meanval = round_two($meanval);
        echo elgg_view('resume/progressbar', array('importance' => $meanval, 
            'text' => "CVR: $meanval/100"));
        echo "<br /><br />";
        $k++;
        }
        echo '</div>';
      }
    }
    echo '<div class="clearfloat"></div> <br />';
    
      
       //$edurank = maximaledu($total_cvedu, $page_owner->guid);
       //$edurank_two = round_two($edurank);
       
        echo $vars['owner'];
   
    } else {
       //Listing view
      echo '<a href="' . $vars['entity']->getURL() . '">en savoir plus..</a>';
      
    }
   
    echo '<p>';
      // Edit & delete links
      if (($page_owner->guid == get_loggedin_user()->guid) && (get_context() != "profileprint")) {
        echo '<a href="' . $vars['url'] . 'mod/resume/cvranking.php?id=' . $vars['entity']->getGUID() . '">' . elgg_echo('resume:edit') . '</a>&nbsp; ';
        echo elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(),
            'text' => elgg_echo('resume:delete'), 'confirm' => elgg_echo('resume:delete:element'), )) . '&nbsp; ';
        echo elgg_view("editmenu", array('entity' => $vars['entity'])); // Allow the menu to be extended
      }
      if (!$full && (get_context () != "profileprint")) {
        $num_comments = elgg_count_comments($vars['entity']);
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
  if ($page_owner->guid == get_loggedin_user()->guid) {
    echo '<a href="' . $vars['url'] . 'mod/resume/cvranking.php?id=' . $vars['entity']->getGUID() . '" title="' . elgg_echo('edit') . '">' . date('m/Y', $vars['entity']->startdate) . " &rarr; ";
    if ($vars['entity']->ongoing == 'ongoing') echo elgg_echo('resume:date:now'); else echo date('d/m/Y', $vars['entity']->enddate);
    echo '&nbsp;: ' . $vars['entity']->heading . '</a> &nbsp; ' 
      . '<b>' . elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(), 'text' => 'x', 'confirm' => elgg_echo('resume:delete:element'), 'title' => elgg_echo('delete'))) . '</b>';
  } else {
    echo '<a href="' . $vars['entity']->getURL() . '">' . $vars['entity']->heading . '</a>';
  }
}

