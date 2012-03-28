<?php
/**
 * language_form arrays
 */

$langtypes = array(
    '' => '',
   "mother" => elgg_echo('resume:languages:type:mother'),
   "mother2" => elgg_echo('resume:languages:type:mother2'),
   "foreign" => elgg_echo('resume:languages:type:foreign'),
  );

$experience = array(
   elgg_echo('resume:language:experience:philology') => 'philology',  
   elgg_echo('resume:language:experience:study') => 'study', 
   elgg_echo('resume:language:experience:publication') => 'publication', 
   elgg_echo('resume:language:experience:discourse') => 'discourse', 
  );

$level_options = array(
    '' => '',
    // Basic User
    'a1' => elgg_echo('resume:languages:level:a1'),
    'a2' => elgg_echo('resume:languages:level:a2'),
    // Independent user
    'b1' => elgg_echo('resume:languages:level:b1'),
    'b2' => elgg_echo('resume:languages:level:b2'),
    // Proficient user
    'c1' => elgg_echo('resume:languages:level:c1'),
    'c2' => elgg_echo('resume:languages:level:c2'),
  );