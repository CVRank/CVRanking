<?php
$page_owner = $vars['owner'];

$body = '<style>
.resume_body_printer { padding:3ex; }
.tabla_idiomas th, .tabla_idiomas td { border:1px solid darkgrey !important; }
</style>';

// -------- BEGIN MAIN PAGE CONTENT ---------
if ((get_context() != 'profile') && (get_context() != "index")) {
  $body .= '<div class="resume">';
  $body .=  "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/profile/" . $page_owner->username . "\")>" . elgg_echo("resume:profile:goto") . "</a></p>";
  $body .=  "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/resumesprintversion/" . $page_owner->username . "\" target=\"_blank\" \">" . elgg_echo("resume:profile:gotoprint") . "</a></p>";
  $body .=  "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/profile/" . $page_owner->username . "?view=xml-europass\" target=\"_blank\" \">" . elgg_echo("resume:profile:xml-europass") . "</a></p>";
  $body .= "<div class=\"clearfloat\"></div>";
  $body .= "<br />";
}

if ((get_plugin_setting('cvranking', 'resume') == 'yes') && (list_user_objects($page_owner->guid, 'cvranking', 0, false, false, false))) {
  $body .= '<div class="contentWrapper resume_contentWrapper" width=716>
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <h3>' . elgg_echo('resume:cvranking') . '</h3>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">' . list_user_objects($page_owner->guid, 'cvranking', 0, false, false, false) . '</div>
    </div>';
}

if ((get_plugin_setting('education', 'resume') == 'yes') && (list_user_objects($page_owner->guid, 'education', 0, false, false, false))) {
  
  // EDURANKING
  $objects_array = get_user_objects ($page_owner->guid, 'education', 0, false, false, false);
  if (!$cvr_array) $cvr_array = set_defaultcvr ();
  foreach ($objects_array as $key => $value) {
  $total_cvedu += educvrate($value, $cvr_array);
  } 
  $edurank = maximalCVR($total_cvedu, $page_owner->guid, 'edu');
  $edurank_two = round_two($edurank);
  
   echo $vars['owner'];
   
   $body .= '<div class="contentWrapper resume_contentWrapper" width=716>
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <h3>' . elgg_echo('resume:educations') . '</h3>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
      <div><p> CVR edu'
      . elgg_view('resume/progressbar', array('importance' => $edurank_two, 'text' => "EduCVR: $edurank_two/100")).
      '</p></div><br /><br /> <br />'
      . list_user_objects($page_owner->guid, 'education', 0, false, false, false) . '</div>
    </div>';
}

if ((get_plugin_setting('workexperience', 'resume') == 'yes') && (list_user_objects($page_owner->guid, 'workexperience', 0, false, false, false))) {
  // WORKRANKING
  $objects_array = get_user_objects ($page_owner->guid, 'workexperience', 0, false, false, false);
  if (!$cvr_array) $cvr_array = set_defaultcvr();
  foreach ($objects_array as $key => $value) {
  $total_cvwork += workcvrate($value, $cvr_array);
  }   
  $workrank = maximalCVR($total_cvwork, $page_owner->guid, 'work');
  $workrank_two = round_two($workrank);
    
    $body .= '<div class="contentWrapper resume_contentWrapper" width=716>
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <h3>' . elgg_echo('resume:workexperiences') . '</h3>
      <div style="display:all;" class="collapsible_box resume_collapsible_box"> <div><p> CVR work'
      . elgg_view('resume/progressbar', array('importance' => $workrank_two, 'text' => "WorkCVR: $workrank_two/100")).
      '</p></div><br /><br /> <br />'
      . list_user_objects($page_owner->guid, 'workexperience', 0, false, false, false) . '</div>
    </div>';
}

if ((get_plugin_setting('language', 'resume') == 'yes') && (list_user_objects($page_owner->guid, 'language', 0, false, false, false))) {
   // LANGRANKING
  $objects_array = get_user_objects ($page_owner->guid, 'language', 0, false, false, false);
  if (!$cvr_array) $cvr_array = set_defaultcvr();
  foreach ($objects_array as $key => $value) {
      // falta el + en +=
  $total_cvlang += langcvrate($value, $cvr_array, $objects_array);
  }   
  $langrank = maximalCVR($total_cvlang, $page_owner->guid, 'lang');
  $langrank_two = round_two($langrank);
  
  $body .= '<div class="contentWrapper resume_contentWrapper">
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <h3>' . elgg_echo('resume:languages') . '</h3>
      <div style="display:all;" class="collapsible_box resume_collapsible_box"> <div><p> CVR lang'
      . elgg_view('resume/progressbar', array('importance' => $langrank_two, 'text' => "LangCVR: $langrank_two/100")).
      '</p></div><br /><br /> <br />'. list_user_objects($page_owner->guid, 'language', 0, false, false, false) . '</div>
    </div>';
}

if ((get_plugin_setting('research', 'resume') == 'yes') && (list_user_objects($page_owner->guid, 'research', 0, false, false, false))) {
  $objects_array = get_user_objects ($page_owner->guid, 'research', 0, false, false, false);
  if (!$cvr_array) $cvr_array = set_defaultcvr();
  foreach ($objects_array as $key => $value) {
  $total_cvres += rescvrate($value, $cvr_array);
  }   
  $resrank = maximalCVR($total_cvres, $page_owner->guid, 'res');
  $resrank_two = round_two($resrank);
  $body .= '<div class="contentWrapper resume_contentWrapper" width="716">
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <h3>' . elgg_echo('resume:researches') . '</h3>
      <div style="display:all;" class="collapsible_box resume_collapsible_box"> <div><p> CVR res'
      . elgg_view('resume/progressbar', array('importance' => $resrank_two, 'text' => "ResCVR: $resrank_two/100")).
      '</p></div><br /><br /> <br />'. list_user_objects($page_owner->guid, 'research', 0, false, false, false) . '</div>
    </div>';
}

if ((get_plugin_setting('publication', 'resume') == 'yes') && (list_user_objects($page_owner->guid, 'publication', 0, false, false, false))) {
  $objects_array = get_user_objects ($page_owner->guid, 'publication', 0, false, false, false);
  if (!$cvr_array) $cvr_array = set_defaultcvr();
  foreach ($objects_array as $key => $value) {
  $total_cvpub += pubcvrate($value, $cvr_array);
  }   
  $pubrank = maximalCVR($total_cvpub, $page_owner->guid, 'pub');
  $pubrank_two = round_two($pubrank);
  $body .= '<div class="contentWrapper resume_contentWrapper" width="716">
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <h3>' . elgg_echo('resume:publications') . '</h3>
      <div style="display:all;" class="collapsible_box resume_collapsible_box"> <div><p> CVR pub'
      . elgg_view('resume/progressbar', array('importance' => $pubrank_two, 'text' => "PubCVR: $pubrank_two/100")).
      '</p></div><br /><br /> <br />'. list_user_objects($page_owner->guid, 'publication', 0, false, false, false) . '</div>
    </div>';
}

if ((get_plugin_setting('skill', 'resume') == 'yes') && (list_user_objects($page_owner->guid, 'skill', 0, false, false, false))) {
  $objects_array = get_user_objects ($page_owner->guid, 'skill', 0, false, false, false);
  if (!$cvr_array) $cvr_array = set_defaultcvr();
  foreach ($objects_array as $key => $value) {
  $total_cvskill += skillcvrate($value, $cvr_array);
  }   
  $skillrank = maximalCVR($total_cvskill, $page_owner->guid, 'skill');
  $skillrank_two = round_two($skillrank);
  $body .= '<div class="contentWrapper resume_contentWrapper" width=716>
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <h3>' . elgg_echo('resume:skills') . '</h3>
      <div style="display:all;" class="collapsible_box resume_collapsible_box"> <div><p> CVR skill'
      . elgg_view('resume/progressbar', array('importance' => $skillrank_two, 'text' => "SkillCVR: $skillrank_two/100")).
      '</p></div><br /><br /> <br />'. list_user_objects($page_owner->guid, 'skill', 0, false, false, false) . '</div>
      </div>';
}

// Show a message if there aren't any user objects.
if (!list_user_objects($page_owner->getGUID(), 'cvranking', 0, true, true, true)
    && !list_user_objects($page_owner->getGUID(), 'education', 0, true, true, true)
    && !list_user_objects($page_owner->getGUID(), 'workexperience', 0, true, true, true)
    && !list_user_objects($page_owner->getGUID(), 'language', 0, true, true, true)
    && !list_user_objects($page_owner->getGUID(), 'research', 0, true, true, true)
    && !list_user_objects($page_owner->getGUID(), 'publication', 0, true, true, true)
    && !list_user_objects($page_owner->getGUID(), 'skill', 0, true, true, true)
  ) {
  ?>
    <h3><?php
    if ($page_owner->guid == get_loggedin_user()->guid) {
      echo '<a href="' . $CONFIG->wwwroot . "pg/resumes/" . $page_owner->username . '">' . elgg_echo('resume:noentries:create') . '</a>';
    } else {
      echo elgg_echo('resume:noentries');
    }
    ?>
    </h3>
<?php }

$body .= '</div>';

echo $body;