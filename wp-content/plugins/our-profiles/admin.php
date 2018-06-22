<?php
function ourprofiles_admin_menu() {
    $plugin_hook_name = add_menu_page( __('Profile Pages'), __('Profile Pages'), 'manage_options', 'our-profiles-config', 'ourprofiles_config_page',plugins_url() . '/our-profiles/images/favicon.png' );
    add_action( 'admin_head-' . $plugin_hook_name, 'ourprofiles_admin_head' );
}
add_action( 'admin_menu', 'ourprofiles_admin_menu' );


function ourprofiles_config_page(){
	include('thisplugin.php');
    global $ourprofiles_links, $ourprofiles_services, $ourprofiles_options;
    $saved_ok = false;

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core',false,array('jquery'));
    wp_enqueue_script('jquery-ui-sortable',false,array('jquery','jquery-ui-core'));

    $images_size = isset($ourprofiles_options['images_folder']) ? $ourprofiles_options['images_folder'] : '100x50';

    if ( isset( $_POST['submit'] ) ) {
        if ( function_exists('current_user_can') && !current_user_can('manage_options') )
            die(__('Cheatin&#8217; uh?'));

        check_admin_referer( 'our-profiles-config' );

        if (isset($_POST['ourprofiles_links'])){
            $ourprofiles_links = $_POST['ourprofiles_links'];
            $saved_ok = update_option('ourprofiles_links', $ourprofiles_links);
        }

        if ( isset($_POST['ourprofiles_size']) && in_array($_POST['ourprofiles_size'], array('100x50', '150x75')) ) {
            $ourprofiles_options['images_folder'] = $_POST['ourprofiles_size'];
            update_option('ourprofiles_options', $ourprofiles_options);
            $images_size = $ourprofiles_options['images_folder'];
        }
    }
?>

<div class="wrap">
<br />
<div id="dashboard-widgets-wrap">
<div id='dashboard-widgets' class='metabox-holder'>

<div class='postbox-container' style='width:60%;'>
<div id='normal-sortables' class='meta-box-sortables'>

<div id="main-admin-box" class="postbox">
    <h3><span><img src="<?php echo plugins_url().$thisplugin; ?>/images/favicon.png" alt="SEO Automatic" /> Profile Pages</span></h3>
	<div class="inside">
    <?php if ( !empty($_POST['submit'] ) && $saved_ok ) : ?>
        <div id="message" class="updated fade"><p><strong><?php _e('Settings saved.') ?></strong></p></div>
    <?php endif; ?>
	<div align="center"><b>3 Minute Video</b><br /><iframe width="350" height="197" src="https://www.youtube.com/embed/E1bupoV_RXI?rel=0" frameborder="0" allowfullscreen></iframe></div>
    <p style="font-size: 1.1em;">When filling in the URLs, view your profile, and look for "leave a review". Some services will let you link directly to that function, making it easier for your users. Otherwise, just link to your profile page, and select the size of the icon that you wish to use.</p>
	<p style="font-size: 1.1em;">To make these logos and link display on any page or post, use the shortcode [ourprofiles].</p>
	<p style="font-size: 1.1em;">You can sort the order of your profiles by left clicking on the profile name below, then dragging it to the desired location and letting go. This will sort both the order of profiles on both the page and in the widget.</p>
	
    <form action="" method="post" id="our-profiles-config">
        <?php wp_nonce_field( 'our-profiles-config' ); ?>
        <div>
            <ul id="our-profiles-list">
                <?php foreach ($ourprofiles_links as $service => $link) : ?>
                    <?php
                    $domain = '#';
                    if (isset($ourprofiles_services[$service])){
                        $domain = $ourprofiles_services[$service]['domain'];
                    }
                    ?>
                    <li>
                        <div class="our-profiles-labels">
                            <a href="<?php echo $domain; ?>" target="_blank"><?php echo $service; ?></a>
                        </div>
                        <div class="our-profiles-links">
                            <input name="ourprofiles_links[<?php echo $service; ?>]" type="text" value="<?php echo $link; ?>">
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div id="our-profiles-options">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th><label for="size"><?php _e('Images Size');?></label></th>
                            <td>
                                <select name="ourprofiles_size" id="our-profiles-size">
                                    <option value="100x50"<?php selected( $images_size, '100x50' ); ?>>100x50</option>
                                    <option value="150x75"<?php selected( $images_size, '150x75' ); ?>>150x75</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="clear"></div>
        </div>
        <p class="submit" id="profile-button">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes');?>">
        </p>
    </form>

</div></div>

</div></div>

<?php include('seoauto-sidebar.php'); ?>

<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div></div><!-- wrap -->

<?php
}

function ourprofiles_admin_head(){
?>
    <script>
        jQuery(function() {
            jQuery( "#our-profiles-list" ).sortable({
                cursor: "move",
                placeholder: "our-profiles-list-highlight",
                containment: "parent"
            });
        });
    </script>
    <style>
        #our-profiles-list{
            width: 530px;
            float: left;
            margin: 15px 0 0;
        }
        #our-profiles-list li{
            background-color: #fcfcfc;
            padding: 0 15px;
            clear: both;
            height: 30px;
            border-radius: 5px;
        }
        #our-profiles-list li div{
            line-height: 30px;
            height: 30px;
            float: left;
        }
        .our-profiles-labels{
            width: 200px;;
        }
        .our-profiles-links{
            width: 300px;
        }
        .our-profiles-links input{
            width: 300px;
        }
        #our-profiles-list li.our-profiles-list-highlight{
            background-color: rgb(255, 253, 219);
        }
        #our-profiles-options{
            clear: both;
            margin: 15px 0 0 6px;
        }
        #our-profiles-options table{
            margin-top: 0;
        }
        #our-profiles-options th{
            width: 100px;
            padding: 5px 10px;
        }
        #our-profiles-options td{
            padding: 1px 10px;
        }
		#profile-button #submit{
			margin-left: 15px;
		}
    </style>
<?php
}
?>