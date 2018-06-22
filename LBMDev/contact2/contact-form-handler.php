<?php 
$errors = '';
$myemail = 'katrina@lightsidemedia.com';//<-----Put Your email address here.
if(empty($_POST['name'])  || 
   empty($_POST['phone']) || 
   empty($_POST['email']))
{
    $errors .= "\n Error: all fields are required";
}

$name = $_POST['name']; 
$phone = $_POST['phone']; 
$email = $_POST['email']; 
$from_street = $_POST['from_street']; 
$from_city = $_POST['from_city']; 
$from_state = $_POST['from_state']; 
$to_street = $_POST['to_street']; 
$to_city = $_POST['to_city']; 
$to_state = $_POST['to_state']; 
$move_out = $_POST['move_out']; 
$move_in = $_POST['move_in']; 

if (!preg_match(
"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", 
$email))
{
    $errors .= "\n Error: Invalid email address";
}

if( empty($errors))
{
	$to = $myemail; 
	$email_subject = "Contact form submission: $name";
	$email_body = "You have received a new message. ".
	" Here are the details:\n Name: $name \n Phone: $phone \n Email: $email \n Moving From: $from_street  , $from_city, $from_state \n Moving To: $from_street  , $from_city, $from_state \n Move Out Date: $move_out \n Move In Date: $move_in"; 
	
	$headers = "From: $myemail\n"; 
	$headers .= "Reply-To: $email";
	
	mail($to,$email_subject,$email_body,$headers);
	//redirect to the 'thank you' page
	header('Location: contact-form-thank-you.html');
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Contact form handler</title>
</head>

<body>
<!-- This page is displayed only if there is some error -->
<?php
echo nl2br($errors);
?>


</body>
</html>