<div class="cfsFormOptRow">
	<label>
		<?php echo htmlCfs::checkbox('params[tpl][enb_subscribe]', array(
			'checked' => htmlCfs::checkedOpt($this->form['params']['tpl'], 'enb_subscribe'),
			'attrs' => 'data-switch-block="subShell"',
		))?>
		<?php  _e('Enable Subscription', CFS_LANG_CODE)?>
	</label>
</div>
<span data-block-to-switch="subShell">
	<table class="form-table cfsSubShellMainTbl" style="width: auto;">
		<tr>
			<th scope="row">
				<?php _e('Subscribe to', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Destination for your Subscribers.', CFS_LANG_CODE))?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::selectbox('params[tpl][sub_dest]', array(
					'options' => $this->subDestListForSelect, 
					'value' => (isset($this->form['params']['tpl']['sub_dest']) ? $this->form['params']['tpl']['sub_dest'] : '')))?>
			</td>
		</tr>
		<?php
			foreach($this->subDestListForSelect as $subModKey => $subLabel) {
				if(frameCfs::_()->getModule( $subModKey )) {
					echo frameCfs::_()->getModule( $subModKey )->getView()->generateAdminFields( $this->form );
				} else { ?>
					<tr class="cfsFormSubDestOpts cfsFormSubDestOpts_<?php echo $subModKey?>">
						<th scope="row">
							<?php _e('Activate License or update PRO version plugin', CFS_LANG_CODE)?>
							<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(__('Apparently - you have installed PRO version, but did not activate it license - then please activate it. Or you have old version of plugin - then you need go to Plugins page and Update PRO version plugin, after this go to License tab and re-activate license (just click one more time on "Activate" button).', CFS_LANG_CODE))?>"></i>
						</th>
						<td>
							<a href="<?php echo frameCfs::_()->getModule('options')->getTabUrl('license');?>" class="button"><?php _e('Activate License', CFS_LANG_CODE)?></a>
						</td>
					</tr>
				<?php }
			}
		?>
		<?php /*TODO: Check - if this button required in this plugin at all*/ ?>
		<?php /*?><tr>
			<th scope="row">
				<?php _e('Subscribe with Facebook', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php echo esc_html(sprintf(__('Add button to your Form with possibility to subscribe just in one click - without filling fields in your subscribe form, <img src="%s" />', CFS_LANG_CODE), $this->promoModPath. 'img/fb-subscribe.jpg'))?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::checkbox('params[tpl][sub_enb_fb_subscribe]', array(
					'attrs' => 'class="cfsProOpt"',
					'checked' => htmlCfs::checkedOpt($this->form['params']['tpl'], 'sub_enb_fb_subscribe')))?>
			</td>
		</tr><?php */?>
		<tr class="cfsFormSubCreateWpUser">
			<th scope="row">
				<?php _e('Create WP user', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php echo _e('Once user will subscribe to selected Subscription service - it will create WordPress Subscriber too. PLease be carefull using this option: WordPressusers will be created right after you submit your Subscribe form without confirmation.', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::checkbox('params[tpl][sub_create_wp_user]', array(
					'checked' => htmlCfs::checkedOpt($this->form['params']['tpl'], 'sub_create_wp_user')))?>
			</td>
		</tr>
	</table>
	<table class="form-table cfsSubShellOptsTbl">
		<tr class="cfsFormSubTxtsAndRedirect" style="display: none;">
			<th scope="row">
				<?php _e('"Confirmation sent" message', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('This is the message that the user will see after subscription, when letter with confirmation link was sent.', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_txt_confirm_sent]', array(
					'value' => (isset($this->form['params']['tpl']['sub_txt_confirm_sent']) ? esc_html( $this->form['params']['tpl']['sub_txt_confirm_sent'] ) : __('Confirmation link was sent to your email address. Check your email!', CFS_LANG_CODE)),
				))?>
			</td>
		</tr>
		<tr class="cfsFormSubTxtsAndRedirect" style="display: none;">
			<th scope="row">
				<?php _e('Subscribe success message', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('Right after subscriber will be created and confirmed - this message will be shown.', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_txt_success]', array(
					'value' => (isset($this->form['params']['tpl']['sub_txt_success']) ? esc_html( $this->form['params']['tpl']['sub_txt_success'] ) : __('Thank you for subscribing!', CFS_LANG_CODE)),
				))?>
			</td>
		</tr>
		<tr class="cfsFormSubTxtsAndRedirect" style="display: none;">
			<th scope="row">
				<?php _e('Email error message', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('If email that was entered by user is invalid, user will see this message', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_txt_invalid_email]', array(
					'value' => (isset($this->form['params']['tpl']['sub_txt_invalid_email']) ? esc_html( $this->form['params']['tpl']['sub_txt_invalid_email'] ) : __('Empty or invalid email', CFS_LANG_CODE)),
				))?>
			</td>
		</tr>
		<tr class="cfsFormSubTxtsAndRedirect" style="display: none;">
			<th scope="row">
				<?php _e('Email exists error message', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('If email that was entered by user already exists - user will see this message. But be careful: this can be used by hackers - to detect existing email in your database, so it\'s better for you to leave this message same as error message about invalid email above.', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_txt_exists_email]', array(
					'value' => (isset($this->form['params']['tpl']['sub_txt_exists_email']) ? esc_html( $this->form['params']['tpl']['sub_txt_exists_email'] ) : __('Empty or invalid email', CFS_LANG_CODE)),
				))?>
			</td>
		</tr>
		<tr class="cfsFormSubRedirect">
			<th scope="row">
				<?php _e('Redirect after subscription URL', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('You can enable redirection after subscription, just enter here URL that you want to redirect to after subscribe - and user will be redirected there. If you don\'t need this feature - just leave this field empty.', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_redirect_url]', array(
					'value' => (isset($this->form['params']['tpl']['sub_redirect_url']) ? esc_url( $this->form['params']['tpl']['sub_redirect_url'] ) : ''),
					'attrs' => 'placeholder="http://example.com"',
				))?>
				<label>
					<?php echo htmlCfs::checkbox('params[tpl][sub_redirect_new_wnd]', array(
						'checked' => htmlCfs::checkedOpt($this->form['params']['tpl'], 'sub_redirect_new_wnd')))?>
					<?php _e('Open in a new window (tab)', CFS_LANG_CODE)?>
				</label>
			</td>
		</tr>
		<tr class="cfsFormSubEmailTxt" style="display: none;">
			<th scope="row">
				<?php _e('Confirmation email subject', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('Email with confirmation link subject', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_txt_confirm_mail_subject]', array(
					'value' => esc_html ( isset($this->form['params']['tpl']['sub_txt_confirm_mail_subject']) 
						? $this->form['params']['tpl']['sub_txt_confirm_mail_subject'] 
						: __('Confirm subscription on [sitename]', CFS_LANG_CODE)),
				))?>
			</td>
		</tr>
		<tr class="cfsFormSubEmailTxt" style="display: none;">
			<th scope="row">
				<?php _e('Confirmation email From field', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('Email with confirmation link From field', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_txt_confirm_mail_from]', array(
					'value' => esc_html ( isset($this->form['params']['tpl']['sub_txt_confirm_mail_from']) 
						? $this->form['params']['tpl']['sub_txt_confirm_mail_from'] 
						: $this->adminEmail),
				))?>
			</td>
		</tr>
		<tr class="cfsFormSubEmailTxt" style="display: none;">
			<th scope="row">
				<?php _e('Confirmation email text', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('Email with confirmation link content', CFS_LANG_CODE)?>"></i>
				<?php $allowVarsInMail = array('sitename', 'siteurl', 'confirm_link', 'subscribe_url');?>
				<?php if(isset($this->form['params']['tpl']['sub_fields']) && !empty($this->form['params']['tpl']['sub_fields'])) {
					foreach($this->form['params']['tpl']['sub_fields'] as $fName => $fData) {
						$allowVarsInMail[] = 'user_'. $fName;
					}
				}?>
				<div class="description"><?php printf(__('You can use next variables here: %s, and any other subscribe field value - just place here [user_FIELD_NAME], where FIELD_NAME - is name attribute of required field.', CFS_LANG_CODE), '['. implode('], [', $allowVarsInMail).']')?></div>
			</th>
			<td>
				<?php echo htmlCfs::textarea('params[tpl][sub_txt_confirm_mail_message]', array(
					'value' => esc_html( isset($this->form['params']['tpl']['sub_txt_confirm_mail_message']) 
						? $this->form['params']['tpl']['sub_txt_confirm_mail_message'] 
						: __('You subscribed on site <a href="[siteurl]">[sitename]</a>. Follow <a href="[confirm_link]">this link</a> to complete your subscription. If you did not subscribe here - just ignore this message.', CFS_LANG_CODE)),
				))?><br />
				<div class="cfsFormAttachFilesShell" data-key="confirm">
					<a href="#" class="button cfsFormAddEmailAttachBtn"><i class="fa fa-plus"></i><?php _e('Add Attach', CFS_LANG_CODE)?></a>
				</div>
			</td>
		</tr>
		<tr class="cfsFormSubEmailTxt" style="display: none;">
			<th scope="row">
				<?php _e('New Subscriber email subject', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('Email to New Subscriber subject', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_txt_subscriber_mail_subject]', array(
					'value' => esc_html ( isset($this->form['params']['tpl']['sub_txt_subscriber_mail_subject']) 
						? $this->form['params']['tpl']['sub_txt_subscriber_mail_subject'] 
						: __('[sitename] Your username and password', CFS_LANG_CODE)),
				))?>
			</td>
		</tr>
		<tr class="cfsFormSubEmailTxt" style="display: none;">
			<th scope="row">
				<?php _e('New Subscriber email From field', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('New Subscriber email From field', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_txt_subscriber_mail_from]', array(
					'value' => esc_html ( isset($this->form['params']['tpl']['sub_txt_subscriber_mail_from']) 
						? $this->form['params']['tpl']['sub_txt_subscriber_mail_from'] 
						: $this->adminEmail),
				))?>
			</td>
		</tr>
		<tr class="cfsFormSubEmailTxt" style="display: none;">
			<th scope="row">
				<?php _e('New Subscriber email text', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('Email to New Subscriber content', CFS_LANG_CODE)?>"></i>
				<?php $allowVarsInMail = array('user_login', 'user_email', 'password', 'login_url', 'sitename', 'siteurl', 'subscribe_url');?>
				<?php if(isset($this->form['params']['tpl']['sub_fields']) && !empty($this->form['params']['tpl']['sub_fields'])) {
					foreach($this->form['params']['tpl']['sub_fields'] as $fName => $fData) {
						$allowVarsInMail[] = 'user_'. $fName;
					}
				}?>
				<div class="description" style=""><?php printf(__('You can use next variables here: %s, and any other subscribe field value - just place here [user_FIELD_NAME], where FIELD_NAME - is name attribute of required field.', CFS_LANG_CODE), '['. implode('], [', $allowVarsInMail).']')?></div>
			</th>
			<td>
				<?php echo htmlCfs::textarea('params[tpl][sub_txt_subscriber_mail_message]', array(
					'value' => esc_html( isset($this->form['params']['tpl']['sub_txt_subscriber_mail_message']) 
						? $this->form['params']['tpl']['sub_txt_subscriber_mail_message'] 
						: __('Username: [user_login]<br />Password: [password]<br />[login_url]', CFS_LANG_CODE)),
				))?><br />
				<div class="cfsFormAttachFilesShell" data-key="subscriber">
					<a href="#" class="button cfsFormAddEmailAttachBtn"><i class="fa fa-plus"></i><?php _e('Add Attach', CFS_LANG_CODE)?></a>
				</div>
			</td>
		</tr>
		<tr class="cfsFormSubEmailTxt" style="display: none;">
			<th scope="row">
				<?php _e('Redirect if email already exists', CFS_LANG_CODE)?>
				<i class="fa fa-question supsystic-tooltip" title="<?php _e('Link to redirect to if user subscribes - but this email already exists', CFS_LANG_CODE)?>"></i>
			</th>
			<td>
				<?php echo htmlCfs::text('params[tpl][sub_redirect_email_exists]', array(
					'value' => esc_html ( isset($this->form['params']['tpl']['sub_redirect_email_exists']) 
						? $this->form['params']['tpl']['sub_redirect_email_exists'] 
						: ''),
					'attrs' => 'placeholder="http://example.com"'
				))?>
			</td>
		</tr>
	</table>
</span>
<div id="cfsFormAttachShell" class="cfsFormAttachShell">
	<a href="#" class="button cfsFormAttachBtn"><?php _e('Select File', CFS_LANG_CODE)?></a>
	<?php echo htmlCfs::hidden('params[tpl][sub_attach][]', array(
		'disabled' => true,
	))?>
	<span class="cfsFormAttachFile"></span>
	<a href="#" class="button cfsFormAttachRemoveBtn" title="<?php _e('Remove', CFS_LANG_CODE)?>"><i class="fa fa-trash"></i></a>
</div>