<?php

require_once('old/pilot.inc.php');

require_once 'bumoodle/mathscript.class.php';
require_once 'bumoodle/mathscript_array.php';
require_once 'bumoodle/mathscript_randomization.php';
require_once 'bumoodle/mathscript_binary.php';
require_once 'bumoodle/mathscript_control.php';
require_once 'bumoodle/mathscript_legacy.php';
require_once 'bumoodle/mathscript_debug.php';
require_once 'bumoodle/mathscript_string.php';
require_once 'bumoodle/mathscript_console.php';

$files = glob('programs/*.hck');
foreach ($files as $f) {
	$program = file($f);
	echo basename($f).'</br>';
	
	$e = new MathScript(array('spreadsheet', 'basicmath', 'array', 'randomization', 'binary', 'control', 'legacy', 'debug', 'string', 'console'));
	$e->suppress_errors = true;
	$e->setup($program);
	save('programs/'.substr(basename($f),0,-4).'.exe',$e);
}