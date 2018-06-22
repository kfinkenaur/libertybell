<?php
/*
Plugin Name: Simple Picture Menu
Plugin URI: http://
Description: A menu bar placed on any side of the screen to create a picture based bar, for users to navigate through out your website.
Version: 1.5
Author: Logan Wheeler
Author URI: http://profiles.wordpress.org/loganw
License: Free
*/

/*  Copyright 2013  Logan Wheeler  (email : loganw@rhodesbread.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


register_activation_hook();
register_deactivation_hook();
register_uninstall_hook();
add_action('admin_menu', 'add_new_pages');



add_option('ECLIPSE_color', '');
add_option('ECLIPSE_POSITION', '');
add_option('ECLIPSE_STICK', '');
add_option('E_SIZE', '');
add_option('HEROES1', '');
add_option('HEROES2', '');
add_option('HEROES3', '');
add_option('HEROES4', '');
add_option('HEROES5', '');
add_option('HEROES6', '');
add_option('HEROES7', '');
add_option('HEROES8', '');
add_option('HEROES9', '');
add_option('HEROES10', '');
add_option('H1-LINK', '');
add_option('H2-LINK', '');
add_option('H3-LINK', '');
add_option('H4-LINK', '');
add_option('H5-LINK', '');
add_option('H6-LINK', '');
add_option('H7-LINK', '');
add_option('H8-LINK', '');
add_option('H9-LINK', '');
add_option('H10-LINK', '');
add_option('H1-TITLE', '');
add_option('H2-TITLE', '');
add_option('H3-TITLE', '');
add_option('H4-TITLE', '');
add_option('H5-TITLE', '');
add_option('H6-TITLE', '');
add_option('H7-TITLE', '');
add_option('H8-TITLE', '');
add_option('H9-TITLE', '');
add_option('H10-TITLE', '');
add_option('HERO_NAVi', '');
add_option('TRANS', '');



function add_new_pages() {
    // Add the top-level admin menu
    $page_title = 'SimplePictureMenu';
    $menu_title = 'Simple Picture Menu';
    $capability = 5;
    $menu_slug = 'simplepicturemenu';
    $function = 'simple_picture_menu';
    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function);
}

add_action('admin_enqueue_scripts', 'my_admin_scripts');
 
function my_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'simplepicturemenu') {
        wp_enqueue_media();
        wp_register_script('scripts', WP_PLUGIN_URL.'/scripts.php', array('jquery'));
        wp_enqueue_script('scripts');
    }
}




function simple_picture_menu() { ?>
 <script type="text/javascript">
var color=new Array(5);
color[0]="#f7f298";
color[1]="#a8f798";
color[2]="#80E3F7";
color[3]="#c683c7";
color[4]="#f96464";
color[5]="#7ccadd";
function changeColor()
{
var ranNum= Math.floor(Math.random()*6);
document.getElementById('H_FREEZE1').style.backgroundColor=color[ranNum];
document.getElementById('H_FREEZE2').style.backgroundColor=color[ranNum];
document.getElementById('H_FREEZE3').style.backgroundColor=color[ranNum];
document.getElementById('H_FREEZE4').style.backgroundColor=color[ranNum];
document.getElementById('H_FREEZE5').style.backgroundColor=color[ranNum];
document.getElementById('LOC1').style.backgroundColor=color[ranNum];
document.getElementById('LOC2').style.backgroundColor=color[ranNum];
document.getElementById('LOC3').style.backgroundColor=color[ranNum];
document.getElementById('LOC4').style.backgroundColor=color[ranNum];
document.getElementById('LOC5').style.backgroundColor=color[ranNum];
document.getElementById('LOC6').style.backgroundColor=color[ranNum];
document.getElementById('LOC7').style.backgroundColor=color[ranNum];
document.getElementById('LOC8').style.backgroundColor=color[ranNum];
document.getElementById('LOC9').style.backgroundColor=color[ranNum];
document.getElementById('LOC10').style.backgroundColor=color[ranNum];
document.getElementById('FOOT').style.backgroundColor=color[ranNum];
document.getElementById('HEAD').style.backgroundColor=color[ranNum];
document.getElementById('iFind1').style.backgroundColor=color[ranNum];
document.getElementById('iFind2').style.backgroundColor=color[ranNum];
}
</script>  

<script>

function hiii(elem) {
vis = document.getElementById('ABILITY1').style.height;
vis2 = document.getElementById('ABILITY2').style.height;
vis3 = document.getElementById('ABILITY3').style.height;
vis4 = document.getElementById('ABILITY4').style.height;
vis5 = document.getElementById('ABILITY5').style.height;
vis6 = document.getElementById('ABILITY6').style.height;
vis7 = document.getElementById('ABILITY7').style.height;
vis8 = document.getElementById('ABILITY8').style.height;
vis9 = document.getElementById('ABILITY9').style.height;
vis10 = document.getElementById('ABILITY10').style.height;
if (vis > "1")
  {
document.getElementById('HEROES1').value=elem.src;
save();
  }
else {}
if (vis2 > "1")
  {
document.getElementById('HEROES2').value=elem.src;
save();
  }
else {}
if (vis3 > "1")
  {
document.getElementById('HEROES3').value=elem.src;
save();
  }
else {}
if (vis4 > "1")
  {
document.getElementById('HEROES4').value=elem.src;
save();
  }
else {}
if (vis5 > "1")
  {
document.getElementById('HEROES5').value=elem.src;
save();
  }
else {}
if (vis6 > "1")
  {
document.getElementById('HEROES6').value=elem.src;
save();
  }
else {}
if (vis7 > "1")
  {
document.getElementById('HEROES7').value=elem.src;
save();
  }
else {}
if (vis8 > "1")
  {
document.getElementById('HEROES8').value=elem.src;
save();
  }
else {}
if (vis9 > "1")
  {
document.getElementById('HEROES9').value=elem.src;
save();
  }
else {}
if (vis10 > "1")
  {
document.getElementById('HEROES10').value=elem.src;
save();
  }
else {}

}
</script>


<?php
$plugins_url = plugins_url();
?>

<?php
require( plugin_dir_path( __FILE__ ) . 'scripts.php');
?>


<?php
require( plugin_dir_path( __FILE__ ) . 'admin-css.php');
?>


<!DOCTYPE HTML>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>
        </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="screen.css" type="text/css" media="screen, projection">
        <!--[if lt IE 8]>
            <link rel="stylesheet" href="ie.css" type="text/css" media="screen, projection">
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="mobile.css" media="only screen and (max-device-width: 640px)">
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    </head>
    
    <body onload="changeColor();">
        <div class="container">
<form id="FLYING_MAN" method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<?php
$plugins_url = plugins_url();
?>

            <div id="HEAD" class="span-24 r1 first last">
<center>Simple Picture Menu</center>
            </div>
            <div class="span-5 r2 first">
                <p>

<?php
require( plugin_dir_path( __FILE__ ) . 'Hiro-Freeze.php');
?>
<!--sidebar-->
                </p>
            </div>
            <div class="span-14 r2" style="text-align:center;">
                <p>


<?php
require( plugin_dir_path( __FILE__ ) . 'abilities.php');
?>
                </p>
            </div>
            <div class="span-5 r2 last" >
                <p>
<script>

function iconsss(elem) {
in = document.getElementById('iconss').style.height;
in2 = document.getElementById('iconss2').style.height;

if (in > "1")
  {
document.getElementById('HEROES1').value=elem.src;
save();
  }
else {}
if (in > "1")
  {
document.getElementById('HEROES2').value=elem.src;
save();
  }
else {}


}
</script>


<div onclick="FindI1();" id="iFind1">Robot</div>

<div id="iconss" style="height:200px;">
<?php echo "<img  src='" . plugins_url( 'pictures/robot/Audio.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Address-Book.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Calendar.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Cd.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Dvd.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Images.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Keyboard.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Mail.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Pictures.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Safari.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Settings.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Mac.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/robot/Web.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>
</div>

<div onclick="FindI2();" id="iFind2">Simple Icons</div>

<div id="iconss2" style="height:0px;">

<?php echo "<img  src='" . plugins_url( 'pictures/simple/addThis.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>


<?php echo "<img  src='" . plugins_url( 'pictures/simple/amazon.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/blogger.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/dailyBooth.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/facebook.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/flickr.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/google.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/googlePlus.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/picasa.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/pinIt.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/pinterest.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/rss.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/tumblr.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/twitter.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/vimeo.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/wordpress.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/yahoo.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>

<?php echo "<img  src='" . plugins_url( 'pictures/simple/youtube.png' , __FILE__ ) . "' onclick='hiii(this)'> "; ?>


</div>

                </p>
            </div>




            <div onclick="save();" id="FOOT" class="span-24 r3 first last">
              <center> Save</center>
           </div>
        </div>
    </body>

</html>






<input style="display:none;" id="CLAIRE" type="submit" name="Submit" value="<?php _e('Save') ?>" />
<input type="hidden" name="action" value="update" /><input type="hidden" name="page_options" onsubmit="return false;" value="HERO_NAVi,ECLIPSE_color,ECLIPSE_POSITION,E_SIZE,HEROES1,HEROES2,HEROES3,HEROES4,HEROES5,HEROES6,HEROES7,HEROES8,HEROES9,HEROES10,H1-LINK,H2-LINK,H3-LINK,H4-LINK,H5-LINK,H6-LINK,H7-LINK,H8-LINK,H9-LINK,H10-LINK,H1-TITLE,H2-TITLE,H3-TITLE,H4-TITLE,H5-TITLE,H6-TITLE,H7-TITLE,H8-TITLE,H9-TITLE,H10-TITLE,TRANS,ECLIPSE_STICK" />



</form>
<script>
$('ul.tabs').each(function(){
  // For each set of tabs, we want to keep track of
  // which tab is active and it's associated content
  var $active, $content, $links = $(this).find('a');

  // If the location.hash matches one of the links, use that as the active tab.
  // If no match is found, use the first link as the initial active tab.
  $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
  $active.addClass('active');
  $content = $($active.attr('href'));

  // Hide the remaining content
  $links.not($active).each(function () {
    $($(this).attr('href')).hide();
  });

  // Bind the click event handler
  $(this).on('click', 'a', function(e){
    // Make the old tab inactive.
    $active.removeClass('active');
    $content.hide();

    // Update the variables with the new link and content
    $active = $(this);
    $content = $($(this).attr('href'));

    // Make the tab active.
    $active.addClass('active');
    $content.show();

    // Prevent the anchor's default click action
    e.preventDefault();
  });
});

<?php } 



function ECLIPSE_HEADER() {
?>
<?php
$plugins_url = plugins_url();
?>


<?php
require( plugin_dir_path( __FILE__ ) . 'templates.php');
?>

<?php if (get_option('HERO_NAVi')=="enable"){ ?>


<div id="ECLIPSE">
<div id="POWERS">
<center>

<?php if (get_option('HEROES1') != '') { ?><a  class="H_SYLAR" href="<?php echo get_option('H1-LINK'); ?>"><img  id="Hee1" src="<?php echo get_option('HEROES1'); ?>" title="<?php echo get_option('H1-TITLE'); ?>"><br><?php echo get_option('H1-TITLE'); ?></a>
<? } else { }?>

<?php if (get_option('HEROES2') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H2-LINK'); ?>"><img id="H2" src="<?php echo get_option('HEROES2'); ?>" title="<?php echo get_option('H2-TITLE'); ?>"><br><?php echo get_option('H2-TITLE'); ?></a>
<? } else { }?>


<?php if (get_option('HEROES3') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H3-LINK'); ?>"><img src="<?php echo get_option('HEROES3'); ?>" title="<?php echo get_option('H3-TITLE'); ?>"><br><?php echo get_option('H3-TITLE'); ?></a>
<? } else { }?>


<?php if (get_option('HEROES4') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H4-LINK'); ?>"><img src="<?php echo get_option('HEROES4'); ?>" title="<?php echo get_option('H4-TITLE'); ?>"><br><?php echo get_option('H4-TITLE'); ?></a>
<? } else { }?>


<?php if (get_option('HEROES5') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H5-LINK'); ?>"><img src="<?php echo get_option('HEROES5'); ?>" title="<?php echo get_option('H5-TITLE'); ?>"><br><?php echo get_option('H5-TITLE'); ?></a>
<? } else { }?>

<?php if (get_option('HEROES6') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H6-LINK'); ?>"><img src="<?php echo get_option('HEROES6'); ?>" title="<?php echo get_option('H6-TITLE'); ?>"><br><?php echo get_option('H6-TITLE'); ?></a>
<? } else { }?>



<?php if (get_option('HEROES7') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H7-LINK'); ?>"><img src="<?php echo get_option('HEROES7'); ?>" title="<?php echo get_option('H7-TITLE'); ?>"><br><?php echo get_option('H7-TITLE'); ?></a>
<? } else { }?>



<?php if (get_option('HEROES8') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H8-LINK'); ?>"><img src="<?php echo get_option('HEROES8'); ?>" title="<?php echo get_option('H8-TITLE'); ?>"><br><?php echo get_option('H8-TITLE'); ?></a>
<? } else { }?>


<?php if (get_option('HEROES9') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H9-LINK'); ?>"><img src="<?php echo get_option('HEROES9'); ?>" title="<?php echo get_option('H9-TITLE'); ?>"><br><?php echo get_option('H9-TITLE'); ?></a>
<? } else { }?>


<?php if (get_option('HEROES10') != '') { ?><a class="H_SYLAR" href="<?php echo get_option('H10-LINK'); ?>"><img src="<?php echo get_option('HEROES10'); ?>" title="<?php echo get_option('H10-TITLE'); ?>"><br><?php echo get_option('H10-TITLE'); ?></a>
<? } else { }?>



</center>
</div>
</div>

<?php } else{  } ?>
<?php
}
add_action('wp_head','ECLIPSE_HEADER');


