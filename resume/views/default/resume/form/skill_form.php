<?php
/**
 * skill_form
 */

$action = "resume/skill_add"; 

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; 
 else $access_id = 0;
 
	require_once(dirname(dirname(__FILE__)) . "/lib/workexperience_form.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/skill.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/skill_form.php");

$certs_array = $vars['entity']->certs;
$scores_array = $vars['entity']->scores;
$structures_array = $vars['entity']->structures;
$starts_array = $vars['entity']->starts;
$ends_array = $vars['entity']->ends;

$counted = count($certs_array);

if (!isset($vars['entity'])) {
    $counted_js = 2;
}
else{
    $counted_js = $counted;
}

$divcerts = '<div style="float:left; width:70%; margin-right:15px">';
$divscores = '<div style="float:left; width:21%;">';
$divstructures = '<div style="float:left; width:41%; margin-right:20px">';
$divstarts = '<div style="float:left; width:26%; margin-right:10px">';
$divends = '<div style="float:left; width:26%;">';
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
          bodyText += '<?php echo $divcerts;?><?php echo elgg_echo('resume:skill:cert'); echo elgg_echo('resume:*');?><input type="text" name="certs[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divscores;?><?php echo elgg_echo('resume:skill:score'); echo elgg_echo('resume:*');?><input type="text" name="scores[]" value="" class="elgg-input-text"/></div><div class="clearfloat"></div>';
          bodyText += '<?php echo $divstructures;?><?php echo elgg_echo('resume:skill:structure');?><input type="text" name="structures[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divstarts;?><?php echo elgg_echo('resume:education:starts');?><br /><input type="text" name="starts' + counter + '" class="elgg-input-date popup_calendar" /></div>';
          bodyText += '<?php echo $divends;?><?php echo elgg_echo('resume:education:ends');?><br /><input type="text" name="ends' + counter + '" class="elgg-input-date popup_calendar" /></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" class="elgg-button elgg-button-action" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:education:removesubject'); ?>"></div></div><div class="divsubobject"></div><br />';
          newdiv.innerHTML = bodyText;
          document.getElementById(divName).appendChild(newdiv);
          counter++;
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
      <?php echo elgg_echo('resume:skill:heading');  
      echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('name' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
     <p>
      <?php echo elgg_echo('resume:skill:level'); 
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'level', 
                  'options_values' => $levels, 
                  'value' => $vars['entity']->level));
      ?>
     </p>
    
    <p>
      <?php echo elgg_echo('resume:skill:typology'); 
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'skilltype', 
                  'options_values' => $skilltypes, 
                  'value' => $vars['entity']->skilltype));
      ?>
    </p>
    
    <?php
    
     $title = 'resume:skill:skills';
     $help = 'resume:skill:skills:help';
     collapsiblebox("skills1", $title, $help, true);
     
    if (!isset($vars['entity'])) {
       echo $divcerts;
       echo "1. ";
    echo elgg_echo('resume:skill:cert');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "certs[]", 'value' => ""));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:skill:score');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "scores[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div>';
       
       echo $divstructures;
    echo elgg_echo('resume:skill:structure');
       echo elgg_view('input/text', array('name' => "structures[]", 'value' => ""));
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
       
       echo $divcerts;
       echo "2. ";
    echo elgg_echo('resume:skill:cert');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "certs[]", 'value' => ""));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:skill:score');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "scores[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div>';
       
       echo $divstructures;
    echo elgg_echo('resume:skill:structure');
       echo elgg_view('input/text', array('name' => "structures[]", 'value' => ""));
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
    } 
    else {
    $count = count($certs_array);	
    for ($i = 0; $i < $count; $i++) {
    	$j= ($i+1);
       echo $divcerts;
       echo $j . ". ";
    echo elgg_echo('resume:skill:cert');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "certs[]", 'value' => $certs_array[$i]));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:education:score');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "scores[]", 'value' => $scores_array[$i]));
       echo '</div><div class="clearfloat"></div>';
       
       echo $divstructures;
    echo elgg_echo('resume:skill:structure');
       echo elgg_view('input/text', array('name' => "structures[]", 'value' => $structures_array[$i]));
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
      
      echo '<div class="clearfloat"></div><br />';
         
         $name = "skills" . $i;
     collapsiblebox($name, $title, $help, true, true);
     
     }
    } 
   }
    ?>
    
    <div id="dynamicInput">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:skill:addskill'); ?>" onClick="addInput('dynamicInput');">
   
  
      </div>
     </div>
    </div>
   
    <p>
      <?php echo elgg_echo('resume:research:contact'); ?><br />
      <?php echo elgg_view('input/text', array('name' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:skill:description'); ?><br />
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
    
    <?php if (isset($vars['entity'])) { echo elgg_view('input/hidden', array('name' => 'id', 'value' => $vars['entity']->getGUID())); } ?>
  </form>
  
</div>
