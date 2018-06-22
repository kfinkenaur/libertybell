<?php if (get_post_meta($wpl_id,'_wpl_name',true)):?>
<div class="wpl_location mini" itemscope itemtype="http://schema.org/<?php print (get_post_meta($wpl_id,'_wpl_business',true) && $this->settings->enable_type_of_business) ? get_post_meta($wpl_id,'_wpl_business',true) : $this->settings->default_business; ?>">
    
    <div class="wpl_head">   
        <?php if (get_post_meta($wpl_id,'_wpl_name',true)): ?>
            <h4 class="wpl_name" itemprop="name" ><a href="<?php print get_permalink($wpl_id); ?>"><?php print get_post_meta($wpl_id, '_wpl_name', true); ?></a></h4>
        <?php endif; ?>    
    </div>
    <div class="wpl_info">           

        <?php if (get_post_meta($wpl_id,'_wpl_streetAddress',true) || get_post_meta($wpl_id,'_wpl_postalCode',true) || get_post_meta($wpl_id,'_wpl_addressLocality',true) ): ?>
        <p class="wpl_address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <?php if (get_post_meta($wpl_id,'_wpl_streetAddress',true)): ?><span class="wpl_streetAddress" itemprop="streetAddress"><?php print get_post_meta($wpl_id,'_wpl_streetAddress',true) ?></span><br/><?php endif; ?>
            <?php if (get_post_meta($wpl_id,'_wpl_postalCode',true)): ?><span class="wpl_postalCode" itemprop="postalCode"><?php print get_post_meta($wpl_id,'_wpl_postalCode',true) ?></span><?php endif; if (get_post_meta($wpl_id,'_wpl_addressLocality',true)): ?> <span  class="wpl_addressLocality" itemprop="addressLocality"><?php print get_post_meta($wpl_id,'_wpl_addressLocality',true) ?></span><?php endif; ?>
        </p>  
        <?php endif; ?>  
    </div>   
</div>
<?php endif; ?>