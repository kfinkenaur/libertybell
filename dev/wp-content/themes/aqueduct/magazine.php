<?php
/**
 * @package HowlThemes
 */
?>

<div class="container featpostholder">
<?php
  $featpost = new WP_Query( '&posts_per_page=5' );
$newnum = 1;
while($featpost->have_posts()) : $featpost->the_post();
?>
<article class="featured-post" id="featpost<?php echo $newnum?>" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
<div class="thumbnail-container" itemprop="image">

<?php 
 
if($newnum != 1){
  if ( get_the_post_thumbnail() != '' ) {
    echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
  $source_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 250 && $imginfo[1] >= 200){
  $resizedImage = aq_resize($source_image_url, 250, 200, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
    echo '</a>';
}
    elseif(howlthemes_catch_that_image()){
   $source_image_url = howlthemes_catch_that_image();
   $imginfo = getimagesize($source_image_url);
    if($imginfo[0] >= 250 && $imginfo[1] >= 200){
   $resizedImage = aq_resize($source_image_url, 250, 200, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
   echo '</a>';
    } 
    else{
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
    echo '<img src="';
    echo esc_url( get_template_directory_uri() );
    echo '/img/featuredimgsmall.jpg" alt="';the_title();
    echo '" />';
    echo '</a>';
}
  }
  else{
 if ( get_the_post_thumbnail() != '' ) {
    echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
  $source_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 586 && $imginfo[1] >= 420){
  $resizedImage = aq_resize($source_image_url, 586, 420, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
    echo '</a>';
}
 elseif(howlthemes_catch_that_image()){
   $source_image_url = howlthemes_catch_that_image();
   $imginfo = getimagesize($source_image_url);
     if($imginfo[0] >= 586 && $imginfo[1] >= 420){
   $resizedImage = aq_resize($source_image_url, 586, 420, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
   echo '</a>';
    } 
    else{
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
    echo '<img src="';
    echo esc_url( get_template_directory_uri() );
    echo '/img/featuredimg.jpg" alt="';the_title();
    echo '" />';
    echo '</a>';
}
  }
?>
</div>
<div class="featured-content">
<?php if($newnum != 1){ ?>
<?php } ?>
<header class="entry-header">
<h2 itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2></header>
<?php if($newnum == 1){ ?>
<p class="entry-meta">
<span class="entry-author"><i class="fa fa-user"></i> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><span ><?php echo get_the_author() ?></span></a></span>

<span class="time-drag"><i class="fa fa-calendar-o"></i><span class="dtime"><?php the_time('F j, Y'); ?></span></span>
<span class="comment-count"><i class="fa fa-comments"></i> <a href="<?php the_permalink() ?>/#comment"><?php echo get_comments_number(); ?></a></span>
</p>
<?php } ?>
</div>
</article>
<?php 
$newnum++;
endwhile; ?>
</div>


<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">



  


<?php 

if(get_theme_mod("homebuilder") && get_theme_mod("category_remember")){
        $totalslide =  explode(', ', get_theme_mod("homebuilder"));
        $slidecount = count($totalslide) -1;
        $totalcat = explode(', ', get_theme_mod("category_remember"));


for($i=0;$i<=$slidecount;$i++){
  $catboxnum = str_replace(',', '', $totalslide[$i]);
  $catid = str_replace(',', '', $totalcat[$i]);


if($catboxnum == 1 && $catid != 'none' && $catid !=''){?>

<!--Slider--> 
<div id="cat-slider"><div class="slider-title"><a href='<?php echo get_site_url(); ?>/category/<?php echo str_replace(" ", "-", get_category($catid)->name) ?>'><?php echo get_category($catid)->name ?></a></div><ul class="bjqs">
<?php $featpost = new WP_Query( 'cat='.$catid.'&posts_per_page=5' );  while($featpost->have_posts()) : $featpost->the_post(); ?>    
<li> 

<div class="slider-img-con" itemprop="image">
  <?php if ( get_the_post_thumbnail() != '' ) { 
  echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
  $source_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 740 && $imginfo[1] >= 400){
  $resizedImage = aq_resize($source_image_url, 740, 400, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
    echo '</a>';
    } 
    elseif(howlthemes_catch_that_image()){
   $source_image_url = howlthemes_catch_that_image();
   $imginfo = getimagesize($source_image_url);
   if($imginfo[0] >= 740 && $imginfo[1] >= 400){
   $resizedImage = aq_resize($source_image_url, 740, 400, true);
   }
   else{
   $resizedImage = $source_image_url;
   }
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
   echo '</a>';
    } 
    else{
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
    echo '<img src="';
    echo esc_url( get_template_directory_uri() );
    echo '/img/slider-thumbnail.jpg" alt="';the_title();
    echo '" />';
    echo '</a>';
}
  ?>
</div><h2 class="bjqs-caption" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
</li> 
<?php endwhile; ?>
</ul></div>

<?php  } if($catboxnum == 2 && $catid != 'none' && $catid !=''){?>

<!--Carousel-->
<div id="carouselpost">
<div class="titlecatholder"><span><a href='<?php echo get_site_url(); ?>/category/<?php echo str_replace(" ", "-", get_category($catid)->name) ?>'><?php echo get_category($catid)->name ?></a></span>
<div class="navigator-holder">
<a class="buttons prev" href="#"><i class="fa fa-angle-left"></i></a>
<a class="buttons next" href="#"><i class="fa fa-angle-right"></i></a></div>
</div>
    <div class="viewport">
      <ul class="overview">

<?php $featpost = new WP_Query( 'cat='.$catid.'&posts_per_page=5' );  while($featpost->have_posts()) : $featpost->the_post(); ?>    
<li>  
<div class="imgcarholder" itemprop="image">
 <?php if ( get_the_post_thumbnail() != '' ) { 
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
  $source_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 300 && $imginfo[1] >= 180){
  $resizedImage = aq_resize($source_image_url, 300, 180, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
    echo '</a>';
    } 
   elseif(howlthemes_catch_that_image()){
   $source_image_url = howlthemes_catch_that_image();
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 300 && $imginfo[1] >= 180){
  $resizedImage = aq_resize($source_image_url, 300, 180, true);
  }
  else{
  $resizedImage = $source_image_url;
  }   
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
   echo '</a>';
    } 
    else{
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
    echo '<img src="';
    echo esc_url( get_template_directory_uri() );
    echo '/img/carousel-thumbnail.jpg" alt="';the_title();
    echo '" />';
    echo '</a>';
}
  ?>
</div>
<p class="meta-holder">
<span class="time-drag"><i class="fa fa-calendar-o"></i><span class="dtime"><?php the_time('F j, Y'); ?></span></span>
<span class="comment-count"><i class="fa fa-comments"></i> <a href="<?php the_permalink() ?>/#comment"><?php echo get_comments_number(); ?></a></span>
</p>
<h2 itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
</li>
<?php endwhile; ?>

      </ul>
    </div>
    
  </div>
<?php  } if($catboxnum == 3 && $catid != 'none' && $catid !=''){?>

<!--Grid Posts-->
<div class="grid-posts-holder">
<div class="titlecatholder"><span><a href='<?php echo get_site_url(); ?>/category/<?php echo str_replace(" ", "-", get_category($catid)->name) ?>'><?php echo get_category($catid)->name ?></a></span></div>
<?php $featpost = new WP_Query( 'cat='.$catid.'&posts_per_page=5' ); $rnewnum = 1;  while($featpost->have_posts()) : $featpost->the_post(); ?>    
<?php if($rnewnum == 1 or $rnewnum == 4){ ?>
<div class="grid-posts-big" itemprop="image">
 <?php 
 if ( get_the_post_thumbnail() != '' ) { 
    echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
  $source_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 477 && $imginfo[1] >= 247){
  $resizedImage = aq_resize($source_image_url, 477, 247, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
    echo '</a>';
    } 
    elseif(howlthemes_catch_that_image()){
   $source_image_url = howlthemes_catch_that_image();
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 477 && $imginfo[1] >= 247){
  $resizedImage = aq_resize($source_image_url, 477, 247, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
   echo '</a>';
    } 
    else{
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
    echo '<img src="';
    echo esc_url( get_template_directory_uri() );
    echo '/img/giridpostbig.jpg" alt="';the_title();
    echo '" />';
    echo '</a>';
}
  ?>
<div class="post-content-holder">
<div class="post-meta-holder">
<span class="time-drag"><i class="fa fa-calendar-o"></i><span class="dtime"><?php the_time('F j, Y'); ?></span></span>
<span class="comment-count"><i class="fa fa-comments"></i> <a href="<?php the_permalink() ?>/#comment"><?php echo get_comments_number(); ?></a></span>
</div>
<h2 itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
</div>
</div>
<?php } else{?>

<div class="grid-posts-small" itemprop="image">  
 <?php if ( get_the_post_thumbnail() != '' ) { 
  echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
  $source_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 250 && $imginfo[1] >= 160){
  $resizedImage = aq_resize($source_image_url, 250, 160, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
    echo '</a>';
    } 
    elseif(howlthemes_catch_that_image()){
   $source_image_url = howlthemes_catch_that_image();
  $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 250 && $imginfo[1] >= 160){
   $resizedImage = aq_resize($source_image_url, 250, 160, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
   echo '</a>';
    } 
    else{
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
    echo '<img src="';
    echo esc_url( get_template_directory_uri() );
    echo '/img/gridpostsmall.jpg" alt="';the_title();
    echo '" />';
    echo '</a>';
}
  ?>
<h2 itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
</div>
<?php  } ?>
<?php $rnewnum++; endwhile; ?>
</div>
<?php } if($catboxnum == 4 && $catid != 'none' && $catid !=''){?>

<!--Blog Posts-->
<div class="blog-cnt-holder">
  <div class="titlecatholder"><span><a href='<?php echo get_site_url(); ?>/category/<?php echo str_replace(" ", "-", get_category($catid)->name) ?>'><?php echo get_category($catid)->name ?></a></span></div>
<?php $featpost = new WP_Query( 'cat='.$catid.'&posts_per_page=6' ); $randnewnum = 1;  while($featpost->have_posts()) : $featpost->the_post(); ?>
<div class="blogposts <?php if($randnewnum== 1 or $randnewnum== 3 or $randnewnum== 5){echo"left-posts";} else{ echo"right-post"; } ?>">
<div class="hldrblog4" itemprop="image">
<?php 
  if ( get_the_post_thumbnail() != '' ) { 
    echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
  $source_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
 $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 365 && $imginfo[1] >= 220){
  $resizedImage = aq_resize($source_image_url, 365, 220, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
    echo '</a>';
    } 
    elseif(howlthemes_catch_that_image()){
   $source_image_url = howlthemes_catch_that_image();
 $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 365 && $imginfo[1] >= 220){
  $resizedImage = aq_resize($source_image_url, 365, 220, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
   echo '</a>';
    } 
    else{
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
    echo '<img src="';
    echo esc_url( get_template_directory_uri() );
    echo '/img/gridposts.jpg" alt="';the_title();
    echo '" />';
    echo '</a>';
}
  ?>
</div>
  <div class="entry-content-hldr">
      <div class="entry-metatag">

<span class="time-drag"><i class="fa fa-calendar-o"></i><span class="dtime"><?php the_time('F j, Y'); ?></span></span>
<span class="comment-count"><i class="fa fa-comments"></i> <a href="<?php the_permalink() ?>/#comment"><?php echo get_comments_number(); ?></a></span>
 </div> <h2 itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
</div>

</div>


 <?php $randnewnum++; endwhile; ?>
</div>

<?php  } if($catboxnum == 5 && $catid != 'none' && $catid !=''){?>
<!--Simple Posts-->
<div class="simple-posts">
    <div class="titlecatholder"><span><a href='<?php echo get_site_url(); ?>/category/<?php echo str_replace(" ", "-", get_category($catid)->name) ?>'><?php echo get_category($catid)->name ?></a></span></div>
<?php $featpost = new WP_Query( 'cat='.$catid.'&posts_per_page=6' ); while($featpost->have_posts()) : $featpost->the_post(); ?>
<article itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
<?php if ( get_the_post_thumbnail() != '' ) { 
    echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
  $source_image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );
 $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 220 && $imginfo[1] >= 170){
  $resizedImage = aq_resize($source_image_url, 220, 170, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
    echo '</a>';
    } 
    elseif(howlthemes_catch_that_image()){
   $source_image_url = howlthemes_catch_that_image();
 $imginfo = getimagesize($source_image_url);
  if($imginfo[0] >= 220 && $imginfo[1] >= 170){
  $resizedImage = aq_resize($source_image_url, 220, 170, true);
  }
  else{
  $resizedImage = $source_image_url;
  }
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
   echo '<img src="';
   echo $resizedImage;
   echo '" alt="';the_title();
   echo '" />';
   echo '</a>';
    } 
    else{
   echo '<a href="'; the_permalink(); echo '" class="thumbnail-wrapper">';
    echo '<img src="';
    echo esc_url( get_template_directory_uri() );
    echo '/img/simplethumbnail.jpg" alt="';the_title();
    echo '" />';
    echo '</a>';
}
  ?>
 <div class="blog-content-hldr">
    <h2 itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
  <div class="entry-metatag">
<span class="entry-author"><i class="fa fa-user"></i> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><span><?php echo get_the_author() ?></span></a></span>
<span class="time-drag"><i class="fa fa-calendar-o"></i><span class="dtime"><?php the_time('F j, Y'); ?></span></span>
<span class="comment-count"><i class="fa fa-comments"></i> <a href="<?php the_permalink() ?>/#comment"><?php echo get_comments_number(); ?></a></span>
 </div> 
<?php the_excerpt(); ?>
</div>
</article>
<?php endwhile; ?>
</div>

<?php }

} // foreach loop ends

}
?>


</main><!-- #main -->
</div><!-- #primary -->
