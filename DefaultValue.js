jQuery.fn.DefaultValue = function(text){
    return this.each(function(){
		//Make sure we're dealing with text-based form fields
		if(this.type != 'text' && this.type != 'password' && this.type != 'textarea'){
			return;
		}

		//Store field reference
		var fld_current=this;

		//Set value initially if none are specified
        if(this.value=='') {
			this.value=text;
			$(this).css( 'color', '#888' );
		} else {
			//Other value exists - ignore
			//return;
		}

		//Remove values on focus
		$(this).focus(function() {
			if(this.value==text || this.value=='')
				this.value='';
				$(this).css( 'color', 'black' );
		});

		//Place values back on blur
		$(this).blur(function() {
			if(this.value==text || this.value==''){
				if( this.value=='' ){
					$(this).css( 'color', '#888' );
				}
				this.value=text;
			}
		});

		//Capture parent form submission
		//Remove field values that are still default
		$(this).parents("form").each(function() {
			//Bind parent form submit
			$(this).submit(function() {
				if(fld_current.value==text) {
					fld_current.value='';
				}
			});
		});

		$(this).attr( 'default_value', text );
	
		
		

		
    });
};