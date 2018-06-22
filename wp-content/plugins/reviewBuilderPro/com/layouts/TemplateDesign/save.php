<?php
if (get_option(SG_REVIEW_BANNER)) {
	require_once($sgrb->app_path.'/com/layouts/Review/banner.php');
}
?>
<div class="wrap">
	<form class="sgrb-template-js-form">
		<div class="sgrb-top-bar">
			<h1 class="sgrb-add-edit-title">
				<?php echo (@$sgrbTemplateId != 0) ? _e('Edit Template', 'sgrb') : _e('Add New Template', 'sgrb');?>
				<span class="sgrb-spinner-save-button-wrapper">
					<i class="sgrb-loading-spinner"><img src='<?php echo $sgrb->app_url.'/assets/page/img/spinner-2x.gif';?>'></i>
					<a href="javascript:void(0)"
						class="sgrb-template-js-update button-primary sgrb-pull-right"><?php _e('Save changes', 'sgrb'); ?></a>
				</span>
			</h1>
			<input class="sgrb-text-input sgrb-title-input" value="<?php echo esc_attr(@$sgrbTemplateDataArray['templateName']); ?>"
			type="text" autofocus name="sgrbTemplateName" placeholder="<?php _e('Enter title here', 'sgrb'); ?>">
			<input type="hidden" name="sgrbTemplateId" value="<?php echo esc_attr(@$_GET['id']); ?>">
			<input type="hidden" name="sgrbSaveUrl" value="<?php echo esc_attr(@$sgrb->adminUrl('TemplateDesign/save')); ?>">
		</div>

		<div class="sgrb-options-main-wrapper">
			<div class="sg-row">
				<div class="sg-col-7">
					<div class="sg-box">
						<div class="sg-box-title">
							<?php echo _e('Enter Your html here', 'sgrb');?>
						</div>
						<div class="sg-box-content">
							<?php @$sgrbTemplateDataArray['templateHtmlContent'] ? @$contentHtml = @$sgrbTemplateDataArray['templateHtmlContent'] : '';
								wp_editor(@$contentHtml, 'sgrbhtml', array(
									'wpautop'       => 1,
									'media_buttons' => 0,
									'textarea_name' => 'sgrbHtmlContent',
									'textarea_rows' => 15,
									'tabindex'      => null,
									'editor_css'    => '',
									'editor_class'  => '',
									'teeny'         => 0,
									'dfw'           => 0,
									'tinymce'       => 1,
									'quicktags'     => 1,
									'drag_drop_upload' => false
								) );?>
						</div>
					</div>
					<div class="sg-box">
						<div class="sg-box">
							<div class="sg-box-title">
								<?php echo _e('Enter Your css here', 'sgrb');?>
							</div>
							<div class="sg-box-content">
								<?php @$sgrbTemplateDataArray['templateCssContent'] ? @$contentCss = @$sgrbTemplateDataArray['templateCssContent'] : '';
									wp_editor(@$contentCss, 'sgrbcss', array(
										'wpautop'       => 1,
										'media_buttons' => 0,
										'textarea_name' => 'sgrbCssContent',
										'textarea_rows' => 10,
										'tabindex'      => null,
										'editor_css'    => '',
										'editor_class'  => '',
										'teeny'         => 0,
										'dfw'           => 0,
										'tinymce'       => 0,
										'quicktags'     => 0,
										'drag_drop_upload' => false
									) );?>
							</div>
						</div>
					</div>
				</div>
				<div class="sg-col-5">
					<div class="sg-box">
						<div class="sg-box-title">
							All suggested <code>[tags]</code> to help You to create or edit template.
						</div>
						<div class="sg-box-content sgrb-tag-wrapper">
							<div class="sg-row sgrb-template-design-description-box">
								<div class="sg-col-11">
									<p>To add the needed fields to your template, you can simply copy the selected tag and paste it into the HTML section of your template.
										Or you can simply click on "Insert tag" button next to it. <i style="color:red;">(Note: insert button works in visual mode only)</i>.
									</p>
									<p>
										You can also add classes to available tags, to give styles directly.
										You can simply leave space after the tag name,then the word "<code>class</code>",
										equal sign "<code>=</code>" and enter your new class name enclosed in double quotes <code>""</code>.
									</p>
									<p>
										<b>Important!</b> Your new class name should have the "<code>sgrb-</code>" prefix to avoid conflicts with other plugins.
									</p>
									<p>
										<i>example: <code>class="sgrb-main-title"</i></code>
									</p>
									<p>
										And as a result you should have something like this:
									</p>
									<p>
										<i>example:</i> <code>[sgrbimg class="sgrb-my-image"]</code>
									</p>
								</div>
							</div>
							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrbimg]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('image field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrbimg]')" class="button button-small sgrbimg" value="Insert tag">
									</p>
								</div>
							</div>
							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrbtitle]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('title field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrbtitle]')" class="button button-small sgrbtitle" value="Insert tag">
									</p>
								</div>
							</div>

							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrbsubtitle]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('subtitle field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrbsubtitle]')" class="button button-small sgrbsubtitle" value="Insert tag">
									</p>
								</div>
							</div>

							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrbshortdescription]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('short description field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrbshortdescription]')" class="button button-small sgrbshortdesc" value="Insert tag">
									</p>
								</div>
							</div>

							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrblongdescription]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('long description field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrblongdescription]')" class="button button-small sgrblongdesc" value="Insert tag">
									</p>
								</div>
							</div>

							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrbprice]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('price field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrbprice]')" class="button button-small sgrbprice" value="Insert tag">
									</p>
								</div>
							</div>

							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrbproductby]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('product by field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrbproductby]')" class="button button-small sgrbproductby" value="Insert tag">
									</p>
								</div>
							</div>

							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrbshipping]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('shipping field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrbshipping]')" class="button button-small sgrbshipping" value="Insert tag">
									</p>
								</div>
							</div>

							<div class="sg-row">
								<div class="sg-col-4">
									<p><input class="sgrb-tag-shortcode" type="text" value="[sgrblink]" readonly onfocus="this.select();"></p>
								</div>
								<div class="sg-col-8">	
									<p> - <?php echo _e('url link and its title field', 'sgrb')?>
										<input type="button" name="" onclick="SGReview.prototype.insertTag('[sgrblink]')" class="button button-small sgrblink" value="Insert tag">
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="sg-box" style="min-height:152px !important;">
						<div class="sg-box-title">
							Template Image (optional)
						</div>
						<div class="sg-box-content">
							<?php 
								$imageStyle = 'style="width: 200px;height:200px;background-color:#f7f7f7;margin: 0 auto;"';
								if (@$sgrbTemplateDataArray['templateImage']) {
									$imageStyle = 'style="background-image:url('.@$sgrbTemplateDataArray['templateImage'].');width: 200px;height:200px;background-color:#f7f7f7;margin: 0 auto;"';
								}
							?>
							<div class="sgrb-image-review" <?php echo $imageStyle;?>>
								<div class="sgrb-icon-wrapper" style="left: 20%;">
									<div class="sgrb-image-review-plus"><span class="sgrb-tepmlate-img-upload" name=""><i><img class="sgrb-plus-icon" src="<?=$sgrb->app_url.'assets/page/img/add.png';?>"></i></span>
										<input type="hidden" class="sgrb-img-num" data-auto-id=""> 
										<input type="hidden" class="sgrb-images" id="sgrb-templateimg-url" name="sgrbTemplateImage" value="<?=@$sgrbTemplateDataArray['templateImage'];?>">
									</div>
									<div class="sgrb-image-review-minus">
										<span class="sgrb-remove-template-img-btn" name="">
											<i>
												<img class="sgrb-minus-icon" src="<?=$sgrb->app_url.'assets/page/img/remove_image.png';?>">
											</i>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>
</div>
