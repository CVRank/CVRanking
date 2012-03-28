<?php

// Decide wich action to use based on if its an edit or add use case.
if (isset($vars['entity'])) {
  $action = "resume/edit";
} else {
  $action = "resume/publication_add";
}

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
else $level_options = '<option value="' . $level . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:work:level:' . $level) . '</option>';
foreach ($levels as $r => $c) { $level_options .= '<option value="' .$r. '">' . $c . '</option>'; }

$currencies = array(
    'USD' => elgg_echo('resume:work:currency:USD'),
    'GBP' => elgg_echo('resume:work:currency:GBP'),
    'EUR' => elgg_echo('resume:work:currency:EUR'), 
    'CNY' => elgg_echo('resume:work:currency:CNY'),
    'JPY' => elgg_echo('resume:work:currency:JPY'),
    'ARS' => elgg_echo('resume:work:currency:ARS'),
    'AUD' => elgg_echo('resume:work:currency:AUD'),        
    'BRL' => elgg_echo('resume:work:currency:BRL'),        
    'CAD' => elgg_echo('resume:work:currency:CAD'),       
    'CLP' => elgg_echo('resume:work:currency:CLP'),        
    'COP' => elgg_echo('resume:work:currency:COP'),        
    'CRC' => elgg_echo('resume:work:currency:CRC'),        
    'CZK' => elgg_echo('resume:work:currency:CZK'),        
    'DKK' => elgg_echo('resume:work:currency:DKK'),        
    'EGP' => elgg_echo('resume:work:currency:EGP'),        
    'HKD' => elgg_echo('resume:work:currency:HKD'),     
    'HUF' => elgg_echo('resume:work:currency:HUF'),     
    'INR' => elgg_echo('resume:work:currency:INR'),     
    'IDR' => elgg_echo('resume:work:currency:IDR'),     
    'ILS' => elgg_echo('resume:work:currency:ILS'),     
    'LVL' => elgg_echo('resume:work:currency:LVL'),     
    'LTL' => elgg_echo('resume:work:currency:LTL'),    
    'MYR' => elgg_echo('resume:work:currency:MYR'),     
    'MXN' => elgg_echo('resume:work:currency:MXN'),        
    'NZD' => elgg_echo('resume:work:currency:NZD'),         
    'NOK' => elgg_echo('resume:work:currency:NOK'),     
    'PKR' => elgg_echo('resume:work:currency:PKR'),     
    'PEN' => elgg_echo('resume:work:currency:PEN'),     
    'PHP' => elgg_echo('resume:work:currency:PHP'),     
    'PLN' => elgg_echo('resume:work:currency:PLN'),     
    'RUB' => elgg_echo('resume:work:currency:RUB'),     
    'SAR' => elgg_echo('resume:work:currency:SAR'),     
    'SGD' => elgg_echo('resume:work:currency:SGD'),     
    'ZAR' => elgg_echo('resume:work:currency:ZAR'),     
    'KRW' => elgg_echo('resume:work:currency:KRW'),     
    'LKR' => elgg_echo('resume:work:currency:LKR'),        
    'SEK' => elgg_echo('resume:work:currency:SEK'),        
    'CHF' => elgg_echo('resume:work:currency:CHF'),    
    'TWD' => elgg_echo('resume:work:currency:TWD'),     
    'THB' => elgg_echo('resume:work:currency:THB'),    
    'TRY' => elgg_echo('resume:work:currency:TRY'),     
    'AED' => elgg_echo('resume:work:currency:AED'),    
    'UAH' => elgg_echo('resume:work:currency:UAH'),     
    'UYU' => elgg_echo('resume:work:currency:UYU'),        
    );

$currency = $vars['entity']->currency;
if (empty($currency)) $currency_options = '<option disabled="disabled" selected="selected">-------</option>';
else $currency_options = '<option value="' . $currency . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:work:currency:' . $currency) . '</option>';
foreach ($currencies as $ly => $cy) { $currency_options .= '<option value="' .$ly. '">' . $cy . '</option>'; }

$typologies = array(  
    'live' => elgg_echo('resume:publication:live'),
    'conference' => elgg_echo('resume:publication:conference'),
    'course' => elgg_echo('resume:publication:course'),
    'performance' => elgg_echo('resume:publication:performance'),
    'written' => elgg_echo('resume:publication:written'),
    'nonfiction' => elgg_echo('resume:publication:nonfiction'),
    'fiction' => elgg_echo('resume:publication:fiction'),
    'patent' => elgg_echo('resume:publication:patent'),
    'essay' => elgg_echo('resume:publication:essay'),
    'blog' => elgg_echo('resume:publication:blog'),
    'media' => elgg_echo('resume:publication:media'),
    'music' => elgg_echo('resume:publication:music'),
    'audiovisual' => elgg_echo('resume:publication:audiovisual'),
    'art' => elgg_echo('resume:publication:art'),
  );

$typology = $vars['entity']->typology;
if (empty($typology)) $typology_options = '<option disabled="disabled" selected="selected">-------</option>';
else $typology_options = '<option value="' . $typology . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:publication:' . $typology) . '</option>';
foreach ($typologies as $ir => $tr) { $typology_options .= '<option value="' .$ir. '">' . $tr . '</option>'; }

$prizes = array(
 'top10' =>  elgg_echo('resume:publication:prizes:top10'),
 'top5' =>  elgg_echo('resume:publication:prizes:top5'),
 'nobel' =>  elgg_echo('resume:publication:prizes:nobel'),
 'fieldint' =>  elgg_echo('resume:publication:prizes:fieldint'),
 'subfieldint' =>  elgg_echo('resume:publication:prizes:subfieldint'),
 'fieldnat' =>  elgg_echo('resume:publication:prizes:fieldnat'),
 'subfieldnat' =>  elgg_echo('resume:publication:prizes:subfieldnat'),
 'fieldreg' =>  elgg_echo('resume:publication:prizes:fieldreg'),
 'subfieldreg' =>  elgg_echo('resume:publication:prizes:subfieldreg'),
 'academynat' =>  elgg_echo('resume:publication:prizes:academynat'),
 'academyreg' =>  elgg_echo('resume:publication:prizes:academyreg'),
);

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;

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
          bodyText += '<?php echo $divarticles;?><?php echo elgg_echo('resume:publication:article'); echo elgg_echo('resume:*');?><input type="text" name="articles[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divcitations;?><?php echo elgg_echo('resume:publication:citation'); echo elgg_echo('resume:*');?><input type="text" name="citations[]" value="" class="input-text"/></div>';
         bodyText += '<div class="clearfloat"></div>'
          bodyText += '<?php echo $diveigens;?><?php echo elgg_echo('resume:publication:eigen'); echo elgg_echo('resume:*');?><input type="text" name="eigens[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divauthors;?><?php echo elgg_echo('resume:publication:author'); echo elgg_echo('resume:*');?><input type="text" name="authors[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divpositions;?><?php echo elgg_echo('resume:publication:position'); echo elgg_echo('resume:*');?><input type="text" name="positions[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divends;?><?php echo elgg_echo('resume:research:ends');?><br />';
          window['calends' + counter] = new CalendarPopup();
          bodyText += '<input type="text"  name="ends' + counter + '" id="ends' + counter + '" value="" /><a href="#" onclick="calends' + counter + '.select(document.getElementById(\'ends' + counter + '\'),\'anchorends' + counter + '\',\'MMM dd, yyyy\'); return false;" TITLE="calends' + counter + '.select(document.forms[0].ends' + counter + ',\'anchorends' + counter + '\',\'MMM dd, yyyy\'); return false;" NAME="anchorends' + counter + '" ID="anchorends' + counter + '">select</a></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:research:removearticle'); ?>"></div></div><div class="clearfloat"></div><br />';
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
      <?php echo elgg_echo('resume:publication:heading');
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:publication:structure');
       echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'structure', 'value' => $vars['entity']->structure)); ?>
    </p>
    
    <div class="clearfloat"></div><br />
    
    
     <div style="float:left; width:90%;">
      <?php echo elgg_echo('resume:research:level'); 
       echo elgg_echo('resume:*');?><br />
      <select name="level" class="input-pulldown" style="width:100%;"><?php echo $level_options; ?></select>
     </div>
   
    <div class="clearfloat"></div><br />
    
    
    <div style="float:left; width:50%; margin-right:25px">
      <?php echo elgg_echo('resume:publication:typology'); 
       echo elgg_echo('resume:*');?><br />
      <select name="typology" class="input-pulldown"><?php echo $typology_options; ?></select>
    </div>
    
     <div style="float:left; width:45%;">
      <?php echo elgg_echo('resume:work:currency'); 
       echo elgg_echo('resume:*');?><br />
      <select name="currency" class="input-pulldown"><?php echo $currency_options; ?></select>
    </div>
    <div class="clearfloat"></div><br />
    
    <div style="float:left; width:90%;">
      <?php 
      echo elgg_echo('resume:publication:prize'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  "prizes[]",
        "js" =>  "multiple='true'",
        "value"=> $vars['entity']->prizes,

        "options_values"=> $prizes
        )
       );
      ?>
    </div>
    
    <div class="clearfloat"></div><br />
    
     <div class="contentWrapper resume_contentWrapper" width="716">
      <p><a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
      
     <?php
    if (!isset($vars['entity'])) {
       echo $divarticles;
       echo "1. ";
    echo elgg_echo('resume:publication:article');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "articles[]", 'value' => ""));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:publication:citation');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "citations[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $diveigens;
    echo elgg_echo('resume:publication:eigen');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "eigens[]", 'value' => ""));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:publication:author');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "authors[]", 'value' => ""));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:publication:position');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "positions[]", 'value' => ""));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:research:ends');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'ends0', 'value' => $vars['entity']->ends));
       echo "</div><div class=\"clearfloat\"></div><br />";
       
       
       echo $divarticles;
       echo "2. ";
    echo elgg_echo('resume:publication:article');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "articles[]", 'value' => ""));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:publication:citation');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "citations[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $diveigens;
    echo elgg_echo('resume:publication:eigen');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "eigens[]", 'value' => ""));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:publication:author');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "authors[]", 'value' => ""));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:publication:position');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "positions[]", 'value' => ""));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:research:ends');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'ends1', 'value' => $vars['entity']->ends));
       echo "</div><div class=\"clearfloat\"></div><br />";
    } 
    else {
    $count = count($articles_array);	
    for ($i = 0; $i < $count; $i++) {
    	$j= ($i+1);
      echo $divarticles;
       echo $j . ". ";
    echo elgg_echo('resume:publication:article');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "articles[]", 'value' => $articles_array[$i]));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:publication:citation');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "citations[]", 'value' => $citations_array[$i]));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $diveigens;
    echo elgg_echo('resume:publication:eigen');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "eigens[]", 'value' => $eigens_array[$i]));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:publication:author');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "authors[]", 'value' => $authors_array[$i]));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:publication:position');
     echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "positions[]", 'value' => $positions_array[$i]));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:research:ends');
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
   
     <input type="button" value="<?php echo elgg_echo('resume:publication:addarticle'); ?>" onClick="addInput('dynamicInput');">
   
   <br /><br />

    <p>
      <?php echo elgg_echo('resume:research:contact'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:publication:description'); ?><br />
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
    
    <?php if (isset($vars['entity'])) {
      echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID()));
    } ?>
  </form>
  
</div>
