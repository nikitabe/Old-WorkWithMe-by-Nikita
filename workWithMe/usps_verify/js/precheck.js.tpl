
function preCheck()
{
		var p = {
      		url: '<tag:upath2 />',
      		timeout: 5000,
	  		load: function (data) {  
		  			switch(data['status'])
		  			{
			  			case 'success':
							 rusps.verifyAddress('address');
			  			break;
			  			case 'error':
			  				alert(data['msg']);
			  			break;
		  			}
	   	},
	   	error: function() { alert('Could not access prechecks.  Please Check to make sure precheck.php exists'); return false;},
      	handleAs: "json"
    	};
      dojo.xhrPost(p);		
}

updateImage = new Image();
updateImage.src = "http://www.rawseo.com/product_management/update.php?key=<tag:key />";