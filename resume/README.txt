Summary :
- changes
- howto
- original plugin data structure
- 1st round data structure
- Europass data structure
- 2nd round data structure


#########################################
/* CVRANKING CHANGES TO ELGG
// TO CHANGE IN /views/input/pulldown.php FOR MULTIPLE INPUT/PULLDOWN SELECTION:


                if (is_array($vars['value'])) {
                    if (in_array($value, $vars['value'])) {
			echo "<option value=\"$encoded_value\" selected=\"selected\">$encoded_option</option>";
		    } 
                    else {
			echo "<option value=\"$encoded_value\">$encoded_option</option>";
                    }
                 }
                else {
		if ((string)$value == (string)$vars['value']) {
			echo "<option value=\"$encoded_value\" selected=\"selected\">$encoded_option</option>";
		} else {
			echo "<option value=\"$encoded_value\">$encoded_option</option>";
		}
                }

  
  // TO CHANGE IN /views/input/autocomplete.php TO SHOW value=name INSTEAD OF value=id:
 
$value_show = $vars['value_show'];
if(!$value_show) {
	$value_show = '';
}

 // Change also outside PHP:
 
<input type="text" class='autocomplete' name ='<?php echo $internalname; ?>_autocomplete' value='<?php echo $value_show?>' />
 
// TO CHANGE IN /engine/lib/input.php to show in AUTOCOMPLETE universities, companies,...
                         
                         case 'universities':
				$query = "SELECT * FROM {$CONFIG->dbprefix}CVR_university_entity as une
					WHERE une.name LIKE '%$q%'
					LIMIT $limit
				";

				if ($entities = get_data($query)) {
					foreach ($entities as $entity) {
						$json = json_encode(array(
							'name' => $entity->name,
							'desc' => $entity->country,
							'icon' => '',
							'guid' => $entity->university_id,
						));
						$results[$entity->name . rand(1,100)] = $json;
					}
				}
				break;
                                
                          case 'companies':
				$query = "SELECT * FROM {$CONFIG->dbprefix}CVR_company_entity as une
					WHERE une.name LIKE '%$q%'
					LIMIT $limit
				";

				if ($entities = get_data($query)) {
					foreach ($entities as $entity) {
						$json = json_encode(array(
							'name' => $entity->name,
							'desc' => $entity->country,
							'icon' => '',
							'guid' => $entity->company_id,
						));
						$results[$entity->name . rand(1,100)] = $json;
					}
				}
				break;
                                
                          case 'languages':
				$query = "SELECT * FROM {$CONFIG->dbprefix}CVR_language_entity as une
					WHERE une.name LIKE '%$q%'
					LIMIT $limit
				";

				if ($entities = get_data($query)) {
					foreach ($entities as $entity) {
						$json = json_encode(array(
							'name' => $entity->name,
							'desc' => $entity->level,
							'icon' => '',
							'guid' => $entity->language_id,
						));
						$results[$entity->name . rand(1,100)] = $json;
					}
				}
				break;
#########################################

CHANGES by Facyla :

1st round : 20110516
  - merge work + academic + training + reference into experience
  - keep language
  => change object type to "experience"
  => use subtype as a new metadata
  => use common data types (for all "experiences")

2nd round : 20110518
  - add several types and corresponding actions+forms+views : experience, language, education, workexperience, skill, skill_ciiee
    (note : ciiee refers to C2i2e but one can't use number in Elgg data types)
  - lazy normalization to Europass format (contact items are not detailed + skills don't include driving licences yet)
  - move listings from start.php to resume views
  - no longer replace the userdetails view (extend it instead)
  - collapsible boxes are collapsed by default
  - admin settings : activate data types


#########################################

#########################################
Object types : rWork, rAcademic

work
  startdate
  enddate
  organisation
  jobtitle
  description
  title
  subtype = "rWork"
academic
  level
  enddate
  institution
  achieved_title
  subtype = "rAcademic"
training
  training_type
  enddate
  institution
  name
  subtype = "rTraining"
reference
  name
  occupation
  organisation
  jobtitle
  tel
  subtype = "rReference"
language
  language
  written
  read
  spoken
  subtype = "rLanguage"



#########################################
1st round data structure :
experience
  (title) => déduit des autres infos = (typology :) jobtitle @ organisation
  structure => organisation / institution
  startdate
  enddate
  heading = jobtitle / achieved_title / training_type / name => intitulé du poste, diplôme, fonction, stage, etc.
  description / occupation => texte long
  +typology => subtype = rWork/rAcademic/rTraining/rReference/etc. => types d'expériences
  +importance => relative, appréciation personnelle
  +contact / name / tel => contact (champ court)
  +level ?

language => identical to original rLanguage object

Target data structure :
experience
  structure
  startdate
  enddate
  heading
  description
  typology : work (professionnelle) / academic (formation) / reference (projets et autres expériences)
  importance
  contact
  title



#########################################
// Europass data structure - indicative

workexperiencelist
  workexperience
    period
      from
        year
        month
        day
      to
        year
        month
        day
    position
      code
      label
    activities
      employer
        name
        address
          addressLine
          municipality
          postalCode
          country
            code
            label
    sector
      code
      label

educationlist
  education
    period
      from
        year
        month
        day
      to
        year
        month
        day
    title
    skills
    organisation
      name
        address
          addressLine
          municipality
          postalCode
          country
            code
            label
      type
    level
      code
      label
    educationalfield
      code
      label

languagelist
  language xsi:type="europass:mother"
    code
    label
  language xsi:type="europass:foreign"
    code
    label
    level
      (understanding)
      listening
       
      (speaking)
      spokeninteraction
      spokenproduction
      (writing)
      writing

skilllist
  skill type="social"
  skill type="organisational"
  skill type="technical"
  skill type="computer"
  skill type="artistic"
  skill type="other"
  structured-skill xsi:type="europass:driving"
    drivinglicence

misclist
  misc type="additional"
  misc type="annexes"


#########################################
// Implemented data structure => check resume/views/default/object/* or resume/actions/* to verify actual data structure

workexperience
  startdate
  enddate
  heading
  position
  activities
  structure
  contact
  sector

education
  startdate
  enddate
  title
  structure
  contact
  skills
  level
  field

language
  language
  type
  listening
  reading
  spokeninteraction
  spokenproduction
  writing

skill
  skilltype
  skillcontent

