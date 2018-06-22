/************* Tab Sections *******************/
	
jQuery(document).ready(function($) {
	
	
    var inputs = 1; 

    jQuery('#btnAdd').click(function() {
	
        $('.btnDel:disabled').removeAttr('disabled');
        var c = $('.clonedInput:first').clone(true);
		var num= ++inputs;
		var d = "<div class=clonedInput style=margin-bottom:4px;><input type=button value=Delete class=btnDel><input type=\"text\"  value=\"\" name=\"dk_responsive[slider_image"+ (num) +"]\" class=\"upload\" id=\"slider_image"+ (num) +"\"><input type=\"button\" value=\"Upload\" class=\"upload-button\" id=\"upload-slider_image"+ (num) +"\"><div id=\"slider_image"+ (num) +"-image\" class=\"screenshot\"></div></div>";		  
        $('.clonedInput:last').after(d);
    });

    jQuery('.btnDel').click(function() {
        if (confirm('continue delete?')) {
            --inputs;
            $(this).closest('.clonedInput').remove();
            $('.btnDel').attr('disabled',($('.clonedInput').length  < 2));
        }
    });

    jQuery('.of-color').wpColorPicker();
	
	

	// Image Options
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});

	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();

	// Loads tabbed sections if they exist
	
	if ( jQuery('#dk-options-framework-wrap .nav-tab-wrapper').length > 0 ) {		
		dk_framework_tabs();
	}		

	function dk_framework_tabs() {	   

		var $group = jQuery('.group'),
			$navtabs = jQuery('#dk-options-framework-wrap .nav-tab-wrapper a'),
			active_tab = '';	
		

		// Hides all the .group sections to start
		$group.hide();    
			
		// Find if a selected tab is saved in localStorage
		if ( typeof(localStorage) != 'undefined' ) {
		active_tab = localStorage.getItem('active_tab_dk_responsive');			
		} 
	

		// If active tab is saved and exists, load it's .group
		if ( active_tab != '' && $(active_tab).length ) {
			$(active_tab).fadeIn();
			//alert(active_tab + '-tab')
			$(active_tab + '-tab').addClass('nav-tab-active');
		} else {
			$('.group:first').fadeIn();
			$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
		}

		// Bind tabs clicks
		$navtabs.click(function(e) {
			
           
			e.preventDefault();

			// Remove active class from all tabs
			$navtabs.removeClass('nav-tab-active');
			

			$(this).addClass('nav-tab-active').blur();

			if (typeof(localStorage) != 'undefined' ) {
				localStorage.setItem('active_tab_dk_responsive', $(this).attr('href') );
			}

			var selected = $(this).attr('href');

			$group.hide();
			$(selected).fadeIn();

		});
	}
	$(".rwd-container").hide();
	$("h3.rwd-toggle").click(function () {
		$(this).toggleClass("active").next().slideToggle("fast");
		return false; //Prevent the browser jump to the link anchor
	});
	/* $(".expand a").click(function () {	    
		//$(".rwd-container").slideToggle("fast");
		expand = false;
		
        jQuery('.rwd-toggle').each( function() {
            if( jQuery(this).hasClass('active') ) {
                $(this).toggleClass("active").next().slideToggle("fast");
            }
        });
		
		
	}); */
	
	jQuery('.expand').live( 'click', function(){
        expand = false;
        jQuery('.rwd-toggle').each( function() {
            if( jQuery(this).hasClass('active') ) {
                expand = true;
            }
        });
        jQuery('.rwd-toggle').each( function(){
            if ( expand ) {
                if( jQuery(this).hasClass('active') ) {
                    jQuery(this).trigger('click');
                }
            } else {
                if( !jQuery(this).hasClass('active') ) {
                    jQuery(this).trigger('click');
                }
            }
        });
        return false;
    } );
	/* Slider Row Add */
	$('#btnAdd').click(function() {
        $('.btnDel:disabled').removeAttr('disabled');
        var c = $('#section-home-slide1:first').clone(true);
            c.children(':text').attr('name','input'+ (++inputs) );
        $('#section-home-slide1:last').after(c);
    });

    $('.btnDel').click(function() {
        if (confirm('continue delete?')) {
            --inputs;
            $(this).closest('.clonedInput').remove();
            $('.btnDel').attr('disabled',($('.clonedInput').length  < 2));
        }
    });
	

});