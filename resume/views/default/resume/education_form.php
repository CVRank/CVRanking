<?php

// Decide wich action to use based on if its an edit or add use case.
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/education_add"; }

/*
@todo : affiner le form et les champs (select pour typology)
*/

$levels = array(
    'ISCED0' => elgg_echo('resume:education:level:ISCED0'),
    'ISCED010' => elgg_echo('resume:education:level:ISCED010'),  
    'ISCED020' => elgg_echo('resume:education:level:ISCED020'),
    'ISCED1' => elgg_echo('resume:education:level:ISCED1'),
    'ISCED2' => elgg_echo('resume:education:level:ISCED2'),
    'ISCED2-1' => elgg_echo('resume:education:level:ISCED2-1'),   
    'ISCED2-2' => elgg_echo('resume:education:level:ISCED2-2'),   
    'ISCED2-3' => elgg_echo('resume:education:level:ISCED2-3'),  
    'ISCED2-4' => elgg_echo('resume:education:level:ISCED2-4'), 
    'ISCED3' => elgg_echo('resume:education:level:ISCED3'), 
    'ISCED3-1' => elgg_echo('resume:education:level:ISCED3-1'), 
    'ISCED3-2' => elgg_echo('resume:education:level:ISCED3-2'), 
    'ISCED3-3' => elgg_echo('resume:education:level:ISCED3-3'),  
    'ISCED3-4' => elgg_echo('resume:education:level:ISCED3-4'),
    'ISCED4' => elgg_echo('resume:education:level:ISCED4'),
    'ISCED4-1' => elgg_echo('resume:education:level:ISCED4-1'),
    'ISCED4-3' => elgg_echo('resume:education:level:ISCED4-3'), 
    'ISCED4-4' => elgg_echo('resume:education:level:ISCED4-4'), 
    'ISCED5' => elgg_echo('resume:education:level:ISCED5'),   
    'ISCED5-1' => elgg_echo('resume:education:level:ISCED5-1'),   
    'ISCED5-4' => elgg_echo('resume:education:level:ISCED5-4'),  
    'ISCED6' => elgg_echo('resume:education:level:ISCED6'),   
    'ISCED6-1' => elgg_echo('resume:education:level:ISCED6-1'),  
    'ISCED6-5' => elgg_echo('resume:education:level:ISCED6-5'), 
    'ISCED6-6' => elgg_echo('resume:education:level:ISCED6-6'), 
    'ISCED6-7' => elgg_echo('resume:education:level:ISCED6-7'), 
    'ISCED7' => elgg_echo('resume:education:level:ISCED7'), 
    'ISCED7-1' => elgg_echo('resume:education:level:ISCED7-1'),  
    'ISCED7-6' => elgg_echo('resume:education:level:ISCED7-6'),
    'ISCED7-7' => elgg_echo('resume:education:level:ISCED7-7'),
    'ISCED7-8' => elgg_echo('resume:education:level:ISCED7-8'), 
    'ISCED8' => elgg_echo('resume:education:level:ISCED8'), 
    'ISCED8-1' => elgg_echo('resume:education:level:ISCED8-1'), 
    'ISCED8-4' => elgg_echo('resume:education:level:ISCED8-4'),
    'ISCED999' => elgg_echo('resume:education:level:ISCED999'),  
    );
$level = $vars['entity']->level;
if (empty($level)) $level_options = '<option disabled="disabled" selected="selected">-------</option>';
else $level_options = '<option value="' . $level . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:level:' . $level) . '</option>';
foreach ($levels as $l => $c) { $level_options .= '<option value="' .$l. '">' . $c . '</option>'; }

$level2s = array(
    'ISCED-4-' => elgg_echo('resume:education:level:ISCED-4-'),
    'ISCED-5-' => elgg_echo('resume:education:level:ISCED-5-'),
    'ISCED-6-' => elgg_echo('resume:education:level:ISCED-6-'),
        );
$level2 = $vars['entity']->level2;
if (empty($level2)) $level2_options = '<option disabled="disabled" selected="selected">-------</option>';
else $level2_options = '<option value="' . $level2 . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:level:' . $level2) . '</option>';
foreach ($level2s as $l2 => $c2) { $level2_options .= '<option value="' .$l2. '">' . $c2 . '</option>'; }

$fields = array(
   '0'=> elgg_echo('resume:education:field:0'),
//'01'=> elgg_echo('resume:education:field:01'),
'010'=> elgg_echo('resume:education:field:010'),
//'08'=> elgg_echo('resume:education:field:08'),
'080'=> elgg_echo('resume:education:field:080'),
//'09'=> elgg_echo('resume:education:field:09'),
'090'=> elgg_echo('resume:education:field:090'),
'1'=> elgg_echo('resume:education:field:1'),
//'14'=> elgg_echo('resume:education:field:14'),
'140'=> elgg_echo('resume:education:field:140'),
'141'=> elgg_echo('resume:education:field:141'),
'142'=> elgg_echo('resume:education:field:142'),
'143'=> elgg_echo('resume:education:field:143'),
'144'=> elgg_echo('resume:education:field:144'),
'145'=> elgg_echo('resume:education:field:145'),
'146'=> elgg_echo('resume:education:field:146'),
'149'=> elgg_echo('resume:education:field:149'),
'2'=> elgg_echo('resume:education:field:2'),
'21'=> elgg_echo('resume:education:field:21'),
'210'=> elgg_echo('resume:education:field:210'),
'211'=> elgg_echo('resume:education:field:211'),
'212'=> elgg_echo('resume:education:field:212'),
'213'=> elgg_echo('resume:education:field:213'),
'214'=> elgg_echo('resume:education:field:214'),
'215'=> elgg_echo('resume:education:field:215'),
'219'=> elgg_echo('resume:education:field:219'),
'22'=> elgg_echo('resume:education:field:22'),
'220'=> elgg_echo('resume:education:field:220'),
'221'=> elgg_echo('resume:education:field:221'),
'222'=> elgg_echo('resume:education:field:222'),
'223'=> elgg_echo('resume:education:field:223'),
'225'=> elgg_echo('resume:education:field:225'),
'226'=> elgg_echo('resume:education:field:226'),
'229'=> elgg_echo('resume:education:field:229'),
'3'=> elgg_echo('resume:education:field:3'),
'31'=> elgg_echo('resume:education:field:31'),
'310'=> elgg_echo('resume:education:field:310'),
'311'=> elgg_echo('resume:education:field:311'),
'312'=> elgg_echo('resume:education:field:312'),
'313'=> elgg_echo('resume:education:field:313'),
'314'=> elgg_echo('resume:education:field:314'),
'319'=> elgg_echo('resume:education:field:319'),
'32'=> elgg_echo('resume:education:field:32'),
'321'=> elgg_echo('resume:education:field:321'),
'322'=> elgg_echo('resume:education:field:322'),
'329'=> elgg_echo('resume:education:field:329'),
'34'=> elgg_echo('resume:education:field:34'),
'340'=> elgg_echo('resume:education:field:340'),
'341'=> elgg_echo('resume:education:field:341'),
'342'=> elgg_echo('resume:education:field:342'),
'343'=> elgg_echo('resume:education:field:343'),
'344'=> elgg_echo('resume:education:field:344'),
'345'=> elgg_echo('resume:education:field:345'),
'346'=> elgg_echo('resume:education:field:346'),
'347'=> elgg_echo('resume:education:field:347'),
'349'=> elgg_echo('resume:education:field:349'),
'38'=> elgg_echo('resume:education:field:38'),
'380'=> elgg_echo('resume:education:field:380'),
'4'=> elgg_echo('resume:education:field:4'),
'42'=> elgg_echo('resume:education:field:42'),
'421'=> elgg_echo('resume:education:field:421'),
'422'=> elgg_echo('resume:education:field:422'),
'429'=> elgg_echo('resume:education:field:429'),
'44'=> elgg_echo('resume:education:field:44'),
'440'=> elgg_echo('resume:education:field:440'),
'441'=> elgg_echo('resume:education:field:441'),
'442'=> elgg_echo('resume:education:field:442'),
'443'=> elgg_echo('resume:education:field:443'),
'449'=> elgg_echo('resume:education:field:449'),
'46'=> elgg_echo('resume:education:field:46'),
'461'=> elgg_echo('resume:education:field:461'),
'462'=> elgg_echo('resume:education:field:462'),
'469'=> elgg_echo('resume:education:field:469'),
'48'=> elgg_echo('resume:education:field:48'),
'481'=> elgg_echo('resume:education:field:481'),
'482'=> elgg_echo('resume:education:field:482'),
'489'=> elgg_echo('resume:education:field:489'),
'5'=> elgg_echo('resume:education:field:5'),
'52'=> elgg_echo('resume:education:field:52'),
'520'=> elgg_echo('resume:education:field:520'),
'521'=> elgg_echo('resume:education:field:521'),
'522'=> elgg_echo('resume:education:field:522'),
'523'=> elgg_echo('resume:education:field:523'),
'524'=> elgg_echo('resume:education:field:524'),
'525'=> elgg_echo('resume:education:field:525'),
'529'=> elgg_echo('resume:education:field:529'),
'54'=> elgg_echo('resume:education:field:54'),
'540'=> elgg_echo('resume:education:field:540'),
'541'=> elgg_echo('resume:education:field:541'),
'542'=> elgg_echo('resume:education:field:542'),
'543'=> elgg_echo('resume:education:field:543'),
'544'=> elgg_echo('resume:education:field:544'),
'549'=> elgg_echo('resume:education:field:549'),
'58'=> elgg_echo('resume:education:field:58'),
'581'=> elgg_echo('resume:education:field:581'),
'582'=> elgg_echo('resume:education:field:582'),
'589'=> elgg_echo('resume:education:field:589'),
'6'=> elgg_echo('resume:education:field:6'),
'62'=> elgg_echo('resume:education:field:62'),
'620'=> elgg_echo('resume:education:field:620'),
'621'=> elgg_echo('resume:education:field:621'),
'622'=> elgg_echo('resume:education:field:622'),
'623'=> elgg_echo('resume:education:field:623'),
'624'=> elgg_echo('resume:education:field:624'),
'629'=> elgg_echo('resume:education:field:629'),
'64'=> elgg_echo('resume:education:field:64'),
'640'=> elgg_echo('resume:education:field:640'),
'7'=> elgg_echo('resume:education:field:7'),
'72'=> elgg_echo('resume:education:field:72'),
'720'=> elgg_echo('resume:education:field:720'),
'721'=> elgg_echo('resume:education:field:721'),
'723'=> elgg_echo('resume:education:field:723'),
'724'=> elgg_echo('resume:education:field:724'),
'725'=> elgg_echo('resume:education:field:725'),
'726'=> elgg_echo('resume:education:field:726'),
'727'=> elgg_echo('resume:education:field:727'),
'729'=> elgg_echo('resume:education:field:729'),
'76'=> elgg_echo('resume:education:field:76'),
'761'=> elgg_echo('resume:education:field:761'),
'762'=> elgg_echo('resume:education:field:762'),
'769'=> elgg_echo('resume:education:field:769'),
'8'=> elgg_echo('resume:education:field:8'),
'81'=> elgg_echo('resume:education:field:81'),
'810'=> elgg_echo('resume:education:field:810'),
'811'=> elgg_echo('resume:education:field:811'),
'812'=> elgg_echo('resume:education:field:812'),
'813'=> elgg_echo('resume:education:field:813'),
'814'=> elgg_echo('resume:education:field:814'),
'815'=> elgg_echo('resume:education:field:815'),
'819'=> elgg_echo('resume:education:field:819'),
'84'=> elgg_echo('resume:education:field:84'),
'840'=> elgg_echo('resume:education:field:840'),
'85'=> elgg_echo('resume:education:field:85'),
'850'=> elgg_echo('resume:education:field:850'),
'851'=> elgg_echo('resume:education:field:851'),
'852'=> elgg_echo('resume:education:field:852'),
'853'=> elgg_echo('resume:education:field:853'),
'859'=> elgg_echo('resume:education:field:859'),
'86'=> elgg_echo('resume:education:field:86'),
'860'=> elgg_echo('resume:education:field:860'),
'861'=> elgg_echo('resume:education:field:861'),
'862'=> elgg_echo('resume:education:field:862'),
'863'=> elgg_echo('resume:education:field:863'),
'869'=> elgg_echo('resume:education:field:869'),
//'99'=> elgg_echo('resume:education:field:99'),
  );
  
$field = $vars['entity']->field;
if (empty($field)) $field_options = '<option disabled="disabled" selected="selected">-------</option>';
else $field_options = '<option value="' . $field . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:field:' . $field) . '</option>';
foreach ($fields as $f => $v) { $field_options .= '<option value="' .$f. '">' . $v . '</option>'; }

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
else $country_options = '<option value="' . $country . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:country:' . $country) . '</option>';
foreach ($countries as $ch => $ct) { $country_options .= '<option value="' .$ch. '">' . $ct . '</option>'; }

$edutypes = array(
    'Presence' => elgg_echo('resume:education:edutype:presence'),    
    'Part-time' => elgg_echo('resume:education:edutype:part-time'), 
    'Hybrid' => elgg_echo('resume:education:edutype:hybrid'),
    'Distance' => elgg_echo('resume:education:edutype:distance'),
    'Non-formal' => elgg_echo('resume:education:edutype:non-formal'),
  );
$edutype = $vars['entity']->edutype;
if (empty($edutype)) $edutype_options = '<option disabled="disabled" selected="selected">-------</option>';
else $edutype_options = '<option value="' . $edutype . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:edutype:' . $edutype) . '</option>';
foreach ($edutypes as $eh => $et) { $edutype_options .= '<option value="' .$eh. '">' . $et . '</option>'; }

$prizes = array(   
    'intprize' => elgg_echo('resume:education:prize:international'), 
    'natprize' => elgg_echo('resume:education:prize:country'), 
    'regprize' => elgg_echo('resume:education:prize:region'),
    'instprize' => elgg_echo('resume:education:prize:institution'), 
    'classprize' => elgg_echo('resume:education:prize:class'),
  );

$prize = $vars['entity']->prize;
if (empty($prize)) $prize_options = '<option disabled="disabled" selected="selected">-------</option>';
else $prize_options = '<option value="' . $prize . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:edutype:' . $prize) . '</option>';
foreach ($prizes as $ph => $pt) { $prize_options .= '<option value="' .$ph. '">' . $pt . '</option>'; }

$hourtypes = array(  
    'US' => elgg_echo('resume:education:hourtype:US'),
    'Carnegie' => elgg_echo('resume:education:hourtype:Carnegie'),
    'UK' => elgg_echo('resume:education:hourtype:UK'),
    'ECTS' => elgg_echo('resume:education:hourtype:ECTS'),
    'Japan' => elgg_echo('resume:education:hourtype:Japan'),
    'China' => elgg_echo('resume:education:hourtype:China'),
    'Austria old' => elgg_echo('resume:education:hourtype:Austria old'),
    'Colombia' => elgg_echo('resume:education:hourtype:Colombia'),
    'Denmark old' => elgg_echo('resume:education:hourtype:Denmark old'),
    'El Salvador' => elgg_echo('resume:education:hourtype:El Salvador'),
    'Estonia old' => elgg_echo('resume:education:hourtype:Estonia old'),
    'Finland old' => elgg_echo('resume:education:hourtype:Finland old'),
    'Germany old' => elgg_echo('resume:education:hourtype:Germany old'),
    'Latvia' => elgg_echo('resume:education:hourtype:Latvia'),
    'Netherlands old' => elgg_echo('resume:education:hourtype:Netherlands old'),
    'Norway old' => elgg_echo('resume:education:hourtype:Norway old'),
    'Spain old' => elgg_echo('resume:education:hourtype:Spain old'),
    'Sweden old' => elgg_echo('resume:education:hourtype:Sweden old'),
    'Sweden older' => elgg_echo('resume:education:hourtype:Sweden older'),
    '700' => elgg_echo('resume:education:hourtype:700'),
    '800' => elgg_echo('resume:education:hourtype:800'),
    '900' => elgg_echo('resume:education:hourtype:900'),
    '1000' => elgg_echo('resume:education:hourtype:1000'),
    '1100' => elgg_echo('resume:education:hourtype:1100'),
    '1200' => elgg_echo('resume:education:hourtype:1200'),
    '1300' => elgg_echo('resume:education:hourtype:1300'),
    '1400' => elgg_echo('resume:education:hourtype:1400'),
  );
  
$hourtype = $vars['entity']->hourtype;
if (empty($hourtype)) $hourtype_options = '<option disabled="disabled" selected="selected">-------</option>';
else $hourtype_options = '<option value="' . $hourtype . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:hourtype:' . $hourtype) . '</option>';
foreach ($hourtypes as $h => $t) { $hourtype_options .= '<option value="' .$h. '">' . $t . '</option>'; }

$gradetypes = array(  
'1006' => elgg_echo ('resume:education:gradetype:1006'),
'1005' => elgg_echo ('resume:education:gradetype:1005'),
'1007' => elgg_echo ('resume:education:gradetype:1007'),
'106' => elgg_echo ('resume:education:gradetype:106'),
'105' => elgg_echo ('resume:education:gradetype:105'),
'205' => elgg_echo ('resume:education:gradetype:205'),
'US4' => elgg_echo ('resume:education:gradetype:USnormalGPA'),
'US5' => elgg_echo ('resume:education:gradetype:UShonorsGPA'),
'US9' => elgg_echo ('resume:education:gradetype:US9'),
'US10' => elgg_echo ('resume:education:gradetype:US10'),
'US42' => elgg_echo ('resume:education:gradetype:USnormalother'),
'US52' => elgg_echo ('resume:education:gradetype:UShonorsother'),
'UK' => elgg_echo ('resume:education:gradetype:UK'),
'GCSE' => elgg_echo ('resume:education:gradetype:GCSE'),
'GCE' => elgg_echo ('resume:education:gradetype:GCE'),
'ECTS' => elgg_echo ('resume:education:gradetype:ECTS'),
'IB' => elgg_echo ('resume:education:gradetype:IB'),
'Albania' => elgg_echo ('resume:education:gradetype:Albania'),
'Algeria10' => elgg_echo ('resume:education:gradetype:Algeria10'),
'Algeria20' => elgg_echo ('resume:education:gradetype:Algeria20'),
'Argentina3' => elgg_echo ('resume:education:gradetype:Argentina3'),
'Argentina2' => elgg_echo ('resume:education:gradetype:Argentina2'),
'Argentina70' => elgg_echo ('resume:education:gradetype:Argentina70'),
'Australia3' => elgg_echo ('resume:education:gradetype:Australia3'),
'Australia4' => elgg_echo ('resume:education:gradetype:Australia4'),
//'AustraliaH' => elgg_echo ('resume:education:gradetype:AustraliaH'),
'Australia2' => elgg_echo ('resume:education:gradetype:Australia2'),
'Australia6' => elgg_echo ('resume:education:gradetype:Australia6'),
'Austria' => elgg_echo ('resume:education:gradetype:Austria'),
'Bangladesh' => elgg_echo ('resume:education:gradetype:Bangladesh'),
'Belgium' => elgg_echo ('resume:education:gradetype:Belgium'),
'Bolivia' => elgg_echo ('resume:education:gradetype:Bolivia'),
'Bosnia3' => elgg_echo ('resume:education:gradetype:Bosnia3'),
'Bosnia2' => elgg_echo ('resume:education:gradetype:Bosnia2'),
'Brazil5' => elgg_echo ('resume:education:gradetype:Brazil5'),
'Brazil6' => elgg_echo ('resume:education:gradetype:Brazil6'),
'Brazil7' => elgg_echo ('resume:education:gradetype:Brazil7'),
'Bulgaria2' => elgg_echo ('resume:education:gradetype:Bulgaria2'),
'Bulgaria3' => elgg_echo ('resume:education:gradetype:Bulgaria3'),
'Chile2' => elgg_echo ('resume:education:gradetype:Chile2'),
'Chile1' => elgg_echo ('resume:education:gradetype:Chile1'),
'China' => elgg_echo ('resume:education:gradetype:China'),
'Canada' => elgg_echo ('resume:education:gradetype:Canada'),
'Colombia5' => elgg_echo ('resume:education:gradetype:Colombia5'),
'Colombia10' => elgg_echo ('resume:education:gradetype:Colombia10'),
'CostaRica1' => elgg_echo ('resume:education:gradetype:CostaRica1'),
'CostaRica3' => elgg_echo ('resume:education:gradetype:CostaRica3'),
'Croatia2' => elgg_echo ('resume:education:gradetype:Croatia2'),
'Croatia3' => elgg_echo ('resume:education:gradetype:Croatia3'),
'Czech' => elgg_echo ('resume:education:gradetype:Czech'),
'Denmark13' => elgg_echo ('resume:education:gradetype:Denmark13'),
'Denmark7' => elgg_echo ('resume:education:gradetype:Denmark7'),
'Ecuador' => elgg_echo ('resume:education:gradetype:Ecuador'),
'ElSalvador6' => elgg_echo ('resume:education:gradetype:ElSalvador6'),
'ElSalvador7' => elgg_echo ('resume:education:gradetype:ElSalvador7'),
'ElSalvadorD' => elgg_echo ('resume:education:gradetype:ElSalvadorD'),
'Finland' => elgg_echo ('resume:education:gradetype:Finland'),
'France2' => elgg_echo ('resume:education:gradetype:France2'),
'France3' => elgg_echo ('resume:education:gradetype:France3'),
'Germany' => elgg_echo ('resume:education:gradetype:Germany'),
'Greece3' => elgg_echo ('resume:education:gradetype:Greece3'),
'Greece2' => elgg_echo ('resume:education:gradetype:Greece2'),
'Guatemala' => elgg_echo ('resume:education:gradetype:Guatemala'),
'HongKong3' => elgg_echo ('resume:education:gradetype:HongKong3'),
'HongKong2' => elgg_echo ('resume:education:gradetype:HongKong2'),
'Honduras' => elgg_echo ('resume:education:gradetype:Honduras'),
'Hungary' => elgg_echo ('resume:education:gradetype:Hungary'),
'Iceland100' => elgg_echo ('resume:education:gradetype:Iceland100'),
'Iceland10' => elgg_echo ('resume:education:gradetype:Iceland10'),
'Ireland2' => elgg_echo ('resume:education:gradetype:Ireland2'),
'Indonesia3' => elgg_echo ('resume:education:gradetype:Indonesia3'),
'Indonesia56' => elgg_echo ('resume:education:gradetype:Indonesia56'),
'Indonesia70' => elgg_echo ('resume:education:gradetype:Indonesia70'),
'Indonesia10' => elgg_echo ('resume:education:gradetype:Indonesia10'),
'Ireland3' => elgg_echo ('resume:education:gradetype:Ireland3'),
'Iran' => elgg_echo ('resume:education:gradetype:Iran'),
'Iraq' => elgg_echo ('resume:education:gradetype:Iraq'),
'India100' => elgg_echo ('resume:education:gradetype:India100'),
'India10' => elgg_echo ('resume:education:gradetype:India10'),
'Israel10' => elgg_echo ('resume:education:gradetype:Israel10'),
'Israel100' => elgg_echo ('resume:education:gradetype:Israel100'),
'Italy3' => elgg_echo ('resume:education:gradetype:Italy3'),
'Italy2' => elgg_echo ('resume:education:gradetype:Italy2'),
'Jamaica' => elgg_echo ('resume:education:gradetype:Jamaica'),
'Japan6' => elgg_echo ('resume:education:gradetype:Japan6'),
'Japan4' => elgg_echo ('resume:education:gradetype:Japan4'),
'Korea' => elgg_echo ('resume:education:gradetype:Korea'),
'Kuwait' => elgg_echo ('resume:education:gradetype:Kuwait'),
'Latvia' => elgg_echo ('resume:education:gradetype:Latvia'),
'Lebanon60' => elgg_echo ('resume:education:gradetype:Lebanon60'),
'Lebanon70' => elgg_echo ('resume:education:gradetype:Lebanon70'),
'Lebanon20' => elgg_echo ('resume:education:gradetype:Lebanon20'),
'Lithuania' => elgg_echo ('resume:education:gradetype:Lithuania'),
'Luxembourg' => elgg_echo ('resume:education:gradetype:Luxembourg'),
'Macedonia2' => elgg_echo ('resume:education:gradetype:Macedonia2'),
'Macedonia3' => elgg_echo ('resume:education:gradetype:Macedonia3'),
'Mexico60' => elgg_echo ('resume:education:gradetype:Mexico60'),
'Mexico70' => elgg_echo ('resume:education:gradetype:Mexico70'),
'Mexico80' => elgg_echo ('resume:education:gradetype:Mexico80'),
'Malaysia' => elgg_echo ('resume:education:gradetype:Malaysia'),
'Moldova' => elgg_echo ('resume:education:gradetype:Moldova'),
'Netherlands' => elgg_echo ('resume:education:gradetype:Netherlands'),
'NewZealand' => elgg_echo ('resume:education:gradetype:NewZealand'),
'Nicaragua60' => elgg_echo ('resume:education:gradetype:Nicaragua60'),
'Nicaragua70' => elgg_echo ('resume:education:gradetype:Nicaragua70'),
'NorwayECTS' => elgg_echo ('resume:education:gradetype:NorwayECTS'),
'Norway3' => elgg_echo ('resume:education:gradetype:Norway3'),
'Norway2' => elgg_echo ('resume:education:gradetype:Norway2'),
'Panama' => elgg_echo ('resume:education:gradetype:Panama'),
'Pakistan' => elgg_echo ('resume:education:gradetype:Pakistan'),
'Paraguay' => elgg_echo ('resume:education:gradetype:Paraguay'),
'Poland1' => elgg_echo ('resume:education:gradetype:Poland1'),
'Poland3' => elgg_echo ('resume:education:gradetype:Poland3'),
'Portugal2' => elgg_echo ('resume:education:gradetype:Portugal2'),
'Portugal3' => elgg_echo ('resume:education:gradetype:Portugal3'),
'Peru3' => elgg_echo ('resume:education:gradetype:Peru3'),
'Peru11' => elgg_echo ('resume:education:gradetype:Peru11'),
'Romania' => elgg_echo ('resume:education:gradetype:Romania'),
'Saudi' => elgg_echo ('resume:education:gradetype:Saudi'),
'Serbia3' => elgg_echo ('resume:education:gradetype:Serbia3'),
'Slovakia' => elgg_echo ('resume:education:gradetype:Slovakia'),
'Slovenia3' => elgg_echo ('resume:education:gradetype:Slovenia3'),
'Slovenia2' => elgg_echo ('resume:education:gradetype:Slovenia2'),
'Russia' => elgg_echo ('resume:education:gradetype:Russia'),
'Spain' => elgg_echo ('resume:education:gradetype:Spain'),
'Sweden3' => elgg_echo ('resume:education:gradetype:Sweden3'),
'SwedenECTS' => elgg_echo ('resume:education:gradetype:SwedenECTS'),
'SwedenVG' => elgg_echo ('resume:education:gradetype:SwedenVG'),
'Switzerland' => elgg_echo ('resume:education:gradetype:Switzerland'),
'Thailand' => elgg_echo ('resume:education:gradetype:Thailand'),
'Tunisia10' => elgg_echo ('resume:education:gradetype:Tunisia10'),
'Tunisia20' => elgg_echo ('resume:education:gradetype:Tunisia20'),
'UAE' => elgg_echo ('resume:education:gradetype:UAE'),
'Ukraine' => elgg_echo ('resume:education:gradetype:Ukraine'),
'Uruguay6' => elgg_echo ('resume:education:gradetype:Uruguay6'),
'Uruguay3' => elgg_echo ('resume:education:gradetype:Uruguay3'), 
'Uruguay100' => elgg_echo ('resume:education:gradetype:Uruguay100'),
'Vietnam' => elgg_echo ('resume:education:gradetype:Vietnam'),
'Venezuela20' => elgg_echo ('resume:education:gradetype:Venezuela20'),
'Venezuela100' => elgg_echo ('resume:education:gradetype:Venezuela100'),
'Yugoslavia' => elgg_echo ('resume:education:gradetype:Yugoslavia'),
  );
  
$gradetype = $vars['entity']->gradetype;
if (empty($gradetype)) $gradetype_options = '<option disabled="disabled" selected="selected">-------</option>';
else $gradetype_options = '<option value="' . $gradetype . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:gradetype:' . $gradetype) . '</option>';
foreach ($gradetypes as $he => $te) { $gradetype_options .= '<option value="' .$he. '">' . $te . '</option>'; }

$credittypes = array(
    'major' => elgg_echo('resume:education:credittype:major'),    
    'basic' => elgg_echo('resume:education:credittype:basic'), 
    'chosen' => elgg_echo('resume:education:credittype:chosen'),
    'exam' => elgg_echo('resume:education:credittype:exam'),   
    'transfer' => elgg_echo('resume:education:credittype:transfer'), 
  );
$credittype = $vars['entity']->credittype;
if (empty($credittype)) $credittype_options = '<option selected="selected"></option>';
else $credittype_options = '<option value="' . $credittype . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:credittype:' . $credittype) . '</option>';
foreach ($credittypes as $rh => $rt) { $credittype_options .= '<option value="' .$rh. '">' . $rt . '</option>'; }

$insttypes = array(
    'institution' => elgg_echo('resume:education:insttype:institution'),
    'secondary' => elgg_echo('resume:education:insttype:secondary'),
    'postsec' => elgg_echo('resume:education:insttype:postsec'),
    'university' => elgg_echo('resume:education:insttype:university'),
    'graduate' => elgg_echo('resume:education:insttype:graduate'),
    'research' => elgg_echo('resume:education:insttype:research'),
    'private' => elgg_echo('resume:education:insttype:private'),
    'official' => elgg_echo('resume:education:insttype:official'),
    'state' => elgg_echo('resume:education:insttype:state'), 
    'exam' => elgg_echo('resume:education:insttype:exam'),
    'accessexam' => elgg_echo('resume:education:insttype:accessexam'),
    'medexam' => elgg_echo('resume:education:insttype:medexam'), 
    'stateexam' => elgg_echo('resume:education:insttype:stateexam'),
    'officialexam' => elgg_echo('resume:education:insttype:officialexam'),
    'privateexam' => elgg_echo('resume:education:insttype:privateexam'),    
  );

$insttype_options = '<option selected="selected"></option>';
foreach ($insttypes as $oh => $ot) { $insttype_options .= '<option value="' .$oh. '">' . $ot . '</option>'; }

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;

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
          bodyText += '<?php echo $divsubjects;?><?php echo elgg_echo('resume:education:subject'); echo elgg_echo('resume:*');?><input type="text" name="subjects[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divscores;?><?php echo elgg_echo('resume:education:score'); echo elgg_echo('resume:*');?><input type="text" name="scores[]" value="" class="input-text"/></div>';
          bodyText += '<?php echo $divhours;?><?php echo elgg_echo('resume:education:hour'); echo elgg_echo('resume:*');?><input type="text" name="hours[]" value="" class="input-text"/></div><br /><br /><div class="clearfloat"></div>';
          bodyText += '<?php echo $divtypes;?><?php echo elgg_echo('resume:education:type'); echo elgg_echo('resume:*'); echo '<select name="types[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $credittype_options . '</select>';?></div>';
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
          bodyText += '<div><?php echo elgg_echo('resume:education:structure2'); echo elgg_echo('resume:*'); ?><br /><input type="text" name="structure2" value="" class="input-text"/></div>';
          bodyText += '<div style="float:left; width:24%; margin-right:15px;"><?php echo elgg_echo('resume:education:country'); echo elgg_echo('resume:*'); ?><br /><?php echo '<select name="country" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $country_options . '</select>'; ?></div>';
          bodyText += '<div style="float:left; width:20%; margin-right:15px;"><?php echo elgg_echo('resume:education:insttype'); echo elgg_echo('resume:*'); ?><br /><?php echo '<select name="insttype" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $insttype_options . '</select>'; ?></div>';
          bodyText += '<div style="float:left; width:14%; margin-right:15px;"><?php echo elgg_echo('resume:education:budget'); ?><br /><input type="text" name="budget" value="" class="input-text"/></div>';
          bodyText += '<div style="float:left; width:14%; margin-right:15px;"><?php echo elgg_echo('resume:education:professors'); ?><br /><input type="text" name="professors"  value="" class="input-text"/></div>';
          bodyText += '<div style="float:left; width:14%;"><?php echo elgg_echo('resume:education:students'); ?><br /><input type="text" name="students" value="" class="input-text"/></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" onClick="removeElement(\'parent' + counternew + '\', \'child' + counternew + '\')" value="<?php echo elgg_echo('resume:education:removefield'); ?>"></div></div><div class="clearfloat"></div><br />';
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
  
    <div style="float:left; width:45%;">
      <?php echo elgg_echo('resume:startdate'); ?><br />
      <?php echo elgg_view('input/calendar', array('internalname' => 'startdate', 'value' => $vars['entity']->startdate)); ?>
    </div>
    
    <div style="float:left; width:45%;">
      <?php echo elgg_echo('resume:enddate'); ?>
       &nbsp; <?php echo elgg_echo('resume:enddateorcheck'); ?>
      <input name="ongoing[]" value="ongoing" class="input-checkboxes" type="checkbox" <?php if($vars['entity']->ongoing == 'ongoing') echo 'checked="checked"'; ?>> <?php echo elgg_echo('resume:date:ongoing'); ?><br />
      <?php echo elgg_view('input/calendar', array('internalname' => 'enddate', 'value' => $vars['entity']->enddate)); ?>
    </div>
    
     <div class="clearfloat"></div><br />
    
        <div style="float:left; width:72%; margin-right:1px;">
      <?php echo elgg_echo('resume:education:level');
      echo elgg_echo('resume:*');?><br />
      <select name="level" class="input-pulldown"><?php echo $level_options; ?></select>
    </div>
    
    <div style="float:left; width:20%;">
      <?php echo elgg_echo('resume:education:orientation'); ?><br />
      <select name="orientation" class="input-pulldown"><?php echo $level2_options; ?></select>
    </div>
    
    <div class="clearfloat"></div><br />
        
    <p>
      <?php echo elgg_echo('resume:education:heading'); 
      echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:field'); 
      echo elgg_echo('resume:*');?><br />
      <select name="field" class="input-pulldown"><?php echo $field_options; ?></select>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:edutype'); 
      echo elgg_echo('resume:*');?><br />
      <select name="edutype" class="input-pulldown"><?php echo $edutype_options; ?></select>
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
      echo elgg_view('input/autocomplete', array('internalname' => 'structure', 'match_on' => 'universities',
          'value' => $vars['entity']->structure, 'value_show' => $uniname)); ?>
        </div>
    
       <div style="float:left; width:35%;">
      <?php echo elgg_echo('resume:education:contact'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'contact', 'value' => $vars['entity']->contact)); ?>
       </div>
    
    <div class="clearfloat"></div><br />
     
    <div id="dynamicInput2">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" value="<?php echo elgg_echo('resume:education:addstructure'); ?>" onClick="addInput2('dynamicInput2');">
   
   <br /><br />
    
    <p>
     <?php echo elgg_echo('resume:education:hourtype'); 
      echo elgg_echo('resume:*');?><br />
     <select name="hourtype" class="input-pulldown"><?php echo $hourtype_options; ?></select>
    </p>
        
    <p>
     <?php echo elgg_echo('resume:education:gradetype'); 
      echo elgg_echo('resume:*');?><br />
     <select name="gradetype" class="input-pulldown"><?php echo $gradetype_options; ?></select>
    </p>
   
     <div style="float:left; width:15%; text-align:center; margin-top:10px; margin-right:45px;">
      <?php echo elgg_echo('resume:education:classrank'); 
      echo elgg_echo('resume:*');?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'classrank', 'value' => $vars['entity']->classrank)); ?>
    </div>
    
    <div style="float:left; width:50%;">
      <?php 
      echo elgg_echo('resume:education:prize'); 
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
      <p><?php echo elgg_echo('resume:education:subjects'); 
      echo elgg_echo('resume:*');?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
      
     <?php
    if (!isset($vars['entity'])) {
       echo $divsubjects;
       echo "1. ";
       echo elgg_echo('resume:education:subject');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "subjects[]", 'value' => ""));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:education:score');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "scores[]", 'value' => ""));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:education:hour');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "hours[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $divtypes;
    echo elgg_echo('resume:education:type');
      echo elgg_echo('resume:*');
       echo '<select name="types[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $credittype_options . '</select>';
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
       
       
       echo $divsubjects;
       echo "2. ";
       echo elgg_echo('resume:education:subject');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "subjects[]", 'value' => ""));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:education:score');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "scores[]", 'value' => ""));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:education:hour');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "hours[]", 'value' => ""));
       echo "</div><div class=\"clearfloat\"></div>";
       
       echo $divtypes;
    echo elgg_echo('resume:education:type');
      echo elgg_echo('resume:*');
       echo '<select name="types[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $credittype_options . '</select>';
       echo "</div>";
       echo $divstarts;
    echo elgg_echo('resume:education:starts');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'starts1', 'value' => $vars['entity']->starts));
       echo "</div>";
       echo $divends;
    echo elgg_echo('resume:education:ends');
       echo "<br />";
       echo elgg_view('input/calendar', array('internalname' => 'ends1', 'value' => $vars['entity']->ends));
       echo "</div><div class=\"clearfloat\"></div><br />";
    } 
    else {
    $count = count($subjects_array);	
    for ($i = 0; $i < $count; $i++) {
    	$j= ($i+1);
       echo $divsubjects;
       echo $j . ". ";
       echo elgg_echo('resume:education:subject');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "subjects[]", 'value' => $subjects_array[$i]));
       echo "</div>";
       echo $divscores;
    echo elgg_echo('resume:education:score');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "scores[]", 'value' => $scores_array[$i]));
       echo "</div>";
       echo $divhours;
    echo elgg_echo('resume:education:hour');
      echo elgg_echo('resume:*');
       echo elgg_view('input/text', array('internalname' => "hours[]", 'value' => $hours_array[$i]));
       echo "</div><br /><br /><div class=\"clearfloat\"></div>";
       
$credittype_options = '<option value="' . $types_array[$i] . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:credittype:' . $types_array[$i]) . '</option>';
foreach ($credittypes as $rh => $rt) { $credittype_options .= '<option value="' .$rh. '">' . $rt . '</option>'; }

       echo $divtypes;
    echo elgg_echo('resume:education:type');
      echo elgg_echo('resume:*');
      echo '<select name="types[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $credittype_options . '</select>';
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
