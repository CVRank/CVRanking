<?php
/**
 * research - resume main
 */

  if ($tech_cv_res > 0) { 
     $tech_res_rank = maximalCVR($tech_cv_res, $page_owner->guid, 'res', 'tech');
     $tech_res_rank_two = round_two($tech_res_rank);
  }
  else $tech_res_rank_two = 0;

  if ($sci_cv_res > 0) { 
     $sci_res_rank = maximalCVR($sci_cv_res, $page_owner->guid, 'res', 'sci');
     $sci_res_rank_two = round_two($sci_res_rank);
  }
  else $sci_res_rank_two = 0;

  if ($bio_cv_res > 0) { 
     $bio_res_rank = maximalCVR($bio_cv_res, $page_owner->guid, 'res', 'bio');
     $bio_res_rank_two = round_two($bio_res_rank);
  }
  else $bio_res_rank_two = 0;

  if ($soc_cv_res > 0) { 
     $soc_res_rank = maximalCVR($soc_cv_res, $page_owner->guid, 'res', 'soc');
     $soc_res_rank_two = round_two($soc_res_rank);
  }
  else $soc_res_rank_two = 0;

  if ($art_cv_res > 0) { 
     $art_res_rank = maximalCVR($art_cv_res, $page_owner->guid, 'res', 'art');
     $art_res_rank_two = round_two($art_res_rank);
  }
  else $art_res_rank_two = 0;