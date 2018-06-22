<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Home Tally Form</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" >
	<link rel="stylesheet" href="css/libertyForm.css" >
	
	
	<script src="js/jquery-1.11.2.min.js"></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script> 
	
	
<?php
		$timestamp=time();
	$customer_number=substr($timestamp,-6).'T';
	
?>
</head>

<body>
	
	<header>
		<div class="container">
			<div class="col-sm-12 col-lg-8 offset-lg-2">	
				<img src="img/Logo.png" class="logoImage" />
			</div>
		</div>
	</header>
	
	<!-- form -->
	<section>
		<div class="container">
			<div class="row">

			<div class="col-sm-5">
			<label for="contact_name">Name</label><br />
			<input class="col-sm-12" id="contact_name" type="text"><br />

			<label for="contact_address">Address</label><br />
			<input class="col-sm-12" id="contact_address" type="text">

			<div class="row">
			<div class="col-sm-6">
			<label for="contact_city">City</label><br />
			<input class="col-sm-12" id="contact_address" type="text">
			</div>
			<div class="col-sm-2">
			<label for="contact_city">State</label><br />
			<input class="col-sm-12" id="contact_state" type="text"><br />					
			</div>
			<div class="col-sm-4">
			<label for="contact_zip">Zip</label><br />
			<input class="col-sm-12"  id="contact_state" type="text"><br />					
			</div>					
			</div>
			</div>
				
				
			<div class="col-sm-5">
			<label for="contact_phone">Phone</label><br />
			<input class="col-sm-12" id="contact_phone" type="text">


			<label for="contact_email">Email</label><br />
			<input class="col-sm-12" id="contact_email" type="text">

			<label for="contact_password">Password (Create to save your selections)</label><br />
			<input class="col-sm-12" id="contact_password" type="password">				
			</div>
			<div class="row col-12" style="margin-top:12px">
			<div class="col-6"></div>	
			<div class="col-3">

			<button id="save_contact" type="button" class="btn btn-primary">Lookup My Info/Login</button>

			</div>				
			<div align="right" class="col-3">

			<button id="save_contact" type="button" class="btn btn-danger">Save My Info</button>

			</div>				

			</div>	
			</div> <!-- end row -->
		</div> <!-- end container -->

	</section>

	
	
	
	
	
	
	
	
	
	
	
	

	<br />
		
	<section>
        <div class="container">
			
			<div class="row" style="border:1px solid #999">
				
			<div align="center" id="living_room" class="col-sm-2" style="border:1px solid #999;cursor:pointer" onClick="showRoom('Living Room')">Living Room</div>			
			<div align="center" id="living_room" class="col-sm-2" style="border:1px solid #999;cursor:pointer" onClick="showRoom('Dining Room')">Dining Room</div>	
			<div align="center" id="living_room" class="col-sm-2" style="border:1px solid #999;cursor:pointer" onClick="showRoom('Kitchen')">Kitchen</div>	
			<div align="center" id="living_room" class="col-sm-2" style="border:1px solid #999;cursor:pointer" onClick="showRoom('Bedroom')">Bedroom</div>	
			<div align="center" id="living_room" class="col-sm-2" style="border:1px solid #999;cursor:pointer" onClick="showRoom('Basement')">Basement</div>	
			<div align="center" id="living_room" class="col-sm-2" style="border:1px solid #999;cursor:pointer" onClick="showRoom('Garage')">Garage</div>	
			
			</div>	
			
			</div>
			
	</section>
	
	<br />
	

		
	<section>
        <div class="container">
			
			<div id="room_display_row" class="row" style="border:1px solid #999;display:none">

			  <div id="room_to_display" class="col-9">
				
					Living Room
				</div>
	
				<div class="col-3">
				
				<div id="add_item" style="cursor:pointer"><img src="img/plus.png" width="24" height="24" alt="Add Item" onClick="showItemList()"/> Add a Moving Item </div></div>		
			</div>	
			
		</div>
		<br />
        <div class="container">
			
			<div class="row">

				<div class="col-8" style="border-bottom: 1px solid #999;border-right: 1px solid #999">
				
					Item Name
				</div>
	
				<div align="center" class="col-2" style="border-bottom: 1px solid #999;border-right: 1px solid #999">
				
					Qty
				</div>
					
				<div align="center" class="col-2" style="border-bottom: 1px solid #999;">
				
					Total Cubes
				</div>	
			</div>
			<br /><br />
<!--	////// Show this div on load with some instructions ////////////-->		
		<div id="initial_display">	
			
			<div class="row">

				<div align="center" class="col-12" >
				
					Select a Room and then click on <span style="font-weight: bold">Add a Moving Item</span> to begin building a list of items to move.
				</div>

			</div>
		
		</div>		
			
	<div class="col-8 offset-2" align="center" id="item_select_list">
		

			
			
			
			
			
	</div>		
				
	<div id="item_list" style="display:none">	
			<div class="row">

				<div class="col-8" style="border-bottom: 1px solid #999;border-right: 1px solid #999">
				
					Coffee Table
				</div>
	
				<div align="center" class="col-2" style="border-bottom: 1px solid #999;border-right: 1px solid #999">
				
					2
				</div>
					
				<div align="center" class="col-2" style="border-bottom: 1px solid #999;">
				
					4
				</div>	
			</div>
		
	</div>		
		</div>		
	</section>	
	
	
	
	<script>
	///////// Get listing of items by room //////////////////
		
	function showItemList(){
		//alert(roomName);
	
	 var roomName=$('#room_to_display').text();
			$.ajax({
     			url:'includes/items_get_by_room.php',
     			dataType:'text',
     			type:'POST',
     			data:{'roomName':roomName},
    			timeout:60000,
     			success:function(response){
					$('#initial_display').hide();
					var resultArray=$.parseJSON(response);
					//alert(resultArray[0].room_name);
					var resultHtml='<table class="col-12" border="1"><tbody><tr><th class="col-10">Item Name</th><th class="col-2" align="center">&nbsp;</th></tr>';
					
					for(i=0;i<resultArray.length;i++){
								
					resultHtml=resultHtml + '<tr><td id="'+resultArray[i].room_items_recid+'">&nbsp;'+resultArray[i].room_item_name+'</td><td align="center"><button type="button" class="btn btn-success btn-sm" onClick="getRoomItem('+resultArray[i].room_items_recid+')">Select</button></td></tr>';

					}
					
					resultHtml=resultHtml + '</tbody></table>';
					
					$('#item_select_list').html(resultHtml);
					
				},
    			error: function(){
				}	
			});	
		
	}
		
		function getRoomItem(recid){
			alert(recid);
			
			
		}
	</script>
	
	<script>
	function showRoom(room_name){
		$('#room_to_display').html(room_name);
		$('#room_display_row').show();
	}
</script>	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
</body>
</html>