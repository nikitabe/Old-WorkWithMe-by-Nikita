<?php

foreach ($_REQUEST as $k => $v) {
  print " <br/>  $k = $v\n";
  print "Value: " . ( $v );
}
$name 		 = $_REQUEST['my_name'];
$location 	 = $_REQUEST['q'];
$t_start  	 = $_REQUEST['my_start'];
$t_end 		 = $_REQUEST['my_end'];
$working_on  = $_REQUEST['my_working'];
$looking_for = $_REQUEST['my_looking'];
$comment 	 = $_REQUEST['my_comment'];
$lng	 	 = $_REQUEST['my_lng'];
$lat 		 = $_REQUEST['my_lat'];


// Check if this is a new request
$is_new = 1;
$u_id = $_COOKIE['workwithme'];
if( $u_id == null ){
	echo 'This is a new request';
	$is_new = 1;
	$u_id = uniqid();
	echo 'a: ';
	echo $u_id; 
	setcookie( 'workwithme', $u_id, time() + 60 * 60 * 24 );
}
else{
	$is_new = 0;
	echo 'This is an old request';
}

include 'DBConnection.php';

if( $is_new == 0 ){
	echo '<br/>This is an old request';
	$tsql = "SELECT name, location, start_time, end_time FROM Event WHERE uid = '" . $u_id . "'";

	$stmt = sqlsrv_query( $conn, $tsql);
	if( $stmt === false )
	{
		 echo "Error in statement preparation/execution.\n";
		 die( print_r( sqlsrv_errors(), true));
	}

	$check = sqlsrv_fetch( $stmt );
	echo "<br/>The query returned: $check";
	if( $check ){
		$username_new = sqlsrv_get_field( $stmt, 0);
		$location_new = sqlsrv_get_field( $stmt, 1);
		$start_time_new = sqlsrv_get_field( $stmt, 2);
		$end_time_new = sqlsrv_get_field( $stmt, 3);

		echo 'Name: ' + $username_new;
		echo 'Location' + $location_new;
		echo 'Start:' + $start_time_new;
		echo 'End:' + $end_time_new;
		
	}
	else
		$is_new = 1;

	sqlsrv_free_stmt( $stmt);
}
if( $is_new == 1 ){
	$tsql = "INSERT INTO Event( name, location, start_time, end_time, working_on, looking_for, comment, uid, latitude, longtitude) VALUES ( '$name', '$location', '$t_start', '$t_end', '$working_on', '$looking_for', '$comment', '$u_id', $lat, $lng )";
}
else{
	$tsql = "UPDATE Event SET name = '$name', location = '$location', start_time = '$t_start', end_time = '$t_end', working_on = '$working_on', looking_for = '$looking_for', comment = '$comment', longtitude = $lng, latitude = $lat WHERE uid = '" . $u_id . "'";
}

echo '<p>' . $tsql .'</p>';
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
	 echo "Error in statement preparation/execution.\n";
	 die( print_r( sqlsrv_errors(), true));
}
sqlsrv_free_stmt( $stmt);

include 'DBConnectionClose.php';

?>