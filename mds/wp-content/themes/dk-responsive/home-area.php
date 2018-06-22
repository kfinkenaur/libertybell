<?php
/**
 * Home Featured Area Template
 *
 *
 * @file           home-featured-area.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */

$dk_options=dk_get_options();
if(!empty($dk_options['home_page_headline'])) {
 $home_page_headline = esc_html( $dk_options['home_page_headline'] );
}
if(!empty($dk_options['home_page_sub_headline'])) {
 $home_page_sub_headline = esc_html( $dk_options['home_page_sub_headline'] );
}
if(!empty($dk_options['home_page_content'])) {
 $home_page_content = $dk_options['home_page_content'];
}
?>
<div id="home-content" class="col-md-12">
	<div class="home-page-content">
		<?php
		 if(isset($home_page_headline)) {
			echo'<h1>'.$home_page_headline.'</h1>';
		 } else {
		 ?>
         <h1><?php _e('Page heading','dk-responsive'); ?></h1>
         <?php	   
		 }
		 if(isset($home_page_sub_headline)) {
			echo'<h5>'.$home_page_sub_headline.'</h5>';
		 } else {
		 ?>
         <h5><?php _e('Your subheadline here','dk-responsive'); ?></h5>
         <?php
		 }
		 if(isset($home_page_content)) {
			  $home_page_content =  wp_kses_post( $home_page_content );
			  // apply_filters( 'the_content', $home_page_content);
			//$home_page_content = do_shortcode( $home_page_content ); // CHANGED HERE
			//$home_page_content = apply_filters('the_content', $home_page_content);
			 echo'<div>'.$home_page_content.'</div>';
		 } else {
			 ?>
             <div><p><?php _e('All Content like title, subtitle, content is editable from Theme Options.','dk-responsive'); ?></p></div>
             <?php
			
		 }
		?>
	</div>
</div>

<div id="home-page-widget" class="home-widget-area ">  
    <div id="home-widget-1" class="col-md-4">	
		<div class="panel panel-default">
			<div class="widget-title">
				<?php
					if(!empty($dk_options['home_widget_title1'])) {
					echo '<h5>'.esc_html( $dk_options['home_widget_title1']).'</h5>';
					} else { ?>
                    <h5><?php _e('Home Callout 1','dk-responsive'); ?></h5>
				<?php	
				    }		 
				?>
			</div>
			<div  class="widget-image overflow-hidden">
				<?php
					if(!empty($dk_options['home_widget_image_1'])) {
						echo '<img class="img-responsive" src='.esc_url($dk_options['home_widget_image_1']).' alt="'.esc_attr($dk_options['home_widget_title1']).'" title="'.esc_attr($dk_options['home_widget_title1']).'">';
					} 
				?>
			</div>
			<div class="widget-description">
				<?php
				if(!empty($dk_options['home_widget_content1'])) {
					echo esc_html( $dk_options['home_widget_content1'] );
				} else {
					_e('Callout title, Callout text, Callout link is editable from Theme Options.Also you can add Callout image URL.','dk-responsive');
				}
				?>
			</div>
			<div class="read-more">
				<?php
					if(!empty($dk_options['home_widget_link1'])) {
						$link1= $dk_options['home_widget_link1'];
					} else {
						$link1="#";
					}
				?>
				<a href="<?php echo esc_url($link1); ?>"><?php _e('Read More','dk-responsive'); ?> &raquo;</a>
			</div>
		</div>			
	 </div>	 
	<div id="home-widget-2" class=" col-md-4">	  
		<div class="panel panel-default">
			<div class="widget-title">
				<?php
					 if(!empty($dk_options['home_widget_title2'])) {
						echo '<h5>'.esc_html( $dk_options['home_widget_title2'] ).'</h5>';
					} else { ?>
                    <h5><?php _e('Home Callout 2','dk-responsive'); ?></h5>
				<?php	
				    }		 
				?>
			</div>
			<div class="widget-image overflow-hidden">
				<?php
					if(!empty($dk_options['home_widget_image_2'])) {
						echo '<img class="img-responsive" src='.esc_url($dk_options['home_widget_image_2']).' alt="'.esc_attr($dk_options['home_widget_title2']).'" title="'.esc_attr($dk_options['home_widget_title2']).'">';
					 } 
				 ?>
			</div>
			<div class="widget-description">
				<?php
					 if(!empty($dk_options['home_widget_content2'])) {
						echo esc_html( $dk_options['home_widget_content2'] );
					 } else {
					_e('Callout title, Callout text, Callout link is editable from Theme Options.Also you can add Callout image URL.','dk-responsive');
					 }
				?>
			</div>
			<div class="read-more">
				<?php
					if(!empty($dk_options['home_widget_link2'])) {
						$link1= $dk_options['home_widget_link2'];
					} else {
						$link1="#";
					}
				?>
				<a href="<?php echo esc_url($link1); ?>"><?php _e('Read More','dk-responsive'); ?> &raquo;</a>
			</div>
		 </div>	
	</div>
	<div id="home-widget-3" class="homeWidget col-md-4">
		<div class="panel panel-default">
			<div class="widget-title">
				<?php
					if(!empty($dk_options['home_widget_title3'])) {
						echo '<h5>'.esc_html( $dk_options['home_widget_title3'] ).'</h5>';
					} else { ?>
                    <h5><?php _e('Home Callout 3','dk-responsive'); ?></h5>
				<?php	
				    }		 
				?>
			</div>
			<div  class="widget-image overflow-hidden">
				<?php
					if(!empty($dk_options['home_widget_image_3'])) {
						echo '<img class="img-responsive" src='.esc_url($dk_options['home_widget_image_3']).' alt="'.esc_attr($dk_options['home_widget_title3']).'" title="'.esc_attr($dk_options['home_widget_title3']).'">';
					} 
				?>
			</div>
			<div class="widget-description">
				<?php
					if(!empty($dk_options['home_widget_content3'])) {
						echo esc_html( $dk_options['home_widget_content3']);
					} else {
					_e('Callout title, Callout text, Callout link is editable from Theme Options.Also you can add Callout image URL.','dk-responsive');
					}
				?>
			</div>
			<div class="read-more">
				<?php
					if(!empty($dk_options['home_widget_link3'])) {
						$link1= $dk_options['home_widget_link3'];
					} else {
						$link1="#";
					}
				?>
				<a href="<?php echo esc_url($link1); ?>"><?php _e('Read More','dk-responsive'); ?> &raquo;</a>
			</div>
		</div>	
	</div>
</div>