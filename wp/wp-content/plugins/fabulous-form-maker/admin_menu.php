<?php

	//fetches the form settings
	function etm_form_settings() {
		global $wpdb;

		//fetch the settings
		$table_name = $wpdb->prefix . "etm_contact_settings";	
		$etm_settings = $wpdb->get_row("SELECT * FROM {$table_name} ORDER BY `id` ASC LIMIT 1", ARRAY_A);		
		$rows = count($etm_settings);
		    

	    //if name is blank, default to admin
	    if($rows == 0 || $rows == null || $etm_settings['recipient_name'] == "" || $etm_settings['recipient_name'] == NULL) {
			$recipient['name'] = "Admin";
	    } else {
	    	$recipient['name'] = $etm_settings['recipient_name'];	
	    }

	    //if email is blank, default to admin email
	    if($rows == 0 || $rows == null || $etm_settings['recipient_email'] == "" || $etm_settings['recipient_email'] == NULL) {
			$recipient['email'] = get_option('admin_email', '');
	    } else {
	    	$recipient['email'] = $etm_settings['recipient_email'];		
	    }    

	    return $recipient;

	}
	
	//fetches an array of objects containing the information
	function etm_get_form() {
		global $wpdb;
		$table_name = $wpdb->prefix . "etm_contact";		
		$etm_results = $wpdb->get_results("SELECT * FROM {$table_name} ORDER BY `id` ASC");
	    etm_process_results($etm_results);
	}

	//print out the results
	function etm_process_results($data) {		
		$i = 0;
		foreach($data as $obj) {
			//start the data output						
			echo "<div id='etm_element_".$i."'><p>";
			echo $obj->text_before_field . "<br>";
			
			//textbox
			if($obj->field_type == "text") {
				echo "<input type='text' id='etm_fakeElement_".$i."' ";
				if($obj->required) 
					echo "required> (required)";
				else 
					echo ">";

				//print the form data
				echo "<input type='hidden' class='etm_toAdd' value='text|+etm+|" . $obj->required . "|+etm+|" . $obj->text_before_field . "|+etm+|" . $obj->field_options . "' name='etm_formElement" . $i . "' id='etm_formElement" . $i . "' form='etm_contact' >";
				

			//textarea
			} elseif ($obj->field_type == "textarea") {
				echo "<textarea rows='5' cols='50' id='etm_fakeElement_".$i."'></textarea>";

				//print the form data
				echo "<input type='hidden' class='etm_toAdd' value='textarea|+etm+|0|+etm+|" . $obj->text_before_field  . "|+etm+|" . $obj->field_options . "' name='etm_formElement" . $i . "' id='etm_formElement" . $i . "' form='etm_contact' >";				

			//password
			} elseif ($obj->field_type == "password") {
				echo "<input type='password' id='etm_fakeElement_".$i."' ";
				if($obj->required) 
					echo "required> (required)";
				else 
					echo ">";

				//print the form data
				echo "<input type='hidden' class='etm_toAdd' value='password|+etm+|" . $obj->required . "|+etm+|" . $obj->text_before_field . "|+etm+|" . $obj->field_options . "' name='etm_formElement" . $i . "' id='etm_formElement" . $i . "' form='etm_contact' >";				
			} elseif ($obj->field_type == "select") {
				echo "<select id='etm_fakeElement_".$i."'>";
				$etm_fields = explode('|-etm-|', $obj->field_options);
				foreach($etm_fields as $field_val) {
					echo "<option value='" . $field_val . "'>" . $field_val . "</option>";
				}
				echo "</select>";

				//print the form data
				echo "<input type='hidden' class='etm_toAdd' value='select|+etm+|" . $obj->required . "|+etm+|" . $obj->text_before_field . "|+etm+|" . $obj->field_options . "' name='etm_formElement" . $i . "' id='etm_formElement" . $i . "' form='etm_contact' >";				

			}  elseif ($obj->field_type == "radio") {				
				$etm_fields = explode('|-etm-|', $obj->field_options);
				foreach($etm_fields as $field_val) {										
					echo "<input type='radio' name='etm_fakeElement_" . $i . "' class='field_" . $i . "' value='" . $field_val . "'> ". $field_val . "<br>";
				}				

				//print the form data
				echo "<input type='hidden' class='etm_toAdd' value='radio|+etm+|" . $obj->required . "|+etm+|" . $obj->text_before_field . "|+etm+|" . $obj->field_options . "' name='etm_formElement" . $i . "' id='etm_formElement" . $i . "' form='etm_contact' >";				
			}   elseif ($obj->field_type == "checkbox") {				
				$etm_fields = explode('|-etm-|', $obj->field_options);
				foreach($etm_fields as $field_val) {										
					echo "<input type='checkbox' name='etm_fakeElement_" . $i . "' class='field_" . $i . "' value='" . $field_val . "'> ". $field_val . "<br>";
				}				

				//print the form data
				echo "<input type='hidden' class='etm_toAdd' value='checkbox|+etm+|" . $obj->required . "|+etm+|" . $obj->text_before_field . "|+etm+|" . $obj->field_options . "' name='etm_formElement" . $i . "' id='etm_formElement" . $i . "' form='etm_contact' >";				
			} 

			//finish output
			echo "<br><a href='#' onclick='etm_deleteElement(".$i.");'>Delete</a></p></div>";
			$i++;
		}

		//add the counter to the page so JS can fetch it
		echo "<input type='hidden' value='".$i."' id='etm_counter'>";

	}	
?>

<style>
.etm_button {
	display:inline-block;
	padding:0.3em 0.7em;
	background:#dcdcdc;
	border:1px solid #d9d9d9;
	border-radius:8px;
	cursor:pointer;
	color:#21759b;
	font-size:100%;
	font-weight:bold;
}

#etm_form_output div {margin-bottom:2em;}

#etm_update {display:none;}
</style>

<div class="wrap">
<div id='etm_update'></div>	
	
	<?php screen_icon(); ?>

	<h2>Custom Contact Form</h2>
	<h3>Plug In Created By <a href="http://ellytronic.com" target="_blank">Ellytronic Media</a></h3>
	<p>To use this plugin, place the following shortcode on any page you wish to have it displayed on:	<strong>[etm_contact_form]</strong>
	</p><hr>

	<h3>Settings</h3>
	<form id="etm_admin_settings" action="#">
		<?php $settings = etm_form_settings(); ?>
		<p>
			<label for='etm_recipient_name'>Address the contact form to the following name:</label>
			<input id='etm_recipient_name' name='etm_recipient_name' form='etm_admin_settings' value='<?php echo $settings['name'];?>' required>
		</p>

		<p>
			<label for='etm_recipient_email'>Send the contact form to this email address:</label>
			<input id='etm_recipient_email' name='etm_recipient_email' form='etm_admin_settings' value='<?php echo $settings['email'];?>' required>
		</p>

		<p class="submit">
			<span class="button button-primary" id="etm_submit_settings">Update Settings</span>
		</p>		
	</form>
	
	<hr>


	<form action="#" id="etm_contact">	
		<h3>Form Editor</h3>
		<div id="etm_selectorContainer">
			
			<p>Choose item to add:</p>		
			<select id="etm_add_selector">
				<option value="do_nothing">Select One...</option>
				<option value="text">Single-Line Text Box</option>
				<option value="select">Selection Box</option>
				<option value="textarea">Large Text Box</option>
				<option value="password">Password Text Box</option>	
				<option value="radio">Radio Box (Choose One Option Style)</option>		
				<option value="checkbox">Check Boxes (Choose Multiple Option Style)</option>	
			</select>
		</div>

		<div id="etm_work_area">

			
		</div>

		<br><hr>

		<div id="etm_form_output">
			<h3>Your form so far:</h3>
			<?php etm_get_form();?>
		</div>

		<div id="etm_form_data" style="display:none;">
		</div>

		<?php //submit_button();?>
		<p class="submit">
			<span class="button button-primary" id="etm_submit">Update Form</span>
		</p>
	</form>
</div>