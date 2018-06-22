=== Wordpress Local SEO ===
Contributors: digitaleheimat,wansinn
Donate link: http://www.digitaleheimat.de/
Tags: seo, local, geo, location, opening hours, custom meta fields, sitemap, digitaleheimat
Requires at least: 3.5.1
Tested up to: 3.8.1
Stable tag: 2.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Boost the Local SEO rankings of your Wordpress and optimize the display of your locations:
Schema.org, GEO sitemap, Google Maps, infinite locations

== Description ==

= Features =
* Branding with title & logo
* Address & contact information with dynamic fields
* Opening hours
* Google Maps display
* Schema.org valid Rich Text Snippets
* GEO sitemap with all locations
* Infinite locations as custom post type, linkable to any other content
* Extensive layout options and custom template support

= Two configuration modes =

**Standard configuration:**

* provides an easy to use interface adding the location information directly into any post

**Advanced features:**

* Creates locations as instances (custom post type) and lets you just add them to any post (multiple locations per post are possible) 
* Enables categories for locations
* Enables Google Map with all locations via shortcode or function call


= Custom post type settings =

**"Location" as post type**     
The plugin comes with a built in post type that only shows the location information. 
Useful, if you have a list of locations with now further information necessary. 
 
**Enable locations for each avaiable post type**     
You can enable the location information individually for each post type you have installed in your Wordpress site.
Useful, if you want to add location information to existing post types (ie. a contact page, blog posts about locations or events)


= Enable additional fields =

The plugin supports, next to the default address fields, additional SEO relevant fields. All these fields can be activated via the settings

* **Type of location** (Schema.org)
* **Phone** (multiple)
* **Fax** (multiple)
* **Email address** (multiple)
* **Website** (multiple)
* **Description**
* **Opening hours** (a dynamic fieldset to enter various opening hours)

= Layout & Template settings =
* custom sizes for maps and logos
* custom css styles for advanced layouting

Additionally, the plugin comes with default templates for the location information and it offers the possibility to override the template in your theme folder.

You can append locations to your theme:

* automatically via **Wordpress filter**
* manually via a **function call**
* directly into post content via **shortcode**


= Multilingual support =

The plugin is fully translatable and comes with following default languages:

* **English**
* **German**
* Send us your translation into another language to make it avaiable for others

Wordpress Local Seo is developed by [digitaleheimat GmbH](http://www.digitaleheimat.de)



== Installation ==

The plugin installation works like most of the Wordpress plugins:

1. Upload the folder `dh-local-seo` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit `Settings > WP Local SEO` to configure the plugin

== Frequently Asked Questions ==

Please use Support section for further support.
FAQ will be added soon.


== Screenshots ==

1. A neat optical display of your location data with additional magic lying in the source code that implements the *Schema.org* notation

2. The settings page gives you quite a view options to adjust the plugin to your needs

== Upgrade Notice ==

The plugin automatically takes care of all updates and notifies you about any manual adjustments that need to be done.


== Changelog ==

= 2.3 =
* renaming the Plugin to Wordpress Local SEO
* optimizing the dscription
* enabling post content for location post type (optionally)
* translatable SEO category labels
* Performance update: Loading only necessary scripts
* Bugfix: Don't show unpublished locations on website, make trashed locations unavaiable


= 2.2 =
* New: Custom map & logo size, Custom CSS
* Bugfix: content filter removed original content
* Bugfix: automatic http:// replace in url fields

= 2.1 =
* Bugfix: faxNumber in location template
* updated function call to "show_locations" to support multile locations


= 2.0 =
* Advanced configuration: Location as post type, multiple instances added to other post types via post meta
* Google map with all locations via shortcode or function call
* Multiple phone & fax numbers, email adresses and websites via dynamic input field
* set type of location as default through settings or directly in location
* updated german translation


= 1.23 =
* fixed rewrite bug: renamed to geo_sitemap.xml
* fixed translation bug in opening hours

= 1.22 =
* updating german translation

= 1.21 =
* no updates

= 1.20 =
* added optional post id to function call and shortcode to extend possibility to show geo location field of a post inside another post
* changed variable $post->ID to $wpl_id in location-template.php

= 1.11 =
* **Bugfix:** wp-local-seo.js, wp-local-seo.css included wrong (wp-localseo.js, wp-localseo.css)
* **Bugfix:** elements in wp-local-seo.js, wp-local-seo.css named wrong (#dhl)
* **Bugfix:** PO-files named wrong

= 1.1 =
* renaming the Plugin to WP Local SEO
* adding upgrading compatibility

= 1.0 =
* First version

