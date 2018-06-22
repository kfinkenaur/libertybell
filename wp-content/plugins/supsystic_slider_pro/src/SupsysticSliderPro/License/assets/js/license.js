(function($, WordPress) {

    var Controller = function() {
        this.$form = $('.license-form');
    };

    Controller.prototype.isNotEmpty = function(email, key) {
        return email && key;
    };

    Controller.prototype.submitForm = (function (e) {
        var email = $('[name="license[email]"]').val(),
            key = $('[name="license[key]"]').val();
        if(!this.isNotEmpty(email, key)) {
            $.jGrowl('Empty email or key, please fill all fields with valid values');
            return;
        }
        $.post(WordPress.ajax.settings.url,
            {
                mail: email,
                key: key,
                action: 'supsystic-slider',
                route: {
                    module: 'license',
                    action: 'activate'
                }
            })
            .success(function (response) {
                if(response.status) {
                    $.jGrowl('License was successfully activated');
                    window.location.reload(true);
                } else {
					var error = '';
					if(response && response.errors && response.errors.length) {
						error = response.errors.join("\n");
					} else {
						error = 'Wrong email or licese key';
					}
                    $.jGrowl( error );
                }
            });
    });

    $(document).ready(function() {
        var controller = new Controller();

        $('#send-license').on('click', function(e) {controller.submitForm(e)});
    });
})(jQuery, window.wp = window.wp || {});