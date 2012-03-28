<?php
/**
 * publication - resume main
 */

  if ($tech_cv_pub > 0) { 
     $tech_pub_rank = maximalCVR($tech_cv_pub, $page_owner->guid, 'pub', 'tech');
     $tech_pub_rank_two = round_two($tech_pub_rank);
  }
  else $tech_pub_rank_two = 0;

  if ($sci_cv_pub > 0) { 
     $sci_pub_rank = maximalCVR($sci_cv_pub, $page_owner->guid, 'pub', 'sci');
     $sci_pub_rank_two = round_two($sci_pub_rank);
  }
  else $sci_pub_rank_two = 0;

  if ($bio_cv_pub > 0) { 
     $bio_pub_rank = maximalCVR($bio_cv_pub, $page_owner->guid, 'pub', 'bio');
     $bio_pub_rank_two = round_two($bio_pub_rank);
  }
  else $bio_pub_rank_two = 0;

  if ($soc_cv_pub > 0) { 
     $soc_pub_rank = maximalCVR($soc_cv_pub, $page_owner->guid, 'pub', 'soc');
     $soc_pub_rank_two = round_two($soc_pub_rank);
  }
  else $soc_pub_rank_two = 0;

  if ($art_cv_pub > 0) { 
     $art_pub_rank = maximalCVR($art_cv_pub, $page_owner->guid, 'pub', 'art');
     $art_pub_rank_two = round_two($art_pub_rank);
  }
  else $art_pub_rank_two = 0;