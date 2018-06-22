<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
global $wpti;

get_header(); ?>

<div id="sommaire">
	<div id="scrollSommaire">
		<div id="contentSommaire">
			
			<h2 class="title"><?php _e('TOP STORIES', 'wp-to-ipad') ?></h2>
			
			<div id="immanquables">
				
				<div id="scrollImmanquables">
				
					<table><tr>
					<?php
					$query = new WP_Query('posts_per_page=7');
					$i = 0;
					$nbPost = $query->post_count;
					$ceil = ceil($nbPost/2) - 1;
					if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

						<?php if($i == 0) : ?>
							<td rowspan="2" onclick="getArticle('<?php the_permalink() ?>')">
								<div class="bOverlay" style="width:306px;height:404px">
									<div class="image1">
										<?php $src = $wpti->getThumbnail(get_the_ID(), 'thumbnail-sommaire-1') ; 
										if($src) : ?> <img src="<?php echo $src ?>" height="404" /><?php endif; ?>
									</div>
									<div class="cOverlay"><h3><?php the_title() ?></h3></div>
									<div class="overlay"></div>
								</div>
							</td>
						<?php 
						else : 
							?>
							<td onclick="getArticle('<?php the_permalink() ?>')">
								<div class="bOverlay" style="width:351px;height:196px">
									<div class="image2">
										<?php $src = $wpti->getThumbnail(get_the_ID(), 'thumbnail-sommaire-2') ; 
										if($src) : ?> <img src="<?php echo $src ?>" width="351" /><?php endif; ?>
									</div>
									<div class="cOverlay"><h3><?php the_title() ?></h3></div>
									<div class="overlay"></div>
								</div>
							</td>

							<?php 
							if($i == $ceil) : ?>
								</tr><tr class="vbottom">
							<?php endif; ?>
						<?php endif; ?>

					<?php $i++; endwhile; endif; ?>
					</tr></table>
				</div>
				
			</div>
			<div class="clear"></div>
			<div id="contentCategory"></div>
			
		</div>
		
		<a href="" class="plus" id="nextCategory" debut="0"></a>
		
		<div class="clear"></div>
		
		<?php if($wpti->config->get('wpti_aff_comments') == "1") : ?>
		<h2 class="title"><?php _e('Last comments', 'wp-to-ipad') ?></h2>
		<div class="blocCat" id="blocComments">
			<div id="scrollComments" class="scrollCat">
				<?php $wpti->getLastComments() ?>
			</div>
		</div>
		<div class="clear"></div>
		<?php endif; ?>

		<?php if($wpti->config->get('wpti_aff_pages') == "1") : ?>
		<h2 class="title"><?php _e('Pages', 'wp-to-ipad') ?></h2>
		<div class="blocCat" id="blocPages">
			<div id="scrollPages" class="scrollCat">
				<?php $wpti->getPages(); ?>
			</div>
		</div>
		<div class="clear"></div>
		<?php endif; ?>
		
		<?php get_footer(); ?>
		
	</div>
</div>

<div id="article" style="display:none">
	<div id="scrollArticle">
		<div id="contentArticle"></div>
	</div>
</div>

<div id="utils" style="display:none"></div>

</div>

<div class="popup" id="popup_info">
    <div class="content" id="scrollPopup">
		<div>
			<div class="description_site">
				<?php 
				if($wpti->config->get('wpti_description_info') != "") 
					echo $wpti->config->get('wpti_description_info');
				else
					bloginfo( 'description' ); 
				?><br/>
			</div>
			<?php if ($wpti->config->get('wpti_credit_link') == "1") : ?>
				<div class="description_kinoa" style="display: none">
					<?php echo $wpti->description_Kinoa() ?><br/>
				</div>
			<?php endif; ?>
		</div>
		
	</div>
	<?php if ($wpti->config->get('wpti_credit_link') == "1") : ?>
		<a href="" class="buttonIphoneStyleLeft selected" id="description_site"><?php _e('About', 'wp-to-ipad') ?></a>
		<a href="" class="buttonIphoneStyleRight" id="description_kinoa">Kinoa</a>
	<?php endif; ?>
</div>

<div class="popup" id="popup_size">
	<div class="content">
    	<ul>
			<li><a href="#" id="extra-small" class="pick-fontsize">Extra-small</a></li>
			<li><a href="#" id="small" class="pick-fontsize">Small</a></li>
			<li><a href="#" id="medium" class="pick-fontsize">Medium</a></li>
			<li><a href="#" id="large" class="pick-fontsize">Large</a></li>
			<li><a href="#" id="extra-large" class="pick-fontsize">Extra-Large</a></li>
		</ul>
	</div>
</div>
