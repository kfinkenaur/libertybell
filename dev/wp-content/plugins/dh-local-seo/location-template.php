<?php if (get_post_meta($wpl_id,'_wpl_name',true) || $this->settings->adv_config):?>
<div class="wpl_location" itemscope itemtype="http://schema.org/<?php print (get_post_meta($wpl_id,'_wpl_business',true) && $this->settings->enable_type_of_business) ? get_post_meta($wpl_id,'_wpl_business',true) : $this->settings->default_business; ?>">
    
   
    <?php if (get_post_meta($wpl_id,'_wpl_name',true) && ( (!is_single() && !is_archive()) || get_post_meta($wpl_id,'_wpl_name',true) != get_the_title($wpl_id)) || $post->post_type != 'location'): ?>
    <div class="wpl_head">
        <h3 class="wpl_name" itemprop="name" ><?php if ($this->settings->adv_config): ?><a href="<?php print get_permalink($wpl_id); ?>"><?php endif; ?><?php print get_post_meta($wpl_id, '_wpl_name', true); ?><?php if ($this->settings->adv_config): ?><?php endif; ?></a></h3>
    </div>  
    <?php endif; ?>  
    <?php if ($wpl_excerpt):?>
    <div class="wpl_excerpt">
        <p><?php print $wpl_excerpt; ?></p>
    </div>   
    <?php endif; ?>
         
    <div class="wpl_info">           
        <?php if (get_post_meta($wpl_id,'_wpl_logo',true)): ?>
        <p class="wpl_logo" itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
            <img src="<?php print get_post_meta($wpl_id,'_wpl_logo',true) ?>" />
            <meta itemprop="contentURL" content="<?php print get_post_meta($wpl_id,'_wpl_logo',true) ?>" />
        </p>
        <?php endif; ?>

        <?php if (get_post_meta($wpl_id,'_wpl_streetAddress',true) || get_post_meta($wpl_id,'_wpl_postalCode',true) || get_post_meta($wpl_id,'_wpl_addressLocality',true) ): ?>
        <p class="wpl_address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <?php if (get_post_meta($wpl_id,'_wpl_streetAddress',true)): ?><span class="wpl_streetAddress" itemprop="streetAddress"><?php print get_post_meta($wpl_id,'_wpl_streetAddress',true) ?></span><br/><?php endif; ?>
            <?php if (get_post_meta($wpl_id,'_wpl_postalCode',true)): ?><span class="wpl_postalCode" itemprop="postalCode"><?php print get_post_meta($wpl_id,'_wpl_postalCode',true) ?></span><?php endif; if (get_post_meta($wpl_id,'_wpl_addressLocality',true)): ?> <span  class="wpl_addressLocality" itemprop="addressLocality"><?php print get_post_meta($wpl_id,'_wpl_addressLocality',true) ?></span><?php endif; ?>
        </p>  
        <?php endif; ?>
                                
        <?php if (get_post_meta($wpl_id,'_wpl_telephone',true) && $this->settings->enable_telephone):?>
            <h3><?php _e('Phone', 'wp_localseo');?></h3>
            <?php $this->dynamicInput(get_post_meta($wpl_id,'_wpl_telephone',true), 'telephone'); ?>
        <?php endif; ?>
        
        <?php if (get_post_meta($wpl_id,'_wpl_faxNumber',true) && $this->settings->enable_faxNumber):?>
            <h3><?php _e('Fax', 'wp_localseo');?></h3>
            <?php $this->dynamicInput(get_post_meta($wpl_id,'_wpl_faxNumber',true), 'faxNumber'); ?>        
        <?php endif; ?>  
        
        <?php if (get_post_meta($wpl_id,'_wpl_email',true) && $this->settings->enable_email):?>
            <h3><?php _e('Email address', 'wp_localseo');?></h3>
            <?php $this->dynamicInput(get_post_meta($wpl_id,'_wpl_email',true), 'email'); ?>        
        <?php endif; ?>  
        
        <?php if (get_post_meta($wpl_id,'_wpl_url',true) && $this->settings->enable_url):?>
            <h3><?php _e('Website', 'wp_localseo');?></h3>
            <?php $this->dynamicInput(get_post_meta($wpl_id,'_wpl_url',true), 'url'); ?>
        <?php endif; ?>
        
        <?php if (get_post_meta($wpl_id,'_wpl_description',true) && $this->settings->enable_description):?>
            <h3><?php _e('Description', 'wp_localseo');?></h3>
            <p class="wpl_description" itemprop="description"><?php echo nl2br(get_post_meta($wpl_id,'_wpl_description',true));?></p>        
        <?php endif; ?>
        
        <?php if (get_post_meta($wpl_id,'_wpl_openingHours',true) && $this->settings->enable_openingHours):?>
            <h3><?php _e('Opening hours', 'wp_localseo');?></h3>
            <?php print $this->openingHours(get_post_meta($wpl_id,'_wpl_openingHours',true)); ?>
        <?php endif; ?>  
        <?php if ($this->settings->adv_config) : ?><?php print get_the_term_list( $wpl_id, 'location_category', '<ul class="location-category-list"><li>', '</li><li>', '</li></ul>' ); ?><?php endif; ?>  
    </div>   
    <div class="wpl_media">
        <?php if (get_post_meta($wpl_id,'_wpl_latitude',true) && get_post_meta($wpl_id,'_wpl_longitude',true)): ?>
        <div class="wpl_geo" itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
            <div id="map-canvas_<?php print $wpl_id; ?>" style class="wpl_map"></div>
            <a href="https://maps.google.com/maps?f=d&dirflg=d&daddr=<?php print str_replace(' ','+', get_post_meta($wpl_id,'_wpl_streetAddress',true).', '.get_post_meta($wpl_id,'_wpl_postalCode',true).' '.get_post_meta($wpl_id,'_wpl_addressLocality',true));  ?>" target="_blank"><?php _e('» get directions on Google Maps', 'wp_localseo'); ?></a>
            <meta itemprop="latitude" content="<?php print get_post_meta($wpl_id,'_wpl_latitude',true) ?>" />
            <meta itemprop="longitude" content="<?php print get_post_meta($wpl_id,'_wpl_longitude',true) ?>" />
            <script>
                jQuery(document).ready(function(){
                    initMap('map-canvas_<?php print $wpl_id; ?>', <?php print get_post_meta($wpl_id,'_wpl_latitude',true) ?>,<?php print get_post_meta($wpl_id,'_wpl_longitude',true) ?>);
                });
            </script>            
        </div>    
        <?php endif; ?>
    </div>
    <div style="clear: both; "></div>
</div>
<?php endif; ?>