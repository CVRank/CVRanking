<?php
/**
 * language - resume main
 */
  if ($tech_cv_lang > 0) { 
     $tech_lang_rank = maximalCVR($tech_cv_lang, $page_owner->guid, 'lang', 'tech');
     $tech_lang_rank_two = round_two($tech_lang_rank);
  }
  else $tech_lang_rank_two = 0;
  
  if ($sci_cv_lang > 0) { 
     $sci_lang_rank = maximalCVR($sci_cv_lang, $page_owner->guid, 'lang', 'sci');
     $sci_lang_rank_two = round_two($sci_lang_rank);
  }
  else $sci_lang_rank_two = 0;

  if ($bio_cv_lang > 0) { 
     $bio_lang_rank = maximalCVR($bio_cv_lang, $page_owner->guid, 'lang', 'bio');
     $bio_lang_rank_two = round_two($bio_lang_rank);
  }
  else $bio_lang_rank_two = 0;

  if ($soc_cv_lang > 0) { 
     $soc_lang_rank = maximalCVR($soc_cv_lang, $page_owner->guid, 'lang', 'soc');
     $soc_lang_rank_two = round_two($soc_lang_rank);
  }
  else $soc_lang_rank_two = 0;
  
  if ($art_cv_lang > 0) { 
     $art_lang_rank = maximalCVR($art_cv_lang, $page_owner->guid, 'lang', 'art');
     $art_lang_rank_two = round_two($art_lang_rank);
  }
  else $art_lang_rank_two = 0;