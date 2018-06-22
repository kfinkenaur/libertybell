=== TG Facebook Meta Tags ===
Contributors: ashokdhamija
Donate link: http://www.tekgazet.com
Tags: Facebook, meta tags, meta, image, opengraph, open graph, featured, thumbnail, incorrect, share, social, posts
Requires at least: 3.1
Tested up to: 4.2.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add Facebook Open Graph meta tags to your posts so that image and other details are shown properly when your content is shared on Facebook.

== Description ==

TG Facebook Meta Tags plugin adds Facebook Open Graph meta tags to the Head section of the HTML code of your posts on WordPress so that when your posts are shared on Facebook, image and other details are shown properly.
 
Many a time, when someone shares content on Facebook, either no image is shown or wrong image is shown or image of wrong size is shown. Likewise, sometimes, wrong brief description of the content is shown. This plugin adds appropriate Facebook Open Graph meta tags in the HTML code of your website so that image and other details could be shown properly when your content is shared on Facebook. You (or your visitors) can continue to use any sharing buttons or methods to share your contents on Facebook, this plugin will insert the correct meta tags for Facebook sharing in the HTML code of your posts.

This plugin adds these meta tags to the posts on your WordPress website or blog. It also adds a Canonical URL of each post to the Head section of the HTML code of that post. It is helpful for better SEO of the posts and also for ensuring that Facebook Meta Tags are attached with the correct URL of a post. 

This plugin adds the following 6 Facebook Meta Tags to the HTML code:

* og:url (for the URL of the post which is being shared). It will be automatically taken from your post. In addition, as mentioned above, a Canonical URL is also added automatically.
* og:type (for the Type of post being shared, i.e., 'article'). It will be automatically inserted by the plugin.
* og:title (for the Title of the post which is being shared). It will be automatically taken from your post.
* og:site_name (for your website name). The site-name will be automatically taken from your WordPress settings.
* og:description (for the Brief Description of the post which is being shared). It is automatically taken from the Excerpt of your post. [Learn more](http://www.tekgazet.com/what-is-excerpt-in-wordpress-and-how-to-add-it-manually-for-a-post/wordpress2/2863.html) about what is Excerpt and how to add it manually for a post in WordPress. If no excerpt has been added manually, and if your theme does not create automatic excerpts in posts, then this plugin will automatically create a 55-word description on-the-fly from the beginning of the post, which may then be used by Facebook (in full or in part) to describe the shared link.
* og:image (for the Image that will be shown along with the post which is being shared). If selected, preference will be given to featured or thumbnail image for the post to be added as meta tag image for that post. However, if no featured image is found for a post, the default image set by you in the options of this plugin will be added as meta tag for that post. [Learn more](http://www.tekgazet.com/what-is-featured-or-thumbnail-image-in-wordpress-and-how-to-set-it-for-a-post/wordpress2/2864.html) about how to set featured image for a post in WordPress.

This plugin allows you to set a default image by uploading a new image or by selecting an existing image from the media library of your WordPress website, or by providing the URL path of an image. The image uploaded or selected by you in the options of the plugin, will be shown as default image in the meta tags of your posts, if no specific featured or thumbnail image is set for an individual post. 

Note: For best results, the default image should generally be of the size of 1200 x 630 pixels for best displays on high resolution devices. At the minimum, you should use images that are 600 x 315 pixels to display links to posts with larger images. If you use an image of some other size, try to keep your image as close to 1.91:1 aspect ratio as possible to display the full image in Facebook News Feed without any cropping. The minimum image size is 200 x 200 pixels, otherwise it may not appear or may not appear properly in your Facebook shares.

TG Facebook Meta Tags plugin asks you to set individual options for these meta tags, whether or not to add them to the HMTL code of posts (except for, og:type meta tag, which is automatically set, if other meta tags are being added, and also the Canonical URL of each post which is added automatically).

Once installed, the settings of the TG Facebook Meta Tags plugin would be available for being changed from the 'TG Facebook Meta Tags' option in the 'Settings' menu on the admin screen (back-end) of your WordPress website or blog.

Detailed instructions have been provided on the settings / options page of TG Facebook Meta Tags plugin in the admin area. Each setting has been explained in detail.

This plugin works on all WordPress websites or blogs. It is a very light-weight plugin.

**About the plugin and our other plugins:**

This plugin has been developed by [Ashok Dhamija](http://tilakmarg.com/dr-ashok-dhamija/), who has also developed few other plugins, such as the following:

* [TG Facebook Comments](https://wordpress.org/plugins/tg-facebook-comments/).
* [TG Copy Protection](https://wordpress.org/plugins/tg-copy-protection/).
* [TG Customized Tags](https://wordpress.org/plugins/tg-customized-tags/).
* [TG Email Protection](https://wordpress.org/plugins/tg-email-protection/).

== Installation ==

1. Upload the 'tg-facebook-meta-tags' folder to the '/wp-content/plugins/' folder on your website server.
2. It will show as installed plugin. Then, activate the plugin through the 'Plugins' menu in WordPress admin page.
3. You can also use the 'Add New' command on the 'Plugins' menu in WordPress admin page. Thereafter, search this plugin from the search-box. Or, alternatively, click the 'Upload Plugin' button to upload the zip file for this plugin (tg-facebook-meta-tags.zip), and then follow on-screen instructions to install and activate the plugin.

== Frequently Asked Questions ==

= Will this plugin change the contents of my WordPress database by contents of my posts permanently? =

No. The contents of your database are NOT changed by the plugin. What the plugin does is something like this: when a visitor requests a post to be displayed in the browser (by visiting its URL), WordPress will display the post by extracting the relevant contents from the database; it is at this time that this plugin steps in and adds the relevant Facebook Meta Tags to the HTML code of the post that is being displayed. Thus, the contents of your database are not changed at all by this plugin.

= Why is it that in spite of these meta tags being present in the HTML code, sometimes the Facebook share still does not correctly show the image and other details? =

Facebook has laid down certain guidelines to insert certain meta tags to show your Facebook shares correctly. TG Facebook Meta Tags plugin follows these guidelines correctly and puts these meta tags in the HTML code of your posts. 

However, there may be issues with your older posts sometimes. In spite of correct meta tags, Facebook may not show correct image or description or other details. The reason is that Facebook caches the images and other details for every URL that is shared. If you change the image or other details at a later stage, Facebook may still use the older values since it keeps them in its cache. Facebook usually uses the existing 'scrape' information of a page for 30 days after which it re-scrapes the page to refresh values for Facebook shares of a web page. You can manually re-scrape your web-page whose Facebook share is showing incorrectly, though it may still be erratic sometimes and may take time to correct it and refresh the values. So, you may have to be patient. For more details on these issues, please visit [TG Facebook Meta Tags Plugin]( http://www.tekgazet.com/tg-facebook-meta-tags-plugin) page.

For the new posts published after installing this plugin, the meta tags added by this plugin should normally work alright for Facebook shares. However, as advised by Facebook Developers website, you should generally wait for some time (may be a few minutes) after publishing new post to share it, so that Facebook is able to correctly detect the meta tags.

Please also note that if there is some problem in a Facebook share not showing correct image or other details, then this would be a problem with the Facebook itself and not with this plugin. Facebook shares have been behaving very erratically for last few years and many support forums on the Internet reflect it emphatically. This plugin inserts the correct meta tags as it states. You can verify the meta tags inserted by this plugin in your post by seeing its HTML source code (for example, in Google Chrome browser, from the right-click context menu, select 'View page source' or directly click Ctrl-U keys together). You would find that these meta tags are correctly added to your HTML code of your post. One sample of the meta tags added by this plugin may be seen in the third screenshot on the [Screenshots]( https://wordpress.org/plugins/tg-facebook-meta-tags/screenshots/) page.

= How can I ask a support question or get help from you in case of any issue with TG Facebook Meta Tags Plugin? =

If you have any doubt or support questions, you are welcome to leave your comments at the [TG Facebook Meta Tags plugin](http://www.tekgazet.com/tg-facebook-meta-tags-plugin) page. You can also ask your support questions on [WordPress plugin site](https://wordpress.org/plugins/tg-facebook-meta-tags/).

== Screenshots ==

1. TG Facebook Meta Tags plugin settings interface (Settings -> TG Facebook Meta Tags). 
2. How to access TG Facebook Meta Tags plugin settings interface from admin screen of your WordPress website.
3. See in action, how Facebook Meta Tags have been inserted by this plugin in the Head section of the HTML source code of a post on WordPress. 

== Changelog ==

= 1.0 =
* This is the first fully-tested stable version of the plugin.

== Upgrade Notice ==

n.a.


