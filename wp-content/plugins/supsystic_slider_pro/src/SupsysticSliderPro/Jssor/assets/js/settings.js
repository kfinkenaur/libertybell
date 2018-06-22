(function ($) {

    function Controller() {
        this.$arrowsDialog = $('#selectArrowsDialog');
        this.$bulletDialog = $('#selectBulletDialog');
        this.$shadowDialog = $('#selectShadowDialog');
        this.$captionPositionDialog = $('#selectCaptionPositionDialog');
        this.$captionSettigsDialog = $('.jssor-caption-settings-editor');
        this.$captionPosition = $('#captionPosition');
		this.$captions = $('input[name="general[captions]"]');
        this.$bullets = $('#bulletType');
        this.$mode = $('#generalMode');

        this.init();
    }

    Controller.prototype.init = (function () {
        this.initArrowsDialog();
        this.initBulletDialog();
        this.initShadowSelection();
        this.bulletTrigger();
		this.captionsTrigger();
        this.thumbTrigger();
        this.initImageSelect();
        this.toggleCarousel();
        this.toggleCaption();
        this.initCaptionPositionDialog();
        this.initCaptionSettingsDialog();
        this.initCaptionSettings();
        this.initSizeSettings();
        this.notification = function(message) {
            var notification = noty({
                layout: 'topCenter',
                type: 'warning',
                text : message,
                timeout: 2000,
                animation: {
                    open: 'animated flipInX',
                    close: 'animated flipOutX',
                    easing: 'swing',
                    speed: '800'
                }
            });
        };
        this.hexToRgb = function(hex, opacity) {
            var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
            hex = hex.replace(shorthandRegex, function(m, r, g, b) {
                return r + r + g + g + b + b;
            });

            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? 'rgba('
                + parseInt(result[1], 16) + ', '
                + parseInt(result[2], 16) + ', '
                + parseInt(result[3], 16) + ', '
                + (opacity ? opacity : 0)
            + ')' : null;
        };
    });

    Controller.prototype.initArrowsDialog = (function () {
        this.$arrowsDialog.dialog({
            autoOpen: false,
            modal:    true,
            height:   600,
            width:    450,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });

        $('#select-arrow').on('click', function (e) {
            e.preventDefault();
            var selectedArrow = $('img#arrowImg[data-selected="selected"]');
            if(selectedArrow) {
                selectedArrow.parent().css('border-bottom', '1px solid aqua');
            }
            $('#selectArrowsDialog').dialog('open');
        });

        $('div#arrowImg').each(function() {
            $(this).on('mouseenter', function() {
                if($(this).find('img').data('selected') != 'selected') {
                    var props = {
                        'cursor': 'pointer',
                        'border-bottom': '1px solid aqua'
                    };
                    $(this).css(props);
                }
            });
            $(this).on('mouseleave', function() {
                if($(this).find('img').data('selected') != 'selected') {
                    $(this).css('border-bottom', '1px solid gray');
                }
            });
        });

        var self = this;

        this.$arrowsDialog.find('img').on('click', function () {
            $('#arrowType').attr('value', $(this).data('value'));
            self.$arrowsDialog.dialog('close');
        });
    });

    Controller.prototype.initBulletDialog = (function () {
        this.$bulletDialog.dialog({
            autoOpen: false,
            modal:    true,
            height:   600,
            width:    180,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });

        $('#select-bullet').on('click', function (e) {
            e.preventDefault();
            var selectedBullet = $('img#bulletImg[data-selected="selected"]');
            if(selectedBullet) {
                selectedBullet.parent().css('border-bottom', '1px solid aqua');
            }
            $('#selectBulletDialog').dialog('open');
        });

        $('div#bulletImg').each(function() {
            $(this).on('mouseenter', function() {
                if($(this).find('img').data('selected') != 'selected') {
                    var props = {
                        'cursor': 'pointer',
                        'border-bottom': '1px solid aqua'
                    };
                    $(this).css(props);
                }
            });
            $(this).on('mouseleave', function() {
                if($(this).find('img').data('selected') != 'selected') {
                    $(this).css('border-bottom', '1px solid gray');
                }
            });
        });

        var self = this;

        this.$bulletDialog.find('img').on('click', function () {
            $('#bulletType').attr('value', $(this).data('value')).trigger('change');
            self.$bulletDialog.dialog('close');
        });
    });

    Controller.prototype.initShadowSelection = (function () {
        var self = this;

        this.$shadowDialog.find('img').on('click', function () {
            $('#propertiesShadow').attr('value', $(this).data('value'));
            self.$shadowDialog.dialog('close');
        });
    });

    Controller.prototype.bulletTrigger = (function() {
        var $thumbTrue = $('#effectsThumbsTrue'),
            $thumbFalse = $('#effectsThumbsFalse'),
			$thumbOpts = $('tr#effectsThumbsType'),
            self = this;

        this.$bullets.on('change', function() {
            if($(this).val() != 'disable') {
                if ($('[name="effects[thumbnails][enable]"]:checked').val() == "true") {
                    $thumbFalse.attr('checked', 'checked').trigger('change');
                    $('[name="effects[thumbnails][enable]"]').iCheck('update');
                    self.notification('<h3>Notice</h3>Thumbnails navigation is disabled now');
					$thumbOpts.hide();
                }
            }
        });
    });

	Controller.prototype.captionsTrigger = (function() {
		var $thumbTrue = $('#effectsThumbsTrue'),
			$thumbFalse = $('#effectsThumbsFalse'),
			$thumbOpts = $('tr#effectsThumbsType'),
			self = this;

		this.$captions.on('change', function() {
			if($('[name="general[captions]"]:checked').val() == "true") {
				if ($('[name="effects[thumbnails][enable]"]:checked').val() == "true") {
					$thumbFalse.attr('checked', 'checked').trigger('change');
					$('[name="effects[thumbnails][enable]"]').iCheck('update');
					self.notification('<h3>Notice</h3>Thumbnails navigation is disabled now');
					$thumbOpts.hide();
				}
			}
		});
	});

    Controller.prototype.thumbTrigger = (function() {
        var self = this,
		$thumbOpts = $('tr#effectsThumbsType');

		if($('#effectsThumbsTrue').is(':checked')) {
			$thumbOpts.show();
		}
        $('#effectsThumbsTrue').on('change', function() {
            if($('#effectsThumbsTrue').val() && self.$bullets.val() != 'disable') {
                self.$bullets.attr('value', 'disable');
                self.notification('<h3>Notice</h3>Bullet navigation is disabled now');
            }
            if($('#effectsThumbsTrue').val() && $('[name="general[captions]"]:checked').val() == 'true') {
				$('#generalCaptionsFalse').attr('checked', 'checked');
				$('[name="general[captions]"]').iCheck('update');
				$('button#show-caption-settings, tr#captionPosOpt').hide();
                self.notification('<h3>Notice</h3>Captions are disabled now');
            }
			$thumbOpts.show();
        });
		$('#effectsThumbsFalse').on('change', function() {
			$thumbOpts.hide();
		});
    });

    Controller.prototype.initImageSelect = function() {
        var bulletType = $('#bulletType'),
            arrowType = $('#arrowType'),
            $bulletsSelect = $('#effectsBulletControl'),
            $arrowsSelect = $('#effectsEffectArrows');
        $bulletsSelect.ddslick({
            onSelected: function(element){
                bulletType.attr('value', element.selectedData.value);
            }
        });

        $arrowsSelect.ddslick({
            onSelected: function(element){
                arrowType.attr('value', element.selectedData.value);
            }
        });
    };

    Controller.prototype.toggleCarousel = function() {
        var self = this,
            $carouselMargin = $('#carouselMargin').closest('tr'),
            $carouselParts = $('#carouselParts').closest('tr');
            $carouselSteps = $('#carouselSteps').closest('tr');

        this.$mode.on('change', function() {
            if($(this).val() == 'carousel') {
                $carouselMargin.show('800');
                $carouselParts.show('800');
                $carouselSteps.show('800');
                self.$captionPositionDialog.find('img[data-value="left"], img[data-value="right"]').parent().hide();
            } else {
                $carouselMargin.hide('800');
                $carouselParts.hide('800');
                $carouselSteps.hide('800');
                self.$captionPositionDialog.find('img[data-value="left"], img[data-value="right"]').parent().show();
            }
        }).trigger('change');
    };

    Controller.prototype.toggleCaption = (function() {
        var captionOn = $('#generalCaptionsTrue')
            , captionOff = $('#generalCaptionsFalse')
            , captionOpts = $('button#show-caption-settings, tr#captionPosOpt')
            , $thumbTrue = $('#effectsThumbsTrue')
            , $thumbFalse = $('#effectsThumbsFalse')
            , $thumbOpts = $('tr#effectsThumbsType')
            , self = this;

        captionOn.on('click', function() {
            if($thumbTrue.is(':checked')) {
                $thumbFalse.attr('checked', 'checked').trigger('change');
                self.notification('<h3>Notice</h3>Thumbnails navigation is disabled now');
				$thumbOpts.hide();
            }
            captionOpts.show();
        });
        captionOff.on('click', function() {
            captionOpts.hide();
        });
    });

    Controller.prototype.initCaptionPositionDialog = function() {
        var self = this;

        this.$captionPositionDialog.dialog({
            autoOpen: false,
            modal:    true,
            width:    460,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });

        $('#select-caption-position').on('click', function(e) {
            e.preventDefault();
            self.$captionPositionDialog.dialog('open');
        });

        this.$captionPositionDialog.find('img').on('click', function () {
            $('#captionPosition').attr('value', $(this).data('value')).trigger('change');
            $('.preset').removeClass('selected');
            $(this).parent().addClass('selected');
            self.$captionPositionDialog.dialog('close');
        });
    };

    Controller.prototype.initCaptionSettings = (function() {
        var co = $('#captionOpacity');
        $("#caption-opacity").slider({
            min: 0.0,
            max: 1.0,
            step: 0.1,
            value: co.val(),
            stop: function(event, ui) {
                co.val($("#caption-opacity").slider("value"));
            },
            slide: function(event, ui) {
                co.val($("#caption-opacity").slider("value"));
            }
        });
        co.change(function() {
            var curVal = $(this).val(), min = 0.0, max = 1.0;
            if(curVal < min) curVal = min;
            if(curVal > max) curVal = max;
            $("#caption-opacity").slider("value", curVal);
            $(this).val(curVal);
        });
    });

    Controller.prototype.initCaptionSettingsDialog = function() {
        var self = this;

        this.$captionSettigsDialog.dialog({
            autoOpen: false,
            modal:    true,
            width:    500,
            buttons:  {
                Cancel: function () {
                    $(this).dialog('close');
                },
                Save: function () {
                    var $settingsContainer = $('.caption');

                    self.$captionSettigsDialog.find('input, select').each(function() {
                        var name = $(this).attr('name'),
                            value = $(this).val(), val;

                        if(name == 'effects[caption][background][color][hex]') {
                            val = self.hexToRgb(value,
                                        self.$captionSettigsDialog.find('[name="effects[caption][background][transparency]"]').val()
                            );
                            $settingsContainer.find('[name="effects[caption][background][color][rgba]"]').attr('value', val);
                        }
                        $settingsContainer.find('[name="' + name + '"]').attr('value', value);
                    });

                    $(this).dialog('close');
                }
            }
        });

        $('#show-caption-settings').on('click', function(e) {
            e.preventDefault();
            self.$captionSettigsDialog.dialog('open');
        });
    };

    Controller.prototype.initSizeSettings = function() {
        var $width = $('[name="properties[width]"]'),
            $height = $('[name="properties[height]"]');

        $(document).on('change', '[name="properties[widthType]"]', function(event) {
            event.preventDefault();
            event.stopPropagation();

            if ($(this).val() == '%') {
                $width.val('100');
                //$height.val('');
                //$height.attr('disabled', false);
            } else if ($(this).val() == 'auto') {
                $width.val('0');
                //$height.val('0');
            } else {
                $width.val('800');
                //$height.val('400');
            }
        });

        $(document).on('change', '[name="properties[heightType]"]', function(event) {
            event.preventDefault();
            event.stopPropagation();

            if ($(this).val() == '%') {
                $height.val('100');
                //$height.val('');
                //$height.attr('disabled', false);
            } else if ($(this).val() == 'auto') {
                //$width.val('0');
                $height.val('0');
            } else {
                //$width.val('800');
                $height.val('400');
            }
        });

    };

    $(document).ready(function () {
        return new Controller();

    });

}(jQuery));