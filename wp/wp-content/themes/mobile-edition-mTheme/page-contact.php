<?php
//If the form is submitted
if(isset($_POST['submitted'])) {

    //Check to see if the honeypot captcha field was filled in
	if(trim($_POST['checking']) !== '') {
		$captchaError = true;
	} else {

		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError = true; //erro especifico do campo
			$hasError = true; //tem erro no form logo não envia
		} else {
			$name = trim($_POST['contactName']);
		}

		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = true;
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = true;
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}

		//Check to make sure comments were entered
		if(trim($_POST['comments']) === '') {
			$commentError = true;
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		//
		if(trim($_POST['assunto']) === '') {
			$assuntoError = true;
			$hasError = true;
		} else {
			$assunto = trim($_POST['assunto']);
		}


		//If there is no error, send the email
		if(!isset($hasError)) {
		    $options = get_option('fdx3_updater_options');
            $emailTo = $options['fdx_email_contato'];
            $urlsend = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
		    $ip = $_SERVER['REMOTE_ADDR']; //ip
            $data = date('d/m/Y H:i:s'); //data
            $subject = '[WP Mobile Edition]~' .$assunto;
			$body = "NAME: $name <p>EMAIL: $email </p><p>SUBJECT: $assunto </p><p>MESSAGE: $comments </p>-------------------------------------------<br /><small>IP: $ip | $data(gmt)<br /> $urlsend </small>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
            $headers .= 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email . "\r\n";

            mail($emailTo, $subject, $body, $headers);
    		$emailSent = true;
		}
    }
}
?>
<?php get_header(); ?>
<div class="fdx_topheading"><?php _e('Contact', 'wp-mobile-edition') ?></div>
<div class="fdx_content" style="padding: 10px">
 <?php if(isset($emailSent) && $emailSent == true) { ?>

	<div class="thanks">
		<h1><?php _e('Thanks', 'wp-mobile-edition') ?>, <?=$name;?></h1>
		<p><?php _e('Your message has been sent successfully', 'wp-mobile-edition') ?>!</p>
	</div>

<?php } else { ?>

<!-- ====================================== -->


<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
<?php _e('Name', 'wp-mobile-edition') ?>:<br />
<input name="contactName" id="contactName" size="22" tabindex="1" type="text" class="fdx_commentform_input" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" <?php if(@$nameError != '') { ?>style="border: 1px solid #DD0000;"<?php } ?>> <br />
<?php _e('Email', 'wp-mobile-edition') ?>: <br />
<input type="text" name="email" id="email" class="fdx_commentform_input" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" <?php if(@$emailError != '') { ?>style="border: 1px solid #DD0000;"<?php } ?>/>
<?php _e('Subject', 'wp-mobile-edition') ?>:<br />
<input type="text" name="assunto" id="assunto" class="fdx_commentform_input" value="<?php if(isset($_POST['assunto'])) echo $_POST['assunto'];?>" <?php if(@$assuntoError != '') { ?>style="border: 1px solid #DD0000;"<?php } ?>/>
<?php _e('Message', 'wp-mobile-edition') ?>:<br />
<textarea name="comments" id="commentsText" cols="100" rows="10" class="fdx_commentform_textarea" <?php if(@$commentError != '') { ?>style="border: 1px solid #DD0000;"<?php } ?>><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
<input type="text" name="checking" class="darkform" id="checking" size="7" value="<?php if(isset($_POST['checking']))  echo $_POST['checking'];?>" <?php if(@$captchaError != '') { ?>style="border: 1px solid #DD0000;"<?php } ?>/> <span style="font-size: 10px">&larr; <?php _e('Anti-Spam, leave this field blank', 'wp-mobile-edition') ?>.</span>
<input type="hidden" name="submitted" id="submitted" value="true" />
<p align="center" style="margin-top: 10px"><button type="submit" name="submit" id="submit" class="fdx_commentform_send"><?php _e('Send message', 'wp-mobile-edition') ?></button></p>
</form>


<!-- ====================================== -->
<?php } ?>
 </div>
<?php get_footer(); ?>