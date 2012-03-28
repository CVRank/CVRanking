<?php
/**
 * CVRank research
 */

/**
 * @todo : $resfields are not clear (WOK definitons and WOK categories overlap, lacking,...)
 */
	/**
	 * Function rescvrate() in research
	 */

  function rescvrate($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $resfields = $cvr_arrays['resfields'];
    
   // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
   
   $field = $ratedobject->field;
   $resfield = $resfields[$field];
  
    // get object data
  
   $articles = $ratedobject->articles;
   $citations = $ratedobject->citations;
   $maxcitations = $ratedobject->maxcitations;
   $impacts = $ratedobject->impacts;
   $maximpacts = $ratedobject->maximpacts;
   $eigens = $ratedobject->eigens;
   $maxeigens = $ratedobject->maxeigens;
   $authors = $ratedobject->authors;
   $positions = $ratedobject->positions;

   $impactcoef = $advanced_values['impact'];
   $eigencoef = $advanced_values['eigen'];
   $stdyear = $advanced_values['resyear'];
   $maxscore = $advanced_values["maxscore"];
   $z = $advanced_values['z'];
      
      // positions
      $posfactor = $advanced_values["posfactor"];
      
   $count_articles = count($articles);
 
   for ($i = 0; $i < $count_articles; $i++) {
      $citation = $citations[$i];
      $googscholar = $maxcitations[$i];
      
    // loop only if scores are set
    if ($citation || $googscholar)  {
       
      // RATING
      // get data and substitute "," by "."
      $impact = str_replace(",",".",$impacts[$i]);
      $maximpact =  str_replace(",",".",$maximpacts[$i]);
      $eigen =  str_replace(",",".",$eigens[$i]);
      $maxeigen =  str_replace(",",".",$maxeigens[$i]);
      
      $impactrating = $impact/$maximpact;
      $eigenrating = $eigen/$maxeigen;
      
       // prove they can't give (at this stage) more than 100% or less than 0%
        if ($impactrating > $maxscore) $impactrating = $maxscore;	
          elseif ($impactrating < 0) $impactrating = 0;
          
        if ($eigenrating > $maxscore) $eigenrating = $maxscore;	
          elseif ($eigenrating < 0) $eigenrating = 0;
          
     // now adjust by advanced values
       $rating = ($impactrating * $impactcoef + $eigenrating * $eigencoef) * 100;
     
     $ratemult = $advanced_values["ratemult"];
     $rateadd = $advanced_values["rateadd"]; 
       $netrating = $rating * $ratemult + $rateadd;
   
     // CVRANK ALGORITHM
     $B = 1/pow(10, $z + $difficulty + $netrating);
     
      // SCORE
        // guarantee they are integers
      $citation = intval ($citation);
      $googscholar = intval ($googscholar);
      // 2001-2012 - retrieved 10 March 2012 (rounded up): WOK / Google Scholar for 10 years
      // agriculture = 900/1400, 800, 600, 600, 600, 600 
      // biomed = 14100/19900, 10100, 4700, 3400, 3400, 3300
      // chemistry = 15700/64100, 8200, 7100, 5300, 3700, 3700
      // clinmed = 9200/?, 6400/6400, 5900, 4900, 5000, 4500 
      // computer = 8100/10200, 7700, 7100, 4600, 3900, 3200
      // economics = 1000/4900, 900, 900, 900, 700, 700 
      // engineering = 2100/4800, 2000, 1600, 1500, 1400, 1200
      // environment/ecology = 4500/5800, 2100, 1800, 1700, 1700, 1600
      // geosciences = 2000/2700, 2000, 2000, 1700, 1400, 1300
      // infectious = 2600/3900, 2500, 2500, 2400, 2400, 2400
      // material = 4300/5500, 4000, 4000, 3400, 2500, 1900, 1800
      // mathematics = 2800/7500, 2700, 1700, 1200, 1000, 800
      // microbio = 1800/2400, 1400, 1200, 1200, 1100, 1100, 1100
      // molbio = 5900/14000, 5500, 4700, 3500, 3100, 3100
      // multi = 800/1200, 500, 500, 500, 400, 400
      // neuro = 3100/4385, 2600, 2300, 1900, 1700, 1700
      // pharma = 1400/5200, 1200, 1100, 1100, 1000, 1000
      // physics = 5600/7500, 4200, 4000, 3600, 3200, 3100
      // plantanimal = 2000/2600, 1400, 1400, 1400, 1400, 1300
      // psycho = 2800/6100, 2400, 1900, 1900, 1700, 1600
      // social = 900/2200, 800, 700, 700, 700, 700
      // space = 5200/8600, 2800, 2400, 2100, 1900, 1800, 1800
    // take reasonable MAXIMUM as double the first value (for ~20-30 years); 
      if ($resfield[1] == "chemistry") $maximum = 31400;
      elseif ($resfield[1] == "biomed") $maximum = 28200; 
      elseif ($resfield[1] == "computer") $maximum = 16200;
      elseif ($resfield[1] == "molbio") $maximum = 11800;
      // genmed - unknown - classify conservatively as clinmed
      elseif (($resfield[1] == "clinmed") || ($resfield[1] == "genmed")) $maximum = 18400;
      elseif ($resfield[1] == "physics") $maximum = 11200;
      elseif ($resfield[1] == "space") $maximum = 10400;
      elseif (($resfield[1] == "environmental") || ($resfield[1] == "ecology")) $maximum = 9000;
      elseif ($resfield[1] == "material") $maximum = 8600;
      elseif ($resfield[1] == "neuro") $maximum = 6200;
      elseif ($resfield[1] == "mathematics") $maximum = 5600;
      elseif ($resfield[1] == "psycho") $maximum = 5600;
      elseif ($resfield[1] == "infectious") $maximum = 5200;
      elseif ($resfield[1] == "engineering") $maximum = 4200;
      elseif ($resfield[1] == "geosciences") $maximum = 4000;
      elseif (($resfield[1] == "plantanimal") || ($resfield[1] == "animal")) $maximum = 4000;
      elseif ($resfield[1] == "microbio") $maximum = 3600;
      elseif ($resfield[1] == "pharma") $maximum = 2800;
      elseif ($resfield[1] == "economics") $maximum = 2000;
      elseif ($resfield[1] == "social") $maximum = 1800;
      elseif ($resfield[1] == "multi") $maximum = 1600;
      elseif ($resfield[1] == "agriculture") $maximum = 900;
        // if research field is not set, take the maximum
      else $maximum = 31400;
      // for Google Scholar, take double value
      $maxgoogle = 2 * $maximum;
        // use log to minimize huge differences
      $score1 = log($citation)/log($maximum) * 100;
      $score2 = log($googscholar)/log($maxgoogle) * 100;
       $score = $score1 * $advanced_values["WOK"] + $score2 * $advanced_values["GOOG"];
         // prove numbers are not over- or infraestimated
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
       
        // calculate each article's CVR
	  $probability = $score/100;
          $CVR = 1/$B * ($probability / (1 - $probability) );
          
         $author = $authors[$i];
         $position = $positions[$i];
         // if Nr. authors is not set, set to 1
         if ($author <= 0) $author = 1;
         // if position is not set, set to last
         if ($position <= 0) $position = $author;
         // correct by number of authors and position, if there are more than 1 authors
         if ($author > 1) {
             $positioncoef = (1/$position) * $posfactor;
             $CVRpart = $CVR/$author;
             $CVR = $CVRpart + $CVRpart * $positioncoef;
         }
        // correct by stdyear, and add each loop
          $totalCVR += $CVR * $stdyear;  
   }
  }
  
  // PRIZE CORRECTION FACTOR 
  // prizes usually affect the whole research done, all articles written on the same subject
  // if they were given per article, the sum would be too much.
    // getdata
    $prizes = $ratedobject->prizes;
    $prcited = $advanced_values["prcited"];
    $prnobel = $advanced_values["prnobel"];
    $prother = $advanced_values["prother"];
    
    foreach ($prizes as $pkey => $pvalue) {
        if (($pvalue == "top10") || ($pvalue == "top20")) $prizecoef += $prcited;
        elseif (($pvalue == "nobel") || ($pvalue == "fields") || ($pvalue == "gairdner") || ($pvalue == "lasker") 
            || ($pvalue == "turing") || ($pvalue == "engineering1") || ($pvalue == "engineering2") 
            || ($pvalue == "engineering3") || ($pvalue == "economics")) $prizecoef += $prnobel;
        else $prizecoef += $prother;
    }   
    
    $prizevalue = 1 + $prizecoef;
    
    $resCVR = $totalCVR * $prizevalue;
         
       // apply weight
       $rescoef = $resfield[0];
       $resCVR = $resCVR * $rescoef;
        
      // return the value!
      return $resCVR;
 }

 function resscore ($ratedobject, $cvr_arrays) {
         
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $resfields = $cvr_arrays['resfields'];
    
  $field = $ratedobject->field;
  $resfield = $resfields[$field];
    
  $articles = $ratedobject->articles;
  
  $maxscore = $advanced_values["maxscore"];
    
   $count_articles = count($articles);
 
    // get object data
  
    $citations = $ratedobject->citations;
    $maxcitations = $ratedobject->maxcitations;
    
  for ($i = 0; $i < $count_articles; $i++) {
  
      $citation = $citations[$i];
      $googscholar = $maxcitations[$i];
      
    // loop only if scores are set
    if ($citation || $googscholar)  {
   
      $citation = intval ($citation);
      $googscholar = intval ($googscholar);
      // 2001-2012 - retrieved 10 March 2012 (rounded up): WOK / Google Scholar for 10 years
      // agriculture = 900/1400, 800, 600, 600, 600, 600 
      // biomed = 14100/19900, 10100, 4700, 3400, 3400, 3300
      // chemistry = 15700/64100, 8200, 7100, 5300, 3700, 3700
      // clinmed = 9200/?, 6400/6400, 5900, 4900, 5000, 4500 
      // computer = 8100/10200, 7700, 7100, 4600, 3900, 3200
      // economics = 1000/4900, 900, 900, 900, 700, 700 
      // engineering = 2100/4800, 2000, 1600, 1500, 1400, 1200
      // environment/ecology = 4500/5800, 2100, 1800, 1700, 1700, 1600
      // geosciences = 2000/2700, 2000, 2000, 1700, 1400, 1300
      // infectious = 2600/3900, 2500, 2500, 2400, 2400, 2400
      // material = 4300/5500, 4000, 4000, 3400, 2500, 1900, 1800
      // mathematics = 2800/7500, 2700, 1700, 1200, 1000, 800
      // microbio = 1800/2400, 1400, 1200, 1200, 1100, 1100, 1100
      // molbio = 5900/14000, 5500, 4700, 3500, 3100, 3100
      // multi = 800/1200, 500, 500, 500, 400, 400
      // neuro = 3100/4385, 2600, 2300, 1900, 1700, 1700
      // pharma = 1400/5200, 1200, 1100, 1100, 1000, 1000
      // physics = 5600/7500, 4200, 4000, 3600, 3200, 3100
      // plantanimal = 2000/2600, 1400, 1400, 1400, 1400, 1300
      // psycho = 2800/6100, 2400, 1900, 1900, 1700, 1600
      // social = 900/2200, 800, 700, 700, 700, 700
      // space = 5200/8600, 2800, 2400, 2100, 1900, 1800, 1800
    // take reasonable MAXIMUM as double the first value (for ~20-30 years); 
      if ($resfield[1] == "chemistry") $maximum = 31400;
      elseif ($resfield[1] == "biomed") $maximum = 28200; 
      elseif ($resfield[1] == "computer") $maximum = 16200;
      elseif ($resfield[1] == "molbio") $maximum = 11800;
      // genmed - unknown - classify conservatively as clinmed
      elseif (($resfield[1] == "clinmed") || ($resfield[1] == "genmed")) $maximum = 18400;
      elseif ($resfield[1] == "physics") $maximum = 11200;
      elseif ($resfield[1] == "space") $maximum = 10400;
      elseif (($resfield[1] == "environmental") || ($resfield[1] == "ecology")) $maximum = 9000;
      elseif ($resfield[1] == "material") $maximum = 8600;
      elseif ($resfield[1] == "neuro") $maximum = 6200;
      elseif ($resfield[1] == "mathematics") $maximum = 5600;
      elseif ($resfield[1] == "psycho") $maximum = 5600;
      elseif ($resfield[1] == "infectious") $maximum = 5200;
      elseif ($resfield[1] == "engineering") $maximum = 4200;
      elseif ($resfield[1] == "geosciences") $maximum = 4000;
      elseif (($resfield[1] == "plantanimal") || ($resfield[1] == "animal")) $maximum = 4000;
      elseif ($resfield[1] == "microbio") $maximum = 3600;
      elseif ($resfield[1] == "pharma") $maximum = 2800;
      elseif ($resfield[1] == "economics") $maximum = 2000;
      elseif ($resfield[1] == "social") $maximum = 1800;
      elseif ($resfield[1] == "multi") $maximum = 1600;
      elseif ($resfield[1] == "agriculture") $maximum = 900;
        // if it is not set, take a maximum max
      else $maximum = 50000;
      // for Google Scholar, take double value
      $maxgoogle = 2 * $maximum;
        // use log to minimize huge differences
      $score1 = log($citation)/log($maximum) * 100;
      $score2 = log($googscholar)/log($maxgoogle) * 100;
      
        // Do not allow errors to continue...
          if ($score1 > $maxscore) $score1 = $maxscore;	
          elseif ($score1 < 0) $score1 = 0;
          if ($score2 > $maxscore) $score2 = $maxscore;	
          elseif ($score2 < 0) $score2 = 0;
          
       $score = $score1 * $advanced_values["WOK"] + $score2 * $advanced_values["GOOG"];
        
          $scores_array[] = $score ;
     }    
   }
     //First, select the maximum score in research
        $score = max($scores_array);
        
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
          
      return $score;
 }
 