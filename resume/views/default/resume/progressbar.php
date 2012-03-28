<?php
// Only required parameter
$imp = (int) $vars['importance'];
$cr = (int) (100-$imp); $cg = (int) $imp; $cb = 0;

// These are for customization
$position = (isset($vars['position'])) ? $vars['position'] : "float:left;position:relative; margin-right:10px;";
$width = (isset($vars['width'])) ? $vars['width'] : "150px";
$wrapperstyle = (isset($vars['wrapperstyle'])) ? $vars['wrapperstyle'] : "height:16px; border:1px solid black; background:darkgrey;";
$barstyle = (isset($vars['barstyle'])) ? $vars['barstyle'] : "width:$imp%; background-color:#84e984;";; // bar style
$contentstyle = (isset($vars['contentstyle'])) ? $vars['contentstyle'] : "width:$width; font-size:11px; font-weight:bold;"; // bar content style
$text = (isset($vars['text'])) ? $vars['text'] : "CVR : $imp%";
?>
<div style="<?php echo $position; ?>">
  <div style="<?php echo $wrapperstyle; ?> width:<?php echo $width; ?>;">
    <div style="position:relative; left: 0; top:0; height:100%; <?php echo $barstyle; ?>">
      <div style="position:relative; left:0.5ex; top:0; <?php echo $contentstyle; ?>"><?php echo $text; ?></div>
    </div>
  </div>
</div>
