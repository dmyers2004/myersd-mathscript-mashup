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

// load add the programs that aren't waiting on a buffer 

// run them

// load the programs that are waiting for a buffer in descending order 20-19-18-17 since that last one aded is the one waiting

// get the buffer and pass it to the program

// continue with the each time until they are all done


$e = load('programs/program.exe');
$state = $e->run();

/* if state is 1 then it's still running */
if ($state['status'] == 1) {
	$e->pc++;
	$e->buffer = $state['buffername'];
	$user['saved'] = serialize($e);
	$e->pause = true;
}

//$restart = unserialize($user['saved']);
//$restart->run('Hello World');
