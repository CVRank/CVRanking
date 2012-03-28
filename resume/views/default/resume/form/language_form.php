<?php
/**
 * language_form
 */

$action = "resume/language_add"; 

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; 
 else $access_id = 0;

	require_once(dirname(dirname(__FILE__)) . "/lib/general.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/language.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/language_form.php");
        
$divexperience = '<div style="float:left; width:90%;">';
$divexams = '<div style="float:left; width:47%; margin-right:15px">';
$divgrades = '<div style="float:left; width:13%;margin-right:25px">';
$divhours = '<div style="float:left; width:16%;">';
$divcountries = '<div style="float:left; width:27%; margin-right:25px">';
$divstarts = '<div style="float:left; width:25%; margin-right:5px">';
$divends = '<div style="float:left; width:25%;">';

$exams_array = $vars['entity']->exams;
$grades_array = $vars['entity']->grades;
$hours_array = $vars['entity']->hours;
$countries_array = $vars['entity']->countries;
$starts_array = $vars['entity']->starts;
$ends_array = $vars['entity']->ends;

$counted = count($exams_array);

if (!isset($vars['entity'])) {
    $counted_js = 2;
}
else{
    $counted_js = $counted;
}
?>

<script type="text/javascript">
 <?php echo "var counter = ".$counted_js."\n";?>
      var limit = 20;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.id = 'parent' + counter;
          var bodyText = '<div id="child' + counter + '"><?php echo elgg_echo('resume:languages:addexams');?><br />';
          bodyText += '<?php echo $divexams;?><?php echo elgg_echo('resume:languages:exam');?><input type="text" name="exams[]" value="" class="elgg-input-text" /></div>';
          bodyText += '<?php echo $divgrades;?><?php echo elgg_echo('resume:languages:grade');?><input type="text" name="grades[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divhours;?><?php echo elgg_echo('resume:languages:hour');?><input type="text" name="hours[]" value="" class="elgg-input-text"/></div><div class="clearfloat"></div><br />';
          bodyText += '<?php echo $divcountries;?><?php echo elgg_echo('resume:education:country'); echo '<select name="countries[]" class="elgg-input-dropdown" style="margin-top:5px;margin-bottom:5px">' . $country_options . '</select>';?></div>';
          bodyText += '<?php echo $divstarts;?><?php echo elgg_echo('resume:languages:starts');?><br /><input type="text" name="starts' + counter + '" class="elgg-input-date popup_calendar" /></div>';
          bodyText += '<?php echo $divends;?><?php echo elgg_echo('resume:languages:ends');?><br /><input type="text" name="ends' + counter + '" class="elgg-input-date popup_calendar" /></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" class="elgg-button elgg-button-action" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:work:removefield'); ?>"></div></div><div class="divsubobject"></div><br />';
          newdiv.innerHTML = bodyText;
          document.getElementById(divName).appendChild(newdiv);
          counter++;
               }
}

 var counternew = 0;
 var limitnew = 1;
 
 function addInput2(divName){
     if (counternew == limitnew)  {
          alert("You have reached the limit of adding " + counternew + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.id = 'parent' + counternew;
          var bodyText = '<div id="child' + counternew + '"><?php echo elgg_echo('resume:languages:examdata'); ?><br />';
          bodyText += '<div style="float:left; width:55%;margin-right:15px"><?php echo elgg_echo('resume:languages:exam2'); echo elgg_echo('resume:*'); ?><br /><input type="text" name="exam2" value="" class="elgg-input-text"/></div>';
          bodyText += '<div style="float:left; width:42%;"><?php echo elgg_echo('resume:languages:level'); echo elgg_echo('resume:*'); ?><br /><input type="text" name="level"  value="" class="elgg-input-text"/></div><div class="clearfloat"></div><br />'
          bodyText += '<div style="float:left; width:20%; margin-right:15px;"><?php echo elgg_echo('resume:languages:students'); ?><br /><input type="text" name="students" value="" class="elgg-input-text"/></div>'
          bodyText += '<div style="float:left; width:20%; margin-right:15px;"><?php echo elgg_echo('resume:languages:official'); ?><br /><input type="text" name="official" value="" class="elgg-input-text"/></div>'
          bodyText += '<div style="float:left; width:20%; margin-right:15px;"><?php echo elgg_echo('resume:languages:valid'); ?><br /><input type="text" name="valid" value="" class="elgg-input-text"/></div>'
          bodyText += '<div style="float:left; width:30%;margin-top:5px"><?php echo elgg_echo('resume:education:country'); echo elgg_echo('resume:*'); ?><br /><select name="country" class="elgg-input-dropdown"><?php echo $country_options; ?></select></div>'
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" class="elgg-button elgg-button-action" onClick="removeElement(\'parent' + counternew + '\', \'child' + counternew + '\')" value="<?php echo elgg_echo('resume:work:removefield'); ?>"></div></div><div class="clearfloat"></div><br />';
          newdiv.innerHTML = bodyText;
          document.getElementById(divName).appendChild(newdiv);
          counternew++;
      }
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
    
    <div style="float:left; width:30%; margin-right:20px;">
      <?php echo elgg_echo('resume:startdate'); ?><br />
      <?php echo elgg_view('input/date', array('name' => 'startdate', 'value' => $vars['entity']->startdate)); ?>
    </div>
    
    <div style="float:left; width:30%; margin-right:20px"> 
      <?php echo elgg_echo('resume:enddate'); ?><br />
      <?php echo elgg_view('input/date', array('name' => 'enddate', 'value' => $vars['entity']->enddate)); ?>
    </div>
      
     <div style="float:left; width:30%;"> 
       &nbsp; <?php echo elgg_echo('resume:enddateorcheck'); ?><br />
      <input name="ongoing[]" value="ongoing" class="elgg-input-checkboxes" type="checkbox" <?php if($vars['entity']->ongoing == 'ongoing') echo 'checked="checked"'; ?>> <?php echo elgg_echo('resume:date:ongoing'); ?><br />
       </div>
      
     <div class="clearfloat"></div><br />
     
    <div style="float:left; width:65%;">
      <?php echo elgg_echo('resume:languages:language');  
      echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'language', 
                  'options_values' => $langs, 
                  'value' => $vars['entity']->language));
      ?>
    </div>
    
    <div style="float:left; width:30%;">
      <p><?php echo elgg_echo('resume:languages:langtype'); 
       echo elgg_echo('resume:*');?> <br /> 
       <?php echo elgg_view('input/dropdown', 
              array('name' => 'langtype', 
                  'options_values' => $langtypes, 
                  'value' => $vars['entity']->langtype));
      ?>
    </div>
    
    <div class="clearfloat"></div> <br />
    
    <?php
      echo $divexperience;
      echo elgg_echo('resume:language:experience'); 
      echo "<br />";
       echo elgg_view('input/checkboxes', array(
        "name" =>  "experience",
           
        "value"=> $vars['entity']->experience,
        "options"=> $experience
        )
       );
      ?>
    </div>    <div class="clearfloat"></div>
<br />

      <h4><?php echo elgg_echo('resume:languages:languages'); ?></h4><br />

    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:understanding'); ?></h4>
      <?php echo elgg_echo('resume:languages:listening');  
      echo elgg_echo('resume:*');?> 
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_listening').toggle();"><?php echo elgg_echo('resume:help'); ?></a>
      <div id="resume_lang_listening" style="display:none;"><?php echo elgg_echo('resume:languages:listening:help'); ?></div>
      <?php echo elgg_view('input/dropdown', array('name' => 'listening', 'options_values' => $level_options, 'value' => $vars['entity']->listening)); ?>
      <br />
      <br />
      <?php echo elgg_echo('resume:languages:reading'); 
      echo elgg_echo('resume:*');?>  
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_reading').toggle();"><?php echo elgg_echo('resume:help'); ?></a>
      <div id="resume_lang_reading" style="display:none;"><?php echo elgg_echo('resume:languages:reading:help'); ?></div>
      <?php echo elgg_view('input/dropdown', array('name' => 'reading', 'options_values' => $level_options, 'value' => $vars['entity']->reading)); ?>
    </div>
    
    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:speaking'); ?></h4>
      <?php echo elgg_echo('resume:languages:spokeninteraction'); 
      echo elgg_echo('resume:*');?>  
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_spokeninteraction').toggle();"><?php echo elgg_echo('resume:help'); ?></a>
      <div id="resume_lang_spokeninteraction" style="display:none;"><?php echo elgg_echo('resume:languages:spokeninteraction:help'); ?></div>
      <?php echo elgg_view('input/dropdown', array('name' => 'spokeninteraction', 'options_values' => $level_options, 'value' => $vars['entity']->spokeninteraction)); ?>
      <br />
      <br />
      <?php echo elgg_echo('resume:languages:spokenproduction'); 
      echo elgg_echo('resume:*');?>  
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_spokenproduction').toggle();"><?php echo elgg_echo('resume:help'); ?></a>
      <div id="resume_lang_spokenproduction" style="display:none;"><?php echo elgg_echo('resume:languages:spokenproduction:help'); ?></div>
      <?php echo elgg_view('input/dropdown', array('name' => 'spokenproduction', 'options_values' => $level_options, 'value' => $vars['entity']->spokenproduction)); ?>
    </div>
    
    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:writing'); 
      echo elgg_echo('resume:*');?> </h4>
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_writing').toggle();"><?php echo elgg_echo('resume:help'); ?></a><br/>
      <div id="resume_lang_writing" style="display:none;"><?php echo elgg_echo('resume:languages:writing:help'); ?></div>
      <?php echo elgg_view('input/dropdown', array('name' => 'writing', 'options_values' => $level_options, 'value' => $vars['entity']->writing)); ?>
    </div>
    
    <div class="clearfloat"></div><br />
   
    <div id="dynamicInput2">

    </div>
   
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:languages:addexamtype'); ?>" onClick="addInput2('dynamicInput2');">
   
   <br /><br />
   <?php 
     $title = 'resume:language:exams';
     $help = 'resume:language:exams:help';
     collapsiblebox("exams", $title, $help, true);
   
    if (!isset($vars['entity'])) {
      echo $divexams;
       echo "1. ";
       echo elgg_echo('resume:languages:exam');
echo elgg_view('input/autocomplete', array('name' => 'exams[0]', 'match_on' => 'languages', 
           'value' => ""));       echo "</div>";
      echo $divgrades;
       echo elgg_echo('resume:languages:grade');
       echo elgg_view('input/text', array('name' => "grades[]", 'value' => ""));
        echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:languages:hour');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div><br/>';
      echo $divcountries;
       echo elgg_echo('resume:education:country');
       echo elgg_view('input/dropdown', 
              array('name' => 'countries[]', 
                  'options_values' => $countries, 
                  'value' => ""));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:languages:starts');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'starts0', 'value' => $vars['entity']->starts));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:languages:ends');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'ends0', 'value' => $vars['entity']->ends));
        
       echo '</div><div class="divsubobject"></div><br />';
       
      echo $divexams;
       echo "2. ";
       echo elgg_echo('resume:languages:exam');
echo elgg_view('input/autocomplete', array('name' => 'exams[1]', 'match_on' => 'languages', 
           'value' => ""));       echo "</div>";
      echo $divgrades;
       echo elgg_echo('resume:languages:grade');
       echo elgg_view('input/text', array('name' => "grades[]", 'value' => ""));
        echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:languages:hour');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div><br/>';
      echo $divcountries;
       echo elgg_echo('resume:education:country'); 
       echo elgg_view('input/dropdown', 
              array('name' => 'countries[]', 
                  'options_values' => $countries, 
                  'value' => ""));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:languages:starts');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'starts1', 'value' => $vars['entity']->starts));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:languages:ends');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'ends1', 'value' => $vars['entity']->ends));
        
       echo '</div><div class="divsubobject"></div><br />';
    } 
    else {
    $count = count($exams_array);	
     for ($i = 0; $i < $count; $i++) {
    	$j= ($i+1);
       echo $divexams;
       echo "$j. ";
       echo elgg_echo('resume:languages:exam');
       $examiname = "exams[".$i."]";
       $language = $exams_array[$i];
       $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_language_entity
                 WHERE language_id='$language'";
       $result = get_data_row($query);
       $comshow = $result->name; 
      
      echo elgg_view('input/autocomplete', array('name' => $examiname, 'match_on' => 'languages', 
           'value' => $guid, 'value_show' => $comshow));
       echo "</div>"; 
       echo $divgrades;
       echo elgg_echo('resume:languages:grade');
       echo elgg_view('input/text', array('name' => "grades[]", 'value' => $grades_array[$i]));
        echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:languages:hour');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => $hours_array[$i]));
       echo '</div><div class="clearfloat"></div><br/>';
      echo $divcountries;
       echo elgg_echo('resume:education:country'); 
       echo elgg_view('input/dropdown', 
              array('name' => 'countries[]', 
                  'options_values' => $countries, 
                  'value' => $countries_array[$i]));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:languages:starts');
       echo "<br />";
    	 $starts_i = "starts".$i;
       echo elgg_view('input/date', array('name' => $starts_i, 'value' => $starts_array[$i]));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:work:ends');
       echo "<br />";
    	 $ends_i = "ends".$i;
       echo elgg_view('input/date', array('name' => $ends_i, 'value' => $ends_array[$i]));
       echo '</div><div class="divsubobject"></div><br />';
     }
    }
    ?>
    
    <div id="dynamicInput">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:languages:addexam'); ?>" onClick="addInput('dynamicInput');">
   
      </div>
     </div>
    </div>
      
    <p>
      <?php echo elgg_echo('resume:workexperience:contact'); ?><br />
      <?php echo elgg_view('input/text', array('name' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
   
    <p>
      <?php echo elgg_echo('resume:languages:description'); ?><br />
      <?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $vars['entity']->description)); ?>
    </p>
    
   
    <p><?php echo elgg_echo('access'); ?><br />
    <?php
    if (isset($vars['entity'])) echo elgg_view('input/access', array('name' => 'access_id', 'value' => $vars['entity']->access_id));
    else echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id));
    ?>
    </p>
    
    <?php echo elgg_view('input/securitytoken'); ?>
    
    <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:languages:save'))); ?></p>
    
    <?php // Pass the GUID if existing entity
    if (isset($vars['entity'])) { echo elgg_view('input/hidden', array('name' => 'id', 'value' => $vars['entity']->getGUID())); }
    ?>
    
  </form>
</div>
