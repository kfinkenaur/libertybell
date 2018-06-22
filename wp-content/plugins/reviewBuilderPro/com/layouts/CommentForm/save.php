<?php
	if (get_option(SG_REVIEW_BANNER)) {
		require_once($sgrb->app_path.'/com/layouts/Review/banner.php');
	}
	$index = 1;
?>

<div class="wrap">
	<form class="sgrb-js-form">
		<div class="sgrb-top-bar">
			<h1 class="sgrb-add-edit-title">
				<?php echo (@$sgrbFormId != 0) ? _e('Edit Form', 'sgrb') : _e('Add New Form', 'sgrb');?>
				<span class="sgrb-spinner-save-button-wrapper">
					<i class="sgrb-loading-spinner"><img src='<?php echo $sgrb->app_url.'/assets/page/img/spinner-2x.gif';?>'></i>
					<a href="javascript:void(0)"
						class="sgrb-js-update button-primary sgrb-pull-right"><?php _e('Save changes', 'sgrb'); ?></a>
				</span>
			</h1>
			<input class="sgrb-text-input sgrb-title-input" value="<?php echo esc_attr(@$sgrbDataArray['title']); ?>"
			type="text" autofocus name="title" placeholder="<?php _e('Enter title here', 'sgrb'); ?>">
			<input type="hidden" name="sgrb-form-id" value="<?php echo esc_attr(@$_GET['id']); ?>">
			<input type="hidden" name="sgrbSaveUrl" value="<?php echo esc_attr(@$sgrbSaveUrl); ?>">

		</div>

		<div class="sgrb-form-options-main-wrapper">
			<div class="sg-row">
				<div class="sg-col-6">
					<div class="sg-box sgrb-form-general-box">
						<div class="sg-box-title">
							<?php echo _e('General', 'sgrb');?>
						</div>
						<div class="sg-box-content">
							<div class="sg-row">
								<div class="sg-col-12 sgrb-form-textareas-wrapper">
								<input type="hidden" name="sgrbAppUrl" value="<?=$sgrb->app_url?>">
								<?php if (@$sgrbDataArray['options']) :?>
									<?php foreach ($sgrbDataArray['options'] as $shortcode) :?>
										<?php $shortcode = $shortcode['code'];?>
										<div id="sgrb-field-<?=$index?>" class="sg-row sgrb-form-row">
											<div class="sg-col-11">
												<textarea rows="2" class="sgrb-form-textarea" name="mainCreatedFormHtml[]"><?php echo $shortcode;?></textarea>
											</div>
											<div class="sg-col-1 sgrb-minus-icon-wrapper">
												<img onclick="SGRB.prototype.deleteField(<?=$index?>);" class="sgrb-form-minus-icon sgrb-delete-form-field-js" src="<?php echo $sgrb->app_url ;?>assets/page/img/remove_image.png">
											</div>
										</div>
										<?php $index++;?>
									<?php endforeach;?>
								<?php else:?>
									<p class="howto">No fields</p>
								<?php endif;?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="sg-col-6">
					<div class="sg-box">
						<div class="sg-box-title">
							All suggested <code>[tags]</code> to help You to create or edit form.
						</div>
						<div class="sg-box-content">
							<div class="sg-row sgrb-template-design-description-box">
								<div class="sg-col-12">
									<p>To create your own form, check the following guide steps.</p>
									<p><b>First of all, select the field type (text, email, number, text area).</b></p>
									<p>Then to customize the field and add attributes, you need to type each attribute values you need to use, in corresponding inputs,then click on "Insert tag".</p>
									<p>Do this for every field type separately.</p>
								</div>
							</div>
							<div class="sg-row sgrb-field-tags-wrapper">
								<div class="sg-col-12">
									<span class="sgrb-reset-options sgrb-woo-product-category-name"><?php echo _e('Select the type to continue: ', 'sgrb');?></span>
									<input type="button" name="" onclick="SGRB.prototype.showFieldOptions(<?=SGRB_FORM_FIELD_TYPE_TEXT?>)" class="button button-small sgrb-insert-form-tag" value="text">
									<input type="button" name="" onclick="SGRB.prototype.showFieldOptions(<?=SGRB_FORM_FIELD_TYPE_EMAIL?>)" class="button button-small sgrb-insert-form-tag" value="email">
									<input type="button" name="" onclick="SGRB.prototype.showFieldOptions(<?=SGRB_FORM_FIELD_TYPE_NUMBER?>)" class="button button-small sgrb-insert-form-tag" value="number">
									<input type="button" name="" onclick="SGRB.prototype.showFieldOptions(<?=SGRB_FORM_FIELD_TYPE_TEXTAREA?>)" class="button button-small sgrb-insert-form-tag" value="text area">
								</div>
							</div>
							<div id="sgrb-as-title" class="sg-row sgrb-field-tags-wrapper">
								<div class="sg-col-12">
									<label>
										<input onclick="SGRB.prototype.selectUseAs('title');" class="sgrb-field-use-as sgrb-attributes-input" type="radio" name="inputUseAs" value="title">
										<?php echo _e('Use as Title to show in front end', 'sgrb');?>
									</label>
								</div>
							</div>
							<div id="sgrb-as-comment" class="sg-row sgrb-field-tags-wrapper">
								<div class="sg-col-12">
									<label>
										<input onclick="SGRB.prototype.selectUseAs('comment');" class="sgrb-field-use-as sgrb-attributes-input" type="radio" name="inputUseAs" value="comment">
										<?php echo _e('Use as Comment to show in front end', 'sgrb');?>
									</label>
								</div>
							</div>
							<div id="sgrb-as-username" class="sg-row sgrb-field-tags-wrapper">
								<div class="sg-col-12">
									<label>
										<input onclick="SGRB.prototype.selectUseAs('username');" class="sgrb-field-use-as sgrb-attributes-input" type="radio" name="inputUseAs" value="username">
										<?php echo _e('Use as Username to show in front end', 'sgrb');?>
									</label>
								</div>
							</div>
							<div class="sg-row sgrb-field-tags-wrapper">
								<div class="sg-col-12">
									<label>
										<input onclick="SGRB.prototype.selectUseAs('');" class="sgrb-field-use-as sgrb-attributes-input" type="radio" name="inputUseAs" value="additional" checked>
										<?php echo _e('Use as additional to show in front end (will be used your label attribute)', 'sgrb');?>
									</label>
								</div>
							</div>
							<input type="hidden" name="inputUseAsHidden" value="">
							<?php require_once($sgrb->app_path.'/com/layouts/CommentForm/textFieldOptions.php');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
