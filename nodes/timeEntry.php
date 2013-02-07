<?php

//allow access from any site
header("Access-Control-Allow-Origin: *");

//grab variables 
$date = $_POST['date'];
$time = $_POST['time'];
$project = $_POST['project'];
$task = $_POST['task'];
$event = $_POST['startstop'];

//get the right default hour
$now = date('H:i:s');
$now = strtotime($now) + 60*60;
$now = date('H:i:s', $now);

//get the right default date
$today = date('Y-m-d');
if (date('H', $now) == '00') {
	$today = strtotime($today . ' + 1 day');
	$today = date('Y-m-d', $today);
}

INCLUDE "db_connection.php";

//do the insert, depending on if the time / date is non default.
if(strlen($project) > 0 && strlen($time) > 0 && strlen($date) > 0) {
	$sql = "INSERT INTO `angelaj2_qs`.`tt`(`id`,`timestamp`,`date`,`time`,`project`,`task`,`startstop`) VALUES (NULL,CURRENT_TIMESTAMP,'$date','$time','$project','$task','$event')";
	mysql_query($sql);
} else if (strlen($project) > 0 && strlen($time) > 0){
	$sql = "INSERT INTO `angelaj2_qs`.`tt`(`id`,`timestamp`,`date`,`time`,`project`,`task`,`startstop`) VALUES (NULL,CURRENT_TIMESTAMP,'$today','$time','$project','$task','$event')";
	mysql_query($sql);
} else if (strlen($project) > 0) {
	$sql = "INSERT INTO `angelaj2_qs`.`tt`(`id`,`timestamp`,`date`,`time`,`project`,`task`,`startstop`) VALUES (NULL,CURRENT_TIMESTAMP,'$today','$now','$project','$task','$event')";
	mysql_query($sql);
}

//close the link to the db
mysql_close($link);

?>
<!doctype HTML>
<html>
	<head>
	</head>
	<body>
		nothing to see here, move along.
	</body>
</html>