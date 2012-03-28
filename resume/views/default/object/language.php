<?php
/**
 * language object
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

    // set default CVR values
  $cvr_array = set_defaultcvr ();
  
// Full and listing views
if (!$compact) {
  echo elgg_view('resume/single_menu');
  ?>
  <div>
    <p>
      <?php 
     // Scoring
      $importance = (int) langscore ($vars['entity'], $cvr_array);
      echo elgg_view('resume/importancebar', array('importance' => $importance, 'text' => "Score: $importance/100")); 
      
      ?>
        
      <h3><a href="<?php echo $vars['entity']->getURL(); ?>">
         <?php echo elgg_echo('resume:languages:' . $vars['entity']->language); ?></a>
        
         <?php 
         echo '(';
         echo elgg_echo('resume:languages:type:' . $vars['entity']->langtype); 
         echo ')';       
         ?></h3>
      <?php
      echo " (" . $vars['entity']->startdate . " &rarr; ";
      if ($vars['entity']->ongoing == 'ongoing') echo elgg_echo('resume:date:now'); 
      else echo $vars['entity']->enddate;
      echo ")";
      ?>
    </p>
    
    <?php
    if ($full) {
      // Full view
      echo '<br />';
      if ($vars['entity']->language) { 
          echo '<p><strong>' . elgg_echo('resume:languages:language') . ' :</strong> <a href="' 
                  . $url . 'search/?tag=' . $vars['entity']->language . '">' 
                  . elgg_echo('resume:languages:' . $vars['entity']->language) . ' ('. $vars['entity']->language . ')</a></p>'; 
      }
      
      if ($vars['entity']->langtype) { 
          echo '<p><strong>' . elgg_echo('resume:languages:langtype') . ' :</strong> <a href="' 
                  . $url . 'search/?tag=' . $vars['entity']->langtype . '">' 
                  . elgg_echo('resume:languages:type:' . $vars['entity']->langtype) . '</a></p>'; 
      } 
      
      echo '<strong>' . elgg_echo('resume:languages:languages') .  ':</strong>';
      echo '<ul>';
      
      if ($vars['entity']->listening) { 
          echo '<li><strong>' . elgg_echo('resume:languages:listening') . ' :</strong> ' 
                  . elgg_echo('resume:languages:level:' .  $vars['entity']->listening) . '</li>';
      } 
      
      if ($vars['entity']->reading) { 
          echo '<li><strong>' . elgg_echo('resume:languages:reading') . ' :</strong> ' 
                   . elgg_echo('resume:languages:level:' .  $vars['entity']->reading) . '</li>'; 
      }
      
      if ($vars['entity']->spokeninteraction) { 
          echo '<li><strong>' . elgg_echo('resume:languages:spokeninteraction') . ' :</strong> ' 
                   . elgg_echo('resume:languages:level:' .  $vars['entity']->spokeninteraction) . '</li>'; 
      }
      
      if ($vars['entity']->spokenproduction) { 
          echo '<li><strong>' . elgg_echo('resume:languages:spokenproduction') . ' :</strong> ' 
                   . elgg_echo('resume:languages:level:' .  $vars['entity']->spokenproduction) . '</li>'; 
      }
      
      if ($vars['entity']->writing) { 
          echo '<li><strong>' . elgg_echo('resume:languages:writing') . ' :</strong> ' 
                   . elgg_echo('resume:languages:level:' .  $vars['entity']->writing) . '</li></ul>'; 
      }
      
      if ($vars['entity']->experience) { 
          echo '<p><strong>' . elgg_echo('resume:language:view:experience') . ' :</strong> '; 
             $experiences = $vars['entity']->experience; 
          if (is_array($experiences)) {
             foreach ($experiences as $exkey => $exvalue) {
                 if ($i > 0) echo ", ";
                 echo elgg_echo('resume:language:experience:'.$exvalue);
                 $i++;
             }
          }
          else echo elgg_echo('resume:language:experience:'.$experiences);
          echo '</p>'; 
      }
      
      if ($vars['entity']->exams) {
          $exams_array = $vars['entity']->exams;
          $grades_array = $vars['entity']->grades;
          $hours_array = $vars['entity']->hours;
          $countries_array = $vars['entity']->countries;
          $starts_array = $vars['entity']->starts;
          $ends_array = $vars['entity']->ends;
          
      $count = count($exams_array);	
      echo '<p><strong>' . elgg_echo('resume:language:exams') . '</strong>:</p> <ul>';
      
         for ($i = 0; $i < $count; $i++) {
           // print only if there is some valuable information:
           if (($exams_array[$i] != "") || ($grades_array[$i] != "") || ($hours_array[$i] != "")) {
             echo '<li><strong>' . elgg_echo('resume:languages:view:exam') . '</strong>: '. $exams_array[$i];
             
                    if ($starts_array[$i]) {
                         echo ' (' . $starts_array[$i] . ' &rarr; ' . $ends_array[$i] . ')';
                    }         
                    
             echo '; <strong>'. elgg_echo('resume:languages:grade') . '</strong>';
             echo ': ' . $hours_array[$i] . '; '
                . '<strong>'. elgg_echo('resume:education:country') . '</strong>: ' . $countries_array[$i] . '</li>'; 
           }
         }
      echo '</ul><br />';
      }
      
      
      if ($vars['entity']->contact) { 
          echo '<p><strong>' . elgg_echo('resume:education:contact') . ' :</strong> ' 
                  . $vars['entity']->contact . '</p>'; 
      }
      
      if ($vars['entity']->description) { 
          echo '<p><strong>' . elgg_echo('resume:languages:description') . ' :</strong> ' 
                  . $vars['entity']->description . '</p>'; 
      }
      echo '<br />';
    } else {
       //Listing view
      echo '<strong><a href="' . $vars['entity']->getURL() . '">';
      echo elgg_echo('resume:view:more');
      echo '</a></strong>';
    }
    
    echo '<p>';
      // Edit & delete links
      if (($page_owner->guid == elgg_get_logged_in_user_entity()->guid) && (elgg_get_context() != "profileprint")) {
        echo '<a href="' . $vars['url'] . 'mod/resume/language.php?id=' . $vars['entity']->getGUID() . '">' . elgg_echo('resume:edit') . '</a>&nbsp; ';
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
    echo '<a href="' . $vars['url'] . 'mod/resume/language.php?id=' . $vars['entity']->getGUID() . '" title="' . elgg_echo('edit') . '">' . date('m/Y', $vars['entity']->startdate) . " &rarr; ";
    if ($vars['entity']->ongoing == 'ongoing') echo elgg_echo('resume:date:now'); else echo date('d/m/Y', $vars['entity']->enddate);
    echo '&nbsp;: ' . $vars['entity']->language . '</a> &nbsp; ' 
      . '<b>' . elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(), 'text' => 'x', 'confirm' => elgg_echo('resume:delete:element'), 'title' => elgg_echo('delete'))) . '</b>';
  } else {
    echo '<a href="' . $vars['entity']->getURL() . '">' . $vars['entity']->language . '</a>';
  }
}
