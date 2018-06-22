jQuery(document).ready(function() {
    //checkbox
    jQuery(".swift_check").kalypto();

    //radio button
    jQuery(".swift_radio").kalypto({toggleClass: "toggleR"});

    // Required Field Validation
    jQuery(".checkValidation").click(function() {
        var ss_err = "";
        jQuery(".ss-err").remove();

        jQuery(".ss-required").each(function() {
            var thisField = jQuery.trim(jQuery(this).val());

            if (thisField == "") {
                if (jQuery(this).is('[type=checkbox]')) {
                    jQuery(this).after('<span class="ss-err" style="color:red;padding: 0 0 0 10px;">This ch field is required.</span>')
                    ss_err += 1;
                }
                if (jQuery(this).is('[type=text]')) {
                    jQuery(this).after('<span class="ss-err" style="color:red;padding: 0 0 0 10px;">This field is required.</span>')
                    ss_err += 1;
                }
                if (jQuery(this).is('[type=radio]')) {
                    jQuery(this).after('<span class="ss-err" style="color:red;padding: 0 0 0 10px;">This ra field is required.</span>')
                    ss_err += 1;
                }
                if (jQuery(this).is('select')) {
                    jQuery(this).after('<span class="ss-err" style="color:red;padding: 0 0 0 10px;">This ra field is required.</span>');
                    ss_err += 1;
                }

            }
        });

        if (signaturePad.isEmpty()) {
            alert("Please provide signature first.");
            return false;
        }

        if (ss_err === "") {
            jQuery("#ss_signDataURL").val(signaturePad.toDataURL());
        } else {
            jQuery("#sf_error").html("Fields are required");
            return false;
        }
    });

    jQuery(".ss-required").on("focus", function() {
        jQuery(this).removeClass('swift-required');
    });
});
