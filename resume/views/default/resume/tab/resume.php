<?php
/**
 * resume main
 */

/**
 * @todo : The same achievements in language and publication CVR are often taken into account in each field. 
 *         Maybe we should concentrate both on Arts.
 * @todo : Allow for import of user-defined CVR objects and immediate use of set_cvrvalues(), either in plugins/widgets,
 *         or from external sources (using exported data from Elgg).
 */
$page_owner = $vars['owner'];
echo $page_owner; 
$collapsed= true;

require_once(dirname(__FILE__) . "/cvranking.php");
require_once(dirname(__FILE__) . "/education.php");
require_once(dirname(__FILE__) . "/workexperience.php");
require_once(dirname(__FILE__) . "/language.php");
require_once(dirname(__FILE__) . "/research.php");
require_once(dirname(__FILE__) . "/publication.php");
require_once(dirname(__FILE__) . "/skill.php");
require_once(dirname(__FILE__) . "/general.php");

  ?>

    <div class="clearfloat"></div><br />
  
  <?php
  $title = 'resume:gen';
  $title2 = elgg_view('resume/progressbar', array('importance' => $gen_total_rank_two, 'text' => "CVR: $gen_total_rank_two/100"));
  $help = 'resume:gen:help';
    echo collapsiblebox("gen", $title, $help, false, $collapsed, 48, $title2);
    if (elgg_get_plugin_setting('education', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $gen_edu_rank_two, 'text' => "EduCVR: $gen_edu_rank_two/100"));
    if (elgg_get_plugin_setting('workexperience', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $gen_work_rank_two, 'text' => "WorkCVR: $gen_work_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('language', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $gen_lang_rank_two, 'text' => "LangCVR: $gen_lang_rank_two/100"));
    if (elgg_get_plugin_setting('research', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $gen_res_rank_two, 'text' => "ResCVR: $gen_res_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('publication', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $gen_pub_rank_two, 'text' => "PubCVR: $gen_pub_rank_two/100"));
    if (elgg_get_plugin_setting('skill', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $gen_skill_rank_two, 'text' => "SkillCVR: $gen_skill_rank_two/100"));
    echo '<br /></div></div></div>';
    
  $title = 'resume:tech';
  $title2 = elgg_view('resume/progressbar', array('importance' => $tech_total_rank_two, 'text' => "CVR: $tech_total_rank_two/100"));
  $help = 'resume:tech:help';
    echo collapsiblebox("tech", $title, $help, false, $collapsed, 48, $title2);
    if (elgg_get_plugin_setting('education', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $tech_edu_rank_two, 'text' => "EduCVR: $tech_edu_rank_two/100"));
    if (elgg_get_plugin_setting('workexperience', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $tech_work_rank_two, 'text' => "WorkCVR: $tech_work_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('language', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $tech_lang_rank_two, 'text' => "LangCVR: $tech_lang_rank_two/100"));
    if (elgg_get_plugin_setting('research', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $tech_res_rank_two, 'text' => "ResCVR: $tech_res_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('publication', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $tech_pub_rank_two, 'text' => "PubCVR: $tech_pub_rank_two/100"));
    if (elgg_get_plugin_setting('skill', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $tech_skill_rank_two, 'text' => "SkillCVR: $tech_skill_rank_two/100"));
    echo '<br /></div></div></div>';
    
   echo '<div class="clearfloat"></div>';
   
  $title = 'resume:sci';
  $title2 = elgg_view('resume/progressbar', array('importance' => $sci_total_rank_two, 'text' => "CVR: $sci_total_rank_two/100"));
  $help = 'resume:sci:help';
    echo collapsiblebox("sci", $title, $help, false, $collapsed, 48, $title2);
    if (elgg_get_plugin_setting('education', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $sci_edu_rank_two, 'text' => "EduCVR: $sci_edu_rank_two/100"));
    if (elgg_get_plugin_setting('workexperience', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $sci_work_rank_two, 'text' => "WorkCVR: $sci_work_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('language', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $sci_lang_rank_two, 'text' => "LangCVR: $sci_lang_rank_two/100"));
    if (elgg_get_plugin_setting('research', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $sci_res_rank_two, 'text' => "ResCVR: $sci_res_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('publication', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $sci_pub_rank_two, 'text' => "PubCVR: $sci_pub_rank_two/100"));
    if (elgg_get_plugin_setting('skill', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $sci_skill_rank_two, 'text' => "SkillCVR: $sci_skill_rank_two/100"));
    echo '<br /></div></div></div>';
   
  $title = 'resume:bio';
  $title2 = elgg_view('resume/progressbar', array('importance' => $bio_total_rank_two, 'text' => "CVR: $bio_total_rank_two/100"));
  $help = 'resume:bio:help';
    echo collapsiblebox("bio", $title, $help, false, $collapsed, 48, $title2);
    if (elgg_get_plugin_setting('education', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $bio_edu_rank_two, 'text' => "EduCVR: $bio_edu_rank_two/100"));
    if (elgg_get_plugin_setting('workexperience', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $bio_work_rank_two, 'text' => "WorkCVR: $bio_work_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('language', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $bio_lang_rank_two, 'text' => "LangCVR: $bio_lang_rank_two/100"));
    if (elgg_get_plugin_setting('research', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $bio_res_rank_two, 'text' => "ResCVR: $bio_res_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('publication', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $bio_pub_rank_two, 'text' => "PubCVR: $bio_pub_rank_two/100"));
    if (elgg_get_plugin_setting('skill', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $bio_skill_rank_two, 'text' => "SkillCVR: $bio_skill_rank_two/100"));
    echo '<br /></div></div></div>';
    
   echo '<div class="clearfloat"></div>';
    
  $title = 'resume:soc';
  $title2 = elgg_view('resume/progressbar', array('importance' => $soc_total_rank_two, 'text' => "CVR: $soc_total_rank_two/100"));
  $help = 'resume:soc:help';
    echo collapsiblebox("soc", $title, $help, false, $collapsed, 48, $title2);
    if (elgg_get_plugin_setting('education', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $soc_edu_rank_two, 'text' => "EduCVR: $soc_edu_rank_two/100"));
    if (elgg_get_plugin_setting('workexperience', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $soc_work_rank_two, 'text' => "WorkCVR: $soc_work_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('language', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $soc_lang_rank_two, 'text' => "LangCVR: $soc_lang_rank_two/100"));
    if (elgg_get_plugin_setting('research', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $soc_res_rank_two, 'text' => "ResCVR: $soc_res_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('publication', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $soc_pub_rank_two, 'text' => "PubCVR: $soc_pub_rank_two/100"));
    if (elgg_get_plugin_setting('skill', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $soc_skill_rank_two, 'text' => "SkillCVR: $soc_skill_rank_two/100"));
    echo '<br /></div></div></div>';
    
  $title = 'resume:art';
  $title2 = elgg_view('resume/progressbar', array('importance' => $art_total_rank_two, 'text' => "CVR: $art_total_rank_two/100"));
  $help = 'resume:art:help';
    echo collapsiblebox("art", $title, $help, false, $collapsed, 48, $title2);
    if (elgg_get_plugin_setting('education', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $art_edu_rank_two, 'text' => "EduCVR: $art_edu_rank_two/100"));
    if (elgg_get_plugin_setting('workexperience', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $art_work_rank_two, 'text' => "WorkCVR: $art_work_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('language', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $art_lang_rank_two, 'text' => "LangCVR: $art_lang_rank_two/100"));
    if (elgg_get_plugin_setting('research', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $art_res_rank_two, 'text' => "ResCVR: $art_res_rank_two/100"));
    echo '<div class="clearfloat"></div><br />';
    if (elgg_get_plugin_setting('publication', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $art_pub_rank_two, 'text' => "PubCVR: $art_pub_rank_two/100"));
    if (elgg_get_plugin_setting('skill', 'resume') == 'yes')
    echo elgg_view('resume/progressbar', array('importance' => $art_skill_rank_two, 'text' => "SkillCVR: $art_skill_rank_two/100"));
    echo '<br /></div></div></div>';
   
  ?>

