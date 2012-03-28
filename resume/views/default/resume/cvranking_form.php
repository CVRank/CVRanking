<?php

// Decide wich action to use based on if its an edit or add use case.
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/cvranking_add"; }

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;
$times = array (
    "none" => elgg_echo('resume:cvranking:time:none'),
    "age" => elgg_echo('resume:cvranking:time:age'),
    "prog" => elgg_echo('resume:cvranking:time:prog'),
    "exp" => elgg_echo('resume:cvranking:time:exp'),
    );
$time = $vars['entity']->time;
if (empty($time)) $time_options = '<option disabled="disabled" selected="selected">-------</option>';
else $time_options = '<option value="' . $time . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:skill:' . $time) . '</option>';
foreach ($times as $f => $v) { $time_options .= '<option value="' .$f. '">' . $v . '</option>'; }

$fields = array(
'any' => elgg_echo('resume:cvranking:any'),
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
  
$countries = array(
'any' => elgg_echo('resume:country:any'),
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
  

$credittypes = array(
'any' => elgg_echo('resume:cvranking:credittype:any'),
    'major' => elgg_echo('resume:education:credittype:major'),    
    'basic' => elgg_echo('resume:education:credittype:basic'), 
    'chosen' => elgg_echo('resume:education:credittype:chosen'),
    'exam' => elgg_echo('resume:education:credittype:exam'),   
    'transfer' => elgg_echo('resume:education:credittype:transfer'), 
  );  

$edutypes = array(
'any' => elgg_echo('resume:cvranking:credittype:any'),
    'Presence' => elgg_echo('resume:cvranking:edutype:presence'),    
    'Part-time' => elgg_echo('resume:cvranking:edutype:part-time'), 
    'Hybrid' => elgg_echo('resume:cvranking:edutype:hybrid'),
    'Distance' => elgg_echo('resume:cvranking:edutype:distance'),
    'Non-formal' => elgg_echo('resume:cvranking:edutype:non-formal'),
  );   

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

$sectors = array(
'any' => elgg_echo('resume:cvranking:any'),
'1' => elgg_echo('resume:work:occupation:1'),
'11' => elgg_echo('resume:work:occupation:11'),
'111' => elgg_echo('resume:work:occupation:111'),
'1111' => elgg_echo('resume:work:occupation:1111'),
'1112' => elgg_echo('resume:work:occupation:1112'),
'1113' => elgg_echo('resume:work:occupation:1113'),
'1114' => elgg_echo('resume:work:occupation:1114'),
'112' => elgg_echo('resume:work:occupation:112'),
'1120' => elgg_echo('resume:work:occupation:1120'),
'12' => elgg_echo('resume:work:occupation:12'),
'121' => elgg_echo('resume:work:occupation:121'),
'1211' => elgg_echo('resume:work:occupation:1211'),
'1212' => elgg_echo('resume:work:occupation:1212'),
'1213' => elgg_echo('resume:work:occupation:1213'),
'1219' => elgg_echo('resume:work:occupation:1219'),
'122' => elgg_echo('resume:work:occupation:122'),
'1221' => elgg_echo('resume:work:occupation:1221'),
'1222' => elgg_echo('resume:work:occupation:1222'),
'1223' => elgg_echo('resume:work:occupation:1223'),
'13' => elgg_echo('resume:work:occupation:13'),
'131' => elgg_echo('resume:work:occupation:131'),
'1311' => elgg_echo('resume:work:occupation:1311'),
'1312' => elgg_echo('resume:work:occupation:1312'),
'132' => elgg_echo('resume:work:occupation:132'),
'1321' => elgg_echo('resume:work:occupation:1321'),
'1322' => elgg_echo('resume:work:occupation:1322'),
'1323' => elgg_echo('resume:work:occupation:1323'),
'1324' => elgg_echo('resume:work:occupation:1324'),
'133' => elgg_echo('resume:work:occupation:133'),
'1330' => elgg_echo('resume:work:occupation:1330'),
'134' => elgg_echo('resume:work:occupation:134'),
'1341' => elgg_echo('resume:work:occupation:1341'),
'1342' => elgg_echo('resume:work:occupation:1342'),
'1343' => elgg_echo('resume:work:occupation:1343'),
'1344' => elgg_echo('resume:work:occupation:1344'),
'1345' => elgg_echo('resume:work:occupation:1345'),
'1346' => elgg_echo('resume:work:occupation:1346'),
'1349' => elgg_echo('resume:work:occupation:1349'),
'14' => elgg_echo('resume:work:occupation:14'),
'141' => elgg_echo('resume:work:occupation:141'),
'1411' => elgg_echo('resume:work:occupation:1411'),
'1412' => elgg_echo('resume:work:occupation:1412'),
'142' => elgg_echo('resume:work:occupation:142'),
'1420' => elgg_echo('resume:work:occupation:1420'),
'143' => elgg_echo('resume:work:occupation:143'),
'1431' => elgg_echo('resume:work:occupation:1431'),
'1439' => elgg_echo('resume:work:occupation:1439'),
'2' => elgg_echo('resume:work:occupation:2'),
'21' => elgg_echo('resume:work:occupation:21'),
'211' => elgg_echo('resume:work:occupation:211'),
'2111' => elgg_echo('resume:work:occupation:2111'),
'2112' => elgg_echo('resume:work:occupation:2112'),
'2113' => elgg_echo('resume:work:occupation:2113'),
'2114' => elgg_echo('resume:work:occupation:2114'),
'212' => elgg_echo('resume:work:occupation:212'),
'2120' => elgg_echo('resume:work:occupation:2120'),
'213' => elgg_echo('resume:work:occupation:213'),
'2131' => elgg_echo('resume:work:occupation:2131'),
'2132' => elgg_echo('resume:work:occupation:2132'),
'2133' => elgg_echo('resume:work:occupation:2133'),
'214' => elgg_echo('resume:work:occupation:214'),
'2141' => elgg_echo('resume:work:occupation:2141'),
'2142' => elgg_echo('resume:work:occupation:2142'),
'2143' => elgg_echo('resume:work:occupation:2143'),
'2144' => elgg_echo('resume:work:occupation:2144'),
'2145' => elgg_echo('resume:work:occupation:2145'),
'2146' => elgg_echo('resume:work:occupation:2146'),
'2149' => elgg_echo('resume:work:occupation:2149'),
'215' => elgg_echo('resume:work:occupation:215'),
'2151' => elgg_echo('resume:work:occupation:2151'),
'2152' => elgg_echo('resume:work:occupation:2152'),
'2153' => elgg_echo('resume:work:occupation:2153'),
'216' => elgg_echo('resume:work:occupation:216'),
'2161' => elgg_echo('resume:work:occupation:2161'),
'2162' => elgg_echo('resume:work:occupation:2162'),
'2163' => elgg_echo('resume:work:occupation:2163'),
'2164' => elgg_echo('resume:work:occupation:2164'),
'2165' => elgg_echo('resume:work:occupation:2165'),
'2166' => elgg_echo('resume:work:occupation:2166'),
'22' => elgg_echo('resume:work:occupation:22'),
'221' => elgg_echo('resume:work:occupation:221'),
'2211' => elgg_echo('resume:work:occupation:2211'),
'2212' => elgg_echo('resume:work:occupation:2212'),
'222' => elgg_echo('resume:work:occupation:222'),
'2221' => elgg_echo('resume:work:occupation:2221'),
'2222' => elgg_echo('resume:work:occupation:2222'),
'223' => elgg_echo('resume:work:occupation:223'),
'2230' => elgg_echo('resume:work:occupation:2230'),
'224' => elgg_echo('resume:work:occupation:224'),
'2240' => elgg_echo('resume:work:occupation:2240'),
'225' => elgg_echo('resume:work:occupation:225'),
'2250' => elgg_echo('resume:work:occupation:2250'),
'226' => elgg_echo('resume:work:occupation:226'),
'2261' => elgg_echo('resume:work:occupation:2261'),
'2262' => elgg_echo('resume:work:occupation:2262'),
'2263' => elgg_echo('resume:work:occupation:2263'),
'2264' => elgg_echo('resume:work:occupation:2264'),
'2265' => elgg_echo('resume:work:occupation:2265'),
'2266' => elgg_echo('resume:work:occupation:2266'),
'2267' => elgg_echo('resume:work:occupation:2267'),
'2269' => elgg_echo('resume:work:occupation:2269'),
'23' => elgg_echo('resume:work:occupation:23'),
'231' => elgg_echo('resume:work:occupation:231'),
'2310' => elgg_echo('resume:work:occupation:2310'),
'232' => elgg_echo('resume:work:occupation:232'),
'2320' => elgg_echo('resume:work:occupation:2320'),
'233' => elgg_echo('resume:work:occupation:233'),
'2330' => elgg_echo('resume:work:occupation:2330'),
'234' => elgg_echo('resume:work:occupation:234'),
'2341' => elgg_echo('resume:work:occupation:2341'),
'2342' => elgg_echo('resume:work:occupation:2342'),
'235' => elgg_echo('resume:work:occupation:235'),
'2351' => elgg_echo('resume:work:occupation:2351'),
'2352' => elgg_echo('resume:work:occupation:2352'),
'2353' => elgg_echo('resume:work:occupation:2353'),
'2354' => elgg_echo('resume:work:occupation:2354'),
'2355' => elgg_echo('resume:work:occupation:2355'),
'2356' => elgg_echo('resume:work:occupation:2356'),
'2359' => elgg_echo('resume:work:occupation:2359'),
'24' => elgg_echo('resume:work:occupation:24'),
'241' => elgg_echo('resume:work:occupation:241'),
'2411' => elgg_echo('resume:work:occupation:2411'),
'2412' => elgg_echo('resume:work:occupation:2412'),
'2413' => elgg_echo('resume:work:occupation:2413'),
'242' => elgg_echo('resume:work:occupation:242'),
'2421' => elgg_echo('resume:work:occupation:2421'),
'2422' => elgg_echo('resume:work:occupation:2422'),
'2423' => elgg_echo('resume:work:occupation:2423'),
'2424' => elgg_echo('resume:work:occupation:2424'),
'243' => elgg_echo('resume:work:occupation:243'),
'2431' => elgg_echo('resume:work:occupation:2431'),
'2432' => elgg_echo('resume:work:occupation:2432'),
'2433' => elgg_echo('resume:work:occupation:2433'),
'2434' => elgg_echo('resume:work:occupation:2434'),
'25' => elgg_echo('resume:work:occupation:25'),
'251' => elgg_echo('resume:work:occupation:251'),
'2511' => elgg_echo('resume:work:occupation:2511'),
'2512' => elgg_echo('resume:work:occupation:2512'),
'2513' => elgg_echo('resume:work:occupation:2513'),
'2514' => elgg_echo('resume:work:occupation:2514'),
'2519' => elgg_echo('resume:work:occupation:2519'),
'252' => elgg_echo('resume:work:occupation:252'),
'2521' => elgg_echo('resume:work:occupation:2521'),
'2522' => elgg_echo('resume:work:occupation:2522'),
'2523' => elgg_echo('resume:work:occupation:2523'),
'2529' => elgg_echo('resume:work:occupation:2529'),
'26' => elgg_echo('resume:work:occupation:26'),
'261' => elgg_echo('resume:work:occupation:261'),
'2611' => elgg_echo('resume:work:occupation:2611'),
'2612' => elgg_echo('resume:work:occupation:2612'),
'2619' => elgg_echo('resume:work:occupation:2619'),
'262' => elgg_echo('resume:work:occupation:262'),
'2621' => elgg_echo('resume:work:occupation:2621'),
'2622' => elgg_echo('resume:work:occupation:2622'),
'263' => elgg_echo('resume:work:occupation:263'),
'2631' => elgg_echo('resume:work:occupation:2631'),
'2632' => elgg_echo('resume:work:occupation:2632'),
'2633' => elgg_echo('resume:work:occupation:2633'),
'2634' => elgg_echo('resume:work:occupation:2634'),
'2635' => elgg_echo('resume:work:occupation:2635'),
'2636' => elgg_echo('resume:work:occupation:2636'),
'264' => elgg_echo('resume:work:occupation:264'),
'2641' => elgg_echo('resume:work:occupation:2641'),
'2642' => elgg_echo('resume:work:occupation:2642'),
'2643' => elgg_echo('resume:work:occupation:2643'),
'265' => elgg_echo('resume:work:occupation:265'),
'2651' => elgg_echo('resume:work:occupation:2651'),
'2652' => elgg_echo('resume:work:occupation:2652'),
'2653' => elgg_echo('resume:work:occupation:2653'),
'2654' => elgg_echo('resume:work:occupation:2654'),
'2655' => elgg_echo('resume:work:occupation:2655'),
'2656' => elgg_echo('resume:work:occupation:2656'),
'2659' => elgg_echo('resume:work:occupation:2659'),
'3' => elgg_echo('resume:work:occupation:3'),
'31' => elgg_echo('resume:work:occupation:31'),
'311' => elgg_echo('resume:work:occupation:311'),
'3111' => elgg_echo('resume:work:occupation:3111'),
'3112' => elgg_echo('resume:work:occupation:3112'),
'3113' => elgg_echo('resume:work:occupation:3113'),
'3114' => elgg_echo('resume:work:occupation:3114'),
'3115' => elgg_echo('resume:work:occupation:3115'),
'3116' => elgg_echo('resume:work:occupation:3116'),
'3117' => elgg_echo('resume:work:occupation:3117'),
'3118' => elgg_echo('resume:work:occupation:3118'),
'3119' => elgg_echo('resume:work:occupation:3119'),
'312' => elgg_echo('resume:work:occupation:312'),
'3121' => elgg_echo('resume:work:occupation:3121'),
'3122' => elgg_echo('resume:work:occupation:3122'),
'3123' => elgg_echo('resume:work:occupation:3123'),
'313' => elgg_echo('resume:work:occupation:313'),
'3131' => elgg_echo('resume:work:occupation:3131'),
'3132' => elgg_echo('resume:work:occupation:3132'),
'3133' => elgg_echo('resume:work:occupation:3133'),
'3134' => elgg_echo('resume:work:occupation:3134'),
'3135' => elgg_echo('resume:work:occupation:3135'),
'3139' => elgg_echo('resume:work:occupation:3139'),
'314' => elgg_echo('resume:work:occupation:314'),
'3141' => elgg_echo('resume:work:occupation:3141'),
'3142' => elgg_echo('resume:work:occupation:3142'),
'3143' => elgg_echo('resume:work:occupation:3143'),
'315' => elgg_echo('resume:work:occupation:315'),
'3151' => elgg_echo('resume:work:occupation:3151'),
'3152' => elgg_echo('resume:work:occupation:3152'),
'3153' => elgg_echo('resume:work:occupation:3153'),
'3154' => elgg_echo('resume:work:occupation:3154'),
'3155' => elgg_echo('resume:work:occupation:3155'),
'32' => elgg_echo('resume:work:occupation:32'),
'321' => elgg_echo('resume:work:occupation:321'),
'3211' => elgg_echo('resume:work:occupation:3211'),
'3212' => elgg_echo('resume:work:occupation:3212'),
'3213' => elgg_echo('resume:work:occupation:3213'),
'3214' => elgg_echo('resume:work:occupation:3214'),
'322' => elgg_echo('resume:work:occupation:322'),
'3221' => elgg_echo('resume:work:occupation:3221'),
'3222' => elgg_echo('resume:work:occupation:3222'),
'323' => elgg_echo('resume:work:occupation:323'),
'3230' => elgg_echo('resume:work:occupation:3230'),
'324' => elgg_echo('resume:work:occupation:324'),
'3240' => elgg_echo('resume:work:occupation:3240'),
'325' => elgg_echo('resume:work:occupation:325'),
'3251' => elgg_echo('resume:work:occupation:3251'),
'3252' => elgg_echo('resume:work:occupation:3252'),
'3253' => elgg_echo('resume:work:occupation:3253'),
'3254' => elgg_echo('resume:work:occupation:3254'),
'3255' => elgg_echo('resume:work:occupation:3255'),
'3256' => elgg_echo('resume:work:occupation:3256'),
'3257' => elgg_echo('resume:work:occupation:3257'),
'3258' => elgg_echo('resume:work:occupation:3258'),
'3259' => elgg_echo('resume:work:occupation:3259'),
'33' => elgg_echo('resume:work:occupation:33'),
'331' => elgg_echo('resume:work:occupation:331'),
'3311' => elgg_echo('resume:work:occupation:3311'),
'3312' => elgg_echo('resume:work:occupation:3312'),
'3313' => elgg_echo('resume:work:occupation:3313'),
'3314' => elgg_echo('resume:work:occupation:3314'),
'3315' => elgg_echo('resume:work:occupation:3315'),
'332' => elgg_echo('resume:work:occupation:332'),
'3321' => elgg_echo('resume:work:occupation:3321'),
'3322' => elgg_echo('resume:work:occupation:3322'),
'3323' => elgg_echo('resume:work:occupation:3323'),
'3324' => elgg_echo('resume:work:occupation:3324'),
'333' => elgg_echo('resume:work:occupation:333'),
'3331' => elgg_echo('resume:work:occupation:3331'),
'3332' => elgg_echo('resume:work:occupation:3332'),
'3333' => elgg_echo('resume:work:occupation:3333'),
'3334' => elgg_echo('resume:work:occupation:3334'),
'3339' => elgg_echo('resume:work:occupation:3339'),
'334' => elgg_echo('resume:work:occupation:334'),
'3341' => elgg_echo('resume:work:occupation:3341'),
'3342' => elgg_echo('resume:work:occupation:3342'),
'3343' => elgg_echo('resume:work:occupation:3343'),
'3344' => elgg_echo('resume:work:occupation:3344'),
'335' => elgg_echo('resume:work:occupation:335'),
'3351' => elgg_echo('resume:work:occupation:3351'),
'3352' => elgg_echo('resume:work:occupation:3352'),
'3353' => elgg_echo('resume:work:occupation:3353'),
'3354' => elgg_echo('resume:work:occupation:3354'),
'3355' => elgg_echo('resume:work:occupation:3355'),
'3359' => elgg_echo('resume:work:occupation:3359'),
'34' => elgg_echo('resume:work:occupation:34'),
'341' => elgg_echo('resume:work:occupation:341'),
'3411' => elgg_echo('resume:work:occupation:3411'),
'3412' => elgg_echo('resume:work:occupation:3412'),
'3413' => elgg_echo('resume:work:occupation:3413'),
'342' => elgg_echo('resume:work:occupation:342'),
'3421' => elgg_echo('resume:work:occupation:3421'),
'3422' => elgg_echo('resume:work:occupation:3422'),
'3423' => elgg_echo('resume:work:occupation:3423'),
'343' => elgg_echo('resume:work:occupation:343'),
'3431' => elgg_echo('resume:work:occupation:3431'),
'3432' => elgg_echo('resume:work:occupation:3432'),
'3433' => elgg_echo('resume:work:occupation:3433'),
'3434' => elgg_echo('resume:work:occupation:3434'),
'3435' => elgg_echo('resume:work:occupation:3435'),
'35' => elgg_echo('resume:work:occupation:35'),
'351' => elgg_echo('resume:work:occupation:351'),
'3511' => elgg_echo('resume:work:occupation:3511'),
'3512' => elgg_echo('resume:work:occupation:3512'),
'3513' => elgg_echo('resume:work:occupation:3513'),
'3514' => elgg_echo('resume:work:occupation:3514'),
'352' => elgg_echo('resume:work:occupation:352'),
'3521' => elgg_echo('resume:work:occupation:3521'),
'3522' => elgg_echo('resume:work:occupation:3522'),
'4' => elgg_echo('resume:work:occupation:4'),
'41' => elgg_echo('resume:work:occupation:41'),
'411' => elgg_echo('resume:work:occupation:411'),
'4110' => elgg_echo('resume:work:occupation:4110'),
'412' => elgg_echo('resume:work:occupation:412'),
'4120' => elgg_echo('resume:work:occupation:4120'),
'413' => elgg_echo('resume:work:occupation:413'),
'4131' => elgg_echo('resume:work:occupation:4131'),
'4132' => elgg_echo('resume:work:occupation:4132'),
'42' => elgg_echo('resume:work:occupation:42'),
'421' => elgg_echo('resume:work:occupation:421'),
'4211' => elgg_echo('resume:work:occupation:4211'),
'4212' => elgg_echo('resume:work:occupation:4212'),
'4213' => elgg_echo('resume:work:occupation:4213'),
'4214' => elgg_echo('resume:work:occupation:4214'),
'422' => elgg_echo('resume:work:occupation:422'),
'4221' => elgg_echo('resume:work:occupation:4221'),
'4222' => elgg_echo('resume:work:occupation:4222'),
'4223' => elgg_echo('resume:work:occupation:4223'),
'4224' => elgg_echo('resume:work:occupation:4224'),
'4225' => elgg_echo('resume:work:occupation:4225'),
'4226' => elgg_echo('resume:work:occupation:4226'),
'4227' => elgg_echo('resume:work:occupation:4227'),
'4229' => elgg_echo('resume:work:occupation:4229'),
'43' => elgg_echo('resume:work:occupation:43'),
'431' => elgg_echo('resume:work:occupation:431'),
'4311' => elgg_echo('resume:work:occupation:4311'),
'4312' => elgg_echo('resume:work:occupation:4312'),
'4313' => elgg_echo('resume:work:occupation:4313'),
'432' => elgg_echo('resume:work:occupation:432'),
'4321' => elgg_echo('resume:work:occupation:4321'),
'4322' => elgg_echo('resume:work:occupation:4322'),
'4323' => elgg_echo('resume:work:occupation:4323'),
'44' => elgg_echo('resume:work:occupation:44'),
'441' => elgg_echo('resume:work:occupation:441'),
'4411' => elgg_echo('resume:work:occupation:4411'),
'4412' => elgg_echo('resume:work:occupation:4412'),
'4413' => elgg_echo('resume:work:occupation:4413'),
'4414' => elgg_echo('resume:work:occupation:4414'),
'4415' => elgg_echo('resume:work:occupation:4415'),
'4416' => elgg_echo('resume:work:occupation:4416'),
'4419' => elgg_echo('resume:work:occupation:4419'),
'5' => elgg_echo('resume:work:occupation:5'),
'51' => elgg_echo('resume:work:occupation:51'),
'511' => elgg_echo('resume:work:occupation:511'),
'5111' => elgg_echo('resume:work:occupation:5111'),
'5112' => elgg_echo('resume:work:occupation:5112'),
'5113' => elgg_echo('resume:work:occupation:5113'),
'512' => elgg_echo('resume:work:occupation:512'),
'5120' => elgg_echo('resume:work:occupation:5120'),
'513' => elgg_echo('resume:work:occupation:513'),
'5131' => elgg_echo('resume:work:occupation:5131'),
'5132' => elgg_echo('resume:work:occupation:5132'),
'514' => elgg_echo('resume:work:occupation:514'),
'5141' => elgg_echo('resume:work:occupation:5141'),
'5142' => elgg_echo('resume:work:occupation:5142'),
'515' => elgg_echo('resume:work:occupation:515'),
'5151' => elgg_echo('resume:work:occupation:5151'),
'5152' => elgg_echo('resume:work:occupation:5152'),
'5153' => elgg_echo('resume:work:occupation:5153'),
'516' => elgg_echo('resume:work:occupation:516'),
'5161' => elgg_echo('resume:work:occupation:5161'),
'5162' => elgg_echo('resume:work:occupation:5162'),
'5163' => elgg_echo('resume:work:occupation:5163'),
'5164' => elgg_echo('resume:work:occupation:5164'),
'5165' => elgg_echo('resume:work:occupation:5165'),
'5169' => elgg_echo('resume:work:occupation:5169'),
'52' => elgg_echo('resume:work:occupation:52'),
'521' => elgg_echo('resume:work:occupation:521'),
'5211' => elgg_echo('resume:work:occupation:5211'),
'5212' => elgg_echo('resume:work:occupation:5212'),
'522' => elgg_echo('resume:work:occupation:522'),
'5221' => elgg_echo('resume:work:occupation:5221'),
'5222' => elgg_echo('resume:work:occupation:5222'),
'5223' => elgg_echo('resume:work:occupation:5223'),
'523' => elgg_echo('resume:work:occupation:523'),
'5230' => elgg_echo('resume:work:occupation:5230'),
'524' => elgg_echo('resume:work:occupation:524'),
'5241' => elgg_echo('resume:work:occupation:5241'),
'5242' => elgg_echo('resume:work:occupation:5242'),
'5243' => elgg_echo('resume:work:occupation:5243'),
'5244' => elgg_echo('resume:work:occupation:5244'),
'5245' => elgg_echo('resume:work:occupation:5245'),
'5246' => elgg_echo('resume:work:occupation:5246'),
'5249' => elgg_echo('resume:work:occupation:5249'),
'53' => elgg_echo('resume:work:occupation:53'),
'531' => elgg_echo('resume:work:occupation:531'),
'5311' => elgg_echo('resume:work:occupation:5311'),
'5312' => elgg_echo('resume:work:occupation:5312'),
'532' => elgg_echo('resume:work:occupation:532'),
'5321' => elgg_echo('resume:work:occupation:5321'),
'5322' => elgg_echo('resume:work:occupation:5322'),
'5329' => elgg_echo('resume:work:occupation:5329'),
'54' => elgg_echo('resume:work:occupation:54'),
'541' => elgg_echo('resume:work:occupation:541'),
'5411' => elgg_echo('resume:work:occupation:5411'),
'5412' => elgg_echo('resume:work:occupation:5412'),
'5413' => elgg_echo('resume:work:occupation:5413'),
'5414' => elgg_echo('resume:work:occupation:5414'),
'5419' => elgg_echo('resume:work:occupation:5419'),
'6' => elgg_echo('resume:work:occupation:6'),
'61' => elgg_echo('resume:work:occupation:61'),
'611' => elgg_echo('resume:work:occupation:611'),
'6111' => elgg_echo('resume:work:occupation:6111'),
'6112' => elgg_echo('resume:work:occupation:6112'),
'6113' => elgg_echo('resume:work:occupation:6113'),
'6114' => elgg_echo('resume:work:occupation:6114'),
'612' => elgg_echo('resume:work:occupation:612'),
'6121' => elgg_echo('resume:work:occupation:6121'),
'6122' => elgg_echo('resume:work:occupation:6122'),
'6123' => elgg_echo('resume:work:occupation:6123'),
'6129' => elgg_echo('resume:work:occupation:6129'),
'613' => elgg_echo('resume:work:occupation:613'),
'6130' => elgg_echo('resume:work:occupation:6130'),
'62' => elgg_echo('resume:work:occupation:62'),
'621' => elgg_echo('resume:work:occupation:621'),
'6210' => elgg_echo('resume:work:occupation:6210'),
'622' => elgg_echo('resume:work:occupation:622'),
'6221' => elgg_echo('resume:work:occupation:6221'),
'6222' => elgg_echo('resume:work:occupation:6222'),
'6223' => elgg_echo('resume:work:occupation:6223'),
'6224' => elgg_echo('resume:work:occupation:6224'),
'63' => elgg_echo('resume:work:occupation:63'),
'631' => elgg_echo('resume:work:occupation:631'),
'6310' => elgg_echo('resume:work:occupation:6310'),
'632' => elgg_echo('resume:work:occupation:632'),
'6320' => elgg_echo('resume:work:occupation:6320'),
'633' => elgg_echo('resume:work:occupation:633'),
'6330' => elgg_echo('resume:work:occupation:6330'),
'634' => elgg_echo('resume:work:occupation:634'),
'6340' => elgg_echo('resume:work:occupation:6340'),
'7' => elgg_echo('resume:work:occupation:7'),
'71' => elgg_echo('resume:work:occupation:71'),
'711' => elgg_echo('resume:work:occupation:711'),
'7111' => elgg_echo('resume:work:occupation:7111'),
'7112' => elgg_echo('resume:work:occupation:7112'),
'7113' => elgg_echo('resume:work:occupation:7113'),
'7114' => elgg_echo('resume:work:occupation:7114'),
'7115' => elgg_echo('resume:work:occupation:7115'),
'7119' => elgg_echo('resume:work:occupation:7119'),
'712' => elgg_echo('resume:work:occupation:712'),
'7121' => elgg_echo('resume:work:occupation:7121'),
'7122' => elgg_echo('resume:work:occupation:7122'),
'7123' => elgg_echo('resume:work:occupation:7123'),
'7124' => elgg_echo('resume:work:occupation:7124'),
'7125' => elgg_echo('resume:work:occupation:7125'),
'7126' => elgg_echo('resume:work:occupation:7126'),
'7127' => elgg_echo('resume:work:occupation:7127'),
'713' => elgg_echo('resume:work:occupation:713'),
'7131' => elgg_echo('resume:work:occupation:7131'),
'7132' => elgg_echo('resume:work:occupation:7132'),
'7133' => elgg_echo('resume:work:occupation:7133'),
'72' => elgg_echo('resume:work:occupation:72'),
'721' => elgg_echo('resume:work:occupation:721'),
'7211' => elgg_echo('resume:work:occupation:7211'),
'7212' => elgg_echo('resume:work:occupation:7212'),
'7213' => elgg_echo('resume:work:occupation:7213'),
'7214' => elgg_echo('resume:work:occupation:7214'),
'7215' => elgg_echo('resume:work:occupation:7215'),
'722' => elgg_echo('resume:work:occupation:722'),
'7221' => elgg_echo('resume:work:occupation:7221'),
'7222' => elgg_echo('resume:work:occupation:7222'),
'7223' => elgg_echo('resume:work:occupation:7223'),
'7224' => elgg_echo('resume:work:occupation:7224'),
'723' => elgg_echo('resume:work:occupation:723'),
'7231' => elgg_echo('resume:work:occupation:7231'),
'7232' => elgg_echo('resume:work:occupation:7232'),
'7233' => elgg_echo('resume:work:occupation:7233'),
'7234' => elgg_echo('resume:work:occupation:7234'),
'73' => elgg_echo('resume:work:occupation:73'),
'731' => elgg_echo('resume:work:occupation:731'),
'7311' => elgg_echo('resume:work:occupation:7311'),
'7312' => elgg_echo('resume:work:occupation:7312'),
'7313' => elgg_echo('resume:work:occupation:7313'),
'7314' => elgg_echo('resume:work:occupation:7314'),
'7315' => elgg_echo('resume:work:occupation:7315'),
'7316' => elgg_echo('resume:work:occupation:7316'),
'7317' => elgg_echo('resume:work:occupation:7317'),
'7318' => elgg_echo('resume:work:occupation:7318'),
'7319' => elgg_echo('resume:work:occupation:7319'),
'732' => elgg_echo('resume:work:occupation:732'),
'7321' => elgg_echo('resume:work:occupation:7321'),
'7322' => elgg_echo('resume:work:occupation:7322'),
'7323' => elgg_echo('resume:work:occupation:7323'),
'74' => elgg_echo('resume:work:occupation:74'),
'741' => elgg_echo('resume:work:occupation:741'),
'7411' => elgg_echo('resume:work:occupation:7411'),
'7412' => elgg_echo('resume:work:occupation:7412'),
'7413' => elgg_echo('resume:work:occupation:7413'),
'742' => elgg_echo('resume:work:occupation:742'),
'7421' => elgg_echo('resume:work:occupation:7421'),
'7422' => elgg_echo('resume:work:occupation:7422'),
'75' => elgg_echo('resume:work:occupation:75'),
'751' => elgg_echo('resume:work:occupation:751'),
'7511' => elgg_echo('resume:work:occupation:7511'),
'7512' => elgg_echo('resume:work:occupation:7512'),
'7513' => elgg_echo('resume:work:occupation:7513'),
'7514' => elgg_echo('resume:work:occupation:7514'),
'7515' => elgg_echo('resume:work:occupation:7515'),
'7516' => elgg_echo('resume:work:occupation:7516'),
'752' => elgg_echo('resume:work:occupation:752'),
'7521' => elgg_echo('resume:work:occupation:7521'),
'7522' => elgg_echo('resume:work:occupation:7522'),
'7523' => elgg_echo('resume:work:occupation:7523'),
'753' => elgg_echo('resume:work:occupation:753'),
'7531' => elgg_echo('resume:work:occupation:7531'),
'7532' => elgg_echo('resume:work:occupation:7532'),
'7533' => elgg_echo('resume:work:occupation:7533'),
'7534' => elgg_echo('resume:work:occupation:7534'),
'7535' => elgg_echo('resume:work:occupation:7535'),
'7536' => elgg_echo('resume:work:occupation:7536'),
'754' => elgg_echo('resume:work:occupation:754'),
'7541' => elgg_echo('resume:work:occupation:7541'),
'7542' => elgg_echo('resume:work:occupation:7542'),
'7543' => elgg_echo('resume:work:occupation:7543'),
'7544' => elgg_echo('resume:work:occupation:7544'),
'7549' => elgg_echo('resume:work:occupation:7549'),
'8' => elgg_echo('resume:work:occupation:8'),
'81' => elgg_echo('resume:work:occupation:81'),
'811' => elgg_echo('resume:work:occupation:811'),
'8111' => elgg_echo('resume:work:occupation:8111'),
'8112' => elgg_echo('resume:work:occupation:8112'),
'8113' => elgg_echo('resume:work:occupation:8113'),
'8114' => elgg_echo('resume:work:occupation:8114'),
'812' => elgg_echo('resume:work:occupation:812'),
'8121' => elgg_echo('resume:work:occupation:8121'),
'8122' => elgg_echo('resume:work:occupation:8122'),
'813' => elgg_echo('resume:work:occupation:813'),
'8131' => elgg_echo('resume:work:occupation:8131'),
'8132' => elgg_echo('resume:work:occupation:8132'),
'814' => elgg_echo('resume:work:occupation:814'),
'8141' => elgg_echo('resume:work:occupation:8141'),
'8142' => elgg_echo('resume:work:occupation:8142'),
'8143' => elgg_echo('resume:work:occupation:8143'),
'815' => elgg_echo('resume:work:occupation:815'),
'8151' => elgg_echo('resume:work:occupation:8151'),
'8152' => elgg_echo('resume:work:occupation:8152'),
'8153' => elgg_echo('resume:work:occupation:8153'),
'8154' => elgg_echo('resume:work:occupation:8154'),
'8155' => elgg_echo('resume:work:occupation:8155'),
'8156' => elgg_echo('resume:work:occupation:8156'),
'8157' => elgg_echo('resume:work:occupation:8157'),
'8159' => elgg_echo('resume:work:occupation:8159'),
'816' => elgg_echo('resume:work:occupation:816'),
'8160' => elgg_echo('resume:work:occupation:8160'),
'817' => elgg_echo('resume:work:occupation:817'),
'8171' => elgg_echo('resume:work:occupation:8171'),
'8172' => elgg_echo('resume:work:occupation:8172'),
'818' => elgg_echo('resume:work:occupation:818'),
'8181' => elgg_echo('resume:work:occupation:8181'),
'8182' => elgg_echo('resume:work:occupation:8182'),
'8183' => elgg_echo('resume:work:occupation:8183'),
'8189' => elgg_echo('resume:work:occupation:8189'),
'82' => elgg_echo('resume:work:occupation:82'),
'821' => elgg_echo('resume:work:occupation:821'),
'8211' => elgg_echo('resume:work:occupation:8211'),
'8212' => elgg_echo('resume:work:occupation:8212'),
'8219' => elgg_echo('resume:work:occupation:8219'),
'83' => elgg_echo('resume:work:occupation:83'),
'831' => elgg_echo('resume:work:occupation:831'),
'8311' => elgg_echo('resume:work:occupation:8311'),
'8312' => elgg_echo('resume:work:occupation:8312'),
'832' => elgg_echo('resume:work:occupation:832'),
'8321' => elgg_echo('resume:work:occupation:8321'),
'8322' => elgg_echo('resume:work:occupation:8322'),
'833' => elgg_echo('resume:work:occupation:833'),
'8331' => elgg_echo('resume:work:occupation:8331'),
'8332' => elgg_echo('resume:work:occupation:8332'),
'834' => elgg_echo('resume:work:occupation:834'),
'8341' => elgg_echo('resume:work:occupation:8341'),
'8342' => elgg_echo('resume:work:occupation:8342'),
'8343' => elgg_echo('resume:work:occupation:8343'),
'8344' => elgg_echo('resume:work:occupation:8344'),
'835' => elgg_echo('resume:work:occupation:835'),
'8350' => elgg_echo('resume:work:occupation:8350'),
'9' => elgg_echo('resume:work:occupation:9'),
'91' => elgg_echo('resume:work:occupation:91'),
'911' => elgg_echo('resume:work:occupation:911'),
'9111' => elgg_echo('resume:work:occupation:9111'),
'9112' => elgg_echo('resume:work:occupation:9112'),
'912' => elgg_echo('resume:work:occupation:912'),
'9121' => elgg_echo('resume:work:occupation:9121'),
'9122' => elgg_echo('resume:work:occupation:9122'),
'9123' => elgg_echo('resume:work:occupation:9123'),
'9129' => elgg_echo('resume:work:occupation:9129'),
'92' => elgg_echo('resume:work:occupation:92'),
'921' => elgg_echo('resume:work:occupation:921'),
'9211' => elgg_echo('resume:work:occupation:9211'),
'9212' => elgg_echo('resume:work:occupation:9212'),
'9213' => elgg_echo('resume:work:occupation:9213'),
'9214' => elgg_echo('resume:work:occupation:9214'),
'9215' => elgg_echo('resume:work:occupation:9215'),
'9216' => elgg_echo('resume:work:occupation:9216'),
'93' => elgg_echo('resume:work:occupation:93'),
'931' => elgg_echo('resume:work:occupation:931'),
'9311' => elgg_echo('resume:work:occupation:9311'),
'9312' => elgg_echo('resume:work:occupation:9312'),
'9313' => elgg_echo('resume:work:occupation:9313'),
'932' => elgg_echo('resume:work:occupation:932'),
'9321' => elgg_echo('resume:work:occupation:9321'),
'9329' => elgg_echo('resume:work:occupation:9329'),
'933' => elgg_echo('resume:work:occupation:933'),
'9331' => elgg_echo('resume:work:occupation:9331'),
'9332' => elgg_echo('resume:work:occupation:9332'),
'9333' => elgg_echo('resume:work:occupation:9333'),
'9334' => elgg_echo('resume:work:occupation:9334'),
'94' => elgg_echo('resume:work:occupation:94'),
'941' => elgg_echo('resume:work:occupation:941'),
'9411' => elgg_echo('resume:work:occupation:9411'),
'9412' => elgg_echo('resume:work:occupation:9412'),
'95' => elgg_echo('resume:work:occupation:95'),
'951' => elgg_echo('resume:work:occupation:951'),
'9510' => elgg_echo('resume:work:occupation:9510'),
'952' => elgg_echo('resume:work:occupation:952'),
'9520' => elgg_echo('resume:work:occupation:9520'),
'96' => elgg_echo('resume:work:occupation:96'),
'961' => elgg_echo('resume:work:occupation:961'),
'9611' => elgg_echo('resume:work:occupation:9611'),
'9612' => elgg_echo('resume:work:occupation:9612'),
'9613' => elgg_echo('resume:work:occupation:9613'),
'962' => elgg_echo('resume:work:occupation:962'),
'9621' => elgg_echo('resume:work:occupation:9621'),
'9622' => elgg_echo('resume:work:occupation:9622'),
'9623' => elgg_echo('resume:work:occupation:9623'),
'9624' => elgg_echo('resume:work:occupation:9624'),
'9629' => elgg_echo('resume:work:occupation:9629'),
'0' => elgg_echo('resume:work:occupation:0'),
'01' => elgg_echo('resume:work:occupation:01'),
'011' => elgg_echo('resume:work:occupation:011'),
'0110' => elgg_echo('resume:work:occupation:0110'),
'02' => elgg_echo('resume:work:occupation:02'),
'021' => elgg_echo('resume:work:occupation:021'),
'0210' => elgg_echo('resume:work:occupation:0210'),
'03' => elgg_echo('resume:work:occupation:03'),
'031' => elgg_echo('resume:work:occupation:031'),
'0310' => elgg_echo('resume:work:occupation:0310'),
  );

$workdbs = array(
    'any' => elgg_echo('resume:cvranking:any'),
    'CVR_company_entity' => elgg_echo('resume:work:sectortype:general'),  
    'CVR_QS12' => elgg_echo('resume:work:sectortype:QS12'),
    'CVR_SCImago12' => elgg_echo('resume:work:sectortype:SCImago12'),
    'CVR_USNewsH12' => elgg_echo('resume:work:sectortype:USNewsH12'), 
  );

$sectortypes = array(
'any'  => elgg_echo('resume:cvranking:any'),
'A'  => elgg_echo('resume:work:industryclass:A'),
'01'  => elgg_echo('resume:work:industryclass:01'),
'011'  => elgg_echo('resume:work:industryclass:011'),
'0111'  => elgg_echo('resume:work:industryclass:0111'),
'0112'  => elgg_echo('resume:work:industryclass:0112'),
'0113'  => elgg_echo('resume:work:industryclass:0113'),
'0114'  => elgg_echo('resume:work:industryclass:0114'),
'0115'  => elgg_echo('resume:work:industryclass:0115'),
'0116'  => elgg_echo('resume:work:industryclass:0116'),
'0119'  => elgg_echo('resume:work:industryclass:0119'),
'012'  => elgg_echo('resume:work:industryclass:012'),
'0121'  => elgg_echo('resume:work:industryclass:0121'),
'0122'  => elgg_echo('resume:work:industryclass:0122'),
'0123'  => elgg_echo('resume:work:industryclass:0123'),
'0124'  => elgg_echo('resume:work:industryclass:0124'),
'0125'  => elgg_echo('resume:work:industryclass:0125'),
'0126'  => elgg_echo('resume:work:industryclass:0126'),
'0127'  => elgg_echo('resume:work:industryclass:0127'),
'0128'  => elgg_echo('resume:work:industryclass:0128'),
'0129'  => elgg_echo('resume:work:industryclass:0129'),
'013'  => elgg_echo('resume:work:industryclass:013'),
'0130'  => elgg_echo('resume:work:industryclass:0130'),
'014'  => elgg_echo('resume:work:industryclass:014'),
'0141'  => elgg_echo('resume:work:industryclass:0141'),
'0142'  => elgg_echo('resume:work:industryclass:0142'),
'0143'  => elgg_echo('resume:work:industryclass:0143'),
'0144'  => elgg_echo('resume:work:industryclass:0144'),
'0145'  => elgg_echo('resume:work:industryclass:0145'),
'0146'  => elgg_echo('resume:work:industryclass:0146'),
'0149'  => elgg_echo('resume:work:industryclass:0149'),
'015'  => elgg_echo('resume:work:industryclass:015'),
'0150'  => elgg_echo('resume:work:industryclass:0150'),
'016'  => elgg_echo('resume:work:industryclass:016'),
'0161'  => elgg_echo('resume:work:industryclass:0161'),
'0162'  => elgg_echo('resume:work:industryclass:0162'),
'0163'  => elgg_echo('resume:work:industryclass:0163'),
'0164'  => elgg_echo('resume:work:industryclass:0164'),
'017'  => elgg_echo('resume:work:industryclass:017'),
'0170'  => elgg_echo('resume:work:industryclass:0170'),
'02'  => elgg_echo('resume:work:industryclass:02'),
'021'  => elgg_echo('resume:work:industryclass:021'),
'0210'  => elgg_echo('resume:work:industryclass:0210'),
'022'  => elgg_echo('resume:work:industryclass:022'),
'0220'  => elgg_echo('resume:work:industryclass:0220'),
'023'  => elgg_echo('resume:work:industryclass:023'),
'0230'  => elgg_echo('resume:work:industryclass:0230'),
'024'  => elgg_echo('resume:work:industryclass:024'),
'0240'  => elgg_echo('resume:work:industryclass:0240'),
'03'  => elgg_echo('resume:work:industryclass:03'),
'031'  => elgg_echo('resume:work:industryclass:031'),
'0311'  => elgg_echo('resume:work:industryclass:0311'),
'0312'  => elgg_echo('resume:work:industryclass:0312'),
'032'  => elgg_echo('resume:work:industryclass:032'),
'0321'  => elgg_echo('resume:work:industryclass:0321'),
'0322'  => elgg_echo('resume:work:industryclass:0322'),
'B'  => elgg_echo('resume:work:industryclass:B'),
'05'  => elgg_echo('resume:work:industryclass:05'),
'051'  => elgg_echo('resume:work:industryclass:051'),
'0510'  => elgg_echo('resume:work:industryclass:0510'),
'052'  => elgg_echo('resume:work:industryclass:052'),
'0520'  => elgg_echo('resume:work:industryclass:0520'),
'06'  => elgg_echo('resume:work:industryclass:06'),
'061'  => elgg_echo('resume:work:industryclass:061'),
'0610'  => elgg_echo('resume:work:industryclass:0610'),
'062'  => elgg_echo('resume:work:industryclass:062'),
'0620'  => elgg_echo('resume:work:industryclass:0620'),
'07'  => elgg_echo('resume:work:industryclass:07'),
'071'  => elgg_echo('resume:work:industryclass:071'),
'0710'  => elgg_echo('resume:work:industryclass:0710'),
'072'  => elgg_echo('resume:work:industryclass:072'),
'0721'  => elgg_echo('resume:work:industryclass:0721'),
'0729'  => elgg_echo('resume:work:industryclass:0729'),
'08'  => elgg_echo('resume:work:industryclass:08'),
'081'  => elgg_echo('resume:work:industryclass:081'),
'0810'  => elgg_echo('resume:work:industryclass:0810'),
'089'  => elgg_echo('resume:work:industryclass:089'),
'0891'  => elgg_echo('resume:work:industryclass:0891'),
'0892'  => elgg_echo('resume:work:industryclass:0892'),
'0893'  => elgg_echo('resume:work:industryclass:0893'),
'0899'  => elgg_echo('resume:work:industryclass:0899'),
'09'  => elgg_echo('resume:work:industryclass:09'),
'091'  => elgg_echo('resume:work:industryclass:091'),
'0910'  => elgg_echo('resume:work:industryclass:0910'),
'099'  => elgg_echo('resume:work:industryclass:099'),
'0990'  => elgg_echo('resume:work:industryclass:0990'),
'C'  => elgg_echo('resume:work:industryclass:C'),
'10'  => elgg_echo('resume:work:industryclass:10'),
'101'  => elgg_echo('resume:work:industryclass:101'),
'1010'  => elgg_echo('resume:work:industryclass:1010'),
'102'  => elgg_echo('resume:work:industryclass:102'),
'1020'  => elgg_echo('resume:work:industryclass:1020'),
'103'  => elgg_echo('resume:work:industryclass:103'),
'1030'  => elgg_echo('resume:work:industryclass:1030'),
'104'  => elgg_echo('resume:work:industryclass:104'),
'1040'  => elgg_echo('resume:work:industryclass:1040'),
'105'  => elgg_echo('resume:work:industryclass:105'),
'1050'  => elgg_echo('resume:work:industryclass:1050'),
'106'  => elgg_echo('resume:work:industryclass:106'),
'1061'  => elgg_echo('resume:work:industryclass:1061'),
'1062'  => elgg_echo('resume:work:industryclass:1062'),
'107'  => elgg_echo('resume:work:industryclass:107'),
'1071'  => elgg_echo('resume:work:industryclass:1071'),
'1072'  => elgg_echo('resume:work:industryclass:1072'),
'1073'  => elgg_echo('resume:work:industryclass:1073'),
'1074'  => elgg_echo('resume:work:industryclass:1074'),
'1075'  => elgg_echo('resume:work:industryclass:1075'),
'1079'  => elgg_echo('resume:work:industryclass:1079'),
'108'  => elgg_echo('resume:work:industryclass:108'),
'1080'  => elgg_echo('resume:work:industryclass:1080'),
'11'  => elgg_echo('resume:work:industryclass:11'),
'110'  => elgg_echo('resume:work:industryclass:110'),
'1101'  => elgg_echo('resume:work:industryclass:1101'),
'1102'  => elgg_echo('resume:work:industryclass:1102'),
'1103'  => elgg_echo('resume:work:industryclass:1103'),
'1104'  => elgg_echo('resume:work:industryclass:1104'),
'12'  => elgg_echo('resume:work:industryclass:12'),
'120'  => elgg_echo('resume:work:industryclass:120'),
'1200'  => elgg_echo('resume:work:industryclass:1200'),
'13'  => elgg_echo('resume:work:industryclass:13'),
'131'  => elgg_echo('resume:work:industryclass:131'),
'1311'  => elgg_echo('resume:work:industryclass:1311'),
'1312'  => elgg_echo('resume:work:industryclass:1312'),
'1313'  => elgg_echo('resume:work:industryclass:1313'),
'139'  => elgg_echo('resume:work:industryclass:139'),
'1391'  => elgg_echo('resume:work:industryclass:1391'),
'1392'  => elgg_echo('resume:work:industryclass:1392'),
'1393'  => elgg_echo('resume:work:industryclass:1393'),
'1394'  => elgg_echo('resume:work:industryclass:1394'),
'1399'  => elgg_echo('resume:work:industryclass:1399'),
'14'  => elgg_echo('resume:work:industryclass:14'),
'141'  => elgg_echo('resume:work:industryclass:141'),
'1410'  => elgg_echo('resume:work:industryclass:1410'),
'142'  => elgg_echo('resume:work:industryclass:142'),
'1420'  => elgg_echo('resume:work:industryclass:1420'),
'143'  => elgg_echo('resume:work:industryclass:143'),
'1430'  => elgg_echo('resume:work:industryclass:1430'),
'15'  => elgg_echo('resume:work:industryclass:15'),
'151'  => elgg_echo('resume:work:industryclass:151'),
'1511'  => elgg_echo('resume:work:industryclass:1511'),
'1512'  => elgg_echo('resume:work:industryclass:1512'),
'152'  => elgg_echo('resume:work:industryclass:152'),
'1520'  => elgg_echo('resume:work:industryclass:1520'),
'16'  => elgg_echo('resume:work:industryclass:16'),
'161'  => elgg_echo('resume:work:industryclass:161'),
'1610'  => elgg_echo('resume:work:industryclass:1610'),
'162'  => elgg_echo('resume:work:industryclass:162'),
'1621'  => elgg_echo('resume:work:industryclass:1621'),
'1622'  => elgg_echo('resume:work:industryclass:1622'),
'1623'  => elgg_echo('resume:work:industryclass:1623'),
'1629'  => elgg_echo('resume:work:industryclass:1629'),
'17'  => elgg_echo('resume:work:industryclass:17'),
'170'  => elgg_echo('resume:work:industryclass:170'),
'1701'  => elgg_echo('resume:work:industryclass:1701'),
'1702'  => elgg_echo('resume:work:industryclass:1702'),
'1709'  => elgg_echo('resume:work:industryclass:1709'),
'18'  => elgg_echo('resume:work:industryclass:18'),
'181'  => elgg_echo('resume:work:industryclass:181'),
'1811'  => elgg_echo('resume:work:industryclass:1811'),
'1812'  => elgg_echo('resume:work:industryclass:1812'),
'182'  => elgg_echo('resume:work:industryclass:182'),
'1820'  => elgg_echo('resume:work:industryclass:1820'),
'19'  => elgg_echo('resume:work:industryclass:19'),
'191'  => elgg_echo('resume:work:industryclass:191'),
'1910'  => elgg_echo('resume:work:industryclass:1910'),
'192'  => elgg_echo('resume:work:industryclass:192'),
'1920'  => elgg_echo('resume:work:industryclass:1920'),
'20'  => elgg_echo('resume:work:industryclass:20'),
'201'  => elgg_echo('resume:work:industryclass:201'),
'2011'  => elgg_echo('resume:work:industryclass:2011'),
'2012'  => elgg_echo('resume:work:industryclass:2012'),
'2013'  => elgg_echo('resume:work:industryclass:2013'),
'202'  => elgg_echo('resume:work:industryclass:202'),
'2021'  => elgg_echo('resume:work:industryclass:2021'),
'2022'  => elgg_echo('resume:work:industryclass:2022'),
'2023'  => elgg_echo('resume:work:industryclass:2023'),
'2029'  => elgg_echo('resume:work:industryclass:2029'),
'203'  => elgg_echo('resume:work:industryclass:203'),
'2030'  => elgg_echo('resume:work:industryclass:2030'),
'21'  => elgg_echo('resume:work:industryclass:21'),
'210'  => elgg_echo('resume:work:industryclass:210'),
'2100'  => elgg_echo('resume:work:industryclass:2100'),
'22'  => elgg_echo('resume:work:industryclass:22'),
'221'  => elgg_echo('resume:work:industryclass:221'),
'2211'  => elgg_echo('resume:work:industryclass:2211'),
'2219'  => elgg_echo('resume:work:industryclass:2219'),
'222'  => elgg_echo('resume:work:industryclass:222'),
'2220'  => elgg_echo('resume:work:industryclass:2220'),
'23'  => elgg_echo('resume:work:industryclass:23'),
'231'  => elgg_echo('resume:work:industryclass:231'),
'2310'  => elgg_echo('resume:work:industryclass:2310'),
'239'  => elgg_echo('resume:work:industryclass:239'),
'2391'  => elgg_echo('resume:work:industryclass:2391'),
'2392'  => elgg_echo('resume:work:industryclass:2392'),
'2393'  => elgg_echo('resume:work:industryclass:2393'),
'2394'  => elgg_echo('resume:work:industryclass:2394'),
'2395'  => elgg_echo('resume:work:industryclass:2395'),
'2396'  => elgg_echo('resume:work:industryclass:2396'),
'2399'  => elgg_echo('resume:work:industryclass:2399'),
'24'  => elgg_echo('resume:work:industryclass:24'),
'241'  => elgg_echo('resume:work:industryclass:241'),
'2410'  => elgg_echo('resume:work:industryclass:2410'),
'242'  => elgg_echo('resume:work:industryclass:242'),
'2420'  => elgg_echo('resume:work:industryclass:2420'),
'243'  => elgg_echo('resume:work:industryclass:243'),
'2431'  => elgg_echo('resume:work:industryclass:2431'),
'2432'  => elgg_echo('resume:work:industryclass:2432'),
'25'  => elgg_echo('resume:work:industryclass:25'),
'251'  => elgg_echo('resume:work:industryclass:251'),
'2511'  => elgg_echo('resume:work:industryclass:2511'),
'2512'  => elgg_echo('resume:work:industryclass:2512'),
'2513'  => elgg_echo('resume:work:industryclass:2513'),
'252'  => elgg_echo('resume:work:industryclass:252'),
'2520'  => elgg_echo('resume:work:industryclass:2520'),
'259'  => elgg_echo('resume:work:industryclass:259'),
'2591'  => elgg_echo('resume:work:industryclass:2591'),
'2592'  => elgg_echo('resume:work:industryclass:2592'),
'2593'  => elgg_echo('resume:work:industryclass:2593'),
'2599'  => elgg_echo('resume:work:industryclass:2599'),
'26'  => elgg_echo('resume:work:industryclass:26'),
'261'  => elgg_echo('resume:work:industryclass:261'),
'2610'  => elgg_echo('resume:work:industryclass:2610'),
'262'  => elgg_echo('resume:work:industryclass:262'),
'2620'  => elgg_echo('resume:work:industryclass:2620'),
'263'  => elgg_echo('resume:work:industryclass:263'),
'2630'  => elgg_echo('resume:work:industryclass:2630'),
'264'  => elgg_echo('resume:work:industryclass:264'),
'2640'  => elgg_echo('resume:work:industryclass:2640'),
'265'  => elgg_echo('resume:work:industryclass:265'),
'2651'  => elgg_echo('resume:work:industryclass:2651'),
'2652'  => elgg_echo('resume:work:industryclass:2652'),
'266'  => elgg_echo('resume:work:industryclass:266'),
'2660'  => elgg_echo('resume:work:industryclass:2660'),
'267'  => elgg_echo('resume:work:industryclass:267'),
'2670'  => elgg_echo('resume:work:industryclass:2670'),
'268'  => elgg_echo('resume:work:industryclass:268'),
'2680'  => elgg_echo('resume:work:industryclass:2680'),
'27'  => elgg_echo('resume:work:industryclass:27'),
'271'  => elgg_echo('resume:work:industryclass:271'),
'2710'  => elgg_echo('resume:work:industryclass:2710'),
'272'  => elgg_echo('resume:work:industryclass:272'),
'2720'  => elgg_echo('resume:work:industryclass:2720'),
'273'  => elgg_echo('resume:work:industryclass:273'),
'2731'  => elgg_echo('resume:work:industryclass:2731'),
'2732'  => elgg_echo('resume:work:industryclass:2732'),
'2733'  => elgg_echo('resume:work:industryclass:2733'),
'274'  => elgg_echo('resume:work:industryclass:274'),
'2740'  => elgg_echo('resume:work:industryclass:2740'),
'275'  => elgg_echo('resume:work:industryclass:275'),
'2750'  => elgg_echo('resume:work:industryclass:2750'),
'279'  => elgg_echo('resume:work:industryclass:279'),
'2790'  => elgg_echo('resume:work:industryclass:2790'),
'28'  => elgg_echo('resume:work:industryclass:28'),
'281'  => elgg_echo('resume:work:industryclass:281'),
'2811'  => elgg_echo('resume:work:industryclass:2811'),
'2812'  => elgg_echo('resume:work:industryclass:2812'),
'2813'  => elgg_echo('resume:work:industryclass:2813'),
'2814'  => elgg_echo('resume:work:industryclass:2814'),
'2815'  => elgg_echo('resume:work:industryclass:2815'),
'2816'  => elgg_echo('resume:work:industryclass:2816'),
'2817'  => elgg_echo('resume:work:industryclass:2817'),
'2818'  => elgg_echo('resume:work:industryclass:2818'),
'2819'  => elgg_echo('resume:work:industryclass:2819'),
'282'  => elgg_echo('resume:work:industryclass:282'),
'2821'  => elgg_echo('resume:work:industryclass:2821'),
'2822'  => elgg_echo('resume:work:industryclass:2822'),
'2823'  => elgg_echo('resume:work:industryclass:2823'),
'2824'  => elgg_echo('resume:work:industryclass:2824'),
'2825'  => elgg_echo('resume:work:industryclass:2825'),
'2826'  => elgg_echo('resume:work:industryclass:2826'),
'2829'  => elgg_echo('resume:work:industryclass:2829'),
'29'  => elgg_echo('resume:work:industryclass:29'),
'291'  => elgg_echo('resume:work:industryclass:291'),
'2910'  => elgg_echo('resume:work:industryclass:2910'),
'292'  => elgg_echo('resume:work:industryclass:292'),
'2920'  => elgg_echo('resume:work:industryclass:2920'),
'293'  => elgg_echo('resume:work:industryclass:293'),
'2930'  => elgg_echo('resume:work:industryclass:2930'),
'30'  => elgg_echo('resume:work:industryclass:30'),
'301'  => elgg_echo('resume:work:industryclass:301'),
'3011'  => elgg_echo('resume:work:industryclass:3011'),
'3012'  => elgg_echo('resume:work:industryclass:3012'),
'302'  => elgg_echo('resume:work:industryclass:302'),
'3020'  => elgg_echo('resume:work:industryclass:3020'),
'303'  => elgg_echo('resume:work:industryclass:303'),
'3030'  => elgg_echo('resume:work:industryclass:3030'),
'304'  => elgg_echo('resume:work:industryclass:304'),
'3040'  => elgg_echo('resume:work:industryclass:3040'),
'309'  => elgg_echo('resume:work:industryclass:309'),
'3091'  => elgg_echo('resume:work:industryclass:3091'),
'3092'  => elgg_echo('resume:work:industryclass:3092'),
'3099'  => elgg_echo('resume:work:industryclass:3099'),
'31'  => elgg_echo('resume:work:industryclass:31'),
'310'  => elgg_echo('resume:work:industryclass:310'),
'3100'  => elgg_echo('resume:work:industryclass:3100'),
'32'  => elgg_echo('resume:work:industryclass:32'),
'321'  => elgg_echo('resume:work:industryclass:321'),
'3211'  => elgg_echo('resume:work:industryclass:3211'),
'3212'  => elgg_echo('resume:work:industryclass:3212'),
'322'  => elgg_echo('resume:work:industryclass:322'),
'3220'  => elgg_echo('resume:work:industryclass:3220'),
'323'  => elgg_echo('resume:work:industryclass:323'),
'3230'  => elgg_echo('resume:work:industryclass:3230'),
'324'  => elgg_echo('resume:work:industryclass:324'),
'3240'  => elgg_echo('resume:work:industryclass:3240'),
'325'  => elgg_echo('resume:work:industryclass:325'),
'3250'  => elgg_echo('resume:work:industryclass:3250'),
'329'  => elgg_echo('resume:work:industryclass:329'),
'3290'  => elgg_echo('resume:work:industryclass:3290'),
'33'  => elgg_echo('resume:work:industryclass:33'),
'331'  => elgg_echo('resume:work:industryclass:331'),
'3311'  => elgg_echo('resume:work:industryclass:3311'),
'3312'  => elgg_echo('resume:work:industryclass:3312'),
'3313'  => elgg_echo('resume:work:industryclass:3313'),
'3314'  => elgg_echo('resume:work:industryclass:3314'),
'3315'  => elgg_echo('resume:work:industryclass:3315'),
'3319'  => elgg_echo('resume:work:industryclass:3319'),
'332'  => elgg_echo('resume:work:industryclass:332'),
'3320'  => elgg_echo('resume:work:industryclass:3320'),
'D'  => elgg_echo('resume:work:industryclass:D'),
'35'  => elgg_echo('resume:work:industryclass:35'),
'351'  => elgg_echo('resume:work:industryclass:351'),
'3510'  => elgg_echo('resume:work:industryclass:3510'),
'352'  => elgg_echo('resume:work:industryclass:352'),
'3520'  => elgg_echo('resume:work:industryclass:3520'),
'353'  => elgg_echo('resume:work:industryclass:353'),
'3530'  => elgg_echo('resume:work:industryclass:3530'),
'E'  => elgg_echo('resume:work:industryclass:E'),
'36'  => elgg_echo('resume:work:industryclass:36'),
'360'  => elgg_echo('resume:work:industryclass:360'),
'3600'  => elgg_echo('resume:work:industryclass:3600'),
'37'  => elgg_echo('resume:work:industryclass:37'),
'370'  => elgg_echo('resume:work:industryclass:370'),
'3700'  => elgg_echo('resume:work:industryclass:3700'),
'38'  => elgg_echo('resume:work:industryclass:38'),
'381'  => elgg_echo('resume:work:industryclass:381'),
'3811'  => elgg_echo('resume:work:industryclass:3811'),
'3812'  => elgg_echo('resume:work:industryclass:3812'),
'382'  => elgg_echo('resume:work:industryclass:382'),
'3821'  => elgg_echo('resume:work:industryclass:3821'),
'3822'  => elgg_echo('resume:work:industryclass:3822'),
'383'  => elgg_echo('resume:work:industryclass:383'),
'3830'  => elgg_echo('resume:work:industryclass:3830'),
'39'  => elgg_echo('resume:work:industryclass:39'),
'390'  => elgg_echo('resume:work:industryclass:390'),
'3900'  => elgg_echo('resume:work:industryclass:3900'),
'F'  => elgg_echo('resume:work:industryclass:F'),
'41'  => elgg_echo('resume:work:industryclass:41'),
'410'  => elgg_echo('resume:work:industryclass:410'),
'4100'  => elgg_echo('resume:work:industryclass:4100'),
'42'  => elgg_echo('resume:work:industryclass:42'),
'421'  => elgg_echo('resume:work:industryclass:421'),
'4210'  => elgg_echo('resume:work:industryclass:4210'),
'422'  => elgg_echo('resume:work:industryclass:422'),
'4220'  => elgg_echo('resume:work:industryclass:4220'),
'429'  => elgg_echo('resume:work:industryclass:429'),
'4290'  => elgg_echo('resume:work:industryclass:4290'),
'43'  => elgg_echo('resume:work:industryclass:43'),
'431'  => elgg_echo('resume:work:industryclass:431'),
'4311'  => elgg_echo('resume:work:industryclass:4311'),
'4312'  => elgg_echo('resume:work:industryclass:4312'),
'432'  => elgg_echo('resume:work:industryclass:432'),
'4321'  => elgg_echo('resume:work:industryclass:4321'),
'4322'  => elgg_echo('resume:work:industryclass:4322'),
'4329'  => elgg_echo('resume:work:industryclass:4329'),
'433'  => elgg_echo('resume:work:industryclass:433'),
'4330'  => elgg_echo('resume:work:industryclass:4330'),
'439'  => elgg_echo('resume:work:industryclass:439'),
'4390'  => elgg_echo('resume:work:industryclass:4390'),
'G'  => elgg_echo('resume:work:industryclass:G'),
'45'  => elgg_echo('resume:work:industryclass:45'),
'451'  => elgg_echo('resume:work:industryclass:451'),
'4510'  => elgg_echo('resume:work:industryclass:4510'),
'452'  => elgg_echo('resume:work:industryclass:452'),
'4520'  => elgg_echo('resume:work:industryclass:4520'),
'453'  => elgg_echo('resume:work:industryclass:453'),
'4530'  => elgg_echo('resume:work:industryclass:4530'),
'454'  => elgg_echo('resume:work:industryclass:454'),
'4540'  => elgg_echo('resume:work:industryclass:4540'),
'46'  => elgg_echo('resume:work:industryclass:46'),
'461'  => elgg_echo('resume:work:industryclass:461'),
'4610'  => elgg_echo('resume:work:industryclass:4610'),
'462'  => elgg_echo('resume:work:industryclass:462'),
'4620'  => elgg_echo('resume:work:industryclass:4620'),
'463'  => elgg_echo('resume:work:industryclass:463'),
'4630'  => elgg_echo('resume:work:industryclass:4630'),
'464'  => elgg_echo('resume:work:industryclass:464'),
'4641'  => elgg_echo('resume:work:industryclass:4641'),
'4649'  => elgg_echo('resume:work:industryclass:4649'),
'465'  => elgg_echo('resume:work:industryclass:465'),
'4651'  => elgg_echo('resume:work:industryclass:4651'),
'4652'  => elgg_echo('resume:work:industryclass:4652'),
'4653'  => elgg_echo('resume:work:industryclass:4653'),
'4659'  => elgg_echo('resume:work:industryclass:4659'),
'466'  => elgg_echo('resume:work:industryclass:466'),
'4661'  => elgg_echo('resume:work:industryclass:4661'),
'4662'  => elgg_echo('resume:work:industryclass:4662'),
'4663'  => elgg_echo('resume:work:industryclass:4663'),
'4669'  => elgg_echo('resume:work:industryclass:4669'),
'469'  => elgg_echo('resume:work:industryclass:469'),
'4690'  => elgg_echo('resume:work:industryclass:4690'),
'47'  => elgg_echo('resume:work:industryclass:47'),
'471'  => elgg_echo('resume:work:industryclass:471'),
'4711'  => elgg_echo('resume:work:industryclass:4711'),
'4719'  => elgg_echo('resume:work:industryclass:4719'),
'472'  => elgg_echo('resume:work:industryclass:472'),
'4721'  => elgg_echo('resume:work:industryclass:4721'),
'4722'  => elgg_echo('resume:work:industryclass:4722'),
'4723'  => elgg_echo('resume:work:industryclass:4723'),
'473'  => elgg_echo('resume:work:industryclass:473'),
'4730'  => elgg_echo('resume:work:industryclass:4730'),
'474'  => elgg_echo('resume:work:industryclass:474'),
'4741'  => elgg_echo('resume:work:industryclass:4741'),
'4742'  => elgg_echo('resume:work:industryclass:4742'),
'475'  => elgg_echo('resume:work:industryclass:475'),
'4751'  => elgg_echo('resume:work:industryclass:4751'),
'4752'  => elgg_echo('resume:work:industryclass:4752'),
'4753'  => elgg_echo('resume:work:industryclass:4753'),
'4759'  => elgg_echo('resume:work:industryclass:4759'),
'476'  => elgg_echo('resume:work:industryclass:476'),
'4761'  => elgg_echo('resume:work:industryclass:4761'),
'4762'  => elgg_echo('resume:work:industryclass:4762'),
'4763'  => elgg_echo('resume:work:industryclass:4763'),
'4764'  => elgg_echo('resume:work:industryclass:4764'),
'477'  => elgg_echo('resume:work:industryclass:477'),
'4771'  => elgg_echo('resume:work:industryclass:4771'),
'4772'  => elgg_echo('resume:work:industryclass:4772'),
'4773'  => elgg_echo('resume:work:industryclass:4773'),
'4774'  => elgg_echo('resume:work:industryclass:4774'),
'478'  => elgg_echo('resume:work:industryclass:478'),
'4781'  => elgg_echo('resume:work:industryclass:4781'),
'4782'  => elgg_echo('resume:work:industryclass:4782'),
'4789'  => elgg_echo('resume:work:industryclass:4789'),
'479'  => elgg_echo('resume:work:industryclass:479'),
'4791'  => elgg_echo('resume:work:industryclass:4791'),
'4799'  => elgg_echo('resume:work:industryclass:4799'),
'H'  => elgg_echo('resume:work:industryclass:H'),
'49'  => elgg_echo('resume:work:industryclass:49'),
'491'  => elgg_echo('resume:work:industryclass:491'),
'4911'  => elgg_echo('resume:work:industryclass:4911'),
'4912'  => elgg_echo('resume:work:industryclass:4912'),
'492'  => elgg_echo('resume:work:industryclass:492'),
'4921'  => elgg_echo('resume:work:industryclass:4921'),
'4922'  => elgg_echo('resume:work:industryclass:4922'),
'4923'  => elgg_echo('resume:work:industryclass:4923'),
'493'  => elgg_echo('resume:work:industryclass:493'),
'4930'  => elgg_echo('resume:work:industryclass:4930'),
'50'  => elgg_echo('resume:work:industryclass:50'),
'501'  => elgg_echo('resume:work:industryclass:501'),
'5011'  => elgg_echo('resume:work:industryclass:5011'),
'5012'  => elgg_echo('resume:work:industryclass:5012'),
'502'  => elgg_echo('resume:work:industryclass:502'),
'5021'  => elgg_echo('resume:work:industryclass:5021'),
'5022'  => elgg_echo('resume:work:industryclass:5022'),
'51'  => elgg_echo('resume:work:industryclass:51'),
'511'  => elgg_echo('resume:work:industryclass:511'),
'5110'  => elgg_echo('resume:work:industryclass:5110'),
'512'  => elgg_echo('resume:work:industryclass:512'),
'5120'  => elgg_echo('resume:work:industryclass:5120'),
'52'  => elgg_echo('resume:work:industryclass:52'),
'521'  => elgg_echo('resume:work:industryclass:521'),
'5210'  => elgg_echo('resume:work:industryclass:5210'),
'522'  => elgg_echo('resume:work:industryclass:522'),
'5221'  => elgg_echo('resume:work:industryclass:5221'),
'5222'  => elgg_echo('resume:work:industryclass:5222'),
'5223'  => elgg_echo('resume:work:industryclass:5223'),
'5224'  => elgg_echo('resume:work:industryclass:5224'),
'5229'  => elgg_echo('resume:work:industryclass:5229'),
'53'  => elgg_echo('resume:work:industryclass:53'),
'531'  => elgg_echo('resume:work:industryclass:531'),
'5310'  => elgg_echo('resume:work:industryclass:5310'),
'532'  => elgg_echo('resume:work:industryclass:532'),
'5320'  => elgg_echo('resume:work:industryclass:5320'),
'I'  => elgg_echo('resume:work:industryclass:I'),
'55'  => elgg_echo('resume:work:industryclass:55'),
'551'  => elgg_echo('resume:work:industryclass:551'),
'5510'  => elgg_echo('resume:work:industryclass:5510'),
'552'  => elgg_echo('resume:work:industryclass:552'),
'5520'  => elgg_echo('resume:work:industryclass:5520'),
'559'  => elgg_echo('resume:work:industryclass:559'),
'5590'  => elgg_echo('resume:work:industryclass:5590'),
'56'  => elgg_echo('resume:work:industryclass:56'),
'561'  => elgg_echo('resume:work:industryclass:561'),
'5610'  => elgg_echo('resume:work:industryclass:5610'),
'562'  => elgg_echo('resume:work:industryclass:562'),
'5621'  => elgg_echo('resume:work:industryclass:5621'),
'5629'  => elgg_echo('resume:work:industryclass:5629'),
'563'  => elgg_echo('resume:work:industryclass:563'),
'5630'  => elgg_echo('resume:work:industryclass:5630'),
'J'  => elgg_echo('resume:work:industryclass:J'),
'58'  => elgg_echo('resume:work:industryclass:58'),
'581'  => elgg_echo('resume:work:industryclass:581'),
'5811'  => elgg_echo('resume:work:industryclass:5811'),
'5812'  => elgg_echo('resume:work:industryclass:5812'),
'5813'  => elgg_echo('resume:work:industryclass:5813'),
'5819'  => elgg_echo('resume:work:industryclass:5819'),
'582'  => elgg_echo('resume:work:industryclass:582'),
'5820'  => elgg_echo('resume:work:industryclass:5820'),
'59'  => elgg_echo('resume:work:industryclass:59'),
'591'  => elgg_echo('resume:work:industryclass:591'),
'5911'  => elgg_echo('resume:work:industryclass:5911'),
'5912'  => elgg_echo('resume:work:industryclass:5912'),
'5913'  => elgg_echo('resume:work:industryclass:5913'),
'5914'  => elgg_echo('resume:work:industryclass:5914'),
'592'  => elgg_echo('resume:work:industryclass:592'),
'5920'  => elgg_echo('resume:work:industryclass:5920'),
'60'  => elgg_echo('resume:work:industryclass:60'),
'601'  => elgg_echo('resume:work:industryclass:601'),
'6010'  => elgg_echo('resume:work:industryclass:6010'),
'602'  => elgg_echo('resume:work:industryclass:602'),
'6020'  => elgg_echo('resume:work:industryclass:6020'),
'61'  => elgg_echo('resume:work:industryclass:61'),
'611'  => elgg_echo('resume:work:industryclass:611'),
'6110'  => elgg_echo('resume:work:industryclass:6110'),
'612'  => elgg_echo('resume:work:industryclass:612'),
'6120'  => elgg_echo('resume:work:industryclass:6120'),
'613'  => elgg_echo('resume:work:industryclass:613'),
'6130'  => elgg_echo('resume:work:industryclass:6130'),
'619'  => elgg_echo('resume:work:industryclass:619'),
'6190'  => elgg_echo('resume:work:industryclass:6190'),
'62'  => elgg_echo('resume:work:industryclass:62'),
'620'  => elgg_echo('resume:work:industryclass:620'),
'6201'  => elgg_echo('resume:work:industryclass:6201'),
'6202'  => elgg_echo('resume:work:industryclass:6202'),
'6209'  => elgg_echo('resume:work:industryclass:6209'),
'63'  => elgg_echo('resume:work:industryclass:63'),
'631'  => elgg_echo('resume:work:industryclass:631'),
'6311'  => elgg_echo('resume:work:industryclass:6311'),
'6312'  => elgg_echo('resume:work:industryclass:6312'),
'639'  => elgg_echo('resume:work:industryclass:639'),
'6391'  => elgg_echo('resume:work:industryclass:6391'),
'6399'  => elgg_echo('resume:work:industryclass:6399'),
'K'  => elgg_echo('resume:work:industryclass:K'),
'64'  => elgg_echo('resume:work:industryclass:64'),
'641'  => elgg_echo('resume:work:industryclass:641'),
'6411'  => elgg_echo('resume:work:industryclass:6411'),
'6419'  => elgg_echo('resume:work:industryclass:6419'),
'642'  => elgg_echo('resume:work:industryclass:642'),
'6420'  => elgg_echo('resume:work:industryclass:6420'),
'643'  => elgg_echo('resume:work:industryclass:643'),
'6430'  => elgg_echo('resume:work:industryclass:6430'),
'649'  => elgg_echo('resume:work:industryclass:649'),
'6491'  => elgg_echo('resume:work:industryclass:6491'),
'6492'  => elgg_echo('resume:work:industryclass:6492'),
'6499'  => elgg_echo('resume:work:industryclass:6499'),
'65'  => elgg_echo('resume:work:industryclass:65'),
'651'  => elgg_echo('resume:work:industryclass:651'),
'6511'  => elgg_echo('resume:work:industryclass:6511'),
'6512'  => elgg_echo('resume:work:industryclass:6512'),
'652'  => elgg_echo('resume:work:industryclass:652'),
'6520'  => elgg_echo('resume:work:industryclass:6520'),
'653'  => elgg_echo('resume:work:industryclass:653'),
'6530'  => elgg_echo('resume:work:industryclass:6530'),
'66'  => elgg_echo('resume:work:industryclass:66'),
'661'  => elgg_echo('resume:work:industryclass:661'),
'6611'  => elgg_echo('resume:work:industryclass:6611'),
'6612'  => elgg_echo('resume:work:industryclass:6612'),
'6619'  => elgg_echo('resume:work:industryclass:6619'),
'662'  => elgg_echo('resume:work:industryclass:662'),
'6621'  => elgg_echo('resume:work:industryclass:6621'),
'6622'  => elgg_echo('resume:work:industryclass:6622'),
'6629'  => elgg_echo('resume:work:industryclass:6629'),
'663'  => elgg_echo('resume:work:industryclass:663'),
'6630'  => elgg_echo('resume:work:industryclass:6630'),
'L'  => elgg_echo('resume:work:industryclass:L'),
'68'  => elgg_echo('resume:work:industryclass:68'),
'681'  => elgg_echo('resume:work:industryclass:681'),
'6810'  => elgg_echo('resume:work:industryclass:6810'),
'682'  => elgg_echo('resume:work:industryclass:682'),
'6820'  => elgg_echo('resume:work:industryclass:6820'),
'M'  => elgg_echo('resume:work:industryclass:M'),
'69'  => elgg_echo('resume:work:industryclass:69'),
'691'  => elgg_echo('resume:work:industryclass:691'),
'6910'  => elgg_echo('resume:work:industryclass:6910'),
'692'  => elgg_echo('resume:work:industryclass:692'),
'6920'  => elgg_echo('resume:work:industryclass:6920'),
'70'  => elgg_echo('resume:work:industryclass:70'),
'701'  => elgg_echo('resume:work:industryclass:701'),
'7010'  => elgg_echo('resume:work:industryclass:7010'),
'702'  => elgg_echo('resume:work:industryclass:702'),
'7020'  => elgg_echo('resume:work:industryclass:7020'),
'71'  => elgg_echo('resume:work:industryclass:71'),
'711'  => elgg_echo('resume:work:industryclass:711'),
'7110'  => elgg_echo('resume:work:industryclass:7110'),
'712'  => elgg_echo('resume:work:industryclass:712'),
'7120'  => elgg_echo('resume:work:industryclass:7120'),
'72'  => elgg_echo('resume:work:industryclass:72'),
'721'  => elgg_echo('resume:work:industryclass:721'),
'7210'  => elgg_echo('resume:work:industryclass:7210'),
'722'  => elgg_echo('resume:work:industryclass:722'),
'7220'  => elgg_echo('resume:work:industryclass:7220'),
'73'  => elgg_echo('resume:work:industryclass:73'),
'731'  => elgg_echo('resume:work:industryclass:731'),
'7310'  => elgg_echo('resume:work:industryclass:7310'),
'732'  => elgg_echo('resume:work:industryclass:732'),
'7320'  => elgg_echo('resume:work:industryclass:7320'),
'74'  => elgg_echo('resume:work:industryclass:74'),
'741'  => elgg_echo('resume:work:industryclass:741'),
'7410'  => elgg_echo('resume:work:industryclass:7410'),
'742'  => elgg_echo('resume:work:industryclass:742'),
'7420'  => elgg_echo('resume:work:industryclass:7420'),
'749'  => elgg_echo('resume:work:industryclass:749'),
'7490'  => elgg_echo('resume:work:industryclass:7490'),
'75'  => elgg_echo('resume:work:industryclass:75'),
'750'  => elgg_echo('resume:work:industryclass:750'),
'7500'  => elgg_echo('resume:work:industryclass:7500'),
'N'  => elgg_echo('resume:work:industryclass:N'),
'77'  => elgg_echo('resume:work:industryclass:77'),
'771'  => elgg_echo('resume:work:industryclass:771'),
'7710'  => elgg_echo('resume:work:industryclass:7710'),
'772'  => elgg_echo('resume:work:industryclass:772'),
'7721'  => elgg_echo('resume:work:industryclass:7721'),
'7722'  => elgg_echo('resume:work:industryclass:7722'),
'7729'  => elgg_echo('resume:work:industryclass:7729'),
'773'  => elgg_echo('resume:work:industryclass:773'),
'7730'  => elgg_echo('resume:work:industryclass:7730'),
'774'  => elgg_echo('resume:work:industryclass:774'),
'7740'  => elgg_echo('resume:work:industryclass:7740'),
'78'  => elgg_echo('resume:work:industryclass:78'),
'781'  => elgg_echo('resume:work:industryclass:781'),
'7810'  => elgg_echo('resume:work:industryclass:7810'),
'782'  => elgg_echo('resume:work:industryclass:782'),
'7820'  => elgg_echo('resume:work:industryclass:7820'),
'783'  => elgg_echo('resume:work:industryclass:783'),
'7830'  => elgg_echo('resume:work:industryclass:7830'),
'79'  => elgg_echo('resume:work:industryclass:79'),
'791'  => elgg_echo('resume:work:industryclass:791'),
'7911'  => elgg_echo('resume:work:industryclass:7911'),
'7912'  => elgg_echo('resume:work:industryclass:7912'),
'799'  => elgg_echo('resume:work:industryclass:799'),
'7990'  => elgg_echo('resume:work:industryclass:7990'),
'80'  => elgg_echo('resume:work:industryclass:80'),
'801'  => elgg_echo('resume:work:industryclass:801'),
'8010'  => elgg_echo('resume:work:industryclass:8010'),
'802'  => elgg_echo('resume:work:industryclass:802'),
'8020'  => elgg_echo('resume:work:industryclass:8020'),
'803'  => elgg_echo('resume:work:industryclass:803'),
'8030'  => elgg_echo('resume:work:industryclass:8030'),
'81'  => elgg_echo('resume:work:industryclass:81'),
'811'  => elgg_echo('resume:work:industryclass:811'),
'8110'  => elgg_echo('resume:work:industryclass:8110'),
'812'  => elgg_echo('resume:work:industryclass:812'),
'8121'  => elgg_echo('resume:work:industryclass:8121'),
'8129'  => elgg_echo('resume:work:industryclass:8129'),
'813'  => elgg_echo('resume:work:industryclass:813'),
'8130'  => elgg_echo('resume:work:industryclass:8130'),
'82'  => elgg_echo('resume:work:industryclass:82'),
'821'  => elgg_echo('resume:work:industryclass:821'),
'8211'  => elgg_echo('resume:work:industryclass:8211'),
'8219'  => elgg_echo('resume:work:industryclass:8219'),
'822'  => elgg_echo('resume:work:industryclass:822'),
'8220'  => elgg_echo('resume:work:industryclass:8220'),
'823'  => elgg_echo('resume:work:industryclass:823'),
'8230'  => elgg_echo('resume:work:industryclass:8230'),
'829'  => elgg_echo('resume:work:industryclass:829'),
'8291'  => elgg_echo('resume:work:industryclass:8291'),
'8292'  => elgg_echo('resume:work:industryclass:8292'),
'8299'  => elgg_echo('resume:work:industryclass:8299'),
'O'  => elgg_echo('resume:work:industryclass:O'),
'84'  => elgg_echo('resume:work:industryclass:84'),
'841'  => elgg_echo('resume:work:industryclass:841'),
'8411'  => elgg_echo('resume:work:industryclass:8411'),
'8412'  => elgg_echo('resume:work:industryclass:8412'),
'8413'  => elgg_echo('resume:work:industryclass:8413'),
'842'  => elgg_echo('resume:work:industryclass:842'),
'8421'  => elgg_echo('resume:work:industryclass:8421'),
'8422'  => elgg_echo('resume:work:industryclass:8422'),
'8423'  => elgg_echo('resume:work:industryclass:8423'),
'843'  => elgg_echo('resume:work:industryclass:843'),
'8430'  => elgg_echo('resume:work:industryclass:8430'),
'P'  => elgg_echo('resume:work:industryclass:P'),
'85'  => elgg_echo('resume:work:industryclass:85'),
'851'  => elgg_echo('resume:work:industryclass:851'),
'8510'  => elgg_echo('resume:work:industryclass:8510'),
'852'  => elgg_echo('resume:work:industryclass:852'),
'8521'  => elgg_echo('resume:work:industryclass:8521'),
'8522'  => elgg_echo('resume:work:industryclass:8522'),
'853'  => elgg_echo('resume:work:industryclass:853'),
'8530'  => elgg_echo('resume:work:industryclass:8530'),
'854'  => elgg_echo('resume:work:industryclass:854'),
'8541'  => elgg_echo('resume:work:industryclass:8541'),
'8542'  => elgg_echo('resume:work:industryclass:8542'),
'8549'  => elgg_echo('resume:work:industryclass:8549'),
'855'  => elgg_echo('resume:work:industryclass:855'),
'8550'  => elgg_echo('resume:work:industryclass:8550'),
'Q'  => elgg_echo('resume:work:industryclass:Q'),
'86'  => elgg_echo('resume:work:industryclass:86'),
'861'  => elgg_echo('resume:work:industryclass:861'),
'8610'  => elgg_echo('resume:work:industryclass:8610'),
'862'  => elgg_echo('resume:work:industryclass:862'),
'8620'  => elgg_echo('resume:work:industryclass:8620'),
'869'  => elgg_echo('resume:work:industryclass:869'),
'8690'  => elgg_echo('resume:work:industryclass:8690'),
'87'  => elgg_echo('resume:work:industryclass:87'),
'871'  => elgg_echo('resume:work:industryclass:871'),
'8710'  => elgg_echo('resume:work:industryclass:8710'),
'872'  => elgg_echo('resume:work:industryclass:872'),
'8720'  => elgg_echo('resume:work:industryclass:8720'),
'873'  => elgg_echo('resume:work:industryclass:873'),
'8730'  => elgg_echo('resume:work:industryclass:8730'),
'879'  => elgg_echo('resume:work:industryclass:879'),
'8790'  => elgg_echo('resume:work:industryclass:8790'),
'88'  => elgg_echo('resume:work:industryclass:88'),
'881'  => elgg_echo('resume:work:industryclass:881'),
'8810'  => elgg_echo('resume:work:industryclass:8810'),
'889'  => elgg_echo('resume:work:industryclass:889'),
'8890'  => elgg_echo('resume:work:industryclass:8890'),
'R'  => elgg_echo('resume:work:industryclass:R'),
'90'  => elgg_echo('resume:work:industryclass:90'),
'900'  => elgg_echo('resume:work:industryclass:900'),
'9000'  => elgg_echo('resume:work:industryclass:9000'),
'91'  => elgg_echo('resume:work:industryclass:91'),
'910'  => elgg_echo('resume:work:industryclass:910'),
'9101'  => elgg_echo('resume:work:industryclass:9101'),
'9102'  => elgg_echo('resume:work:industryclass:9102'),
'9103'  => elgg_echo('resume:work:industryclass:9103'),
'92'  => elgg_echo('resume:work:industryclass:92'),
'920'  => elgg_echo('resume:work:industryclass:920'),
'9200'  => elgg_echo('resume:work:industryclass:9200'),
'93'  => elgg_echo('resume:work:industryclass:93'),
'931'  => elgg_echo('resume:work:industryclass:931'),
'9311'  => elgg_echo('resume:work:industryclass:9311'),
'9312'  => elgg_echo('resume:work:industryclass:9312'),
'9319'  => elgg_echo('resume:work:industryclass:9319'),
'932'  => elgg_echo('resume:work:industryclass:932'),
'9321'  => elgg_echo('resume:work:industryclass:9321'),
'9329'  => elgg_echo('resume:work:industryclass:9329'),
'S'  => elgg_echo('resume:work:industryclass:S'),
'94'  => elgg_echo('resume:work:industryclass:94'),
'941'  => elgg_echo('resume:work:industryclass:941'),
'9411'  => elgg_echo('resume:work:industryclass:9411'),
'9412'  => elgg_echo('resume:work:industryclass:9412'),
'942'  => elgg_echo('resume:work:industryclass:942'),
'9420'  => elgg_echo('resume:work:industryclass:9420'),
'949'  => elgg_echo('resume:work:industryclass:949'),
'9491'  => elgg_echo('resume:work:industryclass:9491'),
'9492'  => elgg_echo('resume:work:industryclass:9492'),
'9499'  => elgg_echo('resume:work:industryclass:9499'),
'95'  => elgg_echo('resume:work:industryclass:95'),
'951'  => elgg_echo('resume:work:industryclass:951'),
'9511'  => elgg_echo('resume:work:industryclass:9511'),
'9512'  => elgg_echo('resume:work:industryclass:9512'),
'952'  => elgg_echo('resume:work:industryclass:952'),
'9521'  => elgg_echo('resume:work:industryclass:9521'),
'9522'  => elgg_echo('resume:work:industryclass:9522'),
'9523'  => elgg_echo('resume:work:industryclass:9523'),
'9524'  => elgg_echo('resume:work:industryclass:9524'),
'9529'  => elgg_echo('resume:work:industryclass:9529'),
'96'  => elgg_echo('resume:work:industryclass:96'),
'960'  => elgg_echo('resume:work:industryclass:960'),
'9601'  => elgg_echo('resume:work:industryclass:9601'),
'9602'  => elgg_echo('resume:work:industryclass:9602'),
'9603'  => elgg_echo('resume:work:industryclass:9603'),
'9609'  => elgg_echo('resume:work:industryclass:9609'),
'T'  => elgg_echo('resume:work:industryclass:T'),
'97'  => elgg_echo('resume:work:industryclass:97'),
'970'  => elgg_echo('resume:work:industryclass:970'),
'9700'  => elgg_echo('resume:work:industryclass:9700'),
'98'  => elgg_echo('resume:work:industryclass:98'),
'981'  => elgg_echo('resume:work:industryclass:981'),
'9810'  => elgg_echo('resume:work:industryclass:9810'),
'982'  => elgg_echo('resume:work:industryclass:982'),
'9820'  => elgg_echo('resume:work:industryclass:9820'),
'U'  => elgg_echo('resume:work:industryclass:U'),
'99'  => elgg_echo('resume:work:industryclass:99'),
'990'  => elgg_echo('resume:work:industryclass:990'),
'9900'  => elgg_echo('resume:work:industryclass:9900'),
  );

$languages = array(
"any" => elgg_echo('resume:cvranking:credittype:any'),
"abk" => elgg_echo('resume:languages:abk'),
"aar" => elgg_echo('resume:languages:aar'),
"afr" => elgg_echo('resume:languages:afr'),
"aka" => elgg_echo('resume:languages:aka'),
"sqi" => elgg_echo('resume:languages:sqi'),
"gsw" => elgg_echo('resume:languages:gsw'),
"amh" => elgg_echo('resume:languages:amh'),
"ara" => elgg_echo('resume:languages:ara'),
"arg" => elgg_echo('resume:languages:arg'),
"hye" => elgg_echo('resume:languages:hye'),
"asm" => elgg_echo('resume:languages:asm'),
"ava" => elgg_echo('resume:languages:ava'),
"ave" => elgg_echo('resume:languages:ave'),
"aym" => elgg_echo('resume:languages:aym'),
"aze" => elgg_echo('resume:languages:aze'),
"bam" => elgg_echo('resume:languages:bam'),
"bak" => elgg_echo('resume:languages:bak'),
"eus" => elgg_echo('resume:languages:eus'),
"bel" => elgg_echo('resume:languages:bel'),
"ben" => elgg_echo('resume:languages:ben'),
"bih" => elgg_echo('resume:languages:bih'),
"bis" => elgg_echo('resume:languages:bis'),
"bjn" => elgg_echo('resume:languages:bjn'),
"bos" => elgg_echo('resume:languages:bos'),
"bre" => elgg_echo('resume:languages:bre'),
"bul" => elgg_echo('resume:languages:bul'),
"mya" => elgg_echo('resume:languages:mya'),
"cat" => elgg_echo('resume:languages:cat'),
"cha" => elgg_echo('resume:languages:cha'),
"che" => elgg_echo('resume:languages:che'),
"nya" => elgg_echo('resume:languages:nya'),
"cmn" => elgg_echo('resume:languages:cmn'),
"cdo" => elgg_echo('resume:languages:cdo'),
"cjy" => elgg_echo('resume:languages:cjy'),
"cpx" => elgg_echo('resume:languages:cpx'),
"czh" => elgg_echo('resume:languages:czh'),
"czo" => elgg_echo('resume:languages:czo'),
"gan" => elgg_echo('resume:languages:gan'),
"hak" => elgg_echo('resume:languages:hak'),
"hsn" => elgg_echo('resume:languages:hsn'),
"mnp" => elgg_echo('resume:languages:mnp'),
"nan" => elgg_echo('resume:languages:nan'),
"wuu" => elgg_echo('resume:languages:wuu'),
"yue" => elgg_echo('resume:languages:yue'),
"chv" => elgg_echo('resume:languages:chv'),
"cor" => elgg_echo('resume:languages:cor'),
"cos" => elgg_echo('resume:languages:cos'),
"cre" => elgg_echo('resume:languages:cre'),
"hrv" => elgg_echo('resume:languages:hrv'),
"ces" => elgg_echo('resume:languages:ces'),
"dan" => elgg_echo('resume:languages:dan'),
"day" => elgg_echo('resume:languages:day'),
"div" => elgg_echo('resume:languages:div'),
"nld" => elgg_echo('resume:languages:nld'),
"dzo" => elgg_echo('resume:languages:dzo'),
"eng" => elgg_echo('resume:languages:eng'),
"epo" => elgg_echo('resume:languages:epo'),
"est" => elgg_echo('resume:languages:est'),
"ewe" => elgg_echo('resume:languages:ewe'),
"fao" => elgg_echo('resume:languages:fao'),
"fij" => elgg_echo('resume:languages:fij'),
"fin" => elgg_echo('resume:languages:fin'),
"fra" => elgg_echo('resume:languages:fra'),
"ful" => elgg_echo('resume:languages:ful'),
"glg" => elgg_echo('resume:languages:glg'),
"kat" => elgg_echo('resume:languages:kat'),
"deu" => elgg_echo('resume:languages:deu'),
"ell" => elgg_echo('resume:languages:ell'),
"grn" => elgg_echo('resume:languages:grn'),
"guj" => elgg_echo('resume:languages:guj'),
"hat" => elgg_echo('resume:languages:hat'),
"hau" => elgg_echo('resume:languages:hau'),
"heb" => elgg_echo('resume:languages:heb'),
"her" => elgg_echo('resume:languages:her'),
"hin" => elgg_echo('resume:languages:hin'),
"hmo" => elgg_echo('resume:languages:hmo'),
"hun" => elgg_echo('resume:languages:hun'),
"ina" => elgg_echo('resume:languages:ina'),
"ind" => elgg_echo('resume:languages:ind'),
"ile" => elgg_echo('resume:languages:ile'),
"gle" => elgg_echo('resume:languages:gle'),
"ibo" => elgg_echo('resume:languages:ibo'),
"ipk" => elgg_echo('resume:languages:ipk'),
"ido" => elgg_echo('resume:languages:ido'),
"isl" => elgg_echo('resume:languages:isl'),
"ita" => elgg_echo('resume:languages:ita'),
"iku" => elgg_echo('resume:languages:iku'),
"jpn" => elgg_echo('resume:languages:jpn'),
"jav" => elgg_echo('resume:languages:jav'),
"kal" => elgg_echo('resume:languages:kal'),
"kan" => elgg_echo('resume:languages:kan'),
"kau" => elgg_echo('resume:languages:kau'),
"kas" => elgg_echo('resume:languages:kas'),
"kaz" => elgg_echo('resume:languages:kaz'),
"khm" => elgg_echo('resume:languages:khm'),
"kik" => elgg_echo('resume:languages:kik'),
"kin" => elgg_echo('resume:languages:kin'),
"kir" => elgg_echo('resume:languages:kir'),
"kom" => elgg_echo('resume:languages:kom'),
"kon" => elgg_echo('resume:languages:kon'),
"kor" => elgg_echo('resume:languages:kor'),
"kur" => elgg_echo('resume:languages:kur'),
"kua" => elgg_echo('resume:languages:kua'),
"lat" => elgg_echo('resume:languages:lat'),
"ltz" => elgg_echo('resume:languages:ltz'),
"lug" => elgg_echo('resume:languages:lug'),
"lim" => elgg_echo('resume:languages:lim'),
"lin" => elgg_echo('resume:languages:lin'),
"lao" => elgg_echo('resume:languages:lao'),
"lit" => elgg_echo('resume:languages:lit'),
"lub" => elgg_echo('resume:languages:lub'),
"lav" => elgg_echo('resume:languages:lav'),
"glv" => elgg_echo('resume:languages:glv'),
"mkd" => elgg_echo('resume:languages:mkd'),
"mlg" => elgg_echo('resume:languages:mlg'),
"msa" => elgg_echo('resume:languages:msa'),
"mal" => elgg_echo('resume:languages:mal'),
"mlt" => elgg_echo('resume:languages:mlt'),
"mri" => elgg_echo('resume:languages:mri'),
"mar" => elgg_echo('resume:languages:mar'),
"mah" => elgg_echo('resume:languages:mah'),
"mon" => elgg_echo('resume:languages:mon'),
"nau" => elgg_echo('resume:languages:nau'),
"nav" => elgg_echo('resume:languages:nav'),
"nob" => elgg_echo('resume:languages:nob'),
"nde" => elgg_echo('resume:languages:nde'),
"nep" => elgg_echo('resume:languages:nep'),
"ndo" => elgg_echo('resume:languages:ndo'),
"nno" => elgg_echo('resume:languages:nno'),
"nor" => elgg_echo('resume:languages:nor'),
"iii" => elgg_echo('resume:languages:iii'),
"nbl" => elgg_echo('resume:languages:nbl'),
"oci" => elgg_echo('resume:languages:oci'),
"oji" => elgg_echo('resume:languages:oji'),
"chu" => elgg_echo('resume:languages:chu'),
"orm" => elgg_echo('resume:languages:orm'),
"ori" => elgg_echo('resume:languages:ori'),
"oss" => elgg_echo('resume:languages:oss'),
"pan" => elgg_echo('resume:languages:pan'),
"pli" => elgg_echo('resume:languages:pli'),
"fas" => elgg_echo('resume:languages:fas'),
"pol" => elgg_echo('resume:languages:pol'),
"pus" => elgg_echo('resume:languages:pus'),
"por" => elgg_echo('resume:languages:por'),
"que" => elgg_echo('resume:languages:que'),
"roh" => elgg_echo('resume:languages:roh'),
"run" => elgg_echo('resume:languages:run'),
"ron" => elgg_echo('resume:languages:ron'),
"rus" => elgg_echo('resume:languages:rus'),
"san" => elgg_echo('resume:languages:san'),
"srd" => elgg_echo('resume:languages:srd'),
"snd" => elgg_echo('resume:languages:snd'),
"sme" => elgg_echo('resume:languages:sme'),
"smo" => elgg_echo('resume:languages:smo'),
"sag" => elgg_echo('resume:languages:sag'),
"srp" => elgg_echo('resume:languages:srp'),
"gla" => elgg_echo('resume:languages:gla'),
"sna" => elgg_echo('resume:languages:sna'),
"sin" => elgg_echo('resume:languages:sin'),
"slk" => elgg_echo('resume:languages:slk'),
"slv" => elgg_echo('resume:languages:slv'),
"som" => elgg_echo('resume:languages:som'),
"sot" => elgg_echo('resume:languages:sot'),
"spa" => elgg_echo('resume:languages:spa'),
"sun" => elgg_echo('resume:languages:sun'),
"swa" => elgg_echo('resume:languages:swa'),
"ssw" => elgg_echo('resume:languages:ssw'),
"swe" => elgg_echo('resume:languages:swe'),
"tam" => elgg_echo('resume:languages:tam'),
"tel" => elgg_echo('resume:languages:tel'),
"tgk" => elgg_echo('resume:languages:tgk'),
"tha" => elgg_echo('resume:languages:tha'),
"tir" => elgg_echo('resume:languages:tir'),
"bod" => elgg_echo('resume:languages:bod'),
"tuk" => elgg_echo('resume:languages:tuk'),
"tgl" => elgg_echo('resume:languages:tgl'),
"tsn" => elgg_echo('resume:languages:tsn'),
"ton" => elgg_echo('resume:languages:ton'),
"tur" => elgg_echo('resume:languages:tur'),
"tso" => elgg_echo('resume:languages:tso'),
"tat" => elgg_echo('resume:languages:tat'),
"twi" => elgg_echo('resume:languages:twi'),
"tah" => elgg_echo('resume:languages:tah'),
"uig" => elgg_echo('resume:languages:uig'),
"ukr" => elgg_echo('resume:languages:ukr'),
"urd" => elgg_echo('resume:languages:urd'),
"uzb" => elgg_echo('resume:languages:uzb'),
"ven" => elgg_echo('resume:languages:ven'),
"vie" => elgg_echo('resume:languages:vie'),
"vol" => elgg_echo('resume:languages:vol'),
"wln" => elgg_echo('resume:languages:wln'),
"cym" => elgg_echo('resume:languages:cym'),
"wol" => elgg_echo('resume:languages:wol'),
"fry" => elgg_echo('resume:languages:fry'),
"xho" => elgg_echo('resume:languages:xho'),
"yid" => elgg_echo('resume:languages:yid'),
"yor" => elgg_echo('resume:languages:yor'),
"zha" => elgg_echo('resume:languages:zha'),
"zul" => elgg_echo('resume:languages:zul'),
);

$langdbs = array (
    "weber" => elgg_echo('resume:languages:databases:weber'),
    "forbes" => elgg_echo('resume:languages:databases:forbes'),
    "first" => elgg_echo('resume:languages:databases:first'),
    "second" => elgg_echo('resume:languages:databases:second'),
    "combined" => elgg_echo('resume:languages:databases:combined'),
    );

$resfields = array(
'any' => elgg_echo('resume:cvranking:any'),
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

$pubfields = array(  
    'any' => elgg_echo('resume:cvranking:any'),
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

$skilltypes = array(
    'any' => elgg_echo('resume:cvranking:any'), 
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

$orders = array(
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
    'edudbgen' => elgg_echo('resume:cvranking:advanced:general'), 
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
    'maxscore' => elgg_echo('resume:cvranking:advanced:maxscore'),
    'z' => elgg_echo('resume:cvranking:advanced:z'),
  );

$advanced_options = '<option selected="selected"></option>';
foreach ($advanceds as $kh => $kt) { $advanced_options .= '<option value="' .$kh. '">' . $kt . '</option>'; }

  $gweights_array = $vars['entity']->gweights;
  
  $users_array = $vars['entity']->users;
  
  $fweights_array = $vars['entity']->fweights;
  $cweights_array = $vars['entity']->cweights;
  $eweights_array = $vars['entity']->eweights;
  $crweights_array = $vars['entity']->crweights;
  $etweights_array = $vars['entity']->etweights;
  
  $sweights_array = $vars['entity']->sweights;
  $wcweights_array = $vars['entity']->wcweights;
  $wweights_array = $vars['entity']->wweights;
  $stweights_array = $vars['entity']->stweights;
  
  $lweights_array = $vars['entity']->lweights;
  $ldbweights_array = $vars['entity']->ldbweights;
  
  $rfweights_array = $vars['entity']->rfweights;
  $pfweights_array = $vars['entity']->pfweights;
  $skweights_array = $vars['entity']->skweights;
  
  $advanceds_array = $vars['entity']->advanceds;
  $aweights_array = $vars['entity']->aweights;
  
  $counted = count($users_array);

if (!isset($vars['entity'])) {
    $counted_js = 1;   
    $counted10_js = 20;   
}
else{
    $counted_js = $counted/20;
    $counted10_js = $counted;   
}

$countedadv = count($advanceds_array);

$divgweights = '<div style="float:left; width:10%; text-align:center; margin-right:25px;">';

$divfields = '<div style="float:left; width:82%; margin-right:5px;">';
$divweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center;">';
$divcountries = '<div style="float:left; width:31%; margin-right:15px;">';
$divcweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divedudbs = '<div style="float:left; width:31%; margin-right:15px;">';
$diveweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divcredittypes = '<div style="float:left; width:25%; margin-right:15px;">';
$divcrweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divedutypes = '<div style="float:left; width:33%; margin-right:15px;">';
$divetweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:25px;">';

$divsectors = '<div style="float:left; width:95%; margin-right:5px;">';
$divsweights = '<div style="float:left; width:20%; margin-top:5px; text-align:center;">';
$divcountries = '<div style="float:left; width:31%; margin-right:15px;">';

$divworkdbs = '<div style="float:left; width:31%; margin-right:20px;">';
$divwweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divsectortypes = '<div style="float:left; width:95%; margin-right:5px;">';
$divstweights = '<div style="float:left; width:20%; margin-top:5px; text-align:center; margin-right:25px;">';

$divlangs = '<div style="float:left; width:31%; margin-right:15px;">';
$divlweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';
$divlangdbs = '<div style="float:left; width:31%; margin-right:15px;">';
$divldbweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';

$divresfields = '<div style="float:left; width:75%; margin-right:15px;">';
$divrfweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center;">';

$divpubfields = '<div style="float:left; width:31%; margin-right:15px;">';
$divpfweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:35px;">';

$divskilltypes = '<div style="float:left; width:31%; margin-right:20px;">';
$divskweights = '<div style="float:left; width:10%; margin-top:5px; text-align:center; margin-right:25px;">';

$divusers = '<div style="float:left; text-align: center; width:49%; margin-right:5px; margin-bottom:5px;">';

$divadvanceds = '<div style="float:left; width:75%; margin-right:15px;">';
$divaweights = '<div style="float:left; width:20%; text-align:center;">';

//For JavaScript:
//bodyText += '<script type="text/javascript">bindAutocomplete();<\/script>'; 
//bindAutocomplete();
?>
<script type="text/javascript">
 <?php echo "var counter = ".$counted_js."\n";?>
 <?php echo "var counterdiv = ".$counted10_js."\n";?>
      var limit = 10;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + (counter*10) + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.id = 'parent' + counter;
          var bodyText = '<div id="child' + counter + '"><div align="center" width="90%" style="float:left; color:red; text-align:center; margin-bottom:10px"><?php echo elgg_echo("resume:cvranking:autocomplete");?></div>';
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++;
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          counterdiv++; 
          bodyText += '<?php echo $divusers;?><?php echo elgg_echo('resume:cvranking:crated');?>';
          bodyText += '<input class="autocomplete ac_input" type="text" value="" name ="users[' + counterdiv + ']_autocomplete"  autocomplete="off"></div><br />';
          bodyText += '<div align="right"><input type="button" onClick="removeElement(\'parent' + counter + '\', \'child' + counter + '\')" value="<?php echo elgg_echo('resume:cvranking:removeuser'); ?>"></div><div class="clearfloat"></div><br />';
          newdiv.innerHTML += bodyText;
          document.getElementById(divName).appendChild(newdiv);
          counter++;
               }

}

 <?php echo "var counteradv = ".$countedadv."\n";?>
 var limitadv = 100;
function addInput2(divName){
          var newdiv = document.createElement('div');
          newdiv.id = 'parent' + counteradv;
          var bodyText = '<div id="child' + counteradv + '">'
          bodyText += '<?php echo $divadvanceds;?><?php echo elgg_echo('resume:cvranking:advanced'); echo '<select name="advanceds[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $advanced_options . '</select>';?>';
          bodyText += '</div>'
          bodyText += '<?php echo $divaweights;?><?php echo elgg_echo('resume:cvranking:weight');?><input type="text" name="aweights[]" value="" class="input-text"/></div>';
          bodyText +=  '<br /><br /><br /> <div align="right"><input type="button" onClick="removeElement(\'parent' + counteradv + '\', \'child' + counteradv + '\')" value="<?php echo elgg_echo('resume:cvranking:removeadvanced'); ?>"></div></div><div class="clearfloat"></div><br />';
          newdiv.innerHTML = bodyText;
          document.getElementById(divName).appendChild(newdiv);
          counteradv++;
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
    <p>
      <?php echo elgg_echo('resume:cvranking:header'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'header', 'value' => $vars['entity']->header)); ?>
    </p>
    
    <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:general'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
     
    <?php 
      echo '<p>';
      echo elgg_echo('resume:cvranking:weights');
      echo "</p>";
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:education');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:work');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:languages');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:research');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:publications');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:weights:skills');
      echo '</div>';
      echo $divgweights;
      echo elgg_echo('resume:cvranking:time');
      echo '</div><br />';
    for( $i = 0; $i < 6; $i++ ) {
      if (!isset($vars['entity'])) {
        $gweights_array[$i] = 100;   
      } 
      echo $divgweights;
      echo elgg_view('input/text', array('internalname' => 'gweights[]', 
           'value' => $gweights_array[$i])); 
      echo '</div>';
    } 
      ?>
          
    <div style="float:left; width:10%; text-align:center; margin-top:5px;">
      <select name="time" class="input-pulldown"><?php echo $time_options; ?></select>
    </div>
     <div class="clearfloat"></div><br />
    
    </div>
   </div>
   
     <div class="clearfloat"></div><br />
    
   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:instructions'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:none;" class="collapsible_box resume_collapsible_box">
    <?php echo elgg_echo('resume:cvranking:instructions:instructions'); ?>
      </div>
   </div>
     <div class="clearfloat"></div><br />
    
   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:education'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
   
      <?php 
      
   // Education fields
      
   for( $i = 0; $i < 3; $i++ ) {
       $j = $i + 1; 
       $field = "fields".$i."[]";
       $fieldvar = "fields".$i;
       $fieldi = $vars['entity']->$fieldvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $fieldi = "any";
      }
      echo $divfields;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:field'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $field,
        "js" =>  "multiple='true'",
        "value"=> $fieldi,

        "options_values"=> $fields
        )
       );
      echo "</div>";
      
      if (!isset($vars['entity'])) {
        $fweights_array[$i] = 100;   
      } 
      echo $divweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight');
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'fweights[]', 
           'value' => $fweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
    
     // Education databases
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $edudb = "edudbs".$i."[]";
       $edudbvar = "edudbs".$i;
       $edudbi = $vars['entity']->$edudbvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $edudbi = "CVR_QS12";
      }
      echo $divedudbs;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:databases'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $edudb,
        "js" =>  "multiple='true'",
        "value"=> $edudbi,

        "options_values"=> $edudbs
        )
       );
      echo "</div>";
     
      
      if (!isset($vars['entity'])) {
        $eweights_array[$i] = 100;   
      } 
      echo $diveweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'eweights[]', 
         'value' => $eweights_array[$i])); 
      echo "</div>";
   }
   
     echo '<div class="clearfloat"></div><br />';
     
   // Education Countries
   
   for( $i = 0; $i < 2; $i++ ) {
       $j = $i + 1; 
       $country = "countries".$i."[]";
       $countryvar = "countries".$i;
       $countryi = $vars['entity']->$countryvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $countryi = "any";
      }
     
      echo $divcountries;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:country');
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $country,
        "js" =>  "multiple='true'",
        "value"=> $countryi,

        "options_values"=> $countries
         )
        );
      echo "</div>";
     
      if (!isset($vars['entity'])) {
        $cweights_array[$i] = 100;   
      } 
      echo $divcweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'cweights[]', 
         'value' => $cweights_array[$i])); 
      echo "</div>";
   }
   
     echo '<div class="clearfloat"></div><br />';
     
     // Credit Types
     
      for( $i = 0; $i < 2; $i++ ) {
           $j = $i + 1; 
       $credittype = "credittypes".$i."[]";
       $credittypevar = "credittypes".$i;
       $credittypei = $vars['entity']->$credittypevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $credittypei = "any";
      }
      echo $divcredittypes;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:credittypes'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $credittype,
        "js" =>  "multiple='true'",
        "value"=> $credittypei,

        "options_values"=> $credittypes
        )
       );
      echo "</div>";
      
      if (!isset($vars['entity'])) {
        $crweights_array[$i] = 100;   
      } 
      echo $divcrweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'crweights[]', 
         'value' => $crweights_array[$i])); 
      echo "</div>";
   }
   
     echo '<div class="clearfloat"></div><br />';
     
     // Education Types
     
      for( $i = 0; $i < 2; $i++ ) {
       $j = $i + 1; 
       $edutype = "edutypes".$i."[]";
       $edutypevar = "edutypes".$i;
       $edutypei = $vars['entity']->$edutypevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $edutypei = "any";
      }
      echo $divedutypes;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:edutypes'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $edutype,
        "js" =>  "multiple='true'",
        "value"=> $edutypei,

        "options_values"=> $edutypes
        )
       );
      echo "</div>";
      
      if (!isset($vars['entity'])) {
        $etweights_array[$i] = 100;   
      } 
      echo $divetweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'etweights[]', 
         'value' => $etweights_array[$i])); 
      echo '</div>';
   }
   
     echo '<div class="clearfloat"></div><br />';
     
     ?>
    </div>
   </div>
   <br />
   
<div class="clearfloat"></div><br /> 
   
   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:work'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
   
   <?php 
    // Sector
   for( $i = 0; $i < 3; $i++ ) {
       $j = $i + 1; 
       $sector = "sectors".$i."[]";
       $sectorvar = "sectors".$i;
       $sectori = $vars['entity']->$sectorvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $sectori = "any";
      }
      echo $divsectors;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:sector'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $sector,
        "js" =>  "multiple='true'",
        "value"=> $sectori,

        "options_values"=> $sectors
        )
       );
      echo '</div><div class="clearfloat"></div>';
      
      if (!isset($vars['entity'])) {
        $sweights_array[$i] = 100;   
      } 
      echo $divsweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight');
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'sweights[]', 
           'value' => $sweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
    
     // Work databases
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $workdb = "workdbs".$i."[]";
       $workdbvar = "workdbs".$i;
       $workdbi = $vars['entity']->$workdbvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $workdbi = "any";
      }
      echo $divworkdbs;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:databases'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $workdb,
        "js" =>  "multiple='true'",
        "value"=> $workdbi,

        "options_values"=> $workdbs
        )
       );
      echo '</div>';
     
      
      if (!isset($vars['entity'])) {
        $wweights_array[$i] = 100;   
      } 
      echo $divwweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'wweights[]', 
         'value' => $wweights_array[$i])); 
      echo '</div>';
   }
   
     echo '<div class="clearfloat"></div><br />';
     
   // Work Countries
   
   for( $i = 0; $i < 2; $i++ ) {
       $j = $i + 1; 
       $wcountry = "wcountries".$i."[]";
       $wcountryvar = "wcountries".$i;
       $wcountryi = $vars['entity']->$wcountryvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $wcountryi = "any";
      }
     
      echo $divcountries;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:country');
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $wcountry,
        "js" =>  "multiple='true'",
        "value"=> $wcountryi,

        "options_values"=> $countries
         )
        );
      echo "</div>";
     
      if (!isset($vars['entity'])) {
        $wcweights_array[$i] = 100;   
      } 
      echo $divcweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'wcweights[]', 
         'value' => $wcweights_array[$i])); 
      echo "</div>";
   }
   
     echo '<div class="clearfloat"></div><br />';
     
     // Sector Types
     
      for( $i = 0; $i < 2; $i++ ) {
           $j = $i + 1; 
       $sectortype = "sectortypes".$i."[]";
       $sectortypevar = "sectortypes".$i;
       $sectortypei = $vars['entity']->$sectortypevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $sectortypei = "any";
      }
      echo $divsectortypes;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:sectortypes'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $sectortype,
        "js" =>  "multiple='true'",
        "value"=> $sectortypei,

        "options_values"=> $sectortypes
        )
       );
      echo '</div><div class="clearfloat"></div>';
      
      if (!isset($vars['entity'])) {
        $stweights_array[$i] = 100;   
      } 
      echo $divstweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'stweights[]', 
         'value' => $stweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
   
  
   ?>
    
     <div class="clearfloat"></div><br />
    </div>
   </div>
   <br />
   
   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:languages'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
   
   <?php 
   
     // Languages
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $language = "languages".$i."[]";
       $languagevar = "languages".$i;
       $languagei = $vars['entity']->$languagevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $languagei = "any";
      }
      echo $divlangs;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:language'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $language,
        "js" =>  "multiple='true'",
        "value"=> $languagei,

        "options_values"=> $languages
        )
       );
      echo '</div>';
     
      
      if (!isset($vars['entity'])) {
        $lweights_array[$i] = 100;   
      } 
      echo $divlweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'lweights[]', 
         'value' => $lweights_array[$i])); 
      echo '</div>';
   }
   
     echo '<div class="clearfloat"></div><br />';
     
   // Lang databases
   
   for( $i = 0; $i < 2; $i++ ) {
       $j = $i + 1; 
       $langdb = "langdbs".$i."[]";
       $langdbvar = "langdbs".$i;
       $langdbi = $vars['entity']->$langdbvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $langdbi = "weber";
      }
      echo $divlangdbs;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:databases'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $langdb,
        "js" =>  "multiple='true'",
        "value"=> $langdbi,

        "options_values"=> $langdbs
        )
       );
      echo '</div>';
     
      
      if (!isset($vars['entity'])) {
        $ldbweights_array[$i] = 100;   
      } 
      echo $divldbweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'ldbweights[]', 
         'value' => $ldbweights_array[$i])); 
      echo '</div>';
   }
   
     echo '<div class="clearfloat"></div><br />';
     
   ?>
    
     <div class="clearfloat"></div><br />
    </div>
   </div>
   <br />
   
   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:researches'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
   
   <?php 
   
     // Research
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $resfield = "resfields".$i."[]";
       $resfieldvar = "resfields".$i;
       $resfieldi = $vars['entity']->$resfieldvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $resfieldi = "any";
      }
      echo $divresfields;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:research'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $resfield,
        "js" =>  "multiple='true'",
        "value"=> $resfieldi,

        "options_values"=> $resfields
        )
       );
      echo '</div>';
     
      if (!isset($vars['entity'])) {
        $rfweights_array[$i] = 100;   
      } 
      echo $divrfweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'rfweights[]', 
         'value' => $rfweights_array[$i])); 
      echo '</div><div class="clearfloat"></div><br />';
   }
   
   ?>
    
     <div class="clearfloat"></div><br />
    </div>
   </div>
   <br />
   
   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:publications'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
   
   <?php 
   
     // Publication
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $pubfield = "pubfields".$i."[]";
       $pubfieldvar = "pubfields".$i;
       $pubfieldi = $vars['entity']->$pubfieldvar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $pubfieldi = "any";
      }
      echo $divpubfields;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:publication'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $pubfield,
        "js" =>  "multiple='true'",
        "value"=> $pubfieldi,

        "options_values"=> $pubfields
        )
       );
      echo '</div>';
     
      if (!isset($vars['entity'])) {
        $pfweights_array[$i] = 100;   
      } 
      echo $divpfweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'pfweights[]', 
         'value' => $pfweights_array[$i])); 
      echo '</div>';
   }
   
      echo '<div class="clearfloat"></div><br />';
   ?>
    
     <div class="clearfloat"></div><br />
    </div>
   </div>
   <br />
   
   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:skills'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
   
   <?php 
   
     // Skill
   
   for( $i = 0; $i < 2; $i++ ) {
          $j = $i + 1; 
       $skilltype = "skilltypes".$i."[]";
       $skilltypevar = "skilltypes".$i;
       $skilltypei = $vars['entity']->$skilltypevar;
       if ( ($i == 0) && (!isset($vars['entity'])) ) {
         $skilltypei = "any";
      }
      echo $divskilltypes;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:skill'); 
      echo "<br />";
      echo  elgg_view("input/pulldown", array(
        "internalname" =>  $skilltype,
        "js" =>  "multiple='true'",
        "value"=> $skilltypei,

        "options_values"=> $skilltypes
        )
       );
      echo '</div>';
     
      if (!isset($vars['entity'])) {
        $skweights_array[$i] = 100;   
      } 
      echo $divskweights;
      echo $j . ". ";
      echo elgg_echo('resume:cvranking:weight'); 
      echo "<br />";
      echo elgg_view('input/text', array('internalname' => 'skweights[]', 
         'value' => $skweights_array[$i])); 
      echo '</div>';
   }
   
      echo '<div class="clearfloat"></div><br />';
   ?>
    
     <div class="clearfloat"></div><br />
    </div>
   </div>
   <br />
   
   <div style="width:97%;margin-left:15px">
    <?php 
    for( $i = 0; $i < 3; $i++ ) { 
    echo '<div style="float:left; width:32%; padding-left:5px;';
     if (!($i%2)) {
         echo 'background-color:#ccc;">'; 
         } 
    else {
        echo 'background-color:#f3f3f3;">';
        }
        
       $j = $i + 1; 
       $cvrtype = "cvrtypes".$i;
       $cvrtypevar = "cvrtypes".$i;
       $cvrtypei = $vars['entity']->$cvrtypevar;
       print_r ($cvrtypei);

      echo $j . ". ";
      echo elgg_echo('resume:cvranking:cvrtypes'); 
      echo "<br />";
       echo elgg_view('input/checkboxes', array(
           'internalname'=> $cvrtype, 
           'value' => $cvrtypei,
                   
           'options' => $cvrtypes
         )
        );    
       
      echo "<br />";
     $order = 'orders'.$i;
     $ordervar = "orders".$i;
     $orderi = $vars['entity']->$ordervar;

if (empty($orderi)) $order_options = '<option disabled="disabled" selected="selected">-------</option>';
else $order_options = '<option value="' . $orderi . '" selected="selected">' . elgg_echo('resume:cvranking:order:' . $orderi) . '</option>';
foreach ($orders as $ah => $at) { $order_options .= '<option value="' .$ah. '">' . $at . '</option>'; }

    echo elgg_echo('resume:cvranking:orders');?>
       <select name="<?php echo $order; ?>" class="input-pulldown" class="input-pulldown" 
               style="margin-top:5px;margin-bottom:5px"><?php echo $order_options; ?></select>
       <?php 
     echo '<br /><br /></div>';
     }
     ?>
   </div>
<div class="clearfloat"></div><br /> 
   
   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php 
      echo elgg_echo('resume:cvranking:users');
      echo " (USERS 1 - 20)"
      ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">

     <?php
     print_r ($users_array);
    if (!isset($vars['entity'])) {
       for ($i = 0; $i < 20; $i++) {
           $j = $i + 1;
        $useriname = "users[".$i."]";
       echo $divusers;
       echo "$j. ";
       echo elgg_echo('resume:cvranking:rated');
       echo elgg_view('input/autocomplete', array('internalname' => $useriname, 'match_on' => 'all', 'value' => ""));      
       echo '</div>';
       } 
    }
    else {
       for ($i = 0; $i < $counted; $i++) {
    	$j = ( $i + 1 );
        $useriname = "users[".$i."]";
        
        if ($i == 20 || $i == 40 || $i == 60 || $i == 80 )  {
     	 ?>
     
     <div class="clearfloat"></div><br />
    </div>
   </div>
      
     <div class="clearfloat"></div> <br />
     
     <div class="contentWrapper resume_contentWrapper" width="716">
        <p><?php 
        echo elgg_echo('resume:cvranking:users');
        echo " USERS (" . $j . " - " .($j+20) . ")";
        ?>
            <a class="collapsibleboxlink resume_collapsibleboxlink">+</a></p>
       <div style="display:none;" class="collapsible_box resume_collapsible_box">
     <?php
     }
     
       echo $divusers;
       echo "$j. ";
       echo elgg_echo('resume:cvranking:rated');
       $guid = $users_array[$i];
       $user = get_user_entity_as_row ($guid);
         if (!$user) {$user = get_group_entity_as_row ($guid);}
       echo elgg_view('input/autocomplete', array('internalname' => $useriname, 'match_on' => 'all', 
           'value' => $guid, 'value_show' => $user->name));
       echo "</div>"; 
    } 
   }
    ?>
      <div class="clearfloat"></div><br />
   </div>
   </div>
    
    <div id="dynamicInput">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" value="<?php echo elgg_echo('resume:cvranking:adduser'); ?>" onClick="addInput('dynamicInput');">
   
   <br /><br />
   
     <div class="clearfloat"></div><br />
     

   <div class="contentWrapper resume_contentWrapper" width="726">
      <p><?php echo elgg_echo('resume:cvranking:education:advanced'); ?>
          <a class="collapsibleboxlink resume_collapsibleboxlink">
          +</a></p>
      <div style="display:all;" class="collapsible_box resume_collapsible_box">
   
      <?php 
      // ADVANCED VALUES
      
      if (!$advanceds_array) {
       echo $divadvanceds;
            echo "1. ";
       echo elgg_echo('resume:cvranking:advanced');
       echo '<select name="advanceds[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $advanced_options . '</select>';
       echo "</div>"; 
       
       echo $divaweights;
            echo "1. ";
       echo elgg_echo('resume:cvranking:weight');
       echo elgg_view('input/text', array('internalname' => "aweights[]", 'value' => ""));
       echo '</div><div class="clearfloat"></div><br />'; 
       
       echo $divadvanceds;
            echo "2. ";
       echo elgg_echo('resume:cvranking:advanced');
       echo '<select name="advanceds[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $advanced_options . '</select>';
       echo "</div>"; 
       
       echo $divaweights;
            echo "2. ";
       echo elgg_echo('resume:cvranking:weight');
       echo elgg_view('input/text', array('internalname' => "aweights[]", 'value' => ""));
        echo '</div><div class="clearfloat"></div><br />'; 
      }
      else { 
        $counted_advanced = count($advanceds_array);
          for ($i=0; $i < $counted_advanced; $i++) {
              $j = $i +1;
            $advanced_options = '<option value="' . $advanceds_array[$i] . '" selected="selected">' . elgg_echo('resume:cvranking:advanced:' . $advanceds_array[$i]) . '</option>';
            foreach ($advanceds as $yh => $yt) { $advanced_options .= '<option value="' .$yh. '">' . $yt . '</option>'; }
            
            echo $divadvanceds;
            echo "$j. ";
            echo elgg_echo('resume:cvranking:advanced');
            echo '<select name="advanceds[]" class="input-pulldown" style="margin-top:5px;margin-bottom:5px">' . $advanced_options . '</select>';
            echo "</div>"; 
            
            echo $divaweights;
            echo "$j. ";
            echo elgg_echo('resume:cvranking:weight');
            echo elgg_view('input/text', array('internalname' => "aweights[]", 'value' => "$aweights_array[$i]"));
             echo '</div><div class="clearfloat"></div><br />'; 
          }
      }
     ?>
   
     <div class="clearfloat"></div><br />
     
    <div id="dynamicInput2">

    </div>
  
   <div class="clearfloat"></div>
   
     <input type="button" value="<?php echo elgg_echo('resume:cvranking:addadvanced'); ?>" onClick="addInput2('dynamicInput2');">
   
   <br /><br />
   
      <div class="clearfloat"></div>

    </div>
   </div>
   <br />
      
 <div class="clearfloat"></div><br />  

    <p>
      <?php echo elgg_echo('access'); ?><br />
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $vars['entity']->access_id));
      else echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
      ?>
    </p>
    
    <?php echo elgg_view('input/securitytoken'); ?>
    
    <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:save'))); ?></p>
    
    <?php if (isset($vars['entity'])) 
    { echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID())); }
    ?>
</form> 
    
</div>