<?php
/**
 * CVRank setters
 */
        
// FUNCTION SET values for CVR

    // Set CVR by $branch and $territory (array)
  function set_cvr ($branch="any", $territory="any") {
     
      $defaultvalues = get_defaultvalues();
      
          $advanced_values = $defaultvalues['advanced_values'];
          $edufields = $defaultvalues['edufields'];
          $educountries = $defaultvalues['educountries']; 
          $edudatabases = $defaultvalues['edudatabases'];
          $credtypes = $defaultvalues['credtypes']; 
          $prestypes = $defaultvalues['prestypes']; 
          $hourtypes = $defaultvalues['hourtypes'];  
          $gradetypes = $defaultvalues['gradetypes'];
          $sectors = $defaultvalues['sectors'];
          $workdatabases = $defaultvalues['workdatabases'];
          $wcountries = $defaultvalues['educountries'];
          $currencies = $defaultvalues['currencies'];
          $industryclasses = $defaultvalues['industryclasses'];
          $languages = $defaultvalues['languages'];
          $langgrades = $defaultvalues['langgrades'];
          $langdbs = $defaultvalues['langdbs'];
          $resfields = $defaultvalues['resfields'];
          $pubfields = $defaultvalues['pubfields'];
          $skilltypes = $defaultvalues['skilltypes'];
       
        // edufields
        foreach ($edufields as $edufkey => $edufvalue) {
           if (($edufvalue[2] == $branch) || ($branch == "any")) {
                   $edufvalue[0] = 1;
                   $edufields[$edufkey] = $edufvalue;
           }
        }
        
        // educountries and workcountries
       foreach ($educountries as $educkey => $educvalue) {
           if (($educkey == $territory) || (in_array($territory, $educvalue)) || ($territory == "any")) {
              $educvalue[0] = 1;
              $educountries[$educkey] = $educvalue;
              $wcountries[$educkey] = $educvalue;
           }
       }
       
       foreach ($edudatabases as $edudbkey => $edudbvalue) {
           if ( ($edudbvalue[11] == $territory) || ($edudbvalue[11] == "inter")  ) {
              $edudbvalue[0] = 1;
              $edudatabases[$edudbkey] = $edudbvalue;
           }
       }
        
        // credtypes
       foreach ($credtypes as $edutkey => $edutvalue) {
           // do not take into account transfer credits!
           if ($edutkey != "transfer") {
                         $edutvalue = 1;
                         $credtypes[$edutkey] = $edutvalue;
           }
       }
         
     // prestypes
        foreach ($prestypes as $prestypekey => $prestypevalue) {
           // More value to presence studies
           if ($edutvalue == "Presence") {
                      $prestypevalue = 1;
                      $prestypes[$prestypekey] = $prestypevalue;
           }
           elseif ($edutvalue == "Part-time") {
                      $prestypevalue = 0.9;
                      $prestypes[$prestypekey] = $prestypevalue;
           }
           elseif ($edutvalue == "Hybrid") {
                      $prestypevalue = 0.75;
                      $prestypes[$prestypekey] = $prestypevalue;
           }
           elseif ($edutvalue == "Distance") {
                      $prestypevalue = 0.5;
                      $prestypes[$prestypekey] = $prestypevalue;
           }
           else {
                      $prestypevalue = 0.25;
                      $prestypes[$prestypekey] = $prestypevalue;
           }
        }
        
     // sectors
        foreach ($sectors as $sectorkey => $sectorvalue) {
           if (($sectorvalue[2] == $branch) || ($branch == "any")) {
                      $sectorvalue[0] = 1;
                      $sectors[$sectorkey] = $sectorvalue;
           }
        }
        
     // workcountries are assigned with educountries!
      
     // workdbs
       foreach ($workdatabases as $wdkey => $wdvalue) {
           if (
               ( ($wdvalue[2] == $territory) || ($wdvalue[2] == "inter") ) 
                 &&  ( ($wdvalue[1] == $branch) || ($wdvalue[1] == "any") ) 
                   ) {
              $wdvalue = 1;
              $workdatabases[$wdkey] = $wdvalue;
           }
       }
       
     // sectortypes
        foreach ($industryclasses as $ickey => $icvalue) {
                      $icvalue[0] = 1;
                      $industryclasses[$ickey] = $icvalue;
        }
        
        // languages
       foreach ($languages as $lkey => $lvalue) {
              $lvalue[0] = 1;
              $languages[$lkey] = $lvalue;
       }
       
        //apply weight to appropriate databases
      
        if ($branch == "soc") {
            $langdbs["weber"] = 1;
            $langdbs["forbes"] = 1;
            // also: first language speakers
        }
        elseif (($branch == "tech") || ($branch == "sci") || ($branch == "bio")) {
            $langdbs["weber"] = 1;
            // also: research language speakers
        }
        // for art, all languages are equally valid
        elseif ($branch == "art") {
            $langdbs["equal"] = 1;
            // also: languages by interest for arts (classical, ancient,...) 
        }
        elseif ($branch == "any") {
            $langdbs["weber"] = 1;
        }
        // research fields
       foreach ($resfields as $rfkey => $rfvalue) {
           if (($rfvalue[2] == $branch) || ($branch == "any")) {
              $rfvalue[0] = 1;
              $resfields[$rfkey] = $rfvalue;
           }
       }
       
        // publication typologies
       foreach ($pubfields as $pfkey => $pfvalue) {
           if (($pfvalue[2] == "any") || ($branch == "art") || ($branch == "any")) {
              $pfvalue[0] = 1;
              $pubfields[$pfkey] = $pfvalue;
           }
       }
       
        // skills
       foreach ($skilltypes as $skkey => $skvalue) {
           if (($skvalue[1] == $branch) || ($branch == "any")) {
              $skvalue[0] = 1;
              $skilltypes[$skkey] = $skvalue;
           }
       }
       
      $cvr_arrays = array (
         'advanced_values' => $advanced_values, 
         'edufields' => $edufields, 
         'educountries' => $educountries, 
         'edudatabases' => $edudatabases, 
         'credtypes' => $credtypes, 
         'prestypes' => $prestypes,
         'hourtypes' => $hourtypes,   
         'gradetypes' => $gradetypes,
         'sectors' => $sectors,
         'wcountries' => $wcountries,
         'workdatabases' => $workdatabases,
         'currencies' => $currencies,
         'industryclasses' => $industryclasses,
         'languages' => $languages,
         'langgrades' => $langgrades,
         'langdbs' => $langdbs,
         'resfields' => $resfields,
         'pubfields' => $pubfields,
         'skilltypes' => $skilltypes,
          );
      
      return $cvr_arrays;
  }

  // SET default
  function set_defaultcvr () {
     
      $defaultvalues = get_defaultvalues();
      
          $advanced_values = $defaultvalues['advanced_values'];
          $edufields = $defaultvalues['edufields'];
          $educountries = $defaultvalues['educountries']; 
          $edudatabases = $defaultvalues['edudatabases'];
          $credtypes = $defaultvalues['credtypes']; 
          $prestypes = $defaultvalues['prestypes']; 
          $hourtypes = $defaultvalues['hourtypes'];  
          $gradetypes = $defaultvalues['gradetypes'];
          $sectors = $defaultvalues['sectors'];
          $workdatabases = $defaultvalues['workdatabases'];
          $wcountries = $defaultvalues['educountries'];
          $currencies = $defaultvalues['currencies'];
          $industryclasses = $defaultvalues['industryclasses'];
          $languages = $defaultvalues['languages'];
          $langgrades = $defaultvalues['langgrades'];
          $langdbs = $defaultvalues['langdbs'];
          $resfields = $defaultvalues['resfields'];
          $pubfields = $defaultvalues['pubfields'];
          $skilltypes = $defaultvalues['skilltypes'];
       
        // edufields
       foreach ($edufields as $edufkey => $edufvalue) {
              $edufvalue[0] = 1;
              $edufields[$edufkey] = $edufvalue;
        }
        
        // educountries
       foreach ($educountries as $educkey => $educvalue) {
              $educvalue[0] = 1;
              $educountries[$educkey] = $educvalue;
       }
       
        //apply weight to STANDARD databases!!
        $edudatabases['CVR_QS12'][0] = 1;
        //$edudatabases['CVR_PISA09'][0] = 1;
        
        // credtypes
       foreach ($credtypes as $edutkey => $edutvalue) {
                         $edutvalue = 1;
                         $credtypes[$edutkey] = $edutvalue;
       }
         
     // prestypes
        foreach ($prestypes as $prestypekey => $prestypevalue) {
                      $prestypevalue = 1;
                      $prestypes[$prestypekey] = $prestypevalue;
        }
        
     // prestypes
        foreach ($sectors as $sectorkey => $sectorvalue) {
                      $sectorvalue[0] = 1;
                      $sectors[$sectorkey] = $sectorvalue;
        }
        
       foreach ($workdatabases as $wdkey => $wdvalue) {
              $wdvalue = 1;
              $workdatabases[$wdkey] = $wdvalue;
       }
       
        // work countries
       foreach ($wcountries as $wckey => $wcvalue) {
              $wcvalue[0] = 1;
              $wcountries[$wckey] = $wcvalue;
       }
       
        foreach ($industryclasses as $ickey => $icvalue) {
                      $icvalue[0] = 1;
                      $industryclasses[$ickey] = $icvalue;
        }
        
        // languages
       foreach ($languages as $lkey => $lvalue) {
              $lvalue[0] = 1;
              $languages[$lkey] = $lvalue;
       }
       
        //apply weight to STANDARD databases!!
      
        $langdbs["weber"] = 1;
      
        // research fields
       foreach ($resfields as $rfkey => $rfvalue) {
              $rfvalue[0] = 1;
              $resfields[$rfkey] = $rfvalue;
       }
       
        // publication typologies
       foreach ($pubfields as $pfkey => $pfvalue) {
              $pfvalue[0] = 1;
              $pubfields[$pfkey] = $pfvalue;
       }
       
        // skills
       foreach ($skilltypes as $skkey => $skvalue) {
              $skvalue[0] = 1;
              $skilltypes[$skkey] = $skvalue;
       }
       
      $cvr_arrays = array (
         'advanced_values' => $advanced_values, 
         'edufields' => $edufields, 
         'educountries' => $educountries, 
         'edudatabases' => $edudatabases, 
         'credtypes' => $credtypes, 
         'prestypes' => $prestypes,
         'hourtypes' => $hourtypes,   
         'gradetypes' => $gradetypes,
         'sectors' => $sectors,
         'wcountries' => $wcountries,
         'workdatabases' => $workdatabases,
         'currencies' => $currencies,
         'industryclasses' => $industryclasses,
         'languages' => $languages,
         'langgrades' => $langgrades,
         'langdbs' => $langdbs,
         'resfields' => $resfields,
         'pubfields' => $pubfields,
         'skilltypes' => $skilltypes,
          );
      
      return $cvr_arrays;
  }
  
  function set_cvrvalues ($cvrpreferences) {
     
      $defaultvalues = get_defaultvalues();
      
          $advanced_values = $defaultvalues['advanced_values'];
          $edufields = $defaultvalues['edufields'];
          $educountries = $defaultvalues['educountries']; 
          $edudatabases = $defaultvalues['edudatabases'];
          $credtypes = $defaultvalues['credtypes']; 
          $prestypes = $defaultvalues['prestypes']; 
          $hourtypes = $defaultvalues['hourtypes'];  
          $gradetypes = $defaultvalues['gradetypes'];
          $sectors = $defaultvalues['sectors'];
          $workcountries = $defaultvalues['educountries'];
          $workdatabases = $defaultvalues['workdatabases'];
          $currencies = $defaultvalues['currencies'];
          $industryclasses = $defaultvalues['industryclasses'];
          $languages = $defaultvalues['languages'];
          $langgrades = $defaultvalues['langgrades'];
          $langdbs = $defaultvalues['langdbs'];
          $resfields = $defaultvalues['resfields'];
          $pubfields = $defaultvalues['pubfields'];
          $skilltypes = $defaultvalues['skilltypes'];
          
      // // Proof  if user wants to use advanced features
      if ($cvrpreferences->advancedbool) {
          // If so, substitute advanced weights 
          $advanceds_array = $cvrpreferences->advanceds;
         if (!is_array ($advanceds_array)) $advanceds_array = array(0=>$advanceds_array);
          $aweights_array = $cvrpreferences->aweights;
          $count_ad = count($advanceds_array);
          
  // We might want to test certain weights before assigning them...
          
          for ($i = 0; $i < $count_ad; $i++) {
            // In $advanced_values, assign to key the value $i from aweights
               $advanced_values[$advanceds_array[$i]] = $aweights_array[$i];
          }
       }
       
    // edufields, sectors
       // get data
       $fweights = $cvrpreferences->fweights;
       $sweights = $cvrpreferences->sweights;
       
      for( $i = 0; $i < 3; $i++ ) {
 //  ATTENTION - THE FOLLOWING WILL OVERRIDE THE PREVIOUS WEIGHTING
         $fieldi = 'fields'.$i;
         $fields_array = $cvrpreferences->$fieldi;
         // if not array, convert to array (TEMPORARY FIX)
         if (!is_array ($fields_array)) $fields_array = array(0=>$fields_array);
         $fweight = $fweights[$i];
         // if set, convert weights 0-100 to 0-1 scale
         if ($fweight) $fweight = $fweight/100;
         if ($fields_array && $fweight) {
            foreach ($fields_array as $fieldkey => $fieldvalue) {
            // apply weight to all keys selected from $edufields array
              if ($fieldvalue == "any") {
                // apply weight to all $edufields array
                foreach ($edufields as $edufkey => $edufvalue) {
                $edufvalue[0] = $fweight;
                $edufields[$edufkey] = $edufvalue;
                }
              }
              $edufields[$fieldvalue][0] = $fweight;
            } 
         }
         // sectors
         $sectori = 'sectors'.$i;
         $sectors_array = $cvrpreferences->$sectori;
         // if not array, convert to array (TEMPORARY FIX)
         if (!is_array ($sectors_array)) $sectors_array = array(0=>$sectors_array);
         $sweight = $sweights[$i];
         // if set, convert weights 0-100 to 0-1 scale
         if ($sweight) $sweight = $sweight/100;
         if ($sectors_array && $sweight) {
            foreach ($sectors_array as $sectorkey => $sectorvalue) {
            // apply weight to all keys selected from $edufields array
              if ($sectorvalue == "any") {
                // apply weight to all $edufields array
                foreach ($sectors as $skey => $svalue) {
                $svalue[0] = $sweight;
                $sectors[$skey] = $svalue;
                }
              }
                     
              $sectors[$sectorvalue][0] = $sweight;
            }
             
         }
       }
      
  //get data
       // Edu
   $cweights = $cvrpreferences->cweights;
   $eweights = $cvrpreferences->eweights;
   $crweights = $cvrpreferences->crweights;
   $etweights = $cvrpreferences->etweights;
       // Work
   $wcweights = $cvrpreferences->wcweights;
   $wweights = $cvrpreferences->wweights;
   $stweights = $cvrpreferences->stweights;
       // Lang
   $lweights = $cvrpreferences->lweights;
       // Res
   $rfweights = $cvrpreferences->rfweights;
   $pfweights = $cvrpreferences->pfweights;
   $skweights = $cvrpreferences->skweights;
   
         for( $i = 0; $i < 2; $i++ ) {
 //  ATTENTION - THE FOLLOWING WILL OVERRIDE THE PREVIOUS WEIGHTING
   // Edu
   $countryi = 'countries'.$i;
   $edudbi = 'edudbs'.$i;
   $credittypei = 'credittypes'.$i;
   $edutypei = 'edutypes'.$i;
   
   $countries_array = $cvrpreferences->$countryi;
   $edudbs_array = $cvrpreferences->$edudbi;
   $credittypes_array = $cvrpreferences->$credittypei;
   $edutypes_array = $cvrpreferences->$edutypei;
   
   // Work
   $wcountryi = 'wcountries'.$i;
   $workdbi = 'workdbs'.$i;
   $sectortypei = 'sectortypes'.$i;
   
   $wcountries_array = $cvrpreferences->$wcountryi;
   $workdbs_array = $cvrpreferences->$workdbi;
   $sectortypes_array = $cvrpreferences->$sectortypei;
   
   // Lang
   $languagei = 'languages'.$i;
   $langdbi = 'langdbs'.$i;
   
   $languages_array = $cvrpreferences->$languagei;
   $langdbs_array = $cvrpreferences->$langdbi;
   
   // Research
   $resfieldi = 'resfields'.$i;
   $resfields_array = $cvrpreferences->$resfieldi;
   // Publications
   $pubfieldi = 'pubfields'.$i;
   $pubfields_array = $cvrpreferences->$pubfieldi;
   // Skills
   $skilltypei = 'skilltypes'.$i;
   $skilltypes_array = $cvrpreferences->$skilltypei;
   
     // if not array, convert to array (TEMPORARY FIX)
         if (!is_array ($countries_array)) $countries_array = array(0=>$countries_array);
         if (!is_array ($edudbs_array)) $edudbs_array = array(0=>$edudbs_array);
         if (!is_array ($credittypes_array)) $credittypes_array = array(0=>$credittypes_array);
         if (!is_array ($edutypes_array)) $edutypes_array = array(0=>$edutypes_array);
         
         if (!is_array ($wcountries_array)) $wcountries_array = array(0=>$wcountries_array);
         if (!is_array ($workdbs_array)) $workdbs_array = array(0=>$workdbs_array);
         if (!is_array ($sectortypes_array)) $sectortypes_array = array(0=>$sectortypes_array);
         
         if (!is_array ($languages_array)) $languages_array = array(0=>$languages_array);
         if (!is_array ($langdbs_array)) $langdbs_array = array(0=>$langdbs_array);
         
         if (!is_array ($resfields_array)) $resfields_array = array(0=>$resfields_array);
         if (!is_array ($pubfields_array)) $pubfields_array = array(0=>$pubfields_array);
         if (!is_array ($skilltypes_array)) $skilltypes_array = array(0=>$skilltypes_array);
   
   $cweight = $cweights[$i];
   $eweight = $eweights[$i];
   $crweight = $crweights[$i];
   $etweight = $etweights[$i];
   
   $wcweight = $wcweights[$i];
   $wweight = $wweights[$i];
   $stweight = $stweights[$i]; 
   
   $lweight = $lweights[$i]; 
   $ldbweight = $ldbweights[$i]; 
   
   $rfweight = $rfweights[$i]; 
   $pfweight = $pfweights[$i];
   $skweight = $skweights[$i];  
   
   // if set, convert weights 0-100 to 0-1 scale
   if($cweight) $cweight = $cweight/100;
   if($eweight) $eweight = $eweight/100;
   if($crweight) $crweight = $crweight/100;
   if($etweight) $etweight =  $etweight/100;
   
   if($wcweight) $wcweight = $wcweight/100;
   if($wweight) $wweight = $wweight/100;
   if($stweight) $stweight = $stweight/100;
   
   if($lweight) $lweight = $lweight/100;
   if($ldbweight) $ldbweight = $ldbweight/100;
   
   if($rfweight) $rfweight = $rfweight/100;
   if($pfweight) $pfweight = $pfweight/100;
   if($skweight) $skweight = $skweight/100;
   
     // educountries
         if ($countries_array && $cweight) {
            // apply weight to all $educountries array
               foreach ($countries_array as $countrykey => $countryvalue) {
                   if ($countryvalue == "any") {
                       foreach ($educountries as $educkey => $educvalue) {
                          $educvalue[0] = $cweight;
                          $educountries[$educkey] = $educvalue;
                       }
                   }
            // apply weight to all selected from $edufields array
                   $educountries[$countryvalue][0] = $cweight;
               }
         }
         
     // edudatabases
         if ($edudbs_array && $eweight) {
            foreach ($edudbs_array as $edudkey => $edudvalue) {
             // apply weight to all keys selected from $edufields array
                    if ($edudvalue == "any") {
                       //apply weight to STANDARD databases!!
                       $edudatabases['CVR_QS12'][0] = $eweight;
                       //$edudatabases['CVR_PISA09'][0] = $eweight;
                     }
                   $edudatabases[$edudvalue][0] = $eweight;
            }
         }
         
     // credtypes
         if ($credittypes_array && $crweight) {
               foreach ($credittypes_array as $credtypekey => $credtypevalue) {
                  if ($credtypevalue == "any") {
                     foreach ($credtypes as $edutkey => $edutvalue) {
                         $edutvalue = $crweight;
                         $credtypes[$edutkey] = $edutvalue;
                     }
                  }
                  $credtypes[$credtypevalue] = $crweight;
               }
         }
         
     // prestypes
         if ($edutypes_array && $etweight) {
             foreach ($edutypes_array as $edutypekey => $edutypevalue) {
               if ($edutypevalue == "any") {  
                  foreach ($prestypes as $prestypekey => $prestypevalue) {
                      $prestypevalue = $etweight;
                      $prestypes[$prestypekey] = $prestypevalue;
                  }
               }
               $prestypes[$edutypevalue] = $etweight;
             }
         }
         
      // workcountries
         if ($wcountries_array && $wcweight) {
            // apply weight to all $educountries array
               foreach ($wcountries_array as $wcountrykey => $wcountryvalue) {
                   if ($wcountryvalue == "any") {
                       foreach ($workcountries as $wckey => $wcvalue) {
                          $wcvalue[0] = $wcweight;
                          $workcountries[$wckey] = $wcvalue;
                       }
                   }
            // apply weight to all selected from $edufields array
                   $workcountries[$wcountryvalue][0] = $wcweight;
               }
         }
         
     // workdatabases
         if ($workdbs_array && $wweight) {
            foreach ($workdbs_array as $workdkey => $workdvalue) {
             // apply weight to all keys selected from $edufields array
                    if ($workdvalue == "any") {
                       foreach ($workdatabases as $wdbkey => $wdbvalue) {
                          $wdbvalue = $wweight;
                          $workdatabases[$wdbkey] = $wdbvalue;
                       }
                     }
                   $workdatabases[$wdbvalue] = $wweight;
            }
         }
     // sectortypes AKA industryclasses
         if ($sectortypes_array && $stweight) {
             foreach ($sectortypes_array as $sectortypekey => $sectortypevalue) {
               if ($sectortypevalue == "any") {  
                  foreach ($sectortypes as $sectypekey => $sectypevalue) {
                      $sectypevalue[0] = $stweight;
                      $sectortypes[$sectypekey] = $sectypevalue;
                  }
               }
               $sectortypes[$sectortypevalue][0] = $stweight;
             }
         }
         
     // languages
         if ($languages_array && $lweight) {
             foreach ($languages_array as $langarrkey => $langarrvalue) {
               if ($langarrvalue == "any") {  
                  foreach ($languages as $langkey => $langvalue) {
                      $langvalue[0] = $lweight;
                      $languages[$langkey] = $langvalue;
                  }
               }
               $languages[$langarrvalue][0] = $lweight;
             }
         }
         
     // langdbs
         if ($langdbs_array && $ldbweight) {
             foreach ($langdbs_array as $ldbarrkey => $ldbarrvalue) {
               if ($ldbarrvalue == "any") {  
                  foreach ($langdbs as $ldbkey => $ldbvalue) {
                      $ldbvalue = $ldbweight;
                      $langdbs[$ldbkey] = $ldbvalue;
                  }
               }
               $langdbs[$ldbarrvalue] = $ldbweight;
             }
         }
         
     // resfields
         if ($resfields_array && $rfweight) {
             foreach ($resfields_array as $rfarrkey => $rfarrvalue) {
               if ($rfarrvalue == "any") {  
                  foreach ($resfields as $rfkey => $rfvalue) {
                      $rfvalue[0] = $rfweight;
                      $resfields[$rfkey] = $rfvalue;
                  }
               }
               $resfields[$rfarrvalue][0] = $rfweight;
             }
         }
         
     // pubfields
         if ($pubfields_array && $pfweight) {
             foreach ($pubfields_array as $pfarrkey => $pfarrvalue) {
               if ($pfarrvalue == "any") {  
                  foreach ($pubfields as $pfkey => $pfvalue) {
                      $pfvalue[0] = $pfweight;
                      $pubfields[$pfkey] = $pfvalue;
                  }
               }
               $pubfields[$pfarrvalue][0] = $pfweight;
             }
         }
         
     // skills
         if ($skilltypes_array && $skweight) {
             foreach ($skilltypes_array as $skillarrkey => $skillarrvalue) {
               if ($skillarrvalue == "any") {  
                  foreach ($skilltypes as $skillkey => $skillvalue) {
                      $skillvalue[0] = $skweight;
                      $skilltypes[$skillkey] = $skillvalue;
                  }
               }
               $skilltypes[$skillarrvalue][0] = $skweight;
             }
         }
      // end For loop
       }
     
      $cvr_arrays = array (
         'advanced_values' => $advanced_values, 
         'edufields' => $edufields, 
         'educountries' => $educountries, 
         'edudatabases' => $edudatabases, 
         'credtypes' => $credtypes, 
         'prestypes' => $prestypes,
         'hourtypes' => $hourtypes,   
         'gradetypes' => $gradetypes,
         'sectors' => $sectors,
         'wcountries' => $wcountries,
         'workdatabases' => $workdatabases,
         'currencies' => $currencies,
         'industryclasses' => $industryclasses,
         'languages' => $languages,
         'langgrades' => $langgrades,
         'langdbs' => $langdbs,
         'resfields' => $resfields,
         'pubfields' => $pubfields,
         'skilltypes' => $skilltypes,
          );
      return $cvr_arrays;
      
  }