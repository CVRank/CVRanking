<?php
/**
 * workexperience_form arrays
 */

$levels = array(
   ''=> '',
    'ISCE0' => elgg_echo('resume:work:level:ISCE0'),
    'ISCE1' => elgg_echo('resume:work:level:ISCE1'),
    'ISCE2' => elgg_echo('resume:work:level:ISCE2'),
    'ISCE3' => elgg_echo('resume:work:level:ISCE3'), 
    'ISCE4' => elgg_echo('resume:work:level:ISCE4'), 
    'ISCE5' => elgg_echo('resume:work:level:ISCE5'),     
    'ISCE6' => elgg_echo('resume:work:level:ISCE6'),      
    'ISCE7' => elgg_echo('resume:work:level:ISCE7'),     
    'ISCE8' => elgg_echo('resume:work:level:ISCE8'),    
    );
$level = $vars['entity']->level;
if (empty($level)) $level_options = '<option disabled="disabled" selected="selected"></option>';
else $level_options = '<option value="' . $level . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:work:level:' . $level) . '</option>';
foreach ($levels as $r => $c) { $level_options .= '<option value="' .$r. '">' . $c . '</option>'; }

$currencies = array(
   ''=> '',
    'USD' => elgg_echo('resume:work:currency:USD'),
    'GBP' => elgg_echo('resume:work:currency:GBP'),
    'EUR' => elgg_echo('resume:work:currency:EUR'), 
    'CNY' => elgg_echo('resume:work:currency:CNY'),
    'JPY' => elgg_echo('resume:work:currency:JPY'),
    'ARS' => elgg_echo('resume:work:currency:ARS'),
    'AUD' => elgg_echo('resume:work:currency:AUD'),        
    'BRL' => elgg_echo('resume:work:currency:BRL'),        
    'CAD' => elgg_echo('resume:work:currency:CAD'),       
    'CLP' => elgg_echo('resume:work:currency:CLP'),        
    'COP' => elgg_echo('resume:work:currency:COP'),        
    'CRC' => elgg_echo('resume:work:currency:CRC'),        
    'CZK' => elgg_echo('resume:work:currency:CZK'),        
    'DKK' => elgg_echo('resume:work:currency:DKK'),        
    'EGP' => elgg_echo('resume:work:currency:EGP'),        
    'HKD' => elgg_echo('resume:work:currency:HKD'),     
    'HUF' => elgg_echo('resume:work:currency:HUF'),     
    'INR' => elgg_echo('resume:work:currency:INR'),     
    'IDR' => elgg_echo('resume:work:currency:IDR'),     
    'ILS' => elgg_echo('resume:work:currency:ILS'),     
    'LVL' => elgg_echo('resume:work:currency:LVL'),     
    'LTL' => elgg_echo('resume:work:currency:LTL'),    
    'MYR' => elgg_echo('resume:work:currency:MYR'),     
    'MXN' => elgg_echo('resume:work:currency:MXN'),        
    'NZD' => elgg_echo('resume:work:currency:NZD'),         
    'NOK' => elgg_echo('resume:work:currency:NOK'),     
    'PKR' => elgg_echo('resume:work:currency:PKR'),     
    'PEN' => elgg_echo('resume:work:currency:PEN'),     
    'PHP' => elgg_echo('resume:work:currency:PHP'),     
    'PLN' => elgg_echo('resume:work:currency:PLN'),     
    'RUB' => elgg_echo('resume:work:currency:RUB'),     
    'SAR' => elgg_echo('resume:work:currency:SAR'),     
    'SGD' => elgg_echo('resume:work:currency:SGD'),     
    'ZAR' => elgg_echo('resume:work:currency:ZAR'),     
    'KRW' => elgg_echo('resume:work:currency:KRW'),     
    'LKR' => elgg_echo('resume:work:currency:LKR'),        
    'SEK' => elgg_echo('resume:work:currency:SEK'),        
    'CHF' => elgg_echo('resume:work:currency:CHF'),    
    'TWD' => elgg_echo('resume:work:currency:TWD'),     
    'THB' => elgg_echo('resume:work:currency:THB'),    
    'TRY' => elgg_echo('resume:work:currency:TRY'),     
    'AED' => elgg_echo('resume:work:currency:AED'),    
    'UAH' => elgg_echo('resume:work:currency:UAH'),     
    'UYU' => elgg_echo('resume:work:currency:UYU'),        
    );

$currency = $vars['entity']->currency;
if (empty($currency)) $currency_options = '<option disabled="disabled" selected="selected"></option>';
else $currency_options = '<option value="' . $currency . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:work:currency:' . $currency) . '</option>';
foreach ($currencies as $ly => $cy) { $currency_options .= '<option value="' .$ly. '">' . $cy . '</option>'; }
