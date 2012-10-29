<pre>
<?php

require_once 'bumoodle/mathscript.class.php';
require_once 'bumoodle/mathscript_array.php';
require_once 'bumoodle/mathscript_randomization.php';
require_once 'bumoodle/mathscript_binary.php';
require_once 'bumoodle/mathscript_control.php';
require_once 'bumoodle/mathscript_legacy.php';
require_once 'bumoodle/mathscript_debug.php';
require_once 'bumoodle/mathscript_string.php';
require_once 'bumoodle/mathscript_console.php';

//get the script to execute
//$script = $_POST['script'];

//create a new math evaluator object
//$program = file('program.txt');

$user['saved'] = null;

$program = file('program.txt');

$e = new MathScript(array('spreadsheet', 'basicmath', 'array', 'randomization', 'binary', 'control', 'legacy', 'debug', 'string', 'console'));
$e->suppress_errors = true;
$e->setup($program);
$e->run();

/*
$e = null;
$e = unserialize($user['saved']);
$e->run();
*/

function save_state() {
	global $e;
	global $user;
	
	$user['saved'] = serialize($e);
}

