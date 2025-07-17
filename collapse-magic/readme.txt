=== Collapse Magic (CLAPS) ===
Contributors: creatorseo, clinton101
Donate link: https://leads5050.com/
Tags: accordion, collapse text, fade text, read-more text, fade content
Requires at least: 6.1
Tested up to: 6.7.2
Stable tag: 1.4.1
Requires PHP: 7.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

The easy way to create a collapsible text block with a 'read-more' label on any page. Also provides a fading text option.

== Description ==

Collapse Magic provides an easy way to display (collapsible) read-more text on a page. This plugin is an alternative to other plugins like collapse-o-matic and can be used as a direct replacement without the need for any changes to page content.

**Features**

* Easy to implement
* Configurable expand and collapse labels
* Configurable up and down arrows
* Adjustable visible text height in the collapsed state
* Adjustable fade-out text visible in the collapsed state
* Unfortunately this plugin does not support Accelerated Mobile Pages (AMP)

**Background**

Collapse Magic provides an easy way to display (collapsible) read-more text on a page. Also, display a few lines of text and add read-more or expand text.

This plugin was developed when a cross-site scripting vulnerability was identified in collapse-o-matic. This plugin can be used as a direct replacement to collapse-o-matic. There is no need for any on-page changes to be made for the plugin to be used as a replacement.

**Set-up**

* Install the plugin
* Set any parameters from the admin Settings menu.
* Place text between [magic_expand][/magic_expand] tags or between  [expand][/expand] for the toggle to work.
* Include alternate 'read-more' text if this is required in the shortcode as [magic_expand title="NEW READ-MORE TEXT"].
* Use alternate 'read-less' text if this is required in the shortcode as [magic_expand swaptitle="NEW READ-LESS TEXT"].
* Toggle button to set the default location of the expand / collapse label to above or below the section.
* Single click disable button to switch off the shortcodes and show the full text.

**Shortcode Parameters**

* Read-more / expand label - 'title'. Example [magic_expand title="--more--"].
* Read-less / collapse label - 'swaptitle'. Example [magic_expand title="--more--" swaptitle="--less--"].
* Position of the expand label - 'pos'. Example [magic_expand pos="above"] or [magic_expand pos="below"]

== Installation ==

1. Upload 'Collapse Magic' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on 'Collapse Magic' in the Settings menu to set global links or
4. Go to the Plugins page and click the 'Settings' link for 'Collapse Magic'
5. Increase the display block value if you want to display some fade-to text.

== Frequently Asked Questions ==

= Will this Plugin work with any theme? =
Yes, the plugin is theme independent.
= Can I display a different drop-down arrow and drop down text? =
Yes, the settings can be configured from the styling page.
= Where do I find the button styling options? =
Click on *Collapse Magic* option on the WordPress 'Settings' admin menu.
= Can I place the 'read-more' and 'read-less' text above the text? =
Yes, go to settings>collapse magic>Toggle Above and set this to 'on'. The toggle text will display above.
= Can I display some teaser text to encourage the visitor to click the read-more button? =
Yes, if you go to settings>collapse magic>Block Height and increase the value, you can display teaser text. You can also change the fade-out height for disappearing text.
= Does the fade text work with the toggle text above the block text? =
Yes, the fade works as long as the Block height is set to a value greater than 1px.
= Will this plugin have a negative impact on my website? =
We make every effort to ensure that all the WordPress guidelines are followed and that our plugins are optimised to perform well in all our tests.
= If I install the plugin and the styling does not look correct, what should I do?
The very first time you view the page after installing the plugin you may need to refresh the page (ctrl+F5) to ensure that the new style and script libraries are initiated. If needed this should be a once-off refresh. Everything should be fine thereafter.
= Why does the plugin not support Accelerated Mobile Pages (AMP)?
Accelerated Mobile Pages (AMP) has strict limitations on JavaScript, and does not allow jQuery. This breaks the dynamic features that are key to this plugin.
= Can I nest the collapse shortcodes? =
Maybe, nesting shortcodes does not always work and if you are using a page builder then this may mangle your shortcodes. Use the classic builder for more chance of success.

== Screenshots ==

1. Sample shortcode including the expand title (title) and the collapse (swaptitle) attributes.
2. Alternative notation for the shortcode where 'magic_expand' is replaced by 'expand'.
3. Text displayed on the front-end (collapsed).
4. Text displayed on the front-end (expanded) when the read-more text is clicked. Notice that any content can be used between the shortcode tags.
5. Settings Menu values. The default values, icons and displayed text values can be set on the Settings menu. Notice the 'enabled' button can be used to switch the plugin off.
6. Changing the block height and the fade height changes the way the text is displayed.
7. The content display fades to the read-more link when the Block Height and Fade Height values are increased.
8. Set the 'Toggle Above' switch to 'on' to place the 'read-more' and 'read-less' text above the text. This also disables the scroll to top.

== Credits ==

This plugin was inspired by the approach used by:
- [Nelson Miller: How To Expand And Collapse Text In Divi](https://www.peeayecreative.com/how-to-expand-and-collapse-text-in-divi/): the jQuery code was modified for this plugin.

== Changelog ==
= 1.4.1 =
* Version checks and minor updates

= 1.4.0 =
* Improvements made to allow nested shortcodes. Note many page builders mangle nested shortcodes and there is no clear solution for this.

= 1.3.3 =
* General maintenance improvements. Debug log error resolved.

= 1.3.1 =
* Removed the restriction on the amount of text that could be contained in the read-more block.

= 1.3.0 =
* Included the option to place the read-more and read-less above or below the text (thanks to @bob33 for the suggestion).

= 1.2.2 =
* Fix applied to allow shortcodes within the shortcode (thanks to @bob33 for identifying this bug).

= 1.2.1 =
* Change the default fade and block settings as these were confusing to new users.

= 1.2.0 =
* Scroll back to the original read-more text included. Checks following feedback from a user investigated but no issues could be found.

= 1.1.0 =
* Improvements to better meet WordPress Plugin requirements

= 1.0.1 =
* Launch version

= 0.0.1 =
* Pilot launch April 2024

== Upgrade Notice ==

= 0.1.0 =
Launch version
