/*global jQuery*/

/**
 * Slider by Supsystic Wordpress Plugin
 * Coin-Slider module.
 */
(function ($, app) {

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
        } else if(parseFloat(value)) {
            return parseFloat(value);
        } else if (typeof value === 'object') {
            for( key in value) {
                value[key] = stringToBoolean(value[key]);
            }
        }
        return value;
    };

    var initSlider = function() {
        var $sliders = $('.supsystic-slider.supsystic-slider-swiper');


        if ($sliders.length < 1) {
            return false;
        }

        $.each($sliders, function (index, slider) {


            var $slider  = $(slider),
                settings = $slider.data('settings'),
                config   = {};

            $.each(settings, function (category, opts) {
                if(opts && typeof opts == 'object') {
                    if(['properties','general','effects','advanced'].includes(category)) {
                        $.each(opts, function (key, value) {
                            if(stringToBoolean(value) != '')
                                config[key] = stringToBoolean(value);
                        });
                    }
                }
            });


            $.each(['pagination', 'nextButton', 'prevButton', 'scrollbar'], function(index, value) {
                if(typeof config[value] !== 'undefined') {
                    config[value] = '.' + config[value];
                    $slider.closest('.swiper-container').find('.'+value).addClass(config[value].substr(1)).show();
                } else {
                    $slider.closest('.swiper-container').find('.'+value).hide();
                }

            });

            // $slider.coinslider(config);
            new Swiper ($slider.closest('.swiper-container'), config);
            if(typeof config.arrows_color != 'undefined') {
                $('.swiper-button-prev svg path').css('fill',config.arrows_color);
                $('.swiper-button-next svg path').css('fill',config.arrows_color);
            }
            $slider.css('visibility', 'visible');

            var width = $sliders.width(),
                width_img = $(slider).find('a img').width();
            //console.log(settings);
            if( settings.general.effect === 'flip' ){
                if(width > width_img){
                    var margin_left = ( width - width_img ) / 2;
                    $(slider).css({'paddingLeft' : margin_left});
                }
            }

        });
    };

    app.plugins = app.plugins || {};
    app.plugins.coin = initSlider;

}(jQuery, window.SupsysticSlider = window.SupsysticSlider || {}));