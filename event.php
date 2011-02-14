<HTML>
<HEAD>
<link href="event_style.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="DefaultValue.js" type="text/javascript"></script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

<script type='text/javascript'>

function mylog( str )
{
	//console.log( str );
}

function run_test()
{
	alert( $('#my_name').attr( 'default_value' ) );
	alert( $('#my_name').val() );
}

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
	initialize();
	find_me();
	$('#find').click(function () {
		showLocation(); return false;
	});

	$('#find_me').click(function () {
		find_me(); return false;
	});

	$('#q').submit(function () {
		showLocation(); return false;
	});
	
	$('#submit_location_button').click(function () {
		submit_my_location(); return false;
	});

});

function respond_to_submit_location()
{
	// improvement - change CSS
	var addr = document.getElementById('submit_result');
	addr.firstChild.data = 'Status updated.';
}


function get_submit_value( id_str )
{
	if( $(id_str).attr( 'default_value' ) == $(id_str).val() )
		return '';
	return $(id_str).val();
}

function submit_my_location()
{
	mylog( "My lat: " + marker.getPosition().lat() );
	mylog( "My lng: " + marker.getPosition().lng() );
	json = {
		my_name: 	get_submit_value('#my_name' ),
		q: 			get_submit_value('#q'),
		my_start: 	get_submit_value('#my_start'),
		my_end: 	get_submit_value('#my_end'),
		my_working: get_submit_value('#my_working'),
		my_looking: get_submit_value('#my_looking'),
		my_comment: get_submit_value('#my_comment'),
		my_lat: 	marker.getPosition().lat(),
		my_lng: 	marker.getPosition().lng(),
		}
		
	mylog( json );
	$.post('update_status.php', json, respond_to_submit_location );
	var addr = document.getElementById('submit_result');
	addr.firstChild.data = 'Submitting Status.';
}


    var map;
    var geocoder;
	var marker;

	function initialize() {
		geocoder = new google.maps.Geocoder();
	    var latlng = new google.maps.LatLng(-34.397, 150.644);
	    var myOptions = {
	      zoom: 14,
	      center: latlng,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
	    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	  }
	  
		function showLocation() {
			if( marker != undefined )
				marker.setMap(null);
		    var address = document.getElementById("q").value;
		    if (geocoder) {
				codeAddress( address );
		    }
		  }
 
 function codeAddress( address )
 {
	  geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		  map.setCenter(results[0].geometry.location);
		  marker = new google.maps.Marker({
			  map: map, 
			  position: results[0].geometry.location
			  });
		  var addr = document.getElementById('address');
		  addr.firstChild.data = results[0].formatted_address;			  

		} else {
		  alert("Geocode was not successful for the following reason: " + status);
		}
	  
	  });
 }
 
function find_me()
{
	if (navigator.geolocation) {
	   navigator.geolocation.getCurrentPosition(function(position) {  
	    s = position.coords.latitude+","+position.coords.longitude;
		mylog( s );
		var addr = document.getElementById('q');
		addr.value = s;
		
		codeAddress( addr );
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
$start = date("g:i a");
$end = '';
$working = '';
$looking = '';
$comment = '';

if (isset($_REQUEST['name'])){
	$name = $_REQUEST['name'];
}
?>
<!--
<button type="button" onclick="run_test()">test</button>
-->
<div class='container'>
<div class='item_title'>Name:</div>
<input type="text" size="40" name="my_name" id="my_name" value='<?php echo $name ?>'/>

<br/>
<div class='item_title'>Location:</div>
	<input type="text" name="q" value="<?php echo $location ?>" id="q" class="address_input" size="40" />
<br/>

<input type="submit" name="find" id='find' value="Search" />
<button type="button" id="find_me">Find me!</button>
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

<br/>
<button type="button" id="submit_location_button" name="submit_location_button">Submit</button>
<span id='submit_result' class='submit_result'> </span>
</div>
</BODY>
</HTML>