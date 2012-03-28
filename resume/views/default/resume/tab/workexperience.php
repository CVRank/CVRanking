<?php
/**
 * workexperience - resume main
 */

  if ($tech_cv_work > 0) { 
     $tech_work_rank = maximalCVR($tech_cv_work, $page_owner->guid, 'work', 'tech');
     $tech_work_rank_two = round_two($tech_work_rank);
  }
  else $tech_work_rank_two = 0;

  if ($sci_cv_work > 0) { 
     $sci_work_rank = maximalCVR($sci_cv_work, $page_owner->guid, 'work', 'sci');
     $sci_work_rank_two = round_two($sci_work_rank);
  }
  else $sci_work_rank_two = 0;
  
  if ($bio_cv_work > 0) { 
     $bio_work_rank = maximalCVR($bio_cv_work, $page_owner->guid, 'work', 'bio');
     $bio_work_rank_two = round_two($bio_work_rank);
  }
  else $bio_work_rank_two = 0;
  
  if ($soc_cv_work > 0) { 
     $soc_work_rank = maximalCVR($soc_cv_work, $page_owner->guid, 'work', 'soc');
     $soc_work_rank_two = round_two($soc_work_rank);
  }
  else $soc_work_rank_two = 0;

  if ($art_cv_work > 0) { 
     $art_work_rank = maximalCVR($art_cv_work, $page_owner->guid, 'work', 'art');
     $art_work_rank_two = round_two($art_work_rank);
  }
  else $art_work_rank_two = 0;