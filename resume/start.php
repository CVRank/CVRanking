<?php
/**
 * CVRanking Resume Start
 *
 * @package CVRanking Resume
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @author Facyla
 * @author Carlos Quiles
 * @copyright Consultora Nivel7 Ltda.
 * @copyright CVRank
 * @link http://www.cvrank.org
 */

/*
 * MAIN ISSUES
 * @todo : use university rankings according to start-end dates of each subject
 * @todo : use company rankings according to start-end dates of each job position
 * @todo : use company capitalizations from company's page information, not from databases
 * SECONDARY
 * @todo : use array of arrays in education fields - array (0, tertiary, secondary) - to avoid (inefficient?) "in_array"
 * @todo : would it be efficient to do the same with workexperience - industryclasses?
 * @todo : when count_titles (articles, res, certs) for loops, to avoid blank scoring, we should 
 *         take only keys from set values from titles_array, and then use them for scores. 
 *         now we are counting all, and even if counting set values, we are not using their keys...
 * @todo : $resfields are not clear (WOK definitons and WOK categories overlap, lacking,...)
 * FUTURE
 * @todo : define $langrades, and make use of it in langcvrate()
 * @todo : with $resfields array (when fixed), let users select (for cvranking) ISI fields, not just categories.
 * @todo : use arrays for countries and let user select (for cvranking) groups: EU, commonwealth, CIE,..
*/

function resume_init() {

  global $CONFIG;

  // Add menu item to logged users
  if (isloggedin ()) {
    add_menu(elgg_echo('resume:menu:item'), $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
  }
  
  elgg_extend_view('profile/userdetails', 'resume/extend_userdetails');
  
  // Extend profile menu to include resume item
  elgg_extend_view('profile/menu/links', 'resume/menu');

  // Extend CSS with plugin's CSS
  elgg_extend_view('css', 'resume/css');
  
  // Extend js with plugin's js
  // elgg_register_simplecache_view('js/resume/education');
  // $url = elgg_get_simplecache_url('js', 'resume/education');
  // elgg_extend_view('metatags', 'resume/metatags');
  
  // Extend search
  if (get_plugin_setting('cvranking') == 'yes') register_entity_type('object', 'cvranking');
  if (get_plugin_setting('education') == 'yes') register_entity_type('object', 'education');
  if (get_plugin_setting('workexperience') == 'yes') register_entity_type('object', 'workexperience');
  if (get_plugin_setting('language') == 'yes') register_entity_type('object', 'language');
  if (get_plugin_setting('research') == 'yes') register_entity_type('object', 'research');
  if (get_plugin_setting('publication') == 'yes') register_entity_type('object', 'publication');
  if (get_plugin_setting('experience') == 'yes') register_entity_type('object', 'experience');
  if (get_plugin_setting('skill') == 'yes') register_entity_type('object', 'skill');
  if (get_plugin_setting('skill_ciiee') == 'yes') register_entity_type('object', 'skill_ciiee');
}

function resume_pagesetup() {
  global $CONFIG;
  $page_owner = page_owner_entity();
  $loggedin_username = get_loggedin_user()->username;

  //Add submenu items to the page
  if (get_context() == "resumes") {
    // Add page owner's exclusive items to menu
    if ($page_owner->guid == get_loggedin_user()->guid) {
      if (get_plugin_setting('cvranking') == 'yes') add_submenu_item(elgg_echo('resume:add:cvranking'), $CONFIG->wwwroot . "mod/resume/cvranking.php");
      if (get_plugin_setting('education') == 'yes') add_submenu_item(elgg_echo('resume:add:education'), $CONFIG->wwwroot . "mod/resume/education.php");
      if (get_plugin_setting('workexperience') == 'yes') add_submenu_item(elgg_echo('resume:add:workexperience'), $CONFIG->wwwroot . "mod/resume/workexperience.php");
      if (get_plugin_setting('language') == 'yes') add_submenu_item(elgg_echo('resume:add:language'), $CONFIG->wwwroot . "mod/resume/language.php");
      if (get_plugin_setting('research') == 'yes') add_submenu_item(elgg_echo('resume:add:research'), $CONFIG->wwwroot . "mod/resume/research.php");
      if (get_plugin_setting('publication') == 'yes') add_submenu_item(elgg_echo('resume:add:publication'), $CONFIG->wwwroot . "mod/resume/publication.php");
      if (get_plugin_setting('experience') == 'yes') add_submenu_item(elgg_echo('resume:add:experience'), $CONFIG->wwwroot . "mod/resume/experience.php");
      if (get_plugin_setting('skill') == 'yes') add_submenu_item(elgg_echo('resume:add:skill'), $CONFIG->wwwroot . "mod/resume/skill.php");
      if (get_plugin_setting('skill_ciiee') == 'yes') add_submenu_item(elgg_echo('resume:add:skill_ciiee'), $CONFIG->wwwroot . "mod/resume/skill_ciiee.php");
      if (is_plugin_enabled('protovis')) {
        add_submenu_item(elgg_echo('resume:chronogram'), $CONFIG->wwwroot . "mod/resume/chronogramme.php?id=" . $page_owner->guid, "main_resume");
        //add_submenu_item(elgg_echo('resume:skillgraph'), $CONFIG->wwwroot . "mod/resume/skillgraph.php"); // @todo
      }
      
    } else if (isloggedin ()) {
      // Not "Page owner's" exclusive items
      add_submenu_item(elgg_echo('resume:menu:goto'), $CONFIG->wwwroot . "pg/resumes/" . $loggedin_username);
      if (is_plugin_enabled('protovis')) {
        add_submenu_item(elgg_echo('resume:chronogram'), $CONFIG->wwwroot . "mod/resume/chronogramme.php?id=" . $page_owner->guid, "main_resume");
      }
    }
  }
  
  // Add "cancel" option if the user is in a create/edit form
  if (get_context() == "resumes_form") {
    add_submenu_item(elgg_echo('resume:menu:cancel'), $CONFIG->wwwroot . "pg/resumes/" . $loggedin_username);
  }
  
}


function resume_page_handler($page) {
  global $CONFIG;
  // determine wich user resume are we showing
  if (isset($page[0]) && !empty($page[0])) {
      $username = $page[0];
      
      // forward away if invalid user.
      if (!$user = get_user_by_username($username)) {
        register_error('blog:error:unknown_username');
        forward($_SERVER['HTTP_REFERER']);
      }

      // set the page owner to show the right content
      set_page_owner($user->getGUID());
      $page_owner = page_owner_entity();

      if ($page_owner === false || is_null($page_owner)) {
        $page_owner = get_loggedin_user();
        set_page_owner(get_loggedin_user());
      }
      
      if ($page_owner->guid == get_loggedin_user()->guid) { $area2 = elgg_view_title(elgg_echo('resume:my')); }
      else { $area1 = elgg_view_title(sprintf(elgg_echo('resume:user'), $page_owner->name)); }
      
      $area2 .= elgg_view('resume/resume', array('owner' => $page_owner));
      $area2 .= elgg_view('resume/cvrating', array('owner' => $page_owner));
      set_context('resumes');
      
      // Add sidebar search
//      $area0 = elgg_view("resume/search");

      $body = elgg_view_layout("two_column_left_sidebar", $area0, $area1 . $area2);
      page_draw(sprintf(elgg_echo('resume:user'), $page_owner->name), $body);

      // -------- END MAIN PAGE CONTENT ---------
  } else if (isloggedin ()) {
    // Forward to user's resume if not user is provided
    forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
  } else {
    // Forward to main page if not logged in
    forward($_SERVER['HTTP_REFERER']);
  }

  if (isset($page[1])) {
      switch ($page[1]) {}
  }
}

/* Printed profile page */
function printed_page_handler($page) {
  echo elgg_view("page_elements/header"); ?>
  <div class="resume_body_printer">
    <?php
    global $CONFIG;
    set_context("profileprint");
    // determine wich user resume are we showing
    if (isset($page[0]) && !empty($page[0])) {
      $username = $page[0];
      // forward away if invalid user.
      if (!$user = get_user_by_username($username)) {
        register_error('blog:error:unknown_username');
        forward($_SERVER['HTTP_REFERER']);
      }
      // set the page owner to show the right content
      set_page_owner($user->getGUID());
      $page_owner = page_owner_entity();
      if ($page_owner === false || is_null($page_owner)) {
        $page_owner = get_loggedin_user();
        set_page_owner(get_loggedin_user());
      }
      echo elgg_view('resume/printed', array('owner' => $page_owner));
    }
  echo '</div><!-- /#resume_body_printer -->';
}

/* Décode les entités HTML ; nécessaire pour le flux XML qui n'apprécie pas vraiment les entités HTML, et évite de répéter les 2 fonctions à chaque fois..
Note : il faut parfois aussi également encoder en UTF-8 avec utf8_encode($txt)
*/
if (!function_exists('unhtmlentities')) {
  function unhtmlentities($chaineHtml) {
    $tmp = get_html_translation_table(HTML_ENTITIES);
    $tmp = array_flip ($tmp);
    $chaineTmp = strtr ($chaineHtml, $tmp);
    return $chaineTmp; 
  }
}


// cvranking BEGINS 

  // FUNCTION GET default values
  function get_defaultvalues () {
      $advanced_values = array (
             "ISCED999" => 1,
             "ISCED0" => 1,
             "ISCED010" => 2,
             "ISCED020" => 3,
             "ISCED1" => 4,
             "ISCED100" => 4,
             "ISCED2" => 4.5,
             "ISCED2-1" => 4.5,
             "ISCED2-2" => 5,
             "ISCED2-3" => 5.5,
             "ISCED2-4" => 6,
             "ISCED3" => 6.5,
             "ISCED3-1" => 6.5,
             "ISCED3-2" => 7,
             "ISCED3-3" => 7.5,
             "ISCED3-4" => 8,
             "ISCED4" => 8.5,
             "ISCED4-1" => 8.5,
             "ISCED4-3" => 9.5,
             "ISCED4-4" => 10,
             "ISCED5" => 10.5,
             "ISCED5-1" => 10.5,
             "ISCED5-4" => 11,
             "ISCED6" => 11.5,
             "ISCED6-1" => 11.5,
             "ISCED6-5" => 12,
             "ISCED6-6" => 12.1,
             "ISCED6-7" => 12.1,
             "ISCED7" => 12,
             "ISCED7-1" => 12,
             "ISCED7-6" => 12.1,
             "ISCED7-7" => 12.5,
             "ISCED7-8" => 12.6,
             "ISCED8" => 12.5,
             "ISCED8-1" => 12.5,
             "ISCED8-4" => 13, 
             "ISCED-4-" => 1,
             "ISCED-5-" => 1,
             "ISCED-6-" => 1,
             "ISCED999" => 1,
             "ISCE0" => 2,
             "ISCE1" => 5,
             "ISCE2" => 5.5,
             "ISCE3" => 7.5,
             "ISCE4" => 9.5,
             "ISCE5" => 11.5,
             "ISCE6" => 12.5,
             "ISCE7" => 13,
             "ISCE8" => 13.5,
             "edudbgen" => 0.5,
      // if it is an exam, give stdyear values; by default = 1 year of study for all
             "exam" => 1,
             "accessexam" => 1,
             "stateexam" => 1,
             "officialexam" => 1,
             "privateexam" => 1,
      // classrank gives a maximum of 5% more
             "crank" => 0.05,
      // classrank is a power of... (the bigger the less value given to lesser values)
             "powerrank" => 2,
     // prizes give the following (conventional - CVRank) values over 100%
             "intprize" => 1,
             "natprize" => 0.75,
             "regprize" => 0.5,
             "instprize" => 0.25,
             "classprize" => 0.1,
      // Maximum ("reasonable") expected wage/week: US$ >1M/year = 20000/week = 500/hour / (working 20 hours/week) 
      // = 25 => log = 5.52
             "maxwage" => 3.21,
      // From Forbes: Gains of foreign language comparable with simply staying in school a bit longer: 
      // "Saiz and Zoido found that an extra year of schooling yielded an 8% to 14% wage premium"
      // http://www.forbes.com/2008/02/22/popular-foreign-languages-tech-language_sp08-cx_rr_0222foreign.html
             "difflang" => "ISCED4-4",
      // Categories FSI - extrapolated from level 3 -> 4 (according to CVRank), and added new category
             "lang0" => 1,
             "langI" => 1.5,
             "langII" => 2,
             "langIII" => 3,
             "langIV" => 3.5,
             "langV" => 5,
      // mother tongue is given minimum Nr years (no merit in comparison to others...)
       // thus, "multiple mother tongues" are avoided...
             "mother" => "lang0",
       // if user already has a mother tongue of the same type, multiply by:
             "mother2" => 0.5,
       // if user already speaks a foreign language of the same type, multiply by:
             "foreign2" => 0.75,
       // minimum given to mother tongue 1 and mother tongue 2
             "minlang1" => 91,
             "minlang2" => 90,
       // maximum possible for foreign languages
             "maxlang2" => 95,
       // weights given to impact factor and eigenfactor (both should sum up 1)
             "impact" => 0.5,
             "eigen" => 0.5,
       // stdyear for research: suppose a conservative, general (potential) 10 articles/year
          // it needs to be thought in terms of full dedication (like all other achievements and merits), 
          // not actual number of months spent (part-time for professors, doctors,...) on the articles
             "resyear" => 0.1,
       // WOK and Google Scholar citations weight (must add to 1)
          // Google Scholar takes into account conferences and post-1990 journals better
             "WOK" => 0.5,
             "GOOG" => 0.5,
       // Prize values from 0-1, multiply final CVR (be careful: they can be added!)
             "prcited" => 0.25,
             "prnobel" => 1,
             "prother" => 0.1,
       // if $posfactor is 1, and there are only 2 authors, the first name is given full CVR; 
       // if $posfactor is <1 or there are >2 authors, he is given less
             "posfactor" => 1,
       // level correction factor: avoid too much weight for publications dependent on academic level
             "levelfactor" => 0.9,
       // stdyear for publication: we have to suppose full-time dedication (actual time spent)
       // potentially (full dedication) you can give a lot of conferences and courses...
             "live" => 0.01,
       // suppose 10 possible works a year (average quality)
             "written" => 0.1,
       // suppose between conferences and written
             "media" => 0.05,
       // weight for publications' scores readers/viewers and units sold and 
             "VIEW" => 0.5,
             "SOLD" => 0.5,
       // suppose a general 10 skills learnt / year
             "skillyear" => 0.1,
       // to avoid multiple related skills, this coef has as exp number of same skills, and multiplies CVR
       // the lesser the number, the lesser the value of each skill of the same type, when multiple similar skills
             "skillcoef" => 0.99,
      // CVR standard values
             "maxscore" => 99.9,
             "z" => 4,
                 );
       $edufields = array(
'any' => 0,
   '0'=> 0,
//'01'=> 0,
'010'=> 0,
//'08'=> 0,
'080'=> 0,
//'09'=> 0,
'090'=> 0,
'1'=> 0,
//'14'=> 0,
'140'=> 0,
'141'=> 0,
'142'=> 0,
'143'=> 0,
'144'=> 0,
'145'=> 0,
'146'=> 0,
'149'=> 0,
'2'=> 0,
'21'=> 0,
'210'=> 0,
'211'=> 0,
'212'=> 0,
'213'=> 0,
'214'=> 0,
'215'=> 0,
'219'=> 0,
'22'=> 0,
'220'=> 0,
'221'=> 0,
'222'=> 0,
'223'=> 0,
'225'=> 0,
'226'=> 0,
'229'=> 0,
'3'=> 0,
'31'=> 0,
'310'=> 0,
'311'=> 0,
'312'=> 0,
'313'=> 0,
'314'=> 0,
'319'=> 0,
'32'=> 0,
'321'=> 0,
'322'=> 0,
'329'=> 0,
'34'=> 0,
'340'=> 0,
'341'=> 0,
'342'=> 0,
'343'=> 0,
'344'=> 0,
'345'=> 0,
'346'=> 0,
'347'=> 0,
'349'=> 0,
'38'=> 0,
'380'=> 0,
'4'=> 0,
'42'=> 0,
'421'=> 0,
'422'=> 0,
'429'=> 0,
'44'=> 0,
'440'=> 0,
'441'=> 0,
'442'=> 0,
'443'=> 0,
'449'=> 0,
'46'=> 0,
'461'=> 0,
'462'=> 0,
'469'=> 0,
'48'=> 0,
'481'=> 0,
'482'=> 0,
'489'=> 0,
'5'=> 0,
'52'=> 0,
'520'=> 0,
'521'=> 0,
'522'=> 0,
'523'=> 0,
'524'=> 0,
'525'=> 0,
'529'=> 0,
'54'=> 0,
'540'=> 0,
'541'=> 0,
'542'=> 0,
'543'=> 0,
'544'=> 0,
'549'=> 0,
'58'=> 0,
'581'=> 0,
'582'=> 0,
'589'=> 0,
'6'=> 0,
'62'=> 0,
'620'=> 0,
'621'=> 0,
'622'=> 0,
'623'=> 0,
'624'=> 0,
'629'=> 0,
'64'=> 0,
'640'=> 0,
'7'=> 0,
'72'=> 0,
'720'=> 0,
'721'=> 0,
'723'=> 0,
'724'=> 0,
'725'=> 0,
'726'=> 0,
'727'=> 0,
'729'=> 0,
'76'=> 0,
'761'=> 0,
'762'=> 0,
'769'=> 0,
'8'=> 0,
'81'=> 0,
'810'=> 0,
'811'=> 0,
'812'=> 0,
'813'=> 0,
'814'=> 0,
'815'=> 0,
'819'=> 0,
'84'=> 0,
'840'=> 0,
'85'=> 0,
'850'=> 0,
'851'=> 0,
'852'=> 0,
'853'=> 0,
'859'=> 0,
'86'=> 0,
'860'=> 0,
'861'=> 0,
'862'=> 0,
'863'=> 0,
'869'=> 0,
//'99'=> 0,
  );
  
        $educountries = array( 
'any' => 0,
'United States' => 0,
'United Kingdom' => 0,
'Afghanistan' => 0,
'Albania' => 0,
'Algeria' => 0,
'American Samoa' => 0,
'Andorra' => 0,
'Angola' => 0,
'Anguilla' => 0,
'Antigua & Barbuda' => 0,
'Argentina' => 0,
'Armenia' => 0,
'Aruba' => 0,
'Australia' => 0,
'Austria' => 0,
'Azerbaijan' => 0,
'Bahamas' => 0,
'Bahrain' => 0,
'Bangladesh' => 0,
'Barbados' => 0,
'Belarus' => 0,
'Belgium' => 0,
'Belize' => 0,
'Benin' => 0,
'Bermuda' => 0,
'Bhutan' => 0,
'Bolivia' => 0,
'Bonaire' => 0,
'Bosnia & Herzegovina' => 0,
'Botswana' => 0,
'Brazil' => 0,
'British Indian Ocean Ter' => 0,
'Brunei' => 0,
'Bulgaria' => 0,
'Burkina Faso' => 0,
'Burundi' => 0,
'Cambodia' => 0,
'Cameroon' => 0,
'Canada' => 0,
'Cape Verde' => 0,
'Cayman Islands' => 0,
'Central African Republic' => 0,
'Chad' => 0,
'Channel Islands' => 0,
'Chile' => 0,
'China' => 0,
'Christmas Island' => 0,
'Cocos Island' => 0,
'Colombia' => 0,
'Comoros' => 0,
'Congo' => 0,
'Cook Islands' => 0,
'Costa Rica' => 0,
'Cote DIvoire' => 0,
'Croatia' => 0,
'Cuba' => 0,
'Curaco' => 0,
'Cyprus' => 0,
'Czech Republic' => 0,
'Denmark' => 0,
'Djibouti' => 0,
'Dominica' => 0,
'Dominican Republic' => 0,
'East Timor' => 0,
'Ecuador' => 0,
'Egypt' => 0,
'El Salvador' => 0,
'Equatorial Guinea' => 0,
'Eritrea' => 0,
'Estonia' => 0,
'Ethiopia' => 0,
'Falkland Islands' => 0,
'Faroe Islands' => 0,
'Fiji' => 0,
'Finland' => 0,
'France' => 0,
'French Guiana' => 0,
'French Polynesia' => 0,
'French Southern Ter' => 0,
'Gabon' => 0,
'Gambia' => 0,
'Georgia' => 0,
'Germany' => 0,
'Ghana' => 0,
'Gibraltar' => 0,
'Greece' => 0,
'Greenland' => 0,
'Grenada' => 0,
'Guadeloupe' => 0,
'Guam' => 0,
'Guatemala' => 0,
'Guinea' => 0,
'Guyana' => 0,
'Haiti' => 0,
'Honduras' => 0,
'Hong Kong' => 0,
'Hungary' => 0,
'Iceland' => 0,
'India' => 0,
'Indonesia' => 0,
'Iran' => 0,
'Iraq' => 0,
'Ireland' => 0,
'Isle of Man' => 0,
'Israel' => 0,
'Italy' => 0,
'Jamaica' => 0,
'Japan' => 0,
'Jordan' => 0,
'Kazakhstan' => 0,
'Kenya' => 0,
'Kiribati' => 0,
'Korea North' => 0,
'Korea' => 0,
'Kuwait' => 0,
'Kyrgyzstan' => 0,
'Laos' => 0,
'Latvia' => 0,
'Lebanon' => 0,
'Lesotho' => 0,
'Liberia' => 0,
'Libya' => 0,
'Liechtenstein' => 0,
'Lithuania' => 0,
'Luxembourg' => 0,
'Macau' => 0,
'Macedonia' => 0,
'Madagascar' => 0,
'Malaysia' => 0,
'Malawi' => 0,
'Maldives' => 0,
'Mali' => 0,
'Malta' => 0,
'Marshall Islands' => 0,
'Martinique' => 0,
'Mauritania' => 0,
'Mauritius' => 0,
'Mayotte' => 0,
'Mexico' => 0,
'Midway Islands' => 0,
'Moldova' => 0,
'Monaco' => 0,
'Mongolia' => 0,
'Montenegro' => 0,
'Montserrat' => 0,
'Morocco' => 0,
'Mozambique' => 0,
'Myanmar' => 0,
'Nambia' => 0,
'Nauru' => 0,
'Nepal' => 0,
'Netherland Antilles' => 0,
'Netherlands' => 0,
'Nevis' => 0,
'New Caledonia' => 0,
'New Zealand' => 0,
'Nicaragua' => 0,
'Niger' => 0,
'Nigeria' => 0,
'Niue' => 0,
'Norfolk Island' => 0,
'Norway' => 0,
'Oman' => 0,
'Pakistan' => 0,
'Palau Island' => 0,
'Palestine' => 0,
'Panama' => 0,
'Papua New Guinea' => 0,
'Paraguay' => 0,
'Peru' => 0,
'Phillipines' => 0,
'Pitcairn Island' => 0,
'Poland' => 0,
'Portugal' => 0,
'Puerto Rico' => 0,
'Qatar' => 0,
'Reunion' => 0,
'Romania' => 0,
'Russia' => 0,
'Rwanda' => 0,
'St Barthelemy' => 0,
'St Eustatius' => 0,
'St Helena' => 0,
'St Kitts-Nevis' => 0,
'St Lucia' => 0,
'St Maarten' => 0,
'St Pierre & Miquelon' => 0,
'St Vincent & Grenadines' => 0,
'Saipan' => 0,
'Samoa' => 0,
'Samoa American' => 0,
'San Marino' => 0,
'Sao Tome & Principe' => 0,
'Saudi Arabia' => 0,
'Senegal' => 0,
'Serbia' => 0,
'Seychelles' => 0,
'Sierra Leone' => 0,
'Singapore' => 0,
'Slovakia' => 0,
'Slovenia' => 0,
'Solomon Islands' => 0,
'Somalia' => 0,
'South Africa' => 0,
'Spain' => 0,
'Sri Lanka' => 0,
'Sudan' => 0,
'Suriname' => 0,
'Swaziland' => 0,
'Sweden' => 0,
'Switzerland' => 0,
'Syria' => 0,
'Tahiti' => 0,
'Taiwan' => 0,
'Tajikistan' => 0,
'Tanzania' => 0,
'Thailand' => 0,
'Togo' => 0,
'Tokelau' => 0,
'Tonga' => 0,
'Trinidad & Tobago' => 0,
'Tunisia' => 0,
'Turkey' => 0,
'Turkmenistan' => 0,
'Turks & Caicos Is' => 0,
'Tuvalu' => 0,
'Uganda' => 0,
'Ukraine' => 0,
'United Arab Emirates' => 0,
'United Kingdom' => 0,
'United States' => 0,
'Uraguay' => 0,
'Uzbekistan' => 0,
'Vanuatu' => 0,
'Vatican City State' => 0,
'Venezuela' => 0,
'Vietnam' => 0,
'Virgin Islands (Brit)' => 0,
'Virgin Islands (USA)' => 0,
'Wake Island' => 0,
'Wallis & Futana Is' => 0,
'Yemen' => 0,
'Zaire' => 0,
'Zambia' => 0,
'Zimbabwe' => 0,
);
        
$edudatabases = array(
    'any' => 0,
    'CVR_QS12' => 0,
    'CVR_THE12' => 0,
    'CVR_ARWU12' => 0,
    'CVR_TIMSS08' => 0,
    'CVR_USNewsU12' => 0,
    'CVR_USNewsG12' => 0,
    'CVR_UK12' => 0,
    'CVR_DEChe12' => 0,
    'CVR_ESISI12' => 0,
  );      

$credtypes = array(
'any' => 0,
    'major' => 0,  
    'basic' => 0,
    'chosen' => 0,
    'exam' => 0,
    'transfer' => 0,
  );  

$prestypes = array(
'any' => 0,
    // added blank "" in case it is not selected!
'' => 0,
    'Presence' => 0,    
    'Part-time' => 0,
    'Hybrid' => 0,
    'Distance' => 0,
    'Non-formal' => 0,
  );   

$hourtypes = array(
    "US" => 31,
    "ECTS" => 60,
    "UK" => 120,
    "Carnegie" => 5.75,
    "Japan" => 32,
    "China" => 35,
    "Latvia" => 40, 
    "Germany old" => 40,
    "Austria old" => 40,
    "Sweden old" => 40,
    "Finland old" => 40,
    "Estonia old" => 40,
    "Netherlands old" => 42,
    "Denmark old" => 1,
    "Norway old" => 20,
    "Spain old" => 75,
    "Sweden older" => 40,
    "Colombia" => 34,
    "El Salvador" => 32,
    "800" => 800,
    "900" => 900,
    "1000" => 1000,
    "1100" => 1100,
    "1200" => 1200,
    "700" => 700,
    "1300" => 1300,
    "1400" => 1400);

// ARRAY ( array(a, b, c) ) : 
// a => weight of grades (adjusting grade inflation)
// b => name of letter_to_grade function
// c => name of function for conversion grade -> score (scale 0-100)
// d => percentage that means PASS
$gradetypes = array(  
'1005' => array (90, 0, 100, 50),
'1006' => array (90, 0, 100, 60),
'1007' => array (90, 0, 100, 70),
'205' => array (90, 0, 20, 50),
'206' => array (90, 0, 20, 60),
'US4' => array (100,'US4','US4', 60),
'US5' => array (100,'US5','US5', 70),
'US9' => array (100, 'US9', 'US9', 70),
'US10' => array (100, 'US10', 'US10', 70),
'US42' => array (100,'US42','US42', 60),
'US52' => array (100,'US52','US52', 70),
'UK' => array (100,'UK','UK', 60),
'GCSE' => array (100,'GCSE', 'GCSE', 60),
'GCE' =>  array (100,'GCSE', 'GCSE', 60),
'ECTS' => array (100,'ECTS', 'UK', 60),
'IB' => array (100, 0, 'IB', 70),
'Canada' => array (100,'US4','US4', 60),
'Albania' => array (100, 0, 10, 50),
'Algeria10' => array (100, 0, 10, 50),
'Algeria20' => array (100, 0, 20, 50),
'Argentina3' => array (100, 0, 10, 40),
'Argentina2' => array (100, 0, 10, 50),
'Argentina70' => array (100, 0, 10, 60),
'Australia3' => array (100, 0, 7, 57),
'Australia4' => array (100, 0, 4, 25),
'Australia2' =>  array (100, 'US4', 'US4', 50),
'Australia6' => array (100, 0, 6, 33),
'Austria' => array (100, 0, 'Germany', 50),
'Bangladesh' => array (100, 'US5', 'US5', 60),
'Belgium' => array (100, 0, 20, 50),
'Bolivia' => array (100, 0, 70, 50),
'Bosnia3' =>  array (100, 0, 10, 60),
'Bosnia2' =>  array (100, 0, 5, 40),
'Brazil5' =>  array (100, 0, 10, 50),
'Brazil6' =>  array (100, 0, 10, 60),
'Brazil7' =>  array (100, 0, 10, 70),
'Bulgaria2' =>  array (100, 0, 6, 33),
'Bulgaria3' =>  array (100, 0, 6, 33),
'Chile' => array (100, 0, 7, 60),
'China'  => array (100, "China", 100, 60),
'Colombia5' => array (100, 0, 5, 65),
'Colombia10' => array (100, 0, 10, 65),
'CostaRica1' =>  array (100, 0, 100, 65),
'CostaRica3' =>  array (100, 0, 7, 70),
'Croatia2' => array (100, 0, 5, 40),
'Croatia3' => array (100, 0, 5, 40),
'Czech' => array (100, 'inv5', 5, 40),
'Denmark13' => array (100, 0, 13, 46),
'Denmark7' => array (100, 'Denmark', 'UK', 46),
'Ecuador' =>  array (100, 0, 20, 65),
'ElSalvador6' => array (100, 0, 10, 60),
'ElSalvador7' => array (100, 0, 10, 70),
'ElSalvadorD' => array (100, 'US4', 'US4', 60),
'Finland' =>  array (100, 0, 10, 50),
'France2' =>  array (100, 0, 10, 50),
'France3' => array (100, 0, 20, 50),
'Germany' => array (100, 0, 'Germany', 50),
'Greece3' => array (100, 0, 10, 50),
'Greece2' => array (100, 0, 20, 50),
'Guatemala' => array (100, 0, 100, 60),
'HongKong3' =>array (100, 'US4', 'US4', 60),
    // It seems that Hong Kong suffers from the UK grade inflation...
'HongKong2' => array (100, 'GCSE', 'GCSE', 60),
'Honduras' => array (100, 0, 100, 60),
'Hungary' => array (100, 0, 5, 40),
'Iceland100' => array (100, 0, 100, 50),
'Iceland10' => array (100, 0, 10, 50),
'Ireland2' => array (100, 'Ireland2', 100, 45),
'Ireland3' => array (100, 'Ireland3', 'UK', 60),
'Iran' => array (100, 0, 20, 50),
'Iraq' => array (100, 0, 100, 50),
'India100' =>  array (100, 0, 100, 40),
'India10' =>  array (100, 0, 10, 50),
'Indonesia3' => array (100, 'US4', 'US4', 60),
'Indonesia56' =>  array (100, 0, 100, 56),
'Indonesia70' =>  array (100, 0, 100, 70),
'Indonesia10' =>  array (100, 0, 10, 40),
'Israel10' =>  array (100, 0, 10, 55),
'Israel100' => array (100, 0, 100, 60),
'Italy3' => array (100, 0, 30, 60),
'Italy2' => array (100, 0, 10, 60),
'Jamaica' => array (100, 'US4', 'US4', 60),
'Japan6' => array (100, "Japan6", 100, 50),
'Japan4' => array (100, "Japan4", 100, 60),
'Korea' => array (100, 'US4', 'US4', 60),
'Kuwait' => array (100, 0, 'US4', 60),
'Latvia' => array (100, 0, 10, 50),
'Lebanon60' => array (100, 0, 100, 60),
'Lebanon70' => array (100, 0, 100, 70),
'Lebanon20' => array (100, 0, 10, 50),
'Lithuania' => array (100, 0, 10, 50),
'Luxembourg' => array (100, 0, 60, 50),
'Macedonia2' =>  array (100, 0, 5, 40),
'Macedonia3' => array (100, 0, 10, 60),
'Mexico60' => array (100, 0, 100, 60),
'Mexico70' => array (100, 0, 100, 70),
'Mexico80' => array (100, 0, 100, 80),
'Malaysia' => array (100, 'US4', 'US4', 60),
'Moldova' =>  array (100, 0, 10, 50),
'Netherlands' => array (100, 0, 10, 60),
'NewZealand' => array (100, 'US9', 'US9', 60),
'Nicaragua60' => array (100, 0, 100, 60),
'Nicaragua70' => array (100, 0, 100, 70),
'Norway3' => array (100, 0, "Germany", 50),
'Norway2' => array (100, 0, 6, 33),
'Panama' => array (100, 0, 5, 60),
'Pakistan' => array (100, 'Ireland2', 100, 50),
'Paraguay' => array (100, 0, 5, 60),
'Poland1' => array (100, 0, 'Poland1', 30),
'Poland3' => array (100, 0, 'Poland3', 60),
'Portugal2' => array (100, 0, 5, 60),
'Portugal3' => array (100, 0, 20, 48),
'Peru3' => array (100, 0, 20, 55),
'Peru11' => array (100, 0, 20, 65),
'Romania' => array (100, 0, 10, 50),
'Saudi' => array (100, 'US4', 'US4', 60),
'Serbia3' => array (100, 0, 10, 60),
'Slovakia' => array (100, 0, 10, 60),
'Slovenia3' => array (100, 0, 10, 60),
'Slovenia2' => array (100, 0, 5, 40),
'Russia' => array (100, 0, 'Russia', 50),
'Spain' => array (100, 0, 10, 50),
'Sweden3' => array (100, 0, 5, 40),
'SwedenECTS' => array (100, 'ECTS', 'UK', 50),
'Switzerland' => array (100, 0, 6, 66),
'Thailand' => array (100, 'US4', 'US4', 60),
'Tunisia10' => array (100, 0, 10, 50),
'Tunisia20' => array (100, 0, 20, 50),
'UAE' => array (100, 'US4', 'US4', 60),
'Ukraine' =>  array (100, 0, 12, 33),
'Uruguay6' => array (100, 0, 12, 50),
'Uruguay3' => array (100, 0, 12, 33),
'Uruguay100' => array (100, 0, 12, 25),
'Vietnam' => array (100, 0, 10, 20),
'Venezuela20' => array (100, 0, 20, 45),
'Venezuela100' => array (100, 0, 100, 50),
'Yugoslavia' => array (100, 0, 5, 40),
    );

    $sectors = array (
  '1' =>	0,
'11' =>	0,
'111' =>	0,
'1111' =>	0,
'1112' =>	0,
'1113' =>	0,
'1114' =>	0,
'112' =>	0,
'1120' =>	0,
'12' =>	0,
'121' =>	0,
'1211' =>	0,
'1212' =>	0,
'1213' =>	0,
'1219' =>	0,
'122' =>	0,
'1221' =>	0,
'1222' =>	0,
'1223' =>	0,
'13' =>	0,
'131' =>	0,
'1311' =>	0,
'1312' =>	0,
'132' =>	0,
'1321' =>	0,
'1322' =>	0,
'1323' =>	0,
'1324' =>	0,
'133' =>	0,
'1330' =>	0,
'134' =>	0,
'1341' =>	0,
'1342' =>	0,
'1343' =>	0,
'1344' =>	0,
'1345' =>	0,
'1346' =>	0,
'1349' =>	0,
'14' =>	0,
'141' =>	0,
'1411' =>	0,
'1412' =>	0,
'142' =>	0,
'1420' =>	0,
'143' =>	0,
'1431' =>	0,
'1439' =>	0,
'2' =>	0,
'21' =>	0,
'211' =>	0,
'2111' =>	0,
'2112' =>	0,
'2113' =>	0,
'2114' =>	0,
'212' =>	0,
'2120' =>	0,
'213' =>	0,
'2131' =>	0,
'2132' =>	0,
'2133' =>	0,
'214' =>	0,
'2141' =>	0,
'2142' =>	0,
'2143' =>	0,
'2144' =>	0,
'2145' =>	0,
'2146' =>	0,
'2149' =>	0,
'215' =>	0,
'2151' =>	0,
'2152' =>	0,
'2153' =>	0,
'216' =>	0,
'2161' =>	0,
'2162' =>	0,
'2163' =>	0,
'2164' =>	0,
'2165' =>	0,
'2166' =>	0,
'22' =>	0,
'221' =>	0,
'2211' =>	0,
'2212' =>	0,
'222' =>	0,
'2221' =>	0,
'2222' =>	0,
'223' =>	0,
'2230' =>	0,
'224' =>	0,
'2240' =>	0,
'225' =>	0,
'2250' =>	0,
'226' =>	0,
'2261' =>	0,
'2262' =>	0,
'2263' =>	0,
'2264' =>	0,
'2265' =>	0,
'2266' =>	0,
'2267' =>	0,
'2269' =>	0,
'23' =>	0,
'231' =>	0,
'2310' =>	0,
'232' =>	0,
'2320' =>	0,
'233' =>	0,
'2330' =>	0,
'234' =>	0,
'2341' =>	0,
'2342' =>	0,
'235' =>	0,
'2351' =>	0,
'2352' =>	0,
'2353' =>	0,
'2354' =>	0,
'2355' =>	0,
'2356' =>	0,
'2359' =>	0,
'24' =>	0,
'241' =>	0,
'2411' =>	0,
'2412' =>	0,
'2413' =>	0,
'242' =>	0,
'2421' =>	0,
'2422' =>	0,
'2423' =>	0,
'2424' =>	0,
'243' =>	0,
'2431' =>	0,
'2432' =>	0,
'2433' =>	0,
'2434' =>	0,
'25' =>	0,
'251' =>	0,
'2511' =>	0,
'2512' =>	0,
'2513' =>	0,
'2514' =>	0,
'2519' =>	0,
'252' =>	0,
'2521' =>	0,
'2522' =>	0,
'2523' =>	0,
'2529' =>	0,
'26' =>	0,
'261' =>	0,
'2611' =>	0,
'2612' =>	0,
'2619' =>	0,
'262' =>	0,
'2621' =>	0,
'2622' =>	0,
'263' =>	0,
'2631' =>	0,
'2632' =>	0,
'2633' =>	0,
'2634' =>	0,
'2635' =>	0,
'2636' =>	0,
'264' =>	0,
'2641' =>	0,
'2642' =>	0,
'2643' =>	0,
'265' =>	0,
'2651' =>	0,
'2652' =>	0,
'2653' =>	0,
'2654' =>	0,
'2655' =>	0,
'2656' =>	0,
'2659' =>	0,
'3' =>	0,
'31' =>	0,
'311' =>	0,
'3111' =>	0,
'3112' =>	0,
'3113' =>	0,
'3114' =>	0,
'3115' =>	0,
'3116' =>	0,
'3117' =>	0,
'3118' =>	0,
'3119' =>	0,
'312' =>	0,
'3121' =>	0,
'3122' =>	0,
'3123' =>	0,
'313' =>	0,
'3131' =>	0,
'3132' =>	0,
'3133' =>	0,
'3134' =>	0,
'3135' =>	0,
'3139' =>	0,
'314' =>	0,
'3141' =>	0,
'3142' =>	0,
'3143' =>	0,
'315' =>	0,
'3151' =>	0,
'3152' =>	0,
'3153' =>	0,
'3154' =>	0,
'3155' =>	0,
'32' =>	0,
'321' =>	0,
'3211' =>	0,
'3212' =>	0,
'3213' =>	0,
'3214' =>	0,
'322' =>	0,
'3221' =>	0,
'3222' =>	0,
'323' =>	0,
'3230' =>	0,
'324' =>	0,
'3240' =>	0,
'325' =>	0,
'3251' =>	0,
'3252' =>	0,
'3253' =>	0,
'3254' =>	0,
'3255' =>	0,
'3256' =>	0,
'3257' =>	0,
'3258' =>	0,
'3259' =>	0,
'33' =>	0,
'331' =>	0,
'3311' =>	0,
'3312' =>	0,
'3313' =>	0,
'3314' =>	0,
'3315' =>	0,
'332' =>	0,
'3321' =>	0,
'3322' =>	0,
'3323' =>	0,
'3324' =>	0,
'333' =>	0,
'3331' =>	0,
'3332' =>	0,
'3333' =>	0,
'3334' =>	0,
'3339' =>	0,
'334' =>	0,
'3341' =>	0,
'3342' =>	0,
'3343' =>	0,
'3344' =>	0,
'335' =>	0,
'3351' =>	0,
'3352' =>	0,
'3353' =>	0,
'3354' =>	0,
'3355' =>	0,
'3359' =>	0,
'34' =>	0,
'341' =>	0,
'3411' =>	0,
'3412' =>	0,
'3413' =>	0,
'342' =>	0,
'3421' =>	0,
'3422' =>	0,
'3423' =>	0,
'343' =>	0,
'3431' =>	0,
'3432' =>	0,
'3433' =>	0,
'3434' =>	0,
'3435' =>	0,
'35' =>	0,
'351' =>	0,
'3511' =>	0,
'3512' =>	0,
'3513' =>	0,
'3514' =>	0,
'352' =>	0,
'3521' =>	0,
'3522' =>	0,
'4' =>	0,
'41' =>	0,
'411' =>	0,
'4110' =>	0,
'412' =>	0,
'4120' =>	0,
'413' =>	0,
'4131' =>	0,
'4132' =>	0,
'42' =>	0,
'421' =>	0,
'4211' =>	0,
'4212' =>	0,
'4213' =>	0,
'4214' =>	0,
'422' =>	0,
'4221' =>	0,
'4222' =>	0,
'4223' =>	0,
'4224' =>	0,
'4225' =>	0,
'4226' =>	0,
'4227' =>	0,
'4229' =>	0,
'43' =>	0,
'431' =>	0,
'4311' =>	0,
'4312' =>	0,
'4313' =>	0,
'432' =>	0,
'4321' =>	0,
'4322' =>	0,
'4323' =>	0,
'44' =>	0,
'441' =>	0,
'4411' =>	0,
'4412' =>	0,
'4413' =>	0,
'4414' =>	0,
'4415' =>	0,
'4416' =>	0,
'4419' =>	0,
'5' =>	0,
'51' =>	0,
'511' =>	0,
'5111' =>	0,
'5112' =>	0,
'5113' =>	0,
'512' =>	0,
'5120' =>	0,
'513' =>	0,
'5131' =>	0,
'5132' =>	0,
'514' =>	0,
'5141' =>	0,
'5142' =>	0,
'515' =>	0,
'5151' =>	0,
'5152' =>	0,
'5153' =>	0,
'516' =>	0,
'5161' =>	0,
'5162' =>	0,
'5163' =>	0,
'5164' =>	0,
'5165' =>	0,
'5169' =>	0,
'52' =>	0,
'521' =>	0,
'5211' =>	0,
'5212' =>	0,
'522' =>	0,
'5221' =>	0,
'5222' =>	0,
'5223' =>	0,
'523' =>	0,
'5230' =>	0,
'524' =>	0,
'5241' =>	0,
'5242' =>	0,
'5243' =>	0,
'5244' =>	0,
'5245' =>	0,
'5246' =>	0,
'5249' =>	0,
'53' =>	0,
'531' =>	0,
'5311' =>	0,
'5312' =>	0,
'532' =>	0,
'5321' =>	0,
'5322' =>	0,
'5329' =>	0,
'54' =>	0,
'541' =>	0,
'5411' =>	0,
'5412' =>	0,
'5413' =>	0,
'5414' =>	0,
'5419' =>	0,
'6' =>	0,
'61' =>	0,
'611' =>	0,
'6111' =>	0,
'6112' =>	0,
'6113' =>	0,
'6114' =>	0,
'612' =>	0,
'6121' =>	0,
'6122' =>	0,
'6123' =>	0,
'6129' =>	0,
'613' =>	0,
'6130' =>	0,
'62' =>	0,
'621' =>	0,
'6210' =>	0,
'622' =>	0,
'6221' =>	0,
'6222' =>	0,
'6223' =>	0,
'6224' =>	0,
'63' =>	0,
'631' =>	0,
'6310' =>	0,
'632' =>	0,
'6320' =>	0,
'633' =>	0,
'6330' =>	0,
'634' =>	0,
'6340' =>	0,
'7' =>	0,
'71' =>	0,
'711' =>	0,
'7111' =>	0,
'7112' =>	0,
'7113' =>	0,
'7114' =>	0,
'7115' =>	0,
'7119' =>	0,
'712' =>	0,
'7121' =>	0,
'7122' =>	0,
'7123' =>	0,
'7124' =>	0,
'7125' =>	0,
'7126' =>	0,
'7127' =>	0,
'713' =>	0,
'7131' =>	0,
'7132' =>	0,
'7133' =>	0,
'72' =>	0,
'721' =>	0,
'7211' =>	0,
'7212' =>	0,
'7213' =>	0,
'7214' =>	0,
'7215' =>	0,
'722' =>	0,
'7221' =>	0,
'7222' =>	0,
'7223' =>	0,
'7224' =>	0,
'723' =>	0,
'7231' =>	0,
'7232' =>	0,
'7233' =>	0,
'7234' =>	0,
'73' =>	0,
'731' =>	0,
'7311' =>	0,
'7312' =>	0,
'7313' =>	0,
'7314' =>	0,
'7315' =>	0,
'7316' =>	0,
'7317' =>	0,
'7318' =>	0,
'7319' =>	0,
'732' =>	0,
'7321' =>	0,
'7322' =>	0,
'7323' =>	0,
'74' =>	0,
'741' =>	0,
'7411' =>	0,
'7412' =>	0,
'7413' =>	0,
'742' =>	0,
'7421' =>	0,
'7422' =>	0,
'75' =>	0,
'751' =>	0,
'7511' =>	0,
'7512' =>	0,
'7513' =>	0,
'7514' =>	0,
'7515' =>	0,
'7516' =>	0,
'752' =>	0,
'7521' =>	0,
'7522' =>	0,
'7523' =>	0,
'753' =>	0,
'7531' =>	0,
'7532' =>	0,
'7533' =>	0,
'7534' =>	0,
'7535' =>	0,
'7536' =>	0,
'754' =>	0,
'7541' =>	0,
'7542' =>	0,
'7543' =>	0,
'7544' =>	0,
'7549' =>	0,
'8' =>	0,
'81' =>	0,
'811' =>	0,
'8111' =>	0,
'8112' =>	0,
'8113' =>	0,
'8114' =>	0,
'812' =>	0,
'8121' =>	0,
'8122' =>	0,
'813' =>	0,
'8131' =>	0,
'8132' =>	0,
'814' =>	0,
'8141' =>	0,
'8142' =>	0,
'8143' =>	0,
'815' =>	0,
'8151' =>	0,
'8152' =>	0,
'8153' =>	0,
'8154' =>	0,
'8155' =>	0,
'8156' =>	0,
'8157' =>	0,
'8159' =>	0,
'816' =>	0,
'8160' =>	0,
'817' =>	0,
'8171' =>	0,
'8172' =>	0,
'818' =>	0,
'8181' =>	0,
'8182' =>	0,
'8183' =>	0,
'8189' =>	0,
'82' =>	0,
'821' =>	0,
'8211' =>	0,
'8212' =>	0,
'8219' =>	0,
'83' =>	0,
'831' =>	0,
'8311' =>	0,
'8312' =>	0,
'832' =>	0,
'8321' =>	0,
'8322' =>	0,
'833' =>	0,
'8331' =>	0,
'8332' =>	0,
'834' =>	0,
'8341' =>	0,
'8342' =>	0,
'8343' =>	0,
'8344' =>	0,
'835' =>	0,
'8350' =>	0,
'9' =>	0,
'91' =>	0,
'911' =>	0,
'9111' =>	0,
'9112' =>	0,
'912' =>	0,
'9121' =>	0,
'9122' =>	0,
'9123' =>	0,
'9129' =>	0,
'92' =>	0,
'921' =>	0,
'9211' =>	0,
'9212' =>	0,
'9213' =>	0,
'9214' =>	0,
'9215' =>	0,
'9216' =>	0,
'93' =>	0,
'931' =>	0,
'9311' =>	0,
'9312' =>	0,
'9313' =>	0,
'932' =>	0,
'9321' =>	0,
'9329' =>	0,
'933' =>	0,
'9331' =>	0,
'9332' =>	0,
'9333' =>	0,
'9334' =>	0,
'94' =>	0,
'941' =>	0,
'9411' =>	0,
'9412' =>	0,
'95' =>	0,
'951' =>	0,
'9510' =>	0,
'952' =>	0,
'9520' =>	0,
'96' =>	0,
'961' =>	0,
'9611' =>	0,
'9612' =>	0,
'9613' =>	0,
'962' =>	0,
'9621' =>	0,
'9622' =>	0,
'9623' =>	0,
'9624' =>	0,
'9629' =>	0,
'0' =>	0,
'01' =>	0,
'011' =>	0,
'0110' =>	0,
'02' =>	0,
'021' =>	0,
'0210' =>	0,
'03' =>	0,
'031' =>	0,
'0310' =>	0,
);

      $currencies = array (
'USD'	=>	1,
'GBP'	=>	1.09,
'EUR'	=>	0.94,
'CNY'	=>	1.42,
'JPY'	=>	1.01,
'ARS'	=>	0.9,
'AUD'	=>	0.82,
'BRL'	=>	0.65,
'CAD'	=>	0.9,
'CLP'	=>	1.03,
'COP'	=>	0.92,
'CRC'	=>	1.04,
'CZK'	=>	1.18,
'DKK'	=>	0.72,
'EGP'	=>	1.39,
'HKD'	=>	1.49,
'HUF'	=>	1.37,
'INR'	=>	1.61,
'IDR'	=>	1.41,
'ILS'	=>	1.02,
'LVL'	=>	1.32,
'LTL'	=>	1.29,
'MYR'	=>	1.44,
'MXN'	=>	1.36,
'NZD'	=>	1.04,
'NOK'	=>	0.38,
'PKR'	=>	1.31,
'PEN'	=>	1.12,
'PHP'	=>	1.36,
'PLN'	=>	1.38,
'RUB'	=>	1.39,
'SAR'	=>	1.36,
'SGD'	=>	1.11,
'ZAR'	=>	1.42,
'KRW'	=>	1.24,
'LKR'	=>	1.39,
'SEK'	=>	0.59,
'CHF'	=>	0.38,
'TWD'	=>	1.40,
'THB'	=>	1.41,
'TRY'	=>	1.16,
'AED'	=>	1.22,
'UAH'	=>	1.5,
'UYU'	=>	0.9,
 );
  
 $workdatabases = array(
    'any' => 0,   
    'CVR_company_entity' => 0,  
    'CVR_QS12' => 0, 
    'CVR_SCImago12' => 0, 
    'CVR_USNewsH12' => 0, 
  );
    
$industryclasses = array (
    'any' =>	0,
    'A' =>	0,
'01' =>	0,
'011' =>	0,
'0111' =>	0,
'0112' =>	0,
'0113' =>	0,
'0114' =>	0,
'0115' =>	0,
'0116' =>	0,
'0119' =>	0,
'012' =>	0,
'0121' =>	0,
'0122' =>	0,
'0123' =>	0,
'0124' =>	0,
'0125' =>	0,
'0126' =>	0,
'0127' =>	0,
'0128' =>	0,
'0129' =>	0,
'013' =>	0,
'0130' =>	0,
'014' =>	0,
'0141' =>	0,
'0142' =>	0,
'0143' =>	0,
'0144' =>	0,
'0145' =>	0,
'0146' =>	0,
'0149' =>	0,
'015' =>	0,
'0150' =>	0,
'016' =>	0,
'0161' =>	0,
'0162' =>	0,
'0163' =>	0,
'0164' =>	0,
'017' =>	0,
'0170' =>	0,
'02' =>	0,
'021' =>	0,
'0210' =>	0,
'022' =>	0,
'0220' =>	0,
'023' =>	0,
'0230' =>	0,
'024' =>	0,
'0240' =>	0,
'03' =>	0,
'031' =>	0,
'0311' =>	0,
'0312' =>	0,
'032' =>	0,
'0321' =>	0,
'0322' =>	0,
'B' =>	0,
'05' =>	0,
'051' =>	0,
'0510' =>	0,
'052' =>	0,
'0520' =>	0,
'06' =>	0,
'061' =>	0,
'0610' =>	0,
'062' =>	0,
'0620' =>	0,
'07' =>	0,
'071' =>	0,
'0710' =>	0,
'072' =>	0,
'0721' =>	0,
'0729' =>	0,
'08' =>	0,
'081' =>	0,
'0810' =>	0,
'089' =>	0,
'0891' =>	0,
'0892' =>	0,
'0893' =>	0,
'0899' =>	0,
'09' =>	0,
'091' =>	0,
'0910' =>	0,
'099' =>	0,
'0990' =>	0,
'C' =>	0,
'10' =>	0,
'101' =>	0,
'1010' =>	0,
'102' =>	0,
'1020' =>	0,
'103' =>	0,
'1030' =>	0,
'104' =>	0,
'1040' =>	0,
'105' =>	0,
'1050' =>	0,
'106' =>	0,
'1061' =>	0,
'1062' =>	0,
'107' =>	0,
'1071' =>	0,
'1072' =>	0,
'1073' =>	0,
'1074' =>	0,
'1075' =>	0,
'1079' =>	0,
'108' =>	0,
'1080' =>	0,
'11' =>	0,
'110' =>	0,
'1101' =>	0,
'1102' =>	0,
'1103' =>	0,
'1104' =>	0,
'12' =>	0,
'120' =>	0,
'1200' =>	0,
'13' =>	0,
'131' =>	0,
'1311' =>	0,
'1312' =>	0,
'1313' =>	0,
'139' =>	0,
'1391' =>	0,
'1392' =>	0,
'1393' =>	0,
'1394' =>	0,
'1399' =>	0,
'14' =>	0,
'141' =>	0,
'1410' =>	0,
'142' =>	0,
'1420' =>	0,
'143' =>	0,
'1430' =>	0,
'15' =>	0,
'151' =>	0,
'1511' =>	0,
'1512' =>	0,
'152' =>	0,
'1520' =>	0,
'16' =>	0,
'161' =>	0,
'1610' =>	0,
'162' =>	0,
'1621' =>	0,
'1622' =>	0,
'1623' =>	0,
'1629' =>	0,
'17' =>	0,
'170' =>	0,
'1701' =>	0,
'1702' =>	0,
'1709' =>	0,
'18' =>	0,
'181' =>	0,
'1811' =>	0,
'1812' =>	0,
'182' =>	0,
'1820' =>	0,
'19' =>	0,
'191' =>	0,
'1910' =>	0,
'192' =>	0,
'1920' =>	0,
'20' =>	0,
'201' =>	0,
'2011' =>	0,
'2012' =>	0,
'2013' =>	0,
'202' =>	0,
'2021' =>	0,
'2022' =>	0,
'2023' =>	0,
'2029' =>	0,
'203' =>	0,
'2030' =>	0,
'21' =>	0,
'210' =>	0,
'2100' =>	0,
'22' =>	0,
'221' =>	0,
'2211' =>	0,
'2219' =>	0,
'222' =>	0,
'2220' =>	0,
'23' =>	0,
'231' =>	0,
'2310' =>	0,
'239' =>	0,
'2391' =>	0,
'2392' =>	0,
'2393' =>	0,
'2394' =>	0,
'2395' =>	0,
'2396' =>	0,
'2399' =>	0,
'24' =>	0,
'241' =>	0,
'2410' =>	0,
'242' =>	0,
'2420' =>	0,
'243' =>	0,
'2431' =>	0,
'2432' =>	0,
'25' =>	0,
'251' =>	0,
'2511' =>	0,
'2512' =>	0,
'2513' =>	0,
'252' =>	0,
'2520' =>	0,
'259' =>	0,
'2591' =>	0,
'2592' =>	0,
'2593' =>	0,
'2599' =>	0,
'26' =>	0,
'261' =>	0,
'2610' =>	0,
'262' =>	0,
'2620' =>	0,
'263' =>	0,
'2630' =>	0,
'264' =>	0,
'2640' =>	0,
'265' =>	0,
'2651' =>	0,
'2652' =>	0,
'266' =>	0,
'2660' =>	0,
'267' =>	0,
'2670' =>	0,
'268' =>	0,
'2680' =>	0,
'27' =>	0,
'271' =>	0,
'2710' =>	0,
'272' =>	0,
'2720' =>	0,
'273' =>	0,
'2731' =>	0,
'2732' =>	0,
'2733' =>	0,
'274' =>	0,
'2740' =>	0,
'275' =>	0,
'2750' =>	0,
'279' =>	0,
'2790' =>	0,
'28' =>	0,
'281' =>	0,
'2811' =>	0,
'2812' =>	0,
'2813' =>	0,
'2814' =>	0,
'2815' =>	0,
'2816' =>	0,
'2817' =>	0,
'2818' =>	0,
'2819' =>	0,
'282' =>	0,
'2821' =>	0,
'2822' =>	0,
'2823' =>	0,
'2824' =>	0,
'2825' =>	0,
'2826' =>	0,
'2829' =>	0,
'29' =>	0,
'291' =>	0,
'2910' =>	0,
'292' =>	0,
'2920' =>	0,
'293' =>	0,
'2930' =>	0,
'30' =>	0,
'301' =>	0,
'3011' =>	0,
'3012' =>	0,
'302' =>	0,
'3020' =>	0,
'303' =>	0,
'3030' =>	0,
'304' =>	0,
'3040' =>	0,
'309' =>	0,
'3091' =>	0,
'3092' =>	0,
'3099' =>	0,
'31' =>	0,
'310' =>	0,
'3100' =>	0,
'32' =>	0,
'321' =>	0,
'3211' =>	0,
'3212' =>	0,
'322' =>	0,
'3220' =>	0,
'323' =>	0,
'3230' =>	0,
'324' =>	0,
'3240' =>	0,
'325' =>	0,
'3250' =>	0,
'329' =>	0,
'3290' =>	0,
'33' =>	0,
'331' =>	0,
'3311' =>	0,
'3312' =>	0,
'3313' =>	0,
'3314' =>	0,
'3315' =>	0,
'3319' =>	0,
'332' =>	0,
'3320' =>	0,
'D' =>	0,
'35' =>	0,
'351' =>	0,
'3510' =>	0,
'352' =>	0,
'3520' =>	0,
'353' =>	0,
'3530' =>	0,
'E' =>	0,
'36' =>	0,
'360' =>	0,
'3600' =>	0,
'37' =>	0,
'370' =>	0,
'3700' =>	0,
'38' =>	0,
'381' =>	0,
'3811' =>	0,
'3812' =>	0,
'382' =>	0,
'3821' =>	0,
'3822' =>	0,
'383' =>	0,
'3830' =>	0,
'39' =>	0,
'390' =>	0,
'3900' =>	0,
'F' =>	0,
'41' =>	0,
'410' =>	0,
'4100' =>	0,
'42' =>	0,
'421' =>	0,
'4210' =>	0,
'422' =>	0,
'4220' =>	0,
'429' =>	0,
'4290' =>	0,
'43' =>	0,
'431' =>	0,
'4311' =>	0,
'4312' =>	0,
'432' =>	0,
'4321' =>	0,
'4322' =>	0,
'4329' =>	0,
'433' =>	0,
'4330' =>	0,
'439' =>	0,
'4390' =>	0,
'G' =>	0,
'45' =>	0,
'451' =>	0,
'4510' =>	0,
'452' =>	0,
'4520' =>	0,
'453' =>	0,
'4530' =>	0,
'454' =>	0,
'4540' =>	0,
'46' =>	0,
'461' =>	0,
'4610' =>	0,
'462' =>	0,
'4620' =>	0,
'463' =>	0,
'4630' =>	0,
'464' =>	0,
'4641' =>	0,
'4649' =>	0,
'465' =>	0,
'4651' =>	0,
'4652' =>	0,
'4653' =>	0,
'4659' =>	0,
'466' =>	0,
'4661' =>	0,
'4662' =>	0,
'4663' =>	0,
'4669' =>	0,
'469' =>	0,
'4690' =>	0,
'47' =>	0,
'471' =>	0,
'4711' =>	0,
'4719' =>	0,
'472' =>	0,
'4721' =>	0,
'4722' =>	0,
'4723' =>	0,
'473' =>	0,
'4730' =>	0,
'474' =>	0,
'4741' =>	0,
'4742' =>	0,
'475' =>	0,
'4751' =>	0,
'4752' =>	0,
'4753' =>	0,
'4759' =>	0,
'476' =>	0,
'4761' =>	0,
'4762' =>	0,
'4763' =>	0,
'4764' =>	0,
'477' =>	0,
'4771' =>	0,
'4772' =>	0,
'4773' =>	0,
'4774' =>	0,
'478' =>	0,
'4781' =>	0,
'4782' =>	0,
'4789' =>	0,
'479' =>	0,
'4791' =>	0,
'4799' =>	0,
'H' =>	0,
'49' =>	0,
'491' =>	0,
'4911' =>	0,
'4912' =>	0,
'492' =>	0,
'4921' =>	0,
'4922' =>	0,
'4923' =>	0,
'493' =>	0,
'4930' =>	0,
'50' =>	0,
'501' =>	0,
'5011' =>	0,
'5012' =>	0,
'502' =>	0,
'5021' =>	0,
'5022' =>	0,
'51' =>	0,
'511' =>	0,
'5110' =>	0,
'512' =>	0,
'5120' =>	0,
'52' =>	0,
'521' =>	0,
'5210' =>	0,
'522' =>	0,
'5221' =>	0,
'5222' =>	0,
'5223' =>	0,
'5224' =>	0,
'5229' =>	0,
'53' =>	0,
'531' =>	0,
'5310' =>	0,
'532' =>	0,
'5320' =>	0,
'I' =>	0,
'55' =>	0,
'551' =>	0,
'5510' =>	0,
'552' =>	0,
'5520' =>	0,
'559' =>	0,
'5590' =>	0,
'56' =>	0,
'561' =>	0,
'5610' =>	0,
'562' =>	0,
'5621' =>	0,
'5629' =>	0,
'563' =>	0,
'5630' =>	0,
'J' =>	0,
'58' =>	0,
'581' =>	0,
'5811' =>	0,
'5812' =>	0,
'5813' =>	0,
'5819' =>	0,
'582' =>	0,
'5820' =>	0,
'59' =>	0,
'591' =>	0,
'5911' =>	0,
'5912' =>	0,
'5913' =>	0,
'5914' =>	0,
'592' =>	0,
'5920' =>	0,
'60' =>	0,
'601' =>	0,
'6010' =>	0,
'602' =>	0,
'6020' =>	0,
'61' =>	0,
'611' =>	0,
'6110' =>	0,
'612' =>	0,
'6120' =>	0,
'613' =>	0,
'6130' =>	0,
'619' =>	0,
'6190' =>	0,
'62' =>	0,
'620' =>	0,
'6201' =>	0,
'6202' =>	0,
'6209' =>	0,
'63' =>	0,
'631' =>	0,
'6311' =>	0,
'6312' =>	0,
'639' =>	0,
'6391' =>	0,
'6399' =>	0,
'K' =>	0,
'64' =>	0,
'641' =>	0,
'6411' =>	0,
'6419' =>	0,
'642' =>	0,
'6420' =>	0,
'643' =>	0,
'6430' =>	0,
'649' =>	0,
'6491' =>	0,
'6492' =>	0,
'6499' =>	0,
'65' =>	0,
'651' =>	0,
'6511' =>	0,
'6512' =>	0,
'652' =>	0,
'6520' =>	0,
'653' =>	0,
'6530' =>	0,
'66' =>	0,
'661' =>	0,
'6611' =>	0,
'6612' =>	0,
'6619' =>	0,
'662' =>	0,
'6621' =>	0,
'6622' =>	0,
'6629' =>	0,
'663' =>	0,
'6630' =>	0,
'L' =>	0,
'68' =>	0,
'681' =>	0,
'6810' =>	0,
'682' =>	0,
'6820' =>	0,
'M' =>	0,
'69' =>	0,
'691' =>	0,
'6910' =>	0,
'692' =>	0,
'6920' =>	0,
'70' =>	0,
'701' =>	0,
'7010' =>	0,
'702' =>	0,
'7020' =>	0,
'71' =>	0,
'711' =>	0,
'7110' =>	0,
'712' =>	0,
'7120' =>	0,
'72' =>	0,
'721' =>	0,
'7210' =>	0,
'722' =>	0,
'7220' =>	0,
'73' =>	0,
'731' =>	0,
'7310' =>	0,
'732' =>	0,
'7320' =>	0,
'74' =>	0,
'741' =>	0,
'7410' =>	0,
'742' =>	0,
'7420' =>	0,
'749' =>	0,
'7490' =>	0,
'75' =>	0,
'750' =>	0,
'7500' =>	0,
'N' =>	0,
'77' =>	0,
'771' =>	0,
'7710' =>	0,
'772' =>	0,
'7721' =>	0,
'7722' =>	0,
'7729' =>	0,
'773' =>	0,
'7730' =>	0,
'774' =>	0,
'7740' =>	0,
'78' =>	0,
'781' =>	0,
'7810' =>	0,
'782' =>	0,
'7820' =>	0,
'783' =>	0,
'7830' =>	0,
'79' =>	0,
'791' =>	0,
'7911' =>	0,
'7912' =>	0,
'799' =>	0,
'7990' =>	0,
'80' =>	0,
'801' =>	0,
'8010' =>	0,
'802' =>	0,
'8020' =>	0,
'803' =>	0,
'8030' =>	0,
'81' =>	0,
'811' =>	0,
'8110' =>	0,
'812' =>	0,
'8121' =>	0,
'8129' =>	0,
'813' =>	0,
'8130' =>	0,
'82' =>	0,
'821' =>	0,
'8211' =>	0,
'8219' =>	0,
'822' =>	0,
'8220' =>	0,
'823' =>	0,
'8230' =>	0,
'829' =>	0,
'8291' =>	0,
'8292' =>	0,
'8299' =>	0,
'O' =>	0,
'84' =>	0,
'841' =>	0,
'8411' =>	0,
'8412' =>	0,
'8413' =>	0,
'842' =>	0,
'8421' =>	0,
'8422' =>	0,
'8423' =>	0,
'843' =>	0,
'8430' =>	0,
'P' =>	0,
'85' =>	0,
'851' =>	0,
'8510' =>	0,
'852' =>	0,
'8521' =>	0,
'8522' =>	0,
'853' =>	0,
'8530' =>	0,
'854' =>	0,
'8541' =>	0,
'8542' =>	0,
'8549' =>	0,
'855' =>	0,
'8550' =>	0,
'Q' =>	0,
'86' =>	0,
'861' =>	0,
'8610' =>	0,
'862' =>	0,
'8620' =>	0,
'869' =>	0,
'8690' =>	0,
'87' =>	0,
'871' =>	0,
'8710' =>	0,
'872' =>	0,
'8720' =>	0,
'873' =>	0,
'8730' =>	0,
'879' =>	0,
'8790' =>	0,
'88' =>	0,
'881' =>	0,
'8810' =>	0,
'889' =>	0,
'8890' =>	0,
'R' =>	0,
'90' =>	0,
'900' =>	0,
'9000' =>	0,
'91' =>	0,
'910' =>	0,
'9101' =>	0,
'9102' =>	0,
'9103' =>	0,
'92' =>	0,
'920' =>	0,
'9200' =>	0,
'93' =>	0,
'931' =>	0,
'9311' =>	0,
'9312' =>	0,
'9319' =>	0,
'932' =>	0,
'9321' =>	0,
'9329' =>	0,
'S' =>	0,
'94' =>	0,
'941' =>	0,
'9411' =>	0,
'9412' =>	0,
'942' =>	0,
'9420' =>	0,
'949' =>	0,
'9491' =>	0,
'9492' =>	0,
'9499' =>	0,
'95' =>	0,
'951' =>	0,
'9511' =>	0,
'9512' =>	0,
'952' =>	0,
'9521' =>	0,
'9522' =>	0,
'9523' =>	0,
'9524' =>	0,
'9529' =>	0,
'96' =>	0,
'960' =>	0,
'9601' =>	0,
'9602' =>	0,
'9603' =>	0,
'9609' =>	0,
'T' =>	0,
'97' =>	0,
'970' =>	0,
'9700' =>	0,
'98' =>	0,
'981' =>	0,
'9810' =>	0,
'982' =>	0,
'9820' =>	0,
'U' =>	0,
'99' =>	0,
'990' =>	0,
'9900' =>	0,
);

$languages = array (
"any" => 0,
"abk" => 0,
"aar" => 0,
"afr" => 0,
"aka" => 0,
"sqi" => 0,
"gsw" => 0,
"amh" => 0,
"ara" => 0,
"arg" => 0,
"hye" => 0,
"asm" => 0,
"ava" => 0,
"ave" => 0,
"aym" => 0,
"aze" => 0,
"bam" => 0,
"bak" => 0,
"eus" => 0,
"bel" => 0,
"ben" => 0,
"bih" => 0,
"bis" => 0,
"bjn" => 0,
"bos" => 0,
"bre" => 0,
"bul" => 0,
"mya" => 0,
"cat" => 0,
"cha" => 0,
"che" => 0,
"nya" => 0,
"cmn" => 0,
"cdo" => 0,
"cjy" => 0,
"cpx" => 0,
"czh" => 0,
"czo" => 0,
"gan" => 0,
"hak" => 0,
"hsn" => 0,
"mnp" => 0,
"nan" => 0,
"wuu" => 0,
"yue" => 0,
"chv" => 0,
"cor" => 0,
"cos" => 0,
"cre" => 0,
"hrv" => 0,
"ces" => 0,
"dan" => 0,
"day" => 0,
"div" => 0,
"nld" => 0,
"dzo" => 0,
"eng" => 0,
"epo" => 0,
"est" => 0,
"ewe" => 0,
"fao" => 0,
"fij" => 0,
"fin" => 0,
"fra" => 0,
"ful" => 0,
"glg" => 0,
"kat" => 0,
"deu" => 0,
"ell" => 0,
"grn" => 0,
"guj" => 0,
"hat" => 0,
"hau" => 0,
"heb" => 0,
"her" => 0,
"hin" => 0,
"hmo" => 0,
"hun" => 0,
"ina" => 0,
"ind" => 0,
"ile" => 0,
"gle" => 0,
"ibo" => 0,
"ipk" => 0,
"ido" => 0,
"isl" => 0,
"ita" => 0,
"iku" => 0,
"jpn" => 0,
"jav" => 0,
"kal" => 0,
"kan" => 0,
"kau" => 0,
"kas" => 0,
"kaz" => 0,
"khm" => 0,
"kik" => 0,
"kin" => 0,
"kir" => 0,
"kom" => 0,
"kon" => 0,
"kor" => 0,
"kur" => 0,
"kua" => 0,
"lat" => 0,
"ltz" => 0,
"lug" => 0,
"lim" => 0,
"lin" => 0,
"lao" => 0,
"lit" => 0,
"lub" => 0,
"lav" => 0,
"glv" => 0,
"mkd" => 0,
"mlg" => 0,
"msa" => 0,
"mal" => 0,
"mlt" => 0,
"mri" => 0,
"mar" => 0,
"mah" => 0,
"mon" => 0,
"nau" => 0,
"nav" => 0,
"nob" => 0,
"nde" => 0,
"nep" => 0,
"ndo" => 0,
"nno" => 0,
"nor" => 0,
"iii" => 0,
"nbl" => 0,
"oci" => 0,
"oji" => 0,
"chu" => 0,
"orm" => 0,
"ori" => 0,
"oss" => 0,
"pan" => 0,
"pli" => 0,
"fas" => 0,
"pol" => 0,
"pus" => 0,
"por" => 0,
"que" => 0,
"roh" => 0,
"run" => 0,
"ron" => 0,
"rus" => 0,
"san" => 0,
"srd" => 0,
"snd" => 0,
"sme" => 0,
"smo" => 0,
"sag" => 0,
"srp" => 0,
"gla" => 0,
"sna" => 0,
"sin" => 0,
"slk" => 0,
"slv" => 0,
"som" => 0,
"sot" => 0,
"spa" => 0,
"sun" => 0,
"swa" => 0,
"ssw" => 0,
"swe" => 0,
"tam" => 0,
"tel" => 0,
"tgk" => 0,
"tha" => 0,
"tir" => 0,
"bod" => 0,
"tuk" => 0,
"tgl" => 0,
"tsn" => 0,
"ton" => 0,
"tur" => 0,
"tso" => 0,
"tat" => 0,
"twi" => 0,
"tah" => 0,
"uig" => 0,
"ukr" => 0,
"urd" => 0,
"uzb" => 0,
"ven" => 0,
"vie" => 0,
"vol" => 0,
"wln" => 0,
"cym" => 0,
"wol" => 0,
"fry" => 0,
"xho" => 0,
"yid" => 0,
"yor" => 0,
"zha" => 0,
"zul" => 0,
);

$langfamilies = array (
"abk" => array ("Northwest Caucasian","Abazgi","",""),
"aar" => array ("Afro-Asiatic","Cushitic","East",""),
"afr" => array ("Indo-European","Germanic","West","Dutch"),
"aka" => array ("Niger–Congo","Atlantic-Congo","Kwa","Tano"),
"sqi" => array ("Indo-European","","",""),
"gsw" => array ("Indo-European","Germanic","West","Ober"),
"amh" => array ("Afro-Asiatic","Semitic","South","West"),
"ara" => array ("Afro-Asiatic","Semitic","Central","Arabic"),
"arg" => array ("Indo-European","Romance","Iberian",""),
"hye" => array ("Indo-European","","",""),
"asm" => array ("Indo-European","Indo-Aryan","East",""),
"ava" => array ("Northeast Caucasian","Avar-Indic","",""),
"ave" => array ("Indo-European","Iranian","East","death"),
"aym" => array ("Aymaran","","",""),
"aze" => array ("Turkic","Oghuz","",""),
"bam" => array ("Niger–Congo","Mande","West","Central"),
"bak" => array ("Turkic","Kipchak","",""),
"eus" => array ("Language isolate","","",""),
"bel" => array ("Indo-European","Slavic","East",""),
"ben" => array ("Indo-European","Indo-Aryan","East",""),
"bih" => array ("Indo-European","Indo-Aryan","East",""),
"bis" => array ("Creole","","","eng"),
"bjn" => array ("Austronesian","Malayo-Polynesian","Nuclear","Malayo-Sumbawan"),
"bos" => array ("Indo-European","Slavic","South","Serbocroate"),
"bre" => array ("Indo-European","Celtic","Insular","Brythonic"),
"bul" => array ("Indo-European","Slavic","South","Bulgarian"),
"mya" => array ("Sino-Tibetan","Tibeto-Burman","Lolo-Burmese","Burmese"),
"cat" => array ("Indo-European","Romance","Gallo-Iberian","Occitano-Romance"),
"cha" => array ("Austronesian","Malayo-Polynesian","Nuclear","Sunda-Sulawesi"),
"che" => array ("Northeast Caucasian","Nakh","Vainakh",""),
"nya" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"cmn" => array ("Sino-Tibetan","Sinitic","North-Central","Mandarin"),
"cdo" => array ("Sino-Tibetan","Sinitic","South","Min"),
"cjy" => array ("Sino-Tibetan","Sinitic","North-Central","Mandarin"),
"cpx" => array ("Sino-Tibetan","Sinitic","South","Min"),
"czh" => array ("Sino-Tibetan","Sinitic","North-Central","Mandarin"),
"czo" => array ("Sino-Tibetan","Sinitic","South","Min"),
"gan" => array ("Sino-Tibetan","Sinitic","North-Central",""),
"hak" => array ("Sino-Tibetan","Sinitic","South",""),
"hsn" => array ("Sino-Tibetan","Sinitic","North-Central",""),
"mnp" => array ("Sino-Tibetan","Sinitic","South","Min"),
"nan" => array ("Sino-Tibetan","Sinitic","South","Min"),
"wuu" => array ("Sino-Tibetan","Sinitic","South",""),
"yue" => array ("Sino-Tibetan","Sinitic","South",""),
"chv" => array ("Turkic","Oghur","",""),
"cor" => array ("Indo-European","Celtic","Insular","Brythonic"),
"cos" => array ("Indo-European","Romance","Italo-Dalmatian","Tuscan"),
"cre" => array ("Algic","Algonquian","",""),
"hrv" => array ("Indo-European","Slavic","South","Serbocroate"),
"ces" => array ("Indo-European","Slavic","West","Czechoslovak"),
"dan" => array ("Indo-European","Germanic","North","East"),
"day" => array ("Austronesian","Malayo-Polynesian","Indo-Melanesian",""),
"div" => array ("Indo-European","Indo-Aryan","South","Insular"),
"nld" => array ("Indo-European","Germanic","West","Dutch"),
"dzo" => array ("Sino-Tibetan","Tibeto-Burman","Tibetan",""),
"eng" => array ("Indo-European","Germanic","West","Anglo-Frisian"),
"epo" => array ("Constructed","","",""),
"est" => array ("Uralic","Finnic","",""),
"ewe" => array ("Niger–Congo","Atlantic-Congo","Volta-Niger",""),
"fao" => array ("Indo-European","Germanic","North","West"),
"fij" => array ("Austronesian","Malayo-Polynesian","Oceanic","Central Pacific"),
"fin" => array ("Uralic","Finnic","",""),
"fra" => array ("Indo-European","Romance","Gallo-Iberian","Gallo-Rhaetian"),
"ful" => array ("Niger–Congo","Atlantic-Congo","Senegambian",""),
"glg" => array ("Indo-European","Romance","Gallo-Iberian","West Iberian"),
"kat" => array ("South Caucasian","Karto-Zan","",""),
"deu" => array ("Indo-European","Germanic","West","Ober"),
"ell" => array ("Indo-European","Greek","",""),
"grn" => array ("Tupian","Tupí-Guaraní","",""),
"guj" => array ("Indo-European","Indo-Aryan","Western",""),
"hat" => array ("Creole","","","fra"),
"hau" => array ("Afro-Asiatic","Chadic","West",""),
"heb" => array ("Afro-Asiatic","Semitic","Central","Northwest"),
"her" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"hin" => array ("Indo-European","Indo-Aryan","Central","Western"),
"hmo" => array ("Austronesian","Malayo-Polynesian","Oceanic","West"),
"hun" => array ("Uralic","Ugric","",""),
"ina" => array ("Constructed","","",""),
"ind" => array ("Austronesian","Malayo-Polynesian","Nuclear","Sunda-Sulawesi"),
"ile" => array ("Constructed","","",""),
"gle" => array ("Indo-European","Celtic","Insular","Goidelic"),
"ibo" => array ("Niger–Congo","Atlantic-Congo","Volta-Niger",""),
"ipk" => array ("Eskimo–Aleut","Eskimo","Inuit",""),
"ido" => array ("Constructed","","",""),
"isl" => array ("Indo-European","Germanic","North","West"),
"ita" => array ("Indo-European","Romance","Italo-Dalmatian","Tuscan"),
"iku" => array ("Eskimo–Aleut","Eskimo","Inuit",""),
"jpn" => array ("Japonic","","",""),
"jav" => array ("Austronesian","Malayo-Polynesian","Nuclear",""),
"kal" => array ("Eskimo–Aleut","Eskimo","Inuit",""),
"kan" => array ("Dravidian","Southern","Tamil-Kannada",""),
"kau" => array ("Nilo-Saharan","Saharan","West",""),
"kas" => array ("Indo-European","Indo-Aryan","Dardic",""),
"kaz" => array ("Turkic","Kipchak","Kipchak-Nogay",""),
"khm" => array ("Austro-Asiatic","Nuclear Mon-Khmer","",""),
"kik" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"kin" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"kir" => array ("Turkic","Kipchak","South",""),
"kom" => array ("Uralic","Permic","",""),
"kon" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"kor" => array ("Language isolate","","",""),
"kur" => array ("Indo-European","Iranian","West","North-West"),
"kua" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"lat" => array ("Indo-European","Romance","","death"),
"ltz" => array ("Indo-European","Germanic","West","Ober"),
"lug" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"lim" => array ("Indo-European","Germanic","West","Dutch"),
"lin" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"lao" => array ("Tai–Kadai","Tai","South-West",""),
"lit" => array ("Indo-European","Baltic","East",""),
"lub" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"lav" => array ("Indo-European","Baltic","East",""),
"glv" => array ("Indo-European","Celtic","Insular","Goidelic"),
"mkd" => array ("Indo-European","Slavic","South","Bulgarian"),
"mlg" => array ("Austronesian","Malayo-Polynesian","Barito","East"),
"msa" => array ("Austronesian","Malayo-Polynesian","Nuclear","Malayo-Sumbawan"),
"mal" => array ("Dravidian","Southern","Tamil-Kannada","Tamil-Malayalam"),
"mlt" => array ("Afro-Asiatic","Semitic","Central","Arabic"),
"mri" => array ("Austronesian","Malayo-Polynesian","Oceanic","Polynesian"),
"mar" => array ("Indo-European","Indo-Aryan","Southern",""),
"mah" => array ("Austronesian","Malayo-Polynesian","Oceanic","Central-East"),
"mon" => array ("Mongolic","Central","",""),
"nau" => array ("Austronesian","Malayo-Polynesian","Oceanic","Micronesian"),
"nav" => array ("Dené–Yeniseian","Athabaskan","South",""),
"nob" => array ("Indo-European","Germanic","North","East"),
"nde" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"nep" => array ("Indo-European","Indo-Aryan","North",""),
"ndo" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"nno" => array ("Indo-European","Germanic","North","West"),
"nor" => array ("Indo-European","Germanic","North","East"),
"iii" => array ("Sino-Tibetan","Tibeto-Burman","Lolo-Burmese","Loloish"),
"nbl" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"oci" => array ("Indo-European","Romance","Gallo-Iberian","Occitano-Romance"),
"oji" => array ("Algic","Algonquian","",""),
"chu" => array ("Indo-European","Slavic","South","death"),
"orm" => array ("Afro-Asiatic","Cushitic","Lowland East",""),
"ori" => array ("Indo-European","Indo-Aryan","Eastern",""),
"oss" => array ("Indo-European","Iranian","East","North-East"),
"pan" => array ("Indo-European","Indo-Aryan","North-West",""),
"pli" => array ("Indo-European","Indo-Aryan","","death"),
"fas" => array ("Indo-European","Iranian","West","South-West"),
"pol" => array ("Indo-European","Slavic","West",""),
"pus" => array ("Indo-European","Iranian","East","North-East"),
"por" => array ("Indo-European","Romance","Gallo-Iberian","West Iberian"),
"que" => array ("Quechuan","","",""),
"roh" => array ("Indo-European","Romance","Gallo-Iberian","Gallo-Rhaetian"),
"run" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"ron" => array ("Indo-European","Romance","East",""),
"rus" => array ("Indo-European","Slavic","East",""),
"san" => array ("Indo-European","Indo-Aryan","","death"),
"srd" => array ("Indo-European","Romance","",""),
"snd" => array ("Indo-European","Indo-Aryan","North-West",""),
"sme" => array ("Uralic","Sami","West",""),
"smo" => array ("Austronesian","Malayo-Polynesian","Oceanic","Polynesian"),
"sag" => array ("Creole","","",""),
"srp" => array ("Indo-European","Slavic","South","Serbocroate"),
"gla" => array ("Indo-European","Celtic","Insular","Goidelic"),
"sna" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"sin" => array ("Indo-European","Indo-Aryan","South","Insular"),
"slk" => array ("Indo-European","Slavic","West","Czechoslovak"),
"slv" => array ("Indo-European","Slavic","South",""),
"som" => array ("Afro-Asiatic","Cushitic","East",""),
"sot" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"spa" => array ("Indo-European","Romance","Gallo-Iberian","West Iberian"),
"sun" => array ("Austronesian","Malayo-Polynesian","Nuclear","Malayo-Sumbawan"),
"swa" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"ssw" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"swe" => array ("Indo-European","Germanic","North","East"),
"tam" => array ("Dravidian","Southern","Tamil-Kannada","Tamil-Malayalam"),
"tel" => array ("Dravidian","Central","",""),
"tgk" => array ("Indo-European","Iranian","West","South-West"),
"tha" => array ("Tai–Kadai","","",""),
"tir" => array ("Afro-Asiatic","Semitic","South","Ethiopian"),
"bod" => array ("Sino-Tibetan","Tibeto-Burman","Tibetan","Central"),
"tuk" => array ("Turkic","Oghuz","",""),
"tgl" => array ("Austronesian","Malayo-Polynesian","Philippine","Central"),
"tsn" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"ton" => array ("Austronesian","Malayo-Polynesian","Oceanic","Polynesian"),
"tur" => array ("Turkic","Oghuz","",""),
"tso" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"tat" => array ("Turkic","Kipchak","Kipchak-Bolgar",""),
"twi" => array ("Niger–Congo","Atlantic-Congo","Kwa","Tano"),
"tah" => array ("Austronesian","Malayo-Polynesian","Oceanic","Polynesian"),
"uig" => array ("Turkic","Uyghur","East",""),
"ukr" => array ("Indo-European","Slavic","East",""),
"urd" => array ("Indo-European","Indo-Aryan","Central","West"),
"uzb" => array ("Turkic","Uyghur","West",""),
"ven" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"vie" => array ("Austro-Asiatic","Vietic","Viet-Muong",""),
"vol" => array ("Constructed","","",""),
"wln" => array ("Indo-European","Romance","Gallo-Iberian","Gallo-Rhaetian"),
"cym" => array ("Indo-European","Celtic","Insular","Brythonic"),
"wol" => array ("Niger–Congo","Atlantic-Congo","Senegambian",""),
"fry" => array ("Indo-European","Germanic","West","Anglo-Frisian"),
"xho" => array ("Niger–Congo","","",""),
"yid" => array ("Indo-European","Germanic","West","Ober"),
"yor" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
"zha" => array ("Tai–Kadai","Tai","",""),
"zul" => array ("Niger–Congo","Atlantic-Congo","Benue-Congo","Bantu"),
    );

// ToDo: future array for grade conversions
$langgrades = array (
'IELTS' => array (100,'IELTS','IELTS', 60),
    );

$langdbs = array (
    "weber" => 0,
    "forbes" => 0,
    "first" => 0,
    "second" => 0,
    "combined" => 0,
    );

$resfields = array (
'any' => array ( 0, "any"),
'1' => array ( 0, "engineering"),
'2' => array ( 0, "engineering"),
'3' => array ( 0, "economics"),
'4' => array ( 0, "environmental"),
'5' => array ( 0, "agriculture"),
'6' => array ( 0, "agriculture"),
'7' => array ( 0, "agriculture"),
'8' => array ( 0, "agriculture"),
'9' => array ( 0, "agriculture"),
'10' => array ( 0, "infectious"),
'11' => array ( 0, "biomed"),
'12' => array ( 0, "biomed"),
'13' => array ( 0, "clinmed"),
'14' => array ( 0, "social"),
'15' => array ( 0, "multi"),
'16' => array ( 0, "multi"),
'17' => array ( 0, "multi"),
'18' => array ( 0, "space"),
'19' => array ( 0, "computer"),
'20' => array ( 0, "neuro"),
'21' => array ( 0, "molbio"),
'22' => array ( 0, "molbio"),
'23' => array ( 0, "ecology"),
'24' => array ( 0, "biomed"),
'25' => array ( 0, "biomed"),
'26' => array ( 0, "molbio"),
'27' => array ( 0, "microbio"),
'28' => array ( 0, "economics"),
'29' => array ( 0, "economics"),
'30' => array ( 0, "clinmed"),
'31' => array ( 0, "biomed"),
'32' => array ( 0, "biomed"),
'33' => array ( 0, "chemistry"),
'34' => array ( 0, "chemistry"),
'35' => array ( 0, "chemistry"),
'36' => array ( 0, "chemistry"),
'37' => array ( 0, "chemistry"),
'38' => array ( 0, "chemistry"),
'39' => array ( 0, "chemistry"),
'40' => array ( 0, "chemistry"),
'41' => array ( 0, "neuro"),
'42' => array ( 0, "social"),
'43' => array ( 0, "computer"),
'44' => array ( 0, "computer"),
'45' => array ( 0, "computer"),
'46' => array ( 0, "computer"),
'47' => array ( 0, "computer"),
'48' => array ( 0, "computer"),
'49' => array ( 0, "computer"),
'50' => array ( 0, "computer"),
'51' => array ( 0, "computer"),
'52' => array ( 0, "engineering"),
'53' => array ( 0, "social"),
'54' => array ( 0, "clinmed"),
'55' => array ( 0, "chemistry"),
'56' => array ( 0, "social"),
'57' => array ( 0, "clinmed"),
'58' => array ( 0, "clinmed"),
'59' => array ( 0, "infectious"),
'60' => array ( 0, "molbio"),
'61' => array ( 0, "ecology"),
'62' => array ( 0, "economics"),
'63' => array ( 0, "social"),
'64' => array ( 0, "genmed"),
'65' => array ( 0, "social"),
'66' => array ( 0, "material"),
'67' => array ( 0, "clinmed"),
'68' => array ( 0, "clinmed"),
'69' => array ( 0, "biomed"),
'70' => array ( 0, "material"),
'71' => array ( 0, "engineering"),
'72' => array ( 0, "engineering"),
'73' => array ( 0, "clinmed"),
'74' => array ( 0, "chemistry"),
'75' => array ( 0, "engineering"),
'76' => array ( 0, "engineering"),
'77' => array ( 0, "environmental"),
'78' => array ( 0, "geosciences"),
'79' => array ( 0, "engineering"),
'80' => array ( 0, "engineering"),
'81' => array ( 0, "engineering"),
'82' => array ( 0, "engineering"),
'83' => array ( 0, "engineering"),
'84' => array ( 0, "environmental"),
'85' => array ( 0, "environmental"),
'86' => array ( 0, "animal"),
'87' => array ( 0, "environmental"),
'88' => array ( 0, "social"),
'89' => array ( 0, "multi"),
'90' => array ( 0, "multi"),
'91' => array ( 0, "multi"),
'92' => array ( 0, "ecology"),
'93' => array ( 0, "multi"),
'94' => array ( 0, "animal"),
'95' => array ( 0, "agriculture"),
'96' => array ( 0, "plantanimal"),
'97' => array ( 0, "clinmed"),
'98' => array ( 0, "molbio"),
'99' => array ( 0, "geosciences"),
'100' => array ( 0, "geosciences"),
'101' => array ( 0, "geosciences"),
'102' => array ( 0, "geosciences"),
'103' => array ( 0, "geosciences"),
'104' => array ( 0, "geosciences"),
'105' => array ( 0, "neuro"),
'106' => array ( 0, "neuro"),
'107' => array ( 0, "genmed"),
'108' => array ( 0, "genmed"),
'109' => array ( 0, "clinmed"),
'110' => array ( 0, "multi"),
'111' => array ( 0, "multi"),
'112' => array ( 0, "multi"),
'113' => array ( 0, "agriculture"),
'114' => array ( 0, "social"),
'115' => array ( 0, "geosciences"),
'116' => array ( 0, "infectious"),
'117' => array ( 0, "economics"),
'118' => array ( 0, "infectious"),
'119' => array ( 0, "social"),
'120' => array ( 0, "chemistry"),
'121' => array ( 0, "agriculture"),
'122' => array ( 0, "social"),
'123' => array ( 0, "multi"),
'124' => array ( 0, "social"),
'125' => array ( 0, "environmental"),
'126' => array ( 0, "multi"),
'127' => array ( 0, "economics"),
'128' => array ( 0, "animal"),
'129' => array ( 0, "material"),
'130' => array ( 0, "material"),
'131' => array ( 0, "material"),
'132' => array ( 0, "material"),
'133' => array ( 0, "material"),
'134' => array ( 0, "material"),
'135' => array ( 0, "material"),
'136' => array ( 0, "material"),
'137' => array ( 0, "material"),
'138' => array ( 0, "biomed"),
'139' => array ( 0, "mathematics"),
'140' => array ( 0, "mathematics"),
'141' => array ( 0, "engineering"),
'142' => array ( 0, "engineering"),
'143' => array ( 0, "engineering"),
'144' => array ( 0, "genmed"),
'145' => array ( 0, "genmed"),
'146' => array ( 0, "biomed"),
'147' => array ( 0, "genmed"),
'148' => array ( 0, "biomed"),
'149' => array ( 0, "biomed"),
'150' => array ( 0, "material"),
'151' => array ( 0, "material"),
'152' => array ( 0, "geosciences"),
'153' => array ( 0, "microbio"),
'154' => array ( 0, "biomed"),
'155' => array ( 0, "geosciences"),
'156' => array ( 0, "material"),
'157' => array ( 0, "biomed"),
'158' => array ( 0, "plantanimal"),
'159' => array ( 0, "material"),
'160' => array ( 0, "neuro"),
'161' => array ( 0, "neuro"),
'162' => array ( 0, "physics"),
'163' => array ( 0, "genmed"),
'164' => array ( 0, "biomed"),
'165' => array ( 0, "clinmed"),
'166' => array ( 0, "ecology"),
'167' => array ( 0, "biomed"),
'168' => array ( 0, "computer"),
'169' => array ( 0, "clinmed"),
'170' => array ( 0, "physics"),
'171' => array ( 0, "ecology"),
'172' => array ( 0, "clinmed"),
'173' => array ( 0, "clinmed"),
'174' => array ( 0, "geosciences"),
'175' => array ( 0, "infectious"),
'176' => array ( 0, "biomed"),
'177' => array ( 0, "clinmed"),
'178' => array ( 0, "clinmed"),
'179' => array ( 0, "pharma"),
'180' => array ( 0, "multi"),
'181' => array ( 0, "geosciences"),
'182' => array ( 0, "physics"),
'183' => array ( 0, "material"),
'184' => array ( 0, "physics"),
'185' => array ( 0, "material"),
'186' => array ( 0, "physics"),
'187' => array ( 0, "physics"),
'188' => array ( 0, "physics"),
'189' => array ( 0, "physics"),
'190' => array ( 0, "physics"),
'191' => array ( 0, "biomed"),
'192' => array ( 0, "economics"),
'193' => array ( 0, "plantanimal"),
'194' => array ( 0, "social"),
'195' => array ( 0, "chemistry"),
'196' => array ( 0, "psycho"),
'197' => array ( 0, "psycho"),
'198' => array ( 0, "psycho"),
'199' => array ( 0, "psycho"),
'200' => array ( 0, "psycho"),
'201' => array ( 0, "psycho"),
'202' => array ( 0, "psycho"),
'203' => array ( 0, "psycho"),
'204' => array ( 0, "psycho"),
'205' => array ( 0, "psycho"),
'206' => array ( 0, "psycho"),
'207' => array ( 0, "psycho"),
'208' => array ( 0, "social"),
'209' => array ( 0, "social"),
'210' => array ( 0, "clinmed"),
'211' => array ( 0, "social"),
'212' => array ( 0, "geosciences"),
'213' => array ( 0, "biomed"),
'214' => array ( 0, "clinmed"),
'215' => array ( 0, "clinmed"),
'216' => array ( 0, "computer"),
'217' => array ( 0, "engineering"),
'218' => array ( 0, "social"),
'219' => array ( 0, "social"),
'220' => array ( 0, "social"),
'221' => array ( 0, "social"),
'222' => array ( 0, "social"),
'223' => array ( 0, "social"),
'224' => array ( 0, "agriculture"),
'225' => array ( 0, "chemistry"),
'226' => array ( 0, "clinmed"),
'227' => array ( 0, "mathematics"),
'228' => array ( 0, "neuro"),
'229' => array ( 0, "clinmed"),
'230' => array ( 0, "computer"),
'231' => array ( 0, "engineering"),
'232' => array ( 0, "pharma"),
'233' => array ( 0, "clinmed"),
'234' => array ( 0, "computer"),
'235' => array ( 0, "computer"),
'236' => array ( 0, "infectious"),
'237' => array ( 0, "social"),
'238' => array ( 0, "biomed"),
'239' => array ( 0, "animal"),
'240' => array ( 0, "infectious"),
'241' => array ( 0, "environmental"),
'242' => array ( 0, "social"),
'243' => array ( 0, "animal"),
    );

$pubfields = array(  
    'any' => array ( 0, "any"),
    'live' => array ( 0, "live"),
    'conference' => array ( 0, "live"),
    'course' => array ( 0, "live"),
    'theatre' => array ( 0, "live"),
    'concert' => array ( 0, "live"),
    'musical' => array ( 0, "live"),
    'sport' => array ( 0, "live"),
    'written' => array ( 0, "written"),
    'nonfiction' => array ( 0, "written"),
    'patent' => array ( 0, "written"),
    'essay' => array ( 0, "written"),
    'fiction' => array ( 0, "written"),
    'blog' => array ( 0, "media"),
    'media' => array ( 0, "media"),
    'music' => array ( 0, "media"),
    'audiovisual' => array ( 0, "media"),
    'art' => array ( 0, "media"),
  );

$skilltypes = array(  
    'accounting' => 0, 
    'artistic' => 0, 
    'music' => 0, 
    'asset' => 0, 
    'aviation' => 0, 
    'business' => 0, 
    'clerical' => 0,   
    'chiro' => 0, 
    'computer' => 0, 
    'programming' => 0,  
    'compspec' => 0, 
    'driving' => 0, 
    'development' =>  0,  
    'legal' => 0, 
    'logistics' => 0, 
    'medicine' => 0, 
    'project' => 0, 
    'technical' => 0, 
    'sanitary' => 0, 
    'security' => 0, 
    'sport' => 0, 
    'other' => 0, 
  );

 $defaultvalues = array (
         'advanced_values' => $advanced_values, 
         'edufields' => $edufields, 
         'educountries' => $educountries, 
         'edudatabases' => $edudatabases, 
         'credtypes' => $credtypes, 
         'prestypes' => $prestypes,  
         'hourtypes' => $hourtypes,
         'gradetypes' => $gradetypes,
         'sectors' => $sectors,
         'currencies' => $currencies,
         'workdatabases' => $workdatabases, 
         'industryclasses' => $industryclasses,
         'languages' => $languages,
         'langfamilies' => $langfamilies, 
         'langgrades' => $langgrades,
         'langdbs' => $langdbs,
         'resfields' => $resfields,
         'pubfields' => $pubfields,
         'skilltypes' => $skilltypes,
      );
  
      return $defaultvalues;
  }
  
  // letter to grade function
  function lettertonumber ($grade, $gradetype){
   // converto "," to numeric ".", to avoid problems
    $grade = str_replace(",",".",$grade);
    
   // only if $grade != numeric, 
   if (!is_numeric($grade)) {
     
       // first of all, trim to avoid problems with blank spaces
       $grade = trim($grade);
       
      if ($gradetype == "US4") {
         if ($grade == "A+") $grade = 4;
         elseif ($grade == "A") $grade = 3.8;
         elseif ($grade == "A-") $grade = 3.6;
         elseif ($grade == "B+") $grade = 3.3;
         elseif ($grade == "B") $grade = 3;
         elseif ($grade == "B-") $grade = 2.7;
         elseif ($grade == "C+") $grade = 2.3;
         elseif ($grade == "C") $grade = 2;
         elseif ($grade == "C-") $grade = 1.7;
         elseif ($grade == "D+") $grade = 1.4;
         elseif ($grade == "D") $grade = 1.2;
         elseif ($grade == "D-") $grade = 1;
         // else: grade == E, F, N, U,...
         else $grade = 0.5;
      }
      
      elseif ($gradetype == "US5") {
          if ($grade == "A+") $grade = 5;
          elseif ($grade == "A") $grade = 4.8;
          elseif ($grade == "A-") $grade = 4.6;
          elseif ($grade == "B+") $grade = 4.3;
          elseif ($grade == "B") $grade = 4;
          elseif ($grade == "B-") $grade = 3.7;
          elseif ($grade == "C+") $grade = 3.3;
          elseif ($grade == "C") $grade = 3;
          elseif ($grade == "C-") $grade = 2.7;
          elseif ($grade == "D+") $grade = 2.4;
          elseif ($grade == "D") $grade = 2.2;
          elseif ($grade == "D-") $grade = 2;
          // else: grade == E, F, N, U,...
          else $grade = 1;
      }
      
      elseif ($gradetype == "US9") {
          if ($grade == "A+") $grade = 9;
          elseif ($grade == "A") $grade = 8;
          elseif ($grade == "A-") $grade = 7;
          elseif ($grade == "B+") $grade = 6;
          elseif ($grade == "B") $grade = 5;
          elseif ($grade == "B-") $grade = 4;
          elseif ($grade == "C+") $grade = 3;
          elseif ($grade == "C") $grade = 2;
          elseif ($grade == "C-") $grade = 1;
          else $grade = 0;
      }
      
      elseif ($gradetype == "US10") {
          if ($grade == "A+") $grade = 10;
          elseif ($grade == "A") $grade = 9;
          elseif ($grade == "A-") $grade = 8;
          elseif ($grade == "B+") $grade = 7;
          elseif ($grade == "B") $grade = 6;
          elseif ($grade == "B-") $grade = 5;
          elseif ($grade == "C+") $grade = 4;
          elseif ($grade == "C") $grade = 3;
          elseif ($grade == "C-") $grade = 2;
          elseif ($grade == "D+") $grade = 1;
          else $grade = 0;
      }
      
      // UK according to the Fullbright commision
      elseif ($gradetype == "UK") {
         if ($grade == "1st*") $grade = 95;
         elseif ($grade == "1st") $grade = 85;
         elseif ($grade == "2:1") $grade = 65;
         elseif ($grade == "2:2") $grade = 55;
         elseif ($grade == "3rd") $grade = 45;
         elseif ($grade == "Pass") $grade = 37.5;
         else $grade = 20;
      } 
      
      elseif ($gradetype == "GCSE") {
         if ($grade == "A*") $grade = 95;
         elseif ($grade == "A") $grade = 85;
         elseif ($grade == "B") $grade = 75;
         elseif ($grade == "C") $grade = 65;
         elseif ($grade == "D") $grade = 55;
         elseif ($grade == "E") $grade = 45;
         elseif ($grade == "F") $grade = 35;
         elseif ($grade == "G") $grade = 25;
         else $grade = 10;
      }
      
      // Grades are given in statistical terms
      // Taken Equivalence to UK system (Wikipedia)
      elseif ($gradetype == "ECTS") {
         if ($grade == "A") $grade = 85;
         elseif ($grade == "B") $grade = 75;
         elseif ($grade == "C") $grade = 65;
         elseif ($grade == "D") $grade = 55;
         elseif ($grade == "E") $grade = 45;
         elseif ($grade == "FX") $grade = 35;
         else $grade = 15;
      }
      
      // A (85-100): Yōuxiù; B (75-84): Liánghǎo; C (65-74): Zhōngděng; D (60-64)...
      elseif ($gradetype == "China") {
          if ($grade == "A") $grade = 95;
          elseif ($grade == "A-") $grade = 87.5;
          elseif ($grade == "B") $grade = 82.5;
          elseif ($grade == "B-") $grade = 77.5;
          elseif ($grade == "C") $grade = 72.5;
          elseif ($grade == "C-") $grade = 67.5;
          elseif ($grade == "D") $grade = 62.5;
          elseif ($grade == "下") $grade = 32.5;
          elseif ($grade == "F") $grade = 30;
          else $grade = 0;
      }
      
      // Equivalences to ECTS, taken from Wikipedia
      elseif ($gradetype == "Denmark") {
         if ($grade == "12") $grade = 85;
         elseif ($grade == "10") $grade = 75;
         elseif ($grade == "7") $grade = 65;
         elseif ($grade == "4") $grade = 55;
         elseif ($grade == "02") $grade = 45;
         elseif ($grade == "00") $grade = 35;
         else $grade = 15;
      }
      
       // A (90-100): shū, B (80-89): yū, C (70-79): ryō, D (60-69): ka...
      elseif ($gradetype == "Japan6") {
         if (($grade == "秀") || ($grade == "A")) $score = 95;
         elseif (($grade == "優") || ($grade == "B")) $score = 85;
         elseif (($grade == "良") || ($grade == "C")) $score = 75;
         elseif (($grade == "可") || ($grade == "D")) $score = 65;
         elseif (($grade == "認") || ($grade == "E")) $score = 55;
         elseif (($grade == "不可") || ($grade == "F")) $score = 25;
         else $score = 0;
      }
      
      // A (80-100): yū, B (70-79): ryō, C (60-69): ka, F (0-59)
      elseif ($gradetype == "Japan4") {
         if (($grade == "優") || ($grade == "A")) $score = 90;
         elseif (($grade == "良") || ($grade == "B")) $score = 75;
         elseif (($grade == "可") || ($grade == "C")) $score = 65;
         elseif (($grade == "不可") || ($grade == "F")) $score = 30;
         else $score = 0;
      }   
      
      // A-D (with or without 1-3)
      elseif ($gradetype == "Ireland2") {
          if ($grade == "A1") $grade = 95;
          elseif ($grade == "A") $grade = 92.5;
          elseif ($grade == "A2") $grade = 87.5;
          elseif ($grade == "B1") $grade = 82.5;
          elseif (($grade == "B2") || ($grade =="B")) $grade = 77.5;
          elseif ($grade == "B3") $grade = 72.5;
          elseif ($grade == "C1") $grade = 67.5;
          elseif (($grade == "C2") || ($grade =="C")) $grade = 65;
          elseif ($grade == "C3") $grade = 57.5;
          elseif ($grade == "D1") $grade = 52.5;
          elseif (($grade == "D2") || ($grade =="D")) $grade = 47.5;
          elseif ($grade == "D3") $grade = 42.5;
          elseif ($grade == "E") $grade = 32.5;
          elseif ($grade == "F") $grade = 17.5;
          elseif ($grade == "NG") $grade = 5;
          else $grade = 0;
      }  
      
       // A/I (70-100), B/II.1 (60-69), C/II.2 (50-59%), D/III (40-49), F1/E (30-39), F2/F (<29)a...
      elseif ($gradetype == "Ireland3") {
         if (($grade == "I") || ($grade == "A")) $score = 85;
         elseif (($grade == "II.1") || ($grade == "B")) $score = 65;
         elseif (($grade == "II.2") || ($grade == "C")) $score = 55;
         elseif (($grade == "III") || ($grade == "D")) $score = 45;
         elseif (($grade == "F1") || ($grade == "E")) $score = 35;
         elseif (($grade == "F2") || ($grade == "F")) $score = 15;
         else $score = 0;
      } 
   }
      
      // Return value: either the new numeric value, or leave numeric as it was
      return $grade;
  }
  
  function scoring_scale ($grade, $scale) {
   if (is_string($scale)) {
    if ($scale == "US4") { 
      if ($grade >= 3.5) {
          // of interval 0-0.5, turn it into 90-100
          // if > 4.0, will get more than 100 (but later cut)
          $score = (($grade - 3.5) * 2 * 10 ) + 90;
      }
      elseif ($grade >= 1.5) {
          // of interval 0-1.99, turn it into 70-89.99
          $score = (($grade - 1.5) * 10) + 70;
      }
      elseif ($grade >= 1) {
          // of interval 0-0.49, turn it into 60-69.99
          $score = (($grade - 1) * 2 * 10 ) + 60;
      }
      else {
          // from 0-0.99 convert into 0-59.99
          $score = (($grade) * 60);
      }
    }
    if ($scale == "US5") { 
      if ($grade >= 4.5) {
          // of interval 0-0.5, turn it into 90-100
          // if > 4.0, will get more than 100 (but later cut)
          $score = (($grade - 4.5) * 2 * 10 ) + 90;
      }
      elseif ($grade >= 3.5) {
          // of interval 0-0.99, turn it into 80-89.99
          $score = (($grade - 3.5) * 10) + 80;
      }
      elseif ($grade >= 2.5) {
          // of interval 0-1.99, turn it into 75-79.99
          $score = (($grade - 2.5)/2 * 10) + 75;
      }
      elseif ($grade >= 2) {
          // of interval 0-0.49, turn it into 70-74.99
          $score = (($grade - 2) * 10 ) + 70;
      }
      else {
          // from 0-1.99 convert into 0-69
          $score = (($grade)/2 * 70);
      }
    }
    if ($scale == "US9") { 
      if ($grade >= 7) {
          // of interval 0-2, turn it into 90-100
          $score = (($grade - 7)/2 * 10 ) + 90;
      }
      elseif ($grade >= 4) {
          // of interval 0-2.99, turn it into 80-89
          $score = (($grade - 4)/3 * 10) + 80;
      }
      elseif ($grade >= 1) {
          // of interval 0-2.99, turn it into 75-79
          $score = ((($grade - 1)/3)/2 * 10) + 75;
      }
      else {
          // from 0-1 convert into 0-74
          $score = $grade * 74;
      }
    }
  
    if ($scale == "US10") { 
      if ($grade >= 8) {
          // of interval 0-2, turn it into 90-100
          $score = (($grade - 8)/2 * 10 ) + 90;
      }
      elseif ($grade >= 5) {
          // of interval 0-2.99, turn it into 80-89
          $score = (($grade - 5)/3 * 10) + 80;
      }
      elseif ($grade >= 2) {
          // of interval 0-2.99, turn it into 75-79
          $score = ((($grade - 2)/3)/2 * 10) + 75;
      }
      elseif ($grade >= 1) {
          // of interval 0-1, turn it into 77.5-79
          $score = ((($grade - 1)/2)/2 * 10) + 77.5;
      }
      else {
          // from 0-1 convert into 0-77.5
          $score = $grade * 77.5;
      }
    }
    if ($scale == "US42") { 
      if ($grade >= 3.5) {
          // of interval 0-0.5, turn it into 93-100
          // if > 4.0, will get more than 100 (but later cut)
          $score = (($grade - 3.5) * 2 * 7 ) + 93;
      }
      elseif ($grade >= 2.5) {
          // of interval 0-1, turn it into 87-92
          $score = (($grade - 2.5)/2 * 10) + 87;
      }
      elseif ($grade >= 1.5) {
          // of interval 0-0.99, turn it into 75-86.99
          $score = (($grade - 1.5) * 12 ) + 75;
      }
      elseif ($grade >= 1) {
          // of interval 0-0.49, turn it into 70-74.99
          $score = (($grade - 1) * 10 ) + 75;
      }
      else {
          // from 0-0.99 convert into 0-69
          $score = (($grade) * 70);
      }
    }
    if ($scale == "US52") { 
      if ($grade >= 4.5) {
          $score = (($grade - 4.5) * 2 * 7 ) + 93;
      }
      elseif ($grade >= 3.5) {
          $score = (($grade - 3.5)/2 * 10) + 87;
      }
      elseif ($grade >= 2.5) {
          $score = (($grade - 2.5) * 12) + 75;
      }
      elseif ($grade >= 2) {
          $score = (($grade - 2) * 10 ) + 70;
      }
      else {
          // from 0-1.99 convert into 0-69
          $score = (($grade)/2 * 70);
      }
    }
    if ($scale == "UK") { 
  // UK Equivalence to US scale (Fullbright, ECTS scale)
  // 1st = A = 4.0 = 93-100
  // 2:1 = A-/B+ = 3.33-3.67 = 87-92.9
  // 2:2 = B = 3.00 = 80-86.9
  // 3rd = C+ = 2.30 = 77-79.9
  // Pass = C = 2.00 = 73-76.9
      if ($grade >= 70) {
          // 0-30 into 93-100
          $score = (($grade - 70)/30 * 7 ) + 93;
      }
      elseif ($grade >= 60) {
          // 0-10 into 87-92.99
          $score = (($grade - 60)/10 * 6 ) + 87;
      }
      elseif ($grade >= 50) {
          // 0-10 into 80-86.99
          $score = (($grade - 50)/10 * 7) + 80;
      }
      elseif ($grade >= 40) {
          // 0-10 into 77-79.99
          $score = (($grade - 40)/10 * 3 ) + 77;
      }
      elseif ($grade >= 35) {
          // 0-5 into 73-76.99
          $score = (($grade - 35)/5 * 4 ) + 73;
      }
      else {
          // from 0-34.99 convert into 0-72.99
          $score = (($grade)/35 * 73);
      }
    }
    if ($scale == "GCSE") { 
      if ($grade >= 20) {
          // A-G: 0-80 into 60-100
          $score = (($grade - 20)/2) + 60;
      }
      else {
          // U: from 0-20 convert into 0-60
          $score = $grade * 3;
      }
    }
    if ($scale == "IB") { 
      if ($grade >= 6.5) {
          // 0-0.5 into 93-100
          $score = (($grade - 6.5)/5 * 70) + 93;
      }
      elseif ($grade >= 4.5) {
          // 0-1 into 85-92.99, 0-1 into 77-84.99, 
          $score = (($grade - 4.5) * 8 ) + 77;
      }
      elseif ($grade >= 3.5) {
          // 0-10 into 70-76.99
          $score = (($grade - 3.5) * 7 ) + 70;
      }
      else {
          // 0-3.49 into 0-69.99
          $score = $grade * 20;
      }
    }
    if ($scale == "Germany") { 
      if (($grade == "1+") || ($grade == "15p") || ($grade == "1.0")) $score = 98;
      elseif (($grade == "1") || ($grade == "14p")) $score = 95;
      elseif (($grade == "1-") || ($grade == "13p") || ($grade == "1.3"))  $score = 92;
      elseif (($grade == "2+") || ($grade == "12p") || ($grade == "1.7"))  $score = 88;
      elseif (($grade == "2") || ($grade == "11p") || ($grade == "2.0"))  $score = 85;
      elseif (($grade == "2-") || ($grade == "10p") || ($grade == "2.3"))  $score = 82;
      elseif (($grade == "3+") || ($grade == "9p") || ($grade == "2.7"))  $score = 77;
      elseif (($grade == "3") || ($grade == "8p") || ($grade == "3.0"))  $score = 73;
      elseif (($grade == "3-") || ($grade == "7p") || ($grade == "3.3"))  $score = 67;
      elseif (($grade == "4+") || ($grade == "6p") || ($grade == "3.7"))  $score = 60.5;
      elseif (($grade == "4") || ($grade == "5p") || ($grade == "4.0"))  $score = 53.5;
      elseif (($grade == "4-") || ($grade == "4p"))  $score = 45;
      elseif (($grade == "5+") || ($grade == "3p"))  $score = 35;
      elseif (($grade == "5") || ($grade == "2p") || ($grade == "5.0"))  $score = 25;
      elseif (($grade == "5-") || ($grade == "1p"))  $score = 15;
      elseif (($grade == "6") || ($grade == "0p"))  $score = 5;
    }
    
    if ($scale == "Russia") { 
  // 5 (85-100): отл; 4 (75-84): хор; 3 (50-74): уд; 2 (1-49): неуд; 1 (0)
      if ($grade == "5+") $score = 97.5;
      elseif ($grade == "5") $score = 92.5;
      elseif ($grade == "5-")   $score = 87.5;
      elseif ($grade == "4+")   $score = 83;
      elseif ($grade == "4")   $score = 80;
      elseif ($grade == "4-")   $score = 77;
      elseif ($grade == "3+")  $score = 71;
      elseif ($grade == "3") $score = 62.5;
      elseif ($grade == "3-")  $score = 54;
      elseif ($grade == "2+") $score = 40;
      elseif ($grade == "2")   $score = 25;
      elseif ($grade == "2-")  $score = 10;
      else $score = 0;
    }
    if ($scale == "Poland1") { 
      if ($grade == "6") $score = 99;
      elseif ($grade == "5+") $score = 95;
      elseif ($grade == "5") $score = 90;
      elseif ($grade == "5-") $score = 85;
      elseif ($grade == "4+") $score = 77;
      elseif ($grade == "4") $score = 72.5;
      elseif ($grade == "4-") $score = 68;
      elseif ($grade == "3+") $score = 62;
      elseif ($grade == "3") $score = 57.5;
      elseif ($grade == "3-") $score = 53;
      elseif ($grade == "2+") $score = 45;
      elseif ($grade == "2") $score = 40;
      elseif ($grade == "2-") $score = 35;
      elseif ($grade == "1+") $score = 22.5;
      elseif ($grade == "1") $score = 15;
      elseif ($grade == "1-") $score = 7.5;
      else $score = 0;
    }
    if ($scale == "Poland3") { 
    // Poland: 5.5-6.0 (98-100): celujący; 5.0 (90-98): bardzo dobry; 4.5 (85-90): dobry +;...
     if (($grade == "6.0") || ($grade == "5.5")) $score = 98;
      elseif ($grade == "5.0") $score = 95;
      elseif ($grade == "4.5")  $score = 87.5;
      elseif ($grade == "4.0")  $score = 82.5;
      elseif ($grade == "3.5")  $score = 75;
      elseif ($grade == "3.0")  $score = 65;
      elseif ($grade == "2.0")  $score = 30;
      else $score = 0;
    }
     if ($scale == "inv5") { 
      if ($grade == "1") $score = 5;
      elseif ($grade == "2") $score = 4;
      elseif ($grade == "4") $score = 2;
      elseif ($grade == "5") $score = 1;
     }
   }
     // if it is not string (i.e. numeric):
    else {
      $score = $grade/$scale * 100;
    }
    
      return $score;
  }   
  
  function pass_std ($grade, $pass) {
      // STD for pass = 60%
      $fail = 100 - $pass;
      if ($grade >= $pass) { 
       // convert interval to 60-100
       $score = (($grade - $pass)/$fail * 40 ) + 60;
      }
      else {
      // convert interval to 0-60
       $score = (($grade/$fail) * 60 );
      }
      return $score;
  }
  
// FUNCTION SET values for CVR
  // SET default
  function set_defaultcvr () {
     
      $defaultvalues = get_defaultvalues();
      
          $advanced_values = $defaultvalues['advanced_values'];
          $edufields = $defaultvalues['edufields'];
          $educountries = $defaultvalues['educountries']; 
          $edudatabases = $defaultvalues['edudatabases'];
          $credtypes = $defaultvalues['credtypes']; 
          $prestypes = $defaultvalues['prestypes']; 
          $hourtypes = $defaultvalues['hourtypes'];  
          $gradetypes = $defaultvalues['gradetypes'];
          $sectors = $defaultvalues['sectors'];
          $workdatabases = $defaultvalues['workdatabases'];
          $wcountries = $defaultvalues['educountries'];
          $currencies = $defaultvalues['currencies'];
          $industryclasses = $defaultvalues['industryclasses'];
          $languages = $defaultvalues['languages'];
          $langfamilies = $defaultvalues['langfamilies'];
          $langgrades = $defaultvalues['langgrades'];
          $langdbs = $defaultvalues['langdbs'];
          $resfields = $defaultvalues['resfields'];
          $pubfields = $defaultvalues['pubfields'];
          $skilltypes = $defaultvalues['skilltypes'];
       
        // edufields
       foreach ($edufields as $edufkey => $edufvalue) {
              $edufvalue = 1;
              $edufields[$edufkey] = $edufvalue;
        }
        
        // educountries
       foreach ($educountries as $educkey => $educvalue) {
              $educvalue = 1;
              $educountries[$educkey] = $educvalue;
       }
       
        //apply weight to STANDARD databases!!
        $edudatabases['QS12'] = 1;
        $edudatabases['TIMSS08'] = 1;
        
        // credtypes
       foreach ($credtypes as $edutkey => $edutvalue) {
                         $edutvalue = 1;
                         $credtypes[$edutkey] = $edutvalue;
       }
         
     // prestypes
        foreach ($prestypes as $prestypekey => $prestypevalue) {
                      $prestypevalue = 1;
                      $prestypes[$prestypekey] = $prestypevalue;
        }
        
     // prestypes
        foreach ($sectors as $sectorkey => $sectorvalue) {
                      $sectorvalue = 1;
                      $sectors[$sectorkey] = $sectorvalue;
        }
        
       foreach ($workdatabases as $wdkey => $wdvalue) {
              $wdvalue = 1;
              $workdatabases[$wdkey] = $wdvalue;
       }
       
        // work countries
       foreach ($wcountries as $wckey => $wcvalue) {
              $wcvalue = 1;
              $wcountries[$wckey] = $wcvalue;
       }
       
        foreach ($industryclasses as $ickey => $icvalue) {
                      $icvalue = 1;
                      $industryclasses[$ickey] = $icvalue;
        }
        
        // languages
       foreach ($languages as $lkey => $lvalue) {
              $lvalue = 1;
              $languages[$lkey] = $lvalue;
       }
       
        //apply weight to STANDARD databases!!
      
        $langdbs["weber"] = 1;
      
        // research fields
       foreach ($resfields as $rfkey => $rfvalue) {
              $rfvalue[0] = 1;
              $resfields[$rfkey] = $rfvalue;
       }
       
        // publication typologies
       foreach ($pubfields as $pfkey => $pfvalue) {
              $pfvalue[0] = 1;
              $pubfields[$pfkey] = $pfvalue;
       }
       
        // skills
       foreach ($skilltypes as $skkey => $skvalue) {
              $skvalue = 1;
              $skilltypes[$skkey] = $skvalue;
       }
       
      $cvr_arrays = array (
         'advanced_values' => $advanced_values, 
         'edufields' => $edufields, 
         'educountries' => $educountries, 
         'edudatabases' => $edudatabases, 
         'credtypes' => $credtypes, 
         'prestypes' => $prestypes,
         'hourtypes' => $hourtypes,   
         'gradetypes' => $gradetypes,
         'sectors' => $sectors,
         'wcountries' => $wcountries,
         'workdatabases' => $workdatabases,
         'currencies' => $currencies,
         'industryclasses' => $industryclasses,
         'languages' => $languages,
         'langfamilies' => $langfamilies,
         'langgrades' => $langgrades,
         'langdbs' => $langdbs,
         'resfields' => $resfields,
         'pubfields' => $pubfields,
         'skilltypes' => $skilltypes,
          );
      
      return $cvr_arrays;
  }
  
  function set_cvrvalues ($cvrpreferences) {
     
      $defaultvalues = get_defaultvalues();
      
          $advanced_values = $defaultvalues['advanced_values'];
          $edufields = $defaultvalues['edufields'];
          $educountries = $defaultvalues['educountries']; 
          $edudatabases = $defaultvalues['edudatabases'];
          $credtypes = $defaultvalues['credtypes']; 
          $prestypes = $defaultvalues['prestypes']; 
          $hourtypes = $defaultvalues['hourtypes'];  
          $gradetypes = $defaultvalues['gradetypes'];
          $sectors = $defaultvalues['sectors'];
          $workcountries = $defaultvalues['educountries'];
          $workdatabases = $defaultvalues['workdatabases'];
          $currencies = $defaultvalues['currencies'];
          $industryclasses = $defaultvalues['industryclasses'];
          $languages = $defaultvalues['languages'];
          $langfamilies = $defaultvalues['langfamilies'];
          $langgrades = $defaultvalues['langgrades'];
          $langdbs = $defaultvalues['langdbs'];
          $resfields = $defaultvalues['resfields'];
          $pubfields = $defaultvalues['pubfields'];
          $skilltypes = $defaultvalues['skilltypes'];
          
      // // Proof  if user wants to use advanced features
      if ($cvrpreferences->advancedbool) {
          // If so, substitute advanced weights 
          $advanceds_array = $cvrpreferences->advanceds;
         if (!is_array ($advanceds_array)) $advanceds_array = array(0=>$advanceds_array);
          $aweights_array = $cvrpreferences->aweights;
          $count_ad = count($advanceds_array);
          
  // We might want to test certain weights before assigning them...
          
          for ($i = 0; $i < $count_ad; $i++) {
            // In $advanced_values, assign to key the value $i from aweights
               $advanced_values[$advanceds_array[$i]] = $aweights_array[$i];
          }
       }
       
    // edufields, sectors
       // get data
       $fweights = $cvrpreferences->fweights;
       $sweights = $cvrpreferences->sweights;
       
      for( $i = 0; $i < 3; $i++ ) {
 //  ATTENTION - THE FOLLOWING WILL OVERRIDE THE PREVIOUS WEIGHTING
         $fieldi = 'fields'.$i;
         $fields_array = $cvrpreferences->$fieldi;
         // if not array, convert to array (TEMPORARY FIX)
         if (!is_array ($fields_array)) $fields_array = array(0=>$fields_array);
         $fweight = $fweights[$i];
         // if set, convert weights 0-100 to 0-1 scale
         if ($fweight) $fweight = $fweight/100;
         if ($fields_array && $fweight) {
            foreach ($fields_array as $fieldkey => $fieldvalue) {
            // apply weight to all keys selected from $edufields array
              if ($fieldvalue == "any") {
                // apply weight to all $edufields array
                foreach ($edufields as $edufkey => $edufvalue) {
                $edufvalue = $fweight;
                $edufields[$edufkey] = $edufvalue;
                }
              }
                     
              $edufields[$fieldvalue] = $fweight;
            } 
         }
         // sectors
         $sectori = 'sectors'.$i;
         $sectors_array = $cvrpreferences->$sectori;
         // if not array, convert to array (TEMPORARY FIX)
         if (!is_array ($sectors_array)) $sectors_array = array(0=>$sectors_array);
         $sweight = $sweights[$i];
         // if set, convert weights 0-100 to 0-1 scale
         if ($sweight) $sweight = $sweight/100;
         if ($sectors_array && $sweight) {
            foreach ($sectors_array as $sectorkey => $sectorvalue) {
            // apply weight to all keys selected from $edufields array
              if ($sectorvalue == "any") {
                // apply weight to all $edufields array
                foreach ($sectors as $skey => $svalue) {
                $svalue = $sweight;
                $sectors[$skey] = $svalue;
                }
              }
                     
              $sectors[$sectorvalue] = $sweight;
            }
             
         }
       }
      
  //get data
       // Edu
   $cweights = $cvrpreferences->cweights;
   $eweights = $cvrpreferences->eweights;
   $crweights = $cvrpreferences->crweights;
   $etweights = $cvrpreferences->etweights;
       // Work
   $wcweights = $cvrpreferences->wcweights;
   $wweights = $cvrpreferences->wweights;
   $stweights = $cvrpreferences->stweights;
       // Lang
   $lweights = $cvrpreferences->lweights;
       // Res
   $rfweights = $cvrpreferences->rfweights;
   $pfweights = $cvrpreferences->pfweights;
   $skweights = $cvrpreferences->skweights;
   
         for( $i = 0; $i < 2; $i++ ) {
 //  ATTENTION - THE FOLLOWING WILL OVERRIDE THE PREVIOUS WEIGHTING
   // Edu
   $countryi = 'countries'.$i;
   $edudbi = 'edudbs'.$i;
   $credittypei = 'credittypes'.$i;
   $edutypei = 'edutypes'.$i;
   
   $countries_array = $cvrpreferences->$countryi;
   $edudbs_array = $cvrpreferences->$edudbi;
   $credittypes_array = $cvrpreferences->$credittypei;
   $edutypes_array = $cvrpreferences->$edutypei;
   
   // Work
   $wcountryi = 'wcountries'.$i;
   $workdbi = 'workdbs'.$i;
   $sectortypei = 'sectortypes'.$i;
   
   $wcountries_array = $cvrpreferences->$wcountryi;
   $workdbs_array = $cvrpreferences->$workdbi;
   $sectortypes_array = $cvrpreferences->$sectortypei;
   
   // Lang
   $languagei = 'languages'.$i;
   $langdbi = 'langdbs'.$i;
   
   $languages_array = $cvrpreferences->$languagei;
   $langdbs_array = $cvrpreferences->$langdbi;
   
   // Research
   $resfieldi = 'resfields'.$i;
   $resfields_array = $cvrpreferences->$resfieldi;
   // Publications
   $pubfieldi = 'pubfields'.$i;
   $pubfields_array = $cvrpreferences->$pubfieldi;
   // Skills
   $skilltypei = 'skilltypes'.$i;
   $skilltypes_array = $cvrpreferences->$skilltypei;
   
     // if not array, convert to array (TEMPORARY FIX)
         if (!is_array ($countries_array)) $countries_array = array(0=>$countries_array);
         if (!is_array ($edudbs_array)) $edudbs_array = array(0=>$edudbs_array);
         if (!is_array ($credittypes_array)) $credittypes_array = array(0=>$credittypes_array);
         if (!is_array ($edutypes_array)) $edutypes_array = array(0=>$edutypes_array);
         
         if (!is_array ($wcountries_array)) $wcountries_array = array(0=>$wcountries_array);
         if (!is_array ($workdbs_array)) $workdbs_array = array(0=>$workdbs_array);
         if (!is_array ($sectortypes_array)) $sectortypes_array = array(0=>$sectortypes_array);
         
         if (!is_array ($languages_array)) $languages_array = array(0=>$languages_array);
         if (!is_array ($langdbs_array)) $langdbs_array = array(0=>$langdbs_array);
         
         if (!is_array ($resfields_array)) $resfields_array = array(0=>$resfields_array);
         if (!is_array ($pubfields_array)) $pubfields_array = array(0=>$pubfields_array);
         if (!is_array ($skilltypes_array)) $skilltypes_array = array(0=>$skilltypes_array);
   
   $cweight = $cweights[$i];
   $eweight = $eweights[$i];
   $crweight = $crweights[$i];
   $etweight = $etweights[$i];
   
   $wcweight = $wcweights[$i];
   $wweight = $wweights[$i];
   $stweight = $stweights[$i]; 
   
   $lweight = $lweights[$i]; 
   $ldbweight = $ldbweights[$i]; 
   
   $rfweight = $rfweights[$i]; 
   $pfweight = $pfweights[$i];
   $skweight = $skweights[$i];  
   
   // if set, convert weights 0-100 to 0-1 scale
   if($cweight) $cweight = $cweight/100;
   if($eweight) $eweight = $eweight/100;
   if($crweight) $crweight = $crweight/100;
   if($etweight) $etweight =  $etweight/100;
   
   if($wcweight) $wcweight = $wcweight/100;
   if($wweight) $wweight = $wweight/100;
   if($stweight) $stweight = $stweight/100;
   
   if($lweight) $lweight = $lweight/100;
   if($ldbweight) $ldbweight = $ldbweight/100;
   
   if($rfweight) $rfweight = $rfweight/100;
   if($pfweight) $pfweight = $pfweight/100;
   if($skweight) $skweight = $skweight/100;
   
     // educountries
         if ($countries_array && $cweight) {
            // apply weight to all $educountries array
               foreach ($countries_array as $countrykey => $countryvalue) {
                   if ($countryvalue == "any") {
                       foreach ($educountries as $educkey => $educvalue) {
                          $educvalue = $cweight;
                          $educountries[$educkey] = $educvalue;
                       }
                   }
            // apply weight to all selected from $edufields array
                   $educountries[$countryvalue] = $cweight;
               }
         }
         
     // edudatabases
         if ($edudbs_array && $eweight) {
            foreach ($edudbs_array as $edudkey => $edudvalue) {
             // apply weight to all keys selected from $edufields array
                    if ($edudvalue == "any") {
                       //apply weight to STANDARD databases!!
                       $edudatabases['QS12'] = $eweight;
                       $edudatabases['TIMSS08'] = $eweight;
                     }
                   $edudatabases[$edudvalue] = $eweight;
            }
         }
         
     // credtypes
         if ($credittypes_array && $crweight) {
               foreach ($credittypes_array as $credtypekey => $credtypevalue) {
                  if ($credtypevalue == "any") {
                     foreach ($credtypes as $edutkey => $edutvalue) {
                         $edutvalue = $crweight;
                         $credtypes[$edutkey] = $edutvalue;
                     }
                  }
                  $credtypes[$credtypevalue] = $crweight;
               }
         }
         
     // prestypes
         if ($edutypes_array && $etweight) {
             foreach ($edutypes_array as $edutypekey => $edutypevalue) {
               if ($edutypevalue == "any") {  
                  foreach ($prestypes as $prestypekey => $prestypevalue) {
                      $prestypevalue = $etweight;
                      $prestypes[$prestypekey] = $prestypevalue;
                  }
               }
               $prestypes[$edutypevalue] = $etweight;
             }
         }
         
      // workcountries
         if ($wcountries_array && $wcweight) {
            // apply weight to all $educountries array
               foreach ($wcountries_array as $wcountrykey => $wcountryvalue) {
                   if ($wcountryvalue == "any") {
                       foreach ($workcountries as $wckey => $wcvalue) {
                          $wcvalue = $wcweight;
                          $workcountries[$wckey] = $wcvalue;
                       }
                   }
            // apply weight to all selected from $edufields array
                   $workcountries[$wcountryvalue] = $wcweight;
               }
         }
         
     // workdatabases
         if ($workdbs_array && $wweight) {
            foreach ($workdbs_array as $workdkey => $workdvalue) {
             // apply weight to all keys selected from $edufields array
                    if ($workdvalue == "any") {
                       foreach ($workdatabases as $wdbkey => $wdbvalue) {
                          $wdbvalue = $wweight;
                          $workdatabases[$wdbkey] = $wdbvalue;
                       }
                     }
                   $workdatabases[$wdbvalue] = $wweight;
            }
         }
     // prestypes
         if ($sectortypes_array && $stweight) {
             foreach ($sectortypes_array as $sectortypekey => $sectortypevalue) {
               if ($sectortypevalue == "any") {  
                  foreach ($sectortypes as $sectypekey => $sectypevalue) {
                      $sectypevalue = $stweight;
                      $sectortypes[$sectypekey] = $sectypevalue;
                  }
               }
               $sectortypes[$sectortypevalue] = $stweight;
             }
         }
         
     // prestypes
         if ($sectortypes_array && $stweight) {
             foreach ($sectortypes_array as $sectortypekey => $sectortypevalue) {
               if ($sectortypevalue == "any") {  
                  foreach ($sectortypes as $sectypekey => $sectypevalue) {
                      $sectypevalue = $stweight;
                      $sectortypes[$sectypekey] = $sectypevalue;
                  }
               }
               $sectortypes[$sectortypevalue] = $stweight;
             }
         }
         
     // languages
         if ($languages_array && $lweight) {
             foreach ($languages_array as $langarrkey => $langarrvalue) {
               if ($langarrvalue == "any") {  
                  foreach ($languages as $langkey => $langvalue) {
                      $langvalue = $lweight;
                      $languages[$langkey] = $langvalue;
                  }
               }
               $languages[$langarrvalue] = $lweight;
             }
         }
         
     // langdbs
         if ($langdbs_array && $ldbweight) {
             foreach ($langdbs_array as $ldbarrkey => $ldbarrvalue) {
               if ($ldbarrvalue == "any") {  
                  foreach ($langdbs as $ldbkey => $ldbvalue) {
                      $ldbvalue = $ldbweight;
                      $langdbs[$ldbkey] = $ldbvalue;
                  }
               }
               $langdbs[$ldbarrvalue] = $ldbweight;
             }
         }
         
     // resfields
         if ($resfields_array && $rfweight) {
             foreach ($resfields_array as $rfarrkey => $rfarrvalue) {
               if ($rfarrvalue == "any") {  
                  foreach ($resfields as $rfkey => $rfvalue) {
                      $rfvalue[0] = $rfweight;
                      $resfields[$rfkey] = $rfvalue;
                  }
               }
               $resfields[$rfarrvalue] = $rfweight;
             }
         }
         
     // pubfields
         if ($pubfields_array && $pfweight) {
             foreach ($pubfields_array as $pfarrkey => $pfarrvalue) {
               if ($pfarrvalue == "any") {  
                  foreach ($pubfields as $pfkey => $pfvalue) {
                      $pfvalue[0] = $pfweight;
                      $pubfields[$pfkey] = $pfvalue;
                  }
               }
               $pubfields[$pfarrvalue] = $pfweight;
             }
         }
         
     // skills
         if ($skilltypes_array && $skweight) {
             foreach ($skilltypes_array as $skillarrkey => $skillarrvalue) {
               if ($skillarrvalue == "any") {  
                  foreach ($skilltypes as $skillkey => $skillvalue) {
                      $skillvalue = $skweight;
                      $skilltypes[$skillkey] = $skillvalue;
                  }
               }
               $skilltypes[$skillarrvalue] = $skweight;
             }
         }
      // end For loop
       }
     
      $cvr_arrays = array (
         'advanced_values' => $advanced_values, 
         'edufields' => $edufields, 
         'educountries' => $educountries, 
         'edudatabases' => $edudatabases, 
         'credtypes' => $credtypes, 
         'prestypes' => $prestypes,
         'hourtypes' => $hourtypes,   
         'gradetypes' => $gradetypes,
         'sectors' => $sectors,
         'wcountries' => $wcountries,
         'workdatabases' => $workdatabases,
         'currencies' => $currencies,
         'industryclasses' => $industryclasses,
         'languages' => $languages,
         'langfamilies' => $langfamilies,
         'langgrades' => $langgrades,
         'langdbs' => $langdbs,
         'resfields' => $resfields,
         'pubfields' => $pubfields,
         'skilltypes' => $skilltypes,
          );
      return $cvr_arrays;
      
  }
 	/**
	 * Function educvrate() in education
	 */

  function educvrate($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $edufields = $cvr_arrays['edufields'];
      $educountries = $cvr_arrays['educountries'];
      $edudatabases = $cvr_arrays['edudatabases'];
      $credtypes = $cvr_arrays['credtypes']; 
      $prestypes = $cvr_arrays['prestypes']; 
      $hourtypes = $cvr_arrays['hourtypes']; 
      $gradetypes = $cvr_arrays['gradetypes'];
    
  // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
    
  // STRUCTURE/FIELD RATING BEGINS
    // get data
    $university_id = $ratedobject->structure;
      // get the name of the university
      if ($university_id) {
         $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_university_entity WHERE university_id='$university_id'";
         $result = get_data_row($query);
         $university = $result->name;
         $country = $result->country;
         $unitype = $result->type;
      }
    $field = $ratedobject->field;
    
    // Rankings and education fields
    $bybranch_rankings = array ('CVR_QS12', 'CVR_THE12', 'CVR_ARWU12', 'CVR_PISA09', 'CVR_USNewsHS12');
    // tertiary edu
    $tertiary_education = array ('ISCED5', 'ISCED5-1', 'ISCED5-4', 'ISCED6', 'ISCED6-1',
        'ISCED6-5', 'ISCED6-6', 'ISCED6-7', 'ISCED7', 'ISCED7-1', 'ISCED7-6', 'ISCED7-7',
        'ISCED7-8', 'ISCED8', 'ISCED8-1', 'ISCED8-4');
     
      $level56_education = array ('ISCED5', 'ISCED5-1', 'ISCED5-4', 'ISCED6', 'ISCED6-1','ISCED6-5', 'ISCED6-6');
      $level56_rankings = array ('CVR_QS12', 'CVR_THE12', 'CVR_ARWU12', 'CVR_USNewsU12', 'CVR_UK12', 'CVR_DEChe12', 'CVR_ESISI12');
      $level7_education = array ('ISCED7', 'ISCED7-1', 'ISCED7-6', 'ISCED7-7', 'ISCED7-8');
      $level7_rankings = array ('CVR_QS12', 'CVR_THE12', 'CVR_ARWU12', 'CVR_USNewsG12', 'CVR_UK12', 'CVR_DEChe12', 'CVR_ESISI12');
      $level8_education = array ('ISCED8', 'ISCED8-1', 'ISCED8-4');
      $level8_rankings = array ('CVR_QS12', 'CVR_THE12', 'CVR_ARWU12', 'CVR_USNewsG12', 'CVR_UK12', 'CVR_DEChe12', 'CVR_ESISI12');
      
      // secondary edu
    $secondary_education = array ("ISCED2", "ISCED2-1", "ISCED2-2", "ISCED2-3", "ISCED2-4", 
        "ISCED3", "ISCED3-1", "ISCED3-2", "ISCED3-3", "ISCED3-4", "ISCED4", "ISCED4-1",
        "ISCED4-3", "ISCED4-4");
      $level2_education = array ("ISCED2", "ISCED2-1", "ISCED2-2", "ISCED2-3", "ISCED2-4");
      $level2_rankings = array ('CVR_PISA09');
      $level3_education = array ("ISCED3", "ISCED3-1", "ISCED3-2", "ISCED3-3", "ISCED3-4",);
      $level3_rankings = array ('CVR_PISA09', 'CVR_USNewsHS12');
      $level4_education = array ("ISCED4", "ISCED4-1", "ISCED4-3", "ISCED4-4");
      $level4_rankings = array ('CVR_PISA09');
      
      //tertiary $fields -> $branch
     $gen_fields = array(0, 01, 010, 08, 080, 09, 090); 
     $art_fields = array (1, 14, 140, 141, 142, 143, 144, 145, 146, 149, 2, 21, 210, 211, 212, 213, 
         214, 215, 219, 22, 220, 221, 222, 223, 225, 226, 229,);
     $soc_fields = array (3, 31, 310, 311, 312, 313, 314, 319, 32, 321, 322, 329, 34, 340, 341,
         342, 343, 344, 345, 346, 347, 349, 38, 380, 8, 81, 810, 811, 812, 813, 814, 815, 819, 
         86, 860, 861, 862, 863, 869);
     $sci_fields = array (4, 42, 421, 422, 429, 44, 440, 441, 442, 443, 449, 46, 461, 462, 469,
         48, 481, 482,489);
     $tech_fields = array (5, 52, 520, 521, 522, 523, 524, 525, 529, 54, 540, 541, 542, 543, 544,
         549, 58, 581, 582, 589, 84, 840);
     $bio_fields = array (6, 62, 620, 621, 622, 623, 624, 629, 64, 640, 7, 72, 720, 721, 723, 724,
         725, 726, 727, 729, 76, 761, 762, 769, 85, 850, 851, 852, 853, 859); 
     
     //secondary $fields -> $branch
     $math_fields = array (46, 461, 462, 469, 48, 481, 482, 489, 5, 52, 520, 521, 522, 523, 524, 525, 
         529, 54, 540, 541, 542, 543, 544, 549, 58, 581, 582, 589);
     $scie_fields = array (4, 42, 421, 422, 429, 44, 440, 441, 442, 443, 449, 6, 62, 620, 621, 622, 623, 624, 
         629, 64, 640, 7, 72, 720, 721, 723, 724, 725, 726, 727, 729); 
     $read_fields = array (1, 14, 140, 141, 142, 143, 144, 145, 146, 149, 
         2, 21, 210, 211, 212, 213, 214, 215, 219, 22, 220, 221, 222, 223, 225, 226, 229, 3, 31, 310, 
         311, 312, 313, 314, 319, 32, 321, 322, 329, 34, 340, 341, 342, 343, 344, 345, 346, 347, 349, 
         38, 380, 76, 761, 762, 769, 8, 81, 810, 811, 812, 813, 814, 815, 819, 84, 840, 85, 850, 851, 852, 
         853, 859, 86, 860, 861, 862, 863, 869, 99);
     $gen_fields = array (0, 01, 010, 08, 080, 09, 090);
      
     if (in_array($level, $tertiary_education)) {
     
        if (in_array($field, $soc_fields)) $branch = "soc";
        elseif (in_array($field, $sci_fields)) $branch = "sci";
        elseif (in_array($field, $tech_fields)) $branch = "tech";
        elseif (in_array($field, $bio_fields)) $branch = "bio";
        elseif (in_array($field, $art_fields)) $branch = "art";
        else $branch = "gen";
      
        // test which exact level within tertiary education
        if (in_array($level, $level56_education)) $available_rankings = $level56_rankings;
        elseif (in_array($level, $level7_education)) $available_rankings = $level7_rankings;
        elseif (in_array($level, $level8_education)) $available_rankings = $level8_rankings;
     }
     
     // elseif (in_array($level, $secondary_education)) 
     else {
        if (in_array($field, $math_fields)) $branch = "math"; 
        elseif (in_array($field, $scie_fields)) $branch = "scie"; 
        elseif (in_array($field, $read_fields)) $branch = "read"; 
        else $branch = "gen";
        
        // test which exact level within secondary education
        if (in_array($level, $level3_education)) $available_rankings = $level3_rankings;
        elseif (in_array($level, $level4_education)) $available_rankings = $level4_rankings;
        elseif (in_array($level, $level2_education)) $available_rankings = $level2_rankings;
     }
  
   // loop through all level_rankings in the database
   foreach ($available_rankings as $keyrankings => $university_ranking) {
    // Loop only if necessary!
    if (!($edudatabases[$university_ranking] == 0)) {
     // If the ranking divides between branches, use $branch
     if (in_array($university_ranking, $bybranch_rankings)) {
         // 1st rating:
           // if structure ($university) is defined, search for it
        if ($university) {
         $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE university='$university' AND field='$branch'";
         $performance1 = get_data_row($query);
        }
         // if it doesn't get a result, or there is no $university, look for country values in database
         if (!$performance1) {
            $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE country='$country' AND field='$branch'";
            $performance1 = get_data_row($query);
            if (!$performance1) {
               $performance1->rating = $educountries[$country];
            }
         }
          $rating1 = $performance1->rating;  
          
         // 2nd rating:
         if ($university) {
         $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE university='$university' AND field='gen'";
   	 $performance2 = get_data_row($query);
         }
         if (!$performance2) {
            $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE country='$country' AND field='gen'";
            $performance2 = get_data_row($query);
            if (!$performance2) {
               $performance2->rating = $educountries[$country];
            }
         }
          $rating2 = $performance2->rating;
          
          // add values and get total
          $totalrating = ( $rating1 * ( 1 - $advanced_values["edudbgen"] ) ) 
          + ( $rating2 * $advanced_values["edudbgen"] );
          
          // weight the totalrating
          $totalrating = $totalrating * $edudatabases[$university_ranking];
          // assign to ratings array
          $ratings[] = $totalrating; 
          
     }   
     // If the ranking does not divide between branches, retrieve general rating
      else {
         if ($university) {
         $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE university='$university'";
         $performance = get_data_row($query);
         }
         // if it doesn't get a result, look for country value
         if (!$performance) {
            $query = "SELECT * FROM {$CONFIG->dbprefix}$university_ranking WHERE country='$country'";
            $performance2 = get_data_row($query);
            if (!$performance2) {
               $performance->rating = $educountries[$country];
            }
         }
          $rating = $performance->rating; 
          $rating = $rating * $edudatabases[$university_ranking];
          $ratings[] = $rating;
        }
    }
   }
    
        // CALCULATE MEAN: SUM OF ARRAY DIVIDED BY COUNT
     $sumratings = array_sum($ratings);
     $countratings = count($ratings);
     $meanrating = $sumratings/$countratings;
   
  // STRUCTURE/FIELD RATING ENDS 
   
  // EDUCATION TYPE CORRECTION FACTOR
    
     $edutype = $ratedobject->edutype;
     $typecorrection = $prestypes[$edutype];
     
   // convert rating to a 0-0.5 scale ((-0.25) - 0.25)
     $netrating = ($meanrating/200)*$typecorrection - 0.25;
   
  // CVRANK ALGORITHM
  $z = $advanced_values['z'];
  $B = 1/pow(10, $z + $difficulty + $netrating);
  
  // get percentile
  $classrank = $ratedobject->classrank;
  
  // if it is an EXAM, and we have a percentile, evaluate only percentile
  if ( 
       ( ($unitype == "exam") || ($unitype == "accessexam") || ($unitype == "stateexam") 
          || ($unitype == "officialexam") || ($unitype == "privateexam") ) 
       && ($classrank)
        ) {
      $score = $classrank;
      
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
       
      // Get stdyear from advanced values
         $stdyear = $advanced_values[$unitype];
         
         // CVR
	  $probability = $score/100;
          $CVR = 1/$B * ($probability / (1 - $probability) );
                
              // add each loop
             $totalCVR = $CVR * $stdyear;
      
  }
  // if it is an INSTITUTION (or not set), evaluate scores
  else {
  // TIME FACTOR
    $hourtype = $ratedobject->hourtype;
    $creditsyear = $hourtypes[$hourtype];
    // if not set, suppose 1100 hours / year
    if (!$creditsyear) $creditsyear = 1100;
    
  // SCORING BEGINS
    // get data
    $scores = $ratedobject->scores;
      $maxscore = $advanced_values["maxscore"];
    $hours =  $ratedobject->hours;
    $types = $ratedobject->types; 
    $gradetype = $ratedobject->gradetype; 
    $arraytype = $gradetypes[$gradetype];
    // use types
     $letter = $arraytype[1];
     $scale = $arraytype[2];
     $pass = $arraytype[3];
     
     // For grade inflation, look for advanced values!
     if (!$advanced_values[$gradetype]) $gradeinflation = $arraytype [0];
     else $gradeinflation = $advanced_values[$gradetype];
     
    // Calculate ratings: loop through types, scores and credits
     $countedscores = count ($scores);
     for ($i=0; $i<$countedscores; $i++) {
       $score = $scores[$i];
       // loop only if score is set
       if ($score) {
         // if score is PASS, give it a value halfway between STD pass interval 60-100
         if ($score == "PASS") $score = 80;
         else {
           // test for letter grades or convert numbers from "," to "." 
            $grade = lettertonumber ($score, $letter);
           // test for scores to percentages
             $grade = scoring_scale ($grade, $scale);
           // convert all grades to a 60% pass score
            $score = pass_std ($grade, $pass);
         }
         // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
          
          // adjust for type
          $type = $types[$i];
            // if type is not set, give it the value of any
            if (!$type) $type = "any";
          $score = $score * $credtypes[$type];
          
	  // calculate standardized credits
          if ($hours[$i] > 0) $stdyear = $hours[$i]/$creditsyear;
           
             // max. limit of 6 academic years and min. limit for each education
             if ($stdyear > 6)  $stdyear = 6;
    
               // calculate subject's CVR
	        $probability = $score/100;
                $CVR = 1/$B * ($probability / (1 - $probability) );
                
              // add each loop
             $totalCVR += $CVR * $stdyear;
     }
    }
    
      // adjust by classrank; 
      $crank = $advanced_values["crank"];
      $powerrank = $advanced_values["powerrank"];
      
      // turn best classrank much better, worse classrank much worse
      $classrank = pow($classrank,$powerrank)/pow(100,$powerrank);
      $classvalue = 1 + $classrank * $crank;
    $totalCVR = $totalCVR * $classvalue;
   } 
      // adjust by prizes obtained
    $prizes = $ratedobject->prizes; 
    $prizerank = 0;
    foreach ($prizes as $key => $prize) {
      $prizerank += $advanced_values[$prize];
    }
      $prizevalue = 1 + $prizerank;
    $totalCVR = $totalCVR * $prizevalue;
    
      // adjust totalrating by the value given to education fields
      $eduCVR = $totalCVR * $edufields[$field];
       
      // return the value!
      return $eduCVR;
 }
 
 function scoring ($ratedobject, $cvr_arrays) {
    
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $credtypes = $cvr_arrays['credtypes']; 
      $gradetypes = $cvr_arrays['gradetypes'];
      
    // SCORING BEGINS
    // get data
    $scores = $ratedobject->scores;
      $maxscore = $advanced_values["maxscore"];
    $hours =  $ratedobject->hours;
    $types = $ratedobject->types; 
    $gradetype = $ratedobject->gradetype; 
    $arraytype = $gradetypes[$gradetype];
    // use types
     $letter = $arraytype[1];
     $scale = $arraytype[2];
     $pass = $arraytype[3];
     
     // For grade inflation, look for advanced values!
     if (!$advanced_values[$gradetype]) $gradeinflation = $arraytype [0];
     else $gradeinflation = $advanced_values[$gradetype];
     
    // Calculate ratings: loop through types, scores and credits
     $countedscores = count ($scores);
     
     for ($i=0; $i<$countedscores; $i++) {
       $score = $scores[$i];
       // loop only if score is set
       if ($score) {
         // if score is PASS, give it a value halfway between STD pass interval 60-100
         if ($score == "PASS") $score = 80;
         else {
           // test for letter grades or convert numbers from "," to "." 
            $grade = lettertonumber ($score, $letter);
           // test for scores to percentages
             $grade = scoring_scale ($grade, $scale);
           // convert all grades to a 60% pass score
            $score = pass_std ($grade, $pass);
         }
         // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
          
          // adjust for type
          $type = $types[$i];
            // if type is not set, give it the value of any
            if (!$type) $type = "any";
          
          $score = $score * $credtypes[$type];
        
          $sumscores += $score * $hours[$i];
          $sumhours += $hours[$i];
      }
     }
     
     $meanscore = $sumscores / $sumhours;
          return $meanscore;
}
 
	/**
	 * Function workcvrate() in workexperience
	 */

  function workcvrate($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $sectors = $cvr_arrays['sectors'];
      $workcountries = $cvr_arrays['educountries'];
      $workdatabases = $cvr_arrays['workdatabases'];
      $currencies = $cvr_arrays['currencies'];
      $industryclasses = $cvr_arrays['industryclasses'];
    
  // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
  
  // STRUCTURE/FIELD RATING BEGINS
    // get data
    $company_id = $ratedobject->structure;
      // get the name of the university
      if ($company_id) {
         $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_company_entity WHERE company_id='$company_id'";
         $result = get_data_row($query);
         $company = $result->name;
         $country = $result->country;
         $industry = $result->industryclass;
         $total = $result->total;
      }
     
    $industryclass = $ratedobject->industryclass;
    // if the user forgot, take it from the database, if possible.
     if ((!$industryclass) && ($industry)) $industryclass = $industry;
     
    // While looping, add available specific rankings for each group sector
       // Higher Education
      if (($industryclass == "8530") || ($industryclass == "853")) {
          $available_rankings[] = 'CVR_QS12';
      }
      
     // Select the sector group (if not already selected, i.e. a letter)
    if (is_numeric($industryclass)) {
        // get first two numbers, if number is bigger
        if (strlen($industryclass) > 2) {
           $industryclass = substr($industryclass, 0, 2);
        }
     
    // Get more general rankings
      // Research
      if ($industryclass == "72") {
          $available_rankings[] = 'CVR_SCImago12';
          $available_rankings[] = 'CVR_QS12';
      }
      // Hospitals
      if ($industryclass == "86") {
          $available_rankings[] = 'CVR_USNewsH12';
      }
      
        // now get the sector group
        if (($industryclass == "01") || ($industryclass == "02") || ($industryclass == "03")) {
            $industryclass = "A";
        }
        elseif (($industryclass == "05") || ($industryclass == "06") || ($industryclass == "07")
                || ($industryclass == "08") || ($industryclass == "09")) {
            $industryclass = "B";
        }
        elseif ($industryclass == "35") {
            $industryclass = "D";
        }
        elseif (($industryclass == "36") || ($industryclass == "37")
                || ($industryclass == "38") || ($industryclass == "39")) {
            $industryclass = "E";
        }
        elseif (($industryclass == "41") || ($industryclass == "42")
                || ($industryclass == "43")) {
            $industryclass = "F";
        }
        elseif (($industryclass == "45") || ($industryclass == "46")
                || ($industryclass == "47")) {
            $industryclass = "G";
        }
        elseif (($industryclass == "49") || ($industryclass == "50") || ($industryclass == "51")
                || ($industryclass == "52") || ($industryclass == "53")) {
            $industryclass = "H";
        }
        elseif (($industryclass == "55") || ($industryclass == "56")) {
            $industryclass = "I";
        }
        elseif (($industryclass == "58") || ($industryclass == "59") || ($industryclass == "60")
                || ($industryclass == "61") || ($industryclass == "62") || ($industryclass == "63")) {
            $industryclass = "J";
        }
        elseif (($industryclass == "64") || ($industryclass == "65")
                || ($industryclass == "6")) {
            $industryclass = "K";
        }
        elseif ($industryclass == "68") {
            $industryclass = "L";
        }
        elseif (($industryclass == "69") || ($industryclass == "70") || ($industryclass == "71")
                || ($industryclass == "72") || ($industryclass == "73") || ($industryclass == "74")
                || ($industryclass == "75")) {
            $industryclass = "M";
        }
        elseif (($industryclass == "77") || ($industryclass == "78") || ($industryclass == "79")
                || ($industryclass == "80") || ($industryclass == "81") || ($industryclass == "82")
                || ($industryclass == "83")) {
            $industryclass = "N";
        }
        elseif ($industryclass == "84") {
            $industryclass = "O";
        }
        elseif ($industryclass == "85") {
            $industryclass = "P";
        }
        elseif (($industryclass == "86") || ($industryclass == "87") || ($industryclass == "88")) {
            $industryclass = "Q";
        }
        elseif (($industryclass == "90") || ($industryclass == "91") || ($industryclass == "92")
                || ($industryclass == "93")) {
            $industryclass = "R";
        }
        elseif (($industryclass == "94") || ($industryclass == "95") || ($industryclass == "96")) {
            $industryclass = "S";
        }
        elseif (($industryclass == "97") || ($industryclass == "98")) {
            $industryclass = "T";
        }
        elseif ($industryclass == "99") {
            $industryclass = "U";
        }
        else {
            $industryclass = "C";
        }
    }
      // Get more general rankings
        // Education
      if ($industryclass == "P") {
          $available_rankings[] = 'CVR_QS12';
      }
      // If no specific class available:
      if (!($available_rankings)) $available_rankings[0] = 'CVR_company_entity';
     
   // loop through all necessary rankings in the database
   foreach ($available_rankings as $keyrankings => $company_ranking) {
    // Loop only if necessary!
    if (!($workdatabases[$company_ranking] == 0)) {
         if ($company) {
             if ($company_ranking == 'CVR_company_entity') {
               $capital = log($total);
              // query for max value plus log
                // either take maximum wage from database (too risky, too much change)
                // or take a maximum expected wage...
                  //$query = "SELECT MAX(total) as total FROM {$CONFIG->dbprefix}$company_ranking WHERE industryclass='$industryclass' ";
                  //$result = get_data_row($query);
                // COULD BE WRONG - DATA_ROW GETS ARRAY, NOT OBJECT??
                 //$maxlog = log($result["total"]);
              // we take maximum theoretical value of 2012, log($418,000M) from Exxon Mobile 
               $maxlog = 26.77;
              // rank over 100:
               $performance->rating = $capital/$maxlog * 100;
             }   
             else {
             $query = "SELECT * FROM {$CONFIG->dbprefix}$company_ranking WHERE university='$company'";
             $performance = get_data_row($query);
             }
               // if it doesn't get a result, look for country value
               if (!$performance) {
               $query = "SELECT * FROM {$CONFIG->dbprefix}$company_ranking WHERE country='$country'";
               $performance2 = get_data_row($query);
                 if (!$performance2) {
                    $performance->rating = $workcountries[$country];
                 }
               }
            $rating = $performance->rating; 
            $rating = $rating * $workdatabases[$company_ranking];
            $ratings[] = $rating;
         }
     }
   }
     
        // CALCULATE MEAN: SUM OF ARRAY DIVIDED BY COUNT
     $sumratings = array_sum($ratings);
     $countratings = count($ratings);
     $meanrating = $sumratings/$countratings;
   
  // STRUCTURE/FIELD RATING ENDS 
   
  // EDUCATION TYPE CORRECTION FACTOR
    
     $ictype = $ratedobject->industryclass;
     if ($ictype) $typecorrection = $industryclasses[$ictype];
     else $typecorrection = $industryclasses['any'];
     
   // convert rating to a 0-0.5 scale ((-0.25) - 0.25)
     $netrating = ($meanrating/200)*$typecorrection - 0.25;
   
  // CVRANK ALGORITHM
  $z = $advanced_values['z'];
  $B = 1/pow(10, $z + $difficulty + $netrating);

  // CURRENCY FACTOR
    $currency = $ratedobject->currency;
    $currindex = $currencies[$currency];
    // if not set, suppose Big Mac Index = 0.5 (< US Dollar)
    if (!$currindex) $currindex = 0.5;
     
  // SCORING BEGINS
    // get data
    $scores = $ratedobject->wages;
      $maxscore = $advanced_values["maxscore"];
    $hours =  $ratedobject->hours;
    $weeks = $ratedobject->weeks; 
    $sector = $ratedobject->sector; 
    
  // For wage inflation, we should look for advanced values - more or less taxes, etc.
     
    // Calculate ratings: loop through types, scores and credits
     $countedscores = count ($scores);
     
     for ($i=0; $i<$countedscores; $i++) {
       $score = $scores[$i];
      // loop only if necessary
      if ($score) {
          // convert wage score to standard US dollars 
          $score = $currindex * $score;
          // convert wage/year to wage/week:
          $score = $score/52;
          // hours/week;
          $hour = $hours[$i];
          // convert wage/week to wage/hour
          $score = $score/$hour;
          
          // either take maximum wage from database (too risky, too much change)
          // or take a maximum ("reasonable") expected wage/week
          $maxwage = $advanced_values["maxwage"];
          // convert scores to a scale 0-100
          $score = (log($score))/$maxwage * 100;
         
         // Prove that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
          
	  // calculate standardized credits
          $week = $weeks[$i];
          if (!($week)) {
           // calculate Nr. weeks by date, in case they are set  
          }
          // use a standard of work per year; e.g. 40 hours/week 
          $stdweek = $hour/40;
          
          // convert Nr of weeks to Nr of standard weeks
          $workedstdweek = $week * $stdweek;
    
               // calculate subject's CVR
	        $probability = $score/100;
                $CVR = 1/$B * ($probability / (1 - $probability) );
                
              // add each loop
             $totalCVR += $CVR * $workedstdweek;
     }  
    }
       
      // adjust totalrating by the value given to work sectors
      $workCVR = $totalCVR * $sectors[$sector]; 
       
      // return the value!
      return $workCVR;
 }
 
 function waging ($ratedobject, $cvr_arrays) {
    
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $currencies = $cvr_arrays['currencies'];
      
  // CURRENCY FACTOR
    $currency = $ratedobject->currency;
    $currindex = $currencies[$currency];
    // if not set, suppose Big Mac Index = 0.5 (< US Dollar)
    if (!$currindex) $currindex = 0.5;
    
    // SCORING BEGINS
    // get data
    $scores = $ratedobject->wages;
      $maxscore = $advanced_values["maxscore"];
    $hours =  $ratedobject->hours;
    
  // For wage inflation, we should look for advanced values - more or less taxes, etc.
     
    // Calculate ratings: loop through types, scores and credits
     $countedscores = count ($scores);
     
     for ($i=0; $i<$countedscores; $i++) {
       $score = $scores[$i];
      // loop only if necessary
      if ($score) {
          // convert wage score to standard US dollars 
          $score = $currindex * $score;
          // convert wage/year to wage/week:
          $score = $score/52;
          // hours/week;
          $hour = $hours[$i];
          // convert wage/week to wage/hour
          $score = $score/$hour;
          
          // either take maximum wage from database (too risky, too much change)
          // or take a maximum ("reasonable") expected wage/week: US$ >10M/year = 200000/week - 5000/hour =log= 8.53
          $maxwage = 8.52;
          // convert scores to a scale 0-100
          $score = (log($score))/$maxwage * 100;
         
          $scores_array[] = $score;
      }
     }
     //First, select the maximum wage/week in scores
        $score = max($scores_array);
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
     
          return $score;
}

	/**
	 * Function langcvrate() in language
	 */

  function langcvrate($ratedobject, $cvr_arrays, $objects_array) {
    
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $languages = $cvr_arrays['languages'];
      $langfamilies = $cvr_arrays['langfamilies'];
      $langdbs = $cvr_arrays['langdbs'];
      // To be used more extensively in the future!
      // Equivalent to education letter grades, but for language exams and courses 
      $langgrades = $cvr_arrays['langgrades'];
    
  // LANGUAGE 
   $lang_id = $ratedobject->language;
   
   // LANGUAGE rating - Weber val
  // ToDO: When $langgrades is implemented, use true DBs with exam rankings;
  // e.g. by number of institutions that accept them, prestige,...
  
  // Weber's top ten (1999-2008): http://www.andaman.org/BOOK/reprints/weber/rep-weber.htm
  // Ratings divided by maximum (English - 37 over 40), divided by 100, +1 (points begins at 100%)
  $weberlang = array ("any" => 1, "eng" => 100, "fra" => 62.16, "spa" => 54.05, "rus" => 43.24, "ara" => 37.84,
    "cmn" => 35.13, "deu" => 32.43, "jpn" => 27.03, "por" => 27.03, "hin" => 24.32, "urd" => 24.32, 
    );
  
  // Forbes' increase in wage (max. 4%)
  //  http://www.forbes.com/2008/02/22/popular-foreign-languages-tech-language_sp08-cx_rr_0222foreign.html
  $forbeslang = array ("any" => 1, "fra" => 67.5, "spa" => 42.5, "rus" => 100, "ara" => 100,
    "cmn" => 100, "ita" => 100,
      // for CIA - unknown percentage - take 1 over 4
     "hin" => 25, "urd" => 25, "swa" => 25, "fas" => 25,
     );
  
  $langcount = 0;
   if ($langdbs["weber"] !=0) {
      $weber = $weberlang[$lang_id];
      if (!$weber) $weber = $weberlang["any"];
      $rating += $weber * $langdbs["weber"];
      $langcount++;
    }
   if ($langdbs["forbes"] !=0) {
      $forbes = $forbeslang[$lang_id];
      if (!$forbes) $forbes = $forbeslang["any"];
      $rating += $forbes * $langdbs["forbes"];
      $langcount++;
    }
    // @todo: by Nr. speakers; Nr. 2nd speakers; Combined;
    
   if ($langcount > 0) $netrating = ($rating/200)/$langcount - 0.25;
   else $netrating = -0.25;
   $difflang = $advanced_values['difflang'];
   $difficulty = $advanced_values[$difflang];
   
   // CVRANK ALGORITHM
   $z = $advanced_values['z'];
   $B = 1/pow(10, $z + $difficulty + $netrating);

   // SCORING BEGINS
    // get data
   $langtype = $ratedobject->langtype; 
   $maxscore = $advanced_values["maxscore"];
   $minlang1 = $advanced_values["minlang1"];
   $maxlang2 = $advanced_values["maxlang2"];
   
   // if it's mother tongue, maximum score
   // mother tongue 2!
   if ($langtype == "mother") $score = $minlang1;
   elseif ($langtype == "mother2") $score = $minlang2;
   // only if it is foreign (or not set), do calculations
   else {
    $scores = array();
     $scores["listening"] = $ratedobject->listening;
     $scores["reading"] = $ratedobject->reading;
     $scores["spokeninteraction"] = $ratedobject->spokeninteraction;
     $scores["spokenproduction"] = $ratedobject->spokenproduction;
     $scores["writing"] = $ratedobject->writing;
     // ToDo: use like Education letter-to-grades with $langgrades, when it is implemented
   
     foreach ($scores as $skey => $svalue) {
       // Use approx. IELTS/PTE equivalencies, with max. 90 for foreign language
       if ($svalue == "a1") $grade = 10;
       elseif ($svalue == "a2") $grade = 25;
       elseif ($svalue == "b1") $grade = 45;
       elseif ($svalue == "b2") $grade = 60;
       elseif ($svalue == "c1") $grade = 72.5;
       elseif ($svalue == "c2") $grade = 87.5;
       else $grade = 0;
       
       $score += $grade;
     }
     $score = $score/5;
   }
   $experience = $ratedobject->experience;
   $countex = 0;
   if (!$experience) $countex = 0; 
   elseif (!is_array($experience)) {
        $countex = 1;
   }
   else {
      foreach ($experience as $exkey => $exvalue) {
          $countex++;
      }
   }
   // there is a maximum of 4 countex, 100/4 = 25
    $explus = $countex * 0.25;
   // plus depends on score (it is a percentage) over 10% of the score
    $explus = $explus * $score/10;
    
    $score = $score + $explus;
    
      // Prove that scores are within limits >=0,
      if (($langtype == "mother") || ($langtype == "mother2")) {
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
      }
      else {
          if ($score > $maxlang2) $score = $maxlang2;	
          elseif ($score < 0) $score = 0;
      }
      
   // Calculate standard years needed
   // Classify languages like the Foreign Service Institute (FSI) of the US Department of State 
   // BUT this must be valid for all speakers, not just English
   // if "Indo-European - Romance", --> Category I
  
      $langfamily = $langfamilies[$lang_id];
      
   // if lang is mother tongue, give std value; no need to loop.
   if (($langtype == "mother") || ($langtype == "mother2")) $IFS = $advanced_values['mother'];
   else {
       // guarantee that $IFS is array
       $IFS = array();
       // get families from all other languages spoken by user
       foreach ($objects_array as $key => $value) {
         $lang2_id = $value->language;
         $lang2_type = $value->langtype;
           // for these calculations, mother2 = mother
           if ($lang2_type == "mother2") $lang2_type = "mother";
         // Loop only if language object is not the same!
         if ($lang2_id != $lang_id) {
           $lang2family = $langfamilies[$lang_id];
           // loop for each subfamily, and prove first that there is a subfamily...
              // if possible, use IFS actual classification. From
              // http://en.wikibooks.org/wiki/Language_Learning_Difficulty_for_English_Speakers
            // only available for Romance - Germanic - Celtic (equivalent to English)
          if (($lang2family[1] == "Romance") || ($lang2family[1] == "Germanic") || ($lang2family[1] == "Celtic")) {
           
           if (($langfamily[1] == "Romance") || ($langfamily[1] == "Germanic") || ($langfamily[1] == "Celtic")) {
               if ($lang_id == "deu") {
                 if ($IFS["langII"] != "mother") $IFS["langII"] = $lang2_type;
               }
               else { if ($IFS["langI"] != "mother") $IFS["langI"] = $lang2_type; }
           }
           
           elseif (($langfamily[1] == "Malayo-Polynesian") || ($langfamily[3] == "Bantu")) {
               if ($IFS["langII"] != "mother") $IFS["langII"] = $lang2_type;
           }
           
           elseif (($langfamily[1] == "Tibeto-Burman") || ($langfamily[0] == "Uralic") 
                || ($langfamily[0] == "Tai-Kadai") || ($langfamily[1] == "Vietic"))  {
               if ($IFS["langIV"] != "mother") $IFS["langIV"] = $lang2_type;
           }
           
           elseif (($lang_id == "ara") || ($langfamily[1] == "Sinitic") 
                || ($lang_id == "jpn") || ($lang_id == "kor") || ($lang_id == "mon"))  {
               if ($IFS["langV"] != "mother") $IFS["langV"] = $lang2_type;
           }
           // for the rest, langIII
           else  {
               if ($IFS["langIII"] != "mother") $IFS["langIII"] = $lang2_type;
           }
           // ?? if the user knew a Germanic-Romance-Celtic lang, break the foreach ??
          }
          // For those whose difficulty is not defined by IFS, use one level less (sanction)!
          else {
             if ($lang2family[0] == $langfamily[0]) {
             if ($IFS["langIII"] != "mother") $IFS["langIII"] = $lang2_type;
                if (($lang2family[1] != 0) && ($lang2family[1] == $langfamily[1])) {
                if ($IFS["langII"] != "mother") $IFS["langII"] = $lang2_type;
                    if  (($lang2family[1] != 0) && ($lang2family[2] == $langfamily[2])) {
                    if ($IFS["langI"] != "mother") $IFS["langI"] = $lang2_type;
                        if  (($lang2family[1] != 0) && ($lang2family[2] == $langfamily[2])) {
                        if ($IFS["lang0"] != "mother") $IFS["lang0"] = $lang2_type;
                        // if it is already the minimum, break foreach
                         elseif ($IFS["lang0"] == "mother"){
                           break;
                         }
                        }
                    }
                }
             }
           }
         }
       } 
       // if it is still not set after all loops, set to maximum
       if (empty($IFS)) $IFS["langIV"] = $lang2_type;
     }
     
     // Now select the minimum from the array:
       if ($IFS["lang0"]) { $langlev = "lang0"; $lang2type = $IFS["lang0"]; }
       elseif ($IFS["langI"]) { $langlev = "langI"; $lang2type = $IFS["langI"]; }
       elseif ($IFS["langII"]) { $langlev = "langII"; $lang2type = $IFS["langII"]; }
       elseif ($IFS["langIII"]) { $langlev = "langIII"; $lang2type = $IFS["langIII"]; }
       elseif ($IFS["langIV"]) { $langlev = "langIV"; $lang2type = $IFS["langIV"]; }
       elseif ($IFS["langV"]) { $langlev = "langV"; $lang2type = $IFS["langV"]; }
       else { $langlev = "lang0"; $lang2type = $IFS["lang0"]; }
       
     $stdyear = $advanced_values[$langlev];
     // put minimum
     if (!$stdyear) $stdyear = 1;
     
     // if we compared lang2, and lang2 was mother tongue, lessen difficulty:
     $stdmother2 = $advanced_values["mother2"];
     if ($lang2type == "mother") $stdyear = $stdyear * $stdmother2;
     else $stdyear = $stdyear * $stdforeign2;
  
           // calculate subject's CVR
	   $probability = $score/100;
           $CVR = 1/$B * ($probability / (1 - $probability) );
                
        $totalCVR = $CVR * $stdyear;
        
         // apply weight
        $langcoef = $languages[$lang_id];
        $langCVR = $totalCVR * $langcoef;
        
      // return the value!
      return $langCVR;
 }
 
 function langscore ($ratedobject, $cvr_arrays) {
    
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      // To be used more extensively in the future!
      // Equivalent to education letter grades, but for language exams and courses 
   // $langgrades = $cvr_arrays['langgrades'];
   
   $langtype = $ratedobject->langtype; 
   $maxscore = $advanced_values["maxscore"];
   $minlang1 = $advanced_values["minlang1"];
   $maxlang2 = $advanced_values["maxlang2"];
   
   // if it's mother tongue, maximum score
   if ($langtype == "mother") $score = $minlang1;
   // only if it is foreign (or not set), do calculations
   else {
    $scores = array();
     $scores["listening"] = $ratedobject->listening;
     $scores["reading"] = $ratedobject->reading;
     $scores["spokeninteraction"] = $ratedobject->spokeninteraction;
     $scores["spokenproduction"] = $ratedobject->spokenproduction;
     $scores["writing"] = $ratedobject->writing;
     // ToDo: use like Education letter-to-grades with $langgrades, when it is implemented
   
     foreach ($scores as $skey => $svalue) {
       // Use approx. IELTS/PTE equivalencies, with max. 90 for foreign language
       if ($svalue == "a1") $grade = 10;
       elseif ($svalue == "a2") $grade = 25;
       elseif ($svalue == "b1") $grade = 45;
       elseif ($svalue == "b2") $grade = 60;
       elseif ($svalue == "c1") $grade = 72.5;
       elseif ($svalue == "c2") $grade = 87.5;
       else $grade = 0;
       
       $score += $grade;
     }
     $score = $score/5;
   }
   $experience = $ratedobject->experience;
   $countex = 0;
   if (!$experience) $countex = 0; 
   elseif (!is_array($experience)) {
        $countex = 1;
   }
   else {
      foreach ($experience as $exkey => $exvalue) {
          $countex++;
      }
   }
   // there is a maximum of 4 countex, 100/4 = 25
    $explus = $countex * 0.25;
   // plus depends on score (it is a percentage) over 10% of the score
    $explus = $explus * $score/10;
    
    $score = $score + $explus;
    
      // Prove that scores are within limits >=0,
      if ($langtype == "mother") {
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
      }
      else {
          if ($score > $maxlang2) $score = $maxlang2;	
          elseif ($score < 0) $score = 0;
      }
      
      // return the value!
      return $score;
 }
 
	/**
	 * Function rescvrate() in research
	 */

  function rescvrate($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $resfields = $cvr_arrays['resfields'];
    
   // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
   
   $field = $ratedobject->field;
   $resfield = $resfields[$field];
  
    // get object data
  
   $articles = $ratedobject->articles;
   $citations = $ratedobject->citations;
   $maxcitations = $ratedobject->maxcitations;
   $impacts = $ratedobject->impacts;
   $maximpacts = $ratedobject->maximpacts;
   $eigens = $ratedobject->eigens;
   $maxeigens = $ratedobject->maxeigens;
   $authors = $ratedobject->authors;
   $positions = $ratedobject->positions;

   $impactcoef = $advanced_values['impact'];
   $eigencoef = $advanced_values['eigen'];
   $stdyear = $advanced_values['resyear'];
   $maxscore = $advanced_values["maxscore"];
   $z = $advanced_values['z'];
      
      // positions
      $posfactor = $advanced_values["posfactor"];
      
   $count_articles = count($articles);
 
   for ($i = 0; $i < $count_articles; $i++) {
      $citation = $citations[$i];
      $googscholar = $maxcitations[$i];
      
    // loop only if scores are set
    if ($citation || $googscholar)  {
       
      // RATING
      // get data and substitute "," by "."
      $impact = str_replace(",",".",$impacts[$i]);
      $maximpact =  str_replace(",",".",$maximpacts[$i]);
      $eigen =  str_replace(",",".",$eigens[$i]);
      $maxeigen =  str_replace(",",".",$maxeigens[$i]);
      
      $impactrating = $impact/$maximpact;
      $eigenrating = $eigen/$maxeigen;
      
       // prove they can't give (at this stage) more than 100% or less than 0%
        if ($impactrating > $maxscore) $impactrating = $maxscore;	
          elseif ($impactrating < 0) $impactrating = 0;
          
        if ($eigenrating > $maxscore) $eigenrating = $maxscore;	
          elseif ($eigenrating < 0) $eigenrating = 0;
          
     // now adjust by advanced values
       $rating = $impactrating * $impactcoef + $eigenrating * $eigencoef;
       
       $netrating = ($rating/2) - 0.25;
   
     // CVRANK ALGORITHM
     $B = 1/pow(10, $z + $difficulty + $netrating);
     
      // SCORE
        // guarantee they are integers
      $citation = intval ($citation);
      $googscholar = intval ($googscholar);
      // 2001-2012 - retrieved 10 March 2012 (rounded up): WOK / Google Scholar for 10 years
      // agriculture = 900/1400, 800, 600, 600, 600, 600 
      // biomed = 14100/19900, 10100, 4700, 3400, 3400, 3300
      // chemistry = 15700/64100, 8200, 7100, 5300, 3700, 3700
      // clinmed = 9200/?, 6400/6400, 5900, 4900, 5000, 4500 
      // computer = 8100/10200, 7700, 7100, 4600, 3900, 3200
      // economics = 1000/4900, 900, 900, 900, 700, 700 
      // engineering = 2100/4800, 2000, 1600, 1500, 1400, 1200
      // environment/ecology = 4500/5800, 2100, 1800, 1700, 1700, 1600
      // geosciences = 2000/2700, 2000, 2000, 1700, 1400, 1300
      // infectious = 2600/3900, 2500, 2500, 2400, 2400, 2400
      // material = 4300/5500, 4000, 4000, 3400, 2500, 1900, 1800
      // mathematics = 2800/7500, 2700, 1700, 1200, 1000, 800
      // microbio = 1800/2400, 1400, 1200, 1200, 1100, 1100, 1100
      // molbio = 5900/14000, 5500, 4700, 3500, 3100, 3100
      // multi = 800/1200, 500, 500, 500, 400, 400
      // neuro = 3100/4385, 2600, 2300, 1900, 1700, 1700
      // pharma = 1400/5200, 1200, 1100, 1100, 1000, 1000
      // physics = 5600/7500, 4200, 4000, 3600, 3200, 3100
      // plantanimal = 2000/2600, 1400, 1400, 1400, 1400, 1300
      // psycho = 2800/6100, 2400, 1900, 1900, 1700, 1600
      // social = 900/2200, 800, 700, 700, 700, 700
      // space = 5200/8600, 2800, 2400, 2100, 1900, 1800, 1800
    // take reasonable MAXIMUM as double the first value (for ~20-30 years); 
      if ($resfield[1] == "chemistry") $maximum = 31400;
      elseif ($resfield[1] == "biomed") $maximum = 28200; 
      elseif ($resfield[1] == "computer") $maximum = 16200;
      elseif ($resfield[1] == "molbio") $maximum = 11800;
      // genmed - unknown - classify conservatively as clinmed
      elseif (($resfield[1] == "clinmed") || ($resfield[1] == "genmed")) $maximum = 18400;
      elseif ($resfield[1] == "physics") $maximum = 11200;
      elseif ($resfield[1] == "space") $maximum = 10400;
      elseif (($resfield[1] == "environmental") || ($resfield[1] == "ecology")) $maximum = 9000;
      elseif ($resfield[1] == "material") $maximum = 8600;
      elseif ($resfield[1] == "neuro") $maximum = 6200;
      elseif ($resfield[1] == "mathematics") $maximum = 5600;
      elseif ($resfield[1] == "psycho") $maximum = 5600;
      elseif ($resfield[1] == "infectious") $maximum = 5200;
      elseif ($resfield[1] == "engineering") $maximum = 4200;
      elseif ($resfield[1] == "geosciences") $maximum = 4000;
      elseif (($resfield[1] == "plantanimal") || ($resfield[1] == "animal")) $maximum = 4000;
      elseif ($resfield[1] == "microbio") $maximum = 3600;
      elseif ($resfield[1] == "pharma") $maximum = 2800;
      elseif ($resfield[1] == "economics") $maximum = 2000;
      elseif ($resfield[1] == "social") $maximum = 1800;
      elseif ($resfield[1] == "multi") $maximum = 1600;
      elseif ($resfield[1] == "agriculture") $maximum = 900;
        // if research field is not set, take the maximum
      else $maximum = 31400;
      // for Google Scholar, take double value
      $maxgoogle = 2 * $maximum;
        // use log to minimize huge differences
      $score1 = log($citation)/log($maximum) * 100;
      $score2 = log($googscholar)/log($maxgoogle) * 100;
       $score = $score1 * $advanced_values["WOK"] + $score2 * $advanced_values["GOOG"];
         // prove numbers are not over- or infraestimated
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
       
        // calculate each article's CVR
	  $probability = $score/100;
          $CVR = 1/$B * ($probability / (1 - $probability) );
          
         $author = $authors[$i];
         $position = $positions[$i];
         // if Nr. authors is not set, set to 1
         if ($author <= 0) $author = 1;
         // if position is not set, set to last
         if ($position <= 0) $position = $author;
         // correct by number of authors and position, if there are more than 1 authors
         if ($author > 1) {
             $positioncoef = (1/$position) * $posfactor;
             $CVRpart = $CVR/$author;
             $CVR = $CVRpart + $CVRpart * $positioncoef;
         }
        // correct by stdyear, and add each loop
          $totalCVR += $CVR * $stdyear;  
   }
  }
  
  // PRIZE CORRECTION FACTOR 
  // prizes usually affect the whole research done, all articles written on the same subject
  // if they were given per article, the sum would be too much.
    // getdata
    $prizes = $ratedobject->prizes;
    $prcited = $advanced_values["prcited"];
    $prnobel = $advanced_values["prnobel"];
    $prother = $advanced_values["prother"];
    
    foreach ($prizes as $pkey => $pvalue) {
        if (($pvalue == "top10") || ($pvalue == "top20")) $prizecoef += $prcited;
        elseif (($pvalue == "nobel") || ($pvalue == "fields") || ($pvalue == "gairdner") || ($pvalue == "lasker") 
            || ($pvalue == "turing") || ($pvalue == "engineering1") || ($pvalue == "engineering2") 
            || ($pvalue == "engineering3") || ($pvalue == "economics")) $prizecoef += $prnobel;
        else $prizecoef += $prother;
    }   
    
    $prizevalue = 1 + $prizecoef;
    
    $resCVR = $totalCVR * $prizevalue;
         
       // apply weight
       $rescoef = $resfield[0];
       $resCVR = $resCVR * $rescoef;
        
      // return the value!
      return $resCVR;
 }

 function resscore ($ratedobject, $cvr_arrays) {
         
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $resfields = $cvr_arrays['resfields'];
    
  $field = $ratedobject->field;
  $resfield = $resfields[$field];
    
  $articles = $ratedobject->articles;
  
  $maxscore = $advanced_values["maxscore"];
    
   $count_articles = count($articles);
 
    // get object data
  
    $citations = $ratedobject->citations;
    $maxcitations = $ratedobject->maxcitations;
    
  for ($i = 0; $i < $count_articles; $i++) {
  
      $citation = $citations[$i];
      $googscholar = $maxcitations[$i];
      
    // loop only if scores are set
    if ($citation || $googscholar)  {
   
      $citation = intval ($citation);
      $googscholar = intval ($googscholar);
      // 2001-2012 - retrieved 10 March 2012 (rounded up): WOK / Google Scholar for 10 years
      // agriculture = 900/1400, 800, 600, 600, 600, 600 
      // biomed = 14100/19900, 10100, 4700, 3400, 3400, 3300
      // chemistry = 15700/64100, 8200, 7100, 5300, 3700, 3700
      // clinmed = 9200/?, 6400/6400, 5900, 4900, 5000, 4500 
      // computer = 8100/10200, 7700, 7100, 4600, 3900, 3200
      // economics = 1000/4900, 900, 900, 900, 700, 700 
      // engineering = 2100/4800, 2000, 1600, 1500, 1400, 1200
      // environment/ecology = 4500/5800, 2100, 1800, 1700, 1700, 1600
      // geosciences = 2000/2700, 2000, 2000, 1700, 1400, 1300
      // infectious = 2600/3900, 2500, 2500, 2400, 2400, 2400
      // material = 4300/5500, 4000, 4000, 3400, 2500, 1900, 1800
      // mathematics = 2800/7500, 2700, 1700, 1200, 1000, 800
      // microbio = 1800/2400, 1400, 1200, 1200, 1100, 1100, 1100
      // molbio = 5900/14000, 5500, 4700, 3500, 3100, 3100
      // multi = 800/1200, 500, 500, 500, 400, 400
      // neuro = 3100/4385, 2600, 2300, 1900, 1700, 1700
      // pharma = 1400/5200, 1200, 1100, 1100, 1000, 1000
      // physics = 5600/7500, 4200, 4000, 3600, 3200, 3100
      // plantanimal = 2000/2600, 1400, 1400, 1400, 1400, 1300
      // psycho = 2800/6100, 2400, 1900, 1900, 1700, 1600
      // social = 900/2200, 800, 700, 700, 700, 700
      // space = 5200/8600, 2800, 2400, 2100, 1900, 1800, 1800
    // take reasonable MAXIMUM as double the first value (for ~20-30 years); 
      if ($resfield[1] == "chemistry") $maximum = 31400;
      elseif ($resfield[1] == "biomed") $maximum = 28200; 
      elseif ($resfield[1] == "computer") $maximum = 16200;
      elseif ($resfield[1] == "molbio") $maximum = 11800;
      // genmed - unknown - classify conservatively as clinmed
      elseif (($resfield[1] == "clinmed") || ($resfield[1] == "genmed")) $maximum = 18400;
      elseif ($resfield[1] == "physics") $maximum = 11200;
      elseif ($resfield[1] == "space") $maximum = 10400;
      elseif (($resfield[1] == "environmental") || ($resfield[1] == "ecology")) $maximum = 9000;
      elseif ($resfield[1] == "material") $maximum = 8600;
      elseif ($resfield[1] == "neuro") $maximum = 6200;
      elseif ($resfield[1] == "mathematics") $maximum = 5600;
      elseif ($resfield[1] == "psycho") $maximum = 5600;
      elseif ($resfield[1] == "infectious") $maximum = 5200;
      elseif ($resfield[1] == "engineering") $maximum = 4200;
      elseif ($resfield[1] == "geosciences") $maximum = 4000;
      elseif (($resfield[1] == "plantanimal") || ($resfield[1] == "animal")) $maximum = 4000;
      elseif ($resfield[1] == "microbio") $maximum = 3600;
      elseif ($resfield[1] == "pharma") $maximum = 2800;
      elseif ($resfield[1] == "economics") $maximum = 2000;
      elseif ($resfield[1] == "social") $maximum = 1800;
      elseif ($resfield[1] == "multi") $maximum = 1600;
      elseif ($resfield[1] == "agriculture") $maximum = 900;
        // if it is not set, take a maximum max
      else $maximum = 50000;
      // for Google Scholar, take double value
      $maxgoogle = 2 * $maximum;
        // use log to minimize huge differences
      $score1 = log($citation)/log($maximum) * 100;
      $score2 = log($googscholar)/log($maxgoogle) * 100;
      
        // Do not allow errors to continue...
          if ($score1 > $maxscore) $score1 = $maxscore;	
          elseif ($score1 < 0) $score1 = 0;
          if ($score2 > $maxscore) $score2 = $maxscore;	
          elseif ($score2 < 0) $score2 = 0;
          
       $score = $score1 * $advanced_values["WOK"] + $score2 * $advanced_values["GOOG"];
        
          $scores_array[] = $score ;
     }    
   }
     //First, select the maximum score in research
        $score = max($scores_array);
        
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
          
      return $score;
 }
 
	/**
	 * Function pubcvrate() in research
	 */

  function pubcvrate($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $pubfields = $cvr_arrays['pubfields'];
    
   // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
     // underestimate academic merit of publication (academi levels are not necessary to publish):
    $difficulty = $difficulty * $advanced_values["levelfactor"];
   
   $typology = $ratedobject->typology;
   $pubfield = $pubfields[$typology];
  
    // get object data
  
   $articles = $ratedobject->articles;
   $citations = $ratedobject->citations;
   $eigens = $ratedobject->eigens;
   $authors = $ratedobject->authors;
   $positions = $ratedobject->positions;
   
   $stdyeartype = $pubfield[1];
   $stdyear = $advanced_values[$stdyeartype];
   $maxscore = $advanced_values["maxscore"];
   $z = $advanced_values['z'];
      
  // CURRENCY FACTOR
    $currency = $ratedobject->currency;
    $currindex = $currencies[$currency];
    // if not set, suppose Big Mac Index = 0.5 (< US Dollar)
    if (!$currindex) $currindex = 0.5;
          
      // positions
      $posfactor = $advanced_values["posfactor"];
      
      // RATING
       $netrating = -0.25;
   
     // CVRANK ALGORITHM
     $B = 1/pow(10, $z + $difficulty + $netrating);
     
   $count_articles = count($articles);
   
   for ($i = 0; $i < $count_articles; $i++) {
     
      // SCORE
        // guarantee they are integers
      $viewer = intval ($citations[$i]);
      
        // get earning in US$
      $earning = intval($eigens[$i]) * $currindex;
      
      // loop only if scores are set
    if ($viewer || $earning)  {
        
      // set maximum and correct $stdyear
      // according to Wikipedia - best-selling books
      if (($typology == "fiction") || ($typology == "written")) $maxview = 100000000;
      elseif (($typology == "nonfiction") || ($typology == "essay")) $maxview = 50000000;
       // take maximum from science research
      elseif ($typology == "patent") $maxview = 30000;
       // "reasonable" (massive!) conference through net 
      elseif (($typology == "conference") || ($typology == "course")) $maxview = 1500;
       // massive performances ever
      elseif (($typology == "performance") || ($typology == "live")) $maxview = 3500000;
       // from Google PageRank
      elseif ($typology == "blog") $maxview = 10;
       // most seen in YouTube
       // elseif (($pubfield[1] == "audiovisual") || ($pubfield[1] == "music") || ($pubfield[1] == "media")
       //        || ($pubfield[1] == "art"))  $maxview = 1000000000;
       else $maxview = 1000000000;
       
      // use log only if necessary (not in PageRank)
      if ($maxview > 10) $score1 = log($viewer)/log($maxview) * 100;
      else $score1 = $viewer/$maxview * 100;
       
      // take MaxEarning from e.g. Avatar earnings
      $maxearning = 2000000000;
      $score2 = log($earning)/log($maxearning) * 100;
        // Do not allow errors to continue...
          if ($score1 > $maxscore) $score1 = $maxscore;	
          elseif ($score1 < 0) $score1 = 0;
          if ($score2 > $maxscore) $score2 = $maxscore;	
          elseif ($score2 < 0) $score2 = 0;
          
        // use log to minimize huge differences
       $score = $score1 * $advanced_values["VIEW"] + $score2 * $advanced_values["SOLD"];
       
      // prove numbers are not over- or infraestimated
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
       
        // calculate each article's CVR
	  $probability = $score/100;
          $CVR = 1/$B * ($probability / (1 - $probability) );
      
         $author = $authors[$i];
         $position = $positions[$i];
         
         // if Nr. authors is not set, set to 1
         if ($author <= 0) $author = 1;
         // if position is not set, set to last
         if ($position <= 0) $position = $author;
         // correct by number of authors and position, if there are more than 1 authors
         if ($author > 1) {
             $positioncoef = (1/$position) * $posfactor;
             $CVRpart = $CVR/$author;
             $CVR = $CVRpart + $CVRpart * $positioncoef;
         }
        
        // correct by stdyear, and add each loop
          $totalCVR += $CVR * $stdyear;
    }
  }
  
  // PRIZE CORRECTION FACTOR 
  // prizes also affect the whole work done: publications/performance/media
    // getdata
    $prizes = $ratedobject->prizes;
    $prcited = $advanced_values["prcited"];
    $prnobel = $advanced_values["prnobel"];
    $prother = $advanced_values["prother"];
    
    foreach ($prizes as $pkey => $pvalue) {
        if (($pvalue == "top10") || ($pvalue == "top5")) $prizecoef += $prcited;
        elseif ($pvalue == "nobel") $prizecoef += $prnobel;
        else $prizecoef += $prother;
    }   
    
    $prizevalue = 1 + $prizecoef;
    $pubCVR = $totalCVR * $prizevalue;
         
       // apply weight
       $pubcoef = $pubfield[0];
       $pubCVR = $pubCVR * $pubcoef;
        
      // return the value!
      return $pubCVR;
 }
 
  function pubscore ($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $pubfields = $cvr_arrays['pubfields'];
    
   $typology = $ratedobject->typology;
   $pubfield = $pubfields[$typology];
  
    // get object data
  
   $articles = $ratedobject->articles;
   $citations = $ratedobject->citations;
   $eigens = $ratedobject->eigens;

   $maxscore = $advanced_values["maxscore"];
      
   
  // CURRENCY FACTOR
    $currency = $ratedobject->currency;
    $currindex = $currencies[$currency];
    // if not set, suppose Big Mac Index = 0.5 (< US Dollar)
    if (!$currindex) $currindex = 0.5;
          
   $count_articles = count($articles);
 
   for ($i = 0; $i < $count_articles; $i++) {
      
      // SCORE
        // guarantee they are integers
      $viewer = intval ($citations[$i]);
        // get earning in US$
      $earning = intval($eigens[$i]) * $currindex;
      
      // loop only if scores are set
    if ($viewer || $earning)  {
        
      // according to Wikipedia - best-selling books
      if (($pubfield[1] == "fiction") || ($pubfield[1] == "written")) $maxview = 100000000;
      elseif (($pubfield[1] == "nonfiction") || ($pubfield[1] == "essay")) $maxview = 50000000;
       // take maximum from science research
      elseif ($pubfield[1] == "patent") $maxview = 30000;
       // "reasonable" (massive!) conference 
      elseif (($pubfield[1] == "conference") || ($pubfield[1] == "course"))  
          $maxview = 1500;
       // massive performances ever
      elseif (($pubfield[1] == "performance") || ($pubfield[1] == "live"))  
          $maxview = 3500000;
       // from Google PageRank
      elseif ($pubfield[1] == "blog") $maxview = 10;
       // most seen in YouTube
      elseif (($pubfield[1] == "audiovisual") || ($pubfield[1] == "music") || ($pubfield[1] == "media")
               || ($pubfield[1] == "art"))  $maxview = 1000000000;
      else $maxview = 1000000000;
      
      // use log only if necessary (not in PageRank)
      if ($maxview > 10) $score1 = log($viewer)/log($maxview) * 100;
      else $score1 = $viewer/$maxview * 100;
      
      // take MaxEarning from e.g. Avatar earnings
      $maxearning = 2000000000;
      $score2 = log($earning)/log($maxearning) * 100;
      
        // Do not allow errors to continue...
          if ($score1 > $maxscore) $score1 = $maxscore;	
          elseif ($score1 < 0) $score1 = 0;
          if ($score2 > $maxscore) $score2 = $maxscore;	
          elseif ($score2 < 0) $score2 = 0;
          
        // use log to minimize huge differences
       $score = $score1 * $advanced_values["VIEW"] + $score2 * $advanced_values["SOLD"];
         // prove numbers are not over- or infraestimated
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
       
          $scores_array[] = $score ;
      }
     }
     //First, select the maximum score in research
        $score = max($scores_array);
        
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
  
      // return the value!
      return $score;
 }
 
	/**
	 * Function skillcvrate() in skills
	 */

  function skillcvrate($ratedobject, $cvr_arrays, $objects_array) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
      $skilltypes = $cvr_arrays['skilltypes'];
    
   // ACADEMIC DIFFICULTY LEVEL
   $level = $ratedobject->level;
   $difficulty = $advanced_values[$level];
   
   $typology = $ratedobject->skilltype;
   $skilltype = $skilltypes[$typology];
  
    // get object data
  
   $certs = $ratedobject->certs;
   $scores = $ratedobject->scores;
   
   $stdyear = $advanced_values["skillyear"];
   $skillcoef = $advanced_values["skillcoef"];
   $maxscore = $advanced_values["maxscore"];
   $z = $advanced_values['z'];
      
      // RATING
       $netrating = -0.25;
   
     // CVRANK ALGORITHM
     $B = 1/pow(10, $z + $difficulty + $netrating);
     
   $count_certs = count($certs);
   
   // COUNT same_skils (number of skills of the same type)
    $same_skills = 0;
    // from this object
    foreach ($scores as $sckey => $scvalue) {
          if (($scvalue) && ($scvalue != 0)) {
               $same_skills++;
          }
    }
    // from other objects of the same skilltype
    foreach ($objects_array as $key => $value) {
         $typology2 = $value->skilltype;
         $scores2 = $value->scores;
         if ($typology2 == $typology) {
             foreach ($scores2 as $sc2key => $sc2value) {
                 if (($sc2value) && ($sc2value != 0)) {
                  $same_skills++;
                 }
             }
          }
     }
             
   for ($i = 0; $i < $count_certs; $i++) {
     
      // SCORE
      $score = $scores[$i];
      // loop only if $score is set and is not 0
    if (($score) && ($score != 0))  {
        
      // prove numbers are not over- or infraestimated
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
     
        // calculate each article's CVR
	  $probability = $score/100;
          $CVR = 1/$B * ($probability / (1 - $probability) );
         
         $samecoef = pow($skillcoef, $same_skills);
         $CVR = $CVR * $samecoef;
         
        // correct by stdyear, and add each loop
          $totalCVR += $CVR * $stdyear;
      }
  }
  
       // apply weight
       $skiCVR = $totalCVR * $skilltype;
        
      // return the value!
      return $skiCVR;
 }
 
 function skillscore ($ratedobject, $cvr_arrays) {
     
      // GET arrays of selected values
      $advanced_values = $cvr_arrays['advanced_values'];
    
   $maxscore = $advanced_values["maxscore"];
   
   $scores = $ratedobject->scores;
   
     //First, select the maximum score in research
        $score = max($scores);
        
      // Proof that scores are within limits >=0, <100
          if ($score > $maxscore) $score = $maxscore;	
          elseif ($score < 0) $score = 0;
  
      // return the value!
      return $score;
 }
 
 function maximalCVR($rating, $pageowner, $field) {
   
   $query = "SELECT * FROM {$CONFIG->dbprefix}CVR_cv_rating WHERE field='$field'";
   $performance = get_data_row($query);
   
  if ($performance) {
   	
    if ($performance->rating >= $rating) {
    	
   	    $cvrrank = ((log($rating)) /(log($performance->rating))) * 100;
    }
    
    else { 
  	    $query = "UPDATE {$CONFIG->dbprefix}CVR_cv_rating 
          	  SET rating='$rating', id='$pageowner' 
          	  WHERE field='$field'";
              update_data($query);
        $cvrrank = 100;
    }
  }
  else {
  	$query = "INSERT INTO {$CONFIG->dbprefix}CVR_cv_rating 
          	  SET rating='$rating', id='$pageowner', field='$field'";
              insert_data($query);
        $cvrrank = 100;
  }
   
   return $cvrrank;
 }
 
 /**
	 * Function round_two() for CVR bar
  */
 function round_two($number) {
   $float_rounded=round($number * 100) / 100;
   return $float_rounded;
} 
  
// ******************** REGISTER ACTIONS ******************
register_action("resume/delete", false, $CONFIG->pluginspath . "resume/actions/delete.php");
register_action("resume/edit", false, $CONFIG->pluginspath . "resume/actions/edit.php");

if (get_plugin_setting('cvranking') == 'yes') { register_action("resume/cvranking_add", false, $CONFIG->pluginspath . "resume/actions/cvranking_add.php"); }
if (get_plugin_setting('education') == 'yes') { register_action("resume/education_add", false, $CONFIG->pluginspath . "resume/actions/education_add.php"); }
if (get_plugin_setting('workexperience') == 'yes') { register_action("resume/workexperience_add", false, $CONFIG->pluginspath . "resume/actions/workexperience_add.php"); }
if (get_plugin_setting('language') == 'yes') { register_action("resume/language_add", false, $CONFIG->pluginspath . "resume/actions/language_add.php"); }
if (get_plugin_setting('research') == 'yes') { register_action("resume/research_add", false, $CONFIG->pluginspath . "resume/actions/research_add.php"); }
if (get_plugin_setting('publication') == 'yes') { register_action("resume/publication_add", false, $CONFIG->pluginspath . "resume/actions/publication_add.php"); }
if (get_plugin_setting('experience') == 'yes') { register_action("resume/experience_add", false, $CONFIG->pluginspath . "resume/actions/experience_add.php"); }
if (get_plugin_setting('skill') == 'yes') { register_action("resume/skill_add", false, $CONFIG->pluginspath . "resume/actions/skill_add.php"); }
if (get_plugin_setting('skill_ciiee') == 'yes') { register_action("resume/skill_ciiee_add", false, $CONFIG->pluginspath . "resume/actions/skill_ciiee_add.php"); }

// ******************** REGISTER PAGE HANDLER ******************
register_page_handler('resumes', 'resume_page_handler');
register_page_handler('resumesprintversion', 'printed_page_handler');


// ******************** REGISTER EVENT HANDLERS ******************
register_elgg_event_handler('pagesetup', 'system', 'resume_pagesetup');
register_elgg_event_handler('init', 'system', 'resume_init');
