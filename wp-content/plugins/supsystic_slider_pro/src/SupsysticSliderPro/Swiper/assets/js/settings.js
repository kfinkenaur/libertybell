(function ($) {

        // on change effect update displaed options
        $('input[name="general[effect]"]').change(function(e) {
            var effectName = $(this).val();
            displayEffectOptions(effectName);
        });

        // display saved options
        if($('input[name="general[effect]"]').val()) {
            displayEffectOptions($('input[name="general[effect]"]').val());
        }

        // select effect dialog init
        $preview = $('#previewEffectsWindow').dialog({
            modal:    true,
            width:    428,
            autoOpen: false,
            buttons:  {
                Select: function () {
                    $('#effectName').text(function () {
                        var text = $('.changeEffect')
                                .filter(':checked')
                                .val(),
                            f = text.charAt(0).toUpperCase();
                        return f + text.substr(1, text.length - 1);
                    });
                    $('[name="general[effect]"]').val($('.changeEffect').filter(':checked').val());
                    $('[name="general[effect]"]').trigger('change');
                    $(this).dialog('close');
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });

        // do display options
        function displayEffectOptions(effectName) {
            $('.effect-option').hide();
            $('.'+effectName+'-effect-option').show();
        }

        // show modal window
        $('#showSwiperEffectsPreview').on('click', $.proxy(function (e) {
            e.preventDefault();
            var currentEffect = $('[name="general[effect]"]').val();
            $('#previewEffectsWindow input[value="'+currentEffect+'"]').iCheck('check');
            $preview.dialog('open');
        }))
        // show advanced options window
        $('#swiper-options-advanced-switch').on('click',(function (e) {
            e.preventDefault();
            $(this).toggleClass( "switched" );
            $('.swiper-options-advanced').toggle("slow");
        }));

        $('[name="advanced[autostart]"]').click(function() {
            if($(this).val() == 'true'){
                $('tr#transition-speed').slideDown(500);
            } else {
                $('tr#transition-speed input[name="advanced[autoplay]"]').val('');
                $('tr#transition-speed').slideUp(500);
            }
        });

        $.each($('[name="advanced[autostart]"]'), function( index, value ) {
            if(value.hasAttribute('checked')) {
                $(value).iCheck('check');
            }
        });

    jQuery('[name="advanced[autostart]"]:checked').trigger('click');
    $('input#advanced-arrows-color').wpColorPicker({color:'#FFFFFF'});

}(jQuery));