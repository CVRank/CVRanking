<?php
/**
 * CVRank language
 */

/**
 * @todo : define $langrades, and make use of it in langcvrate() and langscore()
 */

	/**
	 * Function langcvrate() in language
	 */

  function langcvrate($ratedobject, $cvr_arrays, $objects_array) {
    
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $languages = $cvr_arrays['languages'];
      $langdbs = $cvr_arrays['langdbs'];
      // To be used more extensively in the future!
      // Equivalent to education letter grades, but for language exams and courses 
      $langgrades = $cvr_arrays['langgrades'];
    
  // LANGUAGE 
   $lang_id = $ratedobject->language;
   
   // LANGUAGE rating - Weber val
  // ToDO: When $langgrades is implemented, use true DBs with exam rankings;
  // e.g. by number of institutions that accept them, prestige,...
  
  // Weber's top ten (1999-2008): http://www.andaman.org/BOOK/reprints/weber/rep-weber.htm
  // Ratings divided by maximum (English - 37 over 40), divided by 100, +1 (points begins at 100%)
  $weberlang = array ("any" => 1, "eng" => 100, "fra" => 62.16, "spa" => 54.05, "rus" => 43.24, "ara" => 37.84,
    "cmn" => 35.13, "deu" => 32.43, "jpn" => 27.03, "por" => 27.03, "hin" => 24.32, "urd" => 24.32, 
    );
  
  // Forbes' increase in wage (max. 4%)
  //  http://www.forbes.com/2008/02/22/popular-foreign-languages-tech-language_sp08-cx_rr_0222foreign.html
  $forbeslang = array ("any" => 1, "fra" => 67.5, "spa" => 42.5, "rus" => 100, "ara" => 100,
    "cmn" => 100, "ita" => 100,
      // for CIA - unknown percentage - take 1 over 4
     "hin" => 25, "urd" => 25, "swa" => 25, "fas" => 25,
     );
  
  $langcount = 0;
   if ($langdbs["weber"] !=0) {
      $weber = $weberlang[$lang_id];
      if (!$weber) $weber = $weberlang["any"];
      $rating += $weber * $langdbs["weber"];
      $langcount++;
    }
   if ($langdbs["forbes"] !=0) {
      $forbes = $forbeslang[$lang_id];
      if (!$forbes) $forbes = $forbeslang["any"];
      $rating += $forbes * $langdbs["forbes"];
      $langcount++;
    }
    // equal: give the same 'middle' value to all
   if ($langdbs["equal"] !=0) {;
      $rating += 50;
      $langcount++;
    }
    // @todo: by Nr. speakers; Nr. 2nd speakers; Combined;
    
   $ratemult = $advanced_values["ratemult"];
   $rateadd = $advanced_values["rateadd"];
   if ($langcount > 0) $netrating = ($rating/$langcount) * $ratemult + $rateadd;
   else $netrating = $rateadd;
   
   $difflang = $advanced_values['difflang'];
   $difficulty = $advanced_values[$difflang];
   
   // CVRANK ALGORITHM
   $z = $advanced_values['z'];
   $B = 1/pow(10, $z + $difficulty + $netrating);

   // SCORING BEGINS
    // get data
   $langtype = $ratedobject->langtype; 
   $maxscore = $advanced_values["maxscore"];
   $minlang1 = $advanced_values["minlang1"];
   $maxlang2 = $advanced_values["maxlang2"];
   
   // if it's mother tongue, maximum score
   // mother tongue 2!
   if ($langtype == "mother") $score = $minlang1;
   elseif ($langtype == "mother2") $score = $minlang2;
   // only if it is foreign (or not set), do calculations
   else {
    $scores = array();
     $scores["listening"] = $ratedobject->listening;
     $scores["reading"] = $ratedobject->reading;
     $scores["spokeninteraction"] = $ratedobject->spokeninteraction;
     $scores["spokenproduction"] = $ratedobject->spokenproduction;
     $scores["writing"] = $ratedobject->writing;
     // ToDo: use like Education letter-to-grades with $langgrades, when it is implemented
   
     foreach ($scores as $skey => $svalue) {
       // Use approx. IELTS/PTE equivalencies, with max. 90 for foreign language
       if ($svalue == "a1") $grade = 10;
       elseif ($svalue == "a2") $grade = 25;
       elseif ($svalue == "b1") $grade = 45;
       elseif ($svalue == "b2") $grade = 60;
       elseif ($svalue == "c1") $grade = 72.5;
       elseif ($svalue == "c2") $grade = 87.5;
       else $grade = 0;
       
       $score += $grade;
     }
     $score = $score/5;
   }
   $experience = $ratedobject->experience;
   $countex = 0;
   if (!$experience) $countex = 0; 
   elseif (!is_array($experience)) {
        $countex = 1;
   }
   else {
      foreach ($experience as $ex) {
          $countex++;
      }
   }
   // there is a maximum of 4 countex, 100/4 = 25
    $explus = $countex * 0.25;
   // plus depends on score (it is a percentage) over 10% of the score
    $explus = $explus * $score/10;
    
    $score = $score + $explus;
    
      // Prove that scores are within limits >=0,
      if (($langtype == "mother") || ($langtype == "mother2")) {
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
      }
      else {
          if ($score > $maxlang2) $score = $maxlang2;	
          elseif ($score < 0) $score = 0;
      }
      
   // Calculate standard years needed
   // Classify languages like the Foreign Service Institute (FSI) of the US Department of State 
   // BUT this must be valid for all speakers, not just English
   // if "Indo-European - Romance", --> Category I
  
      $langfamily = $languages[$lang_id];
      
   // if lang is mother tongue, give std value; no need to loop.
   if (($langtype == "mother") || ($langtype == "mother2")) $IFS = $advanced_values['mother'];
   else {
       // guarantee that $IFS is array
       $IFS = array();
       // get families from all other languages spoken by user
       foreach ($objects_array as $key => $value) {
         $lang2_id = $value->language;
         $lang2_type = $value->langtype;
           // for these calculations, mother2 = mother
           if ($lang2_type == "mother2") $lang2_type = "mother";
         // Loop only if language object is not the same!
         if ($lang2_id != $lang_id) {
           $lang2family = $languages[$lang_id];
           // loop for each subfamily, and prove first that there is a subfamily...
              // if possible, use IFS actual classification. From
              // http://en.wikibooks.org/wiki/Language_Learning_Difficulty_for_English_Speakers
            // only available for Romance - Germanic - Celtic (equivalent to English)
          if (($lang2family[2] == "Romance") || ($lang2family[2] == "Germanic") || ($lang2family[2] == "Celtic")) {
           
           if (($langfamily[2] == "Romance") || ($langfamily[2] == "Germanic") || ($langfamily[2] == "Celtic")) {
               if ($lang_id == "deu") {
                 if ($IFS["langII"] != "mother") $IFS["langII"] = $lang2_type;
               }
               else { if ($IFS["langI"] != "mother") $IFS["langI"] = $lang2_type; }
           }
           
           elseif (($langfamily[2] == "Malayo-Polynesian") || ($langfamily[4] == "Bantu")) {
               if ($IFS["langII"] != "mother") $IFS["langII"] = $lang2_type;
           }
           
           elseif (($langfamily[2] == "Tibeto-Burman") || ($langfamily[1] == "Uralic") 
                || ($langfamily[1] == "Tai-Kadai") || ($langfamily[2] == "Vietic"))  {
               if ($IFS["langIV"] != "mother") $IFS["langIV"] = $lang2_type;
           }
           
           elseif (($lang_id == "ara") || ($langfamily[2] == "Sinitic") 
                || ($lang_id == "jpn") || ($lang_id == "kor") || ($lang_id == "mon"))  {
               if ($IFS["langV"] != "mother") $IFS["langV"] = $lang2_type;
           }
           // for the rest, langIII
           else  {
               if ($IFS["langIII"] != "mother") $IFS["langIII"] = $lang2_type;
           }
           // ?? if the user knew a Germanic-Romance-Celtic lang, break the foreach ??
          }
          // For those whose difficulty is not defined by IFS, use one level less (sanction)!
          else {
             if ($lang2family[1] == $langfamily[1]) {
             if ($IFS["langIII"] != "mother") $IFS["langIII"] = $lang2_type;
                if (($lang2family[2] != 0) && ($lang2family[2] == $langfamily[2])) {
                if ($IFS["langII"] != "mother") $IFS["langII"] = $lang2_type;
                    if  (($lang2family[2] != 0) && ($lang2family[3] == $langfamily[3])) {
                    if ($IFS["langI"] != "mother") $IFS["langI"] = $lang2_type;
                        if  (($lang2family[2] != 0) && ($lang2family[3] == $langfamily[3])) {
                        if ($IFS["lang0"] != "mother") $IFS["lang0"] = $lang2_type;
                        // if it is already the minimum, break foreach
                         elseif ($IFS["lang0"] == "mother"){
                           break;
                         }
                        }
                    }
                }
             }
           }
         }
       } 
       // if it is still not set after all loops, set to maximum
       if (empty($IFS)) $IFS["langIV"] = $lang2_type;
     }
     
     // Now select the minimum from the array:
       if ($IFS["lang0"]) { $langlev = "lang0"; $lang2type = $IFS["lang0"]; }
       elseif ($IFS["langI"]) { $langlev = "langI"; $lang2type = $IFS["langI"]; }
       elseif ($IFS["langII"]) { $langlev = "langII"; $lang2type = $IFS["langII"]; }
       elseif ($IFS["langIII"]) { $langlev = "langIII"; $lang2type = $IFS["langIII"]; }
       elseif ($IFS["langIV"]) { $langlev = "langIV"; $lang2type = $IFS["langIV"]; }
       elseif ($IFS["langV"]) { $langlev = "langV"; $lang2type = $IFS["langV"]; }
       else { $langlev = "lang0"; $lang2type = $IFS["lang0"]; }
       
     $stdyear = $advanced_values[$langlev];
     // put minimum
     if (!$stdyear) $stdyear = 1;
     
     // if we compared lang2, and lang2 was mother tongue, lessen difficulty:
     $stdmother2 = $advanced_values["mother2"];
     if ($lang2type == "mother") $stdyear = $stdyear * $stdmother2;
     else $stdyear = $stdyear * $stdforeign2;
  
           // calculate subject's CVR
	   $probability = $score/100;
           $CVR = 1/$B * ($probability / (1 - $probability) );
                
        $totalCVR = $CVR * $stdyear;
        
         // apply weight
        $langcoef = $languages[$lang_id][0];
        $langCVR = $totalCVR * $langcoef;
        
      // return the value!
      return $langCVR;
 }
 
 function langscore ($ratedobject, $cvr_arrays) {
    
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      // To be used more extensively in the future!
      // Equivalent to education letter grades, but for language exams and courses 
   // $langgrades = $cvr_arrays['langgrades'];
   
   $langtype = $ratedobject->langtype; 
   $maxscore = $advanced_values["maxscore"];
   $minlang1 = $advanced_values["minlang1"];
   $maxlang2 = $advanced_values["maxlang2"];
   
   // if it's mother tongue, maximum score
   if ($langtype == "mother") $score = $minlang1;
   // only if it is foreign (or not set), do calculations
   else {
    $scores = array();
     $scores["listening"] = $ratedobject->listening;
     $scores["reading"] = $ratedobject->reading;
     $scores["spokeninteraction"] = $ratedobject->spokeninteraction;
     $scores["spokenproduction"] = $ratedobject->spokenproduction;
     $scores["writing"] = $ratedobject->writing;
     // ToDo: use like Education letter-to-grades with $langgrades, when it is implemented
   
     foreach ($scores as $skey => $svalue) {
       // Use approx. IELTS/PTE equivalencies, with max. 90 for foreign language
       if ($svalue == "a1") $grade = 10;
       elseif ($svalue == "a2") $grade = 25;
       elseif ($svalue == "b1") $grade = 45;
       elseif ($svalue == "b2") $grade = 60;
       elseif ($svalue == "c1") $grade = 72.5;
       elseif ($svalue == "c2") $grade = 87.5;
       else $grade = 0;
       
       $score += $grade;
     }
     $score = $score/5;
   }
   $experience = $ratedobject->experience;
   $countex = 0;
   if (!$experience) $countex = 0; 
   elseif (!is_array($experience)) {
        $countex = 1;
   }
   else {
      foreach ($experience as $exvalue) {
          $countex++;
      }
   }
   // there is a maximum of 4 countex, 100/4 = 25
    $explus = $countex * 0.25;
   // plus depends on score (it is a percentage) over 10% of the score
    $explus = $explus * $score/10;
    
    $score = $score + $explus;
    
      // Prove that scores are within limits >=0,
      if ($langtype == "mother") {
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
      }
      else {
          if ($score > $maxlang2) $score = $maxlang2;	
          elseif ($score < 0) $score = 0;
      }
      
      // return the value!
      return $score;
 }
 