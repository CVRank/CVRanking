<?php

 $page_owner = $vars['owner'];
 
  //echo '<p><a href="' . elgg_get_site_url() . 'resumesprintversion/' . $page_owner->username . '" target="_blank">' . elgg_echo("resume:profile:gotoprint") . '</a></p>';
  //echo '<p><a href="' . elgg_get_site_url() . 'profile/' . $page_owner->username . '?view=xml-europass" target="_blank">' . elgg_echo("resume:profile:xml-europass") . '</a></p>';
 
  $printmenu = new ElggMenuItem;  
  $printmenu->setName('10');
  $printmenu->setText(elgg_echo('resume:profile:gotoprint'));
  $printmenu->setHref(elgg_get_site_url() . 'resumesprintversion/' . $page_owner->username);
  $printmenu->setPriority('500');
  
  $xmlmenu = new ElggMenuItem;
  $xmlmenu->setName('12');
  $xmlmenu->setText(elgg_echo('resume:profile:xml-europass'));
  $xmlmenu->setHref(elgg_get_site_url() . 'profile/' . $page_owner->username . '?view=xml-europass');
  $xmlmenu->setPriority('500');
  
  /*
   * For CVRank:
  $xmlmenu = new ElggMenuItem;
  $xmlmenu->setName('10');
  $xmlmenu->setText(elgg_echo('resume:profile:xml-cvrank'));
  $xmlmenu->setHref(elgg_get_site_url() . 'profile/' . $page_owner->username . '?view=xml-cvrank');
  $xmlmenu->setPriority('500');
   * 
   */
  $sidebarmenu = new ElggMenuItem;
  $sidebarmenu->setName('12');
  $sidebarmenu->setText(elgg_echo('resume:profile:print'));
  $sidebarmenu->addChild($printmenu);
  $sidebarmenu->addChild($xmlmenu);
  
  elgg_register_menu_item('page', $sidebarmenu);
