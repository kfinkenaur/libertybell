	<?php global $woocommerce; ?>
<div class="shop-links">
	<div class="account-link">
	<?php
	if ( is_user_logged_in() ) {
	?>
		<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account" title="<?php _e('My Account','panoramic'); ?>">
			<?php _e('My Account','panoramic'); ?>
		</a>
	<?php
	} else {
	?>
		<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="my-account" title="<?php _e('Login','panoramic'); ?>">
			<?php _e('Sign In / Register','panoramic'); ?>
		</a>
	<?php
	}
	?>
	</div>
	
	<div class="header-cart">
		<a class="header-cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'panoramic'); ?>">
			<span class="header-cart-amount">
				<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'panoramic'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?>
			</span>
			<span class="header-cart-checkout<?php echo ( $woocommerce->cart->cart_contents_count > 0 ) ? ' cart-has-items' : ''; ?>">
				<span><?php _e('Checkout', 'panoramic'); ?></span> <i class="fa fa-shopping-cart"></i>
			</span>
		</a>
	</div>
</div>