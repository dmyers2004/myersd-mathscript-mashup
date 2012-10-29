<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>HTML5 Basic Template</title>
		<link href="assets/css/site.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="assets/js/jquery.1.8.2.js"></script>
		<script type="text/javascript" src="assets/js/site.js"></script>
	</head>
	<body>
		<pre>
<?php

//require('bumoodle/evalmath.class.php');

//include the math evaluator 
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
//$e->suppress_errors = true; 

//$e = new EvalMath();

$e->e('user("health",45)');
$e->e('a = 2');
$e->e('b = a + 1');
$e->e('c = a * 4');
$e->e('d = ((32 + 8) / 4) * 1.3231');
$e->e('e = 32 > 24');
$e->e('f = (32 + 34) < 24');
$e->e('g = "hello"');
$e->e('h = g : " more"');
$e->e('i = average(1,2,3,4,5,6,7,8,9)');
$e->e('j = rand(1,100)');
$e->e('k = strlen(h)');
$e->e('l = k : " length"');
$e->e('m[cat] = 11');
$e->e('m[2] = 22');
$e->e('n = array_count("m")');
$e->e('o = in_array_group("m","m[]")');
$e->e('p = (j+b)/2');
$e->e('q = array_key_name("m[cat]")');
$e->e('r[1][2] = 2');
$e->e('s = oneOf(2,4,6,8,10)');
$e->e('t = md5(j)');
$e->e('u = user("health")');
$e->e('y(23 < 8)');

print_r($e->vars());
var_dump($e->vars());
print_r($e->funcs());

print_r($e->vars);



?>
		</pre>
	</body>
</html>