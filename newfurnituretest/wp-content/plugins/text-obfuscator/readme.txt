=== Text Obfuscator ===
Contributors: ConfuzzledDuck
Tags: word replacement, replace, auto correct, change, anonymous, filter, text, alternative
Requires at least: 2.7
Tested up to: 4.4.1
Stable tag: 1.4.1

Replaces words and phrases in your posts' content with alternative words and phrases.

== Description ==

Text Obfuscator is a simple plugin for replacing words and phrases in post or page content and comments with alternative words and phrases. Initially designed to remove names from personal blog posts, it can be used to correct common spelling errors or automatically expand abbreviations.

Each string can be configured to replace text on input saving the modified text to the database, or on output preserving the content in the database as it was entered by the user.

More information and support is available at [Flutt.co.uk](http://www.flutt.co.uk/development/wordpress-plugins/text-obfuscator/).

== Installation ==

Simply upload the plugin directory to your plugin directory, activate the plugin, and configure it through the Tools->Text Obfuscator menu.

== Changelog ==

= 1.4.1 =
 * Fixed issue relating to replacement of words at the end of a line or string.

= 1.4 =
 * Added ability to replace content in all post types, not just post and page.

= 1.3.2 =
 * Minor change to comments.

= 1.3.1 =
 * Modified the behaviour surrounding preceeding and trailing whitespace in tokens and values.
 * Modified behaviour so leaving the replace box blank now assumes a match removal rule even if 'remove matched' is not checked.
 * Added an uninstall function to tidy up settings when uninstalling.

= 1.3 =

* Added the option to apply rules to either pages, posts, or both.
* Added the option to match or ignore case in matches.
* Added option to remove matched string, not replace it.
* Reworked the admin page to (hopefully) make it easier to use with new options.
* Added settings link to plugin page.

= 1.2 =

* Added option to match partial words.
* Extracted regular expression building into it's own function called by all replacement functions.

= 1.1 =

* Added ability to optionally do replacement in blog posts, titles, excerpts and comments.
* Added ability to apply each filter on input or output.
* Fixed a bug blanking posts when there were no replacement rules.
* Modified escaping to use WP's built in routines.
* Added comments throughout.

= 1.0 =

* Updated to use settings methods added to WP2.7.
* Renamed from 'Obfuscator' to 'Text Obfuscator'.
* Released on the WordPress plugin directory.

= 0.2 =

* Changes to the way the rules are stored to prevent them getting mixed up.
* Minor changes to conditional logic.
* Minor changes to some wording on the admin page.
