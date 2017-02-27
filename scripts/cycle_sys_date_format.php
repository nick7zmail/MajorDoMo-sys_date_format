<?php

chdir(dirname(__FILE__) . '/../');

include_once("./config.php");
include_once("./lib/loader.php");
include_once("./lib/threads.php");
set_time_limit(0);

// connecting to database
$db = new mysql(DB_HOST, '', DB_USER, DB_PASSWORD, DB_NAME);

include_once("./load_settings.php");
include_once(DIR_MODULES . "control_modules/control_modules.class.php");
$ctl = new control_modules();
include_once(DIR_MODULES . 'sys_date_format/sys_date_format.class.php');
$sys_date_format_module = new sys_date_format();
$sys_date_format_module->getConfig();

$old_second = date('s');
$old_minute = date('i');
$old_hour = date('h');

$tmp = SQLSelectOne("SELECT ID FROM sys_date_format LIMIT 1");
if (!$tmp['ID'])
   exit; // no devices added -- no need to run this cycle
echo date("H:i:s") . " running " . basename(__FILE__) . PHP_EOL;
$latest_check=0;
$checkEvery=5; // poll every 5 seconds

while (1)
{
   setGlobal((str_replace('.php', '', basename(__FILE__))) . 'Run', time(), 1);
   if ((time()-$latest_check)>$checkEvery) {
    $latest_check=time();
   }
	$s = date('s');
   	$m = date('i');
	$h = date('h');
	   if ($s != $old_second)
	   {
			$sys_date_format_module->processCycle_sec();
			$old_second = $s;
	   }	
	   if ($m != $old_minute)
	   {
			$sys_date_format_module->processCycle_min();
			$old_minute = $m;
	   }

	   if ($h != $old_hour)
	   {
			$sys_date_format_module->processCycle_hour();
			$old_hour = $h;
	   }

	   if (file_exists('./reboot') || IsSet($_GET['onetime']))
	   {
		  $db->Disconnect();
		  exit;
	   }
   sleep(1);
}
DebMes("Unexpected close of cycle: " . basename(__FILE__));
