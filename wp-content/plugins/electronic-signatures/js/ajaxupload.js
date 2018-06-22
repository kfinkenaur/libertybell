jQuery(document).ready(function() {
    jQuery(".swiftsign-upload-btn").click(function() {
        var uplId = jQuery(this).attr('data-attr');
        jQuery("#" + uplId).click();
    });

    // Add events
    jQuery('.swiftsign-file-upload').on('change', function(event) {
        var trgt = jQuery(this).parent().find('.swiftsign-upload-btn');
        var trgt_hidden = jQuery(this).attr('id') + "_hidden";
        jQuery(trgt).html("<p>" + event.target.value + " uploading...</p>");
        files = event.target.files;
        var data = new FormData();
        var error = 0;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!file.type.match('image.*|audio\/.*|video\/.*|application/pdf') && file.type !== 'application/msword' && file.type !== 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' && file.type !== 'application/vnd.ms-excel.sheet.macroEnabled.12' && file.type !== 'application/vnd.ms-excel' && file.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' && file.type !== 'text/plain' && file.type !== 'application/rtf' && file.type !== 'application/vnd.ms-powerpoint' && file.type !== 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
                jQuery(trgt).html("<p>Invalid file type. Select another file.</p>");
                error = 1;
            } else if (file.size > (1048576 * 50)) {
                jQuery(trgt).html("<p>Too large Payload. Select another file.</p>");
                error = 1;
            } else {
                data.append('image_' + i, file, file.name);
            }
        }
        if (!error) {
            var xhr = new XMLHttpRequest();
            data.append('action', 'ssFileUpload');
            xhr.open('POST', ssign_ajax_object.ajax_url, true);
            xhr.send(data);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var v = xhr.response;
                    if (typeof v == "string" && v !== "") {
                        try {
                            v = JSON.parse(v);
                        } catch (er) {
                            v = {"result": "failed", "msg": "A processing error occurred. Please refresh and try again."};
                        }
                    }
                    if (v["result"] == "success") {
                        jQuery(trgt).html("<p>File Uploaded.</p>");
                        jQuery("#" + trgt_hidden).val(v['msg']);
                        if (jQuery("#ss-id-webcam-results").length > 0) {
                            var file = files[0];
                            if (file.type.match('image.*')) {
                                jQuery("#ss-id-webcam-results").html('<img class="ss-ID-preview-img" src="' + v['msg'] + '"/>');
                            }
                        }
                    } else {
                        jQuery(trgt).html("<p>" + v['msg'] + "</p>");
                        jQuery(trgt_hidden).val('');
                    }
                } else {
                    jQuery(trgt).html("<p>Error in upload, try again.</p>");
                }
            };
        }
    });
    // File uploader function


});