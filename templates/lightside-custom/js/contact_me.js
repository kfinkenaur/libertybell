/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */
$(function() {

 $("input,textarea").jqBootstrapValidation(
    {
     preventSubmit: true,
     submitError: function($form, event, errors) {
      // something to have when submit produces an error ?
      // Not decided if I need it yet
     },
     submitSuccess: function($form, event) {
      event.preventDefault(); // prevent default submit behaviour
       // get values from FORM
	   
	   var name = $("input#name").val(); 
	   var phone = $("input#phone").val();
       var email = $("input#email").val(); 
	   
	   var contact_preference = $("input[name=contact_preference]:checked").val();
	     
	   var from_street = $("input#from_street").val(); 
	   var from_city = $("input#from_city").val();
       var from_state = $("input#from_state").val();
	   var to_street = $("input#to_street").val(); 
	   var to_city = $("input#to_city").val();
       var to_state = $("input#to_state").val();
	   var move_out = $("input#move_out").val(); 
	   var move_in = $("input#move_in").val();
	   
	   var distance = $("input#distance").val();
	   var floor = $("input#floor").val();
	   
	   
	   var help_packing = $("input[name=help_packing]:checked").val();
	   var all_contents = $("input[name=all_contents]:checked").val();	   
	   var park_distance = $("input[name=park_distance]:checked").val();
	   var permit = $("input[name=permit]:checked").val();
	   var elevator = $("input[name=elevator]:checked").val();
	   var furniture_repair = $("input[name=furniture_repair]:checked").val();
	   var start_preference = $("input[name=start_preference]:checked").val();
	   var moved_before = $("input[name=moved_before]:checked").val();
				  
	   var move_type = $( "#move_type option:selected" ).text();
	   var bedrooms = $( "#bedrooms option:selected" ).text();
	   var storage = $( "#storage option:selected" ).text();
	   var items = $( "#items option:selected" ).text();
	   var stuff = $( "#stuff option:selected" ).text();
	   
	 
	   
																												//  var message = $("textarea#message").val();
        var firstName = name; // For Success/Failure Message
           // Check for white space in name for Success/Fail message
        if (firstName.indexOf(' ') >= 0) {
	   firstName = name.split(' ').slice(0, -1).join(' ');
         }        
	 $.ajax({
                url: "http://www.libertybellmoving.com/templates/lightside-custom/bin/contact_me.php",
            	type: "POST",
            	data: {name: name, phone: phone, email: email, contact_preference, bedrooms, move_type, storage, items, stuff, from_street, from_city, from_state, to_street, to_city, to_state, move_out, move_in, help_packing, all_contents, park_distance, permit, distance, floor, elevator, furniture_repair, start_preference, moved_before},
            	cache: false,
            	success: function() {  
            	// Success message
            	   $('#success').html("<div class='alert alert-success'>");
            	   $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            		.append( "</button>");
            	  $('#success > .alert-success')
            		.append("<strong>Thank you, your message has been sent.  We will respond as soon as possible. </strong>");
 		  $('#success > .alert-success')
 			.append('</div>');
 						     
 		  //clear all fields
 		  $('#contactForm').trigger("reset");
 	      },
 	   error: function() {		
	    $('#success').html("<div class='alert alert-success'>");
            	   $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            		.append( "</button>");
            	  $('#success > .alert-success')
            		.append("<strong>Thank you, your message has been sent.  We will respond as soon as possible. </strong>");
 		  $('#success > .alert-success')
 			.append('</div>');
 		// Fail message
 	//	 $('#success').html("<div class='alert alert-danger'>");
    //        	$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
    //        	 .append( "</button>");
    //        	$('#success > .alert-danger').append("<strong>Sorry "+firstName+" it seems that our mail server is not responding...</strong> Could you please email us directly at <a href='mailto:service@libertybellmoving.com?Subject=LBMS_Contact_Form'>service@libertybellmoving.com</a> ? Sorry for the inconvenience!");
 	//        $('#success > .alert-danger').append('</div>');
 		//clear all fields
 		$('#contactForm').trigger("reset");
 	    },
           })
         },
         filter: function() {
                   return $(this).is(":visible");
         },
       });

      $("a[data-toggle=\"tab\"]").click(function(e) {
                    e.preventDefault();
                    $(this).tab("show");
        });
  });
 

/*When clicking on Full hide fail/success boxes */ 
$('#name').focus(function() {
     $('#success').html('');
  });