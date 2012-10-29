<pre>
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

$username = 'iceman';


$user['saved'] = null;

$program = file('program.txt');

$e = new MathScript(array('spreadsheet', 'basicmath', 'array', 'randomization', 'binary', 'control', 'legacy', 'debug', 'string', 'console'));
$e->suppress_errors = true;
$e->setup($program);

$state = $e->run();

/* if state is 1 then it's still running */
if ($state['status'] == 1) {
	$e->pc++;
	$e->buffer = $state['buffername'];
	$user['saved'] = serialize($e);
	$e->pause = true;
}

$e = null;
$e = unserialize($user['saved']);
$e->run('Hello World');

