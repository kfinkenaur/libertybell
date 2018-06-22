<div id='ultra_hidey_body'>
<?php
if (!is_admin()) {
  echo ("<div id='error'>
  <h3>Permission Denied</h3>
  <p>You dont have the required permission to view this page</p>
  </div>");
  }
else {
  ?>
  
<h1>Ultra Hide Comment Box - Settings</h1>

<p>This plugin is powered by <a href='http://www.userw.com'>Custom Wordpress Plugins</a> and designed by <a href='http://www.skinzee.com'>Custom Wordpress Themes</a></p>

<p>If you like this plugin, please consider donating whatever you can afford.
<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="QW7JYQMKVNZVY"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></form>
</p>

<p>Please select the list of categories you would like to hide "Add Comments" box on posts.</p>
<?php

if ($_POST['submit'] == "UPDATE") {
  update_option('ultra_hidey_catlist', $_POST[catg_select]);
  
  echo ("<div id='success'>
  <h3>Settings Update Result</h3>
  <p>Settings update was successful.<br />The posts from the selected categories will not show up the \"Add Comment\" box.</p>
  </div>");
  }



$categories = get_categories();
if (is_array($categories)) {
  echo ("
  <form method='post' action='$_SERVER[PHP_SELF]?page=ultra-hide-settings-page' name='' id=''>
  <table align='center'>");
  
  /* Find existing Category selection */
  $catg_selections = get_option('ultra_hidey_catlist');
  
  foreach ($categories as $catg) {
    if (is_array($catg_selections) && in_array($catg->cat_ID, $catg_selections)) {
    $catg_checked = "checked='checked' ";
    }
    elseif($catg_selections == $catg->cat_ID) {
    $catg_checked = "checked='checked' ";
    }
    else {
    $catg_checked = NULL;
    }
  
    echo ("<tr>
    <td><input type='checkbox' name='catg_select[]' value='$catg->cat_ID' $catg_checked /></td> <td><strong>$catg->name</strong></td>
    </tr>");
  
  }
  echo ("
  <tr>
  <td colspan='2'><br />
  <input type='submit' name='submit' value='UPDATE' /></td>
  </tr>
  </table>
  </form>");
}
?>
  
<?php  
}
?>
</div>
