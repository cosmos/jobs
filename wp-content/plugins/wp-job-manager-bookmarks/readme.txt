=== Job Bookmarks ===
Contributors: mikejolley, automattic, jakeom
Requires at least: 4.1
Tested up to: 4.9
Stable tag: 1.4.1
License: GNU General Public License v3.0

Lets candidates star/bookmark jobs, and employers star/bookmark resumes (if using the Resume Manager addon).

= Documentation =

Usage instructions for this plugin can be found here: [https://wpjobmanager.com/document/bookmarks/](https://wpjobmanager.com/document/bookmarks/).

= Support Policy =

For support, please visit [https://wpjobmanager.com/support/](https://wpjobmanager.com/support/).

We will not offer support for:

1. Customisations of this plugin or any plugins it relies upon
2. Conflicts with "premium" themes from ThemeForest and similar marketplaces (due to bad practice and not being readily available to test)
3. CSS Styling (this is customisation work)

If you need help with customisation you will need to find and hire a developer capable of making the changes.

== Installation ==

To install this plugin, please refer to the guide here: [http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation)

== Changelog ==

= 1.4.1 =
* Adds my_bookmarks shortcode to the wpjm shortcodes list

= 1.4.0 =
* Bookmark actions (adding, removing, and updating) now happen in the background for themes that support it.
* Adds support for `order` (`date`, `post_date`, and `post_title`) and `orderby` (`ASC` and `DESC`) arguments in `[my_bookmarks]` shortcode.
* Adds thumbnail for resume and job listings next to the bookmark in `[my_bookmarks]`.
* Fixes issue with pagination when there are expired or deleted listings bookmarked.

= 1.3.0 =
* Adds compatibility with WP Job Manager 1.29.0 and requires it for future updates.

= 1.2.1 =
* Fix pagination error when limit is not set.

= 1.2.0 =
* Added icon to bookmarked listings.
* Added pagination to my_bookmarks.

= 1.1.7 =
* Improved ajax detection and form action.

= 1.1.6 =
* Fix when submitting bookmarks via ajax.

= 1.1.5 =
* Post form to current URL.

= 1.1.4 =
* Added confirm on delete bookmark.

= 1.1.3 =
* Load translation files from the WP_LANG directory.
* Updated the updater class.

= 1.1.2 =
* Hide during preview.

= 1.1.1 =
* Uninstaller.

= 1.1.0 =
* Add logged out version of bookmark form prompting login.
* Added bookmark_count method.

= 1.0.2 =
* Show message when logged out.

= 1.0.1 =
* Don't restrict bookmark form from displaying on pages.

= 1.0.0 =
* First release.
