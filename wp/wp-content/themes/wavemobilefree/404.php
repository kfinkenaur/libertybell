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
        <div class="post">
        <h1>Not Found</h1>  
            <p>Apologies, but we can't find any page for your request. Perhaps searching will help find a related post.</p>  
</div>  
<?php get_sidebar(); ?>  