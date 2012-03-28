<?php

// Decide wich action to use based on if its and edit or add use case.
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/language_add"; }


// Language ISO codes
$langs = array(
'abk',
'aar',
'afr',
'aka',
'sqi',
'gsw',
'amh',
'ara',
'arg',
'hye',
'asm',
'ava',
'ave',
'aym',
'aze',
'bam',
'bak',
'eus',
'bel',
'ben',
'bih',
'bis',
'bjn',
'bos',
'bre',
'bul',
'mya',
'cat',
'cha',
'che',
'nya',
'zho',
'cdo',
'cjy',
'cmn',
'cpx',
'czh',
'czo',
'gan',
'hak',
'hsn',
'mnp',
'nan',
'wuu',
'yue',
'chv',
'cor',
'cos',
'cre',
'hrv',
'ces',
'dan',
'day',
'div',
'nld',
'dzo',
'eng',
'epo',
'est',
'ewe',
'fao',
'fij',
'fin',
'fra',
'ful',
'glg',
'kat',
'deu',
'ell',
'grn',
'guj',
'hat',
'hau',
'heb',
'her',
'hin',
'hmo',
'hun',
'ina',
'ind',
'ile',
'gle',
'ibo',
'ipk',
'ido',
'isl',
'ita',
'iku',
'jpn',
'jav',
'kal',
'kan',
'kau',
'kas',
'kaz',
'khm',
'kik',
'kin',
'kir',
'kom',
'kon',
'kor',
'kur',
'kua',
'lat',
'ltz',
'lug',
'lim',
'lin',
'lao',
'lit',
'lub',
'lav',
'glv',
'mkd',
'mlg',
'msa',
'mal',
'mlt',
'mri',
'mar',
'mah',
'mon',
'nau',
'nav',
'nob',
'nde',
'nep',
'ndo',
'nno',
'nor',
'iii',
'nbl',
'oci',
'oji',
'chu',
'orm',
'ori',
'oss',
'pan',
'pli',
'fas',
'pol',
'pus',
'por',
'que',
'roh',
'run',
'ron',
'rus',
'san',
'srd',
'snd',
'sme',
'smo',
'sag',
'srp',
'gla',
'sna',
'sin',
'slk',
'slv',
'som',
'sot',
'spa',
'sun',
'swa',
'ssw',
'swe',
'tam',
'tel',
'tgk',
'tha',
'tir',
'bod',
'tuk',
'tgl',
'tsn',
'ton',
'tur',
'tso',
'tat',
'twi',
'tah',
'uig',
'ukr',
'urd',
'uzb',
'ven',
'vie',
'vol',
'wln',
'cym',
'wol',
'fry',
'xho',
'yid',
'yor',
'zha',
'zul',
);

$language = $vars['entity']->language;
if (empty($language)) $language_options = '<option disabled="disabled" selected="selected">-------</option>';
else $language_options = '<option value="' . $language . '" selected="selected">&raquo;&nbsp;' . elgg_echo("resume:languages:$language") . ' (' . $language . ')</option>';
foreach ($langs as $lang) { $language_options .= '<option value="' .$lang. '">' .elgg_echo("resume:languages:$lang"). ' (' .$lang. ')</option>'; }

$countries = array(
'United States' => elgg_echo('resume:country:United States'),
'United Kingdom' => elgg_echo('resume:country:United Kingdom'),
'Afghanistan' => elgg_echo('resume:country:Afghanistan'),
'Albania' => elgg_echo('resume:country:Albania'),
'Algeria' => elgg_echo('resume:country:Algeria'),
'American Samoa' => elgg_echo('resume:country:American Samoa'),
'Andorra' => elgg_echo('resume:country:Andorra'),
'Angola' => elgg_echo('resume:country:Angola'),
'Anguilla' => elgg_echo('resume:country:Anguilla'),
'Antigua & Barbuda' => elgg_echo('resume:country:Antigua & Barbuda'),
'Argentina' => elgg_echo('resume:country:Argentina'),
'Armenia' => elgg_echo('resume:country:Armenia'),
'Aruba' => elgg_echo('resume:country:Aruba'),
'Australia' => elgg_echo('resume:country:Australia'),
'Austria' => elgg_echo('resume:country:Austria'),
'Azerbaijan' => elgg_echo('resume:country:Azerbaijan'),
'Bahamas' => elgg_echo('resume:country:Bahamas'),
'Bahrain' => elgg_echo('resume:country:Bahrain'),
'Bangladesh' => elgg_echo('resume:country:Bangladesh'),
'Barbados' => elgg_echo('resume:country:Barbados'),
'Belarus' => elgg_echo('resume:country:Belarus'),
'Belgium' => elgg_echo('resume:country:Belgium'),
'Belize' => elgg_echo('resume:country:Belize'),
'Benin' => elgg_echo('resume:country:Benin'),
'Bermuda' => elgg_echo('resume:country:Bermuda'),
'Bhutan' => elgg_echo('resume:country:Bhutan'),
'Bolivia' => elgg_echo('resume:country:Bolivia'),
'Bonaire' => elgg_echo('resume:country:Bonaire'),
'Bosnia & Herzegovina' => elgg_echo('resume:country:Bosnia & Herzegovina'),
'Botswana' => elgg_echo('resume:country:Botswana'),
'Brazil' => elgg_echo('resume:country:Brazil'),
'British Indian Ocean Ter' => elgg_echo('resume:country:British Indian Ocean Ter'),
'Brunei' => elgg_echo('resume:country:Brunei'),
'Bulgaria' => elgg_echo('resume:country:Bulgaria'),
'Burkina Faso' => elgg_echo('resume:country:Burkina Faso'),
'Burundi' => elgg_echo('resume:country:Burundi'),
'Cambodia' => elgg_echo('resume:country:Cambodia'),
'Cameroon' => elgg_echo('resume:country:Cameroon'),
'Canada' => elgg_echo('resume:country:Canada'),
'Cape Verde' => elgg_echo('resume:country:Cape Verde'),
'Cayman Islands' => elgg_echo('resume:country:Cayman Islands'),
'Central African Republic' => elgg_echo('resume:country:Central African Republic'),
'Chad' => elgg_echo('resume:country:Chad'),
'Channel Islands' => elgg_echo('resume:country:Channel Islands'),
'Chile' => elgg_echo('resume:country:Chile'),
'China' => elgg_echo('resume:country:China'),
'Christmas Island' => elgg_echo('resume:country:Christmas Island'),
'Cocos Island' => elgg_echo('resume:country:Cocos Island'),
'Colombia' => elgg_echo('resume:country:Colombia'),
'Comoros' => elgg_echo('resume:country:Comoros'),
'Congo' => elgg_echo('resume:country:Congo'),
'Cook Islands' => elgg_echo('resume:country:Cook Islands'),
'Costa Rica' => elgg_echo('resume:country:Costa Rica'),
'Cote DIvoire' => elgg_echo('resume:country:Cote DIvoire'),
'Croatia' => elgg_echo('resume:country:Croatia'),
'Cuba' => elgg_echo('resume:country:Cuba'),
'Curaco' => elgg_echo('resume:country:Curacao'),
'Cyprus' => elgg_echo('resume:country:Cyprus'),
'Czech Republic' => elgg_echo('resume:country:Czech Republic'),
'Denmark' => elgg_echo('resume:country:Denmark'),
'Djibouti' => elgg_echo('resume:country:Djibouti'),
'Dominica' => elgg_echo('resume:country:Dominica'),
'Dominican Republic' => elgg_echo('resume:country:Dominican Republic'),
'East Timor' => elgg_echo('resume:country:East Timor'),
'Ecuador' => elgg_echo('resume:country:Ecuador'),
'Egypt' => elgg_echo('resume:country:Egypt'),
'El Salvador' => elgg_echo('resume:country:El Salvador'),
'Equatorial Guinea' => elgg_echo('resume:country:Equatorial Guinea'),
'Eritrea' => elgg_echo('resume:country:Eritrea'),
'Estonia' => elgg_echo('resume:country:Estonia'),
'Ethiopia' => elgg_echo('resume:country:Ethiopia'),
'Falkland Islands' => elgg_echo('resume:country:Falkland Islands'),
'Faroe Islands' => elgg_echo('resume:country:Faroe Islands'),
'Fiji' => elgg_echo('resume:country:Fiji'),
'Finland' => elgg_echo('resume:country:Finland'),
'France' => elgg_echo('resume:country:France'),
'French Guiana' => elgg_echo('resume:country:French Guiana'),
'French Polynesia' => elgg_echo('resume:country:French Polynesia'),
'French Southern Ter' => elgg_echo('resume:country:French Southern Ter'),
'Gabon' => elgg_echo('resume:country:Gabon'),
'Gambia' => elgg_echo('resume:country:Gambia'),
'Georgia' => elgg_echo('resume:country:Georgia'),
'Germany' => elgg_echo('resume:country:Germany'),
'Ghana' => elgg_echo('resume:country:Ghana'),
'Gibraltar' => elgg_echo('resume:country:Gibraltar'),
'Greece' => elgg_echo('resume:country:Greece'),
'Greenland' => elgg_echo('resume:country:Greenland'),
'Grenada' => elgg_echo('resume:country:Grenada'),
'Guadeloupe' => elgg_echo('resume:country:Guadeloupe'),
'Guam' => elgg_echo('resume:country:Guam'),
'Guatemala' => elgg_echo('resume:country:Guatemala'),
'Guinea' => elgg_echo('resume:country:Guinea'),
'Guyana' => elgg_echo('resume:country:Guyana'),
'Haiti' => elgg_echo('resume:country:Haiti'),
'Honduras' => elgg_echo('resume:country:Honduras'),
'Hong Kong' => elgg_echo('resume:country:Hong Kong'),
'Hungary' => elgg_echo('resume:country:Hungary'),
'Iceland' => elgg_echo('resume:country:Iceland'),
'India' => elgg_echo('resume:country:India'),
'Indonesia' => elgg_echo('resume:country:Indonesia'),
'Iran' => elgg_echo('resume:country:Iran'),
'Iraq' => elgg_echo('resume:country:Iraq'),
'Ireland' => elgg_echo('resume:country:Ireland'),
'Isle of Man' => elgg_echo('resume:country:Isle of Man'),
'Israel' => elgg_echo('resume:country:Israel'),
'Italy' => elgg_echo('resume:country:Italy'),
'Jamaica' => elgg_echo('resume:country:Jamaica'),
'Japan' => elgg_echo('resume:country:Japan'),
'Jordan' => elgg_echo('resume:country:Jordan'),
'Kazakhstan' => elgg_echo('resume:country:Kazakhstan'),
'Kenya' => elgg_echo('resume:country:Kenya'),
'Kiribati' => elgg_echo('resume:country:Kiribati'),
'Korea North' => elgg_echo('resume:country:Korea North'),
'Korea' => elgg_echo('resume:country:Korea'),
'Kuwait' => elgg_echo('resume:country:Kuwait'),
'Kyrgyzstan' => elgg_echo('resume:country:Kyrgyzstan'),
'Laos' => elgg_echo('resume:country:Laos'),
'Latvia' => elgg_echo('resume:country:Latvia'),
'Lebanon' => elgg_echo('resume:country:Lebanon'),
'Lesotho' => elgg_echo('resume:country:Lesotho'),
'Liberia' => elgg_echo('resume:country:Liberia'),
'Libya' => elgg_echo('resume:country:Libya'),
'Liechtenstein' => elgg_echo('resume:country:Liechtenstein'),
'Lithuania' => elgg_echo('resume:country:Lithuania'),
'Luxembourg' => elgg_echo('resume:country:Luxembourg'),
'Macau' => elgg_echo('resume:country:Macau'),
'Macedonia' => elgg_echo('resume:country:Macedonia'),
'Madagascar' => elgg_echo('resume:country:Madagascar'),
'Malaysia' => elgg_echo('resume:country:Malaysia'),
'Malawi' => elgg_echo('resume:country:Malawi'),
'Maldives' => elgg_echo('resume:country:Maldives'),
'Mali' => elgg_echo('resume:country:Mali'),
'Malta' => elgg_echo('resume:country:Malta'),
'Marshall Islands' => elgg_echo('resume:country:Marshall Islands'),
'Martinique' => elgg_echo('resume:country:Martinique'),
'Mauritania' => elgg_echo('resume:country:Mauritania'),
'Mauritius' => elgg_echo('resume:country:Mauritius'),
'Mayotte' => elgg_echo('resume:country:Mayotte'),
'Mexico' => elgg_echo('resume:country:Mexico'),
'Midway Islands' => elgg_echo('resume:country:Midway Islands'),
'Moldova' => elgg_echo('resume:country:Moldova'),
'Monaco' => elgg_echo('resume:country:Monaco'),
'Mongolia' => elgg_echo('resume:country:Mongolia'),
'Montenegro' => elgg_echo('resume:country:Montenegro'),
'Montserrat' => elgg_echo('resume:country:Montserrat'),
'Morocco' => elgg_echo('resume:country:Morocco'),
'Mozambique' => elgg_echo('resume:country:Mozambique'),
'Myanmar' => elgg_echo('resume:country:Myanmar'),
'Nambia' => elgg_echo('resume:country:Nambia'),
'Nauru' => elgg_echo('resume:country:Nauru'),
'Nepal' => elgg_echo('resume:country:Nepal'),
'Netherland Antilles' => elgg_echo('resume:country:Netherland Antilles'),
'Netherlands' => elgg_echo('resume:country:Netherlands (Holland, Europe)'),
'Nevis' => elgg_echo('resume:country:Nevis'),
'New Caledonia' => elgg_echo('resume:country:New Caledonia'),
'New Zealand' => elgg_echo('resume:country:New Zealand'),
'Nicaragua' => elgg_echo('resume:country:Nicaragua'),
'Niger' => elgg_echo('resume:country:Niger'),
'Nigeria' => elgg_echo('resume:country:Nigeria'),
'Niue' => elgg_echo('resume:country:Niue'),
'Norfolk Island' => elgg_echo('resume:country:Norfolk Island'),
'Norway' => elgg_echo('resume:country:Norway'),
'Oman' => elgg_echo('resume:country:Oman'),
'Pakistan' => elgg_echo('resume:country:Pakistan'),
'Palau Island' => elgg_echo('resume:country:Palau Island'),
'Palestine' => elgg_echo('resume:country:Palestine'),
'Panama' => elgg_echo('resume:country:Panama'),
'Papua New Guinea' => elgg_echo('resume:country:Papua New Guinea'),
'Paraguay' => elgg_echo('resume:country:Paraguay'),
'Peru' => elgg_echo('resume:country:Peru'),
'Phillipines' => elgg_echo('resume:country:Philippines'),
'Pitcairn Island' => elgg_echo('resume:country:Pitcairn Island'),
'Poland' => elgg_echo('resume:country:Poland'),
'Portugal' => elgg_echo('resume:country:Portugal'),
'Puerto Rico' => elgg_echo('resume:country:Puerto Rico'),
'Qatar' => elgg_echo('resume:country:Qatar'),
'Reunion' => elgg_echo('resume:country:Reunion'),
'Romania' => elgg_echo('resume:country:Romania'),
'Russia' => elgg_echo('resume:country:Russia'),
'Rwanda' => elgg_echo('resume:country:Rwanda'),
'St Barthelemy' => elgg_echo('resume:country:St Barthelemy'),
'St Eustatius' => elgg_echo('resume:country:St Eustatius'),
'St Helena' => elgg_echo('resume:country:St Helena'),
'St Kitts-Nevis' => elgg_echo('resume:country:St Kitts-Nevis'),
'St Lucia' => elgg_echo('resume:country:St Lucia'),
'St Maarten' => elgg_echo('resume:country:St Maarten'),
'St Pierre & Miquelon' => elgg_echo('resume:country:St Pierre & Miquelon'),
'St Vincent & Grenadines' => elgg_echo('resume:country:St Vincent & Grenadines'),
'Saipan' => elgg_echo('resume:country:Saipan'),
'Samoa' => elgg_echo('resume:country:Samoa'),
'Samoa American' => elgg_echo('resume:country:Samoa American'),
'San Marino' => elgg_echo('resume:country:San Marino'),
'Sao Tome & Principe' => elgg_echo('resume:country:Sao Tome & Principe'),
'Saudi Arabia' => elgg_echo('resume:country:Saudi Arabia'),
'Senegal' => elgg_echo('resume:country:Senegal'),
'Serbia' => elgg_echo('resume:country:Serbia'),
'Seychelles' => elgg_echo('resume:country:Seychelles'),
'Sierra Leone' => elgg_echo('resume:country:Sierra Leone'),
'Singapore' => elgg_echo('resume:country:Singapore'),
'Slovakia' => elgg_echo('resume:country:Slovakia'),
'Slovenia' => elgg_echo('resume:country:Slovenia'),
'Solomon Islands' => elgg_echo('resume:country:Solomon Islands'),
'Somalia' => elgg_echo('resume:country:Somalia'),
'South Africa' => elgg_echo('resume:country:South Africa'),
'Spain' => elgg_echo('resume:country:Spain'),
'Sri Lanka' => elgg_echo('resume:country:Sri Lanka'),
'Sudan' => elgg_echo('resume:country:Sudan'),
'Suriname' => elgg_echo('resume:country:Suriname'),
'Swaziland' => elgg_echo('resume:country:Swaziland'),
'Sweden' => elgg_echo('resume:country:Sweden'),
'Switzerland' => elgg_echo('resume:country:Switzerland'),
'Syria' => elgg_echo('resume:country:Syria'),
'Tahiti' => elgg_echo('resume:country:Tahiti'),
'Taiwan' => elgg_echo('resume:country:Taiwan'),
'Tajikistan' => elgg_echo('resume:country:Tajikistan'),
'Tanzania' => elgg_echo('resume:country:Tanzania'),
'Thailand' => elgg_echo('resume:country:Thailand'),
'Togo' => elgg_echo('resume:country:Togo'),
'Tokelau' => elgg_echo('resume:country:Tokelau'),
'Tonga' => elgg_echo('resume:country:Tonga'),
'Trinidad & Tobago' => elgg_echo('resume:country:Trinidad & Tobago'),
'Tunisia' => elgg_echo('resume:country:Tunisia'),
'Turkey' => elgg_echo('resume:country:Turkey'),
'Turkmenistan' => elgg_echo('resume:country:Turkmenistan'),
'Turks & Caicos Is' => elgg_echo('resume:country:Turks & Caicos Is'),
'Tuvalu' => elgg_echo('resume:country:Tuvalu'),
'Uganda' => elgg_echo('resume:country:Uganda'),
'Ukraine' => elgg_echo('resume:country:Ukraine'),
'United Arab Emirates' => elgg_echo('resume:country:United Arab Emirates'),
'United Kingdom' => elgg_echo('resume:country:United Kingdom'),
'United States' => elgg_echo('resume:country:United States'),
'Uraguay' => elgg_echo('resume:country:Uruguay'),
'Uzbekistan' => elgg_echo('resume:country:Uzbekistan'),
'Vanuatu' => elgg_echo('resume:country:Vanuatu'),
'Vatican City State' => elgg_echo('resume:country:Vatican City State'),
'Venezuela' => elgg_echo('resume:country:Venezuela'),
'Vietnam' => elgg_echo('resume:country:Vietnam'),
'Virgin Islands (Brit)' => elgg_echo('resume:country:Virgin Islands (Brit)'),
'Virgin Islands (USA)' => elgg_echo('resume:country:Virgin Islands (USA)'),
'Wake Island' => elgg_echo('resume:country:Wake Island'),
'Wallis & Futana Is' => elgg_echo('resume:country:Wallis & Futana Is'),
'Yemen' => elgg_echo('resume:country:Yemen'),
'Zaire' => elgg_echo('resume:country:Zaire'),
'Zambia' => elgg_echo('resume:country:Zambia'),
'Zimbabwe' => elgg_echo('resume:country:Zimbabwe'),
  );
  
$country = $vars['entity']->country;
if (empty($country )) $country_options = '<option disabled="disabled" selected="selected">-------</option>';
else $country_options = '<option value="' . $country . '" selected="selected">' . elgg_echo('resume:country:' . $country) . '</option>';
foreach ($countries as $ch => $ct) { $country_options .= '<option value="' .$ch. '">' . $ct . '</option>'; }

$langtype = $vars['entity']->langtype;
if (empty($langtype)) $langtype_options = '<option disabled="disabled" selected="selected">-------</option>';
else $langtype_options = '<option value="' . $langtype . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:languages:type:' . $langtype) . '</option>';
$langtype_options .= '<option value="mother">' . elgg_echo('resume:languages:type:mother') . '</option>
    <option value="mother2">' . elgg_echo('resume:languages:type:mother2') . '</option>
    <option value="foreign">' . elgg_echo('resume:languages:type:foreign') . '</option>';

$experience = array(
   elgg_echo('resume:language:experience:philology') => 'philology',  
   elgg_echo('resume:language:experience:study') => 'study', 
   elgg_echo('resume:language:experience:publication') => 'publication', 
   elgg_echo('resume:language:experience:discourse') => 'discourse', 
  );

$level_options = array(
    // Basic User
    '' => '(CEFR | ILR standards)',
    'a1' => elgg_echo('resume:languages:level:a1'),
    'a2' => elgg_echo('resume:languages:level:a2'),
    // Independent user
    'b1' => elgg_echo('resume:languages:level:b1'),
    'b2' => elgg_echo('resume:languages:level:b2'),
    // Proficient user
    'c1' => elgg_echo('resume:languages:level:c1'),
    'c2' => elgg_echo('resume:languages:level:c2'),
  );

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;

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
          bodyText += '<?php echo $divexams;?><?php echo elgg_echo('resume:languages:exam');?><input type="text" name="exams[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divgrades;?><?php echo elgg_echo('resume:languages:grade');?><input type="text" name="grades[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divhours;?><?php echo elgg_echo('resume:languages:hour');?><input type="text" name="hours[]" value="" class="input-text"/></div><div class="clearfloat"></div><br />';
          bodyText += '<?php echo $divcountries;?><?php echo elgg_echo('resume:education:country'); echo '<select name="countries[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $country_options . '</select>';?></div>';
          bodyText += '<?php echo $divstarts;?><?php echo elgg_echo('resume:languages:starts');?><br />';
          window['calstarts' + counter] = new CalendarPopup();
          bodyText += '<input type="text"  name="starts' + counter + '" id="starts' + counter + '" value="" /><a href="#" onclick="calstarts' + counter + '.select(document.getElementById(\'starts' + counter + '\'),\'anchorstarts' + counter + '\',\'MMM dd, yyyy\'); return false;" TITLE="calstarts' + counter + '.select(document.forms[0].starts' + counter + ',\'anchorstarts' + counter + '\',\'MMM dd, yyyy\'); return false;" NAME="anchorstarts' + counter + '" ID="anchorstarts' + counter + '">select</a></div>';
          bodyText += '<?php echo $divends;?><?php echo elgg_echo('resume:languages:ends');?><br />';
          window['calends' + counter] = new CalendarPopup();
          bodyText += '<input type="text"  name="ends' + counter + '" id="ends' + counter + '" value="" /><a href="#" onclick="calends' + counter + '.select(document.getElementById(\'ends' + counter + '\'),\'anchorends' + counter + '\',\'MMM dd, yyyy\'); return false;" TITLE="calends' + counter + '.select(document.forms[0].ends' + counter + ',\'anchorends' + counter + '\',\'MMM dd, yyyy\'); return false;" NAME="anchorends' + counter + '" ID="anchorends' + counter + '">select</a></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:work:removefield'); ?>"></div></div><div class="clearfloat"></div><br /><br />';
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
          bodyText += '<div style="float:left; width:55%;margin-right:15px"><?php echo elgg_echo('resume:languages:exam2'); echo elgg_echo('resume:*'); ?><br /><input type="text" name="exam2" value="" class="input-text"/></div>';
          bodyText += '<div style="float:left; width:42%;"><?php echo elgg_echo('resume:languages:level'); echo elgg_echo('resume:*'); ?><br /><input type="text"   name="level"  value="" class="input-text"/></div><div class="clearfloat"></div><br />'
          bodyText += '<div style="float:left; width:20%; margin-right:15px;"><?php echo elgg_echo('resume:languages:students'); ?><br /><input type="text" name="students" value="" class="input-text"/></div>'
          bodyText += '<div style="float:left; width:20%; margin-right:15px;"><?php echo elgg_echo('resume:languages:official'); ?><br /><input type="text" name="official" value="" class="input-text"/></div>'
          bodyText += '<div style="float:left; width:20%; margin-right:15px;"><?php echo elgg_echo('resume:languages:valid'); ?><br /><input type="text" name="valid" value="" class="input-text"/></div>'
          bodyText += '<div style="float:left; width:30%;margin-top:5px"><?php echo elgg_echo('resume:education:country'); echo elgg_echo('resume:*'); ?><br /><select name="country" class="input-pulldown"><?php echo $country_options; ?></select></div>'
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" onClick="removeElement(\'parent' + counternew + '\', \'child' + counternew + '\')" value="<?php echo elgg_echo('resume:work:removefield'); ?>"></div></div><div class="clearfloat"></div><br />';
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
    
    <div style="float:left; width:65%;">
      <?php echo elgg_echo('resume:languages:language');  
      echo elgg_echo('resume:*');?>
        <select name="langcode" class="input-pulldown"><?php echo $language_options; ?></select>
    </div>
    
    <div style="float:left; width:30%;">
      <p><?php echo elgg_echo('resume:languages:langtype'); 
       echo elgg_echo('resume:*');?> : 
       <select name="langtype" class="input-pulldown"><?php echo $langtype_options; ?></select>
    </div>
    
    <div class="clearfloat"></div>
    <?php
      echo $divexperience;
      echo elgg_echo('resume:language:experience'); 
      echo "<br />";
       echo elgg_view('input/checkboxes', array(
        "internalname" =>  "experience",
           
        "value"=> $vars['entity']->experience,
        "options"=> $experience
        )
       );
      ?>
    </div>    <div class="clearfloat"></div>
<br />
    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:understanding'); ?></h4>
      <?php echo elgg_echo('resume:languages:listening');  
      echo elgg_echo('resume:*');?> 
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_listening').toggle();"><?php echo elgg_echo('resume:help'); ?></a>
      <div id="resume_lang_listening" style="display:none;"><?php echo elgg_echo('resume:languages:listening:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'listening', 'options_values' => $level_options, 'value' => $vars['entity']->listening)); ?>
      <br />
      <br />
      <?php echo elgg_echo('resume:languages:reading'); 
      echo elgg_echo('resume:*');?>  
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_reading').toggle();"><?php echo elgg_echo('resume:help'); ?></a>
      <div id="resume_lang_reading" style="display:none;"><?php echo elgg_echo('resume:languages:reading:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'reading', 'options_values' => $level_options, 'value' => $vars['entity']->reading)); ?>
    </div>
    
    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:speaking'); ?></h4>
      <?php echo elgg_echo('resume:languages:spokeninteraction'); 
      echo elgg_echo('resume:*');?>  
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_spokeninteraction').toggle();"><?php echo elgg_echo('resume:help'); ?></a>
      <div id="resume_lang_spokeninteraction" style="display:none;"><?php echo elgg_echo('resume:languages:spokeninteraction:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'spokeninteraction', 'options_values' => $level_options, 'value' => $vars['entity']->spokeninteraction)); ?>
      <br />
      <br />
      <?php echo elgg_echo('resume:languages:spokenproduction'); 
      echo elgg_echo('resume:*');?>  
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_spokenproduction').toggle();"><?php echo elgg_echo('resume:help'); ?></a>
      <div id="resume_lang_spokenproduction" style="display:none;"><?php echo elgg_echo('resume:languages:spokenproduction:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'spokenproduction', 'options_values' => $level_options, 'value' => $vars['entity']->spokenproduction)); ?>
    </div>
    
    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:writing'); 
      echo elgg_echo('resume:*');?> </h4>
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_writing').toggle();"><?php echo elgg_echo('resume:help'); ?></a><br/>
      <div id="resume_lang_writing" style="display:none;"><?php echo elgg_echo('resume:languages:writing:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'writing', 'options_values' => $level_options, 'value' => $vars['entity']->writing)); ?>
    </div>
    
    <div class="clearfloat"></div><br />
   
    <div id="dynamicInput2">

    </div>
   
  
   <div class="clearfloat"></div>
   
     <input type="button" value="<?php echo elgg_echo('resume:languages:addexamtype'); ?>" onClick="addInput2('dynamicInput2');">
   
   <br /><br />
   
     <div class="contentWrapper resume_contentWrapper" width="716">
      <p><?php echo elgg_echo('resume:language:exams'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
          
      <?php
    if (!isset($vars['entity'])) {
      echo $divexams;
       echo "1. ";
       echo elgg_echo('resume:languages:exam');
echo elgg_view('input/autocomplete', array('internalname' => 'exams[0]', 'match_on' => 'languages', 
           'value' => ""));       echo "</div>";
      echo $divgrades;
       echo elgg_echo('resume:languages:grade');
       echo elgg_view('input/text', array('internalname' => "grades[]", 'value' => ""));
        echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:languages:hour');
       echo elgg_view('input/text', array('internalname' => "hours[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div><br/>";
      echo $divcountries;
       echo elgg_echo('resume:education:country'); 
       echo '<select name="countries[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">'
       . $country_options . '</select>'; 
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:languages:starts');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'starts0', 'value' => $vars['entity']->starts));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:languages:ends');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'ends0', 'value' => $vars['entity']->ends));
        
       echo "</div><div class=\"clearfloat\"></div><br /><br />";
       
      echo $divexams;
       echo "2. ";
       echo elgg_echo('resume:languages:exam');
echo elgg_view('input/autocomplete', array('internalname' => 'exams[1]', 'match_on' => 'languages', 
           'value' => ""));       echo "</div>";
      echo $divgrades;
       echo elgg_echo('resume:languages:grade');
       echo elgg_view('input/text', array('internalname' => "grades[]", 'value' => ""));
        echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:languages:hour');
       echo elgg_view('input/text', array('internalname' => "hours[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div><br/>";
      echo $divcountries;
       echo elgg_echo('resume:education:country'); 
       echo '<select name="countries[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">'
       . $country_options . '</select>'; 
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:languages:starts');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'starts1', 'value' => $vars['entity']->starts));
       echo "</div>"; 
       echo $divends;
    echo elgg_echo('resume:languages:ends');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'ends1', 'value' => $vars['entity']->ends));
        
       echo "</div><div class=\"clearfloat\"></div><br /><br />";
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
      
      echo elgg_view('input/autocomplete', array('internalname' => $examiname, 'match_on' => 'languages', 
           'value' => $guid, 'value_show' => $comshow));
       echo "</div>"; 
       echo $divgrades;
       echo elgg_echo('resume:languages:grade');
       echo elgg_view('input/text', array('internalname' => "grades[]", 'value' => $grades_array[$i]));
        echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:languages:hour');
       echo elgg_view('input/text', array('internalname' => "hours[]", 'value' => $hours_array[$i]));
       echo "</div><div class=\"clearfloat\"></div><br/>";
      echo $divcountries;
       echo elgg_echo('resume:education:country'); 

$country_options = '<option value="' . $countries_array[$i] . '" selected="selected">' . elgg_echo('resume:country:' . $countries_array[$i]) . '</option>';
foreach ($countries as $ch => $ct) { $country_options .= '<option value="' .$ch. '">' . $ct . '</option>'; }

      echo '<select name="countries[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $country_options . '</select>';

       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:languages:starts');
       echo "<br />";
    	 $starts_i = "starts".$i;
       echo elgg_view('input/calendar', array('internalname' => $starts_i, 'value' => $starts_array[$i]));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:work:ends');
       echo "<br />";
    	 $ends_i = "ends".$i;
       echo elgg_view('input/calendar', array('internalname' => $ends_i, 'value' => $ends_array[$i]));
       echo "</div><div class=\"clearfloat\"></div><br /><br />";
     }
    }
    ?>
      </div>
      </div>
      
     <div class="clearfloat"></div> <br />
    
    <div id="dynamicInput">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" value="<?php echo elgg_echo('resume:languages:addexam'); ?>" onClick="addInput('dynamicInput');">
   
   <br /><br />
   
    <p>
      <?php echo elgg_echo('resume:languages:description'); ?><br />
      <?php echo elgg_view('input/longtext', array('internalname' => 'description', 'value' => $vars['entity']->description)); ?>
    </p>
    
   
    <p><?php echo elgg_echo('access'); ?><br />
    <?php
    if (isset($vars['entity'])) echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $vars['entity']->access_id));
    else echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
    ?>
    </p>
    
    <?php echo elgg_view('input/securitytoken'); ?>
    
    <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:languages:save'))); ?></p>
    
    <?php // Pass the GUID if existing entity
    if (isset($vars['entity'])) { echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID())); }
    ?>
    
  </form>
</div>
