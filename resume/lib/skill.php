<?php
/**
 * CVRank skill
 */

	/**
	 * Function skillcvrate() in skills
	 */

  function skillcvrate($ratedobject, $cvr_arrays, $objects_array) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $skilltypes = $cvr_arrays['skilltypes'];
    
   // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
   
   $typology = $ratedobject->skilltype;
   $skilltype = $skilltypes[$typology];
  
    // get object data
  
   $certs = $ratedobject->certs;
   $scores = $ratedobject->scores;
   
   $stdyear = $advanced_values["skillyear"];
   $skillcoef = $advanced_values["skillcoef"];
   $maxscore = $advanced_values["maxscore"];
   $z = $advanced_values['z'];
   
     $ratemult = $advanced_values["ratemult"];
     $rateadd = $advanced_values["rateadd"];
      // RATING; right now, just set to minimum
       $netrating = $rateadd;
   
     // CVRANK ALGORITHM
     $B = 1/pow(10, $z + $difficulty + $netrating);
     
   $count_certs = count($certs);
   
   // COUNT same_skils (number of skills of the same type)
    $same_skills = 0;
    // from this object
    foreach ($scores as $sckey => $scvalue) {
          if (($scvalue) && ($scvalue != 0)) {
               $same_skills++;
          }
    }
    // from other objects of the same skilltype
    foreach ($objects_array as $key => $value) {
         $typology2 = $value->skilltype;
         $scores2 = $value->scores;
         if ($typology2 == $typology) {
             foreach ($scores2 as $sc2key => $sc2value) {
                 if (($sc2value) && ($sc2value != 0)) {
                  $same_skills++;
                 }
             }
          }
     }
             
   for ($i = 0; $i < $count_certs; $i++) {
     
      // SCORE
      $score = $scores[$i];
      // loop only if $score is set and is not 0
    if (($score) && ($score != 0))  {
        
      // prove numbers are not over- or infraestimated
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
     
        // calculate each article's CVR
	  $probability = $score/100;
          $CVR = 1/$B * ($probability / (1 - $probability) );
         
         $samecoef = pow($skillcoef, $same_skills);
         $CVR = $CVR * $samecoef;
         
        // correct by stdyear, and add each loop
          $totalCVR += $CVR * $stdyear;
      }
  }
       // apply weight
       $skillCVR = $totalCVR * $skilltype[0];
        
      // return the value!
      return $skillCVR;
 }
 
 function skillscore ($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
    
   $maxscore = $advanced_values["maxscore"];
   
   $scores = $ratedobject->scores;
   
     //First, select the maximum score in research
        $score = max($scores);
        
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
  
      // return the value!
      return $score;
 }