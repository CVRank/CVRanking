<?php
/**
 * publication_form
 */

$action = "resume/publication_add";
 
if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT;
 else $access_id = 0;
 
	require_once(dirname(dirname(__FILE__)) . "/lib/workexperience_form.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/publication.php");
	require_once(dirname(dirname(__FILE__)) . "/lib/publication_form.php");

$divarticles = '<div style="float:left; width:60%; margin-right:15px">';
$divcitations = '<div style="float:left; width:20%; margin-right:10px">';
$diveigens = '<div style="float:left; width:20%; margin-right:25px">';
$divauthors = '<div style="float:left; width:12%; margin-right:10px">';
$divpositions = '<div style="float:left; width:12%; margin-right:25px">';
$divends = '<div style="float:left; width:32%;">';

$articles_array = $vars['entity']->articles;
$citations_array = $vars['entity']->citations;
$eigens_array = $vars['entity']->eigens;
$authors_array = $vars['entity']->authors;
$positions_array = $vars['entity']->positions;
$ends_array = $vars['entity']->ends;

$counted = count($articles_array);

if (!isset($vars['entity'])) {
    $counted_js = 2;
}
else{
    $counted_js = $counted;
}
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
          bodyText += '<?php echo $divarticles;?><?php echo elgg_echo('resume:publication:article'); echo elgg_echo('resume:*');?><input type="text" name="articles[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divcitations;?><?php echo elgg_echo('resume:publication:citation'); echo elgg_echo('resume:*');?><input type="text" name="citations[]" value="" class="elgg-input-text"/></div>';
         bodyText += '<div class="clearfloat"></div>'
          bodyText += '<?php echo $diveigens;?><?php echo elgg_echo('resume:publication:eigen'); echo elgg_echo('resume:*');?><input type="text" name="eigens[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divauthors;?><?php echo elgg_echo('resume:publication:author'); echo elgg_echo('resume:*');?><input type="text" name="authors[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divpositions;?><?php echo elgg_echo('resume:publication:position'); echo elgg_echo('resume:*');?><input type="text" name="positions[]" value="" class="elgg-input-text"/></div>';
          bodyText += '<?php echo $divends;?><?php echo elgg_echo('resume:research:ends');?><br /><input type="text" name="ends' + counter + '" class="elgg-input-date popup_calendar" /></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" class="elgg-button elgg-button-action" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:research:removearticle'); ?>"></div></div><div class="divsubobject"></div><br />';
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
      <?php echo elgg_echo('resume:publication:heading');
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('name' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:publication:structure');
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('name' => 'structure', 'value' => $vars['entity']->structure)); ?>
    </p>
    
    <div class="clearfloat"></div><br />
    
    
     <div style="float:left; width:90%;">
      <?php echo elgg_echo('resume:research:level'); 
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'level', 
                  'options_values' => $levels, 
                  'value' => $vars['entity']->level));
      ?>
     </div>
   
    <div class="clearfloat"></div><br />
    
    
    <div style="float:left; width:50%; margin-right:25px">
      <?php echo elgg_echo('resume:publication:typology'); 
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'typology', 
                  'options_values' => $typologies, 
                  'value' => $vars['entity']->typology));
      ?>
    </div>
    
     <div style="float:left; width:45%;">
      <?php echo elgg_echo('resume:work:currency'); 
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/dropdown', 
              array('name' => 'currency', 
                  'options_values' => $currencies, 
                  'value' => $vars['entity']->currency));
      ?>
    </div>
    <div class="clearfloat"></div><br />
    
    <div style="float:left; width:90%;">
      <?php 
      echo elgg_echo('resume:publication:prize'); 
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
     
     $title = 'resume:publication:articles';
     $help = 'resume:publication:articles:help';
     
    if (!isset($vars['entity'])) {
        
     collapsiblebox("articles1", $title, $help, true);
     
       echo $divarticles;
       echo "1. ";
    echo elgg_echo('resume:publication:article');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "articles[]", 'value' => ""));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:publication:citation');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "citations[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div>';
       
       echo $diveigens;
    echo elgg_echo('resume:publication:eigen');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "eigens[]", 'value' => ""));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:publication:author');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "authors[]", 'value' => ""));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:publication:position');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "positions[]", 'value' => ""));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:research:ends');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'ends0', 'value' => $vars['entity']->ends));
       echo '</div><div class="divsubobject"></div><br />';
       
       
       echo $divarticles;
       echo "2. ";
    echo elgg_echo('resume:publication:article');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "articles[]", 'value' => ""));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:publication:citation');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "citations[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div>';
       
       echo $diveigens;
    echo elgg_echo('resume:publication:eigen');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "eigens[]", 'value' => ""));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:publication:author');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "authors[]", 'value' => ""));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:publication:position');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "positions[]", 'value' => ""));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:research:ends');
       echo "<br />";
       echo elgg_view('input/date', array('name' => 'ends1', 'value' => $vars['entity']->ends));
       echo '</div><div class="divsubobject"></div><br />';
    } 
    else {
        
     collapsiblebox("articles1", $title, $help, true, true);
     
    $count = count($articles_array);	
    for ($i = 0; $i < $count; $i++) {
    	$j= ($i+1);
      echo $divarticles;
       echo $j . ". ";
    echo elgg_echo('resume:publication:article');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "articles[]", 'value' => $articles_array[$i]));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:publication:citation');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "citations[]", 'value' => $citations_array[$i]));
       echo '</div><div class="clearfloat"></div>';
       
       echo $diveigens;
    echo elgg_echo('resume:publication:eigen');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "eigens[]", 'value' => $eigens_array[$i]));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:publication:author');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "authors[]", 'value' => $authors_array[$i]));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:publication:position');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('name' => "positions[]", 'value' => $positions_array[$i]));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:research:ends');
       echo "<br />";
    	 $ends_i = "ends".$i;
       echo elgg_view('input/date', array('name' => $ends_i, 'value' => $ends_array[$i]));
       echo '</div><div class="divsubobject"></div><br />';
     if ($i == 9 || $i == 19 || $i == 29 || $i == 39 )  {
      
      echo '</div></div></div>';
      
      echo '<div class="clearfloat"></div><br />';
         
         $name = "articles" . $i;
         
     collapsiblebox($name, $title, $help, true, true);
   
     }
    } 
   }
    ?>
    
    <div id="dynamicInput">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" class="elgg-button elgg-button-action" value="<?php echo elgg_echo('resume:publication:addarticle'); ?>" onClick="addInput('dynamicInput');">
   
      </div>
     </div>
    </div>

    <p>
      <?php echo elgg_echo('resume:research:contact'); ?><br />
      <?php echo elgg_view('input/text', array('name' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:publication:description'); ?><br />
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
