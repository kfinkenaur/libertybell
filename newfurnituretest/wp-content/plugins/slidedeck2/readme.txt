=== SlideDeck 2 Lite Responsive Content Slider ===
Contributors: SlideDeck
Donate link: http://www.slidedeck.com/
Tags: Slider, dynamic, responsive, image gallery, iPad, jquery, media, photo, pictures, plugin, posts, Search Engine Optimized, seo, skinnable, slide, slide show, slider, slideshow, theme, touch support, video, widget, Flickr, Instagram, 500px, RSS, Pinterest, Google+, YouTube, Vimeo, Dailymotion, Picasa, Dribbble, Facebook, NextGEN Gallery
Requires at least: 3.3
Tested up to: 4.5
Stable tag: trunk
License: GPLv3

Create responsive content sliders on your WordPress blogging platform. Manage SlideDeck content and insert them into templates and posts.

== Description ==

= Deprecation Notice =
**SlideDeck 2 Lite Responsive Content Slier is deprecated.** As of 10/05/2015 we will not longer be updating this plugin, but we suggest that you consider trying [SlideDeck 3 Lite](https://wordpress.org/plugins/slidedeck3/) for WordPress instead.
[SlideDeck 3 Lite](https://wordpress.org/plugins/slidedeck3/) has replaced SlideDeck 2 and is now our primary SlideDeck focus.

Thanks for your support! - The SlideDeck Team


http://www.youtube.com/watch?v=IXUH73L7_lM

= Responsive Content Slider by SlideDeck 2 =
= Easily create responsive content sliders for your WordPress site without code. Use images & text, plus YouTube, Flickr, Pinterest & more =
SlideDeck 2 for WordPress is a responsive slider plugin that lets you easily create content sliders out of almost any content. Connect to a variety of Content Sources like YouTube, Flickr, WordPress posts and Pinterest to create gorgeous, dynamic sliders in a few clicks - no coding is required.

**Requirements:** WordPress 3.3+, PHP5 and higher

**Important Links:**

* [More Details](http://www.slidedeck.com/)
* [Knowledge Base](http://support.slidedeck.com/)
* [Join our affiliate program](http://www.slidedeck.com/affiliates)

**Lite Version:**
This Lite version of SlideDeck 2 does not include the full set of 14 content sources, like Facebook and NextGEN Gallery, that are available in the premium version. To see all the features available in the premium versions, check out the [live demo server](http://demo.slidedeck.com/wp-login.php).

This plugin is free to use and is not actively supported by the author, but will be monitored for serious bugs that may need correcting.

== Installation ==

1. Upload the `slidedeck2-lite` folder and all its contents to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create a new SlideDeck from the “SlideDeck » Manage” menu in the control panel sidebar
4. Insert a SlideDeck in your post or page by clicking on the "Embed a SlideDeck" button above the rich text editor in the post/page view.

You can also place a SlideDeck in your template or theme via the PHP command “do_shortcode()”. Just pass the ID of the SlideDeck you want to render. For example:
`<?php echo do_shortcode( "[SlideDeck2 id=1644]" ); ?>`

Where 1644 is the SlideDeck's ID. You can also see this code snippet when you save a new SlideDeck for the first time.

== Screenshots ==

1. The SlideDeck manage view.
2. The editing interface showing the current deck and the top of the lens selection area.
3. One of the many settings page aviable to you. You can tweak dozens of settings for each SlideDeck.
4. Example - Flickr images from ViewsOfIreland.com using the Tool Kit Lens
5. Example - Pinterest images from dwellmedia using the O-Town lens
6. Example - YouTube videos from NativeInstruments using the Reporter Lens

== Frequently Asked Questions ==

= Do you have an affiliate program? =
Yes, we do! It's free to join, and you can get up to a 75% commission on each sale of SlideDeck you refer to us - that's $112 per sale! Go here to sign up: [http://slidedeck.com/affiliates](http://slidedeck.com/affiliates)


= Can I show multiple SlideDecks on one page? =
Of course! The only limitation is the number of slides per SlideDeck, and what kind of content you're sourcing for each slide. The greater the amount of content you're trying to show all at once, the slower your pages will render for your visitors, so avoid trying to show 10 SlideDecks, each with 10 YouTube videos, as it'll make your page pretty sluggish!


= What's with this sharing overlay? Can I disable that? =
Yes!
If you don't want your visitors to easily share your SlideDeck with their social networks, you can disable the sharing overlay in the deck settings. Just set "Show Overlay" to "Never."


= Can I Choose Which WordPress Pages to Show in a SlideDeck? (Featured Posts/Pages) =
If you want to use the WordPress Posts Content Source to add pages to your SlideDeck, but want to include/exclude certain pages then you'll have to add custom taxonomies to your pages. By default WordPress Posts have tags and categories, but Pages do not. The easiest way to mark certain pages on your WordPress site for inclusion in a SlideDeck is to give them categories or tags. A plugin like GD Custom Posts And Taxonomies Tools allows you to add custom taxonomies to your posts and pages. For instance, you could add a category called "Home Page SlideDeck" to your pages and then those pages can be pulled into your SlideDeck.


= What’s the difference between SlideDeck 1 and SlideDeck 2 for WordPress? =
Where to begin! The most important improvement is that SlideDeck 2 is designed to work smoothly with your existing content across a variety of Content Sources on the web, like Flickr,  your blog posts and YouTube. We think this is a way better approach instead of requiring you to create and format content specifically for your slider - as was necessary for SlideDeck in the past. This not only makes it far quicker and easier to create new sliders, but also allows you to breathe new life into content you’ve already invested time into creating. That's just the tip of the iceberg, though. You can get a much better idea as to what’s new with SlideDeck 2 by checking out the Features and Examples pages.


== Changelog ==
= 2.3.14=
* Pinterest board issue fixed. Content now is retrieved as expected.

= 2.3.13=
* Updated version number to keep parity with core

= 2.3.12 =
* Fixed issue of youtube compatibility with api version 3.

= 2.3.11 =
* Fixed Pinterest source issue. Content now is retrieved as expected.
* misc. ui updates

= 2.3.10 =
* Addresses some display issues in custom slide media library modal.
* Addresses very minor JavaScript variable namespacing error.
* Fixed an issue with TinyMCE fix in previous version for issue introduced in WordPress 3.9
* Fixed an issue with the Polarad Lens where some of the layout options were not working correctly
* Added a Content option to Polarad to hide the Image Link
* Fixed an issue where the stack transition type was not looping correctly
* Fixed an issue with the start slide value not outputting properly for RESS and Iframe decks

= 2.3.9 =
* Addresses very minor JavaScript error in the editor.

= 2.3.8 =
* Fixed loss of `$post` context when rendering a deck inside of an iFrame.
* Fixed issue of missing trailing slash on share overlay links.
* Share overlay permalink now handles the `front_page` and `home_page` URLs differently.
* Addressed a z-index issue with the O-Town lens when using videos.
* Fixed the issue where a vertical deck would not get an `active` class on the current slide.
* Cleaned up core JavaScript library and linted it using JSHint.
* Removing the inherited CSS transition for the editor interface links.

= 2.3.7 =
* Updated the core slidedeck.js to be more compatible with IE11

= 2.3.6 =
* Addressing PHP strict notices and warnings.
* Fixing static warning in SlideDeck widget.
* Removing warning from undefined `anonymous_stats_optin` key.
* Moving `slideDeck2AddonsURL` JavaScript variable to the admin views only.
* Fixed PHP warning associated with the scheduling of a cleanup event.

= 2.3.5 =
* Fixed an issue when the user agent server variable is not set.
* Reporter Lens: Improved the reliability of and Lazy Loading when using crossfade.
* Fixed a potential file inclusion vulnerability reported by one of our users.
* Added the ability to filter the admin roles for SlideDeck with: `add_filter( 'slidedeck_roles', 'function' );`

= 2.3.3 =
* Updated jquery request for IFRAME requests and insertion menu to accommodate for new WordPress 3.6 registered script structure

= 2.3.2 =
* Fixed an issue with the IE version detection snippet
* Check out SlideDeck App for using SlideDeck on non-WordPress projects!

= 2.3.1 =
* Fixing corrupt commit


= 2.3 =
* Removed Twitter Feed from Manage Page
* Adjust registered script handling in IFRAME mode to make better accommodation for schema-less URLs
* Updated lense templates for better Lazy Loading handling
* Removed Twitter as a source
* Flickr Author links for Groups fixed

= 2.2.2 =
* Revised SlideDeck Branding

= 2.2.1 =
* Fixed an indexing issue with Lazy Loading Videos
* Flickr content source: fixed author URL linking for groups
* Fixed a PHP notice in the widget class

= 2.2 =
* Fixed the `expansion_factor is not defined` error.
* Fixed the `_preferred_image_size` is not defined error.
* Added groudwork for custom CSS (available in Professional and higher).
* Fixed issue where some SlideDeck scripts were being output on other plugin pages (eg: Gravity Forms)
* Tool Kit Lens: Thumbnail images are now centered within the cropped frame.
* Reporter Lens: Fixed an issue where the layout might not change even with an empty title.
* Now includes Lazy Loading for image slides.
* Now includes Lazy Loading for video slides.

= 2.1.20130325 =
* Reporter Lens: Fixed an issue where multiple decks on one page would not navigate correctly.
* Renamed language files for proper inclusion
* Modified the way that custom taxonomies were looked up for the WordPress Posts Source
* Modified our caching methods to better work with Object Caching setups
* Added a new Advanced Option for aggressive cache flushing
* Updated image source handling for Flickr; will use current protocol i.e. http/https
* Updated font additions to remove protocol from source URL

= 2.1.20130313 =
* Support library update and removal of unused libraries

= 2.1.20130306 =
* Security improvements

= 2.1.20130228 =
* Fixing an issue with the O-Town Lens JavaScript file
* Lenses can now have no variations and the variation dropdown is correctly hidden

= 2.1.20130219 =
* Updating the version of plupload in anticipation of jQuery 1.9
* Removing all calls to jQuery.browser or $.browser in anticipation of jQuery 1.9
* Attempted a fix for the fullscreen images flashing issue
* Addressing an issue where editing a lens could result in a broken page

= 2.1.20130116 =
* Extracted a Regex for filtering images from feeds/sources, and added a filter for it `slidedeck_image_blacklist`
* Made an accommodation for a rare case where many WordPress custom taxonomies could make the WordPress Posts Source's taxonomy selector unusable
* Updated the button style of the `Insert SlideDeck` button to match the new WordPress 3.5 and higher look
* Tweaked the FancyForms dropdown styles so the z-indexing is no longer an issue
* Adjusted the following lenses for a mobile/responsive bug: fashion, half-moon, o-town, reporter, tool-kit, twitter.
* Fixed a warning message related to the $expansion_factor variable

= 2.1.20121212 =
* Updated references in activation routine to fix free to paid upgrade identification if free plugin was still activated
* Help us make SlideDeck 2 better! Added optional anonymous usage statistics opt-in.
* Improved the asset load order of SlideDecks
* Fixed an issue with video IDs containing double underscores and how they were handled
* Fixed an issue in the core JavaScript library that affected transparent decks and the fade transition (eg: Reporter)
* Added content/description pull for Flickr feed source
* Fixed a few notices/errors when deleting a SlideDeck embedded in the theme
* Fixed an issue with Firefox versions 20 and higher
* Avatars are no longer loaded in the HTML if the `Show Author Avatar` option is set to `Off`
* Modified AJAX change lens method in SlideDeck interface to prevent regression bug

= 2.1.20121115 =
* Updated pathing for Ress js asset loading for better consitency across the board
* Adding a filter for the shortcode attributes.
* Adjusting the way that a proportional RESS raito is calculated (Should help with height on some RESS decks).
* Fixing a typo in the 'Overlays Always Open' tooltip.
* Adding Flickr Group support to the Flickr source (recent only, no tags)
* Adding image size choice to the WordPress Posts source. You can now choose auto or a specific registered size.
* Addressing an issue where the manage screen may fail and dislay this error: `Cannot use object of type WP_Error as array`
* Added Georgia to the default list of fonts. 

= 2.1.20121102 =
* Fixed an issue where using the shortcode in your theme could cause SlideDeck to not render.

= 2.1.20121101 =
* Optimized the way that scripts and styles are loaded when using RESS.
* Moved RESS scripts into their own file, echoing them instead of including them.
* Added an IE8 compatible background-color definition for the main navigation arrows
* Fixed a PHP warning in the widget.php file

= 2.1.20121017 =
* Fixed an issue where the responsive SlideDecks would fail in IE10
* Fixed an issue where the classic lens would not render correctly in IE 10
* SlideDeck now renders correctly in Chrome for iOS
* Loading of SlideDeck lenses no longer triggers a fatal error if the lens class was not unique
* Fixed an issue where playing a video slide (on mobile) woud not pause the SlideDeck autoPlay setting

= 2.1.20121010 =
* Fixed an error where upgrading from Lite would show an error page if FTP crendentials were requested
* Fixed an issue where a warning was being thrown due to a lack of a `$found_lens_path`
* Updated URL pathing constant to use plugins_url() for better WordPress Network compatibility
* Updating the slidedeck_dimensions() filter for PHP 5.4 compatibility
* Added Title, Before, and After text to the SlideDeck WordPress Widget
* Tool Kit Lens: Fixed an issue where the excerpt block could show up even if there was no excerpt.

= 2.1.20120919 =
* Updated the http_build_query() method that outputs the dimensions for iframe and RESS decks, added the ampersand as the separator. Some users were having the html encoded '&amp;' being output which was breaking the deck dimensions.
* Namespaced the SlideDeck SimpleModal JavaScript library further to avoid namespace conflicts with plugins like Shortcode Exec PHP and Ajax Event Calendar
* Fixed bug with IE 8 background image processing that was preventing images beyond the first slide from working in vertical SlideDecks.
* Fixed a display issue where the SlideDeck previews on the manage page where sometimes rendered at the wrong height.
* Fixed an issue where SlideDecks using the iframe=1 shortcode option had a larger than necessary height.
* Reporter Lens: Including multiple Reporter decks on the page no longer creates JavaScript errors and broken decks.
* Reporter Lens: Fixed an issue where the video thumbnail was erroneously linking to the video permalink when this was not expected.
* Updated language files to include phrases used in lens templates such as "Read More".
* Fixed an issue where the video cover was not always hidden when automatically advnacing to the next slide.
* Updated language files to include phrases used in lens templates such as "Read More".

= 2.1.20120827 =
* Adding RESS (REsponsive Server-Side) options to the shortcode ress=1 and proportional=no
* Adding RESS (REsponsive Server-Side) options to the widget options
* Shortcode now accepts start=# where # is the starting slide (needed for RESS)
* Adding a fix that prevents a JavaScript lockup if the O-Town lens has thumbnails and is less than 110px tall
* Adding an optimization (speedup) to the iFrame rendering methods (echo scripts instead of linking them)
* Adding a check to some of the sources that may prevent some warnings from being shown.

= 2.1.20120823 =
* SlideDeck will now intelligently only load assets for SlideDecks for non-iframe embedded SlideDecks.
* Added an option that will turn off loading of SlideDeck base assets (common JavaScript/CSS files) on every page. When this option is turned on, SlideDeck will always load the base assets even if it doesn't detect a SlideDeck being loaded in the posts on the page (useful for template embedded SlideDecks). When this option is turned off SlideDeck will intelligently load assets only when it detects a SlideDeck embedded in a post on the page.
* Optimized caching namespacing and cache busting techniques to prevent Object Caching problems with persistent caching plugins like W3 Total Cache, WP Super Cache, Quick Cache and the like.
* Modified slidedeck_get_font filter to be more hookable to allow users to manually add their own fonts to the fonts list.
* Fixed bug that was preventing the insert SlideDeck modal from working in WordPress installations that were installed in a sub-folder.
* Added no-cache headers to AJAX calls on the SlideDeck preview to prevent cached responses from coming back
* Added "slidedeck_iframe_header" and "slidedeck_iframe_footer" actions to the IFRAME render template. This action receives two parameters: $slidedeck (the SlideDeck object Array) and $preview (a boolean of whether or not this is a preview render). Hook into these actions to add additional header and footer content to your IFRAME rendered SlideDecks.
* Fixed bug with the Tool Kit lens that prevented the Dark/Light variations from working on Custom Content SlideDecks with image slides.

= 2.1.20120807 =
* Fixed a bug in the WordPress Post Content Source that was excluding search of the post content area for imagery when the user chose to use the excerpt instead of the post content for the slide copy.
* Created new ability to choose how an image is scaled in a slide (no scaling, scale to fit, scale and crop)
* Fixed bug with IE that was preventing links from being clickable in slides with certain lenses
* Changed the way video slides are handled (on iOS) for better compatibility and better playback starting
* Nav arrows are now hidden while a video is playing (on iOS) as they are unclickable anyway
* Fixed but with O-Town lens JavaScript that was preventing proper completion of lens render in some cases
* Moving the slidedeck2 options to its own option key in the database (resolves a conflict with SlideDeck 1)
* Fixed a toggle issue with the Twitter content source flyout

= 2.1.20120724 =
* Added logic to make more of the lenses cleanly copyable
* Twitter source now specifies small as a starting size
* If the default lens for a source is not available, the default SlideDeck lens is used instead
* Added Twitter, Facebook, and Google+ share buttons to the Lite plugin sidebar; show us some love and spread the word!
* Fixed a bug where a taxonomy name with a dash in it eg: `my-custom-categories` would cause the WordPress posts taxonomy chooser (in SlideDeck) to fail

= 2.1.20120717 =
* Improved how we were affecting the force of target _blank on links when loading SlideDecks in an iframe
* Fixed bug that was casuing some remote content sources cached responses to load incorrectly, causing a "no content" response when loading the SlideDeck
* Added actual slide dimensions indicator in SlideDeck preview area
* Updated IFRAME preview mode to properly identify if it is in a preview or being rendered as part of an iframe=1 shortcode render
* Modified SlideDeck JavaScript core references to include the ?noping parameter when being rendered as part of the admin control panel
* Added filters for higher customization of slide spines

= 2.1.20120711 =
* SlideDecks are no longer rendered in feeds (Even Feedburner!). They are shown as a link instead
* Updated Twitter icons to reflect logo update
* Rearranged some localization code
* Added an option to define a `SLIDEDECK_LICENSE_KEY` constant with your license key in your wp-config file
* Added a GMT override to the "time ago" calculations for the display of dates in lenses
* SlideDecks being rendered in iFrames now respect the 'open in same window' option

= 2.1.20120705 =
* Added min-width value to Flickr source flyout to fix rendering display in Webkit browsers (Safari/Chrome)
* Appended to the sort logic. If the deck only has one source, we don't sort by date. If it has more than one source, we sort by date.
* Added an additional sort option to the WordPress Posts content source. You can now sort by menu_order
* Fixed an issue with the YouTube content source where videos in a playlist did not have the correct date ordering under some circumstances
* Added Pinterest icon to the sources image on the manage page
* Refined lens selection view
* Added a "jQuery Hook" (custom event) for the re-filling of the deck options area and fixed a display issue with the options area

= 2.1.20120702 =
* Adjusted the YouTube API call so no related videos are shown at the end of playback
* Fixed the `slidedeck_lens_selection_before_lenses` and `slidedeck_lens_selection_after_lenses` hooks so they no longer throw notices

= 2.1.20120628 =
* Creation of a Lite version of the SlideDeck 2 Plugin
* Fixed some logic bugs with uploading lenses
* Improved deletion logic for user-uploaded lenses to work properly with server configurations where the owner of the lens folder is the FTP user and not the web server user
* Moved strip_shortcodes() command to take place after an image has been searched for instead of at initial setup of slide nodes for dynamic post content source
* Fixed a bug that was returning a bad URL for first image in content
* Improved the "first image in gallery" logic to properly retrieve the first listed image in a gallery that has not yet been intentionally sorted by the user
* Fixed a regression bug with post thumbnail support in the posts dynamic content source that was preventing SlideDecks from working properly with themes that don't have thumbnail support
* Fixed an issue where jQuery Masonry was not being enqueued

== Upgrade Notice ==
= 2.3.11 =
Pinterest source updated. Minor ui updates

= 2.3.10 =
Addresses some interface display issues, a minor TinyMCE fixed introduced in the previous version and some lens updates

= 2.3.9 =
Addresses very minor JavaScript error in the editor

= 2.3.8 =
Fixes for vertical decks and video, the O-Town lens, the sharing overlay

= 2.3.7 =
Repaired IE11 support

= 2.3.5 =
Improved the reliability of and Lazy Loading when using crossfade

= 2.3.3 =
HOTFIX: Compatibility updates for WordPress 3.6 and RESS/IFRAME rendered SlideDecks and insert SlideDeck views

= 2.3.2 =
Fixed a bug in IE detection script

= 2.3.1 =
Removed Twitter as a source and fixed minor bugs

= 2.2.2 =
Revised the SlideDeck branding

= 2.2.1 =
Fixed an indexing issue with Lazy Loading Videos

= 2.2 =
Adds Lazy Loading for images and video

= 2.1.20130325 =
Bug fixes and better upgrade messaging

= 2.1.20130306 =
Security fixes in this release, please make sure you update your copy

= 2.1.20130228 =
Bug Fix for O-Town lens

= 2.1.20130219 =
Preparing for jQuery 1.9, misc bug fixes

= 2.1.20130116 =
Collection of miscellaneous bug fixes

= 2.1.20121212 =
Many bug fixes, and lens CSS loading optimizations

= 2.1.20121115 =
Bug fixes, adds the ability to purchase lenses

= 2.1.20121102 =
Critical hotfix for decks that are inserted directly into the theme

= 2.1.20121101 =
Bug fixes for IE8. Asset loading optimizations

= 2.1.20121017 =
Bug fixes, IE10 issued resolved, Chrome iOS issues resolved

= 2.1.20121010 =
Various bug fixes

= 2.1.20120919 =
Bug fixes for IE, some lenses, RESS responsive and IFRAME conflicts, cross-plugin conflicts

= 2.1.20120724 =
A few bug fixes and the new 'Reporter' lens

= 2.1.20120628 =
Lite Plugin is available
