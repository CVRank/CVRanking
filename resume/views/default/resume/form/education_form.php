<?php
/**
 * education_form
 */

/**
 * @todo : Use AJAX to provide users with new subject fields
 *         Or at least provide with useful input/date fields...
 */

$action = "resume/education_add"; 

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; 
 else $access_id = 0;

	require_once(dirname(dirname(__FILE__)) . "/lib/general.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/education.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/education_form.php");

$subjects_array = $vars['entity']->subjects;
$scores_array = $vars['entity']->scores;
$hours_array = $vars['entity']->hours;
$types_array = $vars['entity']->types;
$starts_array = $vars['entity']->starts;
$ends_array = $vars['entity']->ends;

$counted = count($subjects_array);

if (!isset($vars['entity'])) {
    $counted_js = 2;
}
else{
    $counted_js = $counted;
}

$divsubjects = '<div style="float:left; width:60%; margin-right:15px">';
$divscores = '<div style="float:left; width:12%; margin-right:20px">';
$divhours = '<div style="float:left; width:12%;">';
$divtypes = ' <div style="float:left; width:24%; margin-right:10px">';
$divstarts = '<div style="float:left; width:32%; margin-right:10px">';
$divends = '<div style="float:left; width:32%;">';
?>

 <script type="text/javascript">
 <?php echo "var counter = ".$counted_js."\n";?>
      var limit = 50;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.id = 'parent' + counter;
          var bodyText = '<div id="child' + counter + '">';
          bodyText += '<?php echo $divsubjects;?><?php echo elgg_echo('resume:education:subject'); echo elgg_echo('resume:*');?><input type="text" value="" name="subjects[]" class="elgg-input-text" /></div>';
          bodyText += '<?php echo $divscores;?><?php echo elgg_echo('resume:education:score'); echo elgg_echo('resume:*');?><input type="text" name="scores[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divhours;?><?php echo elgg_echo('resume:education:hour'); echo elgg_echo('resume:*');?><input type="text" name="hours[]" value="" class="elgg-input-text"/></div><br /><br /><div class="clearfloat"></div>';
          bodyText += '<?php echo $divtypes;?><?php echo elgg_echo('resume:education:type'); echo elgg_echo('resume:*'); echo '<select name="types[]" class="elgg-input-dropdown" style="margin-top:5px;margin-bottom:5px">' . $credittype_options . '</select>';?></div>';
          bodyText += '<?php echo $divstarts;?><?php echo elgg_echo('resume:education:starts');?><br /><input type="text" name="starts' + counter + '" class="elgg-input-date popup_calendar" /></div>';
          bodyText += '<?php echo $divends;?><?php echo elgg_echo('resume:education:ends');?><br /><input type="text" name="ends' + counter + '" class="elgg-input-date popup_calendar hasDatepicker" /></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" class="elgg-button elgg-button-action" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:education:removesubject'); ?>"></div></div><div class="divsubobject"></div><br />';
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
          var bodyText = '<div id="child' + counternew + '"><?php echo elgg_echo('resume:education:structurenew'); ?>';
          bodyText += '<div><?php echo elgg_echo('resume:education:structure2'); echo elgg_echo('resume:*'); ?><br /><input type="text" name="structure2" value="" class="elgg-input-text"/></div>';
          bodyText += '<div style="float:left; width:24%; margin-right:15px;"><?php echo elgg_echo('resume:education:country'); echo elgg_echo('resume:*'); ?><br /><?php echo '<select name="country" class="elgg-input-dropdown" style="margin-top:5px;margin-bottom:5px">' . $country_options . '</select>'; ?></div>';
          bodyText += '<div style="float:left; width:20%; margin-right:15px;"><?php echo elgg_echo('resume:education:insttype'); echo elgg_echo('resume:*'); ?><br /><?php echo '<select name="insttype" class="elgg-input-dropdown" style="margin-top:5px;margin-bottom:5px">' . $insttype_options . '</select>'; ?></div>';
          bodyText += '<div style="float:left; width:14%; margin-right:15px;"><?php echo elgg_echo('resume:education:budget'); ?><br /><input type="text" name="budget" value="" class="elgg-input-text"/></div>';
          bodyText += '<div style="float:left; width:14%; margin-right:15px;"><?php echo elgg_echo('resume:education:professors'); ?><br /><input type="text" name="professors"  value="" class="elgg-input-text"/></div>';
          bodyText += '<div style="float:left; width:14%;"><?php echo elgg_echo('resume:education:students'); ?><br /><input type="text" name="students" value="" class="elgg-input-text"/></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" class="elgg-button elgg-button-action" onClick="removeElement(\'parent' + counternew + '\', \'child' + counternew + '\')" value="<?php echo elgg_echo('resume:education:removefield'); ?>"></div></div><div class="clearfloat"></div><br />';
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
    
        <div style="float:left; width:90%;">
      <?php echo elgg_echo('resume:education:level');
      echo elgg_echo('resume:*');?><br />
       <?php echo elgg_view('input/dropdown', 
              array('name' => 'level', 
                  'options_values' => $levels, 
                  'value' => $vars['entity']->level));
      ?>
    </div>
     
        <div class="clearfloat"></div><br />
        
    <div style="float:left; width:80%;">
      <?php echo elgg_echo('resume:education:orientation'); ?><br />
       <?php echo elgg_view('input/dropdown', 
              array('name' => 'orientation', 
                  'options_values' => $level2s, 
                  'value' => $vars['entity']->orientation));
      ?>
    </div>
    
    <div class="clearfloat"></div><br />
        
    <p>
      <?php echo elgg_echo('resume:education:heading'); 
      echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('name' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:field'); 
      echo elgg_echo('resume:*');?><br /> <?php echo elgg_view('input/dropdown', 
              array('name' => 'field', 
                  'options_values' => $fields, 
                  'value' => $vars['entity']->field));
      ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:edutype'); 
      echo elgg_echo('resume:*');?><br /> <?php echo elgg_view('input/dropdown', 
              array('name' => 'edutype', 
                  'options_values' => $edutypes, 
                  'value' => $vars['entity']->edutype));
      ?>
    </p>
    
        <div style="float:left; width:60%; margin-right:7px;">
      <?php echo elgg_echo('resume:education:structure'); 
      echo elgg_echo('resume:*');?><br />
      <?php 
      if (isset($vars['entity'])){
         $university = $vars['entity']->structure;
             $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_university_entity
                      WHERE university_id='$university'";
             $result = get_data_row($query);
               $uniname = $result->name; 
      }
      echo elgg_view('input/autocomplete', array('name' => 'structure', 'match_on' => 'universities',
          'value' => $vars['entity']->structure)); ?>
        </div>
    
       <div style="float:left; width:35%;">
      <?php echo elgg_echo('resume:education:contact'); ?><br />
      <?php echo elgg_view('input/text', array('name' => 'contact', 'value' => $vars['entity']->contact)); ?>
       </div>
    
    <div class="clearfloat"></div><br />
     
    <div id="dynamicInput2">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:education:addstructure'); ?>" onClick="addInput2('dynamicInput2');">
   
   <br /><br />
    
    <p>
     <?php echo elgg_echo('resume:education:hourtype'); 
      echo elgg_echo('resume:*');?><br /> 
     <?php echo elgg_view('input/dropdown', 
              array('name' => 'hourtype', 
                  'options_values' => $hourtypes, 
                  'value' => $vars['entity']->hourtype));
      ?>
    </p>
        
    <p>
     <?php echo elgg_echo('resume:education:gradetype'); 
      echo elgg_echo('resume:*');?><br /> 
     <?php echo elgg_view('input/dropdown', 
              array('name' => 'gradetype', 
                  'options_values' => $gradetypes, 
                  'value' => $vars['entity']->gradetype));
      ?>
    </p>
   
     <div style="float:left; width:20%; text-align:center; margin-top:10px; margin-right:45px;">
      <?php echo elgg_echo('resume:education:classrank'); 
      echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('name' => 'classrank', 'value' => $vars['entity']->classrank)); ?>
    </div>
    
    <div style="float:left; width:50%;">
      <?php 
      echo elgg_echo('resume:education:prize'); 
      echo "<br />";
      echo  elgg_view("input/dropdown", array(
        "name" =>  "prizes[]",
        "js" =>  "multiple='true'",
        "value"=> $vars['entity']->prizes,

        "options_values"=> $prizes
        )
       );
      ?>
    </div>
    
    <div class="clearfloat"></div><br />
    
     <?php 
     $title = 'resume:education:subjects';
     $help = 'resume:education:subjects:help';
          
      if (!isset($vars['entity'])) {
          
     collapsiblebox("subjects1", $title, $help, true);
     
       echo $divsubjects;
       echo "1. ";
       echo elgg_echo('resume:education:subject');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "subjects[]", 'value' => ""));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:education:score');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "scores[]", 'value' => ""));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:education:hour');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div>';
       
       echo $divtypes;
    echo elgg_echo('resume:education:type');
      echo elgg_echo('resume:*');
       echo elgg_view('input/dropdown', 
              array('name' => 'types[]', 
                  'options_values' => $credittypes, 
                  'value' => ""));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:education:starts');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'starts0', 'value' => $vars['entity']->starts));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:education:ends');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'ends0', 'value' => $vars['entity']->ends));
       echo '</div><div class="divsubobject"></div><br />';
       
       
       echo $divsubjects;
       echo "2. ";
       echo elgg_echo('resume:education:subject');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "subjects[]", 'value' => ""));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:education:score');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "scores[]", 'value' => ""));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:education:hour');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div>';
       
       echo $divtypes;
    echo elgg_echo('resume:education:type');
      echo elgg_echo('resume:*');
       echo elgg_view('input/dropdown', 
              array('name' => 'types[]', 
                  'options_values' => $credittypes, 
                  'value' => ""));       
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:education:starts');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'starts1', 'value' => $vars['entity']->starts));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:education:ends');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'ends1', 'value' => $vars['entity']->ends));
       echo '</div><div class="divsubobject"></div><br />';
    } 
    else {
        
     collapsiblebox("subjects1", $title, $help, true, true);
     
    $count = count($subjects_array);	
    for ($i = 0; $i < $count; $i++) {
    	$j= ($i+1);
       echo $divsubjects;
       echo $j . ". ";
       echo elgg_echo('resume:education:subject');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "subjects[]", 'value' => $subjects_array[$i]));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:education:score');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "scores[]", 'value' => $scores_array[$i]));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:education:hour');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => $hours_array[$i]));
       echo '</div><div class="clearfloat"></div>';
       
       echo $divtypes;
    echo elgg_echo('resume:education:type');
      echo elgg_echo('resume:*');
      echo elgg_view('input/dropdown', 
              array('name' => 'types[]', 
                  'options_values' => $credittypes, 
                  'value' => $types_array[$i]));     
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:education:starts');
       echo "<br />";
    	 $starts_i = "starts".$i;
       echo elgg_view('input/date', array('name' => $starts_i, 'value' => $starts_array[$i]));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:education:ends');
       echo "<br />";
    	 $ends_i = "ends".$i;
       echo elgg_view('input/date', array('name' => $ends_i, 'value' => $ends_array[$i]));
       echo '</div><div class="divsubobject"></div><br />';
     if ($i == 9 || $i == 19 || $i == 29 || $i == 39 )  {
         
      echo '</div></div></div>';
      
      echo '<div class="clearfloat"></div> <br />';
         
         $name = "subjects" . $i;
     collapsiblebox($name, $title, $help, true, true);
     
     }
    } 
   }
    ?>
    
    <div id="dynamicInput">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:education:addsubject'); ?>" onClick="addInput('dynamicInput');">
   
      </div>
     </div>
    </div>
    
    <p>
      <?php echo elgg_echo('resume:education:description'); ?><br />
      <?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $vars['entity']->description)); ?>
    </p>
    
      <?php echo elgg_echo('access'); ?><br />
      
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/access', array('name' => 'access_id', 'value' => $vars['entity']->access_id));
      else echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id));
      ?>
    </p>
    
    <?php echo elgg_view('input/securitytoken'); ?>
    
    <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:save'))); ?></p> 
       
    <?php if (isset($vars['entity'])) {
      echo elgg_view('input/hidden', array('name' => 'id', 'value' => $vars['entity']->getGUID()));
    } ?>
  </form>
 
</div>
