<?php
/**
* Date format 
* @package project
* @author Wizard <sergejey@gmail.com>
* @copyright http://majordomo.smartliving.ru/ (c)
* @version 0.1 (wizard, 20:02:48 [Feb 22, 2017])
*/
//
//
class sys_date_format extends module {
/**
* sys_date_format
*
* Module class constructor
*
* @access private
*/
function sys_date_format() {
  $this->name="sys_date_format";
  $this->title="Date format";
  $this->module_category="<#LANG_SECTION_SYSTEM#>";
  $this->checkInstalled();
}
/**
* saveParams
*
* Saving module parameters
*
* @access public
*/
function saveParams($data=0) {
 $p=array();
 if (IsSet($this->id)) {
  $p["id"]=$this->id;
 }
 if (IsSet($this->view_mode)) {
  $p["view_mode"]=$this->view_mode;
 }
 if (IsSet($this->edit_mode)) {
  $p["edit_mode"]=$this->edit_mode;
 }
 if (IsSet($this->tab)) {
  $p["tab"]=$this->tab;
 }
 return parent::saveParams($p);
}
/**
* getParams
*
* Getting module parameters from query string
*
* @access public
*/
function getParams() {
  global $id;
  global $mode;
  global $view_mode;
  global $edit_mode;
  global $tab;
  if (isset($id)) {
   $this->id=$id;
  }
  if (isset($mode)) {
   $this->mode=$mode;
  }
  if (isset($view_mode)) {
   $this->view_mode=$view_mode;
  }
  if (isset($edit_mode)) {
   $this->edit_mode=$edit_mode;
  }
  if (isset($tab)) {
   $this->tab=$tab;
  }
}
/**
* Run
*
* Description
*
* @access public
*/
function run() {
 global $session;
  $out=array();
  if ($this->action=='admin') {
   $this->admin($out);
  } else {
   $this->usual($out);
  }
  if (IsSet($this->owner->action)) {
   $out['PARENT_ACTION']=$this->owner->action;
  }
  if (IsSet($this->owner->name)) {
   $out['PARENT_NAME']=$this->owner->name;
  }
  $out['VIEW_MODE']=$this->view_mode;
  $out['EDIT_MODE']=$this->edit_mode;
  $out['MODE']=$this->mode;
  $out['ACTION']=$this->action;
  $out['TAB']=$this->tab;
  $this->data=$out;
  $p=new parser(DIR_TEMPLATES.$this->name."/".$this->name.".html", $this->data, $this);
  $this->result=$p->result;
}
/**
* BackEnd
*
* Module backend
*
* @access public
*/
function admin(&$out) {
 if (isset($this->data_source) && !$_GET['data_source'] && !$_POST['data_source']) {
  $out['SET_DATASOURCE']=1;
 }
 if ($this->data_source=='sys_date_format' || $this->data_source=='') {
  if ($this->view_mode=='' || $this->view_mode=='search_sys_date_format') {
   $this->search_sys_date_format($out);
  }
  if ($this->view_mode=='edit_sys_date_format') {
   $this->edit_sys_date_format($out, $this->id);
  }
  if ($this->view_mode=='delete_sys_date_format') {
   $this->delete_sys_date_format($this->id);
   $this->redirect("?");
  }
 }
}
/**
* FrontEnd
*
* Module frontend
*
* @access public
*/
function usual(&$out) {
 $this->admin($out);
}
/**
* sys_date_format search
*
* @access public
*/
 function search_sys_date_format(&$out) {
  require(DIR_MODULES.$this->name.'/sys_date_format_search.inc.php');
 }
/**
* sys_date_format edit/add
*
* @access public
*/
 function edit_sys_date_format(&$out, $id) {
  require(DIR_MODULES.$this->name.'/sys_date_format_edit.inc.php');
 }
/**
* sys_date_format delete record
*
* @access public
*/
 function delete_sys_date_format($id) {
  $rec=SQLSelectOne("SELECT * FROM sys_date_format WHERE ID='$id'");
  // some action for related tables
  SQLExec("DELETE FROM sys_date_format WHERE ID='".$rec['ID']."'");
 }
 function propertySetHandle($object, $property, $value) {
   $table='sys_date_format';
   $properties=SQLSelect("SELECT ID FROM $table WHERE LINKED_OBJECT LIKE '".DBSafe($object)."' AND LINKED_PROPERTY LIKE '".DBSafe($property)."'");
   $total=count($properties);
   if ($total) {
    for($i=0;$i<$total;$i++) {
     //to-do
    }
   }
 }
 function processCycle() {
	 $table='sys_date_format';
	 $all_vals=SQLSelect("SELECT * FROM $table");
	 $total=count($all_vals);
	 if ($total) {
		for($i=0;$i<$total;$i++) {
			if ($all_vals[$i]['FORMAT']=="d1") {
				switch (date( "m", time())) {
					case '01':$mn='Января';break;
					case '02':$mn='Февраля';break;
					case '03':$mn='Марта';break;
					case '04':$mn='Апреля';break;
					case '05':$mn='Мая';break;
					case '06':$mn='Июня';break;
					case '07':$mn='Июля';break;
					case '08':$mn='Августа';break;
					case '09':$mn='Сентября';break;
					case '10':$mn='Октября';break;
					case '11':$mn='Ноября';break;
					case '12':$mn='Декабря';break;
				}
				$result=date( "d", time())." ".$mn." ".date( "Y", time())
			} elseif ($all_vals[$i]['FORMAT']=="n1") {
				switch (date("N", time())) {
					case 1:$result='Понедельник';break;
					case 2:$result='Вторник';break;
					case 3:$result='Среда';break;
					case 4:$result='Четверг';break;
					case 5:$result='Пятница';break;
					case 6:$result='Суббота';break;
					case 7:$result='Воскресенье');break;
				}
			} elseif ($all_vals[$i]['FORMAT']=="n2") {
				switch (date("N", time())) {
					case 1:$result='Пн';break;
					case 2:$result='Вт';break;
					case 3:$result='Ср';break;
					case 4:$result='Чт';break;
					case 5:$result='Пт';break;
					case 6:$result='Сб';break;
					case 7:$result='Вс');break;
				}
			} else {
				$result=date($all_vals[$i]['FORMAT'],time());
			}
			sg($all_vals[$i]['LINKED_OBJECT'].'.'.$all_vals[$i]['LINKED_PROPERTY'], $result);
		}		 
	 }
 }
/**
* Install
*
* Module installation routine
*
* @access private
*/
 function install($data='') {
  parent::install();
 }
/**
* Uninstall
*
* Module uninstall routine
*
* @access public
*/
 function uninstall() {
  SQLExec('DROP TABLE IF EXISTS sys_date_format');
  parent::uninstall();
 }
/**
* dbInstall
*
* Database installation routine
*
* @access private
*/
 function dbInstall() {
/*
sys_date_format - 
*/
  $data = <<<EOD
 sys_date_format: ID int(10) unsigned NOT NULL auto_increment
 sys_date_format: TITLE varchar(100) NOT NULL DEFAULT ''
 sys_date_format: FORMAT varchar(255) NOT NULL DEFAULT ''
 sys_date_format: LINKED_OBJECT varchar(100) NOT NULL DEFAULT ''
 sys_date_format: LINKED_PROPERTY varchar(100) NOT NULL DEFAULT ''
EOD;
  parent::dbInstall($data);
 }
// --------------------------------------------------------------------
}
/*
*
* TW9kdWxlIGNyZWF0ZWQgRmViIDIyLCAyMDE3IHVzaW5nIFNlcmdlIEouIHdpemFyZCAoQWN0aXZlVW5pdCBJbmMgd3d3LmFjdGl2ZXVuaXQuY29tKQ==
*
*/
