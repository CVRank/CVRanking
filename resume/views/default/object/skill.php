<?php
/**
 * skill object
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
      $importance = (int) skillscore ($vars['entity'], $cvr_array);
      
      echo elgg_view('resume/importancebar', array('importance' => $importance, 'text' => "Score: $importance/100")); 
      ?>
     
      <h3><a href="<?php echo $vars['entity']->getURL(); ?>">
              
       <?php echo $vars['entity']->heading; ?></a>
        
       <?php 
         echo '(';
         echo '<a href="' . $url . 'search/?tag=' . $vars['entity']->skilltype . '">' 
                 . elgg_echo('resume:skill:' . $vars['entity']->skilltype); 
         echo '</a>)';       
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
      if ($vars['entity']->heading) { 
          echo '<p><strong>' . elgg_echo('resume:skill:heading') . ' :</strong> <a href="' 
                  . $url . 'search/?tag=' . $vars['entity']->heading . '">' 
                  . $vars['entity']->heading . '</a></p>'; 
      }
      
      if ($vars['entity']->level) { 
          echo '<p><strong>' . elgg_echo('resume:work:level') . ' :</strong> ' 
                  . elgg_echo('resume:work:level:' . $vars['entity']->level) . '</p>';
      } 
      
      if ($vars['entity']->skilltype) { 
          echo '<p><strong>' . elgg_echo('resume:skill:typology') . ' :</strong> ' 
                  . elgg_echo('resume:skill:' . $vars['entity']->skilltype) . '</p>'; 
      }
      
      if ($vars['entity']->certs) {
          $certs_array = $vars['entity']->certs;
          $scores_array = $vars['entity']->scores;
          $structures_array = $vars['entity']->structures;
          $starts_array = $vars['entity']->starts;
          $ends_array = $vars['entity']->ends;
          
      $count = count($certs_array);	
      echo '<p><strong>' . elgg_echo('resume:skill:skills') . '</strong>:</p> <ul>';
      
         for ($i = 0; $i < $count; $i++) {
           // print only if there is some valuable information:
           if (($certs_array[$i] != "") || ($scores_array[$i] != "") || ($structures_array[$i] != "")) {
             echo '<li><strong>' . elgg_echo('resume:skill:cert') . '</strong>: '. $certs_array[$i];
             
                    if ($structures_array[$i] != "") {
                         echo ' <strong>' . elgg_echo('resume:view:at'). '</strong>';
                         echo ' ' . $structures_array[$i] . ''; 
                    }
                    if ($starts_array[$i]) {
                         echo ' (' . $starts_array[$i] . ' &rarr; ' . $ends_array[$i] . ')';
                    }         
                    
             echo '; <strong>'. elgg_echo('resume:skill:score') . '</strong>';
             echo ': ' . $scores_array[$i] . '</li>';
           }
         }
      echo '</ul><br />';
      }
      
      
      if ($vars['entity']->contact) { 
          echo '<p><strong>' . elgg_echo('resume:education:contact') . ' :</strong> ' 
                  . $vars['entity']->contact . '</p>'; 
      }
      
      if ($vars['entity']->description) { 
          echo '<p><strong>' . elgg_echo('resume:skill:description') . ' :</strong> ' 
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
        echo '<a href="' . $vars['url'] . 'mod/resume/skill.php?id=' . $vars['entity']->getGUID() . '">' . elgg_echo('resume:edit') . '</a>&nbsp; ';
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
    echo '<a href="' . $vars['url'] . 'mod/resume/skill.php?id=' . $vars['entity']->getGUID() . '" title="' . elgg_echo('edit') . '">' . $vars['entity']->skilltype . '</a> &nbsp; ' 
      . '<b>' . elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(), 'text' => 'x', 'confirm' => elgg_echo('resume:delete:element'), 'title' => elgg_echo('delete'))) . '</b>';
  } else {
    echo '<a href="' . $vars['entity']->getURL() . '">' . $vars['entity']->skilltype . '</a>';
  }
}
