<?php /* start AceIDE restore code */
if ( $_POST["restorewpnonce"] === "293bd9aa8a1acb9d12c49a3137a6a6c908ab2321d6" ) {
if ( file_put_contents ( "/home/liberuy2/public_html/wp-content/themes/panoramic/header-hampshire.php" ,  preg_replace( "#<\?php /\* start AceIDE restore code(.*)end AceIDE restore code \* \?>/#s", "", file_get_contents( "/home/liberuy2/public_html/wp-content/plugins/aceide/backups/themes/panoramic/header-hampshire_2018-06-20-18.php" ) ) ) ) {
	echo __( "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file." );
}
} else {
echo "-1";
}
die();
/* end AceIDE restore code */ ?>