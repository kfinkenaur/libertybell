/**
*   Plugin Name: Cnhk Slideshow
*
*   Cnhk Slideshow plugin for WordPress, Copyright (C) 2013 Rija Rajaonah
*   Cnhk Slideshow plugin for WordPress is licensed under the GPL License version 3.
*   [http://www.gnu.org/licenses/gpl-3.0.html]
*/

;var CNHK_AJAX_TIMEOUT = 30000;
var CNHKSS_EDITING = false;

function stripslashes (str) {
  return (str + '').replace(/\\(.?)/g, function (s, n1) {
    switch (n1) {
    case '\\':
      return '\\';
    case '0':
      return '\u0000';
    case '':
      return '';
    default:
      return n1;
    }
  });
}

(function($){
    $(function(){
        if (cnhkSlidesData.flash) {
            cnhkFlash();
        }
        
        // Switch from the browser uploader to the flash one
        $('#switch-to-flash').click(function(){
            $.post(
                cnhkSlidesData.url,
                {
                    action : 'cnhk_switch_flash',
                    nonce : cnhkSlidesData.nonce,
                },
                function(resp){}
            );
            cnhkFlash();
            return false;
        });
        
        // Dynamic title edition init
        $('span[id^="edit-title"]').live('click', function(){
            if (!cnhkRunning() && false == CNHKSS_EDITING) {            
                var id = $(this).attr('id');
                var slug = id.substring(11);
                
                cnhkAddLoader('#edit-title-' + slug);
                
                $.post(
                    cnhkSlidesData.url,
                    {
                        action : 'cnhk_title_action',
                        nonce : cnhkSlidesData.nonce,
                        step : 'init',
                        slug : slug,
                    },
                    function(data){
                        cnhkRemLoader();
                        cnhkLineEdit(data.slug, 'title', data.title, '#' + id, cnhkSlidesData.textTitle);
                    }
                );
            }
        });
        
        // Dynamic link edition init
        $('span[id^="edit-link"]').live('click', function(){
            if (!cnhkRunning() && false == CNHKSS_EDITING) {            
                var id = $(this).attr('id');
                var slug = id.substring(10);
                
                cnhkAddLoader('#edit-link-' + slug);
                
                $.post(
                    cnhkSlidesData.url,
                    {
                        action : 'cnhk_link_action',
                        nonce : cnhkSlidesData.nonce,
                        step : 'init',
                        slug : slug,
                    },
                    function(data){
                        cnhkRemLoader();
                        cnhkLineEdit(data.slug, 'link', data.link, '#' + id, cnhkSlidesData.textLink);
                    }
                );
            }
        });
        
        // Dynamic caption edition
        
        $('span[id^="edit-caption"]').live('click', function() {
            if (!cnhkRunning() && false == CNHKSS_EDITING) {
                var slug = $(this).attr('id').substring(13);
                var thumb = $('img[data-slug="' + slug + '"]');
                $('#live-slug').text(slug);
                $('#live-title').text(thumb.attr('title'));
                $('#live-thumb').append(thumb.clone());
                var theEditor = tinyMCE.EditorManager.get('livecaption');
                var editorCnt = $(this).html();
                if (cnhkSlidesData.textNoCaption == editorCnt) {
                    editorCnt = '';
                }
                theEditor.setContent(editorCnt);
                $('.editor-overlay').show(400);
            }
        });
        
        $('#live-cancel').click(function(){
            $('.editor-overlay').hide(400);
            $('#live-thumb').empty();
            return false;
        });
        $('#live-submit').click(function(){
            var slug = $('#live-slug').html();
            var theEditor = tinyMCE.EditorManager.get('livecaption');
            var cnt = theEditor.getContent();
            
            $('.editor-overlay').hide(400);
            $('#live-thumb').empty();
            
            cnhkAddLoader('#edit-caption-' + slug);
            
            $.post(
                cnhkSlidesData.url,
                {
                    action : 'cnhk_caption_action',
                    nonce : cnhkSlidesData.nonce,
                    slug : slug,
                    caption : cnt,
                },
                function(data){
                    cnhkRemLoader();
                    if (data.status) {
                        data.caption = stripslashes(data.caption);
                        $('#edit-caption-' + data.slug).html(data.caption);
                        cnhkMessage(data.message, '#edit-caption-' + data.slug, 'success');
                    } else {
                        cnhkMessage(data.message, '#edit-caption-' + data.slug, 'error');
                    }
                }
            );
            return false;
        });
        
        // Adjust pop-up position (neutral type)
        $(window).on('resize scroll', function() {
            cnhkPlaceStaticBox();
        });
    });

    /**
    * Flash uploader
    */
    function cnhkFlash() {
        $('#slides-file').uploadify({
            'swf' : cnhkSlidesData.uploadifyUrl + '/uploadify.swf',
            'uploader' : cnhkSlidesData.uploadifyUrl + '/uploadify.php',
            'multi' : false,
            'queueSizeLimit' : 1,
            'checkExisting' : false,
            'onSWFReady' : function() {
                $('.flash-text').html(cnhkSlidesData['flashYes']);
                $('#slides-upload-fieldset input[name="slides-upload"]').remove();
            },
            'formData' : {
                sid : cnhkSlidesData.sid,
                nonce : cnhkSlidesData.nonce,
                dir : cnhkSlidesData.uploadDir,
                file_type_error : cnhkSlidesData.fileTypeError,
            },
            'onUploadSuccess' : function(file, strData, response) {
                data = JSON.parse(strData);
                if (cnhkIsValidResp(data)) {
                    if (data['status']) {
                        $.post(
                            cnhkSlidesData.url,
                            {
                                action : 'cnhk_after_upload',
                                nonce : cnhkSlidesData.nonce,
                                name : data.name,
                                extension : data.extension,
                                css : data.css,
                                noLink : cnhkSlidesData.textNolink,
                            },
                            function(resp) {
                                if (resp.status) {
                                    var src = cnhkSlidesData['uploadUrl'] + resp.slug + '.' + resp.type;
                                    var tr = $('<tr />');
                                    var tdThumb = $('<td />').addClass('thumb');
                                    var pageUrl = cnhkSlidesData['adminSlidesUrl'];
                                    var editUrl = cnhkSlidesData.adminSlidesUrl + '&action=edit&id=' + resp.slug + '&key='+ cnhkSlidesData.nonceAction;
                                    var deleteUrl = cnhkSlidesData.adminSlidesUrl + '&action=delete&id=' + resp.slug + '&key='+ cnhkSlidesData.nonceAction;
                                    var editLink = $('<a />').text(cnhkSlidesData.textEdit).attr(
                                        {
                                            title : cnhkSlidesData.textEdit,
                                            href : editUrl,
                                            id : 'edit-action-' + resp.slug,
                                        }
                                    );
                                    var deleteLink = $('<a />').text(cnhkSlidesData.textDelete).attr(
                                        {
                                            title : cnhkSlidesData.textDelete,
                                            href : deleteUrl,
                                            id : 'delete-action-' + resp.slug,
                                        }
                                    );
                                    tdThumb.append(
                                        $('<img />').addClass(resp.css).attr(
                                            {
                                                alt : '',
                                                title : resp.slug,
                                                src : src,
                                            }
                                        )
                                    );
                                    var tdTitle = $('<td />').append($('<span />').addClass('clickable').text(resp.slug).attr('id', 'edit-title-' + resp.slug));
                                    var tdLink = $('<td />').append($('<span />').addClass('clickable').text('No link').attr('id', 'edit-link-' + resp.slug));
                                    var tdAction = $('<td />').append(editLink).append(' | ').append(deleteLink);
                                    var tdCaption = $('<td />').append($('<span />').addClass('clickable').html(resp.caption).attr('id', 'edit-caption-' + resp.slug));
                                    $('#slides-list tbody').append(tr.append(tdThumb, tdTitle, tdLink, tdAction, tdCaption));
                                    $('#no-slides-yet').remove();
                                }
                            }
                        );
                    }
                }
            }
        });
    }

    /**
    * Display a pop-up form with a single text input
    * @param string slug, the slug of the concerned slide
    * @param string fieldName, the field to edit (title or link)
    * @param string value, the current value of the field
    * @param string text, label
    */
    function cnhkLineEdit(slug, fieldName, value, selector, text) {
        if (CNHKSS_EDITING) return;
        CNHKSS_EDITING = true;
        var mainDiv = $('<div />').addClass('line-edit out-border');
        var f = $('<form />').addClass('line-edit-form thick-border');
        var t = $('<label />').text(text);
        var s = $('<input />').attr(
            {
                type : 'hidden',
                name : 'slug',
                value : slug,
            }
        );
        var field = $('<input />').attr(
            {
                type : 'text',
                name : fieldName,
                value : value,
            }
        );
        var btn = $('<div />').addClass('popup-yesno').append(
            $('<input />').addClass('button-primary').attr(
                {
                    type : 'submit',
                    name : 'submit',
                    value : cnhkSlidesData.textSave,
                }
            )
        ).append(
            $('<a />').text(cnhkSlidesData.textCancel).addClass('button').attr(
                {
                    id : 'popup-cancel',
                }
            ).click(function(){
                CNHKSS_EDITING = false;
                mainDiv.remove();
                return false;
            })
        );
        f.submit(function(){
            if (field.val() != value) {
                if (!cnhkRunning()) {
                    cnhkAddLoader('#edit-' + fieldName + '-' + slug);
                    $.post(
                        cnhkSlidesData.url,
                        {
                            action : 'cnhk_' + fieldName + '_action',
                            nonce : cnhkSlidesData.nonce,
                            step : 'submit',
                            current_slug : slug,
                            value : field.val(),
                        },
                        function(resp) {
                            cnhkRemLoader();
                            if (cnhkIsValidResp(resp)) {
                                if (resp.status) {
                                    cnhkMessage(cnhkSlidesData.textUpdated, '#edit-' + fieldName + '-' + slug, 'success');
                                    cnhkUpdateSlug(resp.oldSlug, resp.newSlug, resp.title, resp.link, resp.caption, resp.oldTitle, resp.newSrc);
                                } else {
                                    cnhkMessage(resp.error, '#edit-' + fieldName + '-' + slug, 'error');
                                }
                            }
                        }
                    );
                }
            }
            CNHKSS_EDITING = false;
            mainDiv.remove();
            return false;
        });
        mainDiv.append(f.append(t, s, field, btn));
        $(selector).after(mainDiv);
    }

    /**
    * Update the slug on all html attributes (id, href ...) of a row (defined by the slug of the corresponding slide)
    * @param string oldSlug
    * @param string newSlug
    * @param string title, the slide's title
    * @param string link, the slide's link
    */
    function cnhkUpdateSlug(oldSlug, newSlug, title, link, caption, oldTitle, newSrc) {
        $('span#edit-title-' + oldSlug).attr('id', 'edit-title-' + newSlug).html(title);
        $('span#edit-link-' + oldSlug).attr('id', 'edit-link-' + newSlug).html(link);
        $('span#edit-caption-' + oldSlug).attr('id', 'edit-caption-' + newSlug).html(caption);
        
        actEdit = $('a#edit-action-' +oldSlug);
        editHref = actEdit.attr('href'); 
        newEditHref = editHref.replace('id=' + oldSlug, 'id=' + newSlug);
        actEdit.attr(
            {
                id : 'edit-action-' + newSlug,
                href : newEditHref,
            }
        )
        
        actDel = $('a#delete-action-' +oldSlug);
        delHref = actDel.attr('href'); 
        newDelHref = editHref.replace('id=' + oldSlug, 'id=' + newSlug);
        actDel.attr(
            {
                id : 'delete-action-' + newSlug,
                href : newDelHref,
            }
        );
        $('img[data-slug="' + oldSlug + '"]').attr('title', title).attr('data-slug', newSlug);
    }

    /**
    * Enhanced "alert()" method.
    * @param string message, the message to display (text, not HTML)
    * @param string selector, $ selector of the element after which the message box will be inserted
    * @type string type, "success", "error" or none (which don't need selector and be placed right in the middle of the screen)
    */
    function cnhkMessage(message, selector, type) {   
        var mainDiv = $('<div />');
        var mainP = $('<p />');
        if ('undefined' == typeof(selector)) {
            mainDiv.addClass('staticBox popup');
        } else {
            mainDiv.addClass('regularBox popup');
        }
        switch (type) {
            case 'error' :
                mainDiv.addClass('error-msg');
                break;
            case 'success' :
                mainDiv.addClass('success-msg');
                break;
            default :
                mainDiv.addClass('neutral-msg');
        }
        if ('undefined' != typeof(selector)) {
            $(selector).after(mainDiv.append(mainP.text(message)));
        } else {
            $('body').append(mainDiv.append(mainP.text(message)));
            cnhkPlaceStaticBox();
        }
        cnhkRemPopup();
    }

    // Misc utilities functions

    function cnhkPlaceStaticBox() {
        var p = $('.staticBox');
        var pw = p.width();
        var ph = p.height();
        var bw = $(window).width();
        var bh = $(window).height();
        var s = $(window).scrollTop();
        p.css({
            left : Math.round((bw - pw)/2) + 'px',
            top : Math.round((bh-ph)/2) + s + 'px',
        });
    }

    function cnhkRemPopup() {
        setTimeout(function(){
            $('.popup').animate(
                {
                    opacity : 0,
                },
                2500,
                function() {
                    $(this).remove();
                }
            );
        }, 1500);
    }

    function cnhkAddLoader(selector) {
        var loader = $('<img />').attr(
            {
                src : cnhkSlidesData.imgUrl + 'loading16.gif',
                id : 'loading16',
            }
        );
        $(selector).after(loader);
        cnhkSlidesData.running = setTimeout("cnhkTimeout()", CNHK_AJAX_TIMEOUT);
    }

    function cnhkTimeout() {
        cnhkMessage(cnhkSlidesData.textSecurity);
        cnhkRemLoader();
    }

    function cnhkRunning() {
        if ('undefined' != typeof(cnhkSlidesData.running))
            return true;
        else
            return false;
    }

    function cnhkRemLoader() {
        if (cnhkRunning()) {
            clearTimeout(cnhkSlidesData.running);
            delete cnhkSlidesData.running;
        }
        $('#loading16').remove();
    }

    function cnhkIsValidResp(resp) {
        if ('undefined' != typeof(resp.status)) {
            return true;
        } else {
            return false;
        }
    }
})(jQuery);
