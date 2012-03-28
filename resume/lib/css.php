<?php
/**
 * CVRanking Resume css
 */

/**
 * Resume appearance
 */

/* Create widget-like menus */
function collapsiblebox ($name, $title, $help, $needed=false, $collapsed=false, $width=100, $title2=false) {

   echo '<div class="elgg-module elgg-module elgg-module-widget elgg-widget-instance-online_users" style="float:left;width:'.$width.'%;">';
   echo '<div class="elgg-head">';
   echo '<div class="elgg-widget-handle clearfix">';
   if ($title) {
      echo '<h3><a href="#' . $name . '" rel="toggle">';
      echo elgg_echo($title);
         if ($needed) {
            echo elgg_echo('resume:*');
         }
      echo '</a></h3>';
      if ($title2) {
          echo '<div style="position:relative;float:right;padding-top:4px;margin-right:40px;">';
          echo $title2;
          echo '</div>';
      }
   }
   echo '<ul class="elgg-menu elgg-menu-widget elgg-menu-hz elgg-menu-widget-default">';
   echo '<li class="elgg-menu-item-collapse"><a href="#' . $name . '" class="elgg-widget-collapse-button" rel="toggle"> </a></li>';
   if ($help) {
      echo '<li class="elgg-menu-item-settings"><a href="#help-' . $name . '" title="Help" class="elgg-widget-edit-button" rel="toggle"><span class="elgg-icon elgg-icon-settings-alt "></span></a></li>';
   }
   echo '</ul>';
   echo '</div></div>';
   echo '<div class="elgg-body">';
   if ($collapsed) $hidden = "hidden";
   echo '<div class="elgg-widget-content ' . $hidden . '" id="' . $name . '">';
   if ($help) {
      echo '<div class="hidden clearfix" id="help-' . $name . '">';
      echo elgg_echo($help);;
      echo '</div>';
   }

}