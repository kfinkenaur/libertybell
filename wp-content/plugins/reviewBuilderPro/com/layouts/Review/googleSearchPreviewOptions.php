<div class="sg-row">
	<div class="sg-col-12">
		<label for="sgrb-google-on">
			<input id="sgrb-google-on" class="sgrb-google-search-checkbox" type="checkbox" value="true" name="sgrb-google-search-on"<?php echo (@$sgrbDataArray['sgrb-google-search-on']) ? ' checked' : '';?>>
			<?php echo _e('Show Your review in Google search', 'sgrb');?>
		</label>
	</div>
</div>
<div class="sg-row sgrb-hide-google-preview">
	<div class="sg-col-12">
		<div class="sgrb-google-search-preview">
			<div class="sgrb-google-box-wrapper">
				<div class="sgrb-google-box-title">Your review title</div>
				<div class="sgrb-google-box-url">www.your-web-page.com/your-review-site/...</div>
				<div class="sgrb-google-box-image-votes"><img width="70px" height="20px" src="<?php echo $sgrb->app_url.'/assets/page/img/google_search_preview.png';?>"><span>Rating - 5 - 305 votes</span></div>
				<div class="sgrb-google-box-description"><span>Your description text, if description field in Your selected template not exist, then there will be another field's text, e.g. title,subtitle ...</span></div>
			</div>
		</div>
	</div>
</div>