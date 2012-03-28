<?php
/**
 * workexperience_form
 */

$action = "resume/workexperience_add";

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; 
 else $access_id = 0;
 
	require_once(dirname(dirname(__FILE__)) . "/lib/general.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/workexperience.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/workexperience_form.php");

$positions_array = $vars['entity']->positions;
$wages_array = $vars['entity']->wages;
$hours_array = $vars['entity']->hours;
$weeks_array = $vars['entity']->weeks;
$starts_array = $vars['entity']->starts;
$ends_array = $vars['entity']->ends;

$counted = count($positions_array);

if (!isset($vars['entity'])) {
    $counted_js = 2;
}
else{
    $counted_js = $counted;
}

$divpositions = '<div style="float:left; width:60%; margin-right:15px">';
$divwages = '<div style="float:left; width:13%; margin-right:20px">';
$divhours = '<div style="float:left; width:12%;">';
$divweeks = ' <div style="float:left; width:20%; margin-right:30px">';
$divstarts = '<div style="float:left; width:30%; margin-right:5px">';
$divends = '<div style="float:left; width:30%;">';

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
          var bodyText = '<div id="child' + counter + '"><?php echo $divpositions;?><?php echo elgg_echo('resume:work:position'); echo elgg_echo('resume:*');?><input type="text" name="positions[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divwages;?><?php echo elgg_echo('resume:work:wage'); echo elgg_echo('resume:*');?><input type="text" name="wages[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divhours;?><?php echo elgg_echo('resume:work:hour'); echo elgg_echo('resume:*');?><input type="text" name="hours[]" value="" class="elgg-input-text"/></div><br /><br /><div class="clearfloat"></div>';
          bodyText += '<?php echo $divweeks;?><?php echo elgg_echo('resume:work:weeks'); echo elgg_echo('resume:*');?><input type="text" name="weeks[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divstarts;?><?php echo elgg_echo('resume:work:starts');?><br /><input type="text" name="starts' + counter + '" class="elgg-input-date popup_calendar" /></div>';
          bodyText += '<?php echo $divends;?><?php echo elgg_echo('resume:work:ends');?><br /><input type="text" name="ends' + counter + '" class="elgg-input-date popup_calendar" /></div>';
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
          var bodyText = '<div id="child' + counternew + '"><?php echo elgg_echo('resume:work:companydata'); ?>';
          bodyText += '<div style="float:left; width:60%;margin-right:15px"><?php echo elgg_echo('resume:work:structure2');  echo elgg_echo('resume:*');?><br /><input type="text" name="structure2" value="" class="elgg-input-text"/></div>';
          bodyText += '<div style="float:left; width:30%;margin-top:5px"><?php echo elgg_echo('resume:work:country');  echo elgg_echo('resume:*');?><br /><select name="country" class="elgg-input-dropdown"><?php echo $country_options; ?></select></div><div class="clearfloat"></div><br />'
    bodyText += '<div style="float:left; width:27%; margin-right:15px;"><?php echo elgg_echo('resume:work:currencycap');  echo elgg_echo('resume:*');?><select name="currenycap" class="elgg-input-dropdown"><?php echo $currency_options; ?></select></div>'
    bodyText += '<div style="float:left; width:15%; margin-right:15px;"><?php echo elgg_echo('resume:work:incomecap'); ?><br /><input type="text" name="incomecap" value="" class="elgg-input-text"/></div>'
    bodyText += '<div style="float:left; width:15%; margin-right:15px;"><?php echo elgg_echo('resume:work:assetcap'); ?><br /><input type="text" name="assetcap" value="" class="elgg-input-text"/></div>'
    bodyText += '<div style="float:left; width:14%; margin-right:15px;"><?php echo elgg_echo('resume:work:marketcap'); ?><br /><input type="text" name="marketcap" value="" class="elgg-input-text"/></div>'
    bodyText += '<div style="float:left; width:12%;"><?php echo elgg_echo('resume:work:workers'); ?><br /><input type="text"   name="workers"  value="" class="elgg-input-text"/></div><div class="clearfloat"></div><br />'
    bodyText += '<div style="float:left; width:98%;"><?php echo elgg_echo('resume:workexperience:industryclass'); echo elgg_echo('resume:*');?><br /><select name="industryclass2" class="elgg-input-dropdown"><?php echo $industryclass_options; ?></select></div>'
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
    
    <p>
      <?php echo elgg_echo('resume:workexperience:heading');
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('name' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
     <p>
      <?php echo elgg_echo('resume:workexperience:sector');
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'sector', 
                  'options_values' => $sectors, 
                  'value' => $vars['entity']->sector));
      ?>
    </p>
    
     <div style="float:left; width:90%;">
      <?php echo elgg_echo('resume:workexperience:level');
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'level', 
                  'options_values' => $levels, 
                  'value' => $vars['entity']->level));
      ?>
     </div>
    
    <div class="clearfloat"></div><br />
    
        <div style="float:left; width:60%; margin-right:7px;">
      <?php echo elgg_echo('resume:workexperience:structure');
       echo elgg_echo('resume:*');?><br />
      <?php 
      if (isset($vars['entity'])){
         $company = $vars['entity']->structure;
         $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_company_entity
         WHERE company_id='$company'";
         $result = get_data_row($query);
         $comname = $result->name; 
         $comcountry = $result->country;
         $comshow = "$comname - $comcountry";
      }
      echo elgg_view('input/autocomplete', array('name' => 'structure', 'match_on' => 'companies', 
          'value' => $vars['entity']->structure, 'value_show' => $comshow)); ?>
        </div>
    
     <div style="float:left; width:35%;">
      <?php echo elgg_echo('resume:work:currency');
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'currency', 
                  'options_values' => $currencies, 
                  'value' => $vars['entity']->currency));
      ?>
    </div>
    
   <div class="clearfloat"></div><br />
   
    <div id="dynamicInput2">
 
    </div>
   
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:work:addstructure'); ?>" onClick="addInput2('dynamicInput2');">
   
   <br /><br />
   
   <div style="float:left; width:98%;">
       <?php 
       echo elgg_echo('resume:workexperience:industryclass');
        echo elgg_echo('resume:*');
       echo "<br />";
       echo  elgg_view("input/dropdown", array(
        "name" =>  "industryclass[]",
        "js" =>  "multiple='true'",
        "value"=> $vars['entity']->industryclass,

        "options_values"=> $industryclasses
        )
       );
       ?>
       <br />
   </div>
   
   <div class="clearfloat"></div><br />
   
    <?php
    
     $title = 'resume:work:positions';
     $help = 'resume:workexperience:help';
     
    if (!isset($vars['entity'])) {
        
     collapsiblebox("positions1", $title, $help, true);
     
       echo $divpositions;
       echo "1. ";
       echo elgg_echo('resume:work:position'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "positions[]", 'value' => ""));
       echo "</div>";
       echo $divwages;
    echo elgg_echo('resume:work:wage'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "wages[]", 'value' => ""));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:work:hour'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div>';
       
       echo $divweeks;
    echo elgg_echo('resume:work:weeks'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "weeks[]", 'value' => ""));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:work:starts');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'starts0', 'value' => $vars['entity']->starts));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:work:ends');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'ends0', 'value' => $vars['entity']->ends));
       echo '</div><div class="divsubobject"></div><br />';
       
       echo $divpositions;
       echo "2. ";
       echo elgg_echo('resume:work:position'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "positions[]", 'value' => ""));
       echo "</div>";
       echo $divwages;
    echo elgg_echo('resume:work:wage'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "wages[]", 'value' => ""));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:work:hour'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div><br />';
       
       echo $divweeks;
    echo elgg_echo('resume:work:weeks'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "weeks[]", 'value' => ""));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:work:starts');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'starts1', 'value' => $vars['entity']->starts));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:work:ends');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'ends1', 'value' => $vars['entity']->ends));
       echo '</div><div class="divsubobject"></div><br />';
    } 
    else {
        
     collapsiblebox("positions1", $title, $help, true, true);
     
    $count = count($positions_array);	
    for ($i = 0; $i < $count; $i++) {
    	$j= ($i+1);
       echo $divpositions;
       echo "$j. ";
       echo elgg_echo('resume:work:position'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "positions[]", 'value' => $positions_array[$i]));
       echo "</div>";
       echo $divwages;
    echo elgg_echo('resume:work:wage'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "wages[]", 'value' => $wages_array[$i]));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:work:hour'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "hours[]", 'value' => $hours_array[$i]));
       echo '</div><div class="clearfloat"></div>';
       
       echo $divweeks;
    echo elgg_echo('resume:work:weeks'); 
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "weeks[]", 'value' => $weeks_array[$i]));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:work:starts');
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
     if ($i == 9 || $i == 19 || $i == 29 || $i == 39 )  {
         
      echo '</div></div></div>';
      
      echo '<div class="clearfloat"></div><br />';
         
         $name = "positions" . $i;
     collapsiblebox($name, $title, $help, true, true);
     
     }
    } 
   }
      
      ?>
     
    <div id="dynamicInput">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:work:addposition'); ?>" onClick="addInput('dynamicInput');">
  
      </div>
     </div>
    </div>
    
    <p>
      <?php echo elgg_echo('resume:workexperience:contact'); ?><br />
      <?php echo elgg_view('input/text', array('name' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:workexperience:description'); ?><br />
      <?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $vars['entity']->description)); ?>
    </p>
    
    <p>
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
