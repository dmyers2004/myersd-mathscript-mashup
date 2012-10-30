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

$e = load('programs/program.exe');
$state = $e->run();

/* if state is 1 then it's still running */
if ($state['status'] == 1) {
	$e->pc++;
	$e->buffer = $state['buffername'];
	$saved = serialize($e);
	$e->pause = true;
}

$restart = unserialize($saved);
$restart->run('Hello World');

$login = load('programs/login.exe');
$state = $login->run();