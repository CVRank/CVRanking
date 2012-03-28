<?php
/**
 * education - resume main
 */

  if ($tech_cv_edu > 0) {
     $tech_edu_rank = maximalCVR($tech_cv_edu, $page_owner->guid, 'edu', 'tech');
     $tech_edu_rank_two = round_two($tech_edu_rank);
  }
  else $tech_edu_rank_two = 0;
  
  if ($sci_cv_edu > 0) {
     $sci_edu_rank = maximalCVR($sci_cv_edu, $page_owner->guid, 'edu', 'sci');
     $sci_edu_rank_two = round_two($sci_edu_rank);
  }
  else $sci_edu_rank_two = 0;
  
  if ($bio_cv_edu > 0) {
     $bio_edu_rank = maximalCVR($bio_cv_edu, $page_owner->guid, 'edu', 'bio');
     $bio_edu_rank_two = round_two($bio_edu_rank);
  }
  else $bio_edu_rank_two = 0;
  
  if ($soc_cv_edu > 0) {
     $soc_edu_rank = maximalCVR($soc_cv_edu, $page_owner->guid, 'edu', 'soc');
     $soc_edu_rank_two = round_two($soc_edu_rank);
  }
  else $soc_edu_rank_two = 0;
  
  if ($art_cv_edu > 0) {
     $art_edu_rank = maximalCVR($art_cv_edu, $page_owner->guid, 'edu', 'art');
     $art_edu_rank_two = round_two($art_edu_rank);
  }
  else $art_edu_rank_two = 0;