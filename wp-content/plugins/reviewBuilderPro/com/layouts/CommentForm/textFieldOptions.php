<div class="sg-row">
	<div class="sgrb-field-options-wrapper">
		<div class="sg-row sgrb-field-options-row">
			<div class="sg-col-3">
				<label for="sgrb-for-admin">
					<span class="sgrb-form-field-options-title"><?php echo _e('Hide on front end: ', 'sgrb');?></span>
				</label>
			</div>
			<div class="sg-col-7">
				<label>
					<input id="sgrb-for-admin" type="checkbox" name="isHidden">
				</label>
			</div>
		</div>
		<div class="sg-row sgrb-field-options-row">
			<div class="sg-col-3">
				<label for="sgrb-text-is-required">
					<span class="sgrb-form-field-options-title"><?php echo _e('Required: ', 'sgrb');?></span>
				</label>
			</div>
			<div class="sg-col-7">
				<label>
					<input id="sgrb-text-is-required" type="checkbox" name="isRequired">
				</label>
			</div>
		</div>
		<div class="sg-row sgrb-field-options-row">
			<div class="sg-col-3">
				<label for="sgrb-text-label">
					<span class="sgrb-form-field-options-title"><?php echo _e('Field label: ', 'sgrb');?></span>
				</label>
			</div>
			<div class="sg-col-9">
				<input id="sgrb-text-label" type="text" name="textLabel" placeholder="label" class="sgrb-field-options-inputs sgrb-attributes-input">
			</div>
			<div>
				<input type="hidden" name="textLabelHidden">
			</div>
		</div>
		<div class="sg-row sgrb-field-options-row">
			<div class="sg-col-3">
				<label for="sgrb-text-placeholder">
					<span class="sgrb-form-field-options-title"><?php echo _e(' Field placeholder: ', 'sgrb');?></span>
				</label>
			</div>
			<div class="sg-col-9">
				<input id="sgrb-text-placeholder" type="text" name="textPlaceholder" placeholder="placeholder" class="sgrb-field-options-inputs sgrb-attributes-input">
			</div>
			<div>
				<input type="hidden" name="textPlaceholderHidden">
			</div>
		</div>
		<div class="sg-row sgrb-field-options-row">
			<div class="sg-col-3">
				<label for="sgrb-text-field-id">
					<span class="sgrb-form-field-options-title"><?php echo _e('ID attribute: ', 'sgrb');?></span>
				</label>
			</div>
			<div class="sg-col-9">
				<input id="sgrb-text-field-id" type="text" name="textId" placeholder="id" class="sgrb-field-options-inputs sgrb-attributes-input">
			</div>
			<div>
				<input type="hidden" name="textIdHidden">
			</div>
		</div>
		<div class="sg-row sgrb-field-options-row">
			<div class="sg-col-3">
				<label for="sgrb-text-field-class">
					<span class="sgrb-form-field-options-title"><?php echo _e('Class attribute: ', 'sgrb');?></span>
				</label>
			</div>
			<div class="sg-col-9">
				<input id="sgrb-text-field-class" type="text" name="textClass" placeholder="class" class="sgrb-field-options-inputs sgrb-attributes-input">
			</div>
			<div>
				<input type="hidden" name="textClassHidden">
			</div>
		</div>

		<div class="sg-row sgrb-field-options-row">
			<div class="sg-col-3">
				<label for="sgrb-text-field-style">
					<span class="sgrb-form-field-options-title"><?php echo _e('Style attribute: ', 'sgrb');?></span>
				</label>
			</div>
			<div class="sg-col-9">
				<input id="sgrb-text-field-style" type="text" name="textStyle" placeholder="style" class="sgrb-field-options-inputs sgrb-attributes-input">
			</div>
			<div>
				<input type="hidden" name="textStyleHidden">
			</div>
		</div>
	</div>

	<div class="sg-row sgrb-field-options-row">
		<div class="sg-col-12">
			<input type="button" class="button button-primary sgrb-insert-js" value="Insert tag" disabled>
		</div>
		<div>
			<textarea name="createdTextTag" class="sgrb-field-options-inputs sgrb-created-text-tag"></textarea>
		</div>
	</div>
</div>
