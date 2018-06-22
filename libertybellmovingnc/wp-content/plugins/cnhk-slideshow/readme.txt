=== Cnhk Slideshow ===
Contributors: cnhk_systems
Tags: slideshow, images, jquery, full width slider, mobile, drag and drop, multiple slideshows, translation ready
Requires at least: 3.6.1
Tested up to: 3.7.1
Stable tag: 2.1.1
License: GPLv3 or later

Fast setup and easy to use, full width slideshow plugin for WordPress with a drag and drop system for editing slides order.

== Description ==

Cnhk Slideshow is a slideshow plugin that uses jQuery cycle and is designed for fluid width layout. It uses an easy drag and drop system for managing slideshow. Very fast and easy to setup, it also supports swipe gestures on mobile devices.

Easy integration by shortcode, widget or template tag.

**Features**

* Designed for fluid width and responsive page layout.
* Supports swipe gestures on mobile devices.
* Slides do not mix with the other images of your site (are not attachments nor custom post).
* Creates a Slideshow Widget that you can use on every widget area of you theme.
* Adds a shortcode so you can display a slideshow within a post or page content (`[cnhk_slideshow name="your Slideshow"]` or `[cnhk_slideshow]your Slideshow[/cnhk_slideshow]`).
* Each slide can be used any times, in any slideshow and a page or post can have as many slideshows as you want.
* You can display a text (rich text) as a caption on each slide.
* Simple drag and drop system to add, delete or move a slide within a slideshow.
* Possibility to remove some navigation buttons independently for each slideshow.
* Translation ready.

**IMPORTANT NOTE**

If you are currently using a **1.x** version of this plugin, backup your images before updating the plugin, because the upgrade process will erase your image files and will break all your current slideshows.

== Installation ==
Upload the cnhk-slideshow folder to your /wp-content/plugins/ directory or go to Plugins -> Add New from the Dashboard.
Activate the plugin through the Plugins menu.
You now have a new menu item after "settings".

= How to use it =

You can work on slides or slideshow independently. You can choose to upload slides first or opt for setting up a slideshow.
All slideshows are full width and responsive, in other terms it will fill all available width in the place where you put it, and will be resized automatically each time you resize your web browser or change the orientation of your phone or tablet.
You do not need to enter any size value, the slideshow takes all the width available and calculates its height on basis of the width/height ratio of the first slide present in the list (before skipping if the skip option is enabled).
So all you have to do before displaying a slideshow is to upload slides, create a slideshow, and then drop the slides that you need onto the right column on the *"slides"* tab of the **"slideshow"** page.

**Slides**

You can upload .png and .jpg (or .jpeg) files. For each slide you can asign a title and a link. The title is used in the HTML title attribute of each slide.
But it also affects the filename. For example, *"A $100 bill"* and *"A £100 bill"* will produce the same filename.

Deleting a slide is permanent (No trash system like for posts and pages). When you delete a slide, it is automatically removed from any slideshow where it is present.

**Slideshow**

Like for slides names, you can use any name you want for slideshows. But using some sensible characters such as "(double quote), '(single quote), <(less than) >(greater than) and some other ones will make the slideshow not callable via shortcode.
You are still able to use it as Widget or with direct template tag, but if you plan to use the slideshow via shortcode within the content of a page or post, avoid using these characters in your slideshow's name.

After creating a slideshow, go to the *"slides"* tab of the **"slideshow"** page and drag a slide from left to right to insert it in a slideshow, and from right to left to remove it. The display order is as it is shown on the right column (from top to bottom).
You can edit settings of each slideshow independently on the *"slideshow"* tab of the **"slideshow"** page. Descriptions of the settings on this page are (I hope :)) pretty clear. Anyway, if you need more explanation, the support forum is intended for that.
If you have more than one slideshow, make sure you're editing the right one.

Deleting a slideshow does not affect slides data and files.

Now you have ***3 way to display your slideshow***:

***In sidebar using widget***

A widget called *"Cnhk Slideshow"* is now available in the widget page of your admin panel. Drag it in your sidebar and select the slideshow you want to display.

***In your post using shortcode***

In your post you can use a shortcode like **[cnhk_slideshow name="my slideshow"]** or **[cnhk_slideshow]my slideshow[/cnhk_slideshow]** where ***my slideshow*** is the name you defined when creating the slideshow on the **"slideshow"** page.

***Using template tag***

Directly in your theme's files with `<?php if ( function_exists( 'cnhk_slideshow' ) ) cnhk_slideshow( 'my slideshow' ); ?>`

**Tip** : Use the shortcode in a post and preview this post to try your slideshow without publishing it on the front end.

== Frequently Asked Questions ==

= Does this plugin support Multisite =

No, the plugin is not intended for that.

= How can I modify the styling of the captions on the slides =

The shortest way is to directly edit the corresponding css file (/scripts/overlay-css.css).

= Can the plugin be used to display two or more slideshow =

Yes! The plugin supports multiple slideshows and many slideshows can appear in the same page/post, even the same slideshow in different places.

= Slides appear in a different order that the one I defined in the admin panel =

* If you have more than one slideshow, please verify which one you've edited. A selection area, with a list of all slideshow is available above the thumbnail area on the *"slides"* tab of the **"slideshow"** page.
* Verify the skip option.

= I've created a slideshow, performed all settings but nothing appears =

* Ensure that you put something in the right column on the *"slides"* tab of the **"slideshow"** page.
* If you use a shortcode or a template tag, check the *"name"* parameter. This name is case sensitive.

== Screenshots ==

1. Slideshow preview
2. Slides edition page
3. Slideshow settings page
4. Slideshow page - slides tab

== Changelog ==

= 2.1.1 =

* Fixed a small bug in the main class

= 2.1 =

* Added the caption capability.
* Misc css adjustment.
* Put some texts in the "common texts" array property of the main class, in order to avoid possible issues on translated versions.

= 2.0.2 =

* Fixed bugs reported on the support forum of wordpress.org.
* Added tile transitions plugin of cycle2. (tileBlend and tileSlide).
* Prev/Next button image resized. (48x48 => 36x36)

= 2.0.1 =

* Added the forgotten swipe functionality related file.
* Added a fix for the swipe functionality with iOS 6.

= 2.0 =

* Source code structure completely renewed. Switched to OOP.
* Moved the slides directory in a subfolder of the standard uploads directory. So, slides are no more deleted when upgrading the plugin.
* Removed the background functionality.
* Added launch methods and the capability to skip all uncompletely loaded images.
* Slide can now be used multiple times in one or more slideshow.
* Switched to jQuery.Cycle2 plugin.
* Navigation buttons redesigned, new graphics created for admin pages icons.
* Translation ready.

= 1.1.1 =

* Fixed bugs. An image with 'none' as src was added if there is no background.
* Background is now resized to fit the container before the slideshow starts.
* Fixed bug in ajax.php which causes problem when trying to set a slide as "Unused" while it is still used (and ordered) inside a slideshow.

= 1.1 =

* Added transparency support *(.png files)*
* Added dynamic edition *(ajax)* of slide's properties
* Added optional background image
* Added new navigation buttons
* Added uninstall.php for a separate (from deactivation) uninstallation process

= 1.0 =

* initial release

== Upgrade Notice ==

= 2.1.1 =

Minor bug fix.

= 2.1 =

Add the caption capability.

= 2.0.2 =

fix for known issues and addition of tile transition effects

= 2.0.1 =

Small fix patch for the swipe functionality.

= 2.0 =

Deep overhaul of the source code.
Moved the slide directory onto a sub-folder of the standard upload directory.

= 1.1.1 =

Fixes bugs with background images and ajax edition.

= 1.1 =

Version 1.1 adds .png format support, dynamic edition of slide's properties, background image, new navigation buttons and uninstall process.

= 1.0 =

* initial release
