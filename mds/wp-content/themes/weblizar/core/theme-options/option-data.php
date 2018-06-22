<?php $wl_theme_options = weblizar_get_options();
	/*
	* Home slider settings save
	*/
	if(isset($_POST['weblizar_settings_save_general']))
	{	
		if($_POST['weblizar_settings_save_general'] == 1) 
		{
				foreach($_POST as  $key => $value)
				{
					$wl_theme_options[$key]=sanitize_text_field($_POST[$key]);	
				}				
				
				if($_POST['text_title']){
				echo $wl_theme_options['text_title']=sanitize_text_field($_POST['text_title']); } 
				else
				{ echo $wl_theme_options['text_title']="off"; }
				if($_POST['_frontpage']){
				echo $wl_theme_options['_frontpage']=sanitize_text_field($_POST['_frontpage']); } 
				else
				{ echo $wl_theme_options['_frontpage']="off"; }
					
				update_option('weblizar_options', stripslashes_deep($wl_theme_options));
		}	
		if($_POST['weblizar_settings_save_general'] == 2) 
		{
			$wl_theme_options['upload_image_logo']="";
	$wl_theme_options['_frontpage']="on";	
	$wl_theme_options['height']=55;
	$wl_theme_options['width']=150;
	$wl_theme_options['upload_image_favicon']="";
	$wl_theme_options['text_title']="on";
	$wl_theme_options['custom_css']="";		
	update_option('weblizar_options',$wl_theme_options);
		}
	}
	/*
	* Home slider settings save
	*/
	if(isset($_POST['weblizar_settings_save_home-image']))
	{	
		if($_POST['weblizar_settings_save_home-image'] == 1) {
			foreach($_POST as  $key => $value)
			{
				$wl_theme_options[$key]=sanitize_text_field($_POST[$key]);	
			}
			
			update_option('weblizar_options', stripslashes_deep( $wl_theme_options ));
			
		}	
		if($_POST['weblizar_settings_save_home-image'] == 2) 
		{	
			$ImageUrl1 = WL_TEMPLATE_DIR_URI ."/images/slide-1.jpg";
	$ImageUrl2 = WL_TEMPLATE_DIR_URI ."/images/slide-2.jpg";
	$ImageUrl3 = WL_TEMPLATE_DIR_URI ."/images/slide-3.jpg";
	$wl_theme_options['slide_image'] = $ImageUrl1;
	$wl_theme_options['slide_title'] = "Neque porro  ";
	$wl_theme_options['slide_desc'] = "Valdoh aohu Vidlegue";
	$wl_theme_options['slide_btn_text'] = "Read More";
	$wl_theme_options['slide_btn_link'] = "#";
	$wl_theme_options['slide_image_1'] = $ImageUrl2;
	$wl_theme_options['slide_title_1'] = "Neque porro tle";
	$wl_theme_options['slide_desc_1'] = "Sl sgiden mre tion";
	$wl_theme_options['slide_btn_text_1'] = "Read More";
	$wl_theme_options['slide_btn_link_1'] = "#";
	$wl_theme_options['slide_image_2'] = $ImageUrl3;
	$wl_theme_options['slide_title_2'] = "echo establecido hace demasia.";
	$wl_theme_options['slide_desc_2'] = "Sl sgiden mre tiones simplemente el texto de relleno de las imprentas y archivos de texto.";
	$wl_theme_options['slide_btn_text_2'] = "Read More";
	$wl_theme_options['slide_btn_link_2'] = "#";
	
	update_option('weblizar_options', $wl_theme_options);
		}
	}
	/*
	* Home Blog and site intro settings save
	*/
	
	if(isset($_POST['weblizar_settings_save_site-info']))
	{	
		if($_POST['weblizar_settings_save_site-info'] == 1) 
		{
			foreach($_POST as  $key => $value)
			{
				$wl_theme_options[$key]=sanitize_text_field($_POST[$key]);	
			}
			
			update_option('weblizar_options', stripslashes_deep($wl_theme_options));
			
		}	
		if($_POST['weblizar_settings_save_site-info'] == 2) 
		{
			$wl_theme_options['site_intro_title']="We are weblizar";
	$wl_theme_options['site_intro_text']="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text.";		
	
	$wl_theme_options['blog_title']="Latest Blog";
	$wl_theme_options['blog_text']="Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
	$wl_theme_options['blog_count']= 3;

	update_option('weblizar_options', $wl_theme_options);
		}
	}
	/*
	* Home service setting 
	*/
	if(isset($_POST['weblizar_settings_save_home-service']))
	{	
		if($_POST['weblizar_settings_save_home-service'] == 1) 
		{	
			foreach($_POST as  $key => $value)
			{
				$wl_theme_options[$key]=$_POST[$key];	
			}
			if($_POST['service_enable']){
			echo $wl_theme_options['service_enable']=sanitize_text_field($_POST['service_enable']); }
			else
				{ echo $wl_theme_options['service_enable']="off"; }
			update_option('weblizar_options', stripslashes_deep($wl_theme_options));
			
		}	
		if($_POST['weblizar_settings_save_home-service'] == 2) 
		{	
			$wl_theme_options['service_1_title']="Idea";
	$wl_theme_options['service_1_icons']="fa fa-pagelines";
	$wl_theme_options['service_1_text']="There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in";
	$wl_theme_options['service_1_link']="";
	
	$wl_theme_options['service_2_title']="Design";
	$wl_theme_options['service_2_icons']="fa fa-eye";
	$wl_theme_options['service_2_text']="There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in";
	$wl_theme_options['service_2_link']="#";
	
	$wl_theme_options['service_3_title']="Management";
	$wl_theme_options['service_3_icons']="fa fa-users";
	$wl_theme_options['service_3_text']="There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in";
	$wl_theme_options['service_3_link']="#";
	
	$wl_theme_options['service_4_title']="Development";
	$wl_theme_options['service_4_icons']="fa fa-code";
	$wl_theme_options['service_4_text']="There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in.";
	$wl_theme_options['service_4_link']="#";
	
	update_option('weblizar_options',$wl_theme_options);
		}
	}
	/*
	* social media link Settings
	*/
	if(isset($_POST['weblizar_settings_save_social']))
	{	
		if($_POST['weblizar_settings_save_social'] == 1) 
		{
			
			foreach($_POST as  $key => $value)
			{
				$wl_theme_options[$key]=sanitize_text_field($_POST[$key]);	
			}
			
			// Social Icons footer section yes or on
			if(isset($_POST['footer_section_social_media_enbled']))
			{  $wl_theme_options['footer_section_social_media_enbled'] = $_POST['footer_section_social_media_enbled'];
			} else {  	echo $wl_theme_options['footer_section_social_media_enbled'] = "off";	} 
			
			update_option('weblizar_options', stripslashes_deep($wl_theme_options));
			
		}	
		if($_POST['weblizar_settings_save_social'] == 2) 
		{
			$wl_theme_options['footer_section_social_media_enbled']="on";	
	$wl_theme_options['social_media_twitter_link']="https://twitter.com/";
	$wl_theme_options['social_media_facebook_link']="https://facebook.com/";
	$wl_theme_options['social_media_linkedin_link']="https://linkedin.com/";
	$wl_theme_options['social_media_google_plus']="https://plus.google.com/";			
	
	update_option('weblizar_options', $wl_theme_options);
		}
	}
	/*
	* footer customization Settings
	*/
	if(isset($_POST['weblizar_settings_save_footer']))
	{	
		if($_POST['weblizar_settings_save_footer'] == 1) 
		{
			foreach($_POST as  $key => $value)
			{
				$wl_theme_options[$key]=sanitize_text_field($_POST[$key]);	
			}
			
			update_option('weblizar_options', stripslashes_deep($wl_theme_options));
		}	
		if($_POST['weblizar_settings_save_footer'] == 2) 
		{
			$wl_theme_options['footer_customizations']="@ 2014 Weblizar Theme";
	$wl_theme_options['developed_by_text']="Theme Developed By";
	$wl_theme_options['developed_by_weblizar_text']="Weblizar";
	$wl_theme_options['developed_by_link']="http://weblizar.com/";
	update_option('weblizar_options',$wl_theme_options);
		}
	}	
?>