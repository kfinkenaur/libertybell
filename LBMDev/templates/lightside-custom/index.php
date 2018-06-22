<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addStyleSheet($this->baseurl . '/media/jui/css/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl . '/media/jui/css/bootstrap-responsive.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/style.css');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/main.js', 'text/javascript');
?>


<!DOCTYPE html>
<html>
<head>
    <jdoc:include type="head" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="http://www.lightsidemedia.com/c lients/liberty/images/bell.png">
	<link href='http://fonts.googleapis.com/css?family=EB+Garamond|Muli|Dosis' rel='stylesheet' type='text/css'>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
	
</head>

<body>
 


					<?php if ($this->countModules('spacer-home')): ?>
						<div class="spacer-home">
							<jdoc:include type="modules" name="spacer-home" style="xhtml" />		
						</div>
					<?php endif; ?>
		<!-- Fixed Image ================================================== -->
		<?php if ($this->countModules('fixed')): ?>
				<div class="cd-fixed-bg cd-bg-1">
				<jdoc:include type="modules" name="fixed" style="xhtml" />	
				</div>
		<?php endif; ?>
		<!-- /.fixed -->
	<!-- Fixed Image ================================================== -->
		<?php if ($this->countModules('fixed3')): ?>
			
			<div class="cd-fixed-bg cd-bg-3">
			<jdoc:include type="modules" name="fixed3" style="xhtml" />	
			</div>
			
		<?php endif; ?>
		<!-- /.fixed -->
				<!-- Fixed Image ================================================== -->
		<?php if ($this->countModules('fixed4')): ?>
		
			<div class="cd-fixed-bg cd-bg-4">
			<jdoc:include type="modules" name="fixed4" style="xhtml" />	
			</div>
		
		<?php endif; ?>
		<!-- /.fixed -->
				<!-- Fixed Image ================================================== -->
		<?php if ($this->countModules('fixed5')): ?>
			<div class="cd-fixed-bg cd-bg-5">
			<jdoc:include type="modules" name="fixed5" style="xhtml" />	
			</div>
		<?php endif; ?>
		<!-- /.fixed -->
				<!-- Fixed Image ================================================== -->
		<?php if ($this->countModules('fixed6')): ?>
			<div class="cd-fixed-bg cd-bg-6">
			<jdoc:include type="modules" name="fixed6" style="xhtml" />	
			</div>
		<?php endif; ?>
		<!-- /.fixed -->
				<!-- Fixed Image ================================================== -->
		<?php if ($this->countModules('fixed7')): ?>
			<div class="cd-fixed-bg cd-bg-7">
			<jdoc:include type="modules" name="fixed7" style="xhtml" />	
			</div>
		<?php endif; ?>
		<!-- /.fixed -->
						<!-- Fixed Image ================================================== -->
		<?php if ($this->countModules('fixed8')): ?>
			<div class="cd-fixed-bg cd-bg-8">
			<jdoc:include type="modules" name="fixed8" style="xhtml" />	
			</div>
		<?php endif; ?>
		<!-- /.fixed -->
		<?php if ($this->countModules('fixed9')): ?>
			<div class="cd-fixed-bg cd-bg-9">
			<jdoc:include type="modules" name="fixed9" style="xhtml" />	
			</div>
		<?php endif; ?>
		<?php if ($this->countModules('fixed10')): ?>
			<div class="cd-fixed-bg cd-bg-10">
			<jdoc:include type="modules" name="fixed10" style="xhtml" />	
			</div>
		<?php endif; ?>
		<?php if ($this->countModules('fixed11')): ?>
			<div class="cd-fixed-bg cd-bg-11">
			<jdoc:include type="modules" name="fixed11" style="xhtml" />	
			</div>
		<?php endif; ?>
		<!-- /.fixed -->
			
			
		
	<div class="header">
		<?php if ($this->countModules('header-bg')): ?>
			<div class="header-bg">
		<?php endif; ?>

	    <!--
		<div class="navbar navbar-inverse">
		  <div class="navbar-inner">
			<!--<div class="container">  -->
				
				
									
				<div class="row-fluid">	
					
					<?php if ($this->countModules('header12')): ?>
								<div class="logo-contact margin-med">
									<jdoc:include type="modules" name="header12" style="xhtml" />	
										<div class="span6 nav-logo">
											<div class='logo'>
											<jdoc:include type="modules" name="logo" style="xhtml" />		
											</div>
										</div>
										<div class="span4 nav-contact pull-right">
											<?php if ($this->countModules('phone')): ?>
												<div class="phone">
													<jdoc:include type="modules" name="phone" style="xhtml" />		
												</div>
												<div class="clear:both;"></div> 
											<?php endif; ?>
									
										</div>
										<div class="clear:both;"></div>
								</div>
								
					<?php endif; ?>
					
					
					
					
					
					
						<div class="span5"> 
							<div class="nav-logo"> 
								<!-- Logo --> 
								<?php if ($this->countModules('alpha-3')): ?>
									<div class="alpha-3">
								<?php endif; ?>
								<?php if ($this->countModules('alpha-10')): ?>
									<div class="alpha-10">
								<?php endif; ?>
									
										<jdoc:include type="modules" name="logo" style="xhtml" />		
									
								<?php if ($this->countModules('alpha-3')): ?>
									</div>
								<?php endif; ?>
								<?php if ($this->countModules('alpha-10')): ?>
									</div>
								<?php endif; ?>
								<!-- /logo -->
								<div style="clear:both"></div>
							</div>
						</div>

						<div class="span5 pull-right">
							<div class="nav-contact ">
										<?php if ($this->countModules('alpha-3')): ?>
										<div class="alpha-3">
										<?php endif; ?>
										<?php if ($this->countModules('alpha-10')): ?>
										<div class="alpha-10">
										<?php endif; ?>
											 <!-- Phone ================================================== -->
											<?php if ($this->countModules('phone')): ?>
												<div class="phone">
													<jdoc:include type="modules" name="phone" style="xhtml" />		
												</div>
												<div class="clear:both;"></div> 
											<?php endif; ?>
											<!-- /.Phone -->
											
											 <!-- Email ================================================== -->
											<?php if ($this->countModules('email')): ?>
												<div class="pull-right">
													<jdoc:include type="modules" name="email" style="xhtml" />		
												</div>	
												<div class="clear:both;"></div>
											<?php endif; ?>
											<!-- /.Phone -->
										<?php if ($this->countModules('alpha-3')): ?>
										</div>
										<?php endif; ?>
										<?php if ($this->countModules('alpha-10')): ?>
										</div>
										<?php endif; ?>
											<!-- Top Menu ================================================== -->
										<?php if ($this->countModules('topmenu')): ?>
											
												
													<jdoc:include type="modules" name="topmenu" style="xhtml" />
													<div style="clear:both"></div>
													
										<?php endif; ?>
											<!-- /.Top Menu -->
							</div>
						</div>		
					
					
				
				</div>
				
				
					<div class="row-fluid">
						<div class="span12 pull-right">
							<?php if ($this->countModules('mainmenu')): ?>   
						 		<?php if ($this->countModules('alpha-3')): ?>
								<div class="alpha-3 nav-z">
								<?php endif; ?>
								<?php if ($this->countModules('alpha-10')): ?>
								<div class="alpha-10">
								<?php endif; ?>				
								<div class="container"> 
									<div class="navbar">
										  <div class="navbar-inner">
											<div class="container">  
												<?php if ($this->countModules('header-bg')): ?>
												<div class="mobile-nav">
												<?php endif; ?>
												
													<button type="button" class="btn btn-navbar pull-right" data-toggle="collapse" data-target=".nav-collapse">
														<span class="icon-bar"></span>
														<span class="icon-bar"></span>
														<span class="icon-bar"></span>
													</button>
												<?php if ($this->countModules('header-bg')): ?>
												</div>
												<?php endif; ?>
												
												
												<div class="nav-center">
												 <div class="nav-collapse collapse pull-right">
													<div class="dropdown ">
														<jdoc:include type="modules" name="mainmenu" style="xhtml" />
														<div style="clear:both"></div>
													</div>
												 </div> 
												 </div>
											</div> 
										  </div>
									</div>
								</div>

								<?php if ($this->countModules('alpha-3')): ?>
								</div>
								<?php endif; ?>
								<?php if ($this->countModules('alpha-10')): ?>
								</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					

					
					
					
					
					
					
				<!--</div>    -->
			  
				</div>
			  
			</div>
<!--	</div>
		</div> -->
		
		<?php if ($this->countModules('header-bg')): ?>
			</div>
		<?php endif; ?>
		<?php if ($this->countModules('header-bg-mobile')): ?>
			</div>
		<?php endif; ?>
	
	<div style="clear:both"></div>

		<?php if ($this->countModules('collage')): ?>
			<jdoc:include type="modules" name="collage" style="xhtml" />
		<?php endif; ?>
	
				<?php if ($this->countModules('contact-home')): ?>
				<div class="contact-bg">
					<div class='container'>
						<div class='span4 pull-right contact-adjust'>
								
							<div class='contact'>
							<jdoc:include type="modules" name="contact-home" style="xhtml" />
							</div>
								
							<div style="clear:both;"></div>
						</div>
					</div>
				</div>
			<?php endif; ?> 
	

	
	<?php if ($this->countModules('banner-inner')): ?>
					<div class='banner-inner'>
						<jdoc:include type="modules" name="banner-inner" style="xhtml" />
					</div>			
			<?php endif; ?>
			
				<?php if ($this->countModules('banner-innerblank')): ?>
					<div class="container">
					<div class='banner-innerblank'>
						<jdoc:include type="modules" name="banner-innerblank" style="xhtml" />
					</div>	
					</div>					
			<?php endif; ?>
	

		
		

		

			
						<?php if ($this->countModules('promo')): ?>
					<div id='promo' class='promo'>
						<div class='promo-inner'>
						  <div class='promo-spacer'>
							<div class='container'>
								<jdoc:include type="modules" name="promo" style="xhtml" />
							</div>
						  </div>
						</div>
					</div>			
			<?php endif; ?>
			

			<?php if ($this->countModules('promo-content')): ?>
					<div class='promo-content'>
					<div class='container'>
						<jdoc:include type="modules" name="promo-content" style="xhtml" />
					</div>
					</div>			
			<?php endif; ?>
			
			
			<?php if ($this->countModules('bannerA')): ?>
					<div class='bannerA'>
						<div class="container">
						<jdoc:include type="modules" name="bannerA" style="xhtml" />
						</div>
					</div>			
			<?php endif; ?>
			
			<?php if ($this->countModules('banner')): ?>
					<div class='banner'>
					
						<jdoc:include type="modules" name="banner" style="xhtml" />
					
					</div>			
			<?php endif; ?>
						<?php if ($this->countModules('banner2')): ?>
					<div class='banner2'>
						<div class="container">
						<jdoc:include type="modules" name="banner2" style="xhtml" />
						</div>
					</div>			
			<?php endif; ?>
							
			
			
	    <!--	 <section class="col-2 ss-style-triangles">	  -->
			
		<!-- Promo - Scrolling Image 1          ================================================== -->
		<?php if ($this->countModules('scroll1')): ?>
			<div class="cd-scrolling-bg cd-color-2"> 
			<div class="container">
				<jdoc:include type="modules" name="scroll1" style="xhtml" />	
			</div>
			</div>
		<?php endif; ?>
		<!-- /.fixed -->
	 
		  <!--    </section>   -->
	
	
	

	
	
		<?php if ($this->countModules('promo-blank')): ?>
		<div class='promo'>
		
		<div class='row'>
		<div class='container'>
			<div class='span12' style="margin-left: 0px;">
			<jdoc:include type="modules" name="promo-blank" style="xhtml" />
			</div>
		</div>
		</div>
		</div>
	<?php endif; ?>
	
	
    
<!--	<div class='container'>    -->
    
               <!-- mid container - includes main content area and right sidebar -->
			   
			   
	<?php if ($this->countModules('right') && $this->countModules('left')): ?>
    	 <div class='row'>
		 	
			<div class='span3 pull-right margin-vmin'>
                <jdoc:include type="modules" name="right" style="well" />
			</div>			
            <!-- main content area -->
         <div class='span6 pull-right margin-vmin'>
				
                <jdoc:include type="modules" name="content" style="xhtml" />
                <jdoc:include type="modules" name="position-2" style="none" />
				<jdoc:include type="message" />
				<jdoc:include type="component" />
          </div>

		 <div class="clear:both;"></div>
            <!-- left sidebar -->
          <div class='span3 pull-left margin-vmin'>
                <jdoc:include type="modules" name="left" style="well" />
         </div>
		 
		 		  	<!-- right sidebar        -->
        

       </div>			   
<?php elseif ($this->countModules('right')): ?>
	    <div class='row-fluid'>
	
	
	
					<?php if ($this->countModules('spacer')): ?>
						<div class="spacer">
							<jdoc:include type="modules" name="spacer" style="xhtml" />		
						</div>
					<?php endif; ?>

							<div class="cd-fixed-bg cd-bg-2">
											<div class="container">
											  <div class="pos-margin2">
												<div class='span12 pad-med margin-vmin' >
												
													<div class="span8 menu-spacer">
														<jdoc:include type="modules" name="content" style="xhtml" />
														<jdoc:include type="modules" name="position-2" style="none" />
														<jdoc:include type="message" />
														<jdoc:include type="component" />	
													</div>
													<div class="span4">
														<jdoc:include type="modules" name="right" style="well" />
													</div>
												</div>
												</div>
												</div>	
										<div style="clear:both"></div>
												
												
											
								</div>		















		 

    
<?php elseif ($this->countModules('left')): ?>
    	 <div class='row'>
            <!-- main content area -->
         <div class='span9 pull-right'>
				
                <jdoc:include type="modules" name="content" style="xhtml" />
                <jdoc:include type="modules" name="position-2" style="none" />
				<jdoc:include type="message" />
				<jdoc:include type="component" />

				
          </div>
            <!-- left sidebar -->
          <div class='span3 pull-left margin-vmin'>
                <jdoc:include type="modules" name="left" style="well" />
         </div>
       </div>
	   
	   
   
	   
		
<?php else : ?>
                <!-- main content area -->
					<?php if ($this->countModules('spacer')): ?>
						<div class="spacer">
							<jdoc:include type="modules" name="spacer" style="xhtml" />		
						</div>
					<?php endif; ?>
					
				<div class="cd-fixed-bg cd-bg-2">
					<div class="container">
						<div class='span12 pad-med margin-vmin' >
							<jdoc:include type="modules" name="content" style="xhtml" />
							<jdoc:include type="modules" name="position-2" style="none" />
							<jdoc:include type="message" />
							<jdoc:include type="component" />	
						</div>
					
					</div>	
				</div>

					
					
					
					
				
				</div>
<?php endif; ?>

								<!-- footer -->
	<div class="footer">
			<?php if ($this->countModules('footer')): ?>
				
					<jdoc:include type="modules" name="footer" style="xhtml" />		
				 
			<?php endif; ?>
	

			<?php if ($this->countModules('footer1-1') OR $this->countModules('footer1-2') OR $this->countModules('footer1-3')): ?>
						<div class='row-fluid footer1'>
							<div class='container'>
												
									<jdoc:include type="modules" name="footer1-1" style="xhtml" />
								
							</div>
						</div>	
			<?php endif; ?>
						
			<?php if ($this->countModules('footer2-1') OR $this->countModules('footer2-2')): ?>
						<div class='footer2'>
							<div class='container'>
									<jdoc:include type="modules" name="footer2-1" style="xhtml" />
							</div>
							<hr />
						</div>
			<?php endif; ?>
			<?php if ($this->countModules('footer3-1') OR $this->countModules('footer3-2')): ?>
						<div class='row-fluid footer3'>
						
							<div class='container'>
								<jdoc:include type="modules" name="footer3-1" style="xhtml" />
							</div>
						</div>
			<?php endif; ?>
			<?php if ($this->countModules('footer4-1') OR $this->countModules('footer4-2')): ?>
						
						<div class="row-fluid footer4">
						<hr />
							<div class='container'>
								<div class="span6 pull-left">
									<jdoc:include type="modules" name="footer4-1" style="xhtml" />
								</div>
								<div class="span6 pull-left">
									<jdoc:include type="modules" name="footer4-2" style="xhtml" />
								</div>
							</div>
						</div>
			<?php endif; ?>
	</div>
        
    <!-- end footer -->   
			   
			   
			   

			   
			   
			   
			   
			   <!--    </div>    / container above modules  -->

	
	
	
	
	
	
	
	
	<!-- Le javascript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
	<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addStyleSheet($this->baseurl . '/media/jui/js/jquery.js');
$doc->addStyleSheet($this->baseurl . '/media/jui/js/bootstrap.js');
$doc->addStyleSheet($this->baseurl . '/media/jui/js/bootstrap.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/jquery.cycle.all.js', 'text/javascript');
?>
	
	    
	<script src="/media/jui/js/jquery.js"></script>	
    <script src="/media/jui/js/bootstrap.js"></script>
    <script src="/media/jui/js/bootstrap.min.js"></script>
	
	 <!--  needed for testimonial fader and js 'more details' in contact form  -->
	<script src="/templates/lightside-custom/js/jquery.cycle.all.js"></script>
	
	 
		
		<script type="text/javascript">
    $('.dropdown-menu input, .dropdown-menu label').click(function(e) {
        e.stopPropagation();
    });
		</script>
	

	
	<script type="text/javascript">
	
	
					(function($){   
					  $(document).ready(function(){
					  $('.dropdown-toggle').dropdown();
						  // dropdown
						 $('.navbar .parent').addClass('dropdown');
						 $('.navbar .parent > a').addClass('dropdown-toggle');
						 $('.navbar .parent > a').attr('data-toggle', 'dropdown');
						 $('.navbar .parent > a').attr('data-target', '#');
						 $('.navbar .parent > a').append('<b class="caret"></b>');
						 $('.navbar .parent > ul').addClass('dropdown-menu');
						 $('.navbar .nav-child .parent').removeClass('dropdown');
						 $('.navbar .nav-child .parent .caret').css('display', 'none');
						 $('.navbar .nav-child .parent').addClass('dropdown-submenu');

					// For submenus, the following code needs to be added
						$('.navbar .nav-child .parent > a').removeClass('dropdown-toggle');
						 $('.navbar .nav-child .parent > a').attr('data-toggle', '');
						 $('.navbar .nav-child .parent > a').attr('data-target', '');

						 
						  });
						})(jQuery);
						
						</script>
     
	
	<script type="text/javascript">
		$('.dropdown-menu li a').each(function() {
			if($(location).attr('href').indexOf($(this).attr('href')) > 0) {
				 $('.dropdown-menu').show();
			} 
		});
	</script>

	
	

	
	<!-- Collapse Button JS -->
	<script>	
	jQuery('.toggle').on('click', function(e) {
    e.preventDefault();
    var jQuerythis = jQuery(this);
    var jQuerycollapse = jQuerythis.closest('.collapse-group').find('.collapse');
    jQuerycollapse.collapse('toggle');
	jQuery(".promo").toggleClass("contact-spacer");
	});
	</script>
	
		 
	
	<script type="text/javascript">$(document).ready(function() { $('#slideshowwrapper').cycle({fx: 'fade', speed:1000, timeout: 6000 }); });</script>
	
	
	<!-- Google Plus Badge  JS Call  - Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>


	

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	
	<!--
  
	-->
	
	
	<script src="templates/lightside-custom/js/jqBootstrapValidation.js"></script>
	
	
	
	



	
	

	
</body>

</html>