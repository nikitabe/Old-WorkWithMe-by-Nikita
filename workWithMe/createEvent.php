<?php

//echo $_SERVER['HTTP_USER_AGENT'];

$username = $_POST['username'];
$location = $_POST['location'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$working_on = $_POST['working_on'];
$looking_for = $_POST['looking_for'];
$comment = $_POST['comment'];

include ('db_config.php');
include ('db_open.php');

$insert="INSERT INTO Event (username, location_desc, start_time, end_time, working_on, looking_for, comment) Values ('"
.$username.
"', '"
.$location_desc.
"','"
.$start_date.
 "','"
.$end_date.
"', '"
.$working_on.
"', '"
.$looking_for.
"', '"
.$comment.
"')   ";

//echo $insert;

mysql_query($insert) or die ('Error inserting database');

header( "viewEvents.html" );
?>