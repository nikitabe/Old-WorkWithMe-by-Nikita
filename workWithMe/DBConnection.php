<?php
/*Connect to the local server using Windows Authentication and
specify the AdventureWorks database as the database in use. */
$serverName = "NIKITA_L01\SQLEXPRESS";
$connectionInfo = array("Database" => "WorkWithMe");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
}
?>