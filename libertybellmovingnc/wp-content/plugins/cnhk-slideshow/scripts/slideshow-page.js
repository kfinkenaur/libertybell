/**
*   Plugin Name: Cnhk Slideshow
*
*   Cnhk Slideshow plugin for WordPress, Copyright (C) 2013 Rija Rajaonah
*   Cnhk Slideshow plugin for WordPress is licensed under the GPL License version 3.
*   [http://www.gnu.org/licenses/gpl-3.0.html]
*/

;(function($){
    $(function(){
        var formUrl = $('#slideshow-form').attr('action');
        $('#select-field #target').change(function(){
            document.location.href = formUrl + '&target=' + $(this).val();
        });
        $('#select-ss').remove();
        $('#left-col').sortable(
            {
                connectWith : '#right-col',
                receive : function(ev, ui) {
                    ui.item.remove();
                },
                placeholder : 'slideIn-placeholder',
                forcePlaceholderSize : true,
                opacity : 0.4,
                stop : function(ev, ui) {
                    cnhkUpdateSlideOrder();
                }
            }
        );
        $('#right-col').sortable(
            {
                connectWith : '#left-col',
                receive : function(ev, ui) {
                    pos = parseInt(ui.item.attr('position'));
                    cnhkPlaceOriginal(pos, ui.item.clone());
                },
                placeholder : 'slideOff-placeholder',
                forcePlaceholderSize : true,
                opacity : 0.4,
                stop : function(ev, ui) {
                    cnhkUpdateSlideOrder();
                },
            }
        );
        $('#setting-field input[type="text"]').keypress(function(ev){
            code = ev.which || ev.keyCode;
            if ( 13 == code ) {
                $('#save-ss').trigger('click');
                return false;
            }
        });
    });
    
    function cnhkUpdateSlideOrder() {
        var order = [];
        $('#right-col li').each(function() {
            order.push($(this).attr('slug'));
        });
        $('#order').val(order.join('.'));
    }
    
    function cnhkPlaceOriginal(pos, obj) {
        var target = undefined;
        $('#left-col li').each(function() {
            var Li = $(this).attr('position');
            if (parseInt(Li) > pos && 'undefined' == typeof(target)) {
                target = Li;
            }
        });
        if ('undefined' == typeof(target)) {
            $('#left-col').append(obj.css('opacity', 0).animate({opacity: 1}, 1000));
        } else {
            $('#left-col li[position="' + target + '"]').before(obj.css('opacity', 0).animate({opacity: 1}, 1000));
        }
    }
    
})(jQuery);
