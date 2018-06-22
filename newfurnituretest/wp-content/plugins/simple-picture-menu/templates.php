<?php if (get_option('ECLIPSE_POSITION')=="Bottom"){ ?>
<style>


#ECLIPSE
{
bottom:0px;
left:0px;

<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
<?php } else{?><?php } ?>



<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
<?php } else{?><?php } ?>


<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
<?php } else{?><?php } ?>


width:100%;
<?php if (get_option('ECLIPSE_STICK')=="enable"){ ?>
position:fixed;
<?php } else{?>position:absolute; <?php } ?>
background-color:#<?php echo get_option('ECLIPSE_color'); ?>;
padding:0px;
}

#ECLIPSE img
{
transition:0.5s;
<?php if (get_option('E_SIZE')=="Small"){ ?>
height:40px;
width:40px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:65px;
width:65px;
<?php } else{?><?php } ?>
<?php if (get_option('E_SIZE')=="Large"){ ?>
height:90px;
width:90px;
<?php } else{?><?php } ?>
cursor:pointer;
}

#ECLIPSE img:hover
{
<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
width:50px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
width:75px;
<?php } else{?><?php } ?>
<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
width:100px;
<?php } else{?><?php } ?>
}


#POWERS {

<?php if (get_option('E_SIZE')=="Small"){ ?>
width:400px;<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
width:800px;<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Large"){ ?>
width:1000px;<?php } else{?> <?php } ?>

margin: 0 auto; 
}

.H_SYLAR
{

<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
width:50px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
width:75px;

<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
width:100px;

<?php } else{?><?php } ?>

float:left;
overflow:hidden;
color:grey;
font-size:10px;
transition:all 0.5s;
}



.H_SYLAR:hover
{
margin-top:-10px;
}


/* Smartphones (portrait) ----------- */
@media only screen 
and (max-width : 320px) {

#ECLIPSE
{
bottom:0px;
left:0px;
width:100%;
height:26px;
}


#POWERS { width: 320px; margin: 0 auto; }


.H_SYLAR
{

float:left;
height:26px;
width:26px;
overflow:hidden;
color:grey;
font-size:5px;
transition:all 0.5s;
}



#ECLIPSE img
{
height:16px;
width:16px;
cursor:pointer;
}


}
</style>
<?php } else{?><?php } ?>



<?php if (get_option('ECLIPSE_POSITION')=="Top"){ ?>
<style>


#ECLIPSE
{
top:0px;
left:0px;

<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
<?php } else{?><?php } ?>



<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
<?php } else{?><?php } ?>


<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
<?php } else{?><?php } ?>


width:100%;
<?php if (get_option('ECLIPSE_STICK')=="enable"){ ?>
position:fixed;
<?php } else{?>position:absolute; <?php } ?>
background-color:#<?php echo get_option('ECLIPSE_color'); ?>;
padding:0px;
}

#ECLIPSE img
{
transition:0.5s;
<?php if (get_option('E_SIZE')=="Small"){ ?>
height:40px;
width:40px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:65px;
width:65px;
<?php } else{?><?php } ?>
<?php if (get_option('E_SIZE')=="Large"){ ?>
height:90px;
width:90px;
<?php } else{?><?php } ?>
cursor:pointer;
}

#ECLIPSE img:hover
{
<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
width:50px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
width:75px;
<?php } else{?><?php } ?>
<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
width:100px;
<?php } else{?><?php } ?>
}

#POWERS { <?php if (get_option('E_SIZE')=="Small"){ ?>
width:400px;<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
width:800px;<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Large"){ ?>
width:1000px;<?php } else{?> <?php } ?>
 margin: 0 auto;
margin-top:5px; }

.H_SYLAR
{

<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
width:50px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
width:75px;

<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
width:100px;

<?php } else{?><?php } ?>

float:left;
overflow:hidden;
color:grey;
font-size:10px;
transition:all 0.5s;
}


.H_SYLAR:hover
{
margin-top:10px;
}



/* Smartphones (portrait) ----------- */
@media only screen 
and (max-width : 320px) {

#ECLIPSE
{
bottom:0px;
left:0px;
width:100%;
height:26px;
}


#POWERS { width: 320px; margin: 0 auto; }


.H_SYLAR
{

float:left;
height:26px;
width:26px;
overflow:hidden;
color:grey;
font-size:5px;
transition:all 0.5s;
}



#ECLIPSE img
{
height:16px;
width:16px;
cursor:pointer;
}


}
</style>
<?php } else{?><?php } ?>






<?php if (get_option('ECLIPSE_POSITION')=="Left"){ ?>
<style>


#ECLIPSE
{
top:0px;
left:0px;
<?php if (get_option('E_SIZE')=="Small"){ ?>
width:50px;
<?php } else{?><?php } ?>



<?php if (get_option('E_SIZE')=="Medium"){ ?>
width:75px;
<?php } else{?><?php } ?>


<?php if (get_option('E_SIZE')=="Large"){ ?>
width:100px;

<?php } else{?><?php } ?>

height:100%;

<?php if (get_option('ECLIPSE_STICK')=="enable"){ ?>
position:fixed;
<?php } else{?>position:absolute; <?php } ?>
background-color:#<?php echo get_option('ECLIPSE_color'); ?>;
padding:0px;
}

#ECLIPSE img
{
transition:0.5s;
<?php if (get_option('E_SIZE')=="Small"){ ?>
height:40px;
width:40px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:65px;
width:65px;
<?php } else{?><?php } ?>
<?php if (get_option('E_SIZE')=="Large"){ ?>
height:90px;
width:90px;
<?php } else{?><?php } ?>
cursor:pointer;
}

#ECLIPSE img:hover
{
<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
width:50px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
width:75px;
<?php } else{?><?php } ?>
<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
width:100px;
<?php } else{?><?php } ?>
}

#POWERS {  



<?php if (get_option('E_SIZE')=="Small"){ ?>
width:50px;<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
width:75px;<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Large"){ ?>
width:100px;<?php } else{?> <?php } ?>


margin: 0 auto;
margin-top:5px;



}

.H_SYLAR
{


overflow:hidden;
color:grey;
font-size:10px;
transition:all 0.5s;
float:left;

<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
width:50px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
width:75px;

<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
width:100px;

<?php } else{?><?php } ?>


}


.H_SYLAR:hover
{
margin-left:10px;
}



/* Smartphones (portrait) ----------- */
@media only screen 
and (max-width : 320px) {

#ECLIPSE
{
bottom:0px;
left:0px;
width:100%;
height:26px;
}


#POWERS { height: 320px; margin: 0 auto; }


.H_SYLAR
{

float:left;
height:26px;
width:26px;
overflow:hidden;
color:grey;
font-size:5px;
transition:all 0.5s;
}



#ECLIPSE img
{
height:16px;
width:16px;
cursor:pointer;
}


}
</style>
<?php } else{?><?php } ?>


<?php if (get_option('ECLIPSE_POSITION')=="Right"){ ?>
<style>


#ECLIPSE
{
top:0px;
right:0px;

<?php if (get_option('E_SIZE')=="Small"){ ?>
width:50px;
<?php } else{?><?php } ?>


<?php if (get_option('E_SIZE')=="Medium"){ ?>
width:75px;
<?php } else{?><?php } ?>


<?php if (get_option('E_SIZE')=="Large"){ ?>
width:100px;
<?php } else{?><?php } ?>

height:100%;
<?php if (get_option('ECLIPSE_STICK')=="enable"){ ?>
position:fixed;
<?php } else{?>position:absolute; <?php } ?>
background-color:#<?php echo get_option('ECLIPSE_color'); ?>;
padding:0px;
}

#ECLIPSE img
{
transition:0.5s;
<?php if (get_option('E_SIZE')=="Small"){ ?>
height:40px;
width:40px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:65px;
width:65px;
<?php } else{?><?php } ?>
<?php if (get_option('E_SIZE')=="Large"){ ?>
height:90px;
width:90px;
<?php } else{?><?php } ?>
cursor:pointer;
}
#ECLIPSE img:hover
{
<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
width:50px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
width:75px;
<?php } else{?><?php } ?>
<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
width:100px;
<?php } else{?><?php } ?>
}

#POWERS { 
<?php if (get_option('E_SIZE')=="Small"){ ?>
width:50px;<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
width:75px;<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Large"){ ?>
width:100px;<?php } else{?> <?php } ?>


margin: 0 auto;
margin-top:5px;
 }

.H_SYLAR
{

<?php if (get_option('E_SIZE')=="Small"){ ?>
height:50px;
width:50px;
<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Medium"){ ?>
height:75px;
width:75px;

<?php } else{?><?php } ?>

<?php if (get_option('E_SIZE')=="Large"){ ?>
height:100px;
width:100px;

<?php } else{?><?php } ?>

float:left;
overflow:hidden;
color:grey;
font-size:10px;
transition:all 0.5s;
}


.H_SYLAR:hover
{
margin-left:-10px;
}



/* Smartphones (portrait) ----------- */
@media only screen 
and (max-width : 320px) {

#ECLIPSE
{
bottom:0px;
left:0px;
width:100%;
height:26px;
}


#POWERS { height: 320px; margin: 0 auto; }


.H_SYLAR
{

float:left;
height:26px;
width:26px;
overflow:hidden;
color:grey;
font-size:5px;
transition:all 0.5s;
}



#ECLIPSE img
{
height:16px;
width:16px;
cursor:pointer;
}


}
</style>
<?php } else{?><?php } ?>
