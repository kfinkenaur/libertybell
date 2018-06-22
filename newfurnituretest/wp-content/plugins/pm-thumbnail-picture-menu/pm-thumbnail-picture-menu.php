<?php
/* これは文字化け防止のための日本語文字列です。
   このソースファイルは UTF-8 で保存されています。
   Above is a Japanese strings to avoid charset mis-understanding.
   This source file is saved with UTF-8. */
/*
Plugin Name: PM Thumbnail Picture Menu
Plugin URI: http:/musilog.net/
Description: サムネイル画像を使ったナビゲーションメニューリンクを生成するプラグイン
Author: wackey
Version: 1.31
Author URI: http://musilog.net/
*/

/*  Copyright 2012 wackey

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


/***------------------------------------------
　サムネイル画像メニュー描画関数　参考：WordPressで新着記事へのリンクを投稿の上に設置する方法 | NANOKAMO BLOG http://nanokamo.com/articles/web-service/wordpress/sincyaku-secchi.html
------------------------------------------***/
function thumbpicturemenu() {

// データベースから設定情報を読み込む
$tpm_pict_yokohaba = get_option('tpm_pict_yokohaba');
if ($tpm_pict_yokohaba=="") {$tpm_pict_yokohaba=178;}//横幅デフォルト値
$tpm_pict_tatehaba = get_option('tpm_pict_tatehaba');
if ($tpm_pict_tatehaba=="") {$tpm_pict_tatehaba=133;}//縦幅デフォルト値
$tpm_pict_mojisuu = get_option('tpm_pict_mojisuu');
if ($tpm_pict_mojisuu=="") {$tpm_pict_mojisuu=25;}//文字数デフォルト値
$tpm_pict_amount = get_option('tpm_pict_amount');
if ($tpm_pict_amount=="") {$tpm_pict_amount=5;}//写真数デフォルト値
$tpm_pict_category_switch = get_option('tpm_pict_category_switch');
if ($tpm_pict_category_switch=="") {$tpm_pict_category_switch="0";}//カテゴリーごとに新着表示するかのスイッチ
$tpm_pict_rand_switch = get_option('tpm_pict_rand_switch');
if ($tpm_pict_rand_switch=="") {$tpm_pict_rand_switch="0";}//ランダム画像のスイッチ
?>
<style>
.thumbpicturemenu {
position: absolute;
bottom: 7px;
width:<?php echo $tpm_pict_yokohaba-8; ?>px;
left: 4px;
text-align: left;
background-image: -webkit-gradient(linear, left top, left bottom, from(transparent), to(#333333));
background: -moz-linear-gradient(transparent 0pt, #333333 100%);
filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startcolorstr=#00333333, endcolorstr=#ff333333));
-ms-filter:"progid:DXImageTransform.Microsoft.gradient(GradientType=0,startcolorstr=#00333333, endcolorstr=#ff333333))";
padding: 8px 4px 4px 4px;
}

a.thumbpicturemenu {
color: white;
text-decoration: none;
}

.thumbpicturemenuimg {
position: relative;
float: left;
display: block;
/*background:#fff;*/
}
 
.thumbpicturemenuimg img {
width: <?php echo $tpm_pict_yokohaba-2; ?>px;
height: <?php echo $tpm_pict_tatehaba-2; ?>px;
border:1px solid #cccccc;
margin: 4px;
}
 
#thumbnailheader {
/*width: 950px;*/
/*height: 158px;*/
margin: 10px 0 20px 0;
}
</style>
<div id="thumbnailheader">

<?php  if (is_front_page() || $tpm_pict_category_switch == "0") { ?>
<?php query_posts('&posts_per_page='.$tpm_pict_amount.'&cat=0'); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="thumbpicturemenuimg">
<a href="<?php the_permalink(); ?>">
<img src="<?php echo catch_that_image($tpm_pict_rand_switch); ?>" alt="" />
</a>
<span>
<a href="<?php the_permalink(); ?>" class="thumbpicturemenu"><?php echo mb_substr (the_title('','',false),0,$tpm_pict_mojisuu,"utf-8"); ?>...</a>
</span>
</div>

<?php endwhile; wp_reset_query();?>
<?php endif; wp_reset_query();?>
<?php
} else {//if is_front
?>

<?php
$cat = get_the_category();
$cat_id = $cat[0]->cat_ID;
?>

<?php query_posts('&posts_per_page='.$tpm_pict_amount.'&cat='.$cat_id); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="thumbpicturemenuimg">
<a href="<?php the_permalink(); ?>">
<img src="<?php echo catch_that_image($tpm_pict_rand_switch); ?>" alt="" />
</a>
<span>
<a href="<?php the_permalink(); ?>" class="thumbpicturemenu"><?php echo mb_substr (the_title('','',false),0,$tpm_pict_mojisuu,"utf-8"); ?>...</a></span>
</span>
</div>

<?php endwhile; wp_reset_query();?>
<?php endif; wp_reset_query();?>
<?php
}//if is_front else
?>
</div>
<?php
}//function



/***------------------------------------------
　サムネイル画像生成関数 参考：記事内の一番最初の画像を取得してサムネイル画像表示 | 簡単ホームページ作成支援-Detaramehp http://detarame.moo.jp/2010/12/17/%E8%A8%98%E4%BA%8B%E5%86%85%E3%81%AE%E4%B8%80%E7%95%AA%E6%9C%80%E5%88%9D%E3%81%AE%E7%94%BB%E5%83%8F%E3%82%92%E5%8F%96%E5%BE%97%E3%81%97%E3%81%A6%E3%82%B5%E3%83%A0%E3%83%8D%E3%82%A4%E3%83%AB%E7%94%BB/
------------------------------------------***/
function catch_that_image($tpm_pict_rand_switch ) {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];
 
if(empty($first_img)){ //Defines a default image
		$noimage_file = "noimage.gif";
		if ($tpm_pict_rand_switch=="1") {
		$rand = mt_rand(1,5);
		$noimage_file = "ni00".$rand.".gif";
		}
        $first_img = WP_PLUGIN_URL."/pm-thumbnail-picture-menu/img/".$noimage_file;
    }
    return $first_img;
}




/***------------------------------------------
　管理画面作成
------------------------------------------***/

// 管理画面、管理用
add_action('admin_menu', 'thumb_picture_menu_menu');

// 管理画面メニュー作成関数
function thumb_picture_menu_menu() {
add_options_page('PM Thumbnail Picture Menu Options', 'PM Thumbnail menu', 8, __FILE__, 'pm_thumb_pict_menu_options');
}

function pm_thumb_pict_menu_options() {
// ポストされた値の入力チェックと書き込み
if (isset($_POST['update_option'])) {
check_admin_referer('pm_thumb_pict_menu_options');
update_option('tpm_pict_yokohaba', $_POST['tpm_pict_yokohaba']);
update_option('tpm_pict_tatehaba', $_POST['tpm_pict_tatehaba']);
update_option('tpm_pict_mojisuu', $_POST['tpm_pict_mojisuu']);
update_option('tpm_pict_amount', $_POST['tpm_pict_amount']);
update_option('tpm_pict_category_switch', $_POST['tpm_pict_category_switch']);
update_option('tpm_pict_rand_switch', $_POST['tpm_pict_rand_switch']);
?>

<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p></div>

<?php
}
$tpm_pict_yokohaba = get_option('tpm_pict_yokohaba');
$tpm_pict_tatehaba = get_option('tpm_pict_tatehaba');
$tpm_pict_mojisuu = get_option('tpm_pict_mojisuu');
$tpm_pict_amount = get_option('tpm_pict_amount');
$tpm_pict_category_switch = get_option('tpm_pict_category_switch');
$tpm_pict_rand_switch = get_option('tpm_pict_rand_switch');
?>
<div class="wrap">
<h2>PM Thumbnail Picture Menu管理画面</h2>
<p>一つの写真の縦幅・横幅のpx数を半角数字で入力してください。<br>
記事タイトル文字数を指定するとその文字数で記事タイトル文字を切ります（2行以上にしたくない、など調整にお使いください）</p>

<form name="form" method="post" action="">
<input type="hidden" name="action" value="update" />
<?php wp_nonce_field('pm_thumb_pict_menu_options'); ?>

<table class="form-table"><tbody>

<tr>
<th><label for="tpm_pict_yokohaba">横幅px数（半角数値）</label></th> <td><input type="text" name="tpm_pict_yokohaba"
id="tpm_pict_yokohaba" value="<?php
echo attribute_escape($tpm_pict_yokohaba); ?>" /></td>
</tr>

<tr>
<th><label for="tpm_pict_tatehaba">縦幅px数（半角数値）</label></th> <td><input type="text" name="tpm_pict_tatehaba"
id="tpm_pict_tatehaba" value="<?php
echo attribute_escape($tpm_pict_tatehaba); ?>" /></td>
</tr>

<tr>
<th><label for="tpm_pict_mojisuu">記事タイトル文字数（半角数値）</label></th> <td><input type="text" name="tpm_pict_mojisuu"
id="tpm_pict_mojisuu" value="<?php
echo attribute_escape($tpm_pict_mojisuu); ?>" /></td>
</tr>

<tr>
<th><label for="tpm_pict_amount">表示する写真の数（半角数値）</label></th> <td><input type="text" name="tpm_pict_amount"
id="tpm_pict_amount" value="<?php
echo attribute_escape($tpm_pict_amount); ?>" /></td>
</tr>

<tr>
<th><label for="tpm_pict_category_switch">トップページ以外の時はカテゴリーごとの新着記事を表示する</label></th> <td><input type="radio" name="tpm_pict_category_switch" id="tpm_pict_category_switch1" value="0" <?php if ($tpm_pict_category_switch==0) {echo "checked ";} ?> />常に全体の新着記事
<input type="radio" name="tpm_pict_category_switch" id="tpm_pict_category_switch2" value="1" <?php if ($tpm_pict_category_switch==1) {echo "checked ";} ?> />トップ以外はそのカテゴリーの新着記事を表示</td>
</tr>

<tr>
<th><label for="tpm_pict_rand_switch">noimage画像</label></th> <td><input type="radio" name="tpm_pict_rand_switch" id="tpm_pict_rand_switch1" value="0" <?php if ($tpm_pict_rand_switch==0) {echo "checked ";} ?> />白地にグレーのものを固定
<input type="radio" name="tpm_pict_rand_switch" id="tpm_pict_rand_switch2" value="1" <?php if ($tpm_pict_rand_switch==1) {echo "checked ";} ?> />ランダム表示</td>
</tr>

</tbody></table>

<p class="submit">
<input type="submit" name="update_option" class="button- primary" value="<?php _e('Save Changes'); ?>" />
</p>

</form>
</div>

<?php
}



/***------------------------------------------
　プラグインアンインストール関連
------------------------------------------***/

// プラグインアンインストール
add_action('deactivate_pm-thumb-picture-menu/pm-thumb-picture-menu.php', 'remove_thumb_picture_menu');
register_deactivation_hook(__FILE__, 'thumb-picture-menu');


// プラグインアンインストール時に削除するフィールドを定義した関数
// プラグイン停止時にフィールドを削除
function remove_thumb_picture_menu()
{
	delete_option('tpm_pict_yokohaba');
	delete_option('tpm_pict_tatehaba');
	delete_option('tpm_pict_mojisuu');
	delete_option('tpm_pict_rand_switch');
}

?>