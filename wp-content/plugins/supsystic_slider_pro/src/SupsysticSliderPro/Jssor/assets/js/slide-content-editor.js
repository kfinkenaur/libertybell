(function ($) {

    function Controller() {
        this.$editorDialog = $('#slide-editor-dialog');
        this.$openButton = $('.html-editor');
        this.$addButton = $('.add-button');
        this.$saveButton = $('#save-button');
        this.$buttonsWrapper = this.$editorDialog.find('.editor-buttons');
        this.$editorNavigation = this.$editorDialog.find('.nav-button');
        this.$buttonEditorWrapper = this.$editorDialog.find('.button-editor');
        this.id = null;
        this.savedSettings = null;
        this.componentToHex = function(c) {
            var hex = parseInt(c).toString(16);
            return hex.length == 1 ? "0" + hex : hex;
        };
        this.rgbStrToArray = function(string) {
            return string.slice(4, -1).split(',');
        };
        this.rgbToHex = function(color) {
            return "#" + this.componentToHex(color[0]) + this.componentToHex(color[1]) + this.componentToHex(color[2]);
        };

        this.init();
    }

    Controller.prototype.initDialog = function() {
        var self = this;

        this.$editorDialog.dialog({
            modal:    true,
            width:    850,
            height:   600,
            autoOpen: false
        });

        this.$openButton.on('click', function(e) {
            e.preventDefault();
            self.id = parseInt($(this).data('id'));

            $.post(window.wp.ajax.settings.url,
                {
                    attachment_id : self.id,
                    action: 'supsystic-slider',
                    route: {
                        module: 'photos',
                        action: 'getSlideContent'
                    }
                })
                .success(function (response) {
                    if(response.html) {
                        self.savedSettings = JSON.parse(response.html);
                    } else {
                        self.savedSettings = false;
                    }
                    self.clearSettingsDialog();
                    self.loadSavedData();
                    self.$editorDialog.dialog('open');
                });
        });
    };

    Controller.prototype.clearSettingsDialog = function() {
        this.$editorDialog.find('input.content-caption').val('');
        this.$editorDialog.find('textarea.content-text').val('');
        if(this.$buttonsWrapper.children()) {
            this.$buttonsWrapper.children().each(function() {
                $(this).remove();
            });
        }
        this.$editorDialog.find('input[name="caption[fontSize]"]').val('');
        this.$editorDialog.find('input[name="caption[fontColor]"]').val('#000000');
        this.$editorDialog.find('input[name="content[fontSize]"]').val('');
        this.$editorDialog.find('[name="effect"] [value="L"]').attr('selected', 'selected');
        this.$editorDialog.find('input[name="effectDuration"]').val('');
        this.$buttonEditorWrapper.find('input[name="button[content]"]').val('Button');
        this.$buttonEditorWrapper.find('input[name="button[link]"]').val('');
        this.$buttonEditorWrapper.find('input[name="button[target]"]').attr('checked', '');
        this.$buttonEditorWrapper.find('input[name="button[color]"]').val('#000000');
        this.$buttonEditorWrapper.find('input[name="button[background]"]').val('#000000');
        this.$buttonEditorWrapper.find('input[name="button[colorOnHover]"]').val('#000000');
        this.$buttonEditorWrapper.find('input[name="button[backgroundOnHover]"]').val('#000000');
        this.$buttonEditorWrapper.find('[name="button[position]"] [value="TL"]').attr('selected', 'selected');
    };

    Controller.prototype.initButtonsDialog = function() {
        var self = this;

        this.$buttonsWrapper.find('button').off('click');
        this.$buttonsWrapper.find('button').on('click', function() {
            self.$buttonEditorWrapper.show();
            self.$buttonsWrapper.find('button').removeClass('editing');
            self.$buttonEditorWrapper.find('input').val('');
            $(this).addClass('editing');
        });

        this.$buttonsWrapper.find('button.button01').each(function() {
            $(this).mouseenter(function() {
                var coh = $(this).attr('data-coh'), boh = $(this).attr('data-boh');
                if(coh) {
                    $(this).css('color', coh);
                } else {
                    $(this).css('color', '#000000');
                }
                if(boh) {
                    $(this).css('background', boh);
                } else {
                    $(this).css('background', '#FFF');
                }
            });
            $(this).mouseleave(function() {
                var color = $(this).attr('data-color'), background = $(this).attr('data-background');
                if(color && background) {
                    $(this).css(
                        {
                            'color': color,
                            'background': background
                        }
                    );
                } else {
                    $(this).css(
                        {
                            'color': '#FFF',
                            'background': '#0D6'
                        }
                    );
                }
            });
        });
        this.$buttonsWrapper.find('button.button02').each(function() {
            $(this).mouseenter(function() {
                var coh = $(this).attr('data-coh'), boh = $(this).attr('data-boh');
                if(coh) {
                    $(this).css('color', coh);
                } else {
                    $(this).css('color', '#666');
                }
                if(boh) {
                    $(this).css('background', boh);
                } else {
                    $(this).css('background', '#e2e2e2');
                }
            });
            $(this).mouseleave(function() {
                var color = $(this).attr('data-color'), background = $(this).attr('data-background');
                if(color && background) {
                    $(this).css(
                        {
                            'color': color,
                            'background': background
                        }
                    );
                } else {
                    $(this).css(
                        {
                            'color': '#666',
                            'background': '#e2e2e2'
                        }
                    );
                }
            });
        });

        this.initButtonEditor();
    };

    Controller.prototype.initButtonsAdding = function() {
        var self = this;

        this.$addButton.on('click', function() {

            if(self.$buttonsWrapper.find('button').attr('class') != $(this).data('type')) {
                self.$buttonsWrapper.find('button').remove();
            }
            self.$buttonsWrapper.append(self.getButtonTemplate($(this).data('type')));
            self.initButtonsDialog();
        });
    };

    Controller.prototype.initNavigation = function() {
        var $settings = $('[data-settings]'),
            self = this;

        this.$editorNavigation.on('click', function(e) {
            e.preventDefault();

            self.$editorNavigation.removeClass('active');
            $(this).addClass('active');

            $settings.hide();
            $('[data-settings="' + $(this).data('nav') + '"]').show();
        });
    };

    Controller.prototype.editButton = function() {
        var $fields = this.$buttonEditorWrapper.find('input, select'),
            $removeButton = this.$buttonEditorWrapper.find('.remove-button'),
            self = this;

        $fields.on('change', function() {
            var $button = $('button.editing'),
                contentHelper = self.getButtonTemplate($button.attr('class').split(' ')[0] + '-helper');

            switch($(this).attr('name')) {
                case 'button[content]': {
                    $button.empty().append($(this).val() + (contentHelper ? contentHelper : ''));
                } break;
                case 'button[link]': {
                    $button.attr('data-link', $(this).val());
                } break;
                case 'button[target]': {
                    $button.attr('data-target', $(this).val());
                } break;
                case 'button[color]': {
                    $button.attr('data-color', $(this).val());
                } break;
                case 'button[background]': {
                    $button.attr('data-background', $(this).val());
                } break;
                case 'button[coh]': {
                    $button.attr('data-coh', $(this).val());
                } break;
                case 'button[boh]': {
                    $button.attr('data-boh', $(this).val());
                } break;
                case 'button[position]': {
                    $button.attr('data-position', $(this).val());
                } break;
            }
        });

        $removeButton.on('click', function() {
            var $button = $('button.editing');

            $button.remove();
            self.$buttonEditorWrapper.hide();
        });
    };

    Controller.prototype.saveData = function() {
        var self = this;

        this.$saveButton.on('click', function() {
            $.post(window.wp.ajax.settings.url,
                {
                    attachment_id : self.id,
                    html: self.prepareContent(),
                    action: 'supsystic-slider',
                    route: {
                        module: 'photos',
                        action: 'updateSlideContent'
                    }
                })
                .success(function (response) {
                    $.jGrowl('Succesfully saved');
                    window.location.reload(this);
                });
        });
    };

    Controller.prototype.prepareContent = function() {
        var buttonsSet = [];

        $('.slide-wrapper button').each(function() {
            buttonsSet.push({
                'class': $(this).attr('class'),
                'text': $(this).text(),
                'link': $(this).data('link'),
                'target': $(this).attr('data-target'),
                'color': $(this).attr('data-color'),
                'background': $(this).attr('data-background'),
                'coh': $(this).attr('data-coh'),
                'boh': $(this).attr('data-boh'),
                'position': $(this).attr('data-position')
            });
        });

        //change this
        return {
            'caption': {
                'text': $('.content-caption').val(),
                'fontSize': this.$editorDialog.find('input[name="caption[fontSize]"]').val(),
                'fontColor': this.$editorDialog.find('input[name="caption[fontColor]"]').val()
            },
            'content': {
                'text': $('.content-text').val(),
                'fontSize': this.$editorDialog.find('input[name="content[fontSize]"]').val(),
                'fontColor': this.$editorDialog.find('input[name="content[fontColor]"]').val()
            },
            'buttons': buttonsSet,
            'effect' : $('[name="effect"]').val(),
            'effectDuration': $('[name="effectDuration"]').val()
        };
    };

    Controller.prototype.loadButtons = function() {
        var self = this;

        if(this.savedSettings.buttons && this.savedSettings.buttons.length) {
            $.each(this.savedSettings.buttons, function(index, value) {
                var $button = $(self.getButtonTemplate(value['text'])),
                    data = {};

                $.each(value, function(index, value) {
                    if($.inArray(index, ['class, text']) < 0) {
                        data['data-' + index] = value;
                    }
                });

                self.$buttonsWrapper.append($button);
                $button.addClass(value['class'])
                    .removeClass('editing')
                    .attr(data)
                    .css({
                        'color': value['color'],
                        'background-color': value['background']
                    });
            });
        }

        this.initButtonsDialog();
    };

    Controller.prototype.initButtonEditor = function() {
        var self = this;

        this.$buttonsWrapper.find('button').on('click', function() {
            var $button = $(this);

            self.$buttonEditorWrapper.find('input, select').each(function() {
                var helper = $(this).attr('name').split('[')[1].split(']')[0],
                    value = $button.data(helper);

                $('[name="button[content]"]').val($button.html());

                if(helper == 'target') {
                    if(value == 'on') {
                        $('[name="button[target]"]').val('on').attr('checked', 'checked').iCheck('update');
                    } else {
                        $('[name="button[target]"]').val('off').removeAttr('checked').iCheck('update');
                    }
                }
                if(helper == 'position') {
                    value = $button.attr('data-position');
                    $('[name="button[position]"] [value="' + value + '"]').attr('selected', 'selected');
                }

                $(this).val(value);
            });

            $('[name="button[target]"]').click(function() {
                if($(this).val() == 'on') {
                    $(this).removeAttr('checked').val('off').iCheck('update');
                } else if($(this).val() == 'off' || $(this).val() == '') {
                    $(this).attr('checked', 'checked').val('on').iCheck('update');
                }
            });
        });
    };

    Controller.prototype.loadSavedData = function() {
        var self = this;

        if(this.savedSettings) {
            $.each(this.savedSettings, function(setName, settingsSet) {
                if(typeof(settingsSet) == 'object') {
                    $.each(settingsSet, function(optionName, option) {
                        if(optionName == 'text') {
                            $('.content-' + (setName != 'content' ? setName : 'text')).text(option).val(option);
                        } else {
                            //$('[name="' + setName + '['+ optionName + ']' + '"]').val((optionName == 'fontColor' ? self.rgbToHex(self.rgbStrToArray(option)) : parseInt(option)));
                            if(optionName == 'fontSize') {
                                $('.content-' + (setName != 'content' ? setName : 'text')).css('font-size', option);
                                $('[name="' + setName + '['+ optionName + ']' + '"]').val(parseInt(option));
                            } else if(optionName == 'fontColor') {
                                $('.content-' + (setName != 'content' ? setName : 'text')).css('color', option);
                                $('[name="' + setName + '['+ optionName + ']' + '"]').val(option);
                            } else {
                                $('[name="' + setName + '['+ optionName + ']' + '"]').val(parseInt(option));
                            }
                        }
                    });
                } else {
                    $('[name="' + setName + '"]').val(settingsSet);
                }
            });
        }

        this.loadButtons();
    };

    Controller.prototype.getButtonTemplate = function(button) {

        switch(button) {
            case 'button01' : {
                return '<button class="button01">Button</button>';
            } break;
            case 'button02': {
                return '<button class="button02">Button<span class="button02-arrow">&#10095</span></button>';
            } break;
            case 'button02-helper': {
                return '<span class="button02-arrow">❯</span>';
            } break;
            case 'button01-helper': {
                return;
            } break;
            default: {
                return '<button>' + button + '</button>';
            } break;
        }
    };

    Controller.prototype.init = function() {
        this.initDialog();
        this.initButtonsAdding();
        this.initNavigation();
        this.saveData();
        this.editButton();
    };

    $(document).ready(function () {
        return new Controller();
    });

}(jQuery));

(function ($) {

    function Controller() {
        this.$editorDialog = $('#slide-editor-dialog');

        this.init();
    }

    Controller.prototype.updateTitle = function() {
        var $titleContainer = this.$editorDialog.find('.settings-group.title'),
            $contentCaption = this.$editorDialog.find('.content-caption'),
            settings = [{
                'element': $titleContainer.find('[name="caption[fontSize]"]'),
                'type': 'font-size',
                'pref' : 'px'
            }, {
                'element': $titleContainer.find('[name="caption[fontColor]"]'),
                'type': 'color'
            }];

        $.each(settings, function(index, $value) {
            var type = $value.type;

            $value.element.on('change keyup mouseup', function() {
                $contentCaption.css(type, $(this).val() + ($value.pref ? $value.pref : ''));
            });
        });
    };

    Controller.prototype.updateContent = function() {
        var $contentContainer = this.$editorDialog.find('.settings-group.content'),
            $contentCaption = this.$editorDialog.find('.content-text'),
            settings = [{
                'element': $contentContainer.find('[name="content[fontSize]"]'),
                'type': 'font-size',
                'pref' : 'px'
            }, {
                'element': $contentContainer.find('[name="content[fontColor]"]'),
                'type': 'color'
            }];

        $.each(settings, function(index, $value) {
            var type = $value.type;

            $value.element.on('change keyup mouseup', function() {
                $contentCaption.css(type, $(this).val() + ($value.pref ? $value.pref : ''));
            });
        });
    };

    Controller.prototype.updateButtons = function() {
        var settings = ['button[color]', 'button[background]'];

        $.each(settings, function(index, value) {
            $('[name="' + value + '"]').on('change', function() {
                var $button = $('button.editing');

                $button.css(value.split('[')[1].split(']')[0], $(this).val());
            });
        });
    };

    Controller.prototype.init = function() {
        this.updateTitle();
        this.updateContent();
        this.updateButtons();
    };

    $(document).ready(function () {
        return new Controller();
    });

}(jQuery));