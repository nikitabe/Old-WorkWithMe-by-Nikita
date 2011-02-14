<HTML>
<HEAD>
<link href="event_style.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="DefaultValue.js" type="text/javascript"></script>
<script src="timepicker.js" type="text/javascript"></script>

<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false
    &amp;key=ABQIAAAA3MkIWluwirjPGWsAh4ELkBT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQdRoAQBDldyi17oFiloFbB_YTFTg"
    type="text/javascript">
  </script>



<script type='text/javascript'>
$(document).ready(function() {
	//Assign default values
	$('#my_name').DefaultValue('Enter your name');
	$('#my_location').DefaultValue('Where are you?');
	$('#my_start').DefaultValue('Starting Time');
	$('#my_end').DefaultValue('Ending Time');
	$('#my_working').DefaultValue('PHP, Design, Just Hangin\', Ruby, C++');
	$('#my_looking').DefaultValue('Developers developers developers developers...');
	$('#my_comment').DefaultValue('My project is AWESOME! You like totally should join...');
	$('#q').DefaultValue('Search for a location');
	//$('#my_start').timepicker();
	//$('#my_start').remove();

	initialize();
	find_me();
	$('#find').click(function () {
		showLocation(); return false;
	});
	$('#find').click(function () {
		showLocation(); return false;
	});
});

/*
json = {
	name: $('#my_name').val(),
$.post('/formaction.php', json, function () {});
*/

   var map;
    var geocoder;

    function initialize() {
      map = new GMap2(document.getElementById("map_canvas"));
      map.setCenter(new GLatLng(34, 0), 1);
      geocoder = new GClientGeocoder();
    }

    function addAddressToMap(response) {
      map.clearOverlays();
      if (!response || response.Status.code != 200) {
        alert("Sorry, we were unable to geocode that address");
      } else {
        place = response.Placemark[0];
        point = new GLatLng(place.Point.coordinates[1],
                            place.Point.coordinates[0]);
        marker = new GMarker(point);
        map.setCenter(point, 13);
        map.addOverlay(marker);
		var addr = document.getElementById('address');
		addr.firstChild.data = place.address;
      }
    }

    function showLocation() {
      var address = document.forms[0].q.value;
      geocoder.getLocations(address, addAddressToMap);
    }

    function findLocation(address) {
      document.forms[0].q.value = address;
      showLocation();
    }


function find_me()
{
	if (navigator.geolocation) {
	   navigator.geolocation.getCurrentPosition(function(position) {  
	   s = position.coords.latitude+","+position.coords.longitude;
		document.forms[0].q.value = s;
		showLocation();
	 }); 
	  
	} else {
	  alert("I'm sorry, but geolocation services are not supported by your browser.");
	}  
}


</script>
</HEAD>
<BODY>
<?php

$name = '';
$location = '';
$start = date("h:ia");

$end = date("h:ia", strtotime ("+2 hour"));
$working = '';
$looking = '';
$comment = '';

if (isset($_REQUEST['name'])){
	$name = $_REQUEST['name'];
}
?>

<?php include 'db_config.php'?>
<?php include 'db_open.php'?>

<?php include 'db_close.php'?>
<form>
<div class='item_title'>Name:</div>
<input type="text" size="40" name="my_name" id="my_name" value='<?php echo $name ?>'/>
<br/>
<div class='item_title'>Location:</div>
	<input type="text" name="q" value="<?php echo $location ?>" id="q" class="address_input" size="40" />
<br/>

<input type="submit" name="find" id='find' value="Search" />
<button type="button" onclick="find_me()">Find me!</button>
<span class='last_found_address'><span id="address"> </span></span>
<div id="map_canvas" style="width: 	270px; height: 150px"></div>

<div class='item_title'>Time:</div>
<input type="text" size="16" name="my_start" id="my_start" value='<?php echo $start ?>'/>
to
<input type="text" size="16" name="my_end" id="my_end" value='<?php echo $end ?>'/>
<br/><div class='item_title'>What are you doing?:</div>
<input type="text" size="40" name="my_working" id="my_working" value='<?php echo $working ?>'/>
<br/><div class='item_title'>What do you want people around to do?:</div>
<input type="text" size="40" name="my_looking" id="my_looking" value='<?php echo $looking ?>'/>
<br/><div class='item_title'>Comments:</div>
<input type="text" size="40" name="my_comment" id="my_comment" value='<?php echo $comment ?>'/>
</form>

</BODY>
</HTML>