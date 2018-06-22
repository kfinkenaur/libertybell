
<style>
/*--------------------------------------------------------------
5.1 Links
--------------------------------------------------------------*/
a {
<?php if(get_theme_mod("linkcolor-setting")) { ?>
color: <?php echo get_theme_mod("linkcolor-setting"); ?>;
<?php } else{?>
color:#333333;
<?php } ?>
}


a:hover,
a:focus,
a:active{
<?php if(get_theme_mod("linkcolorhover-setting")) { ?>
color: <?php echo get_theme_mod("linkcolorhover-setting"); ?>;
<?php } else{?>
color:#d23f50;
<?php } ?>
}

<?php if(get_theme_mod("typography-setting")){?>
html{
	font-family:<?php echo get_theme_mod("typography-setting") ;?>;
}
<?php } else{?>
html{
  font-family:Titillium Web;
}
  <?php }?>

.menu-footer ul ul li:hover > a,
.menu-footer ul ul li a:hover, .hentry .entry-meta, .menu-footer > ul > li:hover > a, .drag-social-button a:hover, .three-column-footer h2{
  <?php if(get_theme_mod("color-setting")){ ?>
color: <?php echo get_theme_mod("color-setting"); ?>;
<?php } else{ ?>
color: #d23f50;
<?php } ?>
}
.searchboxcontainer,
button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.newsticker-holder span,
.slider-title,
.titlecatholder span,
.read-more-button a,
.paging .nav-links span,
.howl-email-subs-box,
.woocommerce #respond input#submit, 
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.main-navigation ul ul,
.main-navigation ul li:hover,
.main-navigation ul .current-menu-item,
.tagcloud a:hover,
.drag-social-button-center ul li a:hover
{
<?php if(get_theme_mod("color-setting")){ ?>
background: <?php echo get_theme_mod("color-setting"); ?>;
<?php } else{ ?>
background: #d23f50;
<?php } ?>
}
<?php if(get_theme_mod("fontcolor-setting")){ ?>
.entry-content{
color: <?php echo get_theme_mod("fontcolor-setting"); ?>;
}
<?php } ?>
<?php if(get_theme_mod("fontsize")){ ?>
.entry-content{
font-size: <?php echo get_theme_mod("fontsize"); ?>px;
}
<?php } ?>
/*--------------------------------------------------------------
5.1 Boxed Layout
--------------------------------------------------------------*/
<?php if(get_theme_mod("layout_placement") == 'boxed'){ ?>
#page {
  width: 1140px;
  margin: 0px auto;
  background: rgb(255, 255, 255);
}
.main-navigation {
  margin-left: -20px;
}
@media only screen and (max-width: 1118px){
#page {
  width: 1000px;
}
  }
  @media only screen and (max-width: 970px){
#page {
  width: 780px;
}
.main-navigation {
  margin-left: 0px;
}
  }
  @media only screen and (max-width: 740px){
#page {
  width: 570px;
}
  }
   @media only screen and (max-width: 530px){
#page {
  width: 100%;

}
body{
  background: #fff !important;
}.searchboxcontainer {
  margin-right: 0px !important;
}
   }
    @media only screen and (max-width: 340px){
#page {
  width: 300px;
}
    }

<?php if(get_theme_mod( 'howl-themes_bgimg' )) {?>
body {
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center center;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  background-image:url('<?php echo esc_url( get_theme_mod( 'howl-themes_bgimg' ) ); ?>');
}
<?php } ?>

.searchboxcontainer {
  margin-right: -20px;
}
.srchcontainer {
  margin-right: 0px;
}

<?php } ?>
</style>