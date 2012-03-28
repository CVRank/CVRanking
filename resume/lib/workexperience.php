<?php
/**
 * CVRank work
 */

/**
 * @todo : use company rankings according to start-end dates of each job position
 * @todo : use company capitalizations from (user verified) company page information, not from databases
 * @todo : use array of arrays in industry_classes to avoid (inefficient?) loops
 */
	/**
	 * Function workcvrate() in workexperience
	 */

  function workcvrate($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $sectors = $cvr_arrays['sectors'];
      $workcountries = $cvr_arrays['educountries'];
      $workdatabases = $cvr_arrays['workdatabases'];
      $currencies = $cvr_arrays['currencies'];
      $industryclasses = $cvr_arrays['industryclasses'];
    
    $sector = $ratedobject->sector; 
    $sector_array = $sectors[$sector];
  // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
     // if it is not set, take default from sector
   if (!$level) $level = $sector_array[1];
   $difficulty = $advanced_values[$level];
  
  // STRUCTURE/FIELD RATING BEGINS
    // get data
    $company_id = $ratedobject->structure;
      // get the name of the university
      if ($company_id) {
         $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_company_entity WHERE company_id='$company_id'";
         $result = get_data_row($query);
         $company = $result->name;
         $country = $result->country;
         $industry = $result->industryclass;
         $total = $result->total;
      }
     
    $industryclass = $ratedobject->industryclass;
    // if the user forgot, take it from the database, if possible.
     if ((!$industryclass) && ($industry)) $industryclass = $industry;
     
     $available_rankings = array();
     
     // Before taking general industryclass, add available specific rankings for each group sector
       // Higher Education
      if (($industryclass == "8530") || ($industryclass == "853")) {
          $available_rankings[] = 'CVR_QS12';
      }
     // Get more general rankings
      // Research
      if (($industryclass == "72") || ($industryclass == "721") || ($industryclass == "7210") || 
              ($industryclass == "722") || ($industryclass == "7220")) {
          $available_rankings[] = 'CVR_SCImago12';
          $available_rankings[] = 'CVR_QS12';
      }
      // Hospitals
      if (($industryclass == "86") || ($industryclass == "861") || ($industryclass == "8610") || 
              ($industryclass == "862") || ($industryclass == "8620")  || ($industryclass == "869") ||
              ($industryclass == "8690")) {
          $available_rankings[] = 'CVR_USNewsH12';
      }
      
     $general_ic = $industryclasses[$industryclass][1];
     
      // Get more general rankings
        // Education
      if ($general_ic == "P") {
          $available_rankings[] = 'CVR_QS12';
      }
      
      // If no specific class available:
      if (!($available_rankings)) $available_rankings[0] = 'CVR_company_entity';
     
   // loop through all necessary rankings in the database
      $ratings = array();
   foreach ($available_rankings as $keyrankings => $company_ranking) {
    // Loop only if necessary!
    if ($workdatabases[$company_ranking][0] != 0) {
         if ($company) {
             if ($company_ranking == 'CVR_company_entity') {
               $capital = log($total);
              // query for max value plus log
                // either take maximum wage from database (too risky, too much change)
                // or take a maximum expected wage...
                  //$query = "SELECT MAX(total) as total FROM {$CONFIG->dbprefix}$company_ranking WHERE industryclass='$industryclass' ";
                  //$result = get_data_row($query);
                // COULD BE WRONG - DATA_ROW GETS ARRAY, NOT OBJECT??
                 //$maxlog = log($result["total"]);
              // we take maximum theoretical value of 2012, log($418,000M) from Exxon Mobile 
               $maxlog = 26.77;
              // rank over 100:
               $rating = $capital/$maxlog * 100;
             }   
             else {
             $query = "SELECT * FROM {$CONFIG->dbprefix}$company_ranking WHERE university='$company'";
             $performance = get_data_row($query);
               $rating = $performance->rating; 
             }
               // if it doesn't get a result, look for country value
               if (!$performance) {
                    $rating = $workcountries[$country][0];
               }
            $rating = $rating * $workdatabases[$company_ranking][0];
            $ratings[] = $rating;
         }
     }
   }
     
        // CALCULATE MEAN: SUM OF ARRAY DIVIDED BY COUNT
     $sumratings = array_sum($ratings);
     $countratings = count($ratings);
      // avoid division by 0
     if ($countratings !=0) $meanrating = $sumratings/$countratings;
      else $meanrating = 0;
   
  // STRUCTURE/FIELD RATING ENDS 
   
  // INDUSTRYCLASS TYPE CORRECTION FACTOR
    
     if ($industryclass) $typecorrection = $industryclasses[$industryclass][0];
     else $typecorrection = $industryclasses['any'][0];
   
    $ratemult = $advanced_values["ratemult"];
    $rateadd = $advanced_values["rateadd"];
   // Adjust rating to the scale set
     $netrating = ($meanrating * $typecorrection) * $ratemult + $rateadd;
   
  // CVRANK ALGORITHM
  $z = $advanced_values['z'];
  $B = 1/pow(10, $z + $difficulty + $netrating);

  // CURRENCY FACTOR
    $currency = $ratedobject->currency;
    $currindex = $currencies[$currency];
    // if not set, suppose Big Mac Index = 0.5 (< US Dollar)
    if (!$currindex) $currindex = 0.5;
     
  // SCORING BEGINS
    // get data
    $scores = $ratedobject->wages;
      $maxscore = $advanced_values["maxscore"];
    $hours =  $ratedobject->hours;
    $weeks = $ratedobject->weeks; 
    
  // For wage inflation, we should look for advanced values - more or less taxes, etc.
     
    // Calculate ratings: loop through types, scores and credits
     $countedscores = count ($scores);
     
     for ($i=0; $i<$countedscores; $i++) {
       $score = $scores[$i];
      // loop only if necessary
      if ($score) {
          // convert wage score to standard US dollars 
          $score = $currindex * $score;
          // convert wage/year to wage/week:
          $score = $score/52;
          // hours/week;
          $hour = $hours[$i];
          // convert wage/week to wage/hour
          $score = $score/$hour;
          
          // either take maximum wage from database (too risky, too much change)
          // or take a maximum ("reasonable") expected wage/week
          $maxwage = $advanced_values["maxwage"];
          // convert scores to a scale 0-100
          $score = (log($score))/$maxwage * 100;
         
         // Prove that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
          
	  // calculate standardized credits
          $week = $weeks[$i];
          if (!($week)) {
           // calculate Nr. weeks by date, in case they are set  
          }
          // use a standard of work per year; e.g. 40 hours/week 
          $stdweek = $hour/40;
          
          // convert Nr of weeks to Nr of standard weeks
          $workedstdweek = $week * $stdweek;
    
               // calculate subject's CVR
	        $probability = $score/100;
                $CVR = 1/$B * ($probability / (1 - $probability) );
                
              // add each loop
             $totalCVR += $CVR * $workedstdweek;
     }  
    }
       
      // adjust totalrating by the weight given to work sectors
      $workCVR = $totalCVR *  $sector_array[0]; 
       
      // return the value!
      return $workCVR;
 }
 
 function waging ($ratedobject, $cvr_arrays) {
    
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $currencies = $cvr_arrays['currencies'];
      
  // CURRENCY FACTOR
    $currency = $ratedobject->currency;
    $currindex = $currencies[$currency];
    // if not set, suppose Big Mac Index = 0.5 (< US Dollar)
    if (!$currindex) $currindex = 0.5;
    
    // SCORING BEGINS
    // get data
    $scores = $ratedobject->wages;
      $maxscore = $advanced_values["maxscore"];
    $hours =  $ratedobject->hours;
    
  // For wage inflation, we should look for advanced values - more or less taxes, etc.
     
    // Calculate ratings: loop through types, scores and credits
     $countedscores = count ($scores);
     
     for ($i=0; $i<$countedscores; $i++) {
       $score = $scores[$i];
      // loop only if necessary
      if ($score) {
          // convert wage score to standard US dollars 
          $score = $currindex * $score;
          // convert wage/year to wage/week:
          $score = $score/52;
          // hours/week;
          $hour = $hours[$i];
          // convert wage/week to wage/hour
          $score = $score/$hour;
          
          // either take maximum wage from database (too risky, too much change)
          // or take a maximum ("reasonable") expected wage/week: US$ >10M/year = 200000/week - 5000/hour =log= 8.53
          $maxwage = 8.52;
          // convert scores to a scale 0-100
          $score = (log($score))/$maxwage * 100;
         
          $scores_array[] = $score;
      }
     }
     //First, select the maximum wage/week in scores
        $score = max($scores_array);
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
     
          return $score;
}