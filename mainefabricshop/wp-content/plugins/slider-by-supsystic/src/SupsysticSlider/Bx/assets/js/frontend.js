/*global jQuery*/
(function ($, app) {

    function loadApi(src) {
        var tag = document.createElement('script');
        tag.src = src;
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

    if ($('.supsystic-slider [data-service="youtube"]').length) {
        loadApi('https://www.youtube.com/iframe_api');
    }

    if ($('.supsystic-slider [data-service="vimeo"]').length) {
        loadApi('https://f.vimeocdn.com/js/froogaloop2.min.js');
    }

    onYouTubeAPIReady = function(callback) {
        var check = setInterval(function () {
            if (typeof YT !== "undefined" && YT.loaded) {
                callback();
                clearInterval(check);
            }
        }, 100);
    };

    onVimeoAPIReady = function(callback) {
        var check = setInterval(function () {
            if (typeof $f !== "undefined") {
                callback();
                clearInterval(check);
            }
        }, 100);
    };

    /**
     * Converts string to boolean values if it needed.
     * @type {Function}
     * @param {*} value
     * @return {*}
     */
    var stringToBoolean = (function (value) {
        if (value == 'true') {
            return true;
        } else if (value == 'false') {
            return false;
        } else {
            return value;
        }
    });

    var defaults = {
        adaptiveHeight: false,
        responsive:     true
    };

    var initThumbsTransition = function($slider, $thumbs) {
        $thumbs.find('li').on('click', function() {
            $slider.goToSlide(parseInt($(this).index()));
            //$thumbs.goToSlide(parseInt($(this).index()) - 4);
        });
    };

    var initThumbs = function($slider, $current, config) {
        var $thumbs = $('.' + $slider.data('thumbs')).bxSlider({
                slideWidth: 100,
                minSlides: 4,
                maxSlides: 10,
                slideMargin: 1,
                infiniteLoop: false,
                width: parseInt(config.width)
            }),
            $thumbsContainer = $('.thumbs'),
            maxWidth = parseInt(config.width);

        initThumbsTransition($current, $thumbs);

        if(parseInt($thumbsContainer.find('li').length * 100) < config.width) {
            maxWidth = $thumbsContainer.find('li').length * 100;
        }

        $thumbsContainer.closest('.bx-wrapper').css('max-width', maxWidth);
        $thumbsContainer.closest('.bx-wrapper').css('margin-top', '5px');
        $thumbsContainer.css({visibility: 'visible'});
    };

    var initWrapper = function() {
        $('div#bx-clearfix').each(function() {
            var slider = $(this).prev();
            var wrapper = $(this).next('.bx-wrapper');
            if(wrapper.length) {
                wrapper.css('float', slider.css('float'));
            }
        });
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

    function sliderInit($slider, config) {

        var $currentSlide = $slider.getCurrentSlideElement(),
            $youtubeFrames = $slider.find('[data-service="youtube"]');
            $vimeoFrames = $slider.find('[data-service="vimeo"]');

        $youtubeFrames.each(function(index, el) {
            var $frame = $(this);
            $frame.attr('id', Math.random().toString(36).substr(2, 9));
            onYouTubeAPIReady(function() {
                loadYouTubePlayer($slider, $frame, config, $frame.parent());
            });

        });

        $vimeoFrames.each(function(index, el) {
            var $frame = $(this);
            $frame.attr('id', Math.random().toString(36).substr(2, 9));
            onVimeoAPIReady(function() {
                loadVimeoPlayer($slider, $frame, config, $frame.parent());
            });

        });
    }

    function sliderSlide($container, $slideElement, $oldSlide) {
        var $videoFrame = $oldSlide.find('iframe');

        if ($videoFrame.length) {
            if ($videoFrame.data('service') === 'youtube') {
                var player =  $videoFrame.data('player');
                if (player.getPlayerState() === 1) {
                    player.pauseVideo();
                }
            }

            if ($videoFrame.data('service') === 'vimeo') {
                $videoFrame.data('player').api('pause');
            }
        }

    }

    function loadYouTubePlayer($slider, $youtubeFrame, config, $slide) {
        if ($slide.index() === 1 && config.auto == "enable") {
            $slider.stopAuto();
        }
        var id = $youtubeFrame.attr('id'),
            player = new YT.Player(id, {
                videoId: $youtubeFrame.data('video-id'),
                width: $youtubeFrame.data('width'),
                height: $youtubeFrame.data('height'),
                events: {
                    'onReady': function(event) {
                        player.stopVideo();
                        if ($slide.index() === 1 && config.auto == "enable") {
                            $slider.startAuto();
                        }
                        $slide.find('iframe').data('player', player);
                    },
                    'onStateChange': function(event) {
                        if ($.inArray(event.data, [1]) !== -1) {
                            onVideoPlay($slider, config);
                        } else if ($.inArray(event.data, [0, 2])  !== -1) {
                            onVideoStop($slider, config);
                        }
                    }
                }
            });
    }

    function loadVimeoPlayer($slider, $frame, config, $slide) {
        if ($slide.index() === 1 && config.auto == "enable") {
            $slider.stopAuto();
        }
        var id = $frame.attr('id'),
            $vimeoFrame = $('<iframe>', {
                'id': id,
                'data-service': $frame.data('service'),
                'width': $frame.data('width'),
                'height': $frame.data('height'),
                'src': 'https://player.vimeo.com/video/' + $frame.data('video-id') + '?api=1&player_id=' + id
            });

        $frame.replaceWith($vimeoFrame);

        var player = $f($vimeoFrame[0]);

        player.addEvent('ready', function() {
             if ($slide.index() === 1 && config.auto == "enable") {
                $slider.startAuto();
            }
            player.addEvent('pause', function() {
                onVideoStop($slider, config);
            });
            player.addEvent('finish', function() {
                onVideoStop($slider, config);
            });
            player.addEvent('play', function() {
                onVideoPlay($slider, config);
            });
        });

        $vimeoFrame.data('player', player);
    }

    function onVideoPlay($slider, config) {
        if (config.auto == "enable") {
            $slider.disableAuto();
            $slider.stopAuto();
        }
    }

    function onVideoStop($slider, config) {
        if (config.auto == "enable") {
            $slider.enableAuto();
            $slider.startAuto();
        }
    }

    var init = (function ($container) {
        var $bx;

        if (!$container.length) {
            return;
        }

        $bx = $container.filter('.supsystic-slider-bx');

        if (!$bx.length) {
            return;
        }

        $.each($bx, function (index, slider) {
            var $slider = $(slider),
                settings = $slider.data('settings'),
                config = {},
                $current;

            if(settings.properties.width > 100 && settings.properties.widthType == '%') {
                settings.properties.width = 100;
            }

            if(settings.properties.widthType == '%') {
                settings.properties.width = parseInt($container.parent().css('width'))*parseInt(settings.properties.width)/100.0;
                settings.properties.height = parseInt(settings.properties.height)*100/parseInt(settings.properties.width);
            }

            $.each(settings, function (category, opts) {
                if(category != '__veditor__') {
                    $.each(opts, function (key, value) {
                        if (key !== 'enabled') {
                            config[key] = stringToBoolean(value);
                        }
                    });
                }
            });

            config = $.extend(defaults, config, {
                pause: 5000,
                slideWidth: config.width,
                'sliderId': $slider.attr('id').split('-')[2],
                'startSlide': (typeof(config.start) != 'undefined' && config.start) ? config.start - 1 : 0, // Slides count is start from 0
            });

            for (var i in config) {
                if (!isNaN(parseFloat(config[i]))) {
                    config[i] = Number(config[i]);
                }
            }

            $slider.find('ul').each(function (index, container) {
                var $container = $(container),
                    $oldSlide,
                    $current = $container.bxSlider(
                        $.extend(config, {
                                onSliderLoad: function (idx) {
                                    sliderInit($container, config);

                                    if (config.mode == 'vertical') {
                                        $('.bx-prev').parent().first().addClass('bx-controls-vertical');
                                        if (config.verticalArrowsMode != 'undefined'
                                            && config.verticalArrowsMode) {
                                            $('.bx-controls-vertical .bx-prev').parent().first().addClass('vertical');
                                            $('.bx-controls-vertical .bx-prev').css({
                                                top: '-16px',
                                                left: '48%',
                                                transform: 'rotate(90deg)'
                                            });
                                            $('.bx-controls-vertical .bx-next').css({
                                                top: $('.bx-viewport').height() + 16 + 'px',
                                                left: '48%',
                                                transform: 'rotate(90deg)'
                                            });
                                            $('.bx-has-pager').css({
                                                'margin-top': '30px'
                                            });
                                        }
                                    }

                                    $container.css({visibility: 'visible'});
                                    $oldSlide = $container.getCurrentSlideElement();
                                },
                                onSlideBefore: function($slideElement, oldIndex, newIndex) {
                                    sliderSlide($container, $slideElement, $oldSlide);
                                    $oldSlide = $slideElement;
                                }
                            }
                        )
                    );

                if (parseInt(config.navigation)) {
                    initThumbs($slider, $current, config);
                } else {
                    $('.' + $slider.data('thumbs')).remove();
                }

                // Change slide by a click
                $current.find('li > img').each(function() {
                    $(this).on('click', function() {
                        $current.goToNextSlide();
                    });
                });
            });


            if(settings.caption && settings.caption['font-family']) {
                loadFont(settings.caption['font-family']);
            }
        });

        initWrapper();
    });

    app.plugins = app.plugins || {};
    app.plugins.bx = init;

}(jQuery, window.SupsysticSlider = window.SupsysticSlider || {}));