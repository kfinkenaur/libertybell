<?php
/*
Plugin Name: Enjoy Instagram
Plugin URI: http://www.mediabeta.com/enjoy-instagram/
Description: Instagram Responsive Images Gallery and Carousel, works with Shortcodes and Widgets.
Version: 2.1.3
Author: F. Prestipino, F. Di Pane - Mediabeta Srl
Author URI: http://www.mediabeta.com/team/
*/

require_once('library/enjoyinstagram_shortcode.php');
class Settings_enjoyinstagram_Plugin {

	private $enjoyinstagram_general_settings_key = 'enjoyinstagram_general_settings';
	private $advanced_settings_key = 'enjoyinstagram_advanced_settings';
	private $plugin_options_key = 'enjoyinstagram_plugin_options';
	private $plugin_settings_tabs = array();

	function __construct() {
		add_action( 'init', array( &$this, 'load_settings' ) );
		add_action( 'admin_init', array( &$this, 'register_enjoyinstagram_client_id' ) );
		add_action( 'admin_init', array( &$this, 'register_advanced_settings' ) );
		add_action( 'admin_menu', array( &$this, 'add_admin_menus' ) );
	}

	function load_settings() {
		$this->general_settings = (array) get_option( $this->enjoyinstagram_general_settings_key );
		$this->advanced_settings = (array) get_option( $this->advanced_settings_key );
		$this->general_settings = array_merge( array(
			'general_option' => 'General value'
		), $this->general_settings );

		$this->advanced_settings = array_merge( array(
			'advanced_option' => 'Advanced value'
		), $this->advanced_settings );
	}

	function register_enjoyinstagram_client_id() {
		$this->plugin_settings_tabs[$this->enjoyinstagram_general_settings_key] = 'Profile';

		register_setting( $this->enjoyinstagram_general_settings_key, $this->enjoyinstagram_general_settings_key );
		add_settings_section( 'section_general', 'General Plugin Settings', array( &$this, 'section_general_desc' ), $this->enjoyinstagram_general_settings_key );
		add_settings_field( 'general_option', 'A General Option', array( &$this, 'field_general_option' ), $this->enjoyinstagram_general_settings_key, 'section_general' );
	}


	function register_advanced_settings() {
		$this->plugin_settings_tabs[$this->advanced_settings_key] = 'Settings';

		register_setting( $this->advanced_settings_key, $this->advanced_settings_key );
		add_settings_section( 'section_advanced', 'Advanced Plugin Settings', array( &$this, 'section_advanced_desc' ), $this->advanced_settings_key );
		add_settings_field( 'advanced_option', 'An Advanced Option', array( &$this, 'field_advanced_option' ), $this->advanced_settings_key, 'section_advanced' );
	}


	function section_general_desc() { echo 'Instagram Settings'; }
	function section_advanced_desc() { echo 'Manage Enjoy Instagram.'; }


	function field_general_option() {
		?>
		<input type="text" name="<?php echo $this->enjoyinstagram_general_settings_key; ?>[general_option]" value="<?php echo esc_attr( $this->general_settings['general_option'] ); ?>" /><?php
	}


	function field_advanced_option() { ?>
		<input type="text" name="<?php echo $this->advanced_settings_key; ?>[advanced_option]" value="<?php echo esc_attr( $this->advanced_settings['advanced_option'] ); ?>" />
	<?php
	}


	function add_admin_menus() {
		add_options_page( 'Enjoy Instagram', 'Enjoy Instagram', 'manage_options', $this->plugin_options_key, array( &$this, 'enjoyinstagram_options_page' ) );
	}


	function enjoyinstagram_options_page() {
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->enjoyinstagram_general_settings_key;?>
		<div class="wrap">
			<h2><div class="ei_block">
					<div class="ei_left_block">
						<div class="ei_hard_block">
							<?php echo '<img src="' . plugins_url( 'images/enjoyinstagram.png' , __FILE__ ) . '" > '; ?>
						</div>

						<div class="ei_twitter_block">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.mediabeta.com/enjoy-instagram/" data-text="I've just installed Enjoy Instagram for wordpress. Awesome!" data-hashtags="wordpress">Tweet</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
							</script>
						</div>

						<div id="fb-root"></div>
						<script>(function(d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s); js.id = id;
								js.src = "//connect.facebook.net/it_IT/sdk.js#xfbml=1&appId=359330984151581&version=v2.0";
								fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
						<div class="ei_facebook_block">
							<div class="fb-like" data-href="http://www.mediabeta.com/enjoy-instagram/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true">
							</div>
						</div>
					</div>

					<div id="buy_me_a_coffee" style="background:url(<?php echo  plugins_url( 'images/buymeacoffee.png' , __FILE__ )  ; ?>)#fff no-repeat; ">

						<div class="pad_coffee">
							<span class="coffee_title">Buy me a coffee!</span>
							<p><span>If you liked our work please consider to make a kind donation through Paypal.</span></p>
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="8MXZ37DWHAX46">
<input type="image" src="https://www.paypalobjects.com/en_US/IT/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
</form>
						</div>
					</div>
				</div>
				<div class="ei_block">


					<div id="premium_release">

						<div class="pad_premium_release">
							<span class="coffee_title">Premium Version is <a href="http://www.mediabeta.com/enjoy-instagram-premium/">HERE</a> !</span>
							<p><span style="color:#900; font-weight: bold;">Enjoy Instagram Premium</span> is the only plugin that allows you to <span style="color:#900; font-weight: bold;">moderate</span> the pictures and choose which show.<br />
								Discover now all the features and innovations, <a href="http://www.mediabeta.com/enjoy-instagram-premium/">CLICK HERE</a></p>

						</div>

					</div>
					<?php /*
					<div class="promo_enjoy">
						<a target="_blank" href="http://www.mediabetaprojects.com/enjoy-instagram-premium/"><img src="<?php echo plugins_url('/img/gift2016.jpg',__FILE__); ?>" /></a>
					</div> */ ?>
				</div>
			</h2>


			<?php $this->plugin_options_tabs(); ?>
			<?php
			if($tab == 'enjoyinstagram_general_settings') {

				if(isset($_GET['access_token']) && $_GET['access_token']!=''){

					$user = array();
					$user = get_user_info($_GET['access_token']);




					$enjoyinstagram_user_id = $user['data']['id'];
					$enjoyinstagram_user_username = replace4byte($user['data']['username']);
					$enjoyinstagram_user_profile_picture = $user['data']['profile_picture'];
					$enjoyinstagram_user_fullname = replace4byte($user['data']['full_name']);
					$enjoyinstagram_user_website = $user['data']['website'];
					$enjoyinstagram_user_bio = replace4byte($user['data']['bio']);
					$enjoyinstagram_access_token = $_GET['access_token'];

					update_option( 'enjoyinstagram_user_id', $enjoyinstagram_user_id );
					update_option( 'enjoyinstagram_user_username', $enjoyinstagram_user_username );
					update_option( 'enjoyinstagram_user_profile_picture', $enjoyinstagram_user_profile_picture );
					update_option( 'enjoyinstagram_user_fullname', $enjoyinstagram_user_fullname );
					update_option( 'enjoyinstagram_user_website', $enjoyinstagram_user_website );
					update_option( 'enjoyinstagram_user_bio', $enjoyinstagram_user_bio );
					update_option( 'enjoyinstagram_access_token', $enjoyinstagram_access_token );


					// get accee token fine	
					include('library/profile_auth.php');

				}
				else{

					if(!(get_option('enjoyinstagram_access_token'))){
						include('library/autenticazione.php');
					} else {
						include('library/profile_auth.php');
					}

				}
			}else if($tab == 'enjoyinstagram_advanced_settings'){
				include('library/impostazioni_shortcode.php');
			} ?>
		</div>
	<?php
	}

	function plugin_options_tabs() {
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->enjoyinstagram_general_settings_key;

		screen_icon();
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
		echo '</h2>';
	}
};




function get_user_info($access_token){
	$url = 'https://api.instagram.com/v1/users/self/?access_token='.$access_token;
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

		//Data are stored in $data
		$data = json_decode(curl_exec($curl_connection), true);
		curl_close($curl_connection);
		return $data;
	} catch(Exception $e) {
		return $e->getMessage();
	}

}
function get_hash($hashtag,$count){


	$access_token = get_option('enjoyinstagram_access_token');


		$url = 'https://api.instagram.com/v1/tags/' . $hashtag . '/media/recent?count=' . $count . '&access_token=' . $access_token;
		try {
			$curl_connection = curl_init($url);
			curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

			//Data are stored in $data
			$result = json_decode(curl_exec($curl_connection), true);
			curl_close($curl_connection);
			return $result;
		} catch (Exception $e) {
			return $e->getMessage();
		}

}
function get_hash_code($hashtag,$count){

	$access_token = get_option('enjoyinstagram_access_token');


		$url = 'https://api.instagram.com/v1/tags/' . $hashtag . '/media/recent?count=' . $count . '&access_token=' . $access_token;
		try {
			$curl_connection = curl_init($url);
			curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

			//Data are stored in $data
			$result = json_decode(curl_exec($curl_connection), true);
			$code = $result['meta']['code'];
			curl_close($curl_connection);
			return $code;
		} catch (Exception $e) {
			return $e->getMessage();
		}

}
function get_user($user,$count){



	$access_token = get_option('enjoyinstagram_access_token');


	$url = 'https://api.instagram.com/v1/users/self/media/recent?count='.$count.'&access_token='.$access_token;
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

		//Data are stored in $data
		$result = json_decode(curl_exec($curl_connection), true);
		curl_close($curl_connection);
		return $result;
	} catch(Exception $e) {
		return $e->getMessage();
	}

}
function get_user_code($user,$count){

	$access_token = get_option('enjoyinstagram_access_token');


	$url = 'https://api.instagram.com/v1/users/self/media/recent?count='.$count.'&access_token='.$access_token;
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

		//Data are stored in $data
		$result = json_decode(curl_exec($curl_connection), true);
		$code = $result['meta']['code'];
		curl_close($curl_connection);
		return $code;
	} catch(Exception $e) {
		return $e->getMessage();
	}

}
function get_media($user,$media){

	$access_token = get_option('enjoyinstagram_access_token');


	$url = 'https://api.instagram.com/v1/media/'.$media.'?access_token='.$access_token;
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

		//Data are stored in $data
		$result = json_decode(curl_exec($curl_connection), true);
		curl_close($curl_connection);
		return $result;
	} catch(Exception $e) {
		return $e->getMessage();
	}

}
function get_likes($user,$count){
	$access_token = get_option('enjoyinstagram_access_token');
	$url = 'https://api.instagram.com/v1/users/self/media/liked?count='.$count.'&access_token='.$access_token;
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

		//Data are stored in $data
		$result = json_decode(curl_exec($curl_connection), true);
		curl_close($curl_connection);
		return $result;
	} catch(Exception $e) {
		return $e->getMessage();
	}
}
function get_likes_code($user,$count){
	$access_token = get_option('enjoyinstagram_access_token');
	$url = 'https://api.instagram.com/v1/users/self/media/liked?count='.$count.'&access_token='.$access_token;
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

		//Data are stored in $data
		$result = json_decode(curl_exec($curl_connection), true);
		$code = $result['meta']['code'];
		curl_close($curl_connection);
		return $code;
	} catch(Exception $e) {
		return $e->getMessage();
	}
}
function replace4byte($string) {
	return preg_replace('%(?:
          \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
        | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
        | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
    )%xs', '', $string);
}

// Initialize the plugin
add_action( 'plugins_loaded', create_function( '', '$Settings_enjoyinstagram_Plugin = new Settings_enjoyinstagram_Plugin;' ) );


function enjoyinstagram_default_option()
{
	add_option('enjoyinstagram_client_id', '');
	add_option('enjoyinstagram_client_secret', '');
	add_option('enjoyinstagram_client_code', '');
	add_option('enjoyinstagram_user_instagram', '');
	add_option('enjoyinstagram_user_id', '');
	add_option('enjoyinstagram_user_username', '');
	add_option('enjoyinstagram_user_profile_picture', '');
	add_option('enjoyinstagram_user_fullname', '');
	add_option('enjoyinstagram_user_website', '');
	add_option('enjoyinstagram_user_bio', '');
	add_option('enjoyinstagram_access_token', '');
	add_option('enjoyinstagram_carousel_items_number', 4);
	add_option('enjoyinstagram_carousel_navigation', 'false');
	add_option('enjoyinstagram_grid_rows', '2');
	add_option('enjoyinstagram_grid_cols', '5');
	add_option('enjoyinstagram_hashtag', '');
	add_option('enjoyinstagram_user_or_hashtag', 'user');
}

register_activation_hook( __FILE__, 'enjoyinstagram_default_option');

function enjoyinstagram_register_options_group_auth()
{
	register_setting('enjoyinstagram_options_group_auth', 'enjoyinstagram_client_id');
	register_setting('enjoyinstagram_options_group_auth', 'enjoyinstagram_client_secret');
	register_setting('enjoyinstagram_options_group_auth', 'enjoyinstagram_client_code');
	register_setting('enjoyinstagram_options_group_auth', 'enjoyinstagram_user_instagram');
}

add_action ('admin_init', 'enjoyinstagram_register_options_group_auth');

function enjoyinstagram_register_options_group()
{
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_client_id');
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_user_instagram');
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_user_id');
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_user_username');
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_user_profile_picture');
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_user_fullname');
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_user_website');
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_user_bio');
	register_setting('enjoyinstagram_options_group', 'enjoyinstagram_access_token');
}

add_action ('admin_init', 'enjoyinstagram_register_options_group');

function enjoyinstagram_register_options_carousel()
{
	register_setting('enjoyinstagram_options_carousel_group', 'enjoyinstagram_carousel_items_number');
	register_setting('enjoyinstagram_options_carousel_group', 'enjoyinstagram_carousel_navigation');
	register_setting('enjoyinstagram_options_carousel_group', 'enjoyinstagram_grid_cols');
	register_setting('enjoyinstagram_options_carousel_group', 'enjoyinstagram_grid_rows');
	register_setting('enjoyinstagram_options_carousel_group', 'enjoyinstagram_hashtag');
	register_setting('enjoyinstagram_options_carousel_group', 'enjoyinstagram_user_or_hashtag');

}

add_action ('admin_init', 'enjoyinstagram_register_options_carousel');

function aggiungi_script_instafeed_owl() {

	if(!is_admin()) {

		wp_register_script('owl', plugins_url('/js/owl.carousel.js',__FILE__),'jquery','');
		wp_register_script('swipebox', plugins_url('/js/jquery.swipebox.js',__FILE__),'jquery','');
		wp_register_script('gridrotator', plugins_url('/js/jquery.gridrotator.js',__FILE__),'jquery','');
		wp_register_script('modernizr.custom.26633', plugins_url('/js/modernizr.custom.26633.js',__FILE__),'jquery','');
		wp_register_script('orientationchange', plugins_url('/js/ios-orientationchange-fix.js',__FILE__),'jquery','');

		wp_register_style( 'owl_style', plugins_url('/css/owl.carousel.css',__FILE__) );
		wp_register_style( 'owl_style_2', plugins_url('/css/owl.theme.css',__FILE__) );
		wp_register_style( 'owl_style_3', plugins_url('/css/owl.transitions.css',__FILE__) );
		wp_register_style( 'swipebox_css', plugins_url('/css/swipebox.css',__FILE__) );
		wp_register_style( 'grid_fallback', plugins_url('/css/grid_fallback.css',__FILE__) );
		wp_register_style( 'grid_style', plugins_url('/css/grid_style.css',__FILE__) );

		wp_enqueue_script( 'jquery' ); // include jQuery
		wp_enqueue_script('owl');
		wp_enqueue_script('swipebox');
		wp_enqueue_script('modernizr.custom.26633');
		wp_enqueue_script('gridrotator');
		wp_enqueue_script('orientationchange');
		wp_enqueue_style( 'owl_style' );
		wp_enqueue_style( 'owl_style_2' );
		wp_enqueue_style( 'owl_style_3' );
		wp_enqueue_style( 'swipebox_css' );
		wp_enqueue_style( 'grid_fallback' );
		wp_enqueue_style( 'grid_style' );
	}
}

add_action( 'wp_enqueue_scripts', 'aggiungi_script_instafeed_owl' );

function aggiungi_script_in_admin(){
	wp_register_style( 'enjoyinstagram_settings', plugins_url('/css/enjoyinstagram_settings.css',__FILE__) );
	wp_enqueue_style( 'enjoyinstagram_settings' );
}

add_action( 'admin_enqueue_scripts', 'aggiungi_script_in_admin' );
add_action( 'admin_head', 'aggiungo_javascript_in_pannello_amministrazione' );

function aggiungo_javascript_in_pannello_amministrazione() {
	?>
	<script type="text/javascript">


		function post_to_url(path, method) {
			method = method || "get";
			var params = new Array();
			var client_id = '1f1bf91b383647749df62b59526d9be1';
			var client_secret = 'c1e2c0d890bf4602ac5786b3073288d4';
			params['client_id'] = client_id;
			params['redirect_uri'] = 'http://www.mediabetaprojects.com/put_access_token.php?url_redirect=<?php echo admin_url('options-general.php?page=enjoyinstagram_plugin_options&tab=enjoyinstagram_general_settings'); ?>';
			params['response_type'] = 'token';

			var form = document.createElement("form");
			form.setAttribute("method", method);
			form.setAttribute("action", path);

			for(var key in params) {
				if(params.hasOwnProperty(key)) {
					var hiddenField = document.createElement("input");
					hiddenField.setAttribute("type", "hidden");
					hiddenField.setAttribute("name", key);
					hiddenField.setAttribute("value", params[key]);

					form.appendChild(hiddenField);
				}
			}


			document.body.appendChild(form);
			form.submit();

		}


	</script>
<?php
}



function funzioni_in_head() {
	?>
	<script type="text/javascript">
		jQuery(function($) {
			$(".swipebox_grid").swipebox({
				hideBarsDelay : 0
			});

		});

		jQuery(function(){
			/*
			jQuery(document.body)
				.on('click touchend','#swipebox-slider .current img', function(e){
					jQuery('#swipebox-next').click();
					return false;
				})
				.on('click touchend','#swipebox-slider .current', function(e){
					jQuery('#swipebox-close').trigger('click');
				});
			*/
		});

	</script>
<?php
}


add_action('wp_head', 'funzioni_in_head');



function enjoyinstagram_plugin_settings_link($links) {
	$settings_link = '<a href="options-general.php?page=enjoyinstagram_plugin_options">' . __( 'Settings' ) . '</a>';
	$widgets_link = '<a href="widgets.php">' . __( 'Widgets' ) . '</a>';
	$premium_link = '<a href="http://www.mediabeta.com/enjoy-instagram-premium/">' . __( 'Premium Version' ) . '</a>';
	array_push($links, $settings_link);
	array_push($links, $widgets_link);
	array_push($links, $premium_link);
	return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'enjoyinstagram_plugin_settings_link');





add_action( 'admin_footer', 'add_option_client_ajax' );

function add_option_client_ajax() {
	?>
	<script type="text/javascript" >

		jQuery('#button_autorizza_instagram').click(function() {
			var client_id = '1f1bf91b383647749df62b59526d9be1';
			var client_secret = 'c1e2c0d890bf4602ac5786b3073288d4';
			var data = {
				action: 'user_option_ajax',
				client_id_value: client_id,
				client_secret_value: client_secret
			};


			jQuery.post(ajaxurl, data, function(response) {
				post_to_url('https://api.instagram.com/oauth/authorize/','get');
			});
		});
	</script>
<?php
}

add_action( 'wp_ajax_user_option_ajax', 'user_option_ajax_callback' );

function user_option_ajax_callback() {
	global $wpdb;

	$client_id = $_POST['client_id_value'];
	$client_secret = $_POST['client_secret_value'];
	echo $client_id."<br />".$client_secret;
	update_option( 'enjoyinstagram_client_id', $client_id );
	update_option( 'enjoyinstagram_client_secret', $client_secret );

	die();
}


add_action( 'admin_footer', 'logout_client_ajax' );

function logout_client_ajax() {
	?>
	<script type="text/javascript" >

		jQuery('#button_logout').click(function() {
			var data = {
				action: 'user_logout_ajax'
			};


			jQuery.post(ajaxurl, data, function(response) {
				location.href = '<?php echo get_admin_url(); ?>options-general.php?page=enjoyinstagram_plugin_options&tab=enjoyinstagram_general_settings';
			});
		});
	</script>
<?php
}

add_action( 'wp_ajax_user_logout_ajax', 'user_logout_ajax_callback' );

function user_logout_ajax_callback() {
	global $wpdb;

	update_option('enjoyinstagram_user_id','');
	update_option('enjoyinstagram_user_username','');
	update_option('enjoyinstagram_user_profile_picture','');
	update_option('enjoyinstagram_user_fullname','');
	update_option('enjoyinstagram_user_website','');
	update_option('enjoyinstagram_user_bio','');
	update_option('enjoyinstagram_access_token','');

	die();
}

function isHttps() {

	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
		return true;
	}
}
/*
add_action('admin_notices', 'banner_admin_notice');
function banner_admin_notice() {
	global $current_user ;
	$user_id = $current_user->ID;
	if ( ! get_user_meta($user_id, 'ignore_enjoy_notice') ) {
		echo '<div style="padding: 20px;border:1px solid #ccc;background: #fff;margin-top: 20px;"><div class="promo_enjoy">
						<a target="_blank" href="http://www.mediabetaprojects.com/enjoy-instagram-premium/"><img src="'.plugins_url('/img/gift2016.jpg',__FILE__).'" /></a>
					</div>';
		printf(__('It not interesting to me  | <a href="%1$s">Hide Notice</a>'), '?ignore_enjoy=0');
		echo '</div>';
	}
}
*/
add_action('admin_init', 'ignore_enjoy');

function ignore_enjoy() {
	global $current_user;
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset($_GET['ignore_enjoy']) && '0' == $_GET['ignore_enjoy'] ) {
		add_user_meta($user_id, 'ignore_enjoy_notice', 'true', true);
	}
}

/*
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;

	wp_add_dashboard_widget('custom_help_widget', 'Enjoy Instagram', 'custom_dashboard_help');
}

function custom_dashboard_help() {
	echo '<div class="promo_enjoy">
					<a href="http://www.mediabetaprojects.com/enjoy-instagram-premium/" target="_blank"><img src="'.plugins_url('/img/gift2016_dashboard.jpg',__FILE__).'"  style="width:100%;"/></a>
					</div>'
 ;
}
*/


include_once ('tinymce/tinymce.php');
require_once ('tinymce/ajax.php');

require_once('library/widgets.php');
require_once('library/widgets_grid.php');
require_once('library/enjoyinstagram_shortcode_grid.php');
require_once('library/enjoyinstagram_shortcode_widget.php');
require_once('library/enjoyinstagram_shortcode_grid_widget.php');

?>