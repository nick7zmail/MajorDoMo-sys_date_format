<?php
/*
* @version 0.1 (wizard)
*/
  if ($this->owner->name=='panel') {
   $out['CONTROLPANEL']=1;
  }
  $table_name='sys_date_format';
  $rec=SQLSelectOne("SELECT * FROM $table_name WHERE ID='$id'");
  $out['format']=$rec['FORMAT'];
  if ($this->mode=='update') {
   $ok=1;

   global $title;
   $rec['TITLE']=$title;
   if ($rec['TITLE']=='') {
    $out['ERR_TITLE']=1;
    $ok=0;
   }
  //updating 'FORMAT' (varchar)
   global $format;
   $rec['FORMAT']=$format;

   global $linked_object;
   $rec['LINKED_OBJECT']=$linked_object;

   global $linked_property;
   $rec['LINKED_PROPERTY']=$linked_property;
  //UPDATING RECORD
   if ($ok) {
    if ($rec['ID']) {
     SQLUpdate($table_name, $rec); // update
    } else {
     $new_rec=1;
     $rec['ID']=SQLInsert($table_name, $rec); // adding new record
    }
    $out['OK']=1;
	$out['format']=$rec['FORMAT'];
   } else {
    $out['ERR']=1;
   }
  }
  if (is_array($rec)) {
   foreach($rec as $k=>$v) {
    if (!is_array($v)) {
     $rec[$k]=htmlspecialchars($v);
    }
   }
  }
  outHash($rec, $out);
