<?php


$dictionary=array(

/* end module names */
'DATE_FORMAT'=>'Date format',
'FORMAT'=>'Format'

);

foreach ($dictionary as $k=>$v) {
 if (!defined('LANG_'.$k)) {
  define('LANG_'.$k, $v);
 }
}
