<?php
require_once('old/pilot.inc.php');

$json['command'] = $_POST['command'];
$json['status'] = 200;
$json['session'] = $_POST['session'];
$json['running'] = false;
$json['carrot'] = true;

$command = $_REQUEST['command'];
$session = $_REQUEST['session'];
$user_id = 1;

/* Any running programs? */
dbconnect('localhost','console','root','root');


if ($command == 'login') {
	$sql = "delete from running where user_id = ".$user_id;
	mysql_query($sql);
}

$sql = "select * from running where user_id = ".$user_id." and buffer = 0 order by id desc";
$dbc = safe_query($sql);
while ($dbr = mysql_fetch_assoc($dbc)) {
	$exe = create($dbr['saved']);
	$state = $exe->run();

	/* if state is 1 then it's still running */
	if ($state['status'] == 1) {
		$exe->pc++;
		$exe->buffer = $state['buffername'];
		dbupdate($dbr['id'],$exe);
		$exe->pause = true;
	} else {
		dbremove($dbr['id']);
	}
}

$application_running = false;

/* run 1 waiting for a buffer */
$sql = "select * from running where user_id = ".$user_id." and buffer = 1 order by id desc limit 1";
$dbc = safe_query($sql);
while ($dbr = mysql_fetch_assoc($dbc)) {
	$application_running = true;
	ob_start();
	$exe = create($dbr['saved']);
	$state = $exe->run($command);
	$output = ob_get_clean();
	
	/* if state is 1 then it's still running */
	if ($state['status'] == 1) {
		$json['running'] = true;
		$exe->pc++;
		$exe->buffer = $state['buffername'];
		dbupdate($dbr['id'],$exe);
		$exe->pause = true;
	} else {
		dbremove($dbr['id']);
	}
	
	$json['output'] = $output;
}

/* run the newly requested program */
if (file_exists('programs/'.$command.'.exe') && !$application_running) {
	$json['command'] = '> '.$_POST['command'];
	ob_start();
	$exe = load('programs/'.$command.'.exe');
	$state = $exe->run();
	$output = ob_get_clean();
	/* if state is 1 then it's still running */
	if ($state['status'] == 1) {
		$json['carrot'] = false;
		$exe->pc++;
		$exe->buffer = $state['buffername'];
		dbinsert($exe);
		$exe->pause = true;
	}
	$json['output'] = $output;
} else if (!$application_running) {
	$json['command'] = '> '.$_POST['command'];
	$json['output'] = $command.': command not found'.chr(10);
}

echo json_encode($json);