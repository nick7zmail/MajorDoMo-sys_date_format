<?php


$dictionary=array(

/* end module names */
'DATE_FORMAT'=>'Формат даты',
'FORMAT'=>'Формат'

);

foreach ($dictionary as $k=>$v) {
 if (!defined('LANG_'.$k)) {
  define('LANG_'.$k, $v);
 }
}
