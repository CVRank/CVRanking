<?php

// Decide wich action to use based on if its an edit or add use case.
if (isset($vars['entity'])) {
  $action = "resume/edit";
} else {
  $action = "resume/research_add";
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

// ISI fields, used for impact factor and Eigenfactor
$fields = array(
'1' => elgg_echo('resume:research:1'),
'2' => elgg_echo('resume:research:2'),
'3' => elgg_echo('resume:research:3'),
'4' => elgg_echo('resume:research:4'),
'5' => elgg_echo('resume:research:5'),
'6' => elgg_echo('resume:research:6'),
'7' => elgg_echo('resume:research:7'),
'8' => elgg_echo('resume:research:8'),
'9' => elgg_echo('resume:research:9'),
'10' => elgg_echo('resume:research:10'),
'11' => elgg_echo('resume:research:11'),
'12' => elgg_echo('resume:research:12'),
'13' => elgg_echo('resume:research:13'),
'14' => elgg_echo('resume:research:14'),
'15' => elgg_echo('resume:research:15'),
'16' => elgg_echo('resume:research:16'),
'17' => elgg_echo('resume:research:17'),
'18' => elgg_echo('resume:research:18'),
'19' => elgg_echo('resume:research:19'),
'20' => elgg_echo('resume:research:20'),
'21' => elgg_echo('resume:research:21'),
'22' => elgg_echo('resume:research:22'),
'23' => elgg_echo('resume:research:23'),
'24' => elgg_echo('resume:research:24'),
'25' => elgg_echo('resume:research:25'),
'26' => elgg_echo('resume:research:26'),
'27' => elgg_echo('resume:research:27'),
'28' => elgg_echo('resume:research:28'),
'29' => elgg_echo('resume:research:29'),
'30' => elgg_echo('resume:research:30'),
'31' => elgg_echo('resume:research:31'),
'32' => elgg_echo('resume:research:32'),
'33' => elgg_echo('resume:research:33'),
'34' => elgg_echo('resume:research:34'),
'35' => elgg_echo('resume:research:35'),
'36' => elgg_echo('resume:research:36'),
'37' => elgg_echo('resume:research:37'),
'38' => elgg_echo('resume:research:38'),
'39' => elgg_echo('resume:research:39'),
'40' => elgg_echo('resume:research:40'),
'41' => elgg_echo('resume:research:41'),
'42' => elgg_echo('resume:research:42'),
'43' => elgg_echo('resume:research:43'),
'44' => elgg_echo('resume:research:44'),
'45' => elgg_echo('resume:research:45'),
'46' => elgg_echo('resume:research:46'),
'47' => elgg_echo('resume:research:47'),
'48' => elgg_echo('resume:research:48'),
'49' => elgg_echo('resume:research:49'),
'50' => elgg_echo('resume:research:50'),
'51' => elgg_echo('resume:research:51'),
'52' => elgg_echo('resume:research:52'),
'53' => elgg_echo('resume:research:53'),
'54' => elgg_echo('resume:research:54'),
'55' => elgg_echo('resume:research:55'),
'56' => elgg_echo('resume:research:56'),
'57' => elgg_echo('resume:research:57'),
'58' => elgg_echo('resume:research:58'),
'59' => elgg_echo('resume:research:59'),
'60' => elgg_echo('resume:research:60'),
'61' => elgg_echo('resume:research:61'),
'62' => elgg_echo('resume:research:62'),
'63' => elgg_echo('resume:research:63'),
'64' => elgg_echo('resume:research:64'),
'65' => elgg_echo('resume:research:65'),
'66' => elgg_echo('resume:research:66'),
'67' => elgg_echo('resume:research:67'),
'68' => elgg_echo('resume:research:68'),
'69' => elgg_echo('resume:research:69'),
'70' => elgg_echo('resume:research:70'),
'71' => elgg_echo('resume:research:71'),
'72' => elgg_echo('resume:research:72'),
'73' => elgg_echo('resume:research:73'),
'74' => elgg_echo('resume:research:74'),
'75' => elgg_echo('resume:research:75'),
'76' => elgg_echo('resume:research:76'),
'77' => elgg_echo('resume:research:77'),
'78' => elgg_echo('resume:research:78'),
'79' => elgg_echo('resume:research:79'),
'80' => elgg_echo('resume:research:80'),
'81' => elgg_echo('resume:research:81'),
'82' => elgg_echo('resume:research:82'),
'83' => elgg_echo('resume:research:83'),
'84' => elgg_echo('resume:research:84'),
'85' => elgg_echo('resume:research:85'),
'86' => elgg_echo('resume:research:86'),
'87' => elgg_echo('resume:research:87'),
'88' => elgg_echo('resume:research:88'),
'89' => elgg_echo('resume:research:89'),
'90' => elgg_echo('resume:research:90'),
'91' => elgg_echo('resume:research:91'),
'92' => elgg_echo('resume:research:92'),
'93' => elgg_echo('resume:research:93'),
'94' => elgg_echo('resume:research:94'),
'95' => elgg_echo('resume:research:95'),
'96' => elgg_echo('resume:research:96'),
'97' => elgg_echo('resume:research:97'),
'98' => elgg_echo('resume:research:98'),
'99' => elgg_echo('resume:research:99'),
'100' => elgg_echo('resume:research:100'),
'101' => elgg_echo('resume:research:101'),
'102' => elgg_echo('resume:research:102'),
'103' => elgg_echo('resume:research:103'),
'104' => elgg_echo('resume:research:104'),
'105' => elgg_echo('resume:research:105'),
'106' => elgg_echo('resume:research:106'),
'107' => elgg_echo('resume:research:107'),
'108' => elgg_echo('resume:research:108'),
'109' => elgg_echo('resume:research:109'),
'110' => elgg_echo('resume:research:110'),
'111' => elgg_echo('resume:research:111'),
'112' => elgg_echo('resume:research:112'),
'113' => elgg_echo('resume:research:113'),
'114' => elgg_echo('resume:research:114'),
'115' => elgg_echo('resume:research:115'),
'116' => elgg_echo('resume:research:116'),
'117' => elgg_echo('resume:research:117'),
'118' => elgg_echo('resume:research:118'),
'119' => elgg_echo('resume:research:119'),
'120' => elgg_echo('resume:research:120'),
'121' => elgg_echo('resume:research:121'),
'122' => elgg_echo('resume:research:122'),
'123' => elgg_echo('resume:research:123'),
'124' => elgg_echo('resume:research:124'),
'125' => elgg_echo('resume:research:125'),
'126' => elgg_echo('resume:research:126'),
'127' => elgg_echo('resume:research:127'),
'128' => elgg_echo('resume:research:128'),
'129' => elgg_echo('resume:research:129'),
'130' => elgg_echo('resume:research:130'),
'131' => elgg_echo('resume:research:131'),
'132' => elgg_echo('resume:research:132'),
'133' => elgg_echo('resume:research:133'),
'134' => elgg_echo('resume:research:134'),
'135' => elgg_echo('resume:research:135'),
'136' => elgg_echo('resume:research:136'),
'137' => elgg_echo('resume:research:137'),
'138' => elgg_echo('resume:research:138'),
'139' => elgg_echo('resume:research:139'),
'140' => elgg_echo('resume:research:140'),
'141' => elgg_echo('resume:research:141'),
'142' => elgg_echo('resume:research:142'),
'143' => elgg_echo('resume:research:143'),
'144' => elgg_echo('resume:research:144'),
'145' => elgg_echo('resume:research:145'),
'146' => elgg_echo('resume:research:146'),
'147' => elgg_echo('resume:research:147'),
'148' => elgg_echo('resume:research:148'),
'149' => elgg_echo('resume:research:149'),
'150' => elgg_echo('resume:research:150'),
'151' => elgg_echo('resume:research:151'),
'152' => elgg_echo('resume:research:152'),
'153' => elgg_echo('resume:research:153'),
'154' => elgg_echo('resume:research:154'),
'155' => elgg_echo('resume:research:155'),
'156' => elgg_echo('resume:research:156'),
'157' => elgg_echo('resume:research:157'),
'158' => elgg_echo('resume:research:158'),
'159' => elgg_echo('resume:research:159'),
'160' => elgg_echo('resume:research:160'),
'161' => elgg_echo('resume:research:161'),
'162' => elgg_echo('resume:research:162'),
'163' => elgg_echo('resume:research:163'),
'164' => elgg_echo('resume:research:164'),
'165' => elgg_echo('resume:research:165'),
'166' => elgg_echo('resume:research:166'),
'167' => elgg_echo('resume:research:167'),
'168' => elgg_echo('resume:research:168'),
'169' => elgg_echo('resume:research:169'),
'170' => elgg_echo('resume:research:170'),
'171' => elgg_echo('resume:research:171'),
'172' => elgg_echo('resume:research:172'),
'173' => elgg_echo('resume:research:173'),
'174' => elgg_echo('resume:research:174'),
'175' => elgg_echo('resume:research:175'),
'176' => elgg_echo('resume:research:176'),
'177' => elgg_echo('resume:research:177'),
'178' => elgg_echo('resume:research:178'),
'179' => elgg_echo('resume:research:179'),
'180' => elgg_echo('resume:research:180'),
'181' => elgg_echo('resume:research:181'),
'182' => elgg_echo('resume:research:182'),
'183' => elgg_echo('resume:research:183'),
'184' => elgg_echo('resume:research:184'),
'185' => elgg_echo('resume:research:185'),
'186' => elgg_echo('resume:research:186'),
'187' => elgg_echo('resume:research:187'),
'188' => elgg_echo('resume:research:188'),
'189' => elgg_echo('resume:research:189'),
'190' => elgg_echo('resume:research:190'),
'191' => elgg_echo('resume:research:191'),
'192' => elgg_echo('resume:research:192'),
'193' => elgg_echo('resume:research:193'),
'194' => elgg_echo('resume:research:194'),
'195' => elgg_echo('resume:research:195'),
'196' => elgg_echo('resume:research:196'),
'197' => elgg_echo('resume:research:197'),
'198' => elgg_echo('resume:research:198'),
'199' => elgg_echo('resume:research:199'),
'200' => elgg_echo('resume:research:200'),
'201' => elgg_echo('resume:research:201'),
'202' => elgg_echo('resume:research:202'),
'203' => elgg_echo('resume:research:203'),
'204' => elgg_echo('resume:research:204'),
'205' => elgg_echo('resume:research:205'),
'206' => elgg_echo('resume:research:206'),
'207' => elgg_echo('resume:research:207'),
'208' => elgg_echo('resume:research:208'),
'209' => elgg_echo('resume:research:209'),
'210' => elgg_echo('resume:research:210'),
'211' => elgg_echo('resume:research:211'),
'212' => elgg_echo('resume:research:212'),
'213' => elgg_echo('resume:research:213'),
'214' => elgg_echo('resume:research:214'),
'215' => elgg_echo('resume:research:215'),
'216' => elgg_echo('resume:research:216'),
'217' => elgg_echo('resume:research:217'),
'218' => elgg_echo('resume:research:218'),
'219' => elgg_echo('resume:research:219'),
'220' => elgg_echo('resume:research:220'),
'221' => elgg_echo('resume:research:221'),
'222' => elgg_echo('resume:research:222'),
'223' => elgg_echo('resume:research:223'),
'224' => elgg_echo('resume:research:224'),
'225' => elgg_echo('resume:research:225'),
'226' => elgg_echo('resume:research:226'),
'227' => elgg_echo('resume:research:227'),
'228' => elgg_echo('resume:research:228'),
'229' => elgg_echo('resume:research:229'),
'230' => elgg_echo('resume:research:230'),
'231' => elgg_echo('resume:research:231'),
'232' => elgg_echo('resume:research:232'),
'233' => elgg_echo('resume:research:233'),
'234' => elgg_echo('resume:research:234'),
'235' => elgg_echo('resume:research:235'),
'236' => elgg_echo('resume:research:236'),
'237' => elgg_echo('resume:research:237'),
'238' => elgg_echo('resume:research:238'),
'239' => elgg_echo('resume:research:239'),
'240' => elgg_echo('resume:research:240'),
'241' => elgg_echo('resume:research:241'),
'242' => elgg_echo('resume:research:242'),
'243' => elgg_echo('resume:research:243'),
    );
$field = $vars['entity']->field;
if (empty($field)) $field_options = '<option disabled="disabled" selected="selected">-------</option>';
else $field_options = '<option value="' . $field . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:research:' . $field) . '</option>';
foreach ($fields as $f => $v) { $field_options .= '<option value="' .$f. '">' . $v . '</option>'; }

$prizes = array(
 'top10' =>  elgg_echo('resume:research:prizes:top10'),
 'top20' =>  elgg_echo('resume:research:prizes:top20'),
 'nobel' =>  elgg_echo('resume:research:prizes:nobel'),
 'fields' =>  elgg_echo('resume:research:prizes:fields'),
 'gairdner' =>  elgg_echo('resume:research:prizes:gairdner'),
 'lasker' =>  elgg_echo('resume:research:prizes:lasker'),
 'turing' =>  elgg_echo('resume:research:prizes:turing'),
 'engineering1' =>  elgg_echo('resume:research:prizes:engineering1'),
 'engineering2' =>  elgg_echo('resume:research:prizes:engineering2'),
 'engineering3' =>  elgg_echo('resume:research:prizes:engineering3'),
 'economics' =>  elgg_echo('resume:research:prizes:economics'),
 'fieldint' =>  elgg_echo('resume:research:prizes:fieldint'),
 'subfieldint' =>  elgg_echo('resume:research:prizes:subfieldint'),
 'fieldnat' =>  elgg_echo('resume:research:prizes:fieldnat'),
 'subfieldnat' =>  elgg_echo('resume:research:prizes:subfieldnat'),
 'fieldreg' =>  elgg_echo('resume:research:prizes:fieldreg'),
 'subfieldreg' =>  elgg_echo('resume:research:prizes:subfieldreg'),
 'academynat' =>  elgg_echo('resume:research:prizes:academynat'),
 'academyreg' =>  elgg_echo('resume:research:prizes:academyreg'),
);

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;

$divarticles = '<div style="float:left; width:60%; margin-right:15px">';
$divcitations = '<div style="float:left; width:12%; margin-right:10px">';
$divmaxcitations = '<div style="float:left; width:13%;">';
$divjournals = '<div style="float:left; width:60%; margin-right:15px">';
$divimpacts = '<div style="float:left; width:12%; margin-right:10px">';
$divmaximpacts = '<div style="float:left; width:12%;">';
$diveigens = '<div style="float:left; width:12%; margin-right:10px">';
$divmaxeigens = '<div style="float:left; width:12%; margin-right:20px">';
$divauthors = '<div style="float:left; width:13%; margin-right:10px">';
$divpositions = '<div style="float:left; width:12%; margin-right:25px">';
$divends = '<div style="float:left; width:32%;">';

$articles_array = $vars['entity']->articles;
$citations_array = $vars['entity']->citations;
$maxcitations_array = $vars['entity']->maxcitations;
$journals_array = $vars['entity']->journals;
$impacts_array = $vars['entity']->impacts;
$maximpacts_array = $vars['entity']->maximpacts;
$eigens_array = $vars['entity']->eigens;
$maxeigens_array = $vars['entity']->maxeigens;
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
          bodyText += '<?php echo $divarticles;?><?php echo elgg_echo('resume:research:article'); echo elgg_echo('resume:*');?><input type="text" name="articles[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divcitations;?><?php echo elgg_echo('resume:research:citation'); echo elgg_echo('resume:*');?><input type="text" name="citations[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divmaxcitations;?><?php echo elgg_echo('resume:research:maxcit'); echo elgg_echo('resume:*');?><input type="text" name="maxcitations[]" value="" class="input-text"/></div>';
         bodyText += '<div class="clearfloat"></div>'
          bodyText += '<?php echo $divjournals;?><?php echo elgg_echo('resume:research:journal'); echo elgg_echo('resume:*');?><input type="text" name="journals[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divimpacts;?><?php echo elgg_echo('resume:research:impact'); echo elgg_echo('resume:*');?><input type="text" name="impacts[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divmaximpacts;?><?php echo elgg_echo('resume:research:max'); echo elgg_echo('resume:*');?><input type="text" name="maximpacts[]" value="" class="input-text"/></div>';
         bodyText += '<div class="clearfloat"></div>'
          bodyText += '<?php echo $diveigens;?><?php echo elgg_echo('resume:research:eigen'); echo elgg_echo('resume:*');?><input type="text" name="eigens[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divmaxeigens;?><?php echo elgg_echo('resume:research:max'); echo elgg_echo('resume:*');?><input type="text" name="maxeigens[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divauthors;?><?php echo elgg_echo('resume:research:author'); echo elgg_echo('resume:*');?><input type="text" name="authors[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divpositions;?><?php echo elgg_echo('resume:research:position'); echo elgg_echo('resume:*');?><input type="text" name="positions[]" value="" class="input-text"/></div>';
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
      <?php echo elgg_echo('resume:research:heading'); 
      echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <div style="float:left; width:90%;">
      <?php echo elgg_echo('resume:research:structure'); 
      echo elgg_echo('resume:*');?><br />
     <?php 
      if (isset($vars['entity'])){
         $university = $vars['entity']->structure;
            $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_university_entity
                     WHERE university_id='$university'";
            $result = get_data_row($query);
              $uniname = $result->name; 
      }
      echo elgg_view('input/autocomplete', array('internalname' => 'structure', 'match_on' => 'universities',
          'value' => $vars['entity']->structure, 'value_show' => $uniname)); ?>
        </div>
    
    <div class="clearfloat"></div><br />
    
    
     <div style="float:left; width:90%;">
      <?php echo elgg_echo('resume:research:level');
      echo elgg_echo('resume:*');?><br />
      <select name="level" class="input-pulldown" style="width:100%;"><?php echo $level_options; ?></select>
     </div>
   
    <div class="clearfloat"></div><br />
    
    
    <div style="float:left; width:90%;">
      <?php echo elgg_echo('resume:research:field'); 
      echo elgg_echo('resume:*');?><br />
      <select name="field" class="input-pulldown"><?php echo $field_options; ?></select>
    </div>
    
    <div class="clearfloat"></div><br />
    
    <div style="float:left; width:90%;">
      <?php 
      echo elgg_echo('resume:research:prize'); 
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
    echo elgg_echo('resume:research:article');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "articles[]", 'value' => ""));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:research:citation');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "citations[]", 'value' => ""));
       echo "</div>";
       echo $divmaxcitations;
    echo elgg_echo('resume:research:maxcit');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maxcitations[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $divjournals;
    echo elgg_echo('resume:research:journal');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "journals[]", 'value' => ""));
       echo "</div>";
       echo $divimpacts;
    echo elgg_echo('resume:research:impact');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "impacts[]", 'value' => ""));
       echo "</div>";
       echo $divmaximpacts;
    echo elgg_echo('resume:research:max');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maximpacts[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $diveigens;
    echo elgg_echo('resume:research:eigen');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "eigens[]", 'value' => ""));
       echo "</div>";
       echo $divmaxeigens;
    echo elgg_echo('resume:research:max');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maxeigens[]", 'value' => ""));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:research:author');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "authors[]", 'value' => ""));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:research:position');
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
    echo elgg_echo('resume:research:article');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "articles[]", 'value' => ""));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:research:citation');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "citations[]", 'value' => ""));
       echo "</div>";
       echo $divmaxcitations;
    echo elgg_echo('resume:research:maxcit');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maxcitations[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $divjournals;
    echo elgg_echo('resume:research:journal');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "journals[]", 'value' => ""));
       echo "</div>";
       echo $divimpacts;
    echo elgg_echo('resume:research:impact');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "impacts[]", 'value' => ""));
       echo "</div>";
       echo $divmaximpacts;
    echo elgg_echo('resume:research:max');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maximpacts[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $diveigens;
    echo elgg_echo('resume:research:eigen');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "eigens[]", 'value' => ""));
       echo "</div>";
       echo $divmaxeigens;
    echo elgg_echo('resume:research:max');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maxeigens[]", 'value' => ""));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:research:author');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "authors[]", 'value' => ""));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:research:position');
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
    echo elgg_echo('resume:research:article');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "articles[]", 'value' => $articles_array[$i]));
       echo "</div>";
       echo $divcitations;
    echo elgg_echo('resume:research:citation');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "citations[]", 'value' => $citations_array[$i]));
       echo "</div>";
       echo $divmaxcitations;
    echo elgg_echo('resume:research:maxcit');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maxcitations[]", 'value' => $maxcitations_array[$i]));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $divjournals;
    echo elgg_echo('resume:research:journal');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "journals[]", 'value' => $journals_array[$i]));
       echo "</div>";
       echo $divimpacts;
    echo elgg_echo('resume:research:impact');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "impacts[]", 'value' => $impacts_array[$i]));
       echo "</div>";
       echo $divmaximpacts;
    echo elgg_echo('resume:research:max');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maximpacts[]", 'value' => $maximpacts_array[$i]));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $diveigens;
    echo elgg_echo('resume:research:eigen');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "eigens[]", 'value' => $eigens_array[$i]));
       echo "</div>";
       echo $divmaxeigens;
    echo elgg_echo('resume:research:max');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "maxeigens[]", 'value' => $maxeigens_array[$i]));
       echo "</div>";
       echo $divauthors;
    echo elgg_echo('resume:research:author');
    echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "authors[]", 'value' => $authors_array[$i]));
       echo "</div>";
       echo $divpositions;
    echo elgg_echo('resume:research:position');
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
   
     <input type="button" value="<?php echo elgg_echo('resume:research:addarticle'); ?>" onClick="addInput('dynamicInput');">
   
   <br /><br />

    <p>
      <?php echo elgg_echo('resume:research:contact'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:research:description'); ?><br />
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
