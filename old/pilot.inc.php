<?php
define(KEY,'thisisthesupersecretpassword');

require_once 'bumoodle/mathscript.class.php';
require_once 'bumoodle/mathscript_array.php';
require_once 'bumoodle/mathscript_randomization.php';
require_once 'bumoodle/mathscript_binary.php';
require_once 'bumoodle/mathscript_control.php';
require_once 'bumoodle/mathscript_legacy.php';
require_once 'bumoodle/mathscript_debug.php';
require_once 'bumoodle/mathscript_string.php';
require_once 'bumoodle/mathscript_console.php';

function myencrypt($text) {
	$key = KEY;
	for ($i=0;$i<=strlen($text)-1;$i++) {
		$rtn .= chr(ord($text{$i}) ^ ord($key{$keyindex}));
		if ($keyindex++ == strlen($key)-1) $keyindex = 0;
	}
	return $rtn;
}

function dbupdate($id,$object) {
	$data['user_id'] = 1;
	$data['saved'] = myencrypt(base64_encode(serialize($obj)));
	$data['buffer'] = ($object->buffer == '') ? 0 : 1;
	$data['type'] = 1;
	safe_query(mysql_insertupdate('running',$data,'id = '.$id));
}

function dbremove($id) {
	$sql = "delete from running where id = ".$id;
	safe_query($sql);
}

function dbinsert($object) {
	$data['user_id'] = 1;
	$data['saved'] = myencrypt(base64_encode(serialize($object)));
	$data['buffer'] = ($object->buffer == '') ? 0 : 1;
	$data['type'] = 1;
	safe_query(mysql_insertupdate('running',$data));
}

function save($file,$obj) {
	file_put_contents($file,myencrypt(base64_encode(serialize($obj))));
}

function load($file) {
	return unserialize(base64_decode(myencrypt(file_get_contents($file))));
}

function create($text) {
	return unserialize(base64_decode(myencrypt($text)));
}

function dbconnect($host,$database,$user,$pass) {
  @mysql_connect($host,$user,$pass) or die('database connect error');
  @mysql_select_db($database) or die('database select error');
}

function mysql_columns_to_array($sql) {
  $result = safe_query($sql);
  $ary = array();
  while ($row = mysql_fetch_array($result))
  $ary[$row[0]] = $row[1];
  return $ary;
}

function safe_query($query,$log=true) {
  if ($log) logger($query);

  if (empty($query)) return FALSE;

  $result = @mysql_query($query);

  if (mysql_errno() > 0) {
  if (DEBUG == 1) echo('Query Failed <li>errorno='.mysql_errno().'<li>error='.mysql_error().'<li>query='.$query);
		die('<p><font size="+1" color="#ff3300" face="Helvetica, Geneva, Arial, SunSans-Regular, sans-serif"><b>Internal Error 101</b></font></p>');
  }
  return $result;
}

function mysql_insertupdate($t,$f,$where=false) {
  if (!$where) { // insert
    foreach ($f as $key => $value) $fields .= '`'.$key.'`, ';
    foreach ($f as $key => $value) $values .= "'".mysql_real_escape_string($value)."', ";
    $rtn_sql = 'insert into '.$t.' ('.rtrim($fields,', ').') values ('.rtrim($values,', ').')';
  } else { // update
    foreach ($f as $key => $value) $sql .= "`".$key."`='".mysql_real_escape_string($value)."', "; // quote it all can't hurt
    $rtn_sql = 'update '.$t.' set '.rtrim($sql,', ').' where '.$where;
  }
  return $rtn_sql;
}

function mysql_replace($t,$f) {
  foreach ($f as $key => $value) $fields .= '`'.$key.'`, ';
  foreach ($f as $key => $value) $values .= "'".mysql_real_escape_string($value)."', ";
  return 'replace into '.$t.' ('.rtrim($fields,', ').') values ('.rtrim($values,', ').')';
}

function logger($v) {
	if ($log_handle = fopen('logname.log','a')) {
		fwrite($log_handle,$v.chr(10));
		fclose($log_handle);
	}
}
