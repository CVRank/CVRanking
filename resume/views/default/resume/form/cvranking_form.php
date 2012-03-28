<?php
/**
 * cvranking_form
 */

/**
 * @todo : with AJAX : add more user fields with autocomplete functioning, instantly
 * @todo : with $resfields array (when fixed), let users select (for cvranking) ISI fields, not just categories.
 * @todo : use arrays for countries and let user select (for cvranking) groups: EU, commonwealth, CIE,.
 */

$action = "resume/cvranking_add";

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;

	require_once(dirname(dirname(__FILE__)) . "/lib/general.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/education.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/workexperience.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/language.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/research.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/publication.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/skill.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/cvranking_form.php");

  $gweights_array = $vars['entity']->gweights;
  
  $users_array = $vars['entity']->users;
  
  $fweights_array = $vars['entity']->fweights;
  $cweights_array = $vars['entity']->cweights;
  $eweights_array = $vars['entity']->eweights;
  $crweights_array = $vars['entity']->crweights;
  $etweights_array = $vars['entity']->etweights;
  
  $sweights_array = $vars['entity']->sweights;
  $wcweights_array = $vars['entity']->wcweights;
  $wweights_array = $vars['entity']->wweights;
  $stweights_array = $vars['entity']->stweights;
  
  $lweights_array = $vars['entity']->lweights;
  $ldbweights_array = $vars['entity']->ldbweights;
  
  $rfweights_array = $vars['entity']->rfweights;
  $pfweights_array = $vars['entity']->pfweights;
  $skweights_array = $vars['entity']->skweights;
  
  $advanceds_array = $vars['entity']->advanceds;
  $aweights_array = $vars['entity']->aweights;
  
  $counted = count($users_array);

if (!isset($vars['entity'])) {
    $counted_js = 1;   
    $counted10_js = 20;   
}
else{
    $counted_js = $counted/10;
    $counted10_js = $counted;   
}

$countedadv = count($advanceds_array);

$divgweights = '<div style="float:left; width:11%; text-align:center; margin-right:20px;">';

$divfields = '<div style="float:left; width:82%; margin-right:5px;">';
$divweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center;">';
$divcountries = '<div style="float:left; width:31%; margin-right:15px;">';
$divcweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divedudbs = '<div style="float:left; width:31%; margin-right:15px;">';
$diveweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divcredittypes = '<div style="float:left; width:25%; margin-right:15px;">';
$divcrweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divedutypes = '<div style="float:left; width:85%; margin-right:15px;">';
$divetweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center;">';

$divsectors = '<div style="float:left; width:95%; margin-right:5px;">';
$divsweights = '<div style="float:left; width:20%; margin-top:5px; text-align:center;">';
$divcountries = '<div style="float:left; width:31%; margin-right:15px;">';
$divworkdbs = '<div style="float:left; width:32%; margin-right:15px;">';
$divwweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divsectortypes = '<div style="float:left; width:95%; margin-right:5px;">';
$divstweights = '<div style="float:left; width:20%; margin-top:5px; text-align:center; margin-right:25px;">';

$divlangs = '<div style="float:left; width:36%; margin-right:7px;">';
$divlweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:20px;">';
$divlangdbs = '<div style="float:left; width:34%; margin-right:10px;">';
$divldbweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:30px;">';

$divresfields = '<div style="float:left; width:75%; margin-right:15px;">';
$divrfweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center;">';

$divpubfields = '<div style="float:left; width:35%; margin-right:10px;">';
$divpfweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:20px;">';

$divskilltypes = '<div style="float:left; width:35%; margin-right:20px;">';
$divskweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:10px;">';

$divusers = '<div style="float:left; text-align: center; width:49%; margin-right:5px; margin-bottom:5px;">';

$divadvanceds = '<div style="float:left; width:75%; margin-right:15px;">';
$divaweights = '<div style="float:left; width:20%; text-align:center;">';

// for testing: collapse or view all menus
$collapsed = true;
?>
<script type="text/javascript">
 <?php echo "var counter = ".$counted_js."\n";?>
 <?php echo "var counterdiv = ".$counted10_js."\n";?>
      var limit = 10;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + (counter*10) + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.id = 'parent' + counter;
          var bodyText = '<div id="child' + counter + '"><div align="center" width="90%" style="float:left; color:red; text-align:center; margin-bottom:10px"><?php echo elgg_echo("resume:cvranking:autocomplete");?></div>';
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          counterdiv++; 
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input type="text" value="" name="users[' + counterdiv + ']" class="elgg-input-text" /></div><br />';
          bodyText += '<div align="right"><input type="button" class="elgg-button elgg-button-action" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:cvranking:removeuser'); ?>"></div><div class="clearfloat"></div><br />';
          newdiv.innerHTML += bodyText;
          document.getElementById(divName).appendChild(newdiv);
          counter++;
               }

}

 <?php echo "var counteradv = ".$countedadv."\n";?>
 var limitadv = 100;
function addInput2(divName){
          var newdiv = document.createElement('div');
          newdiv.id = 'parent' + counteradv;
          var bodyText = '<div id="child' + counteradv + '">'
          bodyText += '<?php echo $divadvanceds;?><?php echo elgg_echo('resume:cvranking:advanced'); echo '<select name="advanceds[]" class="elgg-input-dropdown" style="margin-top:5px;margin-bottom:5px">' . $advanced_options . '</select>';?>';
          bodyText += '</div>'
          bodyText += '<?php echo $divaweights;?><?php echo elgg_echo('resume:cvranking:weight');?><input type="text" name="aweights[]" value="" class="input-text"/></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" class="elgg-button elgg-button-action" onClick="removeElement(\'parent' + counteradv + '\', \'child' + counteradv + '\')" value="<?php echo elgg_echo('resume:cvranking:removeadvanced'); ?>"></div></div><div class="clearfloat"></div><br />';
          newdiv.innerHTML = bodyText;
          document.getElementById(divName).appendChild(newdiv);
          counteradv++;
}

function removeElement(parentDiv, childDiv){
    if (childDiv == parentDiv) {
         alert("These fields cannot be removed.");
    }
    else if (document.getElementById(childDiv)) {     
         var child = document.getElementById(childDiv);
         var parent = document.getElementById(parentDiv);
         parent.removeChild(child);
    }
    else {
         alert("This field has already been removed or does not exist.");
         return false;
    }
}
</script>

<div class="contentWrapper">

  <form action="<?php echo $vars['url']; ?>action/<?php echo $action ?>" method="post">
    <p>
      <?php echo elgg_echo('resume:cvranking:heading'); ?><br />
      <?php echo elgg_view('input/text', array('name' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <?php 
    
    // General weights
    
     $title = 'resume:cvranking:general';
     $help = 'resume:cvranking:weights';
     collapsiblebox("general", $title, $help, true);
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:education');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:work');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:languages');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:research');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:publications');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:skills');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:time');
      echo '</div><br />';
    for( $i = 0; $i < 6; $i++ ) {
      if (!isset($vars['entity'])) {
        $gweights_array[$i] = 100;   
      } 
      echo $divgweights;
      echo elgg_view('input/text', array('name' => 'gweights[]', 
           'value' => $gweights_array[$i])); 
      echo '</div>';
    } 
    
     // Time options
      ?>
          
    <div style="float:left; width:10%; text-align:center; margin-top:5px;">
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'time', 
                  'options_values' => $times, 
                  'value' => $vars['entity']->time));
      ?>
    </div>
     <div class="clearfloat"></div>
    
    </div>
   </div>
  </div>
  
     <div class="clearfloat"></div>
    
         <?php
     $title = 'resume:cvranking:instructions';
     collapsiblebox("instructions", $title, false, false, $collapsed);
     echo elgg_echo('resume:cvranking:instructions:instructions'); 
        ?>
      </div>
     </div>
   </div>
    
      <?php 
      
   // Education
     $title = 'resume:cvranking:education';
     $help = 'resume:cvranking:education:help';
     collapsiblebox("education", $title, $help, false, $collapsed);
      
   // Education fields
      
   for( $i = 0; $i < 3; $i++ ) {
       $j = $i + 1; 
       $field = "fields".$i."[]";
       $fieldvar = "fields".$i;
       $fieldi = $vars['entity']->$fieldvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $fieldi = "any";
      }
      echo $divfields;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:field'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $field,
        "js" =>  "multiple='true'",
        "value"=> $fieldi,

        "options_values"=> $fields
        )
       );
      echo "</div>";
      
      if (!isset($vars['entity'])) {
        $fweights_array[$i] = 100;   
      } 
      echo $divweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight');
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'fweights[]', 
           'value' => $fweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
    
     // Education databases
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $edudb = "edudbs".$i."[]";
       $edudbvar = "edudbs".$i;
       $edudbi = $vars['entity']->$edudbvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $edudbi = "CVR_QS12";
      }
      echo $divedudbs;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:databases'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $edudb,
        "js" =>  "multiple='true'",
        "value"=> $edudbi,

        "options_values"=> $edudbs
        )
       );
      echo "</div>";
     
      
      if (!isset($vars['entity'])) {
        $eweights_array[$i] = 100;   
      } 
      echo $diveweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'eweights[]', 
         'value' => $eweights_array[$i])); 
      echo "</div>";
   }
   
     echo '<div class="clearfloat"></div><br />';
     
   // Education Countries
   
   for( $i = 0; $i < 2; $i++ ) {
       $j = $i + 1; 
       $country = "countries".$i."[]";
       $countryvar = "countries".$i;
       $countryi = $vars['entity']->$countryvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $countryi = "any";
      }
     
      echo $divcountries;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:country');
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $country,
        "js" =>  "multiple='true'",
        "value"=> $countryi,

        "options_values"=> $countries
         )
        );
      echo "</div>";
     
      if (!isset($vars['entity'])) {
        $cweights_array[$i] = 100;   
      } 
      echo $divcweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'cweights[]', 
         'value' => $cweights_array[$i])); 
      echo "</div>";
   }
   
     echo '<div class="clearfloat"></div><br />';
     
     // Credit Types
     
      for( $i = 0; $i < 2; $i++ ) {
           $j = $i + 1; 
       $credittype = "credittypes".$i."[]";
       $credittypevar = "credittypes".$i;
       $credittypei = $vars['entity']->$credittypevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $credittypei = "any";
      }
      echo $divcredittypes;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:credittypes'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $credittype,
        "js" =>  "multiple='true'",
        "value"=> $credittypei,

        "options_values"=> $credittypes
        )
       );
      echo "</div>";
      
      if (!isset($vars['entity'])) {
        $crweights_array[$i] = 100;   
      } 
      echo $divcrweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'crweights[]', 
         'value' => $crweights_array[$i])); 
      echo "</div>";
   }
   
     echo '<div class="clearfloat"></div><br />';
     
     // Education Types
     
      for( $i = 0; $i < 2; $i++ ) {
       $j = $i + 1; 
       $edutype = "edutypes".$i."[]";
       $edutypevar = "edutypes".$i;
       $edutypei = $vars['entity']->$edutypevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $edutypei = "any";
      }
      echo $divedutypes;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:edutypes'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $edutype,
        "js" =>  "multiple='true'",
        "value"=> $edutypei,

        "options_values"=> $edutypes
        )
       );
      echo '</div>';
      
      if (!isset($vars['entity'])) {
        $etweights_array[$i] = 100;   
      } 
      echo $divetweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'etweights[]', 
         'value' => $etweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
   
     
     ?>
     </div>
    </div>
   </div>
   
    <?php
    
    // Workexperience
    
     $title = 'resume:cvranking:work';
     $help = 'resume:cvranking:work:help';
     collapsiblebox("work", $title, $help, false, $collapsed); 
    
    // Sector
   for( $i = 0; $i < 3; $i++ ) {
       $j = $i + 1; 
       $sector = "sectors".$i."[]";
       $sectorvar = "sectors".$i;
       $sectori = $vars['entity']->$sectorvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $sectori = "any";
      }
      echo $divsectors;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:sector'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $sector,
        "js" =>  "multiple='true'",
        "value"=> $sectori,

        "options_values"=> $sectors
        )
       );
      echo '</div><div class="clearfloat"></div>';
      
      if (!isset($vars['entity'])) {
        $sweights_array[$i] = 100;   
      } 
      echo $divsweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight');
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'sweights[]', 
           'value' => $sweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
    
     // Work databases
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $workdb = "workdbs".$i."[]";
       $workdbvar = "workdbs".$i;
       $workdbi = $vars['entity']->$workdbvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $workdbi = "any";
      }
      echo $divworkdbs;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:databases'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $workdb,
        "js" =>  "multiple='true'",
        "value"=> $workdbi,

        "options_values"=> $workdbs
        )
       );
      echo '</div>';
     
      
      if (!isset($vars['entity'])) {
        $wweights_array[$i] = 100;   
      } 
      echo $divwweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'wweights[]', 
         'value' => $wweights_array[$i])); 
      echo '</div>';
   }
   
     echo '<div class="clearfloat"></div><br />';
     
   // Work Countries
   
   for( $i = 0; $i < 2; $i++ ) {
       $j = $i + 1; 
       $wcountry = "wcountries".$i."[]";
       $wcountryvar = "wcountries".$i;
       $wcountryi = $vars['entity']->$wcountryvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $wcountryi = "any";
      }
     
      echo $divcountries;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:country');
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $wcountry,
        "js" =>  "multiple='true'",
        "value"=> $wcountryi,

        "options_values"=> $countries
         )
        );
      echo "</div>";
     
      if (!isset($vars['entity'])) {
        $wcweights_array[$i] = 100;   
      } 
      echo $divcweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'wcweights[]', 
         'value' => $wcweights_array[$i])); 
      echo "</div>";
   }
   
     echo '<div class="clearfloat"></div><br />';
     
     // Sector Types
     
      for( $i = 0; $i < 2; $i++ ) {
           $j = $i + 1; 
       $sectortype = "sectortypes".$i."[]";
       $sectortypevar = "sectortypes".$i;
       $sectortypei = $vars['entity']->$sectortypevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $sectortypei = "any";
      }
      echo $divsectortypes;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:sectortypes'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $sectortype,
        "js" =>  "multiple='true'",
        "value"=> $sectortypei,

        "options_values"=> $industryclasses
        )
       );
      echo '</div><div class="clearfloat"></div>';
      
      if (!isset($vars['entity'])) {
        $stweights_array[$i] = 100;   
      } 
      echo $divstweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'stweights[]', 
         'value' => $stweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
   
  
   ?>
    
     </div>
    </div>
   </div>
   <br />
   
  <?php
  
     // Languages
  
     $title = 'resume:cvranking:languages';
     $help = 'resume:cvranking:languages:help';
     collapsiblebox("language", $title, $help, false, $collapsed);
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $language = "languages".$i."[]";
       $languagevar = "languages".$i;
       $languagei = $vars['entity']->$languagevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $languagei = "any";
      }
      echo $divlangs;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:language'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $language,
        "js" =>  "multiple='true'",
        "value"=> $languagei,

        "options_values"=> $langs
        )
       );
      echo '</div>';
     
      
      if (!isset($vars['entity'])) {
        $lweights_array[$i] = 100;   
      } 
      echo $divlweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'lweights[]', 
         'value' => $lweights_array[$i])); 
      echo '</div>';
   }
   
     echo '<div class="clearfloat"></div><br />';
     
   // Lang databases
   
   for( $i = 0; $i < 2; $i++ ) {
       $j = $i + 1; 
       $langdb = "langdbs".$i."[]";
       $langdbvar = "langdbs".$i;
       $langdbi = $vars['entity']->$langdbvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $langdbi = "weber";
      }
      echo $divlangdbs;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:databases'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $langdb,
        "js" =>  "multiple='true'",
        "value"=> $langdbi,

        "options_values"=> $langdbs
        )
       );
      echo '</div>';
     
      
      if (!isset($vars['entity'])) {
        $ldbweights_array[$i] = 100;   
      } 
      echo $divldbweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'ldbweights[]', 
         'value' => $ldbweights_array[$i])); 
      echo '</div>';
   }
   
     echo '<div class="clearfloat"></div><br />';
     
   ?>
    
      </div>
     </div>
   </div>
   
    <?php 
    
     // Research
      
     $title = 'resume:cvranking:researches';
     $help = 'resume:cvranking:research:help';
     collapsiblebox("research", $title, $help, false, $collapsed);
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $resfield = "resfields".$i."[]";
       $resfieldvar = "resfields".$i;
       $resfieldi = $vars['entity']->$resfieldvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $resfieldi = "any";
      }
      echo $divresfields;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:research'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $resfield,
        "js" =>  "multiple='true'",
        "value"=> $resfieldi,

        "options_values"=> $resfields
        )
       );
      echo '</div>';
     
      if (!isset($vars['entity'])) {
        $rfweights_array[$i] = 100;   
      } 
      echo $divrfweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'rfweights[]', 
         'value' => $rfweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
   
   ?>
    
      </div>
     </div>
   </div>
   
   <?php 
   
     // Publication
  
     $title = 'resume:cvranking:publications';
     $help = 'resume:cvranking:publication:help';
     collapsiblebox("publication", $title, $help, false, $collapsed);
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $pubfield = "pubfields".$i."[]";
       $pubfieldvar = "pubfields".$i;
       $pubfieldi = $vars['entity']->$pubfieldvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $pubfieldi = "any";
      }
      echo $divpubfields;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:publication'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $pubfield,
        "js" =>  "multiple='true'",
        "value"=> $pubfieldi,

        "options_values"=> $typologies
        )
       );
      echo '</div>';
     
      if (!isset($vars['entity'])) {
        $pfweights_array[$i] = 100;   
      } 
      echo $divpfweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'pfweights[]', 
         'value' => $pfweights_array[$i])); 
      echo '</div>';
   }
   
      echo '<div class="clearfloat"></div><br />';
   ?>
    
    
     </div>
    </div>
   </div>
   
   <?php 
   
     // Skill
  
     $title = 'resume:cvranking:skills';
     $help = 'resume:cvranking:skill:help';
     collapsiblebox("skill", $title, $help, false, $collapsed);
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $skilltype = "skilltypes".$i."[]";
       $skilltypevar = "skilltypes".$i;
       $skilltypei = $vars['entity']->$skilltypevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $skilltypei = "any";
      }
      echo $divskilltypes;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:skill'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  $skilltype,
        "js" =>  "multiple='true'",
        "value"=> $skilltypei,

        "options_values"=> $skilltypes
        )
       );
      echo '</div>';
     
      if (!isset($vars['entity'])) {
        $skweights_array[$i] = 100;   
      } 
      echo $divskweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('name' => 'skweights[]', 
         'value' => $skweights_array[$i])); 
      echo '</div>';
   }
   
      echo '<div class="clearfloat"></div><br />';
   ?>
    
      </div>
     </div>
   </div>
    
 <?php 
 
       // CVRanking
 
     $title = 'resume:cvranking:cvranking';
     $help = 'resume:cvranking:cvranking:help';
     collapsiblebox("cvranking", $title, $help, false, false);

    for( $i = 0; $i < 3; $i++ ) { 
    echo '<div style="float:left; width:32%; margin:0; padding-left:5px;';
     if (!($i%2)) {
         echo 'background-color:#ccc;">'; 
         } 
    else {
        echo 'background-color:#f3f3f3;">';
        }
        
       $j = $i + 1; 
       $cvrtype = "cvrtypes".$i;
       $cvrtypevar = "cvrtypes".$i;
       $cvrtypei = $vars['entity']->$cvrtypevar;
       print_r ($cvrtypei);

      echo $j . ". ";
      echo elgg_echo('resume:cvranking:cvrtypes'); 
      echo "<br />";
       echo elgg_view('input/checkboxes', array(
           'name'=> $cvrtype, 
           'value' => $cvrtypei,
                   
           'options' => $cvrtypes
         )
        );    
       
      echo "<br />";
     $order = 'orders'.$i;
     $ordervar = "orders".$i;
     $orderi = $vars['entity']->$ordervar;

    echo elgg_echo('resume:cvranking:orders');
    
    echo elgg_view('input/dropdown', 
              array('name' => $order, 
                  'options_values' => $orders, 
                  'value' => $orderi));
     
     echo '<br /><br /></div>';
     }
     ?>
<div class="clearfloat"></div>
     </div>
    </div>
   </div>

   <?php 
   
     // Users
  
     $title = 'resume:cvranking:users';
     $help = 'resume:cvranking:users:help';
     
     print_r ($users_array);
    if (!isset($vars['entity'])) {
        
     collapsiblebox("users", $title, $help, false, false);
     
       for ($i = 0; $i < 20; $i++) {
           $j = $i + 1;
        $useriname = "users[".$i."]";
       echo $divusers;
       echo "$j. ";
       echo elgg_echo('resume:cvranking:rated');
       echo elgg_view('input/autocomplete', array('name' => $useriname, 'match_on' => 'users', 'value' => ""));      
       echo '</div>';
       } 
    }
    else {
        
     collapsiblebox("users", $title, $help, false, $collapsed);
     
       for ($i = 0; $i < $counted; $i++) {
    	$j = ( $i + 1 );
        $useriname = "users[".$i."]";
       
        if ($i == 20 || $i == 40 || $i == 60 || $i == 80 )  {
     	 ?>
     
      </div>
     </div>
   </div>
     
<?php 

     $name = "users" . $i;
     collapsiblebox($name, $title, $help, false, $collapsed);
     
       }
       
       echo $divusers;
       echo "$j. ";
       echo elgg_echo('resume:cvranking:rated');
       echo elgg_view('input/autocomplete', array('name' => $useriname, 'match_on' => 'users', 'value' => $users_array[$i]));
       echo "</div>";
     } 
   }
   
    echo '<div id="dynamicInput"></div>';
   
    echo '<div class="clearfloat"></div>';
   
    echo '<input type="button" class="elgg-button elgg-button-action" value="';
    echo elgg_echo('resume:cvranking:adduser'); 
    echo '" onClick="addInput(\'dynamicInput\');">';
    
      echo '</div></div></div>';
    ?>
   
     
      <?php 
      // ADVANCED VALUES
      
     $title = 'resume:cvranking:advanced';
     $help = 'resume:cvranking:advanced:help';
     collapsiblebox("advanced", $title, $help, false);
     
      if (!$advanceds_array) {
       echo $divadvanceds;
            echo "1. ";
       echo elgg_echo('resume:cvranking:advanced');
       echo '<select name="advanceds[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $advanced_options . '</select>';
       echo "</div>"; 
       
       echo $divaweights;
            echo "1. ";
       echo elgg_echo('resume:cvranking:weight');
       echo elgg_view('input/text', array('name' => "aweights[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div><br />'; 
       
       echo $divadvanceds;
            echo "2. ";
       echo elgg_echo('resume:cvranking:advanced');
       echo '<select name="advanceds[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $advanced_options . '</select>';
       echo "</div>"; 
       
       echo $divaweights;
            echo "2. ";
       echo elgg_echo('resume:cvranking:weight');
       echo elgg_view('input/text', array('name' => "aweights[]", 'value' => ""));
        echo '</div><div class="clearfloat"></div><br />'; 
      }
      else { 
        $counted_advanced = count($advanceds_array);
          for ($i=0; $i < $counted_advanced; $i++) {
              $j = $i +1;
            $advanced_options = '<option value="' . $advanceds_array[$i] . '" selected="selected">' . elgg_echo('resume:cvranking:advanced:' . $advanceds_array[$i]) . '</option>';
            foreach ($advanceds as $yh => $yt) { $advanced_options .= '<option value="' .$yh. '">' . $yt . '</option>'; }
            
            echo $divadvanceds;
            echo "$j. ";
            echo elgg_echo('resume:cvranking:advanced');
            echo '<select name="advanceds[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $advanced_options . '</select>';
            echo "</div>"; 
            
            echo $divaweights;
            echo "$j. ";
            echo elgg_echo('resume:cvranking:weight');
            echo elgg_view('input/text', array('name' => "aweights[]", 'value' => "$aweights_array[$i]"));
             echo '</div><div class="clearfloat"></div><br />'; 
          }
      }
     ?>
     </div>
     
    <div id="dynamicInput2">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:cvranking:addadvanced'); ?>" onClick="addInput2('dynamicInput2');">

    </div>
   </div>
   </div>

    <p>
      <?php echo elgg_echo('access'); ?><br />
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/access', array('name' => 'access_id', 'value' => $vars['entity']->access_id));
      else echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id));
      ?>
    </p>
    
    <?php echo elgg_view('input/securitytoken'); ?>
    
    <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:save'))); ?></p>
    
    <?php if (isset($vars['entity'])) 
    { echo elgg_view('input/hidden', array('name' => 'id', 'value' => $vars['entity']->getGUID())); }
    ?>
</form> 
    
</div>