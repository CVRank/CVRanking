<?php

// Decide wich action to use based on if its an edit or add use case.
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/skill_add"; }

$levels = array(
    'ISCE0' => elgg_echo('resume:work:level:ISCE0'),
    'ISCE1' => elgg_echo('resume:work:level:ISCE1'),
    'ISCE2' => elgg_echo('resume:work:level:ISCE2'),
    'ISCE3' => elgg_echo('resume:work:level:ISCE3'), 
    'ISCE4' => elgg_echo('resume:work:level:ISCE4'), 
    'ISCE5' => elgg_echo('resume:work:level:ISCE5'),     
    'ISCE6' => elgg_echo('resume:work:level:ISCE6'),      
    'ISCE7' => elgg_echo('resume:work:level:ISCE7'),     
    'ISCE8' => elgg_echo('resume:work:level:ISCE8'),    
    );
$level = $vars['entity']->level;
if (empty($level)) $level_options = '<option disabled="disabled" selected="selected">-------</option>';
else $level_options = '<option value="' . $level . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:level:' . $level) . '</option>';
foreach ($levels as $r => $c) { $level_options .= '<option value="' .$r. '">' . $c . '</option>'; }

$skilltypes = array(
    'accounting' => elgg_echo('resume:skill:accounting'), 
    'artistic' => elgg_echo('resume:skill:artistic'), 
    'music' => elgg_echo('resume:skill:music'), 
    'asset' => elgg_echo('resume:skill:asset'), 
    'aviation' => elgg_echo('resume:skill:aviation'), 
    'business' => elgg_echo('resume:skill:business'),
    'clerical' => elgg_echo('resume:skill:clerical'),   
    'chiro' => elgg_echo('resume:skill:chiro'),   
    'computer' => elgg_echo('resume:skill:computer'), 
    'programming' => elgg_echo('resume:skill:programming'), 
    'compspec' => elgg_echo('resume:skill:compspec'), 
    'driving' => elgg_echo('resume:skill:driving'), 
    'development' => elgg_echo('resume:skill:development'), 
    'legal' => elgg_echo('resume:skill:legal'),  
    'logistics' => elgg_echo('resume:skill:logistics'), 
    'medicine' => elgg_echo('resume:skill:medicine'),
    'project' => elgg_echo('resume:skill:project'),  
    'technical' => elgg_echo('resume:skill:technical'), 
    'sanitary' => elgg_echo('resume:skill:sanitary'),  
    'security' => elgg_echo('resume:skill:security'),  
    'sport' => elgg_echo('resume:skill:sport'), 
    'other' => elgg_echo('resume:skill:other'), 
);

$skilltype = $vars['entity']->skilltype;
if (empty($skilltype)) $skilltype_options = '<option disabled="disabled" selected="selected">-------</option>';
else $skilltype_options = '<option value="' . $skilltype . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:skill:' . $skilltype) . '</option>';
foreach ($skilltypes as $f => $v) { $skilltype_options .= '<option value="' .$f. '">' . $v . '</option>'; }

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;

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
          bodyText += '<?php echo $divcerts;?><?php echo elgg_echo('resume:skill:cert'); echo elgg_echo('resume:*');?><input type="text" name="certs[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divscores;?><?php echo elgg_echo('resume:skill:score'); echo elgg_echo('resume:*');?><input type="text" name="scores[]" value="" class="input-text"/></div><div class="clearfloat"></div>';
          bodyText += '<?php echo $divstructures;?><?php echo elgg_echo('resume:skill:structure');?><input type="text" name="structures[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divstarts;?><?php echo elgg_echo('resume:education:starts');?><br />';
          window['calstarts' + counter] = new CalendarPopup();
          bodyText += '<input type="text"  name="starts' + counter + '" id="starts' + counter + '" value="" /><a href="#" onclick="calstarts' + counter + '.select(document.getElementById(\'starts' + counter + '\'),\'anchorstarts' + counter + '\',\'MMM dd, yyyy\'); return false;" TITLE="calstarts' + counter + '.select(document.forms[0].starts' + counter + ',\'anchorstarts' + counter + '\',\'MMM dd, yyyy\'); return false;" NAME="anchorstarts' + counter + '" ID="anchorstarts' + counter + '">select</a></div>';
          bodyText += '<?php echo $divends;?><?php echo elgg_echo('resume:education:ends');?><br />';
          window['calends' + counter] = new CalendarPopup();
          bodyText += '<input type="text"  name="ends' + counter + '" id="ends' + counter + '" value="" /><a href="#" onclick="calends' + counter + '.select(document.getElementById(\'ends' + counter + '\'),\'anchorends' + counter + '\',\'MMM dd, yyyy\'); return false;" TITLE="calends' + counter + '.select(document.forms[0].ends' + counter + ',\'anchorends' + counter + '\',\'MMM dd, yyyy\'); return false;" NAME="anchorends' + counter + '" ID="anchorends' + counter + '">select</a></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:education:removesubject'); ?>"></div></div><div class="clearfloat"></div><br />';
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

    <div style="float:left; width:35%;">
      <?php echo elgg_echo('resume:startdate'); ?><br />
      <?php echo elgg_view('input/calendar', array('internalname' => 'startdate', 'value' => $vars['entity']->startdate)); ?>
    </div>
    
    <div style="float:left; width:35%;">
      <?php echo elgg_echo('resume:enddate'); ?>
       &nbsp; <?php echo elgg_echo('resume:enddateorcheck'); ?>
      <input name="ongoing[]" value="ongoing" class="input-checkboxes" type="checkbox" <?php if($vars['entity']->ongoing == 'ongoing') echo 'checked="checked"'; ?>> <?php echo elgg_echo('resume:date:ongoing'); ?><br />
      <?php echo elgg_view('input/calendar', array('internalname' => 'enddate', 'value' => $vars['entity']->enddate)); ?>
    </div>
    
    <div class="clearfloat"></div><br />
    
    <p>
      <?php echo elgg_echo('resume:skill:heading');  
      echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
     <p>
      <?php echo elgg_echo('resume:skill:level'); 
       echo elgg_echo('resume:*');?><br />
      <select name="level" class="input-pulldown" style="width:100%;"><?php echo $level_options; ?></select>
     </p>
    
    <p>
      <?php echo elgg_echo('resume:skill:typology'); 
       echo elgg_echo('resume:*');?><br />
      <select name="skilltype" class="input-pulldown"><?php echo $skilltype_options; ?></select>
    </p>
    
     <div class="contentWrapper resume_contentWrapper" width="716">
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
      
    <?php
    if (!isset($vars['entity'])) {
       echo $divcerts;
       echo "1. ";
    echo elgg_echo('resume:skill:cert');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "certs[]", 'value' => ""));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:skill:score');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "scores[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $divstructures;
    echo elgg_echo('resume:skill:structure');
       echo elgg_view('input/text', array('internalname' => "structures[]", 'value' => ""));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:education:starts');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'starts0', 'value' => $vars['entity']->starts));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:education:ends');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'ends0', 'value' => $vars['entity']->ends));
       echo "</div><div class=\"clearfloat\"></div><br />";
       
       
       echo $divcerts;
       echo "2. ";
    echo elgg_echo('resume:skill:cert');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "certs[]", 'value' => ""));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:skill:score');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "scores[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $divstructures;
    echo elgg_echo('resume:skill:structure');
       echo elgg_view('input/text', array('internalname' => "structures[]", 'value' => ""));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:education:starts');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'starts0', 'value' => $vars['entity']->starts));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:education:ends');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'ends0', 'value' => $vars['entity']->ends));
       echo "</div><div class=\"clearfloat\"></div><br />";
    } 
    else {
    $count = count($certs_array);	
    for ($i = 0; $i < $count; $i++) {
    	$j= ($i+1);
       echo $divcerts;
       echo $j . ". ";
    echo elgg_echo('resume:skill:cert');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "certs[]", 'value' => $certs_array[$i]));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:education:score');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "scores[]", 'value' => $scores_array[$i]));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $divstructures;
    echo elgg_echo('resume:skill:structure');
       echo elgg_view('input/text', array('internalname' => "structures[]", 'value' => $structures_array[$i]));
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:education:starts');
       echo "<br />";
    	 $starts_i = "starts".$i;
       echo elgg_view('input/calendar', array('internalname' => $starts_i, 'value' => $starts_array[$i]));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:education:ends');
       echo "<br />";
    	 $ends_i = "ends".$i;
       echo elgg_view('input/calendar', array('internalname' => $ends_i, 'value' => $ends_array[$i]));
       echo "</div><div class=\"clearfloat\"></div><br />";
     if ($i == 9 || $i == 19 || $i == 29 || $i == 39 )  {
     	 ?>
      </div>
      </div>
      
     <div class="clearfloat"></div> <br />
     
     <div class="contentWrapper resume_contentWrapper" width="716">
       <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
       <div style="display:none;" class="collapsible_box resume_collapsible_box">
     <?php
     }
    } 
   }
    ?>
   </div>
   </div>
    
    <div id="dynamicInput">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" value="<?php echo elgg_echo('resume:education:addsubject'); ?>" onClick="addInput('dynamicInput');">
   
   <br /><br />
   
    <p>
      <?php echo elgg_echo('resume:research:contact'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:skill:description'); ?><br />
      <?php echo elgg_view('input/longtext', array('internalname' => 'description', 'value' => $vars['entity']->description)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('access'); ?><br />
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $vars['entity']->access_id));
      else echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
      ?>
    </p>
    
    <?php echo elgg_view('input/securitytoken'); ?>
    
    <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:save'))); ?></p>
    
    <?php if (isset($vars['entity'])) { echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID())); } ?>
  </form>
  
</div>
