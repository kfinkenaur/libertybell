<aside id="sidebar" class="clearfix">  

            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("primary") ) : ?> 
            
        <?php endif; ?>  
            
</aside><!-- sidebar -->  
<?php get_footer(); ?>