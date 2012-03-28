<?php
/**
 * cvranking_form arrays
 */

$times = array (
    "" => "",
    "age" => elgg_echo('resume:cvranking:time:age'),
    "prog" => elgg_echo('resume:cvranking:time:prog'),
    "exp" => elgg_echo('resume:cvranking:time:exp'),
    );

$fields['any'] = elgg_echo('resume:cvranking:any');
  
$countries['any'] = elgg_echo('resume:country:any');

$credittypes['any'] = elgg_echo('resume:cvranking:credittype:any');

$edutypes['any'] = elgg_echo('resume:cvranking:credittype:any');   

$edudbs = array(
    'any' => elgg_echo('resume:cvranking:edudb:any'),
    'CVR_QS12' => elgg_echo('resume:cvranking:edudb:QS12'),
    'CVR_THE12' => elgg_echo('resume:cvranking:edudb:THE12'),
    'CVR_ARWU12' => elgg_echo('resume:cvranking:edudb:ARWU12'),
    'CVR_PISA09' => elgg_echo('resume:cvranking:edudb:PISA09'),
    'CVR_USNewsU12' => elgg_echo('resume:cvranking:edudb:USNewsU12'),
    'CVR_USNewsG12' => elgg_echo('resume:cvranking:edudb:USNewsG12'),
    'CVR_UK12' => elgg_echo('resume:cvranking:edudb:UK12'),
    'CVR_DEChe12' => elgg_echo('resume:cvranking:edudb:DEChe12'), 
    'CVR_ESISI12' => elgg_echo('resume:cvranking:edudb:ESISI12'),    
  );

$sectors['any'] = elgg_echo('resume:cvranking:any');  
    
$workdbs = array(
    'any' => elgg_echo('resume:cvranking:any'),
    'CVR_company_entity' => elgg_echo('resume:work:sectortype:general'),  
    'CVR_QS12' => elgg_echo('resume:work:sectortype:QS12'),
    'CVR_SCImago12' => elgg_echo('resume:work:sectortype:SCImago12'),
    'CVR_USNewsH12' => elgg_echo('resume:work:sectortype:USNewsH12'), 
  );

$industryclasses['any'] = elgg_echo('resume:cvranking:any');  

$langs['any'] = elgg_echo('resume:cvranking:credittype:any');

$langdbs = array (
    "weber" => elgg_echo('resume:languages:databases:weber'),
    "forbes" => elgg_echo('resume:languages:databases:forbes'),
    "equal" => elgg_echo('resume:languages:databases:equal'),
    "first" => elgg_echo('resume:languages:databases:first'),
    "second" => elgg_echo('resume:languages:databases:second'),
    "combined" => elgg_echo('resume:languages:databases:combined'),
    );

$resfields['any'] = elgg_echo('resume:cvranking:any');

$typologies['any'] = elgg_echo('resume:cvranking:any');  

$skilltypes['any'] = elgg_echo('resume:cvranking:any');  

$orders = array(
    '' => '',
    'User' => elgg_echo('resume:cvranking:order:User'),
    'CVRasc' => elgg_echo('resume:cvranking:order:CVRasc'),
    'CVRdesc' => elgg_echo('resume:cvranking:order:CVRdesc'),
    'Alfaasc' => elgg_echo('resume:cvranking:order:Alfaasc'),
    'Alfadesc' => elgg_echo('resume:cvranking:order:Alfadesc'),    
  );
 
$cvrtypes = array(
   elgg_echo('resume:cvranking:cvrtype:Education') => 'education',    
   elgg_echo('resume:cvranking:cvrtype:Work') => 'workexperience',
   elgg_echo('resume:cvranking:cvrtype:Language') => 'language',
   elgg_echo('resume:cvranking:cvrtype:Research') => 'research',
   elgg_echo('resume:cvranking:cvrtype:Publications') => 'publication',
   elgg_echo('resume:cvranking:cvrtype:Skill') => 'skill',
   elgg_echo('resume:cvranking:cvrtype:Experience') => 'experience',
  );

$advanceds = array(
    '' => '',
    'ISCED0' => elgg_echo('resume:cvranking:advanced:ISCED0'),
    'ISCED010' => elgg_echo('resume:cvranking:advanced:ISCED010'),  
    'ISCED020' => elgg_echo('resume:cvranking:advanced:ISCED020'),
    'ISCED1' => elgg_echo('resume:cvranking:advanced:ISCED1'),
    'ISCED2' => elgg_echo('resume:cvranking:advanced:ISCED2'),
    'ISCED2-1' => elgg_echo('resume:cvranking:advanced:ISCED2-1'),   
    'ISCED2-2' => elgg_echo('resume:cvranking:advanced:ISCED2-2'),   
    'ISCED2-3' => elgg_echo('resume:cvranking:advanced:ISCED2-3'),  
    'ISCED2-4' => elgg_echo('resume:cvranking:advanced:ISCED2-4'), 
    'ISCED3' => elgg_echo('resume:cvranking:advanced:ISCED3'), 
    'ISCED3-1' => elgg_echo('resume:cvranking:advanced:ISCED3-1'), 
    'ISCED3-2' => elgg_echo('resume:cvranking:advanced:ISCED3-2'), 
    'ISCED3-3' => elgg_echo('resume:cvranking:advanced:ISCED3-3'),  
    'ISCED3-4' => elgg_echo('resume:cvranking:advanced:ISCED3-4'),
    'ISCED4' => elgg_echo('resume:cvranking:advanced:ISCED4'),
    'ISCED4-1' => elgg_echo('resume:cvranking:advanced:ISCED4-1'),
    'ISCED4-3' => elgg_echo('resume:cvranking:advanced:ISCED4-3'), 
    'ISCED4-4' => elgg_echo('resume:cvranking:advanced:ISCED4-4'), 
    'ISCED5' => elgg_echo('resume:cvranking:advanced:ISCED5'),   
    'ISCED5-1' => elgg_echo('resume:cvranking:advanced:ISCED5-1'),   
    'ISCED5-4' => elgg_echo('resume:cvranking:advanced:ISCED5-4'),  
    'ISCED6' => elgg_echo('resume:cvranking:advanced:ISCED6'),   
    'ISCED6-1' => elgg_echo('resume:cvranking:advanced:ISCED6-1'),  
    'ISCED6-5' => elgg_echo('resume:cvranking:advanced:ISCED6-5'), 
    'ISCED6-6' => elgg_echo('resume:cvranking:advanced:ISCED6-6'), 
    'ISCED6-7' => elgg_echo('resume:cvranking:advanced:ISCED6-7'), 
    'ISCED7' => elgg_echo('resume:cvranking:advanced:ISCED7'), 
    'ISCED7-1' => elgg_echo('resume:cvranking:advanced:ISCED7-1'),  
    'ISCED7-6' => elgg_echo('resume:cvranking:advanced:ISCED7-6'),
    'ISCED7-7' => elgg_echo('resume:cvranking:advanced:ISCED7-7'),
    'ISCED7-8' => elgg_echo('resume:cvranking:advanced:ISCED7-8'), 
    'ISCED8' => elgg_echo('resume:cvranking:advanced:ISCED8'), 
    'ISCED8-1' => elgg_echo('resume:cvranking:advanced:ISCED8-1'), 
    'ISCED8-4' => elgg_echo('resume:cvranking:advanced:ISCED8-4'),
    'ISCED999' => elgg_echo('resume:cvranking:advanced:ISCED999'),  
    'ISCED-4-' => elgg_echo('resume:cvranking:advanced:ISCED-4-'),
    'ISCED-5-' => elgg_echo('resume:cvranking:advanced:ISCED-5-'),
    'ISCED-6-' => elgg_echo('resume:cvranking:advanced:ISCED-6-'),
    'edudbgen' => elgg_echo('resume:cvranking:advanced:edudbgen'), 
        "exam" => elgg_echo('resume:cvranking:advanced:exam'), 
        "accessexam" => elgg_echo('resume:cvranking:advanced:accessexam'), 
        "stateexam" => elgg_echo('resume:cvranking:advanced:stateexam'), 
        "officialexam" => elgg_echo('resume:cvranking:advanced:officialexam'), 
        "privateexam" => elgg_echo('resume:cvranking:advanced:privateexam'), 
             "crank" => elgg_echo('resume:cvranking:advanced:crank'), 
             "powerrank" => elgg_echo('resume:cvranking:advanced:powerrank'), 
             "intprize" => elgg_echo('resume:cvranking:advanced:intprize'), 
             "natprize" => elgg_echo('resume:cvranking:advanced:natprize'), 
             "regprize" => elgg_echo('resume:cvranking:advanced:regprize'), 
             "instprize" => elgg_echo('resume:cvranking:advanced:instprize'), 
             "classprize" => elgg_echo('resume:cvranking:advanced:classprize'), 
             "maxwage" => elgg_echo('resume:cvranking:advanced:maxwage'), 
             "difflang" => elgg_echo('resume:cvranking:advanced:difflang'), 
             "lang0" => elgg_echo('resume:cvranking:advanced:lang0'), 
             "langI" => elgg_echo('resume:cvranking:advanced:langI'), 
             "langII" => elgg_echo('resume:cvranking:advanced:langII'), 
             "langIII" => elgg_echo('resume:cvranking:advanced:langIII'), 
             "langIV" => elgg_echo('resume:cvranking:advanced:langIV'), 
             "langV" => elgg_echo('resume:cvranking:advanced:langV'), 
             "mother" => elgg_echo('resume:cvranking:advanced:mother'), 
             "mother2" => elgg_echo('resume:cvranking:advanced:mother2'), 
             "foreign2" => elgg_echo('resume:cvranking:advanced:foreign2'), 
             "minlang1" => elgg_echo('resume:cvranking:advanced:minlang1'), 
             "minlang2" => elgg_echo('resume:cvranking:advanced:minlang2'), 
             "maxlang2" => elgg_echo('resume:cvranking:advanced:maxlang2'), 
             "impact" => elgg_echo('resume:cvranking:advanced:impact'), 
             "eigen" => elgg_echo('resume:cvranking:advanced:eigen'), 
             "resyear" => elgg_echo('resume:cvranking:advanced:resyear'), 
             "WOK" => elgg_echo('resume:cvranking:advanced:WOK'), 
             "GOOG" => elgg_echo('resume:cvranking:advanced:GOOG'), 
             "prcited" => elgg_echo('resume:cvranking:advanced:prcited'), 
             "prnobel" => elgg_echo('resume:cvranking:advanced:prnobel'), 
             "prother" => elgg_echo('resume:cvranking:advanced:prother'), 
             "posfactor" => elgg_echo('resume:cvranking:advanced:posfactor'), 
             "levelfactor" => elgg_echo('resume:cvranking:advanced:levelfactor'), 
             "live" => elgg_echo('resume:cvranking:advanced:live'), 
             "written" => elgg_echo('resume:cvranking:advanced:written'), 
             "media" => elgg_echo('resume:cvranking:advanced:media'), 
             "VIEW" => elgg_echo('resume:cvranking:advanced:VIEW'), 
             "SOLD" => elgg_echo('resume:cvranking:advanced:SOLD'), 
             "skillyear" => elgg_echo('resume:cvranking:advanced:skillyear'), 
             "skillcoef" => elgg_echo('resume:cvranking:advanced:skillcoef'), 
    "ratemult"=> elgg_echo('resume:cvranking:advanced:ratemult'), 
    "rateadd" => elgg_echo('resume:cvranking:advanced:rateadd'), 
    'maxscore' => elgg_echo('resume:cvranking:advanced:maxscore'),
    'z' => elgg_echo('resume:cvranking:advanced:z'),
  );

foreach ($advanceds as $kh => $kt) { $advanced_options .= '<option value="' .$kh. '">' . $kt . '</option>'; }
