<div id="cfsClShell">
	
</div>
<a href="#" class="button button-primary cfsClAddBlockBtn">
	<i class="fa fa-plus fa-fw"></i>
	<?php _e('Add New Conditional Logic', CFS_LANG_CODE)?>
</a>
<div id="cfsClBlockShellEx" class="cfsClBlockShell">
	<fieldset>
		<legend>
			<div class="cfsClLabel">
				<a href="#" class="button cfsClBlockToggleBtn" title="<?php _e('Show / Hide Settings', CFS_LANG_CODE)?>">
					<i class="fa fa-minus cfsClBlockToggleClose cfsClBlockToggleIcon"></i>
					<i class="fa fa-plus cfsClBlockToggleOpen cfsClBlockToggleIcon"></i>
				</a>
				<?php echo htmlCfs::text('params[cl][][label]', array(
					'attrs' => 'class="cfsClLabelTxt"',
					'disabled' => true,
				))?>
				<a href="#" class="button cfsClBlockRemoveBtn">
					<i class="fa fa-trash"></i>
				</a>
			</div>
		</legend>
		<div class="cfsClInnerShell">
			<div class="cfsClConditions">
				<p>
					<i class="fa fa-question supsystic-tooltip sup-no-init" title="<?php echo esc_html(__('Your conditions', CFS_LANG_CODE))?>"></i>
					<span class="cfsClSubLabel"><?php _e('Conditions', CFS_LANG_CODE)?></span>
					<a href="#" class="button cfsClAddCondBtn">
						<i class="fa fa-plus"></i>
						<?php _e('Add Condition', CFS_LANG_CODE)?>
					</a>
				</p>
				<div class="cfsClCondShell"></div>
				<hr />
			</div>
			<div class="cfsClLogics">
				<p>
					<i class="fa fa-question supsystic-tooltip sup-no-init" title="<?php echo esc_html(__('Your actions', CFS_LANG_CODE))?>"></i>
					<span class="cfsClSubLabel"><?php _e('Actions', CFS_LANG_CODE)?></span>
					<a href="#" class="button cfsClAddLogicBtn">
						<i class="fa fa-plus"></i>
						<?php _e('Add Action', CFS_LANG_CODE)?>
					</a>
				</p>
				<div class="cfsClLogicsShell"></div>
			</div>
		</div>
	</fieldset>
</div>
<div id="cfsClConditionShellEx" class="cfsClConditionShell">
	<div class="cfsClCondition">
		<?php echo htmlCfs::selectbox('params[cl][][cond][][type]', array(
			'options' => $this->conditionTypes,
			'value' => 'field',
			'disabled' => true,
			'attrs' => 'class="cfsClCondTypeSel"'
		))?>
		<span class="cfsClCond" data-type="field">
			<?php echo htmlCfs::selectbox('params[cl][][cond][][field]', array(
				'attrs' => 'class="cfsClFieldSel"',
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClCond" data-type="field">
			<?php echo htmlCfs::selectbox('params[cl][][cond][][field_eq]', array(
				'options' => $this->conditionEqs,
				'value' => 'eq',
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClCond" data-type="field">
			<?php echo htmlCfs::text('params[cl][][cond][][field_eq_to]', array(
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClCond" data-type="user">
			<?php echo htmlCfs::selectbox('params[cl][][cond][][user_type]', array(
				'options' => $this->userConditionTypes,
				'value' => 'country',
				'attrs' => 'class="cfsClUserTypeSel"',
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClCond" data-type="user" data-user-type="country">
			<?php echo htmlCfs::countryListMultiple('params[cl][][cond][][user_country]', array(
				'attrs' => 'data-placeholder="'. __('Select Country', CFS_LANG_CODE). '"',
				'listBy' => 'iso_code_2',
				'notSelected' => false,
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClCond" data-type="user" data-user-type="lang">
			<?php echo htmlCfs::selectlist('params[cl][][cond][][user_lang]', array(
				'options' => $this->languages,
				'attrs' => 'data-placeholder="'. __('Select Language', CFS_LANG_CODE). '"',
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClCond" data-type="user" data-user-type="url">
			<?php echo htmlCfs::selectbox('params[cl][][cond][][url_eq]', array(
				'options' => $this->userUrlEqs,
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClCond" data-type="user" data-user-type="url">
			<?php echo htmlCfs::text('params[cl][][cond][][url_eq_to]', array(
				'disabled' => true,
			))?>
		</span>
		<a href="#" title="<?php _e('Remove Condition', CFS_LANG_CODE)?>" class="button cfsClCondRemoveBtn">
			<i class="fa fa-trash fa-fw"></i>
		</a>
		<span class="cfsClCondNextEqShell">
			<?php echo htmlCfs::selectbox('params[cl][][cond][][next_eq]', array(
				'options' => $this->booleanEqs,
				'value' => 'or',
				'disabled' => true,
			))?>
		</span>
	</div>
</div>
<div id="cfsClLogicShellEx" class="cfsClLogicShell">
	<div class="cfsClLogics">
		<?php echo htmlCfs::selectbox('params[cl][][logic][][type]', array(
			'options' => $this->logicTypes,
			'value' => 'field',
			'disabled' => true,
			'attrs' => 'class="cfsClLogicTypeSel"'
		))?>
		<span class="cfsClLog" data-type="field">
			<?php echo htmlCfs::selectlist('params[cl][][logic][][fields]', array(
				'attrs' => 'class="cfsClFieldSel" data-placeholder="'. __('Select Field', CFS_LANG_CODE). '"',
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClLog" data-type="field">
			<?php echo htmlCfs::selectbox('params[cl][][logic][][field_act]', array(
				'options' => $this->logicFieldActions,
				'attrs' => 'class="cfsClFieldActionSel"',
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClLog" data-type="field" data-field-act="prefill,add,substruct,add_currency,substruct_currency">
			<?php echo htmlCfs::text('params[cl][][logic][][field_prefill]', array(
				'disabled' => true,
			))?>
		</span>
		<span class="cfsClLog" data-type="redirect">
			<?php _e('to', CFS_LANG_CODE)?>
			<?php echo htmlCfs::text('params[cl][][logic][][redirect_url]', array(
				'attrs' => 'placeholder="'. __('URL', CFS_LANG_CODE). '"',
				'disabled' => true,
			))?>
			<label title="<?php _e('Redirect after form will be submitted', CFS_LANG_CODE)?>">
				<?php _e('After submit', CFS_LANG_CODE)?>
				<?php echo htmlCfs::checkbox('params[cl][][logic][][redirect_after_submit]', array(
					'attrs' => 'class="sup-no-init"',
					'disabled' => true,
				))?>
			</label>
		</span>
		<span class="cfsClLog" data-type="sendto">
			<?php echo htmlCfs::text('params[cl][][logic][][sendto]', array(
				'attrs' => 'placeholder="'. __('E-Mail', CFS_LANG_CODE). '"',
				'disabled' => true,
			))?>
		</span>
		<a href="#" title="<?php _e('Remove Action', CFS_LANG_CODE)?>" class="button cfsClLogicRemoveBtn">
			<i class="fa fa-trash fa-fw"></i>
		</a>
	</div>
</div>
