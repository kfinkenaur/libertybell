 jQuery(function(){

    jQuery(".main-navigation ul li a").hover(function(){
        jQuery('ul:first',this).css('visibility', 'visible');
        jQuery('.sub-menu .fa-angle-down').css('display', 'none');
    }, function(){
        jQuery('ul:first',this).css('visibility', 'hidden');
    });
    
    jQuery(".main-navigation ul li ul li:has(ul)").find("a:first").append(" &raquo; ");
jQuery(".main-navigation ul li ul").prev().addClass('has-sub');
jQuery('.has-sub').append('<i class="fa fa-angle-down"></i>');
});
(function($, window, document, undefined) {
        'use strict';
        // undefined is used here as the undefined global variable in ECMAScript 3 is
        // mutable (ie. it can be hasMoved by someone else). undefined isn't really being
        // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
        // can no longer be modified.

        // window and document are passed through as local variable rather than global
        // as this (slightly) quickens the resolution process and can be more efficiently
        // minified (especially when both are regularly referenced in your plugin).

        // Create the defaults once
        var pluginName = 'newsTicker',
                defaults = {
                        row_height: 20,
                        max_rows: 3,
                        speed: 400,
                        duration: 2500,
                        direction: 'up',
                        autostart: 1,
                        pauseOnHover: 1,
                        nextButton: null,
                        prevButton: null,
                        startButton: null,
                        stopButton: null,
                        hasMoved: function() {},
                        movingUp: function() {},
                        movingDown: function() {},
                        start: function() {},
                        stop: function() {},
                        pause: function() {},
                        unpause: function() {}
                };

        // The actual plugin constructor
        function Plugin(element, options) {
                this.element = element;
                this.$el = $(element);
                this.options = $.extend({}, defaults, options);
                this._defaults = defaults;
                this._name = pluginName;
                this.moveInterval;
                this.state = 0;
                this.paused = 0;
                this.moving = 0;
                if (this.$el.is('ul')) {
                        this.init();
                }
        }

        Plugin.prototype = {
                init: function() {
                        this.$el.height(this.options.row_height * this.options.max_rows)
                                .css({overflow : 'hidden'});

                        this.checkSpeed();

                        if(this.options.nextButton && typeof(this.options.nextButton[0]) !== 'undefined')
                                this.options.nextButton.click(function(e) {
                                        this.moveNext();
                                        this.resetInterval();
                                }.bind(this));
                        if(this.options.prevButton && typeof(this.options.prevButton[0]) !== 'undefined')
                                this.options.prevButton.click(function(e) {
                                        this.movePrev();
                                        this.resetInterval();
                                }.bind(this));
                        if(this.options.stopButton && typeof(this.options.stopButton[0]) !== 'undefined')
                                this.options.stopButton.click(function(e) {
                                        this.stop()
                                }.bind(this));
                        if(this.options.startButton && typeof(this.options.startButton[0]) !== 'undefined')
                                this.options.startButton.click(function(e) {
                                        this.start()
                                }.bind(this));
                        
                        if(this.options.pauseOnHover) {
                                this.$el.hover(function() {
                                        if (this.state)
                                                this.pause();
                                }.bind(this), function() {
                                        if (this.state)
                                                this.unpause();
                                }.bind(this));
                        }

                        if(this.options.autostart)
                                this.start();
                },

                start: function() {
                        if (!this.state) {
                                this.state = 1;
                                this.resetInterval();
                                this.options.start();
                        }
                },

                stop: function() {
                        if (this.state) {
                                clearInterval(this.moveInterval);
                                this.state = 0;
                                this.options.stop();
                        }
                },

                resetInterval: function() {
                        if (this.state) {
                                clearInterval(this.moveInterval);
                                this.moveInterval = setInterval(function() {this.move()}.bind(this), this.options.duration);
                        }
                },

                move: function() {
                         if (!this.paused) this.moveNext();
                },

                moveNext: function() {
                        if (this.options.direction === 'down')
                                this.moveDown();
                        else if (this.options.direction === 'up')
                                this.moveUp();
                },

                movePrev: function() {
                        if (this.options.direction === 'down')
                                this.moveUp();
                        else if (this.options.direction === 'up')
                                this.moveDown();
                },

                pause: function() {
                        if (!this.paused) this.paused = 1;
                        this.options.pause();
                },

                unpause: function() {
                        if (this.paused) this.paused = 0;
                        this.options.unpause();
                },

                moveDown: function() {
                        if (!this.moving) {
                                this.moving = 1;
                                this.options.movingDown();
                                this.$el.children('li:last').detach().prependTo(this.$el).css('marginTop', '-' + this.options.row_height + 'px')
                                        .animate({marginTop: '0px'}, this.options.speed, function(){
                                                this.moving = 0;
                                                this.options.hasMoved();
                                        }.bind(this));
                        }
                },

                moveUp: function() {
                        if (!this.moving) {
                                this.moving = 1;
                                this.options.movingUp();
                                var element = this.$el.children('li:first');
                                element.animate({marginTop: '-' + this.options.row_height + 'px'}, this.options.speed,
                                        function(){
                                                element.detach().css('marginTop', '0').appendTo(this.$el);
                                                this.moving = 0;
                                                this.options.hasMoved();
                                        }.bind(this));
                        }
                },

                updateOption: function(option, value) {
                        if (typeof(this.options[option]) !== 'undefined'){
                                this.options[option] = value;
                                if (option == 'duration' || option == 'speed'){
                                    this.checkSpeed();
                                    this.resetInterval();
                                }
                        }
                },

                getState: function() {
                        if (paused) return 2
                        else return this.state;//0 = stopped, 1 = started
                },

                checkSpeed: function() {
                        if (this.options.duration < (this.options.speed + 25))
                                this.options.speed = this.options.duration - 25;
                },

                destroy: function() {
                        this._destroy(); //or this.delete; depends on jQuery version
                }
        };

        // A really lightweight plugin wrapper around the constructor,
        // preventing against multiple instantiations
        $.fn[pluginName] = function(option) {
                var args = arguments;
                
                return this.each(function() {
                        var $this = $(this),
                                data = $.data(this, 'plugin_' + pluginName),
                                options = typeof option === 'object' && option;
                        if (!data) {
                                $this.data('plugin_' + pluginName, (data = new Plugin(this, options)));
                        }
                        // if first argument is a string, call silimarly named function
                        // this gives flexibility to call functions of the plugin e.g.
                        //   - $('.dial').plugin('destroy');
                        //   - $('.dial').plugin('render', $('.new-child'));
                        if (typeof option === 'string') {
                                data[option].apply(data, Array.prototype.slice.call(args, 1));
                        }
                });
        };
})(jQuery, window, document);

/*
 * Basic jQuery Slider plug-in v.1.3
 *
 * http://www.basic-slider.com
 *
 * Authored by John Cobb
 * http://www.johncobb.name
 * @john0514
 *
 * Copyright 2011, John Cobb
 * License: GNU General Public License, version 3 (GPL-3.0)
 * http://www.opensource.org/licenses/gpl-3.0.html
 *
 */(function(e){"use strict";e.fn.bjqs=function(t){var n={width:700,height:300,animtype:"fade",animduration:450,animspeed:4e3,automatic:!0,showcontrols:!0,centercontrols:!0,nexttext:"Next",prevtext:"Prev",showmarkers:!0,centermarkers:!0,keyboardnav:!0,hoverpause:!0,usecaptions:!0,randomstart:!1,responsive:!1},r=e.extend({},n,t),i=this,s=i.find("ul.bjqs"),o=s.children("li"),u=null,a=null,f=null,l=null,c=null,h=null,p=null,d=null,v={slidecount:o.length,animating:!1,paused:!1,currentslide:1,nextslide:0,currentindex:0,nextindex:0,interval:null},m={width:null,height:null,ratio:null},g={fwd:"forward",prev:"previous"},y=function(){o.addClass("bjqs-slide");r.responsive?b():E();if(v.slidecount>1){r.randomstart&&L();r.showcontrols&&x();r.showmarkers&&T();r.keyboardnav&&N();r.hoverpause&&r.automatic&&C();r.animtype==="slide"&&S()}r.usecaptions&&k();if(r.animtype==="slide"&&!r.randomstart){v.currentindex=1;v.currentslide=2}s.show();o.eq(v.currentindex).show();r.automatic&&(v.interval=setInterval(function(){O(g.fwd,!1)},r.animspeed))},b=function(){m.width=i.outerWidth();m.ratio=m.width/r.width,m.height=r.height*m.ratio;if(r.animtype==="fade"){o.css({height:r.height,width:"100%"});o.children("img").css({height:r.height,width:"100%"});s.css({height:r.height,width:"100%"});i.css({height:r.height,"max-width":r.width,position:"relative"});if(m.width<r.width){o.css({height:m.height});o.children("img").css({height:m.height});s.css({height:m.height});i.css({height:m.height})}e(window).resize(function(){m.width=i.outerWidth();m.ratio=m.width/r.width,m.height=r.height*m.ratio;o.css({height:m.height});o.children("img").css({height:m.height});s.css({height:m.height});i.css({height:m.height})})}if(r.animtype==="slide"){o.css({height:r.height,width:r.width});o.children("img").css({height:r.height,width:r.width});s.css({height:r.height,width:r.width*r.slidecount});i.css({height:r.height,"max-width":r.width,position:"relative"});if(m.width<r.width){o.css({height:m.height});o.children("img").css({height:m.height});s.css({height:m.height});i.css({height:m.height})}e(window).resize(function(){m.width=i.outerWidth(),m.ratio=m.width/r.width,m.height=r.height*m.ratio;o.css({height:m.height,width:m.width});o.children("img").css({height:m.height,width:m.width});s.css({height:m.height,width:m.width*r.slidecount});i.css({height:m.height});h.css({height:m.height,width:m.width});w(function(){O(!1,v.currentslide)},200,"some unique string")})}},w=function(){var e={};return function(t,n,r){r||(r="Don't call this twice without a uniqueId");e[r]&&clearTimeout(e[r]);e[r]=setTimeout(t,n)}}(),E=function(){o.css({height:r.height,width:r.width});s.css({height:r.height,width:r.width});i.css({height:r.height,width:r.width,position:"relative"})},S=function(){p=o.eq(0).clone();d=o.eq(v.slidecount-1).clone();p.attr({"data-clone":"last","data-slide":0}).appendTo(s).show();d.attr({"data-clone":"first","data-slide":0}).prependTo(s).show();o=s.children("li");v.slidecount=o.length;h=e('<div class="bjqs-wrapper"></div>');if(r.responsive&&m.width<r.width){h.css({width:m.width,height:m.height,overflow:"hidden",position:"relative"});s.css({width:m.width*(v.slidecount+2),left:-m.width*v.currentslide})}else{h.css({width:r.width,height:r.height,overflow:"hidden",position:"relative"});s.css({width:r.width*(v.slidecount+2),left:-r.width*v.currentslide})}o.css({"float":"left",position:"relative",display:"list-item"});h.prependTo(i);s.appendTo(h)},x=function(){u=e('<ul class="bjqs-controls"></ul>');a=e('<li class="bjqs-next"><a href="#" data-direction="'+g.fwd+'">'+r.nexttext+"</a></li>");f=e('<li class="bjqs-prev"><a href="#" data-direction="'+g.prev+'">'+r.prevtext+"</a></li>");u.on("click","a",function(t){t.preventDefault();var n=e(this).attr("data-direction");if(!v.animating){n===g.fwd&&O(g.fwd,!1);n===g.prev&&O(g.prev,!1)}});f.appendTo(u);a.appendTo(u);u.appendTo(i);if(r.centercontrols){u.addClass("v-centered");var t=(i.height()-a.children("a").outerHeight())/2,n=t/r.height*100,s=n+"%";a.find("a").css("top",s);f.find("a").css("top",s)}},T=function(){l=e('<ol class="bjqs-markers"></ol>');e.each(o,function(t,n){var i=t+1,s=t+1;r.animtype==="slide"&&(s=t+2);var o=e('<li><a href="#">'+i+"</a></li>");i===v.currentslide&&o.addClass("active-marker");o.on("click","a",function(e){e.preventDefault();!v.animating&&v.currentslide!==s&&O(!1,s)});o.appendTo(l)});l.appendTo(i);c=l.find("li");if(r.centermarkers){l.addClass("h-centered");var t=(r.width-l.width())/2;l.css("left",t)}},N=function(){e(document).keyup(function(e){if(!v.paused){clearInterval(v.interval);v.paused=!0}if(!v.animating)if(e.keyCode===39){e.preventDefault();O(g.fwd,!1)}else if(e.keyCode===37){e.preventDefault();O(g.prev,!1)}if(v.paused&&r.automatic){v.interval=setInterval(function(){O(g.fwd)},r.animspeed);v.paused=!1}})},C=function(){i.hover(function(){if(!v.paused){clearInterval(v.interval);v.paused=!0}},function(){if(v.paused){v.interval=setInterval(function(){O(g.fwd,!1)},r.animspeed);v.paused=!1}})},k=function(){e.each(o,function(t,n){var r=e(n).children("img:first-child").attr("title");r||(r=e(n).children("a").find("img:first-child").attr("title"));if(r){r=e('<p class="bjqs-caption">'+r+"</p>");r.appendTo(e(n))}})},L=function(){var e=Math.floor(Math.random()*v.slidecount)+1;v.currentslide=e;v.currentindex=e-1},A=function(e){if(e===g.fwd)if(o.eq(v.currentindex).next().length){v.nextindex=v.currentindex+1;v.nextslide=v.currentslide+1}else{v.nextindex=0;v.nextslide=1}else if(o.eq(v.currentindex).prev().length){v.nextindex=v.currentindex-1;v.nextslide=v.currentslide-1}else{v.nextindex=v.slidecount-1;v.nextslide=v.slidecount}},O=function(e,t){if(!v.animating){v.animating=!0;if(t){v.nextslide=t;v.nextindex=t-1}else A(e);if(r.animtype==="fade"){if(r.showmarkers){c.removeClass("active-marker");c.eq(v.nextindex).addClass("active-marker")}o.eq(v.currentindex).fadeOut(r.animduration);o.eq(v.nextindex).fadeIn(r.animduration,function(){v.animating=!1;v.currentslide=v.nextslide;v.currentindex=v.nextindex})}if(r.animtype==="slide"){if(r.showmarkers){var n=v.nextindex-1;n===v.slidecount-2?n=0:n===-1&&(n=v.slidecount-3);c.removeClass("active-marker");c.eq(n).addClass("active-marker")}r.responsive&&m.width<r.width?v.slidewidth=m.width:v.slidewidth=r.width;s.animate({left:-v.nextindex*v.slidewidth},r.animduration,function(){v.currentslide=v.nextslide;v.currentindex=v.nextindex;if(o.eq(v.currentindex).attr("data-clone")==="last"){s.css({left:-v.slidewidth});v.currentslide=2;v.currentindex=1}else if(o.eq(v.currentindex).attr("data-clone")==="first"){s.css({left:-v.slidewidth*(v.slidecount-2)});v.currentslide=v.slidecount-1;v.currentindex=v.slidecount-2}v.animating=!1})}}};y()}})(jQuery);

/*! tinycarousel - v2.1.8 - 2015-02-22
 * https://baijs.com/tinycarousel
 *
 * Copyright (c) 2015 Maarten Baijs <wieringen@gmail.com>;
 * Licensed under the MIT license */

!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){function b(b,e){function f(){return i.update(),i.move(i.slideCurrent),g(),i}function g(){i.options.buttons&&(n.click(function(){return i.move(--t),!1}),m.click(function(){return i.move(++t),!1})),a(window).resize(i.update),i.options.bullets&&b.on("click",".bullet",function(){return i.move(t=+a(this).attr("data-slide")),!1})}function h(){i.options.buttons&&!i.options.infinite&&(n.toggleClass("disable",i.slideCurrent<=0),m.toggleClass("disable",i.slideCurrent>=i.slidesTotal-r)),i.options.bullets&&(o.removeClass("active"),a(o[i.slideCurrent]).addClass("active"))}this.options=a.extend({},d,e),this._defaults=d,this._name=c;var i=this,j=b.find(".viewport:first"),k=b.find(".overview:first"),l=null,m=b.find(".next:first"),n=b.find(".prev:first"),o=b.find(".bullet"),p=0,q={},r=0,s=0,t=0,u="x"===this.options.axis,v=u?"Width":"Height",w=u?"left":"top",x=null;return this.slideCurrent=0,this.slidesTotal=0,this.intervalActive=!1,this.update=function(){return k.find(".mirrored").remove(),l=k.children(),p=j[0]["offset"+v],s=l.first()["outer"+v](!0),i.slidesTotal=l.length,i.slideCurrent=i.options.start||0,r=Math.ceil(p/s),k.append(l.slice(0,r).clone().addClass("mirrored")),k.css(v.toLowerCase(),s*(i.slidesTotal+r)),h(),i},this.start=function(){return i.options.interval&&(clearTimeout(x),i.intervalActive=!0,x=setTimeout(function(){i.move(++t)},i.options.intervalTime)),i},this.stop=function(){return clearTimeout(x),i.intervalActive=!1,i},this.move=function(a){return t=isNaN(a)?i.slideCurrent:a,i.slideCurrent=t%i.slidesTotal,0>t&&(i.slideCurrent=t=i.slidesTotal-1,k.css(w,-i.slidesTotal*s)),t>i.slidesTotal&&(i.slideCurrent=t=1,k.css(w,0)),q[w]=-t*s,k.animate(q,{queue:!1,duration:i.options.animation?i.options.animationTime:0,always:function(){b.trigger("move",[l[i.slideCurrent],i.slideCurrent])}}),h(),i.start(),i},f()}var c="tinycarousel",d={start:0,axis:"x",buttons:!0,bullets:!1,interval:!1,intervalTime:3e3,animation:!0,animationTime:1e3,infinite:!0};a.fn[c]=function(d){return this.each(function(){a.data(this,"plugin_"+c)||a.data(this,"plugin_"+c,new b(a(this),d))})}});

/* 
TinyNav
*/
(function(a,i,g){a.fn.tinyNav=function(j){var b=a.extend({active:"selected",header:"",label:""},j);return this.each(function(){g++;var h=a(this),d="tinynav"+g,f=".l_"+d,e=a("<select/>").attr("id",d).addClass("tinynav "+d);if(h.is("ul,ol")){""!==b.header&&e.append(a("<option/>").text(b.header));var c="";h.addClass("l_"+d).find("a").each(function(){c+='<option value="'+a(this).attr("href")+'">';var b;for(b=0;b<a(this).parents("ul, ol").length-1;b++)c+="- ";c+=a(this).text()+"</option>"});e.append(c);
b.header||e.find(":eq("+a(f+" li").index(a(f+" li."+b.active))+")").attr("selected",!0);e.change(function(){i.location.href=a(this).val()});a(f).after(e);b.label&&e.before(a("<label/>").attr("for",d).addClass("tinynav_label "+d+"_label").append(b.label))}})}})(jQuery,this,0);
/*
Functions By DragThemes
*/
jQuery(document).ready(function(){
jQuery(".searchboxcontainer").click(function(){
        jQuery(".srchcontainer").toggle();
    });
jQuery('.newsticker').newsTicker({
    row_height: 24,
    max_rows: 1,
    speed: 600,
    direction: 'up',
    duration: 4000,
    autostart: 1,
    pauseOnHover: 0
});
    jQuery('#cat-slider').bjqs({
        'height' : 400,
        'width' : 740,
        'responsive' : true,
        showmarkers : false,
        animtype : 'slide',
        nexttext : '<i class="fa fa-angle-right"></i>', 
        prevtext : '<i class="fa fa-angle-left"></i>', 

});
jQuery('#carouselpost').tinycarousel({interval: true });
if (jQuery('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = jQuery(window).scrollTop();
        };
    backToTop();
    jQuery(window).on('scroll', function () {
        backToTop();
    });
    jQuery('#back-to-top').on('click', function (e) {
        e.preventDefault();
        jQuery('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}

jQuery(".main-navigation ul").tinyNav({
  header: '≡ Navigation',
});
jQuery(".secondary-navigation ul").tinyNav({
  header: '≡ Navigation',
});
jQuery(".globetoogle").click(function(){
jQuery(".drag-social-button").toggle();
});
var secnavwidth = jQuery("#bottom-navigation").width();

if(secnavwidth > 700){
     jQuery("#bottom-navigation").css('float', 'left');
}
});
