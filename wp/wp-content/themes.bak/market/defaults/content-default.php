<?php
/**
 * @package Market
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class("archive col-md-4 col-sm-8 col-xs-12"); ?>>
	
	<div class="main-article sun-effect"> 
		<div class="feat-thumb-holder"> 
		    <img src="<?php echo get_template_directory_uri()."/defaults/images/dimg".mt_rand(1,7).".jpg"; ?>">
		</div>
	     <div class="main-content">  
<!-- 		     <h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>   -->
		     <p><?php echo substr(get_the_excerpt(),0,120)."..."; ?></p>  
		         <a href="<?php the_permalink(); ?>" class="info"><?php _e('Read More','market'); ?></a>  
	     </div>  
	</div> 
	<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>  

</article><!-- #post-## -->