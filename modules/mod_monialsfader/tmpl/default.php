<?php
/**
* @file
* @brief    Monials Fader module for Joomla
* @author   Gauti Creator
* @version  3.0.2
* @remarks  Copyright (C) 2013 Gauti Creator
* @remarks  Licensed under GNU/GPLv3, see http://www.gnu.org/licenses/gpl-3.0.html
*/
?>

<script type="text/javascript">

	var wait_time = <?php echo $wait_time; ?>;
	var fader_time = <?php echo $fader_time; ?>;
	var active, time_holder, next;

	jQuery(document).ready(function(){
		monialsfader();
	});

	jQuery("#monialsfader").live("mouseenter", function(){
		clearInterval(time_holder);
		<?php if($fader_image == 1) { ?>
		jQuery("#monialsfader_next").show();
		jQuery("#monialsfader_prev").show();
		<?php } ?>
	});

	jQuery("#monialsfader").live("mouseleave", function(){
		monialsfader();
		<?php if($fader_image == 1) { ?>
		jQuery("#monialsfader_next").hide();
		jQuery("#monialsfader_prev").hide();
		<?php } ?>
	});

	jQuery("#monialsfader_next").live("click", function(){
		monialsfader_next();
	});

	jQuery("#monialsfader_prev").live("click", function(){
		monialsfader_prev();
	});

	function monialsfader() {
		clearInterval(time_holder);
		time_holder = setInterval(monialsfader_next, wait_time);
	}

	function monialsfader_blinker(){
		active.css({opacity: 1.0}).removeClass('active').animate({opacity: 0}, fader_time / 2, function(){
			next.css({opacity: 0.0}).addClass('active').animate({opacity: 1.0}, fader_time / 2);
			});
	}

	function monialsfader_fader(){
		active.css({opacity: 1.0}).removeClass('active').animate({opacity: 0}, fader_time / 2);
		next.css({opacity: 0.0}).addClass('active').animate({opacity: 1.0}, fader_time / 2);
	}

	function monialsfader_next(){
		active = jQuery('#monials li.active');
		next =  active.next().length ? active.next() : jQuery('#monials li:first');

		<?php if(fade_blink == 1) { ?>
			monialsfader_blinker();
		<?php }else { ?>
			monialsfader_fader();
		<?php } ?>
	}

	function monialsfader_prev(){
		active = jQuery('#monials li.active');
		next =  active.prev().length ? active.prev() : jQuery('#monials li:last');

		<?php if(fade_blink == 1) { ?>
			monialsfader_blinker();
		<?php }else { ?>
			monialsfader_fader();
		<?php } ?>
	}

</script>

<style>

<?php echo $font_import; ?>

#monialsfader{
	width:<?php echo $mod_width; ?>;
	<!-- height:<?php echo $mod_height; ?>; -->
	margin:0 auto;
}

#monialsfader #inner-monialsfader{
	width:100%;
	position:relative;
	overflow:hidden;
	height:100%;
	float:left;
}

#monialsfader ul#monials{
	width:<?php echo $monials_width ?>;
	height:<?php echo $monials_height ?>;
	float:left;
	position:relative;
	list-style-type:none;
	padding:15px 15px 15px 40px;
	margin:0;
	background:<?php echo $background; ?>;
	border-radius:<?php echo $round_corner; ?>;
	-moz-border-radius:<?php echo $round_corner; ?>;
	-webkit-border-radius:<?php echo $round_corner; ?>;
}

#monialsfader #monials li{
	width:<?php echo $monials_width ?>;
	height:<?php echo $monials_height ?>;  
	position:absolute;
	background:<?php echo $background; ?>;
	opacity:0;
	z-index:8;
}

#monialsfader #monials li.active {
	z-index:10;
	opacity:1;
}

#monialsfader #monials li h4{
	width:<?php echo $titwid; ?>;
	line-height:<?php echo $title_font_size; ?>;
	color:<?php echo $title_color; ?>;
	<!-- font-size:<?php echo $title_font_size; ?>;   -->
	text-align:<?php echo $title_text_align; ?>;
	font-weight:<?php echo $title_font_weight; ?>;
	font-style:<?php echo $title_font_style; ?>;
	float:left;
	font-family:<?php echo $title_font_a; ?>;
}

#monialsfader #monials li .testimonials{
	width:<?php echo $testiwid; ?>;
	color:<?php echo $testimonials_color; ?>;
	<!-- font-size:<?php echo $testimonials_font_size; ?>;  -->
	text-align:<?php echo $testimonials_text_align; ?>;
	font-weight:<?php echo $testimonials_font_weight; ?>;
	font-style:<?php echo $testimonials_font_style; ?>;
	font-family:<?php echo $testi_font_a; ?>;
	float:left;
}

#monialsfader #monials li .imghol{
	width:<?php echo $imgholwid; ?>;
	float:left;
}

#monialsfader #monials li .img{
	width:<?php echo $imgwid; ?>;
	float:left;
	text-align:center;
}

#monialsfader #monials li .img img{
	width:<?php echo $imgwid; ?>;
}

#monialsfader #monials li .author,#monialsfader #monials li .date{
	width:<?php echo $authorwid; ?>;
	color:<?php echo $authors_color; ?>;
	font-size:<?php echo $authors_font_size; ?>;
	text-align:<?php echo $authors_text_align; ?>;
	font-weight:<?php echo $authors_font_weight; ?>;
	font-style:<?php echo $authors_font_style; ?>;
	font-family:<?php echo $auth_font_a; ?>;
	float:left;
}

#monialsfader #monials li .author{
	padding:5px;
}

#monialsfader #bottom-link a{
	width:100%;
	color:<?php echo $link_color; ?>;
	font-size:<?php echo $link_font_size; ?>;
	text-align:<?php echo $link_text_align; ?>;
	font-weight:<?php echo $link_font_weight; ?>;
	font-style:<?php echo $link_font_style; ?>;
	font-family:<?php echo $link_font_a; ?>;
	float:left;
}

#monialsfader #monials-top, #monialsfader #monialsfader_next, #monialsfader #monialsfader_prev{
	float:left;
	position:absolute;
	z-index:15;
	text-align: left;
}

#monialsfader #monials-top{
	left:<?php echo $qleft; ?>;
	top:<?php echo $qtop; ?>;;
}

#monialsfader #monialsfader_prev{
	left:<?php echo $l_arr_left; ?>;
	top:<?php echo $l_arr_top; ?>;
	<?php if($fader_image == 1) { ?>
	display:none;
	<?php } ?>
	cursor: pointer;
}

#monialsfader #monialsfader_next{
	right:<?php echo $r_arr_right; ?>;
	top:<?php echo $r_arr_top; ?>;
	<?php if($fader_image == 1) { ?>
	display:none;
	<?php } ?>
	cursor: pointer;
}

</style>

<div id="monialsfader">
	<div id="inner-monialsfader">
		<ul id="monials">
			<?php if($image_s_no == 0){ ?>
				<li class="active">
					<h4>
						<?php
						if(!empty($titles[0]))
						echo $titles[0];
						?>
					</h4>
					<div class="testimonials">
						<?php
						echo $testimonials[0];
						?>
					</div>
					<div class="author">
						<?php
						if(!empty($authors[0]))
						echo $authors[0];
						?>
						<br/>
						<?php
						if(!empty($dates[0]))
						echo $dates[0];
						?>
					</div>
				</li>
				<?php
				for ($i = 1; $i < sizeof($testimonials); $i++ ) {
				if(!empty($testimonials[$i])){
				?>
					<li>
						<h4>
							<?php
							if(!empty($titles[$i]))
							echo $titles[$i];
							?>
						</h4>
						<div class="testimonials">
							<?php
							echo $testimonials[$i];
							?>
						</div>
						<div class="author">
							<?php
							if(!empty($authors[$i]))
							echo $authors[$i];
							?>
						<br/>
							<?php
							if(!empty($dates[$i]))
							echo $dates[$i];
							?>
						</div>
					</li>
				<?php
			} } }
			else{
			?>
			<li class="active">
				<?php if($style < 4){ ?>
				<div class="imghol">
					<?php if($style == 0 || $style == 2){ ?>
						<div class="img">
							<?php
							if(!empty($images[0]))
							echo modmonialsfaderHelper::img_url($images[0],$imgwidth);
							?>
						</div>
						<div class="author">
							<?php
							if(!empty($authors[0]))
							echo $authors[0];
							?>
						<br/>
							<?php
							if(!empty($dates[0]))
							echo $dates[0];
							?>
						</div>
					<?php } else{ ?>
						<div class="author">
							<?php
							if(!empty($authors[0]))
							echo $authors[0];
							?>
						<br/>
							<?php
							if(!empty($dates[0]))
							echo $dates[0];
							?>
						</div>
						<div class="img">
							<?php
							if(!empty($images[0]))
							echo modmonialsfaderHelper::img_url($images[0],$imgwidth);
							?>
						</div>
					<?php } ?>
				</div>
				<?php } ?>
				<h4>
					<?php
					if(!empty($titles[0]))
					echo $titles[0];
					?>
				</h4>
				<div class="testimonials">
					<?php
					echo $testimonials[0];
					?>
				</div>
					<?php if($style > 3){ ?>
						<div class="imghol">
							<?php if($style == 4 || $style == 6){ ?>
								<div class="img">
									<?php
									if(!empty($images[0]))
									echo modmonialsfaderHelper::img_url($images[0],$imgwidth);
									?>
								</div>
								<div class="author">
									<?php
									if(!empty($authors[0]))
									echo $authors[0];
									?>
								<br/>
									<?php
									if(!empty($dates[0]))
									echo $dates[0];
									?>
								</div>
							<?php } else{ ?>
								<div class="author">
									<?php
									if(!empty($authors[0]))
									echo $authors[0];
									?>
								<br/>
									<?php
									if(!empty($dates[0]))
									echo $dates[0];
									?>
								</div>
								<div class="img">
									<?php
									if(!empty($images[0]))
									echo modmonialsfaderHelper::img_url($images[0],$imgwidth);
									?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
			</li>
			<?php
			for ($i=1; $i<sizeof($testimonials); $i++) {
			if(!empty($testimonials[$i])){
			?>
				<li>
					<?php if($style < 4){ ?>
						<div class="imghol">
							<?php if($style == 0 || $style == 2){ ?>
								<div class="img">
									<?php
									if(!empty($images[$i]))
									echo modmonialsfaderHelper::img_url($images[$i],$imgwidth);
									?>
								</div>
								<div class="author">
									<?php
									if(!empty($authors[$i]))
									echo $authors[$i];
									?>
								<br/>
									<?php
									if(!empty($dates[$i]))
									echo $dates[$i];
									?>
								</div>
							<?php } else{ ?>
								<div class="author">
									<?php
									if(!empty($authors[$i]))
									echo $authors[$i];
									?>
								<br/>
									<?php
									if(!empty($dates[$i]))
									echo $dates[$i];
									?>
								</div>
								<div class="img">
									<?php
									if(!empty($images[$i]))
									echo modmonialsfaderHelper::img_url($images[$i],$imgwidth);
									?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				<h4>
					<?php
					if(!empty($titles[$i]))
					echo $titles[$i];
					?>
				</h4>
				<div class="testimonials">
					<?php
					echo $testimonials[$i];
					?>
				</div>
					<?php if($style > 3){ ?>
				<div class="imghol">
					<?php if($style == 4 || $style == 6){ ?>
						<div class="img">
							<?php
							if(!empty($images[$i]))
							echo modmonialsfaderHelper::img_url($images[$i],$imgwidth);
							?>
						</div>
						<div class="author">
							<?php
							if(!empty($authors[$i]))
							echo $authors[$i];
							?>
						<br/>
							<?php
							if(!empty($dates[$i]))
							echo $dates[$i];
							?>
						</div>
					<?php } else{ ?>
						<div class="author">
							<?php
							if(!empty($authors[$i]))
							echo $authors[$i];
							?>
						<br/>
							<?php
							if(!empty($dates[$i]))
							echo $dates[$i];
							?>
						</div>
						<div class="img">
							<?php
							if(!empty($images[$i]))
							echo modmonialsfaderHelper::img_url($images[$i],$imgwidth);
							?>
						</div>
					<?php } ?>
				</div>
					<?php } ?>
				</li>
			<?php } } } ?>
		</ul>
		<div id="monials-top">
			<?php
			echo $quote_link;
			?>
		</div>
		<?php if($fader_image > 0) { ?>
			<div id="monialsfader_next">
				<img src="<?php echo JURI::base() ?>/modules/mod_monialsfader/images/next.png" alt="Next" />
			</div>
			<div id="monialsfader_prev">
				<img src="<?php echo JURI::base() ?>/modules/mod_monialsfader/images/prev.png" alt="Prev" />
			</div>
		<?php } ?>
	</div>
	<div id="bottom-link">
		<?php echo $linktext; ?> 
		<?php echo $callbacktext; ?> 
	</div>
	<div style="clear:both"></div>
</div>