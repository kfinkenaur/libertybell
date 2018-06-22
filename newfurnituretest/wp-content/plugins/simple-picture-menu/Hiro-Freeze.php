<?php { ?>

<?php
$plugins_url = plugins_url();
?>
<div class="clear"></div>
Power
<div class="clear"></div>
<div class="HIRO_FREEZE" title="On or Off" id="H_FREEZE1" style='cursor:pointer;height:50px;width:100px;'>


<?php if (get_option('HERO_NAVi') != '') { ?>
<?php if (get_option('HERO_NAVi')=="enable"){ ?><?php echo "<img class='funny' onclick='swap();' style='cursor:pointer;height:50px;width:100px;' src='" . plugins_url( 'pictures/nav-on.png' , __FILE__ ) . "'> "; ?>
<?php } else{  } ?><?php if (get_option('HERO_NAVi')=="disable"){ ?><?php echo "<img class='funny' onclick='swap2();' style='cursor:pointer;height:50px;width:100px;'  src='" . plugins_url( 'pictures/off.png' , __FILE__ ) . "' > "; ?>
<?php } else{  } ?>

<? } else {  echo "<img class='funny' onclick='swap2();' style='cursor:pointer;height:50px;width:100px;'  src='" . plugins_url( 'pictures/off.png' , __FILE__ ) . "' > "; 
}?>
<input style="visibility:hidden;display:none;" type="radio" name="HERO_NAVi" id="HERO_NAVi" onclick="save()" value="enable" <?php if(get_option('HERO_NAVi') == "enable") { echo ' checked'; } ?>/> 
<input style="visibility:hidden;display:none;" type="radio" name="HERO_NAVi" id="HERO_NAVi2" onclick="save()" value="disable" <?php if(get_option('HERO_NAVi') == "disable") { echo ' checked'; } ?>/> 
</div>
<div class="clear"></div>
Position
<div class="clear"></div>
<div class="HIRO_FREEZE" id="H_FREEZE2" style='cursor:pointer;height:50px;width:100px;'>

<div class="styled-select">
       <select name="ECLIPSE_POSITION" id="ECLIPSE_POSITION" onchange="save();">
        <option name="Top" value="Top"<?php if(get_option('ECLIPSE_POSITION') == "Top") { echo ' selected'; } ?>>Top</option>
        <option name="Bottom" value="Bottom"<?php if(get_option('ECLIPSE_POSITION') == "Bottom") { echo ' selected'; } ?>>Bottom</option>
        <option name="Left" value="Left"<?php if(get_option('ECLIPSE_POSITION') == "Left") { echo ' selected'; } ?>>Left</option>
        <option name="Right" value="Right"<?php if(get_option('ECLIPSE_POSITION') == "Right") { echo ' selected'; } ?>>Right</option>
        </select>
</div>

</div>

<div class="clear"></div>
Size
<div class="clear"></div>
<div class="HIRO_FREEZE" id="H_FREEZE3" style='cursor:pointer;height:50px;width:100px;'>

<div class="styled-select">
       <select style="cursor:pointer;" name="E_SIZE" id="E_SIZE" onchange="save();">
        <option name="Small" value="Small"<?php if(get_option('E_SIZE') == "Small") { echo ' selected'; } ?>>Small</option>
        <option name="Medium" value="Medium"<?php if(get_option('E_SIZE') == "Medium") { echo ' selected'; } ?>>Medium</option>
        <option name="Large" value="Large"<?php if(get_option('E_SIZE') == "Large") { echo ' selected'; } ?>>Large</option>
        </select>
</div>

</div>


<div class="clear"></div>
Scroll
<div class="clear"></div>

<div class="HIRO_FREEZE"  id="H_FREEZE5" style='cursor:pointer;height:50px;width:100px;' title="Decide between a navigation bar that is sticky to the top when scrolled or if it stays in place">
                      <?php if (get_option('ECLIPSE_STICK') != '') { ?>
<?php if (get_option('ECLIPSE_STICK')=="enable"){ ?><?php echo "<img class='funny' onclick='swap3();' style='cursor:pointer;height:50px;width:100px;' src='" . plugins_url( 'pictures/nav-on.png' , __FILE__ ) . "'> "; ?>
<?php } else{  } ?><?php if (get_option('ECLIPSE_STICK')=="disable"){ ?><?php echo "<img class='funny' onclick='swap33();' style='cursor:pointer;height:50px;width:100px;'  src='" . plugins_url( 'pictures/off.png' , __FILE__ ) . "' > "; ?>
<?php } else{  } ?>

<? } else {  echo "<img class='funny' onclick='swap33();' style='cursor:pointer;height:50px;width:100px;'  src='" . plugins_url( 'pictures/off.png' , __FILE__ ) . "' > "; 
}?>
<input style="visibility:hidden;display:none;" type="radio" name="ECLIPSE_STICK" id="ECLIPSE_STICK" onclick="save()" value="enable" <?php if(get_option('ECLIPSE_STICK') == "enable") { echo ' checked'; } ?>/> 
<input style="visibility:hidden;display:none;" type="radio" name="ECLIPSE_STICK" id="ECLIPSE_STICK2" onclick="save()" value="disable" <?php if(get_option('ECLIPSE_STICK') == "disable") { echo ' checked'; } ?>/>
</div>

<div class="clear"></div>
Color
<div class="clear"></div>
<div class="HIRO_FREEZE" id="H_FREEZE4" style='cursor:pointer;height:50px;width:100px;'>

<?php if (get_option('TRANS') != '') { ?>
<?php if (get_option('TRANS')=="enable"){ ?><?php echo "<img class='funny' onclick='swap4();' style='cursor:pointer;height:50px;width:100px;' src='" . plugins_url( 'pictures/nav-on.png' , __FILE__ ) . "'> "; ?>
<?php } else{  } ?><?php if (get_option('TRANS')=="disable"){ ?><?php echo "<img class='funny' onclick='swap44();' style='cursor:pointer;height:50px;width:100px;'  src='" . plugins_url( 'pictures/off.png' , __FILE__ ) . "' > "; ?>
<?php } else{  } ?>

<? } else {  echo "<img class='funny' onclick='swap44();' style='cursor:pointer;height:50px;width:100px;'  src='" . plugins_url( 'pictures/off.png' , __FILE__ ) . "' > "; 
}?>
<input style="visibility:hidden;display:none;" type="radio" name="TRANS" id="TRANS" onclick="save()" value="enable" <?php if(get_option('TRANS') == "enable") { echo ' checked'; } ?>/> 
<input style="visibility:hidden;display:none;" type="radio" name="TRANS" id="TRANS2" onclick="save()" value="disable" <?php if(get_option('TRANS') == "disable") { echo ' checked'; } ?>/> 



<?php if (get_option('TRANS')=="enable"){ ?>
<br>
<?php
echo "<script src='" . plugins_url( 'js/jscolor.js' , __FILE__ ) . "'></script> ";
?>
<input class="color {onImmediateChange:'updateInfo(this);}" type="text" id="ECLIPSE_color" name="ECLIPSE_color" value="<?php echo get_option('ECLIPSE_color'); ?>"/>

<?php } else{?>
<?php  } ?>
</div>
<div class="clear"></div>
<br><br><br>
<?php } ?>