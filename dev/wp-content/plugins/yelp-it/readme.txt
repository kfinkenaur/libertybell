=== Plugin Name ===
Contributors: coffeesnobdavis
Donate link: http://coffeesnobdavis.com/yelp-it
Tags: yelp, reviews, oauth
Requires at least: 3.0.1
Tested up to: 3.3.1
Stable tag: trunk

Displays a small Yelp profile for a specific business or a search: Name (link), Rating, Review Count, and Picture. Shortcode only for now.

== Description ==

=== Important Note ===

**You get 100 views by default. To increase your call limit, contact Yelp and ask for a higher limit using the handy textbox where you [manage your Yelp API key](http://www.yelp.com/developers/getting_started/api_access). See 'Installation' for more details. I do not control this, Yelp does.**

So you're talking about some cafe or restaurant and you wish you could display a small box that contains a fresh Yelp rating for it. Well now you can. This plugin installs a shortcode. By default, you can set the `term` and `location` and it will spit out the first business result from that search. Or, you can set the `limit` to higher than 1 and it will spit out more. Or, you can set the `id` to and enter the Yelp `id` for a business to only get that business (see *Business method* under Parameters below).

== Installation ==

Note: Requires `curl` and might require PHP5, not sure.

1. Upload `yelp-it` directory to the `/wp-content/plugins/` directory or install it using the "Install" button in Wordpress' plugin directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Get your Yelp API v2 token, token secret, consumer key, and consumer secret
  * Sign in to Yelp and [manage your API access](http://www.yelp.com/developers/getting_started/api_access "It's free!")
  * Press the button to get access to Yelp API v2 (free)
1. Copy over those things into the Yelp It plugin config screen, under the Wordpress Plugins menu in the Administration Dashboard.
1. Use the shortcode `[yelpprofile term="Donuts" location="San Francisco, CA" align="right"]` to test it out (shortcodes are entered directly in your page/blog post!)

Keep in mind that your Yelp API key is limited to 100 calls per day by default. There's no caching allowed, so that means after 100 views of a page with this Yelp widget on it, it will stop working until the next day. To increase your call limit, contact Yelp and ask for a higher limit using the handy textbox where you [manage your Yelp API key](http://www.yelp.com/developers/getting_started/api_access).

== Parameters ==

All parameters are optional. There are two methods, Business and Search. Use Business if you know the ID of the business you want to show. See below for more details.

* `align` accepts left, right, center, or nothing. If you don't define align, it will just be a block element. You can configure all this stuff in the CSS or your own CSS.

*Business method*

* `id` (required) is the ID of the business. It is the last part of the Yelp URL of its Yelp page. Ex: `http://www.yelp.com/biz/the-waterboy-sacramento`, the id is `the-waterboy-sacramento`. This is the *only* parameter you need to set to use this method.

*Search method*

* `term` is the search term that you would use if you were just entering it in a Yelp search. Default is "Four Barrel", but might change.
* `location` (required) is the location part of the search, exactly like when you use Yelp at yelp.com. Default is "San Francisco", but might change.
* `limit` is the number of businesses that Yelp will return. Default is 1.
* `sort` is the Yelp sorting method, 0 (default) is Best Match, 1 is Distance, and 2 is Highest Rated.

== Screenshots ==

1. Context for my cafe breakdown.

== Changelog ==

= 0.4.3 = 
* Fix broken yelp logo image, now included in plugin

= 0.4.2 =
* Add check for OAuthException class again. If you are getting errors about that, this should fix it.

= 0.4.1 =
* Remove debug code... so sorry, I'm a terrible person

= 0.4.0 =
* Added much requested option to set the Yelp links to open in a new window. Use with caution, users may not want this.

= 0.3.3 =
* Expanded conditional check to wrap the inclusion of the entire OAuth lib. If you are getting OAuth conflicts, this should resolve that.

= 0.3.2 =
* Added conditional check for OAuthException class creation so it doesn't conflict with others.

= 0.3.1 =
* Bugfix for Yelp API change that is stricter about using a value for "sort" if using a search term.

= 0.3 =
* Deprecated `method` parameter, it will automatically use the correct method depending on whether you set the ID or the term/location. If you set the ID, it will use the Business method and ignore the term/location/limit.
* Set box-shadow to 0 for img tags in the Yelp profiles. This is a common theme style for images, but might not work since some themes use IDs to target them.

= 0.21 =
* Now not completely effing broken for some people
* Re-wrote settings to use a single array of settings instead of individual ones.
* Let Wordpress handle the saving of settings, two people reported their settings were disappearing. That shouldn't happen now. If it does, I can't help you.
* Added legacy support for old settings if they were already working for you, migrates them to new format.
* Added activation and uninstall hooks

= 0.2 =
* Added support for Yelp's new business search, adds the ability to get a listing by business ID.
* Added support for multiple results and sorting.
* Better error handling

= 0.1 =
Created. Limited to one business output. Only accepts term, location, and the ability to align the box.
