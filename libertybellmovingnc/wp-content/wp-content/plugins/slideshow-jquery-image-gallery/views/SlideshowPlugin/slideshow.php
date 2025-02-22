">

	<div class="slideshow_controlPanel slideshow_transparent"><ul><li class="slideshow_togglePlay"></li></ul></div>

	<div class="slideshow_button slideshow_previous slideshow_transparent"></div>
	<div class="slideshow_button slideshow_next slideshow_transparent"></div>

	<div class="slideshow_pagination"><div class="slideshow_pagination_center"></div></div>

	<div class="slideshow_content" style="display: none;">

		<?php

		if(is_array($views) && count($views) > 0)
			foreach($views as $view)
				echo $view->toFrontEndHTML();

		?>

	</div>

	<!-- WordPress Slideshow Version <?php echo SlideshowPluginMain::$version; ?> -->

	<?php if(is_array($log) && count($log) > 0): ?>
	<!-- Error log
	<?php foreach($log as $logMessage): ?>
		- <?php echo htmlspecialchars($logMessage); ?>
	<?php endforeach; ?>
	-->
	<?php endif; ?>
</div>
