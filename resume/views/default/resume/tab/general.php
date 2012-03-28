<?php
/**
 * general - resume main
 */

  if ($gen_cv_edu > 0) { 
     $gen_edu_rank = maximalCVR($gen_cv_edu, $page_owner->guid, 'edu', 'gen');
     $gen_edu_rank_two = round_two($gen_edu_rank);
  }
  else $gen_edu_rank_two = 0;

  if ($gen_cv_work > 0) { 
     $gen_work_rank = maximalCVR($gen_cv_work, $page_owner->guid, 'work', 'gen');
     $gen_work_rank_two = round_two($gen_work_rank);
  }
  else $gen_work_rank_two = 0;

  if ($gen_cv_lang > 0) { 
     $gen_lang_rank = maximalCVR($gen_cv_lang, $page_owner->guid, 'lang', 'gen');
     $gen_lang_rank_two = round_two($gen_lang_rank);
  }
  else $gen_lang_rank_two = 0;

  if ($gen_cv_res > 0) { 
     $gen_res_rank = maximalCVR($gen_cv_res, $page_owner->guid, 'res', 'gen');
     $gen_res_rank_two = round_two($gen_res_rank);
  }
  else $gen_res_rank_two = 0;

  if ($gen_cv_pub > 0) { 
     $gen_pub_rank = maximalCVR($gen_cv_pub, $page_owner->guid, 'pub', 'gen');
     $gen_pub_rank_two = round_two($gen_pub_rank);
  }
  else $gen_pub_rank_two = 0;

  if ($gen_cv_skill > 0) { 
     $gen_skill_rank = maximalCVR($gen_cv_skill, $page_owner->guid, 'skill', 'gen');
     $gen_skill_rank_two = round_two($gen_skill_rank);
  }
  else $gen_skill_rank_two = 0;