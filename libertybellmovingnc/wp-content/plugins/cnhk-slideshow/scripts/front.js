/**
*   Plugin Name: Cnhk Slideshow
*
*   Cnhk Slideshow plugin for WordPress, Copyright (C) 2013 Rija Rajaonah
*   Cnhk Slideshow plugin for WordPress is licensed under the GPL License version 3.
*   [http://www.gnu.org/licenses/gpl-3.0.html]
*/

;(function($){
    // List of slideshows on the current page
    var cnhkSsList = [];
    
    /**
    * The slideshow object
    * @param string identifier, the id attribute of slideshow container
    */
    function cnhkSlideshow(identifier)
    {
        if ('undefined' == typeof(identifier)) {
            throw 'Missing parameter 1 in constructor';
        }
        var instance = this;
        this.id = identifier;
        this.slug = identifier.substring(3,identifier.lastIndexOf('-'));
        this.delay = cnhkOptions['slideshows'][this.slug]['delay'];
        this.skip = cnhkOptions['slideshows'][this.slug]['skip'];
        this.ratio = cnhkOptions['slideshows'][this.slug]['ratio'];
        this.slides = {};
        this.loadedSlides = [];
        this.timeOut = undefined;
        this.started = false;
        var transSpeed = 400;
        if ('none' != cnhkOptions['slideshows'][this.slug]['fx']) {
            transSpeed = cnhkOptions['slideshows'][this.slug]['speed'];
        }
        this.options = 
        {
            fx : cnhkOptions['slideshows'][this.slug]['fx'],
            timeout : cnhkOptions['slideshows'][this.slug]['timeout'],
            speed : transSpeed,
            manualTrump : false,
            slides : '> .cnhk-slide',
            log : false,
            swipe : true,
        };
        
        // Launch the slideshow after the delay parameter
        this.delayedLaunch = function()
        {
            if (!this.started) {
                this.started = true;
                if (cnhkOptions['slideshows'][this.slug]['skip']) {
                    for (var i in this.slides) {
                        if (-1 == this.loadedSlides.indexOf(i)) {
                            delete(this.slides[i]);
                        }
                    }
                }
                $('#' + this.id + ' .loading-image').remove();
                this.appendSlides(this.slides);
                $('#' + this.id).cycle(this.options);
                this.resize()
            }
        }
        
        // Display the "Loading" image
        this.loadingImage = function()
        {
            $('#' + this.id).append($('<img />').attr({
                alt : '',
                src : cnhkOptions['transient']['imageUrl'] + 'loading-bar90.gif',
            }).addClass('loading-image'));
        }
        
        // Triggered when the window is resized
        this.resize = function()
        {
            var w = $('#' + this.id).width();
            var rh = false;
            if (false !== this.ratio) {
                rh = Math.round(w/this.ratio);
                $('#' + this.id).height(rh);
            }
            
            var offset = $('#' + this.id).offset();
            var pagerw = this.count(this.slides) * 14; // where 14 = margin-left + margin-right + width as defined in front-css.css of the ".pager-nav"'s rule.
            var pagerDivLeft = Math.round((w - pagerw) / 2);
            $("#" + this.id + '+ .cycle-pager').css(
                {
                    left:  pagerDivLeft,
                }
            );
            $('#' + this.id + ' .cnhk-slide img').each(function(){
                $(this).css({
                    width: w,
                    height: 'auto',
                });
            });
            $('#' +this.id + ' .cycle-prev').css({
                left: 0,
                top: (rh-48)/2,
            });
            $('#' +this.id + ' .cycle-next').css({
                left: (w-48) ,
                top: (rh-48)/2,
            });
            $('#' + this.id + ' .loading-image').css({
                left: (w-96)/2,
                top: (rh-11)/2,
            });
        }
        
        /**
        * Append slides into the container after delay
        * @param array Slides, an array of jQuery object
        */
        this.appendSlides = function(Slides)
        {
            for (var i in Slides) {
                var slide;
                if (cnhkOptions['transient']['noLink'] == cnhkOptions['slides'][i]['link']) {
                    slide = $('<div />').addClass('cnhk-slide').append(Slides[i].attr({
                        title : cnhkOptions['slides'][i]['title'],
                        alt : '',
                    }));
                } else {
                    slide = $('<a />').addClass('cnhk-slide').attr('href', cnhkOptions['slides'][i]['link']).append(Slides[i].attr({
                        title : cnhkOptions['slides'][i]['title'],
                        alt : '',
                    }));
                }
                if (cnhkOptions['transient']['noCaption'] != cnhkOptions['slides'][i]['caption']) {
                    slide.append($('<div />').addClass('slide-overlay').append($('<p />').addClass('inner-caption').html(cnhkOptions['slides'][i]['caption'])));
                }
                $('#' + this.id).append(slide);
            }
        }
        
        /**
        * Return the count of elements in an object (one level depth)
        * @param object obj
        */
        this.count = function(obj)
        {
            var count = 0;
            for (var i in obj) {
                count++;
            }
            return count;
        }
        
        /**
        * Init function
        */
        this.init = function() {
            var slidesInSS = cnhkOptions['slideshows'][this.slug]['slides'];
            for (var i in slidesInSS) {
                (function(ci){
                    instance.slides[slidesInSS[ci]] = $('<img />').attr('src', cnhkOptions['transient']['uploadUrl'] + cnhkOptions['slides'][slidesInSS[ci]]['src']).load(function(){
                        instance.loadedSlides.push(slidesInSS[ci]);
                        if (instance.loadedSlides.length == instance.count(slidesInSS)) {
                            if (0 != instance.delay) instance.delayedLaunch();
                        }
                    });
                })(i);
            }
            
            if (cnhkOptions['slideshows'][this.slug]['pager']) {
                this.options.pagerTemplate = '<span class="pager-nav"></span>';
                this.options.pagerActiveClass = 'active-pager';
                this.options.pager = '+ .cycle-pager'
            }
            
            if (0 == this.delay) {
                $('#' + this.id).cycle(this.options);
                this.resize()
                this.started = true;
            } else {
                this.loadingImage();
                if (0 < this.delay) {
                    this.timeOut = setTimeout(function(){
                        instance.delayedLaunch();
                    },(1000 * this.delay));
                }
            }
        }
        
    } // End cnhkSlideshow(identifier);
    
    // On DOM loaded
    $(function(){
        $('.cnhk-slideshow').each(function(){
            var id = $(this).attr('id');
            cnhkSsList[id] = new cnhkSlideshow(id);
            cnhkSsList[id].init();
            cnhkSsList[id].resize();
        });
        $(window).resize(function(){
            for (var id in cnhkSsList) {
                cnhkSsList[id].resize();
            }
        })
    });
    
})(jQuery);
