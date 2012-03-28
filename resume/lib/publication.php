<?php
/**
 * CVRank publication
 */

	/**
	 * Function pubcvrate() in research
	 */

  function pubcvrate($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $pubfields = $cvr_arrays['pubfields'];
    
   // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
     // underestimate academic merit of publication (academi levels are not necessary to publish):
    $difficulty = $difficulty * $advanced_values["levelfactor"];
   
   $typology = $ratedobject->typology;
   $pubfield = $pubfields[$typology];
  
    // get object data
  
   $articles = $ratedobject->articles;
   $citations = $ratedobject->citations;
   $eigens = $ratedobject->eigens;
   $authors = $ratedobject->authors;
   $positions = $ratedobject->positions;
   
   $stdyeartype = $pubfield[1];
   $stdyear = $advanced_values[$stdyeartype];
   $maxscore = $advanced_values["maxscore"];
   $z = $advanced_values['z'];
      
  // CURRENCY FACTOR
    $currency = $ratedobject->currency;
    $currindex = $currencies[$currency];
    // if not set, suppose Big Mac Index = 0.5 (< US Dollar)
    if (!$currindex) $currindex = 0.5;
          
      // positions
      $posfactor = $advanced_values["posfactor"];
   
     $ratemult = $advanced_values["ratemult"];
     $rateadd = $advanced_values["rateadd"];
      // RATING; by default, set to minimum
       $netrating = $rateadd;
   
     // CVRANK ALGORITHM
     $B = 1/pow(10, $z + $difficulty + $netrating);
     
   $count_articles = count($articles);
   
   for ($i = 0; $i < $count_articles; $i++) {
     
      // SCORE
        // guarantee they are integers
      $viewer = intval ($citations[$i]);
      
        // get earning in US$
      $earning = intval($eigens[$i]) * $currindex;
      
      // loop only if scores are set
    if ($viewer || $earning)  {
        
      // set maximum and correct $stdyear
      // according to Wikipedia - best-selling books
      if (($typology == "fiction") || ($typology == "written")) $maxview = 100000000;
      elseif (($typology == "nonfiction") || ($typology == "essay")) $maxview = 50000000;
       // take maximum from science research
      elseif ($typology == "patent") $maxview = 30000;
       // "reasonable" (massive!) conference through net 
      elseif (($typology == "conference") || ($typology == "course")) $maxview = 1500;
       // massive performances ever
      elseif (($typology == "performance") || ($typology == "live")) $maxview = 3500000;
       // from Google PageRank
      elseif ($typology == "blog") $maxview = 10;
       // most seen in YouTube
       // elseif (($pubfield[1] == "audiovisual") || ($pubfield[1] == "music") || ($pubfield[1] == "media")
       //        || ($pubfield[1] == "art"))  $maxview = 1000000000;
       else $maxview = 1000000000;
       
      // use log only if necessary (not in PageRank)
      if ($maxview > 10) $score1 = log($viewer)/log($maxview) * 100;
      else $score1 = $viewer/$maxview * 100;
       
      // take MaxEarning from e.g. Avatar earnings
      $maxearning = 2000000000;
      $score2 = log($earning)/log($maxearning) * 100;
        // Do not allow errors to continue...
          if ($score1 > $maxscore) $score1 = $maxscore;	
          elseif ($score1 < 0) $score1 = 0;
          if ($score2 > $maxscore) $score2 = $maxscore;	
          elseif ($score2 < 0) $score2 = 0;
          
        // use log to minimize huge differences
       $score = $score1 * $advanced_values["VIEW"] + $score2 * $advanced_values["SOLD"];
       
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
  // prizes also affect the whole work done: publications/performance/media
    // getdata
    $prizes = $ratedobject->prizes;
    $prcited = $advanced_values["prcited"];
    $prnobel = $advanced_values["prnobel"];
    $prother = $advanced_values["prother"];
    
    foreach ($prizes as $pkey => $pvalue) {
        if (($pvalue == "top10") || ($pvalue == "top5")) $prizecoef += $prcited;
        elseif ($pvalue == "nobel") $prizecoef += $prnobel;
        else $prizecoef += $prother;
    }   
    
    $prizevalue = 1 + $prizecoef;
    $pubCVR = $totalCVR * $prizevalue;
         
       // apply weight
       $pubcoef = $pubfield[0];
       $pubCVR = $pubCVR * $pubcoef;
        
      // return the value!
      return $pubCVR;
 }
 
  function pubscore ($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $pubfields = $cvr_arrays['pubfields'];
    
   $typology = $ratedobject->typology;
   $pubfield = $pubfields[$typology];
  
    // get object data
  
   $articles = $ratedobject->articles;
   $citations = $ratedobject->citations;
   $eigens = $ratedobject->eigens;

   $maxscore = $advanced_values["maxscore"];
      
   
  // CURRENCY FACTOR
    $currency = $ratedobject->currency;
    $currindex = $currencies[$currency];
    // if not set, suppose Big Mac Index = 0.5 (< US Dollar)
    if (!$currindex) $currindex = 0.5;
          
   $count_articles = count($articles);
 
   for ($i = 0; $i < $count_articles; $i++) {
      
      // SCORE
        // guarantee they are integers
      $viewer = intval ($citations[$i]);
        // get earning in US$
      $earning = intval($eigens[$i]) * $currindex;
      
      // loop only if scores are set
    if ($viewer || $earning)  {
        
      // according to Wikipedia - best-selling books
      if (($pubfield[1] == "fiction") || ($pubfield[1] == "written")) $maxview = 100000000;
      elseif (($pubfield[1] == "nonfiction") || ($pubfield[1] == "essay")) $maxview = 50000000;
       // take maximum from science research
      elseif ($pubfield[1] == "patent") $maxview = 30000;
       // "reasonable" (massive!) conference 
      elseif (($pubfield[1] == "conference") || ($pubfield[1] == "course"))  
          $maxview = 1500;
       // massive performances ever
      elseif (($pubfield[1] == "performance") || ($pubfield[1] == "live"))  
          $maxview = 3500000;
       // from Google PageRank
      elseif ($pubfield[1] == "blog") $maxview = 10;
       // most seen in YouTube
      elseif (($pubfield[1] == "audiovisual") || ($pubfield[1] == "music") || ($pubfield[1] == "media")
               || ($pubfield[1] == "art"))  $maxview = 1000000000;
      else $maxview = 1000000000;
      
      // use log only if necessary (not in PageRank)
      if ($maxview > 10) $score1 = log($viewer)/log($maxview) * 100;
      else $score1 = $viewer/$maxview * 100;
      
      // take MaxEarning from e.g. Avatar earnings
      $maxearning = 2000000000;
      $score2 = log($earning)/log($maxearning) * 100;
      
        // Do not allow errors to continue...
          if ($score1 > $maxscore) $score1 = $maxscore;	
          elseif ($score1 < 0) $score1 = 0;
          if ($score2 > $maxscore) $score2 = $maxscore;	
          elseif ($score2 < 0) $score2 = 0;
          
        // use log to minimize huge differences
       $score = $score1 * $advanced_values["VIEW"] + $score2 * $advanced_values["SOLD"];
         // prove numbers are not over- or infraestimated
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
       
          $scores_array[] = $score ;
      }
     }
     //First, select the maximum score in research
        $score = max($scores_array);
        
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
  
      // return the value!
      return $score;
 }
 