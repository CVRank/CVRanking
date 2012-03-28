<?php
/**
 * CVRank cvranking
 */
	/**
	 * Function maximalCVR() for CVR comparisons
	 */

 function maximalCVR($rating, $pageowner, $field, $branch="any") {
   
   $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_cv_rating WHERE field='$field' AND branch='$branch'";
   $performance = get_data_row($query);
   
  if ($performance) {
   	
    if ($performance->rating >= $rating) {
    	
   	    $cvrrank = ((log($rating)) /(log($performance->rating))) * 100;
    }
    
    else { 
  	    $query = "UPDATE {$CONFIG->dbprefix}CVR_cv_rating 
          	  SET rating='$rating', user_id='$pageowner' 
          	  WHERE field='$field' AND branch='$branch'";
              update_data($query);
        $cvrrank = 100;
    }
  }
  else {
  	$query = "INSERT INTO {$CONFIG->dbprefix}CVR_cv_rating 
          	  SET rating='$rating', user_id='$pageowner', field='$field', branch='$branch'";
              insert_data($query);
        $cvrrank = 100;
  }
   
   return $cvrrank;
 }
 
	/**
	 * Function round_two() for CVR bar
	 */
 
 function round_two($number) {
   $float_rounded=round($number * 100) / 100;
   return $float_rounded;
   } 