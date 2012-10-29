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
