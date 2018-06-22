<?php
include ( 'mdp_css.php' );
screen_icon ();

if ($_POST['get']) {

	self::genReveiws();

}
global $wpdb;

$table_name = $wpdb->prefix . "mdp_reviews";
$sql = "SELECT * FROM $table_name";
$rows = $wpdb->get_results($sql);



?>
<div class="wrap">
<div class="right_block">
	<?php include ( 'mdp_contact.php' ); ?>
</div>
<div class="left_block">
<h2>Local Business SEO Reveiws</h2>



<table class="mdp_table">
<tbody><form action="options.php" method="post" class="mdp_form">
<?php settings_fields ( $plugin_id . '_reviews' ); ?>
<tr style="background:#eeeeee;">
	<td colspan="3"><h3>Reviews</h3></td>
</tr>
<tr>
	<td class="left">Activate Reveiws:</td>
	<td><select name="mdp_review">

			<?php if ( get_option ( 'mdp_review' ) == '1' ) { ?>
				<option value="1">Enabled</option>
				<option value="0">Disabled</option>
			<?php
			} else {
				?>
				<option value="0">Disabled</option>
				<option value="1">Enabled</option>
			<?php } ?>

		</select></td>
	<td></td>
</tr>
<tr>
	<td>Review Default:</td>
	<td colspan="2"><input type="checkbox"
	                       name="mdp_review_default" <?php if ( get_option ( 'mdp_review_default' ) == 'on' ) {
			echo 'checked';
		} ?> /> Using the default review method the microdata will place a non visible external link to various websites on your
		website. This is done through the microdata author provider to give relevance to the author. In the current version this option must be selected if you are going to use reviews.
	</td>
</tr>
	<tr style="background:#eeeeee;">
		<td colspan="3"><h3>Keyword</h3></td>
	</tr>
	<tr><td colspan="3">The keyword is essential part of the review for Seo, using a keyword that you are trying rank well on will benefit your sites overall search rank. Future releases will allow for individual keywords to be used on each post/page.</td></tr>
<tr>
	<td>Keyword:</td>
	<td><input type="text" name="mdp_keyword" value="<?php echo get_option ( 'mdp_keyword' ); ?>"
	           placeholder=""/></td>
	<td>Will use the blog name if left empty.</td>
</tr>


<tr>
	<td colspan="3"></td>
</tr>
<tr>
	<td colspan="3"><?php submit_button (); ?></td>
</tr>

</form>
</tbody>
</table>
<table class="mdp_table">
	<tbody>

		<tr style="background:#eeeeee;">
			<td colspan="3"><h3>Generate Reviews</h3></td>
		</tr>
		<tr>
			<td colspan="3">When you generate reviews a unique review will be written for every page/post you have with 5 stars. After you generate reviews you will be able to see a list of them below. You do not need to always generate reviews after creating a page. If enabled reviews are automatically generated when a page/post is visited.</td>
		</tr>
		<tr>
			<td colspan="3"><form action="" method="post"><input type="submit" value="Generate Reviews" name="get"
                                     class="button"></form>
			</td>

		</tr>
		<tr style="background:#eeeeee;">
			<td colspan="3"><h3>Current Reviews</h3></td>
		</tr>
		<tr style="background: #eeeeee;">
			<td colspan="3">
				<table style="width:100%">
					<tr style="background: #eeeeee;">
						<td style="width:20%;">Author</td><td style="width:60%;">Review Body</td><td style="width:30%;overflow: hidden;">Page with review</td></tr>
		<?php
			foreach($rows as $row)
			{
				if(get_option('mdp_keyword')){
					$mdp_keyword = get_option('mdp_keyword');
				}else{
					$mdp_keyword = get_bloginfo('name');
				}
				$review_body = str_replace('[keyword]', $mdp_keyword, $row->review_body);

				echo '<tr style="background: #ffffff;"><td>'.$row->author.'</td><td>'.$review_body.'</td><td><a href="http://www.google.com/webmasters/tools/richsnippets?q='.get_permalink($row->pid).'" target="_blank">'.get_the_title($row->pid).'</a></td></tr>';
			}
		?>
				</table>
			</td>
		</tr>

	</table>
	</tbody>
</div>
</div>