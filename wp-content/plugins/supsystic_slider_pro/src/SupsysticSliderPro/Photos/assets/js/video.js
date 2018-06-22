/*global jQuery*/
(function ($, WordPress, undefined) {
    $(document).ready(function () {

        var $uploadBtn = $('#uploadVideo'),
            $form = $('#uploadVideoForm'),
            $formError = $('#uploadVideoFormError'),
            $window = $('#uploadVideoModal'),
            $container = $('[data-container]');

        function showError(error) {
            $formError.text(error);
        }

        function reloadImages() {
            $('.ready-lazy').lazyload();
        }

        function clearErrors() {
            $formError.text(' ');
        }

        function validate(value) {
            var regex = /^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/;
			var sliderType = $('#changePlugin input[type="radio"][name="plugin"]:checked').val();

            if (value == undefined || value.length < 1) {
				showError($('#sggMsgYouMustEnterURL').val());
                return false;
            }

            if(!regex.test(value)) {
				// check url for vimeo data
				if(sliderType == "bx") {
					var $vimeoPattern = '(https?:\/\/)?(www.)?(player.)?vimeo.com/([a-z]*/)*([0-9]{6,11})[?]?.*'
					,	regEx = new RegExp($vimeoPattern, 'ui')
					,	reRes = regEx.exec(value);

					if(reRes && reRes.length && reRes[5]) {
					} else {
						showError($('#sggMsgYouMustEnterYoutubeOrVimeoUrl').val());
						return false;
					}
				} else {
					showError($('#sggMsgYouMustEnterOnlyYoutubeUrl').val());
					return false;
				}
            }

            return true;
        }

        function Controller() {
            this.init();
        }

        Controller.prototype.init = (function () {
            if($window && $window.dialog) {
                $window.dialog({
                    width:    550,
                    autoOpen: false,
                    modal:    true
                    /*buttons:  {
                     Import: function () {
                     var url = $form.find('[name="url"]').val();

                     if (!validate(url)) {
                     return;
                     }

                     $.post(
                     WordPress.ajax.settings.url,
                     {
                     action: 'supsystic-slider',
                     route: {
                     module: 'photos',
                     action: 'importVideo'
                     },
                     url: url,
                     id: $uploadBtn.data('slider-id')
                     },
                     function (response) {
                     if (response.error) {
                     showError(response.message);

                     return false;
                     }

                     // Clear validation errors.
                     clearErrors();

                     // Append video html and close modal.
                     $container.append(response.html);
                     $window.dialog('close');

                     // Reinitialize lazy loading.
                     reloadImages();

                     window.location.reload(true);

                     return true;
                     }
                     );
                     },
                     Close:  function () {
                     $window.dialog('close');
                     }
                     }*/
                });
            }

            jQuery('#uploadVideoModal_importBtn').click(function() {
                var url = $form.find('[name="url"]').val();

                if (!validate(url)) {
                    return;
                }

                $.post(
                    WordPress.ajax.settings.url,
                    {
                        action: 'supsystic-slider',
                        route: {
                            module: 'photos',
                            action: 'importVideo'
                        },
                        url: url,
                        id: $uploadBtn.data('slider-id')
                    },
                    function (response) {
                        if (response.error) {
                            showError(response.message);

                            return false;
                        }

                        // Clear validation errors.
                        clearErrors();

                        // Append video html and close modal.
                        $container.append(response.html);
                        $window.dialog('close');

                        // Reinitialize lazy loading.
                        reloadImages();

                        window.location.reload(true);

                        return true;
                    }
                );
            });

            jQuery('#uploadVideoModal_closeBtn').click(function() {
                $window.dialog('close');
            });

            $uploadBtn.on('click', function () {
                $window.dialog('open');
            });
        });

        return new Controller();
    });
}(jQuery, window.wp = window.wp || {}));