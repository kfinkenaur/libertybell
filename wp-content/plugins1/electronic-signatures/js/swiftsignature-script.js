jQuery(document).ready(function($) {
    /* set browserResolution */
    if (jQuery('#browserResolution').length > 0) {
        width = jQuery(window).width();
        height = jQuery(window).height();
        jQuery('#browserResolution').val(width + "x" + height + "px");
    }

    if (jQuery(".ssign_tooltip").length > 0) {
        jQuery(".ssign_tooltip").tooltip({
            tooltipClass: "swiftsign-tooltip",
            position: {
                my: "center top+8",
                at: "center bottom",
                using: function(position, feedback) {
                    jQuery(this).css(position);
                    jQuery("<div>")
                            .addClass("swiftsign-arrow")
                            .addClass(feedback.vertical)
                            .addClass(feedback.horizontal)
                            .appendTo(this);
                }
            }
        });
    }

    //circle word
    if (jQuery(document).find(".swift_cw_radio").length > 0) {
        jQuery(".swift_cw_radio").labelauty();
    }

    // Required Field Validation
    jQuery(document).on('click', '.checkValidation', function() {
        var ss_err = "";

        jQuery(".ss-err,.swiftsign-field-error").remove();
        jQuery("#sc_Frmswift").find(".swiftsign-input-error").removeClass('swiftsign-input-error');
        jQuery(".ss-required").each(function() {
            var thisField = jQuery.trim(jQuery(this).val());
            if (thisField == "") {
                if (jQuery(this).is('[type=text]')) {
                    jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
                    jQuery(this).addClass('swiftsign-input-error');
                    ss_err += 1;
                }
                if (jQuery(this).is('[type=number]')) {
                    jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
                    jQuery(this).addClass('swiftsign-input-error');
                    ss_err += 1;
                }
                if (jQuery(this).is('[type=email]')) {
                    jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
                    jQuery(this).addClass('swiftsign-input-error');
                    ss_err += 1;
                }
                if (jQuery(this).is('[type=url]')) {
                    jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
                    jQuery(this).addClass('swiftsign-input-error');
                    ss_err += 1;
                }
                if (jQuery(this).is('textarea')) {
                    jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
                    jQuery(this).addClass('swiftsign-input-error');
                    ss_err += 1;
                }
                if (jQuery(this).is('select')) {
                    jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
                    jQuery(this).addClass('swiftsign-input-error');
                    ss_err += 1;
                }
            } else {
                if (jQuery(this).is('[type=email]')) {
                    if (!ValidateEmail(jQuery(this).val())) {
                        jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">Invalid email address.</span>');
                        jQuery(this).addClass('swiftsign-input-error');
                        ss_err += 1;
                    }
                }
                if (jQuery(this).is('[type=URL]')) {
                    if (!validateUrl(jQuery(this).val())) {
                        jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">Invalid URL.</span>');
                        jQuery(this).addClass('swiftsign-input-error');
                        ss_err += 1;
                    }
                }
            }
        });

        // Circle button validation
        var cw_err = '';
        jQuery(".ss-cw-required").each(function() {
            if (!jQuery(this).find(".swift_cw_radio").is(":checked")) {
                cw_err += 1;
            }
        });
        if (cw_err !== '') {
            jQuery(".cw-wrap").append('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
            ss_err += 1;
        }

        // Radio button validation
        jQuery(".ss-radio-required").each(function() {
            if (!jQuery(this).find(".swift_radio").is(":checked")) {
                jQuery(this).append('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
                ss_err += 1;
            }
        });

        // Checkbox button validation
        jQuery(".ss-checkbox-required").each(function() {
            if (!jQuery(this).find(".swift_check").is(':checked')) {
                jQuery(this).append('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">This field is required.</span>');
                ss_err += 1;
            }
        });

        // Phone validation
        jQuery(".swift_phone_field").each(function() {
            if (jQuery(this).val() != "") {
                var phone = jQuery(this).val();
                var phone_test = /^\+?([0-9]{2})\)?([\-\. ])?(\(?\d{0,3}\))?([\-\. ])?\(?\d{0,3}\)?([\-\. ])?\d{3}([\-\. ])?\d{4}$/.test(phone);
                if (!phone_test) {
                    jQuery(this).after('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">Invalid phone number.</span>');
                    ss_err += 1;
                }
            }
        });

        // File upload validation
        jQuery(".ss-file-required").each(function() {
            if (jQuery(this).find('input:hidden').val() == '') {
                jQuery(this).append('<span class="ss-err swiftsign-field-error" style="color:red;padding: 0 0 0 10px;">Please select file.</span>');
                ss_err += 1;
            }
        });

        //multipal signature field
        jQuery(".ss-sign-dataurl").each(function() {
            if (jQuery(this).val() === "") {
                jQuery(this).parent().parent().addClass("swiftsign-signbox-error");
                jQuery(this).parent().parent().before("<span class='swiftsign-field swiftsign-field-error' style='color:red;padding: 0 0 0 10px;'>" + arrow_img + " Please sign below.</span>");
                ss_err += 1;
            } else {
                jQuery(this).parent().parent().removeClass("swiftsign-signbox-error");
            }
        });
        jQuery(".ss-initials-dataurl").each(function() {
            if (jQuery(this).val() === "") {
                jQuery(this).parent().parent().addClass("swiftsign-signbox-error");
                jQuery(this).parent().parent().before("<span class='swiftsign-field swiftsign-field-error ss-er$rand_id' style='color:red;padding: 0 0 0 10px;'>" + arrow_img + " Please sign below.</span>");
                ss_err += 1;
            } else {
                jQuery(this).parent().parent().removeClass("swiftsign-signbox-error");
            }
        });

        //form submit
        if (ss_err > 0) {
            if (jQuery('.swiftsign-field-error').length > 0) {
                offTop = jQuery('.swiftsign-field-error:first').offset().top - 50;
            } else if (jQuery('.m-signature-pad--body').length > 0) {
                offTop = jQuery('.m-signature-pad--body:first').offset().top - 50;
            } else {
                offTop = 100;
            }
            jQuery('html, body').animate({
                scrollTop: offTop
            }, 1000, function() {
                jQuery(".swiftsign-input-error").effect("shake");
            });
            return false;
        } else {
            jQuery("#swift_sign_submit").attr('disabled', 'disabled');
            jQuery("#swift_sign_submit").html('');
            jQuery("#swift_sign_submit").html('<i class="ssing-loader fa fa-spinner fa-pulse fa-lg fa-fw"></i> Sending...');

            /*
             * Local capture form data
             */
            var data = {
                'action': 'ssing_capture_form',
                'form_data': jQuery("#sc_Frmswift").serialize(),
                'page_id': jQuery("#sma_lead_page_id").val()
            };
            jQuery.post(ssign_ajax_object.ajax_url, data, function(response) {
                setTimeout(function() {
                    jQuery("#sc_Frmswift").submit();
                }, 1500);
            });
        }
    });

    jQuery(".ss-required").on("focus", function() {
        jQuery(this).removeClass('swift-required');
    });

    //on click display ifram in modal
    if (jQuery('#consentModal').length > 0) {
        var modal = jQuery('#consentModal');
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.css("display", "none");
            }
        };
        jQuery(".sc_consent_text a").on('click', function(e) {
            jQuery('#consentModal').css('display', 'block');
            jQuery('#consentModal .swiftsign-modal-content').css("top", ($(window).height() - jQuery('#consentModal .swiftsign-modal-content').height()) / 2 + "px");
            jQuery('#consentModal .swiftsign-modal-content').css("left", ($(window).width() - jQuery('#consentModal .swiftsign-modal-content').width()) / 2 + "px");
            e.preventDefault();
        });
        jQuery(".swiftsign-modal-close").on('click', function() {
            modal.css("display", "none");
        });
    }

    if (jQuery('#swiftsign-typing-modal').length > 0) {
        var fontModal = jQuery('#swiftsign-typing-modal');
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target === fontModal) {
                fontModal.css("display", "none");
            }
        }

        // popup for sign font
        jQuery(".sign-typing").on('click', function(e) {
            jQuery('#swiftsign-typing-modal').css('display', 'block');
            jQuery('#swiftsign-typing-modal .swiftsign-modal-content').css("top", ($(window).height() - jQuery('#swiftsign-typing-modal .swiftsign-modal-content').height()) / 2 + "px");
            jQuery('#swiftsign-typing-modal .swiftsign-modal-content').css("left", ($(window).width() - jQuery('#swiftsign-typing-modal .swiftsign-modal-content').width()) / 2 + "px");

            var boxType = jQuery(this).attr('data-boxtype');
            jQuery(".swiftsign-font-type").text('');
            if (boxType == 'initials') {
                jQuery("#ssing-typing-text").val(jQuery("#ssing-initials-val").val());
                jQuery("#swiftsign-typing-modal .swiftsign-font-submit").attr("id", "initials-font-submit");
                jQuery(".swiftsign-font-type").text(jQuery("#ssing-initials-val").val());
            } else if (boxType == 'sign') {
                jQuery("#ssing-typing-text").val(jQuery("#ssing-val").val());
                jQuery("#swiftsign-typing-modal .swiftsign-font-submit").attr("id", "swiftsign-font-submit");
                jQuery(".swiftsign-font-type").text(jQuery("#ssing-val").val());
            }
            jQuery("#ssing-counter").val(0);

            var padSize = jQuery(this).attr("data-pad-size");
            jQuery(".ssing-typing-text").after('<input class="ssing-pad-size" value="' + padSize + '" type="hidden">');

            e.preventDefault();
        });
        jQuery(".swiftsign-modal-close").on('click', function() {
            fontModal.css("display", "none");
        });
    }

    /*
     *  Sign font
     */
    jQuery(".sign-typing").on('click', function() {

    });

    jQuery("#ssing-typing-text").on('keyup', function() {
        var sign = jQuery(this).val();
        if (sign.length > 0) {
            jQuery(".swiftsign-font-type").html('');
            jQuery(".swiftsign-font-type").append(sign);
        }
    });

    jQuery(".swiftsign-font-type").on('click', function() {
        jQuery("#ssing-typing-text").removeClass("swiftsign-typing-text-error");
        jQuery(".type-modal-error").remove();
        jQuery(".swiftsign-typing-preview").find('.swiftsign-font-selected').removeClass('swiftsign-font-selected');
        jQuery(this).addClass('swiftsign-font-selected');
    });

    jQuery("#ssing-typing-text").on('focus', function() {
        jQuery("#ssing-typing-text").removeClass("swiftsign-typing-text-error");
        jQuery(".type-modal-error").remove();
    });

    /*var bootstrap_enabled = (typeof jQuery().modal == 'function');
     if (!bootstrap_enabled) {
     var script = document.createElement('script');
     script.type = 'text/javascript';
     script.src = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js';
     jQuery("head").append(script);
     }*/

    /*jQuery(".sign-typing").on("click", function() {
     var padSize = jQuery(this).attr("data-pad-size");
     jQuery(".ssing-typing-text").after('<input class="ssing-pad-size" value="' + padSize + '" type="hidden">');
     });*/

    jQuery('#swiftsign-typing-modal').on('shown.bs.modal', function() {
        var name_val = jQuery.trim(jQuery("#name").val());
        if (name_val.length > 0) {
            jQuery("#ssing-typing-text").val(name_val);
            jQuery(".swiftsign-font-type").text(name_val);
        }
    });

    // auto fill extra swift name with main name field
    if (jQuery(".ss-swiftname").length > 0) {
        jQuery(document).on("keyup, blur", ".ss-swiftname", function() {
            var sign_text = jQuery.trim(jQuery(this).val());
            jQuery(".ss-swiftname-extra").val(sign_text);

            if (sign_text.length > 0) {
                var data = {
                    'action': 'ssign_capture_log',
                    'ssign_name': sign_text
                };
                jQuery.post(ssign_ajax_object.ajax_url, data, function(response) {
                });
            }
        });
    }

    // swiftsign full screen
    jQuery(document).on('click', '#submitBtn', function() {
        jQuery("#swift_sign_submit").trigger('click');
    });

    jQuery(".swiftsign-fullscreen-container").height(jQuery(window).outerHeight());
});
//Email validation
function ValidateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return (true);
    }
    return (false);
}
// URL validation
function validateUrl(value) {
    return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
}


function setTypeTextCookie(textboxVal, type) {
    var data = {
        'action': 'set_typing_text_cookie',
        'textboxVal': textboxVal,
        'type': type
    };
    jQuery.post(ssign_ajax_object.ajax_url, data, function(response) {
    });
}