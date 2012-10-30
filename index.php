<?php
$BASE_URL = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER["SCRIPT_NAME"]).'/';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Console</title>
		<link rel="stylesheet" type="text/css" href="wc.css" />
		<script type="text/javascript" language="javascript" src="jquery-1.8.2.js"></script>
		<script type="text/javascript" language="javascript" src="wc.js"></script>
		<script>var base_url = '<?=$BASE_URL ?>';</script>
	</head>
	<body>
	<div id="outputbox"></div>
	<div id="inputbox"></div>
	</body>
</html>