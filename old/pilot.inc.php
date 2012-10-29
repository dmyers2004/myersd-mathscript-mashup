<?php
define(KEY,'thisisthesupersecretpassword');

function myencrypt($text) {
	$key = KEY;
	for ($i=0;$i<=strlen($text)-1;$i++) {
		$rtn .= chr(ord($text{$i}) ^ ord($key{$keyindex}));
		if ($keyindex++ == strlen($key)-1) $keyindex = 0;
	}
	return $rtn;
}

function save($file,$obj) {
	file_put_contents($file,myencrypt(base64_encode(serialize($obj))));
}

function load($file) {
	return unserialize(base64_decode(myencrypt(file_get_contents($file))));
}
