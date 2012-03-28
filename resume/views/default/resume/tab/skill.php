<?php
/**
 * skill - resume main
 */

  if ($tech_cv_skill > 0) { 
     $tech_skill_rank = maximalCVR($tech_cv_skill, $page_owner->guid, 'skill', 'tech');
     $tech_skill_rank_two = round_two($tech_skill_rank);
  }
  else $tech_skill_rank_two = 0;

  if ($sci_cv_skill > 0) { 
     $sci_skill_rank = maximalCVR($sci_cv_skill, $page_owner->guid, 'skill', 'sci');
     $sci_skill_rank_two = round_two($sci_skill_rank);
  }
  else $sci_skill_rank_two = 0;

  if ($bio_cv_skill > 0) { 
     $bio_skill_rank = maximalCVR($bio_cv_skill, $page_owner->guid, 'skill', 'bio');
     $bio_skill_rank_two = round_two($bio_skill_rank);
  }
  else $bio_skill_rank_two = 0;

  if ($soc_cv_skill > 0) { 
     $soc_skill_rank = maximalCVR($soc_cv_skill, $page_owner->guid, 'skill', 'soc');
     $soc_skill_rank_two = round_two($soc_skill_rank);
  }
  else $soc_skill_rank_two = 0;

  if ($art_cv_skill > 0) { 
     $art_skill_rank = maximalCVR($art_cv_skill, $page_owner->guid, 'skill', 'art');
     $art_skill_rank_two = round_two($art_skill_rank);
  }
  else $art_skill_rank_two = 0;