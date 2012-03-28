<?php
/**
 * CVRank education
 */

/**
 * @todo : use university rankings according to start-end dates of each subject
 * @todo : when count_titles (articles, res, certs) for loops, to avoid blank scoring, we should 
 *         take only keys from set values from titles_array, and then use them for scores. 
 *         now we are counting all, and even if counting set values, we are not using their keys...
 * @todo : use array of arrays in education fields - array (0, tertiary, secondary) - to avoid (inefficient?) "in_array"
 */
 	/**
	 * Function educvrate() in education
	 */

  function educvrate($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $edufields = $cvr_arrays['edufields'];
      $educountries = $cvr_arrays['educountries'];
      $edudatabases = $cvr_arrays['edudatabases'];
      $credtypes = $cvr_arrays['credtypes']; 
      $prestypes = $cvr_arrays['prestypes']; 
      $hourtypes = $cvr_arrays['hourtypes']; 
      $gradetypes = $cvr_arrays['gradetypes'];
    
  // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
    
  // STRUCTURE/FIELD RATING BEGINS
    // get data
    $university_id = $ratedobject->structure;
      // get the name of the university
      if ($university_id) {
         $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_university_entity WHERE university_id='$university_id'";
         $result = get_data_row($query);
         $university = $result->name;
         $country = $result->country;
         $unitype = $result->type;
      }
    $field = $ratedobject->field;
    
    // Rankings and education fields
    // Obtain general ISCED level as integer
    if ($level) $genlevel = (int) substr($level, 5, 6);
    
     // prove for tertiary fields, else take secondary fields
     if ($genlevel > 4) $branch = $edufields[2];
     else $branch = $edufields[1];
     
     $available_rankings = array();
     // levels in $edudatabases are 1 more:
     $prooflevel = $genlevel + 1;
     foreach ($edudatabases as $edudbkey => $edudbvalue) {
         // include only if database is valid for level, AND if the weight is not 0
         if (($edudbvalue[$prooflevel]) || ($edudbvalue[0] != 0)) $available_rankings[] = $edudbkey;
     }
   
   $ratings = array();
   // loop through all level_rankings in the database
   foreach ($available_rankings as $keyrankings => $university_ranking) {
     // If the ranking divides between branches, use $branch
     if ($edudatabases[$university_ranking][10]) {
         // 1st rating:
           // if structure ($university) is defined, search for it
        if ($university) {
           $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE university='$university' AND field='$branch'";
           $performance1 = get_data_row($query);
           $rating1 = $performance1->rating; 
        }
         // if it doesn't get a result, or there is no $university, look for country values in database
         if (!$performance1) {
            $rating1 = $educountries[$country][0];
         } 
          
         // 2nd rating:
         if ($university) {
            $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE university='$university' AND field='gen'";
   	    $performance2 = get_data_row($query);
            $rating2 = $performance2->rating;
         }
          if (!$performance2) {
             $rating2 = $educountries[$country][0];
          }
          
          // add values and get total
          $totalrating = ( $rating1 * ( 1 - $advanced_values["edudbgen"] ) ) 
          + ( $rating2 * $advanced_values["edudbgen"] );
          
          // weight the totalrating
          $totalrating = $totalrating * $edudatabases[$university_ranking][0];
          // assign to ratings array
          $ratings[] = $totalrating; 
          
     }   
     // If the ranking does not divide between branches, retrieve general rating
      else {
         if ($university) {
 // IMPORTANT - if database uses country (NOT university), then use country='$country'
         $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE university='$university'";
         $performance = get_data_row($query);
         $rating = $performance->rating; 
         }
         // if it doesn't get a result, look for country value
          if (!$performance) {
             $rating = $educountries[$country][0];
          }
          $rating = $performance->rating; 
          $rating = $rating * $edudatabases[$university_ranking][0];
          $ratings[] = $rating;
        }
   }
    
        // CALCULATE MEAN: SUM OF ARRAY DIVIDED BY COUNT
     $sumratings = array_sum($ratings);
     $countratings = count($ratings);
     $meanrating = $sumratings/$countratings;
   
  // STRUCTURE/FIELD RATING ENDS 
   
  // EDUCATION TYPE CORRECTION FACTOR
    
     $edutype = $ratedobject->edutype;
     $typecorrection = $prestypes[$edutype];
     $ratemult = $advanced_values["ratemult"];
     $rateadd = $advanced_values["rateadd"];
     
   // convert rating to scale
     $netrating = ($meanrating * $typecorrection) * $ratemult + $rateadd;
   
  // CVRANK ALGORITHM
  $z = $advanced_values['z'];
  $B = 1/pow(10, $z + $difficulty + $netrating);
  
  // get percentile
  $classrank = $ratedobject->classrank;
  
  // if it is an EXAM, and we have a percentile, evaluate only percentile
  if ( 
       ( ($unitype == "exam") || ($unitype == "accessexam") || ($unitype == "stateexam") 
          || ($unitype == "officialexam") || ($unitype == "privateexam") ) 
       && ($classrank)
        ) {
      $score = $classrank;
      
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
       
      // Get stdyear from advanced values
         $stdyear = $advanced_values[$unitype];
         
         // CVR
	  $probability = $score/100;
          $CVR = 1/$B * ($probability / (1 - $probability) );
                
              // add each loop
             $totalCVR = $CVR * $stdyear;
      
  }
  // if it is an INSTITUTION (or not set), evaluate scores
  else {
  // TIME FACTOR
    $hourtype = $ratedobject->hourtype;
    $creditsyear = $hourtypes[$hourtype];
    // if not set, suppose 1100 hours / year
    if (!$creditsyear) $creditsyear = 1100;
    
  // SCORING BEGINS
    // get data
    $scores = $ratedobject->scores;
      $maxscore = $advanced_values["maxscore"];
    $hours =  $ratedobject->hours;
    $types = $ratedobject->types; 
    $gradetype = $ratedobject->gradetype; 
    $arraytype = $gradetypes[$gradetype];
    // use types
     $letter = $arraytype[1];
     $scale = $arraytype[2];
     $pass = $arraytype[3];
     
     // For grade inflation, look for advanced values!
     if (!$advanced_values[$gradetype]) $gradeinflation = $arraytype [0];
     else $gradeinflation = $advanced_values[$gradetype];
     
    // Calculate ratings: loop through types, scores and credits
     $countedscores = count ($scores);
     for ($i=0; $i<$countedscores; $i++) {
       $score = $scores[$i];
       // loop only if score is set
       if ($score) {
         // if score is PASS, give it a value halfway between STD pass interval 60-100
         if ($score == "PASS") $score = 80;
         else {
           // test for letter grades or convert numbers from "," to "." 
            $grade = lettertonumber ($score, $letter);
           // test for scores to percentages
             $grade = scoring_scale ($grade, $scale);
           // convert all grades to a 60% pass score
            $score = pass_std ($grade, $pass);
         }
         // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
          
          // adjust for type
          $type = $types[$i];
            // if type is not set, give it the value of any
            if (!$type) $type = "any";
          $score = $score * $credtypes[$type];
          
	  // calculate standardized credits
          if ($hours[$i] > 0) $stdyear = $hours[$i]/$creditsyear;
           
             // max. limit of 6 academic years and min. limit for each education
             if ($stdyear > 6)  $stdyear = 6;
    
               // calculate subject's CVR
	        $probability = $score/100;
                $CVR = 1/$B * ($probability / (1 - $probability) );
                
              // add each loop
             $totalCVR += $CVR * $stdyear;
     }
    }
    
      // adjust by classrank; 
      $crank = $advanced_values["crank"];
      $powerrank = $advanced_values["powerrank"];
      
      // turn best classrank much better, worse classrank much worse
      $classrank = pow($classrank,$powerrank)/pow(100,$powerrank);
      $classvalue = 1 + $classrank * $crank;
    $totalCVR = $totalCVR * $classvalue;
   } 
      // adjust by prizes obtained
    $prizes = $ratedobject->prizes; 
    $prizerank = 0;
    if (!is_array($prizes)) $prizes[0] = $prizes;
    foreach ($prizes as $key => $prize) {
      $prizerank += $advanced_values[$prize];
    }
      $prizevalue = 1 + $prizerank;
    $totalCVR = $totalCVR * $prizevalue;
    
      // adjust totalrating by the value given to education fields
      $eduCVR = $totalCVR * $edufields[$field][0];
       
      // return the value!
      return $eduCVR;
 }
 
 function scoring ($ratedobject, $cvr_arrays) {
    
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $credtypes = $cvr_arrays['credtypes']; 
      $gradetypes = $cvr_arrays['gradetypes'];
      
    // SCORING BEGINS
    // get data
    $scores = $ratedobject->scores;
      $maxscore = $advanced_values["maxscore"];
    $hours =  $ratedobject->hours;
    $types = $ratedobject->types; 
    $gradetype = $ratedobject->gradetype; 
    $arraytype = $gradetypes[$gradetype];
    // use types
     $letter = $arraytype[1];
     $scale = $arraytype[2];
     $pass = $arraytype[3];
     
     // For grade inflation, look for advanced values!
     if (!$advanced_values[$gradetype]) $gradeinflation = $arraytype [0];
     else $gradeinflation = $advanced_values[$gradetype];
     
    // Calculate ratings: loop through types, scores and credits
     $countedscores = count ($scores);
     
     for ($i=0; $i<$countedscores; $i++) {
       $score = $scores[$i];
       // loop only if score is set
       if ($score) {
         // if score is PASS, give it a value halfway between STD pass interval 60-100
         if ($score == "PASS") $score = 80;
         else {
           // test for letter grades or convert numbers from "," to "." 
            $grade = lettertonumber ($score, $letter);
           // test for scores to percentages
             $grade = scoring_scale ($grade, $scale);
           // convert all grades to a 60% pass score
            $score = pass_std ($grade, $pass);
         }
         // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
          
          // adjust for type
          $type = $types[$i];
            // if type is not set, give it the value of any
            if (!$type) $type = "any";
          
          $score = $score * $credtypes[$type];
        
          $sumscores += $score * $hours[$i];
          $sumhours += $hours[$i];
      }
     }
     // avoid division by 0
     if ($sumhours != 0) $meanscore = $sumscores / $sumhours;
          return $meanscore;
}