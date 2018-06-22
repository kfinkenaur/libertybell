<?php
if(isset($_POST['Submit']) == 'Update'){
    require_once ("geocode-class.php");
    $googleplaces_plugin_options=array(
    'googleplaces_Plugin_Settings_description'=> htmlentities($_POST['googleplaces_Plugin_Settings_description']),
    'googleplaces_Plugin_Settings_ln'=> $_POST['googleplaces_Plugin_Settings_ln'],
    'googleplaces_Plugin_Settings_street_address'=>$_POST['googleplaces_Plugin_Settings_street_address'],
    'googleplaces_Plugin_Settings_city_town'=>$_POST['googleplaces_Plugin_Settings_city_town'],
    'googleplaces_Plugin_Settings_state'=>$_POST['googleplaces_Plugin_Settings_state'],
    'googleplaces_Plugin_Settings_postal_code'=>$_POST['googleplaces_Plugin_Settings_postal_code'],
    'googleplaces_Plugin_Settings_country'=>$_POST['googleplaces_Plugin_Settings_country'],
    'googleplaces_Plugin_Settings_ln'=>$_POST['googleplaces_Plugin_Settings_ln'],
    'googleplaces_Plugin_Settings_phone'=>$_POST['googleplaces_Plugin_Settings_phone'],
    'googleplaces_Plugin_filename'=>$_POST['googleplaces_Plugin_filename'],
    'googleplaces_Plugin_filename_georss'=>$_POST['googleplaces_Plugin_filename_georss']
);
update_option('googleplaces_plugin_options',$googleplaces_plugin_options );       


$geocode=new geocode($googleplaces_plugin_options['googleplaces_Plugin_Settings_street_address'],$googleplaces_plugin_options['googleplaces_Plugin_Settings_city_town'],$googleplaces_plugin_options['googleplaces_Plugin_Settings_country']);
$site_url = site_url();
$kml=array();
$kml[]='<?xml version="1.0" encoding="UTF-8"?>';
$kml[]='<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">';
    $kml[]='<name>'.$googleplaces_plugin_options['googleplaces_Plugin_Settings_ln'].'</name>';
    $kml[]='<atom:author>';
    $kml[]='<atom:name>Ritesh Khare</atom:name>';
    $kml[]='</atom:author>';
    $kml[]='<atom:link rel="related" href="'.$site_url.'" />';
        $kml[]='<folder>';
            $kml[]='<Document>';
                $kml[]='<Placemark>';
                    $kml[]='<name><![CDATA['.$googleplaces_plugin_options['googleplaces_Plugin_Settings_ln'].']]></name>';
                    $kml[]='<address><![CDATA['.$googleplaces_plugin_options['googleplaces_Plugin_Settings_street_address'].','.$googleplaces_plugin_options['googleplaces_Plugin_Settings_city_town'].' , '.$googleplaces_plugin_options['googleplaces_Plugin_Settings_state'].','.$googleplaces_plugin_options['googleplaces_Plugin_Settings_postal_code'].','.$googleplaces_plugin_options['googleplaces_Plugin_Settings_country'].']]></address>';
                    $kml[]='<description><![CDATA['.$googleplaces_plugin_options['googleplaces_Plugin_Settings_description'].']]></description>';
                    $kml[]='<Point><coordinates>'.$geocode->lat().','.$geocode->lng().'</coordinates></Point>';
                $kml[]='</Placemark>';
            $kml[]='</Document>';
       $kml[]='</folder>';
$kml[]='</kml>';
    //echo $kml."<br/>";
    //echo $kml;
    $kmlOutput = join("\n", $kml);
    $filename_kml=get_home_path().'/'.$googleplaces_plugin_options['googleplaces_Plugin_filename'].".kml";
    if (check_permissions($filename_kml)) {
             file_put_contents($filename_kml, $kmlOutput);
    }else{
        echo "unable to write the file check permissions";
    }

	  

          $geo_sitemap_xml=array();
          $geo_sitemap_xml[]='<?xml version="1.0" encoding="UTF-8"?>';
          $geo_sitemap_xml[]='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:geo="http://www.google.com/geo/schemas/sitemap/1.0">';
            $geo_sitemap_xml[]='<url>';
                $geo_sitemap_xml[]='<loc>'.$site_url.'/'.$googleplaces_plugin_options['googleplaces_Plugin_filename'].'.kml</loc>';
                    $geo_sitemap_xml[]='<geo:geo>';
                        $geo_sitemap_xml[]='<geo:format>kml</geo:format>';
                    $geo_sitemap_xml[]='</geo:geo>';
            $geo_sitemap_xml[]='</url>';
          $geo_sitemap_xml[]='</urlset>';
          
          $geo_sitemap_Output = join("\n", $geo_sitemap_xml);
            $filename_xml = get_home_path().'/'.$googleplaces_plugin_options['googleplaces_Plugin_filename_georss'].'.xml';
            if (check_permissions($filename_xml)) {
            file_put_contents($filename_xml, $geo_sitemap_Output);
            } else{
                echo "unable to write the file check permissions";
            }

?>
<div class="updated"><p><strong><?php _e("Options saved." ); ?></strong></p></div>  <?php
}
?>

<div class="wrap">
    <?php echo "<h2>" . __('googleplaces Plugin Settings Page') . "</h2>";

    $googleplaces_plugin_options=  get_option('googleplaces_plugin_options');
    //print_r($googleplaces_plugin_options);

    ?>

    <form name="googleplaces-Plugin-Settings-form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <?php    echo "<h4>" . __('Google maps Details') . "</h4>"; ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row"><label for="googleplaces_Plugin_Settings_ln">Location / Company Name<span> *</span>: </label></th>
            <td><input id="googleplaces_Plugin_Settings_ln" type="text" name="googleplaces_Plugin_Settings_ln" value="<?php echo $googleplaces_plugin_options['googleplaces_Plugin_Settings_ln']; ?>" size="20"><?php _e("" ); ?></td>
        </tr>

        <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_Settings_description">Description:<span>*</span>:</label>
                <td><textarea id="googleplaces_Plugin_Settings_description" name="googleplaces_Plugin_Settings_description" rows="7" cols="65"><?php echo $googleplaces_plugin_options['googleplaces_Plugin_Settings_description']; ?></textarea></td>
        </tr>
        
        <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_Settings_street_address">Street Address<span>*</span>:</label>
                <td><input type="text" id="googleplaces_Plugin_Settings_street_address" name="googleplaces_Plugin_Settings_street_address" value="<?php echo $googleplaces_plugin_options['googleplaces_Plugin_Settings_street_address']; ?>" size="70"><?php _e("" ); ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_Settings_city_town">City / Town<span>*</span>:</label>
                <td><input type="text" id="googleplaces_Plugin_Settings_city_town" name="googleplaces_Plugin_Settings_city_town" value="<?php echo $googleplaces_plugin_options['googleplaces_Plugin_Settings_city_town']; ?>" size="20"><?php _e("" ); ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_Settings_state">State<span>*</span>:</label>
                <td><input type="text" id="googleplaces_Plugin_Settings_state" name="googleplaces_Plugin_Settings_state" value="<?php echo $googleplaces_plugin_options['googleplaces_Plugin_Settings_state']; ?>" size="20"><?php _e("" ); ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_Settings_postal_code">Zip Code<span>*</span>:</label>
                <td><input type="text" id="googleplaces_Plugin_Settings_postal_code" name="googleplaces_Plugin_Settings_postal_code" value="<?php echo $googleplaces_plugin_options['googleplaces_Plugin_Settings_postal_code']; ?>" size="20"><?php _e("" ); ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_Settings_country">Country<span>*</span>:</label>
                <td><input type="text" id="googleplaces_Plugin_Settings_country" name="googleplaces_Plugin_Settings_country" value="<?php echo $googleplaces_plugin_options['googleplaces_Plugin_Settings_country']; ?>" size="20"><?php _e("" ); ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_Settings_phone">Phone<span>*</span>:</label>
                <td><input type="text" id="googleplaces_Plugin_Settings_phone" name="googleplaces_Plugin_Settings_phone" value="<?php echo $googleplaces_plugin_options['googleplaces_Plugin_Settings_phone']; ?>" size="20"><?php _e("" ); ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_filename">Filename KML<span>*</span>:</label>
                <td><input type="text" id="googleplaces_Plugin_filename" name="googleplaces_Plugin_filename" value="<?php
                if(isset($googleplaces_plugin_options['googleplaces_Plugin_filename'])){echo $googleplaces_plugin_options['googleplaces_Plugin_filename']; }else
                {echo "localsitemap"; }
                ?>" size="20"><?php _e(".kml" ); ?></td>
        </tr>

            <tr valign="top">
            <th scope="row">
                <label for="googleplaces_Plugin_filename_georss">Filename Georss<span>*</span>:</label>
                <td><input type="text" id="googleplaces_Plugin_filename_georss" name="googleplaces_Plugin_filename_georss" value="<?php
                if(isset($googleplaces_plugin_options['googleplaces_Plugin_filename_georss'])){echo $googleplaces_plugin_options['googleplaces_Plugin_filename_georss']; }else
                {echo "georss"; }
                ?>" size="20"><?php _e(".xml" ); ?></td>
        </tr>
    
    </table>
        <p class="submit">
        <input class="button-primary" type="submit" name="Submit" value="<?php _e('Update' ) ?>" />
        </p>
        <hr />

    </form>
</div>

