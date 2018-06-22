<div class='postbox-container' style='width:35%;'>
<div id='side-sortables' class='meta-box-sortables'>

<div id="about-plugins" class="postbox " >
<h3><span>About</span></h3>
<div class="inside">
<div align="center"><img src="<?php echo plugins_url().$thisplugin; ?>/images/logo-2017-flat-grey.png" alt="SEO Automatic" style="float: none; width: 100%; height: auto;" /></div>
<br />
<iframe src="http://www.facebook.com/plugins/like.php?app_id=240292089323261&amp;href=http%3A%2F%2Fwww.facebook.com%2FSearchCommander&amp;send=false&amp;layout=standard&amp;width=250&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:80px;" allowTransparency="true"></iframe>
<?php if (function_exists('autoseo_add_pages_pro')){ } else { ?>
<!--<ul>
	<li style="margin-left: -4px;"><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="5701868">
<input type="image" src="<?php echo plugins_url().$thisplugin; ?>/images/donate.jpg" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" onclick="this.form.target='_blank';return true;">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</li>
</ul>-->
<?php } ?>

</div></div>

<div id="resources" class="postbox" >
<h3><span>Resources</span></h3>
<div class="inside">
<ul>
	<li><img src="<?php echo plugins_url().$thisplugin; ?>/images/favicon.png" height="16" width="16" alt="SEO Automatic" /> <a href="https://www.searchcommander.com/wp-plugin-gather-reviews/" target="_blank"> Plugin Suggestions</a></li>
	<li><img src="<?php echo plugins_url().$thisplugin; ?>/images/favicon.png" height="16" width="16" alt="SEO Automatic" /> <a href="https://wordpress.org/plugins/our-profiles/" target="_blank"> Plugin Page at Wordpress</a></li>
	<li><img src="<?php echo plugins_url().$thisplugin; ?>/images/favicon.png" height="16" width="16" alt="SEO Automatic" /> <a href="https://wordpress.org/support/plugin/our-profiles" target="_blank"> Plugin Support</a></li>
</ul>
</div></div>

<div id="resources" class="postbox" >
<h3><span>Search Commander Blog</span></h3>
<div class="inside">
<?php
include_once(ABSPATH . WPINC . '/feed.php');
$rss = fetch_feed('https://www.searchcommander.com/news/feed/');
if (!is_wp_error( $rss ) ) : 
    $maxitems = $rss->get_item_quantity(3); 
    $rss_items = $rss->get_items(0, $maxitems); 
endif;
?>

<ul>
    <?php if ($maxitems == 0) echo '<li>No items.</li>';
    else
    foreach ( $rss_items as $item ) : ?>
    <li>
        <a href='<?php echo $item->get_permalink(); ?>' target='_blank' title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
        <?php echo $item->get_title(); ?></a><br />
    </li>
    <?php endforeach; ?>
</ul>
</div></div>

<div id="resources" class="postbox" >
<h3><span>Recommended Affiliates</span></h3>
<div class="inside">
<div align="center">
<a href="https://www.searchcommander.com/rec/wpengine/?utm_source=profilestheme" target="_blank">
<img src="<?php echo plugins_url().$thisplugin; ?>/images/affiliates/wpengine.jpeg" alt="WPEngine" /></a>
<br /><br />
<a href="https://www.searchcommander.com/rec/sucuri/?utm_source=profilestheme" target="_blank" rel="nofollow"><img src="<?php echo plugins_url().$thisplugin; ?>/images/affiliates/sucuri125x125-2.png" alt="Sucuri Security" /></a>
<br /><br />
<a href="https://www.searchcommander.com/rec/backupbuddy/?utm_source=profilestheme" target="_blank" rel="nofollow"><img src="<?php echo plugins_url().$thisplugin; ?>/images/affiliates/wptwinbanner-125.png" alt="WPTwin" /></a>
<br /><br />
<a href="https://www.searchcommander.com/rec/elegant/?utm_source=profilestheme" target="_blank" rel="nofollow"><img src="<?php echo plugins_url().$thisplugin; ?>/images/affiliates/divi-aff-125.jpg" alt="Divi" /></a>
</div>
</div></div>

</div></div>