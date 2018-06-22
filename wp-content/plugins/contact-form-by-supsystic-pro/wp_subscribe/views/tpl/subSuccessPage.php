<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<title>
		<?php echo ($this->forReg 
			? __('Registration Confirmation', CFS_LANG_CODE) 
			: __('Subscribe Confirmation', CFS_LANG_CODE))?>
	</title>
	<style type="text/css">
		html, body {
			background-color: #f1f1f1;
			font-family: Lato,​ helvetica, sans-serif;
		}
		a {
			color: #2866ff;
				
		}
		.cfsConfirmMainShell {
			border: 1px solid #a1a1a1;
			border-radius: 6px;
			width: 540px;
			margin: 0 auto;
			background-color: #fff;
			text-align: center;
		}
		.cfsErrorMsg {
			color: #db3611;
		}
		.cfsConfirmContent, .cfsConfirmTitle {
			padding: 0 20px;
		}
		.cfsConfirmRedirectShell {
			background-color: #c1e1f7;
			border: 1px solid #7abeef;
			border-right: none;
			border-left: none;
			margin: 20px 0;
			padding: 20px 0;
		}
	</style>
</head>
<body>
	<div class="cfsConfirmMainShell">
		<?php if($this->res->error()) {
			$errors = $this->res->getErrors();
		?>
		<h1 class="cfsConfirmTitle">
			<?php echo ($this->forReg 
				? __('Some errors occured while trying to registrate', CFS_LANG_CODE) 
				: __('Some errors occured while trying to subscribe', CFS_LANG_CODE))?>
		</h1>
		<div class="cfsConfirmContent">
			<div class="cfsErrorMsg"><?php echo implode('<br />', $errors)?></div>
		</div>
		<?php
		} else {
			$pref = $this->forReg ? 'reg' : 'sub';
			$defaultSuccessMsg = $this->forReg 
				? __('Thank you for registration!', CFS_LANG_CODE) 
				: __('Thank you for subscribing!', CFS_LANG_CODE);
			$successMessage = $this->form && isset($this->form['params']['tpl'][$pref. '_txt_success'])
				? $this->form['params']['tpl'][$pref. '_txt_success']
				: $defaultSuccessMsg;
			$redirectUrl = isset($this->form['params']['tpl'][$pref. '_redirect_url']) && !empty($this->form['params']['tpl'][$pref. '_redirect_url'])
				? $this->form['params']['tpl'][$pref. '_redirect_url']
				: get_bloginfo('wpurl');
			$redirectUrl = uriCfs::normal( $redirectUrl );
			$autoRedirectTime = 10;
		?>
		<h1 class="cfsConfirmTitle"><?php echo ($this->forReg 
				? __('Registration confirmed', CFS_LANG_CODE) 
				: __('Subscription confirmed', CFS_LANG_CODE))?></h1>
		<div class="cfsConfirmContent">
			<?php echo $successMessage;?>
		</div>
		<div class="cfsConfirmRedirectShell">
			<?php printf(__('<a href="%s">Back to site</a> in <i id="cfsConfirmBackCounter">%d</i> seconds'), $redirectUrl, $autoRedirectTime)?>
		</div>
		<script type="text/javascript">
			var cfsAutoRedirectTime = <?php echo $autoRedirectTime;?>
			,	cfsAutoRedirectTimeLeft = cfsAutoRedirectTime;
			function cfsAutoRedirectWaitClb() {
				cfsAutoRedirectTime--;
				if(cfsAutoRedirectTime > 0) {
					document.getElementById('cfsConfirmBackCounter').innerHTML = cfsAutoRedirectTime;
					setTimeout(cfsAutoRedirectWaitClb, 1000);
				} else {
					window.location.href = '<?php echo $redirectUrl?>';
				}
			}
			setTimeout(cfsAutoRedirectWaitClb, 1000);
		</script>
		<?php
		}?>
	</div>
</body>
</html>