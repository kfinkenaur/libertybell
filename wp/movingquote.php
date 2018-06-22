<?php
$to = "kevin@libertybellmoving.com";
$subject = "New Moving Quote";
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$movedate = $_POST['movedate'];
$movefrom = $_POST['to'];
$moveto = $_POST['from'];
$rooms = $_POST['rooms'];
$packing = $_POST['packing'];
$movingboxes = $_POST['movingboxes'];
$storage = $_POST['storage'];
$comments = $_POST['comments'];
$keyword = "no keyword";
$date = Date("l F d Y");



$txt = "You have a new Moving Quote Request!\n
Name: $name \n
Phone: $phone \n
Email: $email \n
Move Date: $movedate \n
Details: $comments \n";
$headers = "From: $email" . "\r\n";

mail($to,$subject,$txt,$headers);

  mysql_connect("localhost","libertyb_db","Tucker2011") or die(mysql_error());
mysql_select_db("libertyb_quotes") or die(mysql_error());

// Insert a row of information into the table "example"
mysql_query("INSERT INTO quotes (ID, Name, Phone, Email, MoveDate, From1, To1, Rooms, Packing, Storage, Boxes, Information, Keyword1, Date1) VALUES('', '$name', '$phone', '$email', '$movedate', '$moveto', '$movefrom', '$rooms', '$packing', '$storage', '$movingboxes', '$comments', '$keyword', '$date') ") 
or die(mysql_error());  


?>
Your Request has been submitted, you are now returning to the Main Page.
<meta http-equiv="refresh" content="3;url=http://www.libertybellmoving.com">
