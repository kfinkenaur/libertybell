<style type="text/css">
<?php
if(isset($_51d['Javascript']) && $_51d['Javascript']!="False")
{
	?>
	
#menu-mobile-container li:hover > #menu-mobile{
	display:block;
}
<?php	
}
if(isset($_51d['SuggestedLinkSizePixels']))
{
?>

a{
	font-size:<?php echo $_51d['SuggestedLinkSizePixels']; ?>px;
}
<?php
}
?>
</style>
<?php get_header(); ?>
<div class="search-page">
 <form method="get" id="searchform" action="" >  
                Search: <input type="text" value="<?php the_search_query(); ?>" onfocus="if(this.value == this.defaultValue) this.value = ''" name="s" id="s" />  
            </form>
</div>
<?php if ( ! have_posts() ) : ?>  
        <div class="post">
        <h1>Not Found</h1>  
            <p>Apologies, but no results were found for '<strong><?php the_search_query(); ?></strong>'. Perhaps searching will help find a related post</p>  
</div>
  <?php else:?>  
        <h1>&nbsp;Results for '<?php the_search_query(); ?>'</h1>                  
<?php endif; ?>
<div class="loop clearfix">
<?php 
$count=1;
while ( have_posts() ) : the_post(); ?>
 		  
        <div class="post-loop <?php if($count%2==0) echo " even" ?> <?php if(!has_post_thumbnail()) echo " no-thumb" ?>">
        <a href="<?php the_permalink(); ?>" class="post-link">
        <?php if(has_post_thumbnail()){ ?>
                    <div class="post-thumb">
                    <?php the_post_thumbnail('medium'); ?>
                    </div>
                    <?php } ?>
        <div class="post-info">
        <div class="post-details-top">  
                        <span class="category"><?php 					
						$categories = get_the_category();
						$seperator = ' ';
						$output = '';
						if($categories){
							foreach($categories as $category) {
								$output .= $category->cat_name.$seperator;
							}
						echo trim($output, $seperator);
} 
						
						
						?></span> 
                    </div>  
                <h1><?php the_title(); ?></h1>
               
                <?php 
				$text=get_the_excerpt();
				$text=explode(" ",$text);
				$words=25;
				$excerpt="";
				for($i=0;$i<$words;$i++)
				{
					$excerpt.=$text[$i]." ";	
				}
				?>
                <p>
                <?php
				if(sizeof($text)>$words)
					$excerpt.="[...]";
				echo trim($excerpt);
				?>  
                </p>
  
                <?php //if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>  
                        <?php //the_excerpt(); ?>  
                <?php //else : ?>  
                        <?php //the_content('Read More'); ?>  
                <?php //endif; ?>
                
                <?php
				if($_51d['IsMobile']!="True") {
					//the_excerpt();
				  }
				
				 ?>  
                <div class="dots"></div>
           </div>
           </a>
            </div><!-- post-loop -->  

<?php
$count++;
 endwhile; ?>
</div>
<div class="clearfix">
<?php
if(get_next_posts_link()!=NULL)
{
?>
<div id="older-posts"><?php next_posts_link('Older Posts'); ?></div>
<?php
}
if(get_previous_posts_link()!=NULL)
{
?>
<div id="newer-posts"><?php previous_posts_link('Newer Posts'); ?></div> 
<?php
}
?>
</div> 
  
<?php get_sidebar(); ?>  