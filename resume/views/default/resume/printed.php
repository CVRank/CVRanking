<?php
$page_owner = $vars['owner'];
$iconsize = "medium";

// wrap all profile info - name, picture and links ?>

<div id="profile_info_printed">
  <?php
  echo "<h1>" . $page_owner->name . "</h1><br/>";
  echo "<strong>" . elgg_echo("resume:profileurl") . "&nbsp;: </strong><a href=\"" . $page_owner->getUrl() . "\">" . $page_owner->getUrl() . "</a>";
  //'align' => "left",
  ?>
  <br/>
  
  <div class="print-block"> 
    <?php
    /*
    // Simple XFN
    $rel_type = "";
    if (elgg_get_logged_in_user_guid() == $page_owner->guid) { $rel_type = 'me'; } 
    elseif (check_entity_relationship(elgg_get_logged_in_user_guid(), 'friend', $page_owner->guid)) { $rel_type = 'friend'; }
    if ($rel_type) { $rel = "rel=\"$rel_type\""; }

    //insert a view that can be extended
    echo elgg_view("profile/status", array("entity" => $vars['entity']));
    
    $even_odd = null;
    if (is_array($CONFIG->profile) && sizeof($CONFIG->profile) > 0) {
      foreach ($CONFIG->profile as $shortname => $valtype) {
        if ($shortname != "description") {
          $value = $page_owner->$shortname;
          if (!empty($value)) {
            //This function controls the alternating class
            $even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even'; ?>
            <p class="<?php echo $even_odd; ?>">
              <b><?php echo elgg_echo("profile:{$shortname}"); ?>&nbsp;: </b>
              <?php $options = array( 'value' => $page_owner->$shortname );
              if ($valtype == 'tags') { $options['tag_names'] = $shortname; }
              echo elgg_view("output/{$valtype}", $options); ?>
            </p>
            <?php
          }
        }
      }
    }
    */
    ?>
     
  </div><!-- /#print-block -->
  
  <?php if (!elgg_get_plugin_setting('user_defined_fields', 'profile')) { ?>
    <div class="print-block">
      <p class="profile_aboutme_title"><b><?php echo elgg_echo("profile:aboutme"); ?></b></p>
      <?php if ($page_owner->isBanned()) {
        echo '<div>' . elgg_echo('profile:banned') . '</div><!-- /#profile_info_column_right -->';
      } else {
        echo elgg_view('output/longtext', array('value' => $page_owner->description));
        //echo autop(filter_tags($vars['entity']->description));
      } ?>
    </div><!-- /#print-block -->
  <?php } ?>
  
</div><!-- /#profile_info_printed -->


<div>
  <?php echo $title;
  
  if ((elgg_get_plugin_setting('education') == 'yes') && (elgg_get_entities(array('types' => 'object', 'subtypes' => 'education', 'container_guids' => array($page_owner->guid), 'limit' => 0)))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:educations'); ?></h3>
      <?php echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'education', 'container_guids' => array($page_owner->guid), 'limit' => 0)); ?>
    </div> <?php
  }
  
  if ((elgg_get_plugin_setting('workexperience') == 'yes') && (elgg_get_entities(array('types' => 'object', 'subtypes' => 'workexperience', 'container_guids' => array($page_owner->guid), 'limit' => 0)))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:workexperiences'); ?></h3>
      <?php echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'education', 'container_guids' => array($page_owner->guid), 'limit' => 0)); ?>
    </div> <?php
  }
  
  if ((elgg_get_plugin_setting('language') == 'yes') && (elgg_get_entities(array('types' => 'object', 'subtypes' => 'language', 'container_guids' => array($page_owner->guid), 'limit' => 0)))) { ?>
      <div class="print-block"><h3><?php echo elgg_echo('resume:languages'); ?></h3>
      <?php echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'language', 'container_guids' => array($page_owner->guid), 'limit' => 0)); ?>
    </div> <?php
  }
  
  if ((elgg_get_plugin_setting('research') == 'yes') && (elgg_get_entities(array('types' => 'object', 'subtypes' => 'research', 'container_guids' => array($page_owner->guid), 'limit' => 0)))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:researches'); ?></h3>
      <?php echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'research', 'container_guids' => array($page_owner->guid), 'limit' => 0)); ?>
    </div> <?php
  }
  
  if ((elgg_get_plugin_setting('publication') == 'yes') && (elgg_get_entities(array('types' => 'object', 'subtypes' => 'publication', 'container_guids' => array($page_owner->guid), 'limit' => 0)))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:publications'); ?></h3>
      <?php echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'publication', 'container_guids' => array($page_owner->guid), 'limit' => 0)); ?>
    </div> <?php
  }
  
  if ((elgg_get_plugin_setting('skill') == 'yes') && (elgg_get_entities(array('types' => 'object', 'subtypes' => 'skill', 'container_guids' => array($page_owner->guid), 'limit' => 0)))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:skills'); ?></h3>
      <?php echo elgg_list_entities(array('types' => 'object', 'subtypes' => 'skill', 'container_guids' => array($page_owner->guid), 'limit' => 0)); ?>
    </div> <?php
  }
  
  // Show a message if there aren't any user objects.
  if (!elgg_list_entities(array('types' => 'object', 'subtypes' => 'education', 'container_guids' => array($page_owner->guid), 'limit' => 0))
      && !elgg_list_entities(array('types' => 'object', 'subtypes' => 'workexperience', 'container_guids' => array($page_owner->guid), 'limit' => 0))
      && !elgg_list_entities(array('types' => 'object', 'subtypes' => 'language', 'container_guids' => array($page_owner->guid), 'limit' => 0))
      && !elgg_list_entities(array('types' => 'object', 'subtypes' => 'research', 'container_guids' => array($page_owner->guid), 'limit' => 0))
      && !elgg_list_entities(array('types' => 'object', 'subtypes' => 'publication', 'container_guids' => array($page_owner->guid), 'limit' => 0))
      && !elgg_list_entities(array('types' => 'object', 'subtypes' => 'skill', 'container_guids' => array($page_owner->guid), 'limit' => 0))
  ) { echo '<div class="print-block"><h3>' . elgg_echo('resume:noentries') . '</h3></div>'; }
  ?>
</div>

