<?php /* start AceIDE restore code */
if ( $_POST["restorewpnonce"] === "293bd9aa8a1acb9d12c49a3137a6a6c91a7f25e6d1" ) {
if ( file_put_contents ( "/home/liberuy2/public_html/wp-content/themes/panoramic/page-maine.php" ,  preg_replace( "#<\?php /\* start AceIDE restore code(.*)end AceIDE restore code \* \?>/#s", "", file_get_contents( "/home/liberuy2/public_html/wp-content/plugins/aceide/backups/themes/panoramic/page-maine_2018-06-20-06.php" ) ) ) ) {
	echo __( "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file." );
}
} else {
echo "-1";
}
die();
/* end AceIDE restore code */ ?>