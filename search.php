<html>
<head>
<link href="event_style.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="DefaultValue.js" type="text/javascript"></script>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  

<script type='text/javascript'>
function test()
{
	var bounds = map.getBounds();			
	GetWorkerList( bounds );
	return false;
	//setMarkers(map, GetWorkerList( bounds ) );
}

$(document).ready(function() {
	//Assign default values
    console.log('Doing initialization');
	
	$('#when').DefaultValue('Enter the time. Ex: 2pm');
	$('#where').DefaultValue('Enter the location or click \"Find me!\"');
	
	$('#findme').click(function () {
		find_me(); return false;
	});

	$('#findgeneral').click(function () {
		codeAddress(); return false;
	});
	$('#test').click(function () {
		test(); return false;
	});
	initialize();
	find_me()
});

// -------------------- Map stuff ----------------------

    var map;
    var geocoder;
	var marker;
	var worker_markers = Array();;

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
	  
		function codeAddress() {
			if( marker != undefined )
				marker.setMap(null);
		    var address = document.getElementById("q").value;
		    if (geocoder) {
		      geocoder.geocode( { 'address': address}, function(results, status) {
		        if (status == google.maps.GeocoderStatus.OK) {
		          map.setCenter(results[0].geometry.location);
		          var marker = new google.maps.Marker({
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
			populate_workers();
		  }
 
function find_me()
{
	if (navigator.geolocation) {
	   navigator.geolocation.getCurrentPosition(function(position) {  
	   s = position.coords.latitude+","+position.coords.longitude;
		var addr = document.getElementById('q');
		addr.value = s;
		codeAddress();
	 }); 
	  
	} else {
	  alert("I'm sorry, but geolocation services are not supported by your browser.");
	}  
}

/**
 * Data for the markers consisting of a name, a LatLng and a zIndex for
 * the order in which these markers should display on top of each
 * other.
 */

function do_populate_workers( data, status )
{
	// Clean out old arrays
	for( w in worker_markers ){
		w.setMap( null );
	}
	
	worker_markers = Array();
	
	console.log( 'Received: ' + data );
	for( i = 0; i < data.length; i++ ){
		
		console.log( "Adding " + data[i][0] + ",  " + data[i][1] + ", " + data[i][2] + ", " + data[i][3] + " , " + data[i][4]  );

		var worker = data[i];
	    var myLatLng = new google.maps.LatLng(worker[1], worker[2]);
	    var marker = new google.maps.Marker({
	        position: myLatLng,
	        map: map,
	        // shadow: shadow,
	        // icon: image,
	        // shape: shape,
	        title: worker[3] + ", " + worker[4] + ", " + worker[5],
	        zIndex: i
	    });
	
	}
}

function populate_workers()
{
	var bounds = map.getBounds();
	
	console.log( "lng_min: " + bounds.getSouthWest().lng() );
	console.log( "lng_max: " + bounds.getNorthEast().lng() );
	console.log( "lat_min: " + bounds.getSouthWest().lat() ); 
	console.log( "lat_max: " + bounds.getNorthEast().lat() );
    
	$url ="http://localhost/publish/workwithme/GetWorkersNear.php";
/*	$.getJSON( $url, { lng_min: bounds.getSouthWest().lng(), 
					   lng_max: bounds.getNorthEast().lng(), 
					   lat_min: bounds.getSouthWest().lat(), 
					   lat_max: bounds.getNorthEast().lat() }, 
				do_populate_workers
	);*/
	$.getJSON( $url, { lng_min: "-400", 
					   lng_max: "400", 
					   lat_min: "-400", 
					   lat_max: "400" }, 
				do_populate_workers
	);
}

</script>
</head>
<body>
<div class='container1'>
<div class='item_title'>When?</div>
<input type="text" size="40" name="when" id="when" />
<!--
<button id='test'>test</button>
-->
<div class='item_title'>Where?</div>
<input type="text" size="40" name="q" id="q" '/>
<br/>
<input type="submit" name="find" id='findgeneral' value="Search" />
<input type="submit" name="find" id='findme' value="Find Me!" />
<span class='last_found_address'><span id="address"> </span></span>
<div id="map_canvas" style="width: 	500; height: 500px"></div>
</div>
</body>
</html>