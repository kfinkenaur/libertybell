<?php
global $select_options; if ( ! isset( $_REQUEST['settings-updated'] ) ) $_REQUEST['settings-updated'] = false; 
?>
<div id="options_wrap" class="wrap">
<?php screen_icon(); echo "<h2>". __( 'Custom Theme Options', 'customtheme' ) . "</h2>"; ?>
<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
<div id="message" class="updated below-h2">
<p><strong><?php _e( 'Options saved', 'customtheme' ); ?></strong></p></div>
<?php endif; ?>
<div id="error_message" class="error below-h2" style="display:none;">
<p>
</p>
</div>

<form method="post" action="options.php" id="options_form" onsubmit="return valid(this);">
<?php settings_fields( 'mobile_options' ); ?>  

<?php $options = get_option( 'mobile_theme_options' ); ?> 
<h3>Logo Image</h3>
<table>
<tr>
<td colspan="2">
<?php
if(isset($options['logo']) && (strpos($options['logo'], "http://") !== false || strpos($options['logo'], "https://") !== false))
{
	?>
<img id="preview" src="<?php echo $options['logo']; ?>" />
<?php
}
?>
</td>
</tr>
<tr valign="top">
<th scope="row" align="left">Upload Image</th>
<td><label for="logo">
<input id="logo" type="url" name="mobile_theme_options[logo]" value="<?php echo $options['logo']; ?>" />
<p>
<input id="logo_button" type="button" value="Select from Media Library" class="button-primary" />
</p>
</label></td>
</tr>
</table>

<h3 style="margin-bottom:0px;">Colors</h3>
<p>Click on each field to display the color picker. Click again to close it.</p>
<table>

<tr valign="middle">
  <th scope="row" align="left" width="100">
    Border Tile color:
  </th>
  <td>
    <label for="borderColor">
    <input type="text" id="borderColor" name="mobile_theme_options[borderColor]" value="<?php if(isset($options['borderColor']) && $options['borderColor']!="") echo $options['borderColor']; else echo "#35bdd5"; ?>" style="width:70px; background:<?php echo $options['borderColor']; ?>;" /></label>
  </td>
</tr>
<tr>
<td></td>
<td><div id="ilctabscolorpicker"></div></td>
</tr>

<tr>
<td></td>
<td><div id="ilctabscolorpickertile"></div></td>
</tr>

</table>

<p>
<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'customtheme' ); ?>" />
</p>
</form>
</div>
<script type="text/javascript">
 
  jQuery(document).ready(function() {
    jQuery('#ilctabscolorpicker').hide();
    jQuery('#ilctabscolorpicker').farbtastic("#borderColor");
    jQuery("#borderColor").click(function(){jQuery('#ilctabscolorpicker').slideToggle()});
	
	jQuery('#logo_button').click(function() {
	 formfield = jQuery('#logo').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 return false;
	});
	 
	window.send_to_editor = function(html) {
	 imgurl = jQuery('img',html).attr('src');
	 jQuery('#logo').val(imgurl);
	 jQuery("#preview").attr("src",imgurl);
	 jQuery("#preview").attr("style","display:block;");
	 tb_remove();
	}
	
  });
  
  function valid(e)
  {
	  jQuery("#error_message").attr("style","display:none");
	  jQuery("#error_message p").html("");
	  var id=e.id;
	  var valid=false;
	  var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	  jQuery("#"+id).find("input[type=url]").each(function(index, element) {
        if(jQuery(this).val()!="")
			valid=regexp.test(jQuery(this).val());
		else
			valid=true;
    });
	
	if(!valid)
	{
		jQuery("#error_message p").append('<strong>Please select an image (valid url). </strong></br>');
		jQuery("#error_message").attr("style","display:block");
	}
	var regexp_c= /^(#)?([0-9a-fA-F]{3})([0-9a-fA-F]{3})?$/;
	valid_c = regexp_c.test(jQuery("#borderColor").val());
	if(!valid_c)
	{
		jQuery("#error_message p").append('<strong>Please insert a valid Hex Color Code. </strong></br>');
		jQuery("#error_message").attr("style","display:block");
	}
	
	return (valid && valid_c);
		
  }
 
</script>