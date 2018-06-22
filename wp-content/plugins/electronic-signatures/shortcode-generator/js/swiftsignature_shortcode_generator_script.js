function clearInput(fieldName) {
    fieldName = fieldName.replace(/[^a-zA-Z0-9\-_ ]/g, "");
    tmp = fieldName.replace(/(\s|&nbsp;|&\#160;)+/gi, "_");
    //fieldName = tmp.toLowerCase();
    return fieldName;
}
function clearOptions(fieldName) {
    fieldName = fieldName.replace(/[^a-zA-Z0-9,\-_ ]/g, "");
    tmp = fieldName.replace(/(\s|&nbsp;|&\#160;)+/gi, " ");
    //fieldName = tmp.toLowerCase();
    return fieldName;
}

(function() {

    tinymce.PluginManager.add('ssing_mce_button', function(editor, url) {
        /*  CONDITIONAL LOGIC
         * function test_conditional_logic() {
         jQuery("#mceu_107").hide();
         }*/
        editor.addButton('ssing_mce_button', {
            image: url + '/eSignature.png',
            title: 'SwiftSignature Shortcode Generator', //Tooltip
            type: 'menubutton',
            menu: [
                {
                    text: 'Quick Start Setup',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'SwiftSignature Form shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_swift_form_id',
                                    label: 'Enter Swiftform ID*',
                                    value: ''
                                },
                                {
                                    type: 'container',
                                    name: 'ss_quick_swift_form_id_container',
                                    class: 'ss_quick_form_id_container_cls',
                                    html: '<br/><p><a style="text-decoration: underline;cursor: pointer;" href="http://swiftcloud.io/form/create-form" target="_blank">Click to generate</a> a new form if needed, or use any of your existing forms.</p><p style="margin-top:10px;"> Visit <a style="text-decoration: underline;cursor: pointer;" href="http://swiftcloud.io/form/create-form" target="_blank"> http://swiftcloud.io/form/create-form</a> to create a form; this determines <br/>the autoresponder sequence and any automation as well as any tags to <br/>apply to users captured through this form.<br /><br /></p>',
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_full_screen_mode',
                                    label: 'Full Screen Mode',
                                    text: 'Recommended',
                                    id: 'ss_full_screen_mode',
                                    checked: true,
                                },
                                {
                                    type: 'container',
                                    name: 'ss_quick_swift_form_id_container',
                                    class: 'ss_quick_form_id_container_cls',
                                    html: '<p>This will have fewer problems via interference from themes</p><p>which may intercept our server.</p>',
                                }
                            ],
                            onsubmit: function(e) {
                                var numbers = /^[0-9]+$/;
                                if (e.data.ss_swift_form_id === '') {
                                    editor.windowManager.alert('Please, fill swift form id.');
                                    return false;
                                } else if (!e.data.ss_swift_form_id.match(numbers)) {
                                    editor.windowManager.alert('Please enter only digits');
                                    return false;
                                }
                                var ss_full_screen_mode = (e.data.ss_full_screen_mode === true) ? " fullpagemode=\"ON\"" : "";

                                var op = '';
                                op += '[swiftsign swift_form_id="' + clearInput(e.data.ss_swift_form_id) + '"' + ss_full_screen_mode + ']<br/>';
                                op += 'I, [swift_name], and YOURCOMPANYHERE agree to the following awesome text:';
                                op += '<ol><li>Penguins are cute</li><li>Dolphins are fun</li><li>Great whites are not cute.</li><li>Replace this area with whatever you want agreement on.</li></ol>';
                                op += '[swiftsignature]<br/>';
                                op += 'I hereby agree to the above.<br/>';
                                op += 'Addendum A:<br/>';
                                op += '[swift_initials]<br/> I also warrant I am not a great white shark.<br/>';
                                op += '[swift_email]<br/>';
                                op += '[swift_button]<br/>';
                                op += '[/swiftsign]';
                                editor.insertContent(op);
                            }
                        });
                    }
                },
                {
                    text: 'Thanks URL',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Thanks URL shortcode',
                            body: [
                                {
                                    type: 'listbox',
                                    name: 'ssThanksRedirectPage',
                                    label: 'Select Thanks Redirect Page',
                                    values: editor.settings.ssThanksRedirectPages,
                                    id: 'ssThanksRedirectPage',
                                    tooltip: 'Please select page for thanks redirect. User will redirect to this page after submission.'
                                },
                            ],
                            onsubmit: function(e) {
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes('swift_thanksurl')) {
                                    editor.windowManager.alert('Thanks URL shortcode already exist. You can add Thanks URL only once in signature form.');
                                    return false;
                                }
                                editor.insertContent('[swift_thanksurl url=&quot;' + e.data.ssThanksRedirectPage + '&quot;]');
                            }
                        });
                    }
                },
                {
                    text: 'Signature',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Signature box shortcode',
                            body: [
                                {
                                    type: 'listbox',
                                    name: 'ss_size',
                                    label: 'Enter signature box size',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Small', value: 'small'},
                                        {text: 'Medium', value: 'medium'},
                                        {text: 'Large', value: 'large'}
                                    ],
                                    value: 'small', // Sets the default
                                },
                            ],
                            onsubmit: function(e) {
                                editor.insertContent('[swiftsignature size=&quot;' + e.data.ss_size + '&quot;]');
                            }
                        });
                    }
                },
                {
                    text: 'Initials',
                    onclick: function() {
                        editor.insertContent('[swift_initials]');
                    }
                },
                {
                    text: 'Textbox',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Textbox shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_txtbox_name',
                                    label: 'Textbox Name',
                                    value: '',
                                    tooltip: 'No spaces allowed; will not show to visitors.'
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_txtbox_class',
                                    label: 'CSS Class Name',
                                    value: '',
                                    tooltip: 'Optional. Used by designers and programmers to override the visual styling.'
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_txtbox_value',
                                    label: 'Pre-loaded Value',
                                    value: '',
                                    tooltip: 'This text will pre-fill into the field, and will not disappear on click. Useful if there’s a likely answer for most cases.'
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_txtbox_placeholder',
                                    label: 'Placeholder Hint',
                                    value: '',
                                    tooltip: 'This will disappear when clicked, and displays to web visitors.'
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_textbox_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_textbox_required_id',
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_textbox_size',
                                    label: 'Enter field size',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Small', value: 'small'},
                                        {text: 'Medium', value: 'medium'},
                                        {text: 'Long', value: 'long'},
                                        {text: 'Full Line', value: 'fullline'}
                                    ],
                                    value: 'medium' // Sets the default
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_textbox_editable',
                                    label: 'Field is...',
                                    tooltip: 'Non-editable fields will display as in-line text, designed to be pre-filled via URL or API, for example to set a fee or price the customer cannot change.',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Editable', value: 'editable'},
                                        {text: 'NonEditable', value: 'noneditable'},
                                    ],
                                    value: 'editable' // Sets the default
                                },
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_txtbox_name === '') {
                                    editor.windowManager.alert('Please, fill textbox name.');
                                    return false;
                                }

                                txtboxName = clearInput(e.data.ss_txtbox_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(txtboxName)) {
                                    txtboxName = txtboxName + "_" + new Date().getTime();
                                }

                                var textbox_required = (e.data.ss_textbox_required === true) ? " required" : "";
                                var tx_class = (e.data.ss_txtbox_class === '') ? "" : ' class="' + clearOptions(e.data.ss_txtbox_class) + '"';
                                var tx_value = (e.data.ss_txtbox_value === '') ? "" : ' value="' + clearOptions(e.data.ss_txtbox_value) + '"';
                                var tx_placeholder = (e.data.ss_txtbox_placeholder === '') ? "" : ' placeholder="' + clearOptions(e.data.ss_txtbox_placeholder) + '"';
                                var tx_size = (e.data.ss_textbox_size === '') ? "" : ' size="' + e.data.ss_textbox_size + '"';
                                var tx_field = (e.data.ss_textbox_editable === 'editable') ? "" : ' readonly';
                                editor.insertContent('[swift_textbox name="' + txtboxName + '"' + tx_class + tx_value + tx_placeholder + textbox_required + tx_size + tx_field + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Textarea',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Textarea shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_textarea_name',
                                    label: 'Enter textarea name*',
                                    value: '',
                                    tooltip: 'No spaces allowed; will not show to visitors.'
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_textarea_class',
                                    label: 'CSS Class Name',
                                    value: '',
                                    tooltip: 'Optional. Used by designers and programmers to override the visual styling.'
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_textarea_value',
                                    label: 'Pre-loaded Value',
                                    value: '',
                                    tooltip: 'This text will pre-fill into the field, and will not disappear on click. Useful if there’s a likely answer for most cases.'
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_textarea_placeholder',
                                    label: 'Placeholder Hint',
                                    value: '',
                                    tooltip: 'This will disappear when clicked, and displays to web visitors.'
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_textarea_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_textarea_required_id'
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_textarea_rows',
                                    label: 'Enter rows',
                                    value: ''
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_textarea_size',
                                    label: 'Enter field size',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Small', value: 'small'},
                                        {text: 'Medium', value: 'medium'},
                                        {text: 'Long', value: 'long'},
                                        {text: 'Full Line', value: 'fullline'}
                                    ],
                                    value: 'medium' // Sets the default
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_textarea_editable',
                                    label: 'Field is...',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Editable', value: 'editable'},
                                        {text: 'NonEditable', value: 'noneditable'},
                                    ],
                                    tooltip: 'Non-editable fields will display as in-line text, designed to be pre-filled via URL or API, for example to set a fee or price the customer cannot change.',
                                    value: 'editable' // Sets the default
                                }
                            ],
                            onsubmit: function(e) {

                                if (e.data.ss_textarea_name === '') {
                                    editor.windowManager.alert('Please, fill textarea name.');
                                    return false;
                                }
                                if (isNaN(e.data.ss_textarea_rows)) {
                                    editor.windowManager.alert('Please, enter only numbers in rows.');
                                    return false;
                                }

                                txtareaName = clearInput(e.data.ss_textarea_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(txtareaName)) {
                                    txtareaName = txtareaName + "_" + new Date().getTime();
                                }

                                var txarea_required = (e.data.ss_textarea_required === true) ? " required" : "";
                                var txarea_class = (e.data.ss_textarea_class === '') ? "" : ' class="' + clearOptions(e.data.ss_textarea_class) + '"';
                                var txarea_value = (e.data.ss_textarea_value === '') ? "" : ' value="' + clearOptions(e.data.ss_textarea_value) + '"';
                                var txarea_placeholder = (e.data.ss_textarea_placeholder === '') ? "" : ' placeholder="' + clearOptions(e.data.ss_textarea_placeholder) + '"';
                                var txarea_rows = (e.data.ss_textarea_rows === '') ? "" : ' rows="' + clearInput(e.data.ss_textarea_rows) + '"';
                                var txarea_size = (e.data.ss_textarea_size === '') ? "" : ' size="' + e.data.ss_textarea_size + '"';
                                var txarea_field = (e.data.ss_textarea_editable === 'editable') ? "" : ' readonly';
                                editor.insertContent('[swift_textarea name="' + txtareaName + '"' + txarea_class + txarea_value + txarea_placeholder + txarea_required + txarea_rows + txarea_size + txarea_field + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Name',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Name shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_swift_name',
                                    label: '',
                                    value: '',
                                    hidden: true
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_name_size',
                                    label: 'Enter field size',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Medium', value: 'medium'},
                                        {text: 'Long', value: 'long'},
                                        {text: 'Full Line', value: 'fullline'}
                                    ],
                                    value: 'medium' // Sets the default
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_name_editable',
                                    label: 'Field is',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Editable', value: 'editable'},
                                        {text: 'NonEditable', value: 'noneditable'},
                                    ],
                                    value: 'editable' // Sets the default
                                }
                            ],
                            onsubmit: function(e) {

                                txtboxName = "swift_name";
                                pageContent = editor.getContent().toLowerCase();
                                if (pageContent.includes(txtboxName)) {
                                    txtboxName = "extra_name_" + new Date().getTime();
                                }
                                if (txtboxName == "swift_name") {
                                    txtboxName = "name";
                                }

                                var name_size = (e.data.ss_name_size === '') ? "" : ' size="' + e.data.ss_name_size + '"';
                                var name_field = (e.data.ss_name_editable === 'editable') ? "" : ' readonly';
//                                editor.insertContent('[swift_name ' + name_size + name_field + ']');
                                editor.insertContent('[swift_name name="' + txtboxName + '"' + name_size + name_field + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Email',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Email shortcode',
                            body: [
                                {
                                    type: 'listbox',
                                    name: 'ss_email_editable',
                                    label: 'Field is',
                                    minWidth: 110,
                                    values: [
                                        {text: 'Editable', value: 'editable'},
                                        {text: 'NonEditable', value: 'noneditable'},
                                    ],
                                    value: 'editable' // Sets the default
                                }
                            ],
                            onsubmit: function(e) {
                                pageContent = editor.getContent().toLowerCase();
                                if (pageContent.includes('swift_email')) {
                                    editor.windowManager.alert('Email shortcode already exist. You can use Email field only once in signature form.');
                                    return false;
                                }
                                var email_field = (e.data.ss_email_editable === 'editable') ? "" : ' readonly';
                                editor.insertContent('[swift_email ' + email_field + ']');
                            }
                        })
                    }
                },
                {
                    text: 'Phone',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Phone shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_phone_name',
                                    label: 'Enter field name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_phone_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_phone_value',
                                    label: 'Enter value',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_phone_placeholder',
                                    label: 'Enter placeholder',
                                    value: ''
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_phone_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_phone_required_id',
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_phone_size',
                                    label: 'Enter field size',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Medium', value: 'medium'},
                                        {text: 'Long', value: 'long'},
                                        {text: 'Full Line', value: 'fullline'}
                                    ],
                                    value: 'medium' // Sets the default
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_phone_editable',
                                    label: 'Field is',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Editable', value: 'editable'},
                                        {text: 'NonEditable', value: 'noneditable'},
                                    ],
                                    value: 'editable' // Sets the default
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_phone_name === '') {
                                    editor.windowManager.alert('Please, fill field name.');
                                    return false;
                                }

                                txtboxName = clearInput(e.data.ss_phone_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(txtboxName)) {
                                    txtboxName = txtboxName + "_" + new Date().getTime();
                                }

                                var textbox_required = (e.data.ss_phone_required === true) ? " required" : "";
                                var tx_class = (e.data.ss_phone_class === '') ? "" : ' class="' + clearOptions(e.data.ss_phone_class) + '"';
                                var tx_value = (e.data.ss_phone_value === '') ? "" : ' value="' + clearOptions(e.data.ss_phone_value) + '"';
                                var tx_placeholder = (e.data.ss_phone_placeholder === '') ? "" : ' placeholder="' + clearOptions(e.data.ss_phone_placeholder) + '"';
                                var tx_size = (e.data.ss_phone_size === '') ? "" : ' size="' + e.data.ss_phone_size + '"';
                                var tx_field = (e.data.ss_phone_editable === 'editable') ? "" : ' readonly';
                                editor.insertContent('[swift_phone name="' + txtboxName + '"' + tx_class + tx_value + tx_placeholder + textbox_required + tx_size + tx_field + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Address',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Address shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_address_name',
                                    label: 'Enter field name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_address_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_address_value',
                                    label: 'Enter value',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_address_placeholder',
                                    label: 'Enter placeholder',
                                    value: ''
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_address_size',
                                    label: 'Enter field size',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Medium', value: 'medium'},
                                        {text: 'Long', value: 'long'},
                                        {text: 'Full Line', value: 'fullline'}
                                    ],
                                    value: 'medium' // Sets the default
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_address_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_address_required_id',
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_address_editable',
                                    label: 'Field is',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Editable', value: 'editable'},
                                        {text: 'NonEditable', value: 'noneditable'},
                                    ],
                                    value: 'editable' // Sets the default
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_address_name === '') {
                                    editor.windowManager.alert('Please, fill field name.');
                                    return false;
                                }

                                txtboxName = clearInput(e.data.ss_address_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(txtboxName)) {
                                    txtboxName = txtboxName + "_" + new Date().getTime();
                                }

                                var textbox_required = (e.data.ss_address_required === true) ? " required" : "";
                                var tx_class = (e.data.ss_address_class === '') ? "" : ' class="' + clearOptions(e.data.ss_address_class) + '"';
                                var tx_value = (e.data.ss_address_value === '') ? "" : ' value="' + clearOptions(e.data.ss_address_value) + '"';
                                var tx_placeholder = (e.data.ss_address_placeholder === '') ? "" : ' placeholder="' + clearOptions(e.data.ss_address_placeholder) + '"';
                                var tx_field = (e.data.ss_address_editable === 'editable') ? "" : ' readonly';
                                var tx_size = (e.data.ss_address_size === '') ? "" : ' size="' + e.data.ss_address_size + '"';
                                editor.insertContent('[swift_address name="' + txtboxName + '"' + tx_class + tx_value + tx_placeholder + textbox_required + tx_size + tx_field + ']');
                            }
                        });
                    }
                },
                {
                    text: 'URL',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'URL shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_url_name',
                                    label: 'Enter URLbox name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_url_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_url_value',
                                    label: 'Enter value',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_url_placeholder',
                                    label: 'Enter placeholder',
                                    value: ''
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_url_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_url_required_id'
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_url_size',
                                    label: 'Enter field size',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Medium', value: 'medium'},
                                        {text: 'Long', value: 'long'},
                                        {text: 'Full Line', value: 'fullline'}
                                    ],
                                    value: 'medium' // Sets the default
                                },
                                {
                                    type: 'listbox',
                                    name: 'ss_url_editable',
                                    label: 'Field is',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Editable', value: 'editable'},
                                        {text: 'NonEditable', value: 'noneditable'},
                                    ],
                                    value: 'editable' // Sets the default
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_url_name === '') {
                                    editor.windowManager.alert('Please, fill URLbox name.');
                                    return false;
                                }

                                urlName = clearInput(e.data.ss_url_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(urlName)) {
                                    urlName = urlName + "_" + new Date().getTime();
                                }

                                var url_required = (e.data.ss_url_required === true) ? " required" : "";
                                var url_class = (e.data.ss_url_class === '') ? "" : ' class="' + clearOptions(e.data.ss_url_class) + '"';
                                var url_value = (e.data.ss_url_value === '') ? "" : ' value="' + clearOptions(e.data.ss_url_value) + '"';
                                var url_placeholder = (e.data.ss_url_placeholder === '') ? "" : ' placeholder="' + clearOptions(e.data.ss_url_placeholder) + '"';
                                var url_size = (e.data.ss_url_size === '') ? "" : ' size="' + e.data.ss_url_size + '"';
                                var url_field = (e.data.ss_url_editable === 'editable') ? "" : ' readonly';
                                editor.insertContent('[swift_url name="' + urlName + '"' + url_class + url_value + url_placeholder + url_required + url_size + url_field + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Checkbox',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Checkbox shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_chkbx_name',
                                    label: 'Enter checkbox name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_chkbx_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_chkbx_options',
                                    label: 'Enter options*',
                                    tooltip: 'comma seprated list of options',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_chkbx_checked',
                                    label: 'Enter pre-selected option',
                                    tooltip: 'option name which you want to pre-selected',
                                    value: ''
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_chkbx_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_chkbx_required_id'
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_chkbx_name === '') {
                                    editor.windowManager.alert('Please, fill checkbox name.');
                                    return false;
                                }

                                if (e.data.ss_chkbx_options === '') {
                                    editor.windowManager.alert('Please, fill options.' + e.data.ss_chkbx_options);
                                    return false;
                                }

                                chkboxName = clearInput(e.data.ss_chkbx_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(chkboxName)) {
                                    chkboxName = chkboxName + "_" + new Date().getTime();
                                }
                                var chkbx_required = (e.data.ss_chkbx_required === true) ? " required" : "";
                                var chkbx_class = (e.data.ss_chkbx_class === '') ? "" : ' class="' + clearOptions(e.data.ss_chkbx_class) + '"';
                                var chkbx_options = (e.data.ss_chkbx_options === '') ? "" : ' options="' + clearOptions(e.data.ss_chkbx_options) + '"';
                                var chkbx_checked = (e.data.ss_chkbx_checked === '') ? "" : ' checked="' + clearOptions(e.data.ss_chkbx_checked) + '"';
                                editor.insertContent('[swift_checkbox name="' + chkboxName + '"' + chkbx_class + chkbx_options + chkbx_checked + chkbx_required + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Check to Agree',
                    onclick: function() {
                        editor.insertContent('[swift_agree]');
                    }
                },
                {
                    text: 'Radio Buttons',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Radio button shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_rdbtn_name',
                                    label: 'Enter radio button name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_rdbtn_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_rdbtn_options',
                                    label: 'Enter options*',
                                    tooltip: 'comma seprated list of options',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_rdbtn_checked',
                                    label: 'Enter pre-selected option',
                                    tooltip: 'option name which you want to pre-selected',
                                    value: ''
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_rdbtn_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_rdbtn_required_id'
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_rdbtn_name === '') {
                                    editor.windowManager.alert('Please, fill checkbox name.');
                                    return false;
                                }
                                if (e.data.ss_rdbtn_options === '') {
                                    editor.windowManager.alert('Please, fill options.');
                                    return false;
                                }

                                radioName = clearInput(e.data.ss_rdbtn_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(radioName)) {
                                    radioName = radioName + "_" + new Date().getTime();
                                }

                                var rdbtn_required = (e.data.ss_rdbtn_required === true) ? " required" : "";
                                var rdbtn_class = (e.data.ss_rdbtn_class === '') ? "" : ' class="' + clearOptions(e.data.ss_rdbtn_class) + '"';
                                var rdbtn_options = (e.data.ss_rdbtn_options === '') ? "" : ' options="' + clearOptions(e.data.ss_rdbtn_options) + '"';
                                var rdbtn_checked = (e.data.ss_rdbtn_checked === '') ? "" : ' checked="' + clearOptions(e.data.ss_rdbtn_checked) + '"';
                                editor.insertContent('[swift_radio name="' + radioName + '"' + rdbtn_class + rdbtn_options + rdbtn_checked + rdbtn_required + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Circleword',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Circleword shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_cw_name',
                                    label: 'Enter circleword name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_cw_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_cw_options',
                                    label: 'Enter options*',
                                    tooltip: 'comma seprated list of options',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_cw_checked',
                                    label: 'Enter pre-selected option',
                                    tooltip: 'option name which you want to pre-selected',
                                    value: ''
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_cw_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_cw_required_id'
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_cw_name === '') {
                                    editor.windowManager.alert('Please, fill circleword name.');
                                    return false;
                                }
                                if (e.data.ss_cw_options === '') {
                                    editor.windowManager.alert('Please, fill options.');
                                    return false;
                                }

                                circleName = clearInput(e.data.ss_cw_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(circleName)) {
                                    circleName = circleName + "_" + new Date().getTime();
                                }

                                var cw_required = (e.data.ss_cw_required === true) ? " required" : "";
                                var cw_class = (e.data.ss_cw_class === '') ? "" : ' class="' + clearOptions(e.data.ss_cw_class) + '"';
                                var cw_options = (e.data.ss_cw_options === '') ? "" : ' options="' + clearOptions(e.data.ss_cw_options) + '"';
                                var cw_checked = (e.data.ss_cw_checked === '') ? "" : ' checked="' + clearOptions(e.data.ss_cw_checked) + '"';
                                editor.insertContent('[swift_circleword name="' + circleName + '"' + cw_class + cw_options + cw_checked + cw_required + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Dropdown',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Dropdown shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_dd_name',
                                    label: 'Enter dropdown name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_dd_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_dd_options',
                                    label: 'Enter options*',
                                    tooltip: 'comma seprated list of options',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_dd_selected',
                                    label: 'Enter pre-selected option',
                                    tooltip: 'option name which you want to pre-selected',
                                    value: ''
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_dd_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_dd_required_id'
                                }

                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_dd_name === '') {
                                    editor.windowManager.alert('Please, fill dropdown name.');
                                    return false;
                                }
                                if (e.data.ss_dd_options === '') {
                                    editor.windowManager.alert('Please, fill options.');
                                    return false;
                                }

                                dropdownName = clearInput(e.data.ss_dd_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(dropdownName)) {
                                    dropdownName = dropdownName + "_" + new Date().getTime();
                                }

                                var dd_required = (e.data.ss_dd_required === true) ? " required" : "";
                                var dd_class = (e.data.ss_dd_class === '') ? "" : ' class="' + clearOptions(e.data.ss_dd_class) + '"';
                                var dd_options = (e.data.ss_dd_options === '') ? "" : ' option_values="' + clearOptions(e.data.ss_dd_options) + '"';
                                var dd_checked = (e.data.ss_dd_selected === '') ? "" : ' selected_option="' + clearOptions(e.data.ss_dd_selected) + '"';

                                editor.insertContent('[swift_dropdown name="' + dropdownName + '"' + dd_class + dd_options + dd_checked + dd_required + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Date',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Datepicker shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_dt_name',
                                    label: 'Enter date picker name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_dt_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_dt_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_dt_required_id',
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_dt_name === '') {
                                    editor.windowManager.alert('Please, fill date picker name.');
                                    return false;
                                }

                                dateName = clearInput(e.data.ss_dt_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(dateName)) {
                                    dateName = dateName + "_" + new Date().getTime();
                                }

                                var dt_required = (e.data.ss_dt_required === true) ? " required" : "";
                                var dt_class = (e.data.ss_dt_class === '') ? "" : ' class="' + clearOptions(e.data.ss_dt_class) + '"';
                                editor.insertContent('[swift_date name="' + dateName + '"' + dt_class + dt_required + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Date Dropdown',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Date Dropdown shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_dd_name',
                                    label: 'Enter date dropdown name*',
                                    value: ''
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_dd_class',
                                    label: 'Enter class name',
                                    value: ''
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_dd_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_dd_required_id',
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_dd_name === '') {
                                    editor.windowManager.alert('Please, fill date dropdown name.');
                                    return false;
                                }

                                dateName = clearInput(e.data.ss_dd_name);
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(dateName)) {
                                    dateName = dateName + "_" + new Date().getTime();
                                }

                                var dt_required = (e.data.ss_dd_required === true) ? " required" : "";
                                var dt_class = (e.data.ss_dd_class === '') ? "" : ' class="' + clearOptions(e.data.ss_dd_class) + '"';
                                editor.insertContent('[swift_date_dropdown name="' + dateName + '"' + dt_class + dt_required + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Date Today',
                    onclick: function() {
                        editor.insertContent('[swift_date_today]');
                    }
                },
                {
                    text: 'Date Long',
                    onclick: function() {
                        editor.insertContent('[swift_date_long]');
                    }
                },
                {
                    text: 'Date Time Now',
                    onclick: function() {
                        editor.insertContent('[swift_date_time_now]');
                    }
                },
                {
                    text: 'Capture Name',
                    onclick: function() {
                        editor.insertContent('[swiftsign_capture_name]');
                    }
                },
                {
                    text: 'Affiliate / Source Name (Hidden)',
                    onclick: function() {
                        editor.insertContent('[swiftsign_affiliate_name]');
                    }
                },
                {
                    text: 'File Upload',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'File Upload shortcode',
                            body: [
                                {
                                    type: 'textbox',
                                    name: 'ss_fileupload_name',
                                    label: 'File Upload Name',
                                    value: '',
                                    tooltip: 'No spaces allowed; will not show to visitors.'
                                },
                                {
                                    type: 'textbox',
                                    name: 'ss_fileupload_class',
                                    label: 'CSS Class Name',
                                    value: '',
                                    tooltip: 'Optional. Used by designers and programmers to override the visual styling.'
                                },
                                {
                                    type: 'checkbox',
                                    name: 'ss_fileupload_required',
                                    label: 'Required',
                                    text: '',
                                    id: 'ss_fileupload_required_id',
                                }
                            ],
                            onsubmit: function(e) {
                                if (e.data.ss_fileupload_name === '') {
                                    editor.windowManager.alert('Please, fill textbox name.');
                                    return false;
                                }

                                var fileUploadName = clearInput(e.data.ss_fileupload_name);
                                var pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes(fileUploadName)) {
                                    fileUploadName = fileUploadName + "_" + new Date().getTime();
                                }

                                var textbox_required = (e.data.ss_fileupload_required === true) ? " required" : "";
                                var tx_class = (e.data.ss_fileupload_class === '') ? "" : ' class="' + clearOptions(e.data.ss_fileupload_class) + '"';
                                editor.insertContent('[swift_file_upload name="' + fileUploadName + '"' + tx_class + textbox_required + ']');
                            }
                        });
                    }
                },
                {
                    text: 'Webcam',
                    onclick: function() {
                        editor.windowManager.open({
                            title: 'Webcam shortcode',
                            body: [
                                {
                                    type: 'listbox',
                                    name: 'ss_size',
                                    label: 'Enter webcam box size',
                                    minWidth: 100,
                                    values: [
                                        {text: 'Small', value: 'small'},
                                        {text: 'Medium', value: 'medium'},
                                        {text: 'Large', value: 'large'}
                                    ],
                                    value: 'small', // Sets the default
                                },
                            ],
                            onsubmit: function(e) {
                                pageContent = editor.getContent().toLowerCase();

                                if (pageContent.includes('swift_webcam')) {
                                    editor.windowManager.alert('Webcam field already exist. You can add webcam field only one time in this form');
                                    return false;
                                }
                                editor.insertContent('[swift_webcam size=&quot;' + e.data.ss_size + '&quot;]');
                            }
                        });
                    }
                },
                {
                    text: 'ID Custom Field',
                    onclick: function() {
                        pageContent = editor.getContent().toLowerCase();
                        if (pageContent.includes('swift_webcam')) {
                            editor.windowManager.alert('Webcam field already exist. You can add webcam field only one time in this form');
                            return false;
                        }
                        editor.insertContent('[swift_ID]');
                    }
                },
            ]
        });
    });
})();