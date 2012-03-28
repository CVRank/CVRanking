<?php
/**
 * cvranking - resume main
 */

$cvr_array = set_defaultcvr ();
$tech_array = set_cvr ("tech", "any");
$sci_array = set_cvr ("sci", "any");
$bio_array = set_cvr ("bio", "any");
$soc_array = set_cvr ("soc", "any");
$art_array = set_cvr ("art", "any");
  
if ((elgg_get_plugin_setting('education', 'resume') == 'yes') && (elgg_list_entities(array('types' => 'object', 'subtypes' => 'education', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false)))) {

    $edu_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'education', 'owner_guids' => $page_owner->guid, 'limit' => 0));

  foreach ($edu_array as $key => $value) {
     $tech_cv_edu += educvrate($value, $tech_array);
     $sci_cv_edu += educvrate($value, $sci_array);
     $bio_cv_edu += educvrate($value, $bio_array);
     $soc_cv_edu += educvrate($value, $soc_array);
     $art_cv_edu += educvrate($value, $art_array);
     $gen_cv_edu += educvrate($value, $cvr_array);
  } 
}

if ((elgg_get_plugin_setting('workexperience', 'resume') == 'yes') && (elgg_list_entities(array('types' => 'object', 'subtypes' => 'workexperience', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false)))) {
  
    $work_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'workexperience', 'owner_guids' => $page_owner->guid, 'limit' => 0));
  
  foreach ($work_array as $key => $value) {
     $tech_cv_work += workcvrate($value, $tech_array);
     $sci_cv_work += workcvrate($value, $sci_array);
     $bio_cv_work += workcvrate($value, $bio_array);
     $soc_cv_work += workcvrate($value, $soc_array);
     $art_cv_work += workcvrate($value, $art_array);
     $gen_cv_work += workcvrate($value, $cvr_array);
  } 
}

if ((elgg_get_plugin_setting('language', 'resume') == 'yes') && (elgg_list_entities(array('types' => 'object', 'subtypes' => 'language', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false)))) {
  
    $lang_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'language', 'owner_guids' => $page_owner->guid, 'limit' => 0));
  
  foreach ($lang_array as $key => $value) {
     $tech_cv_lang += langcvrate($value, $tech_array, $lang_array);
     $sci_cv_lang += langcvrate($value, $sci_array, $lang_array);
     $bio_cv_lang += langcvrate($value, $bio_array, $lang_array);
     $soc_cv_lang += langcvrate($value, $soc_array, $lang_array);
     $art_cv_lang += langcvrate($value, $art_array, $lang_array);
     $gen_cv_lang += langcvrate($value, $cvr_array, $lang_array);
  } 
}

if ((elgg_get_plugin_setting('research', 'resume') == 'yes') && (elgg_list_entities(array('types' => 'object', 'subtypes' => 'research', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false)))) {
  
    $res_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'research', 'owner_guids' => $page_owner->guid, 'limit' => 0));
  
  foreach ($res_array as $key => $value) {
     $tech_cv_res += rescvrate($value, $tech_array);
     $sci_cv_res += rescvrate($value, $sci_array);
     $bio_cv_res += rescvrate($value, $bio_array);
     $soc_cv_res += rescvrate($value, $soc_array);
     $art_cv_res += rescvrate($value, $art_array);
     $gen_cv_res += rescvrate($value, $cvr_array);
  } 
}

if ((elgg_get_plugin_setting('publication', 'resume') == 'yes') && (elgg_list_entities(array('types' => 'object', 'subtypes' => 'publication', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false)))) {
  
    $pub_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'publication', 'owner_guids' => $page_owner->guid, 'limit' => 0));
  
  foreach ($pub_array as $key => $value) {
     $tech_cv_pub += pubcvrate($value, $tech_array);
     $sci_cv_pub += pubcvrate($value, $sci_array);
     $bio_cv_pub += pubcvrate($value, $bio_array);
     $soc_cv_pub += pubcvrate($value, $soc_array);
     $art_cv_pub += pubcvrate($value, $art_array);
     $gen_cv_pub += pubcvrate($value, $cvr_array);
  } 
}

if ((elgg_get_plugin_setting('skill', 'resume') == 'yes') && (elgg_list_entities(array('types' => 'object', 'subtypes' => 'skill', 'container_guid' => $page_owner->guid, 'limit' => 0, 'full_view' => false)))) {
  
    $skill_array = elgg_get_entities (array('types' => 'object', 'subtypes' => 'skill', 'owner_guids' => $page_owner->guid, 'limit' => 0));
  
  foreach ($skill_array as $key => $value) {
     $tech_cv_skill += skillcvrate($value, $tech_array);
     $sci_cv_skill += skillcvrate($value, $sci_array);
     $bio_cv_skill += skillcvrate($value, $bio_array);
     $soc_cv_skill += skillcvrate($value, $soc_array);
     $art_cv_skill += skillcvrate($value, $art_array);
     $gen_cv_skill += skillcvrate($value, $cvr_array);
  } 
}
   
   $tech_cv_total = $tech_cv_edu + $tech_cv_work + $tech_cv_lang + $tech_cv_res + $tech_cv_pub + $tech_cv_skill; 
   $sci_cv_total = $sci_cv_edu + $sci_cv_work + $sci_cv_lang + $sci_cv_res + $sci_cv_pub + $sci_cv_skill;
   $bio_cv_total = $bio_cv_edu + $bio_cv_work + $bio_cv_lang + $bio_cv_res + $bio_cv_pub + $bio_cv_skill; 
   $soc_cv_total = $soc_cv_edu + $soc_cv_work + $soc_cv_lang + $soc_cv_res + $soc_cv_pub + $soc_cv_skill; 
   $art_cv_total = $art_cv_edu + $art_cv_work + $art_cv_lang + $art_cv_res + $art_cv_pub + $art_cv_skill; 
   $gen_cv_total = $gen_cv_edu + $gen_cv_work + $gen_cv_lang + $gen_cv_res + $gen_cv_pub + $gen_cv_skill;  
 
  if ($tech_cv_total > 0) { 
     $tech_total_rank = maximalCVR($tech_cv_total, $page_owner->guid, 'total', 'tech');
     $tech_total_rank_two = round_two($tech_total_rank);
  }
  else $tech_total_rank_two = 0;
  
 if ($sci_cv_total > 0) { 
     $sci_total_rank = maximalCVR($sci_cv_total, $page_owner->guid, 'total', 'tech');
     $sci_total_rank_two = round_two($sci_total_rank);
  }
  else $sci_total_rank_two = 0;
  
 if ($bio_cv_total > 0) { 
     $bio_total_rank = maximalCVR($bio_cv_total, $page_owner->guid, 'total', 'tech');
     $bio_total_rank_two = round_two($bio_total_rank);
  }
  else $bio_total_rank_two = 0;
  
 if ($soc_cv_total > 0) { 
     $soc_total_rank = maximalCVR($soc_cv_total, $page_owner->guid, 'total', 'tech');
     $soc_total_rank_two = round_two($soc_total_rank);
  }
  else $soc_total_rank_two = 0;
  
 if ($art_cv_total > 0) { 
     $art_total_rank = maximalCVR($art_cv_total, $page_owner->guid, 'total', 'tech');
     $art_total_rank_two = round_two($art_total_rank);
  }
  else $art_total_rank_two = 0;
  
 if ($gen_cv_total > 0) { 
     $gen_total_rank = maximalCVR($gen_cv_total, $page_owner->guid, 'total', 'gen');
     $gen_total_rank_two = round_two($gen_total_rank);
  }
  else $gen_total_rank_two = 0;
  