<?php
if ( is_active_sidebar("banner") ) {
?>
	<aside id="banner">  
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("banner") ) : ?>  
        <?php endif; ?>  
            
</aside><!-- sidebar --> 
<?php
}
?> 
