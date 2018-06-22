/*global jQuery*/

/**
 * Slider by Supsystic Wordpress Plugin
 * Jssor-Slider module.
 */
(function ($, app) {
	if ($('video').length) {
		loadApi('https://www.youtube.com/iframe_api');
	}

	onYouTubeAPIReady = function(callback) {
	    var check = setInterval(function () {
	        if (typeof YT !== "undefined" && YT.loaded) {
	            callback();
	            clearInterval(check);
	        }
	    }, 100);
	};

	function playVideo($slide) {
		var $videoFrame = $slide.find('iframe');

		if (typeof $videoFrame.length !== 'undefined' && $videoFrame.length > 0) {
			var video =  $videoFrame.data('player');

			if (typeof video !== 'undefined') {
				if(typeof video.getPlayerState !== 'undefined' 
				&& video.getPlayerState() !== 1) {
					video.playVideo();
				}
			}
		}
	}

	function stopVideo($slide) {
		var $videoFrame = $slide.find('iframe');
		
		if (typeof $videoFrame.length !== 'undefined' && $videoFrame.length > 0) {
			var video =  $videoFrame.data('player');

			if (video !== 'undefined' 
			&& typeof video.getPlayerState !== 'undefined' 
			&& video.getPlayerState() !== 0) {
				video.pauseVideo();
			}
		}
	}

	function loadYouTubePlayer(el, slide, slider, config, jssor) {
		var $slide = slide;
		var $frame = el;
		var id = $frame.attr('id');

		var player = new YT.Player(id, {
			videoId: $frame.data('video-id'),
			width: $frame.data('width'),
			height: $frame.data('height'),
			events: {
				'onReady': function(event) {
					$slide.find('iframe').data('player', player);
					
					if($slide.index() === 1) {
						var firstSlider = $(slider).find('[debug-id="slide-0"]');

						if(config.videoAutoplay) {
							playVideo(firstSlider);
						}
					}
				},
				'onStateChange': function(event) {
					if(config.slideshow === true && event.target.getPlayerState() === 0) {
						jssor.$Next();
					}
				}
			}
		});
	}

	/**
	 * Converts string true or false to the real boolean values.
	 * If value isn't equals to true or false then returns raw value.
	 * @param value
	 * @returns {*}
	 */
	var stringToBoolean = function (value) {
		if (value == 'true') {
			return true;
		} else if (value == 'false') {
			return false;
		} else {
			return value;
		}
	};

	var initJssorResponsive = function(jssorSlider, config) {
		var $slider = jssorSlider != null ? $(jssorSlider.$Elmt) : false;

		if($slider) {
			function ScaleSlider() {
				var bodyWidth = parseInt($slider.parent().width()),
					sliderWidth = parseInt(config.width),
					captionWidth = $slider.width() / 3,
					thumbnailsWidth = bodyWidth / 6;

				if (config.widthType == "%") {
					sliderWidth = config.calculatedWidth;
				}

				// Do not know why we did this before!
				/*if(bodyWidth > sliderWidth) {
				 bodyWidth = sliderWidth;
				 }*/

				if (bodyWidth) {
					if (config.widthType != "%" &&
						config.caption &&
						(config.caption.position == 'left' || config.caption.position == 'right')) {

						jssorSlider.$ScaleWidth(Math.min(bodyWidth - captionWidth, 1920));

					} else if (config.widthType == "%" &&
						config.thumbnails.enable == "true" &&
						(config.thumbnails.type == "vertical-left" || config.thumbnails.type == "vertical-right")) {

						jssorSlider.$ScaleWidth(Math.min(bodyWidth - thumbnailsWidth, 1920));

						if (config.thumbnails.type == "vertical-left") {
							$slider.css({
								left: (bodyWidth / 6) / 2
							});
						} 
						if  (config.thumbnails.type == "vertical-right") {
							$slider.css({
								right: (bodyWidth / 6) / 2
							});
						}

					} else if (config.widthType == "%" &&
						config.caption &&
						(config.caption.position == "left" || config.caption.position == "right")) {
						jssorSlider.$ScaleWidth(Math.min(bodyWidth - (bodyWidth / 4), 1920));

						if (config.caption.position == "left") {
							$slider.css({
								left: (bodyWidth / 4) / 2
							});
						} 
						if  (config.caption.position == "right") {
							$slider.css({
								right: (bodyWidth / 4) / 2
							});
						}

					} else {
						jssorSlider.$ScaleWidth(Math.min(bodyWidth, 1920));
					}
				} else {
					window.setTimeout(ScaleSlider, 30);
				}
			}
			ScaleSlider();
			$(window).bind("load", ScaleSlider);
			$(window).bind("resize", ScaleSlider);
			$(window).bind("orientationchange", ScaleSlider);
		}
	};

	var loadFont = function(fontName) {
		if(fontName) {
			if(fontName.indexOf(',') + 1) {
				fontName = fontName.split(',')[0];
			}
			WebFont.load({
				google: {
					families: [fontName.split(' ').join('+')]
				}
			});
		}
	};

	var checkMode = function(config, options, slider) {
		//sliderInit(slider, config);
		if (config.widthType == '%') {

			$sliderContainer = $(slider).closest('.slider-container').css({margin: '0 auto'});

			aspectRatio = 1.63;
			maxWidth = $sliderContainer.parent().width();
			width = maxWidth / 100 * config.width;

			if (config.height.length > 0) {
				height = config.height;
			} else {
				height = Math.round(width/aspectRatio);
			}

			config.calculatedWidth = width;
			config.calculatedHeight = height;

			if (config.thumbnails.enable == "true") {
				thumbnailsWidth = width / 6;
				thumbnailsHeight = Math.round(thumbnailsWidth/aspectRatio);

				// Thumbnails sizes default
				$sliderContainer.find('.p, .p .c, .p .w').css({
					width: thumbnailsWidth,
					height: thumbnailsHeight,
				});

				thumbnailsContainerStyle = {
					width: thumbnailsWidth,
					height: height,
				};

				if (config.thumbnails.type == "vertical-left" || config.thumbnails.type == "vertical-right") {

					if (config.thumbnails.type == "vertical-left") { 
						$sliderContainer.css({
							left: thumbnailsWidth / 2
						});
						thumbnailsContainerStyle.left = -thumbnailsWidth;
					} else if (config.thumbnails.type == "vertical-right") {
						$sliderContainer.css({
							right: thumbnailsWidth / 2,
							left: 'auto'
						});
						thumbnailsContainerStyle.right = -thumbnailsWidth;
					};

					width = width - thumbnailsWidth;
				} else {
					thumbnailsContainerStyle = {
						width: width,
						height: thumbnailsHeight,
					}
				}

				$sliderContainer.find('[u="thumbnavigator"]').css(thumbnailsContainerStyle);

				config.thumbnailsWidth = thumbnailsWidth;
				config.thumbnailsHeight = thumbnailsHeight;
			};

			if (config.captions && config.caption.position !== "none") {

				captionsWidth = width / 4;
				captionStyles = {}

				if (config.caption.position == "default") {                  
					captionStyles = {
						width: width,
						height: height / 6
					}
				} else if (config.caption.position == "bottom") {
					captionStyles = {
						width: width,
						height: (height / 6) + 20,
						top: 'auto',
						bottom: -(height / 6 + 20)
					}
					$sliderContainer.css('margin-bottom', height / 6 + 20);
				} else if (config.caption.position == "left") {
					captionStyles = {
						width: captionsWidth,
						height: height,
						left: -captionsWidth
					}

					$sliderContainer.css({
						marginLeft: 'auto',
						marginRight: 'auto',
						left: captionsWidth / 2,
					});

					width = width - captionsWidth;

				} else if (config.caption.position == "right") {

					captionStyles = {
						width: captionsWidth,
						height: height,
						right: -captionsWidth
					}

					$sliderContainer.css({
						marginLeft: 'auto',
						marginRight: 'auto',
						left: 'auto',
						right: captionsWidth / 2
					});

					width = width - captionsWidth;
				}

				$sliderContainer.find('[u="thumbnavigator"], .jssor-caption, [u="thumbnavigator"] [u="prototype"]').css(captionStyles);
			};

			$sliderContainer.css({
				width: width,
				height: height
			});

			$sliderContainer.find('.supsystic-slider, .slide [u="player"], .slide-html, .slide iframe, .buttons-container').css({
				width: width,
				height: height
			});

			options.$SlideWidth = width;
			options.$SlideHeight = height;

			$('.supsystic-slider img[u="image"]').css({
				'max-width': 'none',
			});

			options.$FillMode = 2;
		};

		if(config.mode == 'vertical') {
			options.$DragOrientation = 2;
			options.$PlayOrientation = 2;
		}
		if(config.mode == 'horizontal') {
			options.$DragOrientation = 1;
			options.$PlayOrientation = 1;
		}

		if(config.mode == 'carousel') {
			var parts =  Number(config.carousel.parts || 4),
				pieceWidth = config.width / parts,
				pieceMargin = 0.0;

			$('.jssort07').css({
				bottom: '0'
			});

			if (config.widthType == '%') {
				pieceWidth = config.calculatedWidth / parts;
			}

			if (config.carousel && config.carousel.margin) {
				pieceMargin = parseInt(config.carousel.margin);
			}

			/*if(pieceWidth - config.width / 4.0) {
				pieceMargin = (pieceWidth - config.width / 4) / 4;
			}*/

			options.$SlideWidth =  pieceWidth;
			options.$SlideSpacing = pieceMargin;
			options.$DisplayPieces = parts;

			options.$DragOrientation = 1;
			options.$PlayOrientation = 1;
			options.$ArrowNavigatorOptions.$Steps = Number(config.carousel.steps || 4);
			options.$AutoPlaySteps = Number(config.carousel.steps || 4);
		}

	};

	var checkOrientation = function(config, options) {

		if (config.thumbnails.enable != 'true') {
			if(config.captions && config.caption) {
				var parts = 1,
					sliderCaptionWrapper = $('.slider-caption-wrapper');

				if (config.mode == 'carousel') {
					parts = Number(config.carousel.parts || 4);
					var pieceWidth = config.width / parts,
						pieceHeight = config.height / 3,
						pieceMargin = 0.0;

					if (config.widthType == '%') {
						pieceWidth = config.calculatedWidth / parts;
						pieceHeight = config.calculatedHeight / 3;
					}

					if (config.carousel && config.carousel.margin) {
						pieceMargin = parseInt(config.carousel.margin);
					}

					options.$SlideWidth =  pieceWidth;
					options.$SlideHeight =  pieceHeight;
					options.$SlideSpacing = pieceMargin;

					$('.slider-caption').css({
						width: pieceWidth + 'px',
						'background-color': sliderCaptionWrapper.css('background-color')
					});
					sliderCaptionWrapper.css('background-color', '');
					$('[u="thumbnavigator"], .jssor-caption, [u="slides"] .slider-caption').css({
						height: pieceHeight + 'px'
					});
				}

				options.$ActionMode = 1;
				options.$DisableDrag = true;
				options.$AutoCenter = 2;
				options.$DisplayPieces = parts;
			} else {
				options.$DisplayPieces = 6;
				options.$ParkingPosition = 204;
				options.$Orientation = 1;
			}
		} else {
			options.$Loop = 2;
			options.$SpacingX = 3;
			options.$SpacingY = 3;
			options.$ActionMode = 1;
			options.$Lanes = 1;
			if(config.thumbnails.type == 'horizontal') {
				options.$DisplayPieces = 6;
				options.$ParkingPosition = 204;
				options.$Orientation = 1;
			} else {
				options.$DisplayPieces = config.height / 60;
				if (config.widthType == '%') {
					options.$DisplayPieces = Math.round(config.calculatedHeight / config.thumbnailsHeight);
				}
				options.$ParkingPosition = 156;
				options.$Orientation = 2;
			}
		}


		/*if(config.thumbnails.type == 'horizontal') {
			if(!config.caption || config.caption.position == 'none') {
				options.$DisplayPieces = 6;
				options.$ParkingPosition = 204;
				options.$Orientation = 1;
			}
		} else {
			options.$DisplayPieces = config.height / 60;
			options.$ParkingPosition = 156;
			options.$Orientation = 2;
		}*/

	};

	var initSlideshow = function(config, options, slider) {
		
		/*block of setings for slideshowDisableEffects option*/
		var _SlideshowTransitionsWhithoutEffects = [
			 {$Duration:1200,x:1,$Easing:{$Left:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:0,$Brother:{$Duration:1200,x:-1,$Easing:{$Left:$JssorEasing$.$EaseInOutQuart,$Opacity:$JssorEasing$.$EaseLinear},$Opacity:0}}
			 ];
		 
		var _SlideshowTransitions = [
			//Zoom- in
			{$Duration: 1200, $Zoom: 1, $Easing: { $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseOutQuad }, $Opacity: 2 },
			//Zoom+ out
			{$Duration: 1000, $Zoom: 11, $SlideOut: true, $Easing: { $Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
			//Rotate Zoom- in
			{$Duration: 1200, $Zoom: 1, $Rotate: 1, $During: { $Zoom: [0.2, 0.8], $Rotate: [0.2, 0.8] }, $Easing: { $Zoom: $JssorEasing$.$EaseSwing, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseSwing }, $Opacity: 2, $Round: { $Rotate: 0.5} },
			//Rotate Zoom+ out
			{$Duration: 1000, $Zoom: 11, $Rotate: 1, $SlideOut: true, $Easing: { $Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo }, $Opacity: 2, $Round: { $Rotate: 0.8} },
			//Zoom HDouble- in
			{$Duration: 1200, x: 0.5, $Cols: 2, $Zoom: 1, $Assembly: 2049, $ChessMode: { $Column: 15 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
			//Zoom HDouble+ out
			{$Duration: 1200, x: 4, $Cols: 2, $Zoom: 11, $SlideOut: true, $Assembly: 2049, $ChessMode: { $Column: 15 }, $Easing: { $Left: $JssorEasing$.$EaseInExpo, $Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
			//Rotate Zoom- in L
			{$Duration: 1200, x: 0.6, $Zoom: 1, $Rotate: 1, $During: { $Left: [0.2, 0.8], $Zoom: [0.2, 0.8], $Rotate: [0.2, 0.8] }, $Easing: { $Left: $JssorEasing$.$EaseSwing, $Zoom: $JssorEasing$.$EaseSwing, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseSwing }, $Opacity: 2, $Round: { $Rotate: 0.5} },
			//Rotate Zoom+ out R
			{$Duration: 1000, x: -4, $Zoom: 11, $Rotate: 1, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInExpo, $Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo }, $Opacity: 2, $Round: { $Rotate: 0.8} },
			//Rotate Zoom- in R
			{$Duration: 1200, x: -0.6, $Zoom: 1, $Rotate: 1, $During: { $Left: [0.2, 0.8], $Zoom: [0.2, 0.8], $Rotate: [0.2, 0.8] }, $Easing: { $Left: $JssorEasing$.$EaseSwing, $Zoom: $JssorEasing$.$EaseSwing, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseSwing }, $Opacity: 2, $Round: { $Rotate: 0.5} },
			//Rotate Zoom+ out L
			{$Duration: 1000, x: 4, $Zoom: 11, $Rotate: 1, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInExpo, $Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo }, $Opacity: 2, $Round: { $Rotate: 0.8} },
			//Rotate HDouble- in
			{$Duration: 1200, x: 0.5, y: 0.3, $Cols: 2, $Zoom: 1, $Rotate: 1, $Assembly: 2049, $ChessMode: { $Column: 15 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseOutQuad, $Rotate: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $Round: { $Rotate: 0.7} },
			//Rotate HDouble- out
			{$Duration: 1000, x: 0.5, y: 0.3, $Cols: 2, $Zoom: 1, $Rotate: 1, $SlideOut: true, $Assembly: 2049, $ChessMode: { $Column: 15 }, $Easing: { $Left: $JssorEasing$.$EaseInExpo, $Top: $JssorEasing$.$EaseInExpo, $Zoom: $JssorEasing$.$EaseInExpo, $Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInExpo }, $Opacity: 2, $Round: { $Rotate: 0.7} },
			//Rotate VFork in
			{$Duration: 1200, x: -4, y: 2, $Rows: 2, $Zoom: 11, $Rotate: 1, $Assembly: 2049, $ChessMode: { $Row: 28 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseOutQuad, $Rotate: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $Round: { $Rotate: 0.7} },
			//Rotate HFork in
			{$Duration: 1200, x: 1, y: 2, $Cols: 2, $Zoom: 11, $Rotate: 1, $Assembly: 2049, $ChessMode: { $Column: 19 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Zoom: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseOutQuad, $Rotate: $JssorEasing$.$EaseInCubic }, $Opacity: 2, $Round: { $Rotate: 0.8} }
		];
		
		/* slideshowDisableEffects param from admin panel*/
		if(config.slideshowDisableEffects === true){
			options.$SlideshowOptions.$Transitions = _SlideshowTransitionsWhithoutEffects;
		} else {
			options.$SlideshowOptions.$Transitions = _SlideshowTransitions;  
		}

		if(config.slideshow) {
			options.$AutoPlay = true;
		} else {
			options.$AutoPlay = false;
		}

		if(config.slideshowSpeed) {
			options.$AutoPlayInterval = parseInt(config.slideshowSpeed);
		}
	};

	var initSlideButtons = function() {
		$('a.button01')
			.mouseenter(function() {
				var coh = $(this).data('coh'), boh = $(this).data('boh');
				if(coh) {
					$(this).css('color', coh);
				} else {
					$(this).css('color', '#000000');
				}
				if(boh) {
					$(this).css('background', boh);
				} else {
					$(this).css('background', '#FFF');
				}
			})
			.mouseleave(function() {
				var color = $(this).data('oc'), background = $(this).data('ob');
				if(color && background) {
					$(this).css(
						{
							'color': color,
							'background': background
						}
					);
				} else {
					$(this).css(
						{
							'color': '#FFF',
							'background': '#0D6'
						}
					);
				}
			});
		$('a.button02')
			.mouseenter(function() {
				var coh = $(this).data('coh'), boh = $(this).data('boh');
				if(coh) {
					$(this).css('color', coh);
				} else {
					$(this).css('color', '#666');
				}
				if(boh) {
					$(this).css('background', boh);
				} else {
					$(this).css('background', '#e2e2e2');
				}
			})
			.mouseleave(function() {
				var color = $(this).data('oc'), background = $(this).data('ob');
				if(color && background) {
					$(this).css(
						{
							'color': color,
							'background': background
						}
					);
				} else {
					$(this).css(
						{
							'color': '#666',
							'background': '#e2e2e2'
						}
					);
				}
			});
	};

	var initSlider = function($container) {
		var $sliders = $container,
			jssorSlider = null,
			_CaptionTransitions = [],
			options = {
				$PlayOrientation: 2,
				$DragOrientation: 2,
				$AutoPlay: true,
				$AutoPlayInterval: 1500,
				$BulletNavigatorOptions: {
					$Class: $JssorBulletNavigator$,
					$ChanceToShow: 2
				},
				$ArrowNavigatorOptions: {
					$Class: $JssorArrowNavigator$,
					$ChanceToShow: 2,
					$AutoCenter: 0,
					$Steps: 1
				},
				$ThumbnailNavigatorOptions: {
					$Class: $JssorThumbnailNavigator$,
					$ChanceToShow: 2,
				},
				$CaptionSliderOptions: {
					$Class: $JssorCaptionSlider$,
					$CaptionTransitions: _CaptionTransitions,
					$PlayInMode: 1,
					$PlayOutMode: 3
				},
				$SlideshowOptions: {
					$Class: $JssorSlideshowRunner$,
					$TransitionsOrder: 1,
				}
			};
		
		$.each($sliders, function (index, slider) {
			var $slider  = $(slider),
				settings = $slider.data('settings'),
				config   = {};

			$.each(settings, function (category, opts) {
				if(opts) {
					if(Object.keys(opts).length) {
						$.each(opts, function (key, value) {
							config[key] = stringToBoolean(value);
						});
					}
				}
			});

			$.each(settings, function (category, opts) {
				if(category != '__veditor__') {
					if(Object.keys(opts).length) {
						$.each(opts, function (key, value) {
							if (key !== 'enabled') {
								config[key] = stringToBoolean(value);
							}
						});
					}
				}
			});

			_CaptionTransitions["L"] = { $Duration: 800, x: 0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["R"] = { $Duration: 800, x: -0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["T"] = { $Duration: 800, y: 0.6, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["B"] = { $Duration: 800, y: -0.6, $Clip: 10, $Easing: { $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["TL"] = { $Duration: 800, x: 0.6, y: 0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine, $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["TR"] = { $Duration: 800, x: -0.6, y: 0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine, $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["BL"] = { $Duration: 800, x: 0.6, y: -0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine, $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };
			_CaptionTransitions["BR"] = { $Duration: 800, x: -0.6, y: -0.6, $Easing: { $Left: $JssorEasing$.$EaseInOutSine, $Top: $JssorEasing$.$EaseInOutSine }, $Opacity: 2 };

			options = $.extend(options, {
				$StartIndex: (typeof(config.start) != 'undefined' && config.start) ? config.start - 1 : 0,	// Slides count is start from 0
			});

			if($(slider).parent().attr('id') && $(slider).hasClass('supsystic-slider-jssor')) {
				initSlideshow(config, options, $(slider));
				checkMode(config, options, slider);
				checkOrientation(config, options.$ThumbnailNavigatorOptions);
				jssorSlider = new $JssorSlider$($(slider).parent().attr('id'), options);
				
				jssorSlider.$On($JssorSlider$.$EVT_PARK, function(slideIndex, fromIndex) {
					initSlideButtons();
				});
				jssorSlider.$On($JssorSlider$.$EVT_SWIPE_END, function(position, virtualPosition){
					var $slide = $(slider).find('.slide:eq('+ position+ ')');
					if($slide && $slide.size()) {
						var $mapContainer = $slide.find('.gmp_map_opts');
						if( $mapContainer && $mapContainer.size() && typeof(gmpGetMapByViewId) === 'function' ) {
							var map = gmpGetMapByViewId($mapContainer.data('view-id'));
							if( map ) {
								//map.refresh();	// It will not work as it should here in any case, it is working now ok - let it be like it is
							}
						}
					}
				});

				/* if have video */
				if(config.slideshow && $(slider).find('video').length) {
					jssorSlider.$Pause();
				}

				onYouTubeAPIReady(
					function() {
						var $youtubeFrames = $(slider).find('video');
						if($youtubeFrames.length) {
							$youtubeFrames.each(function(index, el) {
								var slide = $(slider).find('[debug-id="slide-' + index + '"]');

								loadYouTubePlayer($(el), slide, slider, config, jssorSlider);
							});
						}
						
						
						jssorSlider.$On($JssorSlider$.$EVT_PARK , function(slideIndex, fromIndex) {
							var newSlide = $(slider).find('[debug-id="slide-' + slideIndex + '"]');
							var fromSlide = $(slider).find('[debug-id="slide-' + fromIndex + '"]');

							if(newSlide.children('div[data-autoplay]').data('autoplay') === 1) {
								if(config.videoAutoplay) {
									playVideo(newSlide);
								}

								if(config.slideshow) {
									jssorSlider.$Pause();
								}
							} else {
								if(config.slideshow) {
									jssorSlider.$Play();
								}
							}

							stopVideo(fromSlide);
						});
					}
				);
				/*  */
			}

			if(config.responsive) {
				initJssorResponsive(jssorSlider, config);
			}

			$JssorPlayer$.$FetchPlayers(document.body);

			if(settings.effects && settings.effects.caption && settings.effects.caption.font.family) {
				loadFont(settings.effects.caption.font.family);
			}

			$(slider).find('.jssor-html-captions').css({'opacity': '1'});

		});

		return true;
	};

	app.plugins = app.plugins || {};
	app.plugins.jssor = initSlider;

}(jQuery, window.SupsysticSlider = window.SupsysticSlider || {}));

function loadApi(src) {
	var tag = document.createElement('script'),
		firstScriptTag = document.getElementsByTagName('script')[0];

	tag.src = src;
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}