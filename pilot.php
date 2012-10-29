<?php
require('pilot.inc.php');

$stack = array();
$labels = array();
$buffer = '';
$programcounter = 0;
$totallines = 0;
$test = false;

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
$e = new MathScript(array('spreadsheet', 'basicmath', 'array', 'randomization', 'binary', 'control', 'legacy', 'debug', 'string', 'console'));

$program = file('program.txt');

/* find all labels */
foreach ($program as $linenumber => $line) {
	if (substr($line,0,1) == '*') {
		$labels[substr($line,1)] = $linenumber;
	}
}

print_r($labels);

/* now run program */
$totallines = count($program);
for ($programcounter;$programcounter <= $totallines;$programcounter++) {
	
	$line = trim($program[$programcounter]);
	if (!trim($line) == '') {
		$lc = strtolower($line);
		$command = $lc{0};
		if ($lc{1} == 'y' || $lc{1} == 'n') $command .= $lc{1};
		
		$a = before(':',$line);
		$extra = substr($a,1);
		
		if ($lc{0} == 'y' || $lc{0} == 'n') $extra = $lc{0}.$extra;
		
		$options = after(':',$line);
		$trimmed = trim($options);
		
		echo '<pre>';
		echo '['.$line.']'.chr(10);
		echo '['.$command.']'.chr(10);
		echo '['.$extra.']'.chr(10);
		echo '['.$options.']'.chr(10);
		echo '['.$trimmed.']'.chr(10);
		echo '<hr>';
	}
}

function t_action($e,$output) {
	$str = str_replace('##','HGYRERDSD',$output);
	foreach ($e->vars as $key => $value) {
		$str = str_replace('#'.$key,$value,$str);
	}
	$str = str_replace('HGYRERDSD','#',$str);
	echo $str;
}
