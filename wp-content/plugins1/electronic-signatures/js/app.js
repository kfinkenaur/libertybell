var wrapper = document.getElementById("signature-pad");
if (typeof wrapper !== 'undefined' && wrapper !== null) {
    var clearButton = wrapper.querySelector("[data-action=clear]"),
            saveButton = wrapper.querySelector("[data-action=save]"),
            canvas = wrapper.querySelector("canvas"),
            signaturePad;

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        //signaturePad.clear(); // otherwise isEmpty() might return incorrect value
    }

    window.onresize = resizeCanvas;
    resizeCanvas();

    signaturePad = new SignaturePad(canvas);

    jQuery("#ss_signClear").click(function() {
        signaturePad.clear();
        jQuery("#ss_signDataURL").val('');
    });
}


/* Initial pad */

var initials_wrapper = document.getElementById("initials-pad");
if (typeof initials_wrapper !== 'undefined' && initials_wrapper !== null) {
    var initials_clearButton = initials_wrapper.querySelector("[data-action=clear]"),
            initials_saveButton = initials_wrapper.querySelector("[data-action=save]"),
            initials_canvas = initials_wrapper.querySelector("canvas"),
            initials_signaturePad;

    function initials_resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        initials_canvas.width = initials_canvas.offsetWidth * ratio;
        initials_canvas.height = initials_canvas.offsetHeightHeight * ratio;
        initials_canvas.getContext("2d").scale(ratio, ratio);
    }

//window.onresize = initials_resizeCanvas;
//initials_resizeCanvas();

    initials_signaturePad = new SignaturePad(initials_canvas);

    jQuery("#ss_initials_signClear").click(function() {
        initials_signaturePad.clear();
        jQuery("#ss_initialsDataURL").val('');
    });
}