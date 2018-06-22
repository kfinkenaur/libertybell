<?php global $wdwt_front; ?>
<div id="footer">
    <div>
        <?php 
            if ( is_active_sidebar( 'footer-widget-area' ) ) { ?>
                <div class="footer-sidbar">
                    <div id="sidebar-footer" class="container clear-div">
                      <?php  dynamic_sidebar( 'footer-widget-area' );   ?>
                    </div>  
                </div>      
        <?php } ?>
        <div id="footer-bottom">
            <span id="copyright"><?php echo $wdwt_front->footer_text(); ?></span>
        </div>
    </div>
<?php wp_footer(); ?>
</body>
</html>