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

$user['script'] = file('program.txt');
$user['pc'] = 0;
$user['saved'] = null;

$e = new MathScript(array('spreadsheet', 'basicmath', 'array', 'randomization', 'binary', 'control', 'legacy', 'debug', 'string', 'console'));
$e->suppress_errors = true;
$e->setup($user['script']);

/* now run program */
for ($e->pc;$e->pc <= $e->lines;$e->pc++) {
	$e->run_line($user['script'][$e->pc]);
	//if (!empty($user['saved'])) {
		if ($e->last_error) die($e->last_error.' Line: '.($e->pc + 1));
	//}
}

//echo serialize($e);

function save_state() {
	global $e;
	$user['saved'] = serialize($e);
}

