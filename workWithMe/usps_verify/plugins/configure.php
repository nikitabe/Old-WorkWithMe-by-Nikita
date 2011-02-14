<?php
//this is a configuration file
define("USPS_TEST_SERVER","http://testing.shippingapis.com/ShippingAPITest.dll");
define("USPS_SERVER","http://production.shippingapis.com/ShippingAPI.dll");
define("USPS_USERNAME","*your username from usps goes here*");


//this defines your form fields on the page.  These should be the names of your fields on your page
define('ADDRESS1_FIELD','address1');
define('ADDRESS2_FIELD','address2');
define('CITY_FIELD','city');
define('STATE_FIELD','state');
define('ZIP_FIELD','zip');
//end defining form fields


//mapping table for state field
$stateMap = array();

$stateMap['AL'] = ""; 			//ALABAMA
$stateMap['AK'] = "";			//ALASKA
$stateMap['AS'] = ""; 			//AMERICAN SAMOA
$stateMap['AZ'] = "";			//ARIZONA
$stateMap['AR'] = ""; 			//ARKANSAS
$stateMap['CA'] = "";			//CALIFORNIA
$stateMap['CO'] = ""; 			//COLORADO
$stateMap['CT'] = "";			//CONNECTICUT
$stateMap['DE'] = ""; 			//DELAWARE
$stateMap['DC'] = "";			//DISTRICT OF COLUMBIA
$stateMap['FM'] = ""; 			//FEDERATED STATES OF MICRONESIA
$stateMap['FL'] = "";			//FLORIDA
$stateMap['GA'] = ""; 			//GEORGIA
$stateMap['GU'] = "";			//GUAM
$stateMap['HI'] = ""; 			//HAWAII
$stateMap['ID'] = "";			//IDAHO
$stateMap['IL'] = ""; 			//ILLINOIS
$stateMap['IN'] = "";			//INDIANA
$stateMap['IA'] = ""; 			//IOWA
$stateMap['KS'] = "";			//KANSAS
$stateMap['KY'] = ""; 			//KENTUCKY
$stateMap['LA'] = "";			//LOUISIANA
$stateMap['ME'] = ""; 			//MAINE
$stateMap['MH'] = "";			//MARSHALL ISLANDS
$stateMap['MD'] = ""; 			//MARYLAND
$stateMap['MA'] = "";			//MASSACHUSETTS
$stateMap['MI'] = ""; 			//MICHIGAN
$stateMap['MN'] = "";			//MINNESOTA
$stateMap['MS'] = ""; 			//MISSISSIPPI
$stateMap['MO'] = "";			//MISSOURI
$stateMap['MT'] = ""; 			//MONTANA
$stateMap['NE'] = "";			//NEBRASKA
$stateMap['NV'] = ""; 			//NEVADA
$stateMap['NH'] = "";			//NEW HAMPSHIRE
$stateMap['NJ'] = ""; 			//NEW JERSEY
$stateMap['NM'] = "";			//NEW MEXICO
$stateMap['NY'] = ""; 			//NEW YORK
$stateMap['NC'] = "";			//NORTH CAROLINA
$stateMap['ND'] = ""; 			//NORTH DAKOTA
$stateMap['MP'] = "";			//NORTHERN MARIANA ISLANDS
$stateMap['OH'] = ""; 			//OHIO
$stateMap['OK'] = "";			//OKLAHOMA
$stateMap['OR'] = ""; 			//OREGON
$stateMap['PW'] = "";			//PALAU
$stateMap['PA'] = ""; 			//PENNSYLVANIA
$stateMap['PR'] = "";			//PUERTO RICO
$stateMap['RI'] = ""; 			//RHODE ISLAND
$stateMap['SC'] = "";			//SOUTH CAROLINA
$stateMap['SD'] = ""; 			//SOUTH DAKOTA
$stateMap['TN'] = "";			//TENNESSEE
$stateMap['TX'] = ""; 			//TEXAS
$stateMap['UT'] = "";			//UTAH
$stateMap['VT'] = ""; 			//VERMONT
$stateMap['VI'] = "";			//VIRGIN ISLANDS
$stateMap['VA'] = ""; 			//VIRGINIA
$stateMap['WA'] = "";			//WASHINGTON
$stateMap['WV'] = "";			//WEST VIRGINIA
$stateMap['WI'] = ""; 			//WISCONSIN
$stateMap['WY'] = "";			//WYOMING

?>