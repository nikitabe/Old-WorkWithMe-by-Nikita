<?php

include 'DBConnection.php';

$lng_min	 	 = $_REQUEST['lng_min'];
$lat_min	 	 = $_REQUEST['lat_min'];
$lng_max	 	 = $_REQUEST['lng_max'];
$lat_max	 	 = $_REQUEST['lat_max'];

$tsql = "SELECT event_id, latitude, longtitude, name, working_on, looking_for FROM event WHERE longtitude >= $lng_min AND longtitude <= $lng_max AND latitude >= $lat_min AND latitude <= $lat_max";


$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
	 echo "Error in statement preparation/execution.\n";
	 die( print_r( sqlsrv_errors(), true));
}
echo '[';
$is_first = 1;
while( sqlsrv_fetch( $stmt ) ){
	$event_id 		= sqlsrv_get_field( $stmt, 0);
	$lat 			= sqlsrv_get_field( $stmt, 1);
	$lng 			= sqlsrv_get_field( $stmt, 2);
	$name  			= sqlsrv_get_field( $stmt, 3, SQLSRV_PHPTYPE_STRING( SQLSRV_ENC_CHAR));
	$working_on 	= sqlsrv_get_field( $stmt, 4, SQLSRV_PHPTYPE_STRING( SQLSRV_ENC_CHAR));
	$looking_for  	= sqlsrv_get_field( $stmt, 5, SQLSRV_PHPTYPE_STRING( SQLSRV_ENC_CHAR));
	
	if( $is_first == 0 ) echo ",";
	echo "[\"$event_id\", \"$lat\",\"$lng\",\"$name\", \"$working_on\", \"$looking_for\"]";
	$is_first = 0;
}
echo ']';
include 'DBConnectionClose.php';
?>