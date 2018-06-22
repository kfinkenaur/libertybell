<?php get_header(); ?>  
  
<?php /* If there are no posts to display, such as an empty archive page */ ?>  
<?php if ( ! have_posts() ) : ?>  
        <div class="post">
        <h1>Not Found</h1>  
            <p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post</p>  
</div> 
<?php endif; ?>  
  
<?php while ( have_posts() ) : the_post(); ?>  
  
<div class="post">  
    <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>  
    <div class="post-details">  
        <div class="single-details-left">  
        <strong><?php the_date(); ?></strong> by <span class="author"><?php the_author(); ?></span> | <span class="author"><?php the_category(', '); ?></span>  
        </div>  
        <div class="single-details-right">
        <?php edit_post_link('Edit', ' <span class="comment-count">  ' , '</span>'); ?> 
        </div>  
    </div>  
  
    <?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>  
            <?php the_excerpt(); ?>  
    <?php else : ?>  
            <?php the_content('Read More'); ?>  
    <?php endif; ?>  
  
    <div class="dots"></div>  
</div><!-- post -->
<div class="clearfix">
    <div class="older-posts">
    <?php previous_post_link("%link", "Prev"); ?>
    </div>
    <div class="newer-posts">
    <?php next_post_link("%link", "Next"); ?> 
    </div>
</div>
<div class="comments">
<?php comments_template( '', true ); ?> 
</div> 
<?php endwhile; ?>
  
<div class="spacer"></div>  
<?php get_sidebar(); ?>