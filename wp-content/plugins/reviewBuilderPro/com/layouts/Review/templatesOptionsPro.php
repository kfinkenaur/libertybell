<div class="sgrb-template-options">
	<div class="sg-row">
		<div class="sg-col-4">
			<div class="sgrb-total-options-rows-rate-type">
				<p style="margin: 4px 0"><?php echo _e('Font', 'sgrb');?>: </p>
				<span>
					<div id="selectFonts" class="bfh-selectbox bfh-googlefonts" data-font="<?=@$sgrbDataArray['template-font']?>">
						<span class="caret selectbox-caret"></span>
					</div>
					<span id="drop"></span>
					<input class="fontSelectbox" type="hidden" name="fontSelectbox" value="">
				</span>
			</div>
			<div class="sgrb-total-options-rows-rate-type">
				<p style="margin: 3px 0"><?php echo _e('Background color', 'sgrb');?>: </p>
				<span><input name="template-background-color" type="text" value="<?php echo esc_attr(@$sgrbDataArray['template-background-color']);?>" class="color-picker" /></span>
			</div>
			<div class="sgrb-total-options-rows-rate-type">
				<p style="margin: 3px 0"><?php echo _e('Text color', 'sgrb');?>: </p>
				<span><input name="template-text-color" type="text" value="<?php echo esc_attr(@$sgrbDataArray['template-text-color']);?>" class="color-picker" /></span>
			</div>
		</div>
		<div class="sg-col-5">
			<div class="sgrb-total-options-rows-rate-type">
				<p><label for="sgrb-template-shadow-on"><input id="sgrb-template-shadow-on" name="template-field-shadow-on" value="true" type="checkbox"<?php echo (@$sgrbDataArray['template-field-shadow-on']) ? ' checked' : '' ?>> <?php echo _e('Template inner boxes shadow effect', 'sgrb');?> </label></p>
			</div>
			<div class="sgrb-single-option">
				<div class="sgrb-option-title-side"><?php echo _e('Color', 'sgrb');?>: </div><div style="float:right;"><input style="" name="template-shadow-color" type="text" value="<?=@$sgrbDataArray['template-shadow-color']?>" class="color-picker" /></div>
			</div>
			<div class="sgrb-single-option">
				<div class="sgrb-option-title-side"><i class="sgrb-required-asterisk"> * </i><?php echo _e('To Left / Right (- / +)', 'sgrb');?>: </div><div class="sgrb-option-input-side"><input name="shadow-left-right" class="sgrb-template-shadow-directions" type="text" value="<?=@$sgrbDataArray['shadow-left-right']?>"/> - px</div>
			</div>
			<div class="sgrb-single-option">
				<div class="sgrb-option-title-side"><i class="sgrb-required-asterisk"> * </i><?php echo _e('To Top / Bottom (- / +)', 'sgrb');?>: </div><div class="sgrb-option-input-side"><input name="shadow-top-bottom" class="sgrb-template-shadow-directions" type="text" value="<?=@$sgrbDataArray['shadow-top-bottom']?>"/> - px</div>
			</div>
			<div class="sgrb-single-option">
				<div class="sgrb-option-title-side"><?php echo _e('Blur effect', 'sgrb');?>:</div><div class="sgrb-option-input-side"><input name="shadow-blur" class="sgrb-template-shadow-directions" type="text" value="<?=@$sgrbDataArray['shadow-blur']?>"/> - px</div>
			</div>
		</div>
	</div>
</div>
