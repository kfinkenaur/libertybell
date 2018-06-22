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
<style>
		
#item_list_table {
	-moz-box-shadow: 0 0 5px #888;
	-webkit-box-shadow: 0 0 5px#888;
	box-shadow: 0 0 5px #888;
	margin-bottom: 32px;
}
.innerShadow {
   -moz-box-shadow:    inset 0 0 3px #000000;
   -webkit-box-shadow: inset 0 0 3px #000000;
   box-shadow:         inset 0 0 3px #000000;
   background-color: #ffffff;	
   text-align: center;	
}
</style>
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
		<section class="formSection">
			<div class="container">
				<div class="row">

				<div class="col-md-5 offset-md-1">
					<label for="contact_name">Name</label><br />
					<input class="col-sm-12" id="contact_name" type="text"><br />

					<label for="contact_address">Address</label><br />
					<input class="col-sm-12" id="contact_address" type="text">

					<div class="row">
						<div class="col-md-6">
							<label for="contact_city">City</label><br />
							<input class="col-sm-12" id="contact_address" type="text">
						</div> <!-- end grid -->
						<div class="col-md-3">
							<label for="contact_city">State</label><br />
							<input class="col-sm-12" id="contact_state" type="text"><br />					
						</div> <!-- end grid -->
						<div class="col-md-3">
							<label for="contact_zip">Zip</label><br />
							<input class="col-md-12"  id="contact_state" type="text"><br />					
						</div> <!-- end grid -->
					</div> <!-- end row -->
				</div> <!-- end grid -->

				<div class="col-md-5">
					<label for="contact_phone">Phone</label><br />
					<input class="col-sm-12" id="contact_phone" type="text">

					<label for="contact_email">Email</label><br />
					<input class="col-sm-12" id="contact_email" type="text">

<!--					<label for="contact_password">Password</label>
					<input class="col-sm-12" id="contact_password" type="password" placeholder="Create to save your selection">	-->			
				</div>

				</div> <!-- end row -->
<!--				<div class="row">
					<div class="col-sm-12 col-md-11">
						<button id="save_contact" type="button" class="btn btn-danger">Save My Info</button>
						<button id="save_contact" type="button" class="btn btn-primary">Lookup My Info/Login</button>
					</div>  end grid 
				</div>--> <!-- end row -->
			</div> <!-- end container -->
		</section>

		<!-- Show this div on load with some instructions -->		
		<div id="initial_display">	
			<p>Select a Room and then click on <strong>Add a Moving Item</strong> to begin building a list of items to move.</p>
		</div> <!-- end initial_display -->	
		
		<!-- nav -->
		<section id="navSection">
			<ul>
				<li id="living_room" onClick="showRoom('Living Room')"><p>Living Room</p></li>
				<li id="dining_Room" onClick="showRoom('Dining Room')"><p>Dining Room</p></li>
				<li id="kitchen" onClick="showRoom('Kitchen')"><p>Kitchen</p></li>
				<li id="bedroom" onClick="showRoom('Bedroom')"><p>Bedroom</p></li>
				<li id="basement" onClick="showRoom('Basement')"><p>Basement</p></li>
				<li id="garage" onClick="showRoom('Garage')"><p>Garage</p></li>
			</ul>
		</section>
		

		<section>
			<div id="room_display_row" class="row">
				<h3><span id="room_to_display">Living Room </span><span id="add_item"><img src="img/plus.png" alt="Add Item" onClick="showItemList()" />Add a Moving Item </span></h3>
			</div> <!-- end room_display_row -->

			<div class="container tableHeader">
				<div class="row">
					<div align="center" class="col-2 underline ulLeft ulRight">
						<p>Room</p>
					</div> <!--end grid -->					
					<div class="col-7 underline ulRight">
						<p>Item Name</p>
					</div> <!--end grid -->
					<div align="center" class="col-1 underline ulRight">
						<p>Qty</p>
					</div> <!--end grid -->
					<div align="center" class="col-2 underline ulRight">
						<p>Cubes</p>
					</div> <!--end grid -->
				</div> <!-- end row -->
			</div> <!-- end container -->
			
			<div id="item_list" class="container">	
				<!-- add each row separately without the lines and we can stripe it with CSS -->
			</div> <!-- end container -->


			<div id="table_footer" class="container" style="padding:0 0 0 0;display: none">
				<div class="row">
					<div align="center" class="col-2 ulTop">
						<p>&nbsp;</p>
					</div> <!--end grid -->					
					<div class="col-6 ulTop">
						<p>&nbsp;</p>
					</div> <!--end grid -->
					<div align="right" class="col-2 ulTop">
						<p>Total Cubes</p>
					</div> <!--end grid -->
					<div id="total_cubes" align="center" class="col-2 ulTop">
						
					</div> <!--end grid -->
				</div> <!-- end row -->
			</div> <!-- end container -->
		
			
			
			
			
			
			
			
			
		<br /><br />

<div class="row">
		<div class="col-8 offset-2" align="center" id="item_select_list" style="height: 400px;overflow: hidden;overflow-y: auto">







		</div>	
	</row>
		
			
			
			
			
			
			
			
		</section>	


	<script>
	///////// Get listing of items by room //////////////////
		
	function showItemList(){
		//alert('test');
	//$('#room_display_row').hide();
		
	 var roomName=$('#room_to_display').text();
			$.ajax({
     			url:'includes/items_get_by_room.php',
     			dataType:'text',
     			type:'POST',
     			data:{'roomName':roomName},
    			timeout:60000,
     			success:function(response){
				//	alert(response);
					//$('#initial_display').hide();
					var resultArray=$.parseJSON(response);
					//alert(resultArray[0].room_name);
					var resultHtml='<table id="item_list_table" class="col-12" border="1"><tbody><tr><th class="col-10">Item Name</th><th class="col-2" align="center">&nbsp;</th></tr>';
					
					for(i=0;i<resultArray.length;i++){
								
					resultHtml=resultHtml + '<tr><td id="'+resultArray[i].pack_kit_recid+'">&nbsp;'+resultArray[i].pack_kit_name+'</td><td align="center"><button type="button" class="btn btn-success btn-sm" onClick="getRoomItem('+resultArray[i].pack_kit_recid+')" style="margin:3px 12px 3px 12px">Select</button></td></tr>';

					}
					
					resultHtml=resultHtml + '</tbody></table>';
					
					$('#item_select_list').html(resultHtml);
					$('#item_select_list').show();
					
				},
    			error: function(){
				}	
			});	
		
	}
		
		function getRoomItem(recid){
			
			var roomName=$('#room_to_display').text();
			//alert(recid);
			$.ajax({
     			url:'includes/items_get.php',
     			dataType:'text',
     			type:'POST',
     			data:{'recid':recid,'roomName':roomName},
    			timeout:60000,
     			success:function(response){
					//$('#initial_display').hide();
					var resultArray=$.parseJSON(response);
					//alert(resultArray.pack_kit_recid);

					var resultHtml='<div class="row"><div align="center" class="col-2">'+resultArray.room_name+'</div><div class="col-7">'+resultArray.pack_kit_name+'</div><div align="center" class="col-1"><input class="innerShadow" value="1" onChange="updateCubeCount('+resultArray.pack_kit_recid+',this.value)" /></div><div id="'+resultArray.pack_kit_recid+'" align="center" class="col-2 cubes">'+resultArray.cubes+'</div></div>';
							
					
					$('#item_select_list').hide();
					$('#item_list').append(resultHtml);
					
					$('#item_list').show();
					$('#table_footer').show();
					var totalCubes=0;
					$('#item_list .cubes').each(function(){
						
						//alert($(this).html());
						totalCubes=parseFloat(totalCubes) + parseFloat($(this).html());
						
					});
					
					$('#total_cubes').html(totalCubes);
					
				},
    			error: function(){
				}	
			});				
					
		}
	</script>
	
	<script>
	function showRoom(room_name){
		$('#room_to_display').html(room_name);
		$('#room_display_row').show();
	}
		function updateCubeCount(recid,itemCount){
			var cubeCount=$('#'+recid).text();

			var newCubeCount=parseFloat(cubeCount) * parseFloat(itemCount);

			if(itemCount!=0){
				$('#'+recid).text(newCubeCount);
				var totalCubes=0;
					$('#item_list .cubes').each(function(){
						
					
						totalCubes=parseFloat(totalCubes) + parseFloat($(this).html());
						
					});
			$('#total_cubes').html(totalCubes);
			}else{
				$('#'+recid).text('0');
				var totalCubes=0;
					$('#item_list .cubes').each(function(){
						
				
						totalCubes=parseFloat(totalCubes) + parseFloat($(this).html());
						
					});
			$('#total_cubes').html(totalCubes);
			}
		}
</script>	

		
		
		
		
		
		
		
		
		
		

	</body>
</html>