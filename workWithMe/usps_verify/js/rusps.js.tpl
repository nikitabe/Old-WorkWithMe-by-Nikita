
var mutex = false;

//this will be used to check a zipcode and retrieve a city/state
function checkZip(event)
{		
	var zipcode = document.getElementsByName('<tag:zip_field />')[0];
	
	switch(event.type)
	{
		case 'keyup':
			var keyPressed = event.keyCode;
	
			//only send request when 5 numbers are typed (0-9)
			if ((keyPressed >= 48) && (keyPressed <= 57))
			{
				if (zipcode.value.length == 5 && !mutex)
				{
					mutex = true;
					rusps.verifyAddress('zipcode');
				}
			}
		break;
		default:
			if (zipcode.value.length == 5 && !mutex)
			{
				mutex = true;
				rusps.verifyAddress('zipcode');
			}
	}	
}

//first checks to make sure all of the necessary values are there, then checks the address for validation
function checkAddress()
{		
	var address_1 	= document.getElementsByName('<tag:address1_field />')[0].value;
	var state 		= document.getElementsByName('<tag:state_field />')[0].value;
	var city 		= document.getElementsByName('<tag:city_field />')[0].value;
	
	if ((address_1 != "") && (state != "") && (city != "") && !mutex)
	{
		mutex = true;
		rusps.verifyAddress('address');
	}
}

//***********************************************************************
//* USPS toolkit - address verfication
//* http://www.rawseo.com - analytics and e-commerce applications
//***********************************************************************

var rusps = {
	formname:  "",
	ftimeout: 5000,
	autocheck: true,
	autocheckmode: 3,
	fconfirm: false,
	fconfmsg: "Is this the address you meant?",
	fill: [],
	fcallback: "",
	ferror: "",
	verifyAddress: function (cType) {
		var p = {
      	url: '<tag:upath />'+'?cType='+cType,
      	form: this.formname,
      	timeout: this.ftimeout,
      	confirmi: this.fconfirm,
      	filli: this.fill,
      	fconfmsgi: this.fconfmsg,
      	fcallbacki: this.fcallback,
      	ferrori: this.ferror,
	  	load: function (data) {  
	  		mutex = false;
		  	//check to see if any of our values are undefined, and if so, set them to nothing
			if ((typeof data['Address1']) == 'undefined') data['Address1'] = '';
			if ((typeof data['Address2']) == 'undefined') data['Address2'] = '';
			if ((typeof data['City']) == 'undefined') data['City'] = '';
			if ((typeof data['State']) == 'undefined') data['State'] = '';
			if ((typeof data['Zip']) == 'undefined') data['Zip'] = '';
			//end setting values
			
			switch(data['status'])
			{
				case 'success':
					if (this.confirmi && cType == 'address')
					{
						if (typeof this.fcallbacki == 'function')
							var conCheck = this.fcallbacki (data['Address2'],data['Address1'],data['City'],data['State'],data['Zip']);
						else
							var conCheck = confirm(this.fconfmsgi+"\n\nAddress1: "+data['Address2']+"\nAddress2: "+data['Address1']+"\nCity: "+data['City']+"\nState: "+data['State']+"\nZipcode: "+data['Zip']);
					} else {
						conCheck = true;
					}
			
					if (conCheck)
					{
						//if user wants to update their validated address, update each field
						if (this.filli.length)
						{
							for (var x=0;x<this.filli.length;x++)
							{
								switch(this.filli[x])
								{
									case 'address1':
										if (data['Address2'] != "") document.getElementsByName(data['address1_field'])[0].value = data['Address2'];
									break;
									case 'address2':
										if (data['Address1'] != "") document.getElementsByName(data['address2_field'])[0].value = data['Address1'];
									break;
									case 'city':
										if (data['City'] != "") document.getElementsByName(data['city_field'])[0].value = data['City'];
									break;
									case 'zip':
										document.getElementsByName(data['zip_field'])[0].value = data['Zip'];
									break;
									case 'State':
										if (data['State'] != "") document.getElementsByName(data['state_field'])[0].value = data['State'];
									break;
								}
							}
						} else {
		  					if (data['Address2'] != "") document.getElementsByName(data['address1_field'])[0].value = data['Address2'];
		  					if (data['Address1'] != "") document.getElementsByName(data['address2_field'])[0].value = data['Address1'];
		  					if (data['City'] != "") document.getElementsByName(data['city_field'])[0].value = data['City'];
		  					if (data['State'] != "") document.getElementsByName(data['state_field'])[0].value = data['State'];
		  					if (data['Zip'] != "") 
		  					{
			  					var currentZip = document.getElementsByName(data['zip_field'])[0].value;
			  					var currentZip_sp = currentZip.split('-');
			  					var newZip_sp = data['Zip'].split('-');
			  			
			  					if (currentZip_sp[0] != newZip_sp[0])
		  							document.getElementsByName(data['zip_field'])[0].value = data['Zip'];
	  						}
	  					}
		 		 		//end field updating
					}
			 break;
			 case 'error':
					if (typeof this.ferrori == 'function')
					{
						this.ferrori(data['code']);
					}
					
					return false;
			 break;
		 }
	   	},
      	handleAs: "json"
    	};
      dojo.xhrPost(p);			
	}
}

//if autocheck is set to true, automatically 
	dojo.addOnLoad(function() {
		if (rusps.autocheck)
		{
			var address1 	= document.getElementsByName('<tag:address1_field />')[0];
			var city		= document.getElementsByName('<tag:city_field />')[0];
			var state		= document.getElementsByName('<tag:state_field />')[0];
			var zip			= document.getElementsByName('<tag:zip_field />')[0];
					
			 
			switch(rusps.autocheckmode)
			{
				case 1: //address confirm only
					dojo.connect(address1, 'onchange',checkAddress);
			 		dojo.connect(city, 'onchange',checkAddress);
			 		dojo.connect(state, 'onchange',checkAddress);
				break;
				case 2: //zip check only
					dojo.connect(zip, 'onkeyup',function(event){ checkZip(event)});
			 		dojo.connect(zip, 'onchange',function(event){ checkZip(event)});
				break;
				case 3: //zip check and address confirm
					dojo.connect(address1, 'onchange',checkAddress);
			 		dojo.connect(city, 'onchange',checkAddress);
			 		dojo.connect(state, 'onchange',checkAddress);		 
        	 
			 		dojo.connect(zip, 'onkeyup',function(event){ checkZip(event)});
			 		dojo.connect(zip, 'onchange',function(event){ checkZip(event)});
				break;
			}			 
		}
 	});
