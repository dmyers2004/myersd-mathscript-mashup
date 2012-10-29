<?php

function after($tag,$searchthis) {
	if (!is_bool(strpos($searchthis,$tag)))
	return substr($searchthis,strpos($searchthis,$tag)+strlen($tag));
}

function before($tag,$searchthis) {
	return substr($searchthis,0,strpos($searchthis, $tag));
}

function run_line($e,$line) {
	if (trim($line) == '') return;

	$line = ltrim(rtrim($line,chr(10)));

	$function = strtolower(before(' ',$line));
	if (empty($function)) $function = $line;

	$e->step2 = $trimmed = ltrim(after(' ',$line));

	if (substr($line,0,4) == 'if (') {
		$e->step2 = ltrim(after('):',$trimmed));
		$trimmed = before('):',$trimmed).')';
	}

	//echo '['.$function.']['.$line.']['.$trimmed.']['.$step2.']'.chr(10);

	if ($function == '//') {
		/* remark */

	} elseif (substr($line,0,1) == ':') {
		/* label */

	} elseif ($function == 'input') {
		$e->e('console_input('.$trimmed.')');

	} elseif ($function == 'print') {
		$e->e('console_print("'.$trimmed.'")');

	} elseif ($function == 'printl') {
		$e->e('console_printl("'.$trimmed.'")');

	} elseif ($function == 'goto') {
		$e->e('console_goto("'.$trimmed.'")');

	} elseif ($function == 'gosub') {
		$e->e('console_gosub("'.$trimmed.'")');

	} elseif ($function == 'return') {
		$e->e('console_return()');

	} elseif ($function == 'let') {
		$e->e($trimmed);

	} elseif ($function == 'if') {
		$e->e('console_if'.$trimmed);

	} elseif ($function == 'else:') {
		$e->e('console_else()');

	} elseif ($function == 'debug') {
		$e->e('console_debug()');

	} elseif ($function == 'end') {
		$e->e('console_end()');

	} else {

	}
}