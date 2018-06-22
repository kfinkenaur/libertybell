<form method="post" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
       
        <input class="ainput-text" name="s" id="s" value="<?php __('Enter Search Blog...','guardian'); ?>"  onFocus="if (this.value == '<?php _e('Enter Search Blog...','guardian');?>') {this.value = '';}" onBlur="if (this.value == '') {this.value = '<?php _e('Enter Search Blog...','guardian');?>';}" type="text" />
        <input id="searchsubmit" value="<?php __('Search','guardian'); ?>" type="submit" />
       
</form>