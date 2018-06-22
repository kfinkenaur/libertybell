	jQuery(document).ready(function(){
		//the drop down box is changed
		jQuery("#etm_add_selector").change(function(){		
			var etm_action = jQuery("#etm_add_selector").val()
			if( etm_action != "do_nothing" ) {
				//it's not "select one..."
				
				if( etm_action == "text" ) {
					//add a text_box				
					etm_addTextBoxForm();				

				} else if( etm_action == "select") {
					//add a select menu				
					etm_addSelectForm();

				}else if( etm_action == "textarea") {
					//add a textarea
					etm_addTextAreaForm();
					
				} else if( etm_action == "password") {
					//add a password
					etm_addPasswordForm();	
					
				} else if( etm_action == "radio") {
					//add a radio
					etm_addRadioForm();	
					
				} else if( etm_action == "checkbox") {
					//add a radio
					etm_addCheckboxForm();	
					
				}

				//show the cancel button
				etm_showCancel();

			}
		});	

		//the form is submitted
		jQuery("#etm_submit").on("click", function(){
			etm_submitForm();
		});

		//settings are updated
		jQuery("#etm_submit_settings").on("click", function(){
			etm_submitSettings();
		});
	});


	/**
	* Cleans the fields (removes special characters)
	*
	* @since 1.0.6
	*/
	function etm_cleanFields(the_field,is_uri) {	
		//make is_uri optional	
		is_uri = (typeof is_uri === "undefined") ? false : is_uri;
		
		//remove extra spaces
		the_field = jQuery.trim(the_field);				

		//different characters to clean if it's a URI
		if(!is_uri) {
			var entityMap = {
			    "&": "&amp;",
			    "<": "&lt;",
			    ">": "&gt;",
			    '"': '&quot;',
			    "'": '&#39;',
			    "`": '&#39;',
			    "/": '&#x2F;'
			};  

			the_field = String(the_field).replace(/[&<>"`'\/]/g, function (s) {
				return entityMap[s];
			});		    

	    } else {
			var entityMap = {			    
			    "<": "&lt;",
			    ">": "&gt;",
			    '"': '&quot;',
			    "'": '&#39;',
			    "`": '&#39;',		    
			    " ": '%20'	
			};  
	    	the_field = String(the_field).replace(/[<>"'` ]/g, function (s) {
	    		return entityMap[s];
	    	});				    	
	    }
	    
		return the_field;
	}	
	

	//adds the fields
	function etm_doAddFields() {
		var typeOfInput = jQuery("#etm_type").val();
		var required = 0;
		var etm_counter = jQuery("#etm_counter").val();
		var etm_options = "";

		//clean the fields
		jQuery("#etm_namer").val( etm_cleanFields( jQuery("#etm_namer").val(), false ) );

		if( typeOfInput == 'text' ) {
			//add a text box
			var etm_label = jQuery("#etm_namer").val();
			var etm_newElement = '<div id="etm_element_' + etm_counter + '">';
			etm_newElement =  etm_newElement + '<p>' + etm_label + '<br> <input type="text" id="etm_fakeElement_' + etm_counter + '"';

			//is it a required field?
			if( jQuery("#etm_required").is(":checked") ) {			
				etm_newElement = etm_newElement + ' required> (required)';
				required = 1;
			} else {
				etm_newElement = etm_newElement + '>';
			}
						
		} else if ( typeOfInput == "textarea" ) {
			//add a textarea
			var etm_label = jQuery("#etm_namer").val();
			var etm_newElement = '<div id="etm_element_' + etm_counter + '">';
			etm_newElement =  etm_newElement + '<p>' + etm_label;
			//is it a required field?
			if( jQuery("#etm_required").is(":checked") ) {			
				etm_newElement = etm_newElement +   ' (required)<br> <textarea rows="5" cols="50" id="etm_fakeElement_' + etm_counter + '" required></textarea>';	
				required = 1;
			} else {
				etm_newElement = etm_newElement +   '<br> <textarea rows="5" cols="50" id="etm_fakeElement_' + etm_counter + '"></textarea>';	
			}
			 		

		} else if ( typeOfInput == "password" ) {
			//add a password
			var etm_label = jQuery("#etm_namer").val();
			var etm_newElement = '<div id="etm_element_' + etm_counter + '">';
			etm_newElement =  etm_newElement + '<p>' + etm_label + '<br> <input type="password" id="etm_fakeElement_' + etm_counter + '"';

			//is it a required field?
			if( jQuery("#etm_required").is(":checked") ) {			
				etm_newElement = etm_newElement + ' required> (required)';
				required = 1;
			} else {
				etm_newElement = etm_newElement + '>';
			}	

		} else if ( typeOfInput == "select" ) {
			//add a select box

			//first lets just copy the options from the demo
			var etm_clonedOptions = jQuery("#etm_selectDemo").html();

			//now start the process
			var etm_label = jQuery("#etm_namer").val();
			var etm_newElement = '<div id="etm_element_' + etm_counter + '">';
			etm_newElement =  etm_newElement + '<p>' + etm_label;
			//is it a required field?
			if( jQuery("#etm_required").is(":checked") ) {			
				etm_newElement = etm_newElement + ' (required)<br> <select id="etm_fakeElement_' + etm_counter + '" required>';
				required = 1;
			} else {
				etm_newElement = etm_newElement + '<br> <select id="etm_fakeElement_' + etm_counter + '">';
			}			
			etm_newElement = etm_newElement + etm_clonedOptions + "</select>";

			//now get the options into a string
			jQuery("#etm_selectDemo option").each(function(){
				etm_options = etm_options + jQuery(this).val() + "|-etm-|";
			});

			//remove the last |-etm-|
			etm_options = etm_options.substr(0, etm_options.length - 7);
			
		} else if ( typeOfInput == "radio" ) {
			//add a radio list

			//first lets just copy the options from the demo
			var etm_clonedOptions = jQuery("#etm_radioDemo").html();
//console.log(etm_clonedOptions);

			//now start the process
			var etm_label = jQuery("#etm_namer").val();
			var etm_newElement = '<div id="etm_element_' + etm_counter + '">';
			etm_newElement =  etm_newElement + '<p>' + etm_label;
			//is it a required field?
			if( jQuery("#etm_required").is(":checked") ) {			
				etm_newElement = etm_newElement + ' (required)';
				required = 1;
			}
			etm_newElement = etm_newElement + '<br>' + etm_clonedOptions;

			//now get the options into a string
			jQuery("#etm_radioDemo input").each(function(){
				etm_options = etm_options + jQuery(this).val() + "|-etm-|";
			});

			//remove the last |-etm-|
			etm_options = etm_options.substr(0, etm_options.length - 7);
			
		} else if ( typeOfInput == "checkbox" ) {
			//add a checkbox list

			//first lets just copy the options from the demo
			var etm_clonedOptions = jQuery("#etm_checkboxDemo").html();
//console.log(etm_clonedOptions);

			//now start the process
			var etm_label = jQuery("#etm_namer").val();
			var etm_newElement = '<div id="etm_element_' + etm_counter + '">';
			etm_newElement =  etm_newElement + '<p>' + etm_label + '<br>';
			etm_newElement = etm_newElement + etm_clonedOptions;

			//now get the options into a string
			jQuery("#etm_checkboxDemo input").each(function(){
				etm_options = etm_options + jQuery(this).val() + "|-etm-|";
			});

			//remove the last |-etm-|
			etm_options = etm_options.substr(0, etm_options.length - 7);

//console.log(etm_options);			
		}

		//finish the element
		var etm_newElement = etm_finishElement(etm_newElement, etm_counter);

        //print the new element
        jQuery("#etm_form_output").append(etm_newElement);		

		//add the element to the form data
		var etm_formElement = "<input type='hidden' class='etm_toAdd' value='" + typeOfInput + "|+etm+|" + required + "|+etm+|" + etm_label + "|+etm+| " + etm_options + "' name='etm_formElement" + etm_counter + "' id='etm_formElement" + etm_counter + "' form='etm_contact'>";
//console.log("etm_formElement: " + etm_formElement);
		jQuery("#etm_form_data").append(etm_formElement);

        //increase our counter
        etm_counter++;
        jQuery("#etm_counter").val(etm_counter);

		//reset workarea
		etm_doReset();

	}	

	//adds the final touches to a new element
	function etm_finishElement(etm_newElement, etm_counter) {
		etm_newElement = etm_newElement + '<br><a href="#" onclick="etm_deleteElement(' + etm_counter +'); return false;">Delete</a></p>';
		etm_newElement = etm_newElement + '</div><!-- // #etm_element_' + etm_counter +' -->';
		return etm_newElement;
	}


	//shows form to add a textbox 
	function etm_addTextBoxForm() {
		//show the form			
		var etm_dataToAdd = '<p>Text to print before this single line text box: <input id="etm_namer" type="text" required></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Required? <input id="etm_required" type="checkbox"></p>';
		etm_dataToAdd = etm_dataToAdd + '<input type="hidden" id="etm_type" value="text">';
		
		jQuery("#etm_work_area").append(etm_dataToAdd);

		//hide the selector box 
		jQuery("#etm_selectorContainer").hide(0);		

	}

	//shows form to add a textarea
	function etm_addTextAreaForm() {
		//show the form			
		var etm_dataToAdd = '<p>Text to print before this large text box: <input id="etm_namer" type="text" required></p>';		
		etm_dataToAdd = etm_dataToAdd + '<p>Required? <input id="etm_required" type="checkbox"></p>';
		etm_dataToAdd = etm_dataToAdd + '<input type="hidden" id="etm_type" value="textarea">';
		
		jQuery("#etm_work_area").append(etm_dataToAdd);

		//hide the selector box 
		jQuery("#etm_selectorContainer").hide(0);		

	}	

	//shows form to add a password field 
	function etm_addPasswordForm() {
		//show the form			
		var etm_dataToAdd = '<p>Text to print before this password style box: <input id="etm_namer" type="text" required></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Required? <input id="etm_required" type="checkbox"></p>';
		etm_dataToAdd = etm_dataToAdd + '<input type="hidden" id="etm_type" value="password">';
		
		jQuery("#etm_work_area").append(etm_dataToAdd);

		//hide the selector box 
		jQuery("#etm_selectorContainer").hide(0);		

	}	

	//shows form to add a select element
	function etm_addSelectForm() {
		//show the form			
		var etm_dataToAdd = '<p>Text to print before this dropbown select box: <input id="etm_namer" type="text" required></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Required? <input id="etm_required" type="checkbox"></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Next select box option: <input id="etm_optioner" name="etm_optioner" type="text"><br>';
		etm_dataToAdd = etm_dataToAdd + ' <a href="#" onclick="etm_addOption(\'select\'); return false;">Add This Option To My Select Box</a></p>';
		etm_dataToAdd = etm_dataToAdd + '<p id="etm_notifier" style="display:none;"></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Your Select Box So Far: <br>';
		etm_dataToAdd = etm_dataToAdd + '<span id="etm_selectDemoLabel"></span><select id="etm_selectDemo"></select></p>';
		etm_dataToAdd = etm_dataToAdd + '<input type="hidden" id="etm_type" value="select">';
		
		jQuery("#etm_work_area").append(etm_dataToAdd);

		//hide the selector box 
		jQuery("#etm_selectorContainer").hide(0);		
	}	

	//shows form to add a radio element
	function etm_addRadioForm() {
		//show the form			
		var etm_dataToAdd = '<p>Text to print before this list of choices: <input id="etm_namer" type="text" required></p>';
		etm_dataToAdd = etm_dataToAdd + '<p id="etm_required_area">Required? <input id="etm_required" type="checkbox"></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Label for this choice: <input id="etm_optioner" name="etm_optioner" type="text"><br>';
		etm_dataToAdd = etm_dataToAdd + ' <a href="#" onclick="etm_addOption(\'radio\'); return false;">Add This Option To My List</a></p>';
		etm_dataToAdd = etm_dataToAdd + '<p id="etm_notifier" style="display:none;"></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Your List So Far: <br></p>';
		etm_dataToAdd = etm_dataToAdd + '<span id="etm_radioDemoLabel"></span><div id="etm_radioDemo"></div>';
		etm_dataToAdd = etm_dataToAdd + '<input type="hidden" id="etm_type" value="radio">';
		
		jQuery("#etm_work_area").append(etm_dataToAdd);

		//hide the selector box 
		jQuery("#etm_selectorContainer").hide(0);		
	}	

	//shows form to add a radio element
	function etm_addCheckboxForm() {
		//show the form			
		var etm_dataToAdd = '<p>Text to print before this list of choices: <input id="etm_namer" type="text" required></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Label for this choice: <input id="etm_optioner" name="etm_optioner" type="text"><br>';
		etm_dataToAdd = etm_dataToAdd + ' <a href="#" onclick="etm_addOption(\'checkbox\'); return false;">Add This Option To My List</a></p>';
		etm_dataToAdd = etm_dataToAdd + '<p id="etm_notifier" style="display:none;"></p>';
		etm_dataToAdd = etm_dataToAdd + '<p>Your List So Far: <br></p>';
		etm_dataToAdd = etm_dataToAdd + '<span id="etm_checkboxDemoLabel"></span><div id="etm_checkboxDemo"></div>';
		etm_dataToAdd = etm_dataToAdd + '<input type="hidden" id="etm_type" value="checkbox">';
		
		jQuery("#etm_work_area").append(etm_dataToAdd);

		//hide the selector box 
		jQuery("#etm_selectorContainer").hide(0);		
	}				

	//edits an element
	function etm_editElement(ele_ID) {	
	}

	//processes an edit
	function etm_doEditElement(ele_ID) {

	}

	//adds an option
	function etm_addOption(typeOfInput) {
		if(typeOfInput == "select") {
			//select box

			//first lets update the label for the demo element
			//is it required?						
			if( jQuery("#etm_required").is(":checked") ) {							
				jQuery("#etm_selectDemoLabel").text( jQuery("#etm_namer").val() + ' (required) ');
			} else {
				jQuery("#etm_selectDemoLabel").text( jQuery("#etm_namer").val() );
			}
			
			//next let's add the option to the demo element...assuming it's not empty
			if( jQuery("#etm_optioner").val() == '' ) {
				alert("You must first type an option value.");
				return false;
			}
			jQuery("#etm_selectDemo").append("<option value='" + etm_cleanFields(jQuery('#etm_optioner').val(), false) + "'>" + etm_cleanFields(jQuery('#etm_optioner').val()) + "</option>");
			
			//now let's clear the optioner
			jQuery("#etm_optioner").val('');

			//update the user
			jQuery("#etm_notifier").text("Option Added!").fadeIn(500, function(){
				setTimeout(function(){
					jQuery("#etm_notifier").fadeOut(500, function() {
						jQuery("#etm_notifier").text('');
					})
				}, 800);
			});			

			//show the add element button
			jQuery("#etm_addElement").show(0);
			
		} else if(typeOfInput == "radio") {
			//radio

			//first lets update the label for the demo element
			//is it required?						
			if( jQuery("#etm_required").is(":checked") ) {							
				jQuery("#etm_radioDemoLabel").text( jQuery("#etm_namer").val() + ' (required) ');
				var add_required = "required";
			} else {
				jQuery("#etm_radioDemoLabel").text( jQuery("#etm_namer").val() );
				var add_required = "";
			}						
			
			//next let's add the option to the demo element...assuming it's not empty
			if( jQuery("#etm_optioner").val() == '' ) {
				alert("You must first type an option value.");
				return false;
			}
			jQuery("#etm_radioDemo").append("<input type='radio' name='etm_demoRadio' value='" + etm_cleanFields(jQuery('#etm_optioner').val(), false) + "' " + add_required + "> " + etm_cleanFields(jQuery('#etm_optioner').val(), false) + "<br>");

			//if the required box is still visible, let's hide it so we don't have to worry
			//about several options being required and others not in the same element
			jQuery("#etm_required_area").html( "Required? You may not alter this value after starting this element. ");

			//now let's clear the optioner
			jQuery("#etm_optioner").val('');

			//update the user
			jQuery("#etm_notifier").text("Option Added!").fadeIn(500, function(){
				setTimeout(function(){
					jQuery("#etm_notifier").fadeOut(500, function() {
						jQuery("#etm_notifier").text('');
					})
				}, 800);
			});				


			
		} else if(typeOfInput == "checkbox") {
			//checkbox

			//first lets update the label for the demo element
			jQuery("#etm_checkboxDemoLabel").text( jQuery("#etm_namer").val() );
			
			//next let's add the option to the demo element...assuming it's not empty
			if( jQuery("#etm_optioner").val() == '' ) {
				alert("You must first type an option value.");
				return false;
			}
			jQuery("#etm_checkboxDemo").append("<input type='checkbox' name='etm_demoCheckbox' value='" + etm_cleanFields(jQuery('#etm_optioner').val(), false) + "'> " + etm_cleanFields(jQuery('#etm_optioner').val(), false) + "<br>");

			//now let's clear the optioner
			jQuery("#etm_optioner").val('');

			//update the user
			jQuery("#etm_notifier").text("Option Added!").fadeIn(500, function(){
				setTimeout(function(){
					jQuery("#etm_notifier").fadeOut(500, function() {
						jQuery("#etm_notifier").text('');
					})
				}, 800);
			});						
			
		}
	}

	//shows a cancel button
	function etm_showCancel() {
		var appendage = '<p><span class="button button-primary" id="etm_addElement" onclick="etm_doAddFields();">Finish this element and add to form</span>&nbsp;&nbsp;';
		appendage = appendage + "<span class='button' id='etm_cancel' onclick='etm_doReset();'>Cancel adding this element</span></p>";
		jQuery("#etm_work_area").append(appendage);
	}

	//cancels and returns to previous state
	function etm_doReset() {
		//clear the work area
		jQuery("#etm_work_area").html("");

		//show the selector box
		jQuery("#etm_selectorContainer").show(0);	

		//unhide the etm_addElement button (if hidden)
		//jQuery("#etm_addElement").show(0);

		//reset value of selector box
		jQuery("#etm_add_selector").prop('selectedIndex', 0);

	}

	//removes an element
	function etm_deleteElement(etm_ID) {
		if(confirm("Are you sure you wish to delete this element?")) {			
			//remove it from the work area
			jQuery("#etm_element_" + etm_ID).remove();
			//remove it from the form data
			jQuery("#etm_formElement" + etm_ID).remove();
		}
	}

	//submits the form
	function etm_submitForm() {
		//prepare the JSON object "data"		
		var data = {};
		var formData = [];
		var field_counter = -1;
		jQuery('.etm_toAdd').each(function( index ) {						
			formData[index] = jQuery(this).val();
			field_counter = index;
		});	

		//lets ensure there's data to submit			
		if(field_counter < 0 || field_counter == null) {
			//nope
			jQuery("#etm_update").html("<p>You must first add a field before you can update the form!</p>");
			jQuery("#etm_update").addClass("error");
			jQuery("#etm_update").fadeIn(500);				
			setTimeout(5000, function(){
				jQuery("#etm_update").fadeOut(500, function(){
					jQuery("#etm_update").removeClass("error");
				});
			});
			return false;		
		}

		data.action = "etm_contact_update_form";
		data.data = formData;	

//console.log(data);
		
		//submit the form
		jQuery.post(ajaxurl, data, function(response) {
			if(response == "true" || response == true) {
				jQuery("#etm_update").html("<p>Contact Form Updated</p>");
				jQuery("#etm_update").addClass("updated");
				jQuery("html, body").animate({ scrollTop: 0 }, 300);
				jQuery("#etm_update").fadeIn(1000, function(){
					
					setTimeout(function(){
						jQuery("#etm_update").fadeOut(1000, function(){
							jQuery("#etm_update").removeClass("updated");
						});
					}, 5000);
				});
//console.log(response);

			} else {
				jQuery("#etm_update").html("<p>Database Error: Please notify webmaster</p>");
				jQuery("#etm_update").addClass("error");
				jQuery("html, body").animate({ scrollTop: 0 }, 300);
				jQuery("#etm_update").fadeIn(500, function(){
					
					setTimeout(5000, function(){
						jQuery("#etm_update").fadeOut(500, function(){
							jQuery("#etm_update").removeClass("error");
						});
					});
				});				
//console.log(response);
			}			
		});
	}

	//submits/updates the settings
	function etm_submitSettings() {
		var data = {
			action: "etm_contact_update_settings",
			etm_name: jQuery("#etm_recipient_name").val(),
			etm_email: jQuery("#etm_recipient_email").val()
		};

//console.log(data);

		//submit the form
		jQuery.post(ajaxurl, data, function(response) {
			if(response == "true" || response == true) {
				jQuery("#etm_update").html("<p>Settings Updated</p>");
				jQuery("#etm_update").addClass("updated");
				jQuery("html, body").animate({ scrollTop: 0 }, 300);
				jQuery("#etm_update").fadeIn(1000, function(){
					
					setTimeout(function(){
						jQuery("#etm_update").fadeOut(1000, function(){
							jQuery("#etm_update").removeClass("updated");
						});
					}, 5000);
				});

			} else {
				jQuery("#etm_update").html("<p>Database Error: Please notify webmaster</p>");
				jQuery("#etm_update").addClass("error");
				jQuery("html, body").animate({ scrollTop: 0 }, 300);
				jQuery("#etm_update").fadeIn(500, function(){
					
					setTimeout(5000, function(){
						jQuery("#etm_update").fadeOut(500, function(){
							jQuery("#etm_update").removeClass("error");
						});
					});
				});				
			}					
		});		
	}