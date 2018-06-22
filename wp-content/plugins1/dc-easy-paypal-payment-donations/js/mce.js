(function() {
	tinymce.PluginManager.add('wp_paypal_module', function( editor, url ) {
		editor.addButton( 'wp_paypal_module', {
			icon: 'wp-paypal-module',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Easy Wordpress Paypal Payment / Donation Plugin',
					body: [, {
							type: 'listbox',
							name: 'wpm_payment_type',
							label: 'Payment Type',
							'values': [
								{text: 'Buy Now', value: 'buynow'},
								{text: 'Donate', value: 'donate'},								
								{text: 'Add to Cart', value: 'cart'},
								{text: 'Subscribe', value: 'subscribe'}
							]
						}, {
							type: 'listbox',
							name: 'wpm_logo_or_text_choice',
							label: 'Logo or Text?',
							'values': [
								{text: 'Logo', value: 'logo'},
								{text: 'Text', value: 'text'},
								{text: 'None', value: 'none'}								
							]
						}, {
							type: 'textbox',
							name: 'wpm_logo_or_text',
							label: 'Logo URL or Text',
							value: 'http://www.paypal.com/en_US/i/btn/x-click-but04.gif'
						}, {
							type: 'textbox',
							name: 'wpm_paypal_email',
							label: 'Paypal Email',
							value: ''
						}, {
							type: 'textbox',
							name: 'wpm_paypal_org',
							label: 'Paypal Organisation',
							value: ''
						}, {
							type: 'listbox',
							name: 'wpm_editable_currency',
							label: 'Currency On/Off',
							'values': [
								{text: 'No', value: 'false'},
								{text: 'Yes', value: 'true'}																														
							]
						}, {
							type: 'listbox',
							name: 'wpm_editable_amount',
							label: 'Value Textbox On/Off',
							'values': [
								{text: 'No', value: 'false'},
								{text: 'Yes', value: 'true'}																														
							]
						}, {
							type: 'listbox',
							name: 'wpm_default_currency',
							label: 'Default Currency',
							'values': [
								{text: 'Canadian Dollar', value: 'CAD'},
								{text: 'U.S. Dollar', value: 'USD'},
								{text: 'Pound Sterling', value: 'GBP'},
								{text: 'Australian Dollar', value: 'AUD'},
								{text: 'Japanese Yen', value: 'JPY'},
								{text: 'Euro', value: 'EUR'},
								{text: 'Swiss Franc', value: 'CHF'},
								{text: 'Czech Koruna', value: 'CZK'},
								{text: 'Danish Krone', value: 'DKK'},	
								{text: 'Hong Kong Dollar', value: 'HKD'},
								{text: 'Hungarian Forint', value: 'HUF'},
								{text: 'Norwegian Krone', value: 'NOK'},
								{text: 'New Zealand Dollar', value: 'NZD'},
								{text: 'Polish Zloty', value: 'PLN'},								
								{text: 'Swedish Krona', value: 'SEK'},
								{text: 'Singapore Dollar', value: 'SGD'}
							]
						}, {
							type: 'textbox',
							name: 'wpm_button_text',
							label: 'Button text',
							value: 'Donate'
						}, {
							type: 'textbox',
							name: 'wpm_enter_amount_text',
							label: 'Enter Amount Text',
							value: 'Enter Amount'
						}, {
							type: 'textbox',
							name: 'wpm_paypal_amount',
							label: 'Paypal Amount',
							value: ''
						}, {
							type: 'textbox',
							name: 'wpm_smallest_paypal_amount',
							label: 'Smallest Paypal Amount',
							value: ''
						}, {
							type: 'textbox',
							name: 'wpm_return',
							label: 'Success Url',
							value: ''
						}, {
							type: 'textbox',
							name: 'wpm_cancel',
							label: 'Cancel Url',
							value: ''
						}, {
							type: 'listbox',
							name: 'wpm_locale',
							label: 'Locale',
							'values': [
								{text: 'United States', value: 'US'},
								{text: 'Australia', value: 'AU'},
								{text: 'Austria', value: 'AT'},
								{text: 'Belgium', value: 'BE'},
								{text: 'Brazil', value: 'BR'},
								{text: 'Canada', value: 'CA'},
								{text: 'Switzerland', value: 'CH'},	
								{text: 'China', value: 'CN'},	
								{text: 'Germany', value: 'DE'},
								{text: 'Spain', value: 'ES'},
								{text: 'United Kingdom', value: 'GB'},
								{text: 'France', value: 'FR'},
								{text: 'Italy', value: 'IT'},
								{text: 'Netherlands', value: 'NL'},
								{text: 'Poland', value: 'PL'},
								{text: 'Portugal', value: 'PT'},
								{text: 'Russia', value: 'RU'}
							]
						}
					],
					onsubmit: function( e ) {
						editor.insertContent('[paypalbutton type="'+e.data.wpm_payment_type+'" logoortextchoice="'+e.data.wpm_logo_or_text_choice+'" logoortext="'+e.data.wpm_logo_or_text+'" class="'+e.data.wpm_module_class_suffix+'" paypalemail="'+e.data.wpm_paypal_email+'" paypalorg="'+e.data.wpm_paypal_org+'" editablecurrency="'+e.data.wpm_editable_currency+'" editableamount="'+e.data.wpm_editable_amount+'" defaultcurrency="'+e.data.wpm_default_currency+'" buttontext="'+e.data.wpm_button_text+'" enteramount="'+e.data.wpm_enter_amount_text+'" paypalamount="'+e.data.wpm_paypal_amount+'" smallestpaypalamount="'+e.data.wpm_smallest_paypal_amount+'" return="'+e.data.wpm_return+'" cancel="'+e.data.wpm_cancel+'" locale="'+e.data.wpm_locale+'"]');
					}
				});
			}
		});
	});
})();