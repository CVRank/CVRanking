<?php
/**
 * CVRank grade conversion
 */

  // letter to grade function
  function lettertonumber ($grade, $gradetype){
   // converto "," to numeric ".", to avoid problems
    $grade = str_replace(",",".",$grade);
    
   // only if $grade != numeric, 
   if (!is_numeric($grade)) {
     
       // first of all, trim to avoid problems with blank spaces
       $grade = trim($grade);
       
      if ($gradetype == "US4") {
         if ($grade == "A+") $grade = 4;
         elseif ($grade == "A") $grade = 3.8;
         elseif ($grade == "A-") $grade = 3.6;
         elseif ($grade == "B+") $grade = 3.3;
         elseif ($grade == "B") $grade = 3;
         elseif ($grade == "B-") $grade = 2.7;
         elseif ($grade == "C+") $grade = 2.3;
         elseif ($grade == "C") $grade = 2;
         elseif ($grade == "C-") $grade = 1.7;
         elseif ($grade == "D+") $grade = 1.4;
         elseif ($grade == "D") $grade = 1.2;
         elseif ($grade == "D-") $grade = 1;
         // else: grade == E, F, N, U,...
         else $grade = 0.5;
      }
      
      elseif ($gradetype == "US5") {
          if ($grade == "A+") $grade = 5;
          elseif ($grade == "A") $grade = 4.8;
          elseif ($grade == "A-") $grade = 4.6;
          elseif ($grade == "B+") $grade = 4.3;
          elseif ($grade == "B") $grade = 4;
          elseif ($grade == "B-") $grade = 3.7;
          elseif ($grade == "C+") $grade = 3.3;
          elseif ($grade == "C") $grade = 3;
          elseif ($grade == "C-") $grade = 2.7;
          elseif ($grade == "D+") $grade = 2.4;
          elseif ($grade == "D") $grade = 2.2;
          elseif ($grade == "D-") $grade = 2;
          // else: grade == E, F, N, U,...
          else $grade = 1;
      }
      
      elseif ($gradetype == "US9") {
          if ($grade == "A+") $grade = 9;
          elseif ($grade == "A") $grade = 8;
          elseif ($grade == "A-") $grade = 7;
          elseif ($grade == "B+") $grade = 6;
          elseif ($grade == "B") $grade = 5;
          elseif ($grade == "B-") $grade = 4;
          elseif ($grade == "C+") $grade = 3;
          elseif ($grade == "C") $grade = 2;
          elseif ($grade == "C-") $grade = 1;
          else $grade = 0;
      }
      
      elseif ($gradetype == "US10") {
          if ($grade == "A+") $grade = 10;
          elseif ($grade == "A") $grade = 9;
          elseif ($grade == "A-") $grade = 8;
          elseif ($grade == "B+") $grade = 7;
          elseif ($grade == "B") $grade = 6;
          elseif ($grade == "B-") $grade = 5;
          elseif ($grade == "C+") $grade = 4;
          elseif ($grade == "C") $grade = 3;
          elseif ($grade == "C-") $grade = 2;
          elseif ($grade == "D+") $grade = 1;
          else $grade = 0;
      }
      
      // UK according to the Fullbright commision
      elseif ($gradetype == "UK") {
         if ($grade == "1st*") $grade = 95;
         elseif ($grade == "1st") $grade = 85;
         elseif ($grade == "2:1") $grade = 65;
         elseif ($grade == "2:2") $grade = 55;
         elseif ($grade == "3rd") $grade = 45;
         elseif ($grade == "Pass") $grade = 37.5;
         else $grade = 20;
      } 
      
      elseif ($gradetype == "GCSE") {
         if ($grade == "A*") $grade = 95;
         elseif ($grade == "A") $grade = 85;
         elseif ($grade == "B") $grade = 75;
         elseif ($grade == "C") $grade = 65;
         elseif ($grade == "D") $grade = 55;
         elseif ($grade == "E") $grade = 45;
         elseif ($grade == "F") $grade = 35;
         elseif ($grade == "G") $grade = 25;
         else $grade = 10;
      }
      
      // Grades are given in statistical terms
      // Taken Equivalence to UK system (Wikipedia)
      elseif ($gradetype == "ECTS") {
         if ($grade == "A") $grade = 85;
         elseif ($grade == "B") $grade = 75;
         elseif ($grade == "C") $grade = 65;
         elseif ($grade == "D") $grade = 55;
         elseif ($grade == "E") $grade = 45;
         elseif ($grade == "FX") $grade = 35;
         else $grade = 15;
      }
      
      // A (85-100): Yōuxiù; B (75-84): Liánghǎo; C (65-74): Zhōngděng; D (60-64)...
      elseif ($gradetype == "China") {
          if ($grade == "A") $grade = 95;
          elseif ($grade == "A-") $grade = 87.5;
          elseif ($grade == "B") $grade = 82.5;
          elseif ($grade == "B-") $grade = 77.5;
          elseif ($grade == "C") $grade = 72.5;
          elseif ($grade == "C-") $grade = 67.5;
          elseif ($grade == "D") $grade = 62.5;
          elseif ($grade == "下") $grade = 32.5;
          elseif ($grade == "F") $grade = 30;
          else $grade = 0;
      }
      
      // Equivalences to ECTS, taken from Wikipedia
      elseif ($gradetype == "Denmark") {
         if ($grade == "12") $grade = 85;
         elseif ($grade == "10") $grade = 75;
         elseif ($grade == "7") $grade = 65;
         elseif ($grade == "4") $grade = 55;
         elseif ($grade == "02") $grade = 45;
         elseif ($grade == "00") $grade = 35;
         else $grade = 15;
      }
      
       // A (90-100): shū, B (80-89): yū, C (70-79): ryō, D (60-69): ka...
      elseif ($gradetype == "Japan6") {
         if (($grade == "秀") || ($grade == "A")) $score = 95;
         elseif (($grade == "優") || ($grade == "B")) $score = 85;
         elseif (($grade == "良") || ($grade == "C")) $score = 75;
         elseif (($grade == "可") || ($grade == "D")) $score = 65;
         elseif (($grade == "認") || ($grade == "E")) $score = 55;
         elseif (($grade == "不可") || ($grade == "F")) $score = 25;
         else $score = 0;
      }
      
      // A (80-100): yū, B (70-79): ryō, C (60-69): ka, F (0-59)
      elseif ($gradetype == "Japan4") {
         if (($grade == "優") || ($grade == "A")) $score = 90;
         elseif (($grade == "良") || ($grade == "B")) $score = 75;
         elseif (($grade == "可") || ($grade == "C")) $score = 65;
         elseif (($grade == "不可") || ($grade == "F")) $score = 30;
         else $score = 0;
      }   
      
      // A-D (with or without 1-3)
      elseif ($gradetype == "Ireland2") {
          if ($grade == "A1") $grade = 95;
          elseif ($grade == "A") $grade = 92.5;
          elseif ($grade == "A2") $grade = 87.5;
          elseif ($grade == "B1") $grade = 82.5;
          elseif (($grade == "B2") || ($grade =="B")) $grade = 77.5;
          elseif ($grade == "B3") $grade = 72.5;
          elseif ($grade == "C1") $grade = 67.5;
          elseif (($grade == "C2") || ($grade =="C")) $grade = 65;
          elseif ($grade == "C3") $grade = 57.5;
          elseif ($grade == "D1") $grade = 52.5;
          elseif (($grade == "D2") || ($grade =="D")) $grade = 47.5;
          elseif ($grade == "D3") $grade = 42.5;
          elseif ($grade == "E") $grade = 32.5;
          elseif ($grade == "F") $grade = 17.5;
          elseif ($grade == "NG") $grade = 5;
          else $grade = 0;
      }  
      
       // A/I (70-100), B/II.1 (60-69), C/II.2 (50-59%), D/III (40-49), F1/E (30-39), F2/F (<29)a...
      elseif ($gradetype == "Ireland3") {
         if (($grade == "I") || ($grade == "A")) $score = 85;
         elseif (($grade == "II.1") || ($grade == "B")) $score = 65;
         elseif (($grade == "II.2") || ($grade == "C")) $score = 55;
         elseif (($grade == "III") || ($grade == "D")) $score = 45;
         elseif (($grade == "F1") || ($grade == "E")) $score = 35;
         elseif (($grade == "F2") || ($grade == "F")) $score = 15;
         else $score = 0;
      } 
   }
      
      // Return value: either the new numeric value, or leave numeric as it was
      return $grade;
  }
  
  function scoring_scale ($grade, $scale) {
   if (is_string($scale)) {
    if ($scale == "US4") { 
      if ($grade >= 3.5) {
          // of interval 0-0.5, turn it into 90-100
          // if > 4.0, will get more than 100 (but later cut)
          $score = (($grade - 3.5) * 2 * 10 ) + 90;
      }
      elseif ($grade >= 1.5) {
          // of interval 0-1.99, turn it into 70-89.99
          $score = (($grade - 1.5) * 10) + 70;
      }
      elseif ($grade >= 1) {
          // of interval 0-0.49, turn it into 60-69.99
          $score = (($grade - 1) * 2 * 10 ) + 60;
      }
      else {
          // from 0-0.99 convert into 0-59.99
          $score = (($grade) * 60);
      }
    }
    if ($scale == "US5") { 
      if ($grade >= 4.5) {
          // of interval 0-0.5, turn it into 90-100
          // if > 4.0, will get more than 100 (but later cut)
          $score = (($grade - 4.5) * 2 * 10 ) + 90;
      }
      elseif ($grade >= 3.5) {
          // of interval 0-0.99, turn it into 80-89.99
          $score = (($grade - 3.5) * 10) + 80;
      }
      elseif ($grade >= 2.5) {
          // of interval 0-1.99, turn it into 75-79.99
          $score = (($grade - 2.5)/2 * 10) + 75;
      }
      elseif ($grade >= 2) {
          // of interval 0-0.49, turn it into 70-74.99
          $score = (($grade - 2) * 10 ) + 70;
      }
      else {
          // from 0-1.99 convert into 0-69
          $score = (($grade)/2 * 70);
      }
    }
    if ($scale == "US9") { 
      if ($grade >= 7) {
          // of interval 0-2, turn it into 90-100
          $score = (($grade - 7)/2 * 10 ) + 90;
      }
      elseif ($grade >= 4) {
          // of interval 0-2.99, turn it into 80-89
          $score = (($grade - 4)/3 * 10) + 80;
      }
      elseif ($grade >= 1) {
          // of interval 0-2.99, turn it into 75-79
          $score = ((($grade - 1)/3)/2 * 10) + 75;
      }
      else {
          // from 0-1 convert into 0-74
          $score = $grade * 74;
      }
    }
  
    if ($scale == "US10") { 
      if ($grade >= 8) {
          // of interval 0-2, turn it into 90-100
          $score = (($grade - 8)/2 * 10 ) + 90;
      }
      elseif ($grade >= 5) {
          // of interval 0-2.99, turn it into 80-89
          $score = (($grade - 5)/3 * 10) + 80;
      }
      elseif ($grade >= 2) {
          // of interval 0-2.99, turn it into 75-79
          $score = ((($grade - 2)/3)/2 * 10) + 75;
      }
      elseif ($grade >= 1) {
          // of interval 0-1, turn it into 77.5-79
          $score = ((($grade - 1)/2)/2 * 10) + 77.5;
      }
      else {
          // from 0-1 convert into 0-77.5
          $score = $grade * 77.5;
      }
    }
    if ($scale == "US42") { 
      if ($grade >= 3.5) {
          // of interval 0-0.5, turn it into 93-100
          // if > 4.0, will get more than 100 (but later cut)
          $score = (($grade - 3.5) * 2 * 7 ) + 93;
      }
      elseif ($grade >= 2.5) {
          // of interval 0-1, turn it into 87-92
          $score = (($grade - 2.5)/2 * 10) + 87;
      }
      elseif ($grade >= 1.5) {
          // of interval 0-0.99, turn it into 75-86.99
          $score = (($grade - 1.5) * 12 ) + 75;
      }
      elseif ($grade >= 1) {
          // of interval 0-0.49, turn it into 70-74.99
          $score = (($grade - 1) * 10 ) + 75;
      }
      else {
          // from 0-0.99 convert into 0-69
          $score = (($grade) * 70);
      }
    }
    if ($scale == "US52") { 
      if ($grade >= 4.5) {
          $score = (($grade - 4.5) * 2 * 7 ) + 93;
      }
      elseif ($grade >= 3.5) {
          $score = (($grade - 3.5)/2 * 10) + 87;
      }
      elseif ($grade >= 2.5) {
          $score = (($grade - 2.5) * 12) + 75;
      }
      elseif ($grade >= 2) {
          $score = (($grade - 2) * 10 ) + 70;
      }
      else {
          // from 0-1.99 convert into 0-69
          $score = (($grade)/2 * 70);
      }
    }
    if ($scale == "UK") { 
  // UK Equivalence to US scale (Fullbright, ECTS scale)
  // 1st = A = 4.0 = 93-100
  // 2:1 = A-/B+ = 3.33-3.67 = 87-92.9
  // 2:2 = B = 3.00 = 80-86.9
  // 3rd = C+ = 2.30 = 77-79.9
  // Pass = C = 2.00 = 73-76.9
      if ($grade >= 70) {
          // 0-30 into 93-100
          $score = (($grade - 70)/30 * 7 ) + 93;
      }
      elseif ($grade >= 60) {
          // 0-10 into 87-92.99
          $score = (($grade - 60)/10 * 6 ) + 87;
      }
      elseif ($grade >= 50) {
          // 0-10 into 80-86.99
          $score = (($grade - 50)/10 * 7) + 80;
      }
      elseif ($grade >= 40) {
          // 0-10 into 77-79.99
          $score = (($grade - 40)/10 * 3 ) + 77;
      }
      elseif ($grade >= 35) {
          // 0-5 into 73-76.99
          $score = (($grade - 35)/5 * 4 ) + 73;
      }
      else {
          // from 0-34.99 convert into 0-72.99
          $score = (($grade)/35 * 73);
      }
    }
    if ($scale == "GCSE") { 
      if ($grade >= 20) {
          // A-G: 0-80 into 60-100
          $score = (($grade - 20)/2) + 60;
      }
      else {
          // U: from 0-20 convert into 0-60
          $score = $grade * 3;
      }
    }
    if ($scale == "IB") { 
      if ($grade >= 6.5) {
          // 0-0.5 into 93-100
          $score = (($grade - 6.5)/5 * 70) + 93;
      }
      elseif ($grade >= 4.5) {
          // 0-1 into 85-92.99, 0-1 into 77-84.99, 
          $score = (($grade - 4.5) * 8 ) + 77;
      }
      elseif ($grade >= 3.5) {
          // 0-10 into 70-76.99
          $score = (($grade - 3.5) * 7 ) + 70;
      }
      else {
          // 0-3.49 into 0-69.99
          $score = $grade * 20;
      }
    }
    if ($scale == "Germany") { 
      if (($grade == "1+") || ($grade == "15p") || ($grade == "1.0")) $score = 98;
      elseif (($grade == "1") || ($grade == "14p")) $score = 95;
      elseif (($grade == "1-") || ($grade == "13p") || ($grade == "1.3"))  $score = 92;
      elseif (($grade == "2+") || ($grade == "12p") || ($grade == "1.7"))  $score = 88;
      elseif (($grade == "2") || ($grade == "11p") || ($grade == "2.0"))  $score = 85;
      elseif (($grade == "2-") || ($grade == "10p") || ($grade == "2.3"))  $score = 82;
      elseif (($grade == "3+") || ($grade == "9p") || ($grade == "2.7"))  $score = 77;
      elseif (($grade == "3") || ($grade == "8p") || ($grade == "3.0"))  $score = 73;
      elseif (($grade == "3-") || ($grade == "7p") || ($grade == "3.3"))  $score = 67;
      elseif (($grade == "4+") || ($grade == "6p") || ($grade == "3.7"))  $score = 60.5;
      elseif (($grade == "4") || ($grade == "5p") || ($grade == "4.0"))  $score = 53.5;
      elseif (($grade == "4-") || ($grade == "4p"))  $score = 45;
      elseif (($grade == "5+") || ($grade == "3p"))  $score = 35;
      elseif (($grade == "5") || ($grade == "2p") || ($grade == "5.0"))  $score = 25;
      elseif (($grade == "5-") || ($grade == "1p"))  $score = 15;
      elseif (($grade == "6") || ($grade == "0p"))  $score = 5;
    }
    
    if ($scale == "Russia") { 
  // 5 (85-100): отл; 4 (75-84): хор; 3 (50-74): уд; 2 (1-49): неуд; 1 (0)
      if ($grade == "5+") $score = 97.5;
      elseif ($grade == "5") $score = 92.5;
      elseif ($grade == "5-")   $score = 87.5;
      elseif ($grade == "4+")   $score = 83;
      elseif ($grade == "4")   $score = 80;
      elseif ($grade == "4-")   $score = 77;
      elseif ($grade == "3+")  $score = 71;
      elseif ($grade == "3") $score = 62.5;
      elseif ($grade == "3-")  $score = 54;
      elseif ($grade == "2+") $score = 40;
      elseif ($grade == "2")   $score = 25;
      elseif ($grade == "2-")  $score = 10;
      else $score = 0;
    }
    if ($scale == "Poland1") { 
      if ($grade == "6") $score = 99;
      elseif ($grade == "5+") $score = 95;
      elseif ($grade == "5") $score = 90;
      elseif ($grade == "5-") $score = 85;
      elseif ($grade == "4+") $score = 77;
      elseif ($grade == "4") $score = 72.5;
      elseif ($grade == "4-") $score = 68;
      elseif ($grade == "3+") $score = 62;
      elseif ($grade == "3") $score = 57.5;
      elseif ($grade == "3-") $score = 53;
      elseif ($grade == "2+") $score = 45;
      elseif ($grade == "2") $score = 40;
      elseif ($grade == "2-") $score = 35;
      elseif ($grade == "1+") $score = 22.5;
      elseif ($grade == "1") $score = 15;
      elseif ($grade == "1-") $score = 7.5;
      else $score = 0;
    }
    if ($scale == "Poland3") { 
    // Poland: 5.5-6.0 (98-100): celujący; 5.0 (90-98): bardzo dobry; 4.5 (85-90): dobry +;...
     if (($grade == "6.0") || ($grade == "5.5")) $score = 98;
      elseif ($grade == "5.0") $score = 95;
      elseif ($grade == "4.5")  $score = 87.5;
      elseif ($grade == "4.0")  $score = 82.5;
      elseif ($grade == "3.5")  $score = 75;
      elseif ($grade == "3.0")  $score = 65;
      elseif ($grade == "2.0")  $score = 30;
      else $score = 0;
    }
     if ($scale == "inv5") { 
      if ($grade == "1") $score = 5;
      elseif ($grade == "2") $score = 4;
      elseif ($grade == "4") $score = 2;
      elseif ($grade == "5") $score = 1;
     }
   }
     // if it is not string (i.e. numeric):
    else {
      $score = $grade/$scale * 100;
    }
    
      return $score;
  }   
  
  function pass_std ($grade, $pass) {
      // STD for pass = 60%
      $fail = 100 - $pass;
      if ($grade >= $pass) { 
       // convert interval to 60-100
       $score = (($grade - $pass)/$fail * 40 ) + 60;
      }
      else {
      // convert interval to 0-60
       $score = (($grade/$fail) * 60 );
      }
      return $score;
  }
  
  