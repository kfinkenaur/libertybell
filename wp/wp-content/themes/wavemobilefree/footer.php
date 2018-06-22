<div class="spacer"></div>
        <footer id="footer">  
                Copyright © 2012 Wave Mobile by <a href="http://www.wave-digital.co.uk">Wave Mobile</a>
                <?php
				global $_51d;
				if(isset($_51d['IsMobile']) && $_51d['IsMobile']=="True")
				{
				?>
                    <p>
                    <a href="<?php echo get_template_directory_uri(); ?>/desktop-version.php?current=<?php echo $_SERVER['REQUEST_URI']; ?>" class="desktop-version">Switch to Desktop Version</a>
                    </p>
                <?php 
				} 
				?>
        </footer>  
    </div><!-- wrapper -->
    <?php get_sidebar("banner"); ?>
    <?php wp_footer(); ?>
    </body>  
</html>  