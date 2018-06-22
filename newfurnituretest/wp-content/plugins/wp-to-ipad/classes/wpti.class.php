<?php
class Wpti 
{
	public $theme = 'appzine';
	
	public $categoriesParPage = 4;
	public $postsPerPage = 6;
	public $stringLength = 100;
	public $config;

	function __construct()
	{
		global $wp_version;
		
		$this->config = new Wpti_Config();
		$config = $this->config;
		$this->theme = $config->get( 'wpti_template' );
		$this->categoriesParPage = $config->get( 'wpti_cat_per_page' );
		$this->postsPerPage = $config->get( 'wpti_posts_per_page' );
		
		add_theme_support('post-thumbnails');
		add_image_size( 'thumbnail-sommaire-1', '306', '404', true ); 
		add_image_size( 'thumbnail-sommaire-2', '351', '196', true ); 
		add_image_size( 'thumbnail-article-200', '200', '112', false ); 
		add_image_size( 'thumbnail-theme2-HP', '318', '184', true );
		
		$this->setup();
	}
	
	function description_Kinoa()
	{
		return __("This plugin is powered by Kinoa. For more information about WP-to-iPad, visit<a href=\"http://kinoa.com/wp-to-ipad\">http://kinoa.com/wp-to-ipad</a><br/><br/>
				Kinoa, digital agency. <br/>
				Digital communication & 360-degree marketing. Web design. Social Media. Mobile applications. iPad. iPhone. Facebook. Twitter. SEO & SEM. Community management. Wordpress. Videos. Brand content.<br/><br/>

				Like us : <a href=\"http://www.facebook.com/kinoa\">http://www.facebook.com/kinoa</a><br/>
						Follow us on Twitter : <a href=\"http://twitter.com/#!/kinoa\">http://twitter.com/#!/kinoa</a><br/>
						The Kinoa Blog : <a href=\"http://blog.kinoa.com/\">http://blog.kinoa.com/</a><br/>
						Our website : <a href=\"http://www.kinoa.com/\">http://www.kinoa.com/</a><br/>", 'wp-to-ipad');
	}
	
	function setup()
	{
		global $wpdb;
		
		$config = $this->config;
		
		if ( !is_admin() && $this->isIpad() )
		{
			if(isset($_GET['preview']))
			{
				//$this->theme = $_GET['preview'];
			}
			
			$themePath =  KPAD_PLUGIN_DIR . '/themes/' . $this->theme;
			
			add_filter( 'theme_root', array( $this, 'themeRoot' ) );
			add_filter( 'theme_root_uri', array( $this, 'themeRootUrl' ) );
			add_filter( 'template', array( $this, 'setTheme' ) );
			add_filter( 'stylesheet', array( $this, 'setStylesheet' ) );
			add_filter( 'show_admin_bar', '__return_false' );
			
			add_filter( 'excerpt_length', array( $this, newExcerptLength ));
			add_filter( 'excerpt_more', array( $this, newExcerptMore ) );
			
			if(!is_admin())
			{
				
				if($this->theme == "wpti")
				{
					wp_enqueue_script( 'sencha', plugin_dir_url( __FILE__ ) . '../js/sencha-touch.js', array( 'jquery' ) );
					wp_enqueue_script( 'dropdown', plugin_dir_url( __FILE__ ) . '../js/dropdown.js', array( 'jquery' ) );
				}
				wp_enqueue_script( 'my-ajax-request', plugin_dir_url( __FILE__ ) . '../themes/'.$this->theme.'/js/js.js', array( 'jquery' ) );
				wp_localize_script( 'my-ajax-request', 'MyAjax', array(
				    	'ajaxurl' 		=> admin_url( 'admin-ajax.php' ),
						'font_logo_api'	=> $config->get('wpti_default_font_logo'),
						'font_logo_libelle'	=> isset($config->tabFonts[$config->get('wpti_default_font_logo')]) ? $config->tabFonts[$config->get('wpti_default_font_logo')] : '',
						'font_title_api'	=> $config->get('wpti_default_font_titre'),
						'font_title_libelle'	=> isset($config->tabFonts[$config->get('wpti_default_font_titre')]) ? $config->tabFonts[$config->get('wpti_default_font_titre')] : '',
						'header_bg_color'	=> $config->get('wpti_header_color'),
						'header_border_color'	=> $config->get('wpti_header_border_color'),
						'header_txt_color'	=> $config->get('wpti_header_text_color'),
						'fbcomment' => $config->get('wpti_facebook_comment_module'),
				    )
				);
			}
		}
		
		add_action( 'init', array(&$this, 'wpti_load_textdomain'));
		add_action( 'wp_ajax_wpti_file_list', array(&$this, 'wpti_file_list'));
		add_action( 'wp_ajax_wpti_categories', array(&$this, 'wpti_categories'));
		add_action( 'wp_ajax_nopriv_wpti_categories', array(&$this, 'wpti_categories'));
	}
	
	function wpti_load_textdomain() 
	{
		if ( function_exists('load_plugin_textdomain') ) 
		{
			if ( !defined('WP_PLUGIN_DIR') ) {
       		 	load_plugin_textdomain('wp-to-ipad', str_replace( ABSPATH, '', dirname(dirname(__FILE__))));
        	} else {
        		load_plugin_textdomain('wp-to-ipad', false, dirname(dirname(plugin_basename(__FILE__))));
        	}
		}
	}
	
	function isIpad()
	{
		$user_agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
		return (bool) (strpos($user_agent, 'ipad') || (isset($_GET['preview']) && $_GET['preview'] == "wpti") /* || strpos($user_agent, 'chrome')*/);
	}
	
	function themeRoot()
	{
		return KPAD_PLUGIN_DIR . '/themes';
	}
	
	function themeRootUrl( $url ) {
		return KPAD_PLUGIN_URL . '/themes';
	}
	
	function setTheme( $theme ) 
	{
		return $this->theme;
	}
	
	function setStylesheet( $css ) 
	{
		return $this->theme;
	}
	
	function newExcerptLength($length) 
	{
		return 250;
	}
	
	function newExcerptMore($more) 
	{
		return '...';
	}
	
	function getLastComments()
	{
		global $wpdb;
		
		$sql = "SELECT * 
		FROM $wpdb->comments
		WHERE comment_type = ''
			AND comment_approved = 1
		LIMIT 0, 10";
		
		$comments = $wpdb->get_results($sql);
		?>
		<table class="liste" height="170">
		<tr>
		<?php
		$total_comments = count($comments);
		$i = 0;
		foreach ($comments as $comment) :
			
			$date = mysql2date(get_option('date_format'), $comment->comment_date);
			$time = mysql2date(get_option('time_format'), $comment->comment_date);
			?>
			<td class="<?php echo (($i+1) != $total_comments) ? 'border-right' : '' ?>" onclick="getArticle('<?php echo get_permalink($comment->comment_post_ID) ?>')">
				<div class="bloc"></div>
				<h3><?php printf( __( '%s <span class="says">says:</span>', 'wpti' ), sprintf( '<cite class="fn">%s</cite>', $comment->comment_author ) ); ?>
				<br/>
				<?php printf( __( '%1$s at %2$s', 'wpti' ), $date,  $time ); ?>
				</h3><br/>
				<?php echo get_comment_excerpt($comment->comment_ID) ?>
			</td>
			<?php
		$i++;
		endforeach; ?>
		</tr></table>
		<?php
	}
	
	function getPages()
	{
		$query = new WP_Query(array(
			'post_type' => 'page'
		));
		?>
		<table class="liste" height="200"><tr>
		<?php
		$i = 0;
		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			?>
			<td class="<?php echo (($i+1) != $query->post_count) ? 'border-right' : '' ?>" onclick="getArticle('<?php the_permalink() ?>')">
				<div class="bloc"></div>
				<h3><?php the_title() ?></h3>
				<?php $excerpt = get_the_excerpt(); 
				$length = 250;
				if(strlen($excerpt) > $length)
				{
					$excerpt = $this->truncateString($excerpt, $length) . "...";
				}
				echo $excerpt;
				?>
			</td>
			<?php
			$i++;
		endwhile; endif; ?>
		</tr></table>
		<?php
	}
	
	function comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', 'wp-to-ipad' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<div class="content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wp-to-ipad' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<?php printf( __( '%1$s at %2$s', 'wp-to-ipad' ), get_comment_date(),  get_comment_time() ); ?>
				</div><!-- .comment-meta .commentmetadata -->

				<div class="comment-body"><?php comment_text(); ?></div>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</div>
		</div><!-- #comment-##  -->

		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'wp-to-ipad' ); ?> <?php comment_author_link(); ?></p>
		<?php
				break;
		endswitch;
	}
	
	function getArticlesByCategorie( $categorie, $debut = 0 )
	{
		$bg_color = "#ffffff";
		$txt_color = "#000";
		
		if(is_array($categorie)) 
		{
			$categorie_id = $categorie['term_id'];
			$bg_color = $categorie['bg_color'];
			$txt_color = $categorie['txt_color'];
		}
		elseif(is_object($categorie))
			$categorie_id = $categorie->term_id;
		else 
			$categorie_id = $categorie;
			
			
			
		$categorie = get_category( $categorie_id ); 
		
		$query = new WP_Query('post_status=publish&posts_per_page=-1&cat=' . $categorie_id);
		$total_posts = $query->post_count;

		$query = new WP_Query('post_status=publish&posts_per_page=' . $this->postsPerPage . '&cat=' . $categorie_id . "&offset=" . $debut);

		$posts = array();

		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			$size = ($this->theme == "wpti") ? array(200, 112, false) : array(318, 184, false);
			$thumbnail = $this->getThumbnail(get_the_ID(), $size);
			$title = get_the_title();
			$excerpt = get_the_excerpt() ;
			$author = get_the_author();
			$date = get_the_date();
			$permalink = get_permalink();
			
			$index = 0;
			$category_post = "";
			foreach((get_the_category()) as $category) 
			{
				$category_post .= ($index != 0) ? ", " : "";
				$category_post .= $category->cat_name;
				$index++;
			}
			
			if(strlen($title) > 60)
			{
				$title = $this->truncateString($title, 60) . "...";
			}
			
			$length = 130;
			if($thumbnail == null)
				$length = 250;
			
			if(strlen($excerpt) > $length)
			{
				$excerpt = $this->truncateString($excerpt, $length) . "...";
			}
			
			$post = array(
				'id' => get_the_ID(),
				'title' => $title,
				'excerpt' => $excerpt,
				'thumbnail' => $thumbnail,
				'category' => $category_post,
				'author' => $author,
				'date' => $date,
				'permalink' => $permalink
			);

			array_push($posts, $post);

		endwhile; endif;
		
		return array(
			'total_posts' => $total_posts,
			'categorie_id' => $categorie_id,
			'title' => $categorie->name,
			'bg_color' => $bg_color,
			'txt_color' => $txt_color,
			'posts' => $posts,
			'id' => $categorie_id,
			'debut' => $debut + $this->postsPerPage
		);
	}
	
	function truncateString($string, $length = 20)
	{
		if (strlen($string) <= $length) {
		    $string = $string; //do nothing
		}
		else {
		    $string = wordwrap($string, $length);
		    $string = substr($string, 0, strpos($string, "\n"));
		}
		
		return $string;
	}
	
	function facebooktwitter(){

		$url = get_permalink();
		$title = get_the_title();
		
		$twitter = "http://twitter.com/share?text=$title&url=$url";
		$facebook = "http://www.facebook.com/share.php?u=$url";
		$mail = "mailto:?subject=$title&body=$url";
		
		$html = '<span class="partager">Partager: </span><a href="'.$twitter.'" class="twitter">Twitter</a>';
		$html .= '<a href="'.$facebook.'" class="facebook">Facebook</a>';
		//$html .= '<a href="'.$mail.'" class="mailto">Email</a>';
		
		$html .= '<br class="clear" />';
		
		return $html;
	}
	
	function getThumbnail( $postId, $size = "" )
	{
		$config = $this->config;
		
		$src = get_post_meta($postId, 'wpti_image', true);
		
		if($src != "")
			return $src;
		
		if(!has_post_thumbnail())
		{
			$images =& get_children(array(	
				'post_parent' => $postId, 
				'numberposts' => 1, 
				'post_type' => 'attachment', 
				'post_mime_type' => 'image', 
				'order' => 'DESC',  
				'orderby' => 'menu_order date'));
			
			if ( empty($images) ) 
			{
				// no attachments here
				if($config->get('wpti_image_generique'))
					$src = KPAD_PLUGIN_URL . '/images/' . $config->get('wpti_image_generique');
			} 
			else 
			{
				foreach ( $images as $attachment_id => $attachment ) 
				{
					$image = wp_get_attachment_image_src( $attachment_id, $size );
					$src = $image[0];
					break;
				}
			}
		}
		else
		{
			$id = get_post_thumbnail_id( $postId );
			$image = wp_get_attachment_image_src( $id, $size );
			$src = $image[0];
		}
		
		return $src;
	}
	
	function getCategories()
	{
		$categories = get_categories(
			array(
				'type' => 'post',
				'child_of' => 0,
				'orderby' => 'name',
				'hide_empty' => 1
			)
		);
		
		return $categories;
	}
	
	function getDefaultCategories()
	{
		$config = $this->config;
		
		$tab = array();
		
		if($config->get('wpti_categories') !== null)
		{
			$categories = explode(';', $config->get('wpti_categories'));
			$categories_bg_color = explode(';', $config->get('wpti_categories_bg_color'));
			$categories_txt_color = explode(';', $config->get('wpti_categories_txt_color'));
						
			$i = 0;		
			if(count($categories) == 1 && $categories[0] == "")
			{
				unset($categories[0]);
			}	
			
			foreach($categories as $id) 
			{
				$bg_color = (isset($categories_bg_color[$i]) && $categories_bg_color[$i] != "") ? $categories_bg_color[$i] : "#ffffff";
				$txt_color = (isset($categories_txt_color[$i]) && $categories_txt_color[$i] != "") ? $categories_txt_color[$i] : "#000";
				
				$categorie = get_category($id);
				
				$cat = array(
					'title' => $categorie->cat_name,
					'term_id' => $categorie->term_id,
					'bg_color' => $bg_color,
					'txt_color' => $txt_color
				);
				
				array_push($tab, $cat);
				$i++;
			}
		}
		
		if(count($tab) > 0)
			return $tab;
		return $this->getCategories();
	}
	
	function wpti_file_list()
	{
		$post_id = attribute_escape($_POST['post_id']);
		$attachments['data'] = get_children( array( 'post_parent' => $post_id, 'post_type' => 'attachment', 'orderby' => 'menu_order ASC, ID', 'order' => 'DESC') );
		echo json_encode($attachments);
		die;
	}
	
	function wpti_categories()
	{
		if(!isset($_POST['categorie_id']))
		{
			$categories = $this->getDefaultCategories();

			$debut = (isset($_POST['debut'])) ? (int) $_POST['debut'] : 0;
			$fin = $debut + $this->categoriesParPage;
			$i = 0;

			$tab_categories = array();
			foreach($categories as $categorie)
			{
				if($i == $fin)
				 	break;

				if($debut <= $i) :
					array_push($tab_categories, $this->getArticlesByCategorie( $categorie ));
				endif;
				$i++;
			}
			
			echo json_encode(
				array(
					'debut' => $debut,
					'categories' => $tab_categories,
					'fin' => $fin,
					'nbCategories' => count($categories)
				)
			);
		}
		else
		{
			echo json_encode(
				$this->getArticlesByCategorie($_POST['categorie_id'], $_POST['debut'])
			);
		}
		die;
	}
}